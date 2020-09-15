<?php

namespace App\tool;

class HttpRequest
{
    private $_url;
    private $_method;
    private $_param;
    private $_road;
		
    public function __construct($url = null, $method = null)
    {
		
			$this->_url = ($url === null) ? $_SERVER['REQUEST_URI'] : $url;
			$this->_method = ($method === null) ? $_SERVER['REQUEST_METHOD'] : $method;
			$this->_param = array();
		
    }
		
    public function getUrl()
    {
	    return $this->_url;	
    }
	
    public function getMethod()
    {
	    return $this->_method;	
    }
	
    public function getParams()
    {
	    return $this->_params;	
	}
	
    public function setRoad($road)
    {
	    $this->_road = $road;	
    }
	
    public function bindParam()
	{
		switch ($this->_method) {
			case "GET":
			case "POST":
				foreach ($this->_road->getParam() as $param) {
					if (isset($_POST[$param])) {
						$this->_param[] = $_POST[$param];
					}
				}
		}
	}
	public function getRoad()
	{
		return $this->_road;	
	}

	public function getParam()
	{
		return $this->_param;	
	}
	
	public function run()
	{
		$this->bindParam();
		$this->_road->run($this);
	}
}