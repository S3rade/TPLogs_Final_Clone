<html>

<?php

function generateRandomString($length = 20) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
session_start(); 
include 'connect.php';
include 'regex.php';
include 'csrf_token.php';
include "logging.php";
$token=generate_token(); 
write_log(USER_LOGIN_LOG,'User: '.$_SESSION["Username"].' ID: '.$_SESSION["id"].' accessed '.$_SERVER['PHP_SELF'].' ');

$user_id = $_POST['user_id'];

$query = "SELECT * FROM user WHERE user_id = '$user_id'";
$result = mysqli_query($con, $query);
while($row = $result->fetch_assoc()) {
    $salt = $row["U_SALT"]; 
    $dbhash = $row["U_HASH"]; 
}

$dbhash = base64_decode($dbhash); 
?>


<h1>Edit Password Here!</h1>
    <form action="" method="POST" >
    <label><b>Old Password</b></label><br>
    <input type="password" placeholder="Enter Old Password" name="oldPass" required><br>

    <label><b>New Password</b></label><br>
    <input type="password" placeholder="Enter New Password" name="newPass" required><br>

    <label><b>Confirm New Password</b></label><br>
    <input type="password" placeholder="Confirm New Password" name="confirmPass" required><br>

    <br>
    <input type='hidden' name='user_id' id='hiddenField' value='<?php echo $user_id?>' />
    <button name='updateButton' type="submit">Update Password</button>
    </form>
<?php

if ($token == $_SESSION['csrf_token']){

    $token_age = time() - $_SESSION['token_time'];

        if($token_age <= 3600){

            if($_SESSION['Roles'] == "User"){
               
                if (isset($_POST['updateButton'])){
                    
                    $oldPass = $_POST['oldPass'];
                    $newPass = $_POST['newPass'];
                    $confirmPass = $_POST['confirmPass'];
                   
                    $saltedOldPass = $oldPass.$salt;
                    $hashOldPass = hash("sha512", $saltedOldPass);
                    if ($hashOldPass == $dbhash){ 
                        if($newPass == $confirmPass){ 
                            if (checkpassword($newPass) && checkpassword($confirmPass)){
                                
                            $newSalt = generateRandomString();
                            $saltedNewPass = $newPass.$newSalt; 
                            $hashNewPass = hash("sha512", $saltedNewPass); 
                            $encodedNewPass = base64_encode($hashNewPass); 

                            $query = "UPDATE user SET U_SALT='$newSalt', U_HASH='$encodedNewPass' WHERE USER_ID='$user_id'";
                                if (mysqli_query($con, $query)) {
                                    write_log(USER_UPDATE_LOG,'User '.$Username.' Password successfully updated User ID of'.$_SESSION["Username"].' ID: '.$_SESSION["id"].'  ');
                                    echo "Record updated successfully";
                                    header("location: profile.php");
                                }else {
                                    write_log(USER_UPDATE_LOG_ERR,'User '.$Username.' Password successfully updated User ID of'.$_SESSION["Username"].' ID: '.$_SESSION["id"].'  ');
                                    echo "Error updating record: " . mysqli_error($con);
                                    }
                            }
                            else{
                               
                                echo "Invalid after regex";
                            }
                        }
                        else {
                            
                            echo "Not confirmed password";
                        }
                    } 
                    else {
                      
                        echo "Invalid oldpassword";
                    }
                }
            }else {write_log(USER_LOGIN_LOG_ERR,$_SESSION["Username"].' ID: '.$_SESSION["id"].' tried accessing '.$_SERVER['PHP_SELF'].' ');session_destroy();header ('location: index.php');}
        }else {write_log(USER_LOGIN_LOG_ERR,$_SESSION["Username"].' ID: '.$_SESSION["id"].' tried accessing '.$_SERVER['PHP_SELF'].' ');session_destroy();header ('location: index.php');}
}
else {write_log(USER_LOGIN_LOG_ERR,$_SESSION["Username"].' ID: '.$_SESSION["id"].' tried accessing '.$_SERVER['PHP_SELF'].' ');session_destroy();header ('location: index.php');}

?>
</html>
