<?php

namespace Portfolio\Controller;

use Portfolio\Controller\AbstractController;
use Portfolio\Model\LoginManager;

class SecurityController extends AbstractController {

    private $loginManager;

    public function __construct() {
        $this->loginManager = new LoginManager();
    }

    public function create() {

        $users = $this->loginManager->getUsers();

        \var_dump($users); die;

        echo $this->twig->render('security/create.html.twig');
    }
 
};
?>