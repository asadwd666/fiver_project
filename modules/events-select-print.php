<?php
require_once('events-calendar-print_config.php');
require_once('../my-documents/php7-my-db.php');

$connName = $_GET['conn'] ?? "none";
$choice    = $_GET['choice'] ?? 'Meeting';

if (!isset($connectionPool) || $connectionPool == null) {
    $connectionPool[$CommunityName]= array('priority' => 10, 'connection' =>  $conn, 'master' => false, 'primary' => true);
}

if (isset($connectionPool[$connName])) {
    $dbConn = $connectionPool[$connName]['connection'];
} else {
    $dbConn = $conn;
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

$choiceArray = array('Meeting' => 211,'Event' => 212,'Town' => 213,'Social' => 217,'Class' => 218,'Reserved' => 214,'Elevator'=> 215,'Construction' => 216,'Sport'=> 219);

$month_Names = Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

$Current_Month = $_REQUEST["month"] ?? date("n");
$Current_Year = $_REQUEST["year"] ?? date("Y");

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
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">
<head>
	<meta charset="utf-8">
	<!--[if lte IE 10]><meta http-equiv="refresh" content="0;url=../IE.html" /><![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="CondoSites - http://www.condosites.com" name="author">
	<title><?php include('../my-documents/communityname.html'); ?></title>
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <link rel="stylesheet" href="../css/app.css">
    <link rel="stylesheet" href="../css/app-print.css">
</head>

<body style="background-color: #ffffff;" class="no-bg">

<!-- CALENDAR VIEW -->
<!-- CONTENT -->




	<table width="98%" align="center" border="0" cellpadding="0" cellspacing="1" class="table-rowshade-alternate">
	  <tbody>
	    <tr>
	      <td align="center" valign="middle" width="300">
	          <img src="../pics/logo-small.png" style="max-width: 300px; max-height: 100px;">
          </td>
	      <td align="right" valign="middle">
	          <big><big><big><b><?php echo $month_Names[$Current_Month-1].' '.$Current_Year; ?></b></big></big></big><br>
	          <div class="hidden-print"><span align="right"><small>Month: <a href="<?php echo $_SERVER["PHP_SELF"] . "?choice=" . $choice . "&month=". $prev_month . "&year=" . $prev_year . "&conn=" . $connName; ?>">Previous</a>&nbsp;|&nbsp;<a href="<?php echo $_SERVER["PHP_SELF"] . "?choice=" . $choice . "&conn=" . $connName; ?>">Current</a>&nbsp;|&nbsp;<a href="<?php echo $_SERVER["PHP_SELF"] . "?choice=" . $choice . "&month=". $next_month . "&year=" . $next_year . "&conn=" . $connName; ?>">Next</a></small></span>&nbsp;<br></div>

<div id="calendar-wrap">
<header>
	<div class="keys clearfix">
	<ul>
        <?php
        $query = "SELECT `int1` FROM `calendar` WHERE `event` = '$choice' AND `date` BETWEEN CAST('$Current_Year-$Current_Month-1' AS DATE) AND CAST('$Current_Year-$Current_Month-".cal_days_in_month(CAL_GREGORIAN,$Current_Month,$Current_Year)."' AS DATE) LIMIT 1";
        $fromMaster = false;
        foreach ($connectionPool as $key => $configuration) {
            $resultARRAY = mysqli_query($configuration['connection'],$query);
            while($row = $resultARRAY ->fetch_array(MYSQLI_ASSOC)) {
                $data = $row;
                if ($configuration['master'] === true) {
                    $fromMaster = true;
                }
            }
        }
        if ($fromMaster === true) {
            $masterMsg = "<br>* indicates events from $maName";
        }
        if (!empty($data)) {
            echo '<li class="key key__'.$choice.'">'.$eventArray[$choice].'</li>';
        }
        ?>
	</ul>
	</div>
    <div align="right"><p><small><b>Note:</b>&nbsp;12:00&nbsp;am&nbsp;Start&nbsp;Times&nbsp;indicate&nbsp;All&nbsp;Day&nbsp;Events,&nbsp;or&nbsp;a&nbsp;Start&nbsp;Time&nbsp;to&nbsp;be&nbsp;determined.&nbsp;<?php echo $masterMsg;?></small></p></div>
</header>
</div>

	      </td>
	    </tr>
	  </tbody>
	</table>
	<table width="98%" align="center" border="0" cellpadding="0" cellspacing="1" class="table-stripeclass:alternate table-autostripe table-rowshade-alternate">
	  <tbody>
	    <tr>
	      <td width='14%' align="center" class="text">Sun</td>
	      <td width='14%' align="center" class="text">Mon</td>
	      <td width='14%' align="center" class="text">Tue</td>
	      <td width='14%' align="center" class="text">Wed</td>
	      <td width='14%' align="center" class="text">Thu</td>
	      <td width='14%' align="center" class="text">Fri</td>
	      <td width='14%' align="center" class="text">Sat</td>
	    </tr>
<!-- CALENDAR DAYS -->
<?php
/* Build MySQL query */
	$query = "SELECT " . $calendar_vars['column_names']; // fields to select from db as set it config file
	$query .= " FROM " . $calendar_vars['db_tablename']; // from tablename as in config file
	$query .= " WHERE `event` = '$choice' ";  // query only certain events
    $query .= " AND date BETWEEN ";  // start date conditions/range
	$query .= " CAST('$Current_Year-$Current_Month-1' AS DATE)"; // set lower end of date range
	$query .= " AND CAST('$Current_Year-$Current_Month-".cal_days_in_month(CAL_GREGORIAN,$Current_Month,$Current_Year)."' AS DATE)"; // set higher end of date range
	$query .= " ORDER BY date,stime"; // order first by date, then by time of day

    if ($calendar_vars['testing']) echo "<h3>MySQL query:<br/><i>$query</i></h3>"; // debug: show query string

    $dataArray = array();
    foreach ($connectionPool as $key => $configuration) {
        $resultARRAY = mysqli_query($configuration['connection'],$query);
        while ($data = $resultARRAY->fetch_array(MYSQLI_ASSOC)) {
            $data['title'] = $data['title'] . ($configuration['master'] === true ? " *" : "");
            $dataArray[$data['title']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $key, 'master' => $configuration['master']);
        }
    }

    foreach($dataArray as $recordArray ) {
        asort($recordArray);
        foreach ($recordArray as $records) {
            foreach ($records as $record) {
                $rowMONTH = $record['data'];

                $rowMONTH['stime'] = format_event_time($rowMONTH['stime']); // turn time into am/pm format
                $rowMONTH['conn'] = $record['dbconnName'];
                $rowMONTH['master'] = $record['master'];
                $events[$rowMONTH['date']][strtotime($rowMONTH['stime'])][] = $rowMONTH; // add data row to event array. accessed via "$events[$datestring]" (e.g. $events['2011-02-05']...note the leading zeros in month/day spots)
            }
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
    else {
        $day = $i - $startday + 1;
        $Current_Date = date('Y-m-d', mktime(0,0,0,$Current_Month,$day,$Current_Year));
        echo '<td class="calendar-full-view-day-square"><strong class="calendar-full-view-date">'. $day . ' &nbsp;</strong>';
        if ($events[$Current_Date])  {
            echo '<ul class="event_list">';
            //var_dump($events[$Current_Date]);
            ksort($events[$Current_Date]);
            $tempEventArr = $events[$Current_Date];
            $events[$Current_Date] = array();
            foreach($tempEventArr as $temp) {
                $events[$Current_Date][] = $temp;
            }
            foreach ($events[$Current_Date] as $event) {
                foreach($event as $e){
                    echo event_to_html($e);
                }
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
<!-- END CALENDAR VIEW -->

</body>

	<script type="text/javascript" src="../java/google-base.js"></script>
	<script type="text/javascript" src="../my-documents/google-code.js"></script>
    <script src="../java/vendor/foundation.min.js"></script>

</html>
