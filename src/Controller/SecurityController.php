<?php

namespace Portfolio\Controller;

use Entity\User;
use Model\Database;
use Portfolio\Model\UserManager;
use Portfolio\Controller\AbstractController;



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
        $errors = [
            "errorUserName" => "",
            "errorEmail" => "",
            "errorPassword" => "",
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['email']) && !empty($_POST['password'])) {
                
                $email = $_POST['email'];
                $password = trim(htmlspecialchars($_POST['password']));
                $userManager = new UserManager();
                $user = $userManager->getByEmail($email);
        
               
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors["errorEmail"] = "Votre email n'est pas valide";
                }
                
                if (password_verify($password, $user->getPassword())) {
                    $_SESSION["email"] = $user->getEmail();
                    $_SESSION["id"] = $user->getId();
                    $_SESSION["status"] = $user->getStatus();
                  

                    if($_SESSION["status"] == 1)
                    {
                        header('Location:/admin');
                        exit();
                    }
                        header('Location:/mon-compte');
                } 
            
            } else {
                $errors["errorEmail"]= "Vous n'avez pas renseigné votre email ou votre mot de passe";
            }
        }
            echo $this->twig->render('security/login.html.twig',['error' => $errors]);
    }

    // creation de compte
    public function create()
    {
        $errors = [
            "errorUserName" => "",
            "errorEmail" => "",
            "errorPassword" => "",
        ];
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (empty($_POST['username']) || empty($_POST['password'])) {
                    $errors["errorPassword"] = "Identifiant ou mot de passe incorrect";
    
                } else {
                $userName = $_POST['username'];
                $email = $_POST['email'];
                  
                $userManager = new UserManager();
                $user = $userManager->getByEmail($email);
                if ($user){
                    $errors["errorUserName"] = "Le nom existe déja";

                } else {

                $user = [
                    'username' => $userName,
                    'email' => $email,
                    'password' => $_POST['password']
                ];
            
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

                    $errors["errorEmail"] = "Entrez un mail valide";

                } else {

                 $userManager->create($user);
                 header('Location:/connexion');
                } 
            }
            }
        }
            echo $this->twig->render('security/create.html.twig',["error"=> $errors]);
    }

    //logout
    public function logout()
    {
        session_destroy();
        header('Location:/');
    }
    


}
