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
        $query="SELECT C_OBJECTNAME, C_SHORTDESC, C_IMGLINK, C_COLLECTIONPOINT, C_CHARGEPERDAY, C_TIMESTAMP FROM catalogs"; 
        $pQuery = $con->prepare($query); 
        $result=$pQuery->execute(); 
        $result=$pQuery->get_result();
        
       
        if(!$result) {
            die("SELECT query failed<br> ".$con->error);    
        }
        else {
           // echo "SELECT query successful<br>";
        }
        
        $nrows=$result->num_rows; 
        
        if ($nrows>0) {
            echo "<br><br>";
            echo "<div class=outer>";
            echo "<table>"; 
        	echo "<table align='center' border='1'>";
            echo "<th>Item Name</th><th>Short Description</th><th>Image</th><th>Collection Point</th><th>Listed On</th></tr>";
                while ($row=$result->fetch_assoc()) {
                echo "<tr>";
                    echo "<td>";
                    echo $row['C_OBJECTNAME'];
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
                    echo "<a href='login_user.php'>Log In To Borrow</a>";
                    echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        else {
            echo "0 records<br>";}


?>
</div>
</body>
</html>