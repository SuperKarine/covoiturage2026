<?php

namespace Controllers;

use Models\DemandeChauffeurModel;
use Models\TrajetModel;
use Models\NoteModel;


class DashboardAdminController
{
    private DemandeChauffeurModel $demandeModel;
    private TrajetModel $trajetModel;
    private NoteModel $noteModel;

    public function __construct()
    {
        $this->demandeModel = new DemandeChauffeurModel();
        $this->trajetModel = new TrajetModel();
        $this->noteModel = new NoteModel();
    }

    
    // GET /admin/dashboard
     
    public function index(): string
    {
        $demandesEnAttente = $this->demandeModel->findEnAttente();
        $tousLesTrajets = $this->trajetModel->getAllForAdmin();
        $notesParChauffeur = $this->noteModel->findChauffeursParSeuil(0);

        ob_start();
        require __DIR__ . '/../../views/admin/dashboard.php';
        $content = ob_get_clean();

        ob_start();
        require __DIR__ . '/../../views/layouts/main.php';
        return ob_get_clean();
    }
}