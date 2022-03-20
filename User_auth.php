<?php
session_start();

include "connect.php";
include "regex.php";
include "csrf_token.php";

if (isset($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token'])
{
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true ){
        header("location: index_loggedin.php");
        session_destroy();
    }
            if(isset($_POST['login']) == "Login"){
                $inputusername = $_POST['username'];
                $query= "SELECT USER_ID, ROLES, U_USERNAME, U_SALT, U_HASH FROM `user` WHERE U_USERNAME='$inputusername'";
                $pQuery=$con->prepare($query);
                
                $result=$pQuery->execute(); 
                $result=$pQuery->get_result(); 
            while($DB_Data=$result->fetch_assoc()){
                
                $USER_ID=$DB_Data['USER_ID'];
                $Roles=$DB_Data['ROLES'];
                $U_USERNAME=$DB_Data['U_USERNAME'];
                $U_SALT=$DB_Data['U_SALT'];
                $U_HASH=$DB_Data['U_HASH'];

                $inputpassword = $_POST['password'];
                $hashAlgo = "sha512";
                $hashValue = hash($hashAlgo,$inputpassword.$U_SALT);
                $En_pass = base64_encode($hashValue);
                $token=$_POST['token'];

                if ($En_pass === $U_HASH){
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $USER_ID;
                    $_SESSION["Roles"] = $Roles;
                    $_SESSION["Username"]= $U_USERNAME;
                   
                    header('location: index_loggedin.php');
                }else if ($En_pass !== $U_HASH){
                    echo "<script>alert('Incorrect Username or Password');document.location='login_user.php'</script>";
                }
            }
        }
}else {write_log(USER_LOGIN_LOG_ERR,$_SESSION["Username"].' ID: '.$_SESSION["id"].' tried accessing '.$_SERVER['PHP_SELF'].' ');session_destroy();header ('location: index.php');}
?>
