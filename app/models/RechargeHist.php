<?php 
// app/models/RechargeHist.php

require_once(__DIR__ . "/../../config/Database.php");

class RechargeHist {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function coinForPayment() {
        $query = "SELECT 
                    payment_method,
                    SUM(coins) AS total_coins,
                    (SUM(coins) / (SELECT SUM(coins) FROM recharge_history) * 100) AS percentage_of_total_coins
                FROM 
                    recharge_history
                GROUP BY 
                    payment_method;
";
        $stmt = mysqli_prepare($this->db, $query);

        if ($stmt) {
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $payment_method, $total_coins, $percentage_of_total_coins);

            $result = [];
            while (mysqli_stmt_fetch($stmt)) {
                $result[] = [
                    'payment_method' => $payment_method,
                    'total_coins' => $total_coins,
                    'percentage_of_total_coins' => $percentage_of_total_coins
                ];
            }

            mysqli_stmt_close($stmt);
            return $result;
        }
        return false;
}
}