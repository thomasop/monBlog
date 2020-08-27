<?php
namespace App\controller;

use PDO;
use App\manager\CommentManager;
use App\manager\PostManager;

class ControllerComment {
    function commentAdd($postId, $author, $comment)
{
    $postid = trim($postId);
    
    $commentManager = new CommentManager();

    $affectedLines = $commentManager->createComment($postId, $author, $comment);

    if ($affectedLines === false) {
        throw new Exception('Impossible d\'ajouter le commentaire !');
    }
    else {
        
        echo "<script>alert(\"commentaire ajouté, un administrateur le validera.\");
           document.location.href = '/blog/comment/$postid'</script>";
        
    }
    
}   
function commentDelete(){
    $commentDeleteController = new CommentManager();
    $commentDeleteView = $commentDeleteController->deleteComment($_GET['id']);
    echo "<script>alert(\"commentaire supprimé.\");
    document.location.href = '/blog/postsmanager/$_SESSION[id]'</script>";
} 

function commentUpdate($author, $comment){
        
    $commentUpdateController = new CommentManager();
    $commentUpdateView = $commentUpdateController->updateComment($_GET['id'], $author, $comment);
    echo "<script>alert(\"commentaire supprimé.\");
    document.location.href = '/blog/postsmanager/$_SESSION[id]'</script>";
}
function commentUpdateForm(){
    $formCommentUpdate = new CommentManager();
        $formCommentViews = $formCommentUpdate->showComment($_GET['id']);
        //var_dump($formCommentUpdate);
        $twigController = new \App\tool\Twig();
        $twigView = $twigController->getTwig();
        $tpl = $twigView->load('Backend/updatecomment.twig');
        echo $tpl->render(array('formCommentViews' => $formCommentViews));
}
function commentUpdateValid(){
    $validCommentUpdate = new CommentManager();
    $validCommentView = $validCommentUpdate->updateCommentValid($_GET['id']);
   echo "<script>alert(\"commentaire validé.\");
           document.location.href = '/blog/postsmanager/$_SESSION[id]'</script>";
}
}