<?php 
// app/models/Support.php

require_once(__DIR__ . "/../../config/Database.php");

class Support {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function countSupports() {
        $query = "SELECT COUNT(*) as count FROM support where is_processed = 0";
        $stmt = mysqli_prepare($this->db, $query);
        if ($stmt) {
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $count);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);
            return $count;
        }
        return false;
    }

    public function saveQuestion($title, $question) {
        $query = "INSERT INTO support (title, question) VALUES (?, ?)";
        $stmt = mysqli_prepare($this->db, $query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'ss', $title, $question);
            mysqli_stmt_execute($stmt);
            $affectedRows = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $affectedRows > 0;
        }
        return false;
    }
}