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
      <h4><?php $choice    = $_GET['choice']; { ?><?php echo "{$choice}"; ?><?php	} ?></h4>
      <?php if (isset($connectionPool) && isset($connectionPool[$connName])) { ?>
        <p>This content is from <?php echo "{$connName}"; ?></p>
      <?php	} ?>
  </div>

<!-- Mobile Filter Notice -->
  <div class="stand-alone-page-content">
    <div class="rotate-note">Rotate your mobile device to view folder and date columns, and for sorting and filtering tools.</div>
  </div>

<!-- LIAISON PREVIEW NOTE -->
<?php if ($_SESSION["liaison"] == true) { ?>
      <?php if (isset($connectionPool) && isset($connectionPool[$connName])) { ?>
        <br>
      <?php	} ?>
<table width="100%" align="center" border="0" cellpadding="30" cellspacing="0" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr style="background-color: #FAFEB8;">
      <th colspan="2"><p><i class="fa fa-exclamation-triangle" aria-hidden="true" title="Action!"></i> You are viewing this folder as an Administrator.  Scroll down to preview this folder from the perspective of all applicable permission groups.</p></th>
    </tr>
  </thead>
</table>
<br>
<?php }; ?>
<!-- LIAISON PREVIEW NOTE -->

<!-- *** OWNER *** -->
<?php if ($_SESSION["owner"] == true) { ?>

<!-- Table -->

<!-- Documents and Links Inner Join -->
<?php
	$choice    = $_GET['choice'];
	$query  = "SELECT `id` FROM documents INNER JOIN tabs INNER JOIN folders WHERE (documents.doctype = '$choice' AND documents.owner = 'Y' AND type NOT LIKE '%image%' AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE()) OR (tabs.tabname = '$choice' AND tabs.owner = 'Y') OR (folders.tabname = '$choice' AND folders.owner = 'Y') LIMIT 1";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>


<!-- Sort and Filter Head -->
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>

<!-- Administrator Permission Note -->
<?php if ($_SESSION["liaison"] == true) { ?>
    <tr style="background-color: #FAFEB8;">
      <th colspan="2"><p>Preview of this folder with Owner permissions.</p></th>
    </tr>
<?php } ?>

    <tr>
      <th class="table-sortable:alphanumeric" style="cursor:pointer;">&nbsp;&nbsp;&nbsp; Document Title</th>
      <th class="table-sortable:date table-filterable" style="cursor:pointer;"><small>Year</small></th>
    </tr>
  </thead>
  <tbody>

<!-- DATABASE RESULTS DOCUMENTS -->
<?php
	$doctype    = $_GET['choice'];
	$query  = "SELECT `id`, `docdate`, `size`, `title`, `type` FROM documents WHERE doctype = '$doctype' AND owner = 'Y' AND type NOT LIKE '%image%' AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY title DESC";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
	    <tr>
	      <td align="left"><?php include('../icon-links.php'); ?>&nbsp;&nbsp;&nbsp;<a href="../download-documents.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>&conn=<?php echo"{$connName}";?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$row['id']}"; ?>'); "><?php echo "{$row['title']}"; ?></a></span></td>
	      <td align="left"><?php echo date('Y', strtotime($row['docdate'])); ?></td>
	    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS DOCUMENTS -->

<!-- DATABASE RESULTS LINKS -->
<?php
	$tabname    = $_GET['choice'];
	$query  = "SELECT `int1`, `url`, `image`, `title`, `rednote`, `window`, `image` FROM tabs WHERE tabname = '$doctype' AND owner = 'Y' ORDER BY title DESC";
	$result = mysqli_query($dbConn,$query) or die('Error, query failed');

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
        $argurements = strpos($row['url'], '?');
        if ($argurements === false) {
            $url = str_replace(".php", ".php?conn=".$connName, $row['url'] );
        } else {
            $url = str_replace('?', '?conn='.$connName.'&' , $row['url']);
        }
?>
	    <tr>
	      <td align="left"><a href="<?php echo "{$url}"; ?>" <?php if ($row['window'] !== '') { ?><?php echo "{$row['window']}"; ?><?php }; ?> class="<?php if ($row['window'] == '') { ?>iframe-link<?php }; ?>" onclick="javascript:pageTracker._trackPageview('ColumnLink/<?php echo "{$row['title']}"; ?>'); "><?php echo "{$row['image']}"; ?></a>&nbsp
              <a href="<?php echo "{$url}"; ?>" <?php if ($row['window'] !== '') { ?><?php echo "{$row['window']}"; ?><?php }; ?> class="nav-section-link <?php if ($row['rednote'] !== ''){ ?>nav-section-subtext-anchor<?php }; ?> <?php if ($row['window'] == '') { ?>iframe-link<?php }; ?>" onclick="javascript:pageTracker._trackPageview('ColumnLink/<?php echo "{$row['title']}"; ?>'); "><?php echo "{$row['title']}"; ?></a><?php if ($row['rednote'] !== '') { ?><div class="nav-section-subtext"><p>&nbsp;&nbsp;<?php echo "{$row['rednote']}"; ?></p></div><?php }; ?></td>
	      <td></td>
	    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS LINKS -->

<!-- DATABASE RESULTS FOLDERS -->
<?php
	$foldername    = $_GET['choice'];
	$query  = "SELECT `int1`, `tabname`, `title`, `rednote`, `link`, `options`, `image` FROM folders WHERE tabname = '$foldername' AND owner = 'Y' ORDER BY title DESC";
	$result = mysqli_query($dbConn,$query) or die('Error, query failed');

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
        $argurements = strpos($row['link'], '?');
        if ($argurements === false) {
            $link = str_replace(".php", ".php?conn=".$connName, $row['link'] );
        } else {
            $link = str_replace('?', '?conn='.$connName.'&' , $row['link']);
        }
?>
	    <tr>
	      <td align="left"><a href="<?php echo "{$link}"; ?><?php echo "{$row['title']}"; ?>" class="iframe-link" onclick="javascript:pageTracker._trackPageview('FOLDER/<?php echo "{$row['title']}"; ?>'); "><?php echo "{$row['image']}"; ?></a>&nbsp;&nbsp;
              <a href="<?php echo "{$link}"; ?><?php echo "{$row['title']}"; ?>" class="nav-section-link <?php if ($row['rednote'] !== '') { ?>nav-section-subtext-anchor<?php }; ?> iframe-link" onclick="javascript:pageTracker._trackPageview('FOLDER/<?php echo "{$row['title']}"; ?>'); "><b><?php echo "{$row['title']}"; ?></b></a><?php if ($row['rednote'] !== '') { ?><div class="nav-section-subtext"><p>&nbsp;&nbsp;<?php echo "{$row['rednote']}"; ?></p></div><?php }; ?></td>
	      <td></td>
	    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS FOLDERS -->

  </tbody>
</table>
<?php }; ?>

