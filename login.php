<?php 
session_start();

$errors = array();

// initializing variables
$username = "root";
$errors = array();

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'dcsc');

if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);
  $_SESSION['myValue']=1;

  if (empty($username)) {
    array_push($errors, "Username is required");
  }
  if (empty($password)) {
    array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
    $password = md5($password);
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $results = mysqli_query($db, $query);
    if (mysqli_num_rows($results) == 1) {
      $_SESSION['username'] = $username;
      $_SESSION['success'] = "You are now logged in";
      header('location: home.php');
    }else {
      array_push($errors, "Wrong username/password combination");
    }
  }
}

?> 
<html>
<head>
  <title>Login - Vulnerable Web App</title>
  <link rel="stylesheet" type="text/css" href="logincss.css">
</head>
<body>
<div class="container">
	<div class="screen">
		<div class="screen__content">

			<form class="login" method="post">
				<div class="login__field">
					<i class="login__icon fas fa-user"></i>
					<input type="text" name="username" class="login__input" placeholder="Username">
				</div>
				<div class="login__field">
					<i class="login__icon fas fa-lock"></i>
					<input type="password" name="password" class="login__input" placeholder="Password">
				</div>
				<button type="submit" name="login_user" class="button login__submit">
					<span class="button__text">Log In Now</span>
					<i class="button__icon fas fa-chevron-right"></i>
				</button>
				<!-- Ensure the login_user field is always present for servers that don't send button names -->
				<input type="hidden" name="login_user" value="1">
			  	<p>
  				Create an account Here <a href="register.php">Sign up</a>
  	 			</p>
			</form>

		</div>
		<div class="screen__background">
			<span class="screen__background__shape screen__background__shape4"></span>
			<input type="hidden" name="verygood" value="am9lOmNhbnlvdWYxbmRtMw%3D%3D">
			<span class="screen__background__shape screen__background__shape3"></span>		
			<span class="screen__background__shape screen__background__shape2"></span>
			<span class="screen__background__shape screen__background__shape1"></span>
		</div>		
	</div>
</div>
</body>
</html>
