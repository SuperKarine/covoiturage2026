<?php
namespace Models;


use Models\Model;
use PDO;

class VoitureModel extends Model
{
    protected string $table = 'Voiture';

    
     // Récupère toutes les voitures d'un chauffeur 
     
    public function getByChauffeur(int $idUtilisateur): array|false
    {
        $stmt = $this->getPDO('read')->prepare("
            SELECT id_voiture, modele, nb_places, energie, id_utilisateurs
            FROM {$this->table}
            WHERE id_utilisateurs = :id_utilisateurs
            ORDER BY modele ASC
        ");
        $stmt->execute([':id_utilisateurs' => $idUtilisateur]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
     // Récupère une voiture précise par son ID.
     
    public function findById(int $id): array|false
    {
        $stmt = $this->getPDO('read')->prepare("
            SELECT id_voiture, modele, nb_places, energie, id_utilisateurs
            FROM {$this->table}
            WHERE id_voiture = :id
        ");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
     // Crée une nouvelle voiture pour un chauffeur.
     
    public function create(array $data): int|false
    {
        $pdo = $this->getPDO('write');

        $stmt = $pdo->prepare("
            INSERT INTO {$this->table} (modele, nb_places, energie, id_utilisateurs)
            VALUES (:modele, :nb_places, :energie, :id_utilisateurs)
        ");

        $success = $stmt->execute([
            ':modele' => $data['modele'],
            ':nb_places' => $data['nb_places'],
            ':energie' => $data['energie'],
            ':id_utilisateurs' => $data['id_utilisateurs'],
        ]);

        return $success ? (int) $pdo->lastInsertId() : false;
    }
}