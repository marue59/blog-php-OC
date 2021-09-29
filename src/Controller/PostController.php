<?php

namespace Portfolio\Controller;

use finfo;
use Entity\Post;
use Model\Database;
use Portfolio\Model\PostManager;
use Portfolio\Controller\AbstractController;

class PostController extends AbstractController {
    

    private $postManager;

    
    public function __construct() {
        $this->postManager = new PostManager();
        parent::__construct();
    }

    // creation de post
    public function create() 
    {   
        $errors = [
            "errorChamps" => "",
            "errorName" => ""
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        { 
            if (empty($_POST['title']) || empty($_POST['text']) || empty($_FILES['picture'])) 
            {
                $errors["errorsChamps"] = "Un des champs n'est pas correctement remplit";
            } else {
                
                $title = $_POST['title'];
                $text = $_POST['text'];
                $picture = $this->upload($_FILES);
                
                // Utilisation de la methode postByTitle pour verifier que mon titre n'existe pas deja.
                $post = $this->postManager->getPostByTitle($title);

                if ($post){
                    $errors["errorName"] = "Ce post existe déja";

                } else {

                $post = [
                    'title' => $title,
                    'text' => $text,
                    'picture' => $picture,
                    'author' => $_SESSION['id'],
                    'status' => 2,
                ]; 
                
                $this->postManager->create($post);

                }
            }
       } 
       echo $this->twig->render('post/create.html.twig',["error"=> $errors]);  
    }

    // Afficher un post grace a l'id
    public function post($parameter)
    
    {       
        $post = $this->postManager->findOnePost($parameter['id']);

        echo $this->twig->render('post/show.html.twig',["post" => $post]);
    }
    
    // Afficher tout les post grace a la methode getValidatePost
    public function findAll()
    {
        $posts = $this->postManager->getValidatePost();

        echo $this->twig->render('project/showAllPosts.html.twig', ['posts' => $posts]);
    }

    // Upload d'image adaptation meth PHP
    public function upload($files)
    {
        try {
   
            // Undefined | Multiple Files | $_FILES Corruption Attack
            // If this request falls under any of them, treat it invalid.
            if (
                !isset($files['picture']['error']) ||
                is_array($files['picture']['error'])
            ) {
                throw new \RuntimeException('Paramètre invalide');
            }
        
            // Check $_FILES['upfile']['error'] value.
            switch ($files['picture']['error']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    throw new \RuntimeException('Fichier non trouvé');
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    throw new \RuntimeException('La taille de l\image ne correspond pas');
                default:
                    throw new \RuntimeException('Erreur inconnue');
            }
        
            // Verification de la taille
            if ($files['picture']['size'] > 1000000) {
                throw new \RuntimeException('La taille du fichier n\est pas pris en charge');
            }
        
            // Verification du format
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            if (false === $ext = array_search(
                $finfo->file($files['picture']['tmp_name']),
                array(
                    'jpg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                ),
                true
            )) {
                throw new \RuntimeException('Format invalide');
            }
        
           
            // Move dans le dossier defini
            $pictureName = sha1_file($files['picture']['tmp_name']);

            if (!move_uploaded_file(
                $files['picture']['tmp_name'],
                sprintf(__DIR__.'/../../public/images/uploads/%s.%s',
                    $pictureName,
                    $ext
                )
            )) {
                throw new \RuntimeException('Failed to move uploaded file.');
            }
        
            return $pictureName . "." . $ext;
        
        } catch (\RuntimeException $e) {
        
            echo $e->getMessage();
        
        }
    }

    // Modifier un post grace a l'id
    public function edit($id)
    {   
        $errors = ["errorChamps" => ""];
        $post = $this->postManager->findOnePost($id['id']);

        //si l'auteur n'est pas la perso authentifié alors
        if ($post->getAuthor() != $_SESSION['id'])
        {
            echo "Vous n'etes pas autorisé";
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
            {
            if (empty($_POST['title']) || empty($_POST['text']) || empty($_FILES['picture'])) 
            {
                $errors["errorsChamps"] = "Un des champs n'est pas correctement rempli";
            } else {
                
                $title = $_POST['title'];
                $text = $_POST['text'];
                $picture = $this->upload($_FILES);
                
                $this->postManager->edit($id, $title, $text, $picture);
                               
            }      
        } 
        echo $this->twig->render('post/edit.html.twig',["error"=> $errors, "post"=>$post]);
    }
        
      // Supprimer un post grace a l'id
    public function delete($parameter)
    {       
        $post = $this->postManager->findOnePost($parameter['id']);
        
        //si l'auteur n'est pas la perso authentifié alors
        if ($post->getAuthor() != $_SESSION['id'] || $_SESSION['status'->$status(1)])
        {
            echo "Vous n'etes pas autorisé";
            exit();
        }

        $post = $this->postManager->delete($parameter['id']);
        
        header('Location:/mon-compte');
    }
}
