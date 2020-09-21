<?php

session_start();
$cookie_name = "grslo";
$ticket = session_id().microtime().rand(0,9999999999);
$tickette = password_hash($ticket, PASSWORD_DEFAULT);
setcookie($cookie_name, $ticket, time() + 3600, null, null, false, true);
$_SESSION['gruhto'] = $tickette;
$_COOKIE['grslo'] = $_SESSION['gruhto'];


require('vendor/autoload.php');

use App\controller\IndexController;
use App\controller\ControllerComment;
use App\controller\ControllerPost;
use App\controller\ControllerUser;
use App\tool\Router;
use App\tool\HttpRequest;

try {
    $httprequest = new HttpRequest();
    $router = new Router();
    $httprequest->setRoad($router->findRoad($httprequest));
    $httprequest->run();
}
catch(MonException $e) {
    echo "Erreur : " . $e->getMessage();
}
