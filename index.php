<?php
session_start();
require('modules/database.php');
require('modules/functions.php');
$_SESSION['cart_items'] = 0;
$page = "index.php";
adminRedirect();
if (isset($_SESSION['user_email'])) {
  header("Location: main.php");
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (empty($_POST['email']) || empty($_POST['password'])) {
    $error_msg = "Please fill all the fields";
  } else {
    $email = $_POST['email'];
    $pass = $_POST['password'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $error_msg = "E-mail is invalid";
    } else {
      $userQuery = pg_query("SELECT * FROM relic_user WHERE uemail = '$email' AND upass = '$pass'");
      $adminQuery = pg_query("SELECT * FROM admins WHERE aemail = '$email' AND apass = '$pass'");
      if (pg_affected_rows($userQuery) != 1 && pg_affected_rows($adminQuery) != 1) {
        $error_msg = "No user found with given credentials";
      } else {
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = username($email);
        if (pg_affected_rows($adminQuery) == 1) {
          header("Location: admin.php");
        } else {
          header("Location: main.php");
        }
      }

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
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
      integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
      crossorigin="anonymous"
    />
    <!-- Font Awesome 5 -->
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
      integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU"
      crossorigin="anonymous"
    />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css"/>
    <style>
      html,
body {
  height: 100%;
}
.spaceExtra {
  margin-top: 500px;
}
body {
  display: flex;
  flex-direction: column;
}
.background-pattern {
  flex: 1 0 auto;
}
.footer {
  flex-shrink: 0;
  
}
#carouselBack{
  height: 600px;
  position: relative;
}
#login{
  position: absolute;
  top: 20%;
  width: 100%;
}
.contain{
  height: 100%;
}

    </style>
    <title>Bootstrap Theme</title>
  </head>
  <body>
  <div class="background-pattern">
    <?php require('components/navbar.php'); ?>
    <div id="carouselBack">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" src="img/slide/pic1.jpeg" alt="First slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="img/slide/pic2.jpeg" alt="Second slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="img/slide/pic3.jpeg" alt="Third slide">
    </div>
  </div>
</div>
</div>
    </div>
    <div id="login">
    <div class="container">
      <div class="row">
        <div class="col-md-4 mx-auto mt-5">
        <h1 class="display-4 text-center text-white"><strong><i class="fas fa-clipboard-check"></i>  Log In</strong> </h1>
          <div class="form mt-5">
          <?php
          if (isset($error_msg)) {
            show_alert($error_msg, 'alert alert-danger');
          }
          ?>
          <form action="<?php echo ($_SERVER['PHP_SELF']); ?>" method="post">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">@</span>
            </div>
            <input
              type="email"
              class="form-control"
              placeholder="enter your email"
              name="email"
            />
            </div>
            <div class="input-group mt-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-lock"></i></span>
            </div>
            <input
              type="password"
              name="password"
              class="form-control"
              placeholder="enter the password"
            />
        </div>
        <div class="btn-group" style="width:100%">
            <input type="submit" value="Log In" class="btn btn-dark mt-3 btn-block" />
            <a href="signup.php" class="btn btn-info mt-3 btn-block"> Sign Up</a>
            </div>
          </form>
          </div>
        </div>
      </div>
      </div>
    </div>
    <script
      src="https://code.jquery.com/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
      integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
      integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
      crossorigin="anonymous"
    ></script>
    <!-- TypeIt Js -->
<script src="https://cdn.jsdelivr.net/npm/typeit@5.10.7/dist/typeit.min.js"></script>
        </div>
    <?php require('components/footer.php');
    ?>
  </body>
</html>