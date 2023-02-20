<?php $current_page = '4'; include('protect.php'); ?>
<?php require_once('calendar_config.php'); ?>
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="CondoSites - http://www.condosites.com" name="author">
<title>Control Panel</title>
<?php include('../control/cp-head-scripts.php'); ?>
    <script type="application/javascript">
        $(document).ready(function() {
            $("#repeat").click(function() {
                    $("#repeatcriteria").toggle();
                    $("#report_period").val("");
                    $("#daycriteria").hide();
                    $("#weekcriteria").hide();
                    $("#monthcriteria").hide();
                    $("#yearcriteria").hide();
                    $("#eventDate").show();
                });

            $("#report_period").change(function() {
                switch ($(this).val()) {
                    case 'day':
                        $("#eventDate").show();
                        $("#daycriteria").show();
                        $("#weekcriteria").hide();
                        $("#monthcriteria").hide();
                        $("#yearcriteria").hide();
                        break;
                    case 'week':
                        $("#eventDate").show();
                        $("#daycriteria").hide();
                        $("#weekcriteria").show();
                        $("#monthcriteria").hide();
                        $("#yearcriteria").hide();
                        break;
                    case 'month':
                        $("#eventDate").hide();
                        $('[name ="date"]').removeAttr('required');
                        $("#daycriteria").hide();
                        $("#weekcriteria").hide();
                        $("#monthcriteria").show();
                        $("#yearcriteria").hide();
                        break;
                    case 'year':
                        $("#eventDate").hide();
                        $('[name ="date"]').removeAttr('required');
                        $("#daycriteria").hide();
                        $("#weekcriteria").hide();
                        $("#monthcriteria").hide();
                        $("#yearcriteria").show();
                        break;
                    default:
                        alert('Please select criteria');
                }
            });
        });
    </script>
