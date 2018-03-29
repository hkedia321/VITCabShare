<?php
session_start();
include_once("src/Google_Client.php");
include_once("src/contrib/Google_Oauth2Service.php");
######### edit details ##########
$clientId = '255740797537-i125ot2r3kvu8vhm5hh48lhb5tct0iur.apps.googleusercontent.com'; //Google CLIENT ID
$clientSecret = 'UYZ8sXfZGpEMQT6g07AelZIh'; //Google CLIENT SECRET
$redirectUrl = 'http://vitcabshare.16mb.com';  //return url (url to script)
$homeUrl = 'http://vitcabshare.16mb.com';  //return to home
##################################

$gClient = new Google_Client();
$gClient->setApplicationName('Login to codexworld.com');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectUrl);
$google_oauthV2 = new Google_Oauth2Service($gClient);
?>
