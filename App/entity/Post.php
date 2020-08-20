<?php
namespace App\entity;
class Post
{
  private $_id;
  private $_title;
  private $_content;
  private $_date;
  


public function __construct($donnees) {
    if(is_array($donnees))
    {
        $this->hydrate($donnees);
    }
}

  
public function hydrate(array $donnees) {
    
    foreach ($donnees as $key => $value) {
        
        $method = 'set'.ucfirst($key);
        if (method_exists($this, $method)) {
            $this->$method($value);
        }
    }
}
  // Liste des getters
  public function id()
  {
    return $this->_id;
  }

  public function title()
  {
    return $this->_title;
  }
  
  public function content()
  {
    return $this->_content;
  }
  public function date(){
      return $this->_date;
  }
 
  
  
  
  
  // Liste des setters
  
  public function setId($_id)
  {
   $this->_id = $_id;
    
  }

  public function setTitle($_title)
  {
    
    if (is_string($_title) && $_title < 50)
    {
      
      $this->_title = $_title;
    }
  }
  
  public function setContent($_content)
  {
    
    if (is_string($_content))
    {
      $this->_content = $_content;
    }
 }
  public function setDate($_date)
  {
    
    if (is_int($_date))
    {
      $this->_date = $_date;
    }
  }
}
  
 