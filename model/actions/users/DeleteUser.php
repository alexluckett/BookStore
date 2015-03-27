<?php

/**
 * Description of DeleteUser
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class DeleteUser extends AuthenticatedAction {
   
    public function __construct() {
        parent::__construct(self::staffPermission);
    }

    public function execute($requestParams) {
        $userId = $requestParams['userId'];
        $user = UserDAO::getUser($userId);
        
        if($user->permissionString == "Staff") {
            throw new Exception("Administrators cannot be deleted.");
        }
        
        BasketDAO::emptyBasket($userId); // basket must be emptied first (foreign key constraints)
        UserDAO::deleteUser($userId);
        
        $_REQUEST['users'] = UserDAO::getStudents(); // refresh updated users
    }

    public function pageInclude() {
        return "/view/staff/viewUserList.php";
    }

}
