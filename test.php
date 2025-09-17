<?php

$access_token = "IGQWROU05iOWNPTDZAHOVY2T0hFUktUOUVDSVdyR2E2X3RselI5VXA2VS1qamZA0Q25xRktUQWRVT1pfZAlQ4UDRTRGxtNTl1UjBKZATJkWmk5RVJ0eC12NVdOek1IMHNxOXFGYW9mdm1wVWV6UzU5djIxR2YyU0VPcUFRaUlmNkRwUWRGUQZDZD";
$profile_url = "https://graph.instagram.com/me?fields=id,username,account_type,media_count&access_token={$access_token}";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $profile_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Optional: Set CURL options for SSL verification if necessary
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'CURL error: ' . curl_error($ch);
} else {
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($http_code == 200) {
        $profile_data = json_decode($response, true);
        print_r($profile_data);
    } else {
        echo 'API request failed with response: ' . $response;
    }
}

curl_close($ch);

?>
