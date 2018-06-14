<?php
	$con = mysqli_connect("localhost","root","","social_network") or die ("Connection was not established");

	if(isset($_GET['post_id'])){
		$post_id = $_GET['post_id'];
		$delete_post = "delete from posts where post_id='$post_id'";
		$run_delete = mysqli_query($con, $delete_post);
		header("Location: ../my_posts.php");
		exit();			
	}

	if(isset($_GET['comment_id'])){
		$comment_id = $_GET['comment_id'];
		$get_post = "select post_id from comments where comment_id='$comment_id'";
		$run_post = mysqli_query($con, $get_post);
		$row = mysqli_fetch_array($run_post);
		$post_id = $row['post_id'];
		$delete_comment = "delete from comments where comment_id='$comment_id'";
		$run_delete = mysqli_query($con, $delete_comment);
		header("Location: ../single.php?post_id=$post_id");
		//echo "<script>window.open('../single.php?post_id=$post_id','_self')</script>";	
	}
?>