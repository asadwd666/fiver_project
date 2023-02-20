<?php

$maName = '';
foreach ($connectionPool as $name => $connDetails) {
    if ($connDetails['master'] === true) {
        $maName = $name;
    }
}

$countCALCOUNT30 = 0;
$queryCALCOUNT30 = "SELECT count(*) as `calCOUNT` FROM `calendar` WHERE `date` BETWEEN CURDATE() AND CURRENT_DATE() + INTERVAL 45 DAY";
$countCALCOUNT5 = 0;
$queryCALCOUNT5 = "SELECT count(*) as `calCOUNT` FROM `calendar` WHERE `date` BETWEEN CURDATE() AND CURRENT_DATE() + INTERVAL 4 DAY";
foreach ($connectionPool as $connName => $configuration) {
    $resultCALARRAY = mysqli_query($configuration['connection'],$queryCALCOUNT30);
    $data = $resultCALARRAY ->fetch_array(MYSQLI_ASSOC);
    $countCALCOUNT30  += $data['calCOUNT'];
}


foreach ($connectionPool as $connName => $configuration) {
    $resultCALARRAY = mysqli_query($configuration['connection'],$queryCALCOUNT5);
    $data = $resultCALARRAY ->fetch_array(MYSQLI_ASSOC);
    $countCALCOUNT5  += $data['calCOUNT'];
}

$countCALCOUNT5 = 0;

if ($countCALCOUNT5 == 0 AND $countCALCOUNT30 >= 1) { ?>

<!-- Calendar List Setup -->
                <div>
             <!--        <div class="large-4 columns">
                        <div class="slider-icon center">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        </div>
                    </div> -->
                    <div class="large-12 columns mvix-overflow-container-calendar-grid">
                        <div class="information left">
                            <h2>Upcoming Events</h2>
                            <p>Up to five upcoming events are shown. A full calendar is also available on the website.
                            <?php
                                if ($maName != "") {
                            ?>
                            <br>&nbsp;* indicates events from <?php echo $maName; ?>
                                <?php } ?></p>
                            <div class="calendar-container-list-view">

<!-- Calendar List -->
<?php
	$query  = "SELECT `event`, `date`, `stime`, `title` FROM `calendar` WHERE `date` BETWEEN CURDATE() + INTERVAL 2 DAY AND CURRENT_DATE() + INTERVAL 45 DAY ORDER BY `date`, `stime` LIMIT 5";
    $dataArray = array();
    foreach ($connectionPool as $connName => $configuration) {

        $result = mysqli_query($configuration['connection'],$query);
        while ($data = $result->fetch_array(MYSQLI_ASSOC)) {
            $dataArray[$data['date']][strtotime($data['stime'])][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
        }
    }

    $limit = 0;
    foreach($dataArray as $recordArray )
    {
        ksort($recordArray);
        foreach ($recordArray as $records) {
            ksort($records);
            foreach($records as $recordt) {
                foreach($recordt as $record) {
                    if ($limit == 5) {
                        break;
                    }
                    $row = $record['data'];
                    $limit += 1;
?>
                                <div class="event-title">
                                    <p>
                                        <i class="event event__<?php echo "{$row['event']}"; ?>" aria-hidden="true"></i>
                                        <?php echo date('D M d', strtotime($row['date'])); ?>: <?php if ($row['stime'] !== '00:00:00'){ ?><?php echo date('g:i a', strtotime($row['stime'])); ?><?php }; ?>
                                        <?php echo "{$row['title']}"; ?>
                                        <?php if ($record['master'] === true) { echo "*"; } ?>

                                    </p>
                                </div>
<?php
	            }
            }
        }
    }

?>
<!-- Calendar List -->

                            </div>
                        </div>
                    </div>
                </div>
<!-- Calendar List Setup -->

<?php } ?>