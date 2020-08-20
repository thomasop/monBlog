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
    document.location.href = '/blog/comment/$postid'</script>";
} 

function commentUpdate($author, $comment){
        
    $commentUpdateController = new CommentManager();
    $commentUpdateView = $commentUpdateController->updateComment($_GET['id'], $author, $comment);
    //header('Location: index.php?r=postsManager');
}
function commentUpdateForm(){
    $formCommentUpdate = new CommentManager();
        $formCommentViews = $formCommentUpdate->showComment($_GET['id']);
        //var_dump($formCommentViews);
        $twigController = new \App\tool\Twig();
        $twigView = $twigController->getTwig();
        $tpl = $twigView->load('Backend/updatecomment.twig');
        echo $tpl->render(array('formCommentViews' => $formCommentViews));
}
function commentUpdateValid(){
    //echo'ok';
    $validCommentUpdate = new CommentManager();
    $validCommentView = $validCommentUpdate->updateCommentValid($_GET['id']);
   // header('Location: index.php?r=postsManager');
   echo "<script>alert(\"commentaire validé.\");
           document.location.href = '/blog/postmanager/'</script>";
}
}