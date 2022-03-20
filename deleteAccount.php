
<?php 
include 'connect.php';
include 'logging.php';
include 'csrf_token.php';
session_start();
$token=$_SESSION['csrf_token'];
?>

<?php
if ($token == $_SESSION['csrf_token'])
{ write_log(USER_LOGIN_LOG,'User: '.$_SESSION["Username"].' ID: '.$_SESSION["id"].' accessed '.$_SERVER['PHP_SELF'].' ');
  if(isset($_POST['but_delete'])){
   
    if (!empty($_REQUEST['user_id'])) {
       $user_id = $_REQUEST['user_id'];
    }

      $query = "DELETE FROM user WHERE user_id='$user_id' ";
      
      if (mysqli_query($con, $query)) {
          echo "Record updated successfully";
          write_log(USER_DELETE_LOG,'Deleted'.$user_id.'by User of'.$_SESSION["Username"].' ID: '.$_SESSION['id']);
          session_destroy();
          header ("location: login_user.php");
      }else {
        write_log(USER_DELETE_LOG_ERR,'ERROR Deleted'.$user_id.'by User of'.$_SESSION["Username"].' ID: '.$_SESSION['id']);
          echo "Error updating record: " . mysqli_error($con);
        }
  }
}else {write_log(USER_LOGIN_LOG_ERR,$_SESSION["Username"].' ID: '.$_SESSION["id_for_user"].' tried accessing '.$_SERVER['PHP_SELF'].' ');session_destroy();header ('location: index.php');}

?>
