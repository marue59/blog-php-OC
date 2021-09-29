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
    public function create() 
    {   
        $errors = [
            "errorChamps" => ""
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    { 
            if (empty($_POST['title']) || empty($_POST['text'])) 
            {
                $errors["errorsChamps"] = "Un des champs n'est pas correctement remplit";
            } else {
            
            $comment = [
                
                'title' => $_POST['title'],
                'text' => $_POST['text'],
                'date_creation' => $_POST['date_creation'],
                'author' => $_SESSION['id'],
                'status' => 2,
            ];
            $this->commentManager->create($comment);

                }
    }
    
    echo $this->twig->render('comment/create-form.html.twig',["error"=> $errors]);  
    }

    // Afficher tout les comments grace a la methode findAll
    public function findAllComment()
    {
        $comments = $this->commentManager->findAll();

        echo $this->twig->render('comment/showAllComment.html.twig', ['comments' => $comments]);
    
    }
}
