<?php

include '../includes/config.php';

if (isset($_SESSION['logged_in'])) {
	if ($_SESSION['logged_in']['groupid'] != 1) {
		header("location: ../");
	}
} else {
	header("location: ../login.php");
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
    <link href="../assets/css/bootstrap.css" rel="stylesheet"/>
    <!-- W3 styles -->
    <link href="../assets/css/w3.css" rel="stylesheet"/>
    <!-- Customize styles -->
    <link href="../assets/css/style.css" rel="stylesheet"/>
    <!-- font awesome styles -->
	<link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet">
		<!--[if IE 7]>
			<link href="css/font-awesome-ie7.min.css" rel="stylesheet">
		<![endif]-->

		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

	<!-- Favicons -->
    <link rel="shortcut icon" href="../favicon.ico">
  </head>
<body>

<!-- Sidebar -->
<div class="w3-sidebar w3-bar-block" style="background:#262e32; color:#fff; width:17%">
	<div class="w3-bar-item">
		<a class="logo" href="../index.php">
			<img src="../assets/img/company-logo.png" alt="Okay Happy">
		</a>
	</div>
	<br><br>
	<a href="index.php" class="w3-bar-item w3-button">Control Panel Home</a>
	<a href="orders.php" class="w3-bar-item w3-button">Orders</a>
	<a href="products.php" class="w3-bar-item w3-button">Products</a>
	<a href="sales.php" class="w3-bar-item w3-button">Sales</a>
	<a href="users.php" class="w3-bar-item w3-button">Users</a>
</div>