<?php

// Read the JSON input from the client
$inputJSON = file_get_contents('php://input');

// Optional: decode it for validation or logging
$input = json_decode($inputJSON, true);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://checkout-test.adyen.com/checkout/v71/payments',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>$inputJSON,
  CURLOPT_HTTPHEADER => array(
    'x-api-key: AQEuhmfxK47HbBxEw0m/n3Q5qf3VZYpFCIFrW2ZZ03a/qqNxYzLIkV4T4RpD+QLLkBDBXVsNvuR83LVYjEgiTGAH-SA1rN63uaZO505w752voi4T0qnhRYn/bJo9Rezz1Tt0=-i1i;(XaqSPL5WqCq+Xt',
    'content-type: application/json',
    'Cookie: JSESSIONID=9D2461CA058BF3B7335A86B587256621; __cf_bm=pakuFZVjENwBSvDX1K9a8BnRrnug2We39RNVoG_PkFs-1753779819-1.0.1.1-cXtnwlXc_X3ckfHRlR_t1FjPg536ssMWI7Ypk3mQZcFu_TK9mV.W6Na1jg._N_VLrb2cUVh0m.2BqPHrfVL9qVOz.2K4BNHiQCrsrFrZSD0; _cfuvid=QARprgN0E6rWP.GMRnE6uHbfK6zju2p8RntvkNb96Y4-1753779819265-0.0.1.1-604800000'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
