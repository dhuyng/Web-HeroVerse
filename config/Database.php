<?php

// app/config/Database.php
class Database {
    private static $conn = null;

    // Singleton pattern to return the connection instance
    public static function getConnection() {
        if (self::$conn === null) {
            require_once 'config/database_connect.php';
            self::$conn = $conn;
        }
        return self::$conn;
    }

    // Destructor to explicitly close the connection
    public static function closeConnection() {
        if (self::$conn) {
            mysqli_close(self::$conn);
            self::$conn = null;
        }
    }
}

?>