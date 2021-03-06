<?php

/**
 * Displays the page containing the form for user balance addition.
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class AddUserBalancePage extends AuthenticatedAction {
    
    public function __construct() {
        parent::__construct(self::staffPermission);
    }
    
    public function execute($requestParams) {
        $userId = $_REQUEST['userId'];
        
        $userToEdit = UserDAO::getUser($userId);
        
        $_REQUEST['userToEdit'] = $userToEdit; // send user details to view
    }

    public function pageInclude() {
        return "/view/staff/addUserBalance.php";
    }

}
