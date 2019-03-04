<?php
session_start();
require('modules/database.php');
require('modules/functions.php');
if (isset($_SESSION['user_name']) && isset($_SESSION['user_email'])) {
  header("Location: main.php");
} else {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uname = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $cpass = $_POST['cpassword'];
    $classes = 'alert alert-danger';
    if ($uname == '' || $email == '' || $pass == '' || $cpass == '') {
      $error_msg = "Please Complete all the fields";
    } else {
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_msg = "E-mail is invalid";
      } else {
        if ($pass !== $cpass) {
          $error_msg = "Passwords do not match";
        } else {
          $selectUser = pg_query("SELECT * FROM relic_user WHERE uemail = '$email'");
          $selectAdmin = pg_query("SELECT * FROM admins WHERE aemail = '$email'");
          if (pg_affected_rows($selectUser) != 0 || pg_affected_rows($selectAdmin) != 0) {
            $error_msg = "User already registered with the given email";
          } else {
            $registor = pg_query("INSERT INTO relic_user(uname,uemail,upass) VALUES('$uname','$email','$pass')");
            if (pg_affected_rows($registor) == 1) {
              $error_msg = "User Registered Successfully";
              $classes = "alert alert-success";
            }
          }
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />
    <!-- Font Awesome 5 -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css" />
    <style>
        .background-pattern{
      background-image: url("img/slide/sign-in.jpg");
      background-size: cover;
    }
    </style>
    <title>Bootstrap Theme</title>
</head>

<body>
    <div class="background-pattern">
        <?php require('components/navbar.php'); ?>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mx-auto mt-5">
                    <h1 class="display-4 text-center mb-4"> Sign Up </h1>
                    <?php
                    if (isset($error_msg)) {
                      show_alert($error_msg, $classes);
                    }
                    ?>
                    <form action="<?php echo ($_SERVER['PHP_SELF']); ?>" method="post">
                        <div class="input-group mt-3">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-signature"></i>
                                </div>
                            </div>
                            <input type="text" name="name" placeholder="enter your name" class="form-control">
                        </div>

                        <div class="input-group mt-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-envelope-open"></i>
                                </div>
                            </div>
                            <input type="email" name="email" placeholder="enter your email" class="form-control">
                        </div>

                        <div class="input-group mt-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-key"></i>
                                </div>
                            </div>
                            <input type="password" name="password" placeholder="enter your password" class="form-control" id="userPass">
                            <div class="input-group-append">
                                <button id="userPassBtn" type="button" class="btn">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="input-group mt-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-key"></i>
                                </div>
                            </div>
                            <input type="password" name="cpassword" placeholder="confirm password" class="form-control" id="confPass">
                            <div class="input-group-append">
                                <button type="button" id="confPassBtn" class="btn">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="btn-group" style="width:100%">
                            <input type="submit" name="signup" value="sign up" class="btn btn-info btn-block mt-3">
                            <a href="index.php" class="btn btn-dark btn-block mt-3">Log In</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        const upass = document.getElementById("userPass");
        const cpass = document.getElementById("confPass");

        document.getElementById("userPassBtn").addEventListener("click", e => {
            console.log(e.target.value);
            if (upass.getAttribute("type") == "password") {
                upass.setAttribute("type", "text");
            } else {
                upass.setAttribute("type", "password");
            }
        });

        document.getElementById("confPassBtn").addEventListener("click", e => {
            if (cpass.getAttribute("type") == "password") {
                cpass.setAttribute("type", "text");
            } else {
                cpass.setAttribute("type", "password");
            }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <!-- <div class="spaceExtra"></div> -->
    <?php require('components/footer.php'); ?>
</body>

</html> 