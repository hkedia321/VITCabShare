<?php
session_start();
$form_error=null;
$id=$_SESSION['google_data']['id'];
$email=$_SESSION['google_data']['email'];
if(!isset($_SESSION['google_data'])):header("Location:index.php");endif;
include_once("google_includes/functions.php");

if(isset($_POST['editdetailssubmit']))
{
	// header("Location:http://google.com");
	$noerrors=0;
	$oauth_uid=$_SESSION['google_data']['id'];
	
	$travelfrom=$_POST['travelfrom'];
	$travelto=$_POST['travelto'];
	$traveldate=($_POST['traveldate']);
	$traveltime=$_POST['traveltime'];
	$flightno=($_POST['flightno']);
	$emailvisible=$_POST['seeemail'];
	if(isset($emailvisible) && $emailvisible=="1");
	else
		$emailvisible="0";
	$phoneno=$_POST['phoneno'];
	$phonenovisible=$_POST['seephoneno'];
	if(isset($phonenovisible) && $phonenovisible=="1");
	else
		$phonenovisible="0";
	if(!isset($phoneno) or empty($phoneno)){
		$form_error="Phone no can't be blank";
		$noerrors=1;
	}
	if(!has_max_length($flightno,20)){
		$form_error="flight no max length is 20 characters";
		$noerrors=1;
	}
	if(!has_min_length($phoneno,10) or !has_max_length($phoneno,13))
	{
		$form_error="Please enter correct mobile no";
		$noerrors=1;
	}
	if(isset($travelfrom) && !empty($travelfrom))
	{
		if(!has_presence($travelto) or !has_presence($traveldate) or !has_presence($traveltime) )
		{
			$form_error="Please enter complete travel details or leave it fully blank";
			$noerrors=1;
		}
	}
	if($noerrors==0)
	{
		$gUser=new Users();
		$success=$gUser->update_details($id,$travelfrom,$travelto,$traveldate,$traveltime,$flightno,$emailvisible,$phoneno,$phonenovisible);
		if(!$success)
		{
			$form_error="Some error occured. Please try again later";
			$noerrors=1;
		}
		else
		{
			$form_error="Suceessfully changed details";
			$noerrors=2;
		}
	}
}
$google_travelfrom=$_SESSION['google_data']['travelfrom'];
$google_travelto=$_SESSION['google_data']['travelto'];
$google_traveldate=$_SESSION['google_data']['traveldate'];
$google_traveltime=$_SESSION['google_data']['traveltime'];
$google_flightno=$_SESSION['google_data']['flightno'];
$google_emailvisible=$_SESSION['google_data']['emailvisible'];
$google_phoneno=$_SESSION['google_data']['phoneno'];
$google_phonenovisible=$_SESSION['google_data']['phonenovisible'];
global $title;
$title="VIT Cab Share - Edit My Details";
require_once('includes/head.php');
?>
<link rel="stylesheet" type="text/css" href="css/materialize.clockpicker.css">
<link rel="stylesheet" type="text/css" href="css/common.css">
</head>
<body>
	<?php 
	global $active_nav;
	$active_nav="editdetails";
	require_once('includes/navigation.php');
	?>
	<main>
		<h4>Edit your details:</h4>
		<div class="container">
			<h5 class="form-error" id="errordisplay"><?php if($noerrors==1) echo $form_error;?></h5>
			<h5 class="form-success"><?php if($noerrors==2) echo $form_error;?></h5>
			<form action="editdetails.php" method="POST">
				<h5>Travel details:</h5>
				<div class="row">
					<div class="input-field col s12 m6">
						<select class="placeselect" id="from" name="travelfrom">
							<option id="10" value="0"<?php if(!has_presence($google_travelfrom)) echo " selected";?> >Choose your option</option>
							<option id="11" value="1" <?php if($google_travelfrom=="1") echo " selected";?> >VIT-Vellore</option>
							<option id="12" value="2" <?php if($google_travelfrom=="2") echo " selected";?> >VIT-Chennai</option>
							<option id="13" value="3" <?php if($google_travelfrom=="3") echo " selected";?> >Chennai Airport</option>
							<option id="14" value="4" <?php if($google_travelfrom=="4") echo " selected";?> >Bangalore Airport</option>
						</select>
						<label>From:</label>
					</div>
					<div class="input-field col s12 m6">
						<select class="placeselect" id="to" name="travelto">
							<option id="20" value="0"<?php if(!has_presence($google_travelto)) echo " selected"?> >Choose your option</option>
							<option id="21" value="1"<?php if($google_travelto=="1") echo " selected"?> >VIT-Vellore</option>
							<option id="22" value="2"<?php if($google_travelto=="2") echo " selected"?> >VIT-Chennai</option>
							<option id="23" value="3"<?php if($google_travelto=="3") echo " selected"?> >Chennai Airport</option>
							<option id="24" value="4"<?php if($google_travelto=="4") echo " selected"?> >Bangalore Airport</option>
						</select>
						<label>To:</label>
					</div>
					<div class="input-field col s12 m6">
						<span class="text-light">Date of travel:</span>
						<input type="text" class="datepicker" class="validate" placeholder="pick a date.." id="traveldate" name="traveldate"<?php if(has_presence($google_traveldate)) echo " value='{$google_traveldate}'"?> >
						<label for="date"></label>
					</div>
					<div class="input-field col s12 m6">
						<span class="text-light">Time of travel:</span>
						<input type="text" id="traveltime" class="timepicker" name="traveltime"<?php if(has_presence($google_traveltime)) echo " value='{$google_traveltime}'"?> >
						<label for="time"></label>
					</div>
					<div class="input-field col s12">
						<input type="text" name="flightno" id="flightno"<?php if(has_presence($google_flightno)) echo " value='{$google_flightno}'"?> >
						<label for="flightno">Flight/Train no. (optional)</label>
					</div>
					<div class="col s12">
						<a class="waves-effect waves-light btn" id="reset"><i class="fa fa-trash-o" aria-hidden="true"></i> reset</a>
					</div>
				</div>
				<h5 class="margin-up-little">Personal details:</h5>
				<div class="row">
					<div class="input-field col s12">
						<i class="material-icons prefix">email</i>
						<input disabled title="you cannot change your email id since it is received from your google account !!" name="email" id="email" type="email" class="validate" data-error="wrongemail" data-success=""<?php echo " value='{$email}'"?> >
						<labeL for="email">Email</labeL>
					</div>
					<div class="col s12">
						Show my email to others&nbsp;
						<span class="switch">
							<label>
								No
								<input type="checkbox" name="seeemail" value="1" id="seeemail"<?php if(has_presence($google_emailvisible) and $google_emailvisible=="1") echo " checked"?> >
								<span class="lever"></span>
								Yes
							</label>
						</span>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">
						<i class="material-icons prefix">phone</i>
						<input name="phoneno" id="phoneno" type="number" length="13"<?php if(has_presence($google_phoneno)) echo " value={$google_phoneno}"?>>
						<labeL for="phoneno">Mobile no</labeL>
					</div>
					<div class="col s12">
						Show my phone no. to others&nbsp;
						<span class="switch">
							<label>
								No
								<input type="checkbox" name="seephoneno" id="seephoneno" value="1" <?php if(has_presence($google_phonenovisible) and $google_phonenovisible=="1") echo " checked"?> >
								<span class="lever"></span>
								Yes
							</label>
						</span>
					</div>
				</div>
				<br>
				<button class="btn waves-effect waves-light right" type="submit" name="editdetailssubmit" onclick="return check_valid()" value="1">Save changes<i class="material-icons right">send</i>
				</button>
			</form>
			<br><br><br><br>
		</div>

	</div>
