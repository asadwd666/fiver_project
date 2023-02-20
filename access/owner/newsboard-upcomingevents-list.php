<?php
if (!isset($connectionPool) || $connectionPool == null) {
    $connectionPool[$CommunityName]= array('priority' => 10, 'connection' =>  $conn, 'master' => false, 'primary' => true);
}

$query30 = "SELECT count(*) FROM `calendar` WHERE `date` BETWEEN CURDATE() AND CURRENT_DATE() + INTERVAL 45 DAY AND `event` != 'Holiday'";
$query5 = "SELECT count(*) FROM `calendar` WHERE `date` BETWEEN CURDATE() AND CURRENT_DATE() + INTERVAL 4 DAY AND `event` != 'Holiday'";
$countCALCOUNT30 = 0;
$countCALCOUNT5 = 0;
foreach ($connectionPool as $connName => $configuration) {
    $result30 = mysqli_query($configuration['connection'], $query30);
    $row = mysqli_fetch_row($result30);
    $countCALCOUNT30 = ($countCALCOUNT30 > $row[0] ? $countCALCOUNT30 : $row[0]);

    $result5 = mysqli_query($configuration['connection'], $query5);
    $row = mysqli_fetch_row($result5);
    $countCALCOUNT5 = ($countCALCOUNT5 > $row[0] ? $countCALCOUNT5 : $row[0]);
}

$maName = '';
foreach ($connectionPool as $name => $connDetails) {
    if ($connDetails['master'] === true) {
        $maName = $name;
    }
}

//$sqlCALCOUNT30 = mysqli_query($conn,"SELECT count(*) FROM `calendar` WHERE `date` BETWEEN CURDATE() AND CURRENT_DATE() + INTERVAL 45 DAY AND `event` != 'Holiday'") or die(mysqli_error($conn));
////$countCALCOUNT30 = mysql_result($sqlCALCOUNT30, "0");
//$row = mysqli_fetch_row($sqlCALCOUNT30);
//$countCALCOUNT30 = $row[0];
?>

<?php
//$sqlCALCOUNT5 = mysqli_query($conn,"SELECT count(*) FROM `calendar` WHERE `date` BETWEEN CURDATE() AND CURRENT_DATE() + INTERVAL 4 DAY AND `event` != 'Holiday'") or die(mysqli_error($conn));
////$countCALCOUNT5 = mysql_result($sqlCALCOUNT5, "0");
//$row = mysqli_fetch_row($sqlCALCOUNT5);
//$countCALCOUNT5 = $row[0];
?>

