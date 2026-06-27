<?php
namespace Models;

use Models\Model;
use Entity\Note;
use PDO;
use Exception;


class NoteModel extends Model
{
    protected string $table = 'Notes';

    
     // Je Vérifie si un auteur (passager) a déjà noté un trajet donné.
     
    public function existeDeja(int $idTrajet, int $idAuteur): bool
    {
        $stmt = $this->getPDO('read')->prepare("
            SELECT COUNT(*) AS total
            FROM {$this->table}
            WHERE id_trajet = :id_trajet
            AND id_auteur = :id_auteur
        ");

        $stmt->execute([
            ':id_trajet' => $idTrajet,
            ':id_auteur' => $idAuteur,
        ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return (int) $row['total'] > 0;
    }

    /**
     * Evaluation d'un chauffeur par un passager sur un trajet donné
     * Refuse la création si ce passager a déjà noté ce trajet.
     */

    public function create(Note $note): int|false
    {
        if ($this->existeDeja($note->getIdTrajet(), $note->getIdAuteur())) {
            throw new Exception("Ce trajet a déjà été noté par cet utilisateur.");
        }

        $pdo = $this->getPDO('write');

        $stmt = $pdo->prepare("
            INSERT INTO {$this->table} (note, id_utilisateurs, id_trajet, id_auteur)
            VALUES (:note, :id_utilisateurs, :id_trajet, :id_auteur)
        ");

        $success = $stmt->execute([
            ':note' => $note->getNote(),
            ':id_utilisateurs' => $note->getIdUtilisateurs(),
            ':id_trajet' => $note->getIdTrajet(),
            ':id_auteur' => $note->getIdAuteur(),
        ]);

        return $success ? (int) $pdo->lastInsertId() : false;
    }

    /**
     * Calcule la moyenne des notes reçues par un chauffeur donné.
     * Renvoie null si le chauffeur n'a encore reçu aucune note.
     */

    public function getMoyenneParChauffeur(int $idChauffeur): ?float
    {
        $stmt = $this->getPDO('read')->prepare("
            SELECT AVG(note) AS moyenne
            FROM {$this->table}
            WHERE id_utilisateurs = :id_utilisateurs
            AND note IS NOT NULL
        ");
        $stmt->execute([':id_utilisateurs' => $idChauffeur]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['moyenne'] !== null ? (float) $row['moyenne'] : null;
    }

    /**
     * Recherche les chauffeurs ayant une moyenne de notes supérieure ou égale
     * à un seuil donné 
     */
    
    public function findChauffeursParSeuil(float $seuil): array|false
    {
        $stmt = $this->getPDO('read')->prepare("
            SELECT
                n.id_utilisateurs,
                u.nom,
                u.prenom,
                AVG(n.note) AS moyenne,
                COUNT(n.note) AS nombre_notes
            FROM {$this->table} n
            JOIN Utilisateurs u ON n.id_utilisateurs = u.id_utilisateurs
            WHERE n.note IS NOT NULL
            GROUP BY n.id_utilisateurs, u.nom, u.prenom
            HAVING AVG(n.note) >= :seuil
            ORDER BY moyenne DESC
        ");
        $stmt->execute([':seuil' => $seuil]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}