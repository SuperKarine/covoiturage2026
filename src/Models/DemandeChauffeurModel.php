<?php
namespace Models;


use Models\Model;
use Entity\DemandeChauffeur;
use Entity\StatutDemandeChauffeur;
use PDO;
use DateTimeImmutable;


class DemandeChauffeurModel extends Model
{
    protected string $table = 'DemandeChauffeur';

    
    // je crée une nouvelle demande pour devenir chauffeur
     
    public function create(int $idUtilisateur): int|false
    {
        $pdo = $this->getPDO('write');

        $stmt = $pdo->prepare("
            INSERT INTO {$this->table} (id_utilisateurs, statut, date_demande)
            VALUES (:id_utilisateurs, :statut, NOW())
        ");

        $success = $stmt->execute([
            ':id_utilisateurs' => $idUtilisateur,
            ':statut' => StatutDemandeChauffeur::EN_ATTENTE->value,
        ]);

        return $success ? (int) $pdo->lastInsertId() : false;
    }

    
    // Je récupère une demande par son ID
     
    public function findById(int $id): ?DemandeChauffeur
    {
        $stmt = $this->getPDO('read')->prepare("
            SELECT * FROM {$this->table} WHERE id_demande = :id
        ");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return $this->hydrate($row);
    }

    
    // Je liste toutes les demandes en attente 
     
    public function findEnAttente(): array
    {
        $stmt = $this->getPDO('read')->prepare("
            SELECT d.*, u.nom, u.prenom, u.mail
            FROM {$this->table} d
            JOIN Utilisateurs u ON d.id_utilisateurs = u.id_utilisateurs
            WHERE d.statut = :statut
            ORDER BY d.date_demande ASC
        ");
        $stmt->execute([':statut' => StatutDemandeChauffeur::EN_ATTENTE->value]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    /**
    * Je sauvegarde le nouveau statut d'une demande après accepter/refuser
    * et je mets à jour le rôle de l'utilisateur si la demande est acceptée.
    */

    public function save(DemandeChauffeur $demande): bool
    {
        $pdo = $this->getPDO('write');

        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("
                UPDATE {$this->table}
                SET statut = :statut, date_traitement = :date_traitement
                WHERE id_demande = :id
            ");
            $stmt->execute([
                ':statut' => $demande->getStatut()->value,
                ':date_traitement' => $demande->getDateTraitement()?->format('Y-m-d H:i:s'),
                ':id' => $demande->getIdDemande(),
            ]);

            if ($demande->getStatut() === StatutDemandeChauffeur::ACCEPTEE) {
                $stmtRole = $pdo->prepare("
                    UPDATE Utilisateurs
                    SET id_role = (SELECT id_role FROM Role WHERE name = 'chauffeur')
                    WHERE id_utilisateurs = :id
                ");
                $stmtRole->execute([':id' => $demande->getIdUtilisateurs()]);
            }

            $pdo->commit();
            return true;

        } catch (\Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }
    

     // Je construis un objet DemandeChauffeur à partir d'une ligne SQL
     
     
    private function hydrate(array $row): DemandeChauffeur
    {
        $demande = new DemandeChauffeur((int) $row['id_utilisateurs']);
        $demande->setIdDemande((int) $row['id_demande']);
        $demande->setStatut(StatutDemandeChauffeur::from($row['statut']));

        if ($row['date_traitement'] !== null) {
            $demande->setDateTraitement(new DateTimeImmutable($row['date_traitement']));
        }

        return $demande;
    }
}