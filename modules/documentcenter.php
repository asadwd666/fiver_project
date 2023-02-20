<?php require_once('../my-documents/php7-my-db.php'); 
	if (!isset($connectionPool) || $connectionPool == null) {
        $connectionPool[$CommunityName] = array('priority' => 10, 'connection' =>  $conn, 'master' => false, 'primary' => true);
    }

    $connName = isset($_GET['conn']) ? $_GET['conn'] : "none";

	if ($connName != "none") {
	    foreach($connectionPool as $key => $value) {
	        if ($key != $connName && $key != 'Default') {
	            unset($connectionPool[$key]);
            }
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
      <h4>All Documents</h4>
      <?php if (isset($connectionPool) && isset($connectionPool[$connName])) { ?>
        <p>This content is from <?php echo "{$connName}"; ?></p>
      <?php	} ?>
  </div>

<!-- Mobile Filter Notice -->
  <div class="stand-alone-page-content">
    <div class="rotate-note">Rotate your mobile device to view folder and date columns, and for sorting and filtering tools.</div>
  </div>

<!-- *** NOT LOGGED IN *** -->
<?php if (($_SESSION['owner'] != true) AND ($_SESSION['lease'] != true) AND ($_SESSION['realtor'] != true)){ ?>
<table width="100%" class="responsive-table">
  <thead>
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
</table>
<?php }; ?>
<br>
<!-- LIAISON PREVIEW NOTE -->
<?php if ($_SESSION["liaison"] == true) { ?>
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr style="background-color: #FAFEB8;">
      <th colspan="2"><p>You are viewing this folder as an Administrator.  Scroll down to preview this folder from the perspective of applicable permission groups.</p></th>
    </tr>
  </thead>
</table>
<?php }; ?>
<!-- LIAISON PREVIEW NOTE -->

<!-- *** OWNER *** -->
<?php if ($_SESSION["owner"] == true) { ?>

<?php if ($_SESSION["liaison"] == true) { ?>
<!-- Administrator Permission Note -->
      <div class="permissions-notification"><p>Preview of this folder with Owner permissions.</p></div>
<?php } ?>

<!-- Table -->
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-stripeclass:alternate table-autostripe table-rowshade-alternate">

<!-- Sort and Filter Head -->
  <thead>
    <tr>
      <th class="table-sortable:alphanumeric" style="cursor:pointer;">&nbsp;&nbsp;&nbsp; Document Title</th>
      <th class="table-sortable:alphanumeric table-filterable" style="cursor:pointer;"><small>Folder</small></th>
      <th class="table-sortable:date table-filterable" style="cursor:pointer;"><small>Year</small></th>
    </tr>
  </thead>

<!-- Body -->
  <tbody>
<?php

	$dataArray = array();
	$query  = "SELECT `id`, docdate, size, title, doctype, type FROM documents WHERE owner = 'Y' AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY title";


    foreach ($connectionPool as $connName => $configuration) {

        $resultARRAY = mysqli_query($configuration['connection'],$query);

        while ($data = $resultARRAY->fetch_array(MYSQLI_ASSOC)) {
            $dataArray[$data['title']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
        }
    }


	//$result = mysqli_query($conn, $query);
	foreach($dataArray as $recordArray ) {
		asort($recordArray);
		foreach ($recordArray as $records) {
			foreach($records as $record) {
				$row = $record['data'];

	// while($row = $result->fetch_array(MYSQLI_ASSOC))
	// {
?>
	    <tr>
	      <td align="left"><?php include('../icon-links.php'); ?>&nbsp;&nbsp;&nbsp;<a href="../download-documents.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>&conn=<?php echo $record['dbconnName']; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$row['id']}"; ?>'); "><?php echo "{$row['title']}"; ?></a></span></td>
	      <td align="left" class="responsive-table-cell"><?php echo "{$row['doctype']}"; ?><br></td>
	      <td align="left"><?php echo date('Y', strtotime($row['docdate'])); ?></td>
	    </tr>
<?php
			}
		}
	}
?>
  </tbody>

</table>

<?php }; ?>
<!-- *** OWNER *** -->

<!-- *** LEASE *** -->
<?php if ($_SESSION["lease"] == true) { ?>

<?php if ($_SESSION["liaison"] == true) { ?>
<!-- Administrator Permission Note -->
      <div class="permissions-notification"><p>Preview of this folder with Leaser/Renter permissions.</p></div>
<?php } ?>

<!-- Table -->
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-stripeclass:alternate table-autostripe table-rowshade-alternate">

<!-- Sort and Filter Head -->
  <thead>
    <tr>
      <th class="table-sortable:alphanumeric" style="cursor:pointer;">&nbsp;&nbsp;&nbsp; Document Title</th>
      <th class="table-sortable:alphanumeric table-filterable" style="cursor:pointer;">&nbsp;&nbsp;&nbsp; <small>Folder</small></th>
      <th class="table-sortable:date table-filterable" style="cursor:pointer;">&nbsp;&nbsp;&nbsp; <small>Year</small></th>
    </tr>
  </thead>

<!-- Body -->
  <tbody>
<?php
	$dataArray = array();
	$query  = "SELECT `id`, docdate, size, title, doctype, type FROM documents WHERE lease = 'Y' AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY title";
	
	//$result = mysqli_query($conn, $query);
	foreach ($connectionPool as $connName => $configuration) {
        $resultARRAY = mysqli_query($configuration['connection'],$query);

        while ($data = $resultARRAY->fetch_array(MYSQLI_ASSOC)) {
            $dataArray[$data['title']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
        }
    }

	//while($row = $result->fetch_array(MYSQLI_ASSOC))
	//{
    foreach($dataArray as $recordArray ) {
		asort($recordArray);
		foreach ($recordArray as $records) {
			foreach($records as $record) {
				$row = $record['data'];
?>
	    <tr>
	      <td align="left"><?php include('../icon-links.php'); ?>&nbsp;&nbsp;&nbsp;<a href="../download-documents.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>&conn=<?php echo $record['dbconnName']; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$row['id']}"; ?>'); "><?php echo "{$row['title']}"; ?></a></span></td>
	      <td align="left" class="responsive-table-cell"><?php echo "{$row['doctype']}"; ?><br></td>
	      <td align="left"><?php echo date('Y', strtotime($row['docdate'])); ?></td>
	    </tr>
<?php
			}
		}
	}
?>
  </tbody>

</table>

<?php }; ?>
<!-- *** LEASE *** -->

<!-- *** REALTOR *** -->
<?php if ($_SESSION["realtor"] == true) { ?>

<?php if ($_SESSION["liaison"] == true) { ?>
<!-- Administrator Permission Note -->
      <div class="permissions-notification"><p>Preview of this folder with Realtor permissions.</p></div>
<?php } ?>

<!-- Table -->
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-stripeclass:alternate table-autostripe table-rowshade-alternate">

<!-- Sort and Filter Head -->
  <thead>
    <tr>
      <th class="table-sortable:alphanumeric" style="cursor:pointer;">&nbsp;&nbsp;&nbsp; Document Title</th>
      <th class="table-sortable:alphanumeric table-filterable" style="cursor:pointer;">&nbsp;&nbsp;&nbsp; <small>Folder</small></th>
      <th class="table-sortable:date table-filterable" style="cursor:pointer;">&nbsp;&nbsp;&nbsp; <small>Year</small></th>
    </tr>
  </thead>

<!-- Body -->
  <tbody>
<?php
	$dataArray = array();
	$query  = "SELECT `id`, docdate, size, title, doctype, type FROM documents WHERE realtor = 'Y' AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY title";
	foreach ($connectionPool as $connName => $configuration) {
        $resultARRAY = mysqli_query($configuration['connection'],$query);

        while ($data = $resultARRAY->fetch_array(MYSQLI_ASSOC)) {
            $dataArray[$data['title']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
        }
    }
	//$result = mysqli_query($conn, $query);

	//while($row = $result->fetch_array(MYSQLI_ASSOC))
	//{
    foreach($dataArray as $recordArray ) {
		asort($recordArray);
		foreach ($recordArray as $records) {
			foreach($records as $record) {
				$row = $record['data'];

?>
	    <tr>
	      <td align="left"><?php include('../icon-links.php'); ?>&nbsp;&nbsp;&nbsp;<a href="../download-documents.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>&conn=<?php echo $record['dbconnName']; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$row['id']}"; ?>'); "><?php echo "{$row['title']}"; ?></a></span></td>
	      <td align="left" class="responsive-table-cell"><?php echo "{$row['doctype']}"; ?><br></td>
	      <td align="left"><?php echo date('Y', strtotime($row['docdate'])); ?></td>
	    </tr>
<?php
			}
		}
	}
?>
  </tbody>

</table>

<?php }; ?>
<!-- *** REALTOR *** -->
  
</div>

</body>
  
	<script src="../java/vendor/what-input.js"></script>
	<script src="../java/vendor/foundation.min.js"></script>
	<script type="text/javascript" src="../java/google-base.js"></script>
	<script type="text/javascript" src="../my-documents/google-code.js"></script>

</html>
