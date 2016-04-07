<div class='main product-list container'>
<?php
if (count($products) < 1) {
  echo 'There is no product in store';
}
else {
  ?>  
  <div class='row'>
  <?php
    for($i=0; $i<count($products); $i++) {
      $product = $products[$i];
      ?>
      <div class="product col-xs-3">
        <div class='thumbnail'>
          <img src="<?=base_url()?>images/product/<?=$product->photo_url?>">
          <div class='caption'>
            <h3><?=$product->name?></h3>
            <p>Price : $<?=$product->price?></p>
            <p>
              <a href="/estore/store/product_detail/<?=$product->id?>" class="btn btn-default" role="button">Description</a> 
              <a href="/estore/store/addcart/<?=$product->id?>" class="btn btn-primary" role="button">AddCart</a>
            </p>
          </div>
        </div>
      </div>
      <?php 
      if (($i+1)%4 == 0) {
        ?>
  </div>
  <div class='row'>
    <?php
      }
    }
    if(count($product) % 4 != 0) {
      echo '</div>';
    }
    ?>
  </div>
  <div class='cart-buttons row'>
    <div class='cart-button-center'>
      <a href="/estore/store/cart" class='btn btn-success'>Show Cart</a>
    </div>
  </div>
  <?php
}
?>
</div>

