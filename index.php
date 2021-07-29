<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

require 'vendor/autoload.php';

$uri = $_SERVER['REQUEST_URI'];
//Le routing
$router = new AltoRouter();

// map homepage
$router->map('GET', '/', 'FrontController#home');
// security
$router->map('GET|POST', '/inscription', 'SecurityController#create');
$router->map('GET|POST', '/connexion', 'SecurityController#login');

//account
$router->map('GET', '/mon-compte', 'AccountController#account');

//whoIam
$router->map('GET', '/whoIam', 'FrontController#whoIam');

$match = $router->match();

if (stripos($match['target'], '#') !== false) {
    list($controller, $method) = explode('#', $match['target'], 2);

    $cname = "Portfolio\Controller\\" . $controller;
    $controllerName = new $cname;

    if ($match['params']) {
        call_user_func_array(array($controllerName, $method), array($match['params']));
    } else {

    call_user_func(array($controllerName, $method));

    }
} else {
    header('Location: /');
}

 ?>
<!-- Affichage -->
<?php
       try
       {
       $bdd = new PDO('mysql:dbname:Portfolio;host=localhost:8000', 'root', '08111987');
       }    
       catch(Exception $e)
       {
               die('Erreur : '.$e->getMessage());
       }
       
           $req = $bdd->query('SELECT id, username, email');
       
           return $req;
           
   

?>
