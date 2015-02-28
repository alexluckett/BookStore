<?php

include_once 'model/actions/IAction.php';
include_once 'model/actions/AuthenticatedAction.php';
include_once 'model/actions/GuestAction.php';

include_once 'model/dbaccess/UserDAO.php';
include_once 'model/dbaccess/BasketDAO.php';
include_once 'model/dbaccess/BookDAO.php';

include_once 'model/actions/users/CreateAccount.php';
include_once 'model/actions/users/ViewAccountDetails.php';
include_once 'model/actions/users/AddUserBalancePage.php';
include_once 'model/actions/users/AddUserBalance.php';
include_once 'model/actions/users/UserLogin.php';
include_once 'model/actions/users/UserLogout.php';
include_once 'model/actions/users/ViewUsers.php';
include_once 'model/actions/LoadPage.php';
include_once 'model/actions/books/BookView.php';
include_once 'model/actions/books/AddBook.php';
include_once 'model/actions/books/AddBookForm.php';
include_once 'model/actions/books/DeleteBook.php';
include_once 'model/actions/basket/AddToBasket.php';
include_once 'model/actions/basket/ProcessBasket.php';
include_once 'model/actions/basket/ViewBasket.php';
include_once 'model/actions/basket/ViewBasketStaff.php';

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
            "welcomeScreen" => new LoadPage("/view", "welcomeScreen.php"),
            "displayError" => new LoadPage("/view", "displayError.php"),
            "displayLogin" => new LoadPage("/view", "login.php"), // display login page
            "displayRegister" => new LoadPage("/view", "register.php"), // display account registration page
            "info" => new LoadPage("/view", "info.php"), // display information page
            "register" => new CreateAccount(), // log in to system
            "login" => new UserLogin(), // log in to system
            "logout" => new UserLogout(self::$userPermission), // log out from system
            "accountDetails" => new ViewAccountDetails(self::$userPermission), // log out from system
            "editUserPage" => new AddUserBalancePage(self::$staffPermission), // log out from system
            "addBalanceAmount" => new AddUserBalance(self::$staffPermission), // log out from system
            "viewBooks" => new BookView(self::$userPermission), // view a list of books
            "deleteBook" => new DeleteBook(self::$staffPermission), // delete a book
            "addBook" => new AddBook(self::$staffPermission), // add a book
            "addBookForm" => new AddBookForm(self::$staffPermission), // display page to add book
            "addToBasket" => new AddToBasket(self::$userPermission), // add a book to basket
            "viewBasket" => new ViewBasket(self::$userPermission), // view items in basket
            "viewUserBasket" => new ViewBasketStaff(self::$staffPermission), // view user's basket (from outside account)
            "processBasket" => new ProcessBasket(self::$staffPermission), // process a user's basket
            "viewUsers" => new ViewUsers(self::$staffPermission) // view a list of users
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
            throw new Exception("The action you are trying to run does not exist.");
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