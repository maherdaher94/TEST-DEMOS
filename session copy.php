<?php

// Default values
$defaultData = [
    "merchantAccount" => "MaherAccountECOM",
    "amount" => [
        "value" => 0,
        "currency" => "AED"
    ],
    "returnUrl" => "http://127.0.0.1:8080/page.html",
    "reference" => "Card-Signup",
    "countryCode" => "AE",
    "recurringProcessingModel" => "CardOnFile",
    "shopperInteraction" => "Ecommerce"
];

// Get the input JSON body
$rawInput = file_get_contents('php://input');
$input = json_decode($rawInput, true);
// echo json_encode($input);
// Use default if input is empty or invalid JSON

$requestData = (!empty($input) && is_array($input)) ? $input : $defaultData;
// echo json_encode($requestData);
// echo "####";
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://checkout-test.adyen.com/checkout/v70/sessions',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode($requestData),
    CURLOPT_HTTPHEADER => array(
        'x-api-key: AQEuhmfxK47HbBxEw0m/n3Q5qf3VZYpFCIFrW2ZZ03a/qqNxYzLIkV4T4RpD+QLLkBDBXVsNvuR83LVYjEgiTGAH-SA1rN63uaZO505w752voi4T0qnhRYn/bJo9Rezz1Tt0=-i1i;(XaqSPL5WqCq+Xt',
        'Content-Type: application/json'
    ),
));

$response = curl_exec($curl);
curl_close($curl);

echo $response;
