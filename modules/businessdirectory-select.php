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
<?php
	$choice    = $_GET['choice'];
	{
?>
      <?php echo "{$choice}"; ?>
<?php
	}
?>
    </h4>
  </div>

<!-- Mobile Filter Notice -->
  <div class="stand-alone-page-content">
    <div class="rotate-note">Rotate your device to view comments.</div>
  </div>
  
</div>

<!-- CONTENT -->
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>   

<!-- SUBMIT CONTENT -->
<?php if (($_SESSION['owner'] == true) OR ($_SESSION['lease'] == true) OR ($_SESSION['realtor'] == true)){ ?>
    <tr style="background-color: #FAFEB8;">
      <th colspan="2">
<a href="../forms/submit-BusinessDirectory.php">Would you like to <u>recommend a business</u> for the directory?</a>
      </th>
    </tr>
<?php }; ?>
<!-- END SUBMIT CONTENT -->

    <tr>
      <th align="left" class="table-sortable:alphanumeric" style="cursor:pointer;">&nbsp;&nbsp;&nbsp; Listing</th>
      <th align="left" class="table-sortable:alphanumeric" style="cursor:pointer;">&nbsp;&nbsp;&nbsp; Comments</th>
    </tr>
  </thead>
  <tfoot>

<!-- DISCLOSURE -->
    <tr>
      <th align="left" colspan="2">
<blockquote>
<?php
	$query  = "SELECT * FROM 3rd WHERE type = 'Business Directory Disclosure'";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<small><?php echo "{$row['theircode']}"; ?></small>
<?php
	}
?>
</blockquote>
      </th>
    </tr>
<!-- END DISCLOSURE -->

  </tfoot>
  <tbody>





<!-- DATABASE RESULTS -->
<?php
	$type    = $_GET['choice'];
	$query  = "SELECT * FROM concierge WHERE type = '$type' AND approved = 'Y' ORDER BY name";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
    <tr>
      <td align="left" valign="top">
<b><?php echo "{$row['name']}"; ?></b><br>

<?php if ($row['address'] !== ''){ ?><br><?php echo "{$row['address']}"; ?><?php }; ?>
<?php if ($row['phone'] !== ''){ ?><br><b><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row['phone']); ?>"><?php echo "{$row['phone']}"; ?></a></b><?php }; ?>

<?php if ($row['url'] !== ''){ ?><br><a href="<?php echo "{$row['url']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('External/<?php echo "{$row['url']}"; ?>'); "><?php echo "{$row['url']}"; ?></a><?php }; ?>

<?php if ($row['directions'] !== ''){ ?><br><a href="<?php echo "{$row['directions']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('External/<?php echo "{$row['directions']}"; ?>'); ">Map Directions</a><?php }; ?>

<?php if ($row['email'] !== ''){ ?><br><a href="mailto:<?php echo "{$row['email']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('Email/<?php echo "{$row['email']}"; ?>'); "><?php echo "{$row['email']}"; ?></a><?php }; ?>

<?php if ($row['docid'] !== ''){ ?>
	<?php
		$type    = $row['docid'];
		$queryDOC  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$resultDOC = mysqli_query($dbConn,$queryDOC);

		while($rowDOC = $resultDOC->fetch_array(MYSQLI_ASSOC))
		{
	?>
<br><a href="../download-documents.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>'); ">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a>
	<?php
		}
	?>
<?php }; ?>

      </td>

      <td align="left" valign="middle">
<?php if ($row['comments'] !== ''){ ?><?php echo "{$row['comments']}"; ?><?php }; ?>
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