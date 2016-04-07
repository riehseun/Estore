<?php 
// Check to see the URL variable is set and that it exists in the database
if (isset($_GET['id'])) {
	// Connect to the MySQL database  
  include "scripts/mysql_connect.php"; 
	$id = $_GET['id']; 
	$sql = mysql_query("SELECT * FROM products WHERE id='$id' LIMIT 1");
	$productCount = mysql_num_rows($sql); 
  if ($productCount > 0) {
	  while($row = mysql_fetch_array($sql)) { 
	 	  $name = $row["name"];
      $description = $row["description"];
      $photo_url = $row["photo_url"];
	    $price = $row["price"];
	  }	 
  }
  else {
	  echo "That item does not exist.";
	  exit();
	}
} 
else {
	echo "Data to render this page is missing.";
	exit();
}
mysql_close();
?>

<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $product_name; ?></title>
    <link rel="stylesheet" href="style/style.css" type="text/css">
  </head>
  <body>
    <?php include_once("header.php");?>
    <table>
      <tr>
        <td><img src="<?= $photo_url ?>"><br>
        <a href="<?= $photo_url ?>">View Full Size Image</a></td>
        <td><Strong><?php echo $name; ?></strong><br>
        Price: <?php echo "$".$price; ?><br>
        Description: <?php echo $description; ?></td>
        <form id="form1" name="form1" method="post" action="cart.php">
          <input type="hidden" name="pid" id="pid" value="<?php echo $id; ?>">
          <input type="submit" name="button" id="button" value="Add to Shopping Cart">
        </form>
        </td>
      </tr>
    </table>
    <?php include_once("footer.php");?>
  </body>
</html>