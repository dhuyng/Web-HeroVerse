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
        $rechargeQuery = "SELECT id, orderId, date, amount, coins, payment_method, status, description FROM recharge_history WHERE user_id = ? ORDER BY date DESC";
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

    public function insertRechargeHistory($userId, $orderId, $amount, $coins, $paymentMethod, $description = '', $status = 'pending'): bool {
        $queryUser = "SELECT username FROM users WHERE id = ?";
        $stmtUser = mysqli_prepare($this->db, $queryUser);
    
        if (!$stmtUser) {
            error_log("Error preparing user query: " . mysqli_error($this->db));
            return false;
        }
        mysqli_stmt_bind_param($stmtUser, "i", $userId);
        if (!mysqli_stmt_execute($stmtUser)) {
            // error_log("Error executing user query: " . mysqli_stmt_error($stmtUser));
            return false;
        }
        $resultUser = mysqli_stmt_get_result($stmtUser);
        $user = mysqli_fetch_assoc($resultUser);
        if (!$user) {
            error_log("User not found for ID: " . $userId);
            return false;
        }
        $orderId = $orderId ?? $user['username'] . "_" . time();
        $query = "INSERT INTO recharge_history (user_id, orderId, amount, coins, payment_method, status, description) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->db, $query);
        if (!$stmt) {
            error_log("Error preparing insert query: " . mysqli_error($this->db));
            return false;
        }
        mysqli_stmt_bind_param($stmt, "isdssss", $userId, $orderId, $amount, $coins, $paymentMethod, $status, $description);
        if (!mysqli_stmt_execute($stmt)) {
            error_log("Error executing insert query: " . mysqli_stmt_error($stmt));
            return false;
        }
    
        return true;
    }
    

    public function updateUserBalance($userId, $amount) {
        $sql = "UPDATE users SET balance = balance + ? WHERE id = ?";
        $stmt = mysqli_prepare($this->db, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "di", $amount, $userId);
            $result = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            return $result;
        } else {
            return false;
        }
    }

    public function updateUserTier($userId, $tier) {
        $sql = "UPDATE users SET subscription_type = ? WHERE id = ?";
        $stmt = mysqli_prepare($this->db, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "si", $tier, $userId);
            $result = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            return $result;
        } else {
            return false;
        }
    }

    public function spendUserBalance($userId, $amount) {
        if ($amount < 0) {
            throw new InvalidArgumentException("Amount must be a positive value.");
        }
        $sql = "SELECT balance FROM users WHERE id = ?";
        $stmt = mysqli_prepare($this->db, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $userId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $currentBalance);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);

            if ($currentBalance >= $amount) {
                return $this->updateUserBalance($userId, $amount);
            }
            return false; //Insufficient funds
        }
        return false; //Query failed
    }
    
    public function completedRechargeHistory($apptransid) {
        $query = "SELECT status, description, user_id, coins FROM recharge_history WHERE orderId = ?";
        $stmt = mysqli_prepare($this->db, $query);
        mysqli_stmt_bind_param($stmt, "s", $apptransid);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $recharge = mysqli_fetch_assoc($result);
    
        if (!$recharge) {
            return false; // Order not found
        }
        
        if ($recharge['status'] !== 'completed') {
            $updateQuery = "UPDATE recharge_history SET status = 'completed' WHERE orderId = ?";
            $updateStmt = mysqli_prepare($this->db, $updateQuery);
            mysqli_stmt_bind_param($updateStmt, "s", $apptransid);
            mysqli_stmt_execute($updateStmt);
        } else return false;
    
        // Return the required details
        return [
            'description' => $recharge['description'],
            'userId' => $recharge['user_id'],
            'coins' => $recharge['coins']
        ];
    }

    public function getUserBalance($userId) {
        $query = "SELECT balance FROM users WHERE id = ?";
        if ($stmt = mysqli_prepare($this->db, $query)){
            mysqli_stmt_bind_param($stmt, "i", $userId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            return mysqli_fetch_assoc($result)['balance'];
        }
        return false;
    }
    

}
