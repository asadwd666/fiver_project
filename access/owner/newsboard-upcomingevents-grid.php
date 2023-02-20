<?php

$connName = isset($_GET['conn']) ? $_GET['conn'] : "none";

if (isset($connectionPool) && isset($connectionPool[$connName])) {
    $dbConn = $connectionPool[$connName]['connection'];
} else {
    $dbConn = $conn;
}

if (!isset($connectionPool) || $connectionPool == null) {
   $connectionPool[$CommunityName]= array('priority' => 10, 'connection' =>  $conn, 'master' => false, 'primary' => true);
}

$maName = '';
$fromMaster = false;
foreach ($connectionPool as $name => $connDetails) {
    if ($connDetails['master'] === true) {
        $maName = $name;
    }
}

$eventArray = array('Other' => 'Other', 'Town' => 'Town Events', 'Social' => 'Social Events', 'Class' => 'Classes', 
                    'Event' => 'Community Events', 'Reserved' => 'Reserved', 'Meeting' =>'Meetings', 'Elevator' => 'Elevator',
                    'Construction' => 'Construction/Maintenance', 'Sport' => 'Sport', 'Holiday' => 'Holiday');
                    

$searchFilter = "'". implode("','", array_keys($eventArray))."'";

$query  = "SELECT DISTINCT `event` FROM `calendar` WHERE `event` in ( " . $searchFilter. ") AND `date` BETWEEN CURDATE() AND CURRENT_DATE() + INTERVAL 4 DAY";
$calEventsArray = array();
foreach ($connectionPool as $connName => $configuration) {
    $resultARRAY = mysqli_query($configuration['connection'],$query);

    while ($data = $resultARRAY->fetch_array(MYSQLI_ASSOC)) {
        $calEventsArray[$data['event']] = ($configuration['primary']== true) ? 'Primary' : 'Master';
        if ($configuration['master'] === true) {
          $fromMaster = true;
        }
    }
}

$showCal = false;
if (count($calEventsArray) > 0 ) {
  if (count($calEventsArray) == 1) {
    $showCal = isset($calEventsArray['Holiday']) ? false : true;
  }
  $showCal = true;
}

