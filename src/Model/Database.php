<?php
namespace Portfolio\Model;
use \PDO;


class Database{

    protected $pdo;

    public function getPDO()
    {
        $this->pdo = new PDO('mysql:host=' . APP_DB_HOST . '; dbname=' . APP_DB_NAME . '; charset=utf8',
        APP_DB_USER,
        APP_DB_PWD
    );
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $this->pdo;
    }
 
    //recuperer les données :

    public function query($statement)
    {
        $pdoStatement = $this->getPDO()->query($statement);
        $datas = $pdoStatement->fetchAll();
        return $datas;
    }


}

?>