<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

    if(isset($_GET["checkaction"]) && $_GET["checkaction"] == 'checklimit'){
         
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://analytics-api.culturex.in/api/check',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer IOdWnKph0v'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        $res = json_decode($response);
        $total_limit = $res->result->total_limit;
        $total_usage = $res->result->total_usage;
        $avail = $total_limit - $total_usage;
        if($total_usage == $total_limit || $total_usage > $total_limit || $avail < 8){
            
            require_once('PHPMailer/Exception.php');
            require_once('PHPMailer/OAuth.php');
            require_once('PHPMailer/PHPMailer.php');
            require_once('PHPMailer/SMTP.php');
            require_once('PHPMailer/POP3.php');
            
            $msg = 'API Rate Limit Exceeded.';
            
            $mail = new PHPMailer();
                $mail->SMTPAuth = true;
            $mail->Username = 'connect@thevibes.network';
            $mail->Password = 'tkddiidljlgbjewp';
            $mail->SetFrom('connect@thevibes.network', 'The Vibes Network');
            $mail->addBCC("rdungawat@gmail.com", "Rahul");
            $mail->addCC("sagar@thevibes.academy", "Sagar");
            $mail->addCC("sandiip@thevibes.academy", "Sandiip");
            $mail->addCC("marketing@thinquilab.com", "Connect");
            $mail->addCC("sandiip.porwal@gmail.com", "Sandiip Porwal");
            $mail->addAddress('connect@thevibes.network');
            $mail->Subject = "API Limit over";
            $mail->Body =  $welcome_msg;
            
            $result = $mail->Send();
        }
  
    }

?>