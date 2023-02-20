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
	$query  = "SELECT title FROM tabs WHERE `int1` = '310'";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php echo "{$row['title']}"; ?>
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
    <tr>
      <th align="left" class="table-sortable:alphanumeric" style="cursor:pointer;">&nbsp;&nbsp;&nbsp; Listing</th>
      <th align="left" class="table-sortable:alphanumeric" style="cursor:pointer; min-width: 50%;">&nbsp;&nbsp;&nbsp; Comments</th>
    </tr>
  </thead>

  <tbody>

<!-- DATABASE RESULTS -->
<?php
	$query  = "SELECT * FROM utilities WHERE category = 'Utility' OR category = 'Manager' OR category = 'Local Links' ORDER BY company";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
    <tr>
      <td valign="top">
	<?php if ($row['company'] !== ''){ ?><b><?php echo "{$row['company']}"; ?></b><?php }; ?>
	    <?php if ($row['name'] !== ''){ ?>
	        <div style="float: right; padding: 25px;">
	            <?php if ($row['name'] !== '' AND $row['name'] !== 'none.gif'){ ?>
	                <div class="module-image"><img src="../download-utilities.php?id=<?php echo "{$row['id']}"; ?>" alt="<?php echo "{$row['company']}"; ?>"></div>
	            <?php }; ?>
	        </div>
	    <?php }; ?>
	<?php if ($row['utility'] !== ''){ ?><br>(<?php echo "{$row['utility']}"; ?>)<?php }; ?>
	<?php if ($row['contact'] !== ''){ ?><br><?php echo "{$row['contact']}"; ?><?php }; ?>
	<br>
	<?php if ($row['address1'] !== ''){ ?><br><?php echo "{$row['address1']}"; ?><?php }; ?>
	<?php if ($row['address2'] !== ''){ ?><br><?php echo "{$row['address2']}"; ?><?php }; ?>
	<?php if ($row['address1'] !== ''){ ?><br><?php }; ?>

	<?php if ($row['phone1'] !== ''){ ?><br><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row['phone1']); ?>"><?php echo "{$row['phone1']}"; ?></a><?php }; ?>
	<?php if ($row['phone2'] !== ''){ ?><br><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row['phone2']); ?>"><?php echo "{$row['phone2']}"; ?></a><?php }; ?>
	<?php if ($row['phone3'] !== ''){ ?><br><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row['phone3']); ?>"><?php echo "{$row['phone3']}"; ?></a><?php }; ?>
	<?php if ($row['phone4'] !== ''){ ?><br><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row['phone4']); ?>"><?php echo "{$row['phone4']}"; ?></a><?php }; ?>
	<?php if ($row['phone1'] !== ''){ ?><br><?php }; ?>

	<?php if ($row['web'] !== ''){ ?><br><a href="<?php echo "{$row['web']}"; ?>" target="_blank"><?php echo "{$row['web']}"; ?></a><?php }; ?>
	<?php if ($row['email'] !== ''){ ?><br><a href="mailto:<?php echo "{$row['email']}"; ?>?subject=<?php include('../my-documents/communityname.html'); ?>"><?php echo "{$row['email']}"; ?></a><?php }; ?>	

<?php if ($row['docid'] !== ''){ ?>
	<?php
		$type    = $row['docid'];
		$queryDOC  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$resultDOC = mysqli_query($dbConn,$queryDOC);

		while($rowDOC = $resultDOC->fetch_array(MYSQLI_ASSOC))
		{
	?>
<br><br><a href="../download-documents.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>'); ">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a>
	<?php
		}
	?>
<?php }; ?>
      </td>
      <td>
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
