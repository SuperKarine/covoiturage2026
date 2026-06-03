<?php

ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) ? '1' : '0');
ini_set('session.cookie_httponly', '1');

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// ...

require __DIR__ . '/../vendor/autoload.php';


use Router\Router;
use Source\App;
use Controllers\HomeController;
use Controllers\AuthController;


$router = new Router();

$router->register('/', [HomeController::class, 'index']);
$router->register('/home', [HomeController::class, 'index']);
$router->register('/auth', [AuthController::class, 'register']);
$router->register('/auth/register', [AuthController::class, 'register']);
$router->register('/auth/confirm', [AuthController::class, 'confirm']);
$router->register('/auth/email-sent', [AuthController::class, 'emailSent']);
$router->register('/auth/login', [AuthController::class, 'login']);     
$router->register('/auth/logout', [AuthController::class, 'logout']);    



$app = new App($router, $_SERVER['REQUEST_URI']);
$app->run();