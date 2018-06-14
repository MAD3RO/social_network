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
			<div id="content_timeline" style="margin-right: 550px;">
			<?php 
				$user_posts = "select * from posts where user_id='$user_id'";
				$run_posts = mysqli_query($con, $user_posts);
				$posts = mysqli_num_rows($run_posts);

				if($posts == 0){
					echo "<h3 style='padding:10px; text-align: center; margin-left: 60px; background-color: white; border-radius: 5px; box-shadow: 1px 1px 7px rgba(0,0,0,0.6); margin-top: 10px; width: 370px; height: 50px;'>You don't have any posts!</h3>";
				}
				else{
			?>
				<h3>All of your posts</h3><br>
					<?php user_posts();}?> 
			</div>
			<!--Content timeline ends-->
		</div>
		<!--Content area ends-->
	</div>
	<!--Container ends-->
</body>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
</html>
