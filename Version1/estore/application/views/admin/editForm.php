<div class='container product-edit'>
  <div class='media'>
    <div class='media-left'>
      <img src="<?=base_url()?>images/product/<?=$product->photo_url?>">
    </div>
    <div class='media-body'>
      <?php
      echo form_open("admin/update/$product->id",'class="form-horizontal" role="form"');
      echo '<h2>Edit Product</h2>';
            
      echo '<div class="form-group">';
      echo '<label class="col-sm-2 control-label">Name</label>';
      echo '<div class="col-sm-10">';
      echo form_input('name',$product->name,"class='form-control' placeholder='Name' required");
      echo form_error('name');
      echo '</div></div>';

      echo '<div class="form-group">';
      echo '<label class="col-sm-2 control-label">Description</label>';
      echo '<div class="col-sm-10">';
      echo form_input('description',$product->description,"class='form-control' placeholder='Description' required");
      echo form_error('description');
      echo '</div></div>';
            
      echo '<div class="form-group">';
      echo '<label class="col-sm-2 control-label">Price</label>';
      echo '<div class="col-sm-10">';
      echo form_input('price',$product->price,"class='form-control' placeholder='Price' required");
      echo form_error('price');
      echo '</div></div>';
            
      echo form_submit('submit', 'Save', "class='btn btn-lg btn-primary btn-block'");
      echo form_close();
      ?>	
    </div>
  </div>
</div>
