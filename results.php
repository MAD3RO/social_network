<?php
session_start();
if(!isset($_SESSION['user_email'])){
	header("location: index.php");
}
include("includes/connection.php");
include("functions/functionss.php");
include("user_timeline.php");

?>
			<div id="content_timeline" class="klasa" style="margin-right: 550px; margin-top: 80px; width: 400px;">
				<h4>Your result is here</h4><hr>
				<?php GetResults();?>
			</div>
			<!--Content timeline ends-->
		</div>
		<!--Content area ends-->
	</div>
	<!--Container ends-->

</body>
</html>
