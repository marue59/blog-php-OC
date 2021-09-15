<?php

namespace Portfolio\Controller;

use Portfolio\Model\UserManager;
use Portfolio\Model\PostManager;
use Portfolio\Controller\AbstractController;


class AdminController extends AbstractController {

    private $userManager;
    private $postManager;

    public function __construct() {
        $this->userManager = new UserManager();
        $this->postManager = new PostManager();

        parent::__construct();
    }

    public function admin()
    {
        
    echo $this->twig->render('admin/index.html.twig');

    }

    //voir tout les user en attente de validation
    public function showAllUser()
    {
        $users = $this->userManager->findAll(3);

        $message = null;
        if(isset($_SESSION['flash_message'])) {
            $message = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
    
        }

        echo $this->twig->render('admin/showAllUser.html.twig', ['users'=> $users, 'message'=> $message]);
    }

    // voir le user selectionné grace a l'id et lui changer le statut
    public function validateStatus($parameter)
    {
        $this->userManager->updateStatus($parameter['id']);
        
        $_SESSION['flash_message'] = "Le compte a été validé";
        
        header('Location:/admin/show');
    }

    // voir tout les articles en attente de validation
    public function showAllArticle()
    {
        $posts = $this->postManager->findAllArticle(2);
        
        $messageArticle = null;

        if(isset($_SESSION['flash_message'])) {
            $messageArticle = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
    
        }
        echo $this->twig->render('admin/showAllArticle.html.twig', ['posts'=> $posts, 'message'=> $messageArticle]);
    }

    // voir l'article selectionné grace a l'id et lui changer le statut
    public function validateArticleStatus($parameter)
    {
        $this->postManager->updateStatusArticle($parameter['id']);
        
        $_SESSION['flash_message'] = "L'article a été validé";
        
        header('Location:/admin/articles');
    }
}

?>