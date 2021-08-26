<?php

namespace Portfolio\Controller;

use Portfolio\Controller\AbstractController;
use Portfolio\Model\database;


class FrontController extends AbstractController {

 
    public function home() {
        echo $this->twig->render('layout.html.twig');

    }
    
    public function login()
    {
        echo $this->twig->render('security/login.html.twig');
    }

}

?>