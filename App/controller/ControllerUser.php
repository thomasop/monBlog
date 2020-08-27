<?php
namespace App\controller;
use PDO;
use App\manager\AdminManager;
use App\manager\PostManager;
use App\manager\CommentManager;
class ControllerUser {
     function admin(){ 
        $token = md5(bin2hex(openssl_random_pseudo_bytes(6)));
        $_SESSION['token'] = $token;
        $twigController = new \App\tool\Twig();
        $twigView = $twigController->getTwig();
        $tpl = $twigView->load('Frontend/connexion.twig');
        echo $tpl->render(array('token' => $token));
    }
    function registration(){
    
        $twigController = new \App\tool\Twig();
        $twigView = $twigController->getTwig();
        $tpl = $twigView->load('Frontend/inscription.twig');
        echo $tpl->render();
    }
    function adminShows(){
        
        $loginManager = new AdminManager();
        $loginvalid = $loginManager->showAdmins();
        $twigController = new \App\tool\Twig();
        $twigView = $twigController->getTwig();
        $tpl = $twigView->load('Backend/adminValid.twig');
        echo $tpl->render(array('loginvalid' => $loginvalid));
        
    }
    function adminUpdateValid(){
        
        $validAdminUpdate = new AdminManager();
        $validAdminView = $validAdminUpdate->updateAdminValid($_GET['id']);
        
        echo "<script>alert(\"Compte validé.\");
        document.location.href = '/blog/admin'</script>";
    }
    
    function connect($pseudo, $motdepasse)
    {
        
        
        $loginManager = new adminManager();
        $login = $loginManager->adminOk($pseudo, $motdepasse);
     
        
       $user = $login->fetch(PDO::FETCH_OBJ);
     
       if (!$user) { 
           
           
           
           "<script>alert(\"Pseudo incorrect\");
           document.location.href = 'index.php?action=admin'</script>";
       }
       
       else { 
           
           
           $mdp = $user->motdepasse;
           $validPassword = password_verify($_POST['motdepasse'], $mdp);
           
           if($validPassword && isset($_SESSION['token']) && isset($_POST['token'])){
            $_SESSION['pseudo'] = $_POST['pseudo'];
            $_SESSION['motdepasse'] = $_POST['motdepasse'];
            $_SESSION['id'] = $user->id;
           
            
           if(isset($_COOKIE['ticket']) && isset($_SESSION['ticket'])){
            if($_COOKIE['ticket'] == $_SESSION['ticket'] && $_POST['token'] == $_SESSION['token']){
           $twigController = new \App\tool\Twig();
                $twigView = $twigController->getTwig();
                $tpl = $twigView->load('Backend/pageAdmin.twig');
                echo $tpl->render(array('user' => $user));
       }}}
      
       
}
       function register($pseudo, $motdepasse){
           $motdepasse = password_hash($motdepasse, PASSWORD_DEFAULT);
            $registerManager = new adminManager();
            $register = $registerManager->adminInscription($pseudo, $motdepasse);
            
            echo "<script>alert(\"Votre compte a été créé, un administrateur validera votre compte.\");
           document.location.href = '/blog/connect'</script>";
           
            
            }
       }
    }