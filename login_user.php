<?php
    $username_err = "Username invalid";
    $password_err = "Password invalid";
    session_start();
    include "csrf_token.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ 
            font: 14px sans-serif; 
            background-image: url('img/tplogimage.png');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size:650px 650px;
            background-position: center;
        }
        .wrapper{ 
            width: 350px; 
            padding: 20px;
            margin-top: 300px;
            margin-left:20px;
            border: solid; 
            }
        
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="User_auth.php" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo generate_token();?>" />
                <label>Username</label>
                <input type="text" name="username" required>
             
           
                <label>Password</label>
                <input type="password" name="password" required>

         
          
                <input type="submit" class="btn btn-primary" name="login" value="Login">
        </form><br>
         Admin & Staff Login Click<a href="login_Admin_Staff.php"> Here</a><br><br>
         Want to Register?<a href="registerPage.php"> Click here</a>   

    </div>    
</body>
</html>
