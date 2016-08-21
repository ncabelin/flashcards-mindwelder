<?php
  echo PHP_VERSION;
  session_start();
  include("includes/connection.php");
  include("includes/functions.php");
  if ( $_SESSION['loggedIn'] ) {
    if ( isset( $_GET['fid'] ) ) {

        $fid = $_SESSION['fid'] = validateFormData($_GET['fid']);

        $query = "SELECT * FROM cards WHERE fid = '$fid'";

        $results = mysqli_query( $conn, $query );

    }

    if ( isset( $_POST['delete'] ) ) {
      $fid = $_SESSION['fid'];

      $query = "DELETE FROM cards WHERE fid = '$fid'";

      $results = mysqli_query( $conn, $query );

      if ( $results ) {

        // redirect to cards
        header("Location: cards.php?set=" . $_SESSION['set']);
      } else {


      }
    }

    if ( isset( $_POST['edit'] ) ) {
      $card_set = validateFormData($_SESSION['set']);
      $question = validateFormData($_POST['question']);
      $answer = validateFormData($_POST['answer']);
      $score = validateFormData($_POST['score']);
      $uid = $_SESSION['uid'];

      $fid = $_SESSION['fid'];

      $query = "UPDATE cards SET
                card_set = '$card_set',
                question = '$question',
                answer = '$answer',
                score = '$score'
                WHERE fid = '$fid'";

      $results = mysqli_query( $conn, $query);

      if ( $results ) {

        header("Location: cards.php?alert=updatesuccess&set=" . $_SESSION['set']);
      } else {
        echo "Error : " . mysqli_error($conn);
      }

    }
  }

  include("includes/header.php");
?>

<div class="container well">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF']); ?>" method="POST">
        <?php
        if ( mysqli_num_rows($results) > 0 ) {
          while ( $row = mysqli_fetch_assoc($results) ) {
              $card_set = $row['card_set'];
              $question = $row['question'];
              $answer = $row['answer'];
              $score = $row['score'];
              echo '<div class="form-group">
                <label for="cardSet">Set :</label>
                <input type="text" class="form-control" id="cardSet" name="card_set" value="' . $_SESSION['set'] . '" readonly>
              </div>';
              echo '<div class="form-group">
                <label for="question">Question :</label>
                <textarea type="text" rows="3" class="form-control" id="question" name="question">' . $question . '</textarea>
              </div>';
              echo '<div class="form-group">
                <label for="answer">Answer :</label>
                <textarea type="text" rows="10" class="form-control" id="answer" name="answer">' . $answer . '</textarea>
              </div>';
              echo '<div class="form-group">
                <label for="score">Box :</label>
                <input type="number" class="form-control" id="score" name="score" value="' . $score .'"></div>';
          }
        } else {
          echo "Error connecting to Database : " . mysqli_error($conn);
        }
        ?>
        <a href="<?php echo 'cards.php?set=' . $_SESSION['set'] ?>" class="btn btn-default">Cancel</a>
        <button type="submit" name="edit" class="btn btn-success">Save</button>
        <button type="submit" name="delete" class="btn btn-danger">Delete</button>
      </form>
    </div>
  </div>
</div>

<?php
  include("includes/footer.php")
?>
