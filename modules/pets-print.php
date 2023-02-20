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
      <th colspan="4" style="background-color: white"><img src="../pics/logo-small.png" style="max-width: 300px; max-height: 100px;">
    </tr>
    <tr>
      <th align="left" class="table-sortable:alphanumeric" style="cursor:pointer;">&nbsp;&nbsp;&nbsp; Information</th>
      <th align="left" class="table-sortable:alphanumeric" style="cursor:pointer;">&nbsp;&nbsp;&nbsp; Owner</th>
      <th>Photo</th>
      <th align="left" class="table-sortable:alphanumeric table-filterable" width="100"><small>Species</small></th>
    </tr>
  </thead>
<?php }; ?>
<?php }; ?>
<?php
	$sessionowner = $_SESSION['owner'];
	$sessionlease = $_SESSION['lease'];
	$sessionrealtor = $_SESSION['realtor'];
	$sessionghost = $_SESSION['ghost'];
	$query  = "SELECT owner, lease FROM `tabs` WHERE `int1`='230'";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php if (((($row['owner'] == 'Y' && $sessionowner == '1') OR ($row['lease'] == 'Y' && $sessionlease == '1')) AND ($_SESSION['ghost'] != 'Y')) OR ($_SESSION['webmaster'] == true)){ ?>

  <tbody>

<!-- DATABASE RESULTS -->
<?php
	$query  = "SELECT * FROM pets WHERE approved = 'Y' ORDER by petname";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
    <tr>
      <td>

	<b><big>&quot;<?php echo "{$row['petname']}"; ?>&quot;</big></b><br>

	<?php if ($row['comments'] !== ''){ ?><?php if ($row['lost'] == 'No'){ ?><?php }; ?>Comments: <?php echo "{$row['comments']}"; ?><br><?php }; ?>

      </td>
      <td>

<?php if ($row['userid'] == '0'){ ?><b><?php echo "{$row['owner']}"; ?></b><?php }; ?>

<?php
	$type    = $row['userid'];
	$query1  = "SELECT first_name, last_name, unit, unit2 FROM users WHERE id = '$type'";
	$result1 = mysqli_query($dbConn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?>
<b><?php echo "{$row1['first_name']}"; ?> <?php echo "{$row1['last_name']}"; ?></b><br>Unit: <?php echo "{$row1['unit']}"; ?><?php if ($row1['unit2'] !== 'X'){ ?> <?php echo "{$row1['unit2']}"; ?><?php }; ?>
<?php
	}
?>

      </td>
      <td><?php if ($row['name'] !== 'none.gif'){ ?><img src="../download-pets.php?id=<?php echo "{$row['id']}"; ?>" height="125" border="0" alt=""><?php }; ?></td>
      <td align="center" width="25%"><?php echo "{$row['species']}"; ?></td>
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