<?php

session_start();
if(isset($_POST['phone'])){
    
    include 'inc/function.php';
    $sqlObj = new Actions();
    $insta_username = $_SESSION['insta_username'];
    $count = $sqlObj->checkmobileuses($_POST['phone'], $insta_username);
    //$count['exists']
    if($count['exists'] > 0){
        
    }else if($count['count'] > 2){
        echo 'limitcross';
        exit;
    }
    
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
    
    $_SESSION['verify_phone'] = $_POST['phone'];
    
    $_SESSION['one_time_pass'] = $otp;
    
    
    
    //$_SESSION['nextstep'] = 3;
    
    exit;
}

if(isset($_POST['clearsession'])){
    session_destroy();
    exit;
}

if(isset($_POST['store_username'])){
    
    include 'inc/function.php';
    $sqlObj = new Actions();
    $profile_res = $sqlObj->getProfileData($_POST['store_username']);
    //echo '<pre>';print_r($profile_res);die();
    if(!isset($profile_res->result)){
        echo $profile_res->message;
        exit;
    }
    if($profile_res->result[0] == '' || $profile_res->result[0] == null){
        echo 404;
    }else{
        $_SESSION['insta_username'] = $_POST['store_username'];
        $_SESSION['nextstep'] = 2;
        
        $_SESSION['profile_res'] = $profile_res;
        echo 200;
        
       
        $insertedId = $sqlObj->storedata($_POST['store_username']);
        if($insertedId != 0){
            $_SESSION['user_inserted_id'] = $insertedId;
        }
    }
    exit;
    
}

if(isset($_POST['otp'])){
    
    if($_POST['otp'] == $_SESSION['one_time_pass']){
        
        include 'inc/function.php';
        $sqlObj = new Actions();
        $sqlObj->storemobileuses($_POST['selectedphone']);
        
        if(isset($_SESSION['user_inserted_id']) && $_SESSION['user_inserted_id'] != 0 && $_SESSION['user_inserted_id'] != ''){
            $sqlObj->updatedata($_POST['selectedphone'],$_SESSION['user_inserted_id']);
        }
        
        $_SESSION['nextstep'] = 3;
        
        echo '1';
    }else{
        echo '0';
    }
    
    //echo '1';
    exit;
}

