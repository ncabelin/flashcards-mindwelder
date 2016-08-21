<!DOCTYPE html>
<?php
  
  /*
  ini_set('display_startup_errors', 1);
  ini_set('display_errors', 1);
  error_reporting(-1);
  */

?>
<html lang="en">
<head>
  <title>Mindwelder</title>
  <meta charset="utf-8">
  <meta content="IE-edge" http-equiv="X-UA-Compatible">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
  <!-- <link href="css/style.css" rel="stylesheet"> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.min.js"></script>
  <script src="https://code.angularjs.org/1.5.7/angular-route.min.js"></script>
  <script src="https://www.gstatic.com/firebasejs/live/3.0/firebase.js"></script>

  <style>
    .navbar {min-height: 80px;}
    .navbar-brand {padding: 10px 15px 5px 15px; height: 50px; line-height: 80px; font-size: 2.0em;}
    .navbar-toggle { margin-top: 20px; }
    .navbar-nav {padding: 20px 15px;}
    .bordered {
      background-color: rgba(0,0,0,0);
      border: 1px solid black;
    }
    .rounded {
      border-radius: 100%;
    }
    body {
      background: linear-gradient(
  rgba(255, 255, 255, 0.5),
  rgba(255, 255, 255, 0.5)
  ),url(images/sky2.jpg) fixed center no-repeat;
      background-size: cover;
      color: black;
    }

  </style>
</head>

<body>
  <nav class="navbar navbar-default">
    <div class="container-fluid">

      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php"><img src="images/logo_sideways.png" class="navbar-brand"></a>
      </div>

      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right text-center">
          <?php if ( $_SESSION["loggedIn"] ) { ?>
            <li><a href="cards.php" class="menuItem"><?php echo "User : " . $_SESSION["user_logged_in"] ?></a></li>
            <li><a href="login.php?logout=true" class="menuItem">Log-out</a></li>
          <?php } else { ?>
            <li><a href="login.php" class="menuItem">Log-in</a></li>
          <?php } ?>
          <li><a href="help.php" class="menuItem">Help</a></li>
          <li><a href="about.php" class="menuItem">About</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
