<?php
require("modules/database.php");
$productArray = pg_query($conn, "SELECT pid,pname,qty,price FROM smartphone ORDER BY pid");
$products = pg_fetch_all($productArray);
?>

<table class="table my-5">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Quantity</th>
            <th scope="col">Price</th>
            <th scope="col">Remove</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($products as $product) {
          $id = $product['pid'];
          $pname = $product['pname'];
          $img = $pname . ".jpg";
          $qty = $product['qty'];
          echo ("
    <tr>
      <th scope='row'>$id</th>
      <td>" . $pname . "</td>
      <td>" . $qty . "</td>
      <td>" . $product['price'] . "</td>
      <td>
        <form action='admin.php?action=remove&id=$id&imgName=$img' method='POST'>
          <button type='submit' name='remove' class='btn btn-danger'>
          <i class='fas fa-trash'></i>
          </button>
        </form>
      </td>
    </tr>
    ");
        }
        ?>
    </tbody>
</table> 