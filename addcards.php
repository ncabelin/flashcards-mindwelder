<?php

  session_start();

  include("includes/functions.php");
  if ( isset( $_POST['addcard'] ) ) {
    $card_set = validateFormData($_SESSION['set']);
    $question = validateFormData($_POST['question']);
    $answer = validateFormData($_POST['answer']);
    $uid = validateFormData($_SESSION['uid']);

    include("includes/connection.php");

    $query = "INSERT INTO cards(uid, fid, card_set, question, answer, score, timestamped) VALUES('$uid', NULL, '$card_set', '$question', '$answer', 0, NULL)";

    $results = mysqli_query( $conn, $query );

    if ( $results ) {
      header("Location: cards.php?added=true&set=" . $_SESSION['set']);
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
          <input class="form-control" name="card_set" id="cardSet" placeholder="Set" value="<?php echo $_SESSION['set']; ?>" readonly>
        </div>
        <div class="form-group">
          <label for="question">Question :</label>
          <textarea class="form-control" rows="3" type="text" name="question" id="question"></textarea>
        </div>
        <div class="form-group">
          <label for="answer">Answer :</label>
          <textarea class="form-control" rows="10" name="answer" id="answer" placeholder="Answer"></textarea>
        </div>
        <button class="btn btn-primary" type="submit" name="addcard">Submit</button>
      </form>
    </div>
  </div>
</div>

<?php
  include("includes/footer.php");
?>
