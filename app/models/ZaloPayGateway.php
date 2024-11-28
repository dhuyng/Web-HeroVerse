<?php
require_once("config/env.php");
class ZaloPayGateway {

    public function createOrder(array $input) {
        header('Content-Type: application/json'); // Ensure JSON response type

        $config = [
            "app_id" => 2553,
            "key1" => "PcY4iZIKFCIdgZvA6ueMcMHHUbRLYjPL",
            "key2" => "kLtgPl8HHhfvMuDHPwKfgfsY4Ydm9eIz",
            "endpoint" => "https://sb-openapi.zalopay.vn/v2/create"
        ];

        $embeddata = '{'.
        '"redirecturl": "http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/paymentResult",'.
        '"userId": "' . ($input['extraData']['userId'] ?? ''). '",' .
        '"coins": "' . ($input['extraData']['coins'] ?? ''). '",' .
        '"subscription": "' . ($input['extraData']['subscription'] ?? ''). '",' .
        '"plan": "' . ($input['extraData']['plan'] ?? ''). '"' .
        '}'; // Merchant's data
        $items = '[]'; // Merchant's data
        $transID = date("ymd") . "_" . $_SESSION['user']['username'] . '_'. time();
        $order = [
            "app_id" => $config["app_id"],
            "app_time" => round(microtime(true) * 1000), // milliseconds
            "app_trans_id" => $transID,
            "app_user" => $_SESSION['user']['username'] ?? "user123",
            "item" => $items,
            "callback_url" => "index.php?ajax=zaloPayGatewayCallbackHandler",
            "embed_data" => $embeddata,
            "amount" => $input['amount'] ?? 50000,
            "description" => $input['orderInfo'] ?? "Lazada - Payment for the order #$transID",
            "bank_code" => ""
        ];

        // Generate HMAC signature
        $data = $order["app_id"] . "|" . $order["app_trans_id"] . "|" . $order["app_user"] . "|" . $order["amount"]
            . "|" . $order["app_time"] . "|" . $order["embed_data"] . "|" . $order["item"];
        $order["mac"] = hash_hmac("sha256", $data, $config["key1"]);

        $context = stream_context_create([
            "http" => [
                "header" => "Content-type: application/x-www-form-urlencoded\r\n",
                "method" => "POST",
                "content" => http_build_query($order)
            ]
        ]);

        try {
            $user = new User();
            if (!$user->insertRechargeHistory($input['extraData']['userId'], $transID, $input['amount'], $input['extraData']['coins'] ?? 0, 'zalopay', $input['orderInfo'], 'pending'))
                throw new Exception('Cannot create order');
            $resp = file_get_contents($config["endpoint"], false, $context);
            $result = json_decode($resp, true);
            if ($result === null) { 
                throw new Exception("Invalid JSON response from API");
            }
            // Check for successful response and return the order_url
            if ($result['return_code'] == 1) {
                return $result['order_url'];
            } else {
                throw new Exception("ZaloPay API Error: " . $result['return_message']);
            }
        } catch (Exception $e) {
            return ["error" => $e->getMessage()];
        }

    }
}
