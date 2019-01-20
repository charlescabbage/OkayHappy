<?php

include 'sidebar.php';

if (isset($_POST['save-notes'])) {
	$notes = $_POST['notes']." ";
	$myfile = fopen("notes", "w") or die("ERROR: Cannot open file");
	fwrite($myfile, $notes);
	fclose($myfile);
}

?>

<!-- Page Content -->
<div style="margin-left:17%">
<div class="w3-container" style="background:#3e7aa4; color:#fff;">
	<b>Admin Control Panel</b>
	<b class="pull-right">
		<a href="../">Home</a> | <a href="../signout.php">Log Out</a>
	</b>
	<center><h3>Welcome to the Okay Happy Admin Control Panel</h3></center>
</div>

<div class="w3-container" style="padding:40px 80px 40px 80px;">
	<form method="POST">
	<table class="w3-table w3-striped w3-border">
		<tr>
			<th><center>Administrator Notes</center></th>
		</tr>
		<tr>
			<td>
			<center>
				<textarea name="notes" style="width:90%; height:200px; min-height:200px; max-height:400px; resize:vertical;"><?php
				if (file_exists("notes")) {
					$myfile = fopen("notes", "r") or die("ERROR: Cannot open file");
					echo fread($myfile,filesize("notes"));
					fclose($myfile);
				}
				?></textarea>
			</center>
			</td>
		</tr>
		<tr>
			<td><center><button name="save-notes">Save</button></center></td>
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