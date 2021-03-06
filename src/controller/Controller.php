<?php

include_once ('ActionFactory.php');

class Controller {
    private $actionFactory; // map of all possible actions within the program
    
    private $debugEnabled = false;
    
    public function __construct() {
        $this->actionFactory = ActionFactory::getInstance();
    }
    
    /**
     * Finds the relevant business action and executes it, sending the output to the view.
     * 
     * @param array $request request parameters
     */
    public function invoke($request) {
        $actionName = NULL;
        
        if(isset($request['action'])) {
           $actionName = $request['action'];
        }
        
        $executeParams = $request;
        unset($executeParams['action']); // out of scope for models - unneccessary
        
        try {
            $finalAction = $this->actionFactory->getAction('viewWelcome'); // default not logged in. display welcome screen.
            
            if($actionName !== NULL) { // user has requested an action
                $finalAction = $this->actionFactory->getAction($actionName);
            } else if(isset($_SESSION['permission']) && $_SESSION['permission'] !== 0) {  // user is logged in but no action requested
                $finalAction = $this->actionFactory->getAction("viewBooks"); // user has logged in so display home page
            }
            
            $this->exeucteAction($finalAction, $executeParams);
        } catch (PDOException $ex) {
            if($this->debugEnabled) { var_dump($ex); }
            
            $this->displayError("Database connection error.", 
                                "Unable to connect to database, or the operation has malfunctioned."); // can't recover from database errors
        } catch (Exception $ex) {
            if($this->debugEnabled) { var_dump($ex); }
            
            $this->displayError("Specified action encountered a problem or does not exist.", 
                                $ex->getMessage()." <a href='index.php'>Please click here to go back</a>."); // specific action has failed to execute
        }
    }
    
    /**
     * Executes a business action and displays output
     * 
     * @param IAction $action
     * @param array $executeParams
     */
    private function exeucteAction($action, $executeParams) {
        if ($action->isLegalRequest()) { // checks if the user has permission to run the action
            $action->execute($executeParams); // run pre-requisites before page shown
            $this->loadPage($action); // show page
        } else {
            $this->displayError("Unable to load page", "You do not have permission to run this action.");
        }
    }

    /**
     * Loads a page from a business action
     * @param IAction $action
     */
    private function loadPage($action) {
        $url = $action->pageInclude();
        
        if(strlen($url) !== 0) { // only execute if we have a URL
            include( __DIR__."/..".$url);
        }     
    }
    
    /**
     * Display an error message to the view
     * 
     * @param string $errorTitle
     * @param string $errorMessage
     */
    private function displayError($errorTitle, $errorMessage) {        
        $_REQUEST['errorTitle'] = $errorTitle;
        $_REQUEST['errorMessage'] = $errorMessage;
            
        $errorAction = $this->actionFactory->getAction('viewError');
        $this->loadPage($errorAction);
    }
    
}