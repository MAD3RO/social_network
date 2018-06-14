<?php

	$con = mysqli_connect("localhost","root","","social_network") or die ("Connection was not established");
				
//function for getting topics
function getTopics(){
global $con;
$get_topics = "select * from topics";
$run_topics = mysqli_query($con, $get_topics);

while($row = mysqli_fetch_array($run_topics)){
	$topic_id = $row['topic_id'];
	$topic_title = $row['topic_title'];
	echo "<option value='$topic_id'>$topic_title</option>";
	}
}


//function for inserting posts
function insertTopicPost(){
	if(isset($_POST['sub'])){

		global $con;
		global $user_id;
		$title = addslashes($_POST['title']);
		$content = addslashes($_POST['content']);

		$topic = $_GET['topic'];
		$is_public = $_POST['visibly'];
		
		$post_image = $_FILES['post_image']['name'];
		$image_tmp = $_FILES['post_image']['tmp_name'];

		move_uploaded_file($image_tmp, "user/post_images/$post_image");

		if(strlen($title)>40){
			echo "<script>alert('Title can contain maximum 38 characters!')</script>";
			echo "<script>window.open('home.php','_self')</script>";
			exit();
		}

		else {
		$insert = "insert into posts(user_id, topic_id, post_title, post_content, image, post_date, is_public) values('$user_id','$topic','$title','$content','$post_image', NOW(), $is_public)";
		$run = mysqli_query($con, $insert);

			if($run){
				$update = "update users set posts='yes' where user_id = '$user_id'";
				$run_update = mysqli_query($con, $update);
				echo "<script>window.open('topic.php?topic=$topic','_self')</script>";
			}
		}	
	}
}


function insertHomePost(){
	if(isset($_POST['sub'])){

		global $con;
		global $user_id;
		$title = addslashes($_POST['title']);
		$content = addslashes($_POST['content']);

		$topic = $_POST['topic'];
		$is_public = $_POST['visibly'];

		$post_image = $_FILES['post_image']['name'];
		$image_tmp = $_FILES['post_image']['tmp_name'];

		move_uploaded_file($image_tmp, "user/post_images/$post_image");

		if(strlen($title)>40){
			echo "<script>alert('Title can contain maximum 38 characters!')</script>";
			echo "<script>window.open('home.php','_self')</script>";
			exit();
		}
		
		else {
		$insert = "insert into posts(user_id, topic_id, post_title, post_content, image, post_date, is_public) values('$user_id','$topic','$title','$content','$post_image', NOW(), $is_public)";
		$run = mysqli_query($con, $insert);

			if($run){
				$update = "update users set posts='yes' where user_id = '$user_id'";
				$run_update = mysqli_query($con, $update);
				echo "<script>window.open('home.php','_self')</script>";
			}
		}
	}
}


