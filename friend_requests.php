<?php
session_start();

include("includes/connection.php");
include("functions/functionss.php");
include("user_timeline.php");

?>
      <div id="content_timeline" class="friend_req" style="margin-right: 550px; margin-top: 80px;">
          <?php
        //Find Friend Requests
            $userr = $_SESSION['user_email'];
            $get_user = "select * from users where user_email = '$userr'";
            $run_user  = mysqli_query($con, $get_user);
            $row = mysqli_fetch_array($run_user);
            //$user_id = $row['user_id'];
            $user = $row['user_id'];

            $friendRequests = "select * from friend_requests where user_id_to='$user'";
            $run_friendRequests = mysqli_query($con, $friendRequests);
            $user_to = $user;

            $numrows = mysqli_num_rows($run_friendRequests);
            echo "<h4>Friend Requests</h4><hr>";

            if ($numrows == 0) {
             echo "<h3 style='padding:5px; text-align:center; height: 20px;'>You have no friend Requests at this time.</h3><br>";
             $user_from = "";
            }

            else{
              while ($get_row = mysqli_fetch_array($run_friendRequests)) {
              $id = $get_row['id']; 
              $user_to = $get_row['user_id_to'];
              $user_from = $get_row['user_id_from'];

               $getFriendQuery = "select * from users where user_id='$user_from'";
               $run_getFriendQuery = mysqli_query($con, $getFriendQuery);
               $getFriendRow = mysqli_fetch_array($run_getFriendQuery);
               $friendProfilePic = $getFriendRow['user_image'];
               $user_from_name = $getFriendRow['user_name'];
                 
               echo "<div class='container-fluid'><img id='imgg' src='user/user_images/$friendProfilePic' title='$user_from_name''><p>" . $user_from_name . " wants to be friends.</p>";

                  if (isset($_POST['acceptrequest'. $user_from])) {
                      //Get friend array for logged in user
                   $get_friend_check = "select friend_array from users where user_id='$user_to'";
                    $run_get_friend_check = mysqli_query($con, $get_friend_check);
                    $get_friend_row = mysqli_fetch_array($run_get_friend_check);
                    $friend_array = $get_friend_row['friend_array'];
                    $friendArray_explode = explode(",",$friend_array);
                    $friendArray_count = count($friendArray_explode);

                    //Get friend array for person who sent request
                    $get_friend_check_friend = "select friend_array from users where user_id='$user_from'";
                    $run_get_friend_check_friend = mysqli_query($con, $get_friend_check_friend);
                    $get_friend_row_friend = mysqli_fetch_array($run_get_friend_check_friend);
                    $friend_array_friend = $get_friend_row_friend['friend_array'];
                    $friendArray_explode_friend = explode(",",$friend_array_friend);
                    $friendArray_count_friend = count($friendArray_explode_friend);

                    if ($friend_array == "") {
                       $friendArray_count = count(NULL);
                    }
                    if ($friend_array_friend == "") {
                       $friendArray_count_friend = count(NULL);
                    }
                    if ($friendArray_count == NULL) {
                      $add_friend_query = "update users set friend_array=concat(friend_array,'$user_from') where user_id = '$user'";
                      $run_add_friend_query = mysqli_query($con, $add_friend_query);
                    }
                    if ($friendArray_count_friend == NULL) {
                      $add_friend_query = "update users set friend_array=concat(friend_array,'$user_to') where user_id = '$user_from'";
                      $run_add_friend_query = mysqli_query($con, $add_friend_query);
                    }
                    if ($friendArray_count >= 1) {
                      $add_friend_query = "update users set friend_array=concat(friend_array,',$user_from') where user_id = '$user'";
                      $run_add_friend_query = mysqli_query($con, $add_friend_query);
                    }
                    if ($friendArray_count_friend >= 1) {
                      $add_friend_query = "update users set friend_array=concat(friend_array,',$user_to') where user_id = '$user_from'";
                      $run_add_friend_query = mysqli_query($con, $add_friend_query);
                    }
                    $delete_request = "delete from friend_requests where user_id_to = '$user_to' && user_id_from = '$user_from'";
                    $run_delete_request = mysqli_query($con, $delete_request);
                    echo "You are now friends!";
                    echo "<script>window.open('friend_requests.php','_self')</script>";
                  }

                  if (isset($_POST['ignorerequest'.$user_from])) {
                    $ignore_request = "delete from friend_requests where user_id_to = '$user_to' && user_id_from = '$user_from'";
                    $run_ignore_request = mysqli_query($con, $ignore_request);
                      echo "Request Ignored!";
                      echo "<script>window.open('friend_requests.php','_self')</script>";
                  }
                ?>
          <form action="friend_requests.php" style="float: right;" method="POST">
            <input style="" class="btn btn-success" type="submit" name="acceptrequest<?php echo $user_from; ?>" value="Confirm">
            <input class="btn btn-danger" type="submit" name="ignorerequest<?php echo $user_from; ?>" value="Ignore">
          </form></div><hr>
<?php 
  }
  }
?>      
        </div>
      </div>
      <!--Content timeline ends-->
    </div>
    <!--Content area ends-->
  </div>
  <!--Container ends-->

</body>
</html>
