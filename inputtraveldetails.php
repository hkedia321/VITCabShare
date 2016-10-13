<?php
session_start();
if(!isset($_SESSION['google_data'])):header("Location:index.php");endif;
$form_error=null;
$travelfrom=null;
$travelto=null;
$traveldate=null;
$traveltime=null;
$flightno=null;
include_once("google_includes/functions.php");
if(isset($_POST['submit']))
{
	$latercheck=$_POST['latercheck'];
	$travelfrom=$_POST['travelfrom'];
	$travelto=$_POST['travelto'];
	$traveldate=$_POST['traveldate'];
	$traveltime=$_POST['traveltime'];
	$flightno=$_POST['flightno'];
	$gUser = new Users();
	$oauth_uid=$_SESSION['google_data']['id'];
	$latercheck=$_POST['latercheck'];
	if(has_presence($latercheck) and $latercheck=="on");
	else
	{
		$travelfrom=$_POST['travelfrom'];
		if(!has_presence($travelfrom))
			$form_error="Please fill in travel from";

		$travelto=$_POST['travelto'];
		if(!has_presence($form_error) && !has_presence($travelto))
			$form_error="Please fill in travel to";

		$traveldate=$_POST['traveldate'];
		if(!has_presence($form_error) && !has_presence($traveldate))
			$form_error="Please fill in travel date";
		$traveltime=$_POST['traveltime'];
		if(!has_presence($form_error) && !has_presence($traveltime))
			$form_error="Please fill in travel time";
		$flightno=$_POST['flightno'];
		if(!has_presence($form_error) && !has_max_length($flightno,20))
			$form_error="Flight no is too large";
		if(!has_presence($form_error) && isset($travelfrom) && !empty($travelfrom))
		{
			if(!has_presence($travelto) or !has_presence($traveldate) or !has_presence($traveltime) )
			{
				$form_error="Please enter complete travel details or leave it fully blank";
			}
		}
	}
	if(!has_presence($form_error)){
		$success=$gUser->update_traveldetails($oauth_uid,$travelfrom,$travelto,$traveldate,$traveltime,$flightno);
		if(!$success)
			header("Location:error.php?inputmobileno");
		$gUser->update_session();//update session
		header("Location:showall.php");
	}
}
global $title;
$title="VIT Cab Share - Input Travel Details";
require_once('includes/head.php');
?>
<link rel="stylesheet" type="text/css" href="css/materialize.clockpicker.css">
<style>
	.form-div-div{
		margin-top: 16vh;
		width: 600px;
		max-width: 95vw;
		margin-left: auto;
		margin-right: auto;
	}
	.form-div{
		/*margin-top: 16vh;
		width: 600px;
		max-width: 95vw;
		margin-left: auto;
		margin-right: auto;*/
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
	#errordisplay{
		color: red;
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
	<div class="form-div-div">
		<!-- <b>Last step, we promise !</b> -->
		<div class="form-div hoverable card">
			<form action="inputtraveldetails.php" method="POST">
				<?php
				if(has_presence($form_error))
					echo "<h5 class='form-error'>{$form_error}</h5>";
				else
					echo "<h5 class='center-align'>Please enter your Travel Details. </h5>";
				?>
				
				<div class="row">
					<div class="input-field col s12 m6">
						<select class="placeselect travelform-elements" id="travelfrom" name="travelfrom">
							<option id="10" value="0" selected>Choose your option</option>
							<option id="11" value="1">VIT-Vellore</option>
							<option id="12" value="2">VIT-Chennai</option>
							<option id="13" value="3">Chennai Airport</option>
							<option id="14" value="4">Bangalore Airport</option>
						</select>
						<label>From:</label>
					</div>
					<div class="input-field col s12 m6">
						<select class="placeselect travelform-elements" id="travelto" name="travelto">
							<option id="20" value="0" selected>Choose your option</option>
							<option id="21" value="1">VIT-Vellore</option>
							<option id="22" value="2">VIT-Chennai</option>
							<option id="23" value="3">Chennai Airport</option>
							<option id="24" value="4">Bangalore Airport</option>
						</select>
						<label>To:</label>
					</div>
					<div class="input-field col s12 m6">
						<span class="text-light">Date of travel:</span>
						<input type="text" class="datepicker travelform-elements" class="validate" placeholder="pick a date.." id="traveldate" name="traveldate" value="<?php if(has_presence($traveldate)) echo $traveldate;?>">
						<label for="date"></label>
					</div>
					<div class="input-field col s12 m6">
						<span class="text-light">Time of travel:</span>
						<input type="text" placeholder="Enter time.." id="traveltime" name="traveltime" class="timepicker travelform-elements" value="<?php if(has_presence($traveltime)) echo $traveltime;?>">
						<label for="traveltime"></label>

						
					</div>
					<div class="input-field col s12">
						<input type="text" name="flightno" id="flightno" class="travelform-elements" value="<?php if(has_presence($flightno)) echo $flightno;?>">
						<label for="flightno">Flight/Train no. (<i>optional</i>)</label>
					</div>
				</div>
				<div class="col s12">
					<p id="errordisplay"></p>
					<h5 class="center-align">OR</h5>
					<div class="later-div center-align">
						<input type="checkbox" class="filled-in" id="latercheck" name="latercheck" />
						<label for="latercheck">Never mind, I will add my travel details later.</label>
					</div>
					<br>
					<button class="btn waves-effect waves-light center-align" onclick="return check_valid()" type="submit" name="submit" value="1">Send<i class="material-icons right">send</i></button>
				</div>
			</form>
		</div>
	</div>
	<br>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="materialize/js/materialize.min.js"></script>
	<script type="text/javascript" src="js/materialize.clockpicker.js"></script>
	<script>
		$(document).ready(function() {
			$('select').material_select();
		});
		$(document).ready(function() {  
			$(document).on('change','#travelfrom',function(){
				var i=$(this).val();
				i=2+i;
				var j;
				for(j=20;j<=24;j++)
					$("#"+j).removeAttr("disabled");
				$("#"+i).attr("disabled","true");
				$('select').material_select();
			});
		});

		$(document).ready(function() {  
			$(document).on('change','#travelto',function(){
				var i=$(this).val();
				i=1+i;
				var j;
				for(j=10;j<=14;j++)
					$("#"+j).removeAttr("disabled");
				$("#"+i).attr("disabled","true");
				$('select').material_select();
			});
		});
		$('.datepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 2 // Creates a dropdown of 15 years to control year
});

