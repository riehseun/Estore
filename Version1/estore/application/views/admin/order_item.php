<div class='main container'>
  <p><a href='/estore/admin/order'>Back</a></p>
  <div class='checkout container'>
    <div class='panel panel-default'>
      <div class="panel-heading">
        <h3>Order Details</h3>
        <p>Customer Name : <?=$customer->first?> <?=$customer->last?></p>
        <p>Customer Email : <?=$customer->email?></p>
        <p>Order Date &amp; Time : <?=$order->order_date?> & <?=$order->order_time?></p>
        <p>Credit Card Number : <?=$order->creditcard_number?></p>
        <p>Credit Card Month : <?=$order->creditcard_month?></p>
        <p>Credit Card Year : <?=$order->creditcard_year?></p>
      </div>
      <table class="table">
        <tr>
          <th>Product</th>
          <th>Name</th>
          <th>Unit Price</th>
          <th>Quantity</th>
          <th>Total</th>
        </tr>
        <?php
        $cartTotal = 0;
        foreach ($order_items as $order_item) {
          $product= $item_array[$order_item->product_id];
          $pricetotal = $product->price * $order_item->quantity;
          $cartTotal = $pricetotal + $cartTotal;
          ?>
          <tr>
            <td><img src="<?=base_url()?>images/product/<?=$product->photo_url?>"></td>
            <td><?=$product->name?></td>
            <td>$<?=$product->price?></td>
            <td><?=$order_item->quantity?></td>
            <td>$<?=$pricetotal?></td>
          </tr>
          <?php
        }
        ?>
      </table>          
      <div class='panel-footer'>Order Total : $<?= $cartTotal; ?></div>
    </div>
  </div>
</div>
