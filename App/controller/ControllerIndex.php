<?php

namespace App\controller;

class ControllerIndex extends Controller
{
    function index()
    {
        $twigview = $this->getTwig();     
        $twigindex = $twigview->load('Frontend/home.twig');
        echo $twigindex->render();
    }
}