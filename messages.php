<?php
session_start();
if(!isset($_SESSION['user_email'])){
	header("location: index.php");
}
include("includes/connection.php");
include("functions/functionss.php");
include("user_timeline.php");

?>
			<!--Content timeline starts-->
			<div id="content_timeline" class="container-fluid" style="margin-right: 565px;">
				<?php
				if(isset($_GET['u_id'])){
						$u_id = $_GET['u_id'];
						$sel = "select * from users where user_id='$u_id'";
						$run = mysqli_query($con,$sel);
						$row = mysqli_fetch_array($run);
						$user_name = $row['user_name'];
						$user_image = $row['user_image'];
						$reg_date = $row['register_date'];
					}
			?>
				<form action="messages.php?u_id=<?php echo $u_id;?>" method="post" class="container-fluid" id="fff">
				<h3>Send a message to <span style="color: brown;"><?php echo $user_name; ?></span></h3><hr>
					<center><input style="margin-bottom: 3px;" type="text" name="msg_title" placeholder="Message Subject..." size="76" required="required">
					<textarea name="msg" cols="78" rows="5" placeholder="Message content..." required="required"></textarea><br/></center>
					<input style="float: right;" class="btn btn-primary" type="submit" name="message" value="Send"/><br>
					<img src="user/user_images/<?php echo $user_image;?>" style="border-radius: 5px;" width="100" height="100"/><br><br><br><br>
				<p style="float: left; margin-left: 10px;"><strong><?php echo $user_name;?></strong> is member of this site since: <?php echo $reg_date;?></p>
				</form><br/>
			<?php

			if(isset($_POST['message'])){
				$msg_title = $_POST['msg_title'];
				$msg = $_POST['msg'];

				$insert = "insert into messages (sender,receiver,msg_sub,msg_topic,reply,status,msg_date) values ('$user_id', '$u_id', '$msg_title', '$msg', 'no_reply', 'unread', NOW())";

				$run_insert = mysqli_query($con, $insert);
				if($run_insert){				
					//header("Refresh:0");
					//echo "<meta http-equiv=\"refresh\"content=\"0; url=messages.php?u_id=$u_id\">";
					echo "<center><h3>Message was sent to ". $user_name . " successfully</h3></center>";
				}
				else{
					echo "<center><h3>Message was not sent...</h3></center>";
				}
			}
			?>
			</div>
		</div>
		<!--Content area ends-->
	</div>
	<!--Container ends-->
</body>
</html>
