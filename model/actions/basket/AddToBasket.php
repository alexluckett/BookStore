<?php

/**
 * Description of AddToBasket
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class AddToBasket extends AuthenticatedAction {
    
    public function __construct($permissionInteger) {
        parent::__construct($permissionInteger);
    }
    
    public function execute($requestParams) {
        $isbn = $requestParams['isbn'];
        $user = $_SESSION['userId'];
        
        try {
            BasketDAO::addToBasketInDatabase($user, $isbn);
            $_REQUEST['alertType'] = 'success';
            $_REQUEST['message'] = "Book (".$isbn.") successfully added to basket";
        } catch (Exception $ex) {
            $_REQUEST['message'] = "Book (".$isbn.") is already in your basket.";
        }
        
        $_REQUEST["categories"] = BookDAO::getBookCategories();
        $_REQUEST['books'] = BookDAO::getBooksFromDatabase();
    }

    public function pageInclude() {
        return "/view/student/viewBookList.php";
    }

}
