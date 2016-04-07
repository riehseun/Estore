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
// Check to see the URL variable is set and that it exists in the database
if (isset($_GET['id'])) {
  // Connect to the MySQL database  
  include "../scripts/mysql_connect.php"; 
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
    <title><?php echo $name; ?></title>
    <link rel="stylesheet" href="style/style.css" type="text/css">
  </head>
  <body>
    <?php include_once("header.php");?>
    <table>
      <tr>
        <td><img src="<?= $photo_url ?>"><br>
        <a href="<?= $photo_url ?>">View Full Size Image</a></td>
        <td><h3><?php echo $name; ?></h3>
        <p><?php echo "$".$price; ?><br><?php echo $description; ?></p>
        </td>
      </tr>
    </table>
    <?php include_once("footer.php");?>
  </body>
</html>