<?php

namespace App\controller;

use PDO;
use App\manager\CommentManager;
use App\manager\PostManager;
use App\tool\MonException;
use App\tool\PHPSession;

class ControllerComment extends Controller
{
    
    function commentAdd($postId, $author, $comment)
    {
        $postid = trim($postId);
        $commentManager = new CommentManager();
        $affectedLines = $commentManager->createComment($postId, $author, $comment);
            if ($affectedLines === false) {
                throw new Exception('Impossible d\'ajouter le commentaire !');
            } elseif (!empty($_POST)) {
                $php_session = new PHPSession();
                $php_session->set('succes', 'Commentaire ajouté, un administrateur le validera.');
                $php_session->redirect('/blog/comment/', $postid); 
            }
    }

    function commentDelete()
    {
        if (isset($_SESSION['pseudo']) && isset($_GET['id']) && !empty($_GET['id'])) {
            $commentDeleteController = new CommentManager();
            $commentDeleteView = $commentDeleteController->deleteComment($_GET['id']);
            $php_session = new PHPSession();
            $php_session->set('succes', 'Commentaire supprimé.');
            $php_session->redirect('/blog/postsmanager/', $_SESSION['id']);
        }
        else {
            $php_session = new PHPSession();
            $php_session->set('stop', 'Vous n\'avez pas acces a cette page.');
            $php_session->redirect('/blog/connect');
        }
    } 

    function commentUpdate($author, $comment)
    {
        if (!isset($_SESSION['pseudo'])) {
            $this->phpSession()->set('stop', 'Vous n\'avez pas acces a cette page.');
            $this->phpSession()->redirect('/blog/connect');
        }
        else {
            $this->comment()->updateComment($_GET['id'], $author, $comment);
            $this->phpSession()->set('succes', 'Commentaire modifié.');
            $this->phpSession()->redirect('/blog/postsmanager/', $_SESSION['id']);
        }
    }
    
    function commentUpdateForm()
    {
        if (!isset($_SESSION['pseudo'])) {
            $this->phpSession()->set('stop', 'Vous n\'avez pas acces a cette page.');
            $this->phpSession()->redirect('/blog/connect');
        }
        else {
            $formCommentViews = $this->comment()->showComment($_GET['id']);
            $twigview = $this->getTwig();
            $tpl = $twigview->load('Backend/managerupdatecomment.twig');
            echo $tpl->render(array('formCommentViews' => $formCommentViews));
        }
    }

    function commentUpdateValid()
    {
        if (!isset($_SESSION['pseudo'])) {
            $this->phpSession()->set('stop', 'Vous n\'avez pas acces a cette page.');
            $this->phpSession()->redirect('/blog/connect');
        } else {
            $this->comment()->updateCommentValid($_GET['id']);
            $this->phpSession()->set('succes', 'Commentaire validé.');
            $this->phpSession()->redirect('/blog/postsmanager/', $_SESSION['id']);
        }
    }
}