<?php
require_once('../my-documents/php7-my-db.php');
$connName = isset($_GET['conn']) ? $_GET['conn'] : "none";

if (isset($connectionPool) && isset($connectionPool[$connName])) {
    $dbConn = $connectionPool[$connName]['connection'];
} else {
    $dbConn = $conn;

}

$owner = false;
$lease = false;

$query = "SELECT `owner`, `lease` FROM `tabs` WHERE `int1`='225'";	
$result = mysqli_query($dbConn,$query) or die('Error, select query failed');
while($row = $result->fetch_array(MYSQLI_ASSOC)){
	$owner = $row['owner'];
	$lease = $row['lease'];
}
$access_granted = true;
if($owner || $lease){
	$access_granted = false;
}
if($owner && $_SESSION['owner']){
	$access_granted = true;
}
if($lease && $_SESSION['lease']){
	$access_granted = true;
}
if(!$access_granted){
	header("Location: ../403.shtml"); exit;
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
<?php if ($_SESSION["board"] == true) { ?>
<div id="all-documents-folder" class="stand-alone-page">
  <div class="popup-header">
  <h4>
<?php
	$query  = "SELECT title FROM tabs WHERE `int1` = '101'";
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

<!-- Table -->

<!-- Sort and Filter Head -->
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>

<!-- Administrator Permission Note -->
<?php if ($_SESSION["liaison"] == true) { ?>
    <tr style="background-color: #FAFEB8;">
      <th colspan="3"><p>Preview of this folder with Owner permissions.</p></th>
    </tr>
<?php } ?>

    <tr>
      <th class="table-sortable:alphanumeric" style="cursor:pointer;">&nbsp;&nbsp;&nbsp; Document Title</th>
      <th class="table-sortable:alphanumeric table-filterable" style="cursor:pointer;"><small>Folder</small></th>
      <th class="table-sortable:date table-filterable" style="cursor:pointer;"><small>Year</small></th>
    </tr>
  </thead>
  <tbody>

<!-- DATABASE RESULTS DOCUMENTS -->
<?php
	$doctype    = $_GET['choice'];
	$query  = "SELECT `id`, `docdate`, `size`, `title`, `type`, `doctype` FROM documents WHERE board = 'Y' AND type NOT LIKE '%image%' AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY title";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
	    <tr>
	      <td align="left"><?php include('../icon-links.php'); ?>&nbsp;&nbsp;&nbsp;<a href="../download-documents.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$row['id']}"; ?>'); "><?php echo "{$row['title']}"; ?></a></span></td>
	      <td align="left"><?php echo "{$row['doctype']}"; ?></td>
	      <td align="left"><?php echo date('Y', strtotime($row['docdate'])); ?></td>
	    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS DOCUMENTS -->

  </tbody>
</table>


<!-- PHOTOS -->
<?php
	$doctype    = $_GET['choice'];
	$query  = "SELECT * FROM documents WHERE board = 'Y' AND type LIKE '%image%' AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY title";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
	      <div class="gallery-image-1">
<a class="image-popup-no-margins" href="../download-documents.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>" alt="<?php echo "{$row['title']}"; ?>" title="<?php echo "{$row['title']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$row['id']}"; ?>'); ">

<img src="../download-documents.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>" alt="<?php echo "{$row['title']}"; ?>" title="<?php echo "{$row['title']}"; ?>" width="100%">

</a>

<div class="row">

<div class="small-10 large-10 columns">
<div align="left" class="gallery-title"><p><?php echo "{$row['title']}"; ?></p></div>
</div>

<div class="small-2 large-2 columns">
  <div align="right" class="gallery-download"><p><a href="../download-documents.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$row['id']}"; ?>'); "><i class="fa fa-download" aria-hidden="true" title="Download"></i></a></p></div>
</div>

</div>

	      </div>

<?php }; ?>
<!-- END PHOTOS -->
 
</div>

<?php }; ?>
</body>
  
	<script src="../java/vendor/what-input.js"></script>
	<script src="../java/vendor/foundation.min.js"></script>
	<script type="text/javascript" src="../java/google-base.js"></script>
	<script type="text/javascript" src="../my-documents/google-code.js"></script>

</html>