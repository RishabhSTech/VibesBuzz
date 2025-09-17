<?php
session_start();

if(!isset($_SESSION['profile_res'])){
    header('Location: /earning-calculator');
    exit;
}


$data = array();
$data['name'] = '';
//$_SESSION['last_insta_profile_inserted_id'];


if(isset($_SESSION['profile_res']) && $_SESSION['profile_res'] != '' && $_SESSION['profile_res'] != null){
    $profile_data = $_SESSION['profile_res'];
    
    if(!empty($profile_data->result) && $_SESSION['profile_res']->result[0] != ''){
        
        $data['name'] = $profile_data->result[0]->name;
    }else{
        $data['name'] = 'User';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Survey - Vibes Buzz</title>

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

<style>
    @media (max-width: 999px) {
        .row {
            flex-direction: column !important;
        }
    }
</style>

<body class="background SurveyPage">

	<section class="Step1 " style="display:block">
		<div class="container">
			<div class="LogoTopnav">
				<a href="index.php" class="LogoClick">
					<img src="images/logo.png" alt="Vibes Buzz" class="Logo" />
				</a>
			</div>
	    	<div class="HeaderBar">
				<div class="MainHeading MainColor">Hi <?php echo $data['name'];?>!</div>
			</div>
			<div class="row">
			    
				<div class="col col-1">
			        <div class="questionBox">
			            <div class="question">Have you ever had a paid brand collaboration</div>
			            <ul class="chips paid_collaboration">
			                <li class="">Yes</li>
			                <li class="">No</li>
			            </ul>
			        </div>
				</div>
				
				<div class="col col-1">
			        <div class="questionBox">
			            <div class="question">Do you create content in youtube?</div>
			            <ul class="chips content_youtube">
			                <li class="">Yes</li>
			                <li class="">No</li>
			                
			                <li class="OthersType">
						      <input type="text" id="make_others_content_youtube" placeholder="+ Type your youtube id" />
						    </li>
			            </ul>
			        </div>
				</div>
				
				<div class="col col-2">
			        <div class="questionBox">
			            <div class="question">What category do you belong to?</div>
			            <ul class="chips your_caste">
			                <li class="">General</li>
			                <li class="">OBC</li>
			                <li class="">SC/ST</li>
			                <li class="">Minority</li>
			            </ul>
			        </div>
				</div>
				<div class="col col-2">
			        <div class="questionBox">
			            <div class="question">What is your audience gender split?</div>
			            <ul class="chips audience_gender">
			                <li class="">Mostly Men</li>
			                <li class="">Mostly Female</li>
			                <li class="">Balanced (50-50)</li>
			                <li class="">Not Sure</li>
			            </ul>
			        </div>
				</div>
			
			</div>
			
			<div class="FooterBar">
				<a href="javascript:;" class="Btn LoginWithInstagram storesurvey"> Submit </a>
			</div>
		
		</div>
	</section>

	

</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {

        var maxSelections = 5;

        $('.paid_collaboration li').click(function(){
            $('.paid_collaboration li').removeClass('selected');
            $(this).addClass('selected');
        });
        
        $('.content_youtube li').click(function(){
            var txt = $(this).text().trim().toLowerCase();

            if(txt === 'yes'){
                $('.content_youtube li.OthersType').show();
            } else {
                if ($(this).hasClass('OthersType')) {
                    return;
                } else {
                    $('.content_youtube li.OthersType').hide();
                    $('#make_others_content_youtube').val('');
                }
            }
            
            $('.content_youtube li').removeClass('selected');
            $(this).addClass('selected');
        });
        
        $('.your_caste li').click(function(){
            $('.your_caste li').removeClass('selected');
            $(this).addClass('selected');
        });
        
        $('.audience_gender li').click(function(){
            $('.audience_gender li').removeClass('selected');
            $(this).addClass('selected');
        });
        
        $('.storesurvey').click(function(){
            
            var paid_collaboration = $('.paid_collaboration .selected').map(function(){
                return $(this).text().trim();
            }).get();

            var selectedCount = paid_collaboration.length;
            if (selectedCount < 1) {
                alert('Please select at least 1 item in each.');
                return;
            }

            if (selectedCount > maxSelections) {
                alert('You can select a maximum of 5 items.');
                return;
            }
            
            var content_youtube = $('.content_youtube .selected').map(function(){
                return $(this).text().trim();
            }).get();
            
            var make_others_content_youtube = $('#make_others_content_youtube').val().trim();

            var youtube_id = '';
            if (content_youtube.length && content_youtube[0].toLowerCase() === 'yes') {
                youtube_id = make_others_content_youtube;
            }
            
            var your_caste = $('.your_caste .selected').map(function(){
                return $(this).text().trim();
            }).get();

            var selectedCasteCount = your_caste.length;
            if (selectedCasteCount < 1) {
                alert('Please select at least 1 item in each.');
                return;
            }

            var your_caste = your_caste[0] || '';

            //==============================
            var audience_gender = $('.audience_gender .selected').map(function(){
                return $(this).text().trim();
            }).get();

            var selectedCount = audience_gender.length;
            if (selectedCount < 1) {
                alert('Please select at least 1 item in each.');
                return;
            }
            
            var data = {
                'paid_collaboration': paid_collaboration,
                'content_youtube': content_youtube,
                'youtube_id': youtube_id,
                'your_caste': your_caste,
                'audience_gender': audience_gender
            };
			$.ajax({
				type:'post',
				data:data,
				url:'request-action.php',
				success:function(res){
					window.location.href = "survey-he-thankyou.php";
				},
                error: function(){
                    alert('Something went wrong. Please try again.');
                }
			});
        });
    });
</script>

</html>