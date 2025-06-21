<?php

// /public/phonepe-callback.php

$input = file_get_contents("php://input");
$data = json_decode($input, true);

file_put_contents('callback_log.txt', print_r($data, true)); // log callback to file for checking

if (isset($data['code']) && $data['code'] === 'PAYMENT_SUCCESS') {
    // update database: payment success
    header("Location: payment-success?transaction_id=" . urlencode($data['transactionId']));
    exit;
} else {
    // update database: payment failed
    header("Location: payment-fail?error=" . urlencode($data['message'] ?? 'Unknown error'));
    exit;
}
