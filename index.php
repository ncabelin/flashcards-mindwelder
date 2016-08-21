<?php
  session_start();

  include('includes/header.php');
?>

  <section class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <img src="images/logo_small.png" class="img-responsive center-block">
        <h3 class="text-center">Flash Cards</h3>
        <hr>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 col-md-offset-3 text-center">
        <?php
          if ( $_SESSION['loggedIn'] ) {
        ?>
            <a href="sets.php" class="btn btn-success btn-lg">Select Set</a>
        <?php
          } else {
        ?>
            <a href="login.php" class="btn btn-default btn-lg">Login</a>
            <a href="signup.php" class="btn btn-success btn-lg">Signup</a>
        <?php
          }
        ?>
      </div>
    </div>
  </section>


<?php

  include('includes/footer.php');

?>
