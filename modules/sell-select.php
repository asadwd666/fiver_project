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
<?php if ($_GET["choice"] == 'CLASSIFIED') { ?>
<?php
	$query  = "SELECT title FROM tabs WHERE `int1` = '205'";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php echo "{$row['title']}"; ?>
<?php
	}
?>
<?php } ?>
<?php if ($_GET["choice"] == 'SALE') { ?>
<?php
	$query  = "SELECT title FROM tabs WHERE `int1` = '206'";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php echo "{$row['title']}"; ?>
<?php
	}
?>
<?php } ?>
<?php if ($_GET["choice"] == 'RENT') { ?>
<?php
	$query  = "SELECT title FROM tabs WHERE `int1` = '207'";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php echo "{$row['title']}"; ?>
<?php
	}
?>
<?php } ?>
<?php if ($_GET["choice"] == 'SOCIAL') { ?>
<?php
	$query  = "SELECT title FROM tabs WHERE `int1` = '209'";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php echo "{$row['title']}"; ?>
<?php
	}
?>
<?php } ?>
<?php
	}
?>
    </h4>
  </div>

<!-- Mobile Filter Notice -->
  <div class="stand-alone-page-content">
    <div class="rotate-note"></div>
  </div>
  
</div>

<!-- CONTENT -->
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>

<!-- POST CONTENT NOTICE -->
<?php if (($_SESSION['owner'] == true) OR ($_SESSION['lease'] == true) OR ($_SESSION['realtor'] == true)){ ?>
    <tr style="background-color: #FAFEB8;">
      <th colspan="2">
<a href="../forms/submit-Sell.php">Would you like to <u>submit a listing</u>?</a>
      </th>
    </tr>
<?php }; ?>
<!-- POST CONTENT NOTICE -->

    <tr>
      <th align="left" width="475" class="table-sortable:alphanumeric" style="cursor:pointer;">&nbsp;&nbsp;&nbsp; Listing</th>
    </tr>
  </thead>

  <tfoot>
    <tr>
      <th align="left">
<blockquote>
<small>This list is an advertising courtesy to the community.  Please contact the person associated with the listing for more information. The Association, Board, Management, and CondoSites (the vendor of this website) does not warrant or confirm any of the details listed.</small>
</blockquote>
      </th>
    </tr>
  </tfoot>

  <tbody>

<!-- DATABASE RESULTS -->
<?php
	$forsalerent    = $_GET['choice'];
	$query  = "SELECT * FROM realestate WHERE forsalerent = '$forsalerent' AND eod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() AND approved = 'Y' ORDER BY created_date DESC";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
	    <tr>
	      <td>
<?php if ($row['name'] !== ''){ ?>
    <?php if ($row['name'] !== 'none.gif'){ ?>
        <div class="module-image"><a href="../download-sell.php?int1=<?php echo "{$row['int1']}"; ?>" target="_blank"><img src="../download-sell.php?int1=<?php echo "{$row['int1']}"; ?>" alt="<?php echo "{$row['title']}"; ?>"></a></div>
    <?php }; ?>
<?php }; ?>
<b><?php echo "{$row['headline']}"; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "{$row['price']}"; ?></b><br>
<br>
<?php if ($row['description'] !== ''){ ?><?php echo "{$row['description']}"; ?><?php }; ?>

<span class="text"><?php if ($row['url'] !== ''){ ?><br><a href="<?php echo "{$row['url']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('External/<?php echo "{$row['url']}"; ?>'); "><?php echo "{$row['url']}"; ?></a><?php }; ?>
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
<?php if ($row['contact'] !== ''){ ?><br>Contact: <?php echo "{$row['contact']}"; ?><?php }; ?>
<?php if ($row['phone'] !== ''){ ?><br>Phone: <a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row['phone']); ?>"><?php echo "{$row['phone']}"; ?></a><?php }; ?>
<?php if ($row['email'] !== ''){ ?><br>Email: <a href="mailto:<?php echo "{$row['email']}"; ?>" onclick="javascript:pageTracker._trackPageview('RealEstate/<?php echo "{$row['email']}"; ?>'); "><?php echo "{$row['email']}"; ?></a><?php }; ?></span></td>
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