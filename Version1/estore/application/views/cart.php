<div class='main container'>
<?php
if (count($cart_array) < 1) {
  echo 'You do not have any items in your cart';
}
else {
  ?>
  <div class='cart'>
    <div class='panel panel-default'>
      <div class="panel-heading">Your Orders</div>
      <table class="table">
        <tr>
          <th>Product</th>
          <th>Name</th>
          <th>Unit Price</th>
          <th>Quantity</th>
          <th>Total</th>
          <th>Remove</th>
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
            <td>
              <form class='form-inline' role='form' action="/estore/store/updatecart/<?=$i?>" method="post">
                <input class='form-control' name="quantity" type="text" value="<?=$order_item->quantity?>">
                <button type='submit' class='btn btn-small'>Change Quantity</button>
              </form>
            </td>
            <td>$<?=$pricetotal?></td>
            <td>
              <a href="/estore/store/removecart/<?=$i?>">X</a>
            </td>
          </tr>
          <?php
        }  
        ?>
      </table>          
      <div class='panel-footer'>Cart Total : $<?= $cartTotal; ?></div>
    </div>
  </div>
  <div class='cart-buttons row'>
    <div class='cart-button-right'>
      <a href="/estore/store/checkout" class='btn btn-success'>Check Out</a>
    </div>
    <div class='cart-button-right'>
      <a href="/estore/store/product" class='btn btn-success'>Continue Shopping</a><br>
    </div>
    <div class='cart-button-left'>
      <a href="/estore/store/removecart/0" class='btn btn-danger'>Empty Cart</a>
    </div>
  </div>
  <?php
}
?>
</div>
