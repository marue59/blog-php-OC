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
        // Utilisation de methode globale de twig
        $this->twig->addGlobal('session', $_SESSION);
        $this->twig->addExtension(new DebugExtension());
    }
    
    /**
     *  Verifier si le user est connecté
     *
     * @return void
     */
    public function isLogged()
    {
        if (!isset($_SESSION['email'])) {
            header('Location:/connexion');
        }
    }

    /**
     *  Génération du token
     *
     * @return void
     */
    public function generateToken()
    { 
        if (!isset($_SESSION['token'])) {
        $token = md5(uniqid(rand(), true));

        // On le stock en session
        $_SESSION['token'] = $token;
        }
    }
}
