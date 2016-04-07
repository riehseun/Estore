<div class='main container'>
  <p><a href='/estore/admin/orderDeleteAll' class='btn btn-lg btn-danger'
    onClick='return confirm("Do you really want to delete all order information?")'>Delete All Order</a></p>
  <div class='customers'>
    <table class='table'>
      <tr>
        <th>ID</th>
        <th>Customer ID</th>
        <th>Order Date &amp; Time</th>
        <th>Total</th>
        <th>Credit Card Number</th>
        <th>Credit Card Month</th>
        <th>Credit Card Year</th>
        <th>Order Detail</th>
        <th>Delete</th>
      </tr>
      <?php 
      foreach($orders as $order) { 
        ?>
        <tr>
          <td><?=$order->id?></td>
          <td><?=$order->customer_id?></td>
          <td><?=$order->order_date?> & <?=$order->order_time?></td>
          <td>$<?=$order->total?></td>
          <td><?=$order->creditcard_number?></td>
          <td><?=$order->creditcard_month?></td>
          <td><?=$order->creditcard_year?></td>
          <td><a href='/estore/admin/orderDetail/<?=$order->id?>'>Detail</a></td>
          <td><a href='/estore/admin/orderDelete/<?=$order->id?>' 
            onClick='return confirm("Do you really want to delete this order information?")'>x</a>
          </td>
        </tr>
      <?php 
      }
    ?>
    </table>
  </div>
</div>
