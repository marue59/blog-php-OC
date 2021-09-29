<?php

namespace Portfolio\Model;
use Portfolio\Entity\Comment;
use Portfolio\Model\Database;
use \PDO;

class CommentManager extends Database
{
    private $table = "comment";

    public function __construct()
    {
        parent::__construct();
    }

    public function create($comment)
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table 
        (title, text, author, status, date_creation) 
        VALUES (:title, :text, :author, :status, :date_creation)");
        $statement->bindValue('title', $comment['title'], \PDO::PARAM_STR);
        $statement->bindValue('text', $comment['text'], \PDO::PARAM_STR);
        $statement->bindValue('status', 2, \PDO::PARAM_INT);
        $statement->bindValue('author', $_SESSION['id'], \PDO::PARAM_INT);
        $statement->bindValue('date_creation', date("Y-m-d H:i:s"));

        $statement->execute();
    } 
    
    
    public function findAll($status = null)
    {
        $sql = 'SELECT * FROM comment';

        if($status){

        $sql .= " WHERE status = $status";
        }

        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll();

        if ($data){
            $comments = [];
            foreach ($data as $entity) {
                $comment = new Comment();
                $comment->hydrate($entity);
                $comments[] = $comment;            
            }
        
            return $comments;
        }

        return false;
        
    }   

    // Validation du comment en modifiant le statut
    public function updateCommentStatus($id)
    {
        $statement = $this->pdo->prepare("UPDATE $this->table SET status = 1 WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);

        $statement->execute();
    }   
}
?>