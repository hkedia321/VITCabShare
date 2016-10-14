<?php
include_once("config.php");
include_once("google_includes/functions.php");
session_start();
$gUser=new Users();
if(isset($_SESSION['google_data']) and isset($_SESSION['google_data']['id']) and ($gUser->has_phoneno($_SESSION['google_data']['id'])))
{
	redirect_to("showall.php");
}
if(isset($_SESSION['google_data']) and isset($_SESSION['google_data']['id']))
{
	redirect_to("inputphoneno.php");
}

//print_r($_GET);die;

if(isset($_REQUEST['code'])){
	$gClient->authenticate();
	$_SESSION['token'] = $gClient->getAccessToken();
	header('Location: ' . filter_var($redirectUrl, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['token'])) {
	$gClient->setAccessToken($_SESSION['token']);
}

if ($gClient->getAccessToken()) {
	$userProfile = $google_oauthV2->userinfo->get();
	//DB Insert
	$gUser = new Users();
	$gUser->checkUser('google',$userProfile['id'],$userProfile['given_name'],$userProfile['family_name'],$userProfile['email'],$userProfile['gender'],$userProfile['locale'],$userProfile['link'],$userProfile['picture']);
	$_SESSION['google_data'] = $userProfile; // Storing Google User Data in Session
	$row_user=$gUser->find_user($userProfile['id']);
	if(!$row_user)
		header("location: error.php");
	$_SESSION['google_data']['fname']=ucfirst($row_user['fname']);
	$_SESSION['google_data']['lname']=ucfirst($row_user['lname']);
	$_SESSION['google_data']['email']=$row_user['email'];
	$_SESSION['google_data']['picture']=$row_user['picture'];
	$_SESSION['google_data']['travelfrom']=$row_user['travelfrom'];
	$_SESSION['google_data']['travelto']=$row_user['travelto'];
	$_SESSION['google_data']['traveldate']=$row_user['traveldate'];
	$_SESSION['google_data']['traveltime']=$row_user['traveltime'];
	$_SESSION['google_data']['flightno']=$row_user['flightno'];
	$_SESSION['google_data']['lnamevisible']=$row_user['lnamevisible'];
	$_SESSION['google_data']['emailvisible']=$row_user['emailvisible'];
	$_SESSION['google_data']['phoneno']=$row_user['phoneno'];
	$_SESSION['google_data']['phonenovisible']=$row_user['phonenovisible'];
	$_SESSION['token'] = $gClient->getAccessToken();
	header("location: account.php");
	
} else {
	$authUrl = $gClient->createAuthUrl();
}

if(isset($authUrl)) {
	require_once('includes/head.php');
	?>
	<link rel="stylesheet" type="text/css" href="css/index.css">
</head>

<body>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=209131759500799";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<div class="logo-div center-align">
		<img src="images/logo.png" class="logoimg">
	</div>
	<div class="login-div center-align">
		<?php echo '<a href="'.$authUrl.'"><img src="images/glogin.png" class="loginimg" alt=""/></a>';?>
	</div>
	<br>
	<div class="center-align">
		<div class="fb-like center-align" data-href="https://www.facebook.com/vitcabshare/" data-layout="button_count" data-action="like" data-size="large" data-show-faces="true" data-share="true">

		</div>
	</div>
	<br>
	<?php 
	include_once('includes/scripts.php');
	?>
	<?php
	include_once('includes/footer.php');
	?>
	<?php
} else {
	echo '<a href="logout.php?logout">Logout</a>';
}

?>