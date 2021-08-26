<?php

namespace Portfolio\Controller;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;



abstract class AbstractController
{
    protected $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(APP_VIEW_PATH);
        $this->twig = new Environment(
            $loader,
            [
                'cache' => false, __DIR__ . '/../var/cache',
                'debug' => true,
            ]
        );
        // utilisation de methode globale de twig 
        $this->twig->addGlobal('session',$_SESSION);
        $this->twig->addExtension(new DebugExtension());

       
    }
//verifier si le user est conencté
    public function isLogged()
    {
        if(!isset($_SESSION['email'])){
            header('Location:/connexion');
        } 

    }
}