<?php

/**
 * Description of UserDAO
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class UserDAO {
    
    public static function updateUserBalance($userId, $balance) {
        $db = DatabaseConnection::getDatabase();

        $query = "UPDATE users SET accountBalance = $balance WHERE userId = $userId";

        $statement = $db->prepare($query); // protect against SQL injection
        $statement->setFetchMode(PDO::FETCH_CLASS, 'UserModel');
        $result = $statement->execute();
        
        return $result;
    }
    
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
    
    /**
     * Returns a user from the database, complete with their permissionString.
     * 
     * @param String $username
     * @param String $passwordMd5 MD5 hash of password
     * @return UserModel
     */
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
    
    public static function createUser($username, $password, $permissionLevel, $accountBalance) {
        $db = DatabaseConnection::getDatabase();
        
        $passwordMd5 = md5($password); // not the most secure, but good enough for this coursework

        $query = "INSERT into users VALUES(DEFAULT, '$username', '$passwordMd5', $permissionLevel, $accountBalance)";
        $statement = $db->prepare($query); // protect against SQL injection
        
        return $statement->execute();
    }
    
    public static function createStudent($username, $password) {
        self::createUser($username, $password, 2, 0); // 2 = student, 0 = no balance
    }
    
}
