<?php

namespace Portfolio\Controller;

use Entity\Post;
use Portfolio\Model\PostManager;
use Portfolio\Controller\AbstractController;
use Model\Database;

class PostController extends AbstractController {
    

    private $postManager;

    
    public function __construct() {
        $this->postManager = new PostManager();
        parent::__construct();
    }

    public function create() 
    {   
        $errors = [
            "errorChamps" => "",
            "errorName" => ""
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             
            if (empty($_POST['title']) || empty($_POST['text']) || empty($_POST['picture'])) {
                $errors["errorsChamps"] = "L'ensemble des champs doit etre remplit";
            } else {
                $title = $_POST['title'];
                $text = $_POST['text'];
                $picture = $_POST['picture'];
                
                // j'utilise la methode postbytitle pour verifier que mon titre n'existe pas deja.
                $post = $this->postManager->getPostByTitle($title);

                if ($post){
                    $errors["errorName"] = "Ce post existe déja";

                } else {

                $post = [
                    'title' => $_POST['title'],
                    'text' => $_POST['text'],
                    'picture' => $_POST['picture'],
                    'author' => $_SESSION['id'],
                    'status' => 2,
                ]; 
                
                $this->postManager->create($post);

                }

        
        }
       } 
       echo $this->twig->render('post/create.html.twig',["error"=> $errors]);  
    }


    public function post($id)
    {       
        $post = $this->postManager->findOnePost($id);
        echo $this->twig->render('post/show.html.twig',["id"=> $id]);
    }
    
}
?>