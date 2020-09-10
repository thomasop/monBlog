<?php

namespace App\entity;

class Post
{
    private $id;
    private $title;
    private $chapo;
    private $content;
    private $date_modif;
  
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

    public function title()
    {
        return $this->title;
    }
    
    public function chapo()
    {
        return $this->chapo;
    }

    public function content()
    {
        return $this->content;
    }
    public function date_modif()
    {
        return $this->date_modif;
    }
 
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTitle($title)
    {
        if (is_string($title) && $title < 50) {
            $this->title = $title;
        }
    }
    
    public function setChapo($chapo)
    {
        if (is_string($chapo) && $chapo < 101) {
            $this->chapo = $chapo;
        }
    }
    public function setContent($content)
    {
        if (is_string($content)) {
            $this->content = $content;
        }
    }

    public function setDate_modif($date_modif)
    {
        $this->date_modif = $date_modif;
    }
}
    
  