<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://analytics-api.culturex.in/api/instagram/profile',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "usernames": [
        "the.ranting.gola"
    ]
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Authorization: Bearer IOdWnKph0v'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
//echo $response;
$res = json_decode($response);
echo '<pre>';print_r($res);





/*
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://2factor.in/API/V1/019c9852-2c78-11ef-8b60-0200cd936042/SMS/+919828848399/5423/OTP i-MBA Content Template',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);
$res = json_decode($response);
echo '<pre>';print_r($res);
*/

