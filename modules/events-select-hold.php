<?php
require_once('events-calendar_config.php');
require_once('../my-documents/php7-my-db.php');
$connName = isset($_GET['conn']) ? trim($_GET['conn']) : "none";

if (isset($connectionPool) && isset($connectionPool[$connName])) {
    $dbConn = $connectionPool[$connName]['connection'];
} else {
    $dbConn = $conn;

}
?>
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">
<head>
	<meta charset="utf-8">
	<!--[if lte IE 10]><meta http-equiv="refresh" content="0;url=../IE.html" /><![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="CondoSites - http://www.condosites.com" name="author">
	<title><?php include('../my-documents/communityname.html'); ?></title>
	<?php include('../my-documents/meta-robots.html'); ?>
	<link rel="stylesheet" href="../css/foundation.css">
	<link rel="stylesheet" href="../css/magnific-popup.css">
	<link rel="stylesheet" href="../css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/jquery-ui.min.css">
	<link rel="stylesheet" href="../css/jquery-ui.structure.min.css">
	<link rel="stylesheet" href="../css/app.css">
    <link rel="stylesheet" href="../my-documents/app-custom.css">
    <script src="../java/table.js" type="text/javascript"></script>
	<script src="../java/vendor/jquery.js"></script>
	<script src="../java/vendor/jquery-ui.min.js"></script>
	<script src="../java/vendor/jquery.magnific-popup.min.js"></script>
</head>

<body>

<!-- Calendar Setup -->
<?php
$choice    = $_GET['choice'];
$month_Names = Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

if (!isset($_REQUEST["month"])) $_REQUEST["month"] = date("n");
if (!isset($_REQUEST["year"])) $_REQUEST["year"] = date("Y");

$Current_Month = $_REQUEST["month"];
$Current_Year = $_REQUEST["year"];

$prev_year = $Current_Year;
$next_year = $Current_Year;
$prev_month = $Current_Month-1;
$next_month = $Current_Month+1;

if ($prev_month == 0 ) {
$prev_month = 12;
$prev_year = $Current_Year - 1;

}

if ($next_month == 13 ) {
$next_month = 1;
$next_year = $Current_Year + 1;

}

?>

<div id="Calendar" class="stand-alone-page">
  <div class="popup-header">
  <h4>
<?php
	$choice    = $_GET['choice'];
	{
?>
<?php if ($_GET["choice"] == 'Meeting') { ?>
<?php
	$query  = "SELECT title FROM tabs WHERE `int1` = '211'";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php echo "{$row['title']}"; ?>
<?php
	}
?>
<?php } ?>
<?php if ($_GET["choice"] == 'Event') { ?>
<?php
	$query  = "SELECT title FROM tabs WHERE `int1` = '212'";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php echo "{$row['title']}"; ?>
<?php
	}
?>
<?php } ?>
<?php if ($_GET["choice"] == 'Town') { ?>
<?php
	$query  = "SELECT title FROM tabs WHERE `int1` = '213'";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php echo "{$row['title']}"; ?>
<?php
	}
?>
<?php } ?>
<?php if ($_GET["choice"] == 'Social') { ?>
<?php
	$query  = "SELECT title FROM tabs WHERE `int1` = '217'";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php echo "{$row['title']}"; ?>
<?php
	}
?>
<?php } ?>
<?php if ($_GET["choice"] == 'Class') { ?>
<?php
	$query  = "SELECT title FROM tabs WHERE `int1` = '218'";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php echo "{$row['title']}"; ?>
<?php
	}
?>
<?php } ?>
<?php if ($_GET["choice"] == 'Reserved') { ?>
<?php
	$query  = "SELECT title FROM tabs WHERE `int1` = '214'";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php echo "{$row['title']}"; ?>
<?php
	}
?>
<?php } ?>
<?php if ($_GET["choice"] == 'Elevator') { ?>
<?php
	$query  = "SELECT title FROM tabs WHERE `int1` = '215'";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php echo "{$row['title']}"; ?>
<?php
	}
