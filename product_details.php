<?php

if (empty($_GET['pid'])) {
	header("location: products.php");
	exit();
}

include 'includes/header.php';

$productId = $_GET['pid'];

$hQuery = $mysqli->query("SELECT * FROM product WHERE productid='$productId'");

if (!$hQuery) {
	die("ERROR ".$mysqli->error);
}

if ($hQuery->num_rows == 0) {
	echo '<script>window.location="products.php";</script>';
	exit();
}

$product = $hQuery->fetch_assoc();

// Calculate product rating

$hQuery = $mysqli->query("SELECT COUNT(reviewid) FROM review WHERE productid='$productId'");
$row = $hQuery->fetch_array();
$total_votes = $row[0];
$total_rating = 0;
if ($total_votes > 0) {
	$hQuery = $mysqli->query("SELECT COUNT(reviewid) FROM review WHERE productid='$productId' AND rating='1'");
	$row = $hQuery->fetch_array();
	$stars_1 = $row[0];
	$hQuery = $mysqli->query("SELECT COUNT(reviewid) FROM review WHERE productid='$productId' AND rating='2'");
	$row = $hQuery->fetch_array();
	$stars_2 = $row[0];
	$hQuery = $mysqli->query("SELECT COUNT(reviewid) FROM review WHERE productid='$productId' AND rating='3'");
	$row = $hQuery->fetch_array();
	$stars_3 = $row[0];
	$hQuery = $mysqli->query("SELECT COUNT(reviewid) FROM review WHERE productid='$productId' AND rating='4'");
	$row = $hQuery->fetch_array();
	$stars_4 = $row[0];
	$hQuery = $mysqli->query("SELECT COUNT(reviewid) FROM review WHERE productid='$productId' AND rating='5'");
	$row = $hQuery->fetch_array();
	$stars_5 = $row[0];
	$total_rating = ($stars_1 + $stars_2 * 2 + $stars_3 * 3 + $stars_4 * 4 + $stars_5 * 5) / $total_votes;
}

?>
<div class="l-page">
<div class="main-content">
<ul class="oh-breadcrumb" style="margin:auto; margin-bottom:20px; width:1000px;">
    <li><a href="index.php">Home</a> <span class="divider">/</span></li>
    <li><a href="products.php">Items</a> <span class="divider">/</span></li>
    <li class="active"><?php echo $product['name']; ?></li>
</ul>
<div class="row banner" style="margin:auto; width:1000px; min-height:437px;">
	<div class="row-fluid">
		<div class="span5">
			<img src="images/products/<?php echo $product['image']; ?>" style="max-height:500px">
		</div>
		<div class="span7">
			<h3><?php echo $product['name']; ?></h3>
			<hr class="soft"/>
			
			<div class="form-horizontal qtyFrm">
				<div class="control-group">
					<label class="control-label"><span><?php echo $product['price']; ?> PHP</span></label>
				</div>

				<?php
				for($x=1;$x<=$total_rating;$x++) {
			        echo '<span class="star-static icon-star"></span>';
			    }
			    if (strpos($total_rating,'.')) {
			        echo '<span class="star-static icon-star-half"></span>&nbsp';
			        $x++;
			    }
			    while ($x<=5) {
			        echo '<span class="star-static icon-star-empty"></span>';
			        $x++;
			    }
			    if ($total_votes > 0)
			    	echo '&nbsp<font color="#ff7519">'.$total_rating.' out of 5</font>';
			    echo  ' <font color="#888">('.$total_votes.' Rating)</font>';
				?><br><br>

				<p><?php echo $product['description']; ?><p>
				<h3>Stock: <?php echo $product['stock']; ?></h3><br>
				<form action="cart.php?pid=<?php echo $product['productid']; ?>" method="POST" class="pull-left">
					<label class="pull-left" style="padding-top:5px"><b>Quantity</b></label>
					<input type="number" name="quantity" value="1" class="pull-right" max="<?php echo $product['stock']; ?>" style="width:40px"><br><br>
					<button type="submit" class="shopBtn pull-left" name="add-to-cart" <?php if ($product['stock'] == 0) echo "disabled"; ?>><span class=" icon-shopping-cart" ></span> Add to cart</button>
				</form><br><br>
				<form action="wishlist.php?pid=<?php echo $product['productid']; ?>" method="POST" class="pull-left" style="margin-left:10px">
				  	<button type="submit" class="shopBtn" name="add-to-wishlist"><span class=" icon-heart"></span> Add to Wish List</button>
				</form>
			</div>
		</div>
		<hr class="softn clr"/>

        <h4>Product Details</h4>
		<p><?php echo $product['details']; ?></p>
		<hr class="softn clr"/>

		<h4>Ratings & Review</h4><br>
		<?php
		$hQuery = $mysqli->query("SELECT * FROM review WHERE productid='$productId'");
		if (!$hQuery) {
			die("ERROR ".$mysqli->error);
		}
		if ($hQuery->num_rows > 0) {
			while ($review = $hQuery->fetch_assoc()) {
				$hQueryB = $mysqli->query("SELECT * FROM user WHERE id='".$review['userid']."'");
				if (!$hQueryB) {
					die("ERROR ".$mysqli->error);
				}
				if ($user = $hQueryB->fetch_assoc()) {
					echo '<p style="color:#888"><img class="avatar" src="images/users/'.$user['image'].'" alt="">'.$user['fname'].' '.$user['lname'].'</p>';
					for ($i = 1; $i <= 5; $i++) {
						echo '<span class="star-static icon-'.($i <= $review['rating'] ? 'star' : 'star-empty').'"></span>';
					}
					echo '<p style="color:#888">'.$review['reviewdate'].'</p>';
					echo '<p>'.$review['comment'].'</p><br>';
				}
			}
		} else {
			echo '<p style="color:#888">No ratings yet.</p>';
		}
		?>
		<hr class="softn clr"/>

		<h4>More Products</h4>
		<ul class="thumbnails">
			<?php
			$hQuery = $mysqli->query("SELECT productid, image, name, price FROM product ORDER BY productid DESC");
			if (!$hQuery) {
				die("ERROR: ".$mysqli->error);
			}
			while ($row = $hQuery->fetch_assoc()) {
				$product[] = $row;
			}

			// Generate 4 distinct random numbers
		  	$num[] = rand(0, ($product[0]['productid']-1));
		  	for ($i = 1; $i < 4; $i++) {
		  		do {
		  			$r = rand(0, ($product[0]['productid']-1));
		  		} while ($num[$i-1] == $r);
		  		$num[] = $r;
		  	}

			for ($i = 0; $i < 4; $i++) {
		  		echo
		  		'<li class="span3">
				  <div class="thumbnail">
					<a  href="product_details.php?pid='.$product[$num[$i]]['productid'].'"><img src="images/products/'.$product[$num[$i]]['image'].'" alt="" style="height:230px" ></a>
					<div class="caption">
					  <h5>'.$product[$num[$i]]['name'].'</h5>
					  <h4>
						  <a class="defaultBtn" href="product_details.php?pid='.$product[$num[$i]]['productid'].'" title="Click to view"><span class="icon-zoom-in"></span></a>
						  <span class="pull-right">'.$product[$num[$i]]['price'].' PHP</span>
					  </h4>
					</div>
				  </div>
				</li>';
		  	}
		?>
		</ul>
    </div>
</div>
</div>
</div>
<?php include 'includes/footer.php'; ?>