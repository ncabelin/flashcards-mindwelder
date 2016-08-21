<?php

  session_start();

  include("includes/functions.php");
  if ( isset( $_POST['addset'] ) ) {
    $card_set = validateFormData($_POST['card_set']);
    $description = validateFormData($_POST['description']);
    $uid = validateFormData($_SESSION['uid']);

    include("includes/connection.php");

    $query = "INSERT INTO cardset(uid, set_name, description, status) VALUES('$uid', '$card_set', '$description', 'new')";

    $results = mysqli_query( $conn, $query );

    if ( $results ) {
      header("Location: sets.php?added=true");
      exit;
    } else {
      $errorMsg = "Error connecting to database : " . mysqli_error($conn);
    }

    mysqli_close($conn);
  }

  include("includes/header.php");
?>

<div class="container">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="POST">
        <div class="form-group">
          <label for="cardSet">Set :</label>
          <input class="form-control" name="card_set" id="cardSet" placeholder="Set Name">
        </div>
        <div class="form-group">
          <label for="description">Description :</label>
          <textarea class="form-control" rows="10" name="description" id="description" placeholder="Put a general explanation of your card set"></textarea>
        </div>
        <button class="btn btn-primary" type="submit" name="addset">Submit</button>
      </form>
    </div>
  </div>
</div>

<?php
  include("includes/footer.php");
?>
