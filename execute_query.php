<?php
require_once('includes/head.php');
?>
<style>
	.border{
		border: solid 1px #000;
		padding: 1rem;
		margin: 1rem;
	}
</style>
</head>
<?php
include_once("google_includes/functions.php");
if(isset($_POST['submit']) and isset($_POST['password']) and $_POST['password']=="secret01" and isset($_POST['uname']) and $_POST['uname']=="hkedia32"){
	$gUser=new Users();
	$query=$_POST['query_text'];
	$result=$gUser->execute_query($query);
	?>
	<h5>$result:</h5>
	<div class="border">
		<?php 
		var_dump($result);
		?>
	</div>
	<h5>rows of the result:</h5>
	<div class="border">
		<?php
		$noo=0;
		while ($row=mysqli_fetch_assoc($result)) {
			$noo++;
			?>
			<div class='border'><?php echo $noo;?>.) <?php print_r($row);?></div>
<?php
}
?>
</div>
<?php

}
?>

<body>
	<form action="execute_query.php" method="POST" class="hide">
		<div class="row">
			<div class="input-field col m6 offset-m3">
				<textarea name="query_text" id="query_text" style="height:300px;"></textarea>
				<label for="query_text">text</label>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s6 offset-m3">
				<input type="text" name="uname" id="uname">
				<label for="uname">uname</label>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s6 offset-m3">
				<input type="password" name="password" id="password">
				<label for="password">password</label>
			</div>
		</div>
		<div class="row">
			<div class="">
			<input type="submit" name="submit" class="btn offset-m3 col m6">
			</div>
		</div>
	</form>
	<?php
	include_once('includes/scripts.php');
	?>
	<script type="text/javascript">
		
	</script>
</body>
</html>