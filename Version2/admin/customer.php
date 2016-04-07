<?php 
session_start();
if (!isset($_SESSION["login"])) {
  header("location: login.php"); 
  exit();
}
// Check SESSION values are in database
$id = $_SESSION["id"]; 
$login = $_SESSION["login"]; 
$password = $_SESSION["password"];
// Double check admin identity by querying again with admin id 
include "../scripts/mysql_connect.php"; 
$sql = mysql_query("SELECT * FROM admin WHERE id='$id' AND login='$login' AND password='$password' LIMIT 1"); 
$existCount = mysql_num_rows($sql); 
if ($existCount == 0) { 
  echo "Your login information does not exist in database";
  exit();
}
?>

<?php
//Delete customer 
if (isset($_GET['deleteid'])) {
  echo 'Do you really want to delete customer with ID of ' . $_GET['deleteid'] . '? <a href="customer.php?yesdelete=' . 
  $_GET['deleteid'] . '">Yes</a> | <a href="customer.php">No</a>';
  exit();
}
if (isset($_GET['yesdelete'])) {
	$id_to_delete = $_GET['yesdelete'];
	$sql = mysql_query("DELETE FROM customers WHERE id='$id_to_delete' LIMIT 1") or die (mysql_error());
	header("location: customer.php"); 
}
?>

<?php 
// List all customers
$customer_list = "";
$sql = mysql_query("SELECT * FROM customers");
$existCount = mysql_num_rows($sql); 
if ($existCount > 0) {
  while($row = mysql_fetch_array($sql)){ 
    $id = $row["id"];
    $first = $row["first"];
    $last = $row["last"];
    $login = $row["login"];
    $password = $row["password"];
    $email = $row["email"];
	$customer_list .= 
	  "Customer ID: $id<br> 
	  Customer name: $first $last<br>
	  Customer login: $login<br>
	  Customer email: $email<br>
	  <a href='customer.php?deleteid=$id'>delete customer</a><br>";
  }
} 
else {
  $customer_list = "There is no customer in database";
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Customer List</title>
    <link rel="stylesheet" href="../style/style.css" type="text/css">
  </head>

  <body>
    <?php include_once("header.php"); ?> 
    <?php echo $customer_list; ?>
    <?php include_once("footer.php"); ?>
  </body>
</html>