<!-- PHOTOS -->
<?php if ($_SESSION["liaison"] == true) { ?>
<?php
	$doctype    = $_GET['choice'];
	$query  = "SELECT `id` FROM documents WHERE doctype = '$doctype' AND owner = 'Y' AND type LIKE '%image%' AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY title DESC LIMIT 1";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr style="background-color: #FAFEB8;">
      <th colspan="2"><p>Preview of this gallery with Owner permissions.</p></th>
    </tr>
  </thead>
</table>
<?php } ?>
<?php }; ?>

<?php
	$doctype    = $_GET['choice'];
	$query  = "SELECT * FROM documents WHERE doctype = '$doctype' AND owner = 'Y' AND type LIKE '%image%' AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY title DESC";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
	      <div class="gallery-image-1">
<a class="image-popup-no-margins" href="../download-documents.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>&conn=<?php echo"{$connName}";?>" alt="<?php echo "{$row['title']}"; ?>" title="<?php echo "{$row['title']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$row['id']}"; ?>'); ">

<img src="../download-documents.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>&conn=<?php echo"{$connName}";?>" alt="<?php echo "{$row['title']}"; ?>" title="<?php echo "{$row['title']}"; ?>" width="100%">

</a>

<div class="row">

<div class="small-10 large-10 columns">
<div align="left" class="gallery-title"><p><?php echo "{$row['title']}"; ?></p></div>
</div>

