<?php $queryTABS = "SELECT `int1`, `image` FROM `tabs` WHERE `digitaldisplay` = 'Y'";
$dataArray = array();
foreach ($connectionPool as $connName => $configuration) {
    $resultNEWSARRAY = mysqli_query($configuration['connection'], $queryTABS);
    while ($data = $resultNEWSARRAY->fetch_array(MYSQLI_ASSOC)) {
        $dataArray[$data['pod']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'connection' => $configuration['connection']);
    }
}
$recCONN = '';
foreach ($dataArray

as $recordArray)    {
asort($recordArray);
foreach ($recordArray

as $records) {
foreach ($records

as $record) {
$rowTABS = $record['data'];
$recCONN = $record['connection']; ?><!-- Custom Module Setup -->
<div>
    <div class="large-4 columns">
        <div class="slider-icon center"><?php $custommoduletabid = $rowTABS['int1'];
            $query3RD = "SELECT `int1`, `type`, `theircode`, `iframe`, `pic`, `digitaldisplaymessage` FROM `3rd` WHERE `int1` = $custommoduletabid";
            $result3RD = mysqli_query($recCONN, $query3RD);
            while ($row3RD = $result3RD->fetch_array(MYSQLI_ASSOC))    { ?><!-- Icon --><?php if ($row3RD['pic'] == '' and $row3RD['iframe'] == ''){ ?>
            <?php echo "{$rowTABS['image']}"; ?><?php }; ?><!-- Icon -->
            <!-- Photo --><?php if ($row3RD['iframe'] == '' and $row3RD['pic'] != ''){ ?>
        <div class="newsboard-post-image-solo-display"><?php $type = $row3RD['pic'];
        $query = "SELECT `id`, `type`, `docdate`, `size` FROM `documents` WHERE `id` = '$type'";
        $result = mysqli_query($recCONN, $query);
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) { ?>        <img
            src="../download-documents-display.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>&conn=<?php echo $record['dbconnName']; ?>"
            style="min-width: 400px; max-width: 525px; min-height: 300px; max-height: 430px"><?php } ?>    </div>
            <?php }; ?><!-- Photo --><!-- iFrame --> <?php if ($row3RD['iframe'] != ''){ ?>
            <div class="content-responsive">            <?php echo "{$row3RD['iframe']}"; ?>        </div>
            <?php }; ?><!-- iFrame -->                        </div>
    </div>
    <div class="large-8 columns">
        <div class="information left"><!-- Headlines --><h2><?php echo "{$row3RD['type']}"; ?></h2><!-- Headlines -->
            <!-- Text -->
            <div class="mvix-overflow-container newsboard-article"><?php if ($row3RD['digitaldisplaymessage'] == '') { ?><?php echo "{$row3RD['theircode']}"; ?><?php }; ?><?php if ($row3RD['digitaldisplaymessage'] != '') { ?><?php echo "{$row3RD['digitaldisplaymessage']}"; ?><?php }; ?></div>
            <!-- Text --><?php } ?>                        </div>
    </div>
</div><!-- Custom Module Setup --><?php }
}
} ?>