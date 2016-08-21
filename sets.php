<?php
session_start();
include("includes/functions.php");

if ( isset( $_GET['added'] ) ) {
  $message = "Successfully added set";
}

if ( isset( $_GET['delete'] ) ) {

}

if ( $_SESSION["loggedIn"] ) {

  include("includes/connection.php");
  $uid = $_SESSION['uid'];

  $query = "SELECT * FROM cardset WHERE uid = '$uid'";

  $results = mysqli_query( $conn, $query );
}

include("includes/header.php");
?>

<div class="container well">
  <div class="row">
    <div class="col-md-12">
      <h1>Select Set :</h1>
      <a class="btn btn-success" href="addset.php">Add</a>
      <br><br>

      <table class="table table-bordered">
        <thead>
          <tr>
            <td><strong>No.</strong></td>
            <td><strong>Set</strong></td>
            <td><strong>Description</strong></td>
            <td>Options</td>
          </tr>
        </thead>
        <tbody>
          <?php
            if ( mysqli_num_rows($results) > 0 ) {

              $row_num = 0;
              while ( $row = mysqli_fetch_assoc($results) ) {
                $row_num = $row_num + 1;
                echo "<tr>
                  <td>" . $row_num . "</td>
                  <td>" . $row['set_name'] . "</td>
                  <td>" . $row['description'] . "</td>
                  <td>
                    <a href='editset.php?set=" . $row['set_name'] . "'>edit</a>
                    <a href='cards.php?set=" . $row['set_name'] . "' class='pull-right'>select</a>
                  </td>
                </tr>";
              }
            } else {
              $message = "You have no Card Sets, Click Add button";
            }

            mysqli_close($conn);
            ?>
        </tbody>
      </table>


      <?php if ( $message ) { echo "<div class='alert alert-success'>" . $message . "<a data-dismiss='alert' class='close'>&times;</a></div>"; } ?>
    </div>
  </div>
</div>
<script src="js/list.min.js"></script>

<?php

include("includes/footer.php");

?>
