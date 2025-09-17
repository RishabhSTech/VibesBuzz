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
				
				<div class="col col-1">
			        <div class="questionBox">
			            <div class="question">What is your gender?</div>
			            <ul class="chips your_gender">
			                <li class="">Male</li>
			                <li class="">Female</li>
			                <li class="">Non-binary</li>
			            </ul>
			        </div>
				</div>
				
				<div class="col col-2">
			        <div class="questionBox">
			            <div class="question">Your content language?</div>
			            <ul class="chips content_language">
			                <li class="">Hindi</li>
			                <li class="">Marathi</li>
			                <li class="">Malayalam</li>
			                <li class="">Bengali</li>
			                <li class="">Kannada</li>
			                <li class="">Telugu</li>
			                
			                <li class="OthersType">
    						    <input type="text" id="make_others_content_language" placeholder="+ Type your own" />
    						</li>
			            </ul>
			        </div>
				</div>
				<div class="col col-2">
			        <div class="questionBox">
			            <div class="question">What is your age?</div>
			                <div class="slider-container">
                                <div class="value-bubble">30</div>
                                <input type="range" min="18" max="65" value="30" class="your_age" id="age-slider">
                                <div class="labels">
                                    <span>18</span>
                                    <span>65+</span>
                                </div>
                            </div>
			        </div>
				</div>
			
			</div>
			
			<div class="FooterBar">
				<a href="javascript:void(0)" class="Btn LoginWithInstagram storeprofilesurvey"> Next </a>
			</div>
		
		</div>
	</section>

	

</body>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {

        var maxSelections = 5;

        $('.content_youtube li').click(function(){
            
            if($(this).text() == 'Yes'){
                $('.content_youtube li.OthersType').show();
            }else{
                if ($(this).hasClass('OthersType')) {
                    return;
                }else{
                    $('.content_youtube li.OthersType').hide();
                }
            }
            
            $('.content_youtube li').removeClass('selected');
            $(this).addClass('selected');
        });
        
        $('.your_gender li').click(function(){
             
            $('.your_gender li').removeClass('selected');
            $(this).addClass('selected');
        });
        
        $('.content_language li').click(function(){
            
            if ($(this).hasClass('OthersType')) {
                return;
            }
             
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                var selectedCount = $('.content_language .selected').length;

                if (selectedCount > 4) {
                    alert('You can select a maximum of 5 items.');
                } else {
                    $(this).addClass('selected');
                }
            }
        });
        
        
        $('.storeprofilesurvey').click(function(){
            
            var content_youtube = $('.content_youtube .selected').map(function(){
                return $(this).text().trim();
            }).get();
            
            var make_others_content_youtube = $('#make_others_content_youtube').val().trim();
            if (make_others_content_youtube != '') {
                content_youtube.push(make_others_content_youtube);
            }

            var selectedCount = content_youtube.length;
            if (selectedCount < 1) {
                alert('Please select at least 1 item in each.');
                return;
            }

            if (selectedCount > maxSelections) {
                alert('You can select a maximum of 5 items.');
                return;
            }
            
            //==============================
            var your_gender = $('.your_gender .selected').map(function(){
                return $(this).text().trim();
            }).get();

            
            var selectedCount = your_gender.length;
            if (selectedCount < 1) {
                alert('Please select at least 1 item in each.');
                return;
            }
             
            //==============================
            var content_language = $('.content_language .selected').map(function(){
                return $(this).text().trim();
            }).get();
            
            var make_others_content_language = $('#make_others_content_language').val().trim();
            if (make_others_content_language != '') {
                content_language.push(make_others_content_language);
            }

            
            var selectedCount = content_language.length;
            if (selectedCount < 1) {
                alert('Please select at least 1 item in each.');
                return;
            }
            
            //==============================
            var your_age = $('.your_age').val().trim();

            var selectedCount = your_age.length;
            if (selectedCount < 1) {
                alert('Please select at least 1 item in each.');
                return;
            }
            
            var data = {
                'your_age': your_age,
                'content_language': content_language,
                'your_gender': your_gender,
                'content_youtube': content_youtube
            };
			$.ajax({
				type:'post',
				data:data,
				url:'request-action.php',
				success:function(res){
					window.location.href = "https://thevibes.academy/";
				}
			});
        });
    });
</script>


<script>
      $(document).ready(function() {
    var slider = $('#age-slider');
    var bubble = $('.value-bubble');

    function updateBubble() {
        var val = slider.val();
        var min = slider.attr('min');
        var max = slider.attr('max');
        var percent = (val - min) / (max - min) * 100;

        // Fine-tune alignment by adjusting with `px` correction
        var correction = 8 - percent * 0.16; // Adjust to center the bubble correctly

        bubble.text(val);
        bubble.css('left', `calc(${percent}% + ${correction}px)`);
    }
    
    slider.on('input', updateBubble);
    updateBubble(); // Initialize
});
    </script>
    
      
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />

<!-- Modal HTML embedded directly into document -->
<div id="ex1" class="modal">
  <div class="PaymentBox">  
  </div>			     
</div>

</html>