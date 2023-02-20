<?php require_once('../my-documents/php7-my-db.php');
$connName = isset($_GET['conn']) ? $_GET['conn'] : "none";

if (isset($connectionPool) && isset($connectionPool[$connName])) {
    $dbConn = $connectionPool[$connName]['connection'];
} else {
    $dbConn = $conn;

}
?>
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">
<head>
	<meta charset="utf-8">
	<!--[if lte IE 10]><meta http-equiv="refresh" content="0;url=../IE.html" /><![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="CondoSites - http://www.condosites.com" name="author">
	<title><?php include('../my-documents/communityname.html'); ?></title>
	<?php include('../my-documents/meta-robots.html'); ?>
	<link rel="stylesheet" href="../css/foundation.css">
	<link rel="stylesheet" href="../css/magnific-popup.css">
	<link rel="stylesheet" href="../css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/jquery-ui.min.css">
	<link rel="stylesheet" href="../css/jquery-ui.structure.min.css">
	<link rel="stylesheet" href="../css/app.css">
    <link rel="stylesheet" href="../my-documents/app-custom.css">
    <script src="../java/table.js" type="text/javascript"></script>
	<script src="../java/vendor/jquery.js"></script>
	<script src="../java/vendor/jquery-ui.min.js"></script>
	<script src="../java/vendor/jquery.magnific-popup.min.js"></script>
</head>

<body>

<div id="all-documents-folder" class="stand-alone-page">
  <div class="popup-header">
    <h4>
Packages and Deliveries
    </h4>
  </div>

<!-- Mobile Filter Notice -->
  <div class="stand-alone-page-content">
    <div class="rotate-note"></div>
  </div>
  
</div>

<!-- CONTENT -->
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">

<?php if (($_SESSION['owner'] != true) AND ($_SESSION['lease'] != true) AND ($_SESSION['realtor'] != true)){ ?>
  <tfoot>
    <tr style="background-color: #FAFEB8;">
      <th>
<br>
<br>
<br>
<br>
<big>Sorry, you need to be logged in to view this content.</big><br>
<br>
<br>
<br>
<br>
      </th>
    </tr>
  </tfoot>
<?php }; ?>

<?php if (($_SESSION['ghost'] == 'Y') AND ($_SESSION['webmaster'] != true)){ ?>
  <tfoot>
    <tr style="background-color: #FAFEB8;">
      <th>
<br>
<br>
<br>
<br>
<big>Sorry, this page is not available to guests.</big><br>
<br>
<br>
<br>
<br>
      </th>
    </tr>
  </tfoot>
<?php }; ?>
  <tbody>
    <tr>
      </td>
<!-- DATABASE RESULTS -->
<?php
	$query  = "SELECT * FROM packages WHERE pickedup = '0000-00-00 00:00:00'";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
	<div style="float:left;">
	<table border="0" cellpadding="0" cellspacing="20" class="text">
	  <tbody>
	    <tr>
	      <td align="center">
<small><b>
<?php if ($row['userid'] == '0'){ ?><?php echo "{$row['recipient']}"; ?><?php }; ?>
<?php if ($row['userid'] !== '0'){ ?>
<?php
	$type    = $row['userid'];
	$query1  = "SELECT * FROM users WHERE id = '$type'";
	$result1 = mysqli_query($dbConn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?>
<b><?php echo "{$row1['last_name']}"; ?>, <?php echo "{$row1['first_name']}"; ?> (<?php echo "{$row1['unit']}"; ?><?php if ($row1['unit2'] !== 'X'){ ?> - <?php echo "{$row1['unit2']}"; ?><?php }; ?>)</b>
<?php
	}
?>
<?php }; ?>
</b></small><br>
<!-- PACKAGES -->
<?php if ($row['packagetype'] == 'UPS Package'){ ?><img alt="" src="https://condosites.net/commons/packages/ups.png" width="50" height="50" border="0"><?php }; ?>
<?php if ($row['packagetype'] == 'UPS Express Package'){ ?><img alt="" src="https://condosites.net/commons/packages/ups.png" width="50" height="50" border="0"><?php }; ?>
<?php if ($row['packagetype'] == 'UPS Ground Package'){ ?><img alt="" src="https://condosites.net/commons/packages/ups.png" width="50" height="50" border="0"><?php }; ?>
<?php if ($row['packagetype'] == 'FedEx Package'){ ?><img alt="" src="https://condosites.net/commons/packages/fedex.png" width="50" height="50" border="0"><?php }; ?>
<?php if ($row['packagetype'] == 'FedEx Express Package'){ ?><img alt="" src="https://condosites.net/commons/packages/fedexexpress.png" width="50" height="50" border="0"><?php }; ?>
<?php if ($row['packagetype'] == 'FedEx Ground Package'){ ?><img alt="" src="https://condosites.net/commons/packages/fedexground.png" width="50" height="50" border="0"><?php }; ?>
<?php if ($row['packagetype'] == 'DHL Package'){ ?><img alt="" src="https://condosites.net/commons/packages/dhl.png" width="50" height="50" border="0"><?php }; ?>
<?php if ($row['packagetype'] == 'Amazon Package'){ ?><img alt="" src="https://condosites.net/commons/packages/amazon.png" width="50" height="50" border="0"><?php }; ?>
<?php if ($row['packagetype'] == 'LaserShip Package'){ ?><img alt="" src="https://condosites.net/commons/packages/lasership.png" width="50" height="50" border="0"><?php }; ?>
<?php if ($row['packagetype'] == 'OnTrac Package'){ ?><img alt="" src="https://condosites.net/commons/packages/ontrac.png" width="50" height="50" border="0"><?php }; ?>
<?php if ($row['packagetype'] == 'USPS Package'){ ?><img alt="" src="https://condosites.net/commons/packages/usps.png" width="50" height="50" border="0"><?php }; ?>
<?php if ($row['packagetype'] == 'USPS Certified Letter'){ ?><img alt="" src="https://condosites.net/commons/packages/usps.png" width="50" height="50" border="0"><?php }; ?>
<?php if ($row['packagetype'] == 'USPS Express Mail'){ ?><img alt="" src="https://condosites.net/commons/packages/uspsexpress.png" width="50" height="50" border="0"><?php }; ?>
<?php if ($row['packagetype'] == 'USPS Priority Mail'){ ?><img alt="" src="https://condosites.net/commons/packages/uspspriority.png" width="50" height="50" border="0"><?php }; ?>
<?php if ($row['packagetype'] == 'USPS Registered Letter'){ ?><img alt="" src="https://condosites.net/commons/packages/usps.png" width="50" height="50" border="0"><?php }; ?>
<!-- DELIVERIES -->
<?php if ($row['packagetype'] == 'Delivery'){ ?><img alt="" src="https://condosites.net/commons/packages/delivery.png" width="50" height="50" border="0"><?php }; ?>
<?php if ($row['packagetype'] == 'Dry Cleaning'){ ?><img alt="" src="https://condosites.net/commons/packages/drycleaning.png" width="50" height="50" border="0"><?php }; ?>
<?php if ($row['packagetype'] == 'Flowers'){ ?><img alt="" src="https://condosites.net/commons/packages/flowers.png" width="50" height="50" border="0"><?php }; ?>
<?php if ($row['packagetype'] == 'Gift'){ ?><img alt="" src="https://condosites.net/commons/packages/gift.png" width="50" height="50" border="0"><?php }; ?>
<?php if ($row['packagetype'] == 'Groceries'){ ?><img alt="" src="https://condosites.net/commons/packages/groceries.png" width="50" height="50" border="0"><?php }; ?>
<?php if ($row['packagetype'] == 'Video'){ ?><img alt="" src="https://condosites.net/commons/packages/video.png" width="50" height="50" border="0"><?php }; ?>
	      </td>
	    </tr>
	  </tbody>
	</table>
	</div>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
      </td>
    </tr>
  </tbody>
</table>
<!-- CONTENT -->

</body>
  
	<script src="../java/vendor/what-input.js"></script>
	<script src="../java/vendor/foundation.min.js"></script>
	<script type="text/javascript" src="../java/google-base.js"></script>
	<script type="text/javascript" src="../my-documents/google-code.js"></script>

</html>