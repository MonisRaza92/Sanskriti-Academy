<?php

class PaymentController
{
    // Initiate Payment
    public function initiatePayment()
    {
        // PhonePe UAT Credentials
        $merchantId = 'SU2506181451387619940344';
        $saltKey    = '26660d68-f98c-4564-840d-080c5e0ac6af';
        $saltIndex  = '1';

        // Order Details
        $userId = $_POST['user_id'];
        $amount = $_POST['price'] * 100; // Convert to paisa (1 INR = 100 paisa)

        $orderId = 'ORDER' . time(); // Unique order ID

        // HTTPS Callback URL (change to your https URL)
        $callbackUrl = 'https://sanskritiacademy.org/phonepeCallback'; // Must be https (even sandbox)

        // Step 1: Prepare Payment Data
        $data = [
            'merchantId'            => $merchantId,
            'merchantTransactionId' => $orderId,
            'merchantUserId'        => $userId,
            'merchantUserPhone'     => '9999999999', // Optional, can be user's phone number
            'amount'                => $amount,
            'callbackUrl'           => $callbackUrl,
        ];

        $jsonPayload = json_encode($data);
        $base64Payload = base64_encode($jsonPayload);

        // Step 2: Generate X-VERIFY checksum
        $apiEndpoint = '/pg/v1/pay';
        $stringToHash = $apiEndpoint . $base64Payload . $saltKey;
        $sha256 = hash('sha256', $stringToHash);
        $checksum = $sha256 . "###" . $saltIndex;

        // Step 3: cURL request
        $url = 'https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay'; // UAT URL

        $headers = [
            'Content-Type: application/json',
            'X-VERIFY: ' . $checksum,
        ];

        $payload = json_encode(['request' => $base64Payload]);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        } else {
            echo "<h3>Raw Response:</h3><pre>";
            print_r($response); // REAL STRING RESPONSE PRINT KAREGA
            echo "</pre>";

            $result = json_decode($response);

            echo "<h3>Decoded JSON:</h3><pre>";
            print_r($result); // JSON decode karke bhi dikhayega
            echo "</pre>";

            // Redirect logic
            if (isset($result->data->instrumentResponse->redirectInfo->url)) {
                header('Location: ' . $result->data->instrumentResponse->redirectInfo->url);
                exit;
            } else {
                echo "<h3>Unexpected Response Structure:</h3><pre>";
                print_r($result);
                echo "</pre>";
            }
        }
        curl_close($ch);
    }

    // PhonePe Callback (After Payment)
    public function phonepeCallback()
    {
        echo "<h2>PhonePe Callback Data Received:</h2>";
        echo "<pre>";

        // In GET
        print_r($_GET);

        // In POST (JSON Body)
        $postData = file_get_contents('php://input');
        print_r(json_decode($postData, true));

        echo "</pre>";
    }
}
