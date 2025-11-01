<html>
<head>
  <title>Contact - 1 Piece Rubiks Cube</title>
  <link rel="stylesheet" type="text/css" href="homecss.css">
</head>
<body>
<div class="header">
  <h1>1 Piece Rubiks cube</h1>
</div>

<div class="topnav">
  <a href="home.php">Home</a>
  <a href="contact.php">Contact</a>
  <a href="logout.php" class="btn btn-info btn-lg" name="logout">Logout</a>
</div>

<div class="footer">
  <h2>Have Feedback? Submit it to us below!</h2>
    <form id="feedback" method="post">
      Name: <input type="text" name="name"><br><br>
      Feedback:<br><textarea name="feedback" placeholder="Enter feedback here"></textarea><br>
      <input type="submit" value="submit" name="submit">
    </form>
</div>
</body>
</html>

<?php
// CHALLENGE 3: This page is vulnerable to SQL injection
// The feedback form does not properly sanitize input

require 'dbconn.php';

$name =  $_POST['name'] ?? '';
$feedback = $_POST['feedback'] ?? '';

if(isset($_POST['submit']))
{
  if ($conn->connect_error){
    $errorMsg = "Connection Failed: " . $conn->connect_error;
    exit();
  }

  else{
    // Intentionally vulnerable - using direct string concatenation (SQL injection possible)
    // WARNING: This is unsafe and only for local testing / challenge purposes.
    $sql = "INSERT INTO feedback (name, feedback) VALUES ('" . $name . "', '" . $feedback . "')";

    if (mysqli_query($conn, $sql)) {
      echo "Feedback submitted successfully!";
      exit();
    } else {
      echo "DB Error: " . mysqli_error($conn);
      exit();
    }
  }
}

if(isset($stmt)) {
  mysqli_stmt_close( $stmt );
}
if(isset($conn)) {
  mysqli_close( $conn ); 
}
?>
