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
<?php if ($_GET["choice"] == 'Realtors') { ?>
<?php
	$query  = "SELECT title FROM tabs WHERE `int1` = '320'";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php echo "{$row['title']}"; ?>
<?php
	}
?>
<?php } ?>
<?php if ($_GET["choice"] == 'Residents') { ?>
<?php
	$query  = "SELECT title FROM tabs WHERE `int1` = '321'";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php echo "{$row['title']}"; ?>
<?php
	}
?>
<?php } ?>
<?php if ($_GET["choice"] == 'Pets') { ?>
<?php
	$query  = "SELECT title FROM tabs WHERE `int1` = '322'";
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
<?php if (($_SESSION['owner'] == true) OR ($_SESSION['lease'] == true) OR ($_SESSION['realtor'] == true)){ ?>
  <tfoot>
    <tr style="background-color: #FAFEB8;">
      <th>
<br>
<big>Clearly you have questions!</big><br>
<a href="../forms/forcom.php?choice=411&conn=<?php echo $connName;?>">Please <u>submit your questions and ideas</u> to the administrator of the website.</a>
<br>
<br>
      </th>
    </tr>
  </tfoot>
<?php }; ?>
  <tbody>

<!-- DATABASE RESULTS -->
<?php
	$type    = $_GET['choice'];
		$query  = "SELECT * FROM faq WHERE type = '$type' ORDER BY `int1`";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

?>
    <tr>
      <td>
        <b><?php echo "{$row['question']}"; ?></b><br>
        <blockquote>
        <?php echo "{$row['answer']}"; ?><br>

<?php if ($row['web'] !== ''){ ?><br><a href="<?php echo "{$row['web']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('External/<?php echo "{$row['web']}"; ?>'); ">Link to Website</a><?php }; ?>

<?php if ($row['email'] !== ''){ ?><br><a href="mailto:<?php echo "{$row['email']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('Email/<?php echo "{$row['email']}"; ?>'); ">Email</a><?php }; ?>

<?php if ($row['docid'] !== ''){ ?>
	<?php
		$type    = $row['docid'];
		$queryDOC  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$resultDOC = mysqli_query($dbConn,$queryDOC);

		while($rowDOC = $resultDOC->fetch_array(MYSQLI_ASSOC))
		{
	?>
<br><a href="../download-documents.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>'); ">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a>
	<?php
		}
	?>
<?php }; ?>
        </blockquote>
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