</head>
<body>
<!-- LOGO AND NAVIGATION -->
<?php include('cp-navigation.php'); ?>
<!-- END LOGO AND NAVIGATION -->
<?php
$int1 = $_POST["int1"];
$action = $_POST["action"];
if ($action != null){

	if ($action == "delete" || $action == 'delete_all'){
		$query = "DELETE FROM calendar WHERE `int1`='$int1'";
		$result = mysqli_query($conn,$query) or die('Error, delete query failed');
    
        if (!is_null($_POST['parent_int1'])) {
            $query = "DELETE FROM calendar WHERE `parent_int1`= " . $_POST['parent_int1']. " AND `int1` >= " . $_POST['int1'];
            $result = mysqli_query($conn,$query) or die('Error, delete query failed');
        }

        $errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Your calendar event was deleted successfully.</strong></div>";

        $useripaddress = $_SERVER['REMOTE_ADDR'];
        $userid = $_SESSION['id'];
        $id = $_POST['int1'];

        $query = "INSERT INTO log (action, tablename, comment, useripaddress, userid, id) VALUES ('D', 'Calendar', 'Delete event from Calendar', '$useripaddress', '$userid', '$id')";
        $result = mysqli_query($conn,$query) or die('Error, log insert query failed');

        $query = "OPTIMIZE TABLE `calendar`";
        $result = mysqli_query($conn,$query) or die('Error, optimize calendar failed');
    }

    if ($action == "Add Event"){
		$title = htmlspecialchars($_POST['title'], ENT_QUOTES);

        if (empty($_POST['date']) || !isset($_POST['date'])) {
            $date = date('Y-m-d');
        } else {
            $date = $_POST["date"];
        }
        $stime = $_POST["stime"];
        $etime = $_POST["etime"];
        $url = htmlspecialchars($_POST['url'], ENT_QUOTES);
        $email = htmlspecialchars($_POST['email'], ENT_QUOTES);
        $details = $_POST["details"];
        $location = preg_replace('/[^a-zA-Z0-9 ]/', '', $_POST['location']);
        $detailsmini = preg_replace('/[^a-zA-Z ]/', '', $_POST['detailsmini']);
        $docid = $_POST["docid"];
        $event = $_POST["event"];

        $request = array( 'repeat' => $_POST['repeat'],
                          'repeat_period' => $_POST['repeat_period'],
                          'repeat_occurance_month' => $_POST['repeat_occurance_month'],
                          'repeat_month_week' => $_POST['repeat_month_week'],
                          'repeat_month_day' => $_POST['repeat_month_day'],
                          'repeat_year_month' => $_POST['repeat_year_month'],
                          'repeat_year_week' => $_POST['repeat_year_week'],
                          'repeat_year_day' => $_POST['repeat_year_day'],
                          'repeat_occurance_day' => $_POST['repeat_occurance_day'],
                          'repeat_week_days' => $_POST['repeat_week_days'],
                          'repeat_occurance_week' => $_POST['repeat_occurance_week']
                        );
        $cal_json = json_encode($request);

        if ($_POST['repeat'] == 'on') {
            // Calculate starting dates
            if ($_POST['repeat_period'] == 'month') {

                $nextMonthIncrement = $_POST['repeat_month_week'] . " " . $_POST['repeat_month_day'];

                // First of the current month
                $firstOfMonth = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
                $scheduledDate = date('Y-m-d', strtotime($nextMonthIncrement . ' of ' . $firstOfMonth));

                if ($date > $scheduledDate) {
                  $date =  date('Y-m-d', mktime(0, 0, 0, date('m')+1, 1, date('Y')));
                }

                if ( (strcasecmp($_POST['repeat_month_week'], 'first') == 0) && (strcasecmp($_POST['repeat_month_day'], 'day') == 0)) {
                    $date1 = $date;
                } else {
                    $date1 = date('Y-m-d', strtotime($nextMonthIncrement . ' of ' . $date));
                }
                $date = $date1;
            }

            if ($_POST['repeat_period'] == 'year') {

                $todayDate = date('Y-m-01');
                $scheduleDate = date('Y-m-d', strtotime('First day of ' . $_POST['repeat_year_month']));

                if ($todayDate > $scheduleDate) {
                    $scheduleDate = date('Y-m-d', strtotime('+1 year', strtotime($scheduleDate)));
                }

                $yearIncrement = $_POST['repeat_year_week'] . " " . $_POST['repeat_year_day'];
                $date = date('Y-m-d', strtotime($yearIncrement . ' ' . $scheduleDate));
            }
        }

        $parentID = 0;
        // Save the initial record
        if ($_POST['repeat_period'] != 'week') {
            $query = "INSERT INTO calendar (title, date, stime, etime, url, email, details, location, detailsmini, docid, event, cal_json) VALUES ('$title', '$date', '$stime', '$etime', '$url', '$email', '$details', '$location', '$detailsmini', '$docid', '$event', '$cal_json')";

            $result = mysqli_query($conn, $query) or die('Error, insert query failed');
            $parentID = $conn->insert_id;
        }

        // Repeating Events
        if ($_POST['repeat'] == 'on') {
            $query = 'UPDATE calendar set `parent_int1` = `int1` WHERE `int1` = ' . $parentID;
            $result = mysqli_query($conn,$query) or die('Error, update calendar query failed');

            // Daily
            if ($_POST['repeat_period'] == 'day') {
                $newDate = $date;
                $repeatOccuranceDay = empty($_POST['repeat_occurance_day']) ? 1 : $_POST['repeat_occurance_day'];

                for($i=0; $i< (ceil(365/$repeatOccuranceDay )); $i++) {
                    $increment = "+" . $repeatOccuranceDay . " day";
                    $newDate = strftime('%Y-%m-%d', strtotime($increment,strtotime($newDate)));
                    $query = "INSERT INTO calendar (title, date, stime, etime, url, email, details, location, detailsmini, docid, event, parent_int1, cal_json) VALUES ('$title', '$newDate', '$stime', '$etime', '$url', '$email', '$details', '$location', '$detailsmini', '$docid', '$event', '$parentID', '$cal_json')";
                    $result = mysqli_query($conn,$query) or die('Error, insert query failed');
                }
            }

            //Weekly
            if ($_POST['repeat_period'] == 'week') {
                $repeatOccuranceWeek = empty($_POST['repeat_occurance_week']) ? 1 : $_POST['repeat_occurance_week'];

                foreach($_POST['repeat_week_days'] as $key=>$weekday) {

                    $nextDayIncrement = "next " . $weekday;
                    $weekIncrement = "+" . $repeatOccuranceWeek . " week";
                    if (strcasecmp(date('l', strtotime($date)), $weekday) == 0) {
                        $newDate = $date;
                    } else {
                        $newDate = date('Y-m-d', strtotime($nextDayIncrement, strtotime($date)));
                    }
                    for($i=0; $i< (ceil(52/$repeatOccuranceWeek)); $i++) {
                        $query = "INSERT INTO calendar (title, date, stime, etime, url, email, details, location, detailsmini, docid, event, parent_int1, cal_json) VALUES ('$title', '$newDate',  '$stime', '$etime', '$url', '$email', '$details', '$location', '$detailsmini', '$docid', '$event', '$parentID', '$cal_json')";
                        $result = mysqli_query($conn,$query) or die('Error, insert query failed');
                        if ($parentID == 0) {
                            $parentID = $conn->insert_id;
                            $query = 'UPDATE calendar set `parent_int1` = `int1` WHERE `int1` = ' . $parentID;
                            $result = mysqli_query($conn,$query) or die('Error, update calendar query failed');
                        }

                        $newDate = strftime('%Y-%m-%d', strtotime($weekIncrement,strtotime($newDate)));
                    }
                }
            }

            // Monthly
            if ($_POST['repeat_period'] == 'month') {
                $newDate = $date;
                $repeatOccuranceMonth = empty($_POST['repeat_occurance_month']) ? 1 : $_POST['repeat_occurance_month'];
                $monthIncrement = "+" . $repeatOccuranceMonth . " month";
                $nextMonthIncrement = $_POST['repeat_month_week'] . " " . $_POST['repeat_month_day'];

                for($i=1; $i<=12; $i+=$repeatOccuranceMonth) {
                    $newDate = date('Y-m-01', strtotime($monthIncrement, strtotime($newDate)));
                    if ( (strcasecmp($_POST['repeat_month_week'], 'first') == 0) && (strcasecmp($_POST['repeat_month_day'], 'day') == 0)) {
                        $calDate = $newDate;
                    } else {
                        $calDate = date('Y-m-d', strtotime($nextMonthIncrement . ' of ' . $newDate));
                    }

                    $query = "INSERT INTO calendar (title, date, stime, etime, url, email, details, location, detailsmini, docid, event, parent_int1, cal_json) VALUES ('$title', '$calDate',  '$stime', '$etime', '$url', '$email', '$details', '$location', '$detailsmini', '$docid', '$event', '$parentID', '$cal_json')";
                    $result = mysqli_query($conn,$query) or die('Error, insert query failed');
                }
            }
        }
	}
  
    $errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Your calendar event was added successfully.</strong></div>";

	$date = date("F j, Y");
	$query = "UPDATE updatedate SET date='$date'";
	mysqli_query($conn,$query) or die('Error, updating update date failed');
}
?>
<!-- HEALTH AND HELP -->
<div>
    <div class="large-8 columns" style="padding: 0px">
        <div class="nav-section-header-health-cp" align="center">
