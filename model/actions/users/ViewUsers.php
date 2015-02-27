<?php

/**
 * Description of ViewUsers
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class ViewUsers extends AuthenticatedAction {
    
    public function execute($requestParams) {
        $_REQUEST['users'] = UserDAO::getStudents();
    }

    public function pageInclude() {
        return "/view/staff/userList.php";
    }

}
