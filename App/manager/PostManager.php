<?php
namespace App\manager;

//require('vendor/autoload.php');

require_once('App/manager/Manager.php');
use PDO;
use App\entity\Post;
class PostManager extends Manager
{
    public function showPosts() 
    { 
        $bd = $this->connection();
        $bdposts = $bd->prepare('SELECT id, title, content FROM posts ORDER BY id DESC LIMIT 0, 10');
        $bdposts->execute();
        $posts = [];
        while( ($row = $bdposts->fetch(PDO::FETCH_ASSOC)) !== false)
        {
            
            $post = new Post([
                'id'=>$row['id'],
                'title'=>$row['title'],
                'content'=>$row['content'],
            ]);

            $posts[] = $post;
        }

        return $posts;
    }
    public function showPostsUser($id_utilisateur) 
    { 
        $bd = $this->connection();
        $bdpostsuser = $bd->prepare('SELECT id, title, content FROM posts WHERE id_utilisateur = ? ORDER BY id DESC LIMIT 0, 10');
        $bdpostsuser->execute(array($id_utilisateur));
        $postsuser = [];
        while( ($row = $bdpostsuser->fetch(PDO::FETCH_ASSOC)) !== false)
        {
            $postuser = new Post([
                'id'=>$row['id'],
                'title'=>$row['title'],
                'content'=>$row['content'],
            ]);

            $postsuser[] = $postuser;
        }

        return $postsuser;
    }
    public function showPost($postId)
    {
        $bd = $this->connection();
        $bdpost = $bd->prepare('SELECT id, title, content FROM posts WHERE id = ?');
        $bdpost->execute(array($postId));
        $post = $bdpost->fetch();
        return $post;

    }
    public function createPost($utilisateurId, $title, $content)
    {
        $bd = $this->connection();
        $bdpostadd = $bd->prepare('INSERT INTO posts (id_utilisateur, title, content) VALUES(?, ?, ?)');
        $postadd = $bdpostadd->execute(array($utilisateurId, $title, $content));

        return $postadd;
    }
    public function updatePost($postId, $title, $content)
    {
        $bd = $this->connection();
        $bdpostupdate = $bd->prepare('UPDATE posts SET title = :title, content = :content WHERE id = :id');
        $bdpostupdate->bindValue(':id', $postId, PDO::PARAM_STR);
        $bdpostupdate->bindValue(':title', $title, PDO::PARAM_STR);
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