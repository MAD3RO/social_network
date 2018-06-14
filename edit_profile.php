<?php
session_start();
if(!isset($_SESSION['user_email'])){
	header("location: index.php");
}
include("includes/connection.php");
include("functions/functionss.php");


?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome User!</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="css/bootstrapp.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css">
<link rel="stylesheet" type="text/css" href="styles/home_stylee.css?d=<?php echo time(); ?>" media="all"/>
</head>
<body>
	<!--Container starts-->
	<div class="container" class="container-fluid">
	<!--Header Wrapper Starts-->
		<div id="head_wrap" class="container-fluid">
		<!--Header Starts-->
			<div id="header" class="container-fluid">
				<ul id="menu" class="container-fluid">
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
				<form method="get" action="results.php" id="form1" class="container-fluid">
					<input type="text" name="user_query" required="required" placeholder="Search a topic"/>
					<button  name="search" class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
				</form>
			</div>
		<!--Header Ends-->
		</div>
	<!--Header Wrapper Ends-->
		<!--Content area starts-->
		<div class="content" class="container-fluid">
			<!--User timeline starts-->
			<!--Content timeline starts-->
			<div id="user_timeline" class="container-fluid">
				<div id="user_details" class="container-fluid">
					<?php
						$user = $_SESSION['user_email'];
						$get_user = "select * from users where user_email = '$user'";
						$run_user  = mysqli_query($con, $get_user);
						$row = mysqli_fetch_array($run_user);
						$user_id = $row['user_id'];
						$user_name = $row['user_name'];
						$user_pass = $row['user_pass'];
						$user_email = $row['user_email'];
						$user_country = $row['user_country'];
						$user_gender = $row['user_gender'];
						$user_image = $row['user_image'];
						$register_date = $row['register_date'];				

						$user_posts = "select * from posts where user_id='$user_id'";
						$run_posts = mysqli_query($con, $user_posts);
						$posts = mysqli_num_rows($run_posts);

						//getting the number of unread messages
						$sel_msg = "select * from messages where receiver='$user_id' AND status='unread' order by 1 ASC";
						$run_msg = mysqli_query($con, $sel_msg);
						$count_msg = mysqli_num_rows($run_msg);

						echo "<center><img src='user/user_images/$user_image' width='200' height='200'/></center><br>
						<div id='user_mention'>
						<p><strong>Name: </strong>$user_name</p>
						<p><strong>Country: </strong>$user_country</p>
						<p><strong>Member Since: </strong>$register_date</p>

						<p><a href='my_messages.php?inbox&u_id=$user_id'>Messages ($count_msg)</a></p>
						<p><a href='my_posts.php?u_id=$user_id'>My Posts ($posts)</a></p>
						<p><a href='edit_profile.php?u_id=$user_id'>Edit my account</a></p>
						<p><a href='logout.php'>Logout</a></p>
						</div>";
					?>
				</div>
			</div>
			<!--User timeline ends-->
			<div id="content_timeline" style="margin-right: 450px; margin-top: 80px;">

				<form action="" method="post" class="container-fluid" id="f" style="height: 500px; width: 520px; float:right;" enctype="multipart/form-data">

						<table>
						<tr align="center">
							<td colspan="6"><h3>Edit Your Profile</h3><hr></td>
						</tr>
						<tr>
							<td align="right">Name: </td>
							<td><input type="text" name="u_name" required="required" value="<?php echo $user_name; ?>"></td>
						</tr>

						<tr>
							<td align="right">Old Password: </td>
							<td><input type="password" name="u_pass" required="required" value=""/></td>
						</tr>

						<tr>
							<td align="right">New Password: </td>
							<td><input type="password" name="n_pass" required="required" value=""/></td>
						</tr>

						<tr>
							<td align="right">Repeat new Password: </td>
							<td><input type="password" name="nn_pass" required="required" value=""/></td>
						</tr>

						<tr>
							<td align="right">Email: </td>
							<td><input type="email" name="u_email" value="<?php echo $user_email; ?>" required="required"/></td>
						</tr>
						<tr>
							<td align="right">Country: </td>
							<td>
								<select name="u_country" disabled="disabled">
									<option><?php echo $user_country; ?></option>
									<option>Afganistan</option>
									<option>Belgia</option>
									<option>Croatia</option>
									<option>Denmark</option>
									<option>England</option>
								</select>
							</td>
						</tr>

						<tr>
							<td align="right" >Gender: </td>
							<td>
								<select disabled="disabled" name="u_gender">
										<option><?php echo $user_gender; ?></option>
										<option>Male</option>
										<option>Female</option>
								</select>
							</td>
						</tr>

						<tr>
							<td align="right">Profile Picture: </td>
							<td>
								<input type="file" name="u_image" value="<?php echo $user_image; ?>" required="required"/>
							</td>
						</tr>

						<tr align="center">
							<td colspan="6">
								<button class="btn btn-default" type="submit" name="update">Update</button>
							</td>
						</tr>
					</table>
					</form>

					<?php 
	
					if(isset($_POST['update'])){
						if($user_pass==$_POST['u_pass']){
							$n_pass = mysqli_real_escape_string($con, $_POST['n_pass']);
							$nn_pass = mysqli_real_escape_string($con, $_POST['nn_pass']);

							if(strlen($n_pass) && strlen($nn_pass)<8){
								echo "<script>alert('Password should contain minimum 8 characters!')</script>";
								exit();
							}

							if ($user_pass!=$n_pass) {
								if($n_pass==$nn_pass){
									$u_name = $_POST['u_name'];
									$u_pass = $_POST['nn_pass'];
									$u_email = $_POST['u_email'];
									$u_image = $_FILES['u_image']['name'];
									$image_tmp = $_FILES['u_image']['tmp_name'];

									move_uploaded_file($image_tmp, "user/user_images/$u_image");
									$update = "update users set user_image='$u_image', user_name='$u_name', user_pass='$u_pass', user_email='$u_email' where user_id='$user_id'";
									$run = mysqli_query($con, $update);
										if($run){
											echo "<script>alert('Your Profile is Updated!')</script>";
											echo "<script>window.open('home.php','_self')</script>";
										}
								}

								else{
									echo "<script>alert('Your two new passwords don't match!')</script>";
									echo "<h3>Your two new passwords don't match!</h3>";
								}
						}
								else{
							         echo "<script>alert('The new and old password must not be the same!')</script>";
							    }
							}
							else{
								echo "<script>alert('The old password is incorrect!')</script>";
							}
					}

					?>
			</div>
			<!--Content timeline ends-->
		</div>
		<!--Content area ends-->
	</div>
	<!--Container ends-->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
</body>
</html>
