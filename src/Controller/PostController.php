<?php

namespace Portfolio\Controller;

use Entity\Post;
use Portfolio\Model\PostManager;
use Portfolio\Controller\AbstractController;
use Model\Database;

class PostController extends AbstractController {
    
    public $errors = [
        "errorChamps" => "",
        "errorName" => ""
    ];

    private $postManager;

    private $post;
    
    public function __construct() {
        $this->postManager = new PostManager();
        parent::__construct();
    }

    public function create() 
    {   
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (empty($_POST['title']) || empty($_POST['text']) || empty($_POST['picture'])) {
                $errors["errorsChamps"] = "L'ensemble des champs doit etre remplit";
            } else {
                $title = $_POST['title'];
                $text = $_POST['text'];
                $picture = $_POST['picture'];

                $postManager = new PostManager();
                $post = $postManager->create($post);

                if ($post){
                    $errors["errorName"] = "Ce post existe déja";

                } else {
                $post = [
                    'title' => $_POST['title'],
                    'text' => $_POST['text'],
                    'picture' => $_POST['picture'],
                ];
                }
            
        }
       } 
       echo $this->twig->render('post/create.html.twig',["error"=> $errors]);  
    }
}
?>