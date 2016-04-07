<?php 
session_start();
if (!isset($_SESSION["login"])) {
  header("location: login.php"); 
  exit();
}
// Check SESSION values are in database
$id = mysql_real_escape_string($_SESSION["id"]); 
$login = mysql_real_escape_string($_SESSION["login"]); 
$password = mysql_real_escape_string($_SESSION["password"]); 
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
//Delete products 
if (isset($_GET['deleteid'])) {
	echo 'Do you really want to delete product with ID of ' . $_GET['deleteid'] . '? <a href="add.php?yesdelete=' . 
  $_GET['deleteid'] . '">Yes</a> | <a href="add.php">No</a>';
	exit();
}
if (isset($_GET['yesdelete'])) {
	// remove item from system and delete its picture
	// delete from database
	$id_to_delete = $_GET['yesdelete'];
	$sql = mysql_query("DELETE FROM products WHERE id='$id_to_delete' LIMIT 1") or die (mysql_error());
	// unlink the image from server
	// Remove The Pic -------------------------------------------
  $pictodelete = ("../images/$id_to_delete.jpg");
  if (file_exists($pictodelete)) {
    unlink($pictodelete);
  }
	header("location: add.php"); 
  exit();
}
?>

<?php 
// Add products
if (isset($_POST['name']) && isset($_POST['price']) && isset($_POST['description'])) {
  // Gather data from admin inputs
  $name = mysql_real_escape_string($_POST['name']);
	$description = mysql_real_escape_string($_POST['description']);
	$price = mysql_real_escape_string($_POST['price']);
  $photo_url = mysql_real_escape_string($_POST['photo_url']);
	// If product name already exists in database
	$sql = mysql_query("SELECT id FROM products WHERE name='$name' LIMIT 1");
	$existCount = mysql_num_rows($sql); 
  if ($existCount > 0) {
		echo 'There is already an item with $name, <a href="add.php">click here</a>';
		exit();
	}
	// Add product to database 
	$sql = mysql_query("INSERT INTO products (name, description, photo_url, price) 
    VALUES('$name','$description','$photo_url','$price')") or die (mysql_error());
  $pid = mysql_insert_id();
	header("location: add.php"); 
  exit();
}
?>

<?php 
// List all products
$product_list = "";
$sql = mysql_query("SELECT * FROM products");
$existCount = mysql_num_rows($sql); 
if ($existCount > 0) {
	while($row = mysql_fetch_array($sql)){ 
    $id = $row["id"];
		$name = $row["name"];
		$price = $row["price"];
		$product_list .= "Product ID: $id - <strong>$name</strong> - $$price - 
    <a href='edit.php?pid=$id'>edit</a> - <a href='add.php?deleteid=$id'>delete</a><br>";
  }
} 
else {
	$product_list = "You have no products in your database";
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Product List</title>
    <link rel="stylesheet" href="../style/style.css" type="text/css">
  </head>

  <body>
    <?php include_once("header.php"); ?>
    <a href="add.php#inventoryForm">+ Add New Item</a>
    <h2>Product list</h2>
    <?php echo $product_list; ?>
    <a name="inventoryForm" id="inventoryForm"></a>
    <h3>Add New Inventory Item Form</h3>
    <form action="add.php" enctype="multipart/form-data" name="myForm" id="myform" method="post">
      <table>
        <tr>
          <td>Product Name</td>
          <td><label><input name="name" type="text" id="name" pattern="[A-Za-z0-9]{1,45}" required></label></td>
        </tr>
        <tr>
          <td>Product Price</td>
          <td><label>$<input name="price" type="text" id="price" pattern="[0-9]{1,}" required></label></td>
        </tr>
        <tr> 
          <td>Description</td>
          <td><label><textarea name="description" id="description" pattern="[A-Za-z]{1,}" required></textarea></label></td>
        </tr>
        <tr> 
          <td>photo_url</td>
          <td><label><textarea name="photo_url" id="photo_url" pattern="[A-Za-z0-9]{1,128}" required></textarea></label></td>
        </tr>      
        <tr>
          <td><label><input type="submit" name="button" id="button" value="Add This Item Now" /></label></td>
        </tr>
      </table>
    </form>  
    <?php include_once("footer.php"); ?>
  </body>
</html>