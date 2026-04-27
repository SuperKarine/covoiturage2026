<?php

namespace Controllers;

class HomeController
{
    public function index()
    {
        ob_start();

        require __DIR__ . '/../../views/home/index.php';

        $content = ob_get_clean();

        ob_start();

        require __DIR__ . '/../../views/layouts/main.php';

        return ob_get_clean();
    }
}