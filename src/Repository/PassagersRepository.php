<?php

namespace App\Repository;

use App\Entity\Passagers;
use PDO;
use DateTime;

class PassagersRepository extends Repository
{
    
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Récupère un passager par son ID
     */
    public function findById(int $id): ?Passagers
    {
        $sql = "SELECT * FROM passagers WHERE id_passagers = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$data) {
            return null;    
        }

        return new Passagers(
            // Paramètres Utilisateurs
            $data['nom'],
            $data['prenom'],
            $data['pseudo'],
            $data['email'],
            '', // mot de passe non nécessaire pour la lecture
            new DateTime($data['date_naissance']),
            $data['telephone'],
            true,
            // Paramètres Passagers
            $data['id_passagers'],
            new DateTime($data['date_heure_trajet']),
            $data['nbre_places'],
            new DateTime($data['date_crédit_en_cours']),
            $data['credit_en_cours'],
            $data['debit'],
            new DateTime($data['date_debit']),
            $data['credit_restant']
        );
    }

    public function rechargeCredits(int $id, int $montant): bool
    {
        $sql = "UPDATE passagers 
            SET credit_en_cours = credit_en_cours + ?,
                credit_restant = (credit_en_cours + ?) - debit - 2,
                date_crédit_en_cours = NOW()
            WHERE id_passagers = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$montant, $montant, $id]);
    }

    public function getReservationById(int $reservationId): ?array
    {
        $sql = "SELECT * FROM reservations WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$reservationId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function cancelReservation(int $reservationId, int $passagerId): bool
    {
        $sql = "UPDATE reservations SET statut = 'annulee' WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$reservationId]);
    }

    /**
     * Crée une nouvelle réservation
     */
    public function createReservation(int $passagerId, int $trajetId, int $nombrePlaces): bool
    {
        try {
            // Vérifier d'abord si le trajet existe et a des places disponibles
            $sqlCheck = "SELECT places_disponibles, prix_par_place FROM trajets WHERE id = ?";
            $stmtCheck = $this->pdo->prepare($sqlCheck);
            $stmtCheck->execute([$trajetId]);
            $trajet = $stmtCheck->fetch(PDO::FETCH_ASSOC);

            if (!$trajet || $trajet['places_disponibles'] < $nombrePlaces) {
                return false;
            }

            // Calculer le coût total
            $coutTotal = $trajet['prix_par_place'] * $nombrePlaces;

            // Vérifier si le passager a assez de crédits
            $sqlCredits = "SELECT credit_restant FROM passagers WHERE utilisateur_id = ?";
            $stmtCredits = $this->pdo->prepare($sqlCredits);
            $stmtCredits->execute([$passagerId]);
            $passager = $stmtCredits->fetch(PDO::FETCH_ASSOC);

            if (!$passager || $passager['credit_restant'] < $coutTotal) {
                return false;
            }

            // Commencer une transaction
            $this->pdo->beginTransaction();

            // Créer la réservation
            $sqlReservation = "INSERT INTO reservations (passager_id, trajet_id, nombre_places, cout_total, statut, date_reservation) 
                              VALUES (?, ?, ?, ?, 'confirmée', NOW())";
            $stmtReservation = $this->pdo->prepare($sqlReservation);
            $stmtReservation->execute([$passagerId, $trajetId, $nombrePlaces, $coutTotal]);

            // Mettre à jour les places disponibles du trajet
            $sqlUpdateTrajet = "UPDATE trajets SET places_disponibles = places_disponibles - ? WHERE id = ?";
            $stmtUpdateTrajet = $this->pdo->prepare($sqlUpdateTrajet);
            $stmtUpdateTrajet->execute([$nombrePlaces, $trajetId]);

            // Débiter les crédits du passager
            $sqlUpdateCredits = "UPDATE passagers SET credit_restant = credit_restant - ? WHERE utilisateur_id = ?";
            $stmtUpdateCredits = $this->pdo->prepare($sqlUpdateCredits);
            $stmtUpdateCredits->execute([$coutTotal, $passagerId]);

            // Valider la transaction
            $this->pdo->commit();
            return true;

        } catch (\Exception $e) {
            // En cas d'erreur, annuler la transaction
            $this->pdo->rollBack();
            error_log("Erreur création réservation: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Récupère les réservations d'un passager
     */
    public function getReservationsByPassager(int $passagerId): array
    {
        $sql = "SELECT * FROM reservations WHERE passager_id = ? AND statut = 'confirmée'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$passagerId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère l'historique des trajets d'un passager
     */
    public function getHistoriqueByPassager(int $passagerId): array
    {
        $sql = "SELECT * FROM reservations WHERE passager_id = ? AND statut IN ('termine', 'annulee')";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$passagerId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}