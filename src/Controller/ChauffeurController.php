<?php

namespace App\Controller;

use App\Repository\ChauffeursRepository;
use App\Repository\UtilisateursRepository;

class ChauffeurController extends Controller
{
    private ChauffeursRepository $chauffeursRepository;
    private UtilisateursRepository $utilisateursRepository;

    public function __construct()
    {
        $this->chauffeursRepository = new ChauffeursRepository();
        $this->utilisateursRepository = new UtilisateursRepository();
    }

    /**
     * Affiche le tableau de bord chauffeur
     */
    public function showDashboard(): void
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'chauffeur') {
            header('Location: /connexion');
            exit;
        }
        
        $chauffeur = $this->chauffeursRepository->findByUtilisateurId($_SESSION['user_id']);
        
        // Vérification et fallback
        $chauffeurId = $this->getChauffeurId($chauffeur);
        
        $trajets = $chauffeur && $chauffeurId ? $this->chauffeursRepository->getTrajetsByChauffeur($chauffeurId) : [];
        
        $this->render('chauffeur/dashboard', [
            'chauffeur' => $chauffeur,
            'trajets' => $trajets
        ]);
    }

    /**
     * Méthode utilitaire pour récupérer l'ID du chauffeur
     */
    private function getChauffeurId($chauffeur): ?int
    {
        if (!$chauffeur) {
            return null;
        }

        // Essayer différentes méthodes possibles
        if (method_exists($chauffeur, 'getIdChauffeurs')) {
            return $chauffeur->getIdChauffeurs();
        }
        
        if (method_exists($chauffeur, 'getIdChauffeur')) {
            return $chauffeur->getIdChauffeur();
        }
        
        if (method_exists($chauffeur, 'getId')) {
            return $chauffeur->getId();
        }

        // Si aucune méthode ne fonctionne, vérifier la structure de l'objet
        error_log("Structure de l'objet chauffeur: " . print_r($chauffeur, true));
        return null;
    }

    /**
     * Affiche le formulaire de proposition de trajet
     */
    public function showProposerTrajet(): void
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'chauffeur') {
            header('Location: /connexion');
            exit;
        }
        
        $this->render('chauffeur/proposer_trajet');
    }

    /**
     * Traite la proposition de trajet
     */
    public function handleProposerTrajet(): void
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'chauffeur') {
            header('Location: /connexion');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /chauffeur/proposer-trajet?error=method');
            exit;
        }

        // Récupération et validation des données
        $ville_depart = trim($_POST['ville_depart'] ?? '');
        $ville_arrivee = trim($_POST['ville_arrivee'] ?? '');
        $date_heure_depart = $_POST['date_heure_depart'] ?? '';
        $date_heure_arrivee = $_POST['date_heure_arrivee'] ?? '';
        $prix_personne = floatval($_POST['prix_personne'] ?? 0);
        $nbr_place_trajet = intval($_POST['nbr_place_trajet'] ?? 0);
        $marque = trim($_POST['marque'] ?? '');
        $modele = trim($_POST['modele'] ?? '');
        $temps_trajets = floatval($_POST['temps_trajets'] ?? 0);
        $information_sup = trim($_POST['information_sup'] ?? '');
        $voyage_ecologique = isset($_POST['voyage_ecologique']);

        // Validation
        if (empty($ville_depart) || empty($ville_arrivee) || empty($date_heure_depart) || 
            empty($date_heure_arrivee) || $prix_personne <= 0 || $nbr_place_trajet <= 0) {
            header('Location: /chauffeur/proposer-trajet?error=empty');
            exit;
        }

        // Convertir les dates
        $date_heure_depart = str_replace('T', ' ', $date_heure_depart) . ':00';
        $date_heure_arrivee = str_replace('T', ' ', $date_heure_arrivee) . ':00';

        // Récupérer le chauffeur
        $chauffeur = $this->chauffeursRepository->findByUtilisateurId($_SESSION['user_id']);
        if (!$chauffeur) {
            header('Location: /chauffeur/proposer-trajet?error=chauffeur_not_found');
            exit;
        }

        // Récupérer l'ID avec la méthode utilitaire
        $chauffeurId = $this->getChauffeurId($chauffeur);
        if (!$chauffeurId) {
            header('Location: /chauffeur/proposer-trajet?error=chauffeur_id_not_found');
            exit;
        }

        // Créer le trajet
        $success = $this->chauffeursRepository->createTrajet([
            'id_chauffeur' => $chauffeurId,
            'ville_depart' => $ville_depart,
            'ville_arrivee' => $ville_arrivee,
            'date_heure_depart' => $date_heure_depart,
            'date_heure_arrivee' => $date_heure_arrivee,
            'prix_personne' => $prix_personne,
            'nbr_place_trajet' => $nbr_place_trajet,
            'pseudo_chauffeur' => $_SESSION['user_prenom'] ?? 'Chauffeur',
            'marque' => $marque,
            'modele' => $modele,
            'temps_trajets' => $temps_trajets,
            'information_sup' => $information_sup,
            'voyage_ecologique' => $voyage_ecologique
        ]);

        if ($success) {
            header('Location: /chauffeur/dashboard?success=trajet_created');
        } else {
            header('Location: /chauffeur/proposer-trajet?error=creation_failed');
        }
        exit;
    }

    /**
     * Affiche tous les trajets disponibles
     */
    public function showTrajetsDisponibles(): void
    {
        $trajets = $this->chauffeursRepository->getAllTrajetsDisponibles();
        
        $this->render('chauffeur/trajets_disponibles', [
            'trajetsChauffeurs' => $trajets
        ]);
    }

    /**
     * Affiche les détails d'un trajet
     */
    public function showTrajetDetail(int $trajetId): void
    {
        $trajet = $this->chauffeursRepository->findTrajetById($trajetId);
        
        if (!$trajet) {
            $this->render('errors/404');
            return;
        }
        
        $this->render('chauffeur/trajet_detail', [
            'trajet' => $trajet
        ]);
    }

    /**
     * Supprime un trajet
     */
    public function handleDeleteTrajet(): void
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'chauffeur') {
            header('Location: /connexion');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /chauffeur/dashboard?error=method');
            exit;
        }

        $trajetId = intval($_POST['trajet_id'] ?? 0);
        
        if ($trajetId <= 0) {
            header('Location: /chauffeur/dashboard?error=invalid_id');
            exit;
        }

        $chauffeur = $this->chauffeursRepository->findByUtilisateurId($_SESSION['user_id']);
        $chauffeurId = $this->getChauffeurId($chauffeur);
        
        if (!$chauffeur || !$chauffeurId || !$this->chauffeursRepository->isChauffeurTrajetOwner($chauffeurId, $trajetId)) {
            header('Location: /chauffeur/dashboard?error=not_owner');
            exit;
        }

        $success = $this->chauffeursRepository->deleteTrajet($trajetId);

        if ($success) {
            header('Location: /chauffeur/dashboard?success=trajet_deleted');
        } else {
            header('Location: /chauffeur/dashboard?error=delete_failed');
        }
        exit;
    }

    /**
     * Met à jour les places restantes
     */
    public function handleUpdatePlaces(): void
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'chauffeur') {
            header('Location: /connexion');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /chauffeur/dashboard?error=method');
            exit;
        }

        $trajetId = intval($_POST['trajet_id'] ?? 0);
        $nouvellesPlaces = intval($_POST['nouvelles_places'] ?? 0);
        
        if ($trajetId <= 0 || $nouvellesPlaces < 0) {
            header('Location: /chauffeur/dashboard?error=invalid_data');
            exit;
        }

        $chauffeur = $this->chauffeursRepository->findByUtilisateurId($_SESSION['user_id']);
        $chauffeurId = $this->getChauffeurId($chauffeur);
        
        if (!$chauffeur || !$chauffeurId || !$this->chauffeursRepository->isChauffeurTrajetOwner($chauffeurId, $trajetId)) {
            header('Location: /chauffeur/dashboard?error=not_owner');
            exit;
        }

        $success = $this->chauffeursRepository->updatePlacesRestantes($trajetId, $nouvellesPlaces);

        if ($success) {
            header('Location: /chauffeur/dashboard?success=places_updated');
        } else {
            header('Location: /chauffeur/dashboard?error=update_failed');
        }
        exit;
    }
}