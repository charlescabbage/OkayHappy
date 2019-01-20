<?php

include 'includes/config.php';

if (isset($_SESSION['logged_in'])) {
	header("location: index.php");
}

if (isset($_POST['login'])) {

	$strEmail = $_POST['email'];
	$strPassword = $_POST['password'];

	$hQuery = $mysqli->query("SELECT * FROM user WHERE email='$strEmail' AND active='1'");

	if(!$hQuery) {
	    die("ERROR: ".$mysqli->error);
	}

	if ($hQuery->num_rows == 0) {
		header("location: login.php?response=failed&class=alert-danger&message=Invalid email or password");
		exit();
	}

	$row = $hQuery->fetch_assoc();

	$strPasswordHash = md5(md5($strPassword).$row['salt']);
	if ($strPasswordHash != $row['password']) {
		header("location: login.php?response=failed&class=alert-danger&message=Invalid email or password");
		exit();
	}

	$_SESSION['logged_in'] = $row;

	header("location: index.php");
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
<div class="l-page login-bg">
<div class="main-content">
	<div class="row login-form">
		<form method="POST">
		<?php
		if (isset($_GET['message'])) {
			echo '<div class="alert '.$_GET['class'].'">'.$_GET['message'].'</div>';
		}
        ?>
		  <div class="control-group">
			<label class="control-label" for="inputEmail"><b>Email:</b></label>
			<div class="controls">
			  <input class="input-block-level"  type="email" placeholder="Email address" name="email" required>
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="inputPassword"><b>Password:</b></label>
			<div class="controls">
			  <input type="password" id="inputPassword" class="input-block-level" placeholder="Password" name="password" maxLength="65" required>
			  <span id="eye" class="pull-right icon-eye-open" onClick="togglePassword()" style="margin-right:10px; margin-top:-32px; position:relative"></span>
			</div>
		  </div>
		  <div class="control-group">
			<div class="controls">
			 <input type="submit" name="login" value="Sign in" class="shopBtn btn-block">
			</div>
		  </div>
		  New customer? <a href="register.php">Join now!</a>
		</form>
	</div>
	<h3 class="banner-title">Smarter Shopping</h3>
	<h3 class="banner-title">Better Living!</h3>
	<ul class="banner-text">
		<li>Choose from dozen of different categories</li>
		<li>with many products</li>
	</ul>
</div>
</div>
<?php include 'includes/footer.php'; ?>