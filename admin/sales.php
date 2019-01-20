<?php include 'sidebar.php'; ?>

<div style="margin-left:17%">
<div class="w3-container" style="background:#3e7aa4; color:#fff;">
	<b>Admin Control Panel</b>
	<b class="pull-right">
		<a href="../">Home</a> | <a href="../signout.php">Log Out</a>
	</b>
	<center><h3>Admin Control Panel: Sales</h3></center>
</div>

<div class="w3-container" style="padding:40px 80px 40px 80px;">
	<?php
	function validDate($date, $format = 'Y-m-d') {
	    $d = DateTime::createFromFormat($format, $date);
	    return $d && $d->format($format) == $date;
	}
	$dateValid = 0;
	if (isset($_POST['report'])) {
		$dateFrom = $_POST['dateFrom'];
		$dateTo = $_POST['dateTo'];
		if ($dateFrom == "" || $dateTo == "") {
			echo '<div class="alert alert-danger">Please fill in both date fields.</div>';
		} else {
			if (validDate($dateFrom) && validDate($dateTo)) {
				$dateValid = 1;
			} else {
				echo '<div class="alert alert-danger">Not a valid date.</div>';
			}
		}
	}
	?>
	<form method="POST">
	<table class="w3-table w3-striped w3-border">
		<tr>
			<th><center>Sales Report</center></th>
		</tr>
		<tr>
			<td>
			<center>
				From: <input style="width:110px" type="text" name="dateFrom" placeholder="YYYY-MM-DD"">
				To: <input style="width:110px" type="text" name="dateTo" placeholder="YYYY-MM-DD"">
			</center>
			</td>
		</tr>
		<tr>
			<td><center><button name="report">Generate Report</button></center></td>
		</tr>
	</table>
	</form>

	<table class="w3-table w3-striped w3-border">
		<tr>
			<th style="width:50%">Category</th>
			<th>Quantity</th>
			<th>Amount</th>
		</tr>
		<?php

    	$total_quantity = 0;
    	$total_amount = 0;

    	$hQuery = $mysqli->query("SELECT * FROM category");

		while ($row = $hQuery->fetch_assoc()) {

			if ($dateValid) {
				$strQuery = "SELECT * FROM purchase WHERE date BETWEEN '$dateFrom' AND '$dateTo'";
			} else {
				$strQuery = "SELECT * FROM purchase";
			}

			$hQueryB = $mysqli->query($strQuery);

			$orders = array();
			while ($purchase = $hQueryB->fetch_assoc()) {
				$product = $mysqli->query("SELECT * FROM product WHERE productid='".$purchase['productid']."'")->fetch_assoc();
				if ($product['category'] == $row['categoryid']) {
					$orders[] = $purchase;
				}
			} 

			$quantity = sizeof($orders);
			$amount = 0;

			foreach ($orders as $o) {
				$hQueryC = $mysqli->query("SELECT * FROM product WHERE productid='".$o['productid']."'");
				if ($hQueryC->num_rows > 0) {
					$rowC = $hQueryC->fetch_assoc();
					$amount += $rowC['price'];
				}
			}

			echo '
			<tr>
				<td>'.$row['categoryname'].'</td>
				<td>'.$quantity.'</td>
				<td>'.$amount.' PHP</td>
			</tr>';
			$total_quantity += $quantity;
			$total_amount += $amount;
		}

		?>
		<tr>
			<td><b>Total</b></td>
            <td><?php echo $total_quantity;?></td>
            <td><?php echo $total_amount;?> PHP</td>
		</tr>
	</table>
	<br>

	<table class="w3-table w3-striped w3-border">
		<tr>
			<th style="width:50%">Product</th>
			<th>Quantity</th>
			<th>Amount</th>
		</tr>
		<?php

    	$total_quantity = 0;
    	$total_amount = 0;

    	$hQuery = $mysqli->query("SELECT * FROM product");

		while ($row = $hQuery->fetch_assoc()) {

			if ($dateValid) {
				$strQuery = "SELECT * FROM purchase WHERE productid='".$row['productid']."' AND date BETWEEN '$dateFrom' AND '$dateTo'";
			} else {
				$strQuery = "SELECT * FROM purchase WHERE productid='".$row['productid']."'";
			}
			
			$hQueryB = $mysqli->query($strQuery);
			$quantity = $hQueryB->num_rows;

			if ($quantity > 0) {
				$amount = $quantity * $row['price'];
				echo '
				<tr>
					<td><a href="../product_details.php?pid='.$row['productid'].'">'.$row['name'].'</a></td>
					<td>'.$quantity.'</td>
					<td>'.$amount.' PHP</td>
				</tr>';
				$total_quantity += $quantity;
				$total_amount += $amount;
			}
		}

    	?>
        <tr>
            <td><b>Total</b></td>
            <td><?php echo $total_quantity;?></td>
            <td><?php echo $total_amount;?> PHP</td>
        </tr>
	</table>
</div>
</div>

<!-- Placed at the end of the document so the pages load faster -->
<script src="../assets/js/jquery.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/shop.js"></script>
</body>
</html>