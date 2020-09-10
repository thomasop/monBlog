<?php

namespace App\manager;

use PDO;
use App\entity\Post;

class PostManager extends Manager
{
    public function showPosts()
    { 
        $bd = $this->connection();
        $bdposts = $bd->prepare('SELECT id, title, chapo, content, DATE_FORMAT(date_modif, \'%d/%m/%Y %Hh%imin\') AS date_modif FROM posts ORDER BY id DESC LIMIT 0, 10');
        $bdposts->execute();
        $posts = [];
        while (($row = $bdposts->fetch(PDO::FETCH_ASSOC)) !== false) {
            $post = new Post([
                'id'=>$row['id'],
                'title'=>$row['title'],
                'chapo'=>$row['chapo'],
                'content'=>$row['content'],
                'date_modif'=>$row['date_modif']
            ]);

            $posts[] = $post;
        }
        return $posts;
    }
    public function showPostsUser($id_utilisateur)
    { 
        $bd = $this->connection();
        $bdpostsuser = $bd->prepare('SELECT id, id_utilisateur, title, chapo, content, DATE_FORMAT(date_modif, \'%d/%m/%Y %Hh%imin\') AS date_modif FROM posts WHERE id_utilisateur = ? ORDER BY id DESC LIMIT 0, 10');
        $bdpostsuser->execute(array($id_utilisateur));
        $postsuser = [];
        while (($row = $bdpostsuser->fetch(PDO::FETCH_ASSOC)) !== false) {
            $postuser = new Post([
                'id'=>$row['id'],
                'id_utilisateur'=>$row['id_utilisateur'],
                'title'=>$row['title'],
                'chapo'=>$row['chapo'],
                'content'=>$row['content'],
                'date_modif'=>$row['date_modif']
            ]);

            $postsuser[] = $postuser;
        }
        return $postsuser;
    }
    public function showPost($postId)
    {
        $bd = $this->connection();
        $bdpost = $bd->prepare('SELECT id, id_utilisateur, title, chapo, content FROM posts WHERE id = ?');
        $bdpost->execute(array($postId));
        $post = $bdpost->fetch();
        return $post;
    }

    public function countPosts()
    {
        $bd = $this->connection();
        $bdcountpost = $bd->prepare('SELECT COUNT(*) FROM posts');
        $bdcountpost->execute();
        $post = $bdcountpost->fetch();
        $stringsolo = array_unique($post);
        $string = implode("",$stringsolo);
        return $string;
    }

    public function showPostUser($utilisateurId)
    {
        $bd = $this->connection();
        $bdpost = $bd->prepare('SELECT id, id_utilisateur,  title, content FROM posts WHERE id = ?');
        $bdpost->execute(array($utilisateurId));
        $post = $bdpost->fetch();
        return $post;
    }
    public function createPost($utilisateurId, $title, $chapo, $content)
    {
        $bd = $this->connection();
        $bdpostadd = $bd->prepare('INSERT INTO posts (id_utilisateur, title, chapo, content) VALUES(?, ?, ?, ?)');
        $postadd = $bdpostadd->execute(array($utilisateurId, $title, $chapo, $content));
        return $postadd;
    }
    public function updatePost($postId, $title, $chapo, $content)
    {
        $bd = $this->connection();
        $bdpostupdate = $bd->prepare('UPDATE posts SET title = :title, chapo = :chapo, content = :content WHERE id = :id');
        $bdpostupdate->bindValue(':id', $postId, PDO::PARAM_STR);
        $bdpostupdate->bindValue(':title', $title, PDO::PARAM_STR);
        $bdpostupdate->bindValue(':chapo', $chapo, PDO::PARAM_STR);
        $bdpostupdate->bindValue(':content', $content, PDO::PARAM_STR);
        $bdpostupdate->execute();
        return $bdpostupdate;
    }
    
    public function deletePost($postId)
    {
        $bd = $this->connection();
        $bdpostdelete = $bd->prepare('DELETE FROM posts WHERE id=?');
        $bdpostdelete->execute(array($postId));
    }
}