<html>
<?php
session_start();

include "connect.php";
include "taskbar.php";
include "style.php";
include "csrf_token.php";
$token=generate_token();

if ($token == $_SESSION['csrf_token']){

    $token_age = time() - $_SESSION['token_time'];

        if($token_age <= 3600){
            $Aquery=("SELECT LO_ID FROM lenderoutstanding");
        
            $bQuery = $con->prepare($Aquery);
            $Presult=$bQuery->execute();
            $Presult=$bQuery->get_result();
            if(!$Presult) {
                die("SELECT query failed<br> ". $con->error());
            }
            else {
                echo "SELECT query successful<br>";
            }
            while ($mrow=$Presult->fetch_assoc()) {
                $lo_id=$mrow['LO_ID'];
            }

            $Showquery=("SELECT user.U_USERNAME, UO_ID, UO_LENDER, UO_OBJECTNAME, UO_SHORTDESC, UO_IMGLINK, UO_COLLECTIONPOINT, UO_CHARGEPERDAY, UO_TIMESTAMP 
            FROM useroutstandings INNER JOIN user ON UO_LENDER = USER_ID");
         
            $showpQuery = $con->prepare($Showquery);
            $result=$showpQuery->execute();
            $result=$showpQuery->get_result();
            if(!$result) {
                die("SELECT query failed<br> ". $con->error());
            }
            else {
                //echo "SELECT query successful<br>";
            }
            $nrows=$result->num_rows;
            //echo "#rows=$nrows<br>";

            if ($nrows>0) {
                echo "<h1>Items you owe</h1>";
                echo '<div class="catalog">';
                echo "<table>";
                echo "<table align='left' border='1'>";
                    echo "<tr>";
                        echo "<th>Lender</th>";
                        echo "<th>Object Name</th>";
                        echo "<th>Description</th>";
                        echo "<th>Image</th>";
                        echo "<th>Collection Point</th>";
                        echo "<th>Charge Per Day</th>";
                        echo "<th>Timestamp</th>";
                    echo "</tr>";
                    while ($row=$result->fetch_assoc()) {
                        
                        $uo_id=$row['UO_ID'];
                        $lender = $row['UO_LENDER'];
                        $objname = $row['UO_OBJECTNAME'];
                        $shortdesc = $row['UO_SHORTDESC'];
                        $collectionpoint = $row['UO_COLLECTIONPOINT'];
                        $chargeperday = $row['UO_CHARGEPERDAY'];
                        echo "<tr>";
                            echo "<td>";
                            echo $row['U_USERNAME'];
                            echo "</td>";
                            echo "<td>";
                            echo $row['UO_OBJECTNAME'];
                            echo "</td>";
                            echo "<td>";
                            echo $row['UO_SHORTDESC'];
                            echo "</td>";
                            echo "<td>";
                            $image=$row['UO_IMGLINK'];
                            echo "<img height='150' width='200' src='img/$image'>";
                            echo "</td>";
                            echo "<td>";
                            echo $row['UO_COLLECTIONPOINT'];
                            echo "</td>";
                            echo "<td>";
                            echo $row['UO_CHARGEPERDAY'];
                            echo "</td>";
                            echo "<td>";
                            echo $row['UO_TIMESTAMP'];
                            echo "</td>";
                            echo "<td>";
                            echo "<form method='post' action='useroutstanding.php'>";
                            echo "<button type='submit' name='return'>Return</button>";
                            echo "</form>";
                            echo "</td>";
                        echo "</tr>";
                                }
                echo "</table>";
                echo "</div>";
                            }
                else {
                        echo "No records available";
                    }


            if(isset($_POST['return'])){
                
                $insertpQuery="INSERT INTO `catalogs`(`C_LENDER`, `C_OBJECTNAME`, `C_SHORTDESC`, `C_IMGLINK`, `C_COLLECTIONPOINT`, `C_CHARGEPERDAY`) 
                VALUES ('$lender','$objname','$shortdesc','$image','$collectionpoint','$chargeperday')";
              
                if (mysqli_query($con, $insertpQuery)){
                    echo "Insert Query Executed";
                    echo "<script>window.location.href='useroutstanding.php'; </script>";
                }else{
                    echo "Error insert executing query.";
                }
                
            }

            if(isset($_POST['return'])){
                $sql= $con->prepare("DELETE FROM useroutstandings WHERE UO_ID = ?");
                $sql->bind_param('i', $uo_id);
                if ($sql->execute()){  
                    echo "delete from user Query Executed";
                    echo "<script>window.location.href='useroutstanding.php'; </script>";
                }else{
                    echo "Error delete executing query.";
                }
            }

            if(isset($_POST['return'])){
                $sql= $con->prepare("DELETE FROM lenderoutstanding WHERE LO_ID = ?");
                $sql->bind_param('i', $lo_id);
                if ($sql->execute()){  
                    echo "delete from lender Query Executed";
                    echo "<script>window.location.href='useroutstanding.php'; </script>";
                }else{
                    echo "Error delete executing query.";
                }
            }
        }else {write_log(USER_LOGIN_LOG_ERR,$_SESSION["Username"].' ID: '.$_SESSION["id_for_user"].' tried accessing '.$_SERVER['PHP_SELF'].' ');session_destroy();header ('location: index.php');}
}else {write_log(USER_LOGIN_LOG_ERR,$_SESSION["Username"].' ID: '.$_SESSION["id_for_user"].' tried accessing '.$_SERVER['PHP_SELF'].' ');session_destroy();header ('location: index.php');}
?>
</html>
