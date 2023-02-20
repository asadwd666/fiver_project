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
Vehicles and Bicycles
    </h4>
    <input type="button" value="Print Directory" onClick="window.open('vehicles-print.php');" class="filter-note" style="margin-top: 25px; ">
  </div>

<!-- Mobile Filter Notice -->
  <div class="stand-alone-page-content">
    <div class="rotate-note">Rotate your device to view vehicle/bicycle information.</div>
  </div>
  
</div>

<!-- CONTENT -->
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">

<?php if (($_SESSION['owner'] == true) OR ($_SESSION['lease'] == true) OR ($_SESSION['realtor'] == true)){ ?>
<?php if (($_SESSION['ghost'] != 'Y') OR ($_SESSION['webmaster'] == true)){ ?>
  <thead>
<!-- SUBMIT CONTENT -->
    <tr style="background-color: #FAFEB8;">
      <th colspan="7">
<a href="../forms/submit-VehicleRegistration.php">Would you like to <u>register your vehicle</u>?</a>
      </th>
    </tr>
<!-- END SUBMIT CONTENT -->
    <tr>
      <th align="center" colspan="7" style="background-image:url(../images/spacer_50yellow.gif)">Registered Vehicles</th>
    </tr>
    <tr>
      <th align="left" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Space &amp; Resident</small></th>
      <th align="left" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Contact</small></th>
      <th align="left" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>License</small></th>
      <th align="left" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>State</small></th>
      <th align="left" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Make & Model</small></th>
      <th align="left" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Color</small></th>
      <th align="left" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Permit</small></th>
    </tr>
  </thead>
<?php }; ?>
<?php }; ?>

