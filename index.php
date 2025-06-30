<?php

session_start();


//include 'inc/function.php';
//$sqlObj = new Actions();
//$profile_res = $sqlObj->getProfileData('amitabhbachchan');
//print_r($profile_res);die();

//session_destroy();

function formatNumber($num) {
    if ($num >= 1000000) {
        return number_format($num / 1000000, 1) . 'M';
    } elseif ($num >= 1000) {
        return number_format($num / 1000, 1) . 'K';
    } else {
        return (string)$num;
    }
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


$data = array();

$data['totalLikes2'] = 0;
$data['totalViews2'] = 0;
$data['totalComments2'] = 0;

$data['ReelsCount'] = 0;
$data['instausername'] = '';
$data['instacategory'] = '';

$data['totalViews'] = 0;
$data['follower'] = 0;
$data['following'] = 0;
$data['posts'] = 0;
$data['name'] = 'User';
$data['avg_view_rate'] = 0;
$data['totalLikes'] = 0;
$data['bio'] = '';
$data['totalComments'] = 0;
$data['avgPostPerWeek'] = 0;
$data['avgVideoDuration'] = 0;
$data['engagement_rate'] = 0;
$data['last_post_date'] = '';
$data['follower_earning'] = 0;
$data['viewrate_earning'] = 0;
$data['eng_earning'] = 0;
$data['feq_earning'] = 0;
$data['total_earning'] = 0;
$data['avrage_view_rate'] = 0;
$data['avrage_eng_rate'] = 0;
$data['profilePicture'] = '';

if(isset($_SESSION['profile_res']) && $_SESSION['profile_res'] != '' && $_SESSION['profile_res'] != null){
    $profile_data = $_SESSION['profile_res'];
    
    
    if(!empty($profile_data->result) && $_SESSION['profile_res']->result[0] != ''){
        
        $data['totalLikes2'] = $profile_data->result[0]->totalLikes;
        $data['totalViews2'] = $profile_data->result[0]->reels->totalViews;
        $data['totalComments2'] = $profile_data->result[0]->reels->totalComments;
        
        $data['ReelsCount'] = $profile_data->result[0]->reels->reelCount;
        $data['instausername'] = $profile_data->result[0]->username;
        $data['instacategory'] = $profile_data->result[0]->category;
        
        
        //$data['profilePicture'] = $_SESSION['profilePicture'];
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
        
        
        $data['totalViews'] = $profile_data->result[0]->reels->totalViews;
        $data['follower'] = $profile_data->result[0]->follower;
        $data['following'] = $profile_data->result[0]->following;
        $data['posts'] = $profile_data->result[0]->totalContent;
        $data['name'] = $profile_data->result[0]->name;
        
        $avg_view_rate = $data['totalViews']/$data['follower'];
        $data['avg_view_rate'] = number_format($avg_view_rate, 2);
        
        
        $data['totalLikes'] = $profile_data->result[0]->totalLikes;
        $data['bio'] = $profile_data->result[0]->bio;
        
        $data['totalComments'] = $profile_data->result[0]->reels->totalComments;
        $data['avgPostPerWeek'] = $profile_data->result[0]->reels->avgPostPerWeek;
        $avgVideoDuration = $profile_data->result[0]->reels->avgVideoDuration;
        
        $formattedAvgVideoDuration = number_format($avgVideoDuration, 2);
        $data['avgVideoDuration'] = $formattedAvgVideoDuration;

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
        
        //$data['total_earning'] = number_format($total_earning, 2);
        
        //$reelAverageViews = $profile_data->result[0]->reels->reelAverageViews;
        $reelAverageViews = $profile_data->result[0]->reels->totalViews;
        //$avrage_view_rate = ($reelAverageViews/$data['follower'])/100;
        $avrage_view_rate = ($reelAverageViews/$data['follower'])*100;
        $data['avrage_view_rate'] = number_format($avrage_view_rate, 2);
        
        $avrage_eng_rate = (($data['totalComments']+$data['totalLikes'])/$data['totalViews'])*100;
        $data['avrage_eng_rate'] = number_format($avrage_eng_rate, 2);

    }else{
        $data['totalComments2'] = 0;
        $data['totalViews2'] = 0;
        $data['totalLikes2'] = 0;
        $data['ReelsCount'] = 0;
        $data['instausername'] = '';
        $data['instacategory'] = '';

        $data['totalViews'] = 0;
        $data['follower'] = 0;
        $data['following'] = 0;
        $data['posts'] = 0;
        $data['name'] = 'User';
        $data['bio'] = '';
        
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

}
$data['follower2'] = formatNumber($data['follower']);
$data['totalComments2'] = formatNumber($data['totalComments2']);

//$data['totalComments2'] = formatNumber($data['totalComments2']);
$data['totalLikes2'] = formatNumber($data['totalLikes2']);
$data['totalViews2'] = formatNumber($data['totalViews2']);

//echo '<pre>';print_r($_SESSION['profile_res']);die();

/*

$profile_res = array();
if (isset($_SESSION['profile_res'])) {
    $profile_res = $_SESSION['profile_res'];
}

*/

$nextstep = 1;
if (isset($_SESSION['nextstep'])) {
    $nextstep = $_SESSION['nextstep'];
}

if(isset($_SESSION['fetch_record']) && $_SESSION['fetch_record'] == 0){
    //$nextstep = 11;
}

if($nextstep == 9){
    //session_destroy();
    header('Location: /earning-calculator/report-card.php');
    exit;
}

if(isset($_GET['sessionclear']) && $_GET['sessionclear'] == '1'){
    session_destroy();
    $nextstep = 1;
}
$verify_phone = '';
if(isset($_SESSION['verify_phone'])){
    $verify_phone = $_SESSION['verify_phone'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Calculator - Vibes Buzz</title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="Cushions Custom">
	<meta name="robots" content="follow, index, max-snippet:-1, max-video-preview:-1, max-image-preview:large" />
	<link rel="icon" href="images/favicon.png" sizes="32x32" />
	<link rel="stylesheet" type="text/css" href="css/reset.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
    
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-VH5ZWC7RYN"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-VH5ZWC7RYN');
</script>

    <meta name="facebook-domain-verification" content="5uev38d3sc8b5ft1o5arig658o9r8m" />
    <!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '818783317033861');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=818783317033861&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->

<!-- Meta Pixel subneet Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '883443177244485');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=883443177244485&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
</head>

<body class="background">

	<section class="Step1" style="display:none">
		<div class="container">
			<div class="LogoTopnav">
				<a href="index.php" class="LogoClick">
					<img src="images/logo.png" alt="Vibes Buzz" class="Logo" />
				</a>
			</div>
			<div class="row">
				<div class="col col-1">
					<div class="MainHeading MainColor">An Influencer can earn between 15K to 5 Lakh per month. </div>
					<div class="SubHeading">Take our One minute survey and find out how much you can earn from Social
						Media. </div>
						<div class="newInputGroup">
						    <div class="textdddd">@</div>
				        	<input type="text" id="insta_user_name" placeholder="Type your Insta handle">
				            <button type="button" id="submit_insta_user">
									<img class="BlackRightIcon"
									src="images/black-right-icon.svg" alt="icon" /></button>
					</div>
					<span class="username_required" style="display:none"><img src="images/close.svg" alt="gif" />Please enter your insta handle</span>
						<span class="pleasewaitmsg" style="display:none"><img src="images/fetching.svg" alt="gif" />fetching data</span>
						<span class="notfoundmgs" style="display:none"><img src="images/close.svg" alt="gif" />  Handle doesn't exist</span>
						<span class="incorrectusername" style="display:none"><img src="images/close.svg" alt="gif" />  Please enter a valid Instagram handle (e.g. <b>instagram</b>). Do not include <code>@</code> or the link.</span>
					
                <div class="privacy-police-page formobile">
                    <a class="HOMEPAGELINKSS" target="_blank" href="https://www.thevibes.buzz/earning-calculator/privacy-policy.php">Privacy Policy</a>
                     <a class="HOMEPAGELINKSS" target="_blank" href="https://www.thevibes.buzz/earning-calculator/terms-and-conditions.php">Terms and Conditions </a>
                </div> 
                    
				</div>
				<div class="col col-2">
					<div class="ImagePreview">
						<img src="images/step1.png" alt="Step 1" class="Step 1 Image" />
					</div>
				</div>
			</div>
			   <div class="privacy-police-page fordesktop">
                    <a class="HOMEPAGELINKSS" target="_blank" href="https://www.thevibes.buzz/earning-calculator/privacy-policy.php">Privacy Policy</a>
                     <a class="HOMEPAGELINKSS" target="_blank" href="https://www.thevibes.buzz/earning-calculator/terms-and-conditions.php">Terms and Conditions </a>
                </div> 
			<div class="FooterMsgFiestPage">
				<div class="FooterLine TextPart">an initiative by <span class="HighlightMsg">The Vibes Academy</span>
				</div>
				<div class="FooterLine LinePart"><span class="LineDesign"></span></div>
				<div class="FooterLine TextPart"><span class="MainColor VisitorCount"><span id="hit-count2">26356</span> people</span> visited till
					now</div>
			</div>
		</div>
	</section>

	<section class="Step2" style="display:none">
		<div class="container">
			<div class="LogoTopnav">
				<a href="index.php" class="LogoClick">
					<img src="images/logo.png" alt="Vibes Buzz" class="Logo" />
				</a>
			</div>
			<div class="row">
				<div class="col col-1">
					<div class="MainHeading MainColor">Login with phone number</div>

					<form>
						<div class="form-group ">
							<label for="phoneno">Enter your phone number to send one time Password</label>
							<div class="input-group addtick foriconuse">
								<input type="text" maxlength="3" value="+91" disabled required />
								<input type="number" value="<?php echo $verify_phone;?>" maxlength="10" class="phone-input num1 mobilenumberInput" required />
							</div>
						</div>
						<div class="form-group OTPgroup otpinputs otpanimation" style="display:none">
							<label class="labelforOTP" for="phoneno">We have sent the OTP to your number
								<b class="senton">XXXXXXX99</b> </label>
								<div class="OTPmainGroup">
								    <div class="input-group addtick foriconuse">
							        	<input type="number" maxlength="1" class="otp-input otp1 typeotp" value='' required />
							        	<input type="number" maxlength="1" class="otp-input otp2 typeotp" value='' required />
							        	<input type="number" maxlength="1" class="otp-input otp3 typeotp" value='' required />
							        	<input type="number" maxlength="1" class="otp-input otp4 typeotp" value='' required />
						        	</div>
						        	
						        	<!--a href="javascript:;" id="myLink" class="ResendOTP" disabled>Resend OTP <span id="timer">15</span>s</a-->
						            <button class="ResendOTP" type="button" disabled>Resend OTP <span id="timer">15</span>s</button>
							
								</div>
						
						</div>
						
					</form>

                    <button type="button" class="Btn LoginWithInstagram sendotp"> Send OTP  </button>
                    
                    	<span class="TimesOnly" style="display:none"><img src="images/information.svg" alt="gif" />You can check only 3 times only</span>

					<a href="javascript:;" class="Btn LoginWithInstagram NextBtn2 verifotp" style="display:none"> Next </a>

				</div>
				<div class="col col-2">
					<div class="ImagePreview">
						<img src="images/step2.png" alt="Step 1" class="Step 1 Image" />
					</div>
				</div>
			</div>
			<div class="FooterMsgFiestPage">
				<div class="FooterLine TextPart">an initiative by <span class="HighlightMsg">The Vibes Academy</span>
				</div>
				<div class="FooterLine LinePart"><span class="LineDesign"></span></div>
				<div class="FooterLine TextPart"><span class="MainColor VisitorCount"><span id="hit-count">26356</span> people</span> visited till
					now</div>
			</div>
		</div>
	</section>


	<section class="Step3" style="display:none">
		<div class="container">
			<div class="NavGroup">
				<div class="NavBar">
					<div class="MainColor MainHeading MainNav ">Hi <span class="loginusername"><?php echo $data['name'];?></span> ! <div class="time">5 seconds to go</div>
					</div>
				</div>
				<div class="ProgressBar progressbar-15"></div>
			</div>
			<div class="RowRatio BcRatio ">
				<div class="r-col-1 r-col">
					<div class="RatioHeading">Did you know, <span>your last <b class="ReelsCount"><?php echo $data['ReelsCount'];?></b> Reels have</span> </div>

					<div class="ViewCount">
						<div class="InnerCount">
							<div class="Text">
								<div class="ViewCountFi totalviews counter" data-count="<?php echo $data['totalViews'];?>" id="counter"><?php echo $data['totalViews'];?></div>
								<div class="ViewTitle">views</div>
							</div>
						</div>
					</div>

					<a href="javascript:;" class="Btn NextBtn LoginWithInstagram"> Next 
									
					</a>

				</div>
				<div class="r-col-2 r-col">
					<div class="InstaPreview">
						<div class="Profile">
							<div class="ProfilePic">
								<img class="userprofile" src="<?php echo $data['profilePicture'];?>"
									alt="image" />
							</div>
							<div class="FollowersDetails">
								<div class="count">
									<div class="fnum totalposts"><?php echo $data['posts'];?></div>
									<div class="ftitle">posts</div>
								</div>
								<div class="count">
									<div class="fnum totalfollower"><?php echo $data['follower2'];?></div>
									<div class="ftitle">followers</div>
								</div>
								<div class="count">
									<div class="fnum totalfollowing"><?php echo $data['following'];?></div>
									<div class="ftitle">follwing</div>
								</div>
							</div>
						</div>
						<div class="UserName loginusername"><?php echo $data['name'];?></div>
						<div class="UserDescription"><?php echo $data['bio'];?></div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="Step4" style="display:none">
		<div class="container">
			<div class="NavGroup">
				<div class="NavBar">
					<div class="MainColor MainHeading MainNav progressbar-20">Hi <span class="loginusername"><?php echo $data['name'];?></span> ! <div class="time">3 seconds to go</div>
					</div>
				</div>
				<div class="ProgressBar progressbar-30"></div>
			</div>
			<div class="RowRatio RowRatio2">
				<div class="r-col-1 r-col">
					<div class="RatioHeading bold StepHeading">Why do you make content?</div>

					<ul class="chips make_content">
						<li class="">Social Change</li>
						<li class="">Travel</li>
						
						<li class="">Earn Money</li>
						<li class="">To Inspire</li>
						<li class="">Storytelling</li>
						<li class="">Show Talent</li>
						<li class="">Entertainment</li>
						<li class="">Awareness</li>
						<li class="">Satire & Humour</li>
						<li class="">Education</li>
						<li class="">Transparency</li>
						<li class="">Advocacy</li>
						<li class="">Social Commentry</li>
						<li class="">Building Community</li>
						<li class="">Selling Products</li>
						<li class="">Post Reviews</li>
						<li class="OthersType">
						    <input type="text" id="make_content_other" placeholder="+ Others (Type your own)" />
						</li>
						
					</ul>


					<div class="BtnGroup">
						<a href="javascript:;" class="Btn LoginWithInstagram storeContent"> Next </a>
						<div class="tiptext">Select between 1 to 5 options</div>
					</div>


				</div>
				<div class="r-col-2 r-col">

				</div>
			</div>
		</div>
	</section>

	<section class="Step5" style="display:none">
		<div class="container">
			<div class="NavGroup">
				<div class="NavBar">
					<div class="MainColor MainHeading MainNav progressbar-40">Hi <span class="loginusername"><?php echo $data['name'];?></span> ! <div class="time">3 seconds to go</div>
					</div>
				</div>
				<div class="ProgressBar progressbar-45"></div>
			</div>
			<div class="RowRatio RowRatio2">
				<div class="r-col-1 r-col">
					<div class="RatioHeading bold StepHeading">I make content about</div>

					<ul class="chips content_about">
						<li class="">Beauty & Fashion</li>
						<li class="">Fitness & Health</li>
						<li class="">Technology & Gadget</li>
						<li class="">Music & Dances</li>
						<li class="">Food & Cooking</li>
						<li class="">Spirituality</li>
						<li class="">Lifestyle</li>
						<li class="">Pet Care</li>
						<li class="">Books</li>
						<li class="">Videos</li>
						<li class="">Literature</li>
						<li class="">Gaming</li>
						<li class="">Education & Learning</li>
						<li class="">Finance & Business</li>
						<li class="">Photography</li>
						<li class="">Environmental and Sustainability</li>
						<li class="">DIY & Craft</li>
						<li class="">Entertainment</li>
						<li class="">Automotive</li>
						<li class="">Personal Development</li>
						<li class="">Activism</li>
						<li class="OthersType"><input type="text" id="about_content_other" placeholder="+ Others (Type your own)" />
						</li>

					</ul>


					<div class="BtnGroup">
						<a href="javascript:;" class="Btn LoginWithInstagram aboutContent"> Next </a>
						<div class="tiptext">Select between 1 to 5 options</div>
					</div>


				</div>
				<div class="r-col-2 r-col">

				</div>
			</div>
		</div>
	</section>

	<section class="Step6" style="display:none">
		<div class="container">
			<div class="NavGroup">
				<div class="NavBar">
					<div class="MainColor MainHeading MainNav progressbar-60">Hi <span class="loginusername"><?php echo $data['name'];?></span> ! <div class="time">2 seconds to go</div>
					</div>
				</div>
				<div class="ProgressBar progressbar-60"></div>
			</div>
			<div class="RowRatio BcRatio3">
				<div class="r-col-1 r-col">
					<div class="RatioHeading">Did you know, <span>your last <b class="ReelsCount"><?php echo $data['ReelsCount'];?></b> Reels have</span> </div>

					<div class="ViewCount ViewCount2">
						<div class="InnerCount InnerCount2">
							<div class="Text">
								<div class="ViewCountFi totallikes counter2" data-count="<?php echo $data['totalLikes'];?>" id="counter2"><?php echo $data['totalLikes'];?></div>
								<div class="ViewTitle">likes</div>
							</div>
						</div>
					</div>

					<a href="javascript:;" class="Btn LoginWithInstagram NextBtn"> Know More </a>

				</div>
				<div class="r-col-2 r-col">

				</div>
			</div>
		</div>
	</section>
	<section class="Step7" style="display:none">
		<div class="container">
			<div class="NavGroup">
				<div class="NavBar">
					<div class="MainColor MainHeading MainNav progressbar-80">Hi <span class="loginusername"><?php echo $data['name'];?></span> ! <div class="time">1 seconds to go</div>
					</div>
				</div>
				<div class="ProgressBar progressbar-75"></div>
			</div>
			<div class="RowRatio RowRatio2">
				<div class="r-col-1 r-col">
					<div class="RatioHeading bold StepHeading">I want to do something about</div>

					<ul class="chips something_about">
						<li class="">Poverty</li>
						<li class="">Pollution</li>
						<li class="">Healthcare</li>
						<li class="">Culture & Heritage</li>
						<li class="">Education</li>
						<li class="">Justice</li>
						<li class="">Communal Harmony</li>
						<li class="">Child Labour</li>
						<li class="">Unemployment</li>
						<li class="">Freedom of Speech</li>
						<li class="">Bahujan Issues</li>
						<li class="">Food Security</li>
						<li class="">Human Rights</li>
						<li class="">Digital Data & Privacy</li>
						<li class="">Global Peace</li>
						<li class="">Corruption</li>
						<li class="">Domestic Violence</li>
						<li class="">Gender Equality</li>
						<li class="">Disinformation</li>
						<li class="">Pandemics</li>
						<li class="">Mental Health</li>
						<li class="">Corporate Accountability</li>
						<li class="">Climate Change</li>
						<li class="">Caste Discrimination</li>
						<li class=" OthersType"><input type="text" id="something_about_other" placeholder="+ Others (Type your own)" />
						</li>

					</ul>


					<div class="BtnGroup">
						<a href="javascript:;" class="Btn LoginWithInstagram saveAboutcontent"> Next </a>
						<div class="tiptext">Select between 1 to 5 options</div>
					</div>


				</div>
				<div class="r-col-2 r-col">

				</div>
			</div>
		</div>
	</section>
	<section class="Step8" style="display:none">
		<div class="container">
			<div class="NavGroup">
				<div class="NavBar">
					<div class="MainColor MainHeading MainNav ">Hi <span class="loginusername"><?php echo $data['name'];?></span> ! <div class="time">You are one click away from your report</div>
					</div>
				</div>
				<div class="ProgressBar progressbar-100"></div>
			</div>
			<div class="RowRatio RowRatio2">
				<div class="r-col-1 r-col">
					<div class="RatioHeading w80 StepHeading">You are almost there! Here is your last step to see how
						much you can earn</div>

					<div class="row">
						<div class="col col-1">

							<form>
								<div class="form-group form-group2">
									<label for="Name">Name</label>
									<div class="input-group">
										<input type="text" class="NameInput" required="">

									</div>
								</div>
								
								
								<div class="form-group form-group2">
								    <label class="labelforOTP" for="phoneno">Pin Code </label>
										<div class="input-group addtick foriconuse">
											<input type="number" maxlength="6" class=" otp-input otp-input22 pin1" required="">
										
										</div>    
								</div>
								
								<div class="form-group form-group2">
								    <label for="samemobile">Whatsapp Number  <input type="checkbox" id="samemobile"><span class="phonecopy">Same as Phone No</span></label>
										<div class="input-group addtick foriconuse">
										   
											<input type="text" maxlength="3" value="+91" disabled="" required="">
											<input type="number" maxlength="10" class="mobilenumberInput phone-input whatsapp_num1" value="" required="">
											
										</div>
								</div>
							</form>


						</div>
						<div class="col col-2">
							<div class="ImagePreview">
								<img src="images/step8.png" alt="Step 1" class="NameStep Step 1 Image">
							</div>
						</div>
					</div>

					<a href="javascript:;" class="Btn LoginWithInstagram mrtop earn_capacity"> Your earning capacity </a>



				</div>
				<div class="r-col-2 r-col">

				</div>
			</div>
		</div>
	</section>

	<section class="Step9" style="display:none">
		<div class="container">


			<div class="rowthree">
				<div class="three_one three three2222">
					<div class="CusName MainColor">Hi <span class="loginusername"><?php echo $data['name'];?></span> !</div>
					<div class="SubHeading">Here is your Report card</div>
				</div>
				<div class="three_two three three2222 earning_result">

					<div class="PaymentBox">
					<div class="BuzzLogo"><img src="images/BuzzLogo.svg" /></div>
			        
			        <div class="REPORTCARD">REPORT CARD</div>

						<div class="NameGorupPayment">
							<div class="CusName MainColor">Hi <span class="loginusername loginusername_rp"><?php echo $data['name'];?></span> !</div>
							<div class="InstaHandle"><span class="insta_username insta_username_rp"><?php echo $data['instausername'];?></span> <span class="AccountCategory AccountCategory_rp"><?php echo $data['instacategory'];?></span> </div>
						</div>
						<div class="EarningCard">
							<div class="EarnLine1">You can earn upto</div>
							<div class="EarningAmount EarningAmount_rp">₹ <?php echo $data['total_earning'];?></div>
							<div class="EarnLine1">per post</div>
						</div>
						
						<div class="InstaProfileInDetails bottommargin">
							<div class="InstaInfoCount">
								<div class="TtileInsta">Followers</div>
								<div class="CountInsta totalfollower userfollower"><?php echo $data['follower2'];?></div>
							</div>
							<div class="InstaInfoCount">
								<div class="TtileInsta">Last Post</div>
								<div class="CountInsta last_post_date last_post_date_rp"><?php echo $data['last_post_date'];?></div>
							</div>
					
						</div>

						<div class="InstaProfileInDetails MorePerformaceCount">
						    <div class="PerformanceReach">Performance of your last <b class="ReelsCount ReelsCount_rp"><?php echo $data['ReelsCount'];?></b> reels</div>
							<div class="InstaInfoCount border-1">
								<div class="TtileInsta">Av. View Rate</div>
								<div class="CountInsta avg_view_rate avg_view_rate_rp"><?php echo $data['avrage_view_rate'];?>%</div>
							</div>
							<div class="InstaInfoCount border-2">
								<div class="TtileInsta">Engagement Rate</div>
								<div class="CountInsta engagement_rate engagement_rate_rp"><?php echo $data['avrage_eng_rate'];?></div>
							</div>
							<div class="InstaInfoCount border-3">
								<div class="TtileInsta">Posts per Week</div>
								<div class="CountInsta postperweek postperweek_rp"><?php echo $data['avgPostPerWeek'];?></div>
							</div>
							<div class="InstaInfoCount border-4">
								<div class="TtileInsta">Av. Video Duration</div>
								<div class="CountInsta avgduration avgduration_rp"><?php echo $data['avgVideoDuration'];?></div>
							</div>
						</div>
						<div class="TotalInstaInformationCount">
							<div class="InstaInfoCount">
								<div class="TtileInsta">Total Likes</div>
								<div class="CountInsta totallikes2 totallikes2_rp"><?php echo $data['totalLikes2'];?></div>
							</div>
							<div class="InstaInfoCount">
								<div class="TtileInsta">Total Views</div>
								<div class="CountInsta totalviews2 totalviews2_rp"><?php echo $data['totalViews2'];?></div>
							</div>
							<div class="InstaInfoCount">
								<div class="TtileInsta">Total Comment</div>
								<div class="CountInsta totalcomment totalcomment_rp"><?php echo $data['totalComments2'];?></div>
							</div>
						</div>

						<div class="RecommendationsByVibes">
							<div class="MainTitleRec">Recommendation</div>
							
							<div class="Recommendation engmax6">You have an amazing engagement with your audience. Continue understanding your audience demographics, create targeted videos with clear call to action.</div>
							<div class="Recommendation engless6">You need to improve your engagement with your audience. Consider improving video quality, grab attention in first 3 seconds, create videos that asks questions and use interactive stickers.</div>
						</div>


					</div>
				</div>
				<div class="three_three three three2222">
					<div class="DIconGroup">
						<div class="downloadIcon"><img src="images/download.svg" /> Download</div>
						<a href="#ex1" rel="modal:open"  class="shareIcon2 "><img src="images/share.svg" /> Share</a>
					</div>
				</div>
			</div>

		</div>
	</section>
	

	
	<section class="Step11" style="display:none">
		<div class="container">

			<div class="rowthree theeboxceneter">
			    
				<div class="three_two three">
				    <img class="loaderrr" src="images/fetching.svg" alt="loading" />
                    <b>Please wait while we fetch your profile.</b>
                   
				</div>

			</div>

		</div>
	</section>


<div class="modal sessionModal" id="sessionModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Current Session</h4>
      </div>

      <div class="modal-body">
        Do you want to remove current session and start from begin?
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger removesession">Yes</button>
        <button type="button" class="btn btn-danger closesessionmodal">Close</button>
      </div>

    </div>
  </div>
</div>

</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    function openInNewTab(url) {
        window.open(url, '_blank').focus();
    }

    function getShareText() {
        var totalLikes = document.querySelector('.totallikes2').textContent;
        var totalViews = document.querySelector('.totalviews2').textContent;
        var totalComments = document.querySelector('.totalcomment').textContent;
        return `My Instagram has received a total of ${totalLikes} likes, ${totalViews} views, and ${totalComments} comments. Check out www.vibes.buzz for more details!`;
    }

    document.querySelector('.Telegram').addEventListener('click', function () {
        var url = `https://t.me/share/url?url=${encodeURIComponent('http://www.vibes.buzz')}&text=${encodeURIComponent(getShareText())}`;
        openInNewTab(url);
    });

    document.querySelector('.Twitter').addEventListener('click', function () {
        var url = `https://twitter.com/intent/tweet?text=${encodeURIComponent(getShareText())}&url=${encodeURIComponent('http://www.vibes.buzz')}`;
        openInNewTab(url);
    });

    document.querySelector('.Whatsapp').addEventListener('click', function () {
        var url = `https://api.whatsapp.com/send?text=${encodeURIComponent(getShareText() + ' ' + 'http://www.vibes.buzz')}`;
        openInNewTab(url);
    });

    document.querySelector('.Share').addEventListener('click', function () {
        if (navigator.share) {
            navigator.share({
                title: 'Check this out!',
                text: getShareText(),
                url: 'http://www.vibes.buzz'
            }).catch((error) => console.log('Error sharing:', error));
        } else {
            alert('Your browser does not support the Web Share API');
        }
    });
});
</script>