if ($showCal == true) { 

?>

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
            <?php if ($fromMaster === true) { ?> 
                <div align="right" style="font-size: .75rem;margin-bottom:10px;">
                  <p>* indicates events from <?php echo $maName; ?>&nbsp;&nbsp;</p>
                </div>
            <?php } ?>  
	              <ul>
<?php 
    foreach ($eventArray as $key => $label) {
      if (isset($calEventsArray[$key])) {
        print '<li class="key key__' . $key .'">'.$label.'</li>';
      }
    }
?>
	              </ul>
	            </div>
          </header>
        </div>
      </div>
  </div>

<!-- Events Setup -->
<div class="row">
  <div class="small-12 columns">
    <div id="calendar-wrap">

<!-- Days - Setup -->
<div id="calendar">
  <ul class="days">

<!-- Days - Today -->								
    <li class="day">
	<div class="weekdays">Today <?php echo (date('M d', strtotime('+ 0 DAY'))); ?></div>

	<!-- No Event -->
	<?php

    $countCAL = 0;
    $query = "SELECT count(*) FROM `calendar` WHERE `date` = CURRENT_DATE()";

    foreach ($connectionPool as $connName => $configuration) {
        $result = mysqli_query($configuration['connection'], $query);
        $row = mysqli_fetch_row($result);
        $countCAL = ($countCAL > $row[0] ? $countCAL : $row[0]);
    }
	?>

	<?php if ($countCAL == '0'){ ?>
	  <div class="event event__none">No Events</div>
	<?php }; ?>

	<!-- Event -->
  	<?php

        $dataArray = array();
        $query  = "SELECT `int1`, `event`, `date`, `stime`, `title` FROM `calendar` WHERE `date` = CURDATE() ORDER BY `stime`";

        foreach ($connectionPool as $connName => $configuration) {
            $resultARRAY = mysqli_query($configuration['connection'],$query);

            while ($data = $resultARRAY->fetch_array(MYSQLI_ASSOC)) {
                //$dataArray[$data['title']][$data['stime']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
                $dataArray[$data['stime']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
            }
        }
        
        ksort($dataArray);
        foreach($dataArray as $recordArray ) {
            foreach ($recordArray as $record) {
                    $row = $record['data'];
                    $row['title'] = $row['title'] . ($record['master'] === true ? " *" : "");
    ?>
	<div class="event event__<?php echo "{$row['event']}"; ?>">
	  <div class="event-desc">
          <a href="../modules/events-single.php?choice=<?php echo "{$row['int1']}"; ?>&conn=<?php echo $record['dbconnName']; ?>" class="iframe-link" title="<?php echo "{$row['title']}"; ?>"><?php if ($row['stime'] !== '00:00:00'){ ?><?php echo date('g:i a', strtotime($row['stime'])); ?><?php }; ?> <?php echo "{$row['title']}"; ?></a></div>
	</div>
	<?php
		}
         //   }
        }
	?>

    </li>

<!-- Days - Tomorrow -->								
    <li class="day">
	    <div class="weekdays">Tomorrow <?php echo (date('M d', strtotime('+ 1 DAY'))); ?></div>

	    <!-- No Event -->
        <?php
        $countCAL = 0;
        $query = "SELECT count(*) FROM `calendar` WHERE `date` = CURRENT_DATE() + INTERVAL 1 DAY";
        foreach ($connectionPool as $connName => $configuration) {
            $result = mysqli_query($configuration['connection'], $query);
            $row = mysqli_fetch_row($result);
            $countCAL = ($countCAL > $row[0] ? $countCAL : $row[0]);
        }
	    ?>

	<?php if ($countCAL == '0'){ ?>
	  <div class="event event__none">No Events</div>
	<?php }; ?>

	<!-- Event -->
  	<?php
        $dataArray = array();

		$query  = "SELECT `int1`, `event`, `date`, `stime`, `title` FROM `calendar` WHERE `date` = CURRENT_DATE() + INTERVAL 1 DAY ORDER BY `stime`";
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
              $row['title'] = $row['title'] . ($record['master'] === true ? " *" : "");
    ?>
	<div class="event event__<?php echo "{$row['event']}"; ?>">
	  <div class="event-desc"><a href="../modules/events-single.php?choice=<?php echo "{$row['int1']}"; ?>&conn=<?php echo $record['dbconnName']; ?>" class="iframe-link" title="<?php echo "{$row['title']}"; ?>"><?php if ($row['stime'] !== '00:00:00'){ ?><?php echo date('g:i a', strtotime($row['stime'])); ?><?php }; ?> <?php echo "{$row['title']}"; ?></a></div>
	</div>
	<?php
		        }
        }
	?>
    </li>
    
<!-- Days - +2 Days -->								
    <li class="day">
	<div class="weekdays"><?php echo (date('D M d', strtotime('+ 2 DAY'))); ?></div>

	<!-- No Event -->

	<?php
        $countCAL = 0;
        $query = "SELECT count(*) FROM `calendar` WHERE `date` = CURRENT_DATE() + INTERVAL 2 DAY";
        foreach ($connectionPool as $connName => $configuration) {
            $result = mysqli_query($configuration['connection'], $query);
            $row = mysqli_fetch_row($result);
            $countCAL = ($countCAL > $row[0] ? $countCAL : $row[0]);
        }
    ?>
	<?php if ($countCAL == '0'){ ?>
	  <div class="event event__none">No Events</div>
	<?php }; ?>

	<!-- Event -->
  	<?php
        $dataArray = array();
		$query  = "SELECT `int1`, `event`, `date`, `stime`, `title` FROM `calendar` WHERE `date` = CURRENT_DATE() + INTERVAL 2 DAY ORDER BY `stime`";
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
          $row['title'] = $row['title'] . ($record['master'] === true ? " *" : "");
    ?>
	<div class="event event__<?php echo "{$row['event']}"; ?>">
	  <div class="event-desc"><a href="../modules/events-single.php?choice=<?php echo "{$row['int1']}"; ?>&conn=<?php echo $record['dbconnName']; ?>" class="iframe-link" title="<?php echo "{$row['title']}"; ?>"><?php if ($row['stime'] !== '00:00:00'){ ?><?php echo date('g:i a', strtotime($row['stime'])); ?><?php }; ?> <?php echo "{$row['title']}"; ?></a></div>
	</div>
	<?php
		        }
        }
	?>

    </li>
    
