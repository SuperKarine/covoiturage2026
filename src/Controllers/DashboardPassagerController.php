<?php

namespace Controllers;

use Models\ReservationModel;

class DashboardPassagerController
{
    private ReservationModel $reservationModel;

    public function __construct()
    {
        $this->reservationModel = new ReservationModel();
    }

    
    // GET /passager/dashboard
     
    public function index(): string
    {
        $idPassager = $_SESSION['user_id'];

        $mesReservations = $this->reservationModel->findByPassager($idPassager);

        ob_start();
        require __DIR__ . '/../../views/passager/dashboard.php';
        $content = ob_get_clean();

        ob_start();
        require __DIR__ . '/../../views/layouts/main.php';
        return ob_get_clean();
    }
}