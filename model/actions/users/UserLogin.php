<?php

include_once 'model/UserModel.php';

/**
 * Description of UserLogin
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
        $passwordMd5 = md5($password);

        $user = UserDAO::validateUserLogin($username, $passwordMd5);

        if (isset($user) && !is_bool($user)) {
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
        
        if($this->enableRedirect === false) {
            $url = '/view/login.php';
        }
        
        return $url;
    }

}
