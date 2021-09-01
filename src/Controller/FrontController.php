<?php

namespace Portfolio\Controller;

use Portfolio\Model\PostManager;
use Portfolio\Controller\AbstractController;


class FrontController extends AbstractController {

    private $postManager;

    
    public function __construct() {
        $this->postManager = new PostManager();
        parent::__construct();
    }
 
    public function home() {

        $posts = $this->postManager->getValidatePost();

        echo $this->twig->render('layout.html.twig', ['posts' => $posts]);

    }
    
    public function login()
    {
        echo $this->twig->render('security/login.html.twig');
    }

    public function project()
    {
        echo $this->twig->render('project/showAllProjects.html.twig');
    }
}

?>