</script>
<script type="text/javascript">
	function isempty(data){
		if (data==0 || data=="" || data==null ||data.length==0)
			return true;
		return false;
	}
	function check_valid(){
		if(document.getElementById("latercheck").checked)
		{
			$("#errordisplay").text("");
			return true;
		}
		else
			$("#errordisplay").text(error);
		var error="";
		var travelfrom=$("#travelfrom").val();
		var travelto=$("#travelto").val();
		var traveldate=$("#traveldate").val();
		var traveltime=$("#traveltime").val();
		var flightno=$("#flightno").val();
		if(isempty(travelfrom))
		{
			error="Travel from can't be empty";
			$("#errordisplay").text(error);
			return false;
		}
		if(isempty(travelto))
		{
			error="Travel to can't be empty";
			$("#errordisplay").text(error);
			return false;
		}
		if(isempty(traveldate))
		{
			error="Travel date can't be empty";
			$("#errordisplay").text(error);
			return false;
		}
		if(isempty(traveltime))
		{
			error="Travel time can't be empty";
			$("#errordisplay").text(error);
			return false;
		}
	}
</script>
<script type="text/javascript">
	$("#latercheck").change(function() {
		if(this.checked)
			$(".travelform-elements").attr("disabled","true");
		else
			$(".travelform-elements").removeAttr("disabled");
		$('select').material_select();
	});
</script>
<script type="text/javascript">
	$('#traveltime').clockpicker({
		placement: 'bottom',
		align: 'left',
		twelvehour: true
	});
	$('.datepicker').pickadate();
</script>
</body>
</html>
