<?php

namespace Portfolio\Controller;

use Portfolio\Entity\User;
use Portfolio\Model\database;
use Portfolio\Model\PostManager;
use Portfolio\Model\AccountManager;
use Portfolio\Controller\AbstractController;

/**
 *  utilisation de la methode de l'abstract isLogged
 *
 * @return void
 */
class AccountController extends AbstractController
{
    private $postManager;

    public function __construct()
    {
        $this->postManager = new PostManager();
        parent::__construct();
    }

    public function account()
    {
        $this ->isLogged();

        //defini une variable
        $author = $_SESSION["id"];

        $posts = $this->postManager->getAllByAuthorId($author);

        echo $this->twig->render('account/index.html.twig', ['posts'=>$posts]);
    }
}
