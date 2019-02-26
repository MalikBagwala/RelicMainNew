<?php
session_start();
require("modules/database.php");
echo ("<pre>");
// $totalItems = pg_fetch_all(pg_query($conn, "SELECT pid,qty from cartitems where id = 26"));
// foreach ($totalItems as $prod) {
//   echo ("<pre>");
//   print_r($prod['pid'] . " " . $prod['qty']);
//   echo ("</pre>");
// }
$qty = pg_fetch_assoc(pg_query($GLOBALS['conn'], "SELECT sum(qty)
    FROM relic_user,cart,cartitems
    WHERE relic_user.uid = cart.uid AND
          cart.id = cartitems.id AND
          relic_user.uid = 3 AND
          cart.id = 32 AND
          cartitems.pid = 4"))['sum'];
print_r($qty);
?>

<form action="test.php" method="post">
    <input type="radio" name="n3" value="1">
    <input type="radio" name="n3" value="2">
    <input type="radio" name="n3" value="3">
    <input type="radio" name="n3" value="4">
    <input type="submit">
</form> 