<?php
class Users {
	public $tableName = 'users';
	
	function __construct(){
		//database configuration
		//######## this is the only place you have to change database details #######
		$dbServer = 'mysql.hostinger.in'; //Define database server host
		$dbUsername = 'u156415601_vit'; //Define database username
		$dbPassword = 'secret'; //Define database password
		$dbName = 'u156415601_vit'; //Define database name
		
		//connect databse
		$con = mysqli_connect($dbServer,$dbUsername,$dbPassword,$dbName);
		if(mysqli_connect_errno()){
			die("Failed to connect with MySQL: ".mysqli_connect_error());
		}else{
			$this->connect = $con;
		}
	}
	
	function checkUser($oauth_provider,$oauth_uid,$fname,$lname,$email,$gender,$locale,$link,$picture){
		$prevQuery = mysqli_query($this->connect,"SELECT * FROM $this->tableName WHERE oauth_provider = '".$oauth_provider."' AND oauth_uid = '".$oauth_uid."'") or die(mysqli_error($this->connect));
		if(mysqli_num_rows($prevQuery) > 0)
		{
			$update = mysqli_query($this->connect,"UPDATE $this->tableName SET oauth_provider = '".$oauth_provider."', oauth_uid = '".$oauth_uid."', fname = '".$fname."', lname = '".$lname."', email = '".$email."', gender = '".$gender."', locale = '".$locale."', picture = '".$picture."', gpluslink = '".$link."', modified = '".date("Y-m-d H:i:s")."' WHERE oauth_provider = '".$oauth_provider."' AND oauth_uid = '".$oauth_uid."'") or die(mysqli_error($this->connect));
		}
		else
		{
			$insert = mysqli_query($this->connect,"INSERT INTO $this->tableName SET oauth_provider = '".$oauth_provider."', oauth_uid = '".$oauth_uid."', fname = '".$fname."', lname = '".$lname."', email = '".$email."', gender = '".$gender."', locale = '".$locale."', picture = '".$picture."', gpluslink = '".$link."', created = '".date("Y-m-d H:i:s")."', modified = '".date("Y-m-d H:i:s")."'") or die(mysqli_error($this->connect));
		}
		
		$query = mysqli_query($this->connect,"SELECT * FROM $this->tableName WHERE oauth_provider = '".$oauth_provider."' AND oauth_uid = '".$oauth_uid."'") or die(mysqli_error($this->connect));
		$result = mysqli_fetch_array($query);
		return $result;
	}

	function find_user($oauth_uid)
	{
		$query="SELECT * FROM users WHERE oauth_uid ='$oauth_uid' LIMIT 1;";
		$result=mysqli_query($this->connect,$query);
		if(!$result)
			return null;
		else
		{
			$row=mysqli_fetch_assoc($result);
			return $row;
		}
	}

	function update_phoneno($oauth_uid,$phoneno){
		$query="UPDATE users SET phoneno={$phoneno} WHERE oauth_uid = '{$oauth_uid}';";
		$result=mysqli_query($this->connect,$query);
		$this->update_session();
		if(!$result)
			return false;
		return true;
	}

