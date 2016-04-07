1. AMI ID: ami-005ccc68
2. Location: 
You can access our website using <domain>/estore/
Source code is located on /var/www/html/estore/

3. Apache is preinstalled in the AMI
4. Please use firefox
5.
*In case of change database and SMTP server, please re-config the files located in application/config/database.php, application/config/email.php.
*We make some assumption that maximum quantity for single purchase is 100 for each item.

5.1. Data Structure
From the schema, there are four tables. For each table, we created two models 
(one for object and one for qurrying) resulting in eight models in total. They are,
5.1.1. customer.php & customer_model.php
5.1.2. order.php & order_model.php
5.1.3. orderitem.php & orderitem_model.php
5.1.4. product.php & product_model.php
Every write (insert) operation has atomic transaction implemented

5.2. User Interface for customers
5.2.1. template.php
- COntains jquery plugin and links to stylesheet
- loads header and footer
- renders other views on its body
5.2.2. login.php
- takes username and password from customers 
5.2.3. register.php
- takes user input (username, password, email, etc)
5.2.4. index.php
- first entry point
5.2.5. header.php
- has links to products, login, logout, cart 
5.2.6. footer.php
- has links to logout, admin page 
5.2.7. product.php
- displays all products in store
- can view product details, add product to cart
5.2.8. product_detail.php
- more extensive informaion on product
5.2.9. cart.php
- displays the summary of products in cart including quantity, price of each item, and total cost
- can change quantity of items in cart
5.2.10. checkout.php
- displays final content of cart before paying
- takes in creadit card number, month, and year
5.2.11. receipt.php
- displays receipt and sucess message that the transaction has gone through

5.3. User Interface for admin
5.3.1. template.php
- COntains jquery plugin and links to stylesheet
- loads header and footer
- renders other views on its body
5.3.2. index.php
- first entry point
5.3.3. header.php
- has links to list, customer, order 
5.3.4. footer.php
- has links to logout, store page 
5.3.5. newForm.php
- displays form to add new products
- takes in name, description, price, and photo 
5.3.6. editForm.php
- displays form to edit existing products in store
- can change name, description, and price
5.3.7. customer.php
- displays all customer information
5.3.8. list.php
- displays all product list
- button for deleting all products
5.3.9. order.php
- displays order history
5.3.10. order_item.php
- displays details on ordered products
5.3.11. read.php
- displays product details

5.4. Controller for store (customer)
Having explained views, it is quite obvious what following functions do. 
Please refer to code if more information is needed.
5.4.1. constructor
5.4.2. check_login
5.4.3. drawview
5.4.4. receipt
5.4.5. index
5.4.6. register
5.4.7. login
5.4.8. logout
5.4.9. product
5.4.10. product_detail
5.4.11. cart
5.4.12. addcart
5.4.13. updatecart
5.4.14. removecart
5.4.15. checkout
5.4.16. check_month
5.4.17. check_card
5.4.18. check_year

5.5. Controller for admin
Having explained views, it is quite obvious what following functions do. 
Please refer to code if more information is needed.
5.4.1. constructor
5.4.2. check_admin
5.4.3. logout
5.4.4. index
5.4.5. deleteAll
5.4.6. product
5.4.7. newForm
5.4.8. create
5.4.9. product
5.4.10. product_deleteAll
5.4.11. read
5.4.12. editForm
5.4.13. update
5.4.14. name_check
5.4.15. delete
5.4.16. customer
5.4.17. customerDelete
5.4.18. customerDeleteAll
5.4.19. order
5.4.20. orderDetail
5.4.21. orderDelete
5.4.22. orderDeleteAll
