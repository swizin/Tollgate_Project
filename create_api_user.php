<?php
include_once("config.php");
//Init curl
$ch = curl_init("https://sandbox.momodeveloper.mtn.com/v1_0/apiuser");
//Set to POST Method
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

//Encode the POSTED data
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

//Return data
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//Set the headers for the endpoint
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "X-Reference-Id: 54b8244a-5a30-46ea-9f64-2cf0ff3614c2",
    "Ocp-Apim-Subscription-Key: ". $secondary_key,
    "Content-Type: Application/json"
));
//Execute the cURL session
$request = curl_exec($ch);
//var_dump($request);
if(curl_error($ch)){
    echo "cURL returned some errors: " . curl_error($ch);
} else{
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    echo $request;

    if($http_code == 201){
  echo "API call was successful! The response code is: ". $http_code;
    }else{
        echo "API call failed with the Code: " . $http_code;
    }
}   
    
?>