<?php

include ('dbConfig.php');
include ('actionFactory.php');

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
                $logoutAction = $this->actionFactory->getAction("logout");
                $logoutAction->execute();
                
                echo("You do not have permission to run this action.");
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
        if(strlen($action->pageInclude()) === 0) {
            header('Location: index.php');
        } else {
            include(__DIR__."/..".$action->pageInclude());
        }     
    }
    
    private function loadHome() {
        if($_SESSION['permission'] == 1) {
            include(__DIR__."/../view/admin.php");
        } else {
            include(__DIR__."/../view/student.php");
        }
    }
    
}