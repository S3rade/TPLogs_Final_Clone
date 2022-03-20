
<?php
session_start(); 

include 'connect.php';
include 'regex.php';
include 'csrf_token.php';
include 'logging.php';

$token = generate_token();
?>

<?php

$ba_id = $_POST['ba_id'];

?>


<?php

if ($token == $_SESSION['csrf_token']){
    write_log(USER_LOGIN_LOG,'User: '.$_SESSION["Username"].' ID: '.$_SESSION["id"].' accessed '.$_SERVER['PHP_SELF'].' ');
    $token_age = time() - $_SESSION['token_time'];
    if ($token_age <= 3600) {
        
        $query = "SELECT * FROM bankaccount WHERE BA_ID = '$ba_id'";
        $result = mysqli_query($con, $query);
       
        while($row = $result->fetch_assoc()) { 
            $encodedCard = $row["BA_CARDNUM"];
            $encodedCvc = $row["BA_CVC"];
            $exp = $row["BA_EXP_DATE"];
            $nameoncard = $row["BA_CARDNAME"];

        }

        $card = base64_decode($encodedCard);
        $cvc = base64_decode($encodedCvc);

        if(isset($_POST['but_update'])){
            $new_card = $_POST['new_card'];
            $new_cvc = $_POST['new_cvc'];
            $new_exp = $_POST['new_exp'];
            $new_nameoncard = $_POST['new_nameoncard'];
            if (checkcard($new_card) && checkcvc($new_cvc) && checkexpiry($new_exp) && checkcardname($new_nameoncard)){
                $newEncodedCard = base64_encode($new_card); 
                $newEncodedCvc = base64_encode($new_cvc); 
                $query = "UPDATE bankaccount SET BA_CARDNUM='$newEncodedCard', BA_CVC='$newEncodedCvc', BA_EXP_DATE='$new_exp', BA_CARDNAME='$new_nameoncard' WHERE BA_ID='$ba_id' ";
                if (mysqli_query($con, $query)){
                     write_log(USER_ADD_CARD,'Card Successfully updating by Username of '.$_SESSION["Username"].' ID: '.$_SESSION["id"].'  ');
                    echo "Record updated successfully";
                    header("location: profile.php");
                }else {
                     write_log(USER_ADD_CARD_ERR,'FAILED updating Card by Username of '.$_SESSION["Username"].' ID: '.$_SESSION["id"].'  ');
                    echo "Error updating record: " . mysqli_error($con);
                }
            }
        }
    }else{write_log(USER_LOGIN_LOG_ERR,'User: '.$_SESSION["Username"].' ID: '.$_SESSION["id"].'tried accessing '.$_SERVER['PHP_SELF'].' ');session_destroy();header('location:login_user.php');}
}else{write_log(USER_LOGIN_LOG_ERR,'User: '.$_SESSION["Username"].' ID: '.$_SESSION["id"].'tried accessing '.$_SERVER['PHP_SELF'].' ');session_destroy();header('location:login_user.php');}
?>

<h1>Edit Card Here!</h1>
    <form action="" method="POST" >
    <label><b>Card Number</b></label><br>
    <input name="new_card"  type="text" value="<?php echo $card?>"><br>

    <label><b>CVC</b></label><br>
    <input  name="new_cvc"  type="text" value="<?php echo $cvc?>" /><br>

    <label><b>Expiry Date</b></label><br>
    <input  name="new_exp"  type="text" value="<?php echo $exp?>" /><br>

    <label><b>Name on Card</b></label><br>
    <input  name="new_nameoncard"  type="text" value="<?php echo $nameoncard?>" /><br>

    <br>
    <input type='hidden' name='ba_id' value='<?php echo $ba_id?>' />
    <button name='but_update' type="submit">Update Card!</button>
    </form>
   
