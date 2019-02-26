<?php
session_start();
require('modules/database.php');
require('modules/functions.php');
require("modules/UI.php");
$page = 'user.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $UserId = id($_SESSION['user_email']);
    if ($_GET['action'] == 'confirm') {
        if (ValidateAddress($UserId) == true) {
            $upt = pg_query("update cart set checked = 'Y' where uid = $UserId");
            if ($upt) {
                echo ("<script>alert('Order Confirmed');</script>");
            }
        } else {
            echo ("<script>alert('Please Fill In A Valid Address');</script>");
        }
    } else {
        if ($_GET['action'] == 'addUser') {
            @pg_query("update relic_user set uaddr = '" . $_POST['addr'] . "',ucity = '" . $_POST['state'] . "',ustate = '" . $_POST['city'] . "',upin = '" . $_POST['pin'] . "' WHERE uid = $UserId");
            echo ("<script>alert('User Details Updated!');</script>");
        }
    }
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
    <link rel="stylesheet" href="../css/style.css" />
    <title>Bootstrap Theme</title>
    <style>
        body {
            height: 100%;
        }

        .background-pattern {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex: 1 0 auto;
        }

        .footer {
            flex-shrink: 0;
        }
    </style>
</head>

<body>
    <div class="background-pattern">
        <?php require('components/navbar.php'); ?>
        <section id="userDet">
            <div class="container">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Update Details
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Update User Details</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="user.php?action=addUser" method="post">
                                    <div class="form-group"><label for="name">State</label><input type="text" name="state" class="form-control"></div>
                                    <div class="form-group"><label for="addr">Address</label><textarea type="text" name="addr" class="form-control"></textarea></div>
                                    <div class="form-group"><label for="city">City</label><input type="text" name="city" class="form-control"></div>
                                    <div class="form-group"><label for="pin">Pin</label><input type="number" name="pin" class="form-control"></div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="userCard">
            <div class="container">
                <h1 class="display-4"> Your Shopping Cart</h1>
                <p class="text-muted">
                    <?php echo ("User : " . $_SESSION['user_name'] . "<br>" . "E-mail : " . $_SESSION['user_email']); ?>
                </p>
                <?php require("components/shopping_cart.php"); ?>
                <form action="user.php?action=confirm" method="post">
                    <input type="submit" value="Confirm" class="btn btn-warning">
                </form>
            </div>
        </section>
        <footer id="footerMain" class="bg-dark text-white py-2 text-center">
            <span>Relic Stores &copy; All Rights Reserved </span>
        </footer>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</ h tml> 