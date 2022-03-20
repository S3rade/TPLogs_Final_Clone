
<?php 
session_start(); 

include 'connect.php';
include 'regex.php';
include 'csrf_token.php';
include 'logging.php';


$token = generate_token();
?>

<?php

$user_id = $_POST['user_id'];

write_log(USER_LOGIN_LOG,'User: '.$_SESSION["Username"].' ID: '.$_SESSION["id"].' accessed '.$_SERVER['PHP_SELF'].' ');
?>
<?php
if ($token == $_SESSION['csrf_token']){
    write_log(USER_LOGIN_LOG,'User: '.$_SESSION["Username"].' ID: '.$_SESSION["id"].' accessed '.$_SERVER['PHP_SELF'].' ');
    $token_age = time() - $_SESSION['token_time'];
    if ($token_age <= 3600) {

        if(isset($_POST['addCardButton'])){
            $user_id = $_POST['user_id'];
       
            $card = $_POST['card'];
            $cvc = $_POST['cvc'];
            $exp = $_POST['exp'];
            $nameoncard = $_POST['nameoncard'];
         
            if (checkcard($card) && checkcvc($cvc) && checkexpiry($exp) && checkcardname($nameoncard)){
                $encodedCard = base64_encode($card); 
                $encodedCvc = base64_encode($cvc); 
                $query=$con->prepare("INSERT INTO `bankaccount`(`BA_USER`, `BA_CARDNUM`, `BA_CVC`, `BA_EXP_DATE`, `BA_CARDNAME`) 
                VALUES (?,?,?,?,?)");
                $query->bind_param('issss', $user_id, $encodedCard, $encodedCvc, $exp, $nameoncard); 
                $res= $query->execute();
                if ($res){
                    write_log(USER_ADD_CARD,'Card Successfully updating by Username of '.$_SESSION["Username"].' ID: '.$_SESSION["id"].'  ');
                    header("Location: profile.php");
                }else{
                    write_log(USER_ADD_CARD_ERR,'FAILED updating Card by Username of '.$_SESSION["Username"].' ID: '.$_SESSION["id"].'  ');
                    echo "Error executing query";
                }
            }
        }

    }else {write_log(USER_LOGIN_LOG_ERR,$_SESSION["Username"].' ID: '.$_SESSION["id"].' tried accessing '.$_SERVER['PHP_SELF'].' ');session_destroy();header ('location: index.php');}
}else {write_log(USER_LOGIN_LOG_ERR,$_SESSION["Username"].' ID: '.$_SESSION["id"].' tried accessing '.$_SERVER['PHP_SELF'].' ');session_destroy();header ('location: index.php');}

?>


<h1>Add Card Details</h1>
<form action="" method="POST" >
<label><b>Card Number</b></label><br>
<input type="text" placeholder="Enter New Card" name="card" required><br>

<label><b>CVC</b></label><br>
<input type="text" placeholder="Enter CVC" name="cvc" required><br>

<label><b>Expiry Date</b></label><br>
<input type="text" placeholder="Enter Expiry Date" name="exp" required><br>

<label><b>Name on Card</b></label><br>
<input type="text" placeholder="Enter Name on Card" name="nameoncard" required><br>

<br>
<input type='hidden' name='user_id' id='hiddenField' value='<?php echo $user_id?>' />
<button name='addCardButton' type="submit">Proceed to Add Card</button>
</form>
