<?php

namespace App\controller;

use PDO;
use App\manager\AdminManager;

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
            $this->phpSession()->set('stop', 'Vous n\'avez pas acces a cette page.');
            $this->phpSession()->redirect('/blog/connect');
        }
    }

    function adminUpdateValid()
    {
        if (isset($_SESSION['pseudo']) && isset($_GET['id']) && !empty($_GET['id'])) {
            $adminmanager = new AdminManager();
            $validAdminView = $adminmanager->updateAdminValid($_GET['id']);
            $this->phpSession()->set('succes', 'Adminnistrateur validé.');
            $this->phpSession()->redirect('/blog/admin/', $_SESSION['id']);
        }
        else {
            $this->phpSession()->set('stop', 'Vous n\'avez pas acces a cette page.');
            $this->phpSession()->redirect('/blog/connect');
        }
    }
    
    function connect($pseudo, $motdepasse)
    {
        $loginmanager = new adminManager();
        $login = $loginmanager->adminOk($pseudo, $motdepasse);
        $user = $login->fetch(PDO::FETCH_OBJ);
        if (!empty($_POST['motdepasse']) && !empty($_POST['pseudo'])) {
            if (!$user) { 
                $this->phpSession()->set('stop', 'Pseudo ou mot de passe incorrect.');
                $this->phpSession()->redirect('/blog/connect');
                
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
                            $this->phpSession()->set('stop', 'Problème d\'authentification.');
                            $this->phpSession()->redirect('/blog/connect');
                        }
                    } else {
                        $this->phpSession()->set('stop', 'Problème d\'authentification.');
                        $this->phpSession()->redirect('/blog/connect'); 
                    }
                } else {
                    $this->phpSession()->set('stop', 'Pseudo ou mot de passe incorrect.');
                    $this->phpSession()->redirect('/blog/connect');
                }
            }
        }  
    }

    function register($pseudo, $motdepasse)
    {
        if (!empty($_POST['motdepasse']) && !empty($_POST['pseudo']) && !empty($_POST['motdepasseconfirmer'])) {
            if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{6,}$#', $_POST['pseudo'])){
                if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{10,}$#', $_POST['motdepasse'])){
                    if ($_POST['motdepasse'] == $_POST['motdepasseconfirmer']) {
                        $motdepasse = password_hash($motdepasse, PASSWORD_DEFAULT);
                        $registerManager = new adminManager();
                        $register = $registerManager->adminInscription($pseudo, $motdepasse);
                        $this->phpSession()->set('stop', 'Votre compte a été créé, un administrateur validera votre compte');
                        $this->phpSession()->redirect('/blog/connect');
                    } else {
                        $this->phpSession()->set('stop', 'Mot de passe different. Les deux meme mot de passe sont attendus.');
                        $this->phpSession()->redirect('/blog/registration');
                    }
                }
                else {
                    $this->phpSession()->set('stop', 'Mot de passe incorrect. Une lettre en majuscule, minuscule, un chiffre et caractère speciaux attendu ainsi que 10 caractères minimum.');
                    $this->phpSession()->redirect('/blog/registration');
                }
            }
            else {
                $this->phpSession()->set('stop', 'Pseudo incorrect. Une lettre en majuscule, minuscule et un chiffre attendu ainsi que 6 caractères minimum.');
                $this->phpSession()->redirect('/blog/registration');
            }   
        }
    }
    
    function logout()
    {
        if(session_status() == PHP_SESSION_ACTIVE)
        {
            session_unset();
            session_destroy();
            $this->phpSession()->set('stop', 'Déconnexion.');
            $this->phpSession()->redirect('/blog/connect');
        }
    }

    function adminDelete(){
        if (!isset($_SESSION['pseudo'])) {
            $this->phpSession()->set('stop', 'Vous n\'avez pas acces a cette page.');
            $this->phpSession()->redirect('/blog/connect');
        } else {
            $register = $this->admin()->deleteUser($_GET['id']);
            $this->phpSession()->set('succes', 'Admin supprimé.');
            $this->phpSession()->redirect('/blog/admin/', $_SESSION['id']);
        }
    }
}
