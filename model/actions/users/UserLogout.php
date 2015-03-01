<?php

/**
 * Logs out the current user.
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class UserLogout extends AuthenticatedAction {
    
    public function __construct($permissionInteger) {
        parent::__construct($permissionInteger);
    }
    
    public function execute($requestParams) {
        session_destroy();
        header('Location: index.php');
    }

    public function pageInclude() { }
    
}
