<?php

include '../includes/config.php';

if (isset($_POST['answer'])) {
	if ($_POST['answer'] == 'Yes') {

		$userId = $_SESSION['logged_in']['id'];
		$hQuery = $mysqli->query("UPDATE user SET active='0' WHERE id=$userId");

		if(!$hQuery) {
		    die("ERROR: ".$mysqli->error);
		}

		header("location: ../signout.php");

	} else if ($_POST['answer'] == 'No') {
		header("location: profile.php");
	}
} else if (isset($_POST['deactivate'])) { ?>

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
<body style="background:#F2F3F7">
<div class="left-form" style="margin:auto; margin-top:50px">
	<form class="form-detail" method="POST">
		<div class="control-group">
			Are you sure you want to deactivate your account?<br><br>
			<div class="controls">
				<input type="submit" name="answer" value="Yes">
				<input type="submit" name="answer" value="No">
			</div>
		</div>
	</form>
</div>
</body>
</html>

<?php } else header("location: profile.php"); ?>