<?php

namespace App\Controller;

use App\Repository\ChauffeursRepository;
use App\Repository\UtilisateursRepository;

class AdminController extends Controller
{
    private ChauffeursRepository $chauffeursRepository;
    private UtilisateursRepository $utilisateursRepository;

    public function __construct()
    {
        $this->chauffeursRepository = new ChauffeursRepository();
        $this->utilisateursRepository = new UtilisateursRepository();
    }

    /**
     * Affiche le tableau de bord admin
     */
    public function showDashboard(): void
    {
        AuthController::requireUserType(['admin']);
        
        // Récupérer tous les trajets pour l'admin
        $trajets = $this->chauffeursRepository->getAllTrajets();
        
        $this->render('admin/dashboard', [
            'trajets' => $trajets
        ]);
    }

    /**
     * Affiche le formulaire de modification d'un trajet
     */
    public function showEditTrajet(int $trajetId): void
    {
        AuthController::requireUserType(['admin']);
        
        $trajet = $this->chauffeursRepository->findTrajetById($trajetId);
        
        if (!$trajet) {
            $this->render('errors/404');
            return;
        }
        
        $this->render('admin/edit_trajet', [
            'trajet' => $trajet
        ]);
    }

    /**
     * Traite la modification d'un trajet
     */
    public function handleEditTrajet(): void
    {
        AuthController::requireUserType(['admin']);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/dashboard?error=method');
            exit;
        }

        $trajetId = intval($_POST['trajet_id'] ?? 0);
        
        if ($trajetId <= 0) {
            header('Location: /admin/dashboard?error=invalid_id');
            exit;
        }

        // Vérifier que le trajet existe
        $trajet = $this->chauffeursRepository->findTrajetById($trajetId);
        if (!$trajet) {
            header('Location: /admin/dashboard?error=trajet_not_found');
            exit;
        }

        // Récupération et nettoyage des données
        $ville_depart = trim($_POST['ville_depart'] ?? '');
        $ville_arrivee = trim($_POST['ville_arrivee'] ?? '');
        $date_heure_depart = $_POST['date_heure_depart'] ?? '';
        $date_heure_arrivee = $_POST['date_heure_arrivee'] ?? '';
        $prix_personne = floatval($_POST['prix_personne'] ?? 0);
        $nbr_place_trajet = intval($_POST['nbr_place_trajet'] ?? 0);
        $nbr_place_restantes = intval($_POST['nbr_place_restantes'] ?? 0);
        $marque = trim($_POST['marque'] ?? '');
        $modele = trim($_POST['modele'] ?? '');
        $temps_trajets = floatval($_POST['temps_trajets'] ?? 0);
        $information_sup = trim($_POST['information_sup'] ?? '');
        $voyage_ecologique = isset($_POST['voyage_ecologique']);

        // Validation
        if (empty($ville_depart) || empty($ville_arrivee) || empty($date_heure_depart) || 
            empty($date_heure_arrivee) || $prix_personne <= 0 || $nbr_place_trajet <= 0) {
            header('Location: /admin/trajet/' . $trajetId . '/edit?error=empty');
            exit;
        }

        // Convertir les dates pour MySQL
        $date_heure_depart = str_replace('T', ' ', $date_heure_depart) . ':00';
        $date_heure_arrivee = str_replace('T', ' ', $date_heure_arrivee) . ':00';

        // Mettre à jour le trajet
        $success = $this->chauffeursRepository->updateTrajet($trajetId, [
            'ville_depart' => $ville_depart,
            'ville_arrivee' => $ville_arrivee,
            'date_heure_depart' => $date_heure_depart,
            'date_heure_arrivee' => $date_heure_arrivee,
            'prix_personne' => $prix_personne,
            'nbr_place_trajet' => $nbr_place_trajet,
            'nbr_place_restantes' => $nbr_place_restantes,
            'marque' => $marque,
            'modele' => $modele,
            'temps_trajets' => $temps_trajets,
            'information_sup' => $information_sup,
            'voyage_ecologique' => $voyage_ecologique
        ]);

        if ($success) {
            header('Location: /admin/dashboard?success=trajet_updated');
        } else {
            header('Location: /admin/trajet/' . $trajetId . '/edit?error=update_failed');
        }
        exit;
    }

    /**
     * Annule un trajet (suppression)
     */
    public function handleCancelTrajet(): void
    {
        AuthController::requireUserType(['admin']);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/dashboard?error=method');
            exit;
        }

        $trajetId = intval($_POST['trajet_id'] ?? 0);
        
        if ($trajetId <= 0) {
            header('Location: /admin/dashboard?error=invalid_id');
            exit;
        }

        // L'admin peut supprimer n'importe quel trajet sans vérification de propriétaire
        $success = $this->chauffeursRepository->deleteTrajet($trajetId);

        if ($success) {
            header('Location: /admin/dashboard?success=trajet_cancelled');
        } else {
            header('Location: /admin/dashboard?error=cancel_failed');
        }
        exit;
    }

    /**
     * Affiche tous les trajets (pour l'admin)
     */
    public function showAllTrajets(): void
    {
        AuthController::requireUserType(['admin']);
        
        $trajets = $this->chauffeursRepository->getAllTrajets();
        
        $this->render('admin/all_trajets', [
            'trajets' => $trajets
        ]);
    }
}