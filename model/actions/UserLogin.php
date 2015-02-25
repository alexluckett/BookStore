<?php

include 'model/domainmodels/userModel.php';

/**
 * Description of UserLogin
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class UserLogin extends GuestAction {
    
    public function execute() {
        $this->authenticate($_POST['username'], $_POST['password']);
    }
    
    private function authenticate($username, $password) {
        $passwordMd5 = md5($password);

        $user = $this->getUserFromDatabase($username, $passwordMd5);

        if (isset($user) && !is_bool($user)) {
            $_SESSION['username'] = $user->username;
            $_SESSION['permission'] = $user->permission;
            $_SESSION['permissionString'] = $user->permissionString;

            header('Location: index.php'); // reload with new permissions
        } else {
            if(session_status() === PHP_SESSION_ACTIVE) {
                session_destroy();
            }
            
            echo 'log in attempt: fail. <a href="index.php">Go back?</a>';
        }
    }

    /**
     * Returns a user from the database, complete with their permissionString.
     * 
     * @param String $username
     * @param String $passwordMd5 MD5 hash of password
     * @return UserModel
     */
    private function getUserFromDatabase($username, $passwordMd5) {
        $db = DatabaseConnection::getDatabase();

        $query = "SELECT users.*, userPermissions.permissionString from users, userPermissions "
                . "WHERE users.username = '$username' and users.password = '$passwordMd5' and users.permission = userPermissions.permissionId";

        $statement = $db->prepare($query); // protect against SQL injection
        $statement->setFetchMode(PDO::FETCH_CLASS, 'UserModel');
        $statement->execute();
        $user = $statement->fetch();
        return $user; // need one user returned, else invalid login details
    }

    public function pageInclude() {
        return "/index.php";
    }

}