<div class="small-2 large-2 columns">
  <div align="right" class="gallery-download"><p><a href="../download-documents.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>&conn=<?php echo"{$connName}";?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$row['id']}"; ?>'); "><i class="fa fa-download" aria-hidden="true" title="Download"></i></a></p></div>
</div>

</div>

	      </div>

<?php }; ?>
<!-- END PHOTOS -->

<?php }; ?>
<!-- *** OWNER *** -->


<!-- *** LEASE *** -->
<?php if ($_SESSION["lease"] == true) { ?>

<!-- Table -->

<!-- Documents and Links Inner Join -->
<?php
	$choice    = $_GET['choice'];
	$query  = "SELECT `id` FROM documents INNER JOIN tabs INNER JOIN folders WHERE (documents.doctype = '$choice' AND documents.lease = 'Y' AND type NOT LIKE '%image%' AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE()) OR (tabs.tabname = '$choice' AND tabs.lease = 'Y') OR (folders.tabname = '$choice' AND folders.lease = 'Y') LIMIT 1";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>


<!-- Sort and Filter Head -->
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>

<!-- Administrator Permission Note -->
<?php if ($_SESSION["liaison"] == true) { ?>
    <tr style="background-color: #FAFEB8;">
      <th colspan="2"><p>Preview of this folder with Leaser/Renter permissions.</p></th>
    </tr>
<?php } ?>

    <tr>
      <th class="table-sortable:alphanumeric" style="cursor:pointer;">&nbsp;&nbsp;&nbsp; Document Title</th>
      <th class="table-sortable:date table-filterable" style="cursor:pointer;">&nbsp;&nbsp;&nbsp; <small>Year</small></th>
    </tr>
  </thead>
  <tbody>

<!-- DATABASE RESULTS DOCUMENTS -->
<?php
	$doctype    = $_GET['choice'];
	$query  = "SELECT `id`, `docdate`, `size`, `title`, `type` FROM documents WHERE doctype = '$doctype' AND lease = 'Y' AND type NOT LIKE '%image%' AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY title DESC";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
	    <tr>
	      <td align="left"><?php include('../icon-links.php'); ?>&nbsp;&nbsp;&nbsp;<a href="../download-documents.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>&conn=<?php echo"{$connName}";?>" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$row['id']}"; ?>'); "><?php echo "{$row['title']}"; ?></a></span></td>
	      <td align="left"><?php echo date('Y', strtotime($row['docdate'])); ?></td>
	    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS DOCUMENTS -->

<!-- DATABASE RESULTS LINKS -->
<?php
	$tabname    = $_GET['choice'];
	$query  = "SELECT `int1`, `url`, `image`, `title`, `rednote`, `window`, `image` FROM tabs WHERE tabname = '$doctype' AND lease = 'Y' ORDER BY title DESC";
	$result = mysqli_query($dbConn,$query) or die('Error, query failed');

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
        $argurements = strpos($row['url'], '?');
        if ($argurements === false) {
            $url = str_replace(".php", ".php?conn=".$connName, $row['url'] );
        } else {
            $url = str_replace('?', '?conn='.$connName.'&' , $row['url']);
        }
