<?php

namespace Portfolio\Controller;

use Portfolio\Model\UserManager;
use Portfolio\Controller\AbstractController;



$errors = [
    "errorUserName" => "",
    "errorEmail" => "",
    "errorPassword" => "",
];


class SecurityController extends AbstractController {

    private $userManager;

    public function __construct() {
        $this->userManager = new UserManager();
    }

    // creation de compte
    public function create() {

        $users = $this->userManager->getUsers();


        echo $this->twig->render('security/create.html.twig', ['users' => $users]);
    }


    
    // authentification
    public function auth() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $userName = $_POST[('userName')];
                $email = $_POST['email'];
                $password = trim(htmlspecialchars($_POST['password']));
    
                if(empty($userName)){
                    $errors["errorUserName"]= "<small> Vous n'avez pas renseigné votre nom</small>";
                } elseif (!preg_match("/^[a-zA-Z ]*$/", $userName)) {
                    $errors["errorUserName"] = "<small>Seul les lettres et les espaces sont autorisés</small>";
                }
                if(empty($email)){
                    $errors["errorEmail"]= "<small> Vous n'avez pas renseigné votre email</small>";
                }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors["errorEmail"] = "<small>Entrez un mail valide</small>";
                }

                $userManager = new UserManager();
                $user = $userManager->selectOneByUser($email);
    
                if (password_verify($password, $user['password'])) {
                    $_SESSION["username"] = $user['username'];
                    $_SESSION["userId"] = $user['id'];
                    header('Location:/layout.html.twig' . $_SESSION['userId']);
                } else {

                    return $this->twig->render('security/auth.html.twig', ['mdp' => $mdp]);
                }
            }
            return $this->twig->render('security/create.html.twig');
    
    }



    // si la session n'est pas debutée il start
     
   /* public function isConnected() :bool
    {
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
        return !empty($_SESSION['connected']);
        
    }*/
 
};
?>