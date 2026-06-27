<?php
namespace Models;

use Models\Model;
use Entity\Reservation;
use Entity\Trajet;
use Entity\Utilisateurs;
use Entity\Role;
use Entity\Compte;
use Entity\StatutReservation;
use Entity\StatutTransaction;
use Entity\TypeTransaction;
use PDO;
use DateTimeImmutable;
use Exception;


class ReservationModel extends Model
{
    protected string $table = 'Reservation';

    /**
     * Construction d'un objet Utilisateurs 
     * en utilisant un préfixe pour distinguer plusieurs utilisateurs
     * dans une même requête 
     */

    private function hydrateUtilisateur(array $row, string $prefix): Utilisateurs
    {
        $compte = new Compte(
            (int) $row["{$prefix}id_compte"],
            (int) $row["{$prefix}id_utilisateurs"],
            (float) $row["{$prefix}solde"]
        );

        $utilisateur = new Utilisateurs(
            $row["{$prefix}nom"],
            $row["{$prefix}prenom"],
            $row["{$prefix}tel"],
            $row["{$prefix}username"],
            $row["{$prefix}mail"],
            $row["{$prefix}password"],
            $row["{$prefix}confirmation_token"],
            (bool) $row["{$prefix}is_confirmed"],
            Role::from($row["{$prefix}role_name"]),
            $compte
        );

        $utilisateur->setIdUtilisateurs((int) $row["{$prefix}id_utilisateurs"]);

        return $utilisateur;
    }

    
     // Construction d'un objet Trajet 
     
    private function hydrateTrajet(array $row): Trajet
    {
        $chauffeur = $this->hydrateUtilisateur($row, 'chauffeur_');

        $trajet = new Trajet(
            $chauffeur,
            (int) $row['id_ville_depart'],
            (int) $row['id_ville_arrivee'],
            (int) $row['id_voiture'],
            (int) $row['nbr_places_dispo'],
            (float) $row['prix'],
            (bool) $row['fumeur'],
            (bool) $row['animaux'],
            new DateTimeImmutable($row['date_depart'])
        );

        $trajet->setIdTrajet((int) $row['id_trajet']);

        return $trajet;
    }

    /**
     * Je récupère une réservation complète par son ID, avec son Trajet
     * son chauffeur et son passager
     */

