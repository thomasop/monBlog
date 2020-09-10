<?php
namespace App\entity;
class Comment
{
  private $_id;
  private $author;
  private $comment;
  private $post_id;
  


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
  
  public function author()
  {
    return $this->_author;
  }
  
  public function comment()
  {
    return $this->_comment;
  }
  public function post_id(){
      return $this->_post_id;
  }
 
  
  
  
  // Liste des setters
  public function setId($id)
  {
   $this->_id = $id;
    
  }

  public function setauthor($author)
  {
    
    if (is_string($author) && $author < 50)
    {
      
      $this->_author = $author;
    }
  }
  
  public function setcomment($comment)
  {
    
    if (is_string($comment))
    {
      $this->_comment = $comment;
    }
 }
  public function setpostId($post_id)
  {
    
    if (is_int($post_id))
    {
      $this->_post_id = $post_id;
    }
  }
  
}
 