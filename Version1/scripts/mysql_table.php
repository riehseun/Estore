<?php
// Connect to the MySQL database  
require "mysql_connect.php";  

mysql_query(
"CREATE TABLE admin (
  id INT NOT NULL AUTO_INCREMENT, #For each admin, assign unique id
  login VARCHAR(16) NOT NULL, 
  password VARCHAR(16) NOT NULL,
  UNIQUE INDEX id_UNIQUE (id ASC),
  UNIQUE INDEX login_UNIQUE(login ASC),
  PRIMARY KEY(id)
)") or die (mysql_error());
echo "admin table has been created successfully!"; 

mysql_query(
"CREATE TABLE customers (
  id INT NOT NULL AUTO_INCREMENT, 
  first VARCHAR(24) NOT NULL,
  last VARCHAR(24) NOT NULL,
  login VARCHAR(16) NOT NULL, 
  password VARCHAR(16) NOT NULL,
  email VARCHAR(45) NOT NULL,
  UNIQUE INDEX id_UNIQUE (id ASC),
  UNIQUE INDEX login_UNIQUE(login ASC),
  UNIQUE INDEX email_UNIQUE(email ASC),
  PRIMARY KEY(id)
)") or die (mysql_error());
echo "customers table has been created successfully!";

mysql_query(
"CREATE TABLE orders (
  id INT NOT NULL auto_increment,
  customer_id INT NOT NULL,
  order_date DATE NOT NULL,
  order_time TIME NOT NULL,
  total FLOAT NOT NULL,
  creditcard_number VARCHAR(16) NOT NULL,
  creditcard_month INT NOT NULL,
  creditcard_year INT NOT NULL,
  PRIMARY KEY (id),
  INDEX fk_order_customer (customer_id ASC),
  UNIQUE INDEX id_UNIQUE (id ASC) ,
  CONSTRAINT fk_order_customer
  FOREIGN KEY (customer_id)
  REFERENCES customers (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
)") or die (mysql_error());
echo "orders table has been created successfully!";

mysql_query(
"CREATE TABLE products (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(45) NOT NULL,
  description LONGTEXT NOT NULL,
  photo_url VARCHAR(128) NOT NULL,
  price FLOAT NOT NULL,
  PRIMARY KEY (id),
  UNIQUE INDEX id_UNIQUE (id ASC) ,
  UNIQUE INDEX name_UNIQUE (name ASC) 
)") or die (mysql_error());
echo "products table has been created successfully!";

mysql_query(
"CREATE TABLE order_items (
  id INT NOT NULL AUTO_INCREMENT,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  quantity INT NOT NULL,
  PRIMARY KEY (id),
  INDEX fk_order_item_order1 (order_id ASC),
  INDEX fk_order_item_product1 (product_id ASC),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  CONSTRAINT fk_order_item_order1
    FOREIGN KEY (order_id)
    REFERENCES orders (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT fk_order_item_product1
    FOREIGN KEY (product_id)
    REFERENCES products (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
)") or die (mysql_error());
echo "order_items table has been created successfully!";
?>