?>
	    <tr>
	      <td align="left">
              <a href="<?php echo "{$url}"; ?>" <?php if ($row['window'] !== '') { ?><?php echo "{$row['window']}"; ?><?php }; ?> class="<?php if ($row['window'] == '') { ?>iframe-link<?php }; ?>" onclick="javascript:pageTracker._trackPageview('ColumnLink/<?php echo "{$row['title']}"; ?>'); "><?php echo "{$row['image']}"; ?></a>&nbsp;&nbsp;
              <a href="<?php echo "{$url}"; ?>" <?php if ($row['window'] !== '') { ?><?php echo "{$row['window']}"; ?><?php }; ?> class="nav-section-link <?php if ($row['rednote'] !== ''){ ?>nav-section-subtext-anchor<?php }; ?> <?php if ($row['window'] == '') { ?>iframe-link<?php }; ?>" onclick="javascript:pageTracker._trackPageview('ColumnLink/<?php echo "{$row['title']}"; ?>'); "><?php echo "{$row['title']}"; ?></a><?php if ($row['rednote'] !== '') { ?><div class="nav-section-subtext"><p>&nbsp;&nbsp;<?php echo "{$row['rednote']}"; ?></p></div><?php }; ?></td>
	      <td></td>
	    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS LINKS -->

<!-- DATABASE RESULTS FOLDERS -->
<?php
	$foldername    = $_GET['choice'];
	$query  = "SELECT `int1`, `tabname`, `title`, `rednote`, `link`, `options`, `image` FROM folders WHERE tabname = '$foldername' AND lease = 'Y' ORDER BY title DESC";
	$result = mysqli_query($dbConn,$query) or die('Error, query failed');

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
        $argurements = strpos($row['link'], '?');
        if ($argurements === false) {
            $link = str_replace(".php", ".php?conn=".$connName, $row['link'] );
        } else {
            $link = str_replace('?', '?conn='.$connName.'&' , $row['link']);
        }

?>
	    <tr>
	      <td align="left"><a href="<?php echo "{$link}"; ?><?php echo "{$row['title']}"; ?>" class="iframe-link" onclick="javascript:pageTracker._trackPageview('FOLDER/<?php echo "{$row['title']}"; ?>'); "><?php echo "{$row['image']}"; ?></a>&nbsp;&nbsp;
              <a href="<?php echo "{$link}"; ?><?php echo "{$row['title']}"; ?>" class="nav-section-link <?php if ($row['rednote'] !== '') { ?>nav-section-subtext-anchor<?php }; ?> iframe-link" onclick="javascript:pageTracker._trackPageview('FOLDER/<?php echo "{$row['title']}"; ?>'); "><b><?php echo "{$row['title']}"; ?></b></a><?php if ($row['rednote'] !== '') { ?><div class="nav-section-subtext"><p>&nbsp;&nbsp;<?php echo "{$row['rednote']}"; ?></p></div><?php }; ?></td>
	      <td></td>
	    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS FOLDERS -->

  </tbody>
</table>
<?php }; ?>

<!-- PHOTOS -->
<?php if ($_SESSION["liaison"] == true) { ?>
<?php
	$doctype    = $_GET['choice'];
	$query  = "SELECT `id` FROM documents WHERE doctype = '$doctype' AND lease = 'Y' AND type LIKE '%image%' AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY title DESC LIMIT 1";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr style="background-color: #FAFEB8;">
      <th colspan="2"><p>Preview of this gallery with Leaser/Renter permissions.</p></th>
    </tr>
  </thead>
</table>
<?php } ?>
<?php }; ?>

<?php
	$doctype    = $_GET['choice'];
	$query  = "SELECT * FROM documents WHERE doctype = '$doctype' AND lease = 'Y' AND type LIKE '%image%' AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY title DESC";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
	      <div class="gallery-image-1">
<img src="../download-documents.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>&conn=<?php echo"{$connName}";?>" alt="<?php echo "{$row['title']}"; ?>" title="<?php echo "{$row['title']}"; ?>" width="100%" align="center" border="0">