?>
<?php } ?>
<?php if ($_GET["choice"] == 'Construction') { ?>
<?php
	$query  = "SELECT title FROM tabs WHERE `int1` = '216'";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php echo "{$row['title']}"; ?>
<?php
	}
?>
<?php } ?>
<?php if ($_GET["choice"] == 'Sport') { ?>
<?php
	$query  = "SELECT title FROM tabs WHERE `int1` = '219'";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php echo "{$row['title']}"; ?>
<?php
	}
?>
<?php } ?>
<?php
	}
?>

            
  </h4>
        <input type="button" value="Print Calendar" onClick="window.open('events-select-print.php?choice=<?php echo $choice; ?>&conn=<?php echo $connName; ?>');" class="filter-note" style="margin-top: 25px; ">
  </div>

<!-- Mobile Filter Notice -->
  <div class="stand-alone-page-content">
    <div class="rotate-note">Rotate your mobile device for calendar details.</div>

<!-- EVENT COUNT -->
<?php $event = $_GET['choice']; $sqlCALCOUNT = mysqli_query($dbConn,"SELECT count(*) FROM `calendar` WHERE event = '$event' AND `date` BETWEEN CURDATE() AND CURRENT_DATE() + INTERVAL 180 DAY") or die(mysqli_error($dbConn));
//$countCALCOUNT = mysql_result($sqlCALCOUNT, "0");
$row = mysqli_fetch_row($sqlCALCOUNT);
$countCALCOUNT = $row[0];
?>

<!-- LIST VIEW NO EVENTS -->
<?php if ($countCALCOUNT == '0'){ ?>

<!-- Upcoming Events Setup -->
<div style="margin: 2.5%;" >
<div class="newsboard-container newsboard-container__upcoming-events">

<!-- Upcoming Events Headline -->
  <div class="row">
    <div class="small-4 columns"><h3 class="newsboard-subtitle">Upcoming Events</h3></div>
  </div>
  <div class="row"  align="left">
    <div class="small-12 medium-8 large-9 columns">
      <blockquote>There are no more events for the next six months.</blockquote>
    </div>
  </div>

</div>
</div>

<?php }; ?>

<!-- LIST VIEW -->
<?php if ($countCALCOUNT <= '10' AND $countCALCOUNT >= '1'){ ?>

<!-- Upcoming Events Setup -->
<div style="margin: 2.5%;" >
<div class="newsboard-container newsboard-container__upcoming-events">

<!-- Upcoming Events Headline -->
  <div class="row">
    <div class="small-4 columns"><h3 class="newsboard-subtitle">Upcoming Events</h3></div>

<!-- Events Key -->
    <div class="small-8 columns">
        <div id="calendar-wrap">
<header>
	<div class="keys clearfix">
	<ul>
<?php
	$choice    = $_GET['choice'];
	{
?>
<?php if ($_GET["choice"] == 'Meeting') { ?>
  	<?php
		$query  = "SELECT `int1` FROM `calendar` WHERE `event` = 'Meeting' AND `date` BETWEEN CURDATE() AND CURRENT_DATE() + INTERVAL 180 DAY LIMIT 1";
		$result = mysqli_query($dbConn, $query);

		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
	    <li class="key key__Meeting">Meetings</li>
	<?php
		}
	?>
<?php } ?>
<?php if ($_GET["choice"] == 'Class') { ?>
	<?php
		$query  = "SELECT `int1` FROM `calendar` WHERE `event` = 'Class' AND `date` BETWEEN CURDATE() AND CURRENT_DATE() + INTERVAL 180 DAY LIMIT 1";
		$result = mysqli_query($dbConn, $query);

		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
	    <li class="key key__Class">Classes</li>
	<?php
		}
	?>
<?php } ?>
<?php if ($_GET["choice"] == 'Event') { ?>
	<?php
		$query  = "SELECT `int1` FROM `calendar` WHERE `event` = 'Event' AND `date` BETWEEN CURDATE() AND CURRENT_DATE() + INTERVAL 180 DAY LIMIT 1";
		$result = mysqli_query($dbConn, $query);

		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
	    <li class="key key__Event">Community Events</li>
	<?php
		}
	?>
