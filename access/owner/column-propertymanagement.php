<?php
    if (!isset($connectionPool) || $connectionPool == null) {
        $connectionPool[$CommunityName]= array('priority' => 10, 'connection' =>  $conn, 'master' => false, 'primary' => true);
    }
?>
<!-- Property Management Setup -->
      <div class="nav-contact-container">

<!-- Property Management Information -->

<?php

    $dataArray = array();
    $query  = "SELECT * FROM utilities WHERE category = 'Manager' ORDER BY company";
    foreach ($connectionPool as $connName => $configuration) {
        $resultARRAY = mysqli_query($configuration['connection'],$query);

        while ($data = $resultARRAY->fetch_array(MYSQLI_ASSOC)) {
            $dataArray[$data['title']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master'],'primary' => $configuration['primary']);
        }
    }

    foreach($dataArray as $recordArray ) {
        asort($recordArray);
        foreach ($recordArray as $records) {
            foreach($records as $record) {
                $row = $record['data'];

                if ($record['primary'] === true) {

?>
        <div class="row">
            <?php if ($row['name'] !== '' AND $row['name'] !== 'none.gif'){ ?>
                <div id="docs" class="property-manager__fullwidth small-12 large-12 columns" style="padding-bottom: 10px; padding-top: 5px;">
                    <a href="<?php echo "{$row['web']}"; ?>" onclick="javascript:pageTracker._trackPageview('Utility/<?php echo "{$row['web']}"; ?>');" target="_blank"><img src="../download-utilities.php?id=<?php echo "{$row['id']}"; ?>" alt="<?php echo "{$row['company']}"; ?> Logo"></a>
                </div>
            <?php //}
                }?>

		  <!-- apply property-manager__fullwidth here as well -->
            <div class="property-manager__fullwidth small-12 large-12 columns">

<?php if ($row['company'] !== ''){ ?><p class="nav-property-manager"><b><?php echo "{$row['company']}"; ?></b></p><?php }; ?>
<?php if ($row['contact'] !== ''){ ?><p class="nav-property-manager"><?php echo "{$row['contact']}"; ?></p><?php }; ?>
<?php if ($row['phone1'] !== ''){ ?><p class="nav-property-manager"><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row['phone1']); ?>"><?php echo "{$row['phone1']}"; ?></a></p><?php }; ?>
<?php if ($row['phone2'] !== ''){ ?><p class="nav-property-manager"><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row['phone2']); ?>"><?php echo "{$row['phone2']}"; ?></a></p><?php }; ?>
<?php if ($row['phone3'] !== ''){ ?><p class="nav-property-manager"><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row['phone3']); ?>"><?php echo "{$row['phone3']}"; ?></a></p><?php }; ?>
<?php if ($row['phone4'] !== ''){ ?><p class="nav-property-manager"><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row['phone4']); ?>"><?php echo "{$row['phone4']}"; ?></a></p><?php }; ?>

<p class="nav-property-manager">
<?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>?Subject=<?php echo "{$CommunityName}"; ?>" onclick="javascript:pageTracker._trackPageview('Email/<?php echo "{$row['email']}"; ?>'); "><?php echo "{$row['email']}"; ?></a><br><?php }; ?>
<?php if ($row['web'] !== ''){ ?><a href="<?php echo "{$row['web']}"; ?>" onclick="javascript:pageTracker._trackPageview('Utility/<?php echo "{$row['web']}"; ?>');" target="_blank">Link&nbsp;to&nbsp;Website</a><br><?php }; ?>
<?php if ($row['comments'] !== ''){ ?><a href="../modules/utilities-select.php?choice=Manager" class="iframe-link">More&nbsp;Information</a><?php }; ?>
</p>

            </div>

        </div>

<?php
                }
	        }
        }
    }
?>

<!-- Documents & Links Setup -->

          <div class="row">
            <div class="small-12 columns">

<!-- Documents -->
<?php
    $dataArray = array();
	$navigation    = $rowNAVIGATION['type'];
    $query  = "SELECT `id`, type, title, aod, docdate, size FROM documents WHERE doctype = 'PropertyManager' AND owner = 'Y' AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY title";
    foreach ($connectionPool as $connName => $configuration) {
        $resultARRAY = mysqli_query($configuration['connection'],$query);

        while ($data = $resultARRAY->fetch_array(MYSQLI_ASSOC)) {
            $dataArray[$data['title']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
        }
    }

    foreach($dataArray as $recordArray ) {
        asort($recordArray);
        foreach ($recordArray as $records) {
            foreach($records as $record) {
                $row = $record['data'];

?>
		<ul class="nav-section-links">
		<li style="margin-left: -14px;"><?php include('../icon-links.php'); ?><a href="../download-documents.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>&conn=<?php echo "{$connName}";?>" target="_blank" class="nav-section-link" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$row['id']}"; ?>'); "><?php echo "{$row['title']}"; ?></a></li>
		</ul>
<?php
	        }
        }
    }
?>

<!-- Links -->
<?php

    $dataArray = array();
    $navigation    = $rowNAVIGATION['type'];
    $query  = "SELECT `int1`, tabname, title, rednote, image, url, window FROM tabs WHERE tabname = 'PropertyManager' AND owner = 'Y' ORDER BY title";
    foreach ($connectionPool as $connName => $configuration) {
        $resultARRAY = mysqli_query($configuration['connection'],$query);

        while ($data = $resultARRAY->fetch_array(MYSQLI_ASSOC)) {
            $dataArray[$data['title']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
        }
    }

    foreach($dataArray as $recordArray ) {
        asort($recordArray);
        foreach ($recordArray as $records) {
            foreach($records as $record) {
                $row = $record['data'];
                
                if ($row['window'] != '') {
                     $link = $row['url'];
                 } else {
                     if (strpos($row['url'], '?') === false) {
                         $link = $row['url']. "?conn=" . $record['dbconnName'];
                     } else {
                         $link = $row['url']. "&conn=" . $record['dbconnName'];
                     }
                 }
?>
		<ul class="nav-section-links">
		<li style="margin-left: -14px;"><a href="<?php echo "{$link}"; ?>" <?php if ($row['window'] !== '') { ?><?php echo "{$row['window']}"; ?><?php }; ?> class="<?php if ($row['window'] == '') { ?>iframe-link<?php }; ?>" onclick="javascript:pageTracker._trackPageview('ColumnLink/<?php echo "{$row['title']}"; ?>'); "><?php echo "{$row['image']}"; ?></a><a href="<?php echo "{$link}"; ?>" <?php if ($row['window'] !== '') { ?><?php echo "{$row['window']}"; ?><?php }; ?> class="nav-section-link <?php if ($row['rednote'] !== ''){ ?>nav-section-subtext-anchor<?php }; ?> <?php if ($row['window'] == '') { ?>iframe-link<?php }; ?>" onclick="javascript:pageTracker._trackPageview('ColumnLink/<?php echo "{$row['title']}"; ?>'); "><?php echo "{$row['title']}"; ?></a><?php if ($row['rednote'] !== '') { ?><div class="nav-section-subtext"><p><?php echo "{$row['rednote']}"; ?></p></div><?php }; ?></li>
		</ul>
<?php
	        }
        }
    }
?>

<!-- Folders -->
<?php

    $dataArray = array();
    $navigation    = $rowNAVIGATION['type'];
    $query  = "SELECT * FROM folders WHERE tabname = 'PropertyManager' AND owner = 'Y' ORDER BY title";
    foreach ($connectionPool as $connName => $configuration) {
        $resultARRAY = mysqli_query($configuration['connection'],$query);

        while ($data = $resultARRAY->fetch_array(MYSQLI_ASSOC)) {
            $dataArray[$data['title']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
        }
    }

    foreach($dataArray as $recordArray ) {
        asort($recordArray);
        foreach ($recordArray as $records) {
            foreach($records as $record) {
                $row = $record['data'];
?>
		<ul class="nav-section-links">
		<li style="margin-left: -14px;"><a href="<?php echo "{$row['link']}"; ?><?php echo "{$row['title']}"; ?>" class="iframe-link" onclick="javascript:pageTracker._trackPageview('FOLDER/<?php echo "{$row['title']}"; ?>'); "><?php echo "{$row['image']}"; ?></a><a href="<?php echo "{$row['link']}"; ?><?php echo "{$row['title']}"; ?>" class="nav-section-link <?php if ($row['rednote'] !== '') { ?>nav-section-subtext-anchor<?php }; ?> iframe-link" onclick="javascript:pageTracker._trackPageview('FOLDER/<?php echo "{$row['title']}"; ?>'); "><b><?php echo "{$row['title']}"; ?></b></a><?php if ($row['rednote'] !== '') { ?><div class="nav-section-subtext"><p><?php echo "{$row['rednote']}"; ?></p></div><?php }; ?></li>
		</ul>
<?php
	        }
        }
    }
?>

            </div>
          </div>

<!-- Property Management Setup -->
      </div>
