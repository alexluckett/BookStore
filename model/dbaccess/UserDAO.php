<?php

/**
 * Description of UserDAO
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class UserDAO {
    
    public static function validateUserLogin($username, $passwordMd5) {
        $db = DatabaseConnection::getDatabase();

        $query = "SELECT users.*, userPermissions.permissionString from users, userPermissions "
                . "WHERE users.username = '$username' and users.password = '$passwordMd5' and users.permission = userPermissions.permissionId";

        $statement = $db->prepare($query); // protect against SQL injection
        $statement->setFetchMode(PDO::FETCH_CLASS, 'UserModel');
        $statement->execute();
        $user = $statement->fetch();
        return $user; // need one user returned, else invalid login details
    }
    
    public static function getUserFromDatabase($userId) {
        $db = DatabaseConnection::getDatabase();

        $query = "SELECT users.*, userPermissions.permissionString from users, userPermissions "
                . "WHERE users.userId = '$userId' and users.permission = userPermissions.permissionId";

        $statement = $db->prepare($query); // protect against SQL injection
        $statement->setFetchMode(PDO::FETCH_CLASS, 'UserModel');
        $statement->execute();
        $user = $statement->fetch();
        return $user; // need one user returned, else invalid login details
    }
    
    public static function getStudents() {
        $db = DatabaseConnection::getDatabase();

        $query = "SELECT users.*, userPermissions.permissionString from users, userPermissions "
                . "WHERE userPermissions.permissionId = 2 and users.permission = userPermissions.permissionId";

        $statement = $db->prepare($query); // protect against SQL injection
        $statement->setFetchMode(PDO::FETCH_CLASS, 'UserModel');
        $statement->execute();
        $users = $statement->fetchAll();
        return $users;
    }
    
}
