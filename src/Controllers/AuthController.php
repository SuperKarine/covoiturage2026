<?php

namespace Controllers;

use Models\UtilisateursModel;
use Services\Mailer;

class AuthController
{
    protected UtilisateursModel $userModel;

    public function __construct()
    {
        $this->userModel = new UtilisateursModel();
    }

    
    //  REGISTER / Inscription
    
    public function register(): string
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!$this->verifyCsrf()) {
                $errors['csrf'] = "Requête invalide, veuillez réessayer.";
            } else {
                $errors = $this->gestionRegister();
                if (empty($errors)) {
                    header('Location: /auth/email-sent');
                    exit;
                }
            }
        }

        $this->generateCsrfToken();

        ob_start();
        require __DIR__ . '/../../views/auth/register.php';
        $content = ob_get_clean();

        ob_start();
        require __DIR__ . '/../../views/layouts/main.php';
        return ob_get_clean();
    }

    public function confirm(): void
    {
        $token   = $_GET['token'] ?? '';
        $success = $token ? $this->userModel->confirmUser($token) : false;
        header('Location: ' . ($success ? '/auth/login' : '/auth/register'));
        exit;
    }

    public function emailSent(): string
    {
        ob_start();
        require __DIR__ . '/../../views/auth/email-sent.php';
        $content = ob_get_clean();

        ob_start();
        require __DIR__ . '/../../views/layouts/main.php';
        return ob_get_clean();
    }

    
    //  LOGIN
    
    public function login(): string
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!$this->verifyCsrf()) {
                $errors['csrf'] = "Requête invalide, veuillez réessayer.";
            } else {
                $errors = $this->gestionLogin();
            }
        }

        $this->generateCsrfToken();

        ob_start();
        require __DIR__ . '/../../views/auth/login.php';
        $content = ob_get_clean();

        ob_start();
        require __DIR__ . '/../../views/layouts/main.php';
        return ob_get_clean();
    }

    private function gestionLogin(): array  
    {
        $errors = [];

        $email    = trim($_POST['mail']    ?? '');
        $password = $_POST['password'] ?? '';

        // Champs vides 
        if (empty($email) || empty($password)) {
            $errors['login'] = "Veuillez remplir tous les champs.";
            return $errors;
        }

        //  Recherche en base 
        $user = $this->userModel->findByEmail($email);

        if (!$user) {
            $errors['login'] = "Identifiants incorrects.";
            return $errors;
        }

        // Est-ce que le compte est confirmé 
        if (empty($user['is_confirmed'])) {
            $errors['login'] = "Confirmez votre email avant de vous connecter.";
            return $errors;
        }

        //  Vérification mot de passe 
        if (!password_verify($password, $user['password'])) {
            $errors['login'] = "Identifiants incorrects.";
            return $errors;
        }

        // Connexion réussie 
        
        session_regenerate_id(true);

        $_SESSION['user_id']   = $user['id_utilisateurs'];
        $_SESSION['username']  = $user['username'];
        $_SESSION['role_id']   = $user['id_role'];
        $_SESSION['role_name'] = $user['name'];
        
        // Renouvellement du token CSRF après login
        unset($_SESSION['csrf_token']);
        $this->generateCsrfToken();

        $this->redirectByRole($user['role_id']);

        return $errors;

    }   
    
    //  LOGOUT
    
    public function logout(): void
    {
        session_unset();
        session_destroy();

        header('Location: /auth/login');
        exit;
    }
    
    //  REDIRECTION PAR RÔLE
    
    private function redirectByRole(int $roleId): void
    {
        $routes = [
            1 => '/admin/dashboard',
            2 => '/passager/dashboard',
            3 => '/chauffeur/dashboard',
        ];

        header('Location: ' . ($routes[$roleId] ?? '/home'));
        exit;
    }

    
    //  CSRF
    

    private function generateCsrfToken(): void
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }

    private function verifyCsrf(): bool
    {
        $tokenRecu = $_POST['csrf_token'] ?? '';

        return !empty($_SESSION['csrf_token'])
            && hash_equals($_SESSION['csrf_token'], $tokenRecu);
    }

    
    //  REGISTER 
    
    private function gestionRegister(): array
    {
        $errors = [];

        if (!empty($_POST)) {

            if (empty($_POST['username']) || !preg_match("#^[a-zA-Z0-9_]+$#", $_POST['username'])) {
                $errors['username'] = "Votre identifiant n'est pas valide";
            } else {
                if ($this->userModel->findByUsername($_POST['username'])) {
                    $errors['username'] = "Cet identifiant est déjà pris";
                }
            }

            if (empty($_POST['mail']) || !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
                $errors['mail'] = "Votre email n'est pas valide";
            } else {
                if ($this->userModel->findByEmail($_POST['mail'])) {
                    $errors['mail'] = "Cette adresse mail est déjà prise";
                }
            }

            if (empty($_POST['password'])) {
                $errors['password'] = "Le mot de passe est obligatoire";
            } elseif (strlen($_POST['password']) < 8) {
                $errors['password'] = "Le mot de passe doit faire au moins 8 caractères";
            } elseif ($_POST['password'] !== ($_POST['password_confirm'] ?? '')) {
                $errors['password'] = "Les mots de passe ne correspondent pas";
            }

            if (empty($errors)) {

                $token = bin2hex(random_bytes(32));

                $this->userModel->createUser([
                    'username'           => $_POST['username'],
                    'email'              => $_POST['mail'],
                    'password'           => password_hash($_POST['password'], PASSWORD_BCRYPT),
                    'confirmation_token' => $token
                ]);

                $mailer = new Mailer();
                $mailer->sendConfirmation($_POST['mail'], $_POST['username'], $token);
            }
        }

        return $errors;
    }

}   