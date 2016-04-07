<div class='main container'>
<?php
if(count($cart_array) < 1) {
  echo 'You do not have any items in your cart!';
}
else {
  ?>
  <div class='checkout container'>
    <div class='panel panel-default'>
    <div class="panel-heading">Your Orders</div>
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
        foreach ($cart_array as $i => $order_item) {
          $pricetotal = $item_array[$i]->price * $order_item->quantity;
          $cartTotal = $pricetotal + $cartTotal;
          ?>
          <tr>
            <td>
              <a href="/estore/store/product_detail/<?=$item_array[$i]->id?>"><img src="<?=base_url()?>images/product/<?=$item_array[$i]->photo_url?>"></a>
            </td>
            <td><?=$item_array[$i]->name?></td>
            <td>$<?=$item_array[$i]->price?></td>
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
  <div class='form-checkout container'>
    <?php
    echo form_open('store/checkout','class="form-horizontal" role="form"');
    echo '<div class="form-group">';
    echo '<label class="col-sm-4 control-label">Credit Card Number</label>';
    echo '<div class="col-sm-8">';
    echo form_input('credit',set_value('credit'),'class="form-control" placeholder="Credit Card Number" pattern="[0-9]{16}" required');
    echo form_error('credit');
    echo '</div></div>';
    echo '<div class="form-group">';
    echo '<label class="col-sm-4 control-label">Expiration Month</label>';
    echo '<div class="col-sm-8">';
    echo form_input('month',set_value('month'),'class="form-control" placeholder="Expiration Month" pattern="[0-9]{2}" required');
    echo form_error('month');
    echo '</div></div>';
    echo '<div class="form-group">';
    echo '<label class="col-sm-4 control-label">Expiration Year</label>';
    echo '<div class="col-sm-8">';
    echo form_input('year',set_value('year'),'class="form-control" placeholder="Expiration Year" pattern="[0-9]{2}" required');
    echo form_error('year');
    echo '</div></div>';
    echo form_submit('submit','Place order','class="btn btn-lg btn-primary btn-block"');
    echo form_close();
}
    ?>
  </div> 
</div>
