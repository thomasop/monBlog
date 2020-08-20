<?php
namespace App\manager;
 
use PDO;
class Manager
{ 
    protected $bd;

    const DBHOST = 'mysql:host=localhost;dbname=mon_blog;charset=utf8';
    const DBUSER = 'root';
    const DBPASS = 'root';

 
    public static function connection() 
    { 
        try{
            $bd = new PDO(self::DBHOST, self::DBUSER, self::DBPASS);
            $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $bd;
        }
        catch(Exeption $errorconnection){
            echo 'Connexion échouée' . $errorconnection->getMessage();
        }
    }
}