<?php if ($countCALCOUNT5 == '0' AND $countCALCOUNT30 >= '1'){ ?>

<!-- Upcoming Events Setup -->
<div class="newsboard-container newsboard-container__upcoming-events">

<!-- Upcoming Events Headline -->
  <div class="row">
    <div class="small-4 columns"><h2 class="newsboard-subtitle">Upcoming Events</h2></div>

<!-- Events Key -->
    <div class="small-8 columns">
        <div id="calendar-wrap">
<header>
	<div class="keys clearfix">
	<ul>
	
  	<?php
        $dataArray = array();
		$query  = "SELECT `event` FROM `calendar` WHERE `event` = 'Other' AND `date` BETWEEN CURDATE() AND CURRENT_DATE() + INTERVAL 45 DAY LIMIT 1";

        foreach ($connectionPool as $connName => $configuration) {
            $resultARRAY = mysqli_query($configuration['connection'],$query);

            while ($data = $resultARRAY->fetch_array(MYSQLI_ASSOC)) {
                $dataArray[$data['title']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
            }
        }

		//$result = mysqli_query($conn, $query);

		//while($row = $result->fetch_array(MYSQLI_ASSOC))
		//{
        if (!empty($dataArray)) {

	?>
	<li class="key key__Other">Other</li>
	<?php
		}
	?>
  	<?php
        $dataArray = array();
		$query  = "SELECT `event` FROM `calendar` WHERE `event` = 'Town' AND `date` BETWEEN CURDATE() AND CURRENT_DATE() + INTERVAL 45 DAY LIMIT 1";
        foreach ($connectionPool as $connName => $configuration) {
            $resultARRAY = mysqli_query($configuration['connection'],$query);

            while ($data = $resultARRAY->fetch_array(MYSQLI_ASSOC)) {
                $dataArray[$data['title']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
            }
        }
		//$result = mysqli_query($conn, $query);

		//while($row = $result->fetch_array(MYSQLI_ASSOC))
		//{
		    if (!empty($dataArray)) {

                ?>
                <li class="key key__Town">Town Events</li>
                <?php
            }
	?>

  	<?php
		$query  = "SELECT `event` FROM `calendar` WHERE `event` = 'Event' AND `date` BETWEEN CURDATE() AND CURRENT_DATE() + INTERVAL 45 DAY LIMIT 1";
		//$result = mysqli_query($conn, $query);

        $dataArray = array();
        foreach ($connectionPool as $connName => $configuration) {
            $resultARRAY = mysqli_query($configuration['connection'],$query);

            while ($data = $resultARRAY->fetch_array(MYSQLI_ASSOC)) {
                $dataArray[$data['title']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
            }
        }

		//while($row = $result->fetch_array(MYSQLI_ASSOC))
		//{
        if (!empty($dataArray)) {
	?>
	<li class="key key__Event">Community Events</li>
	<?php
		}
	?>
  	<?php
		$query  = "SELECT `event` FROM `calendar` WHERE `event` = 'Construction' AND `date` BETWEEN CURDATE() AND CURRENT_DATE() + INTERVAL 45 DAY LIMIT 1";
		//$result = mysqli_query($conn, $query);

		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{

	?>
	<li class="key key__Construction">Construction/Maintenance</li>
	<?php
		}
	?>
  	<?php
		$query  = "SELECT `event` FROM `calendar` WHERE `event` = 'Reserved' AND `date` BETWEEN CURDATE() AND CURRENT_DATE() + INTERVAL 45 DAY LIMIT 1";
		//$result = mysqli_query($conn, $query);
        $dataArray = array();
        foreach ($connectionPool as $connName => $configuration) {
            $resultARRAY = mysqli_query($configuration['connection'],$query);

            while ($data = $resultARRAY->fetch_array(MYSQLI_ASSOC)) {
                $dataArray[$data['title']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
            }
        }

		//while($row = $result->fetch_array(MYSQLI_ASSOC))
		//{
        if (!empty($dataArray)) {
	?>
	<li class="key key__Reserved">Reserved</li>
	<?php
		}
	?>

  	<?php
		$query  = "SELECT `event` FROM `calendar` WHERE `event` = 'Social' AND `date` BETWEEN CURDATE() AND CURRENT_DATE() + INTERVAL 45 DAY LIMIT 1";
		//$result = mysqli_query($conn, $query);
        $dataArray = array();
        foreach ($connectionPool as $connName => $configuration) {
            $resultARRAY = mysqli_query($configuration['connection'],$query);

            while ($data = $resultARRAY->fetch_array(MYSQLI_ASSOC)) {
                $dataArray[$data['title']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
            }
        }

		//while($row = $result->fetch_array(MYSQLI_ASSOC))
		//{
        if (!empty($dataArray)) {

	?>
	<li class="key key__Social">Social Events</li>
	<?php
		}
	?>
	
  	<?php
		$query  = "SELECT `event` FROM `calendar` WHERE `event` = 'Class' AND `date` BETWEEN CURDATE() AND CURRENT_DATE() + INTERVAL 45 DAY LIMIT 1";
		$result = mysqli_query($conn, $query);

		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{

	?>
	<li class="key key__Class">Classes</li>
	<?php
		}
	?>

  	<?php
		$query  = "SELECT `event` FROM `calendar` WHERE `event` = 'Meeting' AND `date` BETWEEN CURDATE() AND CURRENT_DATE() + INTERVAL 45 DAY LIMIT 1";
		//$result = mysqli_query($conn, $query);
        $dataArray = array();
        foreach ($connectionPool as $connName => $configuration) {
            $resultARRAY = mysqli_query($configuration['connection'],$query);

            while ($data = $resultARRAY->fetch_array(MYSQLI_ASSOC)) {
                $dataArray[$data['title']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
            }
        }

        if (!empty($dataArray)) {
		//while($row = $result->fetch_array(MYSQLI_ASSOC))
		//{

	?>
	<li class="key key__Meeting">Meetings</li>
	<?php
		}
	?>

  	<?php
		$query  = "SELECT `event` FROM `calendar` WHERE `event` = 'Elevator' AND `date` BETWEEN CURDATE() AND CURRENT_DATE() + INTERVAL 45 DAY LIMIT 1";
		//$result = mysqli_query($conn, $query);
        $dataArray = array();
        foreach ($connectionPool as $connName => $configuration) {
            $resultARRAY = mysqli_query($configuration['connection'],$query);

            while ($data = $resultARRAY->fetch_array(MYSQLI_ASSOC)) {
                $dataArray[$data['title']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
            }
        }

        if (!empty($dataArray)) {

		//while($row = $result->fetch_array(MYSQLI_ASSOC))
		//{

	?>
	<li class="key key__Elevator">Elevator</li>
	<?php
		}
	?>
  	<?php
		$query  = "SELECT `event` FROM `calendar` WHERE `event` = 'Sport' AND `date` BETWEEN CURDATE() AND CURRENT_DATE() + INTERVAL 45 DAY LIMIT 1";
		$result = mysqli_query($conn, $query);
        $dataArray = array();
        foreach ($connectionPool as $connName => $configuration) {
            $resultARRAY = mysqli_query($configuration['connection'],$query);

            while ($data = $resultARRAY->fetch_array(MYSQLI_ASSOC)) {
                $dataArray[$data['title']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
            }
        }

        if (!empty($dataArray)) {

		//while($row = $result->fetch_array(MYSQLI_ASSOC))
		//{

	?>
	<li class="key key__Sport">Sport</li>
	<?php
		}
	?>

	</ul>
	</div>
    <?php
     $query  = "SELECT `event` FROM `calendar` WHERE `date` BETWEEN CURDATE() AND CURRENT_DATE() + INTERVAL 45 DAY LIMIT 1";
     $data = array();
     foreach ($connectionPool as $connName => $configuration) {
         if ($configuration['master'] === true) {
             $resultARRAY = mysqli_query($configuration['connection'],$query);
             $data = $resultARRAY->fetch_array(MYSQLI_ASSOC);
         }
     }
     if (!empty($data)) {
     ?>
    <div align="right"><p><small><b>Note:</b>&nbsp;* indicates events from <?php echo $maName; ?></small></p></div>
    <?php } 
     ?>
</header>
  </div>
    </div>
  </div>

<!-- Content -->
  	<?php
        $dataArray = array();
		$query  = "SELECT `int1`, `event`, `date`, `stime`, `etime`, `title` FROM `calendar` WHERE `date` BETWEEN CURDATE() AND CURRENT_DATE() + INTERVAL 45 DAY AND `event` != 'Holiday' ORDER BY `date`, `stime` LIMIT 10";
		//$result = mysqli_query($conn, $query);

		//while($row = $result->fetch_array(MYSQLI_ASSOC))
		//{
        foreach ($connectionPool as $connName => $configuration) {
            $resultARRAY = mysqli_query($configuration['connection'],$query);

            while ($data = $resultARRAY->fetch_array(MYSQLI_ASSOC)) {
                //$dataArray[$data['title']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
                $dataArray[$data['stime']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
            }
        }

        ksort($dataArray);
        foreach($dataArray as $recordArray ) {
          foreach ($recordArray as $record) {
            $row = $record['data'];
            //$row['title'] = $row['title'] . ($record['master'] === true ? " *" : "");
      
	?>
    <div class="row calendar-container-list-view calendar-container__event">
      <div class="small-12 medium-6 columns">
        <div class="event-title"><p>
        <a href="../modules/events-single.php?choice=<?php echo "{$row['int1']}"; ?>&conn=<?php echo $record['dbconnName']; ?>" class="iframe-link" title="<?php echo "{$row['title']}"; ?>">
            <i class="event event__<?php echo "{$row['event']}"; ?>" aria-hidden="true"></i><?php echo "{$row['title']}".($record['master'] === true ? " *" : ""); ?></a></p>
        </div>
      </div>
      <div class="small-6 medium-3 columns">
        <div class="event-date"><p><?php echo date('l, M d', strtotime($row['date'])); ?></p></div>
      </div>
      <div class="small-6 medium-3 columns">
        <div class="event-time"><p><?php if ($row['stime'] !== '00:00:00'){ ?><?php echo date('g:i a', strtotime($row['stime'])); ?><?php }; ?><?php if ($row['etime'] !== '00:00:00'){ ?> to <?php echo date('g:i a', strtotime($row['etime'])); ?><?php }; ?></p></div>
      </div>
    </div>

	<?php
		}
        }
	?>

<!-- Full Calendar -->
<div class="row">
  <div class="small-12 columns">
    <div class="calendar-view-full">
        <a href="../modules/events-month.php" class="iframe-link"><i class="fa fa-calendar" aria-hidden="true"></i>View Full Calendar</a></div>
  </div>
</div>

</div>


<?php }; ?>
