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
            "errorEmail" => "",
            "errorEmpty" => "",
            "errorMdp" => ""
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['email']) && !empty($_POST['password'])) {
                
                $email = trim(htmlspecialchars($_POST['email']));
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
                } else {
                 // PROBLEME
                    $errors["errorMdp"]= "Vous n'avez pas renseigné votre mot de passe";
                }
            
            } else {
                
                $errors["errorEmpty"]= "Vous devez remplir tout les champs";
            }
        }
            echo $this->twig->render('security/login.html.twig',['error' => $errors]);
    }

    // creation de compte
    public function create()
    {
        $errors = [
            "errorUsername" => "",
            "errorEmailCreate" => "",
            "errorMail" => "",
            "errorPassword" => "",
        ];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
                    $errors["errorUsername"] = "Vous devez remplir votre nom";
                    $errors["errorEmailCreate"] = "Vous devez remplir votre adresse mail";
                    $errors["errorPassword"] = "Vous devez remplir votre mot de passe";
                    

                } else {
                $username = trim(htmlspecialchars($_POST['username']));
                $email = trim(htmlspecialchars($_POST['email']));
                  
                $userManager = new UserManager();
                $user = $userManager->getByEmail($email);
                if ($user){
                    $errors["errorMail"] = "L'adresse mail existe déja";

                } else {

                $user = [
                    'username' => trim(htmlspecialchars($username)),
                    'email' => trim(htmlspecialchars($email)),
                    'password' => trim(htmlspecialchars($_POST['password']))
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
