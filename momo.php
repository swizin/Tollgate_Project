<?php
//Generate UUID with the format 8-4-4-4-12
function generate_uuid()
{
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), 
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    );
}

$reference_id = generate_uuid();
$secondary_key = "d509988236d947a9971b5999f11b39c3";

// Set the request URL and data
$url = 'https://sandbox.momodeveloper.mtn.com/collection/v1_0/bc-authorize';
$data = array(
    'providerCallbackHost' => 'https://portal.umeskiasoftwares.com/umeskiapay/momocallbackurl.php'
);

// Set the headers
$headers = array(
    'Content-Type: application/json',
    'X-Reference-Id: ' . $reference_id,
    'Ocp-Apim-Subscription-Key: ' . $secondary_key
);

// Initialize cURL
$curl = curl_init();

// Set the cURL options
curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_HTTPHEADER => $headers
));

// Execute the cURL request
$response = curl_exec($curl);

if (curl_errno($curl)) {
    echo "cURL Error: " . curl_error($curl);
} else {
    echo "Response: " . $response ;
}

curl_close($curl);
