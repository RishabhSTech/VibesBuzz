<?php
session_start();

if(!isset($_SESSION['profile_res'])){
    header('Location: /earning-calculator');
    exit;
}
 

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Registration Completed - Vibes Buzz</title>

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
.row.register-comp {
    background: linear-gradient(0deg, #F5F4F4 0%, #E8E8E8 100%);
    border: 1px solid rgba(255, 55, 1, 0.12);
    border-radius: 22px;
    padding: 4rem 2rem;
    box-shadow: 0px 12px 12px rgba(0, 0, 0, 0.05);
    position: relative;
}

.BtnGroup {
    margin-top: 90px; 
    gap: 25px;
}

.orange {
    background-color: #FF1E00 !important;
    color: #fff;
    background-image: url(../images/right-icon.svg);
}

@media (max-width: 900px) {
    .row.register-comp {
        background: linear-gradient(0deg, #FFB9B9 0%, #FFCCCC 100%);
        padding: 1rem 2rem;
        gap: 0px;
        overflow: hidden;
    }
    
    .Step1 .SubHeading {
        width: 300px;
        margin: 15px 0px 22px 0px;
    }
    
    .BtnGroup {
        margin-top: 50px; 
        gap: 10px;
    }
    
    .row.register-comp::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(0deg, #FFB9B9 0%, #FFCCCC 100%);
        filter: blur(5px);
        z-index: 0;
    }
    
    .row.register-comp > * {
        position: relative;
        z-index: 1;
    }
    
    .BtnGroup .Btn {
        flex: none;
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
			<div class="row register-comp">
				<div class="col col-1">
                <div class="MainHeading MainColor">Registration Completed</div>
                <div class="col col-1" style="width: 80%;">
                    <div class="SubHeading">To become a better influencer do sign up to our influencer MBA course.</div>

                    
                    <div class="BtnGroup" style="">
                        <a href="https://www.thevibes.academy/become-an-insta-influencer-within-a-week" class="Btn orange"> Enroll Now </a>
                        <a href="https://www.thevibes.buzz/" class="Btn"> Skip </a>
                    </div>
                </div>
                    
				</div>
				<div class="col col-2">
					<div class="ImagePreview">
						<img src="images/register-comp.png" alt="Registeration Completed" class="Registeration Completed Image" />
					</div>
				</div>
			</div>
			<div class="FooterMsgFiestPage">
				<div class="FooterLine TextPart">an initiative by <span class="HighlightMsg">The Vibes Academy</span>
				</div>
				<div class="FooterLine LinePart"><span class="LineDesign"></span></div>
				<div class="FooterLine TextPart"><span class="MainColor VisitorCount"><span id="hit-count2">62757</span> people</span> visited till
					now</div>
			</div>
		</div>
	</section>

	

</body>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        
        var data = {
            'clearsession': 'clearsession',
        };
		$.ajax({
			type:'post',
			data:data,
			url:'request-action.php',
			success:function(res){
                setTimeout(function(){
                    window.location.href = "https://thevibes.academy";
                }, 5000);
			}
		});
        
    });
</script>

</html>