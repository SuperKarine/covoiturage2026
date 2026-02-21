<?php

namespace App\Repository;

use App\Entity\ProposeTrajetChauffeurs;
use App\Entity\ReserverTrajets;
use App\Entity\Trajets;
use PDO;
use DateTime;
use Exception;

class ReserverTrajetsRepository extends Repository
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Récupère un trajet par son ID depuis la table propose_trajet_chauffeurs
     */
    public function getTrajetById($numTrajet)
    {
        $sql = "SELECT * FROM propose_trajet_chauffeurs WHERE num_trajet = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$numTrajet]);
        
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($data) {
            // Convertir les chaînes de date en objets DateTime
            $dateHeureArrivee = new DateTime($data['date_heure_arrivee']);
            $dateHeureDepart = new DateTime($data['date_heure_depart']);
            
            return new ProposeTrajetChauffeurs(
                (int)$data['num_trajet'],
                $dateHeureArrivee,
                $dateHeureDepart,
                $data['ville_depart'],
                $data['ville_arrivee'],
                $data['pseudo_chauffeur'],
                $data['marque'],
                $data['modele'],
                (int)$data['nbr_place_restantes'],
                (int)$data['nbr_place_trajet'],
                (int)$data['prix_personne'],
                (float)$data['temps_trajets'],
                $data['information_sup'],
                (bool)$data['voyage_ecologique']
            );
        }
        
        return null;
    }

    /**
     * Récupère un trajet depuis la table trajets (si alimentée par trigger)
     */
    public function getTrajetFromTrajetsTable($numTrajet)
    {
        $sql = "SELECT * FROM trajets WHERE num_trajet = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$numTrajet]);
        
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($data) {
            $dateHeureArrivee = new DateTime($data['date_heure_arrivee']);
            $dateHeureDepart = new DateTime($data['date_heure_depart']);
            
            return new Trajets(
                (int)$data['id_trajets'],
                $dateHeureArrivee,
                $dateHeureDepart,
                $data['ville_depart'],
                $data['ville_arrivee'],
                (int)$data['id_trajets_effectues'],
                (int)$data['num_trajet']
            );
        }
        
        return null;
    }

    /**
     * Met à jour les places restantes dans propose_trajet_chauffeurs
     */
    public function updatePlacesRestantes($numTrajet, $nbrPlacesReservees)
    {
        $sql = "UPDATE propose_trajet_chauffeurs SET nbr_place_restantes = nbr_place_restantes - ? WHERE num_trajet = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nbrPlacesReservees, $numTrajet]);
    }

    /**
     * Crée une réservation et met à jour les places
     */
    public function createReservation($numTrajet, $userId, $nbrPlaces, $message)
    {
        try {
            $this->pdo->beginTransaction();

            // 1. Vérifier les places disponibles dans propose_trajet_chauffeurs
            $sqlCheck = "SELECT nbr_place_restantes FROM propose_trajet_chauffeurs WHERE num_trajet = ?";
            $stmtCheck = $this->pdo->prepare($sqlCheck);
            $stmtCheck->execute([$numTrajet]);
            $placesRestantes = $stmtCheck->fetchColumn();

            if ($placesRestantes < $nbrPlaces) {
                $this->pdo->rollBack();
                return false;
            }

            // 2. Récupérer les infos du trajet depuis propose_trajet_chauffeurs
            $sqlTrajet = "SELECT date_heure_depart, date_heure_arrivee, ville_depart, ville_arrivee 
                         FROM propose_trajet_chauffeurs WHERE num_trajet = ?";
            $stmtTrajet = $this->pdo->prepare($sqlTrajet);
            $stmtTrajet->execute([$numTrajet]);
            $trajetData = $stmtTrajet->fetch(PDO::FETCH_ASSOC);

            // 3. Créer la réservation dans reserver_trajets
            $sqlReservation = "INSERT INTO reserver_trajets 
                             (num_trajet_reserve, date_heure_depart, date_heure_arrivee, ville_depart, ville_arrivee, id_utilisateur, nbr_places, message, etat_validation) 
                             VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'en attente')";
            
            $stmtReservation = $this->pdo->prepare($sqlReservation);
            $stmtReservation->execute([
                $numTrajet,
                $trajetData['date_heure_depart'],
                $trajetData['date_heure_arrivee'],
                $trajetData['ville_depart'],
                $trajetData['ville_arrivee'],
                $userId,
                $nbrPlaces,
                $message
            ]);

            // 4. Mettre à jour les places restantes dans propose_trajet_chauffeurs
            $this->updatePlacesRestantes($numTrajet, $nbrPlaces);

            $this->pdo->commit();
            return true;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Erreur création réservation: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Vérifie si l'utilisateur a déjà réservé ce trajet
     */
    public function reservationExists($numTrajet, $userId)
    {
        $sql = "SELECT COUNT(*) FROM reserver_trajets WHERE num_trajet_reserve = ? AND id_utilisateur = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$numTrajet, $userId]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Récupère toutes les réservations d'un utilisateur
     */
    public function getReservationsByUser($userId)
    {
        $sql = "SELECT rt.*, ptc.pseudo_chauffeur, ptc.marque, ptc.modele, ptc.prix_personne
                FROM reserver_trajets rt
                JOIN propose_trajet_chauffeurs ptc ON rt.num_trajet_reserve = ptc.num_trajet
                WHERE rt.id_utilisateur = ?
                ORDER BY rt.date_heure_depart DESC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);
        
        $reservations = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $dateHeureArrivee = new DateTime($data['date_heure_arrivee']);
            $dateHeureDepart = new DateTime($data['date_heure_depart']);
            
            $reservations[] = new ReserverTrajets(
                (int)$data['id_reserver_trajet'],
                (int)$data['num_trajet_reserve'],
                $dateHeureArrivee,
                $dateHeureDepart,
                $data['ville_depart'],
                $data['ville_arrivee']
            );
        }
        
        return $reservations;
    }
}