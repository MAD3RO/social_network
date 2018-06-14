<?php

$get_id = $_GET['post_id'];
$get_com = "select * from comments where post_id='$get_id' ORDER by 1 ASC";
$run_com = mysqli_query($con, $get_com);

//getting the user who has posted the thread
$user = "select * from users where user_id='$user_id' AND posts='yes'";
$run_user = mysqli_query($con, $user);
$row_user = mysqli_fetch_array($run_user);
$user_name = $row_user['user_name'];
$user_image = $row_user['user_image'];

$get_posts = "select * from posts where post_id='$get_id'";
$run_posts = mysqli_query($con, $get_posts);
$row_posts = mysqli_fetch_array($run_posts);
$post_id = $row_posts['post_id'];
$user_id = $row_posts['user_id'];

$count_com = mysqli_num_rows($run_com);

while($row = mysqli_fetch_array($run_com)){

	$com = $row['comment'];
	$com_author_id = $row['comment_author_id'];
	$date = $row['date'];
	$comment_id = $row['comment_id'];

	$get_author_name = "select user_name from users where user_id='$com_author_id'";
	$run_get_author_name = mysqli_query($con, $get_author_name);
	$row_get_author_name = mysqli_fetch_array($run_get_author_name);
	$author_name = $row_get_author_name['user_name'];

	echo "
	<div id='comments'>
	<a href='user_profile.php?u_id=$com_author_id'><h3>$author_name</h3></a><i><span>Said</i> on $date</span> 
	<p>$com</p>";

	$get_u_id = $_SESSION['user_id'];

	$query = "SELECT user_id FROM posts WHERE user_id='$get_u_id'";
	$run_query = mysqli_query($con, $query);
	if ($com_author_id==$get_u_id || $user_id==$get_u_id){
		echo "<a href='functions/delete_post.php?comment_id=$comment_id'><button name='com_del' type='button' style='float:right; padding: 2px 6px;' class='btn btn-danger'>Delete</button></a>";
	}
	echo "</div>";
}
?>

