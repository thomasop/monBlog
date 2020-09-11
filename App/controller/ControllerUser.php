<?php

namespace App\controller;

use PDO;
use App\manager\AdminManager;
use App\manager\PostManager;
use App\manager\CommentManager;
use App\tool\PHPSession;
use Exception;

class ControllerUser extends Controller
{
    function admin()
    { 
        $token = md5(bin2hex(openssl_random_pseudo_bytes(6)));
        $_SESSION['token'] = $token;
        $twigview = $this->getTwig();
        $twigadmin = $twigview->load('Frontend/connection.twig');
        echo $twigadmin->render(array('token' => $token));
    }
    function registration()
    {
        $twigview = $this->getTwig();
        $twigregistration = $twigview->load('Frontend/registration.twig');
        echo $twigregistration->render();
    }

    function adminShows()
    {
        if (isset($_SESSION['pseudo'])) {
            $pseudo = $_SESSION['pseudo'];
            $motdepasse = $_SESSION['motdepasse'];
            $loginmanager = new AdminManager();
            $loginvalid = $loginmanager->showAdmins();
            $loginvalidadmin = $loginmanager->showAdminsValid();
            $twigview = $this->getTwig();
            $twigadminshows = $twigview->load('Backend/managervalid.twig');
            echo $twigadminshows->render(array('loginvalid' => $loginvalid,
                                                'loginvalidadmin' => $loginvalidadmin)); 
        }
        else {
            $php_session = new PHPSession();
            $php_session->set('stop', 'Vous n\'avez pas acces a cette page.');
            $php_session->redirect('/blog/connect');
        }
    }

    function adminUpdateValid()
    {
        $php_session = new PHPSession();
        if (isset($_SESSION['pseudo']) && isset($_GET['id']) && !empty($_GET['id'])) {
            $adminmanager = new AdminManager();
            $validAdminView = $adminmanager->updateAdminValid($_GET['id']);
            $php_session->set('succes', 'Adminnistrateur validé.');
            $php_session->redirect('/blog/admin/', $_SESSION['id']);
        }
        else {
            $php_session->set('stop', 'Vous n\'avez pas acces a cette page.');
            $php_session->redirect('/blog/connect');
        }
    }
    
    function connect($pseudo, $motdepasse)
    {
        $loginmanager = new adminManager();
        $login = $loginmanager->adminOk($pseudo, $motdepasse);
        $user = $login->fetch(PDO::FETCH_OBJ);
        $php_session = new PHPSession();
        if (!empty($_POST['motdepasse']) && !empty($_POST['pseudo'])) {
            if (!$user) { 
                $php_session->set('stop', 'Pseudo ou mot de passe incorrect.');
                $php_session->redirect('/blog/connect');
                
            } else {
                $mdp = $user->motdepasse;
                $validPassword = password_verify($_POST['motdepasse'], $mdp);
            
                if($validPassword && isset($_SESSION['token']) && isset($_POST['token'])) {
                    $_SESSION['pseudo'] = $_POST['pseudo'];
                    $_SESSION['motdepasse'] = $_POST['motdepasse'];
                    $_SESSION['id'] = $user->id_admin;
                    if(isset($_COOKIE['grslo']) && isset($_SESSION['gruhto'])) {
                        if($_COOKIE['grslo'] == $_SESSION['gruhto'] && $_POST['token'] == $_SESSION['token']) {
                            $twigview = $this->getTwig();
                            $twigconnect = $twigview->load('Backend/managerhome.twig');
                            echo $twigconnect->render(array('user' => $user));
                        } else{
                            $php_session->set('stop', 'Problème d\'authentification.');
                            $php_session->redirect('/blog/connect');
                        }
                    } else {
                        $php_session->set('stop', 'Problème d\'authentification.');
                        $php_session->redirect('/blog/connect'); 
                    }
                } else {
                    $php_session->set('stop', 'Pseudo ou mot de passe incorrect.');
                    $php_session->redirect('/blog/connect');
                }
            }
        }  
    }

    function register($pseudo, $motdepasse)
    {
        $php_session = new PHPSession();
        if (!empty($_POST['motdepasse']) && !empty($_POST['pseudo']) && !empty($_POST['motdepasseconfirmer'])) {
            if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{6,}$#', $_POST['pseudo'])){
                if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{10,}$#', $_POST['motdepasse'])){
                    if ($_POST['motdepasse'] == $_POST['motdepasseconfirmer']) {
                        $motdepasse = password_hash($motdepasse, PASSWORD_DEFAULT);
                        $registerManager = new adminManager();
                        $register = $registerManager->adminInscription($pseudo, $motdepasse);
                        $php_session->set('stop', 'Votre compte a été créé, un administrateur validera votre compte');
                        $php_session->redirect('/blog/connect');
                    } else {
                        $php_session->set('stop', 'Mot de passe different. Les deux meme mot de passe sont attendus.');
                        $php_session->redirect('/blog/registration');
                    }
                }
                else {
                    $php_session->set('stop', 'Mot de passe incorrect. Une lettre en majuscule, minuscule, un chiffre et caractère speciaux attendu ainsi que 10 caractères minimum.');
                    $php_session->redirect('/blog/registration');
                }
            }
            else {
                $php_session->set('stop', 'Pseudo incorrect. Une lettre en majuscule, minuscule et un chiffre attendu ainsi que 6 caractères minimum.');
                $php_session->redirect('/blog/registration');
            }   
        }
    }
    
    function logout()
    {
        if(session_status() == PHP_SESSION_ACTIVE)
        {
            session_unset();
            session_destroy();
            $php_session = new PHPSession();
            $php_session->set('stop', 'Déconnexion.');
            $php_session->redirect('/blog/connect');
        }
    }

    function adminDelete(){
        $php_session = new PHPSession();
        if (isset($_SESSION['pseudo']) && isset($_GET['id']) && !empty($_GET['id'])) {
            $registerManager = new adminManager();
            $register = $registerManager->deleteUser($_GET['id']);
            $php_session->set('succes', 'Admin supprimé.');
            $php_session->redirect('/blog/admin/', $_SESSION['id']);
        } else {
            $php_session = new PHPSession();
            $php_session->set('stop', 'Vous n\'avez pas acces a cette page.');
            $php_session->redirect('/blog/connect');
        }
    }
}
