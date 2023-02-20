<?php require_once('../my-documents/php7-my-db.php');

if (!isset($connectionPool) || $connectionPool == null) {
    $connectionPool['default'] = array('priority' => 10, 'connection' =>  $conn, 'master' => false, 'primary' => true);
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
Newsboard Archive
    </h4>
  </div>

<!-- Mobile Filter Notice -->
  <div class="stand-alone-page-content">
    <div class="rotate-note"></div>
  </div>
  
</div>

<!-- CONTENT -->
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">

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
</table>

<!-- DATABASE RESULTS - OWNER -->

<?php if ((($_SESSION['owner'] == true) AND ($_SESSION['ghost'] != 'Y')) OR ($_SESSION['webmaster'] == true)){ ?>

<?php if ($_SESSION["liaison"] == true) { ?>
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0">
  <thead>
    <tr style="background-color: #FAFEB8;">
      <th colspan="2"><p>Preview of this content with Owner permissions.</p></th>
    </tr>
  </thead>
</table>

<div style="margin: 2.5%;" >

<?php } ?>

<?php

	$queryNEWS  = "SELECT * FROM chalkboard WHERE owner = 'Y' AND eod < CURRENT_DATE() ORDER BY pod DESC";
    $dataArray = array();

    foreach ($connectionPool as $connName => $configuration) {

	    $resultNEWSARRAY = mysqli_query($configuration['connection'],$queryNEWS);

	    while ($data = $resultNEWSARRAY->fetch_array(MYSQLI_ASSOC)) {
            $dataArray[$data['pod']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName);
        }
    }

    //	$resultNEWS = mysqli_query($conn,$queryNEWS);

	//while($row = $resultNEWS->fetch_array(MYSQLI_ASSOC))
    foreach($dataArray as $recordArray )
	{
	    asort($recordArray);
	    foreach ($recordArray as $records) {
	        foreach($records as $record) {
	            $row = $record['data'];

?>
<!-- Newsboard Article Setup -->
  <div class="newsboard-container">

<!-- Newsboard Article Ribbon -->
<?php if ($row['flag'] !== 'N'){ ?>
    <div class="ribbon-wrapper">
      <div class="ribbon ribbon__<?php echo "{$row['flag']}"; ?>">
        <?php if ($row['flag'] == 'U'){ ?>URGENT!<?php }; ?>
        <?php if ($row['flag'] == 'M'){ ?>Meeting!<?php }; ?>
        <?php if ($row['flag'] == 'A'){ ?>ACTION!<?php }; ?>
        <?php if ($row['flag'] == 'I'){ ?>Important!<?php }; ?>
        <?php if ($row['flag'] == 'D'){ ?>Update!<?php }; ?>
        <?php if ($row['flag'] == 'S'){ ?><i>Social Event</i><?php }; ?>
        <?php if ($row['flag'] == 'K'){ ?>What's new!<?php }; ?>
        <?php if ($row['flag'] == 'R'){ ?><i>Reminder</i><?php }; ?>
        <?php if ($row['flag'] == 'C'){ ?>Construction<?php }; ?>
        <?php if ($row['flag'] == 'H'){ ?>HOT Topic!<?php }; ?>
        <?php if ($row['flag'] == 'G'){ ?>Great News!<?php }; ?>
        <?php if ($row['flag'] == 'O'){ ?>Next Up:<?php }; ?>
        <?php if ($row['flag'] == 'L'){ ?><i>for laughs!</i><?php }; ?>
        <?php if ($row['flag'] == 'W'){ ?>Weather<?php }; ?>
      </div>
    </div>
<?php };?>

<!-- Newsboard Article Headline -->
    <div class="row">
      <div class="small-12 columns">
	<h3 class="newsboard-subtitle"><?php echo "{$row['headline']}"; ?></h3>
	<p class="newsboard-post-date"><b>Updated: <?php echo "{$row['pod']}"; ?></b></p>
      </div>
    </div>
<!-- Newsboard Article -->
    <div class="row">
      <div class="small-12 columns">
	<div class="newsboard-post-text">
<?php if ($row['pic'] != '' AND ($row['pic2'] == '' AND $row['pic3'] == '')){ ?>
	<?php
		$type    = $row['pic'];
		$dbConn = $connectionPool[$record['dbconnName']]['connection'];
		$query  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$result = mysqli_query($dbConn, $query);

		while($newsRow = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
		<div class="newsboard-post-image-solo"><img src="../download-documents-mini.php?id=<?php echo "{$newsRow['id']}"; ?>&docdate=<?php echo "{$newsRow['docdate']}"; ?>&size=<?php echo "{$newsRow['size']}"; ?>" alt="<?php echo "{$newsRow['title']}"; ?>" title="<?php echo "{$newsRow['title']}"; ?>"></div>
	<?php
		}
	?>
<?php } ?>
	<?php echo "{$row['message']}"; ?>

<!-- iFrame Content -->
    <?php if ($row['iframe'] != ''){ ?>
        <br>
	    <div class="content-responsive-newsboard">
            <?php echo "{$row['iframe']}"; ?>
        </div>
    <?php }; ?>
<!-- End iFrame Content -->

<!-- Newsboard Article Links -->
	<ul class="newsboard-post-links">

<!-- URL -->
	<?php if ($row['url'] != ''){ ?>
	<li><a href="<?php echo "{$row['url']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('Chalkboard/<?php echo "{$row['url']}"; ?>'); "><i class="fa fa-link" aria-hidden="true"></i></a>
		<a href="<?php echo "{$row['url']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('Chalkboard/<?php echo "{$row['url']}"; ?>'); ">Link to External Website</a></li>
	<?php }; ?>
<!-- END URL -->

<!-- EMAIL -->
	<?php if ($row['email'] != ''){ ?>
	<li><a href="mailto:<?php echo "{$row['email']}"; ?>" onclick="javascript:pageTracker._trackPageview('Chalkboard/<?php echo "{$row['email']}"; ?>'); "><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
		<a href="mailto:<?php echo "{$row['email']}"; ?>" onclick="javascript:pageTracker._trackPageview('Chalkboard/<?php echo "{$row['email']}"; ?>'); ">Email&nbsp;<?php echo "{$row['email']}"; ?></a></li>
	<?php }; ?>
<!-- END EMAIL -->

<!-- MODULE -->
	<?php if ($row['tabid'] != ''){ ?>
	<?php
		$typeTID    = $row['tabid'];
        $dbConn = $connectionPool[$record['dbconnName']]['connection'];
		$queryTID  = "SELECT `url`, `window`, `image`, `title` FROM tabs WHERE `int1` = '$typeTID'";
		$resultTID = mysqli_query($dbConn,$queryTID);

		while($rowTID = $resultTID->fetch_array(MYSQLI_ASSOC))
		{
	?>
	<li><a href="<?php echo "{$rowTID['url']}"; ?>" <?php if ($rowTID['window'] !== '') { ?><?php echo "{$rowTID['window']}"; ?><?php }; ?> class="<?php if ($rowTID['window'] == '') { ?>iframe-link<?php }; ?>" ><?php echo "{$rowTID['image']}"; ?></a>
	<a href="<?php echo "{$rowTID['url']}"; ?>" <?php if ($rowTID['window'] !== '') { ?><?php echo "{$rowTID['window']}"; ?><?php }; ?> class="<?php if ($rowTID['window'] == '') { ?>iframe-link<?php }; ?>" ><?php echo "{$rowTID['title']}"; ?></a></li>
	<?php
		}
	?>
	<?php }; ?>
<!-- END MODULE -->

<!-- FORMS -->
	<?php if ($row['folderid'] != ''){ ?>
	<?php
		$typeFID    = $row['folderid'];
        $dbConn = $connectionPool[$record['dbconnName']]['connection'];
		$queryFID  = "SELECT link, title, options, image FROM folders WHERE `int1` = '$typeFID'";
		$resultFID = mysqli_query($dbConn,$queryFID);

		while($rowFID = $resultFID->fetch_array(MYSQLI_ASSOC))
		{
	?>
	<li><a href="<?php echo "{$rowFID['link']}"; ?><?php echo "{$rowFID['title']}"; ?>" <?php echo "{$rowFID['options']}"; ?> onclick="javascript:pageTracker._trackPageview('FOLDER/<?php echo "{$rowFID['title']}"; ?>'); "><?php echo "{$rowFID['image']}"; ?></a>
	<a href="<?php echo "{$rowFID['link']}"; ?><?php echo "{$rowFID['title']}"; ?>" <?php echo "{$rowFID['options']}"; ?> onclick="javascript:pageTracker._trackPageview('FOLDER/<?php echo "{$rowFID['title']}"; ?>'); "><?php echo "{$rowFID['title']}"; ?></a></li>
	<?php
		}
	?>
	<?php }; ?>
<!-- END FORMS -->

<!-- CALENDAR -->
	<?php if ($row['calid'] != ''){ ?>
	<?php
		$typeCID    = $row['calid'];
        $dbConn = $connectionPool[$record['dbconnName']]['connection'];
		$queryCID  = "SELECT `int1`, `title`, `date` FROM calendar WHERE `int1` = '$typeCID'";
		$resultCID = mysqli_query($dbConn,$queryCID);

		while($rowCID = $resultCID->fetch_array(MYSQLI_ASSOC))
		{
	?>
	<li><a href="../modules/events-single.php?choice=<?php echo "{$rowCID['int1']}"; ?>"><i class="fa fa-calendar-o" aria-hidden="true"></i></a>
	<a href="../modules/events-single.php?choice=<?php echo "{$rowCID['int1']}"; ?>"><?php echo "{$rowCID['title']}"; ?> <?php echo "{$rowCID['date']}"; ?></a></li>
	<?php
		}
	?>
	<?php }; ?>
<!-- END CALENDAR -->

<!-- DOCUMENT 1 -->
	<?php if ($row['docid'] != ''){ ?>
	<?php
		$doc    = $row['docid'];
        $dbConn = $connectionPool[$record['dbconnName']]['connection'];
		$query  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$doc'";
		$result = mysqli_query($dbConn, $query);

		while($rowDOC = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
            <li><a href="../download-documents-embed.php?table=chalkboard&mid=<?php echo "{$rowDOC['int1']}"; ?>&date=<?php echo date('Y-m-d', strtotime($rowDOC['created_date'])); ?>&d1=Y" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>')"><?php include('../icon-links-embed.php'); ?></a>&nbsp;&nbsp;&nbsp;<a href="../download-documents-embed.php?table=chalkboard&mid=<?php echo "{$rowDOC['int1']}"; ?>&date=<?php echo date('Y-m-d', strtotime($rowDOC['created_date'])); ?>&d1=Y" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>')">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a></li>
	<?php
		}
	?>
	<?php }; ?>
<!-- END DOCUMENT 1 -->

<!-- DOCUMENT 2 -->
	<?php if ($row['docid2'] != ''){ ?>
	<?php
		$doc    = $row['docid2'];
        $dbConn = $connectionPool[$record['dbconnName']]['connection'];
		$query  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$doc'";
		$result = mysqli_query($dbConn, $query);

		while($rowDOC = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
            <li><a href="../download-documents-embed.php?table=chalkboard&mid=<?php echo "{$rowDOC['int1']}"; ?>&date=<?php echo date('Y-m-d', strtotime($rowDOC['created_date'])); ?>&d1=Y" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>')"><?php include('../icon-links-embed.php'); ?></a>&nbsp;&nbsp;&nbsp;<a href="../download-documents-embed.php?table=chalkboard&mid=<?php echo "{$rowDOC['int1']}"; ?>&date=<?php echo date('Y-m-d', strtotime($rowDOC['created_date'])); ?>&d1=Y" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>')">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a></li>
	<?php
		}
	?>
	<?php }; ?>
<!-- END DOCUMENT 2 -->

<!-- DOCUMENT 3 -->
	<?php if ($row['docid3'] != ''){ ?>
	<?php
		$doc    = $row['docid3'];
        $dbConn = $connectionPool[$record['dbconnName']]['connection'];
		$query  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$doc'";
		$result = mysqli_query($dbConn, $query);

		while($rowDOC = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
            <li><a href="../download-documents-embed.php?table=chalkboard&mid=<?php echo "{$rowDOC['int1']}"; ?>&date=<?php echo date('Y-m-d', strtotime($rowDOC['created_date'])); ?>&d1=Y" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>')"><?php include('../icon-links-embed.php'); ?></a>&nbsp;&nbsp;&nbsp;<a href="../download-documents-embed.php?table=chalkboard&mid=<?php echo "{$rowDOC['int1']}"; ?>&date=<?php echo date('Y-m-d', strtotime($rowDOC['created_date'])); ?>&d1=Y" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>')">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a></li>
	<?php
		}
	?>
	<?php }; ?>
<!-- END DOCUMENT 2 -->

	</ul>

	</div>
      </div>
    </div>

<!-- Newsboard Article Multiple Photos -->
<?php if ($row['pic'] != '' AND ($row['pic2'] != '' OR $row['pic3'] != '')){ ?>
    <div class="row">
      <div class="small-12 columns">
	<?php
		$type    = $row['pic'];
        $dbConn = $connectionPool[$record['dbconnName']]['connection'];
		$query  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$result = mysqli_query($dbConn, $query);

		while($rowDOC = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
            <div class="newsboard-post-image-1"><img src="../download-documents-mini.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>" alt="<?php echo "{$rowDOC['title']}"; ?>" title="<?php echo "{$rowDOC['title']}"; ?>"></div>
	<?php
		}
	?>
      </div>
    </div>
    <div class="row">
      <div class="small-12 medium-6 columns">
	<?php
		$type    = $row['pic2'];
        $dbConn = $connectionPool[$record['dbconnName']]['connection'];
		$query  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$result = mysqli_query($dbConn, $query);

		while($rowDOC = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
            <div class="newsboard-post-image-2"><img src="../download-documents-mini.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>" alt="<?php echo "{$rowDOC['title']}"; ?>" title="<?php echo "{$rowDOC['title']}"; ?>"></div>
	<?php
		}
	?>
      </div>
      <div class="small-12 medium-6 columns">
	<?php
		$type    = $row['pic3'];
        $dbConn = $connectionPool[$record['dbconnName']]['connection'];
		$query  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$result = mysqli_query($dbConn, $query);

		while($rowDOC = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
            <div class="newsboard-post-image-3"><img src="../download-documents-mini.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>" alt="<?php echo "{$rowDOC['title']}"; ?>" title="<?php echo "{$rowDOC['title']}"; ?>"></div>
	<?php
		}
	?>
      </div>
    </div>
<?php }; ?>

<!-- Newsboard Article Photos 2 & 3 -->
<?php if ($row['pic'] == '' AND ($row['pic2'] != '' AND $row['pic3'] != '')){ ?>
    <div class="row">
      <div class="small-12 medium-6 columns">
	<?php
		$type    = $row['pic2'];
        $dbConn = $connectionPool[$record['dbconnName']]['connection'];
		$query  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$result = mysqli_query($dbConn, $query);

		while($rowDOC = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
		<div class="newsboard-post-image-twins-1"><img src="../download-documents-mini.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>" alt="<?php echo "{$rowDOC['title']}"; ?>" title="<?php echo "{$rowDOC['title']}"; ?>"></div>
	<?php
		}
	?>
      </div>
      <div class="small-12 medium-6 columns">
	<?php
		$type    = $row['pic3'];
        $dbConn = $connectionPool[$record['dbconnName']]['connection'];
		$query  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$result = mysqli_query($dbConn, $query);

		while($rowDOC = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
		    <div class="newsboard-post-image-twins-2"><img src="../download-documents-mini.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>" alt="<?php echo "{$rowDOC['title']}"; ?>" title="<?php echo "{$rowDOC['title']}"; ?>"></div>
	<?php
		}
	?>
      </div>
    </div>
<?php }; ?>

<!-- Newsboard Article Photos Lower Solo -->
<?php if ($row['pic'] == '' AND $row['pic2'] != '' AND $row['pic3'] == ''){ ?>
    <div class="row">
      <div class="small-12 columns">
	<?php
		$type    = $row['pic2'];
        $dbConn = $connectionPool[$record['dbconnName']]['connection'];
		$query  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$result = mysqli_query($dbConn, $query);

		while($rowDOC = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
    		<div class="newsboard-post-image-1"><img src="../download-documents-mini.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>" alt="<?php echo "{$rowDOC['title']}"; ?>" title="<?php echo "{$rowDOC['title']}"; ?>"></div>
	<?php
		}
	?>
      </div>
    </div>
<?php }; ?>


<!-- Newsboard Article Setup -->
  </div>

<?php
	}
?>



<?php }
}
}; ?>
</div>
<!-- END DATABASE RESULTS - OWNER -->

<!-- DATABASE RESULTS - LEASER/RENTER -->

<?php if ((($_SESSION['lease'] == true) AND ($_SESSION['ghost'] != 'Y')) OR ($_SESSION['webmaster'] == true)){ ?>

<?php if ($_SESSION["liaison"] == true) { ?>
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0">
  <thead>
    <tr style="background-color: #FAFEB8;">
      <th colspan="2"><p>Preview of this content with Leaser/Renter permissions.</p></th>
    </tr>
  </thead>
</table>

<div style="margin: 2.5%;" >

<?php } ?>

<?php
	$queryNEWS  = "SELECT * FROM chalkboard WHERE lease = 'Y' AND eod < CURRENT_DATE() ORDER BY pod DESC";

    $dataArray = array();
    foreach ($connectionPool as $connName => $configuration) {

        $resultNEWSARRAY = mysqli_query($configuration['connection'],$queryNEWS);

        while ($data = $resultNEWSARRAY->fetch_array(MYSQLI_ASSOC)) {
            $dataArray[$data['pod']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName);
        }
    }


	// while($row = $resultNEWS->fetch_array(MYSQLI_ASSOC)) {

    foreach($dataArray as $recordArray ) {
        asort($recordArray);
        foreach ($recordArray as $records) {
            foreach($records as $record) {
                $row = $record['data'];
?>

<!-- Newsboard Article Setup -->
  <div class="newsboard-container">

<!-- Newsboard Article Ribbon -->
<?php if ($row['flag'] !== 'N'){ ?>
    <div class="ribbon-wrapper">
      <div class="ribbon ribbon__<?php echo "{$row['flag']}"; ?>">
<?php if ($row['flag'] == 'U'){ ?>URGENT!<?php }; ?>
<?php if ($row['flag'] == 'M'){ ?>Meeting!<?php }; ?>
<?php if ($row['flag'] == 'D'){ ?>Updated!<?php }; ?>
<?php if ($row['flag'] == 'A'){ ?>ACTION!<?php }; ?>
<?php if ($row['flag'] == 'S'){ ?><i>Social Event</i><?php }; ?>
<?php if ($row['flag'] == 'K'){ ?>What's new!<?php }; ?>
<?php if ($row['flag'] == 'C'){ ?>Construction<?php }; ?>
<?php if ($row['flag'] == 'H'){ ?>HOT Topic!<?php }; ?>
<?php if ($row['flag'] == 'G'){ ?>Great News!<?php }; ?>
<?php if ($row['flag'] == 'O'){ ?>Next Up:<?php }; ?>
<?php if ($row['flag'] == 'L'){ ?><i>for laughs!</i><?php }; ?>
<?php if ($row['flag'] == 'W'){ ?>Weather<?php }; ?>
      </div>
    </div>
<?php }; ?>

<!-- Newsboard Article Headline -->
    <div class="row">
      <div class="small-12 columns">
	<h3 class="newsboard-subtitle"><?php echo "{$row['headline']}"; ?></h3>
	<p class="newsboard-post-date"><b>Updated: <?php echo "{$row['pod']}"; ?></b></p>
      </div>
    </div>
<!-- Newsboard Article -->
    <div class="row">
      <div class="small-12 columns">
	<div class="newsboard-post-text">
<?php if ($row['pic'] != '' AND ($row['pic2'] == '' AND $row['pic3'] == '')){ ?>
	<?php
		$type    = $row['pic'];
		$query  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$result = mysqli_query($conn, $query);

		while($newsRow = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
		<div class="newsboard-post-image-solo"><img src="../download-documents-mini.php?id=<?php echo "{$newsRow['id']}"; ?>&docdate=<?php echo "{$newsRow['docdate']}"; ?>&size=<?php echo "{$newsRow['size']}"; ?>" alt="<?php echo "{$newsRow['title']}"; ?>" title="<?php echo "{$newsRow['title']}"; ?>"></div>
	<?php
		}
	?>
<?php }; ?>
	<?php echo $row['message']; ?>

<!-- iFrame Content -->
    <?php if ($row['iframe'] != ''){ ?>
        <br>
	    <div class="content-responsive-newsboard">
            <?php echo "{$row['iframe']}"; ?>
        </div>
    <?php }; ?>
<!-- End iFrame Content -->

<!-- Newsboard Article Links -->
	<ul class="newsboard-post-links">

<!-- URL -->
	<?php if ($row['url'] != ''){ ?>
	<li><a href="<?php echo "{$row['url']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('Chalkboard/<?php echo "{$row['url']}"; ?>'); "><i class="fa fa-link" aria-hidden="true"></i></a>
		<a href="<?php echo "{$row['url']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('Chalkboard/<?php echo "{$row['url']}"; ?>'); ">Link to External Website</a></li>
	<?php }; ?>
<!-- END URL -->

<!-- EMAIL -->
	<?php if ($row['email'] != ''){ ?>
	<li><a href="mailto:<?php echo "{$row['email']}"; ?>" onclick="javascript:pageTracker._trackPageview('Chalkboard/<?php echo "{$row['email']}"; ?>'); "><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
		<a href="mailto:<?php echo "{$row['email']}"; ?>" onclick="javascript:pageTracker._trackPageview('Chalkboard/<?php echo "{$row['email']}"; ?>'); ">Email&nbsp;<?php echo "{$row['email']}"; ?></a></li>
	<?php }; ?>
<!-- END EMAIL -->

<!-- MODULE -->
	<?php if ($row['tabid'] != ''){ ?>
	<?php
		$typeTID    = $row['tabid'];
		$queryTID  = "SELECT `url`, `window`, `image`, `title` FROM tabs WHERE `int1` = '$typeTID'";
		$resultTID = mysqli_query($conn,$queryTID);

		while($rowTID = $resultTID->fetch_array(MYSQLI_ASSOC))
		{
	?>
	<li><a href="<?php echo "{$rowTID['url']}"; ?>" <?php if ($rowTID['window'] !== '') { ?><?php echo "{$rowTID['window']}"; ?><?php }; ?> class="<?php if ($rowTID['window'] == '') { ?>iframe-link<?php }; ?>" ><?php echo "{$rowTID['image']}"; ?></a>
	<a href="<?php echo "{$rowTID['url']}"; ?>" <?php if ($rowTID['window'] !== '') { ?><?php echo "{$rowTID['window']}"; ?><?php }; ?> class="<?php if ($rowTID['window'] == '') { ?>iframe-link<?php }; ?>" ><?php echo "{$rowTID['title']}"; ?></a></li>
	<?php
		}
	?>
	<?php }; ?>
<!-- END MODULE -->

<!-- FORMS -->
	<?php if ($row['folderid'] != ''){ ?>
	<?php
		$typeFID    = $row['folderid'];
		$queryFID  = "SELECT link, title, options, image FROM folders WHERE `int1` = '$typeFID'";
		$resultFID = mysqli_query($conn,$queryFID);

		while($rowFID = $resultFID->fetch_array(MYSQLI_ASSOC))
		{
	?>
	<li><a href="<?php echo "{$rowFID['link']}"; ?><?php echo "{$rowFID['title']}"; ?>" <?php echo "{$rowFID['options']}"; ?> onclick="javascript:pageTracker._trackPageview('FOLDER/<?php echo "{$rowFID['title']}"; ?>'); "><?php echo "{$rowFID['image']}"; ?></a>
	<a href="<?php echo "{$rowFID['link']}"; ?><?php echo "{$rowFID['title']}"; ?>" <?php echo "{$rowFID['options']}"; ?> onclick="javascript:pageTracker._trackPageview('FOLDER/<?php echo "{$rowFID['title']}"; ?>'); "><?php echo "{$rowFID['title']}"; ?></a></li>
	<?php
		}
	?>
	<?php }; ?>
<!-- END FORMS -->

<!-- CALENDAR -->
	<?php if ($row['calid'] != ''){ ?>
	<?php
		$typeCID    = $row['calid'];
		$queryCID  = "SELECT `int1`, `title`, `date` FROM calendar WHERE `int1` = '$typeCID'";
		$resultCID = mysqli_query($conn,$queryCID);

		while($rowCID = $resultCID->fetch_array(MYSQLI_ASSOC))
		{
	?>
	<li><a href="../modules/events-single.php?choice=<?php echo "{$rowCID['int1']}"; ?>"><i class="fa fa-calendar-o" aria-hidden="true"></i></a>
	<a href="../modules/events-single.php?choice=<?php echo "{$rowCID['int1']}"; ?>"><?php echo "{$rowCID['title']}"; ?> <?php echo "{$rowCID['date']}"; ?></a></li>
	<?php
		}
	?>
	<?php }; ?>
<!-- END CALENDAR -->

<!-- DOCUMENT 1 -->
	<?php if ($row['docid'] != ''){ ?>
	<?php
		$doc    = $row['docid'];
		$query  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$doc'";
		$result = mysqli_query($conn, $query);

		while($rowDOC = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
	<li><a href="../download-documents-embed.php?table=chalkboard&mid=<?php echo "{$rowDOC['int1']}"; ?>&date=<?php echo date('Y-m-d', strtotime($rowDOC['created_date'])); ?>&d1=Y" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>')"><?php include('../icon-links-embed.php'); ?></a>&nbsp;&nbsp;&nbsp;<a href="../download-documents-embed.php?table=chalkboard&mid=<?php echo "{$rowDOC['int1']}"; ?>&date=<?php echo date('Y-m-d', strtotime($rowDOC['created_date'])); ?>&d1=Y" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>')">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a></li>
	<?php
		}
	?>
	<?php }; ?>
<!-- END DOCUMENT 1 -->

<!-- DOCUMENT 2 -->
	<?php if ($row['docid2'] != ''){ ?>
	<?php
		$doc    = $row['docid2'];
		$query  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$doc'";
		$result = mysqli_query($conn, $query);

		while($rowDOC = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
	<li><a href="../download-documents-embed.php?table=chalkboard&mid=<?php echo "{$rowDOC['int1']}"; ?>&date=<?php echo date('Y-m-d', strtotime($rowDOC['created_date'])); ?>&d1=Y" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>')"><?php include('../icon-links-embed.php'); ?></a>&nbsp;&nbsp;&nbsp;<a href="../download-documents-embed.php?table=chalkboard&mid=<?php echo "{$rowDOC['int1']}"; ?>&date=<?php echo date('Y-m-d', strtotime($rowDOC['created_date'])); ?>&d1=Y" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>')">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a></li>
	<?php
		}
	?>
	<?php }; ?>
<!-- END DOCUMENT 2 -->

<!-- DOCUMENT 3 -->
	<?php if ($row['docid3'] != ''){ ?>
	<?php
		$doc    = $row['docid3'];
		$query  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$doc'";
		$result = mysqli_query($conn, $query);

		while($rowDOC = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
	<li><a href="../download-documents-embed.php?table=chalkboard&mid=<?php echo "{$rowDOC['int1']}"; ?>&date=<?php echo date('Y-m-d', strtotime($rowDOC['created_date'])); ?>&d1=Y" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>')"><?php include('../icon-links-embed.php'); ?></a>&nbsp;&nbsp;&nbsp;<a href="../download-documents-embed.php?table=chalkboard&mid=<?php echo "{$rowDOC['int1']}"; ?>&date=<?php echo date('Y-m-d', strtotime($rowDOC['created_date'])); ?>&d1=Y" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>')">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a></li>
	<?php
		}
	?>
	<?php }; ?>
<!-- END DOCUMENT 2 -->

	</ul>

	</div>
      </div>
    </div>

<!-- Newsboard Article Multiple Photos -->
<?php if ($row['pic'] != '' AND ($row['pic2'] != '' OR $row['pic3'] != '')){ ?>
    <div class="row">
      <div class="small-12 columns">
	<?php
		$type    = $row['pic'];
		$query  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$result = mysqli_query($conn, $query);

		while($rowDOC = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
		<div class="newsboard-post-image-1"><img src="../download-documents-mini.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>" alt="<?php echo "{$rowDOC['title']}"; ?>" title="<?php echo "{$rowDOC['title']}"; ?>"></div>
	<?php
		}
	?>
      </div>
    </div>
    <div class="row">
      <div class="small-12 medium-6 columns">
	<?php
		$type    = $row['pic2'];
		$query  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$result = mysqli_query($conn, $query);

		while($rowDOC = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
		<div class="newsboard-post-image-2"><img src="../download-documents-mini.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>" alt="<?php echo "{$rowDOC['title']}"; ?>" title="<?php echo "{$rowDOC['title']}"; ?>"></div>
	<?php
		}
	?>
      </div>
      <div class="small-12 medium-6 columns">
	<?php
		$type    = $row['pic3'];
		$query  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$result = mysqli_query($conn, $query);

		while($rowDOC = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
		<div class="newsboard-post-image-3"><img src="../download-documents-mini.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>" alt="<?php echo "{$rowDOC['title']}"; ?>" title="<?php echo "{$rowDOC['title']}"; ?>"></div>
	<?php
		}
	?>
      </div>
    </div>
<?php }; ?>

<!-- Newsboard Article Photos 2 & 3 -->
<?php if ($row['pic'] == '' AND ($row['pic2'] != '' AND $row['pic3'] != '')){ ?>
    <div class="row">
      <div class="small-12 medium-6 columns">
	<?php
		$type    = $row['pic2'];
		$query  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$result = mysqli_query($conn, $query);

		while($rowDOC = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
		<div class="newsboard-post-image-twins-1"><img src="../download-documents-mini.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>" alt="<?php echo "{$rowDOC['title']}"; ?>" title="<?php echo "{$rowDOC['title']}"; ?>"></div>
	<?php
		}
	?>
      </div>
      <div class="small-12 medium-6 columns">
	<?php
		$type    = $row['pic3'];
		$query  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$result = mysqli_query($conn, $query);

		while($rowDOC = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
		<div class="newsboard-post-image-twins-2"><img src="../download-documents-mini.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>" alt="<?php echo "{$rowDOC['title']}"; ?>" title="<?php echo "{$rowDOC['title']}"; ?>"></div>
	<?php
		}
	?>
      </div>
    </div>
<?php }; ?>

<!-- Newsboard Article Photos Lower Solo -->
<?php if ($row['pic'] == '' AND $row['pic2'] != '' AND $row['pic3'] == ''){ ?>
    <div class="row">
      <div class="small-12 columns">
	<?php
		$type    = $row['pic2'];
		$query  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$result = mysqli_query($conn, $query);

		while($rowDOC = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
		<div class="newsboard-post-image-1"><img src="../download-documents-mini.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>" alt="<?php echo "{$rowDOC['title']}"; ?>" title="<?php echo "{$rowDOC['title']}"; ?>"></div>
	<?php
		}
	?>
      </div>
    </div>
<?php }; ?>


<!-- Newsboard Article Setup -->
  </div>

<?php
	} } }
?>

</div>

<?php } ?>

<!-- END DATABASE RESULTS - LEASER/RENTER -->

<!-- DATABASE RESULTS - REALTOR -->

<?php if ((($_SESSION['realtor'] == true) AND ($_SESSION['ghost'] != 'Y')) OR ($_SESSION['webmaster'] == true)){ ?>

<?php if ($_SESSION["liaison"] == true) { ?>
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0">
  <thead>
    <tr style="background-color: #FAFEB8;">
      <th colspan="2"><p>Preview of this content with Realtor permissions.</p></th>
    </tr>
  </thead>
</table>

<div style="margin: 2.5%;" >

<?php } ?>

<?php
	$queryNEWS  = "SELECT * FROM chalkboard WHERE realtor = 'Y' AND eod < CURRENT_DATE() ORDER BY pod DESC";
	//$resultNEWS = mysqli_query($conn,$queryNEWS);

    $dataArray = array();
    foreach ($connectionPool as $connName => $configuration) {

        $resultNEWSARRAY = mysqli_query($configuration['connection'],$queryNEWS);

        while ($data = $resultNEWSARRAY->fetch_array(MYSQLI_ASSOC)) {
            $dataArray[$data['pod']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName);
        }
    }

	//while($row = $resultNEWS->fetch_array(MYSQLI_ASSOC)) {
    foreach($dataArray as $recordArray ) {
        asort($recordArray);
        foreach ($recordArray as $records) {
            foreach($records as $record) {
                $row = $record['data'];
    ?>

<!-- Newsboard Article Setup -->
  <div class="newsboard-container">

<!-- Newsboard Article Ribbon -->
<?php if ($row['flag'] !== 'N'){ ?>
    <div class="ribbon-wrapper">
      <div class="ribbon ribbon__<?php echo "{$row['flag']}"; ?>">
<?php if ($row['flag'] == 'U'){ ?>URGENT!<?php }; ?>
<?php if ($row['flag'] == 'M'){ ?>Meeting!<?php }; ?>
<?php if ($row['flag'] == 'D'){ ?>Updated!<?php }; ?>
<?php if ($row['flag'] == 'A'){ ?>ACTION!<?php }; ?>
<?php if ($row['flag'] == 'S'){ ?><i>Social Event</i><?php }; ?>
<?php if ($row['flag'] == 'K'){ ?>What's new!<?php }; ?>
<?php if ($row['flag'] == 'C'){ ?>Construction<?php }; ?>
<?php if ($row['flag'] == 'H'){ ?>HOT Topic!<?php }; ?>
<?php if ($row['flag'] == 'G'){ ?>Great News!<?php }; ?>
<?php if ($row['flag'] == 'O'){ ?>Next Up:<?php }; ?>
<?php if ($row['flag'] == 'L'){ ?><i>for laughs!</i><?php }; ?>
<?php if ($row['flag'] == 'W'){ ?>Weather<?php }; ?>
      </div>
    </div>
<?php }; ?>

<!-- Newsboard Article Headline -->
    <div class="row">
      <div class="small-12 columns">
	<h3 class="newsboard-subtitle"><?php echo "{$row['headline']}"; ?></h3>
	<p class="newsboard-post-date"><b>Updated: <?php echo "{$row['pod']}"; ?></b></p>
      </div>
    </div>
<!-- Newsboard Article -->
    <div class="row">
      <div class="small-12 columns">
	<div class="newsboard-post-text">
<?php if ($row['pic'] != '' AND ($row['pic2'] == '' AND $row['pic3'] == '')){ ?>
	<?php
		$type    = $row['pic'];
		$query  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$result = mysqli_query($conn, $query);

		while($rowDOC = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
		<div class="newsboard-post-image-solo"><img src="../download-documents-mini.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>" alt="<?php echo "{$rowDOC['title']}"; ?>" title="<?php echo "{$rowDOC['title']}"; ?>"></div>
	<?php
		}
	?>
<?php }; ?>
	<?php echo "{$row['message']}"; ?>

<!-- iFrame Content -->
    <?php if ($row['iframe'] != ''){ ?>
        <br>
	    <div class="content-responsive-newsboard">
            <?php echo "{$row['iframe']}"; ?>
        </div>
    <?php }; ?>
<!-- End iFrame Content -->

<!-- Newsboard Article Links -->
	<ul class="newsboard-post-links">

<!-- URL -->
	<?php if ($row['url'] != ''){ ?>
	<li><a href="<?php echo "{$row['url']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('Chalkboard/<?php echo "{$row['url']}"; ?>'); "><i class="fa fa-link" aria-hidden="true"></i></a>
		<a href="<?php echo "{$row['url']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('Chalkboard/<?php echo "{$row['url']}"; ?>'); ">Link to External Website</a></li>
	<?php }; ?>
<!-- END URL -->

<!-- EMAIL -->
	<?php if ($row['email'] != ''){ ?>
	<li><a href="mailto:<?php echo "{$row['email']}"; ?>" onclick="javascript:pageTracker._trackPageview('Chalkboard/<?php echo "{$row['email']}"; ?>'); "><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
		<a href="mailto:<?php echo "{$row['email']}"; ?>" onclick="javascript:pageTracker._trackPageview('Chalkboard/<?php echo "{$row['email']}"; ?>'); ">Email&nbsp;<?php echo "{$row['email']}"; ?></a></li>
	<?php }; ?>
<!-- END EMAIL -->

<!-- MODULE -->
	<?php if ($row['tabid'] != ''){ ?>
	<?php
		$typeTID    = $row['tabid'];
		$queryTID  = "SELECT `url`, `window`, `image`, `title` FROM tabs WHERE `int1` = '$typeTID'";
		$resultTID = mysqli_query($conn,$queryTID);

		while($rowTID = $resultTID->fetch_array(MYSQLI_ASSOC))
		{
	?>
	<li><a href="<?php echo "{$rowTID['url']}"; ?>" <?php if ($rowTID['window'] !== '') { ?><?php echo "{$rowTID['window']}"; ?><?php }; ?> class="<?php if ($rowTID['window'] == '') { ?>iframe-link<?php }; ?>" ><?php echo "{$rowTID['image']}"; ?></a>
	<a href="<?php echo "{$rowTID['url']}"; ?>" <?php if ($rowTID['window'] !== '') { ?><?php echo "{$rowTID['window']}"; ?><?php }; ?> class="<?php if ($rowTID['window'] == '') { ?>iframe-link<?php }; ?>" ><?php echo "{$rowTID['title']}"; ?></a></li>
	<?php
		}
	?>
	<?php }; ?>
<!-- END MODULE -->

<!-- FORMS -->
	<?php if ($row['folderid'] != ''){ ?>
	<?php
		$typeFID    = $row['folderid'];
		$queryFID  = "SELECT link, title, options, image FROM folders WHERE `int1` = '$typeFID'";
		$resultFID = mysqli_query($conn,$queryFID);

		while($rowFID = $resultFID->fetch_array(MYSQLI_ASSOC))
		{
	?>
	<li><a href="<?php echo "{$rowFID['link']}"; ?><?php echo "{$rowFID['title']}"; ?>" <?php echo "{$rowFID['options']}"; ?> onclick="javascript:pageTracker._trackPageview('FOLDER/<?php echo "{$rowFID['title']}"; ?>'); "><?php echo "{$rowFID['image']}"; ?></a>
	<a href="<?php echo "{$rowFID['link']}"; ?><?php echo "{$rowFID['title']}"; ?>" <?php echo "{$rowFID['options']}"; ?> onclick="javascript:pageTracker._trackPageview('FOLDER/<?php echo "{$rowFID['title']}"; ?>'); "><?php echo "{$rowFID['title']}"; ?></a></li>
	<?php
		}
	?>
	<?php }; ?>
<!-- END FORMS -->

<!-- CALENDAR -->
	<?php if ($row['calid'] != ''){ ?>
	<?php
		$typeCID    = $row['calid'];
		$queryCID  = "SELECT `int1`, `title`, `date` FROM calendar WHERE `int1` = '$typeCID'";
		$resultCID = mysqli_query($conn,$queryCID);

		while($rowCID = $resultCID->fetch_array(MYSQLI_ASSOC))
		{
	?>
	<li><a href="../modules/events-single.php?choice=<?php echo "{$rowCID['int1']}"; ?>"><i class="fa fa-calendar-o" aria-hidden="true"></i></a>
	<a href="../modules/events-single.php?choice=<?php echo "{$rowCID['int1']}"; ?>"><?php echo "{$rowCID['title']}"; ?> <?php echo "{$rowCID['date']}"; ?></a></li>
	<?php
		}
	?>
	<?php }; ?>
<!-- END CALENDAR -->

<!-- DOCUMENT 1 -->
	<?php if ($row['docid'] != ''){ ?>
	<?php
		$doc    = $row['docid'];
		$query  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$doc'";
		$result = mysqli_query($conn, $query);

		while($rowDOC = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
	<li><a href="../download-documents-embed.php?table=chalkboard&mid=<?php echo "{$rowDOC['int1']}"; ?>&date=<?php echo date('Y-m-d', strtotime($rowDOC['created_date'])); ?>&d1=Y" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>')"><?php include('../icon-links-embed.php'); ?></a>&nbsp;&nbsp;&nbsp;<a href="../download-documents-embed.php?table=chalkboard&mid=<?php echo "{$rowDOC['int1']}"; ?>&date=<?php echo date('Y-m-d', strtotime($rowDOC['created_date'])); ?>&d1=Y" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>')">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a></li>
	<?php
		}
	?>
	<?php }; ?>
<!-- END DOCUMENT 1 -->

<!-- DOCUMENT 2 -->
	<?php if ($row['docid2'] != ''){ ?>
	<?php
		$doc    = $row['docid2'];
		$query  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$doc'";
		$result = mysqli_query($conn, $query);

		while($rowDOC = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
	<li><a href="../download-documents-embed.php?table=chalkboard&mid=<?php echo "{$rowDOC['int1']}"; ?>&date=<?php echo date('Y-m-d', strtotime($rowDOC['created_date'])); ?>&d1=Y" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>')"><?php include('../icon-links-embed.php'); ?></a>&nbsp;&nbsp;&nbsp;<a href="../download-documents-embed.php?table=chalkboard&mid=<?php echo "{$rowDOC['int1']}"; ?>&date=<?php echo date('Y-m-d', strtotime($rowDOC['created_date'])); ?>&d1=Y" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>')">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a></li>
	<?php
		}
	?>
	<?php }; ?>
<!-- END DOCUMENT 2 -->

<!-- DOCUMENT 3 -->
	<?php if ($row['docid3'] != ''){ ?>
	<?php
		$doc    = $row['docid3'];
		$query  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$doc'";
		$result = mysqli_query($conn, $query);

		while($rowDOC = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
	<li><a href="../download-documents-embed.php?table=chalkboard&mid=<?php echo "{$rowDOC['int1']}"; ?>&date=<?php echo date('Y-m-d', strtotime($rowDOC['created_date'])); ?>&d1=Y" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>')"><?php include('../icon-links-embed.php'); ?></a>&nbsp;&nbsp;&nbsp;<a href="../download-documents-embed.php?table=chalkboard&mid=<?php echo "{$rowDOC['int1']}"; ?>&date=<?php echo date('Y-m-d', strtotime($rowDOC['created_date'])); ?>&d1=Y" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>')">Download&nbsp;<?php echo "{$rowDOC['title']}"; ?></a></li>
	<?php
		}
	?>
	<?php }; ?>
<!-- END DOCUMENT 2 -->

	</ul>

	</div>
      </div>
    </div>

<!-- Newsboard Article Multiple Photos -->
<?php if ($row['pic'] != '' AND ($row['pic2'] != '' OR $row['pic3'] != '')){ ?>
    <div class="row">
      <div class="small-12 columns">
	<?php
		$type    = $row['pic'];
		$query  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$result = mysqli_query($conn, $query);

		while($rowDOC = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
		<div class="newsboard-post-image-1"><img src="../download-documents-mini.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>" alt="<?php echo "{$rowDOC['title']}"; ?>" title="<?php echo "{$rowDOC['title']}"; ?>"></div>
	<?php
		}
	?>
      </div>
    </div>
    <div class="row">
      <div class="small-12 medium-6 columns">
	<?php
		$type    = $row['pic2'];
		$query  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$result = mysqli_query($conn, $query);

		while($rowDOC = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
		<div class="newsboard-post-image-2"><img src="../download-documents-mini.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>" alt="<?php echo "{$rowDOC['title']}"; ?>" title="<?php echo "{$rowDOC['title']}"; ?>"></div>
	<?php
		}
	?>
      </div>
      <div class="small-12 medium-6 columns">
	<?php
		$type    = $row['pic3'];
		$query  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$result = mysqli_query($conn, $query);

		while($rowDOC = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
		<div class="newsboard-post-image-3"><img src="../download-documents-mini.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>" alt="<?php echo "{$rowDOC['title']}"; ?>" title="<?php echo "{$rowDOC['title']}"; ?>"></div>
	<?php
		}
	?>
      </div>
    </div>
<?php }; ?>

<!-- Newsboard Article Photos 2 & 3 -->
<?php if ($row['pic'] == '' AND ($row['pic2'] != '' AND $row['pic3'] != '')){ ?>
    <div class="row">
      <div class="small-12 medium-6 columns">
	<?php
		$type    = $row['pic2'];
		$query  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$result = mysqli_query($conn, $query);

		while($rowDOC = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
		<div class="newsboard-post-image-twins-1"><img src="../download-documents-mini.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>" alt="<?php echo "{$rowDOC['title']}"; ?>" title="<?php echo "{$rowDOC['title']}"; ?>"></div>
	<?php
		}
	?>
      </div>
      <div class="small-12 medium-6 columns">
	<?php
		$type    = $row['pic3'];
		$query  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$result = mysqli_query($conn, $query);

		while($rowDOC = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
		<div class="newsboard-post-image-twins-2"><img src="../download-documents-mini.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>" alt="<?php echo "{$rowDOC['title']}"; ?>" title="<?php echo "{$rowDOC['title']}"; ?>"></div>
	<?php
		}
	?>
      </div>
    </div>
<?php }; ?>

<!-- Newsboard Article Photos Lower Solo -->
<?php if ($row['pic'] == '' AND $row['pic2'] != '' AND $row['pic3'] == ''){ ?>
    <div class="row">
      <div class="small-12 columns">
	<?php
		$type    = $row['pic2'];
		$query  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$result = mysqli_query($conn, $query);

		while($rowDOC = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
		<div class="newsboard-post-image-1"><img src="../download-documents-mini.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>" alt="<?php echo "{$rowDOC['title']}"; ?>" title="<?php echo "{$rowDOC['title']}"; ?>"></div>
	<?php
		}
	?>
      </div>
    </div>
<?php }; ?>


<!-- Newsboard Article Setup -->
  </div>

<?php
	} } }
?>

</div>

<?php } ?>

<!-- END DATABASE RESULTS - REALTOR -->

<!-- CONTENT -->

</body>
  
	<script src="../java/vendor/what-input.js"></script>
	<script src="../java/vendor/foundation.min.js"></script>
	<script type="text/javascript" src="../java/google-base.js"></script>
	<script type="text/javascript" src="../my-documents/google-code.js"></script>

</html>