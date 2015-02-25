<?php

/**
 * A type of action to only be run when the user is authenticated (valid logged in).
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
abstract class AuthenticatedAction implements IAction {
    
    private $minimumPermissionLevel;
    
    public function __construct($permissionInteger) {
        $this->minimumPermissionLevel = $permissionInteger;
    }
    
    public abstract function execute();
    public abstract function pageInclude();
    
    public function isLegalRequest() {
        $sessionPermission = $_SESSION['permission'];
        
        if(isset($sessionPermission)) {
            return false;
        } else {
            return ($sessionPermission >= $this->minimumPermissionLevel); // true if user has required permission level or above
        }
    }
}
