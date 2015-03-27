<?php

/**
 * Responsible for deleting a book from a user's basket.
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class DeleteBasketItem extends AuthenticatedAction {
    
    public function __construct() {
        parent::__construct(self::userPermission);
    }
    
    public function execute($requestParams) {
        if(!isset($requestParams['isbn'])) {
            throw new Exception("Please give a valid book ISBN");
        }
        
        $userId = $_SESSION['userId'];
        $isbn = $requestParams['isbn'];
        
        $success = BasketDAO::removeFromBasket($userId, $isbn);
        
        if($success) {
            $_REQUEST['message'] = "Book ($isbn) successfully removed from basket.";
        }
        
        $_REQUEST['bookList'] = BasketDAO::getBooksFromBasket($userId); // refresh list of books in basket
    }

    public function pageInclude() {
        return "/view/student/viewBasket.php";
    }

}