<script>
	$(document).ready(function () {
		$('.phone-input, .otp-input').on('input', function () {
			if (this.value.length > this.maxLength) {
				this.value = this.value.slice(0, this.maxLength);
			}
			if (this.value.length >= this.maxLength) {
				$(this).next('input').focus();
			}
		});

		$('.phone-input, .otp-input').on('keydown', function (e) {
			if (e.key === 'Backspace' && this.value.length === 0) {
				$(this).prev('input').focus();
			}
		});
	});
</script>
<script>
    $(document).ready(function () {
        
        <?php 
        if ($nextstep == 9) {
        ?>
            
            $('#sessionModal').modal('show');
            
        <?php
        }
        ?>
        
        $(document).on('click', '.closesessionmodal', function() {
            //$('#sessionModal').modal('hide');
            $('.close-modal').trigger('click');
            
        });
            
        $('.removesession').on('click', function(){
            
            var data = {
                'clearsession': 'clearsession',
            };
			$.ajax({
				type:'post',
				data:data,
				url:'request-action.php',
				success:function(res){
				    
					var currentUrl = window.location.href;
                    window.location.href = currentUrl
				}
			});
			
			/*
            var currentUrl = window.location.href;
            var newParams = '?sessionclear=1'; 
            
            if (currentUrl.indexOf('?') > -1) {
                currentUrl += '&' + newParams.substring(1);
            } else {
                currentUrl += newParams;
            }
            
            window.location.href = currentUrl*/
        });
        //var $sendOtpButton = $('.sendotp');
        //var $phoneNumberInput = $('.num1');
        
        
        $('.addtick').removeClass('foriconuse');
        
        //$('.sendotp').prop('disabled', true);
        
        var num1Length = $('.num1').val().length;
        if (num1Length > 9) {
            
            $('.num1').closest('.addtick').addClass('foriconuse');
            $('.sendotp').prop('disabled', false);
        } else {
            $('.num1').closest('.addtick').removeClass('foriconuse');
            $('.sendotp').prop('disabled', true);
        }
        
        
        $('.typeotp').on('input', function() {
            var o1 = $('.otp1').val();
            var o2 = $('.otp2').val();
            var o3 = $('.otp3').val();
            var o4 = $('.otp4').val();
            var missotp = 0;
            if(o1 == '' || o2 == '' || o3 == '' || o4 == ''){
                missotp = 1;
            }
            if(missotp == 1){
                $(this).closest('.addtick').removeClass('foriconuse');
            }else{
                $(this).closest('.addtick').addClass('foriconuse');
            }
        });
        
        $('.whatsapp_num1').on('input', function() {
            var inputLength = $(this).val().length;
            if (inputLength > 9) {
                
                $(this).closest('.addtick').addClass('foriconuse');
                
            } else {
                $(this).closest('.addtick').removeClass('foriconuse');
                
            }
            
        });
        
        $('.pin1').on('input', function() {
            var inputLength = $(this).val().length;
            if (inputLength > 5) {
                
            var pin1 = $(this).val();
            var data = {
            'c_pincode': pin1,
            'checkzip': 'checkzip',
            };
			$.ajax({
				type:'post',
				data:data,
				url:'request-action.php',
				success:function(res){
				    
				    if(res == 'notfound'){
				        
				    }else{
				        $('.pin1').closest('.addtick').addClass('foriconuse');
				        console.log();
				    }
					
				}
			});
                
                //$(this).closest('.addtick').addClass('foriconuse');
                
            } else {
                $(this).closest('.addtick').removeClass('foriconuse');
                
            }
            
        });
        
        $('.num1').on('input', function() {
            var inputLength = $(this).val().length;
            if (inputLength > 9) {
                
                $(this).closest('.addtick').addClass('foriconuse');
                $('.sendotp').prop('disabled', false);
            } else {
                $(this).closest('.addtick').removeClass('foriconuse');
                $('.sendotp').prop('disabled', true);
            }
            console.log(inputLength);
        });
        
        function totalViewCounter(){
            var targetNumber = parseInt($('#counter').text());
            var currentNumber = 0;
            var duration = 500;
            
            var increment = targetNumber / (duration / 10);
            
            var counterInterval = setInterval(function() {
                currentNumber += increment;
                
                if (currentNumber >= targetNumber) {
                    currentNumber = targetNumber;
                    clearInterval(counterInterval);
                }
                
                //$('#counter').text(Math.floor(currentNumber));
                $('#counter').text(Math.floor(currentNumber).toLocaleString());
            }, 10);
        }
        
        function totalViewCounter2(){
            var targetNumber = parseInt($('#counter2').text());
            var currentNumber = 0;
            var duration = 500;
            
            var increment = targetNumber / (duration / 10);
            
            var counterInterval = setInterval(function() {
                currentNumber += increment;
                
                if (currentNumber >= targetNumber) {
                    currentNumber = targetNumber;
                    clearInterval(counterInterval);
                }
                
                //$('#counter2').text(Math.floor(currentNumber));
                $('#counter2').text(Math.floor(currentNumber).toLocaleString());
            }, 10);
        }
        
        <?php
        if($nextstep == 3){
        ?>
            totalViewCounter();
        <?php    
        }
        ?>
        
        <?php
        if($nextstep == 6){
        ?>
            totalViewCounter2();
        <?php    
        }
        ?>
        
        $('.Recommendation').hide();
		
		<?php 
		if($data['avrage_view_rate'] > 20){
		?>
		    $('.viewmax20').show();
		<?php 
		}else{
		?>
		    $('.viewless20').show();
		<?php    
		}
		?>
		
		
		<?php 
		if($data['avrage_eng_rate'] > 3){
		?>
		    $('.engmax6').show();
		<?php 
		}else{
		?>
		    $('.engless6').show();
		<?php    
		}
		?>
		
		
        <?php
        if($nextstep == 9){
        ?>
            window.location.href = "report-card.php";
            exit;
            $('body').removeClass('background');
            $('body').removeClass('background3');
            $('body').addClass('background2');
			
        <?php    
        }
        ?>
        
        default_phone = '';
        
        // Show the first step initially
        var nextstep = '<?php echo $nextstep;?>';
        $('.Step'+nextstep).show();
        
        // Function to handle the button click
        
      
        $('.closeShareView').click(function () {
            $('.Step10').hide();
            $('.Step9').show();
            
            $('body').removeClass('background');
            $('body').removeClass('background3');
            $('body').addClass('background2');
        });
        $('.NextBtn').click(function () {
            var currentStep = $(this).closest('section');
            var nextStep = currentStep.next('section');

            if (nextStep.length) {
                currentStep.hide();
                nextStep.show();
            }
        });
        
        
        var timer;
        var countdown = 15;
        
        function startCountdown() {
            $('#timer').text(countdown);
            timer = setInterval(function() {
              countdown--;
              $('#timer').text(countdown);
              if (countdown === 0) {
                clearInterval(timer);
                $('.ResendOTP').prop('disabled', false);
              }
            }, 1000);
        }
        
        function resetCountdown() {
            clearInterval(timer);
            countdown = 15;
            $('.ResendOTP').prop('disabled', true);
            startCountdown();
        }
          
          
        $('.sendotp').click(function(){
            $(".TimesOnly").hide();
            var phone = $('.num1').val();
            
            if(phone == ''){
                return;
            }
            var inputLength = $('.num1').val().length;
            
            if(inputLength < 10){
                return;
            }
           
            default_phone = phone;
            //var phone = num1 + num2 + num3;
            
            var lastnum = phone.slice(-2);
            
            var data = {
				'phone':phone
			}
			$.ajax({
				type:'post',
				data:data,
				url:'request-action.php',
				success:function(res){
				    if(res == 'limitcross'){
				        $(".TimesOnly").show();
				        
				    }else{
				        $(".TimesOnly").hide();
				        
				        $('.senton').text('XXXXXXX'+lastnum);
    				    $('.sendotp').hide();
    				    //$('.sendotp').text('Resend OTP');
    					$('.otpinputs').show();
    					  $('.otpinputs').addClass('otpanimationExpend');
    					
    					$('.verifotp').show();    
    					
    					startCountdown();
				    }
				    
				}
			});
		
        });
        
          $('.ResendOTP').click(function(){
            $(".TimesOnly").hide();
            var phone = $('.num1').val();
            if(phone == ''){
                return;
            }
           
            default_phone = phone;
            //var phone = num1 + num2 + num3;
            
            var lastnum = phone.slice(-2);
            
            var data = {
				'phone':phone
			}
			$.ajax({
				type:'post',
				data:data,
				url:'request-action.php',
				success:function(res){
				    if(res == 'limitcross'){
				        $(".TimesOnly").show();
				        
				    }else{
				        $(".TimesOnly").hide();
				        
				        $('.senton').text('XXXXXXX'+lastnum);
    				    
    				    //$('.sendotp').text('Resend OTP');
    					$('.otpinputs').show();
    					  $('.otpinputs').addClass('otpanimationExpend');
    					
    					$('.verifotp').show();    
    					
    					resetCountdown();
				    }
				    
				}
			});
		
        });
        
        
        
        $('.verifotp').click(function(){
            var otp1 = $('.otp1').val();
            var otp2 = $('.otp2').val();
            var otp3 = $('.otp3').val();
            var otp4 = $('.otp4').val();
            
            var otp = otp1 + otp2 + otp3 + otp4;
            
            var selectedphone = $('.num1').val();
            
            var data = {
				'otp':otp,
				'selectedphone':selectedphone,
			}
			$.ajax({
				type:'post',
				data:data,
				url:'request-action.php',
				success:function(res){
					if(res == '1'){
					    
					    //getProfiledata();
					    getProfiledata1();
					    
					}else{
					    alert('Please enter correct otp!');
					}
				}
			});
		
        });
        
        
        function getProfiledata1(){
            
            $('.Step2').hide();
            $('.Step11').show();
            
            var data = {
				'getinsta2':'insta'
			}
			$.ajax({
				type:'post',
				data:data,
				url:'request-action.php',
				success:function(res){
					var res = JSON.parse(res);
					//console.log(res.follower);
					
					$('.totalviews').text(res.totalViews);
					$('.ReelsCount').text(res.ReelsCount);
					$('.insta_username').text(res.instausername);
					$('.AccountCategory').text(res.instacategory);
					
					$('.totalposts').text(res.posts);
					$('.totalfollower').text(res.follower);
					$('.totalfollowing').text(res.following);
					$('.UserName').text(res.name);
					$('.loginusername').text(res.name);
					
					$('.UserDescription').text(res.bio);
					//$('.avg_view_rate').text(res.avg_view_rate+'%');
					$('.avg_view_rate').text(res.avrage_view_rate+'%');
					
					$('.Recommendation').hide();
					
					if(res.avrage_view_rate > 20){
					    
					    $('.viewmax20').show();
					}else{
					    $('.viewless20').show();
					}
					
					if(res.avrage_eng_rate > 3){
					    
					    $('.engmax6').show();
					}else{
					    $('.engless6').show();
					}
					
					$('.EarningAmount').text('₹ '+res.total_earning);
					
					//$('.engagement_rate').text(res.engagement_rate+'%');
					$('.engagement_rate').text(res.avrage_eng_rate+'%');
					
					$('.totallikes').text(res.totalLikes);
					$('.userprofile').attr('src', res.profilePicture);
					
					
					var totalviews2 = formatNumber(res.totalViews);
					var totallikes2 = formatNumber(res.totalLikes);
					var totalcomment = formatNumber(res.totalComments);
					
					$('.totalviews2').text(totalviews2);
					$('.totallikes2').text(totallikes2);
					
					
					$('.postperweek').text(res.avgPostPerWeek);
					$('.totalcomment').text(totalcomment);
					$('.avgduration').text(res.avgVideoDuration);
					
					$('.last_post_date').text(res.last_post_date);
					
					$('.Step11').hide();
                    $('.Step3').show();
                    
                    totalViewCounter();
                    
				}
			});
        }
        
        function getProfiledata(){
            
            var data = {
				'getinsta':'insta'
			}
			$.ajax({
				type:'post',
				data:data,
				url:'request-action.php',
				success:function(res){
					var res = JSON.parse(res);
					//console.log(res.follower);
					
					$('.totalviews').text(res.totalViews);
					$('.totalposts').text(res.posts);
					$('.totalfollower').text(res.follower);
					$('.totalfollowing').text(res.following);
					$('.UserName').text(res.name);
					
				
					
					$('.loginusername').text(res.name);
					
					$('.UserDescription').text(res.bio);
					//$('.avg_view_rate').text(res.avg_view_rate+'%');
					$('.avg_view_rate').text(res.avrage_view_rate+'%');
					
					$('.EarningAmount').text('₹ '+res.total_earning);
					
					//$('.engagement_rate').text(res.engagement_rate+'%');
					$('.engagement_rate').text(res.avrage_eng_rate+'%');
					
					$('.totallikes').text(res.totalLikes);
					$('.userprofile').attr('src', res.profilePicture);
					
					
					var totalviews2 = formatNumber(res.totalViews);
					var totallikes2 = formatNumber(res.totalLikes);
					var totalcomment = formatNumber(res.totalComments);
					
					$('.totalviews2').text(totalviews2);
					$('.totallikes2').text(totallikes2);
					
					
					$('.postperweek').text(res.avgPostPerWeek);
					$('.totalcomment').text(totalcomment);
					$('.avgduration').text(res.avgVideoDuration);
					
					$('.last_post_date').text(res.last_post_date);
					
					$('.Step2').hide();
					$('.sendotp').hide();
					$('.Step3').show();
					
					totalViewCounter();
				}
			});
        }
        
        
        
        var maxSelections = 5;

        $('.make_content li').click(function(){
            
            if ($(this).hasClass('OthersType')) {
                return;
            }

            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                var selectedCount = $('.make_content .selected').length;

                if (selectedCount >= maxSelections) {
                    alert('You can select a maximum of 5 items.');
                } else {
                    $(this).addClass('selected');
                }
            }
        });
        
        $('.storeContent').click(function(){
            
            var selectedItems = $('.make_content .selected').map(function(){
                return $(this).text().trim();
            }).get();

            if (selectedItems.length < 1) {
                
                var otherText = $('#make_content_other').val().trim();
                
                if (otherText != '') {
                    selectedItems.push(otherText);
                }else{
                    alert('Please select at least 1 item.');    
                    return;
                }
            }else{
                
                var otherText = $('#about_content_other').val().trim();
                
                if (otherText != '') {
                    selectedItems.push(otherText);
                }
            }
            
            var selectedCount = selectedItems.length;

            if (selectedCount > maxSelections) {
                alert('You can select a maximum of 5 items.');
                return;
            }

            var data = {
                'storecontent': selectedItems
            };
			$.ajax({
				type:'post',
				data:data,
				url:'request-action.php',
				success:function(res){
					
					$('.Step4').hide();
					$('.Step5').show();
				}
			});
        });
        
        
        $('.content_about li').click(function(){
            
            if ($(this).hasClass('OthersType')) {
                return;
            }

            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                var selectedCount = $('.content_about .selected').length;

                if (selectedCount >= maxSelections) {
                    alert('You can select a maximum of 5 items.');
                } else {
                    $(this).addClass('selected');
                }
            }
        });
        
        $('.aboutContent').click(function(){
            
            var selectedItems = $('.content_about .selected').map(function(){
                return $(this).text().trim();
            }).get();

            if (selectedItems.length < 1) {
                
                var otherText = $('#about_content_other').val().trim();
                
                if (otherText != '') {
                    selectedItems.push(otherText);
                }else{
                    alert('Please select at least 1 item.');    
                    return;
                }
            }else{
                
                var otherText = $('#about_content_other').val().trim();
                
                if (otherText != '') {
                    selectedItems.push(otherText);
                }
            }
            
            var selectedCount = selectedItems.length;

            if (selectedCount > maxSelections) {
                alert('You can select a maximum of 5 items.');
                return;
            }
            
            var data = {
                'aboutcontent': selectedItems
            };
			$.ajax({
				type:'post',
				data:data,
				url:'request-action.php',
				success:function(res){
					
					$('.Step5').hide();
					$('.Step6').show();
					
					totalViewCounter2();
				
				}
			});
        });
        
        
        $('.something_about li').click(function(){
            
            if ($(this).hasClass('OthersType')) {
                return;
            }

            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                var selectedCount = $('.something_about .selected').length;

                if (selectedCount >= maxSelections) {
                    alert('You can select a maximum of 5 items.');
                } else {
                    $(this).addClass('selected');
                }
            }
        }); 
        
        $('.saveAboutcontent').click(function(){
            
            var selectedItems = $('.something_about .selected').map(function(){
                return $(this).text().trim();
            }).get();

            if (selectedItems.length < 1) {
                
                var otherText = $('#something_about_other').val().trim();
                
                if (otherText != '') {
                    selectedItems.push(otherText);
                }else{
                    alert('Please select at least 1 item.');    
                    return;
                }
            }else{
                
                var otherText = $('#something_about_other').val().trim();
                
                if (otherText != '') {
                    selectedItems.push(otherText);
                }
            }
            
            var selectedCount = selectedItems.length;

            if (selectedCount > maxSelections) {
                alert('You can select a maximum of 5 items.');
                return;
            }

            var data = {
                'somethingabout': selectedItems
            };
			$.ajax({
				type:'post',
				data:data,
				url:'request-action.php',
				success:function(res){
					
					$('.Step7').hide();
					$('.Step8').show();
				}
			});
        });
        
        
        $('.earn_capacity').click(function(){
            var NameInput = $('.NameInput').val();
            if(NameInput == ''){
                alert('please enter your name.');
                return;
            }
            
            var pin1 = $('.pin1').val();
            /*var pin2 = $('.pin2').val();
            var pin3 = $('.pin3').val();
            var pin4 = $('.pin4').val();
            var pin5 = $('.pin5').val();
            var pin6 = $('.pin6').val();
            
            var pincode = pin1 + pin2 + pin3 + pin4 + pin5 + pin6;*/
            
            if(pin1 == ''){
                alert('please enter pincode.');
                return;
            }
            
            var whatsapp_num = $('.whatsapp_num1').val();
            if(whatsapp_num == ''){
                alert('please enter WhatsApp number.');
                return;
            }
            
            var totalviews = $('.totalviews').text();
			var totalfollower = $('.userfollower').text();
			var ReelsCount = $('.ReelsCount_rp').text();
			var loginusername = $('.loginusername_rp').text();
			var insta_username = $('.insta_username_rp').text();
			
			var AccountCategory = $('.AccountCategory_rp').text();
			var totallikes2 = $('.totallikes2_rp').text();
			var EarningAmount = $('.EarningAmount_rp').text();
			
			var last_post_date = $('.last_post_date_rp').text();
			var avg_view_rate = $('.avg_view_rate_rp').text();
			var engagement_rate = $('.engagement_rate_rp').text();
			
			var postperweek = $('.postperweek_rp').text();
			var avgduration = $('.avgduration_rp').text();
			var totallikes2 = $('.totallikes2_rp').text();
			var totalcomment = $('.totalcomment_rp').text();
			
            var data = {
                'cap_whatsapp_num': whatsapp_num,
                'cap_pincode': pin1,
                'cap_name': NameInput,
                'totalviews': totalviews,
                'totalfollower': totalfollower,
                'ReelsCount': ReelsCount,
                'loginusername': loginusername,
                'insta_username': insta_username,
                
                'AccountCategory': AccountCategory,
                'totallikes2': totallikes2,
                'EarningAmount': EarningAmount,
                
                'last_post_date': last_post_date,
                'avg_view_rate': avg_view_rate,
                'engagement_rate': engagement_rate,
                
                'postperweek': postperweek,
                'avgvideoduration': avgduration,
                'totallikes2': totallikes2,
                'totalcomment': totalcomment,
            };
			$.ajax({
				type:'post',
				data:data,
				url:'request-action.php',
				success:function(res){
				    
				    if(res == 'notfound'){
				        alert('Please enter correct pincode!');
				    }else{
				        window.location.href = "report-card.php";
				        /*
				        $('.Step8').hide();
					
    					$('body').removeClass('background');
                        $('body').removeClass('background3');
                        $('body').addClass('background2');
                        
    					$('.Step9').show();
    					*/
				    }
					
				}
			});
        });
        
        
        $('#samemobile').change(function() {
            if ($(this).is(':checked')) {
                if(default_phone == ''){
                    default_phone = $('.num1').val();    
                }
                
                $('.whatsapp_num1').val(default_phone);
            } else {
                $('.whatsapp_num1').val('');
            }
            
            var inputLength = $('.whatsapp_num1').val().length;
            if (inputLength > 9) {
                
                $('.whatsapp_num1').closest('.addtick').addClass('foriconuse');
                
            } else {
                $('.whatsapp_num1').closest('.addtick').removeClass('foriconuse');
                
            }
        });
        
        function formatNumber(num) {
            if (num >= 1000000) {
                return (num / 1000000).toFixed(1) + 'M';
            } else if (num >= 1000) {
                return (num / 1000).toFixed(1) + 'K';
            } else {
                return num.toString();
            }
        }
        
        $("#submit_insta_user").click(function (){
            
            $("#submit_insta_user").prop('disabled',true);
            $("#insta_user_name").prop('disabled',true);
            
            $(".username_required").hide();
            $(".notfoundmgs").hide();
            $(".pleasewaitmsg").hide();
            $(".incorrectusername").hide();

            var insta_user_name = $("#insta_user_name").val().trim();
                
            if (insta_user_name == '') {
                $(".username_required").show();
                $("#submit_insta_user").prop('disabled', false);
                $("#insta_user_name").prop('disabled', false);
                return;
            } else {
                if (!/^[a-zA-Z0-9._]{1,30}$/.test(insta_user_name)) {
                    $(".incorrectusername").show();
                    $("#submit_insta_user").prop('disabled', false);
                    $("#insta_user_name").prop('disabled', false);
                    return;
                }
                
                $(".username_required").hide();
                $(".notfoundmgs").hide();
                $(".pleasewaitmsg").show();
                
                var data = {
    				'store_username':insta_user_name
    			}
                
    			$.ajax({
    				type:'post',
    				data:data,
    				url:'request-action.php',
    				success:function(res){
    				    console.log(res);
    				    if(res == 200){
    				        $(".pleasewaitmsg").hide();
    				        
        				    $('.Step1').hide();
        				    $('.Step2').show();
    				    }else{
    				        $(".pleasewaitmsg").hide();
    				        $(".notfoundmgs").show();
    				        $("#submit_insta_user").prop('disabled',false);
    				        $("#insta_user_name").prop('disabled',false);
    				        //alert('Please enter valid Instagram id.');
    				    }
    				    //$("#submit_insta_user").text('Go');
    				    $(".pleasewaitmsg").hide();
    				    $("#submit_insta_user").prop('disabled',false);
    				    $("#insta_user_name").prop('disabled',false);
    				}
    			});
            }
        });
    });
    
  
