<?php
session_start();

include("includes/connection.php");
include("functions/functionss.php");
include("user_timeline.php");

?>
      <div id="content_timeline" class="friends" style="margin-right: 550px; margin-top: 80px; width: 400px;">
          <?php
        //Find Friend Requests
            $userr = $_SESSION['user_email'];
            $get_user = "select * from users where user_email = '$userr'";
            $run_user  = mysqli_query($con, $get_user);
            $row = mysqli_fetch_array($run_user);
            //$user_id = $row['user_id'];
            $user = $row['user_id'];
            $user_name = $row['user_name'];

			$aMyFriends = array();
			$sMyFriends = "";
			$user_friends_query = "select friend_array from users WHERE user_id=".$_GET['u_id'];
			$user_friends_res = mysqli_query($con,$user_friends_query);
			while($row=mysqli_fetch_array($user_friends_res))
			{
				$sMyFriends = $row['friend_array'];
				$aMyFriends = explode(",", $sMyFriends);
			}

			if($sMyFriends == "")
			{
				echo $user_name.' has no friends yet.';
			}
			else
			{ echo "<h3>$user_name's Friends</h3><hr>";
				foreach($aMyFriends as $friend_id)
				{
					$friend_data = mysqli_fetch_assoc(mysqli_query($con, "select * from users where user_id = ".$friend_id));
					$friend_name = $friend_data['user_name'];
					$friend_img = $friend_data['user_image'];
				    echo "<div class='container-fluid'><a href='user_profile.php?u_id=$friend_id'><img src='user/user_images/$friend_img' title=\"$friend_name\" height='50' width='50' style='float:left; margin-right:5px;'></a><a href='user_profile.php?u_id=$friend_id'>$friend_name</a></div><hr>";
				}
			}
           ?>
         </div>
     
        </div>
      </div>
      <!--Content timeline ends-->
    </div>
    <!--Content area ends-->
  </div>
  <!--Container ends-->
</body>
</html>
