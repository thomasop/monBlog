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
        $this->twig->addGlobal('_post', $_POST);
        $this->twig->addGlobal('_get', $_GET);
        $php_session = new PHPSession();
        $this->twig->addGlobal('_flash', $php_session);
        
    }
    
    public function getTwig()
    {
        return $this->twig;
    }
    
}

