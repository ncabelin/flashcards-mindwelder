<?php
session_start();
include("includes/functions.php");

if ( $_SESSION["loggedIn"] ) {
  if ( isset( $_GET['added'] ) ) {
    $message = "Succesfully added card";
  }

  if ( isset( $_GET['set'] ) ) {
    $set = $_SESSION['set'] = validateFormData($_GET['set']);
  }

  include("includes/connection.php");
  $uid = $_SESSION['uid'];

  $query = "SELECT * FROM cards WHERE uid = '$uid' AND card_set = '$set'";

  $results = mysqli_query( $conn, $query );
}

include("includes/header.php");
?>

<div class="container well">
  <div class="row">
    <div class="col-md-12" id="cards">
      <h1><?php echo $_SESSION['set']; ?> set</h1>
      <div class="container">
        <div class="row">
          <div class="col-lg-4">
            <a class="btn btn-success" href="addcards.php">Add</a>
            <a class="btn btn-default" href="test.php?action=start">Test All</a>
          </div>
          <div class="form-group col-lg-4">
            <input type="text" class="search form-control" placeholder="Search">
          </div>
          <div class="col-lg-4">
            <button class="sort btn btn-info" data-sort="date_added">Sort by Date Added</button>
            <button class="sort btn btn-info" data-sort="box">Sort by Box</button>
          </div>
        </div>
      </div>
      <br><br>
      <table class="table table-bordered">
        <thead>
          <tr>
            <td><strong>No.</strong></td>
            <td><strong>Question</strong></td>
            <td><strong>Answer</strong></td>
            <td><strong>Options</strong></td>
            <td><strong>Box</strong></td>
          </tr>
        </thead>
        <tbody class="list">
          <?php
            if ( mysqli_num_rows($results) > 0 ) {

              // add test box #

              $row_num = 0;
              while ( $row = mysqli_fetch_assoc($results) ) {
                $row_num = $row_num + 1;
                echo "<tr>
                  <td class='date_added'>" . $row_num . "</td>
                  <td class='questions'>" . $row['question'] . "</td>
                  <td class='answers'>" . $row['answer'] . "</td>
                  <td>
                    <a href='editcard.php?fid=" . $row['fid'] . "'>edit</a>
                  </td>
                  <td class='box'>" . $row['score'] . "</td>
                </tr>";
              }


            } else {
              $message = "You have no Flash Cards, Click Add button";
            }

            ?>
        </tbody>
      </table>
      <?php if ( $message ) { echo "<div class='alert alert-success'>" . $message . "</div>"; } ?>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div id="finished">
      </div>
    </div>
  </div>
</div>
<script src="js/list.min.js"></script>
<script>
$(document).ready(function() {
  var options = { valueNames: [ 'date_added', 'box', 'questions', 'answers' ] };
  var userList = new List('cards', options);
});
</script>

<?php

include("includes/footer.php");

?>
