<?php

namespace Portfolio\Controller;

use Portfolio\Model\UserManager;
use Portfolio\Controller\AbstractController;
use Entity\User;


class SecurityController extends AbstractController {

    public $errors = [
        "errorUserName" => "",
        "errorEmail" => "",
        "errorPassword" => "",
    ];
    

    private $userManager;

    public function __construct() {
        $this->userManager = new UserManager();
        parent::__construct();
    }

    // login
    public function login() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['email']) || empty($_POST['password'])) {
    
                $email = $_POST['email'];
                $password = trim(htmlspecialchars($_POST['password']));

                $userManager = new UserManager();
                $user = $userManager->getByEmail($email);
                var_dump($user);
                if (password_verify($password, $user->getPassword())) {
                    $_SESSION["email"] = $user->getEmail();
                    $_SESSION["password"] = $user->getPassword;
                    header('Location:/mon-compte');
                } 
            }
        }
            echo $this->twig->render('security/login.html.twig');

    }

    // creation de compte
    public function create()
    {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (empty($_POST['username']) || empty($_POST['password'])) {
                    $errors["password"] = ["Identifiant ou mot de passe incorrect"];
    
                }
                $userName = $_POST['username'];
                $email = $_POST['email'];
                  
                $userManager = new UserManager();
                $user = [
                    'username' => $userName,
                    'email' => $email,
                    'password' => $_POST['password']
                ];

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
               
                 $userManager->create($user);
                
            }
            echo $this->twig->render('security/create.html.twig');
    }
};