<?php } ?>
<?php if ($_GET["choice"] == 'Elevator') { ?>
	<?php
		$query  = "SELECT `int1` FROM `calendar` WHERE `event` = 'Elevator' AND `date` BETWEEN CURDATE() AND CURRENT_DATE() + INTERVAL 180 DAY LIMIT 1";
		$result = mysqli_query($dbConn, $query);

		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
	    <li class="key key__Elevator">Elevator</li>
	<?php
		}
	?>
<?php } ?>
<?php if ($_GET["choice"] == 'Holiday') { ?>
	<?php
		$query  = "SELECT `int1` FROM `calendar` WHERE `event` = 'Holiday' AND `date` BETWEEN CURDATE() AND CURRENT_DATE() + INTERVAL 180 DAY LIMIT 1";
		$result = mysqli_query($dbConn, $query);

		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
	    <li class="key key__Holiday">Holiday</li>
	<?php
		}
	?>
<?php } ?>
<?php if ($_GET["choice"] == 'Reserved') { ?>
	<?php
		$query  = "SELECT `int1` FROM `calendar` WHERE `event` = 'Reserved' AND `date` BETWEEN CURDATE() AND CURRENT_DATE() + INTERVAL 180 DAY LIMIT 1";
		$result = mysqli_query($dbConn, $query);

		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
	    <li class="key key__Reserved">Reserved</li>
	<?php
		}
	?>
<?php } ?>
<?php if ($_GET["choice"] == 'Construction') { ?>
	<?php
		$query  = "SELECT `int1` FROM `calendar` WHERE `event` = 'Construction' AND `date` BETWEEN CURDATE() AND CURRENT_DATE() + INTERVAL 180 DAY LIMIT 1";
		$result = mysqli_query($dbConn, $query);

		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
	    <li class="key key__Construction">Construction/Maintenance</li>
	<?php
		}
	?>
<?php } ?>
<?php if ($_GET["choice"] == 'Social') { ?>
	<?php
		$query  = "SELECT `int1` FROM `calendar` WHERE `event` = 'Social' AND `date` BETWEEN CURDATE() AND CURRENT_DATE() + INTERVAL 180 DAY LIMIT 1";
		$result = mysqli_query($dbConn, $query);

		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
	    <li class="key key__Social">Social</li>
	<?php
		}
	?>
<?php } ?>
<?php if ($_GET["choice"] == 'Sport') { ?>
	<?php
		$query  = "SELECT `int1` FROM `calendar` WHERE `event` = 'Sport' AND `date` BETWEEN CURDATE() AND CURRENT_DATE() + INTERVAL 180 DAY LIMIT 1";
		$result = mysqli_query($dbConn, $query);

		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
	    <li class="key key__Sport">Sport</li>
	<?php
		}
	?>
<?php } ?>
<?php if ($_GET["choice"] == 'Town') { ?>
	<?php
		$query  = "SELECT `int1` FROM `calendar` WHERE `event` = 'Town' AND `date` BETWEEN CURDATE() AND CURRENT_DATE() + INTERVAL 180 DAY LIMIT 1";
		$result = mysqli_query($dbConn, $query);

		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
	    <li class="key key__Town">Town Events</li>
	<?php
		}
	?>
<?php } ?>
<?php if ($_GET["choice"] == 'Other') { ?>
	<?php
		$query  = "SELECT `int1` FROM `calendar` WHERE `event` = 'Other' AND `date` BETWEEN CURDATE() AND CURRENT_DATE() + INTERVAL 180 DAY LIMIT 1";
		$result = mysqli_query($dbConn, $query);

		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
	    <li class="key key__Other">Other</li>
	<?php
		}
	?>
<?php } ?>
<?php
	}
?>
	</ul>
	<div align="right"><p><small><b>Note:</b>&nbsp;12:00&nbsp;am&nbsp;Start&nbsp;Times&nbsp;indicate&nbsp;All&nbsp;Day&nbsp;Events,&nbsp;or&nbsp;a&nbsp;Start&nbsp;Time&nbsp;to&nbsp;be&nbsp;determined.&nbsp;&nbsp;</small></p></div>
	</div>
