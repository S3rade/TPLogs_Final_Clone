<html>

<?php
session_start(); 

include 'connect.php';
include 'regex.php';
include 'taskbar.php';
include 'style.php';
include 'csrf_token.php';
include 'logging.php';

$token = generate_token(); 
?>

<title>Profile Page</title>
<h1>Welcome to your profile, Fellow User!</h1>

<?php
$user_id = $_SESSION["id"];
?>


<?php

if ($token == $_SESSION['csrf_token']){
    write_log(USER_LOGIN_LOG,'User: '.$_SESSION["Username"].' ID: '.$_SESSION["id"].' accessed '.$_SERVER['PHP_SELF'].' ');
    $token_age = time() - $_SESSION['token_time'];
    if ($token_age <= 3600) {
        $query="SELECT USER_ID, ROLES, U_USERNAME, U_HASH, U_EMAIL, U_NRIC, U_DOB FROM user WHERE USER_ID=?";
        $pQuery = $con->prepare($query);
        $pQuery->bind_param('i', $user_id);

        $result=$pQuery->execute(); 

        $pQuery->bind_result($user_id, $role, $username, $userhash, $email, $nric, $dob);

        echo "<table border=1>";
        echo "<tr><td>Username</td><td>Email</td><td>NRIC</td><td>Date of Birth</td></tr>";
        while($pQuery->fetch()){
           
            $nric = base64_decode($nric);
            $count = strlen($nric) - 5;
            $Cen_NRIC = substr_replace($nric, str_repeat('*', $count), 1, $count);
           
            echo "<tr><td>". $username. "</td><td>". $email ."</td><td>"
            . $Cen_NRIC ."</td><td>". $dob ."</td></tr>";
        }
        echo "</table>";
        ?>

     
        <h2>Bank Card Details</h2>
        
        <?php 
        $query="SELECT BA_ID, BA_USER, BA_CARDNUM, BA_CVC, BA_EXP_DATE, BA_CARDNAME, BA_AMOUNT FROM bankaccount WHERE BA_USER=?";
        $pQuery = $con->prepare($query);
        $pQuery->bind_param('i', $user_id); 

        $result=$pQuery->execute(); 

        $pQuery->bind_result($ba_id, $userId, $encodedCard, $encodedCvc, $exp, $nameoncard, $amount);

        echo "<table border=1>";
        echo "<tr><td>Card Number</td><td>Expiry Date</td><td>Name on Card</td><td>Amount</td></tr>";
        while($pQuery->fetch()){
       
            $encodedCard= base64_decode($encodedCard);
            $count = strlen($encodedCard) - 4;
            $Cen_Card = substr_replace($encodedCard, str_repeat('*', $count), 0, $count);
         
            echo "</td><td>". $Cen_Card;
            echo "</td><td>". $exp;
            echo "</td><td>". $nameoncard;
            echo "</td><td>". $amount;
            echo "</td><td>";
            echo "<form method='post' action='profile.php'>";
            echo "<input type='hidden' name='ba_id' value='$ba_id'>";
            echo "<button type='submit' name='deleteCardButton'>Delete</button>";
            echo "</form>";
            echo "<form method='post' action='updateCard.php'>";
            echo "<input type='hidden' name='ba_id' value='$ba_id'>";
            echo "<button type='submit' name='updateCardButton'>Update</button>";
            echo "</form>";
            echo"</td></tr>";

        }
        echo "</table>";

      
        if(isset($_POST['deleteCardButton'])){
            $ba_id=$_POST['ba_id'];
            
            $query = $con->prepare("DELETE FROM bankaccount WHERE BA_ID = ?");
            $query ->bind_param('i', $ba_id);
            
            if ($query->execute()){
                echo "Query executed.";
                write_log(USER_DELETE_LOG,'Deleted User'.$ba_id.' by User '.$_SESSION["Username"].' ID: '.$_SESSION["id"].'  ');
                header ("location: profile.php");
            } else
            write_log(USER_DELETE_LOG_ERR,'Deleted User'.$ba_id.' by User '.$_SESSION["Username"].' ID: '.$_SESSION["id"].'  ');
                echo "Error executing query.";
        }
        ?>

    
        <br>
        <form action='addingCard.php' method='post'>
        <input type='hidden' name='user_id' id='hiddenField' value='<?php echo $user_id?>' />
        <button type='submit' name='but_addCard'>Add a card!</button>
        </form>

        <?php


        $query = "SELECT * FROM user WHERE user_id = '$user_id'";
        $result = mysqli_query($con, $query);
        if ($result->num_rows >= 0) {

            while($row = $result->fetch_assoc()) {
                $user_name_toEdit = $row["U_USERNAME"];
                $user_email_toEdit = $row["U_EMAIL"];

            }
            } else {
            echo "0 results";
           
        }

        if(isset($_POST['but_update'])){
            $user_id = $_POST['user_id'];
            $new_username = $_POST['new_username'];
            $new_user_email = $_POST['new_email'];
            if (checkusername($new_username) && checkemail($new_user_email)){
                $query = "UPDATE user SET U_USERNAME='$new_username', U_EMAIL='$new_user_email' WHERE USER_ID='$user_id' ";
                if (mysqli_query($con, $query)){
                    write_log(USER_UPDATE_LOG,'Successfully Updated by Username of '.$_SESSION["Username"].' ID: '.$_SESSION["id"].'  ');
                    echo "Record updated successfully";
                    header("location: profile.php");
                }else {
                    write_log(USER_UPDATE_LOG_ERR,'Successfully Updated by Username of '.$_SESSION["Username"].' ID: '.$_SESSION["id"].'  ');
                    echo "Error updating record: " . mysqli_error($con);
                }
            }
        }
            ?>

            <br>
            <h2>Edit Account Here!</h2>
            <form action="" method="POST" >
            <p>Username</p>
            <input name="new_username"  type="text" value="<?php echo $user_name_toEdit?>" />
            <br>
            <p>Email</p>
            <input  name="new_email"  type="text" value="<?php echo $user_email_toEdit?>" />
            <br>
            <br>
            <input type='hidden' name='user_id' value='<?php echo $user_id?>' />
            <button name='but_update' type="submit">Update Account!</button>
            </form>

        <form action='deleteAccount.php' method='POST'>
        <input type='hidden' name='user_id'value='<?php echo $user_id?>' />
        <button type='submit' name='but_delete'>Delete Profile!</button>
        </form>


        <form action='updatePassword.php' method='post'>
        <input type='hidden' name='user_id' value='<?php echo $user_id?>' />
        <button type='submit' name='but_updatePass'>Update Password!</button>
        </form>

     

        <h2>Upload items</h2>
        <div class="box">
        <h4>Upload new item</h4>
        <form action="profile.php" method="post">
        <table>
        <tr><td>Name of item:</td><td><input type="text" name="objName" title="Only Letters and Numbers and spaces" required></td></tr>
        <tr><td>Short description:</td><td><input type="text" name="shortDesc" title="Enter a description for your item" required></td></tr>
        <tr><td>Image link:</td><td><input type="text" name="imgLink" required></td></tr>
        <tr><td>Collection Point:</td><td><input type="text" name="cPoint" title="Only Letters and Numbers and spaces" required></td></tr>
        <tr><td>Charge Per Day:</td><td><input type="text" name="cDay" title="Only Numbers"required></td></tr>
        </table>
        <br>
        <input type="submit" name="upload_request" value="Submit">
        </form>
        </div>
        <?php
               
        $query="SELECT user.U_USERNAME, CAT_ID, C_OBJECTNAME, C_SHORTDESC, C_IMGLINK, C_COLLECTIONPOINT, C_CHARGEPERDAY, C_TIMESTAMP
        FROM catalogs INNER JOIN user ON catalogs.C_LENDER = user.USER_ID
        WHERE user.USER_ID = $user_id"; 
        $pQuery = $con->prepare($query); 
        $result=$pQuery->execute(); 
        $result=$pQuery->get_result(); 
        if(!$result) {
            die("SELECT query failed<br> ".$con->error);
        }
        else {
            echo "SELECT query successful<br>";
        }
        
        $nrows=$result->num_rows; 
        if ($nrows>0) {
            echo '<div class="outer">';
            echo "<table>"; 
            echo "<table align='center' border='1'>";
            echo "<th>Items</th><th>Loaner</th><th>Short Description</th><th>Image</th><th>Collection Point</th><th>Listed On</th></tr>";
            while ($row=$result->fetch_assoc()) {
                $cat_id=$row['CAT_ID'];
                echo "<tr>";
                echo "<td>";
                echo $row['C_OBJECTNAME'];
                echo "</td>";
                echo "<td>";
                echo $row['U_USERNAME'];
                echo "</td>";
                echo "<td>";
                echo $row['C_SHORTDESC'];
                echo "</td>";
                echo "<td>";
                $image=$row['C_IMGLINK'];
                echo "<img height='150' width='200' src='img/$image'>" ;
                echo "</td>";
                echo "<td>";
                echo $row['C_COLLECTIONPOINT'];
                echo "</td>";
                echo "<td>";
                echo $row['C_TIMESTAMP'];
                echo "</td>";
                echo "<td>";
                echo "<form method='post' action='profile.php'>";
                echo "<input type='hidden' name='cat_id' value='$cat_id'>";
                echo "<button type='submit' name='deleteItemButton'>Delete</button>";
                echo "</form>";
                echo "<form method='post' action='updateItem.php'>";
                echo "<input type='hidden' name='cat_id' value='$cat_id'>";
                echo "<button type='submit' name='updateItemButton'>Update</button>";
                echo "</form>";
                echo"</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</div>";
        }
        else {
            echo "0 records<br>";
        }
        
  
        if(isset($_POST['deleteItemButton'])){
            $cat_id=$_POST['cat_id'];
            echo "$cat_id";
            $query = "DELETE FROM catalogs WHERE CAT_ID = $cat_id";
           
            
            if (mysqli_query($con, $query)){
                echo "Query executed.";
                echo "<script>window.location.href='profile.php'; </script>" ;
            } else
                echo "Error executing query.";
        }
        ?>



   
        <?php
     
        if(isset($_POST['upload_request'])=="submit"){
         
            if (!empty($_POST["objName"]) && (checkobjname($_POST['objName'])) &&
                !empty($_POST["shortDesc"]) && 
                !empty($_POST["imgLink"]) && (checkimg($_POST['imgLink'])) &&
                !empty($_POST["cPoint"]) && (checkcpoint($_POST['cPoint'])) &&
                !empty($_POST["cDay"]) && (checkcday($_POST['cDay']))){
                    echo "OK: fields are not empty<br>";
                    $objName = $_POST["objName"];
                    $shortDesc = htmlentities($_POST["shortDesc"]);
                    $imgLink = $_POST["imgLink"];
                    $cPoint = $_POST["cPoint"];
                    $cDay = $_POST["cDay"];
                
                    
                    $query= $con->prepare("INSERT INTO catalogs (C_LENDER, C_OBJECTNAME, C_SHORTDESC, C_IMGLINK, C_COLLECTIONPOINT, C_CHARGEPERDAY) VALUES (?,?,?,?,?,?)");
                    $query->bind_param('issssi', $user_id, $objName, $shortDesc, $imgLink, $cPoint, $cDay);
                    if ($query->execute()){
                     echo "<script>window.location.href='profile.php'; </script>" ;
                    }
                }
            else {
                echo "Error: Invalid input<br>";
            }
                
            
        }
        
        ?>

<?php 
    }else{write_log(USER_LOGIN_LOG_ERR,$_SESSION["Username"].' ID: '.$_SESSION["id"].' tried accessing '.$_SERVER['PHP_SELF'].' ');session_destroy();header ('location: login_user.php');}
}else{write_log(USER_LOGIN_LOG_ERR,$_SESSION["Username"].' ID: '.$_SESSION["id"].' tried accessing '.$_SERVER['PHP_SELF'].' ');session_destroy();header ('location: login_user.php');}
$con->close();
?>
</html>
