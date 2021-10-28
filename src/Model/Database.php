<?php

namespace Portfolio\Model;

use PDO;

require('config/db.php');

class Database
{
    protected $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=' . APP_DB_HOST . '; dbname=' . APP_DB_NAME . '; charset=utf8', APP_DB_USER, APP_DB_PWD);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }


    // Récuperation des données :
    public function query($statement)
    {
        $pdoStatement = $this->pdo->query($statement);
        $datas = $pdoStatement->fetchAll();
        return $datas;
    }
}
