<?php

include_once ('ClassLoader.php');

include_once 'IAction.php';
include_once 'model/actions/AuthenticatedAction.php';
include_once 'model/actions/GuestAction.php';

include_once 'model/dbaccess/UserDAO.php';
include_once 'model/dbaccess/BasketDAO.php';
include_once 'model/dbaccess/BookDAO.php';
include_once 'model/dbaccess/CategoryDAO.php';

include_once 'model/DomainModel.php';
include_once 'model/BookCategoryModel.php';
include_once 'model/BookModel.php';
include_once 'model/UserModel.php';

include_once 'model/actions/LoadPage.php';

include_once 'model/actions/users/CreateAccount.php';
include_once 'model/actions/users/ViewAccountDetails.php';
include_once 'model/actions/users/AddUserBalancePage.php';
include_once 'model/actions/users/AddUserBalance.php';
include_once 'model/actions/users/UserLogin.php';
include_once 'model/actions/users/UserLogout.php';
include_once 'model/actions/users/ViewUsers.php';
include_once 'model/actions/users/DeleteUser.php';

include_once 'model/actions/books/ViewBookList.php';
include_once 'model/actions/books/AddBook.php';
include_once 'model/actions/books/AddBookForm.php';
include_once 'model/actions/books/DeleteBook.php';
include_once 'model/actions/books/AddQuantity.php';
include_once 'model/actions/books/ViewAddQuantity.php';

include_once 'model/actions/basket/AddToBasket.php';
include_once 'model/actions/basket/DeleteBasketItem.php';
include_once 'model/actions/basket/ProcessBasket.php';
include_once 'model/actions/basket/ViewBasket.php';
include_once 'model/actions/basket/ViewBasketStaff.php';

include_once 'model/actions/categories/AddCategory.php';
include_once 'model/actions/categories/DeleteCategory.php';
include_once 'model/actions/categories/ViewAddCategory.php';
include_once 'model/actions/categories/ViewCategoryList.php';

/**
 * Description of actionFactory
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class ActionFactory {
    private static $singletonActionFactory;
    
    private $actionMap;
    
    /* permission levels */
    private static $staffPermission = 1;
    private static $userPermission = 2;

    /**
     * Constructs a map of action names to class responsible for execution.
     * 
     * No system action can be ran unless it is explicitly allowed here.
     */
    private function __construct() {
        
        $this->actionMap = array(
            /* viewable */
            "viewWelcome" => new LoadPage("/view", "welcomeScreen.php"),
            "viewError" => new LoadPage("/view", "displayError.php"),
            "viewLogin" => new LoadPage("/view", "login.php"), // display login page
            "viewRegister" => new LoadPage("/view", "register.php"), // display account registration page
            "viewInfo" => new LoadPage("/view", "info.php"), // display information page
            "viewEditUser" => new ClassLoader("AddUserBalancePage", self::$staffPermission), // view edit user page
            "viewAccountDetails" => new ClassLoader("ViewAccountDetails", self::$userPermission), // view account details page
            "viewBooks" => new ClassLoader("ViewBookList", self::$userPermission), // view a list of books
            "viewAddBook" => new ClassLoader("AddBookForm", self::$staffPermission), // display page to add book
            "viewBasket" => new ClassLoader("ViewBasket", self::$userPermission), // view items in basket
            "viewUserBasket" => new ClassLoader("ViewBasketStaff", self::$staffPermission), // view user's basket (from outside account)
            "viewUsers" => new ClassLoader("ViewUsers", self::$staffPermission), // view a list of users
            "viewAddQuantity" => new ClassLoader("ViewAddQuantity", self::$staffPermission), // view page to add book quantity
            "viewCategories" => new ClassLoader("ViewCategoryList", self::$staffPermission), // view page to add book quantity
            "viewAddCategory" => new ClassLoader("ViewAddCategory", self::$staffPermission), // view page to add book quantity
            
            /* functions */
            "register" => new CreateAccount(), // log in to system
            "login" => new UserLogin(), // log in to system
            "logout" => new ClassLoader("UserLogout", self::$userPermission), // log out from system
            "addBalanceAmount" => new ClassLoader("AddUserBalance", self::$staffPermission), // add balance to user
            "addQuantity" => new ClassLoader("AddQuantity", self::$staffPermission), // add balance to user
            "deleteBook" => new ClassLoader("DeleteBook", self::$staffPermission), // delete a book
            "addBook" => new ClassLoader("AddBook", self::$staffPermission), // add a book
            "addToBasket" => new ClassLoader("AddToBasket", self::$userPermission), // add a book to basket
            "deleteBasketItem" => new ClassLoader("DeleteBasketItem", self::$userPermission), // remove a book from basket
            "processBasket" => new ClassLoader("ProcessBasket", self::$staffPermission), // process a user's basket
            "deleteUser" => new ClassLoader("DeleteUser", self::$staffPermission), // delete a user
            "addCategory" => new ClassLoader("AddCategory", self::$staffPermission), // add a new book category
            "deleteCategory" => new ClassLoader("DeleteCategory", self::$staffPermission) // delete a book category
        );
    }

    /**
     * Returns an action responsible for execution of a certain action (identified by a name of type string);
     * 
     * @param String $actionName
     * @return IAction action
     */
    public function getAction($actionName) {
        if (!isset($this->actionMap[$actionName])) {
            throw new Exception("The action you are trying to run does not exist.");
        }
        
        $action = $this->actionMap[$actionName];
        
        if($action instanceof ClassLoader) {
            return $action->getClassInstance(); // temp workaround until I've structured this better
        } else {
            return $action;
        }
    }

    /**
     * Returns the singleton instance of the action factory.
     * 
     * @return ActionFactory
     */
    public static function getInstance() {
        if (!isset(self::$singletonActionFactory)) {
            self::$singletonActionFactory = new ActionFactory();
        }

        return self::$singletonActionFactory;
    }

}