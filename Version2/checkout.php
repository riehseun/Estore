<?php 
session_start();   
include "scripts/mysql_connect.php"; 
?>

<?php 
// Render the cart 
$cartOutput = "";
$content = "";
$cartTotal = "";
$product_id_array = '';
// If cart is empty
if (!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1) {
  $cartOutput = "<h2'>Your shopping cart is empty</h2>";
} 
else { 
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
	  // Dynamic table generation
	  $cartOutput .= "<tr>";
	  $cartOutput .= '<td><a href="product.php?id=' . $item_id . '">' . $name . '</a><br><img src="' . $photo_url . '"></td>';
	  $cartOutput .= '<td>' . $description . '</td>';
	  $cartOutput .= '<td>$' . $price . '</td>';
	  $cartOutput .= '<td>' . $each_item['quantity'] . '</td>';
	  $cartOutput .= '<td>$' . $pricetotal . '</td>';
	  $cartOutput .= '</tr>';
    $content .= '<img src="' . $photo_url . '" width="100px" height="100px"><br>';
    $content .= 'Product name: ' . $name . '<br>';
    $content .= 'Description: ' . $description . '<br>';
    $content .= 'Price: $' . $price . '<br>';
    $content .= 'Quantity: ' . $each_item['quantity'] . '<br>';
    $content .= 'Price Total: $' . $pricetotal . '<br>';     
  } 
  $cartTotal = "<div>Cart Total : ".$cartTotal." USD</div>";
}
?>

<?php 
// Add order
if (isset($_POST['order'])) {
  $id = $_SESSION["id"];	
  $login = 	$_SESSION["login"];
  date_default_timezone_set('America/New_York');
  $date = date("Y/m/d");
  $time = date("h:i:s A");
  $total = $cartTotal;
  $credit = $_POST["credit"];
  $month = $_POST["month"];
  $year = $_POST["year"];  
  // Add order to database 
  mysql_query("INSERT INTO orders (customer_id, order_date, order_time, total, creditcard_number, creditcard_month, creditcard_year) 
  	VALUES('$id','$date','$time','$total','$credit','$month','$year')") or die (mysql_error());
  $oid = mysql_insert_id(); 
  foreach ($_SESSION["cart_array"] as $each_item) {  
    $order_id = $oid;
    $product_id = $each_item['item_id'];
    $quantity = $each_item['quantity'];
    mysql_query("INSERT INTO order_items (order_id, product_id, quantity) 
    	VALUES('$order_id','$product_id','$quantity')") or die (mysql_error());
    $oiid = mysql_insert_id();
  }
  $sql = mysql_query("SELECT * FROM customers WHERE login='$login' LIMIT 1");
  while ($row = mysql_fetch_array($sql)) {
    $email = $row["email"];
    $first = $row["first"];
    $last = $row["last"];
  }
  $subject = "Dear $first $last, This is the receipt for your order";
  $headers = "";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
  $content = $content.'<br>'."Total price for your order: ".$cartTotal.'<br>'."Thank you for visiting out store";
  mail($email,$subject,$content,$headers);
  echo 'Successfully placed your order. <br>';
  echo 'Receipt has been sent to your email. <a href="index.php">Back to products</a>'; 
  exit();
  
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
      </tr>
      <?php echo $cartOutput; ?>    
    </table>          
    <?php echo $cartTotal; ?>
    <form id="form1" name="form1" method="post">
    	Credit card number: <input type="text" name="credit" id="credit" pattern="[0-9]{16}" required>
    	Must be 16 numbers long<br>
    	Expiration month: <input type="text" name="month" id="month" pattern="[0-9]{2}" required>
    	Must be valid month<br>
    	Expiration year: <input type="text" name="year" id="year" pattern="[0-9]{2}" required>
    	Must be valid year<br>
      <input type="submit" name="order" id="button" value="Place order"><br>
    </form>
    <?php include_once("footer.php");?>
  </body>
</html>