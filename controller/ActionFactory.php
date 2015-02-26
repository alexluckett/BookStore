<?php

include_once 'model/actions/IAction.php';
include_once 'model/actions/AuthenticatedAction.php';
include_once 'model/actions/GuestAction.php';

include_once 'model/actions/UserLogin.php';
include_once 'model/actions/UserLogout.php';
include_once 'model/actions/LoadPage.php';
include_once 'model/actions/books/BookView.php';
include_once 'model/actions/books/AddBook.php';
include_once 'model/actions/books/AddBookForm.php';
include_once 'model/actions/books/DeleteBook.php';

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
            "login" => new UserLogin(),
            "logout" => new UserLogout(self::$userPermission),
            "viewBooks" => new BookView(self::$userPermission),
            "deleteBook" => new DeleteBook(self::$staffPermission),
            "addBook" => new AddBook(self::$staffPermission),
            "addBookForm" => new AddBookForm(self::$staffPermission)
        );
    }
    
    /**
     * Returns an action responsible for execution of a certain action (identified by a name of type string);
     * 
     * @param String $actionName
     * @return IAction action
     */
    public function getAction($actionName) {
        if(isset($this->actionMap[$actionName])) {
            return $this->actionMap[$actionName];
        } else {
            throw new Exception("Action does not exist in action factory.");
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