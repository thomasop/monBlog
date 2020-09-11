<?php

namespace App\entity;

class Comment
{
    private $id_comment;
    private $author;
    private $comment;
    private $post_id;
    private $comment_date;
  
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

    public function id_comment()
    {
        return $this->id_comment;
    }
  
    public function author()
    {
        return $this->author;
    }
    
    public function comment()
    {
        return $this->comment;
    }

    public function post_id(){
        return $this->post_id;
    }

    public function comment_date()
    {
        return $this->comment_date;
    }
  
    public function setId($id_comment)
    {
        $this->id_comment = $id_comment; 
    }

    public function setAuthor($author)
    {
        if (is_string($author) && $author < 50) {
            $this->author = $author;
        }
    }
    
    public function setComment($comment)
    {
        if (is_string($comment)) {
            $this->comment = $comment;
        }
    }

    public function setPostid($post_id)
    {
        if (is_int($post_id)) {
            $this->post_id = $post_id;
        }
    }

    public function setComment_date($comment_date)
    {
        $this->comment_date = $comment_date;
    }
}
 