</header>
  </div>
    </div>
  </div>
  <div class="row"  align="left">
    <div class="small-12 medium-8 large-9 columns">
      <blockquote>There are only a few events on the calendar right now, so here is a list of events for the next six months. You can still scroll past this list for a traditional monthly view calendar.</blockquote>
    </div>
  </div>

<!-- Content -->
  	<?php
		$event = $_GET['choice'];
		$query  = "SELECT `int1`, `event`, `date`, `stime`, `etime`, `title` FROM `calendar` WHERE event = '$event' AND `date` BETWEEN CURDATE() AND CURRENT_DATE() + INTERVAL 180 DAY ORDER BY `date`, `stime` LIMIT 10";
		$result = mysqli_query($dbConn, $query);

		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{

	?>

    <div class="row calendar-container-list-view calendar-container__event">
      <div class="small-12 medium-6 columns">
        <div class="event-title"><p>
        <a href="../modules/events-single.php?choice=<?php echo "{$row['int1']}"; ?>&conn=<?php echo $connName;?>" class="iframe-link" title="<?php echo "{$row['title']}"; ?>">
        <i class="event event__<?php echo "{$row['event']}"; ?>" aria-hidden="true"></i><?php echo "{$row['title']}"; ?></a></p></div>
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
	?>

</div>
</div>

<?php }; ?>
<!-- CONTENT -->


<!-- MONTH VIEW -->
<!-- CONTENT -->

  <div id="calendar-wrap" class="calendar-full-view">
<!-- Calendar Headline -->
  <header>
  <div class="row">
    <div class="small-12 medium-5 large-4 columns">
		<h3><strong><?php echo $month_Names[$Current_Month-1].' '.$Current_Year; ?></strong></h3>
    </div>
	<div class="small-12 medium-7 large-8 columns">
		<p class="text-right">Month: <b><a href="<?php echo $_SERVER["PHP_SELF"] . "?choice=" . $choice . "&month=". $prev_month . "&year=" . $prev_year."&conn=".$connName; ?>">Previous</a>&nbsp;|&nbsp;<a href="<?php echo $_SERVER["PHP_SELF"] . "?choice=" . $choice."&conn=".$connName; ?>">Current</a>&nbsp;|&nbsp;<a href="<?php echo $_SERVER["PHP_SELF"] . "?choice=" . $choice . "&month=". $next_month . "&year=" . $next_year."&conn=".$connName; ?>">Next</a></b></p>
	</div>

      <div class="keys">
	<ul>
<?php
	$choice    = $_GET['choice'];
	{
?>
<?php if ($_GET["choice"] == 'Meeting') { ?>
  	<?php
		$query  = "SELECT `int1` FROM `calendar` WHERE `event` = 'Meeting' AND `date` BETWEEN CAST('$Current_Year-$Current_Month-1' AS DATE) AND CAST('$Current_Year-$Current_Month-".cal_days_in_month(CAL_GREGORIAN,$Current_Month,$Current_Year)."' AS DATE) LIMIT 1";
		$result = mysqli_query($dbConn, $query);

		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
	    <li class="key key__Meeting">Meetings</li>
	<?php
		}
	?>
<?php } ?>
<?php if ($_GET["choice"] == 'Class') { ?>
	<?php
		$query  = "SELECT `int1` FROM `calendar` WHERE `event` = 'Class' AND `date` BETWEEN CAST('$Current_Year-$Current_Month-1' AS DATE) AND CAST('$Current_Year-$Current_Month-".cal_days_in_month(CAL_GREGORIAN,$Current_Month,$Current_Year)."' AS DATE) LIMIT 1";
		$result = mysqli_query($dbConn, $query);

		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
	    <li class="key key__Class">Classes</li>
	<?php
		}
	?>
