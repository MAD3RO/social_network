<?php
session_start();
if(!isset($_SESSION['user_email'])){
	header("location: index.php");
}
include("includes/connection.php");
include("functions/functionss.php");
include("user_timeline.php");

if($_SERVER['REQUEST_METHOD'] == 'POST')

?>
			<div id="content_timeline" style="margin-right: 550px;">
				<form action="topic.php?topic=<?php echo $_GET['topic'] ?>" method="post" id="f" enctype="multipart/form-data"><h3 style="margin-bottom: 5px;">What's on your mind?</h3>
				<input type="text" name="title" placeholder="Write a Title..." size="88" required="required" style="border-radius: 7px; padding: 7px; margin-bottom: 2px;"/>
				<textarea style="border-radius: 7px; padding: 7px;" cols="91" rows="4" name="content" placeholder="Write description..."></textarea>
				<button  name="sub" id="post_to_timeline" type="submit" class="btn btn-primary">Post to Timeline</button>
				<select name="visibly" id="visibly" class="btn btn-default" title="Visibility" required>
					<option value="0">Friends</option>
					<option value="1">Public</option>
				</select>
				<input style="float: left; margin-top: 3px;" id="myFileInput" name="post_image" type="file">
				<button style="float: left; padding: 3px 5px;" title="Add photos to your post" type="button" class="btn btn-default" onclick="$('#myFileInput').trigger('click');"><i class="glyphicon glyphicon-picture"></i></button></form><br>
	<?php
		insertTopicPost();
	?>
					<h3>All Posts in this Category!</h3><br>
					<div id="posts_container" style="display:flex; flex-direction:column">
					<?php get_Cats();?>
					</div>
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

