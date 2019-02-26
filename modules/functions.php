<?php
function username($email)
{
  $selectUser = pg_query("SELECT uname FROM relic_user WHERE uemail = '$email'");
  $selectAdmin = pg_query("SELECT aname FROM admins WHERE aemail = '$email'");
  if (pg_affected_rows($selectUser) == 0) {
    $name = pg_fetch_assoc($selectAdmin);
    return $name['aname'];
  }
  $name = pg_fetch_assoc($selectUser);
  return $name['uname'];
}
function show_alert($msg, $class)
{
  echo ("
<div class='$class mt-5'>
  $msg
</div>
");
}

function sessionUser()
{
  if (isset($_SESSION['user_name']) && isset($_SESSION['user_email'])) {
    return 1;
  }
}

function ValidateAddress($uid){
  $qry = pg_fetch_assoc(pg_query("SELECT uaddr,ucity,ustate,upin from relic_user where uid = $uid"));
  //print_r($qry);
  if($qry['uaddr'] == '' || $qry['ucity'] == '' || $qry['ustate'] == '' || $qry['upin'] == ''){
    return 'false';
  }else{
    return 'true';
  }
}
function cartItems($UserId)
{
  $cartItems = 0;
  @$qry = pg_query("SELECT sum(cartitems.qty)
  FROM relic_user,smartphone,cart,cartitems
  WHERE relic_user.uid = cart.uid AND
        cart.id = cartitems.id AND
        smartphone.pid = cartitems.pid AND
        relic_user.uid = $UserId and checked = 'N'");
        if ($qry !=null) {
  return pg_fetch_assoc($qry)['sum'];
        }else{
          return 0;
        }
}
function welcomeUser()
{
  $uname = $_SESSION['user_name'];
  if (sessionUser() == 1) {
    echo ("
  <li class='nav-item ml-5'>
        <a class='nav-link' href='user.php'><i class='fas fa-user'></i> $uname  <span class='ml-2 badge badge-success'>
        " . cartItems(id($_SESSION['user_email'])) . "
        </span></a>
      </li>
  ");
  }
}

function adminRedirect()
{
  if (isset($_SESSION['user_email'])) {
    $admin = $_SESSION['user_email'];
    if (pg_affected_rows(pg_query("SELECT * FROM admins WHERE aemail = '$admin'")) == 1) {
      header("Location: admin.php");
    }
  }
}
function id($email)
{
  $query = pg_query("SELECT uid FROM relic_user WHERE uemail = '$email'");
  $id = pg_fetch_assoc($query);
  return $id['uid'];
}
 