<?php

ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) ? '1' : '0');
ini_set('session.cookie_httponly', '1');

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require __DIR__ . '/../vendor/autoload.php';

// Chargement du .env
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#')) continue;
        if (!str_contains($line, '=')) continue;
        [$key, $value] = explode('=', $line, 2);
        putenv(trim($key) . '=' . trim($value));
    }
}


use Router\Router;
use Source\App;
use Controllers\HomeController;
use Controllers\AuthController;
use Controllers\TrajetController;
use Controllers\ReservationController;
use Controllers\DemandeChauffeurController;
use Controllers\DashboardChauffeurController;
use Controllers\DashboardPassagerController;
use Controllers\DashboardAdminController;
use Controllers\MessageController;
use Controllers\NoteController;





$router = new Router();

// Routes Home et Auth 
$router->register('GET', '/', [HomeController::class, 'index']);
$router->register('GET', '/home', [HomeController::class, 'index']);
$router->register('GET', '/auth', [AuthController::class, 'register']);
$router->register('GET', '/auth/register', [AuthController::class, 'register']);
$router->register('POST', '/auth/register', [AuthController::class, 'register']);
$router->register('GET', '/auth/confirm', [AuthController::class, 'confirm']);
$router->register('GET', '/auth/email-sent', [AuthController::class, 'emailSent']);
$router->register('GET', '/auth/login', [AuthController::class, 'login']);
$router->register('POST', '/auth/login', [AuthController::class, 'login']);
$router->register('GET', '/auth/logout', [AuthController::class, 'logout']);

// Nouvelles routes API REST pour les trajets
$router->register('GET', '/api/trajets', [TrajetController::class, 'search']);
$router->register('GET', '/api/trajets/{id}', [TrajetController::class, 'show']);
$router->register('POST', '/api/trajets', [TrajetController::class, 'create']);
$router->register('PUT', '/api/trajets/{id}', [TrajetController::class, 'update']);
$router->register('DELETE', '/api/trajets/{id}', [TrajetController::class, 'delete']);

// Routes API REST pour les réservations
$router->register('POST', '/api/reservations', [ReservationController::class, 'create']);
$router->register('GET', '/api/reservations/{id}', [ReservationController::class, 'show']);
$router->register('POST', '/api/reservations/{id}/confirmer', [ReservationController::class, 'confirmer']);
$router->register('POST', '/api/reservations/{id}/annuler', [ReservationController::class, 'annuler']);
$router->register('POST', '/api/reservations/{id}/refuser', [ReservationController::class, 'refuser']);

// Route recherche trajets
$router->register('GET', '/trajets', [TrajetController::class, 'index']);

//Route pour Demande chauffeur
$router->register('POST', '/api/demandes-chauffeur', [DemandeChauffeurController::class, 'create']);
$router->register('GET', '/api/demandes-chauffeur', [DemandeChauffeurController::class, 'index']);
$router->register('GET', '/api/demandes-chauffeur/{id}', [DemandeChauffeurController::class, 'show']);
$router->register('POST', '/api/demandes-chauffeur/{id}/accepter', [DemandeChauffeurController::class, 'accepter']);
$router->register('POST', '/api/demandes-chauffeur/{id}/refuser', [DemandeChauffeurController::class, 'refuser']);

//Route pour Dashboard Chauffeur

$router->register('GET', '/chauffeur/dashboard', [DashboardChauffeurController::class, 'index']);
$router->register('GET', '/chauffeur/trajets/ajouter', [DashboardChauffeurController::class, 'ajouterTrajetForm']);

// Route pour Dashboard Passager
$router->register('GET', '/passager/dashboard', [DashboardPassagerController::class, 'index']);

//Route pour Dashboard Admin
$router->register('GET', '/admin/dashboard', [DashboardAdminController::class, 'index']);

//Routes pour les messages de MongoDB
$router->register('POST', '/api/messages', [MessageController::class, 'create']);
$router->register('GET', '/api/messages/{id}', [MessageController::class, 'show']);
$router->register('GET', '/api/messages/entre/{id1}/{id2}', [MessageController::class, 'entreUtilisateurs']);
$router->register('GET', '/api/messages/recus/{id}', [MessageController::class, 'recus']);
$router->register('PUT', '/api/messages/{id}/lu', [MessageController::class, 'marquerCommeLu']);
$router->register('DELETE', '/api/messages/{id}', [MessageController::class, 'delete']);

// Route pour notation chauffeurs
$router->register('POST', '/api/notes', [NoteController::class, 'create']);



$app = new App($router, $_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
$app->run();