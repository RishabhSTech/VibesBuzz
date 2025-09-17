<?php

session_start();
if(isset($_POST['phone'])){
    
    $otp = rand(1000, 9999);
	$curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://2factor.in/API/V1/019c9852-2c78-11ef-8b60-0200cd936042/SMS/+91'.$_POST['phone'].'/'.$otp.'/OTP2',
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
    //$res = json_decode($response);
    $_SESSION['one_time_pass'] = $otp;
    
    $_SESSION['nextstep'] = 3;
    
    exit;
}


if(isset($_POST['otp'])){
    
    $_SESSION['nextstep'] = 3;
    
    if($_POST['otp'] == $_SESSION['one_time_pass']){
        echo '1';
    }else{
        echo '0';
    }
    
    exit;
}
?>