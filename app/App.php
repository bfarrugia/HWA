<?php

// Controller instantiation and basic global constants
// defined here.

// Define system constants and URL/directory constants
define("DS", DIRECTORY_SEPARATOR);
define("NEW_LINE", "\r\n");
define("DOC_ROOT",  $_SERVER['DOCUMENT_ROOT']);

define("BASE_DIR",  dirname(__DIR__));
define("BASE_URL",  str_replace("\\", "/", str_replace(str_replace("\\","/",DOC_ROOT),"",BASE_DIR)));
define("DOMAIN",    $_SERVER['SERVER_NAME']);
define("SITE_URL",  "http://".DOMAIN.BASE_URL);
define("FULL_URL",  SITE_URL.str_replace(BASE_URL,'',$_SERVER['REQUEST_URI']));
define("FRAMEWORK_BASE_PATH", __DIR__);

/**
* Class App
* Main object that routes and intitializes controller based on query string. Handles
* URL requests and redirects.
*/
class App {
    // DEBUG
    private static $_isSetup = false;

    // DEBUG
    private static $_canRender = true;

    // Required configuration modules
    private static $_required = [
        "data" => ["host","dbname","user","pass"]
    ];

    // Configuration object
    private static $_config = null;

    /* 
     * Return the constant system base url
     */
    public static function getBaseUrl(){
        return SITE_URL;
    }

    /* 
     * Get the URL with the attached request details (GET parameters and paths)
     */
    public static function getRequestUrl(){
        return self::getBaseUrl().str_replace(BASE_URL, "", $_SERVER['REQUEST_URI']);
    }

    /* 
     * Only pull paths and parameters from URL. Parse out filetypes
     */
    public static function getRequestString(){
        $path = substr(self::getRequestUrl(), strlen(self::getBaseUrl()));
        $path = ltrim(preg_replace("/(?:\/[a-zA-Z0-9]*\..*)/", "", $path),"/");
        if($pos = strpos($path, "?"))
            $path = substr($path, 0, strpos($path, '?'));
        return $path;
    }

    /* 
     * Pull GET parameters from request
     */
    public static function getRequestParams(){
        return $_GET;
    }

    /**
     *  Returns the name of the controller that needs to be initialized
     */
    public static function getController(){
        // Explode URL parameters and find the first item
        $urlParams = explode('/', self::getRequestString());

        // If no unique route found, default to main index controller
        if(count($urlParams) == 1 && empty($urlParams[0])){
            $urlParams[0] = "index";
        }

        // Get controller name from first item
        $controllerName = ucfirst(array_shift($urlParams))."Controller";
        if(!class_exists($controllerName)){
            $controllerName = "IndexController";
        }
        
        return (class_exists($controllerName) ? new $controllerName() : false);
    }

    /**
     *  Load controllers, models, and views for the system to use
     */
    public static function setup(){
        // Get all files in controllers folder
        if(!self::$_isSetup){
            self::$_isSetup = true;

            $paths = [ CONTROLLER_PATH, MODEL_PATH ];

            foreach($paths as $path){
                $files = scandir($path);

                foreach($files as $file){
                    if($file != '.' && $file != '..')
                        require($path.DS.$file);
                }
            }
        }
    }

    /**
     *  // Redirect to the specific path
     */
    public static function redirect($path, $args = false){
        if($args){
            $q = "?";
            foreach($args as $key=>$value){
                $q .= $key."=".urlencode($value).'&';
            }
            $args = substr($q, 0, strlen($q)-1);
        }
        header("Location: ".self::getBaseUrl().DS.$path.$args);
        die();
    }

    /**
     *  Get information from config file
     */
    public static function parseConfig($path = FRAMEWORK_BASE_PATH){
        if(!isset(self::$_config)){
            $text = preg_replace("/(^)?[^\S\n]*\/(?:\*(.*?)\*\/[^\S\n]*|\/[^\n]*)($)?/", "", file_get_contents($path.DS."etc".DS."config.json"));

            // Return decoded text as an associative array
            self::$_config = json_decode($text, true);
        }
        return self::$_config;
    }

    /**
     *  Check if basic settings attributes required to run the server exist
     */
    public static function verifySettings(){
        $settings = self::parseConfig();
        if($settings){
            foreach(self::$_required as $base){
                foreach($base as $key => $value){
                    if(!$value)
                        return false;
                }
            }
        }

        return true;
    }

    /**
     *  Get config object
     */
    public static function getConfig(){
        return self::$_config;
    }

    public static function getConfigValue($category, $key = false){
        if(!$key && isset(self::$_config[$category]))
            return self::$_config[$category];
        if(isset(self::$_config[$category][$key]))
            return self::$_config[$category][$key];
        return false;
    }

    public static function setRender($bool){
        self::$_canRender = $bool;
    }

    public static function canRender(){
        return self::$_canRender;
    }
}

// Build settings object from JSON config file stored in framework path
if(!App::verifySettings())
{
    // If settings could not be established, kill connection
    trigger_error("Framework settings could not be established. Come back later.");
    die();
}

define("VIEW_PATH", FRAMEWORK_BASE_PATH.DS."views");
define("MODEL_PATH", FRAMEWORK_BASE_PATH.DS."models");
define("CONTROLLER_PATH", FRAMEWORK_BASE_PATH.DS."controllers");
define("DATA_PATH", FRAMEWORK_BASE_PATH.DS."data");

require_once(DATA_PATH.DS."Database.php");

require_once(FRAMEWORK_BASE_PATH.DS."Controller.php");
require_once(FRAMEWORK_BASE_PATH.DS."Model.php");
require_once(FRAMEWORK_BASE_PATH.DS."View.php");