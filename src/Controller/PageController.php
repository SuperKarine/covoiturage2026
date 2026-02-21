<?php

namespace App\Controller;

use App\Controller\Controller;
use App\Repository\ProposeTrajetChauffeursRepository;

class PageController extends Controller
{
    public function accueil(): void
    {
        $this->render('page/accueil');
    }

    public function read_voitures(): void
    {
        $this->render('page/read_voitures');
    }

    public function create_voitures(): void
    {
        $this->render('page/create_voitures');
    }

    public function covoiturage(): void
    {
        $this->render('page/covoiturage');
    }

    public function essaie_trajets(): void
    {
        $proposeTrajetChauffeursRepository = new ProposeTrajetChauffeursRepository();
        $trajets_chauffeurs = $proposeTrajetChauffeursRepository->findAll();
        
        $this->render('page/essaie_trajets', [
            'trajets_chauffeurs' => $trajets_chauffeurs
        ]);
    }

    public function renderView(string $view): void
    {
        $this->render($view);
    }   

    public function login(): void
    {
        $this->render('page/login');
    }

    
    public function propose_trajet_chauffeurs(): void
    {
        $proposeTrajetChauffeursRepository = new ProposeTrajetChauffeursRepository();
        $trajetsChauffeurs = $proposeTrajetChauffeursRepository->findAll();
        
        $this->render('page/propose_trajet_chauffeurs', [
            'trajetsChauffeurs' => $trajetsChauffeurs
        ]);
    }
    
}