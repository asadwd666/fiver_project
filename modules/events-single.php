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
Calendar Event
    </h4>
  </div>

<!-- Mobile Filter Notice -->
  <div class="stand-alone-page-content">
    <div class="rotate-note"></div>
  </div>
  
</div>

<!-- CONTENT -->
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">

  <tbody>

<!-- DATABASE RESULTS -->

<?php
	$type    = $_GET['choice'];
	$queryMOD  = "SELECT `int1`, title, date, stime, etime, url, email, details, detailsmini, location, created_date, docid, event FROM calendar WHERE `int1` = '$type'";
	$resultMOD = mysqli_query($dbConn,$queryMOD);

	while($rowMOD = $resultMOD->fetch_array(MYSQLI_ASSOC))
	{
?>

    <tr>
      <td><b><?php echo "{$rowMOD['title']}"; ?></b><br>

<?php if ($rowMOD['date'] !== '0000-00-00'){ ?><br><?php echo "{$rowMOD['date']}"; ?><?php }; ?><?php if ($rowMOD['date'] == '0000-00-00'){ ?><i>ongoing</i><?php }; ?><?php if ($rowMOD['stime'] !== '00:00:00'){ ?> <br><?php echo date('g:i a', strtotime($rowMOD['stime'])); ?><?php }; ?><?php if ($rowMOD['etime'] !== '00:00:00'){ ?> to <?php echo date('g:i a', strtotime($rowMOD['etime'])); ?><br><?php }; ?>

<?php if ($rowMOD['location'] !== ''){ ?><blockquote><?php echo "{$rowMOD['location']}"; ?></blockquote><?php }; ?>

<?php if ($rowMOD['details'] !== ''){ ?><blockquote><?php echo "{$rowMOD['details']}"; ?></blockquote><?php }; ?>

<?php include('events/google.php'); ?>&nbsp;&nbsp;<?php include('events/calendarlink.php'); ?><br>

<?php if ($rowMOD['url'] !== ''){ ?><br><a href="<?php echo "{$rowMOD['url']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('External/<?php echo "{$rowMOD['url']}"; ?>'); "><?php echo "{$rowMOD['url']}"; ?></a><?php }; ?>

<?php if ($rowMOD['email'] !== ''){ ?><br><a href="mailto:<?php echo "{$rowMOD['email']}"; ?>" onclick="javascript:pageTracker._trackPageview('Email/<?php echo "{$rowMOD['email']}"; ?>'); "><?php echo "{$rowMOD['email']}"; ?></a><?php }; ?>


<!-- DOCUMENT 1 -->
<?php if ($row['docid'] !== ''){ ?>
	<?php
		$type    = $rowMOD['docid'];
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
<!-- END DOCUMENT 1 -->

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
