<?php

include 'includes/header.php';

if (isset($_GET['s'])) {
    $strSearch = mysqli_real_escape_string($mysqli, $_GET['s']);
	$keys = explode(" ", $strSearch);
	$keywords = "";
	foreach($keys as $k){
	    $keywords .= " AND name LIKE '%$k%' ";
	}
} else {
    $strSearch = "";
}

if (isset($_GET['c'])) {
    $strCategory = $_GET['c'];
} else {
    $strCategory = "";
}

?>
<div class="l-page">
<div class="main-content">
<ul class="oh-breadcrumb" style="margin:auto; margin-bottom:20px; width:1000px;">
	<li><a href="index.php">Home</a> <span class="divider">/</span></li>
	<li><a href="products.php">Items</a> <span class="divider">></span></li>
	<?php
	if ($strCategory > 0) {
		$categoryName = $category[$strCategory-1]['categoryname'];
		// Search keyword cannot be "empty"
		if ($strSearch != "" && $strSearch != " ") {
			echo '<li class="active">Search in '.$categoryName.'</li>';
		} else {
			// This is fine as long as categoryid is auto-incremental and continuous
			echo '<li class="active">'.$categoryName.'</li>';
		}
	} else {
		echo '<li class="active">All Products</li>';
	}
	?>
</ul>
<div class="row banner" style="margin:auto; width:1000px; min-height:437px;">
	<div class="row-fluid">
		<?php
		if ($strCategory != "") {
			// Search keyword cannot be "empty"
			if ($strSearch != "" && $strSearch != " ") {
				$hQuery = $mysqli->query("SELECT COUNT(productid) FROM product WHERE category='$strCategory' AND name LIKE '%$strSearch%'$keywords");
			} else {
				$hQuery = $mysqli->query("SELECT COUNT(productid) FROM product WHERE category='$strCategory'");
			}
		// Search keyword cannot be "empty"
		} else if ($strSearch != "" && $strSearch != " ") {
			$hQuery = $mysqli->query("SELECT COUNT(productid) FROM product WHERE name LIKE '%$strSearch%'$keywords");
		} else {
			$hQuery = $mysqli->query("SELECT COUNT(productid) FROM product");
		}

		if(!$hQuery) {
		    die("ERROR: ".$mysqli->error);
		}

		$row = $hQuery->fetch_array();
		$rec_count = $row[0];
		$rec_limit = 12;

		if ($rec_count > 0) {

			$total_pages = ceil($rec_count / $rec_limit);

			if (isset($_GET['p'])) {
			    $page = intval($_GET['p']);
			    if ($page > 0) $page -= 1;
			    $offset = $rec_limit * $page;
			} else {
			    $page = 0;
			    $offset = 0;
			}

			if ($strCategory != "") {
				// Search keyword cannot be "empty"
				if ($strSearch != "" && $strSearch != " ") {
					$hQuery = $mysqli->query("SELECT * FROM product WHERE category='$strCategory' AND name LIKE '%$strSearch%'$keywords LIMIT $offset, $rec_limit");
				} else {
					$hQuery = $mysqli->query("SELECT * FROM product WHERE category='$strCategory' LIMIT $offset, $rec_limit");
				}
			// Search keyword cannot be "empty"
			} else if ($strSearch != "" && $strSearch != " ") {
				$hQuery = $mysqli->query("SELECT * FROM product WHERE name LIKE '%$strSearch%'$keywords LIMIT $offset, $rec_limit");
			} else {
				$hQuery = $mysqli->query("SELECT * FROM product LIMIT $offset, $rec_limit");
			}

			for ($i = 0; $i < 3; $i++) {
				echo '<ul class="thumbnails">';
				for ($j = 0; $j < 4; $j++) {
					if ($product = $hQuery->fetch_assoc()) {

						$hQueryB = $mysqli->query("SELECT COUNT(reviewid) FROM review WHERE productid='".$product['productid']."'");
						$row = $hQueryB->fetch_array();
						$total_votes = $row[0];
						$total_rating = 0;
						if ($total_votes > 0) {
							$hQueryB = $mysqli->query("SELECT COUNT(reviewid) FROM review WHERE productid='".$product['productid']."' AND rating='1'");
							$row = $hQueryB->fetch_array();
							$stars_1 = $row[0];
							$hQueryB = $mysqli->query("SELECT COUNT(reviewid) FROM review WHERE productid='".$product['productid']."' AND rating='2'");
							$row = $hQueryB->fetch_array();
							$stars_2 = $row[0];
							$hQueryB = $mysqli->query("SELECT COUNT(reviewid) FROM review WHERE productid='".$product['productid']."' AND rating='3'");
							$row = $hQueryB->fetch_array();
							$stars_3 = $row[0];
							$hQueryB = $mysqli->query("SELECT COUNT(reviewid) FROM review WHERE productid='".$product['productid']."' AND rating='4'");
							$row = $hQueryB->fetch_array();
							$stars_4 = $row[0];
							$hQueryB = $mysqli->query("SELECT COUNT(reviewid) FROM review WHERE productid='".$product['productid']."' AND rating='5'");
							$row = $hQueryB->fetch_array();
							$stars_5 = $row[0];
							$total_rating = ($stars_1 + $stars_2 * 2 + $stars_3 * 3 + $stars_4 * 4 + $stars_5 * 5) / $total_votes;
						}

						echo
						'<li class="span3">
							<div class="thumbnail">
							 	<a href="product_details.php?pid='.$product['productid'].'"><img class="product-img" src="images/products/'.$product['image'].'" alt=""></a>
							 	<div class="caption cntr">
									<p>'.$product['name'].'</p>
									<p><strong>'.$product['price'].' PHP</strong></p>
									<form class="form-product" action="cart.php?pid='.$product['productid'].'" method="POST">
							 			<h4><button class="shopBtn" name="add-to-cart"> Add to cart </button></h4>
							 		</form>
								 	<form class="form-product" action="wishlist.php?pid='.$product['productid'].'" method="POST">
										<button type="submit" class="link-btn" style="font-size:12px;" name="add-to-wishlist">Add to Wish List</button>
									</form>';

									echo '<font size="1">';
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
								    echo  '&nbsp('.$total_votes.')</font>';

						echo 		'<br class="clr">
								</div>
							</div>
						</li>';
					} else {
						break;
					}
				}
				echo '</ul>';
			}
		?>
	</div>

	<div class="pagination">
        <ul>
           	<?php
            if ($page > 0) {
                echo '<li><a href="products.php?c='.$strCategory.'&s='.$strSearch.'&p='.$page.'" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
            } else {
                echo '<li><a aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
            }
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $page+1) {
                    echo '<li><a style="background-color: #eee;" href="products.php?c='.$strCategory.'&s='.$strSearch.'&p='.$i.'">'.$i.'</a></li>';
                } else {
                    echo '<li><a href="products.php?c='.$strCategory.'&s='.$strSearch.'&p='.$i.'">'.$i.'</a></li>';
                }
            }
            if ($page < $total_pages-1) {
                $next = $page + 2;
                echo '<li><a href="products.php?c='.$strCategory.'&s='.$strSearch.'&p='.$next.'" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
            } else {
                echo '<li><a aria-label="Next"><span aria-hidden="true">»</span></a></li>';
            }
            ?>
        </ul>
    </div>

	<?php } else echo '<center><b>No products found</b></center></div>'; ?>
</div>
</div>
</div>
<?php include 'includes/footer.php'; ?>