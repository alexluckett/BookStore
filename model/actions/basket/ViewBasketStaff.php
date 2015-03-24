<?php

/**
 * Displays a user's basket to a staff member.
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class ViewBasketStaff extends AuthenticatedAction {
    
    public function __construct() {
        parent::__construct(self::staffPermission);
    }
    
    public function execute($requestParams) {
        $userId = $requestParams['userId'];
        $user = UserDAO::getUser($userId);
        $bookList = BasketDAO::getBooksFromBasket($userId);
        
        $_REQUEST['bookList'] = $bookList;
        $_REQUEST['user'] = $user;
    }

    public function pageInclude() {
        return "/view/staff/viewStudentBasket.php";
    }
}
