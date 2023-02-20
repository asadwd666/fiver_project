<?php
$queryNEWS = "SELECT `headline`, `message`, `digitaldisplaymessage`, `flag`, `pic`, `pic2`, `pic3`, `iframe` FROM `chalkboard` WHERE (`digitaldisplay` = 'Y' AND `eod` >= CURRENT_DATE() AND `pod` <= CURRENT_DATE()) ORDER BY pod DESC ";
$dataArray = array();
foreach ($connectionPool as $connName => $configuration) {
    $resultNEWSARRAY = mysqli_query($configuration['connection'], $queryNEWS);
    while ($data = $resultNEWSARRAY->fetch_array(MYSQLI_ASSOC)) {
        $dataArray[$data['pod']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'connection' => $configuration['connection']);
    }
}
$recCONN = '';
foreach ($dataArray as $recordArray)    {
asort($recordArray);
foreach ($recordArray as $records) {
foreach ($records as $record) {
$rowNEWS = $record['data'];
$recCONN = $record['connection'];
//    $resultNEWS = mysqli_query($conn,$queryNEWS);
//
//	while($rowNEWS = $resultNEWS->fetch_array(MYSQLI_ASSOC))
//	{
?><!-- NEWSBOARD CAROUSEL SLIDE --><!-- Newsboard Article Setup -->
<div>
    <div class="large-4 columns">
        <div class="slider-icon center"><!-- Flag --><?php if ($rowNEWS['flag'] !== 'N'){ ?>
        <div class="mvix-ribbon-wrapper">
            <div class="mvix-ribbon ribbon__<?php echo "{$rowNEWS['flag']}"; ?>">
                <?php if ($rowNEWS['flag'] == 'U') { ?>URGENT!<?php } ?>
                <?php if ($rowNEWS['flag'] == 'M') { ?>Meeting!<?php } ?>
                <?php if ($rowNEWS['flag'] == 'A') { ?>ACTION!<?php } ?>
                <?php if ($rowNEWS['flag'] == 'I') { ?>Important!<?php } ?>
                <?php if ($rowNEWS['flag'] == 'D') { ?>Update!<?php } ?>
                <?php if ($rowNEWS['flag'] == 'S') { ?><i>Social Event</i><?php } ?>
                <?php if ($rowNEWS['flag'] == 'K') { ?>What's new!<?php } ?>
                <?php if ($rowNEWS['flag'] == 'R') { ?><i>Reminder</i><?php } ?>
                <?php if ($rowNEWS['flag'] == 'C') { ?>Construction<?php } ?>
                <?php if ($rowNEWS['flag'] == 'H') { ?>HOT Topic!<?php } ?>
                <?php if ($rowNEWS['flag'] == 'G') { ?>Great News!<?php } ?>
                <?php if ($rowNEWS['flag'] == 'O') { ?>Next Up:<?php } ?>
                <?php if ($rowNEWS['flag'] == 'L') { ?><i>for laughs!</i><?php } ?>
                <?php if ($rowNEWS['flag'] == 'W') { ?>Weather<?php } ?>
            </div>
        </div>
            <?php } ?><!-- Flag -->
            <!-- Icon --><?php if ($rowNEWS['pic'] == '' and $rowNEWS['iframe'] == ''){ ?><i class="fa fa-newspaper-o" aria-hidden="true"></i>
            <?php } ?><!-- Icon --><!-- Photo --><?php if ($rowNEWS['iframe'] == '' and $rowNEWS['pic'] != ''){ ?>
            <div class="newsboard-post-image-solo-display"><?php $type = $rowNEWS['pic'];
                $query = "SELECT `id`, `type`, `docdate`, `size` FROM `documents` WHERE `id` = '$type'";
                $result = mysqli_query($recCONN, $query);
                while ($row = $result->fetch_array(MYSQLI_ASSOC)) { ?>        <img
                    src="../download-documents-display.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>&conn=<?php echo $record['dbconnName']; ?>"
                    style="min-width: 400px; max-width: 525px; min-height: 300px; max-height: 430px"><?php } ?>
            </div>
            <?php } ?><!-- Photo --><!-- iFrame --> <?php if ($rowNEWS['iframe'] != ''){ ?>
            <div class="newsboard-post-image-iframe-display" align="center"
                 style="height: auto; max-height: 475px; max-width: 550px;">            <?php echo "{$rowNEWS['iframe']}"; ?>        </div>
            <?php } ?><!-- iFrame -->                        </div>
    </div>
    <div class="large-8 columns">
        <div class="information left"><!-- Newsboard Headlines --> <h2><?php echo "{$rowNEWS['headline']}"; ?></h2>
            <!-- Newsboard Headlines --><!-- Newsboard Article -->
            <div class="mvix-overflow-container newsboard-article"><?php if ($rowNEWS['digitaldisplaymessage'] == '') { ?><?php echo "{$rowNEWS['message']}"; ?><?php } ?><?php if ($rowNEWS['digitaldisplaymessage'] != '') { ?><?php echo "{$rowNEWS['digitaldisplaymessage']}"; ?><?php } ?></div>
            <!-- Newsboard Article -->                        </div>
    </div>
</div><!-- Newsboard Article Setup --><!-- END NEWSBOARD CAROUSEL SLIDE --><!-- PHOTO CAROUSEL SLIDE --><?php if ($rowNEWS['pic2'] != '' or $rowNEWS['pic3'] != ''){ ?><!-- Newsboard Article Setup -->
<div>
    <div class="large-4 columns">
        <div class="slider-icon center"><!-- Flag --><?php if ($rowNEWS['flag'] !== 'N'){ ?>
            <div class="mvix-ribbon-wrapper">
                <div class="mvix-ribbon ribbon__<?php echo "{$rowNEWS['flag']}"; ?>"><?php if ($rowNEWS['flag'] == 'U') { ?>URGENT!<?php } ?><?php if ($rowNEWS['flag'] == 'M') { ?>Meeting!<?php } ?><?php if ($rowNEWS['flag'] == 'A') { ?>ACTION!<?php } ?><?php if ($rowNEWS['flag'] == 'I') { ?>Important!<?php } ?><?php if ($rowNEWS['flag'] == 'D') { ?>Update!<?php } ?><?php if ($rowNEWS['flag'] == 'S') { ?>
                        <i>Social
                            Event</i><?php } ?><?php if ($rowNEWS['flag'] == 'K') { ?>What's new!<?php } ?><?php if ($rowNEWS['flag'] == 'R') { ?>
                        <i>Reminder</i><?php } ?><?php if ($rowNEWS['flag'] == 'C') { ?>Construction<?php } ?><?php if ($rowNEWS['flag'] == 'H') { ?>HOT Topic!<?php } ?><?php if ($rowNEWS['flag'] == 'G') { ?>Great News!<?php } ?><?php if ($rowNEWS['flag'] == 'O') { ?>Next Up:<?php } ?><?php if ($rowNEWS['flag'] == 'L') { ?>
                        <i>for laughs!</i><?php } ?><?php if ($rowNEWS['flag'] == 'W') { ?>Weather<?php } ?>
                </div>
            </div><?php } ?><!-- Flag --><!-- Icon --><i class="fa fa-camera" aria-hidden="true"></i><!-- Icon -->
        </div>
    </div>
    <div class="large-8 columns">
        <div class="information left"><!-- Newsboard Headlines --> <h2>
                Pictures: <?php echo "{$rowNEWS['headline']}"; ?></h2><!-- Newsboard Headlines -->
            <!-- Newsboard Article -->
            <div class="mvix-overflow-container newsboard-article">
                <!-- Pic 2 Center Only --><?php if ($rowNEWS['pic'] == '' and $rowNEWS['pic2'] != '' and $rowNEWS['pic3'] == ''){ ?>
                <div align="center"><?php $type = $rowNEWS['pic2'];
                    $query = "SELECT `id`, `type`, `docdate`, `size` FROM `documents` WHERE `id` = '$type'";
                    $result = mysqli_query($recCONN, $query);
                    while ($row = $result->fetch_array(MYSQLI_ASSOC)) { ?>        <img
                        src="../download-documents-display.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>&conn=<?php echo $record['dbconnName']; ?>"
                        style="max-height: 370px; width: auto; border: 15px solid white; border-radius: 12px; box-shadow: 5px 5px 6px 1px #000000; outline: 1px solid transparent; background: white;"><?php } ?>
                </div>
                <?php } ?><!-- Pic 3 Center Only --><?php if ($rowNEWS['pic'] == '' and $rowNEWS['pic2'] == '' and $rowNEWS['pic3'] != ''){ ?>
                <div align="center"><?php $type = $rowNEWS['pic3'];
                    $query = "SELECT `id`, `type`, `docdate`, `size` FROM `documents` WHERE `id` = '$type'";
                    $result = mysqli_query($recCONN, $query);
                    while ($row = $result->fetch_array(MYSQLI_ASSOC)) { ?>        <img
                        src="../download-documents-display.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>&conn=<?php echo $record['dbconnName']; ?>"
                        style="max-height: 370px; width: auto; border: 15px solid white; border-radius: 12px; box-shadow: 5px 5px 6px 1px #000000; outline: 1px solid transparent; background: white;"><?php } ?>
                </div>
                <?php } ?><!-- Pic 1 Right and 2 Center --><?php if ($rowNEWS['pic'] != '' and $rowNEWS['pic2'] != '' and $rowNEWS['pic3'] == ''){ ?>
                <div align="center"><?php $type = $rowNEWS['pic2'];
                    $query = "SELECT `id`, `type`, `docdate`, `size` FROM `documents` WHERE `id` = '$type'";
                    $result = mysqli_query($recCONN, $query);
                    while ($row = $result->fetch_array(MYSQLI_ASSOC)) { ?>        <img
                        src="../download-documents-display.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>&conn=<?php echo $record['dbconnName']; ?>"
                        style="max-height: 370px; width: auto; border: 15px solid white; border-radius: 12px; box-shadow: 5px 5px 6px 1px #000000; outline: 1px solid transparent; background: white;"><?php } ?>
                </div>
                <?php } ?><!-- Pic 1 Right and 3 Center --><?php if ($rowNEWS['pic'] != '' and $rowNEWS['pic2'] == '' and $rowNEWS['pic3'] != ''){ ?>
                <div align="center"><?php $type = $rowNEWS['pic3'];
                    $query = "SELECT `id`, `type`, `docdate`, `size` FROM `documents` WHERE `id` = '$type'";
                    $result = mysqli_query($recCONN, $query);
                    while ($row = $result->fetch_array(MYSQLI_ASSOC)) { ?>        <img
                        src="../download-documents-display.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>&conn=<?php echo $record['dbconnName']; ?>"
                        style="max-height: 370px; width: auto; border: 15px solid white; border-radius: 12px; box-shadow: 5px 5px 6px 1px #000000; outline: 1px solid transparent; background: white;"><?php } ?>
                </div>
                <?php } ?><!-- Pic 2 and 3 --><?php if ($rowNEWS['pic'] != '' and $rowNEWS['pic2'] != '' and $rowNEWS['pic3'] != ''){ ?>
                <div class="large-6 columns" align="right">
                    <div class="newsboard-post-image-left-display-vertical"><?php $type = $rowNEWS['pic2'];
                        $query = "SELECT `id`, `type`, `docdate`, `size` FROM `documents` WHERE `id` = '$type'";
                        $result = mysqli_query($recCONN, $query);
                        while ($row = $result->fetch_array(MYSQLI_ASSOC)) { ?>        <img
                            src="../download-documents-display.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>&conn=<?php echo $record['dbconnName']; ?>"
                            style="max-width: 425px; max-height: 370px; width: auto; border: 15px solid white; border-radius: 12px; box-shadow: 5px 5px 6px 1px #000000; outline: 1px solid transparent; background: white;"><?php } ?>
                    </div>
                </div>
                <div class="large-6 columns" align="left">
                    <div class="newsboard-post-image-right-display-vertical"><?php $type = $rowNEWS['pic3'];
                        $query = "SELECT `id`, `type`, `docdate`, `size` FROM `documents` WHERE `id` = '$type'";
                        $result = mysqli_query($recCONN, $query);
                        while ($row = $result->fetch_array(MYSQLI_ASSOC)) { ?>        <img
                            src="../download-documents-display.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>&conn=<?php echo $record['dbconnName']; ?>"
                            style="max-width: 425px; max-height: 370px; width: auto; border: 15px solid white; border-radius: 12px; box-shadow: 5px 5px 6px 1px #000000; outline: 1px solid transparent; background: white;"><?php } ?>
                    </div>
                </div>
                <?php } ?><!-- Twin Style --><?php if ($rowNEWS['pic'] == '' and $rowNEWS['pic2'] != '' and $rowNEWS['pic3'] != '') { ?>
                    <div class="newsboard-post-image-left-twin-display-vertical"><?php $type = $rowNEWS['pic3'];
                        $query = "SELECT `id`, `type`, `docdate`, `size` FROM `documents` WHERE `id` = '$type'";
                        $result = mysqli_query($recCONN, $query);
                        while ($row = $result->fetch_array(MYSQLI_ASSOC)) { ?>        <img
                            src="../download-documents-display.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>&conn=<?php echo $record['dbconnName']; ?>"
                            style="max-width: 425px; max-height: 370px; width: auto; border: 15px solid white; border-radius: 12px; box-shadow: 5px 5px 6px 1px #000000; outline: 1px solid transparent; background: white;"><?php } ?>
                    </div>
                    <div class="newsboard-post-image-right-twin-display-vertical"><?php $type = $rowNEWS['pic2'];
                    $query = "SELECT `id`, `type`, `docdate`, `size` FROM `documents` WHERE `id` = '$type'";
                    $result = mysqli_query($recCONN, $query);
                    while ($row = $result->fetch_array(MYSQLI_ASSOC)) { ?>        <img
                        src="../download-documents-display.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>&conn=<?php echo $record['dbconnName']; ?>"
                        style="max-width: 425px; max-height: 370px; width: auto; border: 15px solid white; border-radius: 12px; box-shadow: 5px 5px 6px 1px #000000; outline: 1px solid transparent; background: white;"><?php } ?>
                    </div><?php } ?></div><!-- Newsboard Article -->                        </div>
    </div>
</div><!-- Newsboard Article Setup --><?php } ?><!-- END PHOTO CAROUSEL SLIDE --><?php }
}
} ?>