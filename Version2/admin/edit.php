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
// Edit item
if (isset($_POST['name'])) {
	$pid = $_POST['thisID'];
  $name = $_POST['name'];
  $description = $_POST['description'];
  $photo_url = $_POST['photo_url'];
	$price = $_POST['price'];
	// Update product with new information
	$sql = mysql_query("UPDATE products SET name='$name', description='$description', photo_url='$photo_url', price='$price' 
    WHERE id='$pid'");
	header("Location: add.php"); 
  exit();
}
?>

<?php 
// Gather this product's full information for inserting automatically into the edit form below on page
if (isset($_GET['pid'])) {
	$targetID = $_GET['pid'];
  $sql = mysql_query("SELECT * FROM products WHERE id='$targetID' LIMIT 1");
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
	  echo "Fatal Error: Shoot!";
		exit();
  }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Product List</title>
    <link rel="stylesheet" href="../style/style.css" type="text/css">
  </head>

  <body>
    <?php include_once("header.php");?>
    <a href="add.php#inventoryForm">+ Add New Item</a>
    <h2>Product list</h2>
    <a name="inventoryForm" id="inventoryForm"></a>
    <h3>Add New Inventory Item Form</h3>
    <form action="edit.php" enctype="multipart/form-data" name="myForm" id="myform" method="post">
      <table>
        <tr>
          <td>Product Name</td>
          <td><label><input name="name" type="text" id="name" value="<?php echo $name; ?>"></label></td>
        </tr>
        <tr>
          <td>Product Price</td>
          <td><label>$<input name="price" type="text" id="price" value="<?php echo $price; ?>" /></label></td>
        </tr>
        <tr>
          <td>Description</td>
          <td><label><textarea name="description" id="description"><?php echo $description; ?></textarea></label></td>
        </tr>
        <tr> 
          <td>photo_url</td>
          <td><label><textarea name="photo_url" id="photo_url" ><?php echo $photo_url; ?></textarea></label></td>
        </tr>      
        <tr>
          <td><label>
            <input name="thisID" type="hidden" value="<?php echo $targetID; ?>" />
            <input type="submit" name="button" id="button" value="Make Changes" />
          </label></td>
        </tr>
      </table>
    </form>
    <?php include_once("footer.php");?>
  </body>
</html>