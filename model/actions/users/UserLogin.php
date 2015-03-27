<?php

include_once 'model/UserModel.php';

/**
 * Takes in the user's username and password, then logs them in if appropriate.
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class UserLogin extends GuestAction {
    private $enableRedirect = true;
    
    public function execute($requestParams) {
        $username = $requestParams['username'];
        $password = $requestParams['password'];
        
        $this->authenticate($username, $password);
    }
    
    private function authenticate($username, $password) {
        $user = UserDAO::validateUserLogin($username, $password);

        if (isset($user) && !is_bool($user)) { // if user is a boolean, then query failed. Object returned should be a UserModel.
            $_SESSION['userId'] = $user->userId;
            $_SESSION['username'] = $user->username;
            $_SESSION['permission'] = $user->permission;
            $_SESSION['permissionString'] = $user->permissionString;

            header('Location: index.php'); // reload with new permissions
        } else {
            if(session_status() === PHP_SESSION_ACTIVE) {
                session_destroy();
            }
            
            $this->enableRedirect = false;
            
            $_REQUEST["errorTitle"] = "Invalid login details";
            $_REQUEST["errorMessage"] = "The username or password you supplied was incorrect. Please try again.";
        }
    }

    public function pageInclude() {
        $url = "/index.php";
        
        if($this->enableRedirect === false) { // redirect to login page if failed
            $url = "/view/login.php";
        }
        
        return $url;
    }

}
