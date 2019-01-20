<?php

include '../includes/config.php';

if (empty($_SESSION['logged_in'])) {
	header("location: ../login.php");
}

$userId = $_SESSION['logged_in']['id'];

$hQuery = $mysqli->query("SELECT * FROM purchase WHERE userid='$userId'");

if (!$hQuery) {
	die("ERROR: ".$mysqli->error);
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
	<a class="logo" href="../index.php">
		<img src="../assets/img/company-logo.png" alt="Okay Happy">
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
<ul class="oh-breadcrumb" style="margin:auto; margin-bottom:20px; width:1000px;">
	<li><a href="../index.php">Home</a> <span class="divider">/</span></li>
	<li class="active">My Orders</li>
</ul>
<div class="row banner" style="margin:auto; width:1000px; min-height:437px;">
	<?php
	if ($hQuery->num_rows > 0) {
		while ($order = $hQuery->fetch_assoc()) {

			$hQueryB = $mysqli->query("SELECT * FROM product WHERE productid='".$order['productid']."'");

			if (!$hQueryB) {
				die("ERROR: ".$mysqli->error);
			}

			$product = $hQueryB->fetch_assoc();

			echo 
			'<div class="row-fluid">
				<div class="row-fluid">	  
					<div class="span2">
						<a href="../product_details.php?pid='.$product['productid'].'"><img src="../images/products/'.$product['image'].'" alt=""></a>
					</div>
					<div class="span6">
						<h5>'.$product['name'].'</h5>
						<p style="color:#888">'.$order['date'].'</p>
						<p>'.$order['name'].'</p>
						<p>'.$order['phone'].'</p>
						<p>'.$order['address'].'</p>
					</div>
					<div class="span4 alignR">
						<h3>'.$order['price'].' PHP</h3>
						<label>Quantity: '.$order['quantity'].'</label>
						<a href="review.php?pid='.$product['productid'].'" class="shopBtn" name="review">Write a Review</a>
					</div>
				</div>
				<hr class="soften">
			</div>';
		}
	} else {
		echo '<center><b>No purchased products</b></center>';
	}
	?>
</div>
</div>
</div>
<?php include '../includes/footer.php'; ?>