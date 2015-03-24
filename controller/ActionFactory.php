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
 * Constrcuts a map of actions, then returns actions associated with it.
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class ActionFactory {
    private static $singletonActionFactory;
    
    private $actionMap;
    
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
            "viewEditUser" => "AddUserBalancePage", // view edit user page
            "viewAccountDetails" => "ViewAccountDetails", // view account details page
            "viewBooks" => "ViewBookList", // view a list of books
            "viewAddBook" => "AddBookForm", // display page to add book
            "viewBasket" => "ViewBasket", // view items in basket
            "viewUserBasket" => "ViewBasketStaff", // view user's basket (from outside account)
            "viewUsers" => "ViewUsers", // view a list of users
            "viewAddQuantity" => "ViewAddQuantity", // view page to add book quantity
            "viewCategories" => "ViewCategoryList", // view page for categories
            "viewAddCategory" => "ViewAddCategory", // view page for adding category
            
            /* functions */
            "register" => "CreateAccount", // log in to system
            "login" => "UserLogin", // log in to system
            "logout" => "UserLogout", // log out from system
            "addBalanceAmount" => "AddUserBalance", // add balance to user
            "addQuantity" => "AddQuantity", // add balance to user
            "deleteBook" => "DeleteBook", // delete a book
            "addBook" => "AddBook", // add a book
            "addToBasket" => "AddToBasket", // add a book to basket
            "deleteBasketItem" => "DeleteBasketItem", // remove a book from basket
            "processBasket" => "ProcessBasket", // process a user's basket
            "deleteUser" => "DeleteUser",// delete a user
            "addCategory" => "AddCategory", // add a new book category
            "deleteCategory" => "DeleteCategory" // delete a book category
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
        
        $actionEntry = $this->actionMap[$actionName];
        
        if(is_string($actionEntry)) { // a bit hacky until I fix this
            $action = new $actionEntry;
            
            if($action instanceof IAction) {
                return $action;
            } else {
                return NULL;
            }
        } else {
            return $actionEntry;
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
