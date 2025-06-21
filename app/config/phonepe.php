<?php
return [
    'merchantId' => 'TEST-M23DF8XGNHUJN_25061',
    'saltKey'    => 'NjhlNDRiODItMzk2OS00ZDAwLWJmNWUtN2EzOTQzZjJmNzBj',
    'saltIndex'  => '1', // mostly 1 hota hai
    'env'        => 'UAT', // UAT = testing, PROD = live
    'callbackUrl' => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")
        . "://{$_SERVER['HTTP_HOST']}/?url=phonepeCallback", // Dynamically set callback URL
];
