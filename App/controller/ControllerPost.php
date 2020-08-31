<?php

namespace App\controller;

use App\manager\PostManager;
use App\manager\CommentManager;
use App\manager\AdminManager;

class ControllerPost
{
    function postView()
    {
        $postmanager = new PostManager();
        $commentsmanager = new CommentManager();
        $postview = $postmanager->showPost($_GET['id']);
        $commentsview = $commentsmanager->showComments($_GET['id']);
        $twigcontroller = new \App\tool\Twig();
        $twigview = $twigcontroller->getTwig();
        $twigpostview = $twigview->load('Frontend/comment.twig');
        echo $twigpostview->render(array('postview' => $postview,
                                'commentsview' => $commentsview));    
    }

    function postsView()
    {
        $postsmanager = new PostManager();
        $postsview = $postsmanager->showPosts();
        $twigcontroller = new \App\tool\Twig();
        $twigview = $twigcontroller->getTwig();
        $twigpostsview = $twigview->load('Frontend/posts.twig');
        echo $twigpostsview->render(array('postsview' => $postsview));
    }

    function postsManager()
    {
        $postsmanager = new PostManager();
        $postsadminview = $postsmanager->showPostsUser($_GET['id']);
        $twigcontroller = new \App\tool\Twig();
        $twigview = $twigcontroller->getTwig();
        $twigpostsmanager = $twigview->load('Backend/managerposts.twig');
        echo $twigpostsmanager->render(array('postsadminview' => $postsadminview));
    }

    function postFormUpdate()
    {
        $postmanager = new PostManager();
        $postformview = $postmanager->showPost($_GET['id']);
        $twigcontroller = new \App\tool\Twig();
        $twigview = $twigcontroller->getTwig();
        $twigpostformupdate = $twigview->load('Backend/managerupdatepost.twig');
        echo $twigpostformupdate->render(array('postformview' => $postformview));
    }

    function postUpdate($title, $content)
    {
        $postmanager = new PostManager();
        $updatepostview = $postmanager->updatePost($_GET['id'], $title, $content);
        echo "<script>alert(\"post creé.\");
        document.location.href = '/blog/postsmanager/$_SESSION[id]'</script>";
    }

    function postCreate()
    {
        $postmanager = new PostManager();
        $adminmanager = new AdminManager();
        $adminview = $adminmanager->showAdmin($_GET['id']);
        $twigcontroller = new \App\tool\Twig();
        $twigview = $twigcontroller->getTwig();
        $twigpostcreate = $twigview->load('Backend/managercreatepost.twig');
        echo $twigpostcreate->render();  
    }

    function postAdd($utilisateurId, $title, $content)
    {
        $postmanager = new PostManager();
        $adminmanager = new AdminManager();
        $postaddview = $postmanager->createPost($utilisateurId, $title, $content);

        if ($postaddview === false) {
            throw new Exception('Impossible d\'ajouter le post !');
        } else {
            echo "<script>alert(\"post creé.\");
            document.location.href = '/blog/postsmanager/$_SESSION[id]'</script>";
        }
    }

    function postDelete()
    {
        $postmanager = new PostManager();
        $postdeleteview = $postmanager->deletePost($_GET['id']);
        $postsadminview = $postmanager->showPosts();
        echo "<script>alert(\"post supprimé.\");
        document.location.href = '/blog/postsmanager/$_SESSION[id]'</script>";   
    }

    function postManager()
    {
        $postmanager = new PostManager();
        $commentmanager = new CommentManager();
        $postAdminView = $postmanager->showPost($_GET['id']);
        $commentsNotvalidView = $commentmanager->showCommentsNotValid($_GET['id']);
        $twigcontroller = new \App\tool\Twig();
        $twigview = $twigcontroller->getTwig();
        $twigpostmanager = $twigview->load('Backend/managercomment.twig');
        echo $twigpostmanager->render(array('postsAdminView' => $postAdminView, 'commentsNotvalidView' => $commentsNotvalidView));
    }

    function commentManager()
    {
        $postmanager = new PostManager();
        $commentmanager = new CommentManager();
        $postCommentAdminView = $postmanager->showPost($_GET['id']);
        $commentView = $commentmanager->showComments($_GET['id']);
        $twigcontroller = new \App\tool\Twig();
        $twigview = $twigcontroller->getTwig();
        $twigcommentmanager = $twigview->load('Backend/managercommentvalid.twig');
        echo $twigcommentmanager->render(array('postCommentAdminView' => $postCommentAdminView, 'commentView' => $commentView));  
    }       
}