<?php

	$tabFound=false;
	$maConn=null;

    if (!isset($connectionPool) || $connectionPool == null) {
        $connectionPool[$CommunityName]= array('priority' => 10, 'connection' =>  $conn, 'master' => false, 'primary' => true);
    }

		foreach ($connectionPool as $connName => $configuration) {

			if ($configuration['primary'] == false){
				$maConn = $configuration['connection'];
			}	
		}		

    $queryNAVIGATION  = "SELECT type FROM navigation where owner = 'Y' and type != 'Documents'";
		$resultNAVIGATION = mysqli_query($conn,$queryNAVIGATION);

	while($rowNAVIGATION = $resultNAVIGATION->fetch_array(MYSQLI_ASSOC))
	{

?>

<!-- Section -->

<?php
	$navigation    = $rowNAVIGATION['type'];
    $query  = "SELECT `id` FROM documents INNER JOIN tabs INNER JOIN folders WHERE (documents.aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() AND documents.doctype = '$navigation' AND documents.owner = 'Y') OR (tabs.tabname = '$navigation' AND tabs.owner = 'Y') OR (folders.tabname = '$navigation' AND folders.owner = 'Y') LIMIT 1";
	$result = mysqli_query($conn, $query);
		$row = $result->fetch_array(MYSQLI_ASSOC);
	
	if (empty($row) && !empty($maConn)) {
			$result = mysqli_query($maConn, $query);
			$row = $result->fetch_array(MYSQLI_ASSOC);
			
			$tabFound = empty($row) ? false : true;  
		
	} else {

        $tabFound = empty($row) ? false : true;

    }

	if ($tabFound)
	{
?>
        <div class="nav-section-header">
          <div class="row">
            <div class="small-12 columns"><h3 class="nav-section-title"><?php echo "{$rowNAVIGATION['type']}"; ?></h3></div>
          </div>
        </div>

<!-- Content -->
        <div class="nav-section-container">
          <div class="row">
            <div class="small-12 columns">

<?php
	}
?>

<!-- Documents -->
<?php
	$navigation    = $rowNAVIGATION['type'];
	$query  = "SELECT `id`, type, title, aod, docdate, size FROM documents WHERE doctype = '$navigation' AND owner = 'Y' AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY title";
    $dataArray = array();
    foreach ($connectionPool as $connName => $configuration) {
        $resultARRAY = mysqli_query($configuration['connection'],$query);

        while ($data = $resultARRAY->fetch_array(MYSQLI_ASSOC)) {
            $dataArray[$data['title']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
        }
    }

    ksort($dataArray);
    foreach($dataArray as $recordArray ) {
        ksort($recordArray, 1);
        foreach ($recordArray as $records) {
            foreach($records as $record) {
                $row = $record['data'];


?>
		<ul class="nav-section-links">
		<li><?php include('../icon-links.php'); ?><a href="../download-documents.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&conn=<?php echo $record['dbconnName'];?>&size=<?php echo "{$row['size']}"; ?>" class="nav-section-link" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$row['id']}"; ?>'); "><?php echo "{$row['title']}"; ?></a>
            <?php if ($record['master'] === true) { ?><div class="nav-section-subtext-blue"><br><p>From <?php echo $record['dbconnName']; ?></p></div><?php }; ?>
        </li>
		</ul>
<?php
	        }
        }
    }
?>

<!-- Links -->
<?php
	$navigation    = $rowNAVIGATION['type'];
	$query  = "SELECT `int1`, tabname, title, rednote, image, url, window FROM tabs WHERE tabname = '$navigation' AND owner = 'Y' ORDER BY title";
    $dataArray = array();
    foreach ($connectionPool as $connName => $configuration) {
        $resultARRAY = mysqli_query($configuration['connection'],$query);

        while ($data = $resultARRAY->fetch_array(MYSQLI_ASSOC)) {
            $dataArray[$data['title']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
        }
    }

    ksort($dataArray);
    foreach($dataArray as $recordArray ) {
        ksort($recordArray, 1);
        foreach ($recordArray as $records) {
            foreach($records as $record) {
                $row = $record['data'];

                if ($row['window'] != '') {
                  $link = $row['url'];
                } else {
                  if (strpos($row['url'],'?') === false) {
                    $link = $row['url'] . "?conn=" . $record['dbconnName'];
                  } else {
                    $link = $row['url'] . "&conn=" . $record['dbconnName'];
                  }
                }

?>
		<ul class="nav-section-links">
		<li><a href="<?php echo "{$link}"; ?>" <?php if ($row['window'] !== '') { ?><?php echo "{$row['window']}"; ?><?php }; ?> class="<?php if ($row['window'] == '') { ?>iframe-link<?php }; ?>" onclick="javascript:pageTracker._trackPageview('ColumnLink/<?php echo "{$row['title']}"; ?>'); "><?php echo "{$row['image']}"; ?></a><a href="<?php echo "{$link}"; ?>" <?php if ($row['window'] !== '') { ?><?php echo "{$row['window']}"; ?><?php }; ?> class="nav-section-link <?php if ($row['rednote'] !== ''){ ?>nav-section-subtext-anchor<?php }; ?> <?php if ($row['window'] == '') { ?>iframe-link<?php }; ?>" onclick="javascript:pageTracker._trackPageview('ColumnLink/<?php echo "{$row['title']}"; ?>'); "><?php echo "{$row['title']}"; ?></a><?php if ($row['rednote'] !== '') { ?><div class="nav-section-subtext"><p><?php echo "{$row['rednote']}"; ?></p></div><?php }; ?>
            <?php if ($record['master'] === true) { ?><div class="nav-section-subtext-blue"><br><p>From <?php echo $record['dbconnName']; ?></p></div><?php }; ?>
        </li>
		</ul>
<?php
	            }
            }
        }
?>

<!-- Folders -->
<?php
	$navigation    = $rowNAVIGATION['type'];
	$query  = "SELECT * FROM folders WHERE tabname = '$navigation' AND owner = 'Y' ORDER BY title";
    $dataArray = array();
    foreach ($connectionPool as $connName => $configuration) {
        $resultARRAY = mysqli_query($configuration['connection'],$query);

        while ($data = $resultARRAY->fetch_array(MYSQLI_ASSOC)) {
            $dataArray[$data['title']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
        }
    }

    ksort($dataArray);
    foreach($dataArray as $recordArray ) {
        ksort($recordArray, 1);
        foreach ($recordArray as $records) {
            foreach($records as $record) {
                $row = $record['data'];

                if (strpos($row['link'],'?') === false) {
                    $link = $row['link'] . "?conn=" . $record['dbconnName'];
                } else {
                    $link = $row['link'] . "&conn=" . $record['dbconnName'];
                }
?>
		<ul class="nav-section-links">
		<li>
            <a href="<?php echo "{$row['link']}"; ?><?php echo "{$row['title']}"; ?><?php echo "&conn=" . $record['dbconnName']; ?>" class="iframe-link" onclick="javascript:pageTracker._trackPageview('FOLDER/<?php echo "{$row['title']}"; ?>'); "><?php echo "{$row['image']}"; ?></a>
            <a href="<?php echo "{$row['link']}"; ?><?php echo "{$row['title']}"; ?><?php echo "&conn=" . $record['dbconnName']; ?>" class="nav-section-link <?php if ($row['rednote'] !== '') { ?>nav-section-subtext-anchor<?php }; ?> iframe-link" onclick="javascript:pageTracker._trackPageview('FOLDER/<?php echo "{$row['title']}"; ?>'); "><b><?php echo "{$row['title']}"; ?></b></a><?php if ($row['rednote'] !== '') { ?><div class="nav-section-subtext"><p><?php echo "{$row['rednote']}"; ?></p></div><?php }; ?>
            <?php if ($record['master'] === true) { ?><div class="nav-section-subtext-blue"><br><p>From <?php echo $record['dbconnName']; ?></p></div><?php }; ?>
        </li>
		</ul>
<?php
	        }
        }
    }
?>


<?php
	//$navigation    = $rowNAVIGATION['type'];
  //      $query  = "SELECT `id` FROM documents INNER JOIN tabs INNER JOIN folders WHERE (documents.aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() AND documents.doctype = '$navigation' AND documents.lease = 'Y') OR (tabs.tabname = '$navigation' AND tabs.lease = 'Y') OR (folders.tabname = '$navigation' AND folders.lease = 'Y') LIMIT 1";
  //      $result = mysqli_query($conn, $query);

	//while($row = $result->fetch_array(MYSQLI_ASSOC))
	if ($tabFound)
	{

?>

            </div>
          </div>
        </div>

<?php
	}
?>

<?php

		$tabFound = false;
	}
?>
