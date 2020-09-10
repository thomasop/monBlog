<?php
namespace App\manager;

use PDO;
use App\entity\admin;

class AdminManager extends Manager
{
    private $pseudo;
    private $motdepasse;
      
    public function adminOk($pseudo, $motdepasse)
    {
        $bd = $this->connection();
        $bdconnect = $bd->prepare('SELECT id, motdepasse FROM administrateur WHERE pseudo = ? AND statut = 1');
        $bdconnect->execute(array($pseudo));
        return $bdconnect;  
    }

    public function adminInscription($pseudo, $motdepasse)
    {
        $bd = $this->connection();
        $bdregister = $bd->prepare('INSERT INTO administrateur(pseudo, motdepasse) VALUES(?, ?)');
        $register = $bdregister->execute(array($pseudo, $motdepasse));
        return $register;
    }

    public function updateAdminValid($id)
    {
        $bd = $this->connection();
        $bdadminupdate = $bd->prepare('UPDATE administrateur SET statut = 1 WHERE id = ?');
        $bdadminupdate->execute(array($id));
        return $bdadminupdate;
    }

    public function showAdmins()
    {
        $bd = $this->connection();
        $bdadmins = $bd->prepare('SELECT id, pseudo, motdepasse FROM administrateur WHERE statut is NULL ');
        $bdadmins->execute();
        $admins = [];
        while (($riw = $bdadmins->fetch(PDO::FETCH_ASSOC)) !== false) {
            $admin = new Admin([
                'id'=>$riw['id'],
                'pseudo'=>$riw['pseudo'],
                'motdepasse'=>$riw['motdepasse'],
            ]);

            $admins[] = $admin;
        }
        return $admins;
    }

    public function showAdminsValid()
    {
        $bd = $this->connection();
        $bdadmins = $bd->prepare('SELECT id, pseudo, motdepasse FROM administrateur WHERE statut = 1 ');
        $bdadmins->execute();
        $admins = [];
        while (($riw = $bdadmins->fetch(PDO::FETCH_ASSOC)) !== false) {
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
        $bdadmin = $bd->prepare('SELECT id, pseudo FROM administrateur WHERE id = ?');
        $bdadmin->execute(array($utilisateurId));
        $admin = $bdadmin->fetch();
        return $admin;
    }
    public function deleteUser($utilisateurId)
    {
        $bd = $this->connection();
        $bduserdelete = $bd->prepare('DELETE FROM administrateur WHERE id=?');
        $bduserdelete->execute(array($utilisateurId));
    }
}