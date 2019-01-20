
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Okay Happy</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<!-- Bootstrap styles -->
<link href="assets/css/bootstrap.css" rel="stylesheet"/>
<!-- Customize styles -->
<link href="assets/css/style.css" rel="stylesheet"/>
<!-- font awesome styles -->
<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <!--[if IE 7]>
        <link href="css/font-awesome-ie7.min.css" rel="stylesheet">
    <![endif]-->

    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

<!-- Favicons -->
<link rel="shortcut icon" href="favicon.ico">
</head>

<body>
<div class="main-content">
    <div class="left-form" style="margin:auto; width:700px; min-height:250px;">
        <div class="form-head" id="form-head" style="background:#68c61a; color:#fff; text-align:center;">
            <h2>PAYMENT PAGE</h2>
        </div>
        <form class="form-horizontal" id="main-form" method="POST" style="padding:20px 20px 20px 60px">
            <h3>Card Details</h3>
            <div class="control-group">
                <label class="control-label"><b>Name:</b></label>
                <div class="controls">
                    <input type="text" placeholder="Name on Card" required>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"><b>Card Number:</b></label>
                <div class="controls">
                    <input type="text" placeholder="Card Number" required>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"><b>Expiry Date:</b></label>
                <div class="controls">
                    <select class="pull-left" required name="month" style="width:105px">
                        <option value="">Month</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                    <select class="pull-left" required name="year" style="width:105px;margin-left:10px">
                        <option value="">Year</option>
                        <?php
                            $y = date("Y");
                            for ($i = 0; $i < 50; $i++, $y++) {
                                echo '<option value='.$y.'>'.$y.'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"><b>CVV:</b></label>
                <div class="controls">
                    <input type="text" placeholder="CVV" required>
                </div>
            </div>

            <h3>Shipping Address</h3>
            <div class="control-group">
                <label class="control-label"><b>Name:</b></label>
                <div class="controls">
                    <input type="text" id="inputNumber" placeholder="Name" name="name" value="<?php echo $address['name']; ?>" required>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"><b>Phone Number:</b></label>
                <div class="controls">
                    <input type="text" id="inputNumber" placeholder="Phone Number" name="phone" value="<?php echo $address['phone']; ?>" required>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"><b>Region:</b></label>
                <div class="controls">
                    <input type="text" id="inputRegion" placeholder="Region" name="region" value="<?php echo $address['region']; ?>" required>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"><b>Province:</b></label>
                <div class="controls">
                    <input type="text" id="inputProvince" placeholder="Province" name="province" value="<?php echo $address['province']; ?>" required>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"><b>City:</b></label>
                <div class="controls">
                    <input type="text" id="inputCity" placeholder="City" name="city" value="<?php echo $address['city']; ?>" required>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"><b>Barangay:</b></label>
                <div class="controls">
                    <input type="text" id="inputBarangay" placeholder="Barangay" name="barangay" value="<?php echo $address['barangay']; ?>" required>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"><b>Postal Code:</b></label>
                <div class="controls">
                    <input type="text" id="inputZip" placeholder="Postal Code" name="zip" value="<?php echo $address['zip']; ?>" required>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"><b>Detailed Address:</b></label>
                <div class="controls">
                    <input type="text" style="width:330px;" id="inputDetailedAddress" placeholder="Unit number, house number, building, street name" name="detailed_address" value="<?php echo $address['detailed_address']; ?>" required>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button class="payBtn" type="submit" name="submit">Submit for Processing</button>
                </div>
            </div>
        </form>
    </div>
    <div id="divCreditCard">
        <center><img src="assets/img/cc.png" width="400px"></center>
    </div>
</div>

<script src="assets/js/jquery.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/bootstrap/js/shop.js"></script>
<script>
function paymentSuccess() {
    document.getElementById("form-head").innerHTML = '<h2>THANK YOU<h2>';
    document.getElementById("main-form").innerHTML = '<p>We hope you were pleased with the transaction and that all the details were handled properly.</p><p>We also hope you are satisfied with the product. We appreciate your business.<p>Thanks again!</p><center><a class="pull-right" href="cart.php">← Back to Cart</a></center>';
    document.getElementById("divCreditCard").innerHTML = '';
}
</script>
<?php
if ($paymentSuccess) {
    echo "<script>paymentSuccess();</script>";
}
?>
</body>
</html>
