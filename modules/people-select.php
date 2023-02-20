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
<?php if ($_GET["choice"] == 'Committee') { ?>
<?php
	$query  = "SELECT title FROM tabs WHERE `int1` = '201'";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php echo "{$row['title']}"; ?>
<?php
	}
?>
<?php } ?>
<?php if ($_GET["choice"] == 'Board') { ?>
<?php
	$query  = "SELECT title FROM tabs WHERE `int1` = '202'";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php echo "{$row['title']}"; ?>
<?php
	}
?>
<?php } ?>
<?php if ($_GET["choice"] == 'Staff') { ?>
<?php
	$query  = "SELECT title FROM tabs WHERE `int1` = '203'";
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
    <div class="rotate-note">Rotate your mobile device to view folder and date columns, and for sorting and filtering tools.</div>
  </div>

</div>

<!-- CONTENT -->
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-stripeclass:alternate table-autostripe table-rowshade-alternate">

<?php if (((($_SESSION['owner'] == true) OR ($_SESSION['lease'] == true) OR ($_SESSION['realtor'] == true)) AND ($_SESSION['ghost'] != 'Y')) OR ($_SESSION['webmaster'] == true)){ ?>
  <thead>
    <tr>
      <th class="table-sortable:alphanumeric" style="cursor:pointer;"><b>&nbsp;&nbsp;&nbsp; Name</b></th>
      <th style="min-width: 100px" class="table-sortable:alphanumeric table-filterable" style="cursor:pointer;"><small>Position</small></th>
    </tr>
  </thead>
<?php }; ?>

<?php if (($_SESSION['owner'] != true) AND ($_SESSION['lease'] != true) AND ($_SESSION['realtor'] != true)){ ?>
  <tfoot>
    <tr style="background-color: #FAFEB8;">
      <th>
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
      <th>
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

<?php if (((($_SESSION['owner'] == true) OR ($_SESSION['lease'] == true) OR ($_SESSION['realtor'] == true)) AND ($_SESSION['ghost'] != 'Y')) OR ($_SESSION['webmaster'] == true)){ ?>

<!-- DATABASE RESULTS -->

<?php if ($_GET['choice'] == 'Board'){ ?>
<!-- DATABASE RESULTS - ALL BOARD EMAIL -->
<?php
	$grouping    = $_GET['choice'];
	$query  = "SELECT * FROM board WHERE grouping = '$grouping' AND person = 'Board of Directors'";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

?>
    <tr>
      <td>
          <?php if ($row['name'] !== ''){ ?>
            <?php if ($row['name'] !== 'none.gif'){ ?>
                <div class="module-image"><img src="../download-board.php?id=<?php echo "{$row['id']}"; ?>&conn=<?php echo $connName; ?>" alt="<?php echo "{$row['title']}"; ?>"></div>
            <?php }; ?>
        <?php }; ?>
          <?php if ($row['person'] !== ''){ ?><b><?php echo "{$row['person']}"; ?></b><br><?php }; ?>
          <?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>"><?php echo "{$row['email']}"; ?></a><br><?php }; ?>
          <?php if ($row['bio'] !== ''){ ?><br><?php echo "{$row['bio']}"; ?><br><?php }; ?>
<?php if ($row['docid'] !== ''){ ?>
	<?php
		$type    = $row['docid'];
		$queryDOC  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$resultDOC = mysqli_query($dbConn,$queryDOC);

		while($rowDOC = $resultDOC->fetch_array(MYSQLI_ASSOC))
		{
	?>
<br><a href="../download-documents.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>&conn=<?php echo $connName; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>'); ">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a>
	<?php
		}
	?>
<?php }; ?>
      </td>
      <td><?php if ($row['subposition'] !== ''){ ?><?php echo "{$row['subposition']}"; ?>&nbsp;<?php }; ?><?php echo "{$row['title']}"; ?><br><?php if ($row['thirdposition'] !== ''){ ?> <?php echo "{$row['thirdposition']}"; ?><?php }; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->

<!-- DATABASE RESULTS - PRESIDENT -->
<?php
	$grouping    = $_GET['choice'];
	$query  = "SELECT * FROM board WHERE grouping = '$grouping' AND title = 'President' ORDER by person";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

?>
    <tr>
      <td>
          <?php if ($row['name'] !== ''){ ?>
            <?php if ($row['name'] !== 'none.gif'){ ?>
                <div class="module-image"><img src="../download-board.php?id=<?php echo "{$row['id']}"; ?>&conn=<?php echo $connName; ?>" alt="<?php echo "{$row['title']}"; ?>"></div>
            <?php }; ?>
        <?php }; ?>
          <?php if ($row['person'] !== ''){ ?><b><?php echo "{$row['person']}"; ?></b><br><?php }; ?>
          <?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>"><?php echo "{$row['email']}"; ?></a><br><?php }; ?>
          <?php if ($row['bio'] !== ''){ ?><br><?php echo "{$row['bio']}"; ?><br><?php }; ?>
<?php if ($row['docid'] !== ''){ ?>
	<?php
		$type    = $row['docid'];
		$queryDOC  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$resultDOC = mysqli_query($dbConn,$queryDOC);

		while($rowDOC = $resultDOC->fetch_array(MYSQLI_ASSOC))
		{
	?>
<br><a href="../download-documents.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>&conn=<?php echo $connName; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>'); ">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a>
	<?php
		}
	?>
<?php }; ?>
      </td>
      <td><?php if ($row['subposition'] !== ''){ ?><?php echo "{$row['subposition']}"; ?>&nbsp;<?php }; ?><?php echo "{$row['title']}"; ?><br><?php if ($row['thirdposition'] !== ''){ ?> <?php echo "{$row['thirdposition']}"; ?><?php }; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
<!-- DATABASE RESULTS - VICE-PRESIDENT -->
<?php
	$grouping    = $_GET['choice'];
	$query  = "SELECT * FROM board WHERE grouping = '$grouping' AND title = 'Vice-President' ORDER by person";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

?>
    <tr>
      <td>
          <?php if ($row['name'] !== ''){ ?>
            <?php if ($row['name'] !== 'none.gif'){ ?>
                <div class="module-image"><img src="../download-board.php?id=<?php echo "{$row['id']}"; ?>&conn=<?php echo $connName; ?>" alt="<?php echo "{$row['title']}"; ?>"></div>
            <?php }; ?>
        <?php }; ?>
          <?php if ($row['person'] !== ''){ ?><b><?php echo "{$row['person']}"; ?></b><br><?php }; ?>
          <?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>"><?php echo "{$row['email']}"; ?></a><br><?php }; ?>
          <?php if ($row['bio'] !== ''){ ?><br><?php echo "{$row['bio']}"; ?><br><?php }; ?>
<?php if ($row['docid'] !== ''){ ?>
	<?php
		$type    = $row['docid'];
		$queryDOC  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$resultDOC = mysqli_query($dbConn,$queryDOC);

		while($rowDOC = $resultDOC->fetch_array(MYSQLI_ASSOC))
		{
	?>
<br><a href="../download-documents.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>&conn=<?php echo $connName; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>'); ">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a>
	<?php
		}
	?>
<?php }; ?>
      </td>
      <td><?php if ($row['subposition'] !== ''){ ?><?php echo "{$row['subposition']}"; ?>&nbsp;<?php }; ?><?php echo "{$row['title']}"; ?><br><?php if ($row['thirdposition'] !== ''){ ?> <?php echo "{$row['thirdposition']}"; ?><?php }; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
<!-- DATABASE RESULTS - SECRETARY -->
<?php
	$grouping    = $_GET['choice'];
	$query  = "SELECT * FROM board WHERE grouping = '$grouping' AND title = 'Secretary' ORDER by person";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

?>
    <tr>
      <td>
          <?php if ($row['name'] !== ''){ ?>
            <?php if ($row['name'] !== 'none.gif'){ ?>
                <div class="module-image"><img src="../download-board.php?id=<?php echo "{$row['id']}"; ?>&conn=<?php echo $connName; ?>" alt="<?php echo "{$row['title']}"; ?>"></div>
            <?php }; ?>
        <?php }; ?>
          <?php if ($row['person'] !== ''){ ?><b><?php echo "{$row['person']}"; ?></b><br><?php }; ?>
          <?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>"><?php echo "{$row['email']}"; ?></a><br><?php }; ?>
          <?php if ($row['bio'] !== ''){ ?><br><?php echo "{$row['bio']}"; ?><br><?php }; ?>
<?php if ($row['docid'] !== ''){ ?>
	<?php
		$type    = $row['docid'];
		$queryDOC  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$resultDOC = mysqli_query($dbConn,$queryDOC);

		while($rowDOC = $resultDOC->fetch_array(MYSQLI_ASSOC))
		{
	?>
<br><a href="../download-documents.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>&conn=<?php echo $connName; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>'); ">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a>
	<?php
		}
	?>
<?php }; ?>
      </td>
      <td><?php if ($row['subposition'] !== ''){ ?><?php echo "{$row['subposition']}"; ?>&nbsp;<?php }; ?><?php echo "{$row['title']}"; ?><br><?php if ($row['thirdposition'] !== ''){ ?> <?php echo "{$row['thirdposition']}"; ?><?php }; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
<!-- DATABASE RESULTS - TREASURER -->
<?php
	$grouping    = $_GET['choice'];
	$query  = "SELECT * FROM board WHERE grouping = '$grouping' AND title = 'Treasurer' ORDER by person";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

?>
    <tr>
      <td>
          <?php if ($row['name'] !== ''){ ?>
            <?php if ($row['name'] !== 'none.gif'){ ?>
                <div class="module-image"><img src="../download-board.php?id=<?php echo "{$row['id']}"; ?>&conn=<?php echo $connName; ?>" alt="<?php echo "{$row['title']}"; ?>"></div>
            <?php }; ?>
        <?php }; ?>
          <?php if ($row['person'] !== ''){ ?><b><?php echo "{$row['person']}"; ?></b><br><?php }; ?>
          <?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>"><?php echo "{$row['email']}"; ?></a><br><?php }; ?>
          <?php if ($row['bio'] !== ''){ ?><br><?php echo "{$row['bio']}"; ?><br><?php }; ?>
<?php if ($row['docid'] !== ''){ ?>
	<?php
		$type    = $row['docid'];
		$queryDOC  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$resultDOC = mysqli_query($dbConn,$queryDOC);

		while($rowDOC = $resultDOC->fetch_array(MYSQLI_ASSOC))
		{
	?>
<br><a href="../download-documents.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>&conn=<?php echo $connName; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>'); ">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a>
	<?php
		}
	?>
<?php }; ?>
      </td>
      <td><?php if ($row['subposition'] !== ''){ ?><?php echo "{$row['subposition']}"; ?>&nbsp;<?php }; ?><?php echo "{$row['title']}"; ?><br><?php if ($row['thirdposition'] !== ''){ ?> <?php echo "{$row['thirdposition']}"; ?><?php }; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
<!-- DATABASE RESULTS - BOARD MEMBER -->
<?php
	$grouping    = $_GET['choice'];
	$query  = "SELECT * FROM board WHERE grouping = '$grouping' AND title = 'Board Member' ORDER by person";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

?>
    <tr>
      <td>
          <?php if ($row['name'] !== ''){ ?>
            <?php if ($row['name'] !== 'none.gif'){ ?>
                <div class="module-image"><img src="../download-board.php?id=<?php echo "{$row['id']}"; ?>&conn=<?php echo $connName; ?>" alt="<?php echo "{$row['title']}"; ?>"></div>
            <?php }; ?>
        <?php }; ?>
          <?php if ($row['person'] !== ''){ ?><b><?php echo "{$row['person']}"; ?></b><br><?php }; ?>
          <?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>"><?php echo "{$row['email']}"; ?></a><br><?php }; ?>
          <?php if ($row['bio'] !== ''){ ?><br><?php echo "{$row['bio']}"; ?><br><?php }; ?>
<?php if ($row['docid'] !== ''){ ?>
	<?php
		$type    = $row['docid'];
		$queryDOC  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$resultDOC = mysqli_query($dbConn,$queryDOC);

		while($rowDOC = $resultDOC->fetch_array(MYSQLI_ASSOC))
		{
	?>
<br><a href="../download-documents.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>&conn=<?php echo $connName; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>'); ">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a>
	<?php
		}
	?>
<?php }; ?>
      </td>
      <td><?php if ($row['subposition'] !== ''){ ?><?php echo "{$row['subposition']}"; ?>&nbsp;<?php }; ?><?php echo "{$row['title']}"; ?><br><?php if ($row['thirdposition'] !== ''){ ?> <?php echo "{$row['thirdposition']}"; ?><?php }; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
<!-- DATABASE RESULTS - MEMBER -->
<?php
	$grouping    = $_GET['choice'];
	$query  = "SELECT * FROM board WHERE grouping = '$grouping' AND title = 'Member' ORDER by person";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

?>
    <tr>
      <td>
          <?php if ($row['name'] !== ''){ ?>
            <?php if ($row['name'] !== 'none.gif'){ ?>
                <div class="module-image"><img src="../download-board.php?id=<?php echo "{$row['id']}"; ?>&conn=<?php echo $connName; ?>" alt="<?php echo "{$row['title']}"; ?>"></div>
            <?php }; ?>
        <?php }; ?>
          <?php if ($row['person'] !== ''){ ?><b><?php echo "{$row['person']}"; ?></b><br><?php }; ?>
          <?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>"><?php echo "{$row['email']}"; ?></a><br><?php }; ?>
          <?php if ($row['bio'] !== ''){ ?><br><?php echo "{$row['bio']}"; ?><br><?php }; ?>
<?php if ($row['docid'] !== ''){ ?>
	<?php
		$type    = $row['docid'];
		$queryDOC  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$resultDOC = mysqli_query($dbConn,$queryDOC);

		while($rowDOC = $resultDOC->fetch_array(MYSQLI_ASSOC))
		{
	?>
<br><a href="../download-documents.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>&conn=<?php echo $connName; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>'); ">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a>
	<?php
		}
	?>
<?php }; ?>
      </td>
      <td><?php if ($row['subposition'] !== ''){ ?><?php echo "{$row['subposition']}"; ?>&nbsp;<?php }; ?><?php echo "{$row['title']}"; ?><br><?php if ($row['thirdposition'] !== ''){ ?> <?php echo "{$row['thirdposition']}"; ?><?php }; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
<!-- DATABASE RESULTS - MEMBER AT LARGE -->
<?php
	$grouping    = $_GET['choice'];
	$query  = "SELECT * FROM board WHERE grouping = '$grouping' AND title = 'Member at Large' ORDER by person";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

?>
    <tr>
      <td>
          <?php if ($row['name'] !== ''){ ?>
            <?php if ($row['name'] !== 'none.gif'){ ?>
                <div class="module-image"><img src="../download-board.php?id=<?php echo "{$row['id']}"; ?>&conn=<?php echo $connName; ?>" alt="<?php echo "{$row['title']}"; ?>"></div>
            <?php }; ?>
        <?php }; ?>
          <?php if ($row['person'] !== ''){ ?><b><?php echo "{$row['person']}"; ?></b><br><?php }; ?>
          <?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>"><?php echo "{$row['email']}"; ?></a><br><?php }; ?>
          <?php if ($row['bio'] !== ''){ ?><br><?php echo "{$row['bio']}"; ?><br><?php }; ?>
<?php if ($row['docid'] !== ''){ ?>
	<?php
		$type    = $row['docid'];
		$queryDOC  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$resultDOC = mysqli_query($dbConn,$queryDOC);

		while($rowDOC = $resultDOC->fetch_array(MYSQLI_ASSOC))
		{
	?>
<br><a href="../download-documents.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>&conn=<?php echo $connName; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>'); ">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a>
	<?php
		}
	?>
<?php }; ?>
      </td>
      <td><?php if ($row['subposition'] !== ''){ ?><?php echo "{$row['subposition']}"; ?>&nbsp;<?php }; ?><?php echo "{$row['title']}"; ?><br><?php if ($row['thirdposition'] !== ''){ ?> <?php echo "{$row['thirdposition']}"; ?><?php }; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
<!-- DATABASE RESULTS - COMMERCIAL -->
<?php
	$grouping    = $_GET['choice'];
	$query  = "SELECT * FROM board WHERE grouping = '$grouping' AND title = 'Commercial' ORDER by person";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

?>
    <tr>
      <td>
          <?php if ($row['name'] !== ''){ ?>
            <?php if ($row['name'] !== 'none.gif'){ ?>
                <div class="module-image"><img src="../download-board.php?id=<?php echo "{$row['id']}"; ?>&conn=<?php echo $connName; ?>" alt="<?php echo "{$row['title']}"; ?>"></div>
            <?php }; ?>
        <?php }; ?>
          <?php if ($row['person'] !== ''){ ?><b><?php echo "{$row['person']}"; ?></b><br><?php }; ?>
          <?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>"><?php echo "{$row['email']}"; ?></a><br><?php }; ?>
          <?php if ($row['bio'] !== ''){ ?><br><?php echo "{$row['bio']}"; ?><br><?php }; ?>
<?php if ($row['docid'] !== ''){ ?>
	<?php
		$type    = $row['docid'];
		$queryDOC  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$resultDOC = mysqli_query($dbConn,$queryDOC);

		while($rowDOC = $resultDOC->fetch_array(MYSQLI_ASSOC))
		{
	?>
<br><a href="../download-documents.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>&conn=<?php echo $connName; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>'); ">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a>
	<?php
		}
	?>
<?php }; ?>
      </td>
      <td><?php if ($row['subposition'] !== ''){ ?><?php echo "{$row['subposition']}"; ?>&nbsp;<?php }; ?><?php echo "{$row['title']}"; ?><br><?php if ($row['thirdposition'] !== ''){ ?> <?php echo "{$row['thirdposition']}"; ?><?php }; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
<!-- DATABASE RESULTS - DIRECTOR -->
<?php
	$grouping    = $_GET['choice'];
	$query  = "SELECT * FROM board WHERE grouping = '$grouping' AND title = 'Director' ORDER by person";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

?>
    <tr>
      <td>
          <?php if ($row['name'] !== ''){ ?>
            <?php if ($row['name'] !== 'none.gif'){ ?>
                <div class="module-image"><img src="../download-board.php?id=<?php echo "{$row['id']}"; ?>&conn=<?php echo $connName; ?>" alt="<?php echo "{$row['title']}"; ?>"></div>
            <?php }; ?>
        <?php }; ?>
          <?php if ($row['person'] !== ''){ ?><b><?php echo "{$row['person']}"; ?></b><br><?php }; ?>
          <?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>"><?php echo "{$row['email']}"; ?></a><br><?php }; ?>
          <?php if ($row['bio'] !== ''){ ?><br><?php echo "{$row['bio']}"; ?><br><?php }; ?>
<?php if ($row['docid'] !== ''){ ?>
	<?php
		$type    = $row['docid'];
		$queryDOC  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$resultDOC = mysqli_query($dbConn,$queryDOC);

		while($rowDOC = $resultDOC->fetch_array(MYSQLI_ASSOC))
		{
	?>
<br><a href="../download-documents.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>&conn=<?php echo $connName; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>'); ">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a>
	<?php
		}
	?>
<?php }; ?>
      </td>
      <td><?php if ($row['subposition'] !== ''){ ?><?php echo "{$row['subposition']}"; ?>&nbsp;<?php }; ?><?php echo "{$row['title']}"; ?><br><?php if ($row['thirdposition'] !== ''){ ?> <?php echo "{$row['thirdposition']}"; ?><?php }; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
<!-- DATABASE RESULTS - OFFICER -->
<?php
	$grouping    = $_GET['choice'];
	$query  = "SELECT * FROM board WHERE grouping = '$grouping' AND title = 'Officer' ORDER by person";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

?>
    <tr>
      <td>
          <?php if ($row['name'] !== ''){ ?>
            <?php if ($row['name'] !== 'none.gif'){ ?>
                <div class="module-image"><img src="../download-board.php?id=<?php echo "{$row['id']}"; ?>&conn=<?php echo $connName; ?>" alt="<?php echo "{$row['title']}"; ?>"></div>
            <?php }; ?>
        <?php }; ?>
          <?php if ($row['person'] !== ''){ ?><b><?php echo "{$row['person']}"; ?></b><br><?php }; ?>
          <?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>"><?php echo "{$row['email']}"; ?></a><br><?php }; ?>
          <?php if ($row['bio'] !== ''){ ?><br><?php echo "{$row['bio']}"; ?><br><?php }; ?>
<?php if ($row['docid'] !== ''){ ?>
	<?php
		$type    = $row['docid'];
		$queryDOC  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$resultDOC = mysqli_query($dbConn,$queryDOC);

		while($rowDOC = $resultDOC->fetch_array(MYSQLI_ASSOC))
		{
	?>
<br><a href="../download-documents.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>&conn=<?php echo $connName; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>'); ">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a>
	<?php
		}
	?>
<?php }; ?>
      </td>
      <td><?php if ($row['subposition'] !== ''){ ?><?php echo "{$row['subposition']}"; ?>&nbsp;<?php }; ?><?php echo "{$row['title']}"; ?><br><?php if ($row['thirdposition'] !== ''){ ?> <?php echo "{$row['thirdposition']}"; ?><?php }; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
<!-- DATABASE RESULTS - ALL OTHERS -->
<?php
	$grouping    = $_GET['choice'];
	$query  = "SELECT * FROM board WHERE grouping = '$grouping' AND title = '' ORDER by person";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

?>
    <tr>
      <td>
          <?php if ($row['name'] !== ''){ ?>
            <?php if ($row['name'] !== 'none.gif'){ ?>
                <div class="module-image"><img src="../download-board.php?id=<?php echo "{$row['id']}"; ?>&conn=<?php echo $connName; ?>" alt="<?php echo "{$row['title']}"; ?>"></div>
            <?php }; ?>
        <?php }; ?>
          <?php if ($row['person'] !== ''){ ?><b><?php echo "{$row['person']}"; ?></b><br><?php }; ?>
          <?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>"><?php echo "{$row['email']}"; ?></a><br><?php }; ?>
          <?php if ($row['bio'] !== ''){ ?><br><?php echo "{$row['bio']}"; ?><br><?php }; ?>
<?php if ($row['docid'] !== ''){ ?>
	<?php
		$type    = $row['docid'];
		$queryDOC  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$resultDOC = mysqli_query($dbConn,$queryDOC);

		while($rowDOC = $resultDOC->fetch_array(MYSQLI_ASSOC))
		{
	?>
<br><a href="../download-documents.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>&conn=<?php echo $connName; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>'); ">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a>
	<?php
		}
	?>
<?php }; ?>
      </td>
      <td><?php if ($row['subposition'] !== ''){ ?><?php echo "{$row['subposition']}"; ?>&nbsp;<?php }; ?><?php echo "{$row['title']}"; ?><br><?php if ($row['thirdposition'] !== ''){ ?> <?php echo "{$row['thirdposition']}"; ?><?php }; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
<?php }; ?>


<?php if ($_GET['choice'] == 'Committee'){ ?>
<!-- DATABASE RESULTS -->
<?php
	$grouping    = $_GET['choice'];
	$query  = "SELECT * FROM board WHERE grouping = '$grouping' ORDER by subposition, title, thirdposition, person";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

?>
    <tr>
      <td>
          <?php if ($row['name'] !== ''){ ?>
            <?php if ($row['name'] !== 'none.gif'){ ?>
                <div class="module-image"><img src="../download-board.php?id=<?php echo "{$row['id']}"; ?>&conn=<?php echo $connName; ?>" alt="<?php echo "{$row['title']}"; ?>"></div>
            <?php }; ?>
        <?php }; ?>
          <?php if ($row['person'] !== ''){ ?><b><?php echo "{$row['person']}"; ?></b><br><?php }; ?>
          <?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>"><?php echo "{$row['email']}"; ?></a><br><?php }; ?>
          <?php if ($row['bio'] !== ''){ ?><br><?php echo "{$row['bio']}"; ?><br><?php }; ?>
<?php if ($row['docid'] !== ''){ ?>
	<?php
		$type    = $row['docid'];
		$queryDOC  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$resultDOC = mysqli_query($dbConn,$queryDOC);

		while($rowDOC = $resultDOC->fetch_array(MYSQLI_ASSOC))
		{
	?>
<br><a href="../download-documents.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>&conn=<?php echo $connName; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>'); ">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a>
	<?php
		}
	?>
<?php }; ?>
      </td>
      <td><?php if ($row['subposition'] !== ''){ ?><?php echo "{$row['subposition']}"; ?>&nbsp;<?php }; ?><?php echo "{$row['title']}"; ?><br><?php if ($row['thirdposition'] !== ''){ ?> <?php echo "{$row['thirdposition']}"; ?><?php }; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
<?php }; ?>

<?php if ($_GET['choice'] == 'Staff'){ ?>
<!-- DATABASE RESULTS - MANAGER -->
<?php
	$grouping    = $_GET['choice'];
	$query  = "SELECT * FROM board WHERE grouping = '$grouping' AND title = 'Manager' ORDER by person";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

?>
    <tr>
      <td>
          <?php if ($row['name'] !== ''){ ?>
            <?php if ($row['name'] !== 'none.gif'){ ?>
                <div class="module-image"><img src="../download-board.php?id=<?php echo "{$row['id']}"; ?>&conn=<?php echo $connName; ?>" alt="<?php echo "{$row['title']}"; ?>"></div>
            <?php }; ?>
        <?php }; ?>
          <?php if ($row['person'] !== ''){ ?><b><?php echo "{$row['person']}"; ?></b><br><?php }; ?>
          <?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>"><?php echo "{$row['email']}"; ?></a><br><?php }; ?>
          <?php if ($row['bio'] !== ''){ ?><br><?php echo "{$row['bio']}"; ?><br><?php }; ?>
<?php if ($row['docid'] !== ''){ ?>
	<?php
		$type    = $row['docid'];
		$queryDOC  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$resultDOC = mysqli_query($dbConn,$queryDOC);

		while($rowDOC = $resultDOC->fetch_array(MYSQLI_ASSOC))
		{
	?>
<br><a href="../download-documents.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>&conn=<?php echo $connName; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>'); ">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a>
	<?php
		}
	?>
<?php }; ?>
      </td>
      <td><?php if ($row['subposition'] !== ''){ ?><?php echo "{$row['subposition']}"; ?>&nbsp;<?php }; ?><?php echo "{$row['title']}"; ?><br><?php if ($row['thirdposition'] !== ''){ ?> <?php echo "{$row['thirdposition']}"; ?><?php }; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
<!-- DATABASE RESULTS - HEAD CONCIERGE -->
<?php
	$grouping    = $_GET['choice'];
	$query  = "SELECT * FROM board WHERE grouping = '$grouping' AND title = 'Head Concierge' ORDER by person";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

?>
    <tr>
      <td>
          <?php if ($row['name'] !== ''){ ?>
            <?php if ($row['name'] !== 'none.gif'){ ?>
                <div class="module-image"><img src="../download-board.php?id=<?php echo "{$row['id']}"; ?>&conn=<?php echo $connName; ?>" alt="<?php echo "{$row['title']}"; ?>"></div>
            <?php }; ?>
        <?php }; ?>
          <?php if ($row['person'] !== ''){ ?><b><?php echo "{$row['person']}"; ?></b><br><?php }; ?>
          <?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>"><?php echo "{$row['email']}"; ?></a><br><?php }; ?>
          <?php if ($row['bio'] !== ''){ ?><br><?php echo "{$row['bio']}"; ?><br><?php }; ?>
<?php if ($row['docid'] !== ''){ ?>
	<?php
		$type    = $row['docid'];
		$queryDOC  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$resultDOC = mysqli_query($dbConn,$queryDOC);

		while($rowDOC = $resultDOC->fetch_array(MYSQLI_ASSOC))
		{
	?>
<br><a href="../download-documents.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>&conn=<?php echo $connName; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>'); ">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a>
	<?php
		}
	?>
<?php }; ?>
      </td>
      <td><?php if ($row['subposition'] !== ''){ ?><?php echo "{$row['subposition']}"; ?>&nbsp;<?php }; ?><?php echo "{$row['title']}"; ?><br><?php if ($row['thirdposition'] !== ''){ ?> <?php echo "{$row['thirdposition']}"; ?><?php }; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
<!-- DATABASE RESULTS - CONCIERGE -->
<?php
	$grouping    = $_GET['choice'];
	$query  = "SELECT * FROM board WHERE grouping = '$grouping' AND title = 'Concierge' ORDER by person";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

?>
    <tr>
      <td>
          <?php if ($row['name'] !== ''){ ?>
            <?php if ($row['name'] !== 'none.gif'){ ?>
                <div class="module-image"><img src="../download-board.php?id=<?php echo "{$row['id']}"; ?>&conn=<?php echo $connName; ?>" alt="<?php echo "{$row['title']}"; ?>"></div>
            <?php }; ?>
        <?php }; ?>
          <?php if ($row['person'] !== ''){ ?><b><?php echo "{$row['person']}"; ?></b><br><?php }; ?>
          <?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>"><?php echo "{$row['email']}"; ?></a><br><?php }; ?>
          <?php if ($row['bio'] !== ''){ ?><br><?php echo "{$row['bio']}"; ?><br><?php }; ?>
<?php if ($row['docid'] !== ''){ ?>
	<?php
		$type    = $row['docid'];
		$queryDOC  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$resultDOC = mysqli_query($dbConn,$queryDOC);

		while($rowDOC = $resultDOC->fetch_array(MYSQLI_ASSOC))
		{
	?>
<br><a href="../download-documents.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>&conn=<?php echo $connName; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>'); ">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a>
	<?php
		}
	?>
<?php }; ?>
      </td>
      <td><?php if ($row['subposition'] !== ''){ ?><?php echo "{$row['subposition']}"; ?>&nbsp;<?php }; ?><?php echo "{$row['title']}"; ?><br><?php if ($row['thirdposition'] !== ''){ ?> <?php echo "{$row['thirdposition']}"; ?><?php }; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
<!-- DATABASE RESULTS - FRONT DESK -->
<?php
	$grouping    = $_GET['choice'];
	$query  = "SELECT * FROM board WHERE grouping = '$grouping' AND title = 'Front Desk' ORDER by person";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

?>
    <tr>
      <td>
          <?php if ($row['name'] !== ''){ ?>
            <?php if ($row['name'] !== 'none.gif'){ ?>
                <div class="module-image"><img src="../download-board.php?id=<?php echo "{$row['id']}"; ?>&conn=<?php echo $connName; ?>" alt="<?php echo "{$row['title']}"; ?>"></div>
            <?php }; ?>
        <?php }; ?>
          <?php if ($row['person'] !== ''){ ?><b><?php echo "{$row['person']}"; ?></b><br><?php }; ?>
          <?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>"><?php echo "{$row['email']}"; ?></a><br><?php }; ?>
          <?php if ($row['bio'] !== ''){ ?><br><?php echo "{$row['bio']}"; ?><br><?php }; ?>
<?php if ($row['docid'] !== ''){ ?>
	<?php
		$type    = $row['docid'];
		$queryDOC  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$resultDOC = mysqli_query($dbConn,$queryDOC);

		while($rowDOC = $resultDOC->fetch_array(MYSQLI_ASSOC))
		{
	?>
<br><a href="../download-documents.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>&conn=<?php echo $connName; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>'); ">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a>
	<?php
		}
	?>
<?php }; ?>
      </td>
      <td><?php if ($row['subposition'] !== ''){ ?><?php echo "{$row['subposition']}"; ?>&nbsp;<?php }; ?><?php echo "{$row['title']}"; ?><br><?php if ($row['thirdposition'] !== ''){ ?> <?php echo "{$row['thirdposition']}"; ?><?php }; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
<!-- DATABASE RESULTS - MAINTENANCE -->
<?php
	$grouping    = $_GET['choice'];
	$query  = "SELECT * FROM board WHERE grouping = '$grouping' AND title = 'Maintenance' ORDER by person";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

?>
    <tr>
      <td>
          <?php if ($row['name'] !== ''){ ?>
            <?php if ($row['name'] !== 'none.gif'){ ?>
                <div class="module-image"><img src="../download-board.php?id=<?php echo "{$row['id']}"; ?>&conn=<?php echo $connName; ?>" alt="<?php echo "{$row['title']}"; ?>"></div>
            <?php }; ?>
        <?php }; ?>
          <?php if ($row['person'] !== ''){ ?><b><?php echo "{$row['person']}"; ?></b><br><?php }; ?>
          <?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>"><?php echo "{$row['email']}"; ?></a><br><?php }; ?>
          <?php if ($row['bio'] !== ''){ ?><br><?php echo "{$row['bio']}"; ?><br><?php }; ?>
<?php if ($row['docid'] !== ''){ ?>
	<?php
		$type    = $row['docid'];
		$queryDOC  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$resultDOC = mysqli_query($dbConn,$queryDOC);

		while($rowDOC = $resultDOC->fetch_array(MYSQLI_ASSOC))
		{
	?>
<br><a href="../download-documents.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>&conn=<?php echo $connName; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>'); ">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a>
	<?php
		}
	?>
<?php }; ?>
      </td>
      <td><?php if ($row['subposition'] !== ''){ ?><?php echo "{$row['subposition']}"; ?>&nbsp;<?php }; ?><?php echo "{$row['title']}"; ?><br><?php if ($row['thirdposition'] !== ''){ ?> <?php echo "{$row['thirdposition']}"; ?><?php }; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
<!-- DATABASE RESULTS - SECURITY -->
<?php
	$grouping    = $_GET['choice'];
	$query  = "SELECT * FROM board WHERE grouping = '$grouping' AND title = 'Security' ORDER by person";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

?>
    <tr>
      <td>
          <?php if ($row['name'] !== ''){ ?>
            <?php if ($row['name'] !== 'none.gif'){ ?>
                <div class="module-image"><img src="../download-board.php?id=<?php echo "{$row['id']}"; ?>&conn=<?php echo $connName; ?>" alt="<?php echo "{$row['title']}"; ?>"></div>
            <?php }; ?>
        <?php }; ?>
          <?php if ($row['person'] !== ''){ ?><b><?php echo "{$row['person']}"; ?></b><br><?php }; ?>
          <?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>"><?php echo "{$row['email']}"; ?></a><br><?php }; ?>
          <?php if ($row['bio'] !== ''){ ?><br><?php echo "{$row['bio']}"; ?><br><?php }; ?>
<?php if ($row['docid'] !== ''){ ?>
	<?php
		$type    = $row['docid'];
		$queryDOC  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$resultDOC = mysqli_query($dbConn,$queryDOC);

		while($rowDOC = $resultDOC->fetch_array(MYSQLI_ASSOC))
		{
	?>
<br><a href="../download-documents.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>&conn=<?php echo $connName; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>'); ">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a>
	<?php
		}
	?>
<?php }; ?>
      </td>
      <td><?php if ($row['subposition'] !== ''){ ?><?php echo "{$row['subposition']}"; ?>&nbsp;<?php }; ?><?php echo "{$row['title']}"; ?><br><?php if ($row['thirdposition'] !== ''){ ?> <?php echo "{$row['thirdposition']}"; ?><?php }; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
<!-- DATABASE RESULTS - PORTER -->
<?php
	$grouping    = $_GET['choice'];
	$query  = "SELECT * FROM board WHERE grouping = '$grouping' AND title = 'Porter' ORDER by person";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

?>
    <tr>
      <td>
          <?php if ($row['name'] !== ''){ ?>
            <?php if ($row['name'] !== 'none.gif'){ ?>
                <div class="module-image"><img src="../download-board.php?id=<?php echo "{$row['id']}"; ?>&conn=<?php echo $connName; ?>" alt="<?php echo "{$row['title']}"; ?>"></div>
            <?php }; ?>
        <?php }; ?>
          <?php if ($row['person'] !== ''){ ?><b><?php echo "{$row['person']}"; ?></b><br><?php }; ?>
          <?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>"><?php echo "{$row['email']}"; ?></a><br><?php }; ?>
          <?php if ($row['bio'] !== ''){ ?><br><?php echo "{$row['bio']}"; ?><br><?php }; ?>
<?php if ($row['docid'] !== ''){ ?>
	<?php
		$type    = $row['docid'];
		$queryDOC  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$resultDOC = mysqli_query($dbConn,$queryDOC);

		while($rowDOC = $resultDOC->fetch_array(MYSQLI_ASSOC))
		{
	?>
<br><a href="../download-documents.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>&conn=<?php echo $connName; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>'); ">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a>
	<?php
		}
	?>
<?php }; ?>
      </td>
      <td><?php if ($row['subposition'] !== ''){ ?><?php echo "{$row['subposition']}"; ?>&nbsp;<?php }; ?><?php echo "{$row['title']}"; ?><br><?php if ($row['thirdposition'] !== ''){ ?> <?php echo "{$row['thirdposition']}"; ?><?php }; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
<!-- DATABASE RESULTS - DOORMAN -->
<?php
	$grouping    = $_GET['choice'];
	$query  = "SELECT * FROM board WHERE grouping = '$grouping' AND title = 'Doorman' ORDER by person";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

?>
    <tr>
      <td>
          <?php if ($row['name'] !== ''){ ?>
            <?php if ($row['name'] !== 'none.gif'){ ?>
                <div class="module-image"><img src="../download-board.php?id=<?php echo "{$row['id']}"; ?>&conn=<?php echo $connName; ?>" alt="<?php echo "{$row['title']}"; ?>"></div>
            <?php }; ?>
        <?php }; ?>
          <?php if ($row['person'] !== ''){ ?><b><?php echo "{$row['person']}"; ?></b><br><?php }; ?>
          <?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>"><?php echo "{$row['email']}"; ?></a><br><?php }; ?>
          <?php if ($row['bio'] !== ''){ ?><br><?php echo "{$row['bio']}"; ?><br><?php }; ?>
<?php if ($row['docid'] !== ''){ ?>
	<?php
		$type    = $row['docid'];
		$queryDOC  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$resultDOC = mysqli_query($dbConn,$queryDOC);

		while($rowDOC = $resultDOC->fetch_array(MYSQLI_ASSOC))
		{
	?>
<br><a href="../download-documents.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>&conn=<?php echo $connName; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>'); ">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a>
	<?php
		}
	?>
<?php }; ?>
      </td>
      <td><?php if ($row['subposition'] !== ''){ ?><?php echo "{$row['subposition']}"; ?>&nbsp;<?php }; ?><?php echo "{$row['title']}"; ?><br><?php if ($row['thirdposition'] !== ''){ ?> <?php echo "{$row['thirdposition']}"; ?><?php }; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
<!-- DATABASE RESULTS - ALL OTHERS -->
<?php
	$grouping    = $_GET['choice'];
	$query  = "SELECT * FROM board WHERE grouping = '$grouping' AND title = '' ORDER by person";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

?>
    <tr>
      <td>
          <?php if ($row['name'] !== ''){ ?>
            <?php if ($row['name'] !== 'none.gif'){ ?>
                <div class="module-image"><img src="../download-board.php?id=<?php echo "{$row['id']}"; ?>&conn=<?php echo $connName; ?>" alt="<?php echo "{$row['title']}"; ?>"></div>
            <?php }; ?>
        <?php }; ?>
          <?php if ($row['person'] !== ''){ ?><b><?php echo "{$row['person']}"; ?></b><br><?php }; ?>
          <?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>?subject=<?php include('../my-documents/communityname.html'); ?>"><?php echo "{$row['email']}"; ?></a><br><?php }; ?>
          <?php if ($row['bio'] !== ''){ ?><br><?php echo "{$row['bio']}"; ?><br><?php }; ?>
<?php if ($row['docid'] !== ''){ ?>
	<?php
		$type    = $row['docid'];
		$queryDOC  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$resultDOC = mysqli_query($dbConn,$queryDOC);

		while($rowDOC = $resultDOC->fetch_array(MYSQLI_ASSOC))
		{
	?>
<br><a href="../download-documents.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>&conn=<?php echo $connName; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>'); ">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a>
	<?php
		}
	?>
<?php }; ?>
      </td>
      <td><?php if ($row['subposition'] !== ''){ ?><?php echo "{$row['subposition']}"; ?>&nbsp;<?php }; ?><?php echo "{$row['title']}"; ?><br><?php if ($row['thirdposition'] !== ''){ ?> <?php echo "{$row['thirdposition']}"; ?><?php }; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
<?php }; ?>

<!-- END DATABASE RESULTS -->

<?php }; ?>

  </tbody>
</table>
<!-- CONTENT -->

</body>

	<script src="../java/vendor/what-input.js"></script>
	<script src="../java/vendor/foundation.min.js"></script>
	<script type="text/javascript" src="../java/google-base.js"></script>
	<script type="text/javascript" src="../my-documents/google-code.js"></script>

</html>