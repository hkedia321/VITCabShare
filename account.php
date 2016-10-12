<?php
session_start();
include_once("google_includes/functions.php");
if(!isset($_SESSION['google_data'])):header("Location:index.php");endif;
$gUser = new Users();
	$oauth_uid=$_SESSION['google_data']['id'];
if($gUser->has_phoneno($oauth_uid))
	header("Location:showall.php");
else
	header("Location:inputphoneno.php");
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Login with Google Account by CodexWorld</title>
	<style type="text/css">
		h1
		{
			font-family:Arial, Helvetica, sans-serif;
			color:#999999;
		}
		.wrapper{width:600px; margin-left:auto;margin-right:auto;}
		.welcome_txt{
			margin: 20px;
			background-color: #EBEBEB;
			padding: 10px;
			border: #D6D6D6 solid 1px;
			-moz-border-radius:5px;
			-webkit-border-radius:5px;
			border-radius:5px;
		}
		.google_box{
			margin: 20px;
			background-color: #FFF0DD;
			padding: 10px;
			border: #F7CFCF solid 1px;
			-moz-border-radius:5px;
			-webkit-border-radius:5px;
			border-radius:5px;
		}
		.google_box .image{ text-align:center;}
	</style>
</head>
<body>
	<div class="wrapper">
		<h1>Google Profile Details </h1>
		<?php
		echo '<div class="welcome_txt">Welcome <b>'.$_SESSION['google_data']['given_name'].'</b></div>';
		echo '<div class="google_box">';
		echo '<p class="image"><img src="'.$_SESSION['google_data']['picture'].'" alt="" width="300" height="220"/></p>';
		echo '<p><b>Google ID : </b>' . $_SESSION['google_data']['id'].'</p>';
		echo '<p><b>Name : </b>' . $_SESSION['google_data']['name'].'</p>';
		echo '<p><b>Email : </b>' . $_SESSION['google_data']['email'].'</p>';
		echo '<p><b>Gender : </b>' . $_SESSION['google_data']['gender'].'</p>';
		echo '<p><b>Locale : </b>' . $_SESSION['google_data']['locale'].'</p>';
		echo '<p><b>Google+ Link : </b>' . $_SESSION['google_data']['link'].'</p>';
		echo '<p><b>You are login with : </b>Google</p>';
		echo '<p><b>Logout from <a href="logout.php?logout">Google</a></b></p>';
		echo '</div>';
		?>
	</div>
</body>
</html>