</script>
<script>
        $(document).ready(function(){
            // Download as Image
            $('.downloadIcon').click(function() {
                html2canvas(document.querySelector('.earning_result')).then(canvas => {
                    var imgData = canvas.toDataURL('image/png');
                    var link = document.createElement('a');
                    link.href = imgData;
                    link.download = 'report_card.png';
                    link.click();
                });
            });

            // Download as PDF
            /*$('.downloadIcon1').click(function() {
                html2canvas(document.querySelector('.earning_result')).then(canvas => {
                    var imgData = canvas.toDataURL('image/png');
                    var jsPDF = window.jspdf.jsPDF;
                    var pdf = new jsPDF('p', 'mm', 'a4');
                    var imgWidth = 210;
                    var pageHeight = 295;
                    var imgHeight = canvas.height * imgWidth / canvas.width;
                    var heightLeft = imgHeight;

                    var position = 0;

                    pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                    heightLeft -= pageHeight;

                    while (heightLeft >= 0) {
                        position = heightLeft - imgHeight;
                        pdf.addPage();
                        pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                        heightLeft -= pageHeight;
                    }
                    pdf.save('report_card.pdf');
                });
            });*/
        });
    </script>
    
    <!--script>
$(document).ready(function() {
    // Get the target number from the div
    var targetNumber = parseInt($('#counter').text());
    
    // Start the counter from zero
    var currentNumber = 0;
    
    // Set the duration of the counter effect (in milliseconds)
    var duration = 2000;
    
    // Calculate the increment per step
    var increment = targetNumber / (duration / 10);
    
    // Set the interval for updating the number
    var counterInterval = setInterval(function() {
        currentNumber += increment;
        
        // If the current number has reached or exceeded the target number
        if (currentNumber >= targetNumber) {
            currentNumber = targetNumber;
            clearInterval(counterInterval); // Stop the counter
        }
        
        // Update the div with the current number (rounded to an integer)
        $('#counter').text(Math.floor(currentNumber));
    }, 10); // Update every 10 milliseconds
});
</script-->
<!--script>
$(document).ready(function() {
    // Get the target number from the div
    var targetNumber = parseInt($('#counter2').text());
    
    // Start the counter from zero
    var currentNumber = 0;
    
    // Set the duration of the counter effect (in milliseconds)
    var duration = 2000;
    
    // Calculate the increment per step
    var increment = targetNumber / (duration / 10);
    
    // Set the interval for updating the number
    var counterInterval = setInterval(function() {
        currentNumber += increment;
        
        // If the current number has reached or exceeded the target number
        if (currentNumber >= targetNumber) {
            currentNumber = targetNumber;
            clearInterval(counterInterval); // Stop the counter
        }
        
        // Update the div with the current number (rounded to an integer)
        $('#counter2').text(Math.floor(currentNumber));
    }, 10); // Update every 10 milliseconds
});
</script-->

