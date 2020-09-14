<?php

namespace App\tool;
use App\manager\PostManager;
class Paging 
{
    function count(){
        $postsmanager = new PostManager();
        if ($_GET['r'] == 'posts'){
            $messageperpage = 3;
            $pageposts = $postsmanager->countPosts();
            $numberofpages = ceil($pageposts/$messageperpage);
            return array($numberofpages, $messageperpage);
        }
    }

    function page()
    {
        $count = $this->count();
        if(isset($_GET['id'])) {
            $currentpage=intval($_GET['id']);
            if($currentpage>$count[0])
                {
                    $currentpage=$count[0];
                }
        } else {
            $currentpage=1;
        }
        $firstin = ($currentpage-1)*$count[1];
        return array($currentpage, $firstin, $count[0]);        
    }
    function nextPage(){
        $next = $this->page();
        $nextpage = $next[0] + 1;
        return $nextpage;
    }
    function previousPage(){
        $previous = $this->page();
        $previouspage = $previous[0] - 1;
        return $previouspage;
    }
}