<?php

namespace App\controller;

class ControllerIndex
{
    function index()
    {
        $twigcontroller = new \App\tool\Twig();
        $twigview = $twigcontroller->getTwig();
        $twigindex = $twigview->load('Frontend/home.twig');
        echo $twigindex->render();
    }
}