<?php
namespace App\controller;

class ControllerIndex{
    function index(){
      $twigController = new \App\tool\Twig();
        $twigView = $twigController->getTwig();
        $tpl = $twigView->load('Frontend/Accueil.twig');
        echo $tpl->render();
    }
}