<?php
session_start();
$form_error=null;
$id=$_SESSION['google_data']['id'];
if(!isset($_SESSION['google_data'])):header("Location:index.php");endif;
include_once("google_includes/functions.php");
$gUser=new Users();
if($gUser->has_phoneno($_SESSION['google_data']['id'])); else{header("Location:inputphoneno.php");}
$all_travellers=$gUser->all_travellers_including_me();//returns assoc array
?>
<?php
global $title;
$title="VIT Cab Share - Show all";
require_once('includes/head.php');
?>
<link rel="stylesheet" type="text/css" href="css/common.css">
</head>
<body>
	<?php 
	global $active_nav;
	$active_nav="showall";
	require_once('includes/navigation.php');
	?>
	<main class="showall">
		<br><br>
		<h5 class="samedate-intro" align="center">All travellers</h5>
		<br><br>
		<div class="container">
			<div class="all-passengers">
				<?php
				$no_passengers=0;
				while($row=mysqli_fetch_assoc($all_travellers))
				{
					$no_passengers++;
					$oauth_uid=$row['oauth_uid'];
					$lnamee=$row_from["lname"];
					if(!$row_from["lnamevisible"])
						$lnamee="";
					$name=$row["fname"]." ".$lnamee;
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
					?>
					<section class="passenger card-panel hoverable" id="<?php echo "sec".$oauth_uid;?>">
						<div class="row">
							<div class="placediv"><i class="fa fa-map-marker" aria-hidden="true"></i> <span class="placediv-place"><?php echo $travelfrom;?></span> to <span class="placediv-place-to"><?php echo $travelto;?></span></div>
							<div class="timediv"><i class="fa fa-calendar-o" aria-hidden="true"></i> <?php echo $traveldate;?> <i class="fa fa-clock-o" aria-hidden="true"></i>
								<span><?php echo $traveltime;?></span>
							</div>
							<div class="imgdiv col s3 center-align valign-wrapper">
								<img src="<?php echo $picture;?>"  class="valign">
							</div>
							<div class="detailsdiv col s9">
								<h6 class="fontsize14rem"><b><?php echo ucwords(strtolower($name));?></b></h6>
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
									<p>You can contact me at <?php if($emailvisible=="1"||$emailvisible==1) echo $email."  ";?><?php if(($emailvisible=="1"||$emailvisible==1 ) && ($phonenovisible=="1"||$phonenovisible==1)) echo " or ";?><?php if($phonenovisible=="1"||$phonenovisible==1) echo $phoneno;?>.</p>
									<?php
								}
								?>
								<a class="requestbutton waves-effect waves-light btn right <?php if($request_already_send){echo 'disabled';} else{echo 'modal-trigger';}?>" name="<?php echo $name?>" id="<?php echo $oauth_uid;?>" onclick="return check_valid_request(this)" <?php if(!$request_already_send){echo "href='#modal1'";}?> ><i class="fa fa-envelope-o" aria-hidden="true"></i> <?php if($request_already_send){echo 'send';} else{echo 'send request';}?></a>
							</div>
						</div>
					</section>
					<?php
				}
				if($no_passengers==0)
				{
					echo "<h5>No data to show</h5>";
				}
				?>
				
				<!-- Modal Structure -->
				<div id="modal1" class="modal">
					<div class="modal-content">
						<h5>Send a request to <span id="receive_name_span"></span> for sharing cab?</h5>
						<p><i>Note</i> : The person you send the request, will be able to see your email and phone number to contact you back.</p>
						
					</div>
					<div class="modal-footer">
						<form action="sendrequest.php" method="POST">
							<input type="text" class="hide" id="redirect_page" name="redirect_page">
							<input type="text" class="hide" id="sendrequest_receive" name="sendrequest_receive">
							<input type="submit" name="submitrequest" value="Yes" class="yesoption optionbutton btn-flat modal-action modal-close waves-effect waves-green">
						</form>
						<a class="nooption optionbutton modal-action modal-close waves-effect waves-green btn-flat">No</a>
					</div>
				</div>
			</div>
		</div>

	</main>
	<?php 
	include_once('includes/scripts.php');
	?>
	<script type="text/javascript">
		function check_valid_request(obj){
			if(this.id=="<?php echo $id;?>")
			{
				alert("You cannot send request to yourself!");
				return false;
			}
		}
		$(".requestbutton").click(function(){
			var idd=this.id;
			$("#sendrequest_receive").val(idd);
			$("#receive_name_span").text(this.name);
			$("#redirect_page").val("showall.php#sec"+idd);
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