<big><i class="fa fa-stethoscope" aria-hidden="true"></i></big><strong>&nbsp;Health&nbsp;&nbsp;&nbsp;</strong>
<?php $sqlCALc = mysqli_query($conn,"SELECT count(*) FROM calendar") or die(mysqli_error($conn));
//$countCALc = mysql_result($sqlCALc, "0");
$row = mysqli_fetch_row($sqlCALc);
$countCALc = $row[0];
?>
<?php $sqlCAL = mysqli_query($conn,"SELECT count(*) FROM calendar WHERE date >= CURRENT_DATE() AND `event` != 'Holiday'") or die(mysqli_error($conn));
//$countCAL = mysql_result($sqlCAL, "0");
$row = mysqli_fetch_row($sqlCAL);
$countCAL = $row[0];
?>
<?php if ($countCAL == '0' AND $countCALc == '0'){ ?><i class="fa fa-exclamation-triangle note" aria-hidden="true"></i> You should populate the calendar!<?php }; ?>
<?php if ($countCAL == '0' AND $countCALc >= '1'){ ?><i class="fa fa-exclamation-triangle note" aria-hidden="true"></i> There are no more events left on the calendar<?php }; ?>
<?php if ($countCAL == '1'){ ?><i class="fa fa-exclamation-triangle note" aria-hidden="true"></i> There is only <b>1</b> event left on the calendar<?php }; ?>
<?php if ($countCAL == '2'){ ?><i class="fa fa-exclamation-triangle note" aria-hidden="true"></i> There are only <b>2</b> events left on the calendar<?php }; ?>
<?php if ($countCAL >= '3'){ ?><i class="fa fa-check" aria-hidden="true"></i> Awesome! There are <b><?php print($countCAL); ?></b> more events on the calendar.<?php }; ?>
        </div>
    </div>
    <div class="large-4 columns" style="padding: 0px">
        <div class="nav-section-header-help-cp" align="center">
            <strong><big><i class="fa fa-hand-o-right" aria-hidden="true"></i></big>&nbsp;Hands&nbsp;point&nbsp;to&nbsp;tips!</strong>
        </div>
    </div>
</div>
<!-- HEALTH AND HELP -->
<br>&nbsp;
<div style="max-width: 99%;">

<div class="row cp-help">
    <div class="small-12 medium-6 columns">
        <p>The <b>Calendar</b> control panel is used to tell your community about important dates and events both within your community and your local neighborhood.
        There is room to add plenty of information about the event.</p>
        <p>
    </div>
    <div class="small-12 medium-6 columns">
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#add"><b>Add a Calendar Event</b></a> using the addition form below.</p>
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#edit"><b>View and Edit</b></a> existing entries in your database.</p>
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#modulepermissions"><b>Module Permissions</b></a> allow you to choose what content should be seen by which groups of users.</p>
    </div>
</div>

<!-- UPLOAD FORM -->
<a name="add"></a>
<div class="nav-section-header-cp">
        <strong>Add a Calendar Event</strong>
</div>
<?php echo($errorSUCCESS); ?>
<form enctype="multipart/form-data" method="POST" action="calendar.php">
<div class="cp-form-container">
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 0px 0px;">
            <div class="small-12 medium-12 columns"><strong>1) Event Information</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="event" class="middle">Event Type</label></div>
            <div class="small-12 medium-7 end columns">
