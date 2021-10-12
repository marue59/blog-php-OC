<?php

namespace Portfolio\Model;
use \PDO;
use DateTime;
use Portfolio\Entity\Post;

class PostManager extends Database 
{
    private $table = "post";
    
    public function __construct()
    {
        parent::__construct();
    }

    //create post
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

        $statement = $this->pdo->prepare('SELECT post.id, post.title, post.text, post.picture, post.date_creation, post.status, post.date_update, post.author, users.username FROM post INNER JOIN users ON post.author = users.id WHERE post.status = 1 ORDER BY post.date_creation ASC');
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
         $statement = $this->pdo->prepare("SELECT post.id, post.title, post.picture, post.text, post.date_creation, post.date_update, post.status, post.author, users.username FROM $this->table INNER JOIN users ON post.author = users.id WHERE post.id=:id");
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


    // Récuperation des posts en attente de validation
    public function findAllArticle($status = null) 
    {
        $sql = 'SELECT post.id, post.title, post.picture, post.text, post.date_creation, post.status, post.author, users.username FROM post INNER JOIN users ON post.author = users.id';

        // si l'article existe alors concatene avec where pour filtrer
        if($status){
        $sql .= " WHERE post.status = $status";
        }

        $statement = $this->pdo->prepare($sql);
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

    // Récuperation d'un article grace a l'id et lui modifier son statut
    public function updateStatusArticle($id) 
    { 
        $statement = $this->pdo->prepare("UPDATE $this->table SET status = 1 WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        
        $statement->execute();
    }  

    // Récuperation des posts par l'id de l'auteur
    public function getAllByAuthorId($author) 
    {
        $statement = $this->pdo->prepare('SELECT post.id, post.title, post.text, post.picture, post.date_creation, post.status, post.author, users.username FROM post INNER JOIN users ON post.author = users.id WHERE post.author = :id');
        $statement->bindValue('id', $author, \PDO::PARAM_INT);

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

    // Modifier un post grace a l'id
    public function edit($id, $title, $text, $picture) 
    {
         $statement = $this->pdo->prepare("UPDATE $this->table SET
          title=:title, text=:text, picture=:picture, date_update=:date_update
         WHERE id=:id");
        $statement->bindValue('id', $id['id'], \PDO::PARAM_INT);
        $statement->bindValue('title', $title, \PDO::PARAM_STR);
        $statement->bindValue('text', $text, \PDO::PARAM_STR);
        $statement->bindValue('picture', $picture, \PDO::PARAM_STR);
        $statement->bindValue('date_update', date("Y-m-d H:i:s"));

        $statement->execute();
       
    }   

    // Effacer un post grace a l'id
    public function delete($id) 
    {     
        $statement = $this->pdo->prepare("DELETE FROM $this->table WHERE post.id=:id ADD CONSTRAINT fk_comment_post FOREIGN KEY (post_id) REFERENCES post(id) ON DELETE CASCADE");

        $statement->bindValue('id', $id, \PDO::PARAM_INT);

        $statement->execute();
    }
}