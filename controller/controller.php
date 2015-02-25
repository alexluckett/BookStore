<?php

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
            
            sexyVarDump("Action map", $this->actionFactory);
            sexyVarDump("Action object", $action);
                        
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
            $displayLoginAction = $this->actionFactory->getAction('displayLogin');
            $this->loadPage($displayLoginAction);
        }
    }
    
    private function loadPage($action) {
        echo 'loading page';
        include($action->pageInclude());
    }
    
}

function sexyVarDump($title, $obj) {
        echo $title;
        echo '<pre>';
        var_dump($obj);
        echo '</pre>';
    }