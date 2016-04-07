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
//Delete order_item 
if (isset($_GET['deleteid'])) {
  echo 'Do you really want to delete order with ID of ' . $_GET['deleteid'] . '? <a href="order_item.php?yesdelete=' . 
  $_GET['deleteid'] . '">Yes</a> | <a href="order_item.php">No</a>';
  exit();
}
if (isset($_GET['yesdelete'])) {
	$id_to_delete = $_GET['yesdelete'];
	$sql = mysql_query("DELETE FROM order_items WHERE id='$id_to_delete' LIMIT 1") or die (mysql_error());
	header("location: order_item.php"); 
}
?>

<?php 
// List all orders
$order_items_list = "";
$sql = mysql_query("SELECT * FROM order_items");
$existCount = mysql_num_rows($sql); 
if ($existCount > 0) {
  while($row = mysql_fetch_array($sql)){ 
    $id = $row["id"];
    $order_id = $row["order_id"];
    $product_id = $row["product_id"];
    $quantity = $row["quantity"];
	  $order_items_list .= 
	  "Order_item ID: $id<br>
    Order ID: $order_id<br>
    Product ID: $product_id<br>
    Quantity: $quantity<br><br>";
  }
} 
else {
  $order_items_list = "There is no order in database";
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Order_Items List</title>
    <link rel="stylesheet" href="../style/style.css" type="text/css">
  </head>

  <body>
    <?php include_once("header.php"); ?> 
    <?php echo $order_items_list; ?>
    <?php include_once("footer.php"); ?>
  </body>
</html>