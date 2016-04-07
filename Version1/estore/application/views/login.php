<?php 
  if(isset($message)) {
    echo '<h1>'.$message.'</h1>';
  }
?>
<div class='container form-signin' >
  <?php
  echo form_open('store/login','class="form-horizontal" role="form"');
  echo '<h2 class="form-signin-heading">Please Log In</h2>';
  echo '<div class="form-group">';
  echo '<label class="col-sm-2 control-label">Username</label>';
  echo '<div class="col-sm-10">';
  echo form_input('login',set_value('login'),'class="form-control" placeholder="User Name" required');
  echo form_error('login');
  echo '</div></div>';
  echo '<div class="form-group">';
  echo '<label class="col-sm-2 control-label">Password</label>';
  echo '<div class="col-sm-10">';
  echo form_password('password',set_value('password'),'class="form-control" placeholder="Password" required');
  echo form_error('password');
  echo '</div></div>';
  echo form_submit('submit','Login','class="btn btn-lg btn-primary btn-block"');
  echo form_close();
  ?>
  <div class='btn-signup'>
    <h2>Have not sighed up yet?</h2>
    <a class="btn btn-success btn-block btn-lg" href='/estore/store/register'>Sign Up</a>
  </div>
</div>
