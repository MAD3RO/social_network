<?php
include("includes/connection.php");

if(isset($_POST['sign_up'])){
			
	// deklariranje varijabla
	$name = mysqli_real_escape_string($con, $_POST['u_name']);
	$pass = mysqli_real_escape_string($con, $_POST['u_pass']);
	$c_pass = mysqli_real_escape_string($con, $_POST['c_pass']);
	$email = mysqli_real_escape_string($con, $_POST['u_email']);
	$country = mysqli_real_escape_string($con, $_POST['u_country']);
	$gender = mysqli_real_escape_string($con, $_POST['u_gender']);
	$b_day = mysqli_real_escape_string($con, $_POST['u_birthday']); 
	$status = "unverified";
	$posts = "No";
	
	$get_email = "select * from users where user_email='$email'";
	$run_email = mysqli_query($con, $get_email);
	$check = mysqli_num_rows($run_email);

	// provjeravanje postojeće email adrese
	if($check==1){
		echo "<script>alert('Email is already registered, please try another one!')</script>";
		exit();
	}

	// postavljanje uvjeta dužine lozinke
	if(strlen($pass) && strlen($c_pass)<8){
		echo "<script>alert('Password should contain minimum 8 characters!')</script>";
		exit();
	}

	// provjeravanje identičnosti lozinke i potvrdne lozinke
	if($pass==$c_pass){
		$insert = "insert into users (user_name, user_pass, user_email, user_country, user_gender, user_b_day, user_image, register_date, status, posts) values ('$name', '$pass', '$email', '$country', '$gender', '$b_day', 'default.jpg', NOW(), '$status', '$posts')";

		$run_insert = mysqli_query($con, $insert);

		if($run_insert){
			$_SESSION['user_name']= $name;
			echo "<script>alert('Registration Successful!')</script>";
			echo "<script>window.open('home.php', '_self')</script>";
		}
	}

	else{
		echo "<h4 style='color:red;'>Password does not match the confirm password!</h4>";
	}
}
?>