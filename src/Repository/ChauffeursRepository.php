<?php

namespace App\Repository;

use App\Entity\Chauffeurs;
use App\Entity\ProposeTrajetChauffeurs;
use PDO;
use DateTime;

class ChauffeursRepository extends Repository
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Méthode d'hydratation pour créer un objet ProposeTrajetChauffeurs à partir d'un tableau
     */
    private function hydrateProposeTrajetChauffeurs(array $data): ProposeTrajetChauffeurs
    {
        // Conversion des dates
        $dateHeureDepart = DateTime::createFromFormat('Y-m-d H:i:s', $data['date_heure_depart']);
        $dateHeureArrivee = DateTime::createFromFormat('Y-m-d H:i:s', $data['date_heure_arrivee']);

        // Vérification que les dates sont valides
        if ($dateHeureDepart === false) {
            throw new \Exception("Date de départ invalide: " . $data['date_heure_depart']);
        }
        
        if ($dateHeureArrivee === false) {
            throw new \Exception("Date d'arrivée invalide: " . $data['date_heure_arrivee']);
        }

        // Conversion du booléen
        $voyageEcologique = false;
        if (isset($data['voyage_ecologique'])) {
            if (is_string($data['voyage_ecologique'])) {
                $voyageEcologique = $data['voyage_ecologique'] === '1' || $data['voyage_ecologique'] === 'true';
            } else {
                $voyageEcologique = (bool)$data['voyage_ecologique'];
            }
        }

        return new ProposeTrajetChauffeurs(
            isset($data['num_trajet']) ? (int)$data['num_trajet'] : null,
            $dateHeureArrivee,
            $dateHeureDepart,
            $data['ville_depart'] ?? '',
            $data['ville_arrivee'] ?? '',
            $data['pseudo_chauffeur'] ?? '',
            $data['marque'] ?? '',
            $data['modele'] ?? '',
            isset($data['nbr_place_restantes']) ? (int)$data['nbr_place_restantes'] : 0,
            isset($data['nbr_place_trajet']) ? (int)$data['nbr_place_trajet'] : 0,
            isset($data['prix_personne']) ? (float)$data['prix_personne'] : 0.0,
            isset($data['temps_trajets']) ? (float)$data['temps_trajets'] : 0.0,
            $data['information_sup'] ?? '',
            $voyageEcologique
        );
    }

    /**
     * Trouve un chauffeur par son ID utilisateur
     */
    public function findByUtilisateurId(int $utilisateurId): ?Chauffeurs
    {
        try {
            $sql = "SELECT c.*, u.prenom, u.nom, u.email, u.pseudo, u.date_naissance, u.telephone, u.isChauffeur 
                    FROM chauffeurs c 
                    JOIN utilisateurs u ON c.id_utilisateurs = u.id_utilisateurs 
                    WHERE c.id_utilisateurs = ?";
            
            $statement = $this->pdo->prepare($sql);
            $statement->execute([$utilisateurId]);
            $chauffeurData = $statement->fetch(PDO::FETCH_ASSOC);
            
            return $chauffeurData ? Chauffeurs::fromArray($chauffeurData) : null;
        } catch (\Exception $e) {
            error_log("Erreur recherche chauffeur: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Crée un nouveau chauffeur
     */
    public function createChauffeur(int $utilisateurId): bool
    {
        try {
            $sql = "INSERT INTO chauffeurs (id_utilisateurs, statut, date_creation) 
                    VALUES (?, 'actif', NOW())";
            
            $statement = $this->pdo->prepare($sql);
            return $statement->execute([$utilisateurId]);
        } catch (\Exception $e) {
            error_log("Erreur création chauffeur: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Crée un trajet dans propose_trajet_chauffeurs
     */
    public function createTrajet(array $trajetData): bool
    {
        try {
            $sql = "INSERT INTO propose_trajet_chauffeurs 
                    (id_chauffeur, ville_depart, ville_arrivee, date_heure_depart, date_heure_arrivee, 
                     prix_personne, nbr_place_trajet, nbr_place_restantes, pseudo_chauffeur, 
                     marque, modele, temps_trajets, information_sup, voyage_ecologique) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $statement = $this->pdo->prepare($sql);
            return $statement->execute([
                $trajetData['id_chauffeur'],
                $trajetData['ville_depart'],
                $trajetData['ville_arrivee'],
                $trajetData['date_heure_depart'],
                $trajetData['date_heure_arrivee'],
                $trajetData['prix_personne'],
                $trajetData['nbr_place_trajet'],
                $trajetData['nbr_place_trajet'],
                $trajetData['pseudo_chauffeur'],
                $trajetData['marque'],
                $trajetData['modele'],
                $trajetData['temps_trajets'],
                $trajetData['information_sup'],
                $trajetData['voyage_ecologique'] ? 1 : 0
            ]);
        } catch (\Exception $e) {
            error_log("Erreur lors de la création du trajet: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Récupère tous les trajets d'un chauffeur sous forme d'objets ProposeTrajetChauffeurs
     */
    public function getTrajetsByChauffeur(int $chauffeurId): array
    {
        try {
            $sql = "SELECT tc.*, u.pseudo as pseudo_chauffeur
                    FROM propose_trajet_chauffeurs tc
                    JOIN chauffeurs c ON tc.id_chauffeur = c.id_chauffeur
                    JOIN utilisateurs u ON c.id_utilisateurs = u.id_utilisateurs
                    WHERE tc.id_chauffeur = ?
                    ORDER BY tc.date_heure_depart DESC";
            
            $statement = $this->pdo->prepare($sql);
            $statement->execute([$chauffeurId]);
            
            $resultData = $statement->fetchAll(PDO::FETCH_ASSOC);
            
            $trajets = [];
            foreach ($resultData as $row) {
                try {
                    $trajet = $this->hydrateProposeTrajetChauffeurs($row);
                    $trajets[] = $trajet;
                } catch (\Exception $e) {
                    error_log("Erreur création objet trajet: " . $e->getMessage());
                    continue;
                }
            }
            
            return $trajets;
        } catch (\Exception $e) {
            error_log("Erreur récupération trajets chauffeur: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Récupère tous les trajets disponibles sous forme d'objets ProposeTrajetChauffeurs
     */
    public function getAllTrajetsDisponibles(): array
    {
        try {
            $sql = "SELECT tc.*, u.pseudo as pseudo_chauffeur
                    FROM propose_trajet_chauffeurs tc
                    JOIN chauffeurs c ON tc.id_chauffeur = c.id_chauffeur
                    JOIN utilisateurs u ON c.id_utilisateurs = u.id_utilisateurs
                    WHERE tc.date_heure_depart > NOW() AND tc.nbr_place_restantes > 0
                    ORDER BY tc.date_heure_depart ASC";
            
            $statement = $this->pdo->prepare($sql);
            $statement->execute();
            
            $resultData = $statement->fetchAll(PDO::FETCH_ASSOC);
            
            $trajets = [];
            foreach ($resultData as $row) {
                try {
                    $trajet = $this->hydrateProposeTrajetChauffeurs($row);
                    $trajets[] = $trajet;
                } catch (\Exception $e) {
                    error_log("Erreur création objet trajet disponible: " . $e->getMessage());
                    continue;
                }
            }
            
            return $trajets;
        } catch (\Exception $e) {
            error_log("Erreur récupération trajets disponibles: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Récupère un trajet par son ID sous forme d'objet ProposeTrajetChauffeurs
     */
    public function findTrajetById(int $trajetId): ?ProposeTrajetChauffeurs
    {
        try {
            $sql = "SELECT tc.*, u.pseudo as pseudo_chauffeur
                    FROM propose_trajet_chauffeurs tc
                    JOIN chauffeurs c ON tc.id_chauffeur = c.id_chauffeur
                    JOIN utilisateurs u ON c.id_utilisateurs = u.id_utilisateurs
                    WHERE tc.num_trajet = ?";
            
            $statement = $this->pdo->prepare($sql);
            $statement->execute([$trajetId]);
            $trajetData = $statement->fetch(PDO::FETCH_ASSOC);
            
            if (!$trajetData) {
                return null;
            }
            
            return $this->hydrateProposeTrajetChauffeurs($trajetData);
        } catch (\Exception $e) {
            error_log("Erreur recherche trajet: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Met à jour les places restantes d'un trajet
     */
    public function updatePlacesRestantes(int $trajetId, int $nouvellesPlaces): bool
    {
        try {
            $sql = "UPDATE propose_trajet_chauffeurs 
                    SET nbr_place_restantes = ? 
                    WHERE num_trajet = ?";
            
            $statement = $this->pdo->prepare($sql);
            return $statement->execute([$nouvellesPlaces, $trajetId]);
        } catch (\Exception $e) {
            error_log("Erreur mise à jour places: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Supprime un trajet
     */
    public function deleteTrajet(int $trajetId): bool
    {
        try {
            $sql = "DELETE FROM propose_trajet_chauffeurs WHERE num_trajet = ?";
            $statement = $this->pdo->prepare($sql);
            return $statement->execute([$trajetId]);
        } catch (\Exception $e) {
            error_log("Erreur suppression trajet: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Vérifie si un chauffeur est propriétaire d'un trajet
     */
    public function isChauffeurTrajetOwner(int $chauffeurId, int $trajetId): bool
    {
        try {
            $sql = "SELECT COUNT(*) FROM propose_trajet_chauffeurs 
                    WHERE num_trajet = ? AND id_chauffeur = ?";
            $statement = $this->pdo->prepare($sql);
            $statement->execute([$trajetId, $chauffeurId]);
            return $statement->fetchColumn() > 0;
        } catch (\Exception $e) {
            error_log("Erreur vérification propriétaire trajet: " . $e->getMessage());
            return false;
        }
    }

    /**
 * Récupère tous les trajets (même passés et complets) pour l'admin
 */
public function getAllTrajets(): array
{
    try {
        $sql = "SELECT tc.*, u.pseudo as pseudo_chauffeur
                FROM propose_trajet_chauffeurs tc
                JOIN chauffeurs c ON tc.id_chauffeur = c.id_chauffeur
                JOIN utilisateurs u ON c.id_utilisateurs = u.id_utilisateurs
                ORDER BY tc.date_heure_depart DESC";
        
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        
        $resultData = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        $trajets = [];
        foreach ($resultData as $row) {
            try {
                $trajet = $this->hydrateProposeTrajetChauffeurs($row);
                $trajets[] = $trajet;
            } catch (\Exception $e) {
                error_log("Erreur création objet trajet admin: " . $e->getMessage());
                continue;
            }
        }
        
        return $trajets;
    } catch (\Exception $e) {
        error_log("Erreur récupération tous les trajets: " . $e->getMessage());
        return [];
    }
}

/**
 * Met à jour un trajet
 */
public function updateTrajet(int $trajetId, array $trajetData): bool
{
    try {
        $sql = "UPDATE propose_trajet_chauffeurs 
                SET ville_depart = ?, ville_arrivee = ?, date_heure_depart = ?, date_heure_arrivee = ?,
                    prix_personne = ?, nbr_place_trajet = ?, nbr_place_restantes = ?, 
                    marque = ?, modele = ?, temps_trajets = ?, information_sup = ?, voyage_ecologique = ?
                WHERE num_trajet = ?";

        $statement = $this->pdo->prepare($sql);
        return $statement->execute([
            $trajetData['ville_depart'],
            $trajetData['ville_arrivee'],
            $trajetData['date_heure_depart'],
            $trajetData['date_heure_arrivee'],
            $trajetData['prix_personne'],
            $trajetData['nbr_place_trajet'],
            $trajetData['nbr_place_restantes'],
            $trajetData['marque'],
            $trajetData['modele'],
            $trajetData['temps_trajets'],
            $trajetData['information_sup'],
            $trajetData['voyage_ecologique'] ? 1 : 0,
            $trajetId
        ]);
    } catch (\Exception $e) {
        error_log("Erreur mise à jour trajet: " . $e->getMessage());
        return false;
    }
}


}