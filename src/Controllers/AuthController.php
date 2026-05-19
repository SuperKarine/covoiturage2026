<?php

namespace Controllers;

use Models\UtilisateursModel;

class AuthController
{
    protected UtilisateursModel $userModel;

    public function __construct()
    {
        $this->userModel = new UtilisateursModel();
    }

    public function register()
    {
        
        $errors = [];

        //  Traitement du formulaire (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $errors = $this->gestionRegister();
        
            if (empty($errors)) {
                header('Location: /home');
                exit;
            }
        
        }

    

        //  Affichage formulaire (GET ou erreurs POST)
        ob_start();
        require __DIR__ . '/../../views/auth/register.php';
        $content = ob_get_clean();

        ob_start();
        require __DIR__ . '/../../views/layouts/main.php';
        return ob_get_clean();
    }

    private function gestionRegister(): array
    {
        $errors = [];

        if (!empty($_POST)) {

            
            // USERNAME
         
            if (empty($_POST['username']) || !preg_match("#^[a-zA-Z0-9_]+$#", $_POST['username'])) {
                $errors['username'] = "Votre identifiant n'est pas valide";
            } else {
                
                // Instanciation du model pour avoir un identifiant unique
                $user = $this->userModel->findByUsername($_POST['username']);

                if ($user) {
                    $errors['username'] = "Cet identifiant est déjà pris";
                }
            }

           
            // EMAIL
          
            if (empty($_POST['mail']) || !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
                $errors['mail'] = "Votre email n'est pas valide";
            } else {
                
                // Instanciation du model pour avoir une adresse email unique
                $user = $this->userModel->findByEmail($_POST['mail']);

                if ($user) {
                    $errors['mail'] = "Cette adresse mail est déjà prise";
                }
            }

           
           // PASSWORD
            if (empty($_POST['password'])) {
                $errors['password'] = "Le mot de passe est obligatoire";

            } elseif (strlen($_POST['password']) < 8) {
                $errors['password'] = "Le mot de passe doit faire au moins 8 caractères";

            } elseif ($_POST['password'] !== ($_POST['password_confirm'] ?? '')) {
                $errors['password'] = "Les mots de passe ne correspondent pas";
            }

            
            // INSERT USER
            //Condition avant de passer à l'inscription (si le []errors est vide)
           
            if (empty($errors)) {

             // Génération d’un token sécurisé   
                $token = bin2hex(random_bytes(32));

                $this->userModel->createUser([
                    'username' => $_POST['username'],
                    'email' => $_POST['mail'],
                    'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
                    'confirmation_token' => $token
                ]);
            }
        }

        return $errors;
    }
}