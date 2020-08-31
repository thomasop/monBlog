<?php
namespace App\manager;
 
use PDO;

class Manager
{ 
    protected $bd;

    const DB_HOST = 'mysql:host=localhost;dbname=mon_blog;charset=utf8';
    const DB_USER = 'root';
    const DB_PASS = 'root';

    public static function connection()
    { 
        try {
            $bd = new PDO(self::DB_HOST, self::DB_USER, self::DB_PASS);
            $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $bd;
        }
        catch(Exeption $errorconnection) {
            echo 'Connexion échouée' . $errorconnection->getMessage();
        }
    }
}
