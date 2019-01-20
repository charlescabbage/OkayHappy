<?php

session_start();

if (empty($_SESSION['logged_in'])) {
	header("location: login.php");
	exit();
}

include 'includes/header.php';

if (isset($_POST['add-to-cart'])) {

	$productId = $_GET['pid'];
	$quantity = 1;
	$userId = $_SESSION['logged_in']['id'];

	if (isset($_POST['quantity'])) {
		$quantity = $_POST['quantity'];
	}

	$hQuery = $mysqli->query("SELECT * FROM product WHERE productid='$productId'");
    if(!$hQuery) {
	    die("ERROR: ".$mysqli->error);
	}

	if ($hQuery->num_rows > 0) {
		$product = $hQuery->fetch_assoc();
		
		for ($i = 0; $i < $quantity; $i++) {
			$query = $mysqli->query("SELECT COUNT(id) FROM cart WHERE userid='$userId' AND productid='$productId'");
			$row = $query->fetch_array();
			if ($row[0] < $product['stock']) {
				$hQuery = $mysqli->query("INSERT INTO cart VALUES (NULL, '$productId', '$userId')");
			    if(!$hQuery) {
				    die("ERROR: ".$mysqli->error);
				}
			}
		}
	}

} else if (isset($_POST['del-prod-cart'])) {
	$productId = $_GET['pid'];
	$userId = $_SESSION['logged_in']['id'];

	$hQuery = $mysqli->query("DELETE FROM cart WHERE productid = '$productId' AND userid = '$userId' LIMIT 1");
	if(!$hQuery) {
	    die("ERROR: ".$mysqli->error);
	}

} else if (isset($_POST['del-from-cart'])) {
	$productId = $_GET['pid'];
	$userId = $_SESSION['logged_in']['id'];

	$hQuery = $mysqli->query("DELETE FROM cart WHERE productid = '$productId' AND userid = '$userId'");
	if(!$hQuery) {
	    die("ERROR: ".$mysqli->error);
	}
}

?>
<div class="l-page">
<div class="main-content">
	<ul class="oh-breadcrumb" style="margin:auto; margin-bottom:20px; width:1000px;">
		<li><a href="index.php">Home</a> <span class="divider">/</span></li>
		<li class="active">Cart</li>
	</ul>
	<div class="row banner" style="margin:auto; width:1000px; min-height:437px;">
		<?php

		$userId = $_SESSION['logged_in']['id'];

		$hQueryA = $mysqli->query("SELECT * FROM cart WHERE userid='$userId' GROUP BY productid");

		if(!$hQueryA) {
		    die("ERROR: ".$mysqli->error);
		}

		$hQueryB = $mysqli->query("SELECT * FROM cart WHERE userid='$userId'");

		if(!$hQueryB) {
		    die("ERROR: ".$mysqli->error);
		}

		$cartItems = array();
		while ($row = $hQueryB->fetch_assoc()) {
		    $cartItems[] = $row;
		}

		$total_quantity = 0;
        $total_price = 0;

        echo
        '<table class="table table-bordered table-condensed">
		<thead>
		<tr>
		  <th>Product</th>
		  <th>Description</th>
		  <th>Unit price</th>
		  <th>Qty </th>
		  <th>Total</th>
		</tr>
		</thead>
		<tbody>';

        while ($row = $hQueryA->fetch_assoc()) {

            $hQueryB = $mysqli->query("SELECT * FROM product WHERE productid = '".$row['productid']."'");

            if ($product = $hQueryB->fetch_assoc()) {

                $quantity = 0;
                $price = 0;

                for ($i = 0; $i < sizeof($cartItems); $i++) {
                    if ($product['productid'] == $cartItems[$i]['productid']) {
                        $quantity++;
                        $price += $product['price'];
                        $total_price += $product['price'];
                        $total_quantity += $quantity;
                    }
                }

                echo
                '<tr>
				<td><a href="product_details.php?pid='.$product['productid'].'"><img width="100" src="images/products/'.$product['image'].'" alt=""></a></td>
				<td style="max-width:300px">'.$product['description'].'</td>
				<td>'.$product['price'].' PHP</td>
				<td>
				<form method="POST" action="cart.php?pid='.$product['productid'].'">
					<input class="span1" style="max-width:34px" id="appendedInputButtons" size="16" type="text" value="'.$quantity.'" readonly>
					<div class="input-append">
						<button class="btn btn-mini" type="submit" name="del-prod-cart">-</button>
						<button class="btn btn-mini" type="submit" name="add-to-cart">+</button>
						<button class="btn btn-mini btn-danger" type="submit" name="del-from-cart"><span class="icon-remove"></span></button>
					</div>
				</form>
				</td>
				<td>'.$price.' PHP</td>
				</tr>';
            }
        }

        echo
        '<tr><td colspan="3"><td><b>Total Payment:</b></td><td><b>'.$total_price.' PHP</b></td></tr></tbody></table><br/>
		<form action="checkout.php" method="POST">
		<button class="shopBtn btn-large pull-right" name="checkout"'; 
		if ($total_quantity == 0) echo "disabled";
		echo '>Check Out <span class="icon-arrow-right"></span></button>
		</form>';
		?>
	</div>
</div>
</div>
<?php include 'includes/footer.php'; ?>