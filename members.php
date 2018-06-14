<?php
session_start();
if(!isset($_SESSION['user_email'])){
	header("location: index.php");
}
include("includes/connection.php");
include("functions/functionss.php");
include("user_timeline.php");


?>
			<div id="content_timeline" class="klasa" style="margin-right: 570px; margin-top: 80px; width: auto; height: auto;">
				<center><h3>All registered users on this site</h3></center><hr>

				<?php
						$get_members = "select * from users";
						$run_members  = mysqli_query($con, $get_members);

						while($row = mysqli_fetch_array($run_members)){
						$user_id = $row['user_id'];
						$user_name = $row['user_name'];
						$user_image = $row['user_image'];

						echo "<a href='user_profile.php?u_id=$user_id'>
						<img src='user/user_images/$user_image' width='50' height='50' title='$user_name'/></a>
						";
						}
				?>
			</div>
			<!--Content timeline ends-->
		</div>
		<!--Content area ends-->
	</div>
	<!--Container ends-->

</body>
</html>
