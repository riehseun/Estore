<!DOCTYPE html>
<html>
  <head>
    <title>Store Home Page</title>
    <link rel="stylesheet" href="/css/style.css" type="text/css">
  </head>

  <body>
    <div id="header">
       <a href="index.php"><img id = "logo" src="/images/logo.jpg" alt="Logo"></a><br>
       <a id="nav" href="index.php">Home</a>
    </div>
    
<?php foreach ($product as $products): ?>
    <h2><a href='detail.php?id=<?=$product['id']?>'><?php echo $product['id'] ?></a></h2>
    <ul>
        <li>Name : <?= $product['name']?> </li>
        <li>Description : <?= $product['description']?> </li>
        <li>photo_url : <?= $product['photo_url']?> </li>
        <li><img src=<?=$product['photo_url']?>/></li>
        <li>price : <?= $product['price']?> </li>
    </ul>
<?php endforeach ?>
    <div id="footer">Copyright | <a href="../index">Customer</a> | <a href="./logout">Log out</a></div>
  </body>
</html>
