<?php

/**
 * Adds an amount to a user's balance.
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class AddUserBalance extends AuthenticatedAction {
    
    public function __construct($permissionInteger) {
        parent::__construct($permissionInteger);
    }
    
    public function execute($requestParams) {
        $userId = $_REQUEST['userId'];
        $amountToAdd = $_REQUEST['amountToAdd'];
        
        $user = UserDAO::getUserFromDatabase($userId);
        
        if($amountToAdd < 0) {
            throw new Exception("Please input positive numbers in balance.");
        }
        
        UserDAO::updateUserBalance($userId, ($user->accountBalance + $amountToAdd));
        
        $_REQUEST['user'] = UserDAO::getUserFromDatabase($userId); // send updated user back to client page
    }

    public function pageInclude() {
        return "/view/accountDetails.php";
    }

}
