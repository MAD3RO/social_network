<table width="550" class="container-fluid"> 
				<tr>
					<th>Receiver</th>
					<th>Subject</th>
					<th>Date</th>
					<th>Reply</th>
				</tr>
		<?php
			$sel_msg = "select * from messages where sender='$user_id' order by 1 DESC";
			$run_msg = mysqli_query($con, $sel_msg);
			$count_msg = mysqli_num_rows($run_msg);

			while ($row_msg=mysqli_fetch_array($run_msg)) {
				$msg_id = $row_msg['msg_id'];
				$msg_receiver = $row_msg['receiver'];
				$msg_sender = $row_msg['sender'];
				$msg_sub = $row_msg['msg_sub'];
				$msg_topic = $row_msg['msg_topic'];
				$msg_date = $row_msg['msg_date'];

			$get_receiver = "select * from users where user_id='$msg_receiver'";
			$run_receiver = mysqli_query($con, $get_receiver);
			$row = mysqli_fetch_array($run_receiver);

			$receiver_name = $row['user_name'];	
		?>
				<tr align="center">
					<td><a href="user_profile.php?u_id=<?php echo $msg_receiver;?>" target="blank">
					<?php echo $receiver_name; ?></a></td>
					<td><a href="my_messages.php?msg_id=<?php echo $msg_id; ?>"><?php echo $msg_sub; ?></a></td>
					<td><?php echo $msg_date; ?></td>
					<td><a href="my_messages.php?msg_id=<?php echo $msg_id; ?>">View Reply</a></td>
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

						//updating the unread message to read
						$update_unread = "update messages set status='read' where msg_id='$get_id'";
						$run_unread = mysqli_query($con, $update_unread);

						echo "<br/><hr><h3>Subject: $msg_subject</h3>
						<br/><p style='margin-bottom:5px;'><b>$sender_name: </b>$msg_topic</p>
						<p style='margin-bottom:5px;'><b>$user_name: </b>$reply_content</p>
						<form action='' method='post'><textarea cols='103' required='required' rows='4' name='reply'></textarea><br/><button style='float:right;' class='btn btn-primary' type='submit' name='msg_reply'>Send</button>"; 
					}
					if(isset($_POST['msg_reply'])){
						$user_reply = $_POST['reply'];
						if($reply_content!='no_reply'){
							echo "<h3 align='center'>This message was already replied!</h3>";
						}
						else{
						$update_msg = "update messages set reply='$user_reply' where msg_id='$get_id'";
						$run_update = mysqli_query($con, $update_msg);
						echo "<h3 align='center'>Message was replied!</h3>";
						header("Refresh:0");
						echo "<meta http-equiv=\"refresh\"content=\"0; url=my_messages.php?inbox&msg_id=$msg_id\">";
						}
					}
				?>