if(isset($_POST['getinsta2'])){
    
    $_SESSION['nextstep'] = 3;
    
    //include 'inc/function.php';
    //$sqlObj = new Actions();
    //$profile_res = $sqlObj->getProfileData($_SESSION['insta_username']);
    //$_SESSION['profile_res'] = $profile_res;
    $profile_data = $_SESSION['profile_res'];
    
    $data = array();
    if(!empty($profile_data->result) && $_SESSION['profile_res']->result[0] != ''){
        
        
        $data['ReelsCount'] = $profile_data->result[0]->reels->reelCount;
        $data['instausername'] = $profile_data->result[0]->username;
        $data['instacategory'] = $profile_data->result[0]->category;
        
        
        $data['totalViews'] = $profile_data->result[0]->reels->totalViews;
        $data['follower'] = $profile_data->result[0]->follower;
        $data['following'] = $profile_data->result[0]->following;
        $data['posts'] = $profile_data->result[0]->totalContent;//count($profile_data->result[0]->reels->posts);
        $data['name'] = $profile_data->result[0]->name;
        
        $avg_view_rate = ($data['totalViews']/$data['follower'])*100;
        $data['avg_view_rate'] = number_format($avg_view_rate, 2);
        
        $imageUrl = $profile_data->result[0]->profilePicture;
        
        $imageFileName = 'instagram_image_'.time() . '.jpg';
        $imageFilePath = 'instaimg/' . $imageFileName;
        
        $imageData = file_get_contents($imageUrl);
        
        if ($imageData !== false) {
            
            $saveResult = file_put_contents($imageFilePath, $imageData);
        
            if ($saveResult !== false) {
                
                $data['profilePicture'] = $imageFilePath;
            } else {
                $data['profilePicture'] = '';
            }
        } else {
            $data['profilePicture'] = '';
        }
        
        $_SESSION['profilePicture'] = $data['profilePicture'];
        //$data['profilePicture'] = $profile_data->result[0]->profilePicture;
        
        
        
        $data['totalLikes'] = $profile_data->result[0]->totalLikes;
        $data['bio'] = $profile_data->result[0]->bio;
        
        $data['totalComments'] = $profile_data->result[0]->reels->totalComments;
        $data['avgPostPerWeek'] = $profile_data->result[0]->reels->avgPostPerWeek;
        $avgVideoDuration = $profile_data->result[0]->reels->avgVideoDuration;
        
        $formattedAvgVideoDuration = number_format($avgVideoDuration, 2);
        $data['avgVideoDuration'] = $formattedAvgVideoDuration;

        /*
        if($profile_data->result[0]->reels->avgEngagement != ''){
            $engagement_rate = $profile_data->result[0]->reels->avgEngagement;
            
            $data['engagement_rate'] = number_format($engagement_rate, 2);
            
        }else{
            $data['engagement_rate'] = 0;
        }
        */
        
        $reelCount = $profile_data->result[0]->reels->reelCount;
        $data['engagement_rate'] = floor(($data['totalLikes']+$data['totalComments'])/$reelCount);
        
        $dateString = $profile_data->result[0]->reels->posts[0]->date;
        $date = new DateTime($dateString);
        $data['last_post_date'] = $date->format('d/m/y');
        
        
        $earning = 0;
        
        if($data['follower'] < 1000001){
            $earning = $data['follower']*0.02;
        }else{
            $earning = '310000+';
        }
        $data['follower_earning'] = $earning;
        
        
        //$viewrate = calculateViewRate($data['follower'], $data['avg_view_rate']);
        $avg_view_rate = $data['totalViews']/$reelCount;
        $viewrate = calculateViewRate($data['follower'], $avg_view_rate);
        
        $engrate = calculateEngRate($data['follower'], $data['engagement_rate']);
        
        $feqrate = calculatefeqPost($data['follower'], $data['avgPostPerWeek']);
        
        $data['viewrate_earning'] = $viewrate;
        $data['eng_earning'] = $engrate;
        $data['feq_earning'] = $feqrate;
        
        if($data['follower'] < 1000000){
            $total_earning = $earning+$feqrate+$viewrate+$engrate;
            $data['total_earning'] = number_format($total_earning, 2);
        }else{
            $total_earning = "310000+";
            $data['total_earning'] = "310000+";
        }
        //$data['total_earning'] = $total_earning;
        //$data['total_earning'] = number_format($total_earning, 2);
        
    
    

        //$reelAverageViews = $profile_data->result[0]->reels->reelAverageViews;
        $reelAverageViews = $profile_data->result[0]->reels->totalViews;
        $avrage_view_rate = ($reelAverageViews/$data['follower'])*100;
        $data['avrage_view_rate'] = number_format($avrage_view_rate, 2);
        
        $avrage_eng_rate = (($data['totalComments']+$data['totalLikes'])/$data['totalViews'])*100;
        $data['avrage_eng_rate'] = number_format($avrage_eng_rate, 2);

    }else{
        $data['totalViews'] = 0;
        $data['follower'] = 0;
        $data['following'] = 0;
        $data['posts'] = 0;
        $data['name'] = 'User';
        $data['bio'] = '';
        
        $data['profilePicture'] = '';
        $data['totalLikes'] = 0;
        $data['engagement_rate'] = 0;
        
        $data['totalComments'] = 0;
        $data['avgPostPerWeek'] = 0;
        $data['avgVideoDuration'] = 0;
        $data['last_post_date'] = '0/0/0';
        
        $data['total_earning'] = 0;
        $data['avrage_eng_rate'] = 0;
        $data['avrage_view_rate'] = 0;
    }
    
    echo json_encode($data);
    exit;
    
    exit;
}

