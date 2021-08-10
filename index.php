<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';

require 'config/config.php';



//Le routing
$router = new AltoRouter();

// map homepage
$router->map('GET', '/', 'FrontController#home');
$router->map('GET', '/whoIam', 'FrontController#whoIam');


// security
$router->map('GET|POST', '/login', 'FrontController#login');
//connexion
$router->map('GET|POST', '/auth', 'SecurityController#auth');

//account
$router->map('GET', '/mon-compte', 'AccountController#account');

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