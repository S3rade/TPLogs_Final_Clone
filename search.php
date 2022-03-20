<html>
<?php
include 'connect.php';
?>
<?php
    
    if(isset($_POST['button'])){    
    
      $search=$_POST['search'];
    
      $query=mysql_query("select * from catalogs where C_OBJECTNAME like '%{$search}%'");
    
    if (mysql_num_rows($query) > 0) {
      while ($row = mysql_fetch_array($query)) {
          echo $row['C_OBJECTNAME'];
      }
    }else{
        echo "No Items Similiar Has Found<br><br>";
      }
    
    }else{                         
      $query=mysql_query("select * from catalogs");
    
      while ($row = mysql_fetch_array($query)) {
        echo $row['C_OBJECTNAME'];
      }
    }
    
    mysql_close();
    ?>

<body>

<form action="" method="post">
<input type="text" name="search">
<input type="submit" name="submit" value="Search">
</form>

</body>
