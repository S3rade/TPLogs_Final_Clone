<html>
<style>

body {font-family: Arial, Helvetica, sans-serif;
    background: }
* {box-sizing: border-box}
/* Full-width input fields */
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
/* Set a style for all buttons */
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
include 'regex.php';
include 'csrf_token.php';
include 'style.php';
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

if ($token == $_SESSION['csrf_token']){
    write_log(ADMIN_LOGIN_LOG,'Admin: '.$_SESSION["Username"].' ID: '.$_SESSION["id"].' accessed '.$_SERVER['PHP_SELF'].' ');
    $token_age = time() - $_SESSION['token_time'];
        if($token_age <= 3600){
            if($_SESSION['Roles'] == "Admin"){
                if (isset($_POST['Submit'])&& $_POST['Submit'] ==="Submit"){
                    
                    $password=$_POST['Password'];
                    $Username=$_POST['Username'];
                    $Email=$_POST['Email'];
                    $NRIC=$_POST['NRIC'];
                    $DOB=$_POST['DOB'];
                    
                    if(checkusername($Username) && checkpassword($password) && checkemail($Email) && checknric($NRIC) && checkdob($DOB)){
                        $Salt=getName($n); 
                        $hashAlgo = "sha512";
                        $hashValue = hash($hashAlgo,$password.$Salt);
                        $En_hashed_password=base64_encode($hashValue);
                        $Role="Admin";
                        $En_NRIC=base64_encode($NRIC);

                        $query=$con->prepare("INSERT INTO `ADMIN` (`ROLES`,`A_USERNAME`,`A_NRIC`,`A_DOB`,`A_SALT`,`A_HASH`,`A_EMAIL`) VALUES (?,?,?,?,?,?,?)");
                        $query->bind_param('sssssss',$Role,$Username,$En_NRIC,$DOB,$Salt,$En_hashed_password,$Email);
                        if ($query->execute()){ 
                            write_log(ADMIN_ADD_LOG,'Created Admin '.$Username.'by Admin ID of'.$_SESSION["Username"].' ID: '.$_SESSION["id"].'  ');
                            echo "<script>alert('Successfully Added Admin');";
                            header("location: add_admin.php");
                        }
                    }else{
                        write_log(ADMIN_ADD_LOG_ERR,'FAILED Creating Admin '.$Username.'by Admin ID of'.$_SESSION["Username"].' ID: '.$_SESSION["id"].'  ');
                        echo "Invalid Input";
                    }
                }
                if(isset($_GET['Submit']) && $_GET['Submit'] === "Delete"){ 
                    $AdminU=$_GET['A_USERNAME'];
                    
                    $query= $con->prepare("Delete from ADMIN where A_USERNAME = ?");
                    $query->bind_param('s', $AdminU);
                    if ($query->execute()){ 
                        write_log(ADMIN_DELETE_LOG,'Deleted Admin '.$AdminU.'by Admin Username of'.$_SESSION["Username"].' ID: '.$_SESSION["id"].'  ');
                        echo "<script>alert('Successfully Deleted Admin');";
                        header("location: add_admin.php");
                    }
                }
            }else{write_log(ADMIN_LOGIN_LOG_ERR,$_SESSION["Username"].' ID: '.$_SESSION["id"].' tried accessing '.$_SERVER['PHP_SELF'].' ');session_destroy();header ('location: login_Admin_Staff.php');}
        }else{write_log(ADMIN_LOGIN_LOG_ERR,$_SESSION["Username"].' ID: '.$_SESSION["id"].' tried accessing '.$_SERVER['PHP_SELF'].' ');echo "Session timeout";session_destroy();header ('location: login_Admin_Staff.php');}
}
else {write_log(ADMIN_LOGIN_LOG_ERR,$_SESSION["Username"].' ID: '.$_SESSION["id"].' tried accessing '.$_SERVER['PHP_SELF'].' ');session_destroy();header ('location: login_Admin_Staff.php');}
?>
<body>
<br><br><br><br><br>
<h1> Unauthorized Access is Strictly Prohibited! </h1>
</body>
<?php
echo '<form action="add_admin.php" method="post">';
echo '<table border="1">' ;
echo '<tr><td>Admin Username</td><td><input type="text" name="Username" required /> </td></tr>';
echo '<tr><td>Password</td><td><input type="text" name="Password" required/> </td></tr>';
echo '<tr><td>NRIC</td><td><input type="text" name="NRIC" required/> </td></tr>';
echo '<tr><td>Date of Birth</td><td><input type="text" name="DOB" value="DD-MM-YYYY" required/> </td></tr>';
echo '<tr><td>Email</td><td><input type="text" name="Email"required/> </td></tr>';
echo '<tr><td>';
echo '</td><td><input type="submit" name="Submit" value="Submit"/> </td></tr>';
echo '</table>';
echo '</form>';
?>
<?php

       $query="SELECT ADMIN_ID , A_USERNAME, A_NRIC, A_DOB, A_EMAIL FROM `admin` WHERE `ROLES` LIKE 'admin'";
       $pQuery=$con->prepare($query);
       $result=$pQuery->execute();
       $result=$pQuery->get_result();
    
       $nrows=$result->num_rows;

       if($nrows>0){
        echo "<h1>List of Admin</h1>";
        echo "<table border=1>";
        echo "<tr><td>ID</td><td>Username</td><td>NRIC</td><td>Date Of Birth</td><td>Email</td></tr>";
        while($row=$result->fetch_assoc())
        {
            echo "<tr><td>". $row['ADMIN_ID'] ;
            echo "</td><td>". $row['A_USERNAME'];
            $Uncen_NRIC=base64_decode($row['A_NRIC']);
            $count = strlen($Uncen_NRIC) - 5;
            $Cen_NRIC = substr_replace($Uncen_NRIC, str_repeat('*', $count), 1, $count);
            echo "</td><td>". $Cen_NRIC;
            echo "</td><td>". $row['A_DOB'];
            echo "</td><td>". $row['A_EMAIL'];
            echo "</td><td><a href='edit_admin.php?Submit=GetUpdate&ADMIN_ID=".$row['ADMIN_ID']."'>Edit</a>";
            echo "</td><td><a href='add_admin.php?Submit=Delete&A_USERNAME=".$row['A_USERNAME']."'>Delete</a>";
            echo "</td></tr>";
        }
        
        echo "</table>";
         }

      else {
        echo "<h1>No Users Found<h2>";
       }
?>
<?php

?>
</html>