</main>
<?php 
include_once('includes/scripts.php');
?>
<script src="js/materialize.clockpicker.js"></script>
<script type="text/javascript">
	$('#traveltime').clockpicker({
		placement: 'bottom',
		align: 'left',
		twelvehour: true
	});
</script>
<script type="text/javascript">
	$("#reset").click(function(){
		$("#10").removeAttr("selected");
		$("#11").removeAttr("selected");
		$("#12").removeAttr("selected");
		$("#13").removeAttr("selected");
		$("#14").removeAttr("selected");
		$("#10").attr("selected","selected");

		$("#20").removeAttr("selected");
		$("#21").removeAttr("selected");
		$("#22").removeAttr("selected");
		$("#23").removeAttr("selected");
		$("#24").removeAttr("selected");
		$("#20").attr("selected","selected");
		$('select').material_select();

		$("#traveldate").val("");
		$("#traveltime").val("");
		$("#flightno").val("");
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
		var travelfrom=$("#from").val();
		var travelto=$("#to").val();
		var traveldate=$("#traveldate").val();
		var traveltime=$("#traveltime").val();
		var flightno=$("#flightno").val();
		var email=$("#email").val();
		var phoneno=$("#phoneno").val();
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
		if(isempty(email))
		{
			error="Email can't be empty";
			$("#errordisplay").text(error);
			return false;
		}
		if(isempty(phoneno))
		{
			error="phone can't be empty";
			$("#errordisplay").text(error);
			return false;
		}
		if(phoneno.length<10 || phoneno.length>13)
		{
			error="Please Enter correct Mobile no";
			$("#errordisplay").text(error);
			return false;
		}
	}
</script>
<?php
include_once('includes/footer.php');
?>
