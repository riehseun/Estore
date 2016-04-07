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
	$login = mysql_real_escape_string($_POST["login"]); 
  $password = mysql_real_escape_string($_POST["password"]); 
  // Connect to the MySQL database  
  include "../scripts/mysql_connect.php"; 
  $sql = mysql_query("SELECT id FROM admin WHERE login='$login' AND password='$password' LIMIT 1"); 
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
		echo 'That information is incorrect, try again <a href="index.php">Click Here</a>';
		exit();
	}
}
?>

<!DOCTYPE html>
<html>  
  <head>
    <title>Administrator Log In </title>
    <link rel="stylesheet" href="../style/style.css" type="text/css">
  </head>

  <body>
    <?php include_once("header.php"); ?>
    <h2>Please Log In as Administrator</h2>
      <form id="form1" name="form1" method="post" action="login.php">
        Username: <input name="login" type="text" id="login"><br>
        Password: <input name="password" type="password" id="password"><br>
        <input type="submit" name="button" id="button" value="Log In">
      </form>
    <?php include_once("footer.php"); ?>
  </body>
</html>