<?php
session_start();
$form_error=null;
$id=$_SESSION['google_data']['id'];
if(!isset($_SESSION['google_data'])):header("Location:index.php");endif;
include_once("google_includes/functions.php");
$gUser=new Users();
$all_travellers=$gUser->all_travellers_including_me();//returns assoc array
?>
<?php
global $title;
$title="VIT Cab Share - Requests";
require_once('includes/head.php');
?>
<link rel="stylesheet" type="text/css" href="css/common.css">
</head>
<body>
	<?php 
	global $active_nav;
	$active_nav="requests";
	require_once('includes/navigation.php');
	?>
	<main>
		<br><br>
		<h5 class="samedate-intro" id="heading-introo">You received Requests from following people</h5>
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
					if($request_already_send)
					{
						$no_passengers++;
						$gUser->make_seen($from_uid,$to_uid);
						?>
						<section class="passenger card-panel hoverable">
							<div class="row">
								<div class="placediv"><i class="fa fa-map-marker" aria-hidden="true"></i> <span class="placediv-place"><?php echo $travelfrom;?></span> to <span class="placediv-place-to"><?php echo $travelto;?></span></div>
								<div class="timediv"><i class="fa fa-calendar-o" aria-hidden="true"></i> <?php echo $traveldate;?> <i class="fa fa-clock-o" aria-hidden="true"></i>
									<span><?php echo $traveltime;?></span>
								</div>
								<div class="imgdiv col s3 center-align">
									<img src="<?php echo $picture;?>">
								</div>
								<div class="detailsdiv col s9">
									<h6><?php echo $name;?></h6>
									<p>You can contact me at <?php echo $email;?> or <?php echo $phoneno;?></p>
								</div>
							</div>
						</section>
						<?php
					}
				}
				// echo "<h2>$no_passengers</h2>";

				?>
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
			$("#heading-introo").text("You have no requests");
		</script>
		<?php
	}
	?>
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
