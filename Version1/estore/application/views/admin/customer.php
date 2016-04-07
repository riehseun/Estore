<div class='main container'>
  <p><a href='/estore/admin/customerDeleteAll' class='btn btn-lg btn-danger'
    onClick='return confirm("Do you really want to delete all customer information?")'>Delete All Customer</a></p>
  <div class='customers'>
    <table class='table'>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Username</th>
        <th>Email</th> 
        <th>Delete</th>
      </tr>
      <?php 
      foreach($customers as $customer) { 
        if( strcmp($customer->login,'admin') == 0 && strlen($customer->login)==5 )
            continue;
        ?>
        <tr>
          <td><?= $customer->id?></td>
          <td><?=$customer->first?> <?=$customer->last?></td>
          <td><?=$customer->login?></td>
          <td><?=$customer->email?></td>
          <td><a href='/estore/admin/customerDelete/<?=$customer->id?>'
            onClick='return confirm("Do you really want to delete this customer?")'>x</a></td>
        <tr>
        <?php
      }
      ?>
    </table>
  </div>
</div>