	function update_traveldetails($oauth_uid,$travelfrom,$travelto,$traveldate,$traveltime,$flightno){
		$query="UPDATE users SET travelfrom='{$travelfrom}', travelto='{$travelto}', traveldate='{$traveldate}', traveltime='{$traveltime}', flightno='{$flightno}' WHERE oauth_uid = '{$oauth_uid}';";
		$result=mysqli_query($this->connect,$query);
		$this->update_session();
		if(!$result)
			return false;
		return true;
	}
	function has_phoneno($oauth_uid){
		$query="SELECT phoneno FROM users WHERE oauth_uid='{$oauth_uid}';";
		$result=mysqli_query($this->connect,$query);
		if(!$result)
			header("Location:error.php?phnocheckerror");
		$row=mysqli_fetch_assoc($result);
		if(isset($row['phoneno']) && !empty($row['phoneno']))
			return true;
		return false;
	}
	function update_session()
	{
		session_start();
		$oauth_uid=$_SESSION['google_data']['id'];
		$query="SELECT * FROM users WHERE oauth_uid='{$oauth_uid}' LIMIT 1;";
		$result=mysqli_query($this->connect,$query);
		$row=mysqli_fetch_assoc($result);
		if(!$result)
			header("Location: error.php?update_session failed");
		$_SESSION['google_data']['fname']=$row['fname'];
		$_SESSION['google_data']['lname']=$row['lname'];
		$_SESSION['google_data']['name']=$row['fname']." ".$row['lname'];
		$_SESSION['google_data']['email']=$row['email'];
		$_SESSION['google_data']['picture']=$row['picture'];
		$_SESSION['google_data']['travelfrom']=$row['travelfrom'];
		$_SESSION['google_data']['travelto']=$row['travelto'];
		$_SESSION['google_data']['traveldate']=$row['traveldate'];
		$_SESSION['google_data']['traveltime']=$row['traveltime'];
		$_SESSION['google_data']['flightno']=$row['flightno'];
		$_SESSION['google_data']['lnamevisible']=$row['lnamevisible'];
		$_SESSION['google_data']['emailvisible']=$row['emailvisible'];
		$_SESSION['google_data']['phoneno']=$row['phoneno'];
		$_SESSION['google_data']['phonenovisible']=$row['phonenovisible'];

	}
	function update_details($id,$travelfrom,$travelto,$traveldate,$traveltime,$flightno,$lnamevisible,$emailvisible,$phonenovisible)
	{
		session_start();
		if(!has_presence($travelfrom))
			$travelfrom=0;
		if(!has_presence($travelto))
			$travelto=0;
		if(!has_presence($traveldate))
			$traveldate=0;
		if(!has_presence($traveltime))
			$traveltime=0;
		if(!has_presence($flightno))
			$flightno=0;
		if(!has_presence($lnamevisible))
			$lnamevisible=0;
		if(!has_presence($emailvisible))
			$emailvisible=0;
		if(!has_presence($phonenovisible))
			$phonenovisible=0;

		$query="UPDATE users SET travelfrom='{$travelfrom}', travelto='{$travelto}', traveldate='{$traveldate}', traveltime='{$traveltime}', flightno='{$flightno}', lnamevisible={$lnamevisible}, emailvisible={$emailvisible}, phonenovisible={$phonenovisible} WHERE oauth_uid = '{$id}';";
		$result=mysqli_query($this->connect,$query);
		$_SESSION['myquery']=$query;
		// echo $query;
		// die();
		if(!$result)
			return false;
		$this->update_session();
		return true;
	}
	function all_travellers_including_me(){
		$query="SELECT oauth_uid,fname,lname,email,picture,travelfrom,travelto,traveldate,traveltime,flightno,emailvisible,phoneno,phonenovisible FROM users Where travelfrom='1' or travelfrom='2' or travelfrom='3' or travelfrom='4' order by traveldate,traveltime,travelfrom,travelto,fname,lname;";
		$result=mysqli_query($this->connect,$query);
		if(!$result)
		{
			header("Location:error.php?all_travellers_error");
			return null;
		}
		return $result;
	}
	function all_travellers(){
		//exclude me
		session_start();
		$id=$_SESSION['google_data']['id'];
		$query="SELECT oauth_uid,fname,lname,email,picture,travelfrom,travelto,traveldate,traveltime,flightno,emailvisible,phoneno,phonenovisible FROM users Where oauth_uid!='{$id}' and (travelfrom='1' or travelfrom='2' or travelfrom='3' or travelfrom='4') order by traveldate,traveltime,travelfrom,travelto,fname,lname;";
		// echo $query;
		// die();
		$result=mysqli_query($this->connect,$query);
		if(!$result)
		{
			header("Location:error.php?all_travellers_error");
			return null;
		}
		return $result;
	}
	function all_travellers_ordertime(){
		session_start();
		$id=$_SESSION['google_data']['id'];
		$query="SELECT oauth_uid,fname,lname,email,picture,travelfrom,travelto,traveldate,traveltime,flightno,emailvisible,phoneno,phonenovisible FROM users Where oauth_uid!='{$id}' and (travelfrom='1' or travelfrom='2' or travelfrom='3' or travelfrom='4') order by traveldate,traveltime;";
		$result=mysqli_query($this->connect,$query);
		if(!$result)
		{
			header("Location:error.php?all_travellers_error");
			return null;
		}
		return $result;
	}
	function sendrequest($from_uid,$to_uid)
	{
		$query="INSERT INTO requests(from_uid,to_uid) values('{$from_uid}','{$to_uid}');";
		$result=mysqli_query($this->connect,$query);
		if(!$result)
		{
			header("Location:error.php?send_request_error");
			return null;
		}
		return $result;
	}
	function no_unseen_requests($to_uid){
		$query="SELECT count(r_id) from requests WHERE to_uid='{$to_uid}' and seen=0;";
		$result=mysqli_query($this->connect,$query);
		if(!$result)
		{
			header("Location:error.php?no_seen_error");
			return null;
		}
		$row=mysqli_fetch_assoc($result);
		return $row['count(r_id)'];
	}
	function check_request($from_uid,$to_uid){
		$query="SELECT count(r_id) from requests WHERE from_uid='{$from_uid}' and to_uid='{$to_uid}';";
		$result=mysqli_query($this->connect,$query);
		if(!$result)
		{
			header("Location:error.php?check_request_error");
			return null;
		}
		$row=mysqli_fetch_assoc($result);
		if($row["count(r_id)"]!=0)
			return true;
		return false;
	}

	function execute_query($query){
		$result=mysqli_query($this->connect,$query);
		return $result;
	}

	function make_seen($from_uid,$to_uid){
		$query="UPDATE requests SET seen=1 WHERE from_uid='{$from_uid}' and to_uid='{$to_uid}';";
		
		$result=mysqli_query($this->connect,$query);
		if(!$result)
		{
			header("Location:error.php?make_seen");
			return null;
		}
		return true;
	}

	function make_seen_all($to_uid){
		$query="UPDATE requests SET seen=1 WHERE to_uid='{$to_uid}';";
		
		$result=mysqli_query($this->connect,$query);
		if(!$result)
		{
			header("Location:error.php?make_seen1");
			return null;
		}
		return true;
	}

	function all_requests($id){
		$query="SELECT * FROM requests WHERE to_uid='{$id}' order by r_id desc;";
		$result=mysqli_query($this->connect,$query);
		if(!$result)
		{
			header("Location:error.php?all_requests");
			return null;
		}
		return $result;
	}
}
function redirect_to($stt){
	header("Location:{$stt}");
	die();
}
function has_max_length($value, $max)
{
	return strlen($value)<=$max;
}
function has_min_length($value, $minn)
{
	return strlen($value)>=$minn;
}
function has_exact_length($value, $max)
{
	return strlen($value)==$max;
}
function has_presence($value)
{
	return isset($value) && !empty($value) && $value!=="" && $value!=0 &&$value!="0";
}
function travel_no_words($travel){
	if($travel=="1")
		return "VIT-Vellore";
	elseif($travel=="2")
		return "VIT-Chennai";
	elseif($travel=="3")
		return "Chennai Airport";
	elseif($travel=="4")
		return "Bangalore Airport";
	else
		return false;
}
?>