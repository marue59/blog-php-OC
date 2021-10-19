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
        //generer un token uniqu a chaque form
        // si le token n'est pas en session on le genere et on le met en session

        if (!isset($_SESSION['token'])) {
            $token = md5(uniqid(rand(), true));

            // On le stock en session
            $_SESSION['token'] = $token;
        }

        $errors = [ "errorUsername" => "",
                    "errorEmail" => "",
                    "errorToken" => ""
                  ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['text'])) {
                $errors["errorUsername"] = "Vous n'avez pas remplit votre nom";
                $errors["errorEmail"] = "Vous n'avez pas remplit votre email";
            } elseif ($token != $_POST["token"]) {
                $errors["errorToken"] = "Le token n'est pas valide";
            } else {
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
                ->setBody($text);
               
                // Send the message
                $result = $mailer->send($message);
                unset($_SESSION['token']);
            }
            header('Location:/');
        }
        echo $this->twig->render('project/contact.html.twig');
    }
}