//function for displaying posts
function get_posts(){

	global $con;
	$sMyFriends = '';
	$my_friends_res = mysqli_fetch_assoc(mysqli_query($con, "SELECT friend_array FROM users WHERE user_id = ".$_SESSION['user_id']));
	$sMyFriends = $my_friends_res['friend_array'];
	$sFriendsFilter = ' ';
	if($sMyFriends != '')
	{
		$sFriendsFilter = "OR USER_ID IN (".$sMyFriends.")";
	}

	$user_id = $_SESSION['user_id'];
	$get_posts = "select * from posts WHERE is_public = 1 ".$sFriendsFilter." or user_id='$user_id' ORDER by 1 DESC";
	$run_posts = mysqli_query($con, $get_posts);

	while($row_posts = mysqli_fetch_array($run_posts)){
		$post_id = $row_posts['post_id'];
		$user_id = $row_posts['user_id'];
		$post_title = $row_posts['post_title'];
		$content = $row_posts['post_content'];
		$post_date = $row_posts['post_date'];
		$post_image = $row_posts['image'];
		$topic_id = $row_posts['topic_id'];

		//getting the topic
		$topic ="select * from topics where topic_id='$topic_id'";

		$run_topic = mysqli_query($con, $topic);
		$row_topic = mysqli_fetch_array($run_topic);
		$topic_title = $row_topic['topic_title'];

		//getting the user who has posted the thread
		$user = "select * from users where user_id='$user_id' AND posts='yes'";

		$run_user = mysqli_query($con, $user);
		$row_user = mysqli_fetch_array($run_user);
		$user_name = $row_user['user_name'];
		$user_image = $row_user['user_image'];

		$get_com = "select * from comments where post_id='$post_id'";
		$run_com = mysqli_query($con, $get_com);
		$count_com = mysqli_num_rows($run_com);

		//now displaying all at once
		echo "<div id='posts'>
		<p><img id='profile_pic' src='user/user_images/$user_image'/></p>
		<h3><a href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
		<h3>$post_title <i style='font-size:12px;' color:black; value='$topic_id'>$topic_title</i></h3>
		<i style='font-size:12px;'>$post_date</i><br>
		<p id='post_content'>$content</p>";
		if($post_image != ""){ echo "<a href='user/post_images/".$post_image."' target='_blank'>
			<img id='content_pic' style='width:100%' src='user/post_images/".$post_image."'></a>";}
		if($count_com==0){
			echo "<a class='btn btn-default' href='single.php?post_id=$post_id' style='float:right; padding:1px 5px; display:block;'><i class='fa fa-comments' aria-hidden='true'></i> Write a comment</a>
			</div><br>";}
		else{
			echo "<a class='btn btn-default' href='single.php?post_id=$post_id' style='float:right; padding:1px 5px; display:block;'><i class='fa fa-comments' aria-hidden='true'></i> View comments ($count_com)</a>
			</div><br>";
		}
	}
}


function single_post(){

	if(isset($_GET['post_id'])){

		global $con;
		$get_id = $_GET['post_id'];
		$get_posts = "select * from posts where post_id='$get_id'";
		$run_posts = mysqli_query($con, $get_posts);
		$row_posts = mysqli_fetch_array($run_posts);
		$post_id = $row_posts['post_id'];
		$user_id = $row_posts['user_id'];
		$post_title = $row_posts['post_title'];
		$content = $row_posts['post_content'];
		$post_date = $row_posts['post_date'];
		$post_image = $row_posts['image'];
		$topic_id = $row_posts['topic_id'];

		//getting the topic
		$topic ="select * from topics where topic_id='$topic_id'";

		$run_topic = mysqli_query($con, $topic);
		$row_topic = mysqli_fetch_array($run_topic);
		$topic_title = $row_topic['topic_title'];

		//getting the user who has posted the thread
		$user = "select * from users where user_id='$user_id' AND posts='yes'";
		$run_user = mysqli_query($con, $user);
		$row_user = mysqli_fetch_array($run_user);
		$user_name = $row_user['user_name'];
		$user_image = $row_user['user_image'];

		//getting the user session
		$user_com = $_SESSION['user_email'];
		$get_com = "select * from users where user_email = '$user_com'";
		$run_com  = mysqli_query($con, $get_com);
		$row_com = mysqli_fetch_array($run_com);
		$user_com_id = $row_com['user_id'];
		$user_com_name = $row_com['user_name'];							

		//now displaying all at once
		echo "<div id='posts' style='margin-bottom:10px;'>
		<p style='width:100px;'><img id='profile_pic' src='user/user_images/$user_image'/></p>
		<h3><a href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
		<h3>$post_title <i style='font-size:12px;' color:black; value='$topic_id'>$topic_title</i></h3>
		<i style='font-size:12px;'>$post_date</i><br>
		<p id='post_content'>$content</p>";
		if($post_image != ""){ echo "<a href='user/post_images/".$post_image."' target='_blank'>
			<img id='content_pic' style='width:100%' src='user/post_images/".$post_image."'></a>";}
		echo "
		</div>";
		include("comments.php");

		echo "
		<form id='reply' action='' method='POST'>
		<center><textarea class='form-control' rows='3' placeholder='Write a comment...' name='comment'></textarea></center>
		<button class='btn btn-primary' type='submit' name='reply'><i class='fa fa-comment' aria-hidden='true'></i> Comment</button>
		</form>";

		if(isset($_POST['reply'])){
			$comment = $_POST['comment'];
			$insert = "insert into comments (post_id, user_id, comment, comment_author_id, date) values ('$post_id', '$user_id', '$comment','$user_com_id', NOW())";
			$run = mysqli_query($con, $insert);
			echo "<script>window.open('single.php?post_id=$post_id', '_self')</script>";
		}
}
}

//function for getting the categories or topics
function get_Cats(){

	global $con;
	if(isset($_GET['topic'])){
		$topic_id = $_GET['topic'];
	}

	$get_posts = "select * from posts where topic_id='$topic_id' ORDER by 1 DESC";
	$run_posts = mysqli_query($con, $get_posts);

	while($row_posts = mysqli_fetch_array($run_posts)){
		$post_id = $row_posts['post_id'];
		$user_id = $row_posts['user_id'];
		$post_title = $row_posts['post_title'];
		$content = $row_posts['post_content'];
		$post_date = $row_posts['post_date'];
		$post_image = $row_posts['image'];

		//getting the user who has posted the thread
		$user = "select * from users where user_id='$user_id' AND posts='yes'";

		$run_user = mysqli_query($con, $user);
		$row_user = mysqli_fetch_array($run_user);
		$user_name = $row_user['user_name'];
		$user_image = $row_user['user_image'];

		$get_com = "select * from comments where post_id='$post_id'";
		$run_com = mysqli_query($con, $get_com);
		$count_com = mysqli_num_rows($run_com);

		//now displaying all at once
		echo "<div id='posts'>
		<p><img id='profile_pic' src='user/user_images/$user_image'/></p>
		<h3><a href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
		<h3>$post_title</h3>
		<i style='font-size:12px;'>$post_date</i><br>
		<p id='post_content'>$content</p>";
		if($post_image != ""){ echo "<a href='user/post_images/".$post_image."' target='_blank'>
			<img id='content_pic' style='width:100%' src='user/post_images/".$post_image."'></a>";}
		if($count_com==0){
		echo "<a class='btn btn-default' href='single.php?post_id=$post_id' style='float:right; padding:1px 5px; display:block;'><i class='fa fa-comments' aria-hidden='true'></i> View comments</a>
		</div><br>";}
		else{
			echo "<a class='btn btn-default' href='single.php?post_id=$post_id' style='float:right; padding:1px 5px; display:block;'><i class='fa fa-comments' aria-hidden='true'></i> View comments ($count_com)</a>
		</div><br>";
		}
	}
}


//function for getting search results
function GetResults(){

	global $con;
	if(isset($_GET['user_query'])){
		$search_term = $_GET['user_query'];
	}

	$get_user = "select * from users where user_name LIKE '%$search_term%' ORDER by 1 DESC";
	$run_user = mysqli_query($con, $get_user);
	$count_result = mysqli_num_rows($run_user);

	if($count_result == 0){
		echo "<h3>Sorry, we don't have results for that user!</h3>";
		exit();
	}

	while($row_user = mysqli_fetch_array($run_user)){

		$user_id = $row_user['user_id'];
		$user_name = $row_user['user_name'];
		$user_image = $row_user['user_image'];

		//now displaying all at once
		echo "<div class='container-fluid'>
		<p><img id='imgg' src='user/user_images/$user_image' width='50' height='50'/></p>
		<a href='user_profile.php?u_id=$user_id'>$user_name</a></div><hr>";
	}
}

					//function for displaying posts
					function user_posts(){

						global $con;
						
						$u_id = $_SESSION['user_id'];

						$get_posts = "select * from posts where user_id='$u_id' ORDER by 1 DESC";
						$run_posts = mysqli_query($con, $get_posts);

						while($row_posts = mysqli_fetch_array($run_posts)){
							$post_id = $row_posts['post_id'];
							$user_id = $row_posts['user_id'];
							$post_title = $row_posts['post_title'];
							$content = $row_posts['post_content'];
							$post_date = $row_posts['post_date'];
							$post_image = $row_posts['image'];
							$topic_id = $row_posts['topic_id'];

							//getting the topic
							$topic ="select * from topics where topic_id='$topic_id'";

							$run_topic = mysqli_query($con, $topic);
							$row_topic = mysqli_fetch_array($run_topic);
							$topic_title = $row_topic['topic_title'];

							//getting the user who has posted the thread
							$user = "select * from users where user_id='$user_id' AND posts='yes'";

							$run_user = mysqli_query($con, $user);
							$row_user = mysqli_fetch_array($run_user);
							$user_name = $row_user['user_name'];
							$user_image = $row_user['user_image'];

							$get_com = "select * from comments where post_id='$post_id'";
							$run_com = mysqli_query($con, $get_com);
							$count_com = mysqli_num_rows($run_com);

							//now displaying all at once
							echo "<div id='posts' style='margin-bottom:10px;'>
							<p style='width:100px;'><img id='profile_pic' src='user/user_images/$user_image'/></p>
							<h3><a href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
							<h3>$post_title <i style='font-size:12px;' color:black; value='$topic_id'>$topic_title</i></h3>
							<i style='font-size:12px;'>$post_date</i><br>
							<p id='post_content'>$content</p>";
							if($post_image != ""){ echo "<center><img id='content_pic' style='margin-bottom: 8px;' src='user/post_images/".$post_image."'></center>";}
							if($count_com==0){
							echo "<a class='btn btn-default' style='float:right; padding:2px 6px;' href='single.php?post_id=$post_id' style='float:right; padding:1px 5px; display:block;'><i class='fa fa-comments' aria-hidden='true'></i> View comments</a>";}
							else{
								echo "<a class='btn btn-default' style='float:right; padding:2px 6px;' href='single.php?post_id=$post_id' style='float:right; padding:1px 5px; display:block;'><i class='fa fa-comments' aria-hidden='true'></i> View comments ($count_com)</a>";
							}
							echo "
							<a href='edit_post.php?post_id=$post_id' style='float:right;'><button class='btn btn-primary'>Edit</button></a>
							<a href='functions/delete_post.php?post_id=$post_id' style='float:right;'><button class='btn btn-danger'>Delete</button></a>
							</div><br/>";
							include("delete_post.php");
						}
					}

				function user_profile(){
					new_members();
					echo "</form></div>";
				}


function new_members(){

	global $con;
	//select new members
	$user = "select * from users LIMIT 0,10";
	$run_user = mysqli_query($con,$user);
	echo "<hr><h2>New members on this site</h2><br>";
	while($row_user=mysqli_fetch_array($run_user)){
		$user_id = $row_user['user_id'];
		$user_name = $row_user['user_name'];
		$user_image = $row_user['user_image'];

		echo "<span><a href='user_profile.php?u_id=$user_id'>
		<img  src='user/user_images/$user_image' width='50' height='50' title='$user_name' style='float:left;'/></a></span>
		";
	}
}


function AddFriend($user_id)
{
	global $con;
	$friend_request_query = "INSERT INTO friend_requests (user_id_from, user_id_to) VALUES (".$_SESSION['user_id'].", ".$user_id.")";
	$res = mysqli_query($con, $friend_request_query);
	echo "<script>window.open('user_profile.php?u_id=$user_id','_self')</script>";
}


function AcceptFriend($user_id)
{
	global $con;
	$aMyFriends = array();
	$aHisFriends = array();
	$sMyFriends = "";
	$sHisFriends = "";
	$delete_request = "DELETE FROM friend_requests WHERE user_id_from = ".$user_id." AND user_id_to = ".$_SESSION['user_id'];
	$res = mysqli_query($con, $delete_request);

	$my_friends_res = mysqli_fetch_assoc(mysqli_query($con, "SELECT friend_array FROM users WHERE user_id = ".$_SESSION['user_id']));
	if($my_friends_res['friend_array'] != '')
	{
		$aMyFriends = explode(",", $my_friends_res['friend_array']);
	}

	$his_friends_res = mysqli_fetch_assoc(mysqli_query($con, "SELECT friend_array FROM users WHERE user_id = ".$user_id));
	if($his_friends_res['friend_array'] != '')
	{
		$aHisFriends = explode(",", $his_friends_res['friend_array']);
	}

	array_push($aMyFriends, $user_id);
	array_push($aHisFriends, $_SESSION['user_id']);

	$sMyFriends = implode(",", $aMyFriends);
	$sHisFriends = implode(",", $aHisFriends);

	$add_to_my_query = "UPDATE users SET friend_array = '".$sMyFriends."' WHERE user_id = ".$_SESSION['user_id'];
	$add_to_my_res = mysqli_query($con, $add_to_my_query);

	$add_to_his_query = "UPDATE users SET friend_array = '".$sHisFriends."' WHERE user_id = ".$user_id;
	$add_to_his_res = mysqli_query($con, $add_to_his_query);

	echo "<script>window.open('user_profile.php?u_id=$user_id','_self')</script>";
}


function IgnoreRequest($user_id){
	global $con;
	$aMyFriends = array();
	$aHisFriends = array();
	$sMyFriends = "";
	$sHisFriends = "";
	$delete_request = "DELETE FROM friend_requests WHERE user_id_from = ".$user_id." AND user_id_to = ".$_SESSION['user_id'];
	$res = mysqli_query($con, $delete_request);
      echo "Request Ignored!";
      echo "<script>window.open('user_profile.php?u_id=$user_id','_self')</script>";
}

function RemoveFriend($user_id)
{
	global $con;
	$aMyFriends = array();
	$aHisFriends = array();
	$sMyFriends = "";
	$sHisFriends = "";

	$my_friends_res = mysqli_fetch_assoc(mysqli_query($con, "SELECT friend_array FROM users WHERE user_id = ".$_SESSION['user_id']));
	$aMyFriends = explode(",", $my_friends_res['friend_array']);

	$his_friends_res = mysqli_fetch_assoc(mysqli_query($con, "SELECT friend_array FROM users WHERE user_id = ".$user_id));
	$aHisFriends = explode(",", $his_friends_res['friend_array']);

	$his_index = array_search($user_id, $aMyFriends);
	$my_index = array_search($_SESSION['user_id'], $aHisFriends);

	unset($aMyFriends[$his_index]);
	unset($aHisFriends[$my_index]);

	$sMyFriends = implode(",", $aMyFriends);
	$sHisFriends = implode(",", $aHisFriends);

	$my_new_list_query = "UPDATE users SET friend_array = '".$sMyFriends."' WHERE user_id = ".$_SESSION['user_id'];
	$my_new_list_res = mysqli_query($con, $my_new_list_query);

	$his_new_list_query = "UPDATE users SET friend_array = '".$sHisFriends."' WHERE user_id = ".$user_id;
	$his_new_list_res = mysqli_query($con, $his_new_list_query);
	echo "<script>window.open('user_profile.php?u_id=$user_id','_self')</script>";
}

?>