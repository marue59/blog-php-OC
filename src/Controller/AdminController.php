<?php

namespace Portfolio\Controller;

use Portfolio\Model\PostManager;
use Portfolio\Model\UserManager;
use Portfolio\Model\CommentManager;
use Portfolio\Controller\AbstractController;

class AdminController extends AbstractController
{
    private $userManager;
    private $postManager;
    private $commentManager;

    public function __construct()
    {
        $this->userManager = new UserManager();
        $this->postManager = new PostManager();
        $this->commentManager = new CommentManager();

        parent::__construct();
    }

    public function admin()
    {
        echo $this->twig->render('admin/index.html.twig');
    }

    /**
     * Voir tout les user en attente de validation
     *
     * @return void
     */
    public function showAllUser()
    {
        $users = $this->userManager->findAll(3);

        $message = null;

        if (isset($_SESSION['flash_message'])) {
            $message = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
        }

        echo $this->twig->render('admin/showAllUser.html.twig', 
                                ['users'=> $users, 'message'=> $message]);
    }

    /**
     * Voir le user selectionné grace a l'id et lui changer le statut
     *
     * @return void
     */
    public function validateStatus($parameter)
    {
        $this->userManager->updateStatus($parameter['id']);

        $_SESSION['flash_message'] = "Le compte a été validé";

        header('Location:/admin/show');
    }

    
    /**
     * Voir tout les articles en attente de validation
     *
     * @return void
     */
    public function showAllArticle()
    {
        $posts = $this->postManager->findAllArticle(2);

        $messageArticle = null;

        if (isset($_SESSION['flash_message'])) {
            $messageArticle = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
        }
        echo $this->twig->render('admin/showAllArticle.html.twig', 
                                ['posts'=> $posts, 'message'=> $messageArticle]);
    }


    /**
     * Voir l'article selectionné grace a l'id et lui changer le statut      
     *
     * @return void
     */
    public function validateArticleStatus($parameter)
    {
        $this->postManager->updateStatusArticle($parameter['id']);

        $_SESSION['flash_message'] = "L'article a été validé";

        header('Location:/admin/articles');
    }


    /**
     * Voir tout les comments en attente de validation 
     *
     * @return void
     */
    public function showAllComment()
    {
        $comments = $this->commentManager->findAll(2);

        $message = null;

        if (isset($_SESSION['flash_message'])) {
            $message = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
        }

        echo $this->twig->render('admin/showAllComment.html.twig', 
                                ['comments'=> $comments, 'message'=> $message]);
    }

    // 
    /**
     * Voir le comment selectionné grace a l'id et lui changer le statut
     * 
     * @return void
     */
    public function validateStatusComment($parameter)
    {
        $this->commentManager->updateCommentStatus($parameter['id']);

        $_SESSION['flash_message'] = "Le commentaire a été validé";

        header('Location:/admin/comments');
    }
}
