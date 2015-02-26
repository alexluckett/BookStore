<?php

/**
 * Description of ViewBasketStaff
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class ViewBasketStaff extends AuthenticatedAction {
    
    public function __construct($permissionInteger) {
        parent::__construct($permissionInteger);
    }
    
    public function execute($requestParams) {
        $userId = $requestParams['userId'];
        $user = UserDAO::getUserFromDatabase($userId);
        $bookList = BasketDAO::getBooksFromBasket($userId);
        
        $_REQUEST['bookList'] = $bookList;
        $_REQUEST['user'] = $user;
    }

    public function pageInclude() {
        return "/view/staff/viewStudentBasket.php";
    }
}
