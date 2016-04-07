<?php 
session_start();   
include "scripts/mysql_connect.php"; 
?>

<?php
// If user adds product to cart 
if (isset($_POST['pid'])) {
  $pid = $_POST['pid'];
  $wasFound = false;
  $i = 0;
  // If cart is empty
  if (!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1) { 
	  $_SESSION["cart_array"] = array(0 => array("item_id" => $pid, "quantity" => 1));
  }
  // If cart is not empty
  else {
		foreach ($_SESSION["cart_array"] as $each_item) { 
	    $i++;
	    while (list($key, $value) = each($each_item)) {
		    if ($key == "item_id" && $value == $pid) {
		      // If product is in cart, increase its quantity
		      array_splice($_SESSION["cart_array"], $i-1, 1, array(array("item_id" => $pid, "quantity" => $each_item['quantity'] + 1)));
		      $wasFound = true;
	      } 
	    } 
	  } 
    if ($wasFound == false) {
	    array_push($_SESSION["cart_array"], array("item_id" => $pid, "quantity" => 1));
	  }
  }
  header("location: cart.php"); 
  exit();
}
?>

<?php 
// Emptying cart
if (isset($_GET['cmd']) && $_GET['cmd'] == "emptycart") {
  unset($_SESSION["cart_array"]);
}
?>

<?php 
// Changing product quantity
if (isset($_POST['item_to_adjust']) && $_POST['item_to_adjust'] != "") {
  $item_to_adjust = $_POST['item_to_adjust'];
  $quantity = $_POST['quantity'];
  $quantity = preg_replace('#[^0-9]#i', '', $quantity); // filter everything but numbers
  if ($quantity >= 100) { $quantity = 99; }
  if ($quantity < 1) { $quantity = 1; }
  if ($quantity == "") { $quantity = 1; }
  $i = 0;
  foreach ($_SESSION["cart_array"] as $each_item) { 
    $i++;
    while (list($key, $value) = each($each_item)) {
	    if ($key == "item_id" && $value == $item_to_adjust) {
	      // If product is in cart, increase its quantity
		    array_splice($_SESSION["cart_array"], $i-1, 1, array(array("item_id" => $item_to_adjust, "quantity" => $quantity)));
	    } 
	  } 
  } 
}
?>

<?php 
// Removing product from cart
if (isset($_POST['index_to_remove']) && $_POST['index_to_remove'] != "") {
 	$key_to_remove = $_POST['index_to_remove'];
	if (count($_SESSION["cart_array"]) <= 1) {
		unset($_SESSION["cart_array"]);
	} 
  else {
		unset($_SESSION["cart_array"]["$key_to_remove"]);
		sort($_SESSION["cart_array"]);
	}
}
?>

<?php 
// Render the cart 
$cartOutput = "";
$cartTotal = "";
$product_id_array = '';
// If cart is empty
if (!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1) {
  $cartOutput = "<h2'>Your shopping cart is empty</h2>";
} 
else {
  $i = 0; 
  foreach ($_SESSION["cart_array"] as $each_item) { 
    $item_id = $each_item['item_id'];
	  $sql = mysql_query("SELECT * FROM products WHERE id='$item_id' LIMIT 1");
	  while ($row = mysql_fetch_array($sql)) {
	    $name = $row["name"];
      $description = $row["description"];
      $photo_url = $row["photo_url"];
	    $price = $row["price"];
	  }
	  $pricetotal = $price * $each_item['quantity'];
	  $cartTotal = $pricetotal + $cartTotal;
	  // Create the product array variable
	  $product_id_array .= "$item_id-".$each_item['quantity'].","; 
	  // Dynamic table eneration
	  $cartOutput .= "<tr>";
	  $cartOutput .= '<td><a href="product.php?id=' . $item_id . '">' . $name . '</a><br><img src="' . $photo_url . '"></td>';
	  $cartOutput .= '<td>' . $description . '</td>';
	  $cartOutput .= '<td>$' . $price . '</td>';
	  $cartOutput .= 
	  '<td><form action="cart.php" method="post">
	  <input name="quantity" type="text" value="' . $each_item['quantity'] . '">
	  <input name="adjustBtn' . $item_id . '" type="submit" value="change">
	  <input name="item_to_adjust" type="hidden" value="' . $item_id . '">
	  </form></td>';    
	  $cartOutput .= '<td>' . $each_item['quantity'] . '</td>';
	  $cartOutput .= '<td>' . '$'.$pricetotal . '</td>';
	  $cartOutput .= '<td><form action="cart.php" method="post"><input name="deleteBtn' . $item_id . '" type="submit" value="X" /><input name="index_to_remove" type="hidden" value="' . $i . '" /></form></td>';
	  $cartOutput .= '</tr>';
	  $i++;     
  } 
  $cartTotal = "<div>Cart Total : ".$cartTotal." USD</div>";
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Your Cart</title>
    <link rel="stylesheet" href="style/style.css" type="text/css">
  </head>

  <body>
    <?php include_once("header.php");?>
    <table>
      <tr>
        <td><strong>Product</strong></td>
        <td><strong>Product Description</strong></td>
        <td><strong>Unit Price</strong></td>
        <td><strong>Quantity</strong></td>
        <td><strong>Total</strong></td>
        <td><strong>Price</strong></td>
        <td><strong>Remove</strong></td>
      </tr>
      <?php echo $cartOutput; ?>    
    </table>
    <?php echo $cartTotal; ?>
    <form id="form1" name="form1" method="post" action="checkout.php">
        <input type="submit" name="button" id="button" value="Check Out"><br>
    </form>
    <a href="cart.php?cmd=emptycart">Click Here to Empty Your Shopping Cart</a>
    <?php include_once("footer.php");?>
  </body>
</html>