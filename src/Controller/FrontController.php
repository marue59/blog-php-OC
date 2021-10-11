<?php

namespace Portfolio\Controller;

use Portfolio\Model\PostManager;
use Portfolio\Controller\AbstractController;
use Swift_SmtpTransport;
use Swift_Mailer;
use Swift_Message;

class FrontController extends AbstractController {

    private $postManager;

    
    public function __construct() {
        $this->postManager = new PostManager();
        parent::__construct();
    }
 
    public function home() {

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
        $errors = [ "errorUsername" => "",
                    "errorEmail" => "",
                  ];

        $successMessage = [ "messageSuccess" => "Votre message a bien été envoyé"
                          ];
       
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['text']))
            {
                $errors["errorUsername"] = "Vous n'avez pas remplit votre nom";
                $errors["errorEmail"] = "Vous n'avez pas remplit votre email";

            } else {

                $email = $_POST["email"];

                // Create the Transport smtp.gmail.com
                $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
                ->setUsername(GOOGLE_MAIL)
                ->setPassword(GOOGLE_PASS);
               
                // Create the Mailer using your created Transport
                $mailer = new Swift_Mailer($transport);

                // Create a message
                $message = (new Swift_Message('Wonderful Subject'))
                ->setFrom($email)
                ->setTo(['marue59@hotmail.fr'])
                ->setBody('Nous accusons bonne reception de votre message, nous vous répondrons dans les plus bref delais. Marie');

                // Send the message
                $result = $mailer->send($message);
            }
            $successMessage = [ "messageSuccess"];
            header('Location:/');

        }
       
        echo $this->twig->render('project/contact.html.twig');
    }



}

?>