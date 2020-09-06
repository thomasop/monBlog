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
                throw new MonException('Impossible d\'ajouter le commentaire !');
            } elseif (!empty($_POST)) {
                $php_session = new PHPSession();
                $php_session->set('succes', 'Commentaire ajouté, un administrateur le validera.');
                $php_session->redirect('/blog/comment/', $postid); 
            }
        
    }

    function commentDelete()
    {
        if (isset($_SESSION['pseudo'])) {
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
        if (isset($_SESSION['pseudo'])) {
            $commentUpdateController = new CommentManager();
            $commentUpdateView = $commentUpdateController->updateComment($_GET['id'], $author, $comment);
            $php_session = new PHPSession();
            $php_session->set('succes', 'Commentaire modifié.');
            $php_session->redirect('/blog/postsmanager/', $_SESSION['id']);
        }
        else {
            $php_session = new PHPSession();
            $php_session->set('stop', 'Vous n\'avez pas acces a cette page.');
            $php_session->redirect('/blog/connect');
        }
    }
    
    function commentUpdateForm()
    {
        if (isset($_SESSION['pseudo'])) {
            $formcommentupdate = new CommentManager();
            $formCommentViews = $formcommentupdate->showComment($_GET['id']);
            $twigview = $this->getTwig();
            $tpl = $twigview->load('Backend/managerupdatecomment.twig');
            echo $tpl->render(array('formCommentViews' => $formCommentViews));
        }
        else {
            $php_session = new PHPSession();
            $php_session->set('stop', 'Vous n\'avez pas acces a cette page.');
            $php_session->redirect('/blog/connect');
        }
    }

    function commentUpdateValid()
    {
        if (isset($_SESSION['pseudo'])) {
            $validCommentUpdate = new CommentManager();
            $validCommentView = $validCommentUpdate->updateCommentValid($_GET['id']);
            $php_session = new PHPSession();
            $php_session->set('succes', 'Commentaire validé.');
            $php_session->redirect('/blog/postsmanager/', $_SESSION['id']);
        } else {
            $php_session = new PHPSession();
            $php_session->set('stop', 'Vous n\'avez pas acces a cette page.');
            $php_session->redirect('/blog/connect');
        }
    }
}