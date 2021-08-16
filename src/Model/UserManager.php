<?php

namespace Portfolio\Model;

class UserManager extends Database {

    //create user
    public function create($user)
    {
        $userPassword = trim(htmlspecialchars($user['password']));
        $safePassword = password_hash($userPassword, PASSWORD_DEFAULT);

        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table 
            (username, email, password) 
            VALUES (:username, :email, :password)");
        $statement->bindValue('username', $user['username'], \PDO::PARAM_STR);
        $statement->bindValue('email', $user['email'], \PDO::PARAM_STR);
        $statement->bindValue('password', $user['password'], \PDO::PARAM_STR);
        
        $statement->execute();
    }
    
    

    // login
   /* public function login(string $email)
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE email=:email");
        $statement->bindValue('email', $email, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }
   */ 
    
    public function getByEmail(string $email)
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE email=:email");
        $statement->bindValue('email', $email, \PDO::PARAM_STR);
        $statement->execute();

        $data = $statement->fetch();
        $user = new User();
        $user->hydrate($data);

        return $user;
    }   

    /*public function getUsers() {
       $users = $this->query('select * from users');

       $list = [];
       foreach ($users as $key => $user) {
           $model = new Users();
           $model->hydrate($user);
           $list[] = $model;
       }

       return $list;
    }
*/

    
}