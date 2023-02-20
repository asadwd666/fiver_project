<!-- Newsboard Banner Setup-->
  <div class="newsboard-container newsboard-container__banner">
    <div class="row">
      <div class="small-12 columns">
<?php

    if (!isset($connectionPool) || $connectionPool == null) {
        $connectionPool[$CommunityName]= array('priority' => 10, 'connection' =>  $conn, 'master' => false, 'primary' => true);
    }

    foreach ($connectionPool as $connName => $connInfo) {
        if ($connInfo['priority'] == 10) {
            $headingConn = $connInfo['connection'];
        }
    }

    $queryMB  = "SELECT realtor FROM meetingbox WHERE realtor = 'N'";
    $resultMB = mysqli_query($headingConn,$queryMB);

	while($rowMB = $resultMB->fetch_array(MYSQLI_ASSOC))
	{
?>
	<h2 class="newsboard-title"><div align="center">Newsboard</div></h2>
<?php
	}
?>

<?php
	$queryMB  = "SELECT * FROM meetingbox WHERE realtor = 'Y'";
	$resultMB = mysqli_query($headingConn,$queryMB);

	while($rowMB = $resultMB->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- Newsboard Banner Content-->
	<?php if ($rowMB['line1'] !== ''){ ?><h3 class="newsboard-subtitle newsboard-subtitle__banner"><?php echo "{$rowMB['line1']}"; ?></h3><?php }; ?>
	<?php if ($rowMB['line2'] !== ''){ ?><p><?php echo "{$rowMB['line2']}"; ?></p><?php }; ?>
	<?php if ($rowMB['line3'] !== ''){ ?><p><?php echo "{$rowMB['line3']}"; ?></p><?php }; ?>
<?php if ($rowMB['calid'] !== '' OR $rowMB['docid'] !== '' OR $rowMB['url'] !== '' OR $rowMB['email'] !== ''){ ?>
	<ul class="newsboard-hoa-meeting-links">
<?php if ($rowMB['calid'] !== ''){ ?>
<?php
	$type    = $rowMB['calid'];
	$query  = "SELECT * FROM calendar WHERE `int1` = '$type'";
	$result = mysqli_query($headingConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
		<li><a href="../modules/events-single.php?choice=<?php echo "{$row['int1']}"; ?>" class="iframe-link">Link to Event</a></li>
<?php
	}
?>
<?php }; ?>

<?php if ($rowMB['docid'] !== ''){ ?>
<?php
	$type    = $rowMB['docid'];
	$queryDOC  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
	$resultDOC = mysqli_query($headingConn,$queryDOC);

	while($rowDOC = $resultDOC->fetch_array(MYSQLI_ASSOC))
	{
?>

		<li><a href="../download-documents.php?id=<?php echo "{$rowDOC['id']}"; ?>&docdate=<?php echo "{$rowDOC['docdate']}"; ?>&size=<?php echo "{$rowDOC['size']}"; ?>" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$rowDOC['id']}"; ?>');" target="_blank">Link to Document <?php echo "{$rowDOC['title']}"; ?></a></li>

<?php
	}
?>
<?php }; ?>

<?php if ($rowMB['url'] !== ''){ ?>
		<li><a href="<?php echo "{$rowMB['url']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('URL/<?php echo "{$rowMB['url']}"; ?>'); ">Link to Website</a></li>
<?php }; ?>

<?php if ($rowMB['email'] !== ''){ ?>
		<li><a href="mailto:<?php echo "{$rowMB['email']}"; ?>" onclick="javascript:pageTracker._trackPageview('EMAIL/<?php echo "{$rowMB['email']}"; ?>'); ">Link to Email</a></li>
<?php }; ?>

	</ul>
<?php }; ?>
<?php
	}
?>
<!-- Newsboard Banner Setup-->
      </div>
    </div>
  </div>
