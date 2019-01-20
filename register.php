<?php

include 'includes/config.php';

if (isset($_SESSION['logged_in'])) {
	header("location: index.php");
}

if (isset($_POST['register'])) {

	$strEmail = $_POST['email'];
	$strFname = $_POST['fname'];
	$strLname = $_POST['lname'];
	$strPassword = $_POST['password'];

	$hQuery = $mysqli->query("SELECT * FROM user WHERE email='$strEmail'");

	if(!$hQuery) {
		die("ERROR: ".$mysqli->error);
	}

	if ($hQuery->num_rows > 0) {
		$registered = false;
		while ($row = $hQuery->fetch_assoc()) {
			$registered = $registered || $row['active'];
		}
		if ($registered) {
			header("location: register.php?response=failed&class=alert-danger&message=Email is already registered");
			exit();
		}
	}

	if ($_POST['confirm_password'] != $strPassword) {
		header("location: register.php?response=failed&class=alert-danger&message=Password did not match");
		exit();
	}

	$salt = fetch_user_salt(3);
	$strPasswordHash = md5(md5($strPassword).$salt);

	$mysqli->query("INSERT INTO user VALUES (NULL, 2, '$strEmail', '$strFname', '$strLname', '', '$strPasswordHash', '$salt', 'blank.png', '1')");

	// Automatically sign in user

	$hQuery = $mysqli->query("SELECT * FROM user WHERE email='$strEmail' AND active='1'");

	if(!$hQuery) {
		die("ERROR: ".$mysqli->error);
	}

	if ($hQuery->num_rows == 0) {
		header("location: login.php");
		exit();
	}

	$row = $hQuery->fetch_assoc();

	$strPasswordHash = md5(md5($strPassword).$row['salt']);
	if ($strPasswordHash != $row['password']) {
		header("location: login.php");
		exit();
	}

	$_SESSION['logged_in'] = $row;

	header("location: index.php");

}

function fetch_user_salt($length = 3)
{
    $salt = '';
    for ($i = 0; $i < $length; $i++)
    {
        $salt .= chr(rand(33, 126));
    }
    return $salt;
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Okay Happy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Bootstrap styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet"/>
    <!-- Customize styles -->
    <link href="assets/css/style.css" rel="stylesheet"/>
    <!-- font awesome styles -->
	<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
		<!--[if IE 7]>
			<link href="css/font-awesome-ie7.min.css" rel="stylesheet">
		<![endif]-->

		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

	<!-- Favicons -->
    <link rel="shortcut icon" href="favicon.ico">
  </head>
<body>
<!--
Header Section 
-->
<div class="container">
<div id="gototop"> </div>
<div class="oh-hd">
<header class="oh-hd-header">
<div class="row">
	<div class="span3"></div>
	<div class="span3">
	<h1>
	<a class="logo" href="index.php">
		<img src="assets/img/company-logo.png" alt="Okay Happy">
	</a>
	</h1>
	</div>
</div>
</header>
</div>
<!-- 
Body Section 
-->
<div class="l-page">
<div class="main-content">
	<div class="left-form" style="margin-left: 180px">
		<div class="form-head">
			<h3>Create a New Account</h3>
		</div>
		<form class="form-detail" method="POST">
			<?php
			if (isset($_GET['message'])) {
				echo '<div class="alert '.$_GET['class'].'">'.$_GET['message'].'</div>';
			}
	        ?>
			<div class="control-group">
				<label class="control-label" for="inputEmail">Email address:</label>
				<div class="controls">
				  <input type="email" placeholder="Email address" name="email" required>
				</div>
		  	</div>
			<div class="control-group">
				<label class="control-label" for="inputName">Name:</label>
				<div class="controls">
				  <input type="text" id="inputFname" placeholder="First Name" name="fname" required>
				  <input type="text" id="inputLname" placeholder="Last Name" name="lname" required>
				</div>
			 </div>
			<div class="control-group">
				<label class="control-label">Password:</label>
				<div class="controls">
				  <input type="password" placeholder="6-20 characters" minLength="6" maxlength="20" name="password" required>
				</div>
		  	</div>
			<div class="control-group">
				<label class="control-label">Confirm password:</label>
				<div class="controls">
				  <input type="password" placeholder="Enter password again" maxlength="20" name="confirm_password" required>
				</div>
		  	</div>
			<div class="control-group">
				<div class="controls">
				  <input type="checkbox" name="agree" checked required>
				  I agree to the Okay Happpy Membership Agreement. <a href="article/agreement.php">View Agreement</a>
				</div>
		  	</div>
		  	<br>
			<div class="control-group">
				<div class="controls">
				 <input type="submit" name="register" value="Create Your Account" class="exclusive shopBtn">
				</div>
			</div>
		</form>
	</div>
</div>
</div>
<?php include 'includes/footer.php'; ?>