<div class="row">

<div class="small-9 large-9 columns">
<div align="left" class="gallery-title"><p><?php echo "{$row['title']}"; ?></p></div>
</div>

<div class="small-3 large-3 columns">
  <div align="right" class="gallery-download"><p><a href="../download-documents.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>&conn=<?php echo"{$connName}";?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$row['id']}"; ?>'); "><i class="fa fa-download" aria-hidden="true"></i> Download</a></p></div>
</div>

</div>

	      </div>
<?php }; ?>
<!-- END PHOTOS -->

<?php }; ?>
<!-- *** LEASE *** -->


<!-- *** REALTOR *** -->
<?php if ($_SESSION["realtor"] == true) { ?>

<!-- Table -->

<!-- Documents and Links Inner Join -->
<?php
	$choice    = $_GET['choice'];
	$query  = "SELECT `id` FROM documents INNER JOIN tabs INNER JOIN folders WHERE (documents.doctype = '$choice' AND documents.realtor = 'Y' AND type NOT LIKE '%image%' AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ) OR (tabs.tabname = '$choice' AND tabs.realtor = 'Y') OR (folders.tabname = '$choice' AND folders.realtor = 'Y') LIMIT 1";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>


<!-- Sort and Filter Head -->
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>

<!-- Administrator Permission Note -->
<?php if ($_SESSION["liaison"] == true) { ?>
    <tr style="background-color: #FAFEB8;">
      <th colspan="2"><p>Preview of this folder with Realtor permissions.</p></th>
    </tr>
<?php } ?>

    <tr>
      <th class="table-sortable:alphanumeric" style="cursor:pointer;">&nbsp;&nbsp;&nbsp; Document Title</th>
      <th class="table-sortable:date table-filterable" style="cursor:pointer;">&nbsp;&nbsp;&nbsp; <small>Year</small></th>
    </tr>
  </thead>
  <tbody>

<!-- DATABASE RESULTS DOCUMENTS -->
<?php
	$doctype    = $_GET['choice'];
	$query  = "SELECT `id`, `docdate`, `size`, `title`, `type` FROM documents WHERE doctype = '$doctype' AND realtor = 'Y' AND type NOT LIKE '%image%' AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY title DESC";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
	    <tr>
	      <td align="left"><?php include('../icon-links.php'); ?>&nbsp;&nbsp;&nbsp;<a href="../download-documents.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>&conn=<?php echo"{$connName}";?>" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$row['id']}"; ?>'); "><?php echo "{$row['title']}"; ?></a></span></td>
	      <td align="left"><?php echo date('Y', strtotime($row['docdate'])); ?></td>
	    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS DOCUMENTS -->

<!-- DATABASE RESULTS LINKS -->
<?php
	$tabname    = $_GET['choice'];
	$query  = "SELECT `int1`, `url`, `image`, `title`, `rednote`, `window`, `image` FROM tabs WHERE tabname = '$doctype' AND realtor = 'Y' ORDER BY title DESC";
	$result = mysqli_query($dbConn,$query) or die('Error, query failed');

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
        $argurements = strpos($row['url'], '?');
        if ($argurements === false) {
            $url = str_replace(".php", ".php?conn=".$connName, $row['url'] );
        } else {
            $url = str_replace('?', '?conn='.$connName.'&' , $row['url']);
        }
