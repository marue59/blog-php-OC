<?php
    
namespace Portfolio\Controller;

use Portfolio\Controller\AbstractController;
use Portfolio\Model\database;

class AccountController extends AbstractController {

    public function account() {
        echo $this->twig->render('account/index.html.twig');
    }

}

?>