<?php
require '../vendor/autoload.php';

//Le routing : 
$page = 'home';
if (isset($_GET['p'])) {

    $page = $_GET['p'];
   
}

// Rendu du template
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader, [
   'cache' =>false,  // __DIR__ . '/tmp',
]);
 if ($page === 'home') {
     echo $twig->render ('home.html.twig',['page' => $page]);
 }

?>

