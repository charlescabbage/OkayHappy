<?php

include 'sidebar.php';

$strAction = "";
$strId = "";
$strName = "";
$strImage = "";
$strCategory = "";
$strPrice = "";
$strStock = "";
$strDescription = "";
$strDetails = "";

if (isset($_POST['action'])) {
	$strAction = $_POST['action'];
	$strId = $_POST['productid'];
	$strName = $_POST['name'];
	$strImage = $_POST['image'];
	$strCategory = $_POST['category'];
	$strPrice = $_POST['price'];
	$strStock = $_POST['stock'];
	$strDescription = $_POST['description'];
	$strDetails = $_POST['details'];
}

if ($strAction == "search") {

	$hQuery = $mysqli->query("SELECT * FROM product WHERE productid='$strId'");
	if (!$hQuery) {
		die("ERROR: ".$mysqli->error);
	}

	if ($hQuery->num_rows > 0) {
		$row = $hQuery->fetch_assoc();
		$strName = $row['name'];
		$strImage = $row['image'];
		$strDescription = $row['description'];
		$strDetails = $row['details'];
		$strPrice = $row['price'];
		$strStock = $row['stock'];
		$strCategory = $row['category'];
	} else {
		header("location: products.php?response=failed&class=alert-danger&message=Product ID does not exist.");
		exit();
	}

} else if ($strAction == "add" || $strAction == "update") {

	if ($strName == "") {
		header("location: products.php?response=failed&class=alert-danger&message=Please fill in product name.");
		exit();
	}

	if ($strCategory == "") {
		header("location: products.php?response=failed&class=alert-danger&message=Please choose a product category.");
		exit();
	}

	if ($strPrice == "") {
		header("location: products.php?response=failed&class=alert-danger&message=Please fill in product price.");
		exit();
	}

	if ($strStock == "") {
		header("location: products.php?response=failed&class=alert-danger&message=Please fill in product stock.");
		exit();
	}

	if ($strDescription == "") {
		header("location: products.php?response=failed&class=alert-danger&message=Please fill in product description.");
		exit();
	}

	if ($strDetails == "") {
		header("location: products.php?response=failed&class=alert-danger&message=Please fill in product details.");
		exit();
	}

	if ($strImage == "") {
		header("location: products.php?response=failed&class=alert-danger&message=Please fill in product image file name.");
		exit();
	}

	if (!empty($_FILES['imgUpload']['name'])) {
		$target_dir = "../images/products/";
		$target_file = $target_dir . basename($_FILES['imgUpload']['name']);
		// Check if image file is a actual image or fake image
		if (!getimagesize($_FILES['imgUpload']['tmp_name'])) {
			header("location: products.php?response=failed&class=alert-danger&message=File is not an image.");
			exit();
		}
		// Check if file already exists
		if (file_exists($target_file)) {
			header("location: products.php?response=failed&class=alert-danger&message=File already exists.");
			exit();
		}
		// Try to upload file
		if (!move_uploaded_file($_FILES['imgUpload']['tmp_name'], $target_file)) {
			header("location: products.php?response=failed&class=alert-danger&message=There was an error uploading your file.");
			exit();
		}
	}

	if ($strAction == "add") {

		$hQuery = $mysqli->query("INSERT INTO product VALUES (NULL, '$strImage', '$strName', '$strDescription', '$strDetails', '$strPrice', '$strStock', '$strCategory')");

		if(!$hQuery) {
		    die("ERROR: ".$mysqli->error);
		}

		header("location: products.php?response=success&class=alert-success&message=Successfully added product.");

	} else if ($strAction == "update") {
		
		$hQuery = $mysqli->query("UPDATE product SET image ='$strImage', name='$strName', description='$strDescription', details='$strDetails', price='$strPrice', stock='$strStock', category='$strCategory' WHERE productid='$strId'");

		if(!$hQuery) {
		    die("ERROR: ".$mysqli->error);
		}

		header("location: products.php?response=success&class=alert-success&message=Successfully updated product.");
	}

	exit();

} else if ($strAction == "delete") {

	$hQuery = $mysqli->query("SELECT * FROM product WHERE productid = '$strId'");

	if(!$hQuery) {
	    die("ERROR: ".$mysqli->error);
	}

	if ($hQuery->num_rows > 0) {
		$mysqli->query("DELETE FROM product WHERE productid='$strId'");
		$mysqli->query("DELETE FROM cart WHERE productid='$strId'");
		$mysqli->query("DELETE FROM purchase WHERE productid='$strId'");
		$mysqli->query("DELETE FROM review WHERE productid='$strId'");
		$mysqli->query("DELETE FROM wishlist WHERE productid='$strId'");
		header("location: products.php?response=success&class=alert-success&message=Successfully deleted product.");
	} else {
		header("location: products.php?response=failed&class=alert-danger&message=Product ID does not exist.");
	}

	exit();
}

