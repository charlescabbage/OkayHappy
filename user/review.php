<?php

include '../includes/config.php';

if (empty($_SESSION['logged_in'])) {
	header("location: ../login.php");
}

$userId = $_SESSION['logged_in']['id'];

if (isset($_POST['submit'])) {
	$rating = $_POST['rating'];
	$review = mysqli_escape_string($mysqli, $_POST['review']);
	$productId = $_POST['productid'];

	$hQuery = $mysqli->query("SELECT * FROM review WHERE userid='$userId' AND productid='$productId'");
	if (!$hQuery) {
		die("ERROR: ".$mysqli->error);
	}

	if ($hQuery->num_rows > 0) {
		$hQuery = $mysqli->query("UPDATE review SET rating='$rating', comment='$review', reviewdate=NOW() WHERE userid='$userId' AND productid='$productId'");
		if (!$hQuery) {
			die("ERROR: ".$mysqli->error);
		}
	} else {
		$hQuery = $mysqli->query("INSERT INTO review VALUES (NULL, '$userId', '$productId', '$rating', '$review', NOW())");
		if (!$hQuery) {
			die("ERROR: ".$mysqli->error);
		}
	}
}

$hQuery = $mysqli->query("SELECT * FROM review WHERE userid='$userId'");

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
	<li class="active">My Reviews</li>
</ul>
<div class="row banner" style="margin:auto; width:1000px; min-height:437px;">
	<?php

	$allowReview = false;
	if (isset($_GET['pid'])) {
		$hQueryB = $mysqli->query("SELECT * FROM purchase WHERE userid='$userId' AND productid='".$_GET['pid']."'");
		if ($hQueryB->num_rows > 0) {
			$allowReview=true;
		}
	}

	if ($allowReview) {

		$hQueryB = $mysqli->query("SELECT * FROM product WHERE productid='".$_GET['pid']."'");

		if (!$hQueryB) {
			die("ERROR: ".$mysqli->error);
		}

		$product = $hQueryB->fetch_assoc();

		$review['rating'] = 5;
		$review['comment'] = '';
		while ($row = $hQuery->fetch_assoc()) {
			if ($row['productid'] == $product['productid']) {
				$review = $row;
			}
		}

		echo 
		'<form method="POST" action="review.php">
			<div class="row-fluid">
				<div class="span2">
					<a href="../product_details.php?pid='.$product['productid'].'"><img src="../images/products/'.$product['image'].'" alt=""></a>
				</div>
				<div class="span9">
					<h5>'.$product['name'].'</h5>
					<div class="rating">
						<input type="radio" id="star5" name="rating" value="5" '.($review['rating'] == 5 ? 'checked' : '').'/><label for="star5" title="Excellent"></label>
					    <input type="radio" id="star4" name="rating" value="4" '.($review['rating'] == 4 ? 'checked' : '').'/><label for="star4" title="Very Good"></label>
					    <input type="radio" id="star3" name="rating" value="3" '.($review['rating'] == 3 ? 'checked' : '').'/><label for="star3" title="Good"></label>
					    <input type="radio" id="star2" name="rating" value="2" '.($review['rating'] == 2 ? 'checked' : '').'/><label for="star2" title="Poor"></label>
					    <input type="radio" id="star1" name="rating" value="1" '.($review['rating'] == 1 ? 'checked' : '').'/><label for="star1" title="Bad"></label>
					</div>
					<textarea class="review-field" name="review" maxLength="1000" placeholder="Write your review about this product.">'.$review['comment'].'</textarea>
					<button class="shopBtn" name="submit">Submit</button>
					<a href="review.php" class="danger-btn">Cancel</a>
					<input name="productid" value="'.$_GET['pid'].'" hidden>
				</div>
			</div>
		</form>';

	} else if ($hQuery->num_rows > 0) {

		while ($review = $hQuery->fetch_assoc()) {

			$hQueryB = $mysqli->query("SELECT * FROM product WHERE productid='".$review['productid']."'");

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
						<h5>'.$product['name'].'</h5>';

			for ($i = 1; $i <= 5; $i++) {
				echo '<span class="star-static icon-'.($i <= $review['rating'] ? 'star' : 'star-empty').'"></span>';
			}

			echo
			'<br><br><p>'.$review['comment'].'</p>
					</div>
					<div class="span4 alignR"><label>'.$review['reviewdate'].'</label><a href="?pid='.$product['productid'].'" class="shopBtn">Edit</a></div>
				</div>
				<hr class="soften">
			</div>';
		}

	} else {
		echo '<center><b>No product reviews</b></center>';
	}
	?>
</div>
</div>
</div>
<?php include '../includes/footer.php'; ?>