<?php
namespace App\Entity;
class Admin
{
  private $_id;
  private $_pseudo;
  private $_motdepasse;
  private $_email;
  //private $_role;


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
  public function pseudo()
  {
    return $this->_pseudo;
  }
  
  public function motdepasse()
  {
    return $this->_motdepasse;
  }
  public function email(){
      return $this->_email;
  }
  public function role(){
    return $this->_role;
}
  
  
  
  
  // Liste des setters
  public function setId($_id)
  {
   $this->_id = $_id;
    
  }
  public function setPseudo($pseudo)
  {
    
    if (is_string($pseudo) && $pseudo < 50)
    {
      
      $this->_pseudo = $pseudo;
    }
  }
  
  public function setMotdepasse($motdepasse)
  {
    
    if (is_string($motdepasse))
    {
      $this->_motdepasse = $motdepasse;
    }
 }
  public function setEmail($email)
  {
    
    if (is_string($email))
    {
      $this->_email = $email;
    }
  }
  public function setRole($role)
  {
    
    if (is_bool($role))
    {
      $this->_role = $role;
    }
  }
}
 