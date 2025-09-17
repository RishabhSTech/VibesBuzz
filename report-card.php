<?php

session_start();


if(!isset($_SESSION['profile_res'])){
    header('Location: /earning-calculator');
    exit;
}
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
$data['total_earning_number'] = 0;
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
            $earning = '1.5 Lakh+';
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
            
            $data['total_earning_number'] = $total_earning;
            $data['total_earning'] = number_format($total_earning, 2);
        }else{
            $total_earning = "1.5 Lakh+";
            $data['total_earning'] = "1.5 Lakh+";
        }
        
        //$data['total_earning'] = number_format($total_earning, 2);
        
        //$reelAverageViews = $profile_data->result[0]->reels->reelAverageViews;
        $reelAverageViews = $profile_data->result[0]->reels->totalViews;
        //$avrage_view_rate = ($reelAverageViews/$data['follower'])/100;
        //$avrage_view_rate = ($reelAverageViews/$data['follower'])*100;
        
        //Average View Rate= Total Views/( reels x Total Followers)× 100
        //In this case it will be 69755/(12×753)×100 = 771%
      
        $avrage_view_rate = $reelAverageViews/($reelCount*$data['follower']);
        $avrage_view_rate = $avrage_view_rate*100;

        //$data['avrage_view_rate'] = number_format($avrage_view_rate, 2);
        $data['avrage_view_rate'] = floor($avrage_view_rate);
        
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

//echo $data['follower'].'<br>'.$data['totalComments2'].'<br>'.$data['totalLikes2'].'<br>'.$data['totalViews2'].'<br>';die();
$data['follower2'] = formatNumber($data['follower']);
//$data['totalComments2'] = formatNumber($data['totalComments2']);

$data['totalComments2'] = formatNumber($data['totalComments2']);
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
}

if(isset($_GET['sessionclear']) && $_GET['sessionclear'] == '1'){
    session_destroy();
    $nextstep = 1;
}
$verify_phone = '';
if(isset($_SESSION['verify_phone'])){
    $verify_phone = $_SESSION['verify_phone'];
}

$session_clear_enable = 0;
if(isset($_SESSION['page_read'])){
    $session_clear_enable = 1;
    
}else{
    $_SESSION['page_read'] = 1;
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
	<link rel="stylesheet" type="text/css" href="css/style-new.css">
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

<body class="background2">
 
	<section class="Step9">
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
							<div class="CusName MainColor">Hi <span class="loginusername"><?php echo $data['name'];?></span> !</div>
							<div class="InstaHandle"><span class="insta_username"><?php echo $data['instausername'];?></span> <span class="AccountCategory"><?php echo $data['instacategory'];?></span> </div>
						</div>
						<div class="EarningCard">
							<div class="EarnLine1">You can earn upto</div>
							<div class="EarningAmount">₹ 
							<?php 
							//echo $data['total_earning'];
							if($data['total_earning'] == '0' || $data['total_earning'] == '1.5 Lakh+'){
							    echo $data['total_earning'];
							}else{
							    $total_earning = $data['total_earning_number'];//floatval($data['total_earning_number']);
                                
                                if ($total_earning > 0) {
                                    //echo $total_earning / 3;
                                    echo number_format($total_earning / 3, 2);
                                } else {
                                    echo $data['total_earning'];
                                }
    							
							}
							
							?></div>
							<div class="EarnLine1">per post</div>
						</div>
						
						<div class="InstaProfileInDetails bottommargin">
							<div class="InstaInfoCount">
								<div class="TtileInsta">Followers</div>
								<div class="CountInsta totalfollower"><?php echo $data['follower2'];?></div>
							</div>
							<div class="InstaInfoCount">
								<div class="TtileInsta">Last Post</div>
								<div class="CountInsta last_post_date"><?php echo $data['last_post_date'];?></div>
							</div>
					
						</div>

						<div class="InstaProfileInDetails MorePerformaceCount">
						    <div class="PerformanceReach">Performance of your last <span class="ReelsCount"><?php echo $data['ReelsCount'];?></span> reels</div>
							<div class="InstaInfoCount border-1">
								<div class="TtileInsta">View Rate</div>
								<div class="CountInsta avg_view_rate"><?php echo $data['avrage_view_rate'];?>%</div>
							</div>
							<div class="InstaInfoCount border-2">
								<div class="TtileInsta">Engagement Rate</div>
								<div class="CountInsta engagement_rate"><?php echo $data['avrage_eng_rate'];?>%</div>
							</div>
							<div class="InstaInfoCount border-3">
								<div class="TtileInsta">Posts per Week</div>
								<div class="CountInsta postperweek"><?php echo $data['avgPostPerWeek'];?></div>
							</div>
							<div class="InstaInfoCount border-4">
								<div class="TtileInsta">Avg. Video Duration</div>
								<div class="CountInsta avgduration"><?php echo $data['avgVideoDuration'];?></div>
							</div>
						</div>
						<div class="TotalInstaInformationCount">
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

						<div class="RecommendationsByVibes">
						    
						    <a href="survey.php" class="Recommendation2 Btn2 engmax6">Start Earning Now</a>
						    <a href="https://www.thevibes.academy/" class="Recommendation2 Btn2 engless6">Want to Earn More</a>
						   
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
        
        <?php 
        if ($session_clear_enable == 1) {
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
				    
					//var currentUrl = window.location.href;
                    window.location.href = '/earning-calculator'
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
         
        $('.Recommendation2').hide();
		
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
		if($data['follower'] > 9999){
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
            
            $('body').removeClass('background');
            $('body').removeClass('background3');
            $('body').addClass('background2');
			
        <?php    
        }
        ?>
          
        $('.closeShareView').click(function () {
            $('.Step10').hide();
            $('.Step9').show();
            
            $('body').removeClass('background');
            $('body').removeClass('background3');
            $('body').addClass('background2');
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
 
        });
    </script>
    

<script>
        fetch('counter.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('hit-count').textContent = data;
                 document.getElementById('hit-count2').textContent = data;
            });
    </script>
    
        
    
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