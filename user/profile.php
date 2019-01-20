<?php

include '../includes/config.php';

if (empty($_SESSION['logged_in'])) {
	header("location: ../login.php");
}

if (isset($_POST['editprofile'])) {

	$strFname = $_POST['fname'];
	$strLname = $_POST['lname'];
	$strGender = $_POST['gender'];
	$strEmail = $_POST['email'];
	$strPassword = $_POST['password'];
	$strImage = $_POST['image'];
	$userId = $_SESSION['logged_in']['id'];

	if ($strEmail != $_SESSION['logged_in']['email']) {

		$hQuery = $mysqli->query("SELECT * FROM user WHERE email='$strEmail'");

		if(!$hQuery) {
			die("ERROR: ".$mysqli->error);
		}

		if ($hQuery->num_rows > 0) {
			$registered = false;
			while ($row = $hQuery->fetch_assoc()) {
				$registered = $registered || $row['active'];
			}
			if ($registered) {
				header("location: profile.php?response=failed&class=alert-danger&message=Email is already registered");
				exit();
			}
		}
	}

	if ($_POST['confirm_password'] != $strPassword) {
		header("location: profile.php?response=failed&class=alert-danger&message=Password did not match");
		exit();
	}

	if (!empty($_FILES['imgUpload']['name'])) {
		$target_dir = "../images/users/";
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

	$strPasswordHash = md5(md5($strPassword).$_SESSION['logged_in']['salt']);

	if ($strPassword == "")
		$hQuery = $mysqli->query("UPDATE user SET email='$strEmail', fname='$strFname', lname='$strLname', gender='$strGender', image='$strImage' WHERE id='$userId'");
	else
		$hQuery = $mysqli->query("UPDATE user SET email='$strEmail', fname='$strFname', lname='$strLname', gender='$strGender', password='$strPasswordHash', image='$strImage' WHERE id='$userId'");

	if(!$hQuery) {
		die("ERROR: ".$mysqli->error);
	}

	// Update user session data

	$hQuery = $mysqli->query("SELECT * FROM user WHERE email='$strEmail'");

	if(!$hQuery) {
		die("ERROR: ".$mysqli->error);
	}

	$row = $hQuery->fetch_assoc();
	$_SESSION['logged_in'] = $row;
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
	<li class="active">My Profile</li>
</ul>
	<div class="left-form" style="margin-left: 180px; width:800px;">
		<div class="form-head">
			<h3>My Profile</h3>
		</div>
		<div class="form-detail">
			<form class="form-horizontal" method="POST" enctype="multipart/form-data">
				<?php
				if (isset($_GET['message'])) {
					echo '<div class="alert '.$_GET['class'].'">'.$_GET['message'].'</div>';
				}
		        ?>
				<div class="control-group">
					<label class="control-label"><b>Profile Photo:</b></label>
					<div class="controls">
						<input type="text" id="input-image" name="image" value="<?php echo $_SESSION['logged_in']['image']; ?>" placeholder="Image">
						<input id="imgUpload" onchange="onImageChange()" style="width: 91px; height: 34px;" type="file" name="imgUpload">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><b>Name:</b></label>
					<div class="controls">
						<input type="text" id="inputFname" placeholder="First Name" name="fname" value="<?php echo $_SESSION['logged_in']['fname'] ?>" required>
						<input type="text" id="inputLname" placeholder="Last Name" name="lname" value="<?php echo $_SESSION['logged_in']['lname'] ?>" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><b>Gender:</b></label>
					<div class="controls">
						<input type="radio" name="gender" value="male" required <?php if ($_SESSION['logged_in']['gender'] == 'male') echo "checked"; ?>> Male &nbsp
						<input type="radio" name="gender" value="female" <?php if ($_SESSION['logged_in']['gender'] == 'female') echo "checked"; ?>> Female &nbsp
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><b>Email Address:</b></label>
					<div class="controls">
						<input type="text" id="inputEmail" placeholder="Email Address" name="email" value="<?php echo $_SESSION['logged_in']['email'] ?>" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><b>Password:</b></label>
					<div class="controls">
					  <input type="password" placeholder="6-20 characters" minLength="6" maxlength="20" name="password">
					</div>
			  	</div>
				<div class="control-group">
					<label class="control-label"><b>Confirm Password:</b></label>
					<div class="controls">
					  <input type="password" placeholder="Enter password again" maxlength="20" name="confirm_password">
					</div>
			  	</div>
				<div class="control-group">
					<div class="controls">
					 <input type="submit" name="editprofile" value="Edit Profile" class="exclusive shopBtn">
					</div>
				</div>
			</form>
			<form class="pull-right" action="deactivate.php" method="POST">
				<input type="submit" name="deactivate" value="Deactivate Account" class="link-btn">
			</form>
		</div>
	</div>
</div>
</div>
<?php include '../includes/footer.php'; ?>