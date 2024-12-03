<?php
// app/controllers/DashboardController.php
require_once('BaseController.php');
require_once(__DIR__ . '/../models/User.php');
require_once(__DIR__ . '/../models/Support.php');
require_once(__DIR__ . '/../models/RechargeHist.php');
require_once(__DIR__ . '/../models/Event.php');

class DashboardController extends BaseController{

    public function countUsers(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $response = [
                'status' => 'error',
                'message' => 'Invalid request method'
            ];
            $userModel = new User();
            $count = $userModel->countUsers();

            if($count){
                $response = [
                    'status' => 'success',
                    'message' => 'Users count fetched successfully',
                    'data' => $count
                ];
            }
            else {
                $response = [
                    'status' => 'error',
                    'message' => 'Failed to fetch users count'
                ];
            }
            echo json_encode($response);
    }
    }


    public function countSupports(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $response = [
                'status' => 'error',
                'message' => 'Invalid request method'
            ];
            $supportModel = new Support();
            $count = $supportModel->countSupports();
            error_log('----------countSupports' . $count);
            if($count){
                $response = [
                    'status' => 'success',
                    'message' => 'Supports count fetched successfully',
                    'data' => $count
                ];
            }
            else {
                $response = [
                    'status' => 'error',
                    'message' => 'Failed to fetch supports count'
                ];
            }
            echo json_encode($response);
    }
}

public function countUserbyMonth(){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $response = [
            'status' => 'error',
            'message' => 'Invalid request method'
        ];
        $userModel = new User();
        $count = $userModel->countUserbyMonth();

        $labels = [];
        $values = [];

        foreach($count as $row) {
            $labels[] = $row['month'];
            $values[] = (int)$row['user_count'];
        }


        error_log('----------countUserbyMonth' . print_r($labels,true));

        if($count){
            $response = [
                'status' => 'success',
                'message' => 'Users count fetched successfully',
                'data' => [
                    'labels' => $labels,
                    'values' => $values
                ]
            ];
        }
        else {
            $response = [
                'status' => 'error',
                'message' => 'Failed to fetch users count'
            ];
        }
        echo json_encode($response);
}
}

public function countEvents(){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $response = [
            'status' => 'error',
            'message' => 'Invalid request method'
        ];
        $eventModel = new Event();
        $count = $eventModel->countEvents();

        error_log('----------countEvents' . $count);

        if($count){
            $response = [
                'status' => 'success',
                'message' => 'Events count fetched successfully',
                'data' => $count
            ];
        }
        else {
            $response = [
                'status' => 'error',
                'message' => 'Failed to fetch events count'
            ];
        }
        echo json_encode($response);
}
}

public function coinForPayment(){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $response = [
            'status' => 'error',
            'message' => 'Invalid request method'
        ];
        $rechargeHistModel = new RechargeHist();
        $count = $rechargeHistModel->coinForPayment();

        $labels = [];
        $values = [];
        $percentages = [];

        foreach($count as $row) {
            $labels[] = $row['payment_method'];
            $values[] = (int)$row['total_coins'];
            $percentages[] = (float)$row['percentage_of_total_coins'];
        }

        if($count){
            $response = [
                'status' => 'success',
                'message' => 'Coin for payment fetched successfully',
                'data' => [
                    'labels' => $labels,
                    'values' => $values,
                    'percentages' => $percentages
                ]
            ];
        }
        else {
            $response = [
                'status' => 'error',
                'message' => 'Failed to fetch coin for payment'
            ];
        }
        echo json_encode($response);
}
}
}