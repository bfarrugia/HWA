<?php

/**
 * Class IndexController
 * Generic controller that handles index routing
 */
class IndexController extends Controller
{
    const MAX_CONFIRMATION_MINUTES = 5;

    /**
     *  General index routing to home page
     */
    public function indexRoute(){
        $this->_view = new View("index");
        $this->_view->pageTitle = "Welcome - Registration";
    }

    /**
     *  Handle confirmation of user creation
     */
    public function confirmationRoute(){
        $this->_view = new View("index/confirmation");
        $this->_view->pageTitle = "Registration Confirmation";

        $confirmationId = (isset($_GET['id'])) ? $_GET['id'] : false;
        if($confirmationId){
            $user = new User(["id"=>$confirmationId]);
            if($user->getData('id')){
                // If time was registered in the last 2 minutes, allow the confirmation page to load
                $created = strtotime($user->getData('created'));
                $current = time();

                if(($current - $created) < (self::MAX_CONFIRMATION_MINUTES * 60)){
                    $this->_view->setObject('user', $user);
                }else{
                    App::redirect('', ["error" => "1"]);
                }
            }
        }
    }
}