<select name="event" required autofocus>
<option value="">Select an Event Category</option>
<option value="Meeting" <?php if($row['event'] == "Meeting"){ echo("SELECTED"); } ?>>Meeting</option>
<option value="Class" <?php if($row['event'] == "Class"){ echo("SELECTED"); } ?>>Class</option>
<option value="Construction" <?php if($row['event'] == "Construction"){ echo("SELECTED"); } ?>>Construction/Maintenance</option>
<option value="Elevator" <?php if($row['event'] == "Elevator"){ echo("SELECTED"); } ?>>Elevator</option>
<option value="Event" <?php if($row['event'] == "Event"){ echo("SELECTED"); } ?>>Community Event</option>
<option value="Holiday" <?php if($row['event'] == "Holiday"){ echo("SELECTED"); } ?>>Holiday</option>
<option value="Reserved" <?php if($row['event'] == "Reserved"){ echo("SELECTED"); } ?>>Reserved</option>
<option value="Sport" <?php if($row['event'] == "Sport"){ echo("SELECTED"); } ?>>Sport</option>
<option value="Social" <?php if($row['event'] == "Social"){ echo("SELECTED"); } ?>>Social</option>
<option value="Town" <?php if($row['event'] == "Town"){ echo("SELECTED"); } ?>>Town Event</option>
<option value="Other" <?php if($row['event'] == "Other"){ echo("SELECTED"); } ?>>Other</option>
</select>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="title" class="middle">Event Title</label></div>
            <div class="small-12 medium-7 end columns"><input name="title" size="40" maxlength="100" class="form" type="text" placeholder="Board of Directors Meeting" required></div>
        </div>
        <div class="row" style="padding: 10px 10px 0px 0px;">
            <div class="small-12 medium-12 columns"><strong>2) Dates and Times</strong></div>
        </div>

        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="repeat" class="middle">Is this a Repeating Event? &nbsp;<input type="checkbox" name="repeat" id="repeat" style="margin-bottom: -23px;"/></label></div>
            <div class="small-12 medium-7 end columns">
                <div id="repeatcriteria" style="display: none">
                    <select name="repeat_period" id="report_period">
                        <option value="">Select Occurance</option>
                        <option value="day">Daily</option>
                        <option value="week">Weekly</option>
                        <option value="month">Monthly</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- repeat daily -->
        <div style="display: none" id="daycriteria">
            <div class="row medium-collapse" style="padding-left: 30px;">
                <div class="small-12 medium-6 columns"><label for="repeat_occurance_day" class="middle">Every how many day(s)?&nbsp;
                    <br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Example: 2 will create an event for every other day.</span>
                    <br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Events will add to the Calendar for one year.</span>
                </label></div>
                <div class="small-6 medium-3 end columns"><input type="text" name="repeat_occurance_day" placeholder="1" maxlength="3" size="3" class="form"></div>
            </div>
        </div>
        
        <!-- repeat weekly -->
        <div style="display: none" id="weekcriteria">
            <div class="row medium-collapse" style="padding-left: 30px;">
                <div class="small-12 medium-6 columns"><label for="repeat_occurance_week" class="middle">Every how many week(s)?&nbsp;
                    <br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Example: 2 will create an event for every other week.</span>
                    <br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Events will add to the Calendar for one year.</span>
                </label></div>
                <div class="small-6 medium-3 end columns"><input type="text" name="repeat_occurance_week" placeholder="1" maxlength="3" size="3" class="form"></div>
            </div>
            <div class="row medium-collapse" style="padding-left: 30px;">
                <div class="small-12 medium-5 columns"><label for="title" class="middle">On what days?&nbsp;<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Hold the Command (Mac) / Ctrl (PC) key to select multiple days.</span></label></div>
                <div class="small-12 medium-7 end columns">
                    <select name="repeat_week_days[]" id="repeat_days" multiple="true" size="7">
                        <option value="sunday">Sunday</option>
                        <option value="monday">Monday</option>
                        <option value="tuesday">Tuesday</option>
                        <option value="wednesday">Wednesday</option>
                        <option value="thursday">Thursday</option>
                        <option value="friday">Friday</option>
                        <option value="saturday">Saturday</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- repeat monthly -->
        <div style="display: none" id="monthcriteria">
            <div class="row medium-collapse" style="padding-left: 30px;">
                <div class="small-12 medium-6 columns"><label for="repeat_occurance_month" class="middle">Every how many month(s)?&nbsp;
                    <br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Example: 2 will create an event for every other month.</span>
                    <br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Events will add to the Calendar for one year.</span>
                </label></div>
                <div class="small-6 medium-3 end columns"><input type="text" name="repeat_occurance_month" placeholder="1" maxlength="3" size="3" class="form"></div>
            </div>
            <div class="row medium-collapse" style="padding-left: 30px;">
                <div class="small-12 medium-5 columns"><label for="title" class="middle">On the&nbsp;</label></div>
                <div class="small-12 medium-3 end columns">
                    <select name="repeat_month_week" id="repeat_month_week">
                        <option value="first">First</option>
                        <option value="second">Second</option>
                        <option value="third">Third</option>
                        <option value="fourth">Fourth</option>
                        <option value="last">Last</option>
                    </select>
                </div>
                <div class="hide-on-small medium-1 end columns">&nbsp;</div>
                <div class="small-12 medium-3 end columns">
                    <select name="repeat_month_day" id="repeat_month_day">
                        <option value="day">Day of the Month</option>
                        <option value="weekday">Weekday of the Month</option>
                        <option value=""></option>
                        <option value="sunday">Sunday of the Month</option>
                        <option value="monday">Monday of the Month</option>
                        <option value="tuesday">Tuesday of the Month</option>
                        <option value="wednesday">Wednesday of the Month</option>
                        <option value="thursday">Thursday of the Month</option>
                        <option value="friday">Friday of the Month</option>
                        <option value="saturday">Saturday of the Month</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row medium-collapse" style="padding-left: 30px;" id="eventDate">
            <div class="small-12 medium-5 columns"><label for="date" class="middle">Date of the Event</label></div>
            <div class="small-12 medium-7 end columns"><input name="date" class="form datepicker" type="date" required></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="stime" class="middle">Start Time</label></div>
            <div class="small-12 medium-7 end columns">
                <select name="stime">
                    <option value="">Start Time</option>
                    <option value="" disabled> </option>
    <?php
    $i=0;
    $range=range(strtotime("05:00"),strtotime("24:59"),15*60);
    foreach($range as $time){
       // echo date("H:i",$time)."\n";
        print '<option value=' . date("H:i:s",$time) . '>' . date("h:i A",$time) . '</option>';
        $i+=1;
        if ($i == 4) {
            print '<option value="" disabled> </option>';
            $i=0;
        }
    }
    $i=0;
    $range=range(strtotime("01:00"),strtotime("4:59"),15*60);
    foreach($range as $time){
        //echo date("H:i",$time)."\n";
        print '<option value=' . date("H:i:s",$time) . '>' . date("h:i A",$time) . '</option>';
        $i+=1;
        if ($i == 4) {
            print '<option value="" disabled> </option>';
            $i=0;
        }
    }
    ?>
                </select>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="etime" class="middle">End Time</label></div>
            <div class="small-12 medium-7 end columns">
                <select name="etime">
                    <option value="">End Time</option>
                    <option value="" disabled> </option>
    <?php
    $i=0;
    $range=range(strtotime("05:00"),strtotime("24:59"),15*60);
    foreach($range as $time){
        //echo date("H:i",$time)."\n";
        print '<option value=' . date("H:i:s",$time) . '>' . date("h:i A",$time) . '</option>';
        $i+=1;
        if ($i == 4) {
            print '<option value="" disabled> </option>';
            $i=0;
        }
    }
    $i=0;
    $range=range(strtotime("01:00"),strtotime("4:59"),15*60);
    foreach($range as $time){
        //echo date("H:i",$time)."\n";
        print '<option value=' . date("H:i:s",$time) . '>' . date("h:i A",$time) . '</option>';
        $i+=1;
        if ($i == 4) {
            print '<option value="" disabled> </option>';
            $i=0;
        }
    }
    ?>
                </select>
            </div>
        </div>
        <div class="row" style="padding: 10px 10px 0px 0px;">
            <div class="small-12 medium-12 columns"><strong>3) Details...</strong></div>
        </div>
		<div class="row medium-collapse" style="padding-left: 30px; padding-bottom: 20px;">
			<div class="small-12 medium-12 columns"><label for="details" class="middle">Event Description and Details<br>
			        <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">This information IS visible to the user.</span><br>
			        <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">If pasting content from Microsoft Word, use the "Paste from Word" ( <img src="https://condosites.net/commons/pastefromword.png" width="15"> ) button.</span><br>
			        <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Use the Styles pulldown to apply <b><span class="bluepen">c</span><span class="greenpen">o</span><span class="bluepen">l</span><span class="greenpen">o</span><span class="bluepen">r</span></b> and formatting <span class="marker">styles</span> to your text.</span>
			    </label>
				<textarea name="details" cols="30" rows="2" id="editor1" class="form" type="text" placeholder="Enter Meeting/Event description and details..." required></textarea>
				<script>CKEDITOR.replace( 'editor1' );</script>
			</div>
		</div>
    </div>
    <div class="small-12 medium-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 0px 0px;">
            <div class="small-12 medium-12 columns"><strong>4) Extra Details...</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="location" class="middle">Add a location?<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">100 characters maximum.</span><br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Letters and numbers only.</span></label></div>
            <div class="small-12 medium-7 end columns"><input name="location" placeholder="Clubhouse" maxlength="100" class="form" type="text"></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="email" class="middle">Add an email address?</label></div>
            <div class="small-12 medium-7 end columns"><input name="email" placeholder="email@email.com" maxlength="100" class="form" type="email"></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="url" class="middle">Add a link to a website?</label></div>
            <div class="small-12 medium-7 end columns"><input name="url" placeholder="http://www.mytown.com" maxlength="100" class="form" type="url"></div>
        </div>
