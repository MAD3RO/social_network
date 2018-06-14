<?php
session_start();

if($_GET['u_id'] == $_SESSION['user_id'])
{
	header("Location: home.php");
	exit();
}

include("includes/connection.php");
include("functions/functionss.php");
include("user_timeline.php");

?>
			<!--Content timeline starts-->
			<div id="content_timeline" class="container-fluid" style="margin-right: 565px; height: auto;">

		<?php

			if(isset($_GET['u_id'])){

					global $con;
					$userr = $_SESSION['user_email'];
					$get_user = "select * from users where user_email = '$userr'";
					$run_user  = mysqli_query($con, $get_user);
					$row = mysqli_fetch_array($run_user);
					//$user_id = $row['user_id'];
					$user = $row['user_name'];


					$user_id = $_GET['u_id'];
					$select = "select * from users where user_id='$user_id'";
					$run = mysqli_query($con, $select);
					$row = mysqli_fetch_array($run);

					$id = $row['user_id'];
					$image = $row['user_image'];
					$name = $row['user_name'];
					$country = $row['user_country'];
					$gender = $row['user_gender'];
					$register_date = $row['register_date'];

					if($gender=='Male'){
						$msg="Send him a message";
					}

					else{
						$msg="Send her a message";
					}
		?>
<?php 
$errorMsg = "";
?>

<div id='user_profile' class="container-fluid">
<div class="container-fluid">
	<h2>Info About This User</h2><hr>
	<a href="user/user_images/<?php echo $image;?>" target="_blank"><img id="prof_pic" src='user/user_images/<?php echo $image;?>'/></a>
	<p><strong>Name: </strong><?php echo $name;?></p>
	<p><strong>Gender: </strong><?php echo $gender;?></p>
	<p><strong>Country: </strong><?php echo $country;?></p>
	<p><strong>Member Since: </strong><?php echo $register_date;?></p>
	<a href='messages.php?u_id=<?php echo $id;?>'><button class='btn btn-primary' style="margin-bottom: 10px;"><i class="fa fa-envelope" aria-hidden="true"></i> <?php echo $msg;?></button></a></div>

<?php echo $errorMsg; ?>

<form action="" method="POST">
<div class="container-fluid">

<?php

if(($_SERVER['REQUEST_METHOD'] == 'POST'))
{
					

	if(isset($_POST['addfriend'])) 
	{
		AddFriend($_GET['u_id']);
	}
	else if(isset($_POST['acceptfriend']))
	{
		AcceptFriend($_GET['u_id']);
	}
	else if(isset($_POST['ignorerequest']))
	{
		IgnoreRequest($_GET['u_id']);
	}
	else if(isset($_POST['removefriend']))
	{
		RemoveFriend($_GET['u_id']);
	}
}

$user = $_GET['u_id']; 

$resFriends = mysqli_fetch_assoc(mysqli_query($con, "SELECT friend_array FROM users WHERE user_id = ".$_SESSION['user_id']));
$sFriends = $resFriends['friend_array'];
$aFriends = explode(',',$sFriends);

if (in_array($user, $aFriends)) 
{
	echo '<button class="btn btn-danger" type="submit" name="removefriend"><i class="fa fa-user-times" aria-hidden="true"></i> Unfriend</button>';
}

$my_friend_requests = array();
$my_requests_query = "select * from friend_requests where user_id_from = ".$_SESSION['user_id'];
$my_requests_res = mysqli_query($con, $my_requests_query);

while($row = mysqli_fetch_array($my_requests_res))
{
	array_push($my_friend_requests, $row['user_id_to']);
}

if(in_array($_GET['u_id'], $my_friend_requests))
{
	echo '<input class="btn btn-success" type="submit"  value="Request sent" disabled>';
}

$his_friend_requests = array();
$his_requests_query = "select * from friend_requests where user_id_from = ".$_GET['u_id'];
$his_requests_res = mysqli_query($con, $his_requests_query);

while($row = mysqli_fetch_array($his_requests_res))
{
	array_push($his_friend_requests, $row['user_id_to']);
}

if(in_array($_SESSION['user_id'], $his_friend_requests))
{
	echo '<input class="btn btn-success" type="submit" name="acceptfriend" value="Accept friend request">';
	echo '<input style="margin-left:5px;" class="btn btn-danger" type="submit" name="ignorerequest" value="Ignore">';
}

if(!in_array($user, $aFriends) && !in_array($_GET['u_id'], $my_friend_requests) && !in_array($_SESSION['user_id'], $his_friend_requests)  )
{
	echo '<button class="btn btn-success" type="submit" name="addfriend"><i class="fa fa-user-plus" aria-hidden="true"></i> Add friend</button>';	
}

?>

<hr>

<?php
	
	$aHisFriends = array();
	$sHisFriends = "";
	$user_friends_query = "select friend_array from users WHERE user_id=".$_GET['u_id'];
	$user_friends_res = mysqli_query($con,$user_friends_query);
	while($row=mysqli_fetch_array($user_friends_res))
	{
		$sHisFriends = $row['friend_array'];
		$aHisFriends = explode(",", $sHisFriends);
	}

	if($sHisFriends == "")
	{
		echo $name.' has no friends yet.';
	}
	else
	{ echo "<div style='margin-bottom: 10px;'>$name's Friends</div>";
		foreach($aHisFriends as $friend_id)
		{
			$friend_data = mysqli_fetch_assoc(mysqli_query($con, "select * from users where user_id = ".$friend_id));
			$friend_name = $friend_data['user_name'];
			$friend_img = $friend_data['user_image'];
		    echo "<a href='user_profile.php?u_id=$friend_id'><img src='user/user_images/$friend_img' title=\"$friend_name\" height='50' width='50' style='float:left;'></a>";
		}
	}
?>
</div>
				<?php user_profile();}?>

			</div>
			<!--Content timeline ends-->
		</div>
		<!--Content area ends-->
	</div>
	<!--Container ends-->

</body>
</html>
