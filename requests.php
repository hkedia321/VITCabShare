<?php
session_start();
$form_error=null;
$id=$_SESSION['google_data']['id'];
if(!isset($_SESSION['google_data'])):header("Location:index.php");endif;
include_once("google_includes/functions.php");
$gUser=new Users();
if($gUser->has_phoneno($_SESSION['google_data']['id'])); else{header("Location:inputphoneno.php");}
$all_requests=$gUser->all_requests($id);//returns assoc array
$gUser->make_seen_all($id);
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
		<h5 class="samedate-intro thoda-side-mobile" id="heading-introo">You received Requests from following people</h5>
		<br><br>
		<div class="container">
			<div class="all-passengers">
				<?php
				$no_passengers=0;
				while($row=mysqli_fetch_assoc($all_requests))
				{
					$from_uid=$row["from_uid"];
					$row_from=$gUser->find_user($from_uid);
					$lnamee=$row_from["lname"];
					if(!$row_from["lnamevisible"])
						$lnamee="";
					$name=$row_from["fname"]." ".$lnamee;
					$email=$row_from["email"];
					$picture=$row_from["picture"];
					$travelfrom=$row_from["travelfrom"];
					$travelto=$row_from["travelto"];
					$traveldate=$row_from["traveldate"];
					$traveltime=$row_from["traveltime"];
					$emailvisible=$row_from["emailvisible"];
					$phoneno=$row_from["phoneno"];
					$phonenovisible=$row_from["phonenovisible"];
					if(has_presence($travelfrom) and has_presence($travelto))
					{
						$travelfrom=travel_no_words($travelfrom);
						$travelto=travel_no_words($travelto);
						$no_passengers++;
						?>
						<section class="passenger card-panel hoverable">
							<div class="row">
								<div class="placediv"><i class="fa fa-map-marker" aria-hidden="true"></i> <span class="placediv-place"><?php echo $travelfrom;?></span> to <span class="placediv-place-to"><?php echo $travelto;?></span></div>
								<div class="timediv"><i class="fa fa-calendar-o" aria-hidden="true"></i> <?php echo $traveldate;?> <i class="fa fa-clock-o" aria-hidden="true"></i>
									<span><?php echo $traveltime;?></span>
								</div>
								<div class="imgdiv col s3 center-align valign-wrapper">
									<img src="<?php echo $picture;?>" class="valign">
								</div>
								<div class="detailsdiv col s9">
									<h6 class="fontsize14rem"><b><?php echo ucwords(strtolower($name));?></b></h6>
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
