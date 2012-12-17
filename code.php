<?php
$twitteroauth = new TwitterOAuth('wDisn7GmyuoQ38hJcIG0Sw','vb02wQbEPewzDAnLGuzezIOQlYWVNARGtmTlvBvQDpY', $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);  
// Let's request the access token  
$access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']); 
// Save it in a session var 
$_SESSION['access_token'] = $access_token; 
// Let's get the user's info 
$user_info = $twitteroauth->get('account/verify_credentials'); 

// Print user's info  
?>

<img src='logo.png'>
<?php
echo '<a href="/twitter/twitter_login.php">Relogin</a>';
// this will return an image of  the twitter user and its link
echo "<br><img src =$user_info->profile_image_url_https><br>Hi  <a href=http://www.twitter.com/$user_info->screen_name>$user_info->screen_name</a>";

//START OF USER INFO
echo '<br> Screen Name : ' . $user_info->screen_name;
echo '<br> Tweets : ' . $user_info->statuses_count;
echo '<br> Followers : ' . $user_info->followers_count;
echo '<br> Following: ' . $user_info->friends_count;
echo '<br> Favorites : ' .$user_info->favourites_count;
//END
echo '<h1> User Info </h1> ';
echo '<pre>';
//this will return a JSON format of User info in twitter 
print_r($user_info);

echo '</pre>';
/*
this will show the last 20 tweets of the user 
*/
$tweet1 = $twitteroauth->GET('statuses/user_timeline',array('screen_name'=>'nrpenaredondo'));
echo '<h1> Misc Info\'s</h1>';
echo $tweet1[0]->text;
echo '<br><a href=http://www.twitter.com/'.$user_info->screen_name . '>'.$user_info->name.'</a>';

//end


/* ETO WALA LANG TO FOR TESTING PURPOSES LANG TO ... 
THIS LINE OF CODES WILL BE TWIEETING CONTINUOUSLY WITH DIFFERETE
for($count = 0; $count <=250;$count++)
{
*/
//$twitteroauth->post('statuses/update', array('status' => 'Hello @353532628' , )); 
/*sleep(rand(1,30));
}
*/

/*
this will get all the user id 
*/
echo '<h1> Follower\'s</h1>';
$followers = $twitteroauth->get('friends/ids',array('screen_name'=>$user_info->screen_name));
echo '<h1>'.$followers->ids[0].'</h1>';
echo '<pre>';
print_r($followers);
echo '</pre>';

shuffle($followers->ids);
for($count = 0; $count <= 25; $count++)
{
	$random_stranger= $twitteroauth->get('users/lookup',array('user_id'=>$followers->ids[$count]));
	//$twitteroauth->post('statuses/update', array('status' => ' Tweet Via AdverTWEETment app '));
	$twitteroauth->post('statuses/update', array('status' => ' Hi :))) *BOT*   @'.$random_stranger[0]->screen_name));
	sleep(rand(1,5));
}



echo '<pre>'.print_r($access_token).'</pre>';

echo '<a href="/twitter/twitter_login.php">Relogin</a>';


?>