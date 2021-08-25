<?php

namespace Portfolio\Model;
use \PDO;
use Portfolio\Entity\User;

class UserManager extends Database 
{
    private $table = "users";
    
    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct();
    }

    //create user
    public function create($user)
    {
        
        $userPassword = trim(htmlspecialchars($user['password']));
        $safePassword = password_hash($userPassword, PASSWORD_DEFAULT);

        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table 
            (username, email, password, status) 
            VALUES (:username, :email, :password, :status)");
        $statement->bindValue('username', $user['username'], \PDO::PARAM_STR);
        $statement->bindValue('email', $user['email'], \PDO::PARAM_STR);
        $statement->bindValue('password', $safePassword, \PDO::PARAM_STR);
        $statement->bindValue('status', 2, \PDO::PARAM_INT);

        $statement->execute();
    }
    
    
    public function getByEmail(string $email)
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE email=:email");
        $statement->bindValue('email', $email, \PDO::PARAM_STR);
        $statement->execute();

        $data = $statement->fetch();
        if ($data){
            $user = new User();
            $user->hydrate($data);
            
            return $user;
        }
            return false;
    }   


    
}