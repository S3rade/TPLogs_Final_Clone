
<?php 
session_start(); 

include 'connect.php';
include 'regex.php';
include 'csrf_token.php';
include 'logging.php';

$token = generate_token();
?>

<?php

$cat_id = $_POST['cat_id'];

?>


<?php

if ($token == $_SESSION['csrf_token']){
    write_log(USER_LOGIN_LOG,'User: '.$_SESSION["Username"].' ID: '.$_SESSION["id"].' accessed '.$_SERVER['PHP_SELF'].' ');
    $token_age = time() - $_SESSION['token_time'];
    if ($token_age <= 3600) {
       
        $query = "SELECT * FROM catalogs WHERE CAT_ID = '$cat_id'";
        $result = mysqli_query($con, $query);
       
        while($row = $result->fetch_assoc()) { 
            $objectName = $row["C_OBJECTNAME"];
            $desc = $row["C_SHORTDESC"];
            $imgLink = $row["C_IMGLINK"];
            $cPoint = $row["C_COLLECTIONPOINT"];
            $cDay = $row["C_CHARGEPERDAY"];
        }

        if(isset($_POST['but_updateItem'])){
            $new_objectName = $_POST['new_objectName'];
            $new_desc = htmlentities($_POST['new_desc']);
            $new_link = $_POST['new_link'];
            $new_point = $_POST['new_point'];
            $new_day = $_POST['new_day'];
            if (checkobjname($new_objectName) && checkimg($new_link) && checkcpoint($new_point) && checkcday($new_day)){
                $query = "UPDATE catalogs SET C_OBJECTNAME='$new_objectName', C_SHORTDESC='$new_desc', C_IMGLINK='$new_link', C_COLLECTIONPOINT='$new_point',
                C_CHARGEPERDAY='$new_day' WHERE CAT_ID='$cat_id' ";
                if (mysqli_query($con, $query)){
                     write_log(USER_UPDATECAT_LOG,'Item Successfully updated by Username of '.$_SESSION["Username"].' ID: '.$_SESSION["id"].'  ');
                    echo "Record updated successfully";
                    header("location: profile.php");
                }else {
                     write_log(USER_UPDATECAT_LOG_ERR,'FAILED updated Item by Username of '.$_SESSION["Username"].' ID: '.$_SESSION["id"].'  ');
                    echo "Error updating record: " . mysqli_error($con);
                }
            }
        }
    }else{write_log(USER_LOGIN_LOG_ERR,'User: '.$_SESSION["Username"].' ID: '.$_SESSION["id"].'tried accessing '.$_SERVER['PHP_SELF'].' ');session_destroy();header('location:login_user.php');}
}else{write_log(USER_LOGIN_LOG_ERR,'User: '.$_SESSION["Username"].' ID: '.$_SESSION["id"].'tried accessing '.$_SERVER['PHP_SELF'].' ');session_destroy();header('location:login_user.php');}
?>

<h1>Edit Item Here!</h1>
    <form action="" method="POST" >
    <label><b>Item Name</b></label><br>
    <input name="new_objectName"  type="text" value="<?php echo $objectName?>"><br>

    <label><b>Short Description</b></label><br>
    <input  name="new_desc"  type="text" value="<?php echo $desc?>" /><br>

    <label><b>Image Link</b></label><br>
    <input  name="new_link"  type="text" value="<?php echo $imgLink?>" /><br>

    <label><b>Collection Point</b></label><br>
    <input  name="new_point"  type="text" value="<?php echo $cPoint?>" /><br>

    <label><b>Charge per day</b></label><br>
    <input  name="new_day"  type="text" value="<?php echo $cDay?>" /><br>


    <br>
    <input type='hidden' name='cat_id' value='<?php echo $cat_id?>' />
    <button name='but_updateItem' type="submit">Update Item!</button>
    </form>
   
