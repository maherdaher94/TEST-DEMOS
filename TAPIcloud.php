<?php

// Read the JSON input from the client
$inputJSON = file_get_contents('php://input');

// Optional: decode it for validation or logging
$input = json_decode($inputJSON, true);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://terminal-api-test.adyen.com/sync',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>$inputJSON,
  CURLOPT_HTTPHEADER => array(
    'X-API-Key: AQEuhmfxK47HbBxEw0m/n3Q5qf3VZYpFCIFrW2ZZ03a/qqNxYzLIkV4T4RpD+QLLkBDBXVsNvuR83LVYjEgiTGAH-SA1rN63uaZO505w752voi4T0qnhRYn/bJo9Rezz1Tt0=-i1i;(XaqSPL5WqCq+Xt',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
