<div id="header">
  <nav class='navbar navbar-inverse navbar-fixed-top' role='navigation'>
    <div class='container'>
      <div class='navbar-header'>
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class='navbar-brand' href=''>EStore</a>
      </div>
      <div class="collapse navbar-collapse" id="navbar">
        <ul class="nav navbar-nav">
          <li><a href="/estore/store">Home</a></li>
          <li><a href="/estore/store/product">Product</a></li>
        </ul>
        <ul class='nav navbar-nav navbar-right'>
        <?php
        if(isset($user) == false) {
          ?>
          <li class='Login'><a href='/estore/store/login'>Login</a></li>
          <?php
        }
        else {
          ?>
          <li class='Login'><a href='#'>Logged in as<span class="login"><?=$user?></span></a></li>
          <li class='Login'><a href='/estore/store/logout'>Logout</a></li>
          <li class='Login'><a href='/estore/store/cart'>Show Cart</a></li>
          <?php
        }
        ?>
        </ul>
      </div>
    </div>
  </nav>
</div>
