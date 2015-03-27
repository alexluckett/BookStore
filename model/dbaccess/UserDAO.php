<?php

/**
 * Abstraction layer for database communication relating to users.
 *
 * @author Alex Luckett <lucketta@aston.ac.uk>
 */
class UserDAO {
    
    /**
     * Update a user's balance.
     * 
     * @param int $userId
     * @param decimal $balance
     * @return bool
     */
    public static function updateUserBalance($userId, $balance) {
        $db = DatabaseConnection::getDatabase();

        $query = "UPDATE users SET accountBalance = :balance WHERE userId = :userId";

        $statement = $db->prepare($query); // protect against SQL injection
        $statement->bindValue(":userId", $userId);
        $statement->bindValue(":balance", $balance);
        
        $statement->setFetchMode(PDO::FETCH_CLASS, 'UserModel');
        $result = $statement->execute();
        
        return $result;
    }
    
    /**
     * Checks if a given username/password is correct
     * @param string $username
     * @param string $password
     * @return UserModel
     */
    public static function validateUserLogin($username, $password) {
        $db = DatabaseConnection::getDatabase();
        
        $passwordMd5 = md5($password);

        $query = "SELECT users.*, userPermissions.permissionString from users, userPermissions "
                . "WHERE users.username = :username and users.password = :passwordMd5 and users.permission = userPermissions.permissionId";

        $statement = $db->prepare($query); // protect against SQL injection
        $statement->bindValue(":username", $username);
        $statement->bindValue(":passwordMd5", $passwordMd5);
        
        $statement->setFetchMode(PDO::FETCH_CLASS, 'UserModel');
        $statement->execute();
        $user = $statement->fetch();
        
        return $user; // need one user returned, else invalid login details
    }
    
    /**
     * Returns a user from the database, complete with their permissionString.
     * 
     * @param int $userId
     * @return UserModel
     */
    public static function getUser($userId) {
        $db = DatabaseConnection::getDatabase();

        $query = "SELECT users.*, userPermissions.permissionString from users, userPermissions "
                . "WHERE users.userId = :userId and users.permission = userPermissions.permissionId";

        $statement = $db->prepare($query); // protect against SQL injection
        $statement->bindValue(":userId", $userId);
        
        $statement->setFetchMode(PDO::FETCH_CLASS, 'UserModel');
        $statement->execute();
        $user = $statement->fetch();
        
        return $user; // need one user returned, else invalid login details
    }
    
    /**
     * Returns a lsit of students.
     * 
     * @return array
     */
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
    
    /**
     * Creates a new user.
     * 
     * @param string $username
     * @param string $password
     * @param int $permissionLevel
     * @param decimal $accountBalance
     * @return bool
     */
    public static function createUser($username, $password, $permissionLevel, $accountBalance) {
        $db = DatabaseConnection::getDatabase();
        
        $passwordMd5 = md5($password); // not the most secure, but good enough for this coursework

        $query = "INSERT into users VALUES(DEFAULT, :username, :passwordMd5, :permissionLevel, :accountBalance)";
        $statement = $db->prepare($query); // protect against SQL injection
        $statement->bindValue(":username", $username);
        $statement->bindValue(":passwordMd5", $passwordMd5);
        $statement->bindValue(":permissionLevel", $permissionLevel);
        $statement->bindValue(":accountBalance", $accountBalance);
        
        return $statement->execute();
    }
    
    /**
     * Delete an existing user.
     * 
     * @param int $userId
     * @return bool
     */
    public static function deleteUser($userId) {
        $db = DatabaseConnection::getDatabase();

        $query = "DELETE FROM users WHERE userId = :userId";
        $statement = $db->prepare($query); // protect against SQL injection
        $statement->bindValue(":userId", $userId);
        
        return $statement->execute();
    }
    
    /**
     * Helper function to create a new student.
     * 
     * @param string $username
     * @param string $password
     */
    public static function createStudent($username, $password) {
        self::createUser($username, $password, 2, 0); // 2 = student, 0 = no balance
    }
    
}
