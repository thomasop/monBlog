<?php

require('vendor/autoload.php');

use App\tool\PHPSession;

// Create the Transport
$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
  ->setUsername('thomasdasilva010@gmail.com')
  ->setPassword('azerty66.,')
;

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

// Create a message
$message = (new Swift_Message('Bonjour'))
  ->setFrom(['thomasdasilva010@gmail.com' => 'Thomas DA SILVA'])
  ->setTo([$_POST['email']])
  ->setBody('Nous avons pris votre demande en compte. Nous vous contacterons le plus vite possible, merci de votre visite.')
  ;
  
// Send the message
$mailer->send($message);

$php_session = new PHPSession();
$php_session->set('stop', 'Votre Email a été envoyé.');
$php_session->redirect('/blog/');