if(isset($_POST['getinsta'])){
    
    $_SESSION['nextstep'] = 4;
    
    $profile_data = $_SESSION['profile_res'];
    
    $data = array();
    if(!empty($profile_data->result)){
        
        $data['totalViews'] = $profile_data->result[0]->reels->totalViews;
        $data['follower'] = $profile_data->result[0]->follower;
        $data['following'] = $profile_data->result[0]->following;
        $data['posts'] = $profile_data->result[0]->totalContent;//count($profile_data->result[0]->reels->posts);
        $data['name'] = $profile_data->result[0]->name;
        
        $avg_view_rate = $data['totalViews']/$data['follower'];
        $data['avg_view_rate'] = number_format($avg_view_rate, 2);
        
        $imageUrl = $profile_data->result[0]->profilePicture;
        
        $imageFileName = 'instagram_image_'.time() . '.jpg';
        $imageFilePath = 'instaimg/' . $imageFileName;
        
        $imageData = file_get_contents($imageUrl);
        
        if ($imageData !== false) {
            
            $saveResult = file_put_contents($imageFilePath, $imageData);
        
            if ($saveResult !== false) {
                
                $data['profilePicture'] = $imageFilePath;
            } else {
                $data['profilePicture'] = '';
            }
        } else {
            $data['profilePicture'] = '';
        }
        //$data['profilePicture'] = $profile_data->result[0]->profilePicture;
        
        
        
        $data['totalLikes'] = $profile_data->result[0]->totalLikes;
        $data['bio'] = $profile_data->result[0]->bio;
        
        $data['totalComments'] = $profile_data->result[0]->reels->totalComments;
        $data['avgPostPerWeek'] = $profile_data->result[0]->reels->avgPostPerWeek;
        $avgVideoDuration = $profile_data->result[0]->reels->avgVideoDuration;
        
        $formattedAvgVideoDuration = number_format($avgVideoDuration, 2);
        $data['avgVideoDuration'] = $formattedAvgVideoDuration;

        /*
        if($profile_data->result[0]->reels->avgEngagement != ''){
            $engagement_rate = $profile_data->result[0]->reels->avgEngagement;
            
            $data['engagement_rate'] = number_format($engagement_rate, 2);
            
        }else{
            $data['engagement_rate'] = 0;
        }
        */
        
        $reelCount = $profile_data->result[0]->reels->reelCount;
        $data['engagement_rate'] = floor(($data['totalLikes']+$data['totalComments'])/$reelCount);
        
        $dateString = $profile_data->result[0]->reels->posts[0]->date;
        $date = new DateTime($dateString);
        $data['last_post_date'] = $date->format('d/m/y');
        
        
        $earning = 0;
        
        if($data['follower'] < 1000001){
            $earning = $data['follower']*0.02;
        }else{
            $earning = '310000+';
        }
        $data['follower_earning'] = $earning;
        
        
        //$viewrate = calculateViewRate($data['follower'], $data['avg_view_rate']);
        $avg_view_rate = $data['totalViews']/$reelCount;
        $viewrate = calculateViewRate($data['follower'], $avg_view_rate);
        
        $engrate = calculateEngRate($data['follower'], $data['engagement_rate']);
        
        $feqrate = calculatefeqPost($data['follower'], $data['avgPostPerWeek']);
        
        $data['viewrate_earning'] = $viewrate;
        $data['eng_earning'] = $engrate;
        $data['feq_earning'] = $feqrate;
        
        if($data['follower'] < 1000000){
            $total_earning = $earning+$feqrate+$viewrate+$engrate;
            $data['total_earning'] = number_format($total_earning, 2);
        }else{
            $total_earning = "310000+";
            $data['total_earning'] = "310000+";
        }
        //$data['total_earning'] = $total_earning;
        //$data['total_earning'] = number_format($total_earning, 2);
        
    
    

        //$reelAverageViews = $profile_data->result[0]->reels->reelAverageViews;
        $reelAverageViews = $profile_data->result[0]->reels->totalViews;
        $avrage_view_rate = ($reelAverageViews/$data['follower'])*100;
        $data['avrage_view_rate'] = number_format($avrage_view_rate, 2);
        
        $avrage_eng_rate = (($data['totalComments']+$data['totalLikes'])/$data['totalViews'])*100;
        $data['avrage_eng_rate'] = number_format($avrage_eng_rate, 2);

    }else{
        $data['totalViews'] = 0;
        $data['follower'] = 0;
        $data['following'] = 0;
        $data['posts'] = 0;
        $data['name'] = '';
        $data['bio'] = '';
        
        $data['profilePicture'] = '';
        $data['totalLikes'] = 0;
        $data['engagement_rate'] = 0;
        
        $data['totalComments'] = 0;
        $data['avgPostPerWeek'] = 0;
        $data['avgVideoDuration'] = 0;
        $data['last_post_date'] = '0/0/0';
        
        $data['total_earning'] = 0;
        $data['avrage_eng_rate'] = 0;
        $data['avrage_view_rate'] = 0;
    }
    
    echo json_encode($data);
    exit;
    
    exit;
}


if(isset($_POST['storecontent'])){
    //$storecontent = implode(',',$_POST['storecontent']);
    
    $storecontent = array_map('trim', $_POST['storecontent']);
    $storecontent = array_filter($storecontent);
    
    $storecontent = implode(',', $storecontent);
    
    // insert to db
    $_SESSION['storecontent'] = $storecontent;
    
    
    $_SESSION['nextstep'] = 5;
    exit;
}

