<?php
session_start();

if (!isset($_SESSION['access_token'])) {
    //header('Location: index.html');
    //exit;
}

// Instagram API endpoint to get user profile
$url = 'https://graph.instagram.com/me?fields=id,username,account_type&access_token=IGQWRPSXA5T0ZALNTVjbnVPSExuQV9HS2ZA0eXBNZAG45WDNNUFNwUkl3OV9KYjlibUgtMHBNazVlVzZAPV0ZALNFhrb3BEOVBvVkZA5cXFrQzAyNG1jVGFVUk85aWczMml4RDQyaVFnd0c5aWtGNjBkUWFIWVpHVnh5QkE2VjFpUFNGbkFndwZDZD';

$user_info = file_get_contents($url);
$user = json_decode($user_info, true);
echo '<pre>';print_r($user);die();
if ($user) {
    echo 'Hello, ' . $user['username'];
} else {
    echo 'Failed to fetch user info';
}
?>