<?php } ?>
<?php if ($_GET["choice"] == 'Event') { ?>
	<?php
		$query  = "SELECT `int1` FROM `calendar` WHERE `event` = 'Event' AND `date` BETWEEN CAST('$Current_Year-$Current_Month-1' AS DATE) AND CAST('$Current_Year-$Current_Month-".cal_days_in_month(CAL_GREGORIAN,$Current_Month,$Current_Year)."' AS DATE) LIMIT 1";
		$result = mysqli_query($dbConn, $query);

		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
	    <li class="key key__Event">Community Events</li>
	<?php
		}
	?>
<?php } ?>
<?php if ($_GET["choice"] == 'Elevator') { ?>
	<?php
		$query  = "SELECT `int1` FROM `calendar` WHERE `event` = 'Elevator' AND `date` BETWEEN CAST('$Current_Year-$Current_Month-1' AS DATE) AND CAST('$Current_Year-$Current_Month-".cal_days_in_month(CAL_GREGORIAN,$Current_Month,$Current_Year)."' AS DATE) LIMIT 1";
		$result = mysqli_query($dbConn, $query);

		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
	    <li class="key key__Elevator">Elevator</li>
	<?php
		}
	?>
<?php } ?>
<?php if ($_GET["choice"] == 'Holiday') { ?>
	<?php
		$query  = "SELECT `int1` FROM `calendar` WHERE `event` = 'Holiday' AND `date` BETWEEN CAST('$Current_Year-$Current_Month-1' AS DATE) AND CAST('$Current_Year-$Current_Month-".cal_days_in_month(CAL_GREGORIAN,$Current_Month,$Current_Year)."' AS DATE) LIMIT 1";
		$result = mysqli_query($dbConn, $query);

		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
	    <li class="key key__Holiday">Holiday</li>
	<?php
		}
	?>
<?php } ?>
<?php if ($_GET["choice"] == 'Reserved') { ?>
	<?php
		$query  = "SELECT `int1` FROM `calendar` WHERE `event` = 'Reserved' AND `date` BETWEEN CAST('$Current_Year-$Current_Month-1' AS DATE) AND CAST('$Current_Year-$Current_Month-".cal_days_in_month(CAL_GREGORIAN,$Current_Month,$Current_Year)."' AS DATE) LIMIT 1";
		$result = mysqli_query($dbConn, $query);

		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
	    <li class="key key__Reserved">Reserved</li>
	<?php
		}
	?>
<?php } ?>
<?php if ($_GET["choice"] == 'Construction') { ?>
	<?php
		$query  = "SELECT `int1` FROM `calendar` WHERE `event` = 'Construction' AND `date` BETWEEN CAST('$Current_Year-$Current_Month-1' AS DATE) AND CAST('$Current_Year-$Current_Month-".cal_days_in_month(CAL_GREGORIAN,$Current_Month,$Current_Year)."' AS DATE) LIMIT 1";
		$result = mysqli_query($dbConn, $query);

		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
	    <li class="key key__Construction">Maintenance/Construction</li>
	<?php
		}
	?>
<?php } ?>
<?php if ($_GET["choice"] == 'Social') { ?>
	<?php
		$query  = "SELECT `int1` FROM `calendar` WHERE `event` = 'Social' AND `date` BETWEEN CAST('$Current_Year-$Current_Month-1' AS DATE) AND CAST('$Current_Year-$Current_Month-".cal_days_in_month(CAL_GREGORIAN,$Current_Month,$Current_Year)."' AS DATE) LIMIT 1";
		$result = mysqli_query($dbConn, $query);

		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
	    <li class="key key__Social">Social</li>
	<?php
		}
	?>
<?php } ?>
<?php if ($_GET["choice"] == 'Sport') { ?>
	<?php
		$query  = "SELECT `int1` FROM `calendar` WHERE `event` = 'Sport' AND `date` BETWEEN CAST('$Current_Year-$Current_Month-1' AS DATE) AND CAST('$Current_Year-$Current_Month-".cal_days_in_month(CAL_GREGORIAN,$Current_Month,$Current_Year)."' AS DATE) LIMIT 1";
		$result = mysqli_query($dbConn, $query);

		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
	    <li class="key key__Sport">Sport</li>
	<?php
		}
	?>
