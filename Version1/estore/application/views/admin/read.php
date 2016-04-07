<div class='main product-detail container'>
  <h2>Product Entry</h2>
  <p><a href='/estore/admin/product'>Back</a></p>
  <div class="media">
    <div class='media-left'>
      <img src="<?=base_url()?>images/product/<?=$product->photo_url?>">
    </div>
    <div class="media-body">
      <h4 class="media-heading"><?=$product->name?></h4>
        <p>Price : $<?=$product->price?></p>
        <p><?=$product->description?></p>
        <p><a href='/estore/admin/editForm/<?=$product->id?>' class='btn btn-primary'>Edit</a></p>
    </div>
  </div>
</div>
