<html>
<?php 
session_start();

include "style.php";
include "connect.php";
include "taskbar.php";
include 'csrf_token.php';
include 'logging.php';
$token=generate_token();

if ($token == $_SESSION['csrf_token']){
    write_log(USER_LOGIN_LOG,'User: '.$_SESSION["Username"].' ID: '.$_SESSION["id"].' accessed '.$_SERVER['PHP_SELF'].' ');
    $token_age = time() - $_SESSION['token_time'];
    if ($token_age <= 3600) {
        $query="SELECT user.U_USERNAME, LO_BORROWER, LO_OBJECTNAME, LO_SHORTDESC, LO_IMGLINK, LO_CHARGEPERDAY, LO_COLLECTIONPOINT, LO_TIMESTAMP
        FROM lenderoutstanding
        INNER JOIN user
        ON lenderoutstanding.LO_BORROWER = user.USER_ID";
        
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
            echo '<div class="catalog">';
            echo "<h1>Items you have loaned out</h1>";
            echo "<table>"; 
            echo "<table align='center' border='1'>";
            echo "<th>Items</th><th>Borrower</th><th>Short Description</th><th>Image</th><th>Collection Point</th><th>Borrowed on</th></tr>";
            while ($row=$result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>";
                echo $row['LO_OBJECTNAME'];
                echo "</td>";
                echo "<td>";
                echo $row['U_USERNAME'];
                echo "</td>";
                echo "<td>";
                echo $row['LO_SHORTDESC'];
                echo "</td>";
                echo "<td>";
                $image=$row['LO_IMGLINK'];
                echo "<img height='150' width='200' src='img/$image'>" ;
                echo "</td>";
                echo "<td>";
                echo $row['LO_COLLECTIONPOINT'];
                echo "</td>";
                echo "<td>";
                echo $row['LO_TIMESTAMP'];
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo '<div>';
        }
        else {
            echo "0 records<br>";
        }

    }else {write_log(USER_LOGIN_LOG_ERR,$_SESSION["Username"].' ID: '.$_SESSION["id"].' tried accessing '.$_SERVER['PHP_SELF'].' ');session_destroy();header ('location: index.php');}
}else {write_log(USER_LOGIN_LOG_ERR,$_SESSION["Username"].' ID: '.$_SESSION["id"].' tried accessing '.$_SERVER['PHP_SELF'].' ');session_destroy();header ('location: index.php');}
$con->close();
?>
</html>
