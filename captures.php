

<?php
// captures.php

// --- Config ---
$ADYEN_API_KEY = "AQEuhmfxK47HbBxEw0m/n3Q5qf3VZYpFCIFrW2ZZ03a/qqNxYzLIkV4T4RpD+QLLkBDBXVsNvuR83LVYjEgiTGAH-SA1rN63uaZO505w752voi4T0qnhRYn/bJo9Rezz1Tt0=-i1i;(XaqSPL5WqCq+Xt"; // <— prefer env var
// If you want to hardcode while testing, uncomment the next line (not recommended for prod):
// $ADYEN_API_KEY = 'REPLACE_WITH_YOUR_API_KEY';

// --- Read incoming JSON ---
$raw = file_get_contents('php://input');
$body = json_decode($raw, true);

// Basic validation
if (!is_array($body) || empty($body['pspReference']) || empty($body['request'])) {
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode([
        'error' => 'Invalid request. Expecting { pspReference, request } in JSON body.'
    ]);
    exit;
}

$pspReference = $body['pspReference'];
$payload      = $body['request']; // Send this as-is to Adyen

if (empty($ADYEN_API_KEY)) {
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Server misconfiguration: missing ADYEN_API_KEY.']);
    exit;
}

// --- Build Adyen URL (test env) ---
$endpoint = "https://checkout-test.adyen.com/checkout/v68/payments/{$pspReference}/captures";

// --- cURL call ---
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL            => $endpoint,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_MAXREDIRS      => 5,
    CURLOPT_TIMEOUT        => 30,
    CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST  => 'POST',
    CURLOPT_POSTFIELDS     => json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json',
        'x-api-key: ' . $ADYEN_API_KEY,
    ],
]);

$response = curl_exec($ch);
$curlErr  = curl_error($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// --- Return result to caller ---
header('Content-Type: application/json');

if ($curlErr) {
    http_response_code(502);
    echo json_encode(['error' => 'Curl error', 'details' => $curlErr]);
    exit;
}

// Pass through Adyen’s status code & body
http_response_code($httpCode ?: 200);
echo $response;
