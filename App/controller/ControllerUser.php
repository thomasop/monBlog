<?php
namespace App\controller;
use PDO;
use App\manager\AdminManager;
use App\manager\PostManager;
use App\manager\CommentManager;
class ControllerUser {
     function admin(){ 
        $twigController = new \App\tool\Twig();
        $twigView = $twigController->getTwig();
        $tpl = $twigView->load('Frontend/connexion.twig');
        echo $tpl->render();
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
        //var_dump($validAdminUpdate->updateAdminValid($_GET['id']));
        $validAdminView = $validAdminUpdate->updateAdminValid($_GET['id']);
        
        echo "<script>alert(\"Compte validé.\");
        document.location.href = '/blog/admin'</script>";
    }
    
    function connect($pseudo, $motdepasse)
    {
        //$pseudo = $_POST['pseudo'];
        //$motdepasse = $_POST['motdepasse'];
        //var_dump($pseudo);
        //var_dump($motdepasse);
        //require_once('Views/Backend/pageAdmin.twig');
        
        $loginManager = new adminManager();
        $login = $loginManager->adminOk($pseudo, $motdepasse);
     
        
       $user = $login->fetch(PDO::FETCH_OBJ);
     //var_dump($user);
       if (!$user) { 
           
           
           
           "<script>alert(\"Pseudo incorrect\");
           document.location.href = 'index.php?action=admin'</script>";
       }
       
       else { 
           
           
           $mdp = $user->motdepasse;
           $validPassword = password_verify($_POST['motdepasse'], $mdp);
           //var_dump($mdp);
           if($validPassword){
            $_SESSION['pseudo'] = $_POST['pseudo'];
           $twigController = new \App\tool\Twig();
                $twigView = $twigController->getTwig();
                $tpl = $twigView->load('Backend/pageAdmin.twig');
                echo $tpl->render(array('user' => $user));
       }}
       
           /*
           if(isset($_SESSION['token']) && isset($_POST['token']) && $validPassword){
                
                //require ('Views/pageAdmin.php');
                $_SESSION['pseudo'] = $_POST['pseudo'];
                if($_SESSION['token'] == $_POST['token']){
                //var_dump($_SESSION['token']);
                $twigController = new \App\tool\Twig();
                $twigView = $twigController->getTwig();
                $tpl = $twigView->load('Backend/pageAdmin.twig');
                echo $tpl->render(array('user' => $user));
                
               }
           }
           else{
            
               echo "<script>alert(\"Mot de passe incorrect\");
               document.location.href = 'index.php?action=admin'</script>";
               
           }
       }
    */
}
       function register($pseudo, $motdepasse){
           $motdepasse = password_hash($motdepasse, PASSWORD_DEFAULT);
            $registerManager = new adminManager();
            $register = $registerManager->adminInscription($pseudo, $motdepasse);
            //echo "Votre compte a été créé, vous pouvez maintenant vous connecter!";
            echo "<script>alert(\"Votre compte a été créé, un administrateur validera votre compte.\");
           document.location.href = '/blog/connect'</script>";
            //header('location: index.php?r=admin');
            
            }
       }