<?php include('docid-field.php'); ?>
		<div class="row medium-collapse" style="padding-left: 30px; padding-bottom: 20px;">
			<div class="small-12 medium-12 columns"><label for="detailsmini" class="middle">Event description and details for external calendar applications<br>
			<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">This information is included in iCal/Outlook calendar links.</span><br>
			<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Do NOT use HTML or special characters.</span>
			<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">500 characters maximum.</span></label>
				<textarea name="detailsmini" maxlength="500" cols="45" rows="4"></textarea>
			</div>
		</div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-6 columns"><strong>5) Ready to Save?</strong></div>
            <div class="small-12 medium-6 columns">
	            <input name="action" value="Add Event" type="submit">
            </div>
        </div>
        <div class="row medium-collapse">
            <div class="small-12 medium-12 columns" align="center">
<br><i class="fa fa-hand-o-down" aria-hidden="true"></i> Scroll down to see the calendar events already added.
            </div>
        </div>
    </div>
</div>
</form>
<!-- END UPLOAD FORM -->
<a name="edit"></a>
<br>
<div class="nav-section-header-cp">
        <strong>3 Most Recent Entries</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr align="left">
      <th><b>&nbsp;&nbsp;&nbsp; <small>Event</small></b></th>
      <th width="50" class="table-sortable:numeric">&nbsp;&nbsp;&nbsp; <small>ID</small></th>
      <th><b>&nbsp;&nbsp;&nbsp; <small>Date</small></b></th>
      <th><b>&nbsp;&nbsp;&nbsp; <small>Time</small></b></th>
      <th><b>&nbsp;&nbsp;&nbsp; <small>Event</small></b></th>
  </thead>
  <tbody style="background-color:#ffffff">
<!-- DATABASE RESULTS -->
<?php
	$query  = "SELECT * FROM calendar WHERE (`parent_int1` IS NULL) OR (`parent_int1` = `int1`) ORDER BY `int1` DESC LIMIT 3";
	$result = mysqli_query($conn, $query);
  

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
    
    if (is_null($row['parent_int1']) || $row['parent_int1'] == 0) {
      $repeatCount = "SELECT `int1` FROM calendar where parent_int1 = " . $row['int1'];
      $repeatRS = mysqli_query($conn, $repeatCount);
      $rowcount=mysqli_num_rows($repeatRS);
      
      $rowcount = is_null($rowcount) ? 0 : $rowcount;
      
      if ($rowcount > 0) {
        $row['parent_int1'] = $row['parent_int1'];  
      }
    }
    
      
?>
<!-- DATABASE RESULTS -->
    <tr>
      <td>
        <div class="small-12 medium-12 large-9 columns" style="min-height:45px;">
          <b><?php echo "{$row['title']}"; ?></b><br>
<?php if ($row['location'] !== ''){ ?><blockquote><?php echo "{$row['location']}"; ?></blockquote><?php }; ?>
<?php if ($row['details'] !== ''){ ?><blockquote><?php echo "{$row['details']}"; ?></blockquote><?php }; ?>
<span class="note-black">
<?php if ($row['url'] !== ''){ ?><a href="<?php echo "{$row['url']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('External/<?php echo "{$row['url']}"; ?>'); "><?php echo "{$row['url']}"; ?></a><?php }; ?>
<?php if ($row['email'] !== ''){ ?>&nbsp;|&nbsp;<a href="mailto:<?php echo "{$row['email']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('Email/<?php echo "{$row['email']}"; ?>'); "><?php echo "{$row['email']}"; ?></a><?php }; ?>
<?php if ($row['docid'] !== ''){ ?>
	<?php
  
		$type    = $row['docid'];
		$queryDOC  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
		$resultDOC = mysqli_query($conn,$queryDOC);

		while($rowDOC = $resultDOC->fetch_array(MYSQLI_ASSOC))
		{
      
	?>
		&nbsp;|&nbsp;Link to Document <?php echo "{$rowDOC['title']}"; ?>
	<?php
		}
	?>
<?php }; ?>
</span>
        </div>
		<div class="small-4 medium-4 large-3 columns">
            <form name="CalDup" method="POST" action="calendar-duplicate.php">
                <input type="hidden" name="action" value="duplicate">
                <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
                <input name="submit" value="Copy" class="submit" type="submit">
            </form>
            <br>
		</div>
        <div class="small-4 medium-4 large-3 columns">
            <form name="CalEdit" method="POST" action="calendar-edit.php">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
                <input name="submit" value="Edit" class="submit" type="submit">
            </form>
            <br>
		</div>
		<div class="small-4 medium-4 large-3 columns">
            <form name="CalDelete" method="POST" action="calendar.php" onclick="return confirm('Are you sure you want to delete <?php echo "{$row['title']}"; ?> on <?php echo "{$row['date']}"; ?>?');">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
                <?php if (!is_null($row['parent_int1'])) { ?> 
                <input name="submit" value="Delete Occurance" class="submit" type="submit">
                <?php } else { ?>
                <input name="submit" value="Delete" class="submit" type="submit">
                <?php } ?>
            </form>
            <?php if (!is_null($row['parent_int1'])) { ?> 
              <form name="CalDeleteSeries" method="POST" action="calendar.php" onclick="return confirm('Are you sure you want to delete all the repeating events  <?php echo "{$row['title']}"; ?> on <?php echo "{$row['date']}"; ?>?');">
                  <input type="hidden" name="action" value="delete_all">
                  <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
                  <input type="hidden" name="parent_int1" value="<?php echo "{$row['parent_int1']}"; ?>">
                  <input name="submit" value="Delete Series" class="submit" type="submit">
              </form>
              <br>
            <?php } ?>
		</div>

      </td>
      <td><?php echo "{$row['int1']}"; ?></td>
      <td><?php if ($row['date'] !== '0000-00-00'){ ?><?php echo "{$row['date']}"; ?><?php }; ?><?php if ($row['date'] == '0000-00-00'){ ?><i>ongoing</i><?php }; ?><?php if ($row['parent_int1'] != NULL){ ?><br><i>Repeating Event</i><?php }; ?></td>
      <td><?php if ($row['stime'] !== '00:00:00'){ ?><?php echo date('g:i a', strtotime($row['stime'])); ?><?php }; ?><?php if ($row['etime'] !== '00:00:00'){ ?> - <?php echo date('g:i a', strtotime($row['etime'])); ?><?php }; ?></td>
      <td><?php echo "{$row['event']}"; ?></td>
    </tr>
<!-- END DATABASE RESULTS -->
<?php
	}
?>
  </tbody>
</table>
<br>
<!-- CALENDAR VIEW -->
<div class="nav-section-header-cp">
        <strong><?php $sql = mysqli_query($conn,"SELECT count(*) FROM calendar WHERE date >= CURRENT_DATE()") or die(mysqli_error($conn));
        //$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
        $count = $row[0];
        print($count); ?> Future Events</strong>
</div>

<!-- Calendar Setup -->
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
<!-- End Calendar Setup -->

<!-- MONTH VIEW -->
<!-- CONTENT -->
  <div id="calendar-wrap" class="calendar-full-view">
<!-- Calendar Headline -->
  <header>
  <div class="row">
    <div class="small-12 medium-5 large-4 columns">
		<h3><strong><?php echo $month_Names[$Current_Month-1].' '.$Current_Year; ?><a name="month"></a></strong></h3>
    </div>
	<div class="small-12 medium-7 large-8 columns">
		<p class="text-right">Month: <b><a href="<?php echo $_SERVER["PHP_SELF"] . "?month=". $prev_month . "&year=" . $prev_year . "#month"; ?>">Previous</a>&nbsp;|&nbsp;<a href="calendar.php#month">Current</a>&nbsp;|&nbsp;<a href="<?php echo $_SERVER["PHP_SELF"] . "?month=". $next_month . "&year=" . $next_year . "#month"; ?>">Next</a></b></p>
	</div>
      <div class="keys">
        <ul>
	    <li class="key key__Other">Other</li>
	    <li class="key key__Town">Town Events</li>
	    <li class="key key__Sport">Sport</li>
	    <li class="key key__Social">Social</li>
	    <li class="key key__Reserved">Reserved</li>
	    <li class="key key__Holiday">Holiday</li>
	    <li class="key key__Construction">Construction/Maintenance</li>
	    <li class="key key__Elevator">Elevator</li>
	    <li class="key key__Event">Community Events</li>
	    <li class="key key__Class">Classes</li>
	    <li class="key key__Meeting">Meetings</li>
        </ul>
      </div>
      <div align="right"><p><small><b>Note:</b>&nbsp;12:00&nbsp;am&nbsp;Start&nbsp;Times&nbsp;indicate&nbsp;All&nbsp;Day&nbsp;Events,&nbsp;or&nbsp;a&nbsp;Start&nbsp;Time&nbsp;to&nbsp;be&nbsp;determined.&nbsp;&nbsp;</small></p></div>
	  </div>
<!-- Events Key -->
  </header>
<table width="100%" border="0" cellpadding="0" cellspacing="1">
  <thead>
    <tr>
      <td width="13%" style="background-color: #3A474D;"><div class="weekdays show-for-large">Sunday</div><div class="weekdays show-for-medium-only">Sun</div><div class="weekdays show-for-small-only rotate90"><small>Sun</small></div></td>
      <td width="13%" style="background-color: #3A474D;"><div class="weekdays show-for-large">Monday</div><div class="weekdays show-for-medium-only">Mon</div><div class="weekdays show-for-small-only rotate90"><small>Mon</small></div></td>
      <td width="13%" style="background-color: #3A474D;"><div class="weekdays show-for-large">Tuesday</div><div class="weekdays show-for-medium-only">Tue</div><div class="weekdays show-for-small-only rotate90"><small>Tue</small></div></td>
      <td width="13%" style="background-color: #3A474D;"><div class="weekdays show-for-large">Wednesday</div><div class="weekdays show-for-medium-only">Wed</div><div class="weekdays show-for-small-only rotate90"><small>Wed</small></div></td>
      <td width="13%" style="background-color: #3A474D;"><div class="weekdays show-for-large">Thursday</div><div class="weekdays show-for-medium-only">Thu</div><div class="weekdays show-for-small-only rotate90"><small>Thu</small></div></td>
      <td width="13%" style="background-color: #3A474D;"><div class="weekdays show-for-large">Friday</div><div class="weekdays show-for-medium-only">Fri</div><div class="weekdays show-for-small-only rotate90"><small>Fri</small></div></td>
      <td width="13%" style="background-color: #3A474D;"><div class="weekdays show-for-large">Saturday</div><div class="weekdays show-for-medium-only">Sat</div><div class="weekdays show-for-small-only rotate90"><small>Sat</small></div></td>
    </tr>
  </thead>
  <tbody>
<!-- CALENDAR DAYS -->
<?php

/* Build MySQL query */
    
	$query = "SELECT stime, title, event, date, detailsmini, location, `int1`, `parent_int1`, if(parent_int1 is null, 'none', 'inline') as showdel FROM `calendar` WHERE date BETWEEN ";  // start date conditions/range
	$query .= " CAST('$Current_Year-$Current_Month-1' AS DATE)"; // set lower end of date range
	$query .= " AND CAST('$Current_Year-$Current_Month-".cal_days_in_month(CAL_GREGORIAN,$Current_Month,$Current_Year)."' AS DATE)"; // set higher end of date range
	$query .= " ORDER BY date, stime"; // order first by date, then by time of day

if ($calendar_vars['testing']) echo "<h3>MySQL query:<br/><i>$query</i></h3>"; // debug: show query string

$results = mysqli_query($conn, $query); // query MySQL
if (!$results) // exit if query fails
{
	if ($calendar_vars['testing']) die(mysqli_error($conn)); // debug: MySQL query error
	else die;
}
else // if query returns positive results
{
	$events = array(); // initialize array to store event data
	while ($rowMONTH = mysqli_fetch_assoc($results)) // loop through results
	{
		$rowMONTH['stime'] = format_event_time($rowMONTH['stime']); // turn time into am/pm format
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
<!-- END CALENDAR VIEW -->
<br>
</div>
<!-- MODULE PERMISSIONS -->
<a name="modulepermissions"></a>
<br>
<div style="max-width: 99%;">
<div class="nav-section-header-cp">
    <strong>Module Permissions</strong>
</div>
<br>
<div class="cp-help">
    <div class="small-12 medium-6 columns">
        <p><b>Module Permissions allow you to choose what content should be seen by which groups of users.</b></p>
    </div>
    <div class="small-12 medium-6 columns">
        <p>
            <i class="fa fa-hand-o-right" aria-hidden="true"></i> You may choose to use a combination of modules with different permissions.
        </p>
    </div>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
    <thead>
        <tr align="left" valign="middle">
            <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Module</small></th>
            <th width="50" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>ID</small></th>
            <th class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <small>Tab</small></th>
			<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Owner</small></b></div></th>
			<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Renter</small></b></div></th>
			<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Realtor</small></b></div></th>
            <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Home</small></b></div></th>
        </tr>
    </thead>
    <tbody style="background-color:#ffffff">
<!-- TABS PERMISSION EDITS -->
<?php
	$module = "calendar.php";
	$query  = "SELECT * FROM tabs WHERE liaison = 'Y' AND `int1` BETWEEN '210' AND '210' ORDER BY `int1`";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php include('tabs-modulelist.php'); ?>
<?php
	}
?>
<!-- END TABS PERMISSION EDITS -->
        <tr>
            <td>
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">The module <b>above</b> contains all the entries in this module.</span><br>
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">The modules <b>below</b> contain just that subset entries.</span><br>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
<!-- TABS PERMISSION EDITS -->
<?php
	$module = "calendar.php";
	$query  = "SELECT * FROM tabs WHERE liaison = 'Y' AND `int1` BETWEEN '211' AND '219' ORDER BY `int1`";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php include('tabs-modulelist.php'); ?>
<?php
	}
?>
<!-- END TABS PERMISSION EDITS -->
    </tbody>
</table>
</div>
<br>

<div class="small-12 medium-12 large-12 columns note-black"><br><br>Calendar Control Panel Page<br></div>
</body>
</html>
