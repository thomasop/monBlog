<?php
namespace App\tool;
require('vendor/autoload.php');
use \Twig_Loader_Filesystem;
use \Twig_Environment;
class Twig{

    private $loader;
    private $twig;
     
    public function __construct()
    {
        $this->loader = new \Twig\Loader\FilesystemLoader('Views/');
        $this->twig = new \Twig\Environment($this->loader, [
            'debug' => true,
        ]);
        $this->twig->addGlobal('_session', $_SESSION);
        $this->twig->addGlobal('_post', $_POST);
        $this->twig->addGlobal('_get', $_GET);

        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
        
    }
    public function getTwig()
    {
        return $this->twig;
    }
}
