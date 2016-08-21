<?php

  session_start();

  include('includes/functions.php');

  if ( isset( $_GET['logMessage'] ) ) {
    $message = '<div class="alert alert-success">Successfully Signed up, Please Log in.</div>';
  }


  if ( isset( $_GET['logout'] ) ) {
    session_unset();
    session_destroy();
    session_start();
    $message = '<div class="alert alert-success">Successfully Logged out</div>';
  }

  if ( isset( $_POST['logIn'] ) ) {
    $email = validateFormData($_POST['email']);
    $password = validateFormData($_POST['password']);

    include('includes/connection.php');

    // create query
    $query = "SELECT * FROM users WHERE email = '$email'";

    // query and read
    $result = mysqli_query( $conn, $query);

    if ( mysqli_num_rows($result) > 0) {

      while ( $row = mysqli_fetch_assoc($result) ) {
        $resultEmail = $row['email'];
        $resultPwd = $row['password'];
        $resultUser = $row['lastname'];
        $result_id = $row['uid'];
      }

      if ( password_verify( $password, $resultPwd ) ) {

        $_SESSION['loggedIn'] = true;
        $_SESSION['user_logged_in'] = $resultUser;
        $_SESSION['uid'] = $result_id;
        $message = "<div class='alert alert-success'>Successfully logged in <a class='close' data-dismiss='alert'>&times;</a></div>";

        // redirect to cards.php after succesful login
        header( "Location: sets.php" );


      } else {

        $message = "<div class='alert alert-danger'>Incorrect Password <a class='close' data-dismiss='alert'>&times;</a></div>";
      }
    } else {
      $message = "<div class='alert alert-danger'>Account not found. Please sign up. <a class='close' data-dismiss='alert'>&times;</a></div>";
    }

    mysqli_close($conn);
  }
  include('includes/header.php');
?>

<section class="container">
  <div class="row">
    <div class="col-md-3 col-md-offset-4">
      <h1>Log-in</h1>
      <form action=" <?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post">
        <?php
          if ( !$_SESSION["loggedIn"] ) {
            echo '<div class="form-group">
              <label for="email" class="sr-only">E-mail</label>
              <input class="form-control" type="text" name="email" id="email" placeholder="E-mail">
            </div>
            <div class="form-group">
              <label for="password" class="sr-only">Password</label>
              <input class="form-control" type="password" name="password" id="password" placeholder="Password">
            </div>
            <button class="btn btn-default" type="submit" name="logIn">Submit</button>
            <br><br>
            <h3>First-time Users : </h3>
            <a class="btn btn-success" href="signup.php">Sign-up</a>';
          }
        ?>
      </form>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-md-12">
      <?php
        if ( $message ) {
            echo $message;
        }
      ?>
    </div>
  </div>
</section>


<?php

  include('includes/footer.php');

?>
