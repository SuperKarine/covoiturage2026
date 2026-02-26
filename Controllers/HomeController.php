<?php
namespace Controllers;

use Models\User;
use Source\Renderer;

class HomeController
{
    public function index(): Renderer
    {
        $userModel = new User();
        $users = $userModel->getAll(); // méthode du modèle

        foreach($users as $user) {
            var_dump($user);
        }

        return Renderer::make('home/index');
    }
}