<?php
session_start();
if(!isset($_SESSION['user_email'])){
	header("location: index.php");
}
include("includes/connection.php");
include("functions/functionss.php");
include("user_timeline.php");
?>
			<div id="content_timeline" style="margin-right: 564px;">
					<div id="posts_container" style="display:flex; flex-direction:column;">
					<?php single_post();?>
					</div>
			</div>
			<!--Content timeline ends-->
		</div>
		<!--Content area ends-->
	</div>
	<!--Container ends-->
</body>
</html>
