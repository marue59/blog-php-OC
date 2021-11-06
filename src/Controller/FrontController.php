<?php

namespace Portfolio\Controller;

use Portfolio\Model\PostManager;
use Portfolio\Controller\AbstractController;
use Swift_SmtpTransport;
use Swift_Mailer;
use Swift_Message;

class FrontController extends AbstractController
{
    private $postManager;


    public function __construct()
    {
        $this->postManager = new PostManager();
        parent::__construct();
    }

    public function home()
    {
        $posts = $this->postManager->getValidatePost();

        echo $this->twig->render('layout.html.twig', ['posts' => $posts]);
    }

    /**
     * Connexion
     *
     * @return void
     */
    public function login()
    {
        echo $this->twig->render('security/login.html.twig');
    }

    public function project()
    {
        echo $this->twig->render('project/showAllProjects.html.twig');
    }

    public function contact()
    {
         // Methode dans abstract
        $this->generateToken();
       
        $errors = [ "errorUsername" => "",
                    "errorEmail" => "",
                    "errorToken" => ""
                  ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['text'])) {
                $errors["errorUsername"] = "Vous n'avez pas remplit votre nom";
                $errors["errorEmail"] = "Vous n'avez pas remplit votre email";
                //si j'ai posté un token et que le token en session est different du token posté
            } elseif (isset($_POST['token']) && $_SESSION['token'] != $_POST["token"]) {
                $errors["errorToken"] = "Le token n'est pas valide";
            } else {
                $username = trim(htmlspecialchars($_POST["username"]));
                $email = trim(htmlspecialchars($_POST["email"]));
                $text = trim(htmlspecialchars($_POST["text"]));

                // Create the Transport smtp.gmail.com
                $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
                    ->setUsername(GOOGLE_MAIL)
                    ->setPassword(GOOGLE_PASS);

                // Create the Mailer using your created Transport
                $mailer = new Swift_Mailer($transport);

                // Create a message
                $message = (new Swift_Message('Nouveau message de contact'))
                    ->setFrom($email)
                    ->setTo(GOOGLE_MAIL)
                    ->setBody($this->twig->render('project/mail.html.twig', ['username' => $username, 
                                                                                'email'=>$email, 
                                                                                'text'=>$text]), 'text/html');
               
                // Send the message
                try {
                    $result = $mailer->send($message);
                    header('Location:/');
                    exit;

                } catch (Exception $e) {
                    $errors["errorToken"] = "Erreur lors de l'envoi de l'email";
                }

                unset($_SESSION['token']);
            }
            
        }
        echo $this->twig->render('project/contact.html.twig', ['error' => $errors]);
    }
}
