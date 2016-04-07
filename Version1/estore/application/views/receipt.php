<html>
<style>
table,td,th {
  font-family: Arial, Helvetica, sans-serif;
  font-size: 14px;
  color: #333;
  line-height:1.5em;
}
body {
  padding-top:50px;
  background-color: #FFF;
}
img {
  width: 100px;
  height: 100px;
}
</style>
<div class='checkout container'>
  <div class='panel panel-default'>
  <div class="panel-heading">Finalized Orders</div>
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
</html>
