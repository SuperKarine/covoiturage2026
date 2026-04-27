<?php

namespace Controllers;

class AuthController
{
    public function register()
    {
        ob_start();

        require __DIR__ . '/../../views/auth/register.php';

        $content = ob_get_clean();

        ob_start();

        require __DIR__ . '/../../views/layouts/main.php';

        return ob_get_clean();
    }
}