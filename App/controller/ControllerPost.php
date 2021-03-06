<?php

namespace App\controller;

use App\manager\PostManager;
use App\manager\CommentManager;
use App\manager\AdminManager;
use App\tool\Paging;

class ControllerPost extends Controller
{
        
    function postView()
    {   
        if ( isset($_GET['id']) && !empty($_GET['id'])){
            $postmanager = new PostManager();
            $commentsmanager = new CommentManager();
            $postview = $postmanager->showPost($_GET['id']);
            $commentsview = $commentsmanager->showComments($_GET['id']);
            $twigview = $this->getTwig();
            $twigpostview = $twigview->load('Frontend/comment.twig');
            echo $twigpostview->render(array('postview' => $postview,
                                    'commentsview' => $commentsview));
        }
    }

    function postsView()
    {
        $postsmanager = new PostManager();
        $paging = new Paging();
        $page = $paging->page();
        $nextpage = $paging->nextPage();
        $previouspage = $paging->previousPage();
        $firstin = $page[1];
        $currentpage = $page[0];
        $numberofpages = $page[2];
        $postsview = $postsmanager->showPosts($firstin);
        $twigview = $this->getTwig();
        $twigpostsview = $twigview->load('Frontend/posts.twig');
        echo $twigpostsview->render(array('postsview' => $postsview,
                                    'currentpage' => $currentpage,
                                'nextpage' => $nextpage,
                            'previouspage' => $previouspage,
                        'numberofpages' => $numberofpages));
    }

    function postsManager()
    {
        if (!isset($_SESSION['pseudo']) && !isset($_SESSION['id'])) {
            $this->phpSession()->set('stop', 'Vous n\'avez pas acces a cette page.');
            $this->phpSession()->redirect('/blog/connect');
        } elseif (!$_POST) {
            $token = $_SESSION['token'];
            $postsadminview = $this->post()->showPostsUser($_GET['id']);
            $twigview = $this->getTwig();
            $twigpostsmanager = $twigview->load('Backend/managerposts.twig');
            echo $twigpostsmanager->render(array('postsadminview' => $postsadminview));
        }
    }

    function postFormUpdate()
    {
        if (!isset($_SESSION['pseudo']) && !isset($_SESSION['id'])) {
            $this->phpSession()->set('stop', 'Vous n\'avez pas acces a cette page.');
            $this->phpSession()->redirect('/blog/connect');
        } else {
            $postformview = $this->post()->showPost($_GET['id']);
            $twigview = $this->getTwig();
            $twigpostformupdate = $twigview->load('Backend/managerupdatepost.twig');
            echo $twigpostformupdate->render(array('postformview' => $postformview));
        }
    }

    function postUpdate($title, $chapo, $content)
    {
        if (isset($_SESSION['pseudo']) && isset($_GET['id']) && !empty($_GET['id'])) {
            $postupdatemanager = new PostManager();
            $updatepostview = $postupdatemanager->updatePost($_GET['id'], $title, $chapo, $content);
            $this->phpSession()->set('succes', 'Post modifié.');
            $this->phpSession()->redirect('/blog/postsmanager/', $_SESSION['id']);
        }
        else {
            $this->phpSession()->set('stop', 'Vous n\'avez pas acces a cette page.');
            $this->phpSession()->redirect('/blog/connect');
        }
    }

    function postCreate()
    {
        if (isset($_SESSION['pseudo'])) {
            $postcreate = new AdminManager();
            $adminview = $postcreate->showAdmin($_GET['id']);
            $twigview = $this->getTwig();
            $twigpostcreate = $twigview->load('Backend/managercreatepost.twig');
            echo $twigpostcreate->render();
        } else {
            $this->phpSession()->set('stop', 'Vous n\'avez pas acces a cette page.');
            $this->phpSession()->redirect('/blog/connect');
        }
    }

    function postAdd($utilisateurId, $title, $chapo, $content)
    {
        if (isset($_SESSION['pseudo']) && isset($_POST['title']) && isset($_POST['chapo']) && isset($_POST['content'])) {
            $postmanager = new PostManager();
            $postaddview = $postmanager->createPost($utilisateurId, $title, $chapo, $content);
            $this->phpSession()->set('succes', 'Post ajouté.');
            $this->phpSession()->redirect('/blog/postsmanager/', $_SESSION['id']);
        } else {
            $this->phpSession()->set('stop', 'Vous n\'avez pas acces a cette page.');
            $this->phpSession()->redirect('/blog/connect');
        }
    }

    function postDelete()
    {
        if (!isset($_SESSION['pseudo'])) {
            $this->phpSession()->set('stop', 'Vous n\'avez pas acces a cette page.');
            $this->phpSession()->redirect('/blog/connect');
        } else {
            $postdeleteview = $this->post()->deletePost($_GET['id']);
            $this->phpSession()->set('succes', 'Post supprimé.');
            $this->phpSession()->redirect('/blog/postsmanager/', $_SESSION['id']);
        }
    }

    function postManager()
    {
        if (!isset($_SESSION['pseudo'])) {
            $this->phpSession()->set('stop', 'Vous n\'avez pas acces a cette page.');
            $this->phpSession()->redirect('/blog/connect');
        } else {
            $postAdminView = $this->post()->showPost($_GET['id']);
            $commentsNotvalidView = $this->comment()->showCommentsNotValid($_GET['id']);
            $twigview = $this->getTwig();
            $twigpostmanager = $twigview->load('Backend/managercomment.twig');
            echo $twigpostmanager->render(array('postsAdminView' => $postAdminView, 'commentsNotvalidView' => $commentsNotvalidView));
        }
    }

    function commentManager()
    {
        if (isset($_SESSION['pseudo']) && isset($_GET['id']) && !empty($_GET['id'])) {
            $postmanager = new PostManager();
            $commentmanager = new CommentManager();
            $postCommentAdminView = $postmanager->showPost($_GET['id']);
            $commentView = $commentmanager->showComments($_GET['id']);
            $twigview = $this->getTwig();
            $twigcommentmanager = $twigview->load('Backend/managercommentvalid.twig');
            echo $twigcommentmanager->render(array('postCommentAdminView' => $postCommentAdminView, 'commentView' => $commentView));
        } else {
            $this->phpSession()->set('stop', 'Vous n\'avez pas acces a cette page.');
            $this->phpSession()->redirect('/blog/connect');
        }
    }
}