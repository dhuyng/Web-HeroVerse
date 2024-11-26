<?php
require_once(__DIR__ . '/../models/MoMoGateway.php');
require_once(__DIR__ . '/../models/ZaloPayGateway.php');

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
        header("Content-Type: application/json; charset=UTF-8");
        http_response_code(200); // 200 OK

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
                    if ($errorCode == '0') {
                        $response['status'] = 'success';
                        $response['message'] = "Payment Successful!";
                        $response['debugger'] = [
                            'rawData' => $rawHash,
                            'momoSignature' => $m2signature,
                            'partnerSignature' => $partnerSignature
                        ];
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
}
?>
