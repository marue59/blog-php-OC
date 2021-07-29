<?php

namespace Portfolio\Controller;

use Portfolio\Controller\AbstractController;

class FrontController extends AbstractController {

    public function home() {
        echo $this->twig->render('home.html.twig');

    }

}

?>