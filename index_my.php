<?php
session_start(); 
require_once('includes/head.php');
?>
<link rel="stylesheet" type="text/css" href="css/index.css">
</head>

<body>
	<div class="fb-icon border right-align">
		<i class="fa fa-facebook fa-3x" aria-hidden="true"></i>
	</div>
	<div
  class="fb-like"
  data-share="true"
  data-width="450"
  data-show-faces="true">
</div>
	<div class="logo-div center-align">
		<img src="images/logo.png">
	</div>
	<div class="login-div center-align">
		<a href="fbconfig.php" class="waves-effect waves-light btn">Login with Facebook</a>
	</div>
	<?php
	include_once('includes/footer.php');
	?>