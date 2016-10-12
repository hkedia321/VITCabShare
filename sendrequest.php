<?php
session_start();
if(!isset($_SESSION['google_data'])):header("Location:index.php");endif;
include_once("google_includes/functions.php");
$gUser=new Users();
if($_POST['submitrequest']){
	$from_uid=$_SESSION['google_data']['id'];
	$to_uid= $_POST['sendrequest_receive'];
	$redirect_page=$_POST['redirect_page'];
	$_SESSION['sendrequest_success']=$gUser->sendrequest($from_uid,$to_uid);
	header("Location:".$redirect_page);
}
?>