<?php } ?>
<?php if ($_GET["choice"] == 'Town') { ?>
	<?php
		$query  = "SELECT `int1` FROM `calendar` WHERE `event` = 'Town' AND `date` BETWEEN CAST('$Current_Year-$Current_Month-1' AS DATE) AND CAST('$Current_Year-$Current_Month-".cal_days_in_month(CAL_GREGORIAN,$Current_Month,$Current_Year)."' AS DATE) LIMIT 1";
		$result = mysqli_query($dbConn, $query);

		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
	    <li class="key key__Town">Town Events</li>
	<?php
		}
	?>
<?php } ?>
<?php if ($_GET["choice"] == 'Other') { ?>
	<?php
		$query  = "SELECT `int1` FROM `calendar` WHERE `event` = 'Other' AND `date` BETWEEN CAST('$Current_Year-$Current_Month-1' AS DATE) AND CAST('$Current_Year-$Current_Month-".cal_days_in_month(CAL_GREGORIAN,$Current_Month,$Current_Year)."' AS DATE) LIMIT 1";
		$result = mysqli_query($dbConn, $query);

		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
	    <li class="key key__Other">Other</li>
	<?php
		}
	?>
<?php } ?>
<?php
	}
?>
	</ul>
	<div align="right"><p><small><b>Note:</b>&nbsp;12:00&nbsp;am&nbsp;Start&nbsp;Times&nbsp;indicate&nbsp;All&nbsp;Day&nbsp;Events,&nbsp;or&nbsp;a&nbsp;Start&nbsp;Time&nbsp;to&nbsp;be&nbsp;determined.&nbsp;&nbsp;</small></p></div>
      </div>
	  </div>
<!-- Events Key -->
  

      </header>
  


    
<table width="100%" border="0" cellpadding="0" cellspacing="1">
  <thead>
    <tr>
      <td><div class="weekdays show-for-large">Sunday</div><div class="weekdays show-for-medium-only">Sun</div><div class="weekdays show-for-small-only rotate90"><small>Sun</small></div></td>
      <td><div class="weekdays show-for-large">Monday</div><div class="weekdays show-for-medium-only">Mon</div><div class="weekdays show-for-small-only rotate90"><small>Mon</small></div></td>
      <td><div class="weekdays show-for-large">Tuesday</div><div class="weekdays show-for-medium-only">Tue</div><div class="weekdays show-for-small-only rotate90"><small>Tue</small></div></td>
      <td><div class="weekdays show-for-large">Wednesday</div><div class="weekdays show-for-medium-only">Wed</div><div class="weekdays show-for-small-only rotate90"><small>Wed</small></div></td>
      <td><div class="weekdays show-for-large">Thursday</div><div class="weekdays show-for-medium-only">Thu</div><div class="weekdays show-for-small-only rotate90"><small>Thu</small></div></td>
      <td><div class="weekdays show-for-large">Friday</div><div class="weekdays show-for-medium-only">Fri</div><div class="weekdays show-for-small-only rotate90"><small>Fri</small></div></td>
      <td><div class="weekdays show-for-large">Saturday</div><div class="weekdays show-for-medium-only">Sat</div><div class="weekdays show-for-small-only rotate90"><small>Sat</small></div></td>
    </tr>
  </thead>
  <tbody>
<!-- CALENDAR DAYS -->
<?php

/* Build MySQL query */
	$event = $_GET['choice'];
	$query = "SELECT " . $calendar_vars['column_names']; // fields to select from db as set it config file
	$query .= " FROM " . $calendar_vars['db_tablename']; // from tablename as in config file
	$query .= " WHERE `event` = '$event' ";  // query only certain events
        $query .= " AND date BETWEEN ";  // start date conditions/range
	$query .= " CAST('$Current_Year-$Current_Month-1' AS DATE)"; // set lower end of date range
	$query .= " AND CAST('$Current_Year-$Current_Month-".cal_days_in_month(CAL_GREGORIAN,$Current_Month,$Current_Year)."' AS DATE)"; // set higher end of date range
	$query .= " ORDER BY date,stime"; // order first by date, then by time of day

