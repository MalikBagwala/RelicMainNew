<?php
 //require("../modules/UI.php");
//echo ("<pre>");
// print_r($_SESSION['cart']);
$UserId = id($_SESSION['user_email']);
echo ("</pre>");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  switch ($_GET['action']) {
    case 'remove':
      Cart::removeProduct($UserId, $_GET['id']);
      @header("Refresh:0");
      break;

    case 'empty':
      Cart::removeCart($UserId);
      @header("Refresh:0");
      break;

    case 'update':

    default:
      # code...
      break;
  }
}
?>
<?php
 //if (!empty($_SESSION['cart'])) {

// echo ("<pre>");
// print_r($_SESSION['cart']);
// echo ("</pre>");
$res = pg_query($conn, "SELECT smartphone.pid,pname,cartitems.qty,price
  FROM smartphone,relic_user,cart,cartitems
  WHERE relic_user.uid = cart.uid AND
        cart.id = cartitems.id AND
        smartphone.pid = cartitems.pid AND
        relic_user.uid = $UserId AND checked = 'N'");
if (!$res) {
  Cart::makeCart($UserId);
}
$resArray = pg_fetch_all($res, $result_type = PGSQL_ASSOC);
echo ("<pre>");
//print_r($resArray);
echo ("</pre>");
?>
<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Quantity</th>
            <th scope="col">Price</th>
            <th scope="col">Total</th>
            <th scope="col"><i class="fas fa-trash-alt"></i></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total = 0;
        if ($resArray != null) {
          foreach ($resArray as $items) {
            echo ("<tr>
    <th scope='row'>" . $items['pid'] . "</th>
    <td>" . $items['pname'] . "</td>
    <td>" . $items['qty'] . "</td>
    <td>₹" . $items['price'] . "</td>
    <td>₹" . ($items['qty'] * $items['price']) . "</td>
    <td><form action='user.php?action=remove&id=" . $items['pid'] . "' method='POST'>
    <button type='submit' name='remove' class='btn btn-danger'>
    <i class='fas fa-trash'></i>
    </button>
  </form></td>
  </tr>");
            $total += $items['qty'] * $items['price'];
          }
        }
        ?>
        <tr>
            </th>
            <th class="text-center" scope="row" colspan="4">Total Amount</th>
            <td colspan="1">
                <?php echo ("₹" . $total) ?>
            </td>
            <td>
                <form action='user.php?action=empty' method='POST'>
                    <button type='submit' name='remove' class='btn btn-danger'>
                        <i class='fas fa-trash'></i> Empty
                    </button>
                </form>
            </td>
        </tr>
    </tbody>
</table>
<?php 
?> 