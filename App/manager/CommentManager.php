<?php
namespace App\manager;

use PDO;
use App\entity\Comment;

class CommentManager extends Manager
{
    public function showComments($postId)
    {
        $bd = $this->connection();
        $bdcommentsvalid = $bd->prepare('SELECT id_comment, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y %Hh%imin\') AS comment_date FROM comments WHERE post_id = ? AND valid = 1 ORDER BY id_comment DESC');
        $bdcommentsvalid->execute(array($postId));
        $commentsvalid = [];
        while (($raw = $bdcommentsvalid->fetch(PDO::FETCH_ASSOC)) !== false) {
            $commentvalid = new Comment([
                'id'=>$raw['id_comment'],
                'author'=>$raw['author'],
                'comment'=>$raw['comment'],
                'comment_date'=>$raw['comment_date']
            ]);

            $commentsvalid[] = $commentvalid;
        }
        return $commentsvalid;
    }
    public function showComment($id)
    {
        $bd = $this->connection();
        $bdcomment = $bd->prepare('SELECT id_comment, post_id, author, comment FROM comments WHERE id_comment = ? AND valid = 1');
        $bdcomment->execute(array($id));
        $comment = $bdcomment->fetch();
        return $comment;
    }

    public function showCommentsNotValid($postId)
    {
        $bd = $this->connection();
        $bdcomments = $bd->prepare('SELECT id_comment, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y %Hh%imin\') AS comment_date FROM comments WHERE post_id = ? AND valid IS NULL ORDER BY id_comment DESC');
        $bdcomments->execute(array($postId));
        $comments = [];
        while (($rew = $bdcomments->fetch(PDO::FETCH_ASSOC)) !== false) {
            $comment = new Comment([
                'id'=>$rew['id_comment'],
                'author'=>$rew['author'],
                'comment'=>$rew['comment'],
                'comment_date'=>$rew['comment_date']
            ]);

            $comments[] = $comment;
        }
        return $comments;
    }
    public function createComment($postId, $author, $comment)
    {
        $bd = $this->connection();
        $bdcommentadd = $bd->prepare('INSERT INTO comments(post_id, author, comment, comment_date) VALUES(?, ?, ?, NOW())');
        $commentadd = $bdcommentadd->execute(array($postId, $author, $comment));
        return $commentadd;
    }
    public function updateComment($id, $author, $comment)
    {
        $bd = $this->connection();
        $bdcommentupdate = $bd->prepare('UPDATE comments SET author = :author, comment = :comment WHERE id_comment = :id_comment');
        $bdcommentupdate->bindValue(':id_comment', $id, PDO::PARAM_STR);
        $bdcommentupdate->bindValue(':author', $author, PDO::PARAM_STR);
        $bdcommentupdate->bindValue(':comment', $comment, PDO::PARAM_STR);
        $bdcommentupdate->execute();
        return $bdcommentupdate;
    }
    public function updateCommentValid($id)
    {
        $bd = $this->connection();
        $bdcommentvalidupdate = $bd->prepare('UPDATE comments SET valid = 1 WHERE id_comment = ?');
        $bdcommentvalidupdate->execute(array($id));
        return $bdcommentvalidupdate;
    }
    public function deleteComment(int $id)
    {
        $bd = $this->connection();
        $bdcommentdelete = $bd->prepare('DELETE FROM comments WHERE id_comment= ?');
        $bdcommentdelete->execute(array($id));
        return $bdcommentdelete;
    }
}