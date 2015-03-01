<?php

class DatabaseConnection {

    private static $db;

    /**
     * Initialises a connection to the database.
     */
    private static function initialiseConnection() {
        $dbType = "mysql";
        $dbHost = "localhost";
        $dbName = "bookstore";
        $dbUser = "root";
        $dbPass = "root";

        self::$db = new PDO("$dbType:dbname=$dbName;host=$dbHost", $dbUser, $dbPass);
        self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Returns a singleton instance of the PDO.
     * @return PDO
     */
    public static function getDatabase() {
        if (empty(self::$db)) {
            self::initialiseConnection();
        }

        return self::$db;
    }

}

?>