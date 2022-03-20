<html>
<style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box}

input[type=text], input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
}
input[type=text]:focus, input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}
hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 25px;
}

button {
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}
button:hover {
  opacity:1;
}

.cancelbtn {
  padding: 14px 20px;
  background-color: #f44336;
}

.cancelbtn, .signupbtn {
  float: left;
  width: 50%;
}

.container {
  padding: 16px;
}

.clearfix::after {
  content: "";
  clear: both;
  display: table;
}

@media screen and (max-width: 300px) {
  .cancelbtn, .signupbtn {
     width: 100%;
  }
}
</style>

<head>
<title>Register</title>
</head>


<body>
<form method="post" action="register.php" style="border:1px solid #ccc">
  <div class="container">
    <h1>Register for TPLogs</h1>
    <p>Please fill in this form to create an account.</p>
    <p>Already have an account? <a href="login_user.php">Login now</a>.</p>
    <hr>
    
    <label for="username"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="U_USERNAME" pattern= "^[a-zA-Z\d]+$" title="Only Letters and Numbers" required>
    
     <label for="username"><b>NRIC</b></label>
    <input type="text" placeholder="Enter NRIC" name="U_NRIC" pattern= "^[STFG]\d{7}[A-Z]$" title="Standard Singapore NRIC" required>
    
     <label for="username"><b>Date of Birth</b></label>
    <input type="text" placeholder="Enter Date of Birth" name="U_DOB" pattern= "^(0[1-9]|[12][0-9]|3[01])[- -.](0[1-9]|1[012])[- -.](19|20)\d\d$" title="dd-mm-yyyy" required>
    
    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="U_EMAIL" pattern= "^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$" title="Standard Email Format" required>
    
    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="U_HASH" pattern= "^[a-zA-Z0-9]+.{9}" title="Only Letters and Numbers with a minimum length of 10" required>   
     
    <div class="clearfix">
      <button type="button" name="Cancel" value="Cancel" class="cancelbtn">Cancel</button>
      <button type="submit" name="Submit" value="Submit" class="signupbtn">Sign Up</button>
    </div>
  </div>
</form>
</body>
</html>
