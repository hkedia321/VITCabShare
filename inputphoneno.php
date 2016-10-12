<?php
session_start();
if(!isset($_SESSION['google_data'])):header("Location:index.php");endif;
include_once("google_includes/functions.php");

$form_error=null;
if(isset($_POST['submit']))
{
	$phoneno=$_POST['phoneno'];
	if(!isset($phoneno) or empty($phoneno) or !has_min_length($phoneno,10) or !has_max_length($phoneno,13))
		$form_error="Please enter your correct phone no";
	if(!has_presence($form_error)){
		$gUser = new Users();
		$oauth_uid=$_SESSION['google_data']['id'];
		$success=$gUser->update_phoneno($oauth_uid,$phoneno);
		if(!$success)
			header("Location:error.php?inputmobileno");
		header("Location:inputtraveldetails.php");
	}
}
global $title;
$title="VIT Cab Share - Input Phone no";
require_once('includes/head.php');
?>
<style>
	.form-div{
		margin-top: 25vh;
		width: 400px;
		max-width: 95vw;
		margin-left: auto;
		margin-right: auto;
	}
	body{
		background-color: #eee;
		background-image:url('images/vituniversity.png');
		background-size: cover;
		color: #fff;
	}
	.card{
		background-color: #1e1e1e;
		padding: 2rem;
	}
	button{
		width: 100%;
	}
	h5{
		padding-right: 0px;
		padding-left: 0px;
		margin-left: 0px;
		margin-right: 0px;
	}
	.text-light{
		color: #8a8686;
	}
</style>
</head>
<body>
	<div class="hide-on-small-only">
		<h1 class="center-align">VIT Cab Share</h1>
	</div>
	<div class="hide-on-med-and-up">
		<h3 class="center-align">VIT Cab Share</h3>
	</div>

	<div class="form-div hoverable card">
		<form action="inputphoneno.php" method="POST">
			<?php
			if(has_presence($form_error))
				echo "<h5 class='form-error'>{$form_error}</h5>";
			else
				echo "<h5 class='center-align'>Please enter your mobile number to continue. </h5>
			<p class='text-light'><i class='fa fa-lock' aria-hidden='true'></i> you can later choose to hide your mobile number from public.</p>";
			?>
			
			<div class="input-field col s12">
				<i class="material-icons prefix">phone</i>
				<input required name="phoneno" id="phoneno" type="number" length="13">
				<labeL for="mobileno">Mobile no</labeL>
			</div>
			<div class="col s12">
				<button class="btn waves-effect waves-light center-align" type="submit" name="submit" value="1">Continue<i class="material-icons right">send</i></button>
			</div>
		</form>
	</div>
	
</body>
<?php 
include_once('includes/scripts.php');
?>
<?php
include_once('includes/footer.php');
?>