if(isset($_POST['aboutcontent'])){
    //$aboutcontent = implode(',',$_POST['aboutcontent']);
    
    $aboutcontent = array_map('trim', $_POST['aboutcontent']);
    $aboutcontent = array_filter($aboutcontent);
    
    $aboutcontent = implode(',', $aboutcontent);
    
    // insert to db
    $_SESSION['aboutcontent'] = $aboutcontent;
    
    $_SESSION['nextstep'] = 6;
    exit;
}


if(isset($_POST['somethingabout'])){
    //$somethingabout = implode(',',$_POST['somethingabout']);
    
    $somethingabout = array_map('trim', $_POST['somethingabout']);
    $somethingabout = array_filter($somethingabout);
    
    $somethingabout = implode(',', $somethingabout);
    
    // insert to db
    $_SESSION['somethingabout'] = $somethingabout;
    
    $_SESSION['nextstep'] = 8;
    exit;
}

//====== new step code

if(isset($_POST['paid_collaboration'])){
    
    $paid_collaboration = (array) $_POST['paid_collaboration'];
    $paid_collaboration = array_map('trim', $paid_collaboration);
    $paid_collaboration = array_filter($paid_collaboration);
    $paid_collaboration = implode(',', $paid_collaboration);
    
    $_SESSION['paid_collaboration'] = $paid_collaboration;
    
    //-----------
    $interested_barter_collabs = array_map('trim', $_POST['interested_barter_collabs']);
    $interested_barter_collabs = array_filter($interested_barter_collabs);
    $interested_barter_collabs = implode(',', $interested_barter_collabs);
    
    $_SESSION['interested_barter_collabs'] = $interested_barter_collabs;
    
    //-----------
    $interested_affiliate_collabs = array_map('trim', $_POST['interested_affiliate_collabs']);
    $interested_affiliate_collabs = array_filter($interested_affiliate_collabs);
    $interested_affiliate_collabs = implode(',', $interested_affiliate_collabs);
    
    $_SESSION['interested_affiliate_collabs'] = $interested_affiliate_collabs;
    
    //------------
    $audience_gender = array_map('trim', $_POST['audience_gender']);
    $audience_gender = array_filter($audience_gender);
    $audience_gender = implode(',', $audience_gender);
    
    $_SESSION['audience_gender'] = $audience_gender;
    
    exit;
}


if(isset($_POST['content_youtube'])){
    
    $content_youtube = array_map('trim', $_POST['content_youtube']);
    $content_youtube = array_filter($content_youtube);
    $content_youtube = implode(',', $content_youtube);
    
    $_SESSION['content_youtube'] = $content_youtube;
    
    //-----------
    $your_gender = array_map('trim', $_POST['your_gender']);
    $your_gender = array_filter($your_gender);
    $your_gender = implode(',', $your_gender);
    
    $_SESSION['your_gender'] = $your_gender;
    
    //-----------
    $content_language = array_map('trim', $_POST['content_language']);
    $content_language = array_filter($content_language);
    $content_language = implode(',', $content_language);
    
    $_SESSION['content_language'] = $content_language;
    
    //------------
    
    $_SESSION['your_age'] = $_POST['your_age'];
    
    
    //--------------- update data
    
    $data = array();
    $data['your_age'] = $_SESSION['your_age'];
    $data['content_language'] = $_SESSION['content_language'];
    $data['your_gender'] = $_SESSION['your_gender'];
    $data['content_youtube'] = $_SESSION['content_youtube'];
    
    $data['paid_collaboration'] = $_SESSION['paid_collaboration'];
    $data['interested_barter_collabs'] = $_SESSION['interested_barter_collabs'];
    $data['interested_affiliate_collabs'] = $_SESSION['interested_affiliate_collabs'];
    $data['audience_gender'] = $_SESSION['audience_gender'];
    
    include 'inc/function.php';
    $sqlObj = new Actions();
    $sqlObj->updateSurveydata($data);
    
    //---------
    exit;
}

//======== end new step code

if(isset($_POST['checkzip'])){
    
    $pincode = $_POST['c_pincode'];
    include 'inc/function.php';
    $sqlObj = new Actions();
    $count = $sqlObj->checkpincode($pincode);
    
    if($count < 1){
        echo 'notfound';
        exit;
    }else{
        echo 'found';
        exit;
    }
}

