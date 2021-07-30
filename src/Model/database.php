<?php
    namespace Portfolio;
    use \PDO;


    class Database{

        private $db_name;
        private $db_user;
        private $db_pass;
        private $db_host;
        private $pdo;

        public function __construct($db_name, $db_user = 'root', $db_pass = '08111987' , $db_host = 'localhost')
        {
            $this->db_name = $db_name;
            $this->db_user = $db_user;
            $this->db_pass = $db_pass;
            $this->db_host = $db_host;

        }

        private function getPDO()
        {
            $pdo = new PDO('mysql:dbname:Portfolio;host=localhost:8000', 'root', '08111987');
            $pdo->setAttribute(PDO::ATTR_ERROMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
            return $pdo;

        }

        //recuperer les données :

        public function query($statement)
        {
            $pdoStatement = $this->getPDO()->$pdo->query($statement);
            $datas = $pdoStatement->fetchAlll(PDO::FETCH_OBJ);
            return $datas;

        }


    }

?>