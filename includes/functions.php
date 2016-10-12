<?php
function redirect_to($page)
{
	header("Location: {$page}");
	exit;
}
function make_connection(){
	global $connection;
	
	$dbhost="localhost";
	$dbuser="root";
	$dbpass="secret";
	$dbname="vitbookshare";
	$connection=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
	if(mysqli_connect_errno()){
		die("Database connection failed:".mysqli_conect_error()."(".mysqli_connect_errorno().")"
			);
	}
}
function sql_escape($input){
	global $connection;
	return mysqli_real_escape_string($connection,$input);
}
function confirm_query($result){
	if(!$result){
		echo "DataBase Query failed.";
	}
}
?>