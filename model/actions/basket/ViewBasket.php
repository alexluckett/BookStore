<?php

/**
 * Displays the page to show a user's basket.
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class ViewBasket extends AuthenticatedAction {
    
    public function __construct() {
        parent::__construct(self::userPermission);
    }
    
    public function execute($requestParams) {
        $userId = $_SESSION['userId'];
        $bookList = BasketDAO::getBooksFromBasket($userId);
        
        $_REQUEST['bookList'] = $bookList;
    }

    public function pageInclude() {
        return "/view/student/viewBasket.php";
    }
}
