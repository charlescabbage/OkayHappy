<?php include 'includes/header.php'; ?>
<div class="l-page">
<div class="main-content" style="margin-left: 160px">
	<ul class="oh-breadcrumb" style="width:800px">
		<li><a href="index.php">Home</a> <span class="divider">/</span></li>
		<li class="active">Categories</li>
    </ul>
	<div class="left-form" style="width:800px">
		<div class="form-head">
			<h3>Categories</h3>
		</div>
		<div class="form-detail">
		<?php
		echo "<ul>";
		foreach ($category as $c) {
			echo '<li><a href="products.php?c='.$c['categoryid'].'">'.$c['categoryname'].'</a></li>';
		}
		echo "</ul>";
		?>
		</div>
	</div>
</div>
</div>
<?php include 'includes/footer.php'; ?>