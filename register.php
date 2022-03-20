<?php
include 'connect.php';
include 'regex.php';
?>

<?php

function generateRandomString($length = 20) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

if(isset($_POST['Submit']) && $_POST['Submit'] === "Submit"){ 
    if(!empty($_POST['U_USERNAME']) && (checkusername($_POST['U_USERNAME'])) &&
    !empty($_POST['U_EMAIL']) && (checkemail($_POST['U_EMAIL'])) &&
    !empty($_POST['U_HASH']) && (checkpassword($_POST['U_HASH'])) &&
    !empty($_POST['U_NRIC']) && (checknric($_POST['U_NRIC'])) &&
    !empty($_POST['U_DOB']) && (checkdob($_POST['U_DOB']))) {
       
     echo "OK: fields are not empty and all imputs are correct<br>";
        
    
     $hashAlgo = "sha512";
        
    
     $salt = generateRandomString();
     echo $salt;
     $password=$_POST['U_HASH'];
        
     
     $value= $password.$salt;
     $hashValue = hash($hashAlgo, $value);
     $Encode_password=base64_encode($hashValue);
        
     $role= 'User';
     $username=$_POST['U_USERNAME']; 
     $email=$_POST['U_EMAIL'];
     $Encode_nric=base64_encode($_POST['U_NRIC']);
     $dob=$_POST['U_DOB'];
        
     
     $query= $con->prepare("INSERT INTO user (`ROLES`,`U_USERNAME`,`U_NRIC`, `U_DOB`,`U_SALT`,`U_HASH`, `U_EMAIL`) VALUES  (?,?,?,?,?,?,?)");
     $query->bind_param('sssssss', $role, $username, $Encode_nric, $dob, $salt, $Encode_password, $email); 
        
       if ($query->execute()){  
          header("Location: login_user.php");
       }else{
          echo "Error executing query.";
       }
    }
    else{
        echo "Error: No fields should be empty and please input the correct data<br>";
    }

}
?>
