<div class = 'container product-add'>
  <h2>New Product</h2>
  <p><a href='/estore/admin/product'>Back</a></p>
  <?php
  echo form_open_multipart('admin/create', 'class="form-horziontal" role="form"');
	// Product name
  echo '<div class="form-group">';
  echo '<label class="col-sm-2 control-label">Name</label>';
  echo '<div class="col-sm-10">';
  echo form_input('name',set_value('name'),"class='form-control' placeholder='Name' required");
  echo form_error('name');
  echo '</div></div>';
  // Product description
  echo '<div class="form-group">';
  echo '<label class="col-sm-2 control-label">Description</label>';
  echo '<div class="col-sm-10">';
  echo form_input('description',set_value('description'),"class='form-control' placeholder='Description' required");
  echo form_error('description');
  echo '</div></div>';
	// Product price
  echo '<div class="form-group">';
  echo '<label class="col-sm-2 control-label">Price</label>';
  echo '<div class="col-sm-10">';
  echo form_input('price',set_value('price'),"class='form-control' placeholder='Price'required");
  echo form_error('price');
  echo '</div></div>';
	// Product photo
  echo '<div class="form-group">';
  echo '<label class="col-sm-2 control-label">Photo</label>';
  echo '<div class="col-sm-10">';
  if(isset($fileerror)) {
	echo $fileerror;
  }	
  ?>	
  <input type="file" name="userfile" size="20" />
  <?php 	
  echo form_error('userfile');
  echo '</div></div>';
  echo '<br>';
  echo form_submit('submit','Create New Product','class="btn btn-lg btn-primary btn-block"');
  echo form_close();
  ?>	
</div>
