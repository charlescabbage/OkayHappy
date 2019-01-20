<?php include 'includes/header.php'; ?>
<div class="l-page oh-bg">
<div class="face-top"></div>
<div class="main-content main-first-floor">
	<div class="row banner">
		<div class="span3 pull-left">
			<h3><span class="icon-list-ul"></span> CATEGORIES</h3>
			<ul style="margin-left:15px">
				<?php
					for ($i = 0; $i < 9; $i++) {
						echo '<li class="category-item"><a href="products.php?c='.$category[$i]['categoryid'].'">'.$category[$i]['categoryname'].'</a></li>';
					}
				?>
				<li class="category-item"><a href="category.php">All Categories</a></li>
			</ul>
		</div>
		<div class="oh-promotion">
		    <div class="span3 pull-right">
		    	<div class="top-banner">Popular Categories</div>
		    	<a href="products.php?c=4" class="oh-promotion-item">
					<div class="title">Health & Personal Care</div>
					<div class="sub-title">Featured Top Products</div>
					<div class="view-more">View More</div>
				</a>
		    	<a href="products.php?c=7" class="oh-promotion-item">
					<div class="title">Makeup & Fragrances</div>
					<div class="sub-title">High Qualities</div>
					<div class="view-more">View More</div>
				</a>
		    	<a href="products.php?c=2" class="oh-promotion-item">
					<div class="title">Women's Bags</div>
					<div class="sub-title">Stylish Bags</div>
					<div class="view-more">View More</div>
				</a>
			</div>
		</div>
		<div id="myCarousel" class="carousel slide homCar">
	        <div class="carousel-inner">
			  <div class="item">
	            <img style="width:100%" src="assets/img/carousel3.png">
	          </div>
			  <div class="item active">
			  	<a href="products.php?c=5">
	            	<img style="width:100%" src="assets/img/carousel1.png">
	        	</a>
	            <div class="carousel-caption">
	                  <h4>OKAY HAPPY</h4>
	                  <p><span>Tasty Grocery Treats</span></p>
	            </div>
	          </div>
	          <div class="item">
			  	<a href="products.php?c=4">
	            	<img style="width:100%" src="assets/img/carousel2.png">
	            </a>
	            <div class="carousel-caption">
	                  <h4>OKAY HAPPY</h4>
	                  <p><span>Health & Personal Care</span></p>
	            </div>
	          </div>
	        </div>
	        <a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
	        <a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
	    </div>
	</div>
</div>
<!--
New Products
-->
<?php
$hQuery = $mysqli->query("SELECT productid, image, name, price FROM product ORDER BY productid DESC");
if (!$hQuery) {
	die("ERROR: ".$mysqli->error);
}
while ($row = $hQuery->fetch_assoc()) {
	$product[] = $row;
}
?>
<div class="main-content main-second-floor">
	<div class="row banner">
		<h3>New Products </h3>
		<hr class="soften"/>
			<div class="row-fluid">
			<div id="newProductCar" class="carousel slide">
	            <div class="carousel-inner">
				<div class="item active">
					<ul class="thumbnails">
						<?php
						for ($i = 0; $i < 4; $i++) {
							echo 
						'<li class="span3">
						<div class="thumbnail">
							<a href="product_details.php?pid='.$product[$i]['productid'].'"><img src="images/products/'.$product[$i]['image'].'" alt="" style="height:300px"></a>
						</div>
						</li>';
						}
					?>
					</ul>
				</div>
				<div class="item">
					<ul class="thumbnails">
					<?php
						for ($i = 4; $i < 8; $i++) {
							echo 
						'<li class="span3">
						<div class="thumbnail">
							<a href="product_details.php?pid='.$product[$i]['productid'].'"><img src="images/products/'.$product[$i]['image'].'" alt="" style="height:300px"></a>
						</div>
						</li>';
						}
					?>
					</ul>
				</div>
			    </div>
			  <a class="left carousel-control" href="#newProductCar" data-slide="prev">&lsaquo;</a>
	            <a class="right carousel-control" href="#newProductCar" data-slide="next">&rsaquo;</a>
			</div>
		</div>
	</div>
</div>
<!--
Featured Products
-->
<div class="main-content main-third-floor">
	<div class="row banner">
		<h3>Featured Products</h3>
		<hr class="soften"/>
		  <div class="row-fluid">
		  <ul class="thumbnails">
		  	<?php
		  	// Generate 3 distinct random numbers
		  	$num[] = rand(0, ($product[0]['productid']-1));
		  	for ($i = 1; $i < 3; $i++) {
		  		do {
		  			$r = rand(0, ($product[0]['productid']-1));
		  		} while ($num[$i-1] == $r);
		  		$num[] = $r;
		  	}

		  	for ($i = 0; $i < 3; $i++) {
		  		echo
		  		'<li class="span4">
				  <div class="thumbnail">
					<a  href="product_details.php?pid='.$product[$num[$i]]['productid'].'"><img src="images/products/'.$product[$num[$i]]['image'].'" alt="" style="height:350px" ></a>
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