<script>
        fetch('counter.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('hit-count').textContent = data;
                 document.getElementById('hit-count2').textContent = data;
            });
    </script>
    
       <!--script>
        // Get the link element
        const link = document.getElementById('myLink');

        // Function to disable the link
        function disableLink() {
            link.classList.add('disabled');
            
            // Re-enable the link after 10 seconds
            setTimeout(() => {
                link.classList.remove('disabled');
            }, 15000);
        }

        // Call the function to disable the link initially
        disableLink();
    </script-->
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />

<!-- Modal HTML embedded directly into document -->
<div id="ex1" class="modal">
  <div class="PaymentBox">
					<div class="BuzzLogo"><img src="images/BuzzLogo.svg" /></div>
			        
			        <div class="REPORTCARD">REPORT CARD</div>

						<div class="NameGorupPayment">
							<div class="CusName MainColor">Hi <span class="loginusername"><?php echo $data['name'];?></span> !</div>
							<div class="InstaHandle"><span class="insta_username"><?php echo $data['instausername'];?></span> <span class="AccountCategory"><?php echo $data['instacategory'];?></span> </div>
						
						<div class="EarningCard">
						    <div class="headingearn">My instagram has received a total of:</div>
								<div class="TotalInstaInformationCount2">
							<div class="InstaInfoCount">
								<div class="TtileInsta">Total Likes</div>
								<div class="CountInsta totallikes2"><?php echo $data['totalLikes2'];?></div>
							</div>
							<div class="InstaInfoCount">
								<div class="TtileInsta">Total Views</div>
								<div class="CountInsta totalviews2"><?php echo $data['totalViews2'];?></div>
							</div>
							<div class="InstaInfoCount">
								<div class="TtileInsta">Total Comment</div>
								<div class="CountInsta totalcomment"><?php echo $data['totalComments2'];?></div>
							</div>
						</div>
						</div>
							</div>
						
						
						<div class="sharewithBox">
						    <div class="HeadingShare">Share with</div>
						    <div class="SoicalMediaShareIcon">
						        <div class="IconsSoical IconsSoical1 Telegram">
						            <img src="images/tele.svg" alt="image">
						            <div class="socialmedianame">Telegram</div>
						        </div>
						         <div class="IconsSoical IconsSoical1 Twitter">
						            <img src="images/x.svg" alt="image">
						            <div class="socialmedianame">Twitter</div>
						        </div>
						        <div class="IconsSoical IconsSoical1 Whatsapp">
						            <img src="images/whatsapp.svg" alt="image">
						            <div class="socialmedianame">Whatsapp</div>
						        </div>
						        <div class="IconsSoical IconsSoical1 Share">
						            <img src="images/share2.svg" alt="image">
						            <div class="socialmedianame">Share</div>
						        </div>
						    </div>
						</div>
					</div>
</div>


</html>