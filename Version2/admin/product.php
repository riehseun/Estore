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
//Display all products  
include "../scripts/mysql_connect.php"; 
$dynamicList = "";
$sql = mysql_query("SELECT * FROM products");
$productCount = mysql_num_rows($sql); 
if ($productCount > 0) {
	while($row = mysql_fetch_array($sql)){ 
    $id = $row["id"];
	$name = $row["name"];
    $description = $row["price"];
    $photo_url = $row["photo_url"];
	$price = $row["price"];
	$dynamicList .= 
    '<table>
      <tr>
        <td><a href="detail.php?id=' . $id . '"><img src="' . $photo_url . '"></a></td>
        <td>
          ' . $name . '<br>
          $' . $price . '<br>
          <a href="detail.php?id=' . $id . '">View Product Details</a>
        </td>
      </tr>
    </table>';
  }
} 
else {
	$dynamicList = "There is no product in store";
}
mysql_close();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Store Home Page</title>
    <link rel="stylesheet" href="style/style.css" type="text/css">
  </head>

  <body>
    <?php include_once("header.php");?>
    <table>
      <tr>
        <td><h3>Latest Candies</h3>
          <p><?php echo $dynamicList; ?></p>
        </td>  
      </tr>
    </table>
  <?php include_once("footer.php");?>
  </body>
</html>