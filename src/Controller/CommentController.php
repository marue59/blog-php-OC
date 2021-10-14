<?php
    
namespace Portfolio\Controller;

use Entity\Comment;
use Model\Database;
use Portfolio\Model\CommentManager;
use Portfolio\Controller\AbstractController;


class CommentController extends AbstractController {
    
    private $commentManager;

    public function __construct() {
        $this->commentManager = new CommentManager();

        parent::__construct();
    }
    

     // creation de comment
    public function create($id) 
    {   
        $errors = [
            "errorChamps" => ""
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    { 
            if ( empty($_POST['text'])) 
            {
                $errors["errorsChamps"] = "Un des champs n'est pas correctement remplit";
            } else {
            
            $comment = [
                'id' => trim(htmlspecialchars($id['id'])),
                'text' => trim(htmlspecialchars($_POST['text'])),
                'author' => trim(htmlspecialchars($_SESSION['id'])),
            ];
            $this->commentManager->create($comment);

            }
    }
    //fonction sprint formate en string 
    // %s attente d'une variable
       header(sprintf('Location:/post/%s', $id['id']));
    }

    // Afficher tout les comments grace a la methode findAll
    public function findAllComment()
    {
        $comments = $this->commentManager->findAll(1);

        echo $this->twig->render('comment/showAllComment.html.twig', ['comments' => $comments]);
    }

    public function delete($parameter)
    {       
        $comment = $this->commentManager->findOneComment($parameter['id']);
        //var_dump($comment);die;
        //si l'auteur n'est pas la perso authentifié alors
        if ($comment->getAuthor() != $_SESSION['id'] || $_SESSION['status'== '1'])
        {
            echo "Vous n'etes pas autorisé";
            exit();
        }

        $comment = $this->commentManager->delete($parameter['id']);
        
        header('Location:/post/'. $id . '/all-comment');
    }
}
