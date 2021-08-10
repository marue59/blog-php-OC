<?php

namespace Portfolio\Model;

class LoginManager extends Database {

    private $username;
    private $email;
    private $password;
    

    /**
     * Get the value of username
     */ 
    public function getUsername() : ?string
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */ 
    public function setUsername ($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }
    //create user
    public function create()
    {

        if(!empty($_POST)) {
            //si le errors re-set le username
            $user->setUsername($_POST['username']);
            if (empty($_POST['username']) || empty($_POST['password'])) {
                $errors["password"] = ["Identifiant ou mot de passe incorrect"];

        } else {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table 
            (username, email, password) 
            VALUES (:username, :email, :password)");
        $statement->bindValue('username', $user['username'], \PDO::PARAM_STR);
        $statement->bindValue('email', $user['email'], \PDO::PARAM_STR);
        $statement->bindValue('password', $user['password'], \PDO::PARAM_STR);
            vardump($_POST);
        $statement->execute();

        return $statement->fetch();
        }
    }
    }

    // authentification
    public function selectOneByUser(string $email)
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE email=:email");
        $statement->bindValue('email', $email, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }








    /*public function getUsers() {
       $users = $this->query('select * from users');

       $list = [];
       foreach ($users as $key => $user) {
           $model = new Users();
           $model->hydrate($users);
           $list[] = $model;
       }

       return $list;
    }
*/

    
}