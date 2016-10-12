<?php
include_once('includes/functions.php');
require_once 'autoload.php';
session_start();
// if(!isset($_SESSION['FBID']) or empty($_SESSION['FBID']))
//  redirect_to('nologin.php?nosuccess');
$fbid=$_SESSION['FBID'];
$fbname=$_SESSION['FULLNAME'];
$fbemail=$_SESSION['EMAIL'];
global $title;
$title="VIT Cab Share - Home";
require_once('includes/head.php');
global $my_fbid;
global $my_fbname;
global $my_fbemail;
?>
<link rel="stylesheet" type="text/css" href="css/common.css">
</head>
<body>
	<?php 
	global $active_nav;
	$active_nav="sameflight";
	require_once('includes/navigation.php');
	?>
	<main>
		<h5>Home</h5>
		<p>
		<img src="https://graph.facebook.com/<?php echo $_SESSION['FBID']; ?>/picture">
			name:<?php echo $fbname;?>
			fbid:<?php echo $_SESSION['FBID'];?>
			fbemail:<?php echo $fbemail;?>
		</p>
		<h5>Global se:</h5>
		<p>
			name:<?php echo $my_fbname;?>
			id:<?php echo $my_fbid;?>
			email:<?php echo $my_fbemail;?>
		</main>
		<?php 
include_once('includes/scripts.php');
?>
		<?php
		include_once('includes/footer.php');
		?>