if(isset($_POST['cap_name'])){
    
    $pincode = $_POST['cap_pincode'];
    include 'inc/function.php';
    $sqlObj = new Actions();
    $count = $sqlObj->checkpincode($pincode);
    
    if($count < 1){
        echo 'notfound';
        exit;
    }
    
    // insert to db
    $data = array();
    $data['cap_name'] = $_POST['cap_name'];
    $data['cap_pincode'] = $_POST['cap_pincode'];
    $data['cap_whatsapp_num'] = $_POST['cap_whatsapp_num'];
    $data['somethingabout'] = $_SESSION['somethingabout'];
    $data['aboutcontent'] = $_SESSION['aboutcontent'];
    $data['storecontent'] = $_SESSION['storecontent'];
    $data['mobile'] = $_SESSION['verify_phone'];
    $data['user_name'] = $_SESSION['insta_username'];
    
    $data['totalviews'] = $_POST['totalviews'];
    $data['totalfollower'] = $_POST['totalfollower'];
    
    $data['ReelsCount'] = $_POST['ReelsCount'];
    $data['loginusername'] = $_POST['loginusername'];
    $data['insta_username'] = $_POST['insta_username'];
    $data['AccountCategory'] = $_POST['AccountCategory'];
    $data['totallikes2'] = $_POST['totallikes2'];
    $data['EarningAmount'] = $_POST['EarningAmount'];
    $data['last_post_date'] = $_POST['last_post_date'];
    $data['avg_view_rate'] = $_POST['avg_view_rate'];
    $data['engagement_rate'] = $_POST['engagement_rate'];
    $data['postperweek'] = $_POST['postperweek'];
    $data['avgvideoduration'] = $_POST['avgvideoduration'];
    $data['totalcomment'] = $_POST['totalcomment'];
                
    // write insert query here
    
    $sqlObj->storeUseractions($data);
    
    $_SESSION['nextstep'] = 9;
    exit;
}


function calculateViewRate($C4, $C5) {
    if ($C4 < 10000) {
        return min($C5 * 0.2, 600);
    } elseif ($C4 < 25000) {
        return min($C5 * 0.2, 1500);
    } elseif ($C4 < 50000) {
        return min($C5 * 0.2, 3000);
    } elseif ($C4 < 100000) {
        return min($C5 * 0.2, 6000);
    } elseif ($C4 < 300000) {
        return min($C5 * 0.2, 18000);
    } elseif ($C4 < 600000) {
        return min($C5 * 0.2, 36000);
    } elseif ($C4 <= 1000000) {
        return min($C5 * 0.2, 60000);
    } else {
        return "";  // Or return null if you prefer
    }
}

function calculateEngRate($C4, $C6) {
    if ($C4 < 10000) {
        return min($C6 * 8, 1200);
    } elseif ($C4 < 25000) {
        return min($C6 * 9, 3375);
    } elseif ($C4 < 50000) {
        return min($C6 * 10, 7500);
    } elseif ($C4 < 100000) {
        return min($C6 * 12, 18000);
    } elseif ($C4 < 300000) {
        return min($C6 * 14, 63000);
    } elseif ($C4 < 600000) {
        return min($C6 * 15, 135000);
    } elseif ($C4 <= 1000000) {
        return min($C6 * 15, 225000);
    } else {
        return "";  // Or return null if you prefer
    }
}

function calculatefeqPost($C4, $C7) {
    if ($C4 <= 10000) {
        if ($C7 <= 3) {
            return 100;
        } elseif ($C7 > 3) {
            return 250;
        }
    } elseif ($C4 <= 25000) {
        if ($C7 <= 3) {
            return 300;
        } elseif ($C7 > 3) {
            return 500;
        }
    } elseif ($C4 <= 50000) {
        if ($C7 <= 3) {
            return 500;
        } elseif ($C7 > 3) {
            return 750;
        }
    } elseif ($C4 <= 100000) {
        if ($C7 <= 3) {
            return 750;
        } elseif ($C7 > 3) {
            return 1000;
        }
    } elseif ($C4 <= 300000) {
        if ($C7 <= 3) {
            return 2000;
        } elseif ($C7 > 3) {
            return 4000;
        }
    } elseif ($C4 <= 600000) {
        if ($C7 <= 3) {
            return 2000;
        } elseif ($C7 > 3) {
            return 4000;
        }
    } elseif ($C4 <= 1000000) {
        if ($C7 <= 3) {
            return 3000;
        } elseif ($C7 > 3) {
            return 5000;
        }
    } else {
        return "";  // Or return null if you prefer
    }
}


?>