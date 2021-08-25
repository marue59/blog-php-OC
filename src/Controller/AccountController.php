<?php
    
namespace Portfolio\Controller;

use Portfolio\Controller\AbstractController;
use Portfolio\Model\database;

class AccountController extends AbstractController {

    public function account() {

        if (!isset ($_SESSION ['email'])){
            header('Location:/mon-compte');
        }
        echo $this->twig->render('account/index.html.twig');
    }

}

?>