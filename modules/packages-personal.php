<?php require_once('../my-documents/php7-my-db.php');
$connName = isset($_GET['conn']) ? $_GET['conn'] : "none";

if (isset($connectionPool) && isset($connectionPool[$connName])) {
    $dbConn = $connectionPool[$connName]['connection'];
} else {
    $dbConn = $conn;
}
$updateComplete = false;
$action = $_POST["action"];
// Read the Timezone Offset file
$timezoneOffsetStr = file_get_contents('../my-documents/localization-timezone.txt');

//Extract the offset
$timezoneOffset = substr($timezoneOffsetStr, 0, strpos($timezoneOffsetStr, ";"));

if ($action == "save"){
    $deliveredPackages = $_POST['delivered'];

    $userName = $_SESSION['first_name'] . " " . $_SESSION['last_name'];

    foreach ($deliveredPackages as $package) {
        print 'Package ID is '. $package;
        $sql = "UPDATE packages SET puemp = '" . $userName . "' ,pickedupby = '" . $userName . "', pickedup = '" . gmdate('Y-m-d H:i:s', time() + 3600*($timezoneOffset+date('I'))) ."' WHERE  `int1` = " . $package ;
        mysqli_query($dbConn, $sql);
        $updateComplete = true;
    }
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
My Packages and Deliveries
    </h4>
  </div>

<!-- Mobile Filter Notice -->
  <div class="stand-alone-page-content">
    <div class="rotate-note">Rotate your device for local tracking information.</div>
  </div>
  
</div>

<!-- CONTENT -->
<form action="" method="POST">
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <?php if ($updateComplete) { ?>
    <tr>
        <th colspan="2"><?php echo count($_POST['delivered']); ?> Packages and Deliveries Marked as Delivered</th>
    </tr>
    <?php } ?>
    <tr>
      <th align="center" colspan="2"><?php $type = $_SESSION['id']; $sql = mysqli_query($dbConn,"SELECT count(*) FROM packages WHERE userid = '$type' AND pickedup = '0000-00-00 00:00:00'") or die(mysqli_error($dbConn));
      //$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Packages and Deliveries Awaiting Pickup</th>
    </tr>
    <tr>
      <th align="left" class="table-sortable:alphanumeric"><b>&nbsp;&nbsp;&nbsp; Package information</b></th>
      <th align="left" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; Local tracking information</th>
    </tr>
  </thead>
  <tbody>

<!-- DATABASE RESULTS -->
<?php
	$type   = $_SESSION['id'];
	$query  = "SELECT * FROM packages WHERE userid = '$type' AND pickedup = '0000-00-00 00:00:00' ORDER BY `int1`";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
    <tr>
      <td>
        <div style="float: left; padding-left: 10px; padding-right: 10px;"><?php include('../control/package-graphics.php'); ?></div>
        <b><?php echo "{$row['from']}"; ?></b><br>
       	Package ID: <?php echo "{$row['int1']}"; ?>
	<?php if ($row['pkgtracking'] !== ''){ ?><br><span class="text2"><b>Trk&#35; </b>&nbsp;<?php include('../control/package-track.php'); ?>&nbsp;</span><?php }; ?>
	<?php if ($row['pickedupby'] !== ''){ ?><br><span class="text2"><b>Released to: </b><?php echo "{$row['pickedupby']}"; ?>&nbsp;</span><?php }; ?>
          <br>Mark as Delivered / Already Picked-Up: <input name="delivered[]" type="checkbox" id="delivered_<?php echo "{$row['int1']}"; ?>" class="form" value="<?php echo "{$row['int1']}"; ?>">
      </td>
      <td>
	<?php if ($row['received'] !== ''){ ?><span class="text2"><br><b>Received: </b><?php echo date('Y-m-d g:i a', strtotime($row['received'])); ?><b> by: </b><?php echo "{$row['recemp']}"; ?>&nbsp;</span><?php }; ?>
	<?php if ($row['pickedup'] == '0000-00-00 00:00:00'){ ?><br><span class="text2">Package Location: <?php echo "{$row['pkglocation']}"; ?></span><?php }; ?>
	<?php if ($row['pickedup'] !== '0000-00-00 00:00:00'){ ?><span class="text2"><br><b>Released: </b><?php echo date('Y-m-d g:i a', strtotime($row['pickedup'])); ?><b> by: </b><?php echo "{$row['puemp']}"; ?></span><?php }; ?>
	<blockquote><span class="text2"><?php echo "{$row['comments']}"; ?></span></blockquote>
      </td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
    <tr>
        <td colspan="2">
            <input name="submit" value="Mark Selected Packages Above as Delivered or Already Picked up" class="submit" type="submit" onclick="value='Processing Request - Resubmit'; style='color:red';">
            <input type="hidden" name="action" value="save">
        </td>
    </tr>
  </tbody>
</table>
</form>
<br>
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr>
      <th align="center" colspan="2">Last 10 Picked-up Packages and Deliveries</th>
    </tr>
    <tr>
      <th align="left" class="table-sortable:alphanumeric"><b>&nbsp;&nbsp;&nbsp; Package information</b></th>
      <th align="left" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; Local tracking information</th>
    </tr>
  </thead>
  <tbody>

<!-- DATABASE RESULTS -->
<?php
	$type   = $_SESSION['id'];
	$query  = "SELECT * FROM packages WHERE userid = '$type' AND pickedup != '0000-00-00 00:00:00' ORDER BY `int1`";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
    <tr>
      <td>
        <div style="float: left; padding-left: 10px; padding-right: 10px;"><?php include('../control/package-graphics.php'); ?></div>
        <b><?php echo "{$row['from']}"; ?></b><br>
       	Package ID: <?php echo "{$row['int1']}"; ?>
	<?php if ($row['pkgtracking'] !== ''){ ?><br><span class="text2"><b>Trk&#35; </b>&nbsp;<?php include('../control/package-track.php'); ?>&nbsp;</span><?php }; ?>
	<?php if ($row['pickedupby'] !== ''){ ?><br><span class="text2"><b>Released to: </b><?php echo "{$row['pickedupby']}"; ?>&nbsp;</span><?php }; ?>
      </td>
      <td>
	<?php if ($row['received'] !== ''){ ?><span class="text2"><br><b>Received: </b><?php echo date('Y-m-d g:i a', strtotime($row['received'])); ?><b> by: </b><?php echo "{$row['recemp']}"; ?>&nbsp;</span><?php }; ?>
	<?php if ($row['pickedup'] == '0000-00-00 00:00:00'){ ?><br><span class="text2">Package Location: <?php echo "{$row['pkglocation']}"; ?></span><?php }; ?>
	<?php if ($row['pickedup'] !== '0000-00-00 00:00:00'){ ?><span class="text2"><br><b>Released: </b><?php echo date('Y-m-d g:i a', strtotime($row['pickedup'])); ?><b> by: </b><?php echo "{$row['puemp']}"; ?></span><?php }; ?>
	<blockquote><span class="text2"><?php echo "{$row['comments']}"; ?></span></blockquote>
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