<?php if (($_SESSION['owner'] != true) AND ($_SESSION['lease'] != true) AND ($_SESSION['realtor'] != true)){ ?>
  <tfoot>
    <tr style="background-color: #FAFEB8;">
      <th colspan="7">
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
      <th colspan="7">
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

<?php if (($_SESSION['owner'] == true) OR ($_SESSION['lease'] == true)){ ?>
<!-- DATABASE RESULTS -->
<?php
	$type   = $_SESSION['id'];
	$query  = "SELECT * FROM vehicles WHERE model != 'B*' ";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
	    <tr>
	      <td>
Space: <?php echo "{$row['space']}"; ?>
<?php if ($row['userid'] != '0'){ ?>
<?php
	$type    = $row['userid'];
	$query1  = "SELECT * FROM users WHERE id = '$type'";
	$result1 = mysqli_query($dbConn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?>
<br><b><?php echo "{$row1['first_name']}"; ?> <?php echo "{$row1['last_name']}"; ?></b><br>Unit: <?php echo "{$row1['unit']}"; ?><?php if ($row1['unit2'] !== 'X'){ ?> <?php echo "{$row1['unit2']}"; ?><?php }; ?>
<?php
	}
?>
<?php }; ?>
<?php if ($row['userid'] == '0'){ ?>
<br><b><?php echo "{$row['owner']}"; ?></b>
<?php }; ?>
	      </td>
	      <td>
<?php
	$type    = $row['userid'];
	$query1  = "SELECT phone, email, directory, dphone FROM users WHERE id = '$type'";
	$result1 = mysqli_query($dbConn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?>
	<?php if ($row1['dphone'] == 'Y'){ ?><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row1['phone']); ?>"><?php echo "{$row1['phone']}"; ?></a><?php }; ?>
	<?php if ($row1['directory'] == 'Y'){ ?><?php if ($row1['dphone'] == 'Y'){ ?><br><?php }; ?><a href="mailto:<?php echo($row1['email']); ?>"><?php echo($row1['email']); ?></a><?php }; ?>
<?php
	}
?>
	      </td>
	      <td><span style="text-transform: uppercase"><?php echo "{$row['license']}"; ?></span></td>
	      <td><?php echo "{$row['state']}"; ?></td>
	      <td><?php echo "{$row['make']}"; ?><br><?php echo "{$row['model']}"; ?></td>
	      <td><?php echo "{$row['color']}"; ?></td>
	      <td><?php echo "{$row['permit']}"; ?></td>
	    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
<?php }; ?>

  </tbody>
</table>
<!-- CONTENT -->
<br>
<?php if (($_SESSION['owner'] == true) OR ($_SESSION['lease'] == true) OR ($_SESSION['realtor'] == true)){ ?>
<?php if (($_SESSION['ghost'] != 'Y') OR ($_SESSION['webmaster'] == true)){ ?>
<!-- CONTENT -->
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">

  <thead>
<!-- SUBMIT CONTENT -->
    <tr style="background-color: #FAFEB8;">
      <th colspan="7">
<a href="../forms/submit-BicycleRegistration.php">Would you like to <u>register your bicycle</u>?</a>
      </th>
    </tr>
<!-- END SUBMIT CONTENT -->
    <tr>
      <th align="center" colspan="7" style="background-image:url(../images/spacer_50yellow.gif)">Registered Bicycles</th>
    </tr>
    <tr>
      <th align="left" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Space &amp; Resident</small></th>
      <th align="left" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Contact</small></th>
      <th align="left" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>License</small></th>
      <th align="left" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>State</small></th>
      <th align="left" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Make</small></th>
      <th align="left" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Color</small></th>
      <th align="left" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Permit</small></th>
    </tr>
  </thead>

  <tbody>

<!-- DATABASE RESULTS -->
<?php
	$type   = $_SESSION['id'];
	$query  = "SELECT * FROM vehicles WHERE model = 'B*' ";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
	    <tr>
	      <td>
Space: <?php echo "{$row['space']}"; ?>
<?php if ($row['userid'] != '0'){ ?>
<?php
	$type    = $row['userid'];
	$query1  = "SELECT * FROM users WHERE id = '$type'";
	$result1 = mysqli_query($dbConn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?>
<br><b><?php echo "{$row1['first_name']}"; ?> <?php echo "{$row1['last_name']}"; ?></b><br>Unit: <?php echo "{$row1['unit']}"; ?><?php if ($row1['unit2'] !== 'X'){ ?> <?php echo "{$row1['unit2']}"; ?><?php }; ?>
<?php
	}
?>
<?php }; ?>
<?php if ($row['userid'] == '0'){ ?>
<br><b><?php echo "{$row['owner']}"; ?></b>
<?php }; ?>
	      </td>
	      <td>
<?php
	$type    = $row['userid'];
	$query1  = "SELECT phone, email, directory, dphone FROM users WHERE id = '$type'";
	$result1 = mysqli_query($dbConn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?>
	<?php if ($row1['dphone'] == 'Y'){ ?><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row1['phone']); ?>"><?php echo "{$row1['phone']}"; ?></a><?php }; ?>
	<?php if ($row1['directory'] == 'Y'){ ?><?php if ($row1['dphone'] == 'Y'){ ?><br><?php }; ?><a href="mailto:<?php echo($row1['email']); ?>"><?php echo($row1['email']); ?></a><?php }; ?>
<?php
	}
?>
	      </td>
	      <td><span style="text-transform: uppercase"><?php echo "{$row['license']}"; ?></span></td>
	      <td><?php echo "{$row['state']}"; ?></td>
	      <td><?php echo "{$row['make']}"; ?></td>
	      <td><?php echo "{$row['color']}"; ?></td>
	      <td><?php echo "{$row['permit']}"; ?></td>
	    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->

  </tbody>
</table>
<!-- CONTENT -->
<?php }; ?>
<?php }; ?>

</body>
  
	<script src="../java/vendor/what-input.js"></script>
	<script src="../java/vendor/foundation.min.js"></script>
	<script type="text/javascript" src="../java/google-base.js"></script>
	<script type="text/javascript" src="../my-documents/google-code.js"></script>

</html>