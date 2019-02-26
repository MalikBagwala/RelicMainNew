<?php
require('database.php');
class Product
{
  var $id;
  var $name;
  var $price;
  var $desc;
  var $img;
  var $specs;
  var $nameShort;
  var $brand;
  var $qty;
  function __construct($id)
  {
    $this->id = $id;
    $this->name = pg_fetch_assoc(pg_query($GLOBALS['conn'], "SELECT pname FROM smartphone WHERE pid = '$this->id'"))['pname'];
    $this->desc = pg_fetch_assoc(pg_query($GLOBALS['conn'], "SELECT pdesc FROM smartphone WHERE pid = '$this->id'"))['pdesc'];
    $this->price = pg_fetch_assoc(pg_query($GLOBALS['conn'], "SELECT price FROM smartphone WHERE pid = '$this->id'"))['price'];
    $this->img = pg_fetch_assoc(pg_query($GLOBALS['conn'], "SELECT pimg FROM smartphone WHERE pid = '$this->id'"))['pimg'];
    $this->qty = pg_fetch_assoc(pg_query($GLOBALS['conn'], "SELECT qty FROM smartphone WHERE pid = '$this->id'"))['qty'];
    $this->brand = pg_fetch_assoc(pg_query($GLOBALS['conn'], "SELECT bnm FROM brand,smartphone WHERE brand.bid = smartphone.bid AND pid = '$this->id'"))['bnm'];
    $query = pg_query($GLOBALS['conn'], "SELECT pproc,pdisp,ppcam,pscam,pram,pstore,pbatt from smartphone WHERE pid = '$this->id'");

    $this->specs = pg_fetch_assoc($query);
    $this->nameShort = str_replace(' ', '', $this->name);
  }
  function prodCart()
  {
    $link = "#modal$this->id";
    if ($this->qty == 0) {
      $btnDis = 'disabled';
      $btnText = 'Out of Stock';
      $btnClass = "btn-danger";
    } else {
      $btnDis = '';
      $btnText = 'ADD';
      $btnClass = "btn-success";
    }
    echo ("<div class='col-md-3 mt-3'>
    <div class='card'>
    <a href='#' data-toggle='modal' data-target='$link'>
      <img
        src='img/products/$this->img'
        alt=''
        width='100px'
        height='auto'
        class='card-img-top'
      /> </a>
      <div class='card-body'>
        <h4 class='card-title text-center'>$this->name</h4>
        <div class='row'>
          <div class='col-md-6'><p class='lead'>₹ $this->price</p></div>
          <div class='col-md-6'>
          <form action='main.php?action=add&id=$this->id' method='post'>
            <input type='number' name='qty' id='qty' class='form-control' value=1 min=1 max=4 $btnDis>
            <input type='hidden' name='name' value=$this->nameShort>
            <input type='hidden' name='price' value=$this->price>
          </div>
            <button type='submit' class='btn $btnClass btn btn-block' $btnDis>
              $btnText <i class='fas fa-cart-plus'></i>
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>");
  }

  function prodModal()
  {
    if ($this->qty == 0) {
      $btnDis = 'disabled';
      $btnText = 'Out of Stock';
      $btnClass = "btn-danger";
    } else {
      $btnDis = '';
      $btnText = 'ADD';
      $btnClass = "btn-success";
    }
    echo ("<div class='modal fade' id='modal$this->id' tabindex='-1'>
    <div class='modal-dialog modal-lg'>
      <div class='modal-content'>
        <div class='modal-body'>
          <div class='row'>
            <div class='col-md-8'>
              <img
                src='img/products/$this->img'
                alt=''
                class='ml-4 img-fluid w-75'
              />
              <p class='modal-text'>
                $this->desc
              </p>
            </div>
            <div class='col-md-4'>
              <h2 class='modal-title'>$this->brand</h2>
              <p class='lead'>$this->name</p>
              <p class='lead'>₹ $this->price</p>
              <hr />
              <h2 class='modal-title'>Specifications</h2>
              <ul class='list-group list-group-flush mt-3'>
                <li class='list-group-item'>" . $this->specs['pproc'] . " SOC</li>
                <li class='list-group-item'>" . $this->specs['pdisp'] . " px</li>
                <li class='list-group-item'>" . $this->specs['pram'] . " GB</li>
                <li class='list-group-item'>" . $this->specs['pstore'] . " GB storage</li>
                <li class='list-group-item'>" . $this->specs['ppcam'] . " MP / " . $this->specs['pscam'] . " MP</li>
                <li class='list-group-item'>" . $this->specs['pbatt'] . " Mah</li>
              </ul>
            </div>
          </div>
        </div>
        <div class='modal-footer'>

          <form class='form-inline' action='main.php?action=add&id=$this->id' method='post'>
            <input type='number' name='qty' class='form-control ml-4' value=1 min='1' max='4' $btnDis>
            <input type='hidden' name='name' value=$this->nameShort>
            <input type='hidden' name='price' value=$this->price>
            <button type='submit' class='btn $btnClass mr-2' $btnDis>
              $btnText <i class='fas fa-cart-plus'></i>
            </button>
          </form>
          <button class='btn btn-outline-danger' data-dismiss='modal'>
            <i class='far fa-times-circle'></i>
          </button>
        </div>
      </div>
    </div>
  </div>");
  }
}

class Cart
{
  static function getCart($id)
  {
    $qry = pg_query($GLOBALS['conn'], "SELECT * from cart WHERE uid = $id AND checked = 'N'");
    if (pg_affected_rows($qry) == 1) {
      return true;
    } else {
      return false;
    }
  }

  static function makeCart($id)
  {
    $qry = pg_query($GLOBALS['conn'], "INSERT INTO cart VALUES(DEFAULT,'$id',now(),DEFAULT)");
    if (pg_affected_rows($qry) == 1) {
      return true;
    } else {
      return false;
    }
  }

  static function insertProduct($uid, $pid, $qty)
  {
    $cid = pg_fetch_assoc((pg_query($GLOBALS['conn'], "SELECT id FROM cart WHERE uid = $uid AND checked = 'N'")))['id'];
    if (pg_affected_rows(pg_query($GLOBALS['conn'], "SELECT * FROM cartitems WHERE id = $cid AND pid = $pid")) == 1) {
      @$qry = pg_query("UPDATE cartitems SET qty = qty + $qty WHERE id = $cid AND pid = $pid");
    } else {
      @$qry = pg_query($GLOBALS['conn'], "INSERT INTO cartitems VALUES (DEFAULT,$cid,$pid,$qty)");
    }
    if (!$qry) {
      echo ("<script>alert('Cannot Have more than 4 products');</script>");
    }
  }
  static function removeProduct($uid, $pid)
  {
    $cid = pg_fetch_assoc((pg_query($GLOBALS['conn'], "SELECT id FROM cart WHERE uid = $uid AND checked = 'N'")))['id'];
    $qty = pg_fetch_assoc(pg_query($GLOBALS['conn'], "SELECT sum(qty)
    FROM relic_user,cart,cartitems
    WHERE relic_user.uid = cart.uid AND
          cart.id = cartitems.id AND
          relic_user.uid = $uid AND
          cart.id = $cid AND
          cartitems.pid = $pid"))['sum'];
    $res = pg_query($GLOBALS['conn'], "update smartphone set qty = qty + $qty where pid = $pid");
    @$qry = pg_query("DELETE FROM cartitems WHERE id = $cid AND pid = $pid");
  }

  static function removeCart($uid)
  {
    $cid = pg_fetch_assoc((pg_query($GLOBALS['conn'], "SELECT id FROM cart WHERE uid = $uid AND checked = 'N'")))['id'];
    $totalItems = pg_fetch_all(pg_query($GLOBALS['conn'], "SELECT pid,qty from cartitems where id = $cid"));
    foreach ($totalItems as $item) {
      Cart::addQty($item['pid'], $item['qty']);
    }
    @pg_query("delete from cartitems where id = $cid");
    @pg_query("delete from cart where uid = $uid AND checked = 'N'");
  }

  static function addQty($pid, $qty)
  {
    @$res = pg_query($GLOBALS['conn'], "update smartphone set qty = qty + $qty where pid = $pid");
    if ($res == null) {
      return false;
    } else {
      return true;
    }
  }

  static function removeQty($pid, $qty)
  {
    @$res = pg_query($GLOBALS['conn'], "update smartphone set qty = qty - $qty where pid = $pid");
    if ($res == null) {
      return false;
    } else {
      return true;
    }
  }
  // function makeCart($id){
  //   pg_query()
  // }
}

// $cart = new Cart();
// if ($cart->getCart(4)) {
//   echo('1');
// }else{
//   if ($cart->makeCart(4)) {
//     echo("Done");
//   }
// }
// $p1 = new Product(1, "galaxy s9");
//Cart::makeCart(6);
// Cart::insertProduct(6, 1, 1);
// Cart::insertProduct(6, 2, 1);
// Cart::insertProduct(6, 3, 2);
// Cart::insertProduct(6, 1, 3);
