<?php
require_once("config/env.php");
class Transaction {
    private $partnerCode;
    private $accessKey;
    private $partnerName;
    private $storeId;
    private $requestId;
    private $amount;
    private $orderId;
    private $orderInfo;
    private $redirectUrl;
    private $ipnUrl;
    private $requestType;
    private $extraData;
    private $lang;
    private $signature;

    public function __construct(array $input) {
        // Load sensitive keys from environment variables
        $this->partnerCode = $_ENV['PARTNER_CODE'];
        $this->accessKey = $_ENV['ACCESS_KEY'];
        $this->partnerName = 'Test'; 
        $this->storeId = 'MomoTestStore'; 
        $this->redirectUrl = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/paymentResult'; 
        $this->ipnUrl = 'index.php?ajax=momoGatewayCallbackHandler';
        $this->lang = 'vi';

        // Initialize attributes from the input array
        $this->requestId = time() . "";
        $this->amount = $input['amount'] ?? 10000; 
        $this->orderId = $input['orderId'] ?? time() ."";  
        $this->orderInfo = $input['orderInfo'] ?? "Thanh toán qua MoMo";
        $this->extraData = $input['extraData'] ?? '';
        $this->requestType = 'payWithATM';
    }

    // Method to generate the signature
    public function generateSignature() {
        $rawHash = "accessKey={$this->accessKey}&amount={$this->amount}&extraData={$this->extraData}&ipnUrl={$this->ipnUrl}&orderId={$this->orderId}&orderInfo={$this->orderInfo}&partnerCode={$this->partnerCode}&redirectUrl={$this->redirectUrl}&requestId={$this->requestId}&requestType={$this->requestType}";
        return hash_hmac("sha256", $rawHash, $_ENV['SECRET_KEY']);
    }

    // Prepare data array to be sent to API
    public function toArray() {
        $this->signature = $this->generateSignature();
        
        return [
            'partnerCode' => $this->partnerCode,
            'partnerName' => $this->partnerName,
            'storeId' => $this->storeId,
            'requestId' => $this->requestId,
            'amount' => $this->amount,
            'orderId' => $this->orderId,
            'orderInfo' => $this->orderInfo,
            'redirectUrl' => $this->redirectUrl,
            'ipnUrl' => $this->ipnUrl,
            'requestType' => $this->requestType,
            'extraData' => $this->extraData,
            'lang' => $this->lang,
            'signature' => $this->signature,
        ];
    }

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

    // Send data to MoMo API
    public function sendToMoMo() {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $data = $this->toArray(); 
        $result = $this->execPostRequest($endpoint, json_encode($data));

        $jsonResult = json_decode($result, true); 

        // Return payment URL for redirection
        return $jsonResult['payUrl'];
    }

    public function momoGatewayCallback() {

    }
}
?>
