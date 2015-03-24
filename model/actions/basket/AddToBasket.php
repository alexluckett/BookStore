<?php

/**
 * Adds a book to a user's basket, given a isbn.
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class AddToBasket extends AuthenticatedAction {
    
    public function __construct() {
        parent::__construct(self::userPermission);
    }
    
    public function execute($requestParams) {
        $isbn = $requestParams['isbn'];
        $user = $_SESSION['userId'];
        
        try {
            BasketDAO::addToBasket($user, $isbn);
            $_REQUEST['alertType'] = 'success';
            $_REQUEST['message'] = "Book (".$isbn.") successfully added to basket";
        } catch (Exception $ex) {
            $_REQUEST['message'] = "Book (".$isbn.") is already in your basket.";
        }
        
        $_REQUEST["categories"] = CategoryDAO::getBookCategories();
        $_REQUEST['books'] = BookDAO::getBookList();
    }

    public function pageInclude() {
        return "/view/student/viewBookList.php";
    }

}
