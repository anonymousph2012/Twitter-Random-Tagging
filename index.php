<?php 
include('auth/twitteroauth/twitteroauth.php');
session_start();
if(empty($_SESSION['access_token']))
{
header('Location: auth/index.php');
}
$twitteroauth = new TwitterOAuth('wDisn7GmyuoQ38hJcIG0Sw','vb02wQbEPewzDAnLGuzezIOQlYWVNARGtmTlvBvQDpY', $_SESSION['access_token']['oauth_token'], $_SESSION['access_token']['oauth_token_secret']);  
$user_info = $twitteroauth->get('account/verify_credentials'); 
$tweets = $twitteroauth->get('statuses/user_timeline'); 
//echo "<pre>";
//print_r($tweets);

if(isset($_POST['submit']))
{
	$num_of_tweet = $_POST['number_of_tweet'];
	$tweet = $_POST['tweet_mode'];
	$followers = $twitteroauth->get('friends/ids',array('screen_name'=>$user_info->screen_name));
	shuffle($followers->ids);
	if($_POST['tweet_options'] == 'random_tag')
	{
		for($count = 0; $count <= $num_of_tweet ; $count++)
		{
		$random_stranger= $twitteroauth->get('users/lookup',array('user_id'=>$followers->ids[$count]));
		$twitteroauth->post('statuses/update', array('status' =>  $tweet.' @'.$random_stranger[0]->screen_name));
		sleep(rand(1,10));
		if($count == $num_of_tweet)
			{
				echo '<script>alert("Done")</script>';
				echo '<script>window.location="index.php"</script>';
			}
		}
	}elseif($_POST['tweet_options'] == 'tweet_only')
	{
		$twitteroauth->post('statuses/update', array('status' =>  $tweet));
		echo '<script>alert("Done")</script>';
		echo '<script>window.location="index.php"</script>';
	}else{}
}
?>
<!doctype html>
<html>
	<head>
		<title>Tweet Mo! </title>
		<link rel="stylesheet" type="text/css" href="assets/metro/css/modern.css" />
		<link rel="stylesheet" type="text/css" href="assets/metro/css/auth-buttons.css" />
		<script src="assets/metro/js/accordion.js"></script>
		<script src="assets/metro/js/buttonset.js"></script>
		<script src="assets/metro/js/carousel.js"></script>
		<script src="assets/metro/js/dropdown.js"></script>
		<script src="assets/metro/js/pagecontrol.js"></script>
		<script src="assets/metro/js/rating.js"></script>
		<script src="assets/metro/js/slider.js"></script>
		<script src="assets/metro/js/tile-slider.js"></script>
	</head>
	<body class="modern-ui">
		<div class="page secondary">
		        <div class="page-header">
				<div class="page-header-content">
					<div class="grid">
				         	<div class="navigation-bar">
	        					<div class="navigation-bar-inner">
							       <div class="brand">
							                <span class="name"><small>Adver</small>TWEET<small>ment</small></span>
							       	</div><!--brand-->
							       	
	 						</div><!--navbar-inner-->
	    					</div><!--navigationbar-->
    					</div><!--grid-->
			       </div><!--page-header-content-->
		        </div><!--page-header-->
		        <div class="grid">
		        	<div class="row">
		        		<div class="span5">
					        <div class="page-region" style="margin-top:45px;">
							<div class="page-region-content">
								<div class="grid">
							         	<address>
							         		 <div class="image-collection p4x3">
										        <div><img src="<?php echo $user_info->profile_image_url_https?>" /></div>
										    </div>
							         		
							         		Screen Name :<?php echo $user_info->screen_name;?>
							         		<br>
							         		Followers: <?php echo  $user_info->followers_count; ?>
							         		<br>
							         		Following : 	<?php echo  $user_info->friends_count; ?>
							         		<br>
							         		Tweets : <?php echo $user_info->statuses_count; ?>
							         	</address>
							         	<h2>Follower of the Day</h2>
							         	<div class="span4">
					                                        <div class="tile double image-set" style="margin-top:5px;">
					                                            <div class="tile-content">
					                                                <img src="images/1.jpg" alt="">
					                                            </div>
					                                            <div class="tile-content">
					                                                <img src="images/2.jpg" alt="">
					                                            </div>
					                                            <div class="tile-content">
					                                                <img src="images/3.jpg" alt="">
					                                            </div>
					                                            <div class="tile-content">
					                                                <img src="images/4.jpg" alt="">
					                                            </div>
					                                            <div class="tile-content">
					                                                <img src="images/5.jpg" alt="">
					                                            </div>
					                                        </div>
					                                    </div>

			    					</div><!--grid-->
			    				</div><!--page-header-content-->
					        </div><!--page-header-->
		        		</div>
		        		<div class="span7" style="margin-left:-40px;">
					        <form method="POST" action="#">
					     	<div class="grid">
					 		<div class="row">
							        <div class="page-header">
							            	<div class="page-header-content">
							             		<h1>Tweet!<small>random-tagging</small></h1>
					           			</div><!--page-header-content-->
							        </div><!--page-header-->
					      		</div>
					      	<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
					        <div class="page-region">
					        	<div class="row">
					        		<div class="span7">
						            	<div class="page-region-content">
							                <div class="input-control textarea" >
									        <textarea name="tweet_mode">
									        </textarea>
									</div>
									<input type="range" name="number_of_tweet" min="1" max="25" value="1">
									<input type="radio" name="tweet_options" value="random_tag"/>Random
									<input type="radio" name="tweet_options" value="tweet_only" checked/>Tweet
									<br>
									<button class="default" type="submit" name="submit"><i class="icon-twitter"></i>Tweet</button>
						           	 </div><!--page-region-content-->
					           		</div>
					           	</div>
					        </div><!--page-region-->
					      </form>
					      </div>
					         <div class="grid">
					        	<div class="row">
					        		<div class="span8">
							        <div class="page-region">
							            	<div class="page-region-content">
							             		<h2 style="margin-top:17px;">Top 3 <small>Latest Tweet</small></h2>
							             		<div class="tile">
							             			<div class="tile-content">
							             			<?php echo $tweets[0]->text;?>
							             			</div>
							             			<div class="brand">
							             			<div class="name">@<?php echo $tweets[0]->in_reply_to_screen_name;?></div>
							             			<div class="badge">1</div>
							             			</div>
							             		</div>
							             		<div class="tile">
							             			<div class="tile-content">
							             			<?php echo $tweets[1]->text;?>
							             			</div>
							             			<div class="brand">
							             			<div class="name">@<?php echo $tweets[1]->in_reply_to_screen_name;?></div>
							             			<div class="badge">2</div>
							             			</div>
							             		</div>
							             		<div class="tile">
							             			<div class="tile-content">
							             			<?php echo $tweets[2]->text;?>
							             			</div>
							             			<div class="brand">
							             			<div class="name">@<?php echo $tweets[2]->in_reply_to_screen_name;?></div>
							             			<div class="badge">3</div>
							             			</div>
							             		</div>
					           			</div><!--page-region-content-->
							        </div><!--page-region-->
							      </div>
					      		</div>
					        </div><!--grid-->
					</div>
				</div>
   		 </div><!--page-->
   		</form>
	</body>
</html>