<!-- Days - +3 Days -->								
    <li class="day">
	<div class="weekdays"><?php echo (date('D M d', strtotime('+ 3 DAY'))); ?></div>

	<!-- No Event -->

	<?php
    $countCAL = 0;
    $query = "SELECT count(*) FROM `calendar` WHERE `date` = CURRENT_DATE() + INTERVAL 3 DAY";
    foreach ($connectionPool as $connName => $configuration) {
        $result = mysqli_query($configuration['connection'], $query);
        $row = mysqli_fetch_row($result);
        $countCAL = ($countCAL > $row[0] ? $countCAL : $row[0]);
    }
    ?>
	<?php if ($countCAL == '0'){ ?>
	  <div class="event event__none">No Events</div>
	<?php }; ?>

	<!-- Event -->
  	<?php
        $dataArray = array();
		$query  = "SELECT `int1`, `event`, `date`, `stime`, `title` FROM `calendar` WHERE `date` = CURRENT_DATE() + INTERVAL 3 DAY ORDER BY `stime`";
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
          $row['title'] = $row['title'] . ($record['master'] === true ? " *" : "");
    ?>
	<div class="event event__<?php echo "{$row['event']}"; ?>">
	  <div class="event-desc"><a href="../modules/events-single.php?choice=<?php echo "{$row['int1']}"; ?>&conn=<?php echo $record['dbconnName']; ?>" class="iframe-link" title="<?php echo "{$row['title']}"; ?>"><?php if ($row['stime'] !== '00:00:00'){ ?><?php echo date('g:i a', strtotime($row['stime'])); ?><?php }; ?> <?php echo "{$row['title']}"; ?></a></div>
	</div>
	<?php
		        }
        }
	?>

    </li>

<!-- Days - +4 Days -->								
    <li class="day">
	<div class="weekdays"><?php echo (date('D M d', strtotime('+ 4 DAY'))); ?></div>

	<!-- No Event -->
	<?php
        $countCAL = 0;
        $query = "SELECT count(*) FROM `calendar` WHERE `date` = CURRENT_DATE() + INTERVAL 4 DAY";
        foreach ($connectionPool as $connName => $configuration) {
            $result = mysqli_query($configuration['connection'], $query);
            $row = mysqli_fetch_row($result);
            $countCAL = ($countCAL > $row[0] ? $countCAL : $row[0]);
        }
	?>
	<?php if ($countCAL == '0'){ ?>
	  <div class="event event__none">No Events</div>
	<?php }; ?>

	<!-- Event -->
  	<?php
        $dataArray = array();
		$query  = "SELECT `int1`, `event`, `date`, `stime`, `title` FROM `calendar` WHERE `date` = CURRENT_DATE() + INTERVAL 4 DAY ORDER BY `stime`";
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
          $row['title'] = $row['title'] . ($record['master'] === true ? " *" : "");
	?>
	<div class="event event__<?php echo "{$row['event']}"; ?>">
	  <div class="event-desc"><a href="../modules/events-single.php?choice=<?php echo "{$row['int1']}"; ?>&conn=<?php echo $record['dbconnName']; ?>" class="iframe-link" title="<?php echo "{$row['title']}"; ?>"><?php if ($row['stime'] !== '00:00:00'){ ?><?php echo date('g:i a', strtotime($row['stime'])); ?><?php }; ?> <?php echo "{$row['title']}"; ?></a></div>
	</div>
	<?php
		        }
        }
	?>

    </li>

<!-- Days - Setup -->
  </ul>
</div>

<!-- Events Setup -->
    </div>
  </div>
</div>

<!-- Full Calendar -->
<div class="row">
  <div class="small-12 columns">
    <div class="calendar-view-full"><a href="../modules/events-month.php" class="iframe-link"><i class="fa fa-calendar" aria-hidden="true"></i>View Full Calendar</a></div>
  </div>
</div>

<!-- Upcoming Events Setup -->
</div>

<?php }; ?>
