<?php
    if (!isset($connectionPool) || $connectionPool == null) {
        $connectionPool[$CommunityName]= array('priority' => 10, 'connection' =>  $conn, 'master' => false, 'primary' => true);
    }

    $dataArray = array();
	$query  = "SELECT *, UNIX_TIMESTAMP(CONCAT(pod)) as result_index FROM chalkboard WHERE (owner = 'Y' AND eod >= CURRENT_DATE() AND pod <= CURRENT_DATE()) AND (`flag` != 'U' AND `flag` != 'M' AND `flag` != 'A' AND `flag` != 'I' AND `flag` != 'D' AND `flag` != 'C' AND `flag` != 'R') ORDER BY pod DESC";
    foreach ($connectionPool as $connName => $configuration) {
        $resultARRAY = mysqli_query($configuration['connection'],$query);

        while ($data = $resultARRAY->fetch_array(MYSQLI_ASSOC)) {
            // $dataArray[$data['title']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
            $dataArray[$data['result_index']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
        }
    }

    krsort($dataArray, 1);
    foreach($dataArray as $recordArray ) {
        ksort($recordArray, 1);
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
<?php }; ?>

<!-- Newsboard Article Headline -->
    <div class="row">
      <div class="small-12 columns">
<?php if ($row['pic'] != '' AND ($row['pic2'] == '' AND $row['pic3'] == '')){ ?>
	<?php
		$type    = $row['pic'];
		$query  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$result = mysqli_query($connectionPool[$record['dbconnName']]['connection'], $query);

		//while($row = $result->fetch_array(MYSQLI_ASSOC))
        while($row1 = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
		<div class="newsboard-post-image-solo"><a href="../download-documents-mini.php?id=<?php echo "{$row1['id']}"; ?>&docdate=<?php echo "{$row1['docdate']}"; ?>&size=<?php echo "{$row1['size']}"; ?>&conn=<?php echo $record['dbconnName']; ?>" class="iframe-link" >
                <img src="../download-documents-mini.php?id=<?php echo "{$row1['id']}"; ?>&docdate=<?php echo "{$row1['docdate']}"; ?>&size=<?php echo "{$row1['size']}"; ?>&conn=<?php echo $record['dbconnName']; ?>" alt="<?php echo "{$row1['title']}"; ?>" title="<?php echo "{$row1['title']}"; ?>"></a></div>
	<?php
		}
	?>
<?php }; ?>
	<h3 class="newsboard-subtitle"><?php echo "{$row['headline']}"; ?></h3>
          <?php if ($record['master'] === true) { ?><div class="nav-section-subtext-blue"><br><p>From <?php echo $record['dbconnName']; ?></p></div><?php }; ?>
	<div class="newsboard-post-text">
	<?php echo "{$row['message']}"; ?>

<!-- iFrame Content -->
    <?php if ($row['iframe'] != ''){ ?>
        <br>
	    <div class="content-responsive-newsboard" align="center">
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
		$resultTID = mysqli_query($connectionPool[$record['dbconnName']]['connection'],$queryTID);

		//while($rowTID = $resultTID->fetch_array(MYSQLI_ASSOC))
        while($rowTID  = $resultTID->fetch_array(MYSQLI_ASSOC))
		{
	?>
	<li><a href="<?php echo "{$rowTID['url']}"; ?>" <?php if ($rowTID['window'] !== '') { ?><?php echo "{$rowTID['window']}"; ?><?php }; ?> class="<?php if ($rowTID['window'] == '') { ?>iframe-link<?php }; ?>" ><?php echo "{$rowTID['image']}"; ?></a>
	<a href="<?php echo "{$rowTID['url']}"; ?>" <?php if ($rowTID['window'] !== '') { ?><?php echo "{$rowTID['window']}"; ?><?php }; ?> class="<?php if ($rowTID['window'] == '') { ?>iframe-link<?php }; ?>" ><?php echo "{$rowTID['title']}"; ?></a></li>
	<?php
		}
	?>
	<?php }; ?>
<!-- END MODULE -->

<!-- FOLDER -->
	<?php if ($row['folderid'] != ''){ ?>
	<?php
		$typeFID    = $row['folderid'];
		$queryFID  = "SELECT link, title, options, image FROM folders WHERE `int1` = '$typeFID'";
		$resultFID = mysqli_query($connectionPool[$record['dbconnName']]['connection'],$queryFID);

		//while($rowFID = $resultFID->fetch_array(MYSQLI_ASSOC))
        while($rowFID= $resultFID->fetch_array(MYSQLI_ASSOC))
		{
	?>
	<li><a href="<?php echo "{$rowFID['link']}"; ?><?php echo "{$rowFID['title']}"; ?>" class="iframe-link" onclick="javascript:pageTracker._trackPageview('FOLDER/<?php echo "{$rowFID['title']}"; ?>'); "><?php echo "{$rowFID['image']}"; ?></a>
	<a href="<?php echo "{$rowFID['link']}"; ?><?php echo "{$rowFID['title']}"; ?>" class="iframe-link" onclick="javascript:pageTracker._trackPageview('FOLDER/<?php echo "{$rowFID['title']}"; ?>'); "><?php echo "{$rowFID['title']}"; ?></a></li>
	<?php
		}
	?>
	<?php }; ?>
<!-- END FOLDER -->

<!-- CALENDAR -->
	<?php if ($row['calid'] != ''){ ?>
	<?php
		$typeCID    = $row['calid'];
		$queryCID  = "SELECT `int1`, `title`, `date` FROM calendar WHERE `int1` = '$typeCID'";
		$resultCID = mysqli_query($connectionPool[$record['dbconnName']]['connection'],$queryCID);

		//while($rowCID = $resultCID->fetch_array(MYSQLI_ASSOC))
        while($rowCID = $resultCID->fetch_array(MYSQLI_ASSOC))
		{
	?>
	<li><a href="../modules/events-single.php?choice=<?php echo "{$rowCID['int1']}"; ?>&conn=<?php echo $record['dbconnName']; ?>&conn=<?php echo $record['dbconnName']; ?>" class="iframe-link"><i class="fa fa-calendar-o" aria-hidden="true"></i></a>
	<a href="../modules/events-single.php?choice=<?php echo "{$rowCID['int1']}";?>&conn=<?php echo $record['dbconnName']; ?>&conn=<?php echo $record['dbconnName']; ?>" class="iframe-link"><?php echo "{$rowCID['title']}"; ?> <?php echo "{$rowCID['date']}"; ?></a></li>
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
		$result = mysqli_query($connectionPool[$record['dbconnName']]['connection'], $query);

		while($row1 = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
            <li><a href="../download-documents-embed.php?table=chalkboard&mid=<?php echo "{$row['int1']}"; ?>&date=<?php echo date('Y-m-d', strtotime($row['created_date'])); ?>&d1=Y&conn=<?php echo $record['dbconnName']; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$row1['id']}"; ?>')"><?php include('../icon-links-embed.php'); ?></a>
                <a href="../download-documents-embed.php?table=chalkboard&mid=<?php echo "{$row['int1']}"; ?>&date=<?php echo date('Y-m-d', strtotime($row['created_date'])); ?>&d1=Y&conn=<?php echo $record['dbconnName']; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$row1['id']}"; ?>')">Download&nbsp;<?php echo "{$row1['title']}"; ?></a></li>
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
		$result = mysqli_query($connectionPool[$record['dbconnName']]['connection'], $query);

		while($row1 = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
            <li><a href="../download-documents-embed.php?table=chalkboard&mid=<?php echo "{$row['int1']}"; ?>&date=<?php echo date('Y-m-d', strtotime($row['created_date'])); ?>&d2=Y&conn=<?php echo $record['dbconnName']; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$row1['id']}"; ?>')"><?php include('../icon-links-embed.php'); ?></a>
                <a href="../download-documents-embed.php?table=chalkboard&mid=<?php echo "{$row['int1']}"; ?>&date=<?php echo date('Y-m-d', strtotime($row['created_date'])); ?>&d2=Y&conn=<?php echo $record['dbconnName']; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$row1['id']}"; ?>')">Download&nbsp;<?php echo "{$row1['title']}"; ?></a></li>
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
		$result = mysqli_query($connectionPool[$record['dbconnName']]['connection'], $query);

		while($row1 = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
            <li><a href="../download-documents-embed.php?table=chalkboard&mid=<?php echo "{$row['int1']}"; ?>&date=<?php echo date('Y-m-d', strtotime($row['created_date'])); ?>&d3=Y&conn=<?php echo $record['dbconnName']; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$row1['id']}"; ?>')"><?php include('../icon-links-embed.php'); ?></a>
                <a href="../download-documents-embed.php?table=chalkboard&mid=<?php echo "{$row['int1']}"; ?>&date=<?php echo date('Y-m-d', strtotime($row['created_date'])); ?>&d3=Y&conn=<?php echo $record['dbconnName']; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$row1['id']}"; ?>')">Download&nbsp;<?php echo "{$row1['title']}"; ?></a></li>
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
		$result = mysqli_query($connectionPool[$record['dbconnName']]['connection'], $query);

		while($row1 = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
            <div align="center">
                <a href="../download-documents-mini.php?id=<?php echo "{$row1['id']}"; ?>&docdate=<?php echo "{$row1['docdate']}"; ?>&size=<?php echo "{$row1['size']}"; ?>&conn=<?php echo $record['dbconnName']; ?>" class="iframe-link" >
                    <img src="../download-documents-mini.php?id=<?php echo "{$row1['id']}"; ?>&docdate=<?php echo "{$row1['docdate']}"; ?>&size=<?php echo "{$row1['size']}"; ?>&conn=<?php echo $record['dbconnName']; ?>" alt="Picture of <?php echo "{$row1['title']}"; ?>" title="Picture of <?php echo "{$row1['title']}"; ?>" class="newsboard-post-image-1">
                </a>
            </div>
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
		$result = mysqli_query($connectionPool[$record['dbconnName']]['connection'], $query);

		while($row1 = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
            <div align="center">
                <a href="../download-documents-mini.php?id=<?php echo "{$row1['id']}"; ?>&docdate=<?php echo "{$row1['docdate']}"; ?>&size=<?php echo "{$row1['size']}"; ?>&conn=<?php echo $record['dbconnName']; ?>" class="iframe-link">
                    <img src="../download-documents-mini.php?id=<?php echo "{$row1['id']}"; ?>&docdate=<?php echo "{$row1['docdate']}"; ?>&size=<?php echo "{$row1['size']}"; ?>&conn=<?php echo $record['dbconnName']; ?>" alt="Picture of <?php echo "{$row1['title']}"; ?>" title="Picture of <?php echo "{$row1['title']}"; ?>" class="newsboard-post-image-2">
                </a>
            </div>
	<?php
		}
	?>
      </div>
      <div class="small-12 medium-6 columns">
	<?php
		$type    = $row['pic3'];
		$query  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$result = mysqli_query($connectionPool[$record['dbconnName']]['connection'], $query);

		while($row1 = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
            <div align="center">
                <a href="../download-documents-mini.php?id=<?php echo "{$row1['id']}"; ?>&docdate=<?php echo "{$row1['docdate']}"; ?>&size=<?php echo "{$row1['size']}"; ?>&conn=<?php echo $record['dbconnName']; ?>" class="iframe-link" >
                    <img src="../download-documents-mini.php?id=<?php echo "{$row1['id']}"; ?>&docdate=<?php echo "{$row1['docdate']}"; ?>&size=<?php echo "{$row1['size']}"; ?>&conn=<?php echo $record['dbconnName']; ?>" alt="Picture of <?php echo "{$row1['title']}"; ?>" title="Picture of <?php echo "{$row1['title']}"; ?>" class="newsboard-post-image-3">
                </a>
            </div>
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
		$result = mysqli_query($connectionPool[$record['dbconnName']]['connection'], $query);

		while($row1 = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
            <div class="newsboard-post-image-twins-1">
                <a href="../download-documents-mini.php?id=<?php echo "{$row1['id']}"; ?>&docdate=<?php echo "{$row1['docdate']}"; ?>&size=<?php echo "{$row1['size']}"; ?>&conn=<?php echo $record['dbconnName']; ?>" class="iframe-link" >
                    <img src="../download-documents-mini.php?id=<?php echo "{$row1['id']}"; ?>&docdate=<?php echo "{$row1['docdate']}"; ?>&size=<?php echo "{$row1['size']}"; ?>&conn=<?php echo $record['dbconnName']; ?>" alt="<?php echo "{$row1['title']}"; ?>" title="<?php echo "{$row1['title']}"; ?>"></a></div>
	<?php
		}
	?>
      </div>
      <div class="small-12 medium-6 columns">
	<?php
		$type    = $row['pic3'];
		$query  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$result = mysqli_query($connectionPool[$record['dbconnName']]['connection'], $query);

		while($row1 = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
            <div class="newsboard-post-image-twins-2">
                <a href="../download-documents-mini.php?id=<?php echo "{$row1['id']}"; ?>&docdate=<?php echo "{$row1['docdate']}"; ?>&size=<?php echo "{$row1['size']}"; ?>&conn=<?php echo $record['dbconnName']; ?>" class="iframe-link" >
                    <img src="../download-documents-mini.php?id=<?php echo "{$row1['id']}"; ?>&docdate=<?php echo "{$row1['docdate']}"; ?>&size=<?php echo "{$row1['size']}"; ?>&conn=<?php echo $record['dbconnName']; ?>" alt="<?php echo "{$row1['title']}"; ?>" title="<?php echo "{$row1['title']}"; ?>"></a></div>
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
		$result = mysqli_query($connectionPool[$record['dbconnName']]['connection'], $query);

		while($row1 = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
            <div align="center">
                <a href="../download-documents-mini.php?id=<?php echo "{$row1['id']}"; ?>&docdate=<?php echo "{$row1['docdate']}"; ?>&size=<?php echo "{$row1['size']}"; ?>&conn=<?php echo $record['dbconnName']; ?>" class="iframe-link" >
                    <img src="../download-documents-mini.php?id=<?php echo "{$row1['id']}"; ?>&docdate=<?php echo "{$row1['docdate']}"; ?>&size=<?php echo "{$row1['size']}"; ?>&conn=<?php echo $record['dbconnName']; ?>" alt="Picture of <?php echo "{$row1['title']}"; ?>" title="Picture of <?php echo "{$row1['title']}"; ?>" class="newsboard-post-image-1">
                </a>
            </div>
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
        }
    }

?>
