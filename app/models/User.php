<?php
// app/models/User.php
require_once(__DIR__ . "/../../config/Database.php");
class User {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function register($username, $email, $password, $role) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $query = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->db, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $hashedPassword, $role);
            return mysqli_stmt_execute($stmt);
        } else {
            return false;
        }
    }

    // Login method
    public function login($username, $password): array | bool {
        $query = "SELECT * FROM users WHERE username = ? OR email = ?";
        $stmt = mysqli_prepare($this->db, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $username, $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $user = mysqli_fetch_assoc($result);

            if ($user && password_verify($password, $user['password'])) {
                return $user;
            }
        }
        return false;
    }

    public function getUserById($id) {
        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = mysqli_prepare($this->db, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            return mysqli_fetch_assoc($result);
        }
        return null;
    }
}