    public function findById(int $id): ?Reservation
    {
        $stmt = $this->getPDO('read')->prepare("
            SELECT
                r.id_reservation,
                r.status,
                r.nombre_places,

                t.id_trajet,
                t.nbr_places_dispo,
                t.fumeur,
                t.animaux,
                t.prix,
                t.date_depart,
                t.id_ville_depart,
                t.id_ville_arrivee,
                t.id_voiture,

                p.id_utilisateurs AS passager_id_utilisateurs,
                p.nom AS passager_nom,
                p.prenom AS passager_prenom,
                p.tel AS passager_tel,
                p.username AS passager_username,
                p.mail AS passager_mail,
                p.password AS passager_password,
                p.confirmation_token AS passager_confirmation_token,
                p.is_confirmed AS passager_is_confirmed,
                rp.name AS passager_role_name,
                cp.id_compte AS passager_id_compte,
                cp.solde AS passager_solde,

                c.id_utilisateurs AS chauffeur_id_utilisateurs,
                c.nom AS chauffeur_nom,
                c.prenom AS chauffeur_prenom,
                c.tel AS chauffeur_tel,
                c.username AS chauffeur_username,
                c.mail AS chauffeur_mail,
                c.password AS chauffeur_password,
                c.confirmation_token AS chauffeur_confirmation_token,
                c.is_confirmed AS chauffeur_is_confirmed,
                rc.name AS chauffeur_role_name,
                cc.id_compte AS chauffeur_id_compte,
                cc.solde AS chauffeur_solde

            FROM {$this->table} r
            JOIN Trajets t ON r.id_trajet = t.id_trajet

            JOIN Utilisateurs p ON r.id_utilisateurs = p.id_utilisateurs
            JOIN Role rp ON p.id_role = rp.id_role
            JOIN Compte cp ON p.id_compte = cp.id_compte

            JOIN Utilisateurs c ON t.id_utilisateurs = c.id_utilisateurs
            JOIN Role rc ON c.id_role = rc.id_role
            JOIN Compte cc ON c.id_compte = cc.id_compte

            WHERE r.id_reservation = :id
        ");

        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        $trajet = $this->hydrateTrajet($row);
        $passager = $this->hydrateUtilisateur($row, 'passager_');

        $reservation = new Reservation(
            $trajet,
            $passager,
            (int) $row['nombre_places']
        );

        $reservation->setIdReservation((int) $row['id_reservation']);

        return $reservation;
    }

    
     // Je crée une nouvelle réservation, statut initial EN_ATTENTE.
     
    public function create(int $idTrajet, int $idUtilisateur, int $nombrePlaces): int|false
    {
        $pdo = $this->getPDO('write');

        $stmt = $pdo->prepare("
            INSERT INTO {$this->table} (status, date_reservation, id_trajet, id_utilisateurs, nombre_places)
            VALUES (:status, NOW(), :id_trajet, :id_utilisateurs, :nombre_places)
        ");

        $success = $stmt->execute([
            ':status' => StatutReservation::EN_ATTENTE->value,
            ':id_trajet' => $idTrajet,
            ':id_utilisateurs' => $idUtilisateur,
            ':nombre_places' => $nombrePlaces,
        ]);

        return $success ? (int) $pdo->lastInsertId() : false;
    }

    /**
     * Sauvegarde le nouveau statut de la réservation, les soldes des comptes
     * passager/chauffeur, le nombre de places restantes sur le trajet,
     * et enregistre l'historique de la transaction associée.
     * À appeler après confirmer()/annuler()/refuser() sur l'Entity.
     */

    public function save(Reservation $reservation, Compte $comptePassager, Compte $compteChauffeur): bool
    {
        $pdo = $this->getPDO('write');

        try {
            $pdo->beginTransaction();

            // 1. Mise à jour du statut de la réservation

            $stmt = $pdo->prepare("
                UPDATE {$this->table}
                SET status = :status
                WHERE id_reservation = :id
            ");
            $stmt->execute([
                ':status' => $reservation->getStatut()->value,
                ':id' => $reservation->getIdReservation(),
            ]);

            // 2. Mise à jour des soldes

            $stmtCompte = $pdo->prepare("UPDATE Compte SET solde = :solde WHERE id_compte = :id");
            $stmtCompte->execute([
                ':solde' => $comptePassager->getSolde(),
                ':id' => $comptePassager->getIdCompte(),
            ]);
            $stmtCompte->execute([
                ':solde' => $compteChauffeur->getSolde(),
                ':id' => $compteChauffeur->getIdCompte(),
            ]);

            // 3. Mise à jour des places du trajet

            $stmtTrajet = $pdo->prepare("
                UPDATE Trajets SET nbr_places_dispo = :places WHERE id_trajet = :id
            ");
            $stmtTrajet->execute([
                ':places' => $reservation->getTrajet()->getPlacesDisponibles(),
                ':id' => $reservation->getTrajet()->getIdTrajet(),
            ]);

            // 4. Historique : une seule ligne de transaction, selon le sens du mouvement

            if ($reservation->getStatut() === StatutReservation::CONFIRMEE) {
                $this->enregistrerTransaction(
                    $pdo, $reservation, $comptePassager, $compteChauffeur,
                    StatutTransaction::VALIDE,
                    TypeTransaction::CREDIT
                );
            }

            if ($reservation->getStatut() === StatutReservation::ANNULEE) {
                $this->enregistrerTransaction(
                    $pdo, $reservation, $comptePassager, $compteChauffeur,
                    StatutTransaction::ANNULEE,
                    TypeTransaction::DEBIT
                );
            }

            $pdo->commit();
            return true;

        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    
     // J'enregistre la transaction liée à une confirmation ou annulation de réservation.
     
    private function enregistrerTransaction(
        PDO $pdo,
        Reservation $reservation,
        Compte $comptePassager,
        Compte $compteChauffeur,
        StatutTransaction $statut,
        TypeTransaction $type
    ): void {
        $prixTotal = $reservation->getTrajet()->getPrix() * $reservation->getNombrePlaces();
        $maintenant = (new DateTimeImmutable())->format('Y-m-d H:i:s');

        $stmt = $pdo->prepare("
            INSERT INTO Transactions (date, statut, type, montant, id_compte_source, id_compte_destination, id_reservation)
            VALUES (:date, :statut, :type, :montant, :id_compte_source, :id_compte_destination, :id_reservation)
        ");

        $stmt->execute([
            ':date' => $maintenant,
            ':statut' => $statut->value,
            ':type' => $type->value,
            ':montant' => $prixTotal,
            ':id_compte_source' => $comptePassager->getIdCompte(),
            ':id_compte_destination' => $compteChauffeur->getIdCompte(),
            ':id_reservation' => $reservation->getIdReservation(),
        ]);
    }
}