?>
	    <tr>
	      <td align="left">
              <a href="<?php echo "{$url}"; ?>" <?php if ($row['window'] !== '') { ?><?php echo "{$row['window']}"; ?><?php }; ?> class="<?php if ($row['window'] == '') { ?>iframe-link<?php }; ?>" onclick="javascript:pageTracker._trackPageview('ColumnLink/<?php echo "{$row['title']}"; ?>'); "><?php echo "{$row['image']}"; ?></a>&nbsp;&nbsp;
              <a href="<?php echo "{$url}"; ?>" <?php if ($row['window'] !== '') { ?><?php echo "{$row['window']}"; ?><?php }; ?> class="nav-section-link <?php if ($row['rednote'] !== ''){ ?>nav-section-subtext-anchor<?php }; ?> <?php if ($row['window'] == '') { ?>iframe-link<?php }; ?>" onclick="javascript:pageTracker._trackPageview('ColumnLink/<?php echo "{$row['title']}"; ?>'); "><?php echo "{$row['title']}"; ?></a><?php if ($row['rednote'] !== '') { ?><div class="nav-section-subtext"><p>&nbsp;&nbsp;<?php echo "{$row['rednote']}"; ?></p></div><?php }; ?></td>
	      <td></td>
	    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS LINKS -->

<!-- DATABASE RESULTS FOLDERS -->
<?php
	$foldername    = $_GET['choice'];
	$query  = "SELECT `int1`, `tabname`, `title`, `rednote`, `link`, `options`, `image` FROM folders WHERE tabname = '$foldername' AND realtor = 'Y' ORDER BY title DESC";
	$result = mysqli_query($dbConn,$query) or die('Error, query failed');

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

        $argurements = strpos($row['link'], '?');
        if ($argurements === false) {
            $link = str_replace(".php", ".php?conn=".$connName, $row['link'] );
        } else {
            $link = str_replace('?', '?conn='.$connName.'&' , $row['link']);
        }
?>
	    <tr>
	      <td align="left"><a href="<?php echo "{$link}"; ?><?php echo "{$row['title']}"; ?>" class="iframe-link" onclick="javascript:pageTracker._trackPageview('FOLDER/<?php echo "{$row['title']}"; ?>'); "><?php echo "{$row['image']}"; ?></a>&nbsp;&nbsp;
              <a href="<?php echo "{$link}"; ?><?php echo "{$row['title']}"; ?>" class="nav-section-link <?php if ($row['rednote'] !== '') { ?>nav-section-subtext-anchor<?php }; ?> iframe-link" onclick="javascript:pageTracker._trackPageview('FOLDER/<?php echo "{$row['title']}"; ?>'); "><b><?php echo "{$row['title']}"; ?></b></a><?php if ($row['rednote'] !== '') { ?><div class="nav-section-subtext"><p>&nbsp;&nbsp;<?php echo "{$row['rednote']}"; ?></p></div><?php }; ?></td>
	      <td></td>
	    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS FOLDERS -->

  </tbody>
</table>
<?php }; ?>

<!-- PHOTOS -->
<?php if ($_SESSION["liaison"] == true) { ?>
<?php
	$doctype    = $_GET['choice'];
	$query  = "SELECT `id` FROM documents WHERE doctype = '$doctype' AND realtor = 'Y' AND type LIKE '%image%' AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY title DESC LIMIT 1";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr style="background-color: #FAFEB8;">
      <th colspan="2"><p>Preview of this gallery with Realtor permissions.</p></th>
    </tr>
  </thead>
</table>
<?php } ?>
<?php }; ?>

<?php
	$doctype    = $_GET['choice'];
	$query  = "SELECT * FROM documents WHERE doctype = '$doctype' AND realtor = 'Y' AND type LIKE '%image%' AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY title DESC";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
	      <div class="gallery-image-1">
<img src="../download-documents.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>&conn=<?php echo"{$connName}";?>" alt="<?php echo "{$row['title']}"; ?>" title="<?php echo "{$row['title']}"; ?>" width="100%" align="center" border="0">

<div class="row">

<div class="small-9 large-9 columns">
<div align="left" class="gallery-title"><p><?php echo "{$row['title']}"; ?></p></div>
</div>

<div class="small-3 large-3 columns">
  <div align="right" class="gallery-download"><p><a href="../download-documents.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>&conn=<?php echo"{$connName}";?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$row['id']}"; ?>'); "><i class="fa fa-download" aria-hidden="true"></i> Download</a></p></div>
