<?php

include 'sidebar.php';

if (isset($_POST['process'])) {
	$purchaseId = $_POST['process'];

	$hQuery = $mysqli->query("UPDATE purchase SET processed='1' WHERE purchaseid='$purchaseId'");
	if (!$hQuery) {
		die("ERROR: ".$mysqli->error);
	}
} else if (isset($_POST['unprocess'])) {
	$purchaseId = $_POST['unprocess'];

	$hQuery = $mysqli->query("UPDATE purchase SET processed='0' WHERE purchaseid='$purchaseId'");
	if (!$hQuery) {
		die("ERROR: ".$mysqli->error);
	}
}

?>

<div style="margin-left:17%">
<div class="w3-container" style="background:#3e7aa4; color:#fff;">
	<b>Admin Control Panel</b>
	<b class="pull-right">
		<a href="../">Home</a> | <a href="../signout.php">Log Out</a>
	</b>
	<center><h3>Admin Control Panel: Orders</h3></center>
</div>

<div class="w3-container" style="padding:40px 80px 40px 80px;">
	<form method="POST">
	<table class="w3-table w3-striped w3-border">
		<tr>
			<th colspan="8"><center>Unprocessed Orders</center></th>
		</tr>
		<tr>
			<th>Product</th>
			<th>Quantity</th>
			<th>Price</th>
			<th>Name</th>
			<th>Phone</th>
			<th>Address</th>
			<th>Date</th>
			<th>Action</th>
		</tr>
		<?php

		$hQuery = $mysqli->query("SELECT * FROM purchase WHERE processed='0'");
		if (!$hQuery) {
			die("ERROR: ".$mysqli->error);
		}

		while ($row = $hQuery->fetch_assoc()) {

			$hQueryB = $mysqli->query("SELECT * FROM product WHERE productid='".$row['productid']."'");
			if (!$hQueryB) {
				die("ERROR: ".$mysqli->error);
			}

			if ($product = $hQueryB->fetch_assoc()) {
				echo '<tr>';
				echo '<td><a href="../product_details.php?pid='.$row['productid'].'">'.$product['name'].'</a></td>';
				echo '<td>'.$row['quantity'].'</td>';
				echo '<td>'.$row['price'].' PHP</td>';
				echo '<td>'.$row['name'].'</td>';
				echo '<td>'.$row['phone'].'</td>';
				echo '<td>'.$row['address'].'</td>';
				echo '<td>'.$row['date'].'</td>';
				echo '<td><button name="process" value="'.$row['purchaseid'].'">Process</button></td>';
				echo '</tr>';
			}
		}

		?>
	</table>
	</form><br>

	<form method="POST">
	<table class="w3-table w3-striped w3-border">
		<tr>
			<th colspan="8"><center>Processed Orders</center></th>
		</tr>
		<tr>
			<th>Product</th>
			<th>Quantity</th>
			<th>Price</th>
			<th>Name</th>
			<th>Phone</th>
			<th>Address</th>
			<th>Date</th>
			<th>Action</th>
		</tr>
		<?php

		$hQuery = $mysqli->query("SELECT * FROM purchase WHERE processed='1' ORDER BY purchaseid DESC");
		if (!$hQuery) {
			die("ERROR: ".$mysqli->error);
		}

		while ($row = $hQuery->fetch_assoc()) {

			$hQueryB = $mysqli->query("SELECT * FROM product WHERE productid='".$row['productid']."'");
			if (!$hQueryB) {
				die("ERROR: ".$mysqli->error);
			}

			if ($product = $hQueryB->fetch_assoc()) {
				echo '<tr>';
				echo '<td><a href="../product_details.php?pid='.$product['productid'].'">'.$product['name'].'</a></td>';
				echo '<td>'.$row['quantity'].'</td>';
				echo '<td>'.$row['price'].' PHP</td>';
				echo '<td>'.$row['name'].'</td>';
				echo '<td>'.$row['phone'].'</td>';
				echo '<td>'.$row['address'].'</td>';
				echo '<td>'.$row['date'].'</td>';
				echo '<td><button name="unprocess" value="'.$row['purchaseid'].'">Unprocess</button></td>';
				echo '</tr>';
			}
		}

		?>
	</table>
	</form>
</div>
</div>

<!-- Placed at the end of the document so the pages load faster -->
<script src="../assets/js/jquery.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/shop.js"></script>
</body>
</html>