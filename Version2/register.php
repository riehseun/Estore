<?php 
// Add customer
if (isset($_POST['login'])) {
  $first = $_POST["first"];
  $last = $_POST["last"];
  $login = $_POST["login"];
  $password = $_POST["password"];
  $email = $_POST["email"];
  // If username already exists in database
  include "scripts/mysql_connect.php";
  $sql = mysql_query("SELECT id FROM customers WHERE login='$login' LIMIT 1");
  $existCount = mysql_num_rows($sql); 
  if ($existCount > 0) {
    echo 'There is already a customer with same login, <a href="register.php">Back to register</a>';
    exit();
  }
  // If email address already exists in database
  $sql = mysql_query("SELECT id FROM customers WHERE email='$email' LIMIT 1");
  $existCount = mysql_num_rows($sql); 
  if ($existCount > 0) {
    echo 'There is already a customer with same email address, <a href="register.php">Back to register</a>';
    exit();
  }
  // Add new user information to database 
  $sql = mysql_query("INSERT INTO customers (first, last, login, password, email) 
    VALUES('$first','$last','$login','$password','$email')") or die (mysql_error());
  $cid = mysql_insert_id();
  header("location: login.php"); 
  exit();
}
?>

<!DOCTYPE html>
<html>  
  <head>
    <title>Registering new customer </title>
    <link rel="stylesheet" href="../style/style.css" type="text/css">
  </head>

  <body>
    <?php include_once("header.php"); ?>
    <h2>Welcome new customer!</h2>
      <form id="form1" name="form1" method="post" action="register.php">
        First name: <input name="first" type="text" id="first" pattern="[A-Za-z]{1,24}" required>
        Use upper and lower case only<br>
        Last name: <input name="last" type="text" id="last" pattern="[A-Za-z]{1,24}" required>
        Use upper and lower case only<br>
        Username: <input name="login" type="text" id="login" pattern="[A-Za-z0-9]{1,16}" required>
        Username can be upper case, lower case, or numbers<br>
        Password: <input name="password" type="password" id="password" pattern="[A-Za-z0-9]{6,16}" required>
        Password must be at least 6 characters long. Characters can be upper case, lower case, or numbers<br>
        Email address: <input name="email" type="text" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required><br>
        <input type="submit" name="button" id="button" value="Create new account"><br>
      </form>
    <?php include_once("footer.php"); ?>
  </body>
</html>