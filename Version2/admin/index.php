<?php 
session_start();
if (!isset($_SESSION["login"])) {
    header("location: login.php"); 
    exit();
}
// Check SESSION values are in database
$id = $_SESSION["id"]; // filter everything but numbers and letters
$login = $_SESSION["login"]; // filter everything but numbers and letters
$password = $_SESSION["password"]; // filter everything but numbers and letters
// Double check admin identity by querying again with admin id 
include "../scripts/mysql_connect.php"; 
$sql = mysql_query("SELECT * FROM admin WHERE id='$id' AND login='$login' AND password='$password' LIMIT 1"); 
$existCount = mysql_num_rows($sql); 
if ($existCount == 0) { 
  echo 'Your login information does not exist in database <a href="logout.php">Click</a>';
  exit();
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Administrator's Page</title>
    <link rel="stylesheet" href="../style/style.css" type="text/css">
  </head>

  <body>
    <?php include_once("header.php"); ?>
    <div id="content">
      <h2>Hello Administrator</h2>
      <p>
        <a href="product.php">View Products</a><br>
        <a href="add.php">Manage Inventory</a><br>
        <a href="customer.php">Manage Customers</a><br>
        <a href="order.php">Manage Orders</a><br>
        <a href="order_item.php">View Order_Items</a><br>
      </p>
    </div>
    <?php include_once("footer.php"); ?>
  </body>
</html>