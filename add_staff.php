<html>
<style></style>
<head>
<title>TPLOG Staff Maintenance</title>
</head>
<style>

body {font-family: Arial, Helvetica, sans-serif;
    background: }
* {box-sizing: border-box}
input[type=text], input[type=password] {
  width: 100%;
  padding: 15px;
  display: inline-block;
  border: none;
  background: #f1f1f1;
}
input[type=text]:focus, input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}
h1 {
    text-align: center;
}
table{
  border: 1px solid ;
  width: 100% ;
}
button {
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  opacity: 0.9;
}
button:hover {
  opacity:1;
}
.container {
  padding: 16px;
}
</style>
<?php
session_start();
include 'connect.php';
include 'taskbar.php';
include 'csrf_token.php';
include 'style.php';
include 'regex.php';
include 'logging.php';
$token=generate_token();
?>
<?php   
    $n=20; 
    function getName($n) { 
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz@#$&*'; 
    $randomString = ''; 
    for ($i = 0; $i < $n; $i++) { 
        $index = rand(0, strlen($characters) - 1); 
        $randomString .= $characters[$index]; 
    }
    return $randomString; 
    } 

if ($token == $_SESSION['csrf_token'])
{      write_log(ADMIN_LOGIN_LOG,'Admin: '.$_SESSION["Username"].' ID: '.$_SESSION["id"].' accessed '.$_SERVER['PHP_SELF'].' ');
       $token_age = time() - $_SESSION['token_time'];
        if ($token_age <= 3600) 
        {
            if ($_SESSION["Roles"] == "Admin")
            {
                if (isset($_POST['Submit'])&& $_POST['Submit'] ==="Submit")
                {
                  if (!empty($_POST['Username'])&& (checkusername($_POST['Username'])) &&
                      !empty($_POST['Password'])&& (checkpassword($_POST['Password'])) &&
                      !empty($_POST['NRIC'])&& (checknric($_POST['NRIC'])) &&
                      !empty($_POST['DOB'])&&
                      !empty($_POST['Email'])&& (checkemail($_POST['Email']))) 
                      { 
                            $Salt=getName($n); 
                            $hashAlgo = "sha512";
                            $password=$_POST['Password'];
                            $hashValue = hash($hashAlgo,$password.$Salt);
                            $En_hashed_password=base64_encode($hashValue);
                            $Role="Staff";
                            $Username=$_POST['Username'];
                            $Email=$_POST['Email'];
                            $NRIC=$_POST['NRIC'];
                            $En_NRIC=base64_encode($NRIC);
                            $DOB=$_POST['DOB'];
                            $query=$con->prepare("INSERT INTO `ADMIN` (`ROLES`,`A_USERNAME`,`A_NRIC`,`A_DOB`,`A_SALT`,`A_HASH`,`A_EMAIL`) VALUES (?,?,?,?,?,?,?)");
                            $query->bind_param('sssssss',$Role,$Username,$En_NRIC,$DOB,$Salt,$En_hashed_password,$Email);
                            if ($query->execute())
                            { 
                              write_log(ADMIN_ADD_LOG,'Created Staff'.$Username.'By Admin ID of'.$_SESSION["Username"].'  ');
                                echo "<script>alert('Successfully Added Staff');";
                                header("location: add_staff.php");
                            }else{
                              write_log(ADMIN_ADD_LOG_ERR,'FAILED Creating Staff '.$Username.'by Admin ID of'.$_SESSION["Username"].' ID: '.$_SESSION["id"].'  ');
                              echo "Invalid Input";
                       }
                    }     
                }
                  if(isset($_GET['Submit']) && $_GET['Submit'] === "Delete"){ 
                    $AdminU=$_GET['A_USERNAME'];
          
                    $query= $con->prepare("Delete from ADMIN where A_USERNAME = ?");
                    $query->bind_param('s', $AdminU);
                    if ($query->execute()){ 
                    write_log(ADMIN_DELETE_LOG,'Deleted Staff '.$AdminU.'by Admin Username of'.$_SESSION["Username"].' ID: '.$_SESSION["id"].'  ');
                    echo "<script>alert('Successfully Deleted Staff');";
                    header("location: add_staff.php");
                      }
                  }   
              }
    else{write_log(ADMIN_LOGIN_LOG_ERR,$_SESSION["Username"].' ID: '.$_SESSION["id"].' tried accessing '.$_SERVER['PHP_SELF'].' ');session_destroy();header ('location: login_Admin_Staff.php');}
  }else{write_log(ADMIN_LOGIN_LOG_ERR,$_SESSION["Username"].' ID: '.$_SESSION["id"].' tried accessing '.$_SERVER['PHP_SELF'].' ');session_destroy();header ('location: login_Admin_Staff.php');}
}else{write_log(ADMIN_LOGIN_LOG_ERR,$_SESSION["Username"].' ID: '.$_SESSION["id"].' tried accessing '.$_SERVER['PHP_SELF'].' ');session_destroy();header ('location: login_Admin_Staff.php');}

?>
<body>
<br><br><br><br><br>
<h1> Unauthorized Access is Strictly Prohibited! </h1>
</body>

<form action="add_staff.php" method="post">
    <table border="1">
    <tr><td>Staff Username</td><td><input type="text" name="Username" required /> </td></tr>
    <tr><td>Password</td><td><input type="text" name="Password" required /> </td></tr>
    <tr><td>NRIC</td><td><input type="text" name="NRIC" required/> </td></tr>
    <tr><td>Date of Birth</td><td><input type="text" name="DOB" value="DD-MM-YYYY" required/> </td></tr>
    <tr><td>Email</td><td><input type="text" name="Email"required/> </td></tr>
    <tr><td>
    </td><td><input type="submit" name="Submit" value="Submit"/> </td></tr>
    </table>
</form>
<?php

       $query="SELECT ADMIN_ID , A_USERNAME, A_NRIC, A_DOB, A_EMAIL FROM `admin` WHERE `ROLES` LIKE 'staff'";
       $pQuery=$con->prepare($query);
       $result=$pQuery->execute();
       $result=$pQuery->get_result();
    
       $nrows=$result->num_rows;


       if($nrows>0){
        echo "<h1>List of Staff</h1>";
        echo "<table border=1>";
        echo "<tr><td>ID</td><td>Username</td><td>NRIC</td><td>Date Of Birth</td><td>Email</td></tr>";
            while($row=$result->fetch_assoc()){
            echo "<tr><td>". $row['ADMIN_ID'] ;
            echo "</td><td>". $row['A_USERNAME'];
            $Uncen_NRIC=base64_decode($row['A_NRIC']);
            $count = strlen($Uncen_NRIC) - 5;
            $Cen_NRIC = substr_replace($Uncen_NRIC, str_repeat('*', $count), 1, $count);
            echo "</td><td>". $Cen_NRIC;
            echo "</td><td>". $row['A_DOB'];
            echo "</td><td>". $row['A_EMAIL'];
            echo "</td><td><a href='edit_staff.php?Submit=GetUpdate&ADMIN_ID=".$row['ADMIN_ID']."'>Edit</a>";
            echo "</td><td><a href='add_staff.php?Submit=Delete&A_USERNAME=".$row['A_USERNAME']."'>Delete</a>";
            echo "</td></tr>";
            }
        
        echo "</table>";
         }

      else {
        echo "<h1>No Users Found<h2>";
       }
?>
</html>
