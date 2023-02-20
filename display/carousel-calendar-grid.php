<?php
$maName = '';
foreach ($connectionPool as $name => $connDetails) {
    if ($connDetails['master'] === true) {
        $maName = $name;
    }
}

$countCALCOUNT = 0;
$queryCAL = "SELECT count(*) as `calCOUNT` FROM `calendar` WHERE `date` BETWEEN CURDATE() AND CURRENT_DATE() + INTERVAL 2 DAY";
foreach ($connectionPool as $connName => $configuration) {
    $resultCALARRAY = mysqli_query($configuration['connection'],$queryCAL);
    $data = $resultCALARRAY ->fetch_array(MYSQLI_ASSOC);
    $countCALCOUNT += $data['calCOUNT'];

}
?>

<?php if ($countCALCOUNT >= 1) { ?>

<!-- Calendar Grid Setup -->
                <div>
                    <div class="large-4 columns">
                        <div class="slider-icon center">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="large-8 columns mvix-overflow-container-calendar-grid">
                        <div class="information left">
                            <div id="calendar-wrap">
                                <div id="calendar">
                                    <?php
                                        if ($maName != "") { ?>
                                    <p>&nbsp;* indicates events from <?php echo $maName; ?></p>
                                        <?php } ?>
                                    <ul class="days">

<!-- Calendar Grid Today -->

                                        <li class="day">
                                            <div class="weekdays">Today <?php echo (date('M d', strtotime('+ 0 DAY'))); ?></div>
<!-- No Event -->
<?php
$countCAL = 0;
$day1QUERY = "SELECT count(*) as `calCOUNT` FROM `calendar` WHERE `date` = CURRENT_DATE()";
foreach ($connectionPool as $connName => $configuration) {

    $resultCALARRAY = mysqli_query($configuration['connection'],$day1QUERY);

    $data = $resultCALARRAY ->fetch_array(MYSQLI_ASSOC);
    $countCAL  += $data['calCOUNT'];
}
?>
<?php if ($countCAL == 0){ ?>
    <div class="event event__none">
        <div class="event-desc">
            <p style="color: white;">No Events</p>
        </div>
    </div>
    <!-- No Event -->
<?php } else {
	$query  = "SELECT `int1`, `event`, `stime`, `title` FROM `calendar` WHERE `date` = CURRENT_DATE() ORDER BY `stime` LIMIT 5";
    $dataArray = array();
    foreach ($connectionPool as $connName => $configuration) {

        $result = mysqli_query($configuration['connection'],$query);
        while ($data = $result->fetch_array(MYSQLI_ASSOC)) {
            $dataArray[$data['stime']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
        }
    }
    $limit = 0;
    foreach($dataArray as $recordArray )
    {
        asort($recordArray);
        foreach ($recordArray as $records) {
            foreach($records as $record) {
                if ($limit == 5) {
                    break;
                }
                $row = $record['data'];
                $limit += 1;
?>
        <!-- Event -->
	<div class="event event__<?php echo "{$row['event']}"; ?>">
        <div class="event-desc">
            <p><?php if ($row['stime'] !== '00:00:00'){
                        echo date('g:i a', strtotime($row['stime']));
                    }
                        echo "{$row['title']}";
                        if ($record['master'] === true) { echo "*"; }
            ?></p>
        </div>
	</div>
<?php
	        }
        }
    }
}
?>
<!-- Event -->
                                        </li>
<!-- Calendar Grid Today -->

<!-- Calendar Grid Tomorrow -->
                                        <li class="day">
                                            <div class="weekdays">Tomorrow <?php echo (date('M d', strtotime('+ 1 DAY'))); ?></div>

<!-- No Event -->
<?php
$countCAL = 0;
$day1QUERY = "SELECT count(*) as `calCOUNT` FROM `calendar` WHERE `date` = CURRENT_DATE() + INTERVAL 1 DAY";
foreach ($connectionPool as $connName => $configuration) {
    $resultCALARRAY = mysqli_query($configuration['connection'],$day1QUERY);
    $data = $resultCALARRAY ->fetch_array(MYSQLI_ASSOC);
    $countCAL  += $data['calCOUNT'];
}
?>
<?php if ($countCAL == '0'){ ?>
    <div class="event event__none">
        <div class="event-desc">
            <p style="color: white;">No Events</p>
        </div>
    </div>
    <!-- No Event -->
<?php } else {
	$query  = "SELECT `int1`, `event`, `stime`, `title` FROM `calendar` WHERE `date` = CURRENT_DATE() + INTERVAL 1 DAY ORDER BY `stime` LIMIT 5";
    $dataArray = array();
    foreach ($connectionPool as $connName => $configuration) {

        $result = mysqli_query($configuration['connection'],$query);
        while ($data = $result->fetch_array(MYSQLI_ASSOC)) {
            $dataArray[$data['stime']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
        }
    }
    $limit = 0;
    foreach($dataArray as $recordArray )
    {
        asort($recordArray);
        foreach ($recordArray as $records) {
            foreach($records as $record) {
                if ($limit == 5) {
                    break;
                }
                $row = $record['data'];
                $limit += 1;
?>
        <!-- Event -->
	<div class="event event__<?php echo "{$row['event']}"; ?>">
        <div class="event-desc">
            <p><?php if ($row['stime'] !== '00:00:00'){
                    echo date('g:i a', strtotime($row['stime']));
                }
                echo "{$row['title']}";
                if ($record['master'] === true) { echo "*"; }
                ?></p>
        </div>
	</div>
<?php
	        }
        }
    }
}
?>
<!-- Event -->
                                        </li>
<!-- Calendar Grid Tomorrow -->

<!-- Calendar Grid Day After -->
                                        <li class="day">
                                            <div class="weekdays"><?php echo (date('D M d', strtotime('+ 2 DAY'))); ?></div>

<!-- No Event -->
<?php
$countCAL = 0;
$day1QUERY = "SELECT count(*) as `calCOUNT` FROM `calendar` WHERE `date` = CURRENT_DATE() + INTERVAL 2 DAY";
foreach ($connectionPool as $connName => $configuration) {
    $resultCALARRAY = mysqli_query($configuration['connection'],$day1QUERY);
    $data = $resultCALARRAY ->fetch_array(MYSQLI_ASSOC);
    $countCAL  += $data['calCOUNT'];
}
?>
<?php if ($countCAL == '0'){ ?>
    <div class="event event__none">
        <div class="event-desc">
            <p style="color: white;">No Events</p>
        </div>
    </div>
    <!-- No Event -->
<?php } else {

$query  = "SELECT `int1`, `event`, `stime`, `title` FROM `calendar` WHERE `date` = CURRENT_DATE() + INTERVAL 2 DAY ORDER BY `stime` LIMIT 5";
$dataArray = array();
foreach ($connectionPool as $connName => $configuration) {

    $result = mysqli_query($configuration['connection'],$query);
    while ($data = $result->fetch_array(MYSQLI_ASSOC)) {
        $dataArray[$data['stime']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
    }
}
$limit = 0;
foreach($dataArray as $recordArray )
{
    asort($recordArray);
    foreach ($recordArray as $records) {
        foreach($records as $record) {
            if ($limit == 5) {
                break;
            }
            $row = $record['data'];
            $limit += 1;
?>
<!-- Event -->
            <div class="event event__<?php echo "{$row['event']}"; ?>">
                <div class="event-desc">
                    <p><?php if ($row['stime'] !== '00:00:00'){
                            echo date('g:i a', strtotime($row['stime']));
                        }
                        echo "{$row['title']}";
                        if ($record['master'] === true) { echo "*"; }
                        ?></p>
                </div>
            </div>
<?php
	        }
        }
    }
}
?>
<!-- Event -->
                                        </li>
<!-- Calendar Grid Day After -->

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<!-- Calendar Grid Setup -->

<?php } ?>