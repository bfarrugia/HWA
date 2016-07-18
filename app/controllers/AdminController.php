<?php

/**
* Class AdminController
* Specific methods for routing admin page views.
*
*/
class AdminController extends Controller
{
    /**
    * Route to the index page view (/admin)
    */
    public function indexRoute(){
        $this->_view = new View("admin");
        $this->_view->pageTitle = "Admin";

        // Load all users in the database and set for display
        $result = new User();
        $result = $result->loadGroup();

        $this->_view->setObject('users', $result);
    }
}