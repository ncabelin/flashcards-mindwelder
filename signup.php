<?php

  session_start();
  include('includes/functions.php');
  $errorMsg = "";

  if ( isset( $_POST['signup'] ) ) {
    $signupFirstname = $signupLastname = $signupEmail = $signupPwd = "";

    if ( !$_POST['userFirstname'] ) {
      $signupFirstname = " ";
    } else {
      $signupFirstname = validateFormData( $_POST['userFirstname'] );
    }

    if ( !$_POST['userLastname'] ) {
      $errorMsg = $errorMsg . ' Lastname ';
    } else {
      $signupLastname = validateFormData( $_POST['userLastname'] );
    }

    if ( !$_POST['userEmail'] ) {
      $errorMsg = $errorMsg . ' Email ';
    } else {
      $signupEmail = validateFormData( $_POST['userEmail'] );
    }

    if ( !$_POST['userPwd'] ) {
      $errorMsg = $errorMsg . ' Password ';
    } else {
      if ( strlen($_POST['userPwd']) < 8 ) {
        $errorMsg = '8 or more characters for password ';
      } else {
        $signupPwd = validateFormData( $_POST['userPwd'] );
        $hashedPwd = password_hash( $signupPwd, PASSWORD_DEFAULT);
      }
    }

    if ( !$_POST['sec_q']) {
      $errorMsg = $errorMsg . ' Security question ';
    } else {
      $sec_q = validateFormData( $_POST['sec_q'] );
    }

    if ( !$_POST['sec_a']) {
      $errorMsg = $errorMsg . ' Security question ';
    } else {
      $sec_a = validateFormData( $_POST['sec_a'] );
      $hashedAnswer = password_hash( $sec_a, PASSWORD_DEFAULT);
    }

    if ( $errorMsg ) {
      $errorMsg = $errorMsg . " is required. ";
    }

    if ( $signupEmail && $signupPwd && $signupLastname && $sec_q && $hashedAnswer ) {

      include('includes/connection.php');

      $search_duplicate_query = "SELECT * FROM users WHERE email = '$signupEmail'";

      $search_duplicate = mysqli_query( $conn, $search_duplicate_query );

      if ( mysqli_num_rows($search_duplicate) > 0 ) {

        $errorMsg = "Already registered, please use another e-mail";

      } else {

        // no duplicate proceed to database save
        $query = "INSERT INTO users(uid, firstname, lastname, email, password, timestamped, sec_question, sec_answer)
          VALUES(NULL, '$signupFirstname', '$signupLastname', '$signupEmail', '$hashedPwd', CURRENT_TIMESTAMP, '$sec_q','$hashedAnswer')";

        $result = mysqli_query( $conn, $query );

        if ( $result ) {

          // redirect to index.php
          header( 'Location: login.php?logMessage=true', true, 301);
          exit;

        } else {
          $errorMsg = $query . 'Error connecting to Database :' . mysqli_error($conn);
        }
      }

      mysqli_close($conn);
    }

  }
  include('includes/header.php');
?>

<section class="container">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <h1>Sign-up <span style="font-size: 0.3em;"> * required</span></h1>
      <form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="POST" class="form-horizontal">
        <div class="form-group">
          <label for="userFirstname" class="control-label col-sm-2">Firstname</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="userFirstname" name="userFirstname" placeholder="First Name">
          </div>
        </div>
        <div class="form-group">
          <label for="userLastname" class="control-label col-sm-2">Lastname</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="userLastname" name="userLastname" placeholder="Last Name">
          </div>
        </div>
        <div class="form-group">
          <label for="userEmail" class="control-label col-sm-2">E-mail</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="userEmail" name="userEmail" placeholder="E-mail">
          </div>
        </div>
        <div class="form-group">
          <label for="userPwd" class="control-label col-sm-2">Password</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" id="userPwd" name="userPwd" placeholder="Password">
          </div>
        </div>
        <div class="form-group">
          <label for="secQuestion" class="control-label col-sm-2">Security Question</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="secQuestion" name="sec_q" placeholder="Security Question">
          </div>
        </div>
        <div class="form-group">
          <label for="secAnswer" class="control-label col-sm-2">Security Answer</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="secAnswer" name="sec_a" placeholder="Security Answer">
          </div>
        </div>
        <button type="submit" class="btn btn-default pull-right" name="signup">Submit</button>
      </form>
      <br>
      <?php
        if ( $errorMsg ) {
      ?>
        <div class="alert alert-danger"><small><?php echo $errorMsg; ?></small><a class="close" data-dismiss="alert">&times;</a></div>
      <?php
        } else {
      ?>
      <?php
        }
      ?>
    </div>
  </div>
</section>
<?php

  include('includes/footer.php');

?>
