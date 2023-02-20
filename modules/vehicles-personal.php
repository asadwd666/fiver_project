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

<?php $id = $_POST["id"]; $action = $_POST["action"]; if ($action != null){ ?>
<?php
	if ($action == "delete"){
		$query = "DELETE FROM vehicles WHERE `id`='$id'";
		mysqli_query($dbConn,$query) or die('Error, delete query failed');
		
		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('D', 'Vehicle', '$useripaddress', '$userid', '$id')";
		mysqli_query($dbConn,$query) or die('Error, updating log failed');
	}
	
}
?>

<div id="all-documents-folder" class="stand-alone-page">
  <div class="popup-header">
    <h4>
My Vechicles and Bicycles
    </h4>
  </div>

<!-- Mobile Filter Notice -->
  <div class="stand-alone-page-content">
    <div class="rotate-note">Rotate your device to view vehicle/bicycle information and delete controls.</div>
  </div>
  
</div>

<!-- CONTENT -->
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">

  <thead>
<!-- SUBMIT CONTENT -->
    <tr style="background-color: #FAFEB8;">
      <th colspan="3">
<a href="../forms/submit-VehicleRegistration.php">Would you like to <u>register another vehicle</u>?</a>
      </th>
    </tr>
<!-- END SUBMIT CONTENT -->
    <tr>
      <th align="center" colspan="3" style="background-image:url(../images/spacer_50yellow.gif)"><?php $type = $_SESSION['id']; $sql = mysqli_query($dbConn,"SELECT count(*) FROM vehicles WHERE userid = '$type' AND model != 'B*'") or die(mysqli_error($dbConn));
      //$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Registered Vehicles - <a href="">Register a vehicle</a></th>
    </tr>
    <tr>
      <th align="left" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>License and Permit</small></th>
      <th align="left" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Vehicle</small></th>
      <th align="left"><b><small>Delete</small></b></th>
    </tr>
  </thead>

<?php if (($_SESSION['owner'] != true) AND ($_SESSION['lease'] != true) AND ($_SESSION['realtor'] != true)){ ?>
  <tfoot>
    <tr style="background-color: #FAFEB8;">
      <th colspan="3">
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
      <th colspan="3">
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

<!-- DATABASE RESULTS -->
<?php
	$type   = $_SESSION['id'];
	$query  = "SELECT * FROM vehicles WHERE userid = '$type' AND model != 'B*' ";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
    <tr>
      <td><span style="text-transform: uppercase"><b><?php echo "{$row['state']}"; ?>&nbsp;&nbsp;<?php echo "{$row['license']}"; ?></b></span><br>Space: <?php echo "{$row['space']}"; ?><br>Permit: <?php echo "{$row['permit']}"; ?></td>
      <td><?php echo "{$row['make']}"; ?><br><?php echo "{$row['model']}"; ?><br><?php echo "{$row['color']}"; ?></td>
      <td>
	<form name="VehiclesDelete" method="POST" action="vehicles-personal.php" onclick="return confirm('Are you sure you want to delete this vehicle?');">
	<input type="hidden" name="action" value="delete">
	<input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
	<input name="submit" value="Remove this Vehicle" class="submit" type="submit">
	</form>
      </td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->

  </tbody>
</table>
<!-- CONTENT -->
<br>
<!-- CONTENT -->
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">

  <thead>
<!-- SUBMIT CONTENT -->
    <tr style="background-color: #FAFEB8;">
      <th colspan="3">
<a href="../forms/submit-BicycleRegistration.php">Would you like to <u>register your bicycle</u>?</a>
      </th>
    </tr>
<!-- END SUBMIT CONTENT -->
    <tr>
      <th align="center" colspan="3" style="background-image:url(../images/spacer_50yellow.gif)"><?php $type = $_SESSION['id']; $sql = mysqli_query($dbConn,"SELECT count(*) FROM vehicles WHERE userid = '$type' AND model = 'B*'") or die(mysqli_error($dbConn));
      //$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Registered Bicycles</th>
    </tr>
    <tr>
      <th align="left" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>License and Permit</small></th>
      <th align="left" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Bicycle</small></th>
      <th align="left"><b><small>Delete</small></b></th>
    </tr>
  </thead>

  <tbody>

<!-- DATABASE RESULTS -->
<?php
	$type   = $_SESSION['id'];
	$query  = "SELECT * FROM vehicles WHERE userid = '$type' AND model = 'B*' ";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
    <tr>
      <td><span style="text-transform: uppercase"><b><?php echo "{$row['state']}"; ?>&nbsp;&nbsp;<?php echo "{$row['license']}"; ?></b></span><br>Space: <?php echo "{$row['space']}"; ?><br>Permit: <?php echo "{$row['permit']}"; ?></td>
      <td><?php echo "{$row['make']}"; ?><br><?php echo "{$row['color']}"; ?></td>
      <td>
	<form name="VehiclesDelete" method="POST" action="vehicles-personal.php" onclick="return confirm('Are you sure you want to delete this vehicle?');">
	<input type="hidden" name="action" value="delete">
	<input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
	<input name="submit" value="Remove this Bicycle" class="submit" type="submit">
	</form>
      </td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->

  </tbody>
</table>
<!-- CONTENT -->

</body>
  
	<script src="../java/vendor/what-input.js"></script>
	<script src="../java/vendor/foundation.min.js"></script>
	<script type="text/javascript" src="../java/google-base.js"></script>
	<script type="text/javascript" src="../my-documents/google-code.js"></script>

</html>