<?php
// app/models/User.php
require_once(__DIR__ . "/../../config/Database.php");
class User {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function register($username, $email, $password, $role): bool {
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

    public function updateUserInfo($userId, $email, $newPassword = null, $profilePic, $twoFA) {
        $query = "UPDATE users SET email = ?, profile_pic = ?, two_fa_enabled = ? WHERE id = ?";
    
        $stmt = mysqli_prepare($this->db, $query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssi", $email, $profilePic, $twoFA, $userId);
            $result = mysqli_stmt_execute($stmt);
    
            // Update password only if provided
            if ($newPassword) {
                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                $passwordQuery = "UPDATE users SET password = ? WHERE id = ?";
                $passwordStmt = mysqli_prepare($this->db, $passwordQuery);
                mysqli_stmt_bind_param($passwordStmt, "si", $hashedPassword, $userId);
                mysqli_stmt_execute($passwordStmt);
            }
    
            return $result;
        }
        return false;
    }

    

    public function updateAdminInfo($userId, $newPassword = null, $profilePic) {
        $query = "UPDATE users SET profile_pic = ? WHERE id = ?";
    
        $stmt = mysqli_prepare($this->db, $query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "si", $profilePic, $userId);
            $result = mysqli_stmt_execute($stmt);
    
            // Update password only if provided
            if ($newPassword) {
                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                $passwordQuery = "UPDATE users SET password = ? WHERE id = ?";
                $passwordStmt = mysqli_prepare($this->db, $passwordQuery);
                mysqli_stmt_bind_param($passwordStmt, "si", $hashedPassword, $userId);
                mysqli_stmt_execute($passwordStmt);
            }
    
            return $result;
        }
        return false;
    }
    

    // Add method to verify current password
    public function verifyCurrentPassword($userId, $currentPassword) {
        $query = "SELECT password FROM users WHERE id = ?";
        $stmt = mysqli_prepare($this->db, $query);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $userId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $user = mysqli_fetch_assoc($result);
            
            if ($user && password_verify($currentPassword, $user['password'])) {
                return true;
            }
        }
        
        return false;
    }

    public function getTransactionHistory($userId) {
        $transactionHistory = [];
    
        // Fetch Recharge History
        $rechargeQuery = "SELECT date, amount, coins, payment_method, status FROM recharge_history WHERE user_id = ? ORDER BY date DESC";
        $stmt = mysqli_prepare($this->db, $rechargeQuery);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $userId);
            mysqli_stmt_execute($stmt);
            $rechargeResult = mysqli_stmt_get_result($stmt);
            $transactionHistory['recharges'] = mysqli_fetch_all($rechargeResult, MYSQLI_ASSOC);
            mysqli_stmt_close($stmt);
        } else {
            $transactionHistory['recharges'] = [];
        }
    
        // Fetch Usage History
        $usageQuery = "SELECT date, coins_used, description FROM usage_history WHERE user_id = ? ORDER BY date DESC";
        $stmt = mysqli_prepare($this->db, $usageQuery);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $userId);
            mysqli_stmt_execute($stmt);
            $usageResult = mysqli_stmt_get_result($stmt);
            $transactionHistory['usages'] = mysqli_fetch_all($usageResult, MYSQLI_ASSOC);
            mysqli_stmt_close($stmt);
        } else {
            $transactionHistory['usages'] = [];
        }
    
        return $transactionHistory;
    }

}
