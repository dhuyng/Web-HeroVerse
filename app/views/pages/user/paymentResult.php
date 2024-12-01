<?php
require_once("config/env.php");
$secretKey = $_ENV['SECRET_KEY'];
$key2 = 'kLtgPl8HHhfvMuDHPwKfgfsY4Ydm9eIz';
$result = "";
$thankYouMessage = "";

if (!empty($_GET)) {
    // MoMo Parameters
    $momoParams = [
        "partnerCode", "orderId", "requestId", "amount", "orderInfo", 
        "orderType", "transId", "resultCode", "message", "payType", 
        "responseTime", "extraData", "signature"
    ];
    
    // ZaloPay Parameters
    $zalopayParams = [
        "amount", "appid", "apptransid", "bankcode", "checksum", 
        "discountamount", "pmcid", "status"
    ];

    $amount = 0;
    $orderId = "";

    function execPostRequest($url, $data) {
        $sessionCookie = session_id();
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
        curl_setopt($ch, CURLOPT_COOKIE, "PHPSESSID=" . $sessionCookie);
        
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    
    // MoMo Payment Result Handling
    if (isset($_GET["signature"])) {
        // MoMo parameters
        $partnerCode = $_GET["partnerCode"];
        $orderId = $_GET["orderId"];
        $requestId = $_GET["requestId"];
        $amount = $_GET["amount"];
        $orderInfo = urldecode($_GET["orderInfo"]);
        $orderInfo = mb_convert_encoding($orderInfo, 'UTF-8', 'auto');
        $orderType = $_GET["orderType"];
        $transId = $_GET["transId"];
        $resultCode = $_GET["resultCode"];
        $message = $_GET["message"];
        $payType = $_GET["payType"];
        $responseTime = $_GET["responseTime"];
        $extraData = $_GET["extraData"];
        $m2signature = $_GET["signature"]; // MoMo signature
        $accessKey = 'klm05TvNBzhg7h7j';

        // Checksum calculation for MoMo
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . 
            "&message=" . $message . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . 
            "&orderType=" . $orderType . "&partnerCode=" . $partnerCode . "&payType=" . 
            $payType . "&requestId=" . $requestId . "&responseTime=" . 
            $responseTime . "&resultCode=" . $resultCode . "&transId=" . $transId;

        $partnerSignature = hash_hmac("sha256", $rawHash, $secretKey);

        // Payment result for MoMo
        if ($m2signature == $partnerSignature) {
            if ($resultCode == '0') {
                $result = '<div class="alert alert-success animate__animated animate__fadeIn"><strong>Payment status: </strong>Success (MoMo)</div>';
                $thankYouMessage = '<p><strong>Thank you for your payment!</strong></p>';
                $data = [
                    'amount' => $amount,
                    'orderId' => $orderId,
                    'orderInfo' => $orderInfo,
                    'extraData' => $extraData,
                ];
                $ch = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php?ajax=momoGatewayCallbackHandlerResult';
                $callResult = execPostRequest($ch, json_encode($data));

            } else {
                $result = '<div class="alert alert-danger animate__animated animate__shakeX"><strong>Payment status: </strong>' . $message . '</div>';
            }
        } else {
            $result = '<div class="alert alert-danger animate__animated animate__flash">This transaction could be hacked, please check your signature and returned signature</div>';
        }
    }
    
    // ZaloPay Payment Result Handling
    if (isset($_GET["status"])) {
        $amount = $_GET['amount'];
        $orderId = $_GET['apptransid'];
        $config = [
            "appid" => 2553,
            "key1" => "PcY4iZIKFCIdgZvA6ueMcMHHUbRLYjPL",
            "key2" => "kLtgPl8HHhfvMuDHPwKfgfsY4Ydm9eIz",
        ];

        $reqtime = round(microtime(true) * 1000);
        $data = $_GET;
        
        $checksumData = $data["appid"] . "|" . $data["apptransid"] . "|" . $data["pmcid"] . "|" . $data["bankcode"] . "|" . 
                        $data["amount"] . "|" . $data["discountamount"] . "|" . $data["status"];
        
        $checksum = hash_hmac("sha256", $checksumData, $config["key2"]);

        if (strcmp($checksum, $data["checksum"]) == 0) {
            if ($data["status"] == '1') {
                $result = '<div class="alert alert-success animate__animated animate__fadeIn"><strong>Payment status: </strong>Success (ZaloPay)</div>';
                $thankYouMessage = '<p><strong>Thank you for your payment!</strong></p>';
                $ch = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php?ajax=zaloPayGatewayCallbackHandlerResult';
                $callResult = execPostRequest($ch, json_encode(['apptransid' => $data["apptransid"], 'status' => 'completed']));
            } else {
                $result = '<div class="alert alert-danger animate__animated animate__shakeX"><strong>Payment status: </strong>Failed (ZaloPay)</div>';
                $ch = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php?ajax=zaloPayGatewayCallbackHandlerResult';
                $callResult = execPostRequest($ch, json_encode(['apptransid' => $data["apptransid"], 'status' => 'failed']));
            }
        } else {
            $result = '<div class="alert alert-danger animate__animated animate__flash">This transaction could be hacked, please check your checksum and returned checksum</div>';
        }
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1 class="panel-title text-center">Payment Status</h1>
                </div>
                <div class="panel-body">
                    <div class="text-center">
                        <h3><?php echo $result; ?></h3>
                        <?php echo $thankYouMessage; ?>
                        <p><strong>Username:</strong> <?= $_SESSION['user']['username'] ?></p>
                        <p><strong>Order ID:</strong> <?= $orderId ?></p>
                        <p><strong>Amount:</strong> <?= $amount ?></p>
                    </div>
                </div>
                <div class="panel-footer text-center">
                    <a href="balance" class="btn btn-primary">Back to continue payment...</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- http://localhost/BTL/HeroVerse/paymentResult?amount=10000&appid=2553&apptransid=241126_58473&bankcode=CC&checksum=bf5e9ec1b57fe9d938013512eb0c4cd907212b5ddbd2f27dba8a5b7459c9031f&discountamount=0&pmcid=36&status=1 -->
<!-- http://localhost/BTL/HeroVerse/paymentResult?partnerCode=MOMOBKUN20180529&orderId=1732615697&requestId=1732615697&amount=100000&orderInfo=Cong+mot+ten+lua&orderType=momo_wallet&transId=4242741041&resultCode=0&message=Successful.&payType=napas&responseTime=1732615757917&extraData=&signature=98a5a2652a66a1624bc64f9122fe6ecd9aa63e9da3d48c2d1d03f8f7c86aace6 -->