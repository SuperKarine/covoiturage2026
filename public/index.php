<?php

ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) ? '1' : '0');
ini_set('session.cookie_httponly', '1');

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require __DIR__ . '/../vendor/autoload.php';


use Router\Router;
use Source\App;
use Controllers\HomeController;
use Controllers\AuthController;
use Controllers\TrajetController;
use Controllers\ReservationController;
use Controllers\DemandeChauffeurController;



$router = new Router();

// Routes existantes 
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




$app = new App($router, $_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
$app->run();