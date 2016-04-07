<?php 
session_start();
if (isset($_SESSION["login"])) {
    header("location: index.php"); 
    exit();
}
?>

<?php 
// Parse the form if user fills it out and presses submit
if (isset($_POST["login"]) && isset($_POST["password"])) {
	$login = $_POST["login"]; 
  $password = $_POST["password"];   
  include "scripts/mysql_connect.php"; 
  $sql = mysql_query("SELECT id FROM customers WHERE login='$login' AND password='$password' LIMIT 1"); 
  $existCount = mysql_num_rows($sql); 
  if ($existCount == 1) { 
	  while($row = mysql_fetch_array($sql)){ 
      $id = $row["id"];
		}
	  $_SESSION["id"] = $id;
	  $_SESSION["login"] = $login;
	  $_SESSION["password"] = $password;
	  header("Location:index.php");
    exit();
  } 
  else {
		echo 'That information is incorrect, <a href="index.php">Try again</a> or <a href="register.php">Register</a>';
		exit();
	}
}
?>

<!DOCTYPE html>
<html>  
  <head>
    <title>Customer Log In </title>
    <link rel="stylesheet" href="../style/style.css" type="text/css">
  </head>

  <body>
    <?php include_once("header.php"); ?>
    <h2>Welcome customer! Please Log In</h2>
      <form id="form1" name="form1" method="post" action="login.php">
        Username: <input name="login" type="text" id="login"><br>
        Password: <input name="password" type="password" id="password"><br>
        <input type="submit" name="button" id="button" value="Log In"><br>
        <a href="register.php">Register</a>
      </form>
    <?php include_once("footer.php"); ?>
  </body>
</html>