?>

<div style="margin-left:17%">
<div class="w3-container" style="background:#3e7aa4; color:#fff;">
	<b>Admin Control Panel</b>
	<b class="pull-right">
		<a href="../">Home</a> | <a href="../signout.php">Log Out</a>
	</b>
	<center><h3>Admin Control Panel: Products</h3></center>
</div>

<div class="w3-container" style="padding:40px 80px 40px 80px;">
	<?php
	if (isset($_GET['message'])) {
		echo '<div class="alert '.$_GET['class'].'">'.$_GET['message'].'</div>';
	}
    ?>
	<form action="products.php" method="POST" id="frmCp" enctype="multipart/form-data">
	<table class="w3-table w3-striped w3-border">
		<tr>
			<th colspan="2"><center>Manage Products</center></th>
		</tr>
		<tr>
			<td>Product ID</td>
			<td>
				<input type="text" name="productid" value="<?php echo $strId; ?>" placeholder="Product ID">
				<button name="action" value="search">Search</button>
			</td>
		</tr>
		<tr>
			<td>Name</td>
			<td><input type="text" name="name" value="<?php echo $strName; ?>" placeholder="Name"></td>
		</tr>
		<tr>
			<td>Image</td>
			<td>
				<input type="text" id="input-image" name="image" value="<?php echo $strImage; ?>" placeholder="Image">
				<input id="imgUpload" onchange="onImageChange()" style="width: 91px; height: 34px;" type="file" name="imgUpload">
			</td>
		</tr>
		<tr>
			<td>Category</td>
			<td>
				<select name="category" style="width:205px">
					<option value="">Choose Category</option>
					<?php
					$hQuery = $mysqli->query("SELECT * FROM category");
					if(!$hQuery) {
					    die("ERROR: ".$mysqli->error);
					}
					while ($c = $hQuery->fetch_assoc()) {
						echo '<option value="'.$c['categoryid'].'" '.($strCategory == $c['categoryid'] ? "selected" : "").'>'.$c['categoryname'].'</option>';
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Price</td>
			<td><input type="number" name="price" value="<?php echo $strPrice; ?>" placeholder="Price"></td>
		</tr>
		<tr>
			<td>Stock</td>
			<td><input type="number" name="stock" value="<?php echo $strStock; ?>" placeholder="Stock"></td>
		</tr>
		<tr>
			<td>Descrition</td>
			<td>
				<textarea name="description" style="width:90%; height:100px; min-height:100px; max-height:200px; resize:vertical;"><?php echo $strDescription; ?></textarea>
			</td>
		</tr>
		<tr>
			<td>Details</td>
			<td>
				<textarea name="details" style="width:90%; height:100px; min-height:100px; max-height:200px; resize:vertical;"><?php echo $strDetails; ?></textarea>
			</td>
		</tr>
		<tr>
			<td colspan="2">
			<center>
				<button name="action" value="add">Add</button>
				<button name="action" value="update">Update</button>
				<button name="action" value="delete">Delete</button>
				<input type="button" value="Clear" onClick="clearFields()">
			</center>
			</td>
		</tr>
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