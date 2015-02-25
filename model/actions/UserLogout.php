<?php

/**
 * Description of UserLogout
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class UserLogout extends AuthenticatedAction {
    
    public function __construct($permissionInteger) {
        parent::__construct($permissionInteger);
    }
    
    public function execute() {
        session_destroy();
        header('Location: index.php');
    }

    public function pageInclude() { }
    
}
