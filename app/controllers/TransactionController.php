<?php
require_once(__DIR__ . '/../models/MoMoGateway.php');
require_once(__DIR__ . '/../models/ZaloPayGateway.php');
require_once(__DIR__ . '/../models/User.php');
class TransactionController {
    public function confirmTransaction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            $paymentMethod = $data['paymentMethod'];
            $transactionData = array_diff_key($data, ['paymentMethod' => '']);
            if ($paymentMethod === 'momo') {
                $moMoGatewayModel = new MoMoGateway();
                $payUrl = $moMoGatewayModel->sendToMoMo($transactionData);
                if ($payUrl) {
                    echo json_encode(['success' => true, 'payUrl' => $payUrl]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to get payment URL']);
                }
            } else if ($paymentMethod === 'zalopay') {
                $zaloPayGateway = new ZaloPayGateway();
                $order_url = $zaloPayGateway->createOrder($transactionData);
                if ($order_url) {
                    echo json_encode(['success' => true, 'payUrl' => $order_url]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to get payment URL']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid payment gateway']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
        }
    }
    public function momoGatewayCallbackHandler() {
        error_log('momoGatewayCallbackHandler');
        header("Content-Type: application/json; charset=UTF-8");
        http_response_code(200); // 200 OK
        error_log('momoGatewayCallbackHandler');

        $response = array();
        if (!empty($_POST)) {
            try {
                $partnerCode = $_POST["partnerCode"];
                $accessKey = $_POST["accessKey"];
                $orderId = $_POST["orderId"];
                $orderInfo = $_POST["orderInfo"];
                $amount = $_POST["amount"];
                $errorCode = $_POST["errorCode"];
                $transId = $_POST["transId"];
                $message = $_POST["message"];
                $localMessage = $_POST["localMessage"];
                $responseTime = $_POST["responseTime"];
                $requestId = $_POST["requestId"];
                $extraData = $_POST["extraData"];
                $payType = $_POST["payType"];
                $m2signature = $_POST["signature"]; // MoMo signature

                //Checksum
                $rawHash = "partnerCode={$partnerCode}&accessKey={$accessKey}&requestId={$requestId}&amount={$amount}&orderId={$orderId}&orderInfo={$orderInfo}&orderType={$_POST['orderType']}&transId={$transId}&message={$message}&localMessage={$localMessage}&responseTime={$responseTime}&errorCode={$errorCode}&payType={$payType}&extraData={$extraData}";
                
                $partnerSignature = hash_hmac("sha256", $rawHash, $_ENV['SECRET_KEY']);

                if ($m2signature === $partnerSignature) {
                    error_log('$m2signature === $partnerSignature');
                    if ($errorCode == '0') {
                        error_log('$errorCode == \'0\'');
                        $response['status'] = 'success';
                        $response['message'] = "Payment Successful!";
                        $response['debugger'] = [
                            'rawData' => $rawHash,
                            'momoSignature' => $m2signature,
                            'partnerSignature' => $partnerSignature
                        ];
                        // Give user balance and save transaction history
                        $user = new User();
                        $extraData = json_decode(base64_decode($extraData), true);
                        error_log(print_r($extraData, true)); // This will log the content of extraData for debugging

                        if ($user->insertRechargeHistory($extraData['userId'], $orderId, $amount, $extraData['coins'], 'momo', $orderInfo, 'completed')) {
                            $user->updateUserBalance($extraData['userId'], +$amount);
                        } else {
                            $response['status'] = 'error';
                            $response['message'] = "Failed to insert recharge history.";
                        }
                    } else {
                        $response['status'] = 'error';
                        $response['message'] = "Payment Failed: " . $message;
                    }
                } else {
                    $response['status'] = 'error';
                    $response['message'] = "Signature mismatch. Please verify your signature.";
                }

            } catch (Exception $e) {
                $response['status'] = 'error';
                $response['message'] = "An error occurred: " . $e->getMessage();
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = "No POST data received.";
        }

        echo json_encode($response);
    }

    public function zaloPayGatewayCallbackHandler() {
        error_log("ZaloPAY CALLED BACKED");
        $result = [];

        try {
        $key2 = "kLtgPl8HHhfvMuDHPwKfgfsY4Ydm9eIz";
        $postdata = file_get_contents('php://input');
        $postdatajson = json_decode($postdata, true);
        $mac = hash_hmac("sha256", $postdatajson["data"], $key2);

        $requestmac = $postdatajson["mac"];

        // kiểm tra callback hợp lệ (đến từ ZaloPay server)
        if (strcmp($mac, $requestmac) != 0) {
            // callback không hợp lệ
            $result["return_code"] = -1;
            $result["return_message"] = "mac not equal";
        } else {
            // thanh toán thành công
            // merchant cập nhật trạng thái cho đơn hàng
            $datajson = json_decode($postdatajson["data"], true);
            // echo "update order's status = success where app_trans_id = ". $dataJson["app_trans_id"];
            // $user = new User();
            // $embeddata = $datajson['embeddata'];
            // if ($user->insertRechargeHistory($embeddata['userId'], $embeddata['orderId'], $datajson['amount'], $embeddata['coins'], 'zalopay', $embeddata['orderInfo'], 'completed'))
            //     $user->updateUserBalance($embeddata['userId'], +$datajson['amount']);
            $result["return_code"] = 1;
            $result["return_message"] = "success";
        }
        } catch (Exception $e) {
        $result["return_code"] = 0; // ZaloPay server sẽ callback lại (tối đa 3 lần)
        $result["return_message"] = $e->getMessage();
        }

        // thông báo kết quả cho ZaloPay server
        echo json_encode($result);
    }






    public function momoGatewayCallbackHandlerResult() {
        $response = array();
        $postdata = file_get_contents('php://input');
        $postdatajson = json_decode($postdata, true);
        if (!empty($postdatajson)) {
            try {
                $orderId = $postdatajson["orderId"];
                $orderInfo = $postdatajson["orderInfo"];
                $amount = $postdatajson["amount"];
                $extraData = $postdatajson["extraData"];
                // Give user balance and save transaction history
                $user = new User();
                $extraData = json_decode(base64_decode($extraData), true);
                $coins = $extraData['coins'];
                if ($user->insertRechargeHistory($extraData['userId'], $orderId, $amount, $coins, 'momo', $orderInfo, 'completed')) {
                    if (!($extraData['subscription'] ?? false)){
                        $user->updateUserBalance($extraData['userId'], +$coins);
                        $_SESSION['user']['balance'] += $coins;
                    }
                    else if ($extraData['plan']) {
                        $user->updateUserTier($extraData['userId'], $extraData['plan']);
                        $_SESSION['user']['subscription_type'] = $extraData['plan'];
                    }
                } else {
                    $response['status'] = 'error';
                    $response['message'] = "Failed to insert recharge history.";
                }
                    
            } catch (Exception $e) {
                $response['status'] = 'error';
                $response['message'] = "An error occurred: " . $e->getMessage();
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = "No POST data received.";
        }

        echo json_encode($response);
    }

    public function zaloPayGatewayCallbackHandlerResult() {
        $response = array();
        $postdata = file_get_contents('php://input');
        $postdatajson = json_decode($postdata, true);
    
        if (!empty($postdatajson)) {
            try {
                $apptransid = $postdatajson["apptransid"];
                $status = $postdatajson["status"];
                $user = new User();
                if ($result = $user->completedRechargeHistory($apptransid, $status)) {
                    $description = $result['description'];
                    $plan = null;
    
                    // Match subscription plan from the description
                    if (preg_match('/Subscription Plan: (\w+)/', $description, $matches)) {
                        $plan = strtolower($matches[1]); // Extract plan name (e.g., "premium" or "pro")
                    }
    
                    if ($plan) {
                        // Update user tier if subscription plan is found
                        $user->updateUserTier($result['userId'], $plan);
                        $_SESSION['user']['subscription_type'] = $plan;
                    } else {
                        // Otherwise, update user balance
                        $user->updateUserBalance($result['userId'], +$result['coins']);
                        $_SESSION['user']['balance'] += $result['coins'];
                    }
                    $response['status'] = 'success';
                    $response['message'] = 'Transaction processed successfully.';
                } else {
                    $response['status'] = 'error';
                    $response['message'] = "Failed to process transaction history.";
                }
            } catch (Exception $e) {
                $response['status'] = 'error';
                $response['message'] = "An error occurred: " . $e->getMessage();
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = "No POST data received.";
        }
    
        echo json_encode($response);
    }
    
    public function getUserBalance(){
        // Check if it's an AJAX request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user']['id'])) {
                echo json_encode(['success' => false, 'message' => 'User not logged in']);
                return;
            }
            $userId = $_SESSION['user']['id'];
            $userModel = new User();
            $balance = $userModel->getUserBalance($userId);
    
            // Return JSON response
            if ($balance) {
                echo json_encode(['success' => true, 'balance' => $balance]);
            } else {
                echo json_encode(['success' => false, 'message' => 'No user balance found']);
            }
        } else {
            // If not an AJAX request, return an error
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
        }
    }

}
?>
