<?php
namespace App\manager;
require_once('App/manager/Manager.php');
use PDO;

use App\entity\admin;
class AdminManager extends Manager
{
        private $pseudo;
        private $motdepasse;
      
    public function adminOk($pseudo, $motdepasse){
        $bd = $this->connection();
        $bdconnect = $bd->prepare('SELECT id, motdepasse FROM utilisateur WHERE pseudo = ? AND administrateur = 1');
        $bdconnect->execute(array($pseudo));

        return $bdconnect;  
        }
    public function adminInscription($pseudo, $motdepasse){
        $bd = $this->connection();
        $bdregister = $bd->prepare('INSERT INTO utilisateur(pseudo, motdepasse) VALUES(?, ?)');
        $register = $bdregister->execute(array($pseudo, $motdepasse));
    }
    public function updateAdminValid($id)
    {
        $bd = $this->connection();
        $bdadminupdate = $bd->prepare('UPDATE utilisateur SET administrateur = 1 WHERE id = ?');
        
        $bdadminupdate->execute(array($id));
        return $bdadminupdate;
    }
    public function showAdmins()
    {
        $bd = $this->connection();
        $bdadmins = $bd->prepare('SELECT id, pseudo, motdepasse FROM utilisateur WHERE administrateur is NULL ');
        $bdadmins->execute();
        $admins = [];
        while( ($riw = $bdadmins->fetch(PDO::FETCH_ASSOC)) !== false)
        {
            
            $admin = new Admin([
                'id'=>$riw['id'],
                'pseudo'=>$riw['pseudo'],
                'motdepasse'=>$riw['motdepasse'],
            ]);

            $admins[] = $admin;
        }

        return $admins;
    }
    public function showAdmin($utilisateurId)
    {
        $bd = $this->connection();
        $bdadmin = $bd->prepare('SELECT id, pseudo FROM utilisateur WHERE id = ?');
        $bdadmin->execute(array($utilisateurId));
        $admin = $bdadmin->fetch();
        return $admin;
    }
}