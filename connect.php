<?php

$db_host="localhost";
$db_user="root";
$db_pwd="";
$db_name="tplogs";

$link = mysqli_connect($db_host, $db_user, $db_pwd, $db_name);

$con = new mysqli($db_host,$db_user,$db_pwd,$db_name);
if($con->connect_errno)
{
   // echo "Unable to connect to database: ". $con->connect_error;
}else{
   // echo "Connection is successful!";
}
?>  
