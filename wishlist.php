<?php

session_start();

if (empty($_SESSION['logged_in'])) {
	header("location: login.php");
	exit();
}

include 'includes/header.php';

if (isset($_POST['add-to-wishlist'])) {
	$productId = $_GET['pid'];
	$userId = $_SESSION['logged_in']['id'];

	$hQuery = $mysqli->query("SELECT * FROM wishlist WHERE productid = '$productId' AND userid = '$userId'");

    if(!$hQuery) {
	    die("ERROR: ".$mysqli->error);
	}
    
    if ($hQuery->num_rows == 0) {
        $hQuery = $mysqli->query("INSERT INTO wishlist VALUES (NULL, '$productId', '$userId')");
        if(!$hQuery) {
		    die("ERROR: ".$mysqli->error);
		}
    }
} else if (isset($_POST['del-from-wishlist'])) {
	$productId = $_GET['pid'];
	$userId = $_SESSION['logged_in']['id'];

	$hQuery = $mysqli->query("DELETE FROM wishlist WHERE productid = '$productId' AND userid = '$userId'");

	if(!$hQuery) {
	    die("ERROR: ".$mysqli->error);
	}
}

?>
<div class="l-page">
<div class="main-content">
<ul class="oh-breadcrumb" style="margin:auto; margin-bottom:20px; width:1000px;">
	<li><a href="index.php">Home</a> <span class="divider">/</span></li>
	<li class="active">Wish List</li>
</ul>
<div class="row banner" style="margin:auto; width:1000px; min-height:437px;">
	<div class="row-fluid">
		<?php

		$userId = $_SESSION['logged_in']['id'];
		
		$hQuery = $mysqli->query("SELECT COUNT(id) FROM wishlist WHERE userid = '$userId'");

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

			$hQuery = $mysqli->query("SELECT * FROM wishlist WHERE userid='$userId' LIMIT $offset, $rec_limit");
			if(!$hQuery) {
			    die("ERROR: ".$mysqli->error);
			}

			for ($i = 0; $i < 3; $i++) {
				echo '<ul class="thumbnails">';
				for ($j = 0; $j < 4; $j++) {
					if ($row = $hQuery->fetch_assoc()) {
	                    $hQueryB = $mysqli->query("SELECT * FROM product WHERE productid = '".$row['productid']."'");
	                    if ($product = $hQueryB->fetch_assoc()) {
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
											<button type="submit" class="link-btn" style="font-size:12px;" name="del-from-wishlist">Remove</button>
										</form>
										<br class="clr">
									</div>
								</div>
							</li>';
						}
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
                echo '<li><a href="wishlist.php?p='.$page.'" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
            } else {
                echo '<li><a aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
            }
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $page+1) {
                    echo '<li><a style="background-color: #eee;" href="wishlist.php?p='.$i.'">'.$i.'</a></li>';
                } else {
                    echo '<li><a href="wishlist.php?p='.$i.'">'.$i.'</a></li>';
                }
            }
            if ($page < $total_pages-1) {
                $next = $page + 2;
                echo '<li><a href="wishlist.php?p='.$next.'" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
            } else {
                echo '<li><a aria-label="Next"><span aria-hidden="true">»</span></a></li>';
            }
            ?>
        </ul>
    </div>
    
	<?php } else echo '<center><b>Wish list is empty</b></center></div>'; ?>
</div>
</div>
</div>
<?php include 'includes/footer.php'; ?>