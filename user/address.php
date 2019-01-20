<?php

include '../includes/config.php';

if (empty($_SESSION['logged_in'])) {
	header("location: ../login.php");
}

$userId = $_SESSION['logged_in']['id'];

if (isset($_POST['submit'])) {

	$strName = $_POST['name'];
	$strPhone = $_POST['phone'];
    $strRegion = $_POST['region'];
    $strProvince = $_POST['province'];
    $strCity = $_POST['city'];
    $strBarangay = $_POST['barangay'];
    $strZip = $_POST['zip'];
    $strDetailedAddress = $_POST['detailed_address'];

    $hQuery = $mysqli->query("SELECT * FROM address WHERE userid='$userId'");

    if(!$hQuery) {
        die("ERROR: ".$mysqli->error);
    }

    if ($hQuery->num_rows > 0) {
        $hQuery = $mysqli->query("UPDATE address SET name='$strName' phone='$strPhone', region='$strRegion', province='$strProvince', city='$strCity', barangay='$strBarangay', zip='$strZip', detailed_address='$strDetailedAddress' WHERE userid='$userId'");
        if(!$hQuery) {
            die("ERROR: ".$mysqli->error);
        }
    } else {
        $hQuery = $mysqli->query("INSERT INTO address VALUES (NULL, '$userId', '$strName', '$strPhone', '$strRegion', '$strProvince', '$strCity', '$strBarangay', '$strZip', '$strDetailedAddress')");
        if(!$hQuery) {
            die("ERROR: ".$mysqli->error);
        }
    }
}

$hQuery = $mysqli->query("SELECT * FROM address WHERE userid='$userId'");

if (!$hQuery) {
	die("ERROR: ".$mysqli->error);
}

$address = $hQuery->fetch_assoc();

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
	<li class="active">My Address</li>
</ul>
	<div class="left-form" style="margin-left: 180px; width:800px;">
		<div class="form-head">
			<h3>My Address</h3>
		</div>
		<div class="form-detail">
			<form class="form-horizontal" method="POST">
	            <div class="control-group">
	                <label class="control-label"><b>Name:</b></label>
	                <div class="controls">
	                    <input type="text" value="<?php echo $address['name']; ?>" id="inputNumber" placeholder="Name" name="name" required>
	                </div>
	            </div>
	            <div class="control-group">
	                <label class="control-label"><b>Phone Number:</b></label>
	                <div class="controls">
	                    <input type="text" value="<?php echo $address['phone']; ?>" id="inputNumber" placeholder="Phone Number" name="phone" required>
	                </div>
	            </div>
	            <div class="control-group">
	                <label class="control-label"><b>Region:</b></label>
	                <div class="controls">
	                    <input type="text" value="<?php echo $address['region']; ?>" id="inputRegion" placeholder="Region" name="region" required>
	                </div>
	            </div>
	            <div class="control-group">
	                <label class="control-label"><b>Province:</b></label>
	                <div class="controls">
	                    <input type="text" value="<?php echo $address['province']; ?>" id="inputProvince" placeholder="Province" name="province" required>
	                </div>
	            </div>
	            <div class="control-group">
	                <label class="control-label"><b>City:</b></label>
	                <div class="controls">
	                    <input type="text" value="<?php echo $address['city']; ?>" id="inputCity" placeholder="City" name="city" required>
	                </div>
	            </div>
	            <div class="control-group">
	                <label class="control-label"><b>Barangay:</b></label>
	                <div class="controls">
	                    <input type="text" value="<?php echo $address['barangay']; ?>" id="inputBarangay" placeholder="Barangay" name="barangay" required>
	                </div>
	            </div>
	            <div class="control-group">
	                <label class="control-label"><b>Postal Code:</b></label>
	                <div class="controls">
	                    <input type="text" value="<?php echo $address['zip']; ?>" id="inputZip" placeholder="Postal Code" name="zip" required>
	                </div>
	            </div>
	            <div class="control-group">
	                <label class="control-label"><b>Detailed Address:</b></label>
	                <div class="controls">
	                    <input type="text" style="width:330px;" value="<?php echo $address['detailed_address']; ?>" id="inputDetailedAddress" placeholder="Unit number, house number, building, street name" name="detailed_address" required>
	                </div>
	            </div>
	            <div class="control-group">
	                <div class="controls">
	                    <button class="shopBtn" type="submit" name="submit">Submit</button>
	                </div>
	            </div>
			</form>
		</div>
	</div>
</div>
</div>
<?php include '../includes/footer.php'; ?>