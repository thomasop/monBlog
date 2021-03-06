<?php
namespace App\tool;

use App\tool\Road;
use PDO;
use DOMDocument;
use App\tool\HttpRequest;

class Router
{
    private $_listroad;
	
	public function __construct()
	{
		$stringroad = file_get_contents('Config/route.json');
		$this->_listroad = json_decode($stringroad);
	}
	
	public function findRoad($httprequest)
	{
		$roadfound = array_filter($this->_listroad,function($road) use ($httprequest){
			return preg_match("#^" . $road->path . "$#", $httprequest->getUrl()) && $road->method == $httprequest->getMethod();
		});
		$numberroad = count($roadfound);

		if($numberroad > 1 || $numberroad == 0) {
			echo 'error road';
		} else {
			return new Road(array_shift($roadfound));	
		}
	}
}










