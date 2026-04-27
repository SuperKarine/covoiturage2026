<?php

namespace Controllers;

class HomeController
{
    public function index()
    {
        ob_start();

        require __DIR__ . '/../../views/home/index.php';

        return ob_get_clean();
    }
}