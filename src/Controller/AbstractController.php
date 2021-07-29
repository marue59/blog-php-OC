<?php

namespace Portfolio\Controller;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

/**
 *
 */
abstract class AbstractController
{
    protected $twig;


    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../View');
        $this->twig = new Environment(
            $loader,
            [
                'cache' =>  __DIR__ . '/../var/cache',
                'debug' => true,
            ]
        );
        $this->twig->addExtension(new DebugExtension());

       
    }
}