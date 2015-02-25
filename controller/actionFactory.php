<?php

include 'model/actions/IAction.php';
include 'model/actions/AuthenticatedAction.php';
include 'model/actions/GuestAction.php';

include 'model/actions/UserLogin.php';
include 'model/actions/UserLogout.php';
include 'model/actions/LoadPage.php';

/**
 * Description of actionFactory
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class ActionFactory {
    private $actionMap;
    
    private static $singletonActionFactory;
    
    private static $staffPermission = 1;
    private static $userPermission = 2;
    
    /**
     * Constructs a map of action names to class responsible for execution.
     */
    private function __construct() {
        $this->actionMap = array (
            // "actionName" => class that extends IAction
            "displayLogin" => new LoadPage("/view", "login.php"),
            "login" => new UserLogin(self::$userPermission),
            "logout" => new UserLogout()
        );
    }
    
    /**
     * Returns an action responsible for execution of a certain action (identified by a name of type string);
     * 
     * @param String $actionName
     * @return IAction action
     */
    public function getAction($actionName) {
        $action = $this->actionMap[$actionName];
        
        if(isset($action)) {
            return $action;
        } else {
            
        }
    }
    
    /**
     * Returns the singleton instance of the action factory.
     * 
     * @return type
     */
    public static function getInstance() {
        if(!isset(self::$singletonActionFactory)) {
            self::$singletonActionFactory = new ActionFactory();
        }
        
        return self::$singletonActionFactory;
    }
}
