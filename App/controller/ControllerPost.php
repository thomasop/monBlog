<?php

namespace App\controller;

use App\manager\PostManager;
use App\manager\CommentManager;
use App\manager\AdminManager;
use App\tool\PHPSession;


class ControllerPost extends Controller
{
        
    function postView()
    {   
        
            $postmanager = new PostManager();
            $commentsmanager = new CommentManager();
            $postview = $postmanager->showPost($_GET['id']);
            $commentsview = $commentsmanager->showComments($_GET['id']);
            $twigview = $this->getTwig();
            $twigpostview = $twigview->load('Frontend/comment.twig');
            echo $twigpostview->render(array('postview' => $postview,
                                    'commentsview' => $commentsview));    
    }

    function postsView()
    {

        $postsmanager = new PostManager();
        $postsview = $postsmanager->showPosts();
        $postscountview = $postsmanager->countPosts();
        $parpage = 5;
        $page = ceil($postscountview / $parpage);
        $twigview = $this->getTwig();
        $twigpostsview = $twigview->load('Frontend/posts.twig');
        echo $twigpostsview->render(array('postsview' => $postsview,
                                        'postscountview' => $postscountview));
    }

    function postsManager()
    {
        if (isset($_SESSION['pseudo'])) {
            $postsmanager = new PostManager();
            $postsadminview = $postsmanager->showPostsUser($_GET['id']);
            $twigview = $this->getTwig();
            $twigpostsmanager = $twigview->load('Backend/managerposts.twig');
            echo $twigpostsmanager->render(array('postsadminview' => $postsadminview));
        }
        else {
            $php_session = new PHPSession();
            $php_session->set('stop', 'Vous n\'avez pas acces a cette page.');
            $php_session->redirect('/blog/connect');
        }
    }

    function postFormUpdate()
    {
        if (isset($_SESSION['pseudo'])) {
            $postmanager = new PostManager();
            $postformview = $postmanager->showPost($_GET['id']);
            $twigview = $this->getTwig();
            $twigpostformupdate = $twigview->load('Backend/managerupdatepost.twig');
            echo $twigpostformupdate->render(array('postformview' => $postformview));
        }
        else {
            $php_session = new PHPSession();
            $php_session->set('stop', 'Vous n\'avez pas acces a cette page.');
            $php_session->redirect('/blog/connect');
        }
        
    }

    function postUpdate($title, $chapo, $content)
    {
        if (isset($_SESSION['pseudo'])) {
            $postmanager = new PostManager();
            $updatepostview = $postmanager->updatePost($_GET['id'], $title, $chapo, $content);
            $php_session = new PHPSession();
            $php_session->set('succes', 'Post modifié.');
            $php_session->redirect('/blog/postsmanager/', $_SESSION['id']);
        }
        else {
            $php_session = new PHPSession();
            $php_session->set('stop', 'Vous n\'avez pas acces a cette page.');
            $php_session->redirect('/blog/connect');
        }
    }

    function postCreate()
    {
        if (isset($_SESSION['pseudo'])) {
            $postmanager = new PostManager();
            $adminmanager = new AdminManager();
            $adminview = $adminmanager->showAdmin($_GET['id']);
            $twigview = $this->getTwig();
            $twigpostcreate = $twigview->load('Backend/managercreatepost.twig');
            echo $twigpostcreate->render();
        }
        else {
            $php_session = new PHPSession();
            $php_session->set('stop', 'Vous n\'avez pas acces a cette page.');
            $php_session->redirect('/blog/connect');
        }
    }

    function postAdd($utilisateurId, $title, $chapo, $content)
    {
        if (isset($_SESSION['pseudo'])) {
            $postmanager = new PostManager();
            $adminmanager = new AdminManager();
            $postaddview = $postmanager->createPost($utilisateurId, $title, $chapo, $content);

            if ($postaddview === false) {
                throw new MonException('Impossible d\'ajouter le post !');
            } elseif (!empty($_POST)) {
                $php_session = new PHPSession();
                $php_session->set('succes', 'Post ajouté.');
                $php_session->redirect('/blog/postsmanager/', $_SESSION['id']);
            }
        }
    }

    function postDelete()
    {
        if (isset($_SESSION['pseudo'])) {
            $postmanager = new PostManager();
            $postdeleteview = $postmanager->deletePost($_GET['id']);
            $postsadminview = $postmanager->showPosts();
            $php_session = new PHPSession();
            $php_session->set('succes', 'Post supprimé.');
            $php_session->redirect('/blog/postsmanager/', $_SESSION['id']);
        }
        else {
            $php_session = new PHPSession();
            $php_session->set('stop', 'Vous n\'avez pas acces a cette page.');
            $php_session->redirect('/blog/connect');
        }
    }

    function postManager()
    {
        if (isset($_SESSION['pseudo'])) {
            $postmanager = new PostManager();
            $commentmanager = new CommentManager();
            $postAdminView = $postmanager->showPost($_GET['id']);
            $commentsNotvalidView = $commentmanager->showCommentsNotValid($_GET['id']);
            $twigview = $this->getTwig();
            $twigpostmanager = $twigview->load('Backend/managercomment.twig');
            echo $twigpostmanager->render(array('postsAdminView' => $postAdminView, 'commentsNotvalidView' => $commentsNotvalidView));
        }
        else {
            $php_session = new PHPSession();
            $php_session->set('stop', 'Vous n\'avez pas acces a cette page.');
            $php_session->redirect('/blog/connect');
        }
    }

    function commentManager()
    {
        if (isset($_SESSION['pseudo'])) {
            $postmanager = new PostManager();
            $commentmanager = new CommentManager();
            $postCommentAdminView = $postmanager->showPost($_GET['id']);
            $commentView = $commentmanager->showComments($_GET['id']);
            $twigview = $this->getTwig();
            $twigcommentmanager = $twigview->load('Backend/managercommentvalid.twig');
            echo $twigcommentmanager->render(array('postCommentAdminView' => $postCommentAdminView, 'commentView' => $commentView));
             
        }
        else {
            $php_session = new PHPSession();
            $php_session->set('stop', 'Vous n\'avez pas acces a cette page.');
            $php_session->redirect('/blog/connect');
        }
    }      
}