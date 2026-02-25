
<?php

echo "Je suis sur covoiturage2026";

echo "<br>";

error_reporting(E_ALL);
ini_set('display_errors', 1);




require __DIR__ . '/../vendor/autoload.php';

use Exceptions\RouteNotFoundException;
use Exceptions\UserException;
use Router\Login;
use MongoDB\Client;
//use Router\Payment;
use Router\User;
use Router\Router;


$client = new Client("mongodb://localhost:27017");
$db = $client->covoiturage;

echo "Connexion OK";

echo "<br>";



//$payment = new Payment();

//var_dump($payment);



$user = new User('machine', 'password');
$login = new Login($user);

try {
    $login->login();
} catch (UserException $e) {
    echo $e->getMessage() . ' dans le fichier ' . $e->getFile();
} 

echo '<pre>';

$router = new Router();

$router->register('/', ['Controllers\HomeController', 'index']);

//$router->register('/', function () {
 //   return 'HomePage';

//});

//$router->register('/contact', function () {
 //   return 'ContactPage';

//});





try {
    echo $router->resolve($_SERVER['REQUEST_URI']);
} catch (RouteNotFoundException $e) {
    echo $e->getMessage();
}