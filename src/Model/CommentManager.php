<?php

namespace Portfolio\Model;

use Portfolio\Entity\Comment;
use Portfolio\Model\Database;
use PDO;

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
        (post_id, text, author, status, date_creation) 
        VALUES (:post_id, :text, :author, :status, :date_creation)");
        $statement->bindValue('post_id', $comment['id'], \PDO::PARAM_STR);
        $statement->bindValue('text', $comment['text'], \PDO::PARAM_STR);
        $statement->bindValue('status', 2, \PDO::PARAM_INT);
        $statement->bindValue('author', $comment['author'], \PDO::PARAM_INT);
        $statement->bindValue('date_creation', date("Y-m-d H:i:s"));

        $statement->execute();
    }


    public function findAll($status = null)
    {
        $sql = 'SELECT comment.id, comment.text, comment.date_creation, comment.status, comment.author, users.username  FROM comment INNER JOIN users ON comment.author = users.id ';

        if ($status) {
            $sql .= " WHERE comment.status = $status";
        }

        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll();

        if ($data) {
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

    // Récuperation d'un com grace a l 'id
    public function findOneComment($id)
    {
        $statement = $this->pdo->prepare("SELECT comment.id, comment.text, comment.date_creation, comment.status, comment.author, users.username FROM $this->table INNER JOIN users ON comment.author = users.id WHERE comment.id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);

        $statement->execute();

        $data = $statement->fetch();

        if ($data) {
            $comment = new Comment();
            $comment->hydrate($data);

            return $comment;
        }
        return false;
    }

    // Effacer un com grace a l'id
    public function delete($id)
    {
        $statement = $this->pdo->prepare("DELETE FROM $this->table WHERE comment.id = :id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);

        $statement->execute();
    }

    // findBy recupere le post id
    public function findBy($post_id, $status = null)
    {
        $sql = "SELECT comment.id, comment.text, comment.date_creation, comment.status, comment.author, users.username FROM $this->table INNER JOIN users ON comment.author = users.id WHERE post_id = :post_id";
        if ($status) {
            $sql .= " AND comment.status = :status";
        }
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue('post_id', $post_id, \PDO::PARAM_INT);

        if ($status) {
            $statement->bindValue('status', $status, \PDO::PARAM_INT);
        }


        $statement->execute();
        $data = $statement->fetchAll();

        if ($data) {
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
}
