<!--
Footer
-->
<?php

$folders = explode("\\", getcwd());
$dir = "";

for ($i = sizeof($folders)-1; $i > 0; $i--) {
	if ($folders[$i] != "okayhappy") {
		$dir = $dir."../";
	} else {
		break;
	}
}

?>

<footer class="footer">
<div class="oh-footer">
<div class="row-fluid oh-container">
<div class="span2">
<h5>Account</h5>
<a href="<?php echo $dir; ?>user/profile.php">My Profile</a><br>
<a href="<?php echo $dir; ?>user/address.php">My Address</a><br>
<a href="<?php echo $dir; ?>user/orders.php">My Orders</a><br>
<a href="<?php echo $dir; ?>user/review.php">My Reviews</a><br>
 </div>
<div class="span2">
<h5>Information</h5>
<a href="<?php echo $dir; ?>contact.php">Contact</a><br>
<a href="<?php echo $dir; ?>article/policy.php">Privacy Policy</a><br>
<a href="<?php echo $dir; ?>article/terms.php">Terms of Use</a><br>
<a href="<?php echo $dir; ?>about.php">About Us</a><br>
 </div>
<div class="span2 socialNw">
<h5>Follow Us</h5>
<a href="https://www.facebook.com/Okay-Happy-1954853194752610/"><span class="icon-facebook"></span></a>
<a href="#"><span class="icon-twitter"></span></a>
<a href="#"><span class="icon-instagram"></span></a>
<a href="#"><span class="icon-tumblr"></span></a>
 </div>
 <div class="span5">
<h5>About the company</h5>
Okay Happy is an all in one shop, featuring many categories with dozen 
of products directly imported from Korea. Okay Happy strictly applies the 
Payment First Policy: No pay, no processing orders. Pay now, ship tomorrow.
 </div>
 <br>
 </div>
 <br>
 <hr class="soften" style="height:1px; border:none; background-color:#666">
 <br>
 <p>© 2018 Okay Happy. All rights reserved.</p>
</div>
</footer>
</div><!-- /container -->

<div class="gotop">
	<a href="#"><i class="icon-angle-up"></i></a>
</div>

<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo $dir; ?>assets/js/jquery.js"></script>
<script src="<?php echo $dir; ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo $dir; ?>assets/js/shop.js"></script>
</body>
</html>