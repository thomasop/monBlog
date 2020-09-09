<?php

namespace App\Entity;

class Admin
{
    private $id;
    private $pseudo;
    private $motdepasse;

    public function __construct($donnees)
    {
        if (is_array($donnees)) {
            $this->hydrate($donnees);
        }
    }

    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value) {
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    public function id()
    {
        return $this->id;
    }

    public function pseudo()
    {
        return $this->pseudo;
    }
    
    public function motdepasse()
    {
        return $this->motdepasse;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setPseudo($pseudo)
    {
        if (is_string($pseudo) && $pseudo < 50) {
            $this->pseudo = $pseudo;
        }
    }
    
    public function setMotdepasse($motdepasse)
    {
        if (is_string($motdepasse)) {
            $this->motdepasse = $motdepasse;
        }
    }
}
 