<?php

/**
 * Description of AddUserBalancePage
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class AddUserBalancePage extends AuthenticatedAction {
    
    public function execute($requestParams) {
        $userId = $_REQUEST['userId'];
        
        $userToEdit = UserDAO::getUserFromDatabase($userId);
        
        $_REQUEST['userToEdit'] = $userToEdit;
    }

    public function pageInclude() {
        return "/view/staff/addUserBalance.php";
    }

}
