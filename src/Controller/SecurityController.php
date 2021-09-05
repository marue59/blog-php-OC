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
                     var_dump($_SESSION);
                        die;
                    
                    if($_SESSION["status"] = $user->getStatus('1'))
                    {
                        echo $this->twig->render('account/admin.html.twig');
                
                    }
                        header('Location:/mon-compte');
                } 
            
            } else {
                $errors["errorEmail"]= "Vous n'avez pas renseigné votre email";
            }
        }
            echo $this->twig->render('security/login.html.twig',['error' => $errors]);

    }

    /*public function admin()
    {  
        $user= $this->login($user);

        if($_SESSION["status"] = $user->getStatus('1'))
        {
            echo $this->twig->render('account/admin.html.twig');
        
        }   header('Location:/connexion');
    }     
*/

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
                    $errors["errorEmail"] = "Le nom existe déja";

                } else {

                $user = [
                    'username' => $userName,
                    'email' => $email,
                    'password' => $_POST['password']
                ];
            
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

                    $errors["errorEmail"] = "<small>Entrez un mail valide</small>";

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

    public function showUser()
    {
        $users = $this->userManager->findAll();

        echo $this->$twig->render('account/admin.html.twig', ["users"=> $users]);
    }
   
    


}
