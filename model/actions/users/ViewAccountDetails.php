<?php

/**
 * Displays the page for showing account details.
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class ViewAccountDetails extends AuthenticatedAction {
    
    public function __construct($permissionInteger) {
        parent::__construct($permissionInteger);
    }

    public function execute($requestParams) {
        $userId = $_SESSION['userId'];
        
        $user = UserDAO::getUser($userId);
        
        $_REQUEST['user'] = $user;
    }

    public function pageInclude() {
        return "/view/accountDetails.php";
    }

}