if ($calendar_vars['testing']) echo "<h3>MySQL query:<br/><i>$query</i></h3>"; // debug: show query string

$results = mysqli_query($dbConn, $query); // query MySQL
if (!$results) // exit if query fails
{
	if ($calendar_vars['testing']) die(mysqli_error($dbConn)); // debug: MySQL query error
	else die;
}
else // if query returns positive results
{
	$events = array(); // initialize array to store event data
	while ($rowMONTH = mysqli_fetch_assoc($results)) // loop through results
	{
		$rowMONTH['stime'] = format_event_time($rowMONTH['stime']); // turn time into am/pm format
        $rowMONTH['conn'] = trim($connName);
        $rowMONTH['master'] = $connectionPool[$connName]['master'];
		$events[$rowMONTH['date']][] = $rowMONTH; // add data row to event array. accessed via "$events[$datestring]" (e.g. $events['2011-02-05']...note the leading zeros in month/day spots)
	}
}

if ($calendar_vars['testing']) // debug: print the events array
{
	echo '<pre><hr/>';
	print_r($events);
	echo '</pre><hr/>';
}

/* PRINT TABLE ROWS */
$timestamp = mktime(0,0,0,$Current_Month,1,$Current_Year);
$maxday = date("t",$timestamp);
$thismonth = getdate ($timestamp);
$startday = $thismonth['wday'];
for ($i=0; $i<($maxday+$startday); $i++) {
	if(($i % 7) == 0 ) echo "<tr>\n";
	if($i < $startday) echo '<td class="calendar-full-view-day__empty"></td>' . "\n";
	else 
	{
		$day = $i - $startday + 1;
		$Current_Date = date('Y-m-d', mktime(0,0,0,$Current_Month,$day,$Current_Year));
		echo '<td class="calendar-full-view-day-square"><strong class="calendar-full-view-date">'. $day . ' &nbsp;</strong>';
		if ($events[$Current_Date])
		{
			echo '<ul class="event_list">';
			foreach ($events[$Current_Date] as $event)
			{
				echo event_to_html($event);
			}
			echo '</ul>';
		}
		echo "</td>\n";
	}
	if(($i % 7) == 6 ) echo "</tr>\n";

}

?>
<!-- END CALENDAR DAYS -->
  </tbody>
</table>
  </div>
    </div>
</div>
<!-- PHP FUNCTIONS -->
<?php
/* THIS FUNCTION TAKES A ROW OF EVENT DATA AND INSERTS IT INTO HTML MARKUP BASED ON TEMPLATE IN CONFIG FILE */
function event_to_html($eventdata)
{
	global $calendar_vars;

	$eventhtml = $calendar_vars['event_view_template'];
	preg_match_all('|%(.+?)%|', $eventhtml, $matches);
	
	if ($calendar_vars['testing'] && is_array($matches))
	{
		echo '<hr/><pre>';
		print_r($matches);
		echo '</pre>';
	}
	
	foreach ($matches[1] as $match)
	{
		$eventhtml = str_replace('%'.$match.'%',$eventdata[$match],$eventhtml);
	}
	
	return $eventhtml;
}

/* THIS FUNCTION TAKES A TIME ARGUMENT AND RETURNS IT IN HH:MM AM/PM */
function format_event_time($mysqltime)
{
	global $calendar_vars;
	
	$hms = explode(':',$mysqltime);
	return date($calendar_vars['event_time_format'], mktime($hms[0],$hms[1],$hms[2]));
}

?>
<!-- END PHP FUNCTIONS -->

<!-- END CONTENT -->

<!-- END MONTH VIEW -->
<br>
<br>
</body>
  
	<script src="../java/vendor/what-input.js"></script>
	<script src="../java/vendor/foundation.min.js"></script>
	<script type="text/javascript" src="../java/google-base.js"></script>
	<script type="text/javascript" src="../my-documents/google-code.js"></script>

</html>