<?php

/**
 * Description of UserLogout
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class UserLogout extends AuthenticatedAction {
    
    public function execute() {
        session_destroy();
    }

    public function pageInclude() {
        return "";
    }
    
}
