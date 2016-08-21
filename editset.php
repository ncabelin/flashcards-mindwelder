<?php
  session_start();
  include("includes/functions.php");
  include("includes/connection.php");

  if ( $_SESSION['loggedIn'] ) {

    $uid = $_SESSION['uid'];

    if ( isset( $_GET['set'] ) ) {
      $set = $_SESSION['current_set'] = validateFormData($_GET['set']);

      $query = "SELECT * FROM cardset WHERE set_name = '$set' AND uid = '$uid'";

      $results = mysqli_query( $conn, $query );

      if ( $results ) {
          while ( $row = mysqli_fetch_assoc($results) ) {
            $set_name = $row['set_name'];
            $set_description = $row['description'];
          }
      } else {
        $message = "<div class='alert alert-danger'>Error connecting to database</div>";
      }
    }

    if ( isset( $_POST['editset'] ) ) {
      $set_name = validateFormData($_POST['card_set']);
      $set_description = validateFormData($_POST['card_desc']);
      $set = $_SESSION['current_set'];

      $query = "UPDATE cardset SET set_name = '$set_name', description = '$set_description' WHERE uid = '$uid' AND set_name = '$set'";

      $results = mysqli_query( $conn, $query );

      if ( $results ) {

        header("Location: sets.php?set='$set'");
        exit();
      } else {
        $message = "Error : " . mysqli_error($conn);
      }
    }

  }

  include("includes/header.php");
?>

<div class="container well">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="POST">
        <label for="cardName">Set Name :</label>
        <input type="text" id="cardName" name="card_set" class="form-control" value="<?php echo $set_name; ?>">
        <label for="cardDesc">Set Description :</label>
        <textarea type="text" name="card_desc" rows="5" class="form-control"><?php echo $set_description; ?></textarea>
        <a href="sets.php" class="btn btn-primary">Cancel</a>
        <button type="submit" class="btn btn-success" name="editset">Save</button>
      </form>
      <?php if ( $message ) { echo $message; } ?>
    </div>
  </div>
</div>

<?php
  include("includes/footer.php");
?>
