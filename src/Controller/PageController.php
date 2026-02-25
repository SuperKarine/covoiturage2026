<?php

namespace App\Controller;

use App\Controller\Controller;


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

    public function renderView(string $view): void
    {
        $this->render($view);
    }   

    public function login(): void
    {
        $this->render('page/login');
    }

    

    
}