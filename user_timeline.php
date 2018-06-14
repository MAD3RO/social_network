<!DOCTYPE html>
<html lang="en">
<head>
	<title>Welcome User!</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="css/bootstrapp.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css">
<link rel="stylesheet" type="text/css" href="styles/home_stylee.css?d=<?php echo time(); ?>" media="all"/>
<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
</head>
<body>
	<!--Container starts-->
	<div class="container">
	<!--Header Wrapper Starts-->
		<div id="head_wrap">
		<!--Header Starts-->
			<div id="header">

				<ul id="menu" style="margin-left: 150px;">
					<li><a href="home.php">Home</a></li>
					<li><a href="members.php">Members</a></li>
					<strong>Topics:</strong>
					<?php
						$get_topics = "select * from topics";
						$run_topics = mysqli_query($con, $get_topics);

						while($row = mysqli_fetch_array($run_topics)){
							$topic_id = $row['topic_id'];
							$topic_title = $row['topic_title'];
							echo "<li><a href='topic.php?topic=$topic_id'>$topic_title</a></li>";
						}
					?>		
				</ul>

				<form method="get" action="results.php" id="form1">
					<input type="text" name="user_query" required="required" placeholder="Search a user"/>
					<button  name="search" class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
				</form>
			</div>
		<!--Header Ends-->
		</div>
	<!--Header Wrapper Ends-->
		<!--Content area starts-->
		<div class="content">
			<!--User timeline starts-->
			<!--Content timeline starts-->
			<div id="user_timeline">
				<div id="user_details">
					<?php
						$user = $_SESSION['user_email'];
						$get_user = "select * from users where user_email = '$user'";
						$run_user  = mysqli_query($con, $get_user);
						$row = mysqli_fetch_array($run_user);
						$user_id = $row['user_id'];
						$user_name = $row['user_name'];
						$user_country = $row['user_country'];
						$user_image = $row['user_image'];
						$register_date = $row['register_date'];

						//getting the number of friends
						$my_friends_res = mysqli_fetch_assoc(mysqli_query($con, "SELECT friend_array FROM users WHERE user_id = ".$_SESSION['user_id']));
						$count_friends = 0;
						if($my_friends_res['friend_array'] != '')
						{
							$aMyFriends = array();
							$aMyFriends = explode(",", $my_friends_res['friend_array']);
							$count_friends = count($aMyFriends);
						}
						
						$user_posts = "select * from posts where user_id='$user_id'";
						$run_posts = mysqli_query($con, $user_posts);
						$posts = mysqli_num_rows($run_posts);

						//getting the number of unread messages
						$sel_msg = "select * from messages where receiver='$user_id' AND status='unread' order by 1 ASC";
						$run_msg = mysqli_query($con, $sel_msg);
						$count_msg = mysqli_num_rows($run_msg);

						//getting the number of friend requests
						$friendRequests = "select * from friend_requests where user_id_to=".$_SESSION['user_id'];
			            $run_friendRequests = mysqli_query($con, $friendRequests);
			            $count_req = mysqli_num_rows($run_friendRequests);

						echo "<center><img src='user/user_images/$user_image' width='200' height='200'/></center><br>
						<div id='user_mention'>
						<p><strong>Name: </strong>$user_name</p>
						<p><strong>Country: </strong>$user_country</p>
						<p><strong>Member Since: </strong>$register_date</p>

						<p><a href='my_messages.php?inbox&u_id=$user_id'>Messages ($count_msg)</a></p>
						<p><a href='my_posts.php?u_id=$user_id'>My Posts ($posts)</a></p>
						<p><a href='friend_requests.php?u_id=$user_id'>Friend Requests ($count_req)</a></p>
						<p><a href='friends.php?u_id=$user_id'>Friends ($count_friends)</a></p>
						<p><a href='edit_profile.php?u_id=$user_id'>Edit my account</a></p>
						<p><a href='logout.php'>Logout</a></p>
						</div>";
					?>
				</div>
			</div>
			<!--User timeline ends-->