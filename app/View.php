<?php

/**
 * Class DataView
 * Generic view data class that holds data to be displayed in view templates
 */
class DataView
{
    protected $_objects;

    /**
     *  Check if key exists in the stored object array; return result
     */
    public function checkObject($key){
        return array_key_exists($key, $this->_objects);
    }

    /**
     *  Return object in array if it exists, else return false
     */
    public function getObject($key){
        if($this->checkObject($key)){
            return $this->_objects[$key];
        }
        return false;
    }

    /**
     *  Overwrite by default value at key location in object array
     */
    public function setObject($key, $value, $overwrite = true){
        if($overwrite || !$this->checkObject($key))
            $this->_objects[$key] = $value;
    }

    /**
     *  Set value of parameter key-index in object
     */
    public function setObjectParam($arrayIndex, $key, $value){
        // Check if key exists using class method
        if($this->checkObject($key)){
            // If so, get array based on object reference
            $arr = &$this->_objects[$arrayIndex];

            // If correct object type, set value
            if(getType($arr) === "array"){
                $arr[$arrayIndex] = $value;
            }
        }
    }

    /**
     *  DEBUG - See what the view is holding
     */
    public function printObjects(){
        var_dump($this->_objects);
    }
}

/**
 * Class View
 * Object that holds page meta data and template paths to be used for specified route
 */
class View extends DataView{
	// Generic page title
	public $pageTitle;

	// Template type
	public $templateView;

	// Template to be rendered based on templateView
	protected $_template;

	// Directory of the given view based on type
	protected $_templatePath;

	public function __construct($templateParam){
		// Initialize view object array
		$this->_objects = [];

		try{
			// Get template type passed in
			$this->templateView = $templateParam;

			// Get generic template file
			$templateFile = VIEW_PATH.DS.'templates/template.php';
			
			// If file exists, set text to stored template
			if(file_exists($templateFile))
			{
				$this->_template = $templateFile;
				$this->_templatePath = VIEW_PATH.DS.$this->templateView;
			}
			else
			{
				// Throw a template error exception if not found
				throw new Exception("Template for $templateFile not found.");
			}
		}catch(Exception $e){
			// Build generic error message based on exception
			$this->_template = '<div class="page-error">There was an error rendering the page:<br/>'.$e->getMessage().'</div>';
			// Outside of demo purposes, log the exception thrown
		}
	}

	/**
	 *  Return the render template to be echoed/processed to browser
	 */
	public function getRenderTemplate(){
		return $this->_template;
	}

	public function injectRenderTemplate($key){
		$file = "/$key.php";
		$default = VIEW_PATH.DS."templates".$file;
		$path = $this->_templatePath.$file;

		$path = (!file_exists($path)) ? $default : $path;
		if(file_exists($path))
			return $path;

		return false;
	}
}