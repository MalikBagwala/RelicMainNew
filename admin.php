<?php
session_start();
require("modules/database.php");
require("modules/functions.php");
$brand = pg_fetch_all(pg_query($conn, "SELECT * FROM brand ORDER BY bnm"));
//print_r($brand);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['insert_prod'])) {
        if ($_FILES['customFile']['type'] == 'image/jpeg' && $_FILES['customFile']['error'] == 0) {
            $img = fopen($_FILES['customFile']['tmp_name'], 'r');
            $cont = fread($img, $_FILES['customFile']['size']);
            fwrite(fopen("img/products/" . $_POST['prodName'] . ".jpg", "w"), $cont);

            $pname = $_POST['prodName'];
            $pdesc = $_POST['prodDesc'];
            $proccessor = $_POST['processor'];
            $display = $_POST['Display'];
            $pcam = $_POST['Pcam'];
            $scam = $_POST['Scam'];
            $ram = $_POST['Ram'];
            $store = $_POST['Storage'];
            $batt = $_POST['Battery'];
            $price = $_POST['prodPrice'];
            $imgName = $_POST['prodName'] . ".jpg";
            $bid = $_POST['brand'];
            $insert = pg_query($conn, "INSERT INTO smartphone VALUES(DEFAULT,'$pname','$pdesc','$proccessor','$display',$pcam,$scam,$ram,$store,$batt,$price,'$imgName','$bid')");

            if (pg_affected_rows($insert) == 1) {
                $msg = "Insertion Successful";
                $class = "alert alert-success";
            } else {
                $msg = "Insertion Failed";
                $class = "alert alert-danger";
            }
        } else {
            $msg = "Please Select An Image File";
            $class = "alert alert-warning";
        }
    }
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'remove':
                $remove = pg_query($conn, "DELETE FROM smartphone WHERE pid = " . $_GET['id']);
                unlink("img/products/" . $_GET['imgName']);
                if (pg_affected_rows($remove) != 1) {
                    $_SESSION['delete'] = false;
                } else {
                    $_SESSION['delete'] = true;
                }
                header("Refresh:0");
                break;
            case 'update':
                $upd = pg_query($conn, "UPDATE smartphone SET price = '" . $_POST['sprice'] . "'WHERE pname ='" . $_POST['sname'] . "'");
                break;
            case 'addBrand':
                $upd = pg_query($conn, "INSERT into brand VALUES (DEFAULT,'" . $_POST['bname'] . "')");
                header("Refresh:0");
            case 'removeBrand':
                $rem = pg_query($conn, "DELETE from brand where bid = " . $_POST['RemoveBrand']);
                header("Refresh:0");
            case 'addQty':
                $upd = pg_query($conn, "UPDATE smartphone set qty = " . $_POST['prodQty'] . " WHERE pname = '" . $_POST['prodName'] . "'");
        }
    }
}
$users = pg_fetch_row(pg_query($conn, 'SELECT count(*) FROM relic_user'))[0];
$products = pg_fetch_row(pg_query($conn, 'SELECT count(*) FROM smartphone'))[0];
$admins = pg_fetch_row(pg_query($conn, 'SELECT count(*) FROM admins'))[0];
$cart = 210000;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />
    <!-- Font Awesome 5 -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./css/style.css">
    <style>
        .adminArea {
  overflow: hidden;
  flex: 1 0 auto;
}
#stats {
  border-right: 2px black solid;
}
.card {
  transition: all 0.3s ease-in-out;
}
.card:hover {
  border: 2px solid black;
}

    </style>
    <title>Bootstrap</title>
</head>

<body>
    <section class="adminArea">
        <div class="bg-info py-2 text-white text-center">
            <h5 class="display-4">Welcome
                <?php echo ($_SESSION['user_name']) ?>
            </h5>
            <form action="modules/logout.php" method="post">
                <button type="submit" class="btn btn-primary"><i class="fas fa-sign-out-alt">Logout</i></button>
            </form>
        </div>
        <?php
    // if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //   echo ("<pre>");
        //   print_r($_POST);
        //   print_r($_FILES);
        //   echo ("</pre>");
        // }
        ?>
        <div class="row my-5">
            <div id="stats" class="col-md-3 mt-3">
                <div class="container">
                    <div class="card text-white text-center">
                        <div class="card-body bg-primary">
                            <h5 class="card-title">Users</h5>
                            <i class="fas fa-users fa-4x"></i>
                            <h3 class="card-title mt-2 mb-0">
                                <?php
                                echo ($users);
                                ?>
                                </h5>
                        </div>
                    </div>
                    <div class="card text-white text-center mt-3">
                        <div class="card-body bg-success">
                            <h5 class="card-title">Products</h5>
                            <i class="fas fa-shopping-cart fa-4x"></i>
                            <h3 class="card-title mt-2 mb-0">
                                <?php
                                echo ($products);
                                ?>
                                </h5>
                        </div>
                    </div>
                    <div class="card text-white text-center mt-3">
                        <div class="card-body bg-warning">
                            <h5 class="card-title">Admins</h5>
                            <i class="fas fa-code-branch fa-4x"></i>
                            <h3 class="card-title mt-2 mb-0">
                                <?php
                                echo ($admins);
                                ?>
                                </h5>
                        </div>
                    </div>
                    <div class="card text-white text-center mt-3">
                        <div class="card-body bg-info">
                            <h5 class="card-title">Cart Total</h5>
                            <i class="fas fa-chart-pie fa-4x"></i>
                            <h3 class="card-title mt-2 mb-0">
                                <?php
                                echo ("₹ " . $cart);
                                ?>
                                </h5>
                        </div>
                    </div>
                </div>
            </div>
            <div id="insert" class="col-md-9 mt-3 text-center">
                <div class="container">
                    <?php
                    if (isset($msg)) {
                        echo ("
                <div class='$class mt-5'>
                  $msg
                </div>
                ");
                    }
                    ?>
                    <h4 class="display-4"> Insert Product</h4>
                    <div class="col-md-6 mx-auto mt-4">
                        <form action="admin.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <input type="text" name="prodName" class="form-control mt-4" placeholder="Product Name">
                                <input type="number" name="prodPrice" class="form-control mt-4" placeholder="Product Price">
                                <textarea name="prodDesc" id="prodDesc" class="form-control mt-4" placeholder="Product Desc" cols="30" rows="4"></textarea>
                                <div class="custom-file mt-4">
                                    <input type="file" class="custom-file-input" name="customFile" accept="image/*" id="customFile">
                                    <label class="custom-file-label" for="customFile"> Choose an image</label>
                                </div>
                                <div class="form-group">
                                    <label for="specs">Specifications</label>
                                </div>
                                <div class="form-group"><input type="text" class="form-control" name="processor" placeholder="processor"></div>
                                <div class="form-group"><input type="number" class="form-control" name="Ram" placeholder="Ram"></div>
                                <div class="form-group"><input type="number" class="form-control" name="Storage" placeholder="Storage"></div>
                                <div class="form-group"><input type="text" class="form-control" name="Display" placeholder="Display ( 1920 x 1080)"></div>
                                <div class="form-group"><input type="number" class="form-control" name="Pcam" placeholder="Rear Camera"></div>
                                <div class="form-group"><input type="number" class="form-control" name="Scam" placeholder="Front Camera"></div>
                                <div class="form-group"><input type="number" class="form-control" name="Battery" placeholder="Battery (Mah)"></div>
                                <div class="form-group">
                                    <select class="custom-select" name="brand">
                                        <option selected>Choose your brand</option>
                                        <?php
                                        foreach ($brand as $br) {
                                            echo ("<option value='" . $br['bid'] . "'>" . $br['bnm'] . "</option>");
                                        }
                                        ?>
                                    </select>
                                </div>
                                <input type="submit" value="INSERT PRODUCT" name="insert_prod" class="btn btn-success btn-block mt-5">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <h1 class="display-4 mt-5">Products </h1>
            <?php
            if (isset($_SESSION['delete'])) {
                if ($_SESSION['delete'] == true) {
                    show_alert("Deleted Product", "alert alert-danger");
                } else {
                    show_alert("Deletion Failed", "alert alert-warning");
                    unset($_SESSION['delete']);
                }
            }
            require("components/products.php");
            ?>
        </div>
    </section>
    <section class="py-5">
        <div class="container">
            <h1 class="display-4">Update Price</h1>
            <form action="admin.php?action=update" method="post">
                <div class="form-group">
                    <label for="sname">Name</label>
                    <input type="text" name="sname" class="form-control" id="sname">
                </div>
                <div class="form-group">
                    <label for="sprice">Price</label>
                    <input type="number" name="sprice" id="sprice" class="form-control">
                </div>

                <input type="submit" value="Update Price" class="btn btn-success">
            </form>
        </div>
    </section>
    <section>
        <div class="container">
            <h1 class="display-4">Add Quantity</h1>
            <div class="col-md-3">
                <form action="admin.php?action=addQty" method="post">
                    <input type="text" name="prodName" class="form-control mb-3" placeholder="product Name">
                    <input type="number" name="prodQty" class="form-control mb-3" placeholder="product Quantity" min=1 max=100>
                    <input type="submit" value="Update Qty" class="btn btn-success">
                </form>
            </div>
        </div>
    </section>
    <section class="py-4">
        <div class="container">
            <div class="row mx-auto">
                <div class="col-md-5">
                    <p class="lead">Add brand</p>
                    <form action="admin.php?action=addBrand" method="post">
                        <div class="form-group">
                            <input type="text" name="bname" class="form-control" id="bname">
                        </div>
                        <input type="submit" value="Add Brand" class="btn btn-success">
                    </form>
                </div>
                <div class="col-md-5">
                    <p class="lead">Remove Brand</p>
                    <form action="admin.php?action=removeBrand" method="post">
                        <div class="form-group">
                            <select class="custom-select" name="RemoveBrand">
                                <option selected>Choose your brand</option>
                                <?php
                                foreach ($brand as $br) {
                                    echo ("<option value='" . $br['bid'] . "'>" . $br['bnm'] . "</option>");
                                }
                                ?>
                            </select>
                        </div>
                        <input type="submit" value="Remove Brand" class="btn btn-danger">
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <!-- custom Javascript -->
    <script>
        $('#customFile').on('change', function() {
            //get the file name
            var fileName = $(this).val();
            var tokens = fileName.split("\\");
            var drive = tokens[0];
            var fileName = tokens[tokens.length - 1];

            //replace the "Choose a file" label
            $(this).next('.custom-file-label').html(fileName);
        });
    </script>
    <script src="js/app.js"></script>
    <?php include("components/footer.php"); ?>
</body>






</html> 