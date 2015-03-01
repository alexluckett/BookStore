<?php

/**
 * Creates a user account based on input parameters in the $_REQUEST array.
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class CreateAccount extends GuestAction {

    public function execute($requestParams) {
        $username = $requestParams['username'];
        $password = $requestParams['password'];
        $passwordConfirm = $requestParams['passwordConfirm'];
        
        if($password === $passwordConfirm) {
            try {
                UserDAO::createStudent($username, $password);
                $this->setMessage("success", "User account created",
                            "Your account has been successfully created with the details you specified.");
            } catch (Exception $ex) {
                $this->setMessage("error", "Invalid account details", "The username you specified is already taken");
            }
        } else {
            $this->setMessage("error", "Invalid login details", "Your passwords do not match. Please try again.");
        }
        
    }

    public function pageInclude() {
        return "/view/register.php";
    }
    
    private function setMessage($type, $title, $message) {
        $_REQUEST['messageType'] = $type;
        $_REQUEST["messageTitle"] = $title;
        $_REQUEST["messageText"] = $message;
    }

}
