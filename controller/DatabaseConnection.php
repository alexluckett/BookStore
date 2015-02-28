<?php

class DatabaseConnection {

    private static $db;

    private static function constructDatabase() {
        $dbType = "mysql";
        $dbHost = "localhost";
        $dbName = "bookstore";
        $dbUser = "root";
        $dbPass = "root";

        self::$db = new PDO("$dbType:dbname=$dbName;host=$dbHost", $dbUser, $dbPass);
        self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getDatabase() {
        if (empty(self::$db)) {
            self::constructDatabase();
        }

        return self::$db;
    }

}

?>