<?php

include 'sidebar.php';

$strAction = "";
$strId = "";
$strImage = "";
$strFname = "";
$strLname = "";
$strGender = "";
$strEmail = "";
$strPassword = "";
$strUsergroup = "";

if (isset($_POST['action'])) {
	$strAction = $_POST['action'];
	$strId = $_POST['userid'];
	$strImage = $_POST['image'];
	$strFname = $_POST['fname'];
	$strLname = $_POST['lname'];
	$strGender = $_POST['gender'];
	$strEmail = $_POST['email'];
	$strPassword = $_POST['password'];
	$strUsergroup = $_POST['usergroup'];
}

if ($strAction == "search") {

	$hQuery = $mysqli->query("SELECT * FROM user WHERE id='$strId'");
	if (!$hQuery) {
		die("ERROR: ".$mysqli->error);
	}

	if ($hQuery->num_rows > 0) {
		$row = $hQuery->fetch_assoc();
		$strImage = $row['image'];
		$strFname = $row['fname'];
		$strLname = $row['lname'];
		$strGender = $row['gender'];
		$strEmail = $row['email'];
		$strUsergroup = $row['groupid'];
	} else {
		header("location: users.php?response=failed&class=alert-danger&message=User ID does not exist.");
		exit();
	}

} else if ($strAction == "update") {

	if ($strFname == "") {
		header("location: users.php?response=failed&class=alert-danger&message=Please fill in user's first name.");
		exit();
	}

	if ($strLname == "") {
		header("location: users.php?response=failed&class=alert-danger&message=Please fill in user's last name.");
		exit();
	}

	if ($strGender == "") {
		header("location: users.php?response=failed&class=alert-danger&message=Please specify the user's gender.");
		exit();
	}

	if ($strEmail == "") {
		header("location: users.php?response=failed&class=alert-danger&message=Please fill in user's email address.");
		exit();
	}

	if ($strUsergroup == "") {
		header("location: users.php?response=failed&class=alert-danger&message=Please specify the user's group.");
		exit();
	}

	$hQuery = $mysqli->query("SELECT * FROM user WHERE id='$strId'");
	if (!$hQuery) {
		die("ERROR: ".$mysqli->error);
	}

	if ($hQuery->num_rows > 0) {

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

		if ($strPassword != "") {
			$user = $hQuery->fetch_assoc();
			$salt = $user['salt'];
			$strPasswordHash = md5(md5($strPassword).$salt);
			$hQuery = $mysqli->query("UPDATE user SET image='$strImage', fname='$strFname', lname='$strLname', gender='$strGender', email='$strEmail', password='$strPasswordHash', groupid='$strUsergroup' WHERE id='$strId'");
		} else {
			$hQuery = $mysqli->query("UPDATE user SET image='$strImage', fname='$strFname', lname='$strLname', gender='$strGender', email='$strEmail', groupid='$strUsergroup' WHERE id='$strId'");
		}

		header("location: users.php?response=success&class=alert-success&message=Successfully updated user information.");
		exit();
	}

} else if ($strAction == "deactivate") {

	$hQuery = $mysqli->query("UPDATE user SET active='0' WHERE id='$strId'");
	if (!$hQuery) {
		die("ERROR: ".$mysqli->error);
	}

	header("location: users.php?response=success&class=alert-success&message=Successfully deactivate user.");
	exit();
}

?>

<div style="margin-left:17%">
<div class="w3-container" style="background:#3e7aa4; color:#fff;">
	<b>Admin Control Panel</b>
	<b class="pull-right">
		<a href="../">Home</a> | <a href="../signout.php">Log Out</a>
	</b>
	<center><h3>Admin Control Panel: Users</h3></center>
</div>

<div class="w3-container" style="padding:40px 80px 40px 80px;">
	<?php
	if (isset($_GET['message'])) {
		echo '<div class="alert '.$_GET['class'].'">'.$_GET['message'].'</div>';
	}
    ?>
	<form action="users.php" method="POST" id="frmCp" enctype="multipart/form-data">
	<table class="w3-table w3-striped w3-border">
		<tr>
			<th colspan="2"><center>Manage Users</center></th>
		</tr>
		<tr>
			<td>User ID</td>
			<td>
				<input type="text" name="userid" value="<?php echo $strId; ?>" placeholder="User ID">
				<button name="action" value="search">Search</button>
			</td>
		</tr>
		<tr>
			<td>Profile Photo</td>
			<td>
				<input type="text" id="input-image" name="image" value="<?php echo $strImage; ?>" placeholder="Image">
				<input id="imgUpload" onchange="onImageChange()" style="width: 91px; height: 34px;" type="file" name="imgUpload">
			</td>
		</tr>
		<tr>
			<td>Name</td>
			<td>
				<input type="text" name="fname" value="<?php echo $strFname; ?>" placeholder="First Name">
				<input type="text" name="lname" value="<?php echo $strLname; ?>" placeholder="Last Name">
			</td>
		</tr>
		<tr>
			<td>Gender</td>
			<td>
				<select name="gender" style="width:205px">
					<option value="">Choose Gender</option>
					<option value="male" <?php if ($strGender == "male") echo "selected"; ?> >Male</option>
					<option value="female" <?php if ($strGender == "female") echo "selected"; ?> >Female</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Email</td>
			<td><input type="email" name="email" value="<?php echo $strEmail; ?>" placeholder="Email"></td>
		</tr>
		<tr>
			<td>Password</td>
			<td><input type="password" name="password" placeholder="Password"></td>
		</tr>
		<tr>
			<td>Usergroup</td>
			<td>
				<select name="usergroup" style="width:205px">
					<option value="">Choose Usergroup</option>
					<option value="1" <?php if ($strUsergroup == 1) echo "selected"; ?> >Administrator</option>
					<option value="2" <?php if ($strUsergroup == 2) echo "selected"; ?> >Member</option>
					<option value="3" <?php if ($strUsergroup == 3) echo "selected"; ?> >Guest</option>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2">
			<center>
				<button name="action" value="update">Update</button>
				<button name="action" value="deactivate">Deactivate</button>
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