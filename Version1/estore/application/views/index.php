<div class='container'>
  <div class="cover">
    <h1 class="cover-heading">Welcome To EStore!</h1>
    <p class="lead">In this website, you can grab tons of baseball card.</p>
    <p class="lead">
    <?php
    if(isset($user) == false) {
      ?>
      <a href="/estore/store/login" class="btn btn-lg btn-default">Login</a>
	    <?php
	  }
	  else {
	    ?>
      <a href="/estore/store/product" class="btn btn-lg btn-default">Go Shopping</a>
      <?php
    }
    ?>
    </p>
  </div>
</div>

