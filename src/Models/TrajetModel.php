<?php
namespace Models;

use Models\Model;
use PDO;


class TrajetModel extends Model
{
    protected string $table = 'Trajets';

    
     // Requête avec tous les JOIN nécessaires à l'affichage
     
    private function baseSelect(): string
    {
        return "
            SELECT
                t.id_trajet,
                t.nbr_places_dispo,
                t.fumeur,
                t.animaux,
                t.prix,
                t.date_depart,
                t.id_utilisateurs,
                t.id_ville_depart,
                t.id_ville_arrivee,
                t.id_voiture,
                vd.nom_ville AS ville_depart,
                va.nom_ville AS ville_arrivee,
                v.modele AS voiture_modele,
                v.nb_places AS voiture_nb_places,
                v.energie AS voiture_energie,
                u.nom AS chauffeur_nom,
                u.prenom AS chauffeur_prenom
            FROM {$this->table} t
            JOIN Ville vd ON t.id_ville_depart = vd.id_ville
            JOIN Ville va ON t.id_ville_arrivee = va.id_ville
            JOIN Voiture v ON t.id_voiture = v.id_voiture
            JOIN Utilisateurs u ON t.id_utilisateurs = u.id_utilisateurs
        ";
    }

    
     //Recherche de trajets pour l'API REST publique (passager).
     
    public function search(array $filters = []): array|false
    {
        $sql = $this->baseSelect() . " WHERE 1=1";
        $params = [];

        if (!empty($filters['ville_depart'])) {
            $sql .= " AND vd.nom_ville = :ville_depart";
            $params[':ville_depart'] = $filters['ville_depart'];
        }

        if (!empty($filters['ville_arrivee'])) {
            $sql .= " AND va.nom_ville = :ville_arrivee";
            $params[':ville_arrivee'] = $filters['ville_arrivee'];
        }

        if (!empty($filters['date_depart'])) {
            $sql .= " AND DATE(t.date_depart) = :date_depart";
            $params[':date_depart'] = $filters['date_depart'];
        }

        if (isset($filters['places_min'])) {
            $sql .= " AND t.nbr_places_dispo >= :places_min";
            $params[':places_min'] = (int) $filters['places_min'];
        }

        if (isset($filters['fumeur'])) {
            $sql .= " AND t.fumeur = :fumeur";
            $params[':fumeur'] = (bool) $filters['fumeur'] ? 1 : 0;
        }

        if (isset($filters['animaux'])) {
            $sql .= " AND t.animaux = :animaux";
            $params[':animaux'] = (bool) $filters['animaux'] ? 1 : 0;
        }

        if (isset($filters['prix_max'])) {
            $sql .= " AND t.prix <= :prix_max";
            $params[':prix_max'] = (float) $filters['prix_max'];
        }

        $sql .= " ORDER BY t.date_depart ASC";

        $stmt = $this->getPDO('read')->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
     // Je récupère un trajet précis par son ID.
    
    public function findById(int $id): array|false
    {
        $sql = $this->baseSelect() . " WHERE t.id_trajet = :id";

        $stmt = $this->getPDO('read')->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Vue admin : tous les trajets, avec filtre optionnel par chauffeur
     * et par période (passé / à venir).
     *
     * @param string|null $periode 'passe' | 'avenir' | null (tous)
     */
    public function getAllForAdmin(?int $idChauffeur = null, ?string $periode = null): array|false
    {
        $sql = $this->baseSelect() . " WHERE 1=1";
        $params = [];

        if ($idChauffeur !== null) {
            $sql .= " AND t.id_utilisateurs = :id_chauffeur";
            $params[':id_chauffeur'] = $idChauffeur;
        }

        if ($periode === 'passe') {
            $sql .= " AND t.date_depart < NOW()";
        } elseif ($periode === 'avenir') {
            $sql .= " AND t.date_depart >= NOW()";
        }

        $sql .= " ORDER BY t.date_depart DESC";

        $stmt = $this->getPDO('read')->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
     //Crée un nouveau trajet (dashboard chauffeur)
    
    public function create(array $data): int|false
    {
        $pdo = $this->getPDO('write');

        $stmt = $pdo->prepare("
            INSERT INTO {$this->table}
                (nbr_places_dispo, fumeur, animaux, prix, date_depart, id_utilisateurs, id_ville_depart, id_ville_arrivee, id_voiture)
            VALUES
                (:nbr_places_dispo, :fumeur, :animaux, :prix, :date_depart, :id_utilisateurs, :id_ville_depart, :id_ville_arrivee, :id_voiture)
        ");

        $success = $stmt->execute([
            ':nbr_places_dispo' => $data['nbr_places_dispo'],
            ':fumeur' => $data['fumeur'] ? 1 : 0,
            ':animaux' => $data['animaux'] ? 1 : 0,
            ':prix' => $data['prix'],
            ':date_depart' => $data['date_depart'],
            ':id_utilisateurs' => $data['id_utilisateurs'],
            ':id_ville_depart' => $data['id_ville_depart'],
            ':id_ville_arrivee' => $data['id_ville_arrivee'],
            ':id_voiture' => $data['id_voiture'],
        ]);

        return $success ? (int) $pdo->lastInsertId() : false;
    }

    
     // Je mets à jour un trajet existant (dashboard chauffeur).
     
    public function update(int $id, array $data): bool
    {
        $stmt = $this->getPDO('write')->prepare("
            UPDATE {$this->table}
            SET
                nbr_places_dispo = :nbr_places_dispo,
                fumeur = :fumeur,
                animaux = :animaux,
                prix = :prix,
                date_depart = :date_depart,
                id_ville_depart = :id_ville_depart,
                id_ville_arrivee = :id_ville_arrivee,
                id_voiture = :id_voiture
            WHERE id_trajet = :id
        ");

        return $stmt->execute([
            ':nbr_places_dispo' => $data['nbr_places_dispo'],
            ':fumeur' => $data['fumeur'] ? 1 : 0,
            ':animaux' => $data['animaux'] ? 1 : 0,
            ':prix' => $data['prix'],
            ':date_depart' => $data['date_depart'],
            ':id_ville_depart' => $data['id_ville_depart'],
            ':id_ville_arrivee' => $data['id_ville_arrivee'],
            ':id_voiture' => $data['id_voiture'],
            ':id' => $id,
        ]);
    }

    
     // Je supprime un trajet (dashboard chauffeur).
     
    public function delete(int $id): bool
    {
        $stmt = $this->getPDO('write')->prepare("
            DELETE FROM {$this->table} WHERE id_trajet = :id
        ");
        return $stmt->execute([':id' => $id]);
    }
}