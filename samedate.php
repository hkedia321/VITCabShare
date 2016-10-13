<?php
session_start();
$form_error=null;
$id=$_SESSION['google_data']['id'];
if(!isset($_SESSION['google_data'])):header("Location:index.php");endif;
include_once("google_includes/functions.php");
$my_traveldate=$_SESSION['google_data']['traveldate'];
$my_traveltime=$_SESSION['google_data']['traveltime'];
$my_travelfrom=$_SESSION['google_data']['travelfrom'];
$my_travelfrom=travel_no_words($my_travelfrom);
$my_travelto=$_SESSION['google_data']['travelto'];
$my_travelto=travel_no_words($my_travelto);
$gUser=new Users();
$all_travellers=$gUser->all_travellers_ordertime();//returns assoc array
?>
<?php
global $title;
$title="VIT Cab Share - Same date";
require_once('includes/head.php');
?>
<link rel="stylesheet" type="text/css" href="css/common.css">
</head>
<body>
	<?php 
	global $active_nav;
	$active_nav="samedate";
	require_once('includes/navigation.php');
	?>
	<main>
		<br><br>
		<?php 
		if (!$my_travelfrom or !$my_travelto)
		{
			?>
			<div class="no-travel-intro thoda-side-mobile">You need to <a href="editdetails.php"><span class="chip"><i class="fa fa-pencil" aria-hidden="true"></i> add</span></a> your travel details</div>
			<?php
		}
		else
		{
			?>
			<div class="hide-on-small-only" id="info1">
				<h5 class="samedate-intro">People travelling on <span class="chip chipbig"><?php echo $my_traveldate;?></span> from <span  class="chip chipbig"><?php echo $my_travelfrom;?></span> to <span  class="chip chipbig"><?php echo $my_travelto;?></span> are:</h5>
			</div>
			<div class="hide-on-med-and-up" id="info2">
				<h5 class="samedate-intro thoda-side-mobile">People travelling on <span class="text-light"><?php echo $my_traveldate;?></span> from <span  class="text-light"><?php echo $my_travelfrom;?></span> to <span  class="text-light"><?php echo $my_travelto;?></span></h5>
			</div>
			<h5 id="info0"></h5>
			<?php
		}
		?>
		<br><br>
		<div class="container">
			<div class="all-passengers">
				<?php
				$no_passengers=0;
				while($row=mysqli_fetch_assoc($all_travellers))
				{
					$oauth_uid=$row['oauth_uid'];
					$name=$row["fname"]." ".$row["lname"];
					$email=$row["email"];
					$picture=$row["picture"];
					$travelfrom=$row["travelfrom"];
					$travelto=$row["travelto"];
					$traveldate=$row["traveldate"];
					$traveltime=$row["traveltime"];
					$emailvisible=$row["emailvisible"];
					$phoneno=$row["phoneno"];
					$phonenovisible=$row["phonenovisible"];
					$from_uid=$id;
					$to_uid=$oauth_uid;
					$request_already_send=$gUser->check_request($from_uid,$to_uid);
					$travelfrom=travel_no_words($travelfrom);
					$travelto=travel_no_words($travelto);
					if($travelfrom and $travelto and $travelfrom==$my_travelfrom and $travelto==$my_travelto and $traveldate==$my_traveldate)
					{
						$no_passengers++;
						?>
						<section class="passenger card-panel hoverable" id="<?php echo "sec".$oauth_uid;?>">
							<div class="row">
								
								<div class="timediv"> <i class="fa fa-clock-o" aria-hidden="true"></i>
									<span><?php echo $traveltime;?></span>
								</div>
								<div class="imgdiv col s3 center-align">
									<img src="<?php echo $picture;?>">
								</div>
								<div class="detailsdiv col s9">
									<h6 class="fontsize14rem"><b><?php echo ucwords($name);?></b></h6>
									<?php 
									if(($emailvisible=="0"||$emailvisible==0 ) && ($phonenovisible=="0"||$phonenovisible==0))
									{
										?>
										<p>I dont want to provide my email or phone number. You can only send a request to me.</p>
										<?php
									}
									else
									{
										?>
										<p>You can contact me at <?php if($emailvisible=="1"||$emailvisible==1) echo $email."  ";?><?php if(($emailvisible=="0"||$emailvisible==0 ) && ($phonenovisible=="0"||$phonenovisible==0)) echo " or ";?><?php if($phonenovisible=="1"||$phonenovisible==1) echo $phoneno;?>.</p>
										<?php
									}
									?>
									<a class="requestbutton waves-effect waves-light btn right <?php if($request_already_send){echo 'disabled';} else{echo 'modal-trigger';}?>" name="<?php echo $name?>" id="<?php echo $oauth_uid;?>" <?php if(!$request_already_send) echo "href='#modal1'"?> ><i class="fa fa-envelope-o" aria-hidden="true"></i> <?php if($request_already_send){echo 'send';} else{echo 'send request';}?></a>
								</div>
							</div>
						</section>
						<?php
					}
				}
				?>

				<!-- Modal Structure -->
				<div id="modal1" class="modal">
					<div class="modal-content">
						<h5>Send a request to <i><span id="receive_name_span"></span></i> for sharing cab?</h5>
						<p><i>Note</i> : The person you send the request, will be able to see your email and phone number to contact you back.</p>
						
					</div>
					<div class="modal-footer">
						<form action="sendrequest.php" method="POST">
							<input type="text" class="hide" id="redirect_page" name="redirect_page">
							<input type="text" class="hide" id="sendrequest_receive" name="sendrequest_receive">
							<input type="submit" name="submitrequest" value="Yes" class="right yesoption optionbutton btn-flat modal-action modal-close waves-effect waves-green">
						</form>
						<a class="left nooption optionbutton modal-action modal-close waves-effect waves-green btn-flat">No</a>
					</div>
				</div>
			</div>
		</div>

	</main>
	<?php 
	include_once('includes/scripts.php');
	?>
	<?php
	if($no_passengers==0)
	{
		?>
		<script type="text/javascript">
			$("#info1").addClass("hide");
			$("#info2").addClass("hide");
			$("#info0").text("No one found travelling with you.");
		</script>
		<?php
	}
	?>

</script>
<script type="text/javascript">
	$(".requestbutton").click(function(){
		var idd=this.id;
		$("#sendrequest_receive").val(idd);
		$("#receive_name_span").text(this.name);
		$("#redirect_page").val("samedate.php#sec"+idd);
	});
</script>
<?php
include_once('includes/footer.php');
?>
<?php
if(isset($_SESSION['sendrequest_success']) and $_SESSION['sendrequest_success'])
{
	$_SESSION['sendrequest_success']=null;
	?>
	<script>
		alert("Successfully send request!");
	</script>
	<?php

}
?>
