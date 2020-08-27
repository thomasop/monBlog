<?php
namespace App\controller;

use App\manager\PostManager;
use App\manager\CommentManager;
use App\manager\AdminManager;
class ControllerPost {
    function postView()
    {
        $postmanager = new PostManager();
        $commentsmanager = new CommentManager();
        $postview = $postmanager->showPost($_GET['id']);
        $commentsview = $commentsmanager->showComments($_GET['id']);
        $twigcontroller = new \App\tool\Twig();
        $twigview = $twigcontroller->getTwig();
        $twigcommentview = $twigview->load('Frontend/comment.twig');
        echo $twigcommentview->render(array('postview' => $postview,
                                'commentsview' => $commentsview));    
    }

    function postsView(){
        $postsmanager = new PostManager();
        $postsview = $postsmanager->showPosts();
        $twigcontroller = new \App\tool\Twig();
        $twigview = $twigcontroller->getTwig();
        $twigpostview = $twigview->load('Frontend/post.twig');
        echo $twigpostview->render(array('postsview' => $postsview));
    }

    function postsManager(){
        $postsadminmanager = new PostManager();
        $postsadminview = $postsadminmanager->showPostsUser($_GET['id']);
        $twigcontroller = new \App\tool\Twig();
        $twigview = $twigcontroller->getTwig();
        $twigpostadminview = $twigview->load('Backend/postMana.twig');
        echo $twigpostadminview->render(array('postsadminview' => $postsadminview));
    }

    function postFormUpdate(){
        $postformmanager = new PostManager();
        $postformview = $postformmanager->showPost($_GET['id']);
        $twigcontroller = new \App\tool\Twig();
        $twigview = $twigcontroller->getTwig();
        $twigpostformview = $twigview->load('Backend/updatepost.twig');
        echo $twigpostformview->render(array('postformview' => $postformview));
    }

    function postUpdate($title, $content){
        
        $postUpdateController = new PostManager();
        $updatePostView = $postUpdateController->updatePost($_GET['id'], $title, $content);
       
       echo "<script>alert(\"post creé.\");
    document.location.href = '/blog/postsmanager/$_SESSION[id]'</script>";
    }

    function postCreate(){
        $postmanager = new PostManager();
        $adminmanager = new AdminManager();
        $admincontroller = $adminmanager->showAdmin($_GET['id']);
        $twigController = new \App\tool\Twig();
        $twigView = $twigController->getTwig();
        $tpl = $twigView->load('Backend/creationpost.twig');
        echo $tpl->render();
        
    }

    function postAdd($utilisateurId, $title, $content)
    {
        $postAddController = new PostManager();
        $gfg = new AdminManager();
        $postAddView = $postAddController->createPost($utilisateurId, $title, $content);
        
        if ($postAddView === false) {
            throw new Exception('Impossible d\'ajouter le post !');
            }
        else {
           echo "<script>alert(\"post creé.\");
    document.location.href = '/blog/postsmanager/$_SESSION[id]'</script>";
            
            }
    }   
    function postDelete(){
        $postDeleteController = new PostManager();
        $postDeleteView = $postDeleteController->deletePost($_GET['id']);
        $postsAdmin = new PostManager();
        $postsAdminView = $postsAdmin->showPosts();
        echo "<script>alert(\"post supprimé.\");
    document.location.href = '/blog/postsmanager/$_SESSION[id]'</script>";
        
    } 
    function postManager(){
        $postAdminController = new PostManager();
        $commentsnotvalidController = new CommentManager();
        $postAdminView = $postAdminController->showPost($_GET['id']);
        $commentsNotvalidView = $commentsnotvalidController->showCommentsNotValid($_GET['id']);
        $twigController = new \App\tool\Twig();
        $twigView = $twigController->getTwig();
        $tpl = $twigView->load('Backend/comMana.twig');
        echo $tpl->render(array('postsAdminView' => $postAdminView, 'commentsNotvalidView' => $commentsNotvalidView));
        
    }  
    function commentManager(){
        $postAdminController = new PostManager();
        $commentsvalidController = new CommentManager();
        $postCommentAdminView = $postAdminController->showPost($_GET['id']);
        $commentView = $commentsvalidController->showComments($_GET['id']);
        $twigController = new \App\tool\Twig();
        $twigView = $twigController->getTwig();
        $tpl = $twigView->load('Backend/commentvalid.twig');
        echo $tpl->render(array('postCommentAdminView' => $postCommentAdminView, 'commentView' => $commentView));
        
    }       
}