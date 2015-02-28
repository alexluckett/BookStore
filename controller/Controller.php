<?php

include_once ('DbConfig.php');
include_once ('ActionFactory.php');

class Controller {
    private $actionFactory; // map of all possible actions within the program
    
    private $debugEnabled = true;
    
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
            $finalAction = $this->actionFactory->getAction('welcomeScreen'); // default not logged in. display welcome screen.
            
            if($actionName !== NULL) { // user has requested an action
                $finalAction = $this->actionFactory->getAction($actionName);
            } else if(isset($_SESSION['permission']) && $_SESSION['permission'] !== 0) {  // user is logged in but no action requested
                $finalAction = $this->actionFactory->getAction("viewBooks"); // user has logged in so display home page
            }
            
            $this->exeucteAction($finalAction, $executeParams);
        } catch (Exception $ex) {
            if($this->debugEnabled) { var_dump($ex); }
            echo("Specified action encountered a problem or does not exist."
                    . "<a href='index.php'>Please click here to go back</a>.");
        }
        
    }
    
    private function exeucteAction($action, $executeParams) {
        if ($action->isLegalRequest()) { // checks if the user has permission to run the action
            $action->execute($executeParams);
            $this->loadPage($action);
        } else {
            echo("You do not have permission to run this action.");
        }
    }

    private function loadPage($action) {
        if(strlen($action->pageInclude()) !== 0) {
            include(__DIR__."/..".$action->pageInclude());
        }     
    }
    
}