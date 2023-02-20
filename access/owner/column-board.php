<?php

    if (!isset($connectionPool) || $connectionPool == null) {
        $connectionPool[$CommunityName]= array('priority' => 10, 'connection' =>  $conn, 'master' => false, 'primary' => true);
    }
?>
<!-- Section -->
        <div class="nav-section-header nav-section-header__green">
          <div class="row">
            <div class="small-12 columns"><h3 class="nav-section-title">Board</h3></div>
          </div>
        </div>

<!-- Content -->
        <div class="nav-section-container">
          <div class="row">
            <div class="small-12 columns">

<!-- Documents -->
<?php
	$navigation    = $rowNAVIGATION['type'];
	$query  = "SELECT `id`, type, title, aod, docdate, size FROM documents WHERE doctype = 'DocumentsBoard' AND owner = 'Y' AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY title";

	$dataArray = array();
    foreach ($connectionPool as $connName => $configuration) {
        if ($configuration['primary'] == true) {
            $resultARRAY = mysqli_query($configuration['connection'], $query);

            while ($data = $resultARRAY->fetch_array(MYSQLI_ASSOC)) {
                $dataArray[$data['title']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
            }
        }
    }

    asort($dataArray);
    foreach($dataArray as $recordArray ) {
        ksort($recordArray, 1);
        foreach ($recordArray as $records) {
            foreach($records as $record) {
                $row = $record['data'];
?>
		<ul class="nav-section-links">
		<li><?php include('../icon-links.php'); ?><a href="../download-documents.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>" class="nav-section-link" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$row['id']}"; ?>'); "><?php echo "{$row['title']}"; ?></a></li>
		</ul>
<?php
	        }
        }
    }
?>

<!-- Links -->
<?php
	$navigation    = $rowNAVIGATION['type'];
	$query  = "SELECT `int1`, tabname, title, rednote, image, url, window FROM tabs WHERE tabname = 'DocumentsBoard' AND owner = 'Y' ORDER BY title";

    $dataArray = array();
    foreach ($connectionPool as $connName => $configuration) {
        if ($configuration['primary'] == true) {
            $resultARRAY = mysqli_query($configuration['connection'], $query);

            while ($data = $resultARRAY->fetch_array(MYSQLI_ASSOC)) {
                $dataArray[$data['title']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
            }
        }
    }

    asort($dataArray);
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
		<li><a href="<?php echo "{$link}"; ?>" <?php if ($row['window'] !== '') { ?><?php echo "{$row['window']}"; ?><?php }; ?> class="<?php if ($row['window'] == '') { ?>iframe-link<?php }; ?>" onclick="javascript:pageTracker._trackPageview('ColumnLink/<?php echo "{$row['title']}"; ?>'); "><?php echo "{$row['image']}"; ?></a><a href="<?php echo "{$link}"; ?>" <?php if ($row['window'] !== '') { ?><?php echo "{$row['window']}"; ?><?php }; ?> class="nav-section-link <?php if ($row['rednote'] !== ''){ ?>nav-section-subtext-anchor<?php }; ?> <?php if ($row['window'] == '') { ?>iframe-link<?php }; ?>" onclick="javascript:pageTracker._trackPageview('ColumnLink/<?php echo "{$row['title']}"; ?>'); "><?php echo "{$row['title']}"; ?></a><?php if ($row['rednote'] !== '') { ?><div class="nav-section-subtext"><p><?php echo "{$row['rednote']}"; ?></p></div><?php }; ?></li>
		</ul>
<?php
                }
        }
    }
?>

<!-- Folders -->
<?php
	$navigation    = $rowNAVIGATION['type'];
	$query  = "SELECT * FROM folders WHERE tabname = 'DocumentsBoard' AND owner = 'Y' ORDER BY title";

    $dataArray = array();
    foreach ($connectionPool as $connName => $configuration) {
        if ($configuration['primary'] == true) {
            $resultARRAY = mysqli_query($configuration['connection'], $query);

            while ($data = $resultARRAY->fetch_array(MYSQLI_ASSOC)) {
                $dataArray[$data['title']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
            }
        }
    }

    asort($dataArray);
    foreach($dataArray as $recordArray ) {
        ksort($recordArray, 1);
        foreach ($recordArray as $records) {
            foreach($records as $record) {
                $row = $record['data'];

?>
		<ul class="nav-section-links">
		<li><a href="<?php echo "{$row['link']}"; ?><?php echo "{$row['title']}"; ?>" class="iframe-link" onclick="javascript:pageTracker._trackPageview('FOLDER/<?php echo "{$row['title']}"; ?>'); "><?php echo "{$row['image']}"; ?></a><a href="<?php echo "{$row['link']}"; ?><?php echo "{$row['title']}"; ?>" class="nav-section-link <?php if ($row['rednote'] !== '') { ?>nav-section-subtext-anchor<?php }; ?> iframe-link" onclick="javascript:pageTracker._trackPageview('FOLDER/<?php echo "{$row['title']}"; ?>'); "><b><?php echo "{$row['title']}"; ?></b></a><?php if ($row['rednote'] !== '') { ?><div class="nav-section-subtext"><p><?php echo "{$row['rednote']}"; ?></p></div><?php }; ?></li>
		</ul>
<?php
	        }
        }
    }
?>

            </div>
          </div>
        </div>
