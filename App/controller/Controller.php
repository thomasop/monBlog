<?php

namespace App\controller;
use App\tool\Twig;
use \Twig_Loader_Filesystem;
use \Twig_Environment;
use App\tool\PHPSession;
class controller
{
    protected $twig;
    private $loader;
    
    public function __construct()
    {
        $this->loader = new \Twig\Loader\FilesystemLoader('Views/');
        $this->twig = new \Twig\Environment($this->loader, [
            'debug' => true,
        ]);
        $this->twig->addGlobal('_session', $_SESSION);
        $php_session = new PHPSession();
        $this->twig->addGlobal('_flash', $php_session);
    }
    
    public function getTwig()
    {
        return $this->twig;
    }
    
    public function phpSession(){
        $php_session = new PHPSession();
        return $php_session;
    }

    public function comment(){
        if (isset($_SESSION['pseudo']) && isset($_GET['id']) && !empty($_GET['id'])) {
            $commentmanager = new CommentManager();
            return $commentmanager;
        }
    }

    public function post(){
        if (isset($_SESSION['pseudo']) && isset($_GET['id']) && !empty($_GET['id'])) {
            $postmanager = new PostManager();
            return $postmanager;
        }
    }

    public function administrator(){
        if (isset($_SESSION['pseudo']) && isset($_GET['id']) && !empty($_GET['id'])) {
            $adminmanager = new AdminManager();
            return $adminmanager;
        }
    }
}
