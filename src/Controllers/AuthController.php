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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->gestionRegister();
            return;
        }

        ob_start();
        require __DIR__ . '/../../views/auth/register.php';
        $content = ob_get_clean();

        ob_start();
        require __DIR__ . '/../../views/layouts/main.php';
        return ob_get_clean();
    }

    public function gestionRegister()
    {
        if (!empty($_POST)) {

            $errors = [];

            //Pseudo
            if (empty($_POST['username']) || !preg_match("#^[a-zA-Z0-9_]+$#", $_POST['username'])) {
                $errors['username'] = "Votre identifiant n'est pas valide";
                var_dump($errors);
            } else {

                // Instanciation du model pour avoir un identifiant unique
                $user = $this->userModel->findByUsername($_POST['username']);

                if ($user) {
                    $errors['username'] = "Cet identifiant est déjà pris";
                }
            }

            //Email
            if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Votre email n'est pas valide";
                var_dump($errors);
            } else {

                // Instanciation du model pour avoir une adresse email unique
                $user = $this->userModel->findByEmail($_POST['email']);

                if ($user) {
                    $errors['email'] = "Cette adresse mail est déjà prise";
                }
            }

            //Mot de passe
            if (empty($_POST['password']) || $_POST['password'] !== $_POST['password_confirm']) {
                $errors['password'] = "Vous devez rentrer un mot de passe valide et confirmé";
                var_dump($errors);
            }

            //Condition avant de passer à l'inscription (si le []errors est vide)
            if (empty($errors)) {

                // Génération d’un token sécurisé
                $token = bin2hex(random_bytes(32));
            
                $this->userModel->createUser([
                    'username' => $_POST['username'],
                    'email' => $_POST['email'],
                    'password' => $_POST['password'],
                    'confirmation_token' => $token
                ]);
            
                
            }
        }
    }
}