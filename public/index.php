<?php

require __DIR__ . '/../vendor/autoload.php';

use Router\Router;

$router = new Router();

$router->register('/home', ['Controllers\HomeController', 'index']);

echo $router->resolve('/home');
