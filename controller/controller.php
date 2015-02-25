<?php

include_once ('dbConfig.php');
include_once ('actionFactory.php');

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
        
        if(isset($actionName)) {
            $action = $this->actionFactory->getAction($actionName);
                        
            if($action->isLegalRequest()) {
                $action->execute();
                $this->loadPage($action);
            } else {
                // user does have not permission to run this action. log them out!
                
                echo("You do not have permission to run this action. Logging out.");
                
                $logoutAction = $this->actionFactory->getAction("logout");
                $logoutAction->execute();
            }
        } else {
            if(isset($_SESSION['permission']) && $_SESSION['permission'] !== 0) {                
                $this->loadHome();
            } else {
                $displayLoginAction = $this->actionFactory->getAction('displayLogin');
                $this->loadPage($displayLoginAction);
            }
        }
    }
    
    private function loadPage($action) {
        if(strlen($action->pageInclude()) !== 0) {
            include(__DIR__."/..".$action->pageInclude());
        }     
    }
    
    private function loadHome() {
        include('view/header.php');
        
        if($_SESSION['permission'] == 1) {
            include("view/staff/adminNavbar.php");
        } else {
            include("view/student/studentNavbar.php");
        }
    }
    
}