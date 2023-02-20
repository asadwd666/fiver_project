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
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <link rel="stylesheet" href="../css/app-print.css">
    <script src="../java/table.js" type="text/javascript"></script>
</head>

<body style="background-color: #ffffff;" class="no-bg">

<!-- CONTENT -->
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0" class="table-autosort table-autofilter table-stripeclass:alternate table-stripeclass:alternate table-autostripe table-rowshade-alternate">
<?php if (($_SESSION['owner'] == true) OR ($_SESSION['lease'] == true) OR ($_SESSION['realtor'] == true)){ ?>
<?php if (($_SESSION['ghost'] != 'Y') OR ($_SESSION['webmaster'] == true)){ ?>
  <thead>
    <tr>
      <th colspan="7" style="background-color: white"><img src="../pics/logo-small.png" style="max-width: 300px; max-height: 100px;">
    </tr>
    <tr>
      <th colspan="7"><b>Registered Vehicles</b></th>
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
<?php
	$sessionowner = $_SESSION['owner'];
	$sessionlease = $_SESSION['lease'];
	$sessionrealtor = $_SESSION['realtor'];
	$sessionghost = $_SESSION['ghost'];
	$query  = "SELECT owner, lease FROM `tabs` WHERE `int1`='237'";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php if (((($row['owner'] == 'Y' && $sessionowner == '1') OR ($row['lease'] == 'Y' && $sessionlease == '1')) AND ($_SESSION['ghost'] != 'Y')) OR ($_SESSION['webmaster'] == true)){ ?>

  <tbody>

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
	<?php if ($row1['dphone'] == 'Y'){ ?><?php echo "{$row1['phone']}"; ?><?php }; ?>
	<?php if ($row1['directory'] == 'Y'){ ?><?php if ($row1['dphone'] == 'Y'){ ?><br><?php }; ?><?php echo($row1['email']); ?><?php }; ?>
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

  </tbody>
  

<?php }; ?>
<?php
	}
?>

</table>
<!-- CONTENT -->

<!-- CONTENT -->
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0" class="table-autosort table-autofilter table-stripeclass:alternate table-stripeclass:alternate table-autostripe table-rowshade-alternate">
<?php if (($_SESSION['owner'] == true) OR ($_SESSION['lease'] == true) OR ($_SESSION['realtor'] == true)){ ?>
<?php if (($_SESSION['ghost'] != 'Y') OR ($_SESSION['webmaster'] == true)){ ?>
  <thead>
    <tr>
      <th colspan="7" style="background-color: white"><img src="../pics/logo-small.png" style="max-width: 300px; max-height: 100px;">
    </tr>
    <tr>
      <th colspan="7"><b>Registered Bicycles</b></th>
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
<?php }; ?>
<?php }; ?>
<?php
	$sessionowner = $_SESSION['owner'];
	$sessionlease = $_SESSION['lease'];
	$sessionrealtor = $_SESSION['realtor'];
	$sessionghost = $_SESSION['ghost'];
	$query  = "SELECT owner, lease FROM `tabs` WHERE `int1`='237'";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php if (((($row['owner'] == 'Y' && $sessionowner == '1') OR ($row['lease'] == 'Y' && $sessionlease == '1')) AND ($_SESSION['ghost'] != 'Y')) OR ($_SESSION['webmaster'] == true)){ ?>

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
	<?php if ($row1['dphone'] == 'Y'){ ?><?php echo "{$row1['phone']}"; ?><?php }; ?>
	<?php if ($row1['directory'] == 'Y'){ ?><?php if ($row1['dphone'] == 'Y'){ ?><br><?php }; ?><?php echo($row1['email']); ?><?php }; ?>
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
  

<?php }; ?>
<?php
	}
?>

</table>
<!-- CONTENT -->

</body>

	<script type="text/javascript" src="../java/google-base.js"></script>
	<script type="text/javascript" src="../my-documents/google-code.js"></script>

</html>