<?php
    
namespace Portfolio\Controller;

use Portfolio\Model\database;
use Portfolio\Model\AccountManager;
use Portfolio\Controller\AbstractController;
use Portfolio\Entity\User;

class AccountController extends AbstractController {
    
   
    public function account() {

        $this ->isLogged();
        echo $this->twig->render('account/index.html.twig');

    }
}

?>