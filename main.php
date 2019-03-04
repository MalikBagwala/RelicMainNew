<?php
session_start();
require('modules/database.php');
require('modules/functions.php');
include('modules/UI.php');
$page = 'main.php';
adminRedirect();
if (!isset($_SESSION['user_email'])) {
  header("Location: index.php");
}
$executeQuery = pg_query("SELECT * from smartphone ORDER BY pid");
$brand = pg_fetch_all(pg_query($conn, "SELECT * FROM brand"), $result_type = PGSQL_ASSOC);
$prodHandler = array();
//$search = $_POST['searchBox'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['searchBox']) && isset($_POST['optradio'])) {
    $search = $_POST['searchBox'];
    $bid = $_POST['brand'];
    if ($bid == '') {
      $brandStr = '';
    } else {
      $brandStr = " AND bid = '$bid' ";
    }
    $query = "SELECT * from smartphone WHERE pname LIKE '%$search%'" . $brandStr . "";
    //$_SESSION['post'] = $_POST;
    switch ($_POST['optradio']) {
      case "lth":
        $query = "SELECT * from smartphone WHERE pname LIKE '%$search%'" . $brandStr . " ORDER BY price ASC";
        break;
      case 'htl':
        $query = "SELECT * from smartphone WHERE pname LIKE '%$search%'" . $brandStr . " ORDER BY price DESC";
        break;
      case 'ram':
        $query = "SELECT * from smartphone WHERE pname LIKE '%$search%'" . $brandStr . "  ORDER BY pram DESC";
        break;
      case 'batt':
        $query = "SELECT * from smartphone WHERE pname LIKE '%$search%'" . $brandStr . " ORDER BY pbatt DESC";
        break;
      case "store":
        $query = "SELECT * from smartphone WHERE pname LIKE '%$search%'" . $brandStr . " ORDER BY pstore DESC";
        break;
      case 'none':
        $query = "SELECT * from smartphone WHERE pname LIKE '%$search%'" . $brandStr . "";
        break;
      default:
        $query = "SELECT * from smartphone WHERE pname LIKE '%$search%'" . $brandStr . " ORDER BY pname";
        break;
    }

    $executeQuery = pg_query($query);
  }
  if (!empty($_GET)) {
    switch ($_GET['action']) {
      case 'add':
        if (!Cart::getCart(id($_SESSION['user_email']))) {
          Cart::makeCart(id($_SESSION['user_email']));
          if (!Cart::removeQty($_GET['id'], $_POST['qty'])) {
            echo ("<script>alert('Quantity Not Available');</script>");
          } else {
            Cart::insertProduct(id($_SESSION['user_email']), $_GET['id'], $_POST['qty']);
          }
        } else {
          if (!Cart::removeQty($_GET['id'], $_POST['qty'])) {
            echo ("<script>alert('Quantity Not Available');</script>");
          } else {
            Cart::insertProduct(id($_SESSION['user_email']), $_GET['id'], $_POST['qty']);
          }
        }
    }
  }
}
while (($row = pg_fetch_assoc($executeQuery)) != null) {
  $prodHandler[] = new Product($row['pid']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />
    <!-- Font Awesome 5 -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css" />
    <style>
        @media screen and (max-width: 600px) {
      #qty{
        margin-bottom: 5px;
      }

    }
    #space{
      height: 91.5vh;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      flex: 1 0 auto;
    }
    </style>
    <title>Bootstrap Theme</title>
</head>

<body>
    <div class="background-pattern">
        <?php require('components/navbar.php'); ?>
        <section class="carousel">
        </section>
        <section id="space">
            <section class="search-bar bg-info py-2">
                <div class="container">
                    <div class="col-md-5 mx-auto">
                        <form action="main.php" method="post">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </div>
                                </div>
                                <input type="text" placeholder="enter the product to search" class="form-control" id="searchBox" name="searchBox">
                                <div class="input-group-append">
                                    <form action="main.php" method="post">
                                        <input type="submit" value="Search" name="searchItem" class="btn btn-dark">
                                </div>
                            </div>
                    </div>
                    <div class="checkbox ml-5 mt-3 text-white text-center">
                        <input type="radio" name="optradio" value="lth" class="ml-3">Price: Low to High
                        <input type="radio" name="optradio" value="htl" class="ml-3">Price: High to Low
                        <input type="radio" name="optradio" value="ram" class="ml-3">RAM
                        <input type="radio" name="optradio" value="batt" class="ml-3">BATTERY
                        <input type="radio" name="optradio" value="store" class="ml-3">STORAGE
                        <input type="radio" name="optradio" value="none" class="ml-3" checked>NONE
                        <div class="form-group mt-3">
                            <select class="custom-select" name="brand">
                                <option value='' selected>Choose your brand</option>
                                <?php
                                foreach ($brand as $br) {
                                  echo ("<option value='" . $br['bid'] . "'>" . $br['bnm'] . "</option>");
                                }
                                ?>
                            </select>
                        </div>

                    </div>
                    </form>
                </div>
            </section>
            <section class="productsPage py-4">
                <div class="container">
                    <div class="row">
                        <?php
                        for ($i = 0; $i < sizeof($prodHandler); $i++) {
                          $prodHandler[$i]->prodCart();
                          $prodHandler[$i]->prodModal();
                        }
                        ?>
                    </div>
                </div>
            </section>
            <?php require('components/footer.php'); ?>
        </section>
        <!--
  <script>
    function search(str){
      console.log(str);
      fetch(`modules/suggest.php?products=${str}`).then(res=>{
        res.text().then(result =>{
          document.getElementById("suggestions").innerHTML = result;
        })
      })
    }
  </script>
  -->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </div>
</body>

</html> 