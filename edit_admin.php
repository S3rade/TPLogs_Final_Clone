<html>
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
<head>
<title>TPLOG Admin Maintenance</title>
</head>

<?php
session_start();
include 'connect.php';
include 'taskbar.php';
include 'csrf_token.php';
include 'style.php';
include 'regex.php';
include 'logging.php';
$token=generate_token();

$n=20; 
function getName($n) { 
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
$randomString = ''; 

for ($i = 0; $i < $n; $i++) { 
    $index = rand(0, strlen($characters) - 1); 
    $randomString .= $characters[$index]; 
} 

return $randomString; 
} 
if ($token == $_SESSION['csrf_token'])
{    write_log(ADMIN_LOGIN_LOG,'Admin: '.$_SESSION["Username"].' accessed '.$_SERVER['PHP_SELF'].' ');
  $token_age = time() - $_SESSION['token_time'];
    if ($token_age <= 3600) 
    {
        if ($_SESSION["Roles"]== "Admin")
        {
            if(isset($_POST['Submit']))
            {   
                if (!empty($_POST['Username'])&& (checkusername($_POST['Username'])) &&
                    !empty($_POST['Password'])&& (checkpassword($_POST['Password'])) &&
                    !empty($_POST['Email'])&& (checkemail($_POST['Email'])) &&
                    !empty($_POST['NRIC'])&& (checknric($_POST['NRIC'])) &&
                    !empty($_POST['DOB']) && (checkdob($_POST['DOB'])))    
                {
                    $AdminID=$_POST['ADMIN_ID'];
                    echo "$AdminID";
                    $Salt=getName($n); 
                    $hashAlgo = "sha512";
                    $password=$_POST['Password'];
                    $hashValue = hash($hashAlgo,$password.$Salt);
                    $En_hashed_password=base64_encode($hashValue);
                    $Username=$_POST['Username'];
                    $Email=$_POST['Email'];
                    $NRIC=$_POST['NRIC'];
                    $En_NRIC=base64_encode($NRIC);
                    $DOB=$_POST['DOB'];
    
                    $query= $con->prepare("UPDATE ADMIN SET A_USERNAME=?, A_NRIC=?, A_DOB=?, A_SALT=?, A_HASH=?, A_EMAIL=?  WHERE ADMIN_ID=? ");
                    $query->bind_param('ssssssi', $Username,$En_NRIC,$DOB,$Salt, $En_hashed_password, $Email,$AdminID);       
                    if ($query->execute()){  
                        write_log(ADMIN_UPDATE_LOG,'Updated Admin '.$Username.'By Admin Username of'.$_SESSION["Username"].'   ');
                        echo "<script>alert('Successfully Added Admin'); window.location.href='add_admin.php'; </script>";
                    }else{ 
                      write_log(ADMIN_UPDATE_LOG_ERR,'FAILED Updated Admin '.$Username.'By Admin Username of'.$_SESSION["Username"].' ID: '.$_SESSION["id"].'   ');
                        echo "<script>alert('Error Adding Admin .');</script>";
                    }
                
                }
            }
            if(isset($_GET['Submit']) && $_GET['Submit']==="GetUpdate"){
            $AdminID=$_GET['ADMIN_ID'];  
            $query="SELECT A_USERNAME, A_NRIC, A_DOB,A_EMAIL, ADMIN_ID FROM `ADMIN` WHERE ADMIN_ID=?"; 
            $pQuery = $con->prepare($query);
            $pQuery->bind_param('i', $AdminID); 
    
            $result=$pQuery->execute(); 
            $result=$pQuery->get_result(); 
       
            $nrows=$result->num_rows; 
        
                if ($row=$result->fetch_assoc()) { }
                }

        }
        else{write_log(ADMIN_LOGIN_LOG_ERR,$_SESSION["Username"].' tried accessing '.$_SERVER['PHP_SELF'].' ');session_destroy();header ('location: login_Admin_Staff.php');}
    }
    else{write_log(ADMIN_LOGIN_LOG_ERR,$_SESSION["Username"].' tried accessing '.$_SERVER['PHP_SELF'].' ');;session_destroy();header ('location: login_Admin_Staff.php');}
}
else{write_log(ADMIN_LOGIN_LOG_ERR,$_SESSION["Username"].' tried accessing '.$_SERVER['PHP_SELF'].' ');session_destroy();header ('location: login_Admin_Staff.php');}
?>
<body>
<h1> Unauthorized Access is Stritly Prohibited! </h1>
</body>

<form action="edit_admin.php" method="post">
    <table border="1">
    <tr><td>Staff Username</td><td><input type="text" name="Username" value="<?php echo $row['A_USERNAME']?>" required> </td></tr>
    <tr><td>Password</td><td><input type="text" name="Password" required></td></tr>
    <tr><td>NRIC</td><td><input type="text" name="NRIC" required> </td></tr>
    <tr><td>Date of Birth</td><td><input type="text" name="DOB" value="<?php echo $row['A_DOB']?>" required> </td></tr>
    <tr><td>Email</td><td><input type="text" name="Email" value="<?php echo $row['A_EMAIL']?>" required> </td></tr>
    <tr><td>
    <input type="hidden" name="ADMIN_ID" value="<?php echo $row['ADMIN_ID']?>" required>
    </td><td><input type="submit" name="Submit" value="Update"> </td></tr>
    </table>
<form>
<br>

<a href="add_admin.php"><input type="button" value="BACK" /></a>
</html>
