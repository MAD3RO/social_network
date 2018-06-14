<?php
session_start();
include("includes/connection.php");
include("functions/functionss.php");
include("user_timeline.php");

if(!isset($_SESSION['user_email'])){
	header("location: index.php");
}
else{
?>
			<div id="content_timeline" style="margin-right: 564px;">
			<?php
				if(isset($_GET['post_id'])){
					$get_id = $_GET['post_id'];
					$get_post = "select * from posts where post_id='$get_id'";
					$run_post = mysqli_query($con,$get_post);
					$row=mysqli_fetch_array($run_post);

					$post_title = $row['post_title'];
					$post_con = $row['post_content'];
				}
			?>
				<form action="" method="post" id="f" class="container-fluid" style="height: 225px; width: 525px;"><h3>Edit your post</h3><hr>
				<center><input style="padding: 3px;" type="text" name="title" value="<?php echo $post_title; ?>" size="77" required="required" />
				<textarea style="margin-top: 3px;" cols="78" rows="4" name="content"><?php echo $post_con; ?></textarea></center>
				<select name="topic" class="btn btn-default" id="topic" required>
					<option value="" style="display: none; visibility: hidden;">Topic</option>
					<?php getTopics();?>
				</select>
				<button  name="update" type="submit" class="btn btn-primary">Update Post</button></form>
				
				<?php
					if(isset($_POST['update'])){
						$title = $_POST['title'];
						$content = $_POST['content'];
						$topic = $_POST['topic'];

						$update_post = "update posts set post_title ='$title', post_content='$content', topic_id='$topic' where post_id='$get_id'";
						$run_update = mysqli_query($con, $update_post);

						if($run_update){
							echo "<script>alert('Post has been updated!')</script>";
							echo "<script>window.open('home.php','_self')</script>";
						}
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

<?php } ?>