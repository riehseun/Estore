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
//Delete order 
if (isset($_GET['deleteid'])) {
  echo 'Do you really want to delete order with ID of ' . $_GET['deleteid'] . '? <a href="order.php?yesdelete=' . 
  $_GET['deleteid'] . '">Yes</a> | <a href="order.php">No</a>';
  exit();
}
if (isset($_GET['yesdelete'])) {
	$id_to_delete = $_GET['yesdelete'];
	$sql = mysql_query("DELETE FROM orders WHERE id='$id_to_delete' LIMIT 1") or die (mysql_error());
	header("location: order.php"); 
}
?>

<?php 
// List all orders
$order_list = "";
$sql = mysql_query("SELECT * FROM orders");
$existCount = mysql_num_rows($sql); 
if ($existCount > 0) {
  while($row = mysql_fetch_array($sql)){ 
    $id = $row["id"];
    $customer_id = $row["customer_id"];
    $order_date = $row["order_date"];
    $order_time = $row["order_time"];
    $total = $row["total"];
	  $order_list .= 
	  "Order ID: $id<br> 
	  Customer ID: $customer_id<br>
    Order date: $order_date<br>
    Order time: $order_time<br>
    Total: $$total<br>
	  <a href='order.php?deleteid=$id'>delete order</a><br>";
  }
} 
else {
  $order_list = "There is no order in database";
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Order List</title>
    <link rel="stylesheet" href="../style/style.css" type="text/css">
  </head>

  <body>
    <?php include_once("header.php"); ?> 
    <?php echo $order_list; ?>
    <?php include_once("footer.php"); ?>
  </body>
</html>