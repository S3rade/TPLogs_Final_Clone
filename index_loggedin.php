<html>
<?php
session_start();
include 'taskbar.php';
include 'connect.php';
include 'style.php';
include 'csrf_token.php';
include 'logging.php';
$token=generate_token();
?>
<body>
<br><br>  
<?php
if ($token == $_SESSION['csrf_token']){
    if ($_SESSION['Roles'] =='User'){write_log(USER_LOGIN_LOG,' User: '.$_SESSION["Username"].' accessed '.$_SERVER['PHP_SELF'].' ');}
    else if($_SESSION['Roles'] =='Admin'){write_log(ADMIN_LOGIN_LOG,' Admin: '.$_SESSION["Username"].' accessed '.$_SERVER['PHP_SELF'].' ');}
    else if($_SESSION['Roles'] =='Staff'){write_log(ADMIN_LOGIN_LOG,' Staff: '.$_SESSION["Username"].' accessed '.$_SERVER['PHP_SELF'].' ');}
    $token_age = time() - $_SESSION['token_time'];
    if ($token_age <= 3600) {
        
        $query="SELECT user.U_USERNAME, CAT_ID, C_LENDER, C_OBJECTNAME, C_SHORTDESC, C_IMGLINK, C_COLLECTIONPOINT, C_CHARGEPERDAY, C_TIMESTAMP 
        FROM catalogs
        INNER JOIN user
        ON catalogs.C_LENDER = user.USER_ID"; 
        $pQuery = $con->prepare($query); 
        $result=$pQuery->execute(); 
        $result=$pQuery->get_result(); 
        
        
        if(!$result) {
            die("SELECT query failed<br> ".$con->error);    
        }
        else {
            //echo "SELECT query successful<br>";
        }
        
        $nrows=$result->num_rows; 
        
        if ($nrows>0) {
            echo "<br>";
            echo '<div class="catalog">';
            echo "<table>"; 
        	echo "<table align='center' border='1'>";
            echo "<th>Items</th><th>Loaner</th><th>Short Description</th><th>Image</th><th>Collection Point</th><th>Charge per day</th><th>Listed On</th></tr>";
                while ($row=$result->fetch_assoc()) {
                $user_Id=$_SESSION['id'];
                $cat_id=$row['CAT_ID'];
                $clender=$row['C_LENDER'];
                $cobj=$row['C_OBJECTNAME'];
                $cdesc=$row['C_SHORTDESC'];
                $cimg=$row['C_IMGLINK'];
                $cpoint=$row['C_COLLECTIONPOINT'];
                $cday=$row['C_CHARGEPERDAY'];
                
                $catid = $cat_id;
                $user = $user_Id;
                $lender = $clender;
                $obj = $cobj;
                $desc = $cdesc;
                $img = $cimg;
                $point = $cpoint;
                $day = $cday;
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
                    echo "<img height='150' width='200' src='img/$image'>";
                    echo "</td>";
                    echo "<td>";
                    echo $row['C_COLLECTIONPOINT'];
                    echo "</td>";
                    echo "<td>";
                    echo $row['C_CHARGEPERDAY'];
                    echo "</td>";
                    echo "<td>";
                    echo $row['C_TIMESTAMP'];
                    echo "</td>";
                    echo "<td>";
                    echo "<form method='post' action='index_loggedin.php'>";
                    echo "<button type='submit' name='borrowItemButton'>Borrow</button>";
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
        
        
   
        if(isset($_POST['borrowItemButton'])){
            
            
            $query = "INSERT INTO useroutstandings (UO_LENDER, UO_BORROWER, UO_OBJECTNAME, UO_SHORTDESC, UO_IMGLINK, UO_CHARGEPERDAY, UO_COLLECTIONPOINT) VALUES ('$lender', '$user', '$obj', '$desc', '$img', '$day', '$point')";
            
            
            if (mysqli_query($con, $query)){
                echo "Query executed.";
                echo "<script>window.location.href='index_loggedin.php'; </script>" ;
            } else
                echo "Error executing query.";
        }
        
   
        if(isset($_POST['borrowItemButton'])){
            
            $query = "INSERT INTO lenderoutstanding (LO_LENDER, LO_BORROWER, LO_OBJECTNAME, LO_SHORTDESC, LO_IMGLINK, LO_CHARGEPERDAY, LO_COLLECTIONPOINT) VALUES ('$lender', '$user', '$obj', '$desc', '$img', '$day', '$point')";
            
            if (mysqli_query($con, $query)){
                echo "Query executed.";
                echo "<script>window.location.href='index_loggedin.php'; </script>" ;
            } else
                echo "Error executing query.";
        }

        if(isset($_POST['borrowItemButton'])){
            $query = "DELETE FROM catalogs WHERE CAT_ID = $catid";
            
            if (mysqli_query($con, $query)){
                echo "Query executed.";
                echo "<script>window.location.href='index_loggedin.php'; </script>" ;
            } else
                echo "Error executing query.";
        }
    }else {write_log(USER_LOGIN_LOG_ERR,$_SESSION["Username"].' ID: '.$_SESSION["id"].' tried accessing '.$_SERVER['PHP_SELF'].' ');session_destroy();header ('location: index.php');}
}else {write_log(USER_LOGIN_LOG_ERR,$_SESSION["Username"].' ID: '.$_SESSION["id"].' tried accessing '.$_SERVER['PHP_SELF'].' ');session_destroy();header ('location: index.php');}
        



?>
</body>
</html>
