<?php

// Setup application
require_once("./app/App.php");
App::setup();

// Debug help
// echo '<pre>';
// echo "DOC_ROOT: ".DOC_ROOT.NEW_LINE;
// echo "BASE_DIR: ".BASE_DIR.NEW_LINE;
// echo "BASE_URL: ".BASE_URL.NEW_LINE;
// echo "getBaseUrl: ".App::getBaseUrl().NEW_LINE;
// echo "getRequestUrl: ".App::getRequestUrl().NEW_LINE;
// echo "getRequestString: ".App::getRequestString().NEW_LINE;
// echo "_SERVER: ".$_SERVER['REQUEST_URI'];
// echo '</pre>';

// Instantiate controller
$controller = App::getController();
$view = false;

// If controller initialized
if($controller !== false){
    // Load and process route
    $controller->load();

    // Build view object to use in template
    $view = $controller->serve();
}

if(App::canRender()){
    // Build the view or redirect to 404
    if($view)
        include($view->getRenderTemplate());
    else
        App::redirect(App::getConfigValue('settings', '404'));
}

// VVVV Application no-mans land VVVV