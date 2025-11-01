<?php

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "dcsc";

  // Create connection
  $conn = mysqli_connect($servername, $username, $password, $dbname);

  // Check connection
  if ( mysqli_connect_error() ){
    die("Connection Failed: " . mysqli_connect_error());
  }

  echo "<b><br>DB Connection is Successful</b>"
?>
