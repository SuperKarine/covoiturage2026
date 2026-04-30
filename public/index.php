<?php

require __DIR__ . '/../vendor/autoload.php';

use Router\Router;

$router = new Router();

// J' enregistre toutes les routes
$router->register('/home', ['Controllers\HomeController', 'index']);
$router->register('/auth', ['Controllers\AuthController', 'register']);


echo $router->resolve($_SERVER['REQUEST_URI']);