<nav class="navbar navbar-expand-lg navbar-light bg-light">
<div class="container">
  <a class="navbar-brand" href="#"><i class="fab fa-ravelry"></i> Relic</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item mr-2 <?php if ($page == 'signup.php') {
                                echo ("active");
                              } ?>">
        <a class="nav-link <?php if (sessionUser() == 1) {
                            echo ("d-none non-click");
                          } ?>" href="signup.php"><i class="fas fa-edit"></i> Sign Up</a>
      </li>
      <li class="nav-item mr-2 <?php if ($page == 'index.php') {
                                echo ("active");
                              } ?>">
        <a class="nav-link <?php if (sessionUser() == 1) {
                            echo ("d-none non-click");
                          } ?>" href="index.php"><i class="fas fa-sign-in-alt"></i> Log In</a>
      </li>
      <li class="nav-item mr-2 <?php if ($page != 'user.php') {
                                echo ("d-none");
                              } ?>">
        <a class="nav-link" href="main.php"><i class="fas fa-home"></i> Home</a>
      </li>
      <li class="nav-item mr-2">
        <a class="nav-link <?php if (sessionUser() == 0) {
                            echo ("d-none non-click");
                          } ?>" href="modules/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
      </li>
      <?php if (sessionUser() == 1) {
        welcomeUser();
      } ?>
    </ul>
  </div>
  </div>
</nav>