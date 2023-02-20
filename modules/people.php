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
	$query  = "SELECT title FROM tabs WHERE `int1` = '200'";
	$result = mysqli_query($dbConn, $query);
    $row = $result->fetch_array(MYSQLI_ASSOC);

    if (!empty($row) && !empty($row['title']))
	{
        echo "{$row['title']}";
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
    <tr style="background-color: #FAFEB8;">
      <th colspan="3">
People on this view appear in alphabetical order.
      </th>
    </tr>
    <tr>
      <th class="table-sortable:alphanumeric" style="cursor:pointer;"><b>&nbsp;&nbsp;&nbsp; Name</b></th>
      <th style="min-width: 100px" class="table-sortable:alphanumeric table-filterable" style="cursor:pointer;"><small>Position</small></th>
      <th style="min-width: 100px" class="table-sortable:alphanumeric table-filterable" style="cursor:pointer;"><small>Board/Staff</small></th>
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

<!-- DATABASE RESULTS -->
<?php if (((($_SESSION['owner'] == true) OR ($_SESSION['lease'] == true) OR ($_SESSION['realtor'] == true)) AND ($_SESSION['ghost'] != 'Y')) OR ($_SESSION['webmaster'] == true)){ ?>
<?php
	$query  = "SELECT * FROM board ORDER BY person";
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
        <?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>?subject=<?php include('../my-documents/communityname.html'); ?>"><?php echo "{$row['email']}"; ?></a><br><?php }; ?>
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
      <td><?php echo "{$row['grouping']}"; ?></td>
    </tr>
<?php
	}
?>
<?php }; ?>
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