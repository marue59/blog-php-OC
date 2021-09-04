<?php

namespace Portfolio\Model;
use \PDO;
use DateTime;
use Portfolio\Entity\Post;

class PostManager extends Database 
{
    private $table = "post";
    
    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct();
    }

    //create user
    public function create($post)
    {
        
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table 
            (title, text, picture, author, status, date_creation) 
            VALUES (:title, :text, :picture,:author, :status, :date_creation)");
        $statement->bindValue('title', $post['title'], \PDO::PARAM_STR);
        $statement->bindValue('text', $post['text'], \PDO::PARAM_STR);
        $statement->bindValue('picture', $post['picture'], \PDO::PARAM_STR);
        $statement->bindValue('author', $post['author'], \PDO::PARAM_INT);
        $statement->bindValue('status', $post['status'], \PDO::PARAM_INT);
        $statement->bindValue('date_creation', date("Y-m-d H:i:s"));

        $statement->execute();
    }

    // Récuperation du post via le titre
    public function getPostByTitle($title)
    {
         // prepared request
         $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE title=:title");
         $statement->bindValue('title', $title, \PDO::PARAM_STR);
         $statement->execute();
 
         $data = $statement->fetch();
         if ($data){
             $post = new Post();
             $post->hydrate($data);
             
             return $post;
         }
             return false;
    }   

    // Récuperation des posts validé
    public function getValidatePost() 
    {

        $statement = $this->pdo->prepare('select * from post where status = 1');
        $statement->execute();
        $data = $statement->fetchAll();

        if ($data){
            $posts = [];
            foreach ($data as $entity) {
                $post = new Post();
                $post->hydrate($entity);
                $posts[] = $post;            
            }
        
            return $posts;
        }

        return false;
    }    

    // Récuperation un post grace a l'id
    public function findOnePost($id) 
    {

         // prepared request
         $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE id=:id");
         $statement->bindValue('id', $id, \PDO::PARAM_INT);

         $statement->execute();
 
         $data = $statement->fetch();

         if ($data){
             $post = new Post();
             $post->hydrate($data);
             
             return $post;
         }
             return false;
    }   
}