<div class='main container'>
  <p>
    <a href='/estore/admin/newForm' class='btn btn-lg btn-primary'>Add New Product</a>
    <a href='/estore/admin/productDeleteAll' class='btn btn-lg btn-danger'
      onClick='return confirm("Do you really want to delete all products?")'>Delete All Product</a>
  </p>
  <div class='cart'>
    <div class='panel panel-default'>
      <table class="table">
        <tr>
          <th>ID</th>
          <th>Photo</th>
          <th>Name</th>
          <th>Description</th>
          <th>Price</th>
          <th>Remove</th>
          <th>Edit</th>
          <th>View</th>
        </tr>
        <?php
        foreach ($products as $product) {
          ?>
          <tr>
            <td><?= $product->id?>
              <td><img src="<?=base_url()?>images/product/<?=$product->photo_url?>"></td>
              <td><?=$product->name?></td>
              <td><?=$product->description?></td>
              <td>$<?=$product->price?></td>
              <td><a href="/estore/admin/delete/<?=$product->id?>" onClick='return confirm("Do you really want to delete this record?")'>Remove</a></td>
              <td><a href="/estore/admin/editForm/<?=$product->id?>">Edit</a></td>
              <td><a href="/estore/admin/read/<?=$product->id?>">Read</a></td>
          </tr>
          <?php
        }
        ?>
      </table>          
    </div>
  </div>
</div>
