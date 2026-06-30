<?php

namespace Controllers;

use Models\TrajetModel;
use Models\VoitureModel;
use Models\ReservationModel;


class DashboardChauffeurController
{
    private TrajetModel $trajetModel;
    private VoitureModel $voitureModel;
    private ReservationModel $reservationModel;

    public function __construct()
    {
        $this->trajetModel = new TrajetModel();
        $this->voitureModel = new VoitureModel();
        $this->reservationModel = new ReservationModel();
    }

    
    // GET /chauffeur/dashboard
     
    public function index(): string
    {
        $idChauffeur = $_SESSION['user_id'];

        $trajets = $this->trajetModel->getAllForAdmin($idChauffeur);

        foreach ($trajets as &$trajet) {
            $trajet['reservations_en_attente'] = $this->reservationModel->findEnAttenteParTrajet(
                $trajet['id_trajet']
            );
        }

        $voitures = $this->voitureModel->getByChauffeur($idChauffeur);

        ob_start();
        require __DIR__ . '/../../views/chauffeur/dashboard.php';
        $content = ob_get_clean();

        ob_start();
        require __DIR__ . '/../../views/layouts/main.php';
        return ob_get_clean();
    }

    /**
     * GET /chauffeur/trajets/ajouter
     * Formulaire d'ajout de trajet.
     */
    
    public function ajouterTrajetForm(): string
    {
        $idChauffeur = $_SESSION['user_id'];
        $voitures = $this->voitureModel->getByChauffeur($idChauffeur);

        ob_start();
        require __DIR__ . '/../../views/chauffeur/ajouter-trajet.php';
        $content = ob_get_clean();

        ob_start();
        require __DIR__ . '/../../views/layouts/main.php';
        return ob_get_clean();
    }
}