<?php

$server = 'localhost';
$username = 'root';
$pwd = 'root';
$db = 'cards';

// create connection

$conn = mysqli_connect( $server, $username, $pwd, $db );

if ( !$conn ) {
  die( 'Connection failed: ' . mysqli_connect_error() );
}

 ?>
