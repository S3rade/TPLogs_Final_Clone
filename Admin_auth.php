<?php
session_start();
include "connect.php";
include 'csrf_token.php';
if (isset($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token'])
{
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true ){
    header("location: welcome.php");
    session_destroy();
    }

 

    if(isset($_POST['login']) == "Login")
    {
        $inputusername = $_POST['username'];
        $query= "SELECT ADMIN_ID, ROLES, A_USERNAME, A_SALT, A_HASH FROM `ADMIN` WHERE A_USERNAME='$inputusername'";
        $pQuery=$con->prepare($query);
    
        $result=$pQuery->execute(); 
        $result=$pQuery->get_result(); 
        while($DB_Data=$result->fetch_assoc())
        {
    
            $Admin_ID=$DB_Data['ADMIN_ID'];
            $Roles=$DB_Data['ROLES'];
            $A_USERNAME=$DB_Data['A_USERNAME'];
            $A_SALT=$DB_Data['A_SALT'];
            $A_HASH=$DB_Data['A_HASH'];

            $inputpassword = $_POST['password'];
            $hashAlgo = "sha512";
            $hashValue = hash($hashAlgo,$inputpassword.$A_SALT);
            $En_pass = base64_encode($hashValue);

            if($En_pass === $A_HASH)
            {
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $Admin_ID;
                $_SESSION["Roles"] = $Roles;
                $_SESSION["Username"]= $A_USERNAME;
              
                header('location: index_loggedin.php');
            }
            else if ($En_pass !== $A_HASH)
            {
              
                echo "<script>alert('Error Username or Password is Incorrect');</script>";
                header('location:login_Admin_Staff.php');
            }
        }

    }
}else {write_log(ADMIN_LOGIN_LOG,$_SESSION["Username"].' ID: '.$_SESSION["id"].' tried accessing '.$_SERVER['PHP_SELF'].' ');session_destroy();header ('location: index.php');}

?>
