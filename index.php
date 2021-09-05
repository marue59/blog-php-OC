<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
//Si tu n’arrives pas à charger une classe, 
//voici la fonction que tu peux exécuter pour tenter de la trouver”
spl_autoload_register();
 

require 'vendor/autoload.php';
require 'config/config.php';



//Le routing
$router = new AltoRouter();

// map homepage
$router->map('GET', '/', 'FrontController#home');

// security
$router->map('GET|POST', '/inscription', 'SecurityController#create');
$router->map('GET|POST', '/connexion', 'SecurityController#login');
$router->map('GET|POST', '/deconnexion', 'SecurityController#logout');

//admin
$router->map('GET', '/admin', 'SecurityController#login');
$router->map('GET', '/admin/show', 'SecurityController#showUser');


//account
$router->map('GET', '/mon-compte', 'AccountController#account');

//post
$router->map('GET|POST', '/post/[i:id]', 'PostController#post');
$router->map('GET|POST', '/post', 'PostController#create');
$router->map('GET', '/les-posts', 'PostController#findAll');

//project
$router->map('GET', '/projet', 'FrontController#project');



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