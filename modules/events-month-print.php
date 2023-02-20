<?php
require_once('events-calendar-print_config.php');
require_once('../my-documents/php7-my-db.php');

$connName = isset($_GET['conn']) ? $_GET['conn'] : "none";

if (isset($connectionPool) && isset($connectionPool[$connName])) {
    $dbConn = $connectionPool[$connName]['connection'];
} else {
    $dbConn = $conn;

}



if (!isset($connectionPool) || $connectionPool == null) {
    $connectionPool['default'] = array('priority' => 10, 'connection' =>  $conn, 'master' => false, 'primary' => true);
}

$maName = '';
foreach ($connectionPool as $name => $connDetails) {
    if ($connDetails['master'] === true) {
        $maName = $name;
    }
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
<?php

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
<table width="98%" align="center" border="0" cellpadding="0" cellspacing="1" class="table-rowshade-alternate">
    <tbody>
        <tr>
	      <td align="center" valign="middle" width="300">
	          <img src="../pics/logo-small.png" style="max-width: 300px; max-height: 100px;">
          </td>
	      <td align="right" valign="middle">
            <big><big><big><b><?php echo $month_Names[$Current_Month-1].' '.$Current_Year; ?></b></big></big></big><br>
            <div class="hidden-print"><span align="right"><small>Month: <a href="<?php echo $_SERVER["PHP_SELF"] . "?month=". $prev_month . "&year=" . $prev_year; ?>">Previous</a>&nbsp;|&nbsp;<a href="events-month-print.php">Current</a>&nbsp;|&nbsp;<a href="<?php echo $_SERVER["PHP_SELF"] . "?month=". $next_month . "&year=" . $next_year; ?>">Next</a></small></span>&nbsp;<br></div>

            <div id="calendar-wrap">
                <header>
                    <div class="keys clearfix">
                        <ul>
                            <?php
                            $query  = "SELECT distinct `event` FROM `calendar` WHERE `date` BETWEEN CAST('$Current_Year-$Current_Month-1' AS DATE) AND CAST('$Current_Year-$Current_Month-".cal_days_in_month(CAL_GREGORIAN,$Current_Month,$Current_Year)."' AS DATE)";
                            $calKeyArray = array();
                            foreach ($connectionPool as $connName => $configuration) {
                                $resultARRAY = mysqli_query($configuration['connection'],$query);
                                while($data = $resultARRAY->fetch_array(MYSQLI_ASSOC)) {
                                    if (!in_array($data['event'], $calKeyArray)) {
                                        $calKeyArray[] = $data['event'];
                                    }
                                }
                            }
                            foreach($calKeyArray as $key=> $value) {
                                switch ($value) {
                                    case "Meeting":
                                        echo '<li class="key key__Meeting">Meetings</li>';
                                        break;
                                    case "Class":
                                        echo '<li class="key key__Class">Classes</li>';
                                        break;
                                    case "Event":
                                        echo '<li class="key key__Event">Community Events</li>';
                                        break;
                                    case "Construction":
                                        echo '<li class="key key__Construction">Construction/Maintenance</li>';
                                        break;
                                    case "Elevator":
                                        echo '<li class="key key__Elevator">Elevator</li>';
                                        break;
                                    case "Holiday":
                                        echo '<li class="key key__Holiday">Holiday</li>';
                                        break;
                                    case "Reserved":
                                        echo '<li class="key key__Reserved">Reserved</li>';
                                        break;
                                    case "Social":
                                        echo '<li class="key key__Social">Social</li>';
                                        break;
                                    case "Sport":
                                        echo '<li class="key key__Sport">Sport</li>';
                                        break;
                                    case "Town":
                                        echo '<li class="key key__Town">Town Events</li>';
                                        break;
                                    case 'Other':
                                        echo '<li class="key key__Other">Other</li>';
                                        break;
                                    default:
                                        break;
                                }
                            }
                            ?>
                        </ul>
                        <div align="right"><p><small><b>Note:</b>&nbsp;12:00&nbsp;am&nbsp;Start&nbsp;Times&nbsp;indicate&nbsp;All&nbsp;Day&nbsp;Events,&nbsp;or&nbsp;a&nbsp;Start&nbsp;Time&nbsp;to&nbsp;be&nbsp;determined.&nbsp;&nbsp;</small></p></div>
                        <?php if (!empty($maName) ){
                            $query  = "SELECT `event` FROM `calendar` WHERE `date` BETWEEN CAST('$Current_Year-$Current_Month-1' AS DATE) AND CAST('$Current_Year-$Current_Month-".cal_days_in_month(CAL_GREGORIAN,$Current_Month,$Current_Year)."' AS DATE) LIMIT 1";
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
                        } ?>
                    </div>
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
    $events = array(); // initialize array to store event data
    $query = "SELECT " . $calendar_vars['column_names']; // fields to select from db as set it config file
    $query .= " FROM " . $calendar_vars['db_tablename']; // from tablename as in config file
    $query .= " WHERE date BETWEEN ";  // start date conditions/range
    $query .= " CAST('$Current_Year-$Current_Month-1' AS DATE)"; // set lower end of date range
    $query .= " AND CAST('$Current_Year-$Current_Month-".cal_days_in_month(CAL_GREGORIAN,$Current_Month,$Current_Year)."' AS DATE)"; // set higher end of date range
    $query .= " ORDER BY date,stime"; // order first by date, then by time of day


                    if ($calendar_vars['testing']) echo "<h3>MySQL query:<br/><i>$query</i></h3>"; // debug: show query string

                    $dataArray = array();
                    foreach ($connectionPool as $connName => $configuration) {
                        $resultARRAY = mysqli_query($configuration['connection'],$query);
                        while ($data = $resultARRAY->fetch_array(MYSQLI_ASSOC)) {
                            $data['title'] = $data['title'] . ($configuration['master'] === true ? " *" : "");
                            $dataArray[$data['title']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
                        }
                    }

                    foreach($dataArray as $recordArray ) {
                        asort($recordArray);
                        foreach ($recordArray as $records) {
                            foreach ($records as $record) {
                                $rowMONTH = $record['data'];

                                //$rowMONTH['sorttime'] = strtotime($rowMONTH['stime']);
                                $rowMONTH['stime'] = format_event_time($rowMONTH['stime']); // turn time into am/pm format
                                $rowMONTH['conn'] = $record['dbconnName'];
                                $rowMONTH['master'] = $record['master'];
                                //strtotime($rowMONTH['stime'])
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
            echo "<td style='border: thin solid #999999' align='right' valign='top' height='75px' class='text2'><strong>". $day . " &nbsp;</strong>";
            if ($events[$Current_Date])  {
                echo '<ul class="event_list">';
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
