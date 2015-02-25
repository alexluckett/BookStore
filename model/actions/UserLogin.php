<?php

/**
 * Description of UserLogin
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class UserLogin extends AuthenticatedAction {
    
    public function execute() {
        $this->authenticate();
    }
    
    private function authenticate($username, $password) {
        $passwordMd5 = md5($password);

        $user = $this->getUserFromDatabase($username, $passwordMd5);

        if (isset($user) && !is_bool($user)) {
            $_SESSION['username'] = $user->username;

            $permission = $user->permission;
            $_SESSION['permission'] = $permission;
            $_SESSION['permissionString'] = $user->permissionString;
            $_SESSION['currentUser'] = $user;

            header('Location: index.php'); // reload with new permissions
        } else {
            session_destroy();
            echo 'log in attempt: fail';
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

        if (sizeof($user) != 1) {
            throw new Exception('Critical error: multiple users returned for username and password. Terminating.');
        }

        return $user; // need one user returned, else invalid login details
    }

    public function pageInclude() {
        return "index.php";
    }

}
