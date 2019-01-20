<?php

include 'includes/config.php';

if (isset($_SESSION['logged_in'])) {
	$userId = $_SESSION['logged_in']['id'];
}

$hQuery = $mysqli->query("SELECT * FROM category");

if(!$hQuery) {
    die("ERROR: ".$mysqli->error);
}

while ($row = $hQuery->fetch_assoc()) {
	$category[] = $row;
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
	<div class="span3">
	<h1>
	<a class="logo" href="index.php">
		<img src="assets/img/company-logo.png" alt="Okay Happy">
	</a>
	</h1>
	</div>
</div>
<div class="row">
<div class="navbar" >
	<div class="container">
		<div class="nav-collapse">
			<div class="span3 pull-left">
				<ul class="nav pull-left">
				<li class="dropdown oh-dropdown">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#"><span class="icon-list-ul"></span> Categories <b class="caret"></b></a>
					<div class="dropdown-menu" style="width:300px;border-radius:0">
						<ul style="list-style-type:none">
							<?php
							for ($i = 0; $i < 9; $i++) {
								echo '<li class="category-hd-item"><a href="products.php?c='.$category[$i]['categoryid'].'">'.$category[$i]['categoryname'].'<span class="icon-chevron-right pull-right"></span></a></li>';
							}
							?>
							<li class="category-hd-item"><a href="category.php">All Categories <span class="icon-chevron-right pull-right"></span></a></li>
						</ul>
					</div>
				</li>
				</ul>
			</div>
			<div class="column pull-left">
				<form action="products.php" class="navbar-search" style="width:100%;">
				  <input type="text" placeholder="What are you looking for..." class="search-query span10" name="s" <?php if (isset($_GET['s'])) echo 'value="'.$_GET['s'].'"';?> style="border:2px solid #FF6A00;">
				  <button type="submit" class="oh-searchbar-submit" name="c" <?php if (isset($_GET['c'])) echo 'value="'.$_GET['c'].'"';?> ><span class="icon-search"></span> Search</button>
				</form>
			</div>
			<div class="column pull-right">
				<ul class="nav pull-right">
				<li class="dropdown oh-dropdown">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#"><span class="icon-shopping-cart"></span> Cart </a>
					<div class="dropdown-menu" style="width:225px;padding:16px 20px 10px 20px">
						<?php
						if (isset($_SESSION['logged_in'])) {

							$hQueryA = $mysqli->query("SELECT * FROM cart WHERE userid='$userId' GROUP BY productid");
						    if(!$hQueryA) {
						        die("ERROR: ".$mysqli->error);
						    }

						    $cartSummary = array();
						    while ($row = $hQueryA->fetch_assoc()) {
						        $hQueryB = $mysqli->query("SELECT * FROM product WHERE productid = '".$row['productid']."'");
						        if ($product = $hQueryB->fetch_assoc()) {
						            $cartSummary[] = array($product['productid']);
						        }
						    }

							echo '<p class="oh-hd-fav">Items in Cart</p>';
							echo '<ul class="thumbnails">';
							for ($i = 0; $i < 2; $i++) {
								if (isset($cartSummary[$i])) {
									$hQueryB = $mysqli->query("SELECT * FROM product WHERE productid = '".$cartSummary[$i][0]."'");
			                    	if ($product = $hQueryB->fetch_assoc()) {
										echo
										'<li class="pull-left" style="width:100px;">
											<div class="thumbnail">
								 			<a href="product_details.php?pid='.$product['productid'].'"><img class="product-img" src="images/products/'.$product['image'].'" alt="" style="height:125px"></a>
											</div>
										</li>';
			                    	}
								}
							}
							echo '</ul>';
						}
						?>
						<a href="cart.php" class="shopBtn btn-block">View all items</a>
						<?php if (!isset($_SESSION['logged_in'])) { ?>
						<br><br>
						<p><a href="login.php">Sign In</a> to manage and view all items.</p>
						<?php } ?>
					</div>
				</li>
				</ul>
			</div>
			<div class="column pull-right">
				<ul class="nav pull-right">
				<li class="dropdown oh-dropdown">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#"><span class="icon-heart"></span> Wish List </a>
					<div class="dropdown-menu" style="width:225px;padding:16px 20px 10px 20px">
						<?php
						if (isset($_SESSION['logged_in'])) {
							$hQuery = $mysqli->query("SELECT * FROM wishlist WHERE userid = '$userId'");
							if(!$hQuery) {
							    die("ERROR: ".$mysqli->error);
							}

							echo '<p class="oh-hd-fav">Favorite Products</p>';
							echo '<ul class="thumbnails">';
							for ($i = 0; $i < 2; $i++) {
								if ($w = $hQuery->fetch_assoc()) {
									$hQueryB = $mysqli->query("SELECT * FROM product WHERE productid = '".$w['productid']."'");
			                    	if ($product = $hQueryB->fetch_assoc()) {
										echo
										'<li class="pull-left" style="width:100px;">
											<div class="thumbnail">
								 			<a href="product_details.php?pid='.$product['productid'].'"><img class="product-img" src="images/products/'.$product['image'].'" alt="" style="height:125px"></a>
											</div>
										</li>';
			                    	}
								}
							}
							echo '</ul>';
						}
						?>
						<a href="wishlist.php" class="shopBtn btn-block">View all items</a>
						<?php if (!isset($_SESSION['logged_in'])) { ?>
						<br><br>
						<p><a href="login.php">Sign In</a> to manage and view all items.</p>
						<?php } ?>
					</div>
				</li>
				</ul>
			</div>
			<div class="column pull-right">
				<ul class="nav pull-right">
				<li class="dropdown oh-dropdown">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">
						<?php
						if (isset($_SESSION['logged_in']))
							echo '<img class="avatar" src="images/users/'.$_SESSION['logged_in']['image'].'">';
						else
							echo '<span class="icon-user"></span>&nbsp';
						?><div class="pull-right">My Account</div>
					</a>
					<div class="dropdown-menu" style="width:250px; font-size: 14px; color:#656565; padding-bottom:0">
						<div class="control-group" style="padding:20px">
							<?php
							if (isset($_SESSION['logged_in'])) {
								echo "Hi ".$_SESSION['logged_in']['fname'];
							?>
							<a href="signout.php" class="pull-right">Sign Out</a>
							<?php } else { ?>
						  	Welcome to Okay Happy!
							<a href="login.php" class="shopBtn btn-block">Sign in</a>
						  	<hr>
						  	New customer?
							<a href="register.php" class="danger-btn btn-block">Join now</a>
							<?php } ?>
						</div>
						<div class="oh-entry-group">
							<a class="oh-hd-entry" href="user/orders.php">My Orders</a>
							<a class="oh-hd-entry" href="user/review.php">My Reviews</a>
							<a class="oh-hd-entry" href="user/address.php">My Address</a>
							<a class="oh-hd-entry" href="user/profile.php">My Profile</a>
							<?php
							if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']['groupid'] == 1) {
								echo '<a class="oh-hd-entry" href="admin">Admin CP</a>';
							}
							?>
						</div>
					</div>
				</li>
				</ul>
			</div>
		</div>
	</div>
</div>
</div>
</header>
</div>
<!-- 
Body Section 
-->