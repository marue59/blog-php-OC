<?php

namespace Portfolio\Model;
use \PDO;
use DateTime;
use Portfolio\Entity\Post;

class PostManager extends Database 
{
    private $table = "posts";
    
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
            (title, text, picture, dateCreation) 
            VALUES (:title, :text, :picture, :dateCreation)");
        $statement->bindValue('title', $post['title'], \PDO::PARAM_STR);
        $statement->bindValue('text', $post['text'], \PDO::PARAM_STR);
        $statement->bindValue('picture', $post['picture'], \PDO::PARAM_STR);
        $statement->bindValue(' dateCreation', $post(new DateTime('now')));

        $statement->execute();
    }
}