<?php
require("twitteroauth/twitteroauth.php");
session_start();

//this is the TwitterOAuth instance
$twitterOAuth = new TwitterOAuth('wDisn7GmyuoQ38hJcIG0Sw','vb02wQbEPewzDAnLGuzezIOQlYWVNARGtmTlvBvQDpY');

$request_token = $twitterOAuth->getRequestToken('http://papansin.ako/auth/twitter_oauth.php');
		//saving them into the session
$_SESSION['oauth_token'] = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];


//if everything goes well..
if($twitterOAuth->http_code==200)	
	{

	//generate url and redirect
	$url = $twitterOAuth->getAuthorizeURL($request_token['oauth_token'],TRUE);
	$urlasd = $url.'&force_login=true';
	header('Location: ' .$urlasd);
	

	}else
		{
		die('Something Wrong');
		}
		
	?>