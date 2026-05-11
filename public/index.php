<?php

use Router\Router;
use Source\App;
use Controllers\HomeController;
use Controllers\AuthController;

require __DIR__ . '/../vendor/autoload.php';

$router = new Router();

$router->register('/', [HomeController::class, 'index']);
$router->register('/home', [HomeController::class, 'index']);
$router->register('/auth', [AuthController::class, 'register']);

$app = new App($router, $_SERVER['REQUEST_URI']);
$app->run();