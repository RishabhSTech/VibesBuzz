<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'PHPMailer/Exception.php';
require_once 'PHPMailer/OAuth.php';
require_once 'PHPMailer/PHPMailer.php';
require_once 'PHPMailer/SMTP.php';
require_once 'PHPMailer/POP3.php';

class Actions{
	
    public function __construct(){
        
    }	
    
	public function getProfileData($username){
		
		//$username = '_rahul_dungawat';
		
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
                "'.$username.'"
            ]
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer IOdWnKph0v'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        
        $res = json_decode($response);
        
        $this->storeApiHit();
        
        if(!isset($res->result)){
            $this->sendMail('limit');
        }
        if($res->result[0] == '' || $res->result[0] == null){
            $this->sendMail('error');
        }
        return $res;
	}
	
	public function sendMail($type) {
	   
        $mail_msg = '';
	   if($type == 'limit'){
	       
	       $mail_msg = 'API usage limit reached!';
	   }else if($type == 'error'){
	       
	       $mail_msg = 'API no reponse return. something went wrong.';
	   }
	   
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = "localhost";
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
        $mail->Subject = "API Limit";
        $mail->Body =  $mail_msg;
        
        //$mail->SMTPDebug  = 1;
        
        $result = $mail->Send();
	   
	}
	 
	public function storeApiHit() {
        $servername = "localhost";
        $username = "thevibesbuzz";
        $password = "7XmPzhGJGGKTyRRr";
        $dbname = "thevibesbuzz";
    
        // Create a new database connection
        $conn = new mysqli($servername, $username, $password, $dbname);
    
        // Check for connection errors
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        date_default_timezone_set("Asia/Kolkata");
        $currentDate = date('Y-m-d');
    
        $sql = "SELECT usages FROM apiusages WHERE datetime = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $currentDate);
        $stmt->execute();
        $stmt->store_result();
    
        if ($stmt->num_rows > 0) {
           
            $stmt->bind_result($usages);
            $stmt->fetch();
            $usages++;
    
            $updateSql = "UPDATE apiusages SET usages = ? WHERE datetime = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("is", $usages, $currentDate);
            $updateStmt->execute();
            $updateStmt->close();
        } else {
           
            $insertSql = "INSERT INTO apiusages (usages, datetime) VALUES (1, ?)";
            $insertStmt = $conn->prepare($insertSql);
            $insertStmt->bind_param("s", $currentDate);
            $insertStmt->execute();
            $insertStmt->close();
        }
    
        $stmt->close();
        $conn->close();
    }
	
	public function getProfileDetails(){
	    session_start();
	    $profile_data = $_SESSION['profile_res'];
	    
	    $data = array();
	    if(!empty($profile_data->result)){
        $data['totalViews'] = $profile_data->result[0]->reels->totalViews;
        $data['follower'] = $profile_data->result[0]->follower;
        $data['following'] = $profile_data->result[0]->following;
        $data['posts'] = count($profile_data->result[0]->reels->posts);
        $data['name'] = $profile_data->result[0]->name;
        $data['profilePicture'] = $profile_data->result[0]->profilePicture;
        $data['totalLikes'] = $profile_data->result[0]->totalLikes;
	    }else{
	        $data['totalViews'] = 0;
	        $data['follower'] = 0;
	        $data['following'] = 0;
	        $data['posts'] = 0;
            $data['name'] = '';
            $data['profilePicture'] = '';
            $data['totalLikes'] = 0;
	    }
	    
	    echo json_encode($data);
	    exit;
	}
	
	public function storemobileuses($mobilenum){
	    $servername = "localhost";
        $username = "thevibesbuzz";
        $password = "7XmPzhGJGGKTyRRr";
        $dbname = "thevibesbuzz";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        // Check if the mobile number exists
        $sql = "SELECT usedtime FROM mobile_trial WHERE mobile = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $mobilenum);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            
            $stmt->bind_result($usedtime);
            $stmt->fetch();
            $usedtime++;
            
            $updateSql = "UPDATE mobile_trial SET usedtime = ? WHERE mobile = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("is", $usedtime, $mobilenum);
            $updateStmt->execute();
            $updateStmt->close();
        } else {
            
            $insertSql = "INSERT INTO mobile_trial (mobile, usedtime) VALUES (?, 1)";
            $insertStmt = $conn->prepare($insertSql);
            $insertStmt->bind_param("s", $mobilenum);
            $insertStmt->execute();
            $insertStmt->close();
        }
    
        // Close statements and connection
        $stmt->close();
        $conn->close();
	    
	}
	
	public function checkmobileuses_old_bk($mobilenum){
	    $servername = "localhost";
        $username = "thevibesbuzz";
        $password = "7XmPzhGJGGKTyRRr";
        $dbname = "thevibesbuzz";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        $sql = "SELECT usedtime FROM mobile_trial WHERE mobile = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $mobilenum);
        $stmt->execute();
        $stmt->store_result();
    
        $usedtime = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($usedtime);
            $stmt->fetch();
        }
    
        $stmt->close();
        $conn->close();
    
        return $usedtime;
	}
	
	public function checkpincode($pincode){
	    $servername = "localhost";
        $username = "thevibesbuzz";
        $password = "7XmPzhGJGGKTyRRr";
        $dbname = "thevibesbuzz";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        $sql = "SELECT Pincode FROM pincodes WHERE Pincode = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $pincode);
        $stmt->execute();
        $stmt->store_result();
    
        $usedtime = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($usedtime);
            $stmt->fetch();
        }
    
        $stmt->close();
        $conn->close();
    
        return $usedtime;
	}
	
	public function checkMobileUses($mobilenum, $insta_username) {
        $servername = "localhost";
        $username = "thevibesbuzz";
        $password = "7XmPzhGJGGKTyRRr";
        $dbname = "thevibesbuzz";
         
        $conn = new mysqli($servername, $username, $password, $dbname);
         
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
     
        $sql = "SELECT COUNT(DISTINCT user_name) as count 
                FROM user_insta_profile 
                WHERE mobile = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $mobilenum);
        $stmt->execute();
         
        $usedtime = null;
        $stmt->bind_result($usedtime);
        $stmt->fetch();
        $stmt->close();
         
        $sql = "SELECT EXISTS(SELECT 1 FROM user_insta_profile WHERE mobile = ? AND user_name = ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $mobilenum, $insta_username);
        $stmt->execute();
         
        $exists = null;
        $stmt->bind_result($exists);
        $stmt->fetch();
        
        $stmt->close();
        $conn->close();
        
        return [
            'count' => $usedtime,
            'exists' => $exists
        ];
    }
	
	public function storeUseractions_old($data) {
        
        $servername = "localhost";
        $username = "thevibesbuzz";
        $password = "7XmPzhGJGGKTyRRr";
        $dbname = "thevibesbuzz";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        $mobile = $data['mobile'];
        $checkQuery = "SELECT COUNT(*) as count FROM user_insta_profile WHERE mobile = '$mobile'";
        $result = $conn->query($checkQuery);
    
        $row = $result->fetch_assoc();
    
        if ($row['count'] > 0) {
            
            $updateQuery = "UPDATE user_insta_profile SET 
                                cap_name = '{$data['cap_name']}', 
                                cap_pincode = '{$data['cap_pincode']}', 
                                cap_whatsapp_num = '{$data['cap_whatsapp_num']}', 
                                somethingabout = '{$data['somethingabout']}', 
                                aboutcontent = '{$data['aboutcontent']}', 
                                storecontent = '{$data['storecontent']}', 
                                totalviews = '{$data['totalviews']}', 
                                totalfollower = '{$data['totalfollower']}', 
                                user_name = '{$data['user_name']}' 
                            WHERE mobile = '$mobile'";
            $conn->query($updateQuery);
        } else {
            
            $insertQuery = "INSERT INTO user_insta_profile (
                                cap_name, cap_pincode, cap_whatsapp_num, 
                                somethingabout, aboutcontent, storecontent, 
                                mobile, user_name, totalviews, totalfollower
                            ) VALUES (
                                '".$data['cap_name']."', '".$data['cap_pincode']."', '".$data['cap_whatsapp_num']."', 
                                '".$data['somethingabout']."', '".$data['aboutcontent']."', '".$data['storecontent']."', 
                                '".$data['mobile']."', '".$data['user_name']."', '".$data['totalviews']."', '".$data['totalfollower']."')";
            $conn->query($insertQuery);
        }
    
        // Close the database connection
        $conn->close();
    }
    
    public function storeUseractions($data) {
        
        $servername = "localhost";
        $username = "thevibesbuzz";
        $password = "7XmPzhGJGGKTyRRr";
        $dbname = "thevibesbuzz";
        
        
        $profile_res = json_encode($_SESSION['profile_res']->result);
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        $profile_res = mysqli_real_escape_string($conn,$profile_res);
        
        /*
        $insertQuery = "INSERT INTO user_insta_profile (
                            cap_name, cap_pincode, cap_whatsapp_num, 
                            somethingabout, aboutcontent, storecontent, 
                            mobile, user_name, totalviews, totalfollower, profile_res, ReelsCount, loginusername, insta_username, AccountCategory, totallikes2, EarningAmount, last_post_date, avg_view_rate, engagement_rate, postperweek, avgvideoduration, totalcomment
                        ) VALUES (
                            '".$data['cap_name']."', '".$data['cap_pincode']."', '".$data['cap_whatsapp_num']."', 
                            '".$data['somethingabout']."', '".$data['aboutcontent']."', '".$data['storecontent']."', 
                            '".$data['mobile']."', '".$data['user_name']."', '".$data['totalviews']."', '".$data['totalfollower']."', '".$profile_res."', '".$data['ReelsCount']."', '".$data['loginusername']."', '".$data['insta_username']."', '".$data['AccountCategory']."', '".$data['totallikes2']."', '".$data['EarningAmount']."', '".$data['last_post_date']."', '".$data['avg_view_rate']."', '".$data['engagement_rate']."', '".$data['postperweek']."', '".$data['avgvideoduration']."', '".$data['totalcomment']."')";
        */
        
        $cap_name = mysqli_real_escape_string($conn,$data['cap_name']);
        $cap_pincode = mysqli_real_escape_string($conn,$data['cap_pincode']);
        $cap_whatsapp_num = mysqli_real_escape_string($conn,$data['cap_whatsapp_num']);
        $somethingabout = mysqli_real_escape_string($conn,$data['somethingabout']);
        $aboutcontent = mysqli_real_escape_string($conn,$data['aboutcontent']);
        $storecontent = mysqli_real_escape_string($conn,$data['storecontent']);
        $mobile = mysqli_real_escape_string($conn,$data['mobile']);
        $user_name = mysqli_real_escape_string($conn,$data['user_name']);
        $totalviews = mysqli_real_escape_string($conn,$data['totalviews']);
        $totalfollower = mysqli_real_escape_string($conn,$data['totalfollower']);
        $ReelsCount = mysqli_real_escape_string($conn,$data['ReelsCount']);
        $loginusername = mysqli_real_escape_string($conn,$data['loginusername']);
        $insta_username = mysqli_real_escape_string($conn,$data['insta_username']);
        $AccountCategory = mysqli_real_escape_string($conn,$data['AccountCategory']);
        $totallikes2 = mysqli_real_escape_string($conn,$data['totallikes2']);
        $EarningAmount = mysqli_real_escape_string($conn,$data['EarningAmount']);
        $last_post_date = mysqli_real_escape_string($conn,$data['last_post_date']);
        $avg_view_rate = mysqli_real_escape_string($conn,$data['avg_view_rate']);
        $engagement_rate = mysqli_real_escape_string($conn,$data['engagement_rate']);
        $postperweek = mysqli_real_escape_string($conn,$data['postperweek']);
        $avgvideoduration = mysqli_real_escape_string($conn,$data['avgvideoduration']);
        $totalcomment = mysqli_real_escape_string($conn,$data['totalcomment']);
        
        $insertQuery = "INSERT INTO user_insta_profile (
                            cap_name, cap_pincode, cap_whatsapp_num, 
                            somethingabout, aboutcontent, storecontent, 
                            mobile, user_name, totalviews, totalfollower, profile_res, ReelsCount, loginusername, insta_username, AccountCategory, totallikes2, EarningAmount, last_post_date, avg_view_rate, engagement_rate, postperweek, avgvideoduration, totalcomment
                        ) VALUES (
                            '".$cap_name."', '".$cap_pincode."', '".$cap_whatsapp_num."', 
                            '".$somethingabout."', '".$aboutcontent."', '".$storecontent."', 
                            '".$mobile."', '".$user_name."', '".$totalviews."', '".$totalfollower."', '".$profile_res."', '".$ReelsCount."', '".$loginusername."', '".$insta_username."', '".$AccountCategory."', '".$totallikes2."', '".$EarningAmount."', '".$last_post_date."', '".$avg_view_rate."', '".$engagement_rate."', '".$postperweek."', '".$avgvideoduration."', '".$totalcomment."')";
        $conn->query($insertQuery);
        
        $last_inserted_id = $conn->insert_id;
        $_SESSION['last_insta_profile_inserted_id'] = $last_inserted_id;
    
        // Close the database connection
        $conn->close();
    }
    
    
    public function storedata($store_username) {
        $servername = "localhost";
        $username = "thevibesbuzz";
        $password = "7XmPzhGJGGKTyRRr";
        $dbname = "thevibesbuzz";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        $insertQuery = "INSERT INTO abandoned_cart (insta_username) VALUES ('".$store_username."')";
        
        if ($conn->query($insertQuery) === TRUE) {
           
            $insertedId = $conn->insert_id;
        } else {
            return 0;
        }
    
        $conn->close();
        return $insertedId;
    }
    
    public function updatedata($mobilenum,$id){
	    $servername = "localhost";
        $username = "thevibesbuzz";
        $password = "7XmPzhGJGGKTyRRr";
        $dbname = "thevibesbuzz";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        $updateSql = "UPDATE abandoned_cart SET mobile = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("si", $mobilenum, $id);
        $updateStmt->execute();
        $updateStmt->close();
    
	}
	
	public function updateSurveydata($data) {
        
        $servername = "localhost";
        $username = "thevibesbuzz";
        $password = "7XmPzhGJGGKTyRRr";
        $dbname = "thevibesbuzz";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        $your_age = mysqli_real_escape_string($conn,$data['your_age']);
        $content_language = mysqli_real_escape_string($conn,$data['content_language']);
        $your_gender = mysqli_real_escape_string($conn,$data['your_gender']);
        $content_youtube = mysqli_real_escape_string($conn,$data['content_youtube']);
        
        $paid_collaboration = mysqli_real_escape_string($conn,$data['paid_collaboration']);
        $interested_barter_collabs = mysqli_real_escape_string($conn,$data['interested_barter_collabs']);
        $interested_affiliate_collabs = mysqli_real_escape_string($conn,$data['interested_affiliate_collabs']);
        $audience_gender = mysqli_real_escape_string($conn,$data['audience_gender']);
        
        $id = $_SESSION['last_insta_profile_inserted_id'];
        $checkQuery = "SELECT COUNT(*) as count FROM user_insta_profile WHERE id = '$id'";
        $result = $conn->query($checkQuery);
    
        $row = $result->fetch_assoc();
    
        if ($row['count'] > 0) {
            
            $updateQuery = "UPDATE user_insta_profile SET 
                                your_age = '".$your_age."', 
                                content_language = '".$content_language."', 
                                your_gender = '".$your_gender."', 
                                content_youtube = '".$content_youtube."', 
                                paid_collaboration = '".$paid_collaboration."', 
                                interested_barter_collabs = '".$interested_barter_collabs."', 
                                interested_affiliate_collabs = '".$interested_affiliate_collabs."', 
                                audience_gender = '".$audience_gender."'
                            WHERE id = '$id'";
        //echo $updateQuery;return;
        
            $conn->query($updateQuery);
        }
    
        $conn->close();
    }
	
}
?>