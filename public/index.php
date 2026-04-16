
<?php

echo "Je suis sur covoiturage2026";

echo "<br>";

error_reporting(E_ALL);
ini_set('display_errors', 1);




require __DIR__ . '/../vendor/autoload.php';


use MongoDB\Client;
use Router\Router;
use Source\App;


$client = new Client("mongodb://localhost:27017");
$db = $client->covoiturage;

echo "Connexion OK";

echo "<br>";






define('BASE_VIEW_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);

$router = new Router();

$router->register('/', ['Controllers\HomeController', 'index']);

(new App($router, $_SERVER['REQUEST_URI']))->run();