<?php
ini_set('display_errors', 1);

class DatabaseConnection {
    private static $db;
    
    private function __construct() {
        $dbType = "mysql";
        $dbHost = "localhost";
        $dbName = "bookstore";
        $dbUser = "root";
        $dbPass = "root";
        
        self::$db = new PDO("$dbType:dbname=$dbName;host=$dbHost", $dbUser, $dbPass);
        self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        var_dump(self::$db);
    }
    
    public static function getDatabase() {
        if(empty(self::$singleton)) {            
            $dbType = "mysql";
            $dbHost = "localhost";
            $dbName = "bookstore";
            $dbUser = "root";
            $dbPass = "root";

            self::$db = new PDO("$dbType:dbname=$dbName;host=$dbHost", $dbUser, $dbPass);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        
        return self::$db;
    }
}

?>