</div>

</div>

	      </div>
<?php }; ?>
<!-- END PHOTOS -->

<?php }; ?>
<!-- *** REALTOR *** -->

<!-- *** PUBLIC *** -->
<?php if(!$_SESSION['owner']) if(!$_SESSION['realtor']) if(!$_SESSION['lease']){ ?>

<!-- Table -->

<!-- Documents and Links Inner Join -->
<?php
	$choice    = $_GET['choice'];
	$query  = "SELECT `id` FROM documents INNER JOIN tabs INNER JOIN folders WHERE (documents.doctype = '$choice' AND documents.public = 'Y' AND type NOT LIKE '%image%' AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ) OR (tabs.tabname = '$choice' AND tabs.realtor = 'Y') OR (folders.tabname = '$choice' AND folders.realtor = 'Y') LIMIT 1";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>


<!-- Sort and Filter Head -->
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>

<!-- Administrator Permission Note -->
<?php if ($_SESSION["liaison"] == true) { ?>
    <tr style="background-color: #FAFEB8;">
      <th colspan="2"><p>Preview of this folder with Public permissions.</p></th>
    </tr>
<?php } ?>

    <tr>
      <th class="table-sortable:alphanumeric" style="cursor:pointer;">&nbsp;&nbsp;&nbsp; Document Title</th>
      <th class="table-sortable:date table-filterable" style="cursor:pointer;">&nbsp;&nbsp;&nbsp; <small>Year</small></th>
    </tr>
  </thead>
  <tbody>

<!-- DATABASE RESULTS DOCUMENTS -->
<?php
	$doctype    = $_GET['choice'];
    $query  = "SELECT `id`, `docdate`, `size`, `title`, `type` FROM documents WHERE doctype = '$doctype' AND public = 'Y' AND type NOT LIKE '%image%' AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY title DESC";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
	    <tr>
	      <td align="left"><?php include('../icon-links.php'); ?>&nbsp;&nbsp;&nbsp;<a href="../download-documents.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>&conn=<?php echo"{$connName}";?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$row['id']}"; ?>'); "><?php echo "{$row['title']}"; ?></a></span></td>
	      <td align="left"><?php echo date('Y', strtotime($row['docdate'])); ?></td>
	    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS DOCUMENTS -->

<!-- DATABASE RESULTS LINKS -->
<?php
	$tabname    = $_GET['choice'];
	$query  = "SELECT * FROM tabs WHERE tabname = '$doctype' AND public = 'Y' ORDER BY title DESC";
	$result = mysqli_query($dbConn,$query) or die('Error, query failed');

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
        $argurements = strpos($row['url'], '?');
        if ($argurements === false) {
            $url = str_replace(".php", ".php?conn=".$connName, $row['url'] );
        } else {
            $url = str_replace('?', '?conn='.$connName.'&' , $row['url']);
        }
?>
	    <tr>
	      <td align="left"><a href="<?php echo "{$url}"; ?>" <?php if ($row['window'] !== '') { ?><?php echo "{$row['window']}"; ?><?php }; ?> class="<?php if ($row['window'] == '') { ?>iframe-link<?php }; ?>" onclick="javascript:pageTracker._trackPageview('ColumnLink/<?php echo "{$row['title']}"; ?>'); "><?php echo "{$row['image']}"; ?></a>&nbsp;&nbsp;
              <a href="<?php echo "{$url}"; ?>" <?php if ($row['window'] !== '') { ?><?php echo "{$row['window']}"; ?><?php }; ?> class="nav-section-link <?php if ($row['rednote'] !== ''){ ?>nav-section-subtext-anchor<?php }; ?> <?php if ($row['window'] == '') { ?>iframe-link<?php }; ?>" onclick="javascript:pageTracker._trackPageview('ColumnLink/<?php echo "{$row['title']}"; ?>'); "><?php echo "{$row['title']}"; ?></a><?php if ($row['rednote'] !== '') { ?><div class="nav-section-subtext"><p>&nbsp;&nbsp;<?php echo "{$row['rednote']}"; ?></p></div><?php }; ?></td>
	      <td></td>
	    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS LINKS -->

<!-- DATABASE RESULTS FOLDERS -->
<?php
	$foldername    = $_GET['choice'];
	$query  = "SELECT * FROM folders WHERE tabname = '$foldername' AND public = 'Y' ORDER BY title DESC";
	$result = mysqli_query($dbConn,$query) or die('Error, query failed');

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
        $argurements = strpos($row['link'], '?');
        if ($argurements === false) {
            $link = str_replace(".php", ".php?conn=".$connName, $row['link'] );
        } else {
            $link = str_replace('?', '?conn='.$connName.'&' , $row['link']);
        }
?>
	    <tr>
	      <td align="left">
              <a href="<?php echo "{$link}"; ?><?php echo "{$row['title']}"; ?>" class="iframe-link" onclick="javascript:pageTracker._trackPageview('FOLDER/<?php echo "{$row['title']}"; ?>'); "><?php echo "{$row['image']}"; ?></a>&nbsp;&nbsp;
              <a href="<?php echo "{$link}"; ?><?php echo "{$row['title']}"; ?>" class="nav-section-link <?php if ($row['rednote'] !== '') { ?>nav-section-subtext-anchor<?php }; ?> iframe-link" onclick="javascript:pageTracker._trackPageview('FOLDER/<?php echo "{$row['title']}"; ?>'); "><b><?php echo "{$row['title']}"; ?></b></a><?php if ($row['rednote'] !== '') { ?><div class="nav-section-subtext"><p>&nbsp;&nbsp;<?php echo "{$row['rednote']}"; ?></p></div><?php }; ?></td>
	      <td></td>
	    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS FOLDERS -->

  </tbody>
</table>
<?php }; ?>

<!-- PHOTOS -->
<?php if ($_SESSION["liaison"] == true) { ?>
<?php
	$doctype    = $_GET['choice'];
	$query  = "SELECT `id` FROM documents WHERE doctype = '$doctype' AND public = 'Y' AND type LIKE '%image%' AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY title DESC LIMIT 1";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr style="background-color: #FAFEB8;">
      <th colspan="2"><p>Preview of this gallery with Public permissions.</p></th>
    </tr>
  </thead>
</table>
<?php } ?>
<?php }; ?>

<?php
	$doctype    = $_GET['choice'];
	$query  = "SELECT * FROM documents WHERE doctype = '$doctype' AND public = 'Y' AND type LIKE '%image%' AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY title DESC";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
	      <div class="gallery-image-1">
<img src="../download-documents.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>" alt="<?php echo "{$row['title']}"; ?>&conn=<?php echo"{$connName}";?>" title="<?php echo "{$row['title']}"; ?>" width="100%" align="center" border="0">

<div class="row">

<div class="small-9 large-9 columns">
<div align="left" class="gallery-title"><p><?php echo "{$row['title']}"; ?></p></div>
</div>

<div class="small-3 large-3 columns">
  <div align="right" class="gallery-download"><p><a href="../download-documents.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>&conn=<?php echo"{$connName}";?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$row['id']}"; ?>'); "><i class="fa fa-download" aria-hidden="true"></i> Download</a></p></div>
</div>

</div>

	      </div>
<?php }; ?>
<!-- END PHOTOS -->

<?php }; ?>
<!-- *** PUBLIC *** -->

</div>

</body>
  
	<script src="../java/vendor/what-input.js"></script>
	<script src="../java/vendor/foundation.min.js"></script>
	<script type="text/javascript" src="../java/google-base.js"></script>
	<script type="text/javascript" src="../my-documents/google-code.js"></script>

</html>