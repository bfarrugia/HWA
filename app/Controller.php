<?php

interface IController{
	public function load();
	public function serve();
}

/**
 *  Class Controller
 *  Generic base class for all controllers. Contains
 *  modifiable View container class with necessary view
 *  object accessors
 */
class Controller implements IController{

	// View class object. Used for view data rendering and
	// targeted template injections
	protected $_view;

	public function __construct(){
		$this->_view = false;
	}

    /**
     *  Split route out of request path and call correct routing method
     */
    public function load(){
    	$route = explode('/', App::getRequestString());
    	$size = (strpos(get_class($this), "Index") === 0) ? 0 : 1;
        if(get_class($this) != "IndexController" && count($route) <= 1)
            $route[] = "index";

    	if(count($route) > $size){
    		$route = $route[$size];
            $route = (empty($route)) ? "index" : $route;

    		$methods = get_class_methods(get_class($this));
	    	foreach($methods as $method){
	    		if(strpos($method, $route) === 0)
		            return $this->$method();
	    	}
            App::redirect(App::getConfigValue('settings', '404'));
    	}
    }

    /**
     *  Filter input from GET or POST
     */
	protected function sanitizeInput($filter, $item, $sanitizer){
		$var = filter_input($filter, $item, $sanitizer);
		if(!$var)
			$var = "";
		return $var;
	}

    /**
     *  Retrieve View object
     */
	public function serve(){
		return $this->_view;
	}
}