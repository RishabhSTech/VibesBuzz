<?php
session_start();

// Instagram app credentials
$client_id = '815633160634525';
$client_secret = '630ca4ecd38e96576e5b832bc19be900';
$redirect_uri = 'https://www.thevibes.buzz/auth-redirect.php';

// Get the authorization code from the URL
if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // Exchange the authorization code for an access token
    $url = 'https://api.instagram.com/oauth/access_token';
    $data = [
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'grant_type' => 'authorization_code',
        'redirect_uri' => $redirect_uri,
        'code' => $code
    ];

    $options = [
        'http' => [
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $response = json_decode($result, true);
	
    if (isset($response['access_token'])) {
        //echo '<pre>';print_r($response);die();
        $_SESSION['access_token'] = $response['access_token'];
        $_SESSION['user_id'] = $response['user_id'];
        
        $_SESSION['nextstep'] = 2;
        
        $url = 'https://graph.instagram.com/me?fields=username&access_token='.$response['access_token'];

        $user_info = file_get_contents($url);
        $user = json_decode($user_info, true);
        
        if ($user) {
            
            
            $_SESSION['insta_username'] = $user['username'];
           /* include 'inc/function.php';
            $sqlObj = new Actions();
            $profile_res = $sqlObj->getProfileData($user['username']);
            $_SESSION['profile_res'] = $profile_res;
           */
            //$_SESSION['fetch_record'] = 0;
            
            header('Location: index.php');
            exit;
        } else {
            echo 'Failed to fetch user info';
        }
        
    } else {
        echo 'Failed to get access token';
    }
} else {
    echo 'Authorization code not found';
}
?>
