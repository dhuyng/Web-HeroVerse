<?php
require_once("config/env.php");
class MoMoGateway {
    // Method to execute a POST request
    public function execPostRequest($url, $data) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function sendToMoMo(array $input) {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $data = [
            // Load sensitive keys from environment variables
            'partnerCode' => $_ENV['PARTNER_CODE'],
            'accessKey' => $_ENV['ACCESS_KEY'],
            'partnerName' => 'Test',
            'storeId' => 'MomoTestStore',
            'redirectUrl' => "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/paymentResult', 
            'ipnUrl' => 'index.php?ajax=momoGatewayCallbackHandler',
            'lang' => 'vi',
    
            // Initialize attributes from the input array
            'requestId' => time() . "",
            'amount' => $input['amount'] ?? 10000,
            'orderId' => $input['orderId'] ?? time() ."",
            'orderInfo' => $input['orderInfo'] ?? "Thanh toán qua MoMo",
            'extraData' => $input['extraData'] ?? '',
            'requestType' => 'payWithATM'
        ];
        $rawHash = "accessKey={$data['accessKey']}&amount={$data['amount']}&extraData={$data['extraData']}&ipnUrl={$data['ipnUrl']}&orderId={$data['orderId']}&orderInfo={$data['orderInfo']}&partnerCode={$data['partnerCode']}&redirectUrl={$data['redirectUrl']}&requestId={$data['requestId']}&requestType={$data['requestType']}";
        $data['signature'] = hash_hmac("sha256", $rawHash, $_ENV['SECRET_KEY']);
        
        $result = $this->execPostRequest($endpoint, json_encode($data));

        $jsonResult = json_decode($result, true); 

        // Return payment URL for redirection
        return $jsonResult['payUrl'];
    }
}
