<?php
session_start();
$id=$_SESSION['google_data']['id'];
if(!isset($_SESSION['google_data'])):header("Location:index.php");endif;
include_once("google_includes/functions.php");
$gUser=new Users();
$all_travellers=$gUser->all_travellers();//returns assoc array
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
		<br>
		<h5>You received requests from following people to share a cab:</h5>
		<br><br>


		<div class="container">
			<div class="all-passengers">
				<?php
				$no_passengers=0;
				while($row=mysqli_fetch_assoc($all_travellers))
				{
					$no_passengers++;
					$oauth_uid=$row['oauth_uid'];
					$from_uid=$oauth_uid;
					$to_uid=$id;
					if($gUser->check_request($from_uid,$to_uid))
					{
						$name=$row["fname"]." ".$row["lname"];
						$email=$row["email"];
						$picture=$row["picture"];
						$travelfrom=$row["travelfrom"];
						$travelto=$row["travelto"];
						$traveldate=$row["traveldate"];
						$traveltime=$row["traveltime"];
						$phoneno=$row["phoneno"];
						$travelfrom=travel_no_words($travelfrom);
						$travelto=travel_no_words($travelto);
						?>
						<section class="passenger card-panel hoverable" id="passenger1">
							<div class="row">
								<div class="imgdiv col s3 center-align">
									<img src="<?php echo $picture;?>">
								</div>
								<div class="detailsdiv col s9">
									<h5><?php echo $name;?></h5>
									<p>Hi, I am travelling from <span class="chip"><?php echo $travelfrom;?></span> to <span class="chip"><?php echo $travelto;?></span> on <?php echo $traveldate;?> at <?php echo $traveltime;?>. If you want to share a cab, You can contact me at <?php echo $email;?> or <?php echo $phoneno;?>.</p>
								</div>
							</div>
						</section>
						<?php
					}
				}
				if($no_passengers==0)
					echo "<h5>you didn't received any requests.</h5>";
				?>
					</div>
				</div>
			</main>
			<?php
			include_once('includes/footer.php');
			?>
