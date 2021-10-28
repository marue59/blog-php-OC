<?php

namespace Portfolio\Controller;

use Entity\User;
use Model\Database;
use Portfolio\Model\UserManager;
use Portfolio\Controller\AbstractController;

class SecurityController extends AbstractController
{
    public $errors = [
        "errorUserName" => "",
        "errorEmail" => "",
        "errorPassword" => "",
    ];


    private $userManager;

    public function __construct()
    {
        $this->userManager = new UserManager();
        parent::__construct();
    }

    // login
    public function login()
    {
         //generer un token uniqu a chaque form
        // si le token n'est pas en session on le genere et on le met en session

        if (!isset($_SESSION['token'])) {
            $token = md5(uniqid(rand(), true));

            // On le stock en session
            $_SESSION['token'] = $token;
        }

        $errors = [
            "errorEmail" => "",
            "errorEmpty" => "",
            "errorMdp" => "",
            "errorToken" => ""
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['email']) && !empty($_POST['password'])) {
                $email = trim(htmlspecialchars($_POST['email']));
                $password = trim(htmlspecialchars($_POST['password']));
                $userManager = new UserManager();
                $user = $userManager->getByEmail($email);

                //si le status est 1 ou 2 et u'il est validé et que l'email est valide que le pass est bon on autorise
                if ($user && in_array($user ->getStatus(), [1, 2])
                     && filter_var($email, FILTER_VALIDATE_EMAIL) 
                     && password_verify($password, $user->getPassword())) {
                    $_SESSION["email"] = $user->getEmail();
                    $_SESSION["id"] = $user->getId();
                    $_SESSION["status"] = $user->getStatus();

                    if ($_SESSION["status"] == 1) {
                        header('Location:/admin');
                        exit();
                    }
                    header('Location:/mon-compte');

                  } elseif ($token != $_POST["token"]) {
                    $errors["errorToken"] = "Le token n'est pas valide";
                } else {
                    $errors["errorMdp"]= "Votre compte est en attente de validation, merci de patienter...";
                }
            } else {
                $errors["errorEmpty"]= "Vous devez remplir tout les champs";
            }  
            unset($_SESSION['token']);
        }
        echo $this->twig->render('security/login.html.twig', ['error' => $errors]);
    }

    // creation de compte
    public function create()
    {  
         //generer un token uniqu a chaque form
        // si le token n'est pas en session on le genere et on le met en session

        if (!isset($_SESSION['token'])) {
            $token = md5(uniqid(rand(), true));

            // On le stock en session
            $_SESSION['token'] = $token;
        }

        $errors = [
            "errorUsername" => "",
            "errorEmailCreate" => "",
            "errorMail" => "",
            "errorPassword" => "",
            "errorToken" => ""
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

                if ($user) {
                    $errors["errorMail"] = "L'adresse mail existe déja";
                } elseif ($token != $_POST["token"]) {
                    $errors["errorToken"] = "Le token n'est pas valide";
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
                        unset($_SESSION['token']);

                        header('Location:/connexion');
                    }
                }
            }
        }
        echo $this->twig->render('security/create.html.twig', ["error"=> $errors]);
    }

    //logout
    public function logout()
    {
        session_destroy();
        header('Location:/');
    }
}
