<?php

namespace Portfolio\Controller;

use Portfolio\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class FrontController extends AbstractController {

 
    public function home() {
        echo $this->twig->render('home.html.twig');

    }

    
    public function whoIam()
    {
        echo $this->twig->render('whoIam.html.twig');
    }

    public function project()
    {
        echo $this->twig->render('project.html.twig');
    }
}

?>