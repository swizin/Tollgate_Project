<?php
$secondary_key = "d509988236d947a9971b5999f11b39c3";
$data = array("providerCallbackHost" => "http://localhost:8080/tollgate/callback.php");
$apiUser = "54b8244a-5a30-46ea-9f64-2cf0ff3614c2";
$apiKey = "02bc2793b4d240fa80d502e68b3094cc";

//UUID Version 4
function generate_uuid(){
    $data = random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
     $data[8] = chr(ord($data[8]) & 0x3f  | 0x80);
     return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}
$uuid = generate_uuid();