<?php

namespace Portfolio\Model;

use PDO;
use Portfolio\Entity\User;

class UserManager extends Database
{
    private $table = "users";

    public function __construct()
    {
        parent::__construct();
    }

    
    /**
     * Create user
     *
     * @return void
     */
    public function create($user)
    {
        $userPassword = trim(htmlspecialchars($user['password']));
        $safePassword = password_hash($userPassword, PASSWORD_DEFAULT);

        // Prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table 
            (username, email, password, status) 
            VALUES (:username, :email, :password, :status)");
        $statement->bindValue('username', $user['username'], \PDO::PARAM_STR);
        $statement->bindValue('email', $user['email'], \PDO::PARAM_STR);
        $statement->bindValue('password', $safePassword, \PDO::PARAM_STR);
        $statement->bindValue('status', 3, \PDO::PARAM_INT);

        $statement->execute();
    }

     /**
     * Verification du mail pour la connexion au compte
     *
     * @return void
     */
    public function getByEmail(string $email)
    {
        // Prepared request
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE email=:email");
        $statement->bindValue('email', $email, \PDO::PARAM_STR);
        $statement->execute();

        $data = $statement->fetch();

        if ($data) {
            $user = new User();
            $user->hydrate($data);

            return $user;
        }
        return false;
    }

    /**
     * Admin : Récuperation des users en attente de validation
     *
     * @return void
     */
    public function findAll($status = null)
    {
        $sql = 'SELECT * FROM users';

        // Si status existe alors concatene avec where
        if ($status) {
            $sql .= " WHERE status = $status";
        }
        $statement = $this->pdo->prepare($sql);

        $statement->execute();

        $data = $statement->fetchAll();

        if ($data) {
            $users = [];
            foreach ($data as $entity) {
                $user = new User();
                $user->hydrate($entity);
                $users[] = $user;
            }

            return $users;
        }
        return false;
    }

    /**
     * Validation du user en modifiant le statut
     *
     * @return void
     */
    public function updateStatus($id)
    {
        $statement = $this->pdo->prepare("UPDATE $this->table SET status = 2 WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);

        $statement->execute();
    }


    /**
     * Récuperation d'un user grace a l'id
     *
     * @return void
     */
    public function findOneUser($id)
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);

        $statement->execute();

        $data = $statement->fetch();

        if ($data) {
            $user = new User();
            $user->hydrate($data);

            return $user;
        }
        return false;
    }
}
