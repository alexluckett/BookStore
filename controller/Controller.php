<?php

include_once ('DbConfig.php');
include_once ('ActionFactory.php');

class Controller {
    private $actionFactory; // map of all possible actions within the program
    
    public function __construct() {
        $this->actionFactory = ActionFactory::getInstance();
    }
    
    public function invoke($request) {
        $actionName = NULL;
        
        if(isset($request['action'])) {
           $actionName = $request['action'];
        }
        
        $executeParams = $request;
        unset($executeParams['action']);
        
        try {
            if($actionName !== NULL) {
                $action = $this->actionFactory->getAction($actionName);

                $this->exeucteAction($action, $executeParams);
            } else if(isset($_SESSION['permission']) && $_SESSION['permission'] !== 0) {  
                $defaultAction = $this->actionFactory->getAction("viewBooks");
                $this->exeucteAction($defaultAction, $executeParams); // user has logged in so display home page
            } else {
                $displayLoginAction = $this->actionFactory->getAction('displayLogin'); // not logged in. display login screen.
                $this->loadPage($displayLoginAction);
            }
        } catch (Exception $ex) {
            echo("Specified action encountered a problem or does not exist. <a href='index.php'>Please click here to go back</a>.");
        }
        
    }
    
    private function exeucteAction($action, $executeParams) {
        if ($action->isLegalRequest()) {
            $action->execute($executeParams);
            $this->loadPage($action);
        } else {
            echo("You do not have permission to run this action. Logging out.");

            $logoutAction = $this->actionFactory->getAction("logout");
            $logoutAction->execute($executeParams);
        }
    }

    private function loadPage($action) {
        if(strlen($action->pageInclude()) !== 0) {
            include(__DIR__."/..".$action->pageInclude());
        }     
    }
    
    private function loadHome($action, $params) {
        $action->execute($param);
    }
    
}