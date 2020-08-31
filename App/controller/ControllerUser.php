<?php

namespace App\controller;

use PDO;
use App\manager\AdminManager;
use App\manager\PostManager;
use App\manager\CommentManager;

class ControllerUser
{
    function admin()
    { 
        $token = md5(bin2hex(openssl_random_pseudo_bytes(6)));
        $_SESSION['token'] = $token;
        $twigcontroller = new \App\tool\Twig();
        $twigview = $twigcontroller->getTwig();
        $twigadmin = $twigview->load('Frontend/connection.twig');
        echo $twigadmin->render(array('token' => $token));
    }
    function registration()
    {
        $twigcontroller = new \App\tool\Twig();
        $twigview = $twigcontroller->getTwig();
        $twigregistration = $twigview->load('Frontend/registration.twig');
        echo $twigregistration->render();
    }

    function adminShows()
    {
        $loginmanager = new AdminManager();
        $loginvalid = $loginmanager->showAdmins();
        $twigcontroller = new \App\tool\Twig();
        $twigview = $twigcontroller->getTwig();
        $twigadminshows = $twigview->load('Backend/managervalid.twig');
        echo $twigadminshows->render(array('loginvalid' => $loginvalid)); 
    }

    function adminUpdateValid()
    {
        $adminmanager = new AdminManager();
        $validAdminView = $adminmanager->updateAdminValid($_GET['id']);
        echo "<script>alert(\"Compte validé.\");
        document.location.href = '/blog/admin'</script>";
    }
    
    function connect($pseudo, $motdepasse)
    {
        $loginmanager = new adminManager();
        $login = $loginmanager->adminOk($pseudo, $motdepasse);
        $user = $login->fetch(PDO::FETCH_OBJ);
     
        if (!$user) { 
            "<script>alert(\"Pseudo incorrect\");
            document.location.href = 'index.php?action=admin'</script>";
        } else {
            $mdp = $user->motdepasse;
            $validPassword = password_verify($_POST['motdepasse'], $mdp);
           
            if($validPassword && isset($_SESSION['token']) && isset($_POST['token'])) {
                $_SESSION['pseudo'] = $_POST['pseudo'];
                $_SESSION['motdepasse'] = $_POST['motdepasse'];
                $_SESSION['id'] = $user->id;
                if(isset($_COOKIE['ticket']) && isset($_SESSION['ticket'])) {
                    if($_COOKIE['ticket'] == $_SESSION['ticket'] && $_POST['token'] == $_SESSION['token']) {
                        $twigcontroller = new \App\tool\Twig();
                        $twigview = $twigcontroller->getTwig();
                        $twigconnect = $twigview->load('Backend/managerhome.twig');
                        echo $twigconnect->render(array('user' => $user));
                    }
                }
            }
        }
        function register($pseudo, $motdepasse)
        {
            $motdepasse = password_hash($motdepasse, PASSWORD_DEFAULT);
            $registerManager = new adminManager();
            $register = $registerManager->adminInscription($pseudo, $motdepasse);
            echo "<script>alert(\"Votre compte a été créé, un administrateur validera votre compte.\");
            document.location.href = '/blog/connect'</script>"; 
        }
    }
}