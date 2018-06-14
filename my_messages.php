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
			<br><div id="msg" class="container-fluid">
			<p align="center"><a href="my_messages.php?inbox">My Inbox</a> || <a href="my_messages.php?sent">Sent Items</a></p><hr>

			<?php

			if (isset($_GET['msg_id']) && !isset($_GET['inbox'])) 
			{
				$msg_id = $_GET['msg_id'];
				$query = "SELECT m.msg_sub, m.msg_topic, m.reply, u.user_name as receiver_name, m.receiver as receiver_id, m.msg_date 
				FROM messages AS m 
				LEFT JOIN users AS u ON m.receiver = u.user_id
				WHERE m.msg_id = ".$msg_id." AND m.sender = ".$user_id." ";
				$result = mysqli_query($con, $query);

				$msg_sub = '';
				$msg_topic = '';
				$reply = '';
				$user_name = '';
				$msg_date = '';
				while ($row_msg=mysqli_fetch_array($result)) 
				{
					$msg_sub = $row_msg['msg_sub'];
					$msg_topic = $row_msg['msg_topic'];
					$reply = $row_msg['reply'];
					$user_name_receiver = $row_msg['receiver_name'];
					$id_receiver = $row_msg['receiver_id'];
					$msg_date = $row_msg['msg_date'];
					$my_name = mysqli_fetch_assoc(mysqli_query($con, "SELECT user_name FROM users WHERE user_id = ".$user_id));
				}
				echo '<h3>Subject: '.$msg_sub.'</h3><br/>';
				echo '<strong>'.$my_name['user_name'].'</strong>: '.$msg_topic;
				echo '<br/>';
				echo '<strong>'.$user_name_receiver.'</strong>: '.($reply  == 'no_reply' ? '-' : $reply);
			}
			?>

			<?php 
			if (isset($_GET['sent'])) {
				include("sent.php");
			}
			?>
			<?php  if(isset($_GET['inbox'])){?>
			<table width="550" class="container-fluid">
				<tr>
					<th>Sender</th>
					<th>Subject</th>
					<th>Date</th>
					<th>Reply</th>
				</tr>
		<?php
			$sel_msg = "select * from messages where receiver='$user_id' order by 1 DESC";
			$run_msg = mysqli_query($con, $sel_msg);
			$count_msg = mysqli_num_rows($run_msg);

			while ($row_msg=mysqli_fetch_array($run_msg)) {
				$msg_id = $row_msg['msg_id'];
				$msg_receiver = $row_msg['receiver'];
				$msg_sender = $row_msg['sender'];
				$msg_sub = $row_msg['msg_sub'];
				$msg_topic = $row_msg['msg_topic'];
				$msg_date = $row_msg['msg_date'];

			$get_sender = "select * from users where user_id='$msg_sender'";
			$run_sender = mysqli_query($con, $get_sender);
			$row = mysqli_fetch_array($run_sender);

			$sender_name = $row['user_name'];
		?>

				<tr align="left">
					<td><a href="user_profile.php?u_id=<?php echo $msg_sender;?>" target="blank">
					<?php echo $sender_name; ?></a></td>
					<td><a href="my_messages.php?inbox&msg_id=<?php echo $msg_id; ?>"><?php echo $msg_sub; ?></a></td>
					<td><?php echo $msg_date; ?></td>
					<td><a href="my_messages.php?inbox&msg_id=<?php echo $msg_id; ?>">Reply</a></td>
				</tr>

<?php } ?>

			</table>
				<?php
					if(isset($_GET['msg_id'])){
						$get_id = $_GET['msg_id'];
						$sel_message = "select * from messages where msg_id='$get_id'";
						$run_message = mysqli_query($con,$sel_message);
						$row_message = mysqli_fetch_array($run_message);
						$msg_subject = $row_message['msg_sub'];
						$msg_topic = $row_message['msg_topic'];
						$reply_content = $row_message['reply'];
						$sender_id = $row_message['sender'];

						$my_name = mysqli_fetch_assoc(mysqli_query($con, "SELECT user_name FROM users WHERE user_id = ".$user_id));
						$sender_namee = mysqli_fetch_assoc(mysqli_query($con, "SELECT user_name FROM users WHERE user_id = ".$sender_id));
						$sender_name = $sender_namee['user_name'];
						//updating the unread message to read
						$update_unread = "update messages set status='read' where msg_id='$get_id'";
						$run_unread = mysqli_query($con, $update_unread);

						echo "<br/><hr><h3>Subject: $msg_subject</h3>
						<br/><p style='margin-bottom:5px;'><b>$sender_name: </b>$msg_topic</p>";
						if($reply_content == 'no_reply')
						{
							echo "<form action='' method='post'><textarea cols='103' required='required' rows='4' name='reply'></textarea><br/><button style='float:right;' class='btn btn-primary' type='submit' name='msg_reply'>Reply</button>";
						}
						else
						{
							echo "<p style='margin-bottom:5px;'><b>".$my_name['user_name']."</b>: $reply_content</p>";
						}
						
					}
					if(isset($_POST['msg_reply'])){
						$user_reply = $_POST['reply'];
						$update_msg = "update messages set reply='$user_reply' where msg_id='$get_id'";
						$run_update = mysqli_query($con, $update_msg);
						echo "<h3 align='center'>Message was replied!</h3>";
						//header("Refresh:0");
						//exit();
						echo "<script>window.open('my_messages.php?inbox&msg_id=$get_id')</script>";
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
