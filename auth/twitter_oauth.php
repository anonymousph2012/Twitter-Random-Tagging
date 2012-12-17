<?php
require("twitteroauth/twitteroauth.php");
require('db.php');
session_start();

if(!empty($_GET['oauth_verifier']) || (!empty($_SESSION['oauth_token'])) && (!empty($_SESSION['oauth_token_secret']))){  
    // We've got everything we need  

	// TwitterOAuth instance, with two new parameters we got in twitter_login.php  
$twitteroauth = new TwitterOAuth('wDisn7GmyuoQ38hJcIG0Sw','vb02wQbEPewzDAnLGuzezIOQlYWVNARGtmTlvBvQDpY', $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);  
// Let's request the access token  
$access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']); 
$_SESSION['access_token'] = $access_token;
print_r($access_token);
if(!empty($_SESSION['access_token']))
{
header('Location: /index.php');
}

//$sql = "INSERT INTO users  VALUES ($access_token[user_id],'$access_token[screen_name]','$access_token[oauth_token]','$access_token[oauth_token_secret]')";
//mysql_query($sql) or die(mysql_error());
//echo '<h1>YOU\'RE NOW LOGIN!</h1>';
//echo '<pre>'.print_r($_SESSION['access_token']).'</pre>';
} else {  
    // Something's missing, go back to square 1  
    header('Location: twitter_login.php');  
}  

?>