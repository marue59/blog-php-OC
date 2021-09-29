<?php
    namespace Portfolio\Model;

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
            (title, text, status, date_creation) 
            VALUES (:title, :text, :status, :date_creation)");
            $statement->bindValue('title', $comment['title'], \PDO::PARAM_STR);
            $statement->bindValue('text', $comment['text'], \PDO::PARAM_STR);
            $statement->bindValue('status', 2, \PDO::PARAM_INT);
            $statement->bindValue('date_creation', date("Y-m-d H:i:s"));

            $statement->execute();

        }        
    }
?>