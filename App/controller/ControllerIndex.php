<?php

namespace App\controller;
require_once('App/Controller/Controller.php');
class ControllerIndex extends Controller
{
    function index()
    {
        $twigview = $this->getTwig();     
        $twigindex = $twigview->load('Frontend/home.twig');
        echo $twigindex->render();
    }
}