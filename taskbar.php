<?php
$assign=isset($_SESSION["Roles"]);
$admin=false;
$staff=false;
$user=false;
$public=false;
if($assign){
    $assign_role=$_SESSION["Roles"];
    $admin=$assign_role === "Admin" ;
    $staff=$assign_role ==="Staff";
    $user=$assign_role ==="User";
}else{
    $public = true ;
}
if($public){

    echo "<head>";
    echo "<nav>";
    echo "<ul> ";
    echo '<li><a href="index.php">Catalog</a></li>';
    echo '<li><a href="login_user.php">Login</a></li>';
    echo '<li><a href="registerPage.php">Sign Up </a></li>';
    echo '</ul>';
    echo '</nav>';
    echo '</head>'; 
}
else{

if($admin){ 

    echo '<nav>';
    echo '<ul>';
    echo '<li><a href="index_loggedin.php">Check Catalog</a></li>';
    echo '<li><a href="add_staff.php">Manage Staff</a></li>';
    echo '<li><a href="add_admin.php">Manage Admin</a></li>';
    echo '<li><a href="logout.php">Logout</a></li>';
    echo '</ul>';
    echo '</nav>';
    }
else if ($staff){ 

    echo '<head>';
    echo '<nav>';
    echo '<ul>';
    echo '<li ><a href="approveAd.php">Approve Item</a></li>';
    echo '<li ><a href="index_loggedin.php">Check Catalog</a></li>';
    echo '<li ><a href="logout.php">Logout </a></li>';
    echo '</ul>';
    echo '</nav>';
    echo '</head>'; 
    }
else if ($user){  

        echo '<head>';
        echo "<nav>";
        echo "<ul> ";
        echo '<li ><a href="index_loggedin.php">Catalog</a></li>';
        echo '<li ><a href="useroutstanding.php">Borrowed Items</a></li>';
        echo '<li ><a href="loaned_out_items.php">Loaned Out Items</a></li>';
        echo '<li ><a>Checkout</a></li>';
        echo '<li ><a href="profile.php">My Account</a></li>';
        echo '<li ><a href="logout.php">Logout </a></li>';
        echo '</ul>';
        echo '</nav>';
        echo '</head>'; 
      }
}
?>
