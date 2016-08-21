<?php
  session_start();

  include("includes/connection.php");
  include("includes/functions.php");

  /*

  TO DOs
  1. connect to db, get all set cards from db,
      save/push set cards to session array.
      access 
      if score is 0 then play card
      if score is 
  2. show question field and answer button
  3. answer button pressed, correct or not? query
  3. wrong answer fid gets 0 score
  4. right answer fid gets +1 score
  5. 

  session variables :

  $_SESSION :
    1. set = current set id
    2. uid = current user id
    3. current_fid = current card fid
    4. current_score = current card fid's score
    5. test_set = array of cards
    6. card_total = total number of cards
    7. card_current = current card number

  */

  if ( $_SESSION["loggedIn"] ) {
    
    // if action = start, then set up set testing
    if ( isset( $_GET['action'] ) ) {
      $action = validateFormData($_GET['action']);
      $set = $_SESSION['set'];
      $uid = $_SESSION['uid'];
      
      if ( $action = "start" ) {

        $query = "SELECT * FROM cards WHERE card_set = '$set' AND uid = '$uid'";

        $results = mysqli_query( $conn, $query );

        if ( mysqli_num_rows($results) > 0 ) {

          // assign all elements to session array
          while ( $row = mysqli_fetch_assoc($results) ) {
            $_SESSION['current_fid'] = $current_fid = $row['fid'];
            $_SESSION['current_score'] = $current_score = $row['score'];

            $set_fids[ $current_fid ] = $current_score;

          }

          // array collection of cards
          $_SESSION['test_set'] = $set_fids;

          // assign number of cards
          $_SESSION['card_total'] = count($set_fids);
          $_SESSION['card_current'] = 1;
          $_SESSION['cards_correct'] = 0;

        }
      }
    
  } // end start testing

  // save RIGHT answer to database, update score up
  if ( isset( $_POST['right'] ) ) {
    $fid = validateFormData( $_POST['right'] );
    $new_score = $_SESSION['current_score'] + 1;

    $query = "UPDATE cards SET score = '$new_score' WHERE fid = '$fid' AND uid ='" . $_SESSION['uid'] . "'";

    $results = mysqli_query( $conn, $query);

    if ( $results ) {

      unset($_SESSION['test_set'][$fid]);
      // increment current card count
      $_SESSION["card_current"]++;
      $_SESSION["cards_correct"]++;
      header('Location: test.php');
    } else {
      echo "Error :" . mysql_error($conn);
    }
  }

  // save WRONG answer to database, update score to 1
  if ( isset( $_POST['wrong'] ) ) {
    $fid = validateFormData( $_POST['wrong'] );

    $query = "UPDATE cards SET score = 1 WHERE fid = '$fid' AND uid ='" . $_SESSION['uid'] . "'";

    $results = mysqli_query( $conn, $query);

    if ( $results ) {

      unset($_SESSION['test_set'][$fid]);
      // increment current card count
      $_SESSION["card_current"]++;
      header('Location: test.php');
    } else {
      echo "Error :" . mysql_error($conn);
    }
  }

} 


  include("includes/header.php");
?>

<div class="container well">
  <div class="row">
    <div class="col-md-12">
      <?php 

        // select first element in current set array
        $fid = key( $_SESSION['test_set'] );

        $query = "SELECT * FROM cards WHERE fid = '$fid' AND uid ='" . $_SESSION['uid'] . "'";

        $flashcard = mysqli_query( $conn, $query );        

        if ( $flashcard ) {

          while ( $row = mysqli_fetch_assoc($flashcard) ) {
            $_SESSION['current_score'] = $row['score'];
            $q = $row['question'];
            $a = $row['answer'];
            $fid = $row['fid'];

            echo '<h4>Question #' . $_SESSION["card_current"] . ' of ' . $_SESSION["card_total"] . '</h4><h5>Box ' . $_SESSION['current_score'] . '</h5><div class="jumbotron"><h2>' . $q . '</h2></div>';
            echo '<div class="answer"><h4>Answer : </h4><div class="jumbotron"><p>' . $a . '</p></div></div><button class="btn btn-info shown">Show Answer</button> <a href="cards.php?set=' . $_SESSION["set"] . '" class="btn btn-default shown">Cancel</a>';
          }
        } else {
          echo "Error :" . mysqli_error($conn);
        }

        if ( !mysqli_num_rows($flashcard) > 0 ) {
          echo "<div class='jumbotron'><h1>You got " . $_SESSION['cards_correct'] . " cards correct out of " . $_SESSION['card_total'] . "</h1></div><a href='cards.php?set=" . $_SESSION['set'] . "' class='btn btn-primary'>Return to Card Set</a>";
        }
        
      ?>
      <div class="container answer">
        <div class="row">
          <div class="col-md-1 col-sm-6 col-xs-6">
            <form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF']); ?>" method="POST" class="form-inline">
              <button class="btn btn-success rounded" type="submit" name="right" value="<?php echo $fid; ?>"><i class="fa fa-check"></i></button>
            </form>
          </div>
          <div class="col-md-1 col-sm-6 col-xs-6">
            <form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF']); ?>" method="POST" class="form-inline">
              <button class="btn btn-primary rounded" type="submit" name="wrong" value="<?php echo $fid; ?>"><i class="fa fa-times"></i></button>
            </form>
          </div>
          <div class="col-md-10">
            <a href="cards.php?set=<?php echo $_SESSION["set"]; ?>" class="btn btn-default">Cancel</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function() {

  function toggle() {
    $('.shown').toggle();
    $('.answer').toggle();
  }

  toggle();
  $('.shown').toggle();

  $('.shown').click(function() {
    toggle();
  });
});
</script>

<?php
  include("includes/footer.php");
?>
