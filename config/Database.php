<?php
// app/config/Database.php
class Database {
    private static $conn = null;

    public static function getConnection() {
        if (self::$conn === null) {
            require_once 'config/database_connect.php';  // Đảm bảo đường dẫn đúng
            self::$conn = $conn;
        }
        return self::$conn;
    }

    public static function closeConnection() {
        if (self::$conn) {
            mysqli_close(self::$conn);
            self::$conn = null;
        }
    }
}
?>
