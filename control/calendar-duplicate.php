<?php
$current_page = '4';
include('protect.php');
$int1 = $_POST["int1"];
$action = $_POST["action"];
$errorSUCCESS="";
if ($action == "save"){

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

        $query = 'UPDATE calendar set `parent_int1` = `int1` WHERE `int1` = ' . $parentID;
        $result = mysqli_query($conn,$query) or die('Error, update parent id calendar query failed');
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
                $result = mysqli_query($conn,$query) or die('Error, Daily insert query failed');
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
                    $result = mysqli_query($conn,$query) or die('Error, Weekly insert query failed');
                    if ($parentID == 0) {
                        $parentID = $conn->insert_id;
                        $query = 'UPDATE calendar set `parent_int1` = `int1` WHERE `int1` = ' . $parentID;
                        $result = mysqli_query($conn,$query) or die('Error, Weekly update calendar query failed');
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
                $result = mysqli_query($conn,$query) or die('Error, Monthly insert query failed');
            }
        }
    }

    $errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Your calendar event was added successfully.</strong></div>";

    $date = date("F j, Y");
    $query = "UPDATE updatedate SET date='$date'";
    $result = mysqli_query($conn,$query) or die('Error, Update updatedate query failed');

    $useripaddress = $_SERVER['REMOTE_ADDR'];
    $userid = $_SESSION['id'];
    $id = $_POST['int1'];
    $query = "INSERT INTO log (action, tablename, comment, useripaddress, userid, id) VALUES ('E', 'Calendar', 'Calendar event update', '$useripaddress', '$userid', '$id')";
    $result = mysqli_query($conn,$query) or die('Error, insert log query failed');

    header('Location: calendar-duplicate.php');
}
?>
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">
<head>
<meta charset="UTF-8">
<meta content="CondoSites - http://www.condosites.com" name="author">
<title>Control Panel</title>
<?php include('../control/cp-head-scripts.php'); ?>
    <script type="application/javascript">
        $(document).ready(function() {
            $("#repeat").click(function() {

                if ( !($("#repeat").prop("checked")) ) {
                    $("#repeatcriteria").hide();
                    $("#daycriteria").hide();
                    $("#weekcriteria").hide();
                    $("#monthcriteria").hide();
                    $("#yearcriteria").hide();
                    $("#eventDate").hide();
                } else {
                    $("#repeatcriteria").show();
                    trigger_report_period();
                }
            });

            if ( $("#repeat").prop("checked") ) {
                $("#repeatcriteria").show();
                trigger_report_period();
            }

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

            function trigger_report_period() {
                switch ($("#report_period").val()) {
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
                        $("#repeatcriteria").hide();
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
            }
        });
    </script>
</head>
<body>
<!-- LOGO AND NAVIGATION -->
<?php include('cp-navigation.php'); ?>
<!-- END LOGO AND NAVIGATION -->
<br>
<!-- INPUT FORM -->
<div class="nav-section-header-cp">
	<strong>Copy an Event</strong>
</div>
<?php echo($errorSUCCESS); ?>
<!-- DUPLICATE FROM SPECIFIC INPUT FORM -->
<?php if ($_POST["int1"] != ''){ ?>
<?php
    $query  = "SELECT `int1`, title, date, stime, etime, url, email, details, location, detailsmini, docid, event, parent_int1, cal_json FROM calendar WHERE `int1`='$int1' LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
        $repeat_array = json_decode($row['cal_json'], true);
?>
<div class="cp-form-container">
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 0px 0px;">
            <form enctype="multipart/form-data" method="POST" action="calendar-duplicate.php">
                <div class="small-12 medium-12 columns"><strong>1) Event Information</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="event" class="middle">Event Type</label></div>
            <div class="small-12 medium-7 end columns">
                <select name="event">
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
            <div class="small-12 medium-7 end columns"><input name="title" size="40" maxlength="100" class="form" type="text" placeholder="Board of Directors Meeting" value="<?php echo "{$row['title']}"; ?>" required></div>
        </div>

        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns">
                <label for="repeat" class="middle">Is this a Repeating Event? &nbsp;<input type="checkbox" name="repeat" id="repeat" style="margin-bottom: -23px;" <?php echo (!empty($repeat_array) && isset($repeat_array['repeat']) && $repeat_array['repeat'] == 'on' ) ? "checked" : ""; ?>/></label>
            </div>
            <div class="small-12 medium-7 end columns">
                <div id="repeatcriteria" style="display: none">
                    <select name="repeat_period" id="report_period">
                        <option value="">Select Occurance</option>
                        <option value="day" <?php echo (isset($repeat_array['repeat_period']) && $repeat_array['repeat_period'] == 'day') ? " selected" : ""; ?>>Daily</option>
                        <option value="week" <?php echo (isset($repeat_array['repeat_period']) && $repeat_array['repeat_period'] == 'week') ? " selected" : ""; ?>>Weekly</option>
                        <option value="month" <?php echo (isset($repeat_array['repeat_period']) && $repeat_array['repeat_period'] == 'month') ? " selected" : ""; ?>>Monthly</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- repeat daily -->
        <div style="display:none" id="daycriteria">
            <div class="row medium-collapse" style="padding-left: 30px;">
                <div class="small-12 medium-6 columns"><label for="repeat_occurance_day" class="middle">Every how many day(s)?&nbsp;
                    <br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Example: 2 will create an event for every other day.</span>
                    <br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Events will add to the Calendar for one year.</span>
                </label></div>
                <div class="small-6 medium-3 end columns"><input type="text" name="repeat_occurance_day" placeholder="1" maxlength="3" size="3" class="form" <?php echo (isset($repeat_array['repeat_occurance_day'])) ? 'value='.'"'.$repeat_array['repeat_occurance_day'].'"' : '';?>/></div>
            </div>
        </div>

        <!-- repeat weekly -->
        <div style="display:none" id="weekcriteria">
            <div class="row medium-collapse" style="padding-left: 30px;">
                <div class="small-12 medium-6 columns"><label for="repeat_occurance_week" class="middle">Every how many week(s)?&nbsp;
                    <br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Example: 2 will create an event for every other week.</span>
                    <br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Events will add to the Calendar for one year.</span>
                </label></div>
                <div class="small-6 medium-3 end columns"><input type="text" name="repeat_occurance_week" placeholder="1" maxlength="3" size="3" <?php echo (isset($repeat_array['repeat_occurance_week'])) ? 'value='.'"'.$repeat_array['repeat_occurance_week'].'"' : '';?>/></div>
            </div>
            <div class="row medium-collapse" style="padding-left: 30px;">
                <div class="small-12 medium-5 columns"><label for="title" class="middle">On what days?&nbsp;<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Hold the Command (Mac) / Ctrl (PC) key to select multiple days.</span></label></div>
                <div class="small-12 medium-7 end columns">
                    <select name="repeat_week_days[]" id="repeat_week_days" multiple="true" size="7">
                        <option value="sunday" <?php echo (isset($repeat_array['repeat_week_days']) && in_array('sunday', $repeat_array['repeat_week_days'])) ? ' selected' : ''; ?>>Sunday</option>
                        <option value="monday"<?php echo (isset($repeat_array['repeat_week_days']) && in_array('monday', $repeat_array['repeat_week_days'])) ? ' selected' : ''; ?>>Monday</option>
                        <option value="tuesday"<?php echo (isset($repeat_array['repeat_week_days']) && in_array('tuesday', $repeat_array['repeat_week_days'])) ? '  selected' : ''; ?>>Tuesday</option>
                        <option value="wednesday"<?php echo (isset($repeat_array['repeat_week_days']) && in_array('wednesday', $repeat_array['repeat_week_days'])) ? ' selected' : ''; ?>>Wednesday</option>
                        <option value="thursday"<?php echo (isset($repeat_array['repeat_week_days']) && in_array('thursday', $repeat_array['repeat_week_days'])) ? ' selected' : ''; ?>>Thursday</option>
                        <option value="friday"<?php echo (isset($repeat_array['repeat_week_days']) && in_array('friday', $repeat_array['repeat_week_days'])) ? ' selected' : ''; ?>>Friday</option>
                        <option value="saturday"<?php echo (isset($repeat_array['repeat_week_days']) && in_array('saturday', $repeat_array['repeat_week_days'])) ? ' selected' : ''; ?>>Saturday</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- repeat monthly -->
        <div style="display:none" id="monthcriteria">
            <div class="row medium-collapse" style="padding-left: 30px;">
                <div class="small-12 medium-6 columns"><label for="repeat_occurance_month" class="middle">Every how many month(s)?&nbsp;
                    <br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Example: 2 will create an event for every other month.</span>
                    <br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Events will add to the Calendar for one year.</span>
                </label></div>
                <div class="small-6 medium-3 end columns"><input type="text" name="repeat_occurance_month" placeholder="1" maxlength="3" size="3" <?php echo (isset($repeat_array['repeat_occurance_month'])) ? 'value='.'"'.$repeat_array['repeat_occurance_month'].'"' : '';?>/></div>
            </div>
            <div class="row medium-collapse" style="padding-left: 30px">
                <div class="small-12 medium-5 columns"><label for="title" class="middle">On the&nbsp;</label></div>
                <div class="small-12 medium-3 end columns">
                    <select name="repeat_month_week" id="repeat_month_week">
                        <option value="first" <?php echo (isset($repeat_array['repeat_month_week']) && $repeat_array['repeat_month_week'] == 'first') ? "selected" : ''; ?>/>First</option>
                        <option value="second" <?php echo (isset($repeat_array['repeat_month_week']) && $repeat_array['repeat_month_week'] == 'second') ? "selected" : ''; ?>/>Second</option>
                        <option value="third" <?php echo (isset($repeat_array['repeat_month_week']) && $repeat_array['repeat_month_week'] == 'third') ? "selected" : ''; ?>/>Third</option>
                        <option value="fourth" <?php echo (isset($repeat_array['repeat_month_week']) && $repeat_array['repeat_month_week'] == 'forth') ? "selected" : ''; ?>/>Fourth</option>
                        <option value="last" <?php echo (isset($repeat_array['repeat_month_week']) && $repeat_array['repeat_month_week'] == 'last') ? "selected" : ''; ?>/>Last</option>
                    </select>
                </div>
                <div class="hide-on-small medium-1 end columns">&nbsp;</div>
                <div class="small-12 medium-3 end columns">
                    <select name="repeat_month_day" id="repeat_month_day">
                        <option value="day" <?php echo (isset($repeat_array['repeat_month_day']) && $repeat_array['repeat_month_day'] == 'day') ? 'selected' : ''; ?>>Day of the Month</option>
                        <option value="weekday" <?php echo (isset($repeat_array['repeat_month_day']) && $repeat_array['repeat_month_day'] == 'weekday') ? 'selected' : ''; ?>>Weekday of the Month</option>
                        <option value="" <?php echo (isset($repeat_array['repeat_month_day']) && $repeat_array['repeat_month_day'] == '') ? 'selected' : ''; ?>></option>
                        <option value="sunday" <?php echo (isset($repeat_array['repeat_month_day']) && $repeat_array['repeat_month_day'] == 'sunday') ? 'selected' : ''; ?>>Sunday of the Month</option>
                        <option value="monday" <?php echo (isset($repeat_array['repeat_month_day']) && $repeat_array['repeat_month_day'] == 'monday') ? 'selected' : ''; ?>>Monday of the Month</option>
                        <option value="tuesday" <?php echo (isset($repeat_array['repeat_month_day']) && $repeat_array['repeat_month_day'] == 'tuesday') ? 'selected' : ''; ?>>Tuesday of the Month</option>
                        <option value="wednesday" <?php echo (isset($repeat_array['repeat_month_day']) && $repeat_array['repeat_month_day'] == 'wednesday') ? 'selected' : ''; ?>>Wednesday of the Month</option>
                        <option value="thursday" <?php echo (isset($repeat_array['repeat_month_day']) && $repeat_array['repeat_month_day'] == 'thursday') ? 'selected' : ''; ?>>Thursday of the Month</option>
                        <option value="friday" <?php echo (isset($repeat_array['repeat_month_day']) && $repeat_array['repeat_month_day'] == 'friday') ? 'selected' : ''; ?>>Friday of the Month</option>
                        <option value="saturday" <?php echo (isset($repeat_array['repeat_month_day']) && $repeat_array['repeat_month_day'] == 'saturday') ? 'selected' : ''; ?>>Saturday of the Month</option>
                    </select>
                </div>
            </div>
        </div>


        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="date" class="middle">Date of the event</label></div>
            <div class="small-12 medium-7 end columns"><input name="date" class="form datepicker" type="date" value="<?php echo "{$row['date']}"; ?>" required autofocus></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="stime" class="middle">Start Time</label></div>
            <div class="small-12 medium-7 end columns">
<select name="stime">
<option value=""> </option>
<option value="05:00:00" <?php if($row['stime'] == "05:00:00"){ echo("SELECTED"); } ?>>5:00 AM</option>
<option value="05:15:00" <?php if($row['stime'] == "05:15:00"){ echo("SELECTED"); } ?>>5:15 AM</option>
<option value="05:30:00" <?php if($row['stime'] == "05:30:00"){ echo("SELECTED"); } ?>>5:30 AM</option>
<option value="05:45:00" <?php if($row['stime'] == "05:45:00"){ echo("SELECTED"); } ?>>5:45 AM</option>
<option value=""> </option>
<option value="06:00:00" <?php if($row['stime'] == "06:00:00"){ echo("SELECTED"); } ?>>6:00 AM</option>
<option value="06:15:00" <?php if($row['stime'] == "06:15:00"){ echo("SELECTED"); } ?>>6:15 AM</option>
<option value="06:30:00" <?php if($row['stime'] == "06:30:00"){ echo("SELECTED"); } ?>>6:30 AM</option>
<option value="06:45:00" <?php if($row['stime'] == "06:45:00"){ echo("SELECTED"); } ?>>6:45 AM</option>
<option value=""> </option>
<option value="07:00:00" <?php if($row['stime'] == "07:00:00"){ echo("SELECTED"); } ?>>7:00 AM</option>
<option value="07:15:00" <?php if($row['stime'] == "07:15:00"){ echo("SELECTED"); } ?>>7:15 AM</option>
<option value="07:30:00" <?php if($row['stime'] == "07:30:00"){ echo("SELECTED"); } ?>>7:30 AM</option>
<option value="07:45:00" <?php if($row['stime'] == "07:45:00"){ echo("SELECTED"); } ?>>7:45 AM</option>
<option value=""> </option>
<option value="08:00:00" <?php if($row['stime'] == "08:00:00"){ echo("SELECTED"); } ?>>8:00 AM</option>
<option value="08:15:00" <?php if($row['stime'] == "08:15:00"){ echo("SELECTED"); } ?>>8:15 AM</option>
<option value="08:30:00" <?php if($row['stime'] == "08:30:00"){ echo("SELECTED"); } ?>>8:30 AM</option>
<option value="08:45:00" <?php if($row['stime'] == "08:45:00"){ echo("SELECTED"); } ?>>8:45 AM</option>
<option value=""> </option>
<option value="09:00:00" <?php if($row['stime'] == "09:00:00"){ echo("SELECTED"); } ?>>9:00 AM</option>
<option value="09:15:00" <?php if($row['stime'] == "09:15:00"){ echo("SELECTED"); } ?>>9:15 AM</option>
<option value="09:30:00" <?php if($row['stime'] == "09:30:00"){ echo("SELECTED"); } ?>>9:30 AM</option>
<option value="09:45:00" <?php if($row['stime'] == "09:45:00"){ echo("SELECTED"); } ?>>9:45 AM</option>
<option value=""> </option>
<option value="10:00:00" <?php if($row['stime'] == "10:00:00"){ echo("SELECTED"); } ?>>10:00 AM</option>
<option value="10:15:00" <?php if($row['stime'] == "10:15:00"){ echo("SELECTED"); } ?>>10:15 AM</option>
<option value="10:30:00" <?php if($row['stime'] == "10:30:00"){ echo("SELECTED"); } ?>>10:30 AM</option>
<option value="10:45:00" <?php if($row['stime'] == "10:45:00"){ echo("SELECTED"); } ?>>10:45 AM</option>
<option value=""> </option>
<option value="11:00:00" <?php if($row['stime'] == "11:00:00"){ echo("SELECTED"); } ?>>11:00 AM</option>
<option value="11:15:00" <?php if($row['stime'] == "11:15:00"){ echo("SELECTED"); } ?>>11:15 AM</option>
<option value="11:30:00" <?php if($row['stime'] == "11:30:00"){ echo("SELECTED"); } ?>>11:30 AM</option>
<option value="11:45:00" <?php if($row['stime'] == "11:45:00"){ echo("SELECTED"); } ?>>11:45 AM</option>
<option value=""> </option>
<option value="12:00:00" <?php if($row['stime'] == "12:00:00"){ echo("SELECTED"); } ?>>12:00 PM</option>
<option value="12:15:00" <?php if($row['stime'] == "12:15:00"){ echo("SELECTED"); } ?>>12:15 PM</option>
<option value="12:30:00" <?php if($row['stime'] == "12:30:00"){ echo("SELECTED"); } ?>>12:30 PM</option>
<option value="12:45:00" <?php if($row['stime'] == "12:45:00"){ echo("SELECTED"); } ?>>12:45 PM</option>
<option value=""> </option>
<option value="13:00:00" <?php if($row['stime'] == "13:00:00"){ echo("SELECTED"); } ?>>1:00 PM</option>
<option value="13:15:00" <?php if($row['stime'] == "13:15:00"){ echo("SELECTED"); } ?>>1:15 PM</option>
<option value="13:30:00" <?php if($row['stime'] == "13:30:00"){ echo("SELECTED"); } ?>>1:30 PM</option>
<option value="13:45:00" <?php if($row['stime'] == "13:45:00"){ echo("SELECTED"); } ?>>1:45 PM</option>
<option value=""> </option>
<option value="14:00:00" <?php if($row['stime'] == "14:00:00"){ echo("SELECTED"); } ?>>2:00 PM</option>
<option value="14:15:00" <?php if($row['stime'] == "14:15:00"){ echo("SELECTED"); } ?>>2:15 PM</option>
<option value="14:30:00" <?php if($row['stime'] == "14:30:00"){ echo("SELECTED"); } ?>>2:30 PM</option>
<option value="14:45:00" <?php if($row['stime'] == "14:45:00"){ echo("SELECTED"); } ?>>2:45 PM</option>
<option value=""> </option>
<option value="15:00:00" <?php if($row['stime'] == "15:00:00"){ echo("SELECTED"); } ?>>3:00 PM</option>
<option value="15:15:00" <?php if($row['stime'] == "15:15:00"){ echo("SELECTED"); } ?>>3:15 PM</option>
<option value="15:30:00" <?php if($row['stime'] == "15:30:00"){ echo("SELECTED"); } ?>>3:30 PM</option>
<option value="15:45:00" <?php if($row['stime'] == "15:45:00"){ echo("SELECTED"); } ?>>3:45 PM</option>
<option value=""> </option>
<option value="16:00:00" <?php if($row['stime'] == "16:00:00"){ echo("SELECTED"); } ?>>4:00 PM</option>
<option value="16:15:00" <?php if($row['stime'] == "16:15:00"){ echo("SELECTED"); } ?>>4:15 PM</option>
<option value="16:30:00" <?php if($row['stime'] == "16:30:00"){ echo("SELECTED"); } ?>>4:30 PM</option>
<option value="16:45:00" <?php if($row['stime'] == "16:45:00"){ echo("SELECTED"); } ?>>4:45 PM</option>
<option value=""> </option>
<option value="17:00:00" <?php if($row['stime'] == "17:00:00"){ echo("SELECTED"); } ?>>5:00 PM</option>
<option value="17:15:00" <?php if($row['stime'] == "17:15:00"){ echo("SELECTED"); } ?>>5:15 PM</option>
<option value="17:30:00" <?php if($row['stime'] == "17:30:00"){ echo("SELECTED"); } ?>>5:30 PM</option>
<option value="17:45:00" <?php if($row['stime'] == "17:45:00"){ echo("SELECTED"); } ?>>5:45 PM</option>
<option value=""> </option>
<option value="18:00:00" <?php if($row['stime'] == "18:00:00"){ echo("SELECTED"); } ?>>6:00 PM</option>
<option value="18:15:00" <?php if($row['stime'] == "18:15:00"){ echo("SELECTED"); } ?>>6:15 PM</option>
<option value="18:30:00" <?php if($row['stime'] == "18:30:00"){ echo("SELECTED"); } ?>>6:30 PM</option>
<option value="18:45:00" <?php if($row['stime'] == "18:45:00"){ echo("SELECTED"); } ?>>6:45 PM</option>
<option value=""> </option>
<option value="19:00:00" <?php if($row['stime'] == "19:00:00"){ echo("SELECTED"); } ?>>7:00 PM</option>
<option value="19:15:00" <?php if($row['stime'] == "19:15:00"){ echo("SELECTED"); } ?>>7:15 PM</option>
<option value="19:30:00" <?php if($row['stime'] == "19:30:00"){ echo("SELECTED"); } ?>>7:30 PM</option>
<option value="19:45:00" <?php if($row['stime'] == "19:45:00"){ echo("SELECTED"); } ?>>7:45 PM</option>
<option value=""> </option>
<option value="20:00:00" <?php if($row['stime'] == "20:00:00"){ echo("SELECTED"); } ?>>8:00 PM</option>
<option value="20:15:00" <?php if($row['stime'] == "20:15:00"){ echo("SELECTED"); } ?>>8:15 PM</option>
<option value="20:30:00" <?php if($row['stime'] == "20:30:00"){ echo("SELECTED"); } ?>>8:30 PM</option>
<option value="20:45:00" <?php if($row['stime'] == "20:45:00"){ echo("SELECTED"); } ?>>8:45 PM</option>
<option value=""> </option>
<option value="21:00:00" <?php if($row['stime'] == "21:00:00"){ echo("SELECTED"); } ?>>9:00 PM</option>
<option value="21:15:00" <?php if($row['stime'] == "21:15:00"){ echo("SELECTED"); } ?>>9:15 PM</option>
<option value="21:30:00" <?php if($row['stime'] == "21:30:00"){ echo("SELECTED"); } ?>>9:30 PM</option>
<option value="21:45:00" <?php if($row['stime'] == "21:45:00"){ echo("SELECTED"); } ?>>9:45 PM</option>
<option value=""> </option>
<option value="22:00:00" <?php if($row['stime'] == "22:00:00"){ echo("SELECTED"); } ?>>10:00 PM</option>
<option value="22:15:00" <?php if($row['stime'] == "22:15:00"){ echo("SELECTED"); } ?>>10:15 PM</option>
<option value="22:30:00" <?php if($row['stime'] == "22:30:00"){ echo("SELECTED"); } ?>>10:30 PM</option>
<option value="22:45:00" <?php if($row['stime'] == "22:45:00"){ echo("SELECTED"); } ?>>10:45 PM</option>
<option value=""> </option>
<option value="23:00:00" <?php if($row['stime'] == "23:00:00"){ echo("SELECTED"); } ?>>11:00 PM</option>
<option value="23:15:00" <?php if($row['stime'] == "23:15:00"){ echo("SELECTED"); } ?>>11:15 PM</option>
<option value="23:30:00" <?php if($row['stime'] == "23:30:00"){ echo("SELECTED"); } ?>>11:30 PM</option>
<option value="23:45:00" <?php if($row['stime'] == "23:45:00"){ echo("SELECTED"); } ?>>11:45 PM</option>
<option value=""> </option>
<option value="00:00:00" <?php if($row['stime'] == "00:00:00"){ echo("SELECTED"); } ?>>12:00 AM</option>
<option value="00:15:00" <?php if($row['stime'] == "00:15:00"){ echo("SELECTED"); } ?>>12:15 AM</option>
<option value="00:30:00" <?php if($row['stime'] == "00:30:00"){ echo("SELECTED"); } ?>>12:30 AM</option>
<option value="00:45:00" <?php if($row['stime'] == "00:45:00"){ echo("SELECTED"); } ?>>12:45 AM</option>
<option value=""> </option>
<option value="01:00:00" <?php if($row['stime'] == "01:00:00"){ echo("SELECTED"); } ?>>1:00 AM</option>
<option value="01:15:00" <?php if($row['stime'] == "01:15:00"){ echo("SELECTED"); } ?>>1:15 AM</option>
<option value="01:30:00" <?php if($row['stime'] == "01:30:00"){ echo("SELECTED"); } ?>>1:30 AM</option>
<option value="01:45:00" <?php if($row['stime'] == "01:45:00"){ echo("SELECTED"); } ?>>1:45 AM</option>
<option value=""> </option>
<option value="02:00:00" <?php if($row['stime'] == "02:00:00"){ echo("SELECTED"); } ?>>2:00 AM</option>
<option value="02:15:00" <?php if($row['stime'] == "02:15:00"){ echo("SELECTED"); } ?>>2:15 AM</option>
<option value="02:30:00" <?php if($row['stime'] == "02:30:00"){ echo("SELECTED"); } ?>>2:30 AM</option>
<option value="02:45:00" <?php if($row['stime'] == "02:45:00"){ echo("SELECTED"); } ?>>2:45 AM</option>
<option value=""> </option>
<option value="03:00:00" <?php if($row['stime'] == "03:00:00"){ echo("SELECTED"); } ?>>3:00 AM</option>
<option value="03:15:00" <?php if($row['stime'] == "03:15:00"){ echo("SELECTED"); } ?>>3:15 AM</option>
<option value="03:30:00" <?php if($row['stime'] == "03:30:00"){ echo("SELECTED"); } ?>>3:30 AM</option>
<option value="03:45:00" <?php if($row['stime'] == "03:45:00"){ echo("SELECTED"); } ?>>3:45 AM</option>
<option value=""> </option>
<option value="04:00:00" <?php if($row['stime'] == "04:00:00"){ echo("SELECTED"); } ?>>4:00 AM</option>
<option value="04:15:00" <?php if($row['stime'] == "04:15:00"){ echo("SELECTED"); } ?>>4:15 AM</option>
<option value="04:30:00" <?php if($row['stime'] == "04:30:00"){ echo("SELECTED"); } ?>>4:30 AM</option>
<option value="04:45:00" <?php if($row['stime'] == "04:45:00"){ echo("SELECTED"); } ?>>4:45 AM</option>
</select>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="etime" class="middle">End Time</label></div>
            <div class="small-12 medium-7 end columns">
<select name="etime">
<option value=""> </option>
<option value="05:00:00" <?php if($row['etime'] == "05:00:00"){ echo("SELECTED"); } ?>>5:00 AM</option>
<option value="05:15:00" <?php if($row['etime'] == "05:15:00"){ echo("SELECTED"); } ?>>5:15 AM</option>
<option value="05:30:00" <?php if($row['etime'] == "05:30:00"){ echo("SELECTED"); } ?>>5:30 AM</option>
<option value="05:45:00" <?php if($row['etime'] == "05:45:00"){ echo("SELECTED"); } ?>>5:45 AM</option>
<option value=""> </option>
<option value="06:00:00" <?php if($row['etime'] == "06:00:00"){ echo("SELECTED"); } ?>>6:00 AM</option>
<option value="06:15:00" <?php if($row['etime'] == "06:15:00"){ echo("SELECTED"); } ?>>6:15 AM</option>
<option value="06:30:00" <?php if($row['etime'] == "06:30:00"){ echo("SELECTED"); } ?>>6:30 AM</option>
<option value="06:45:00" <?php if($row['etime'] == "06:45:00"){ echo("SELECTED"); } ?>>6:45 AM</option>
<option value=""> </option>
<option value="07:00:00" <?php if($row['etime'] == "07:00:00"){ echo("SELECTED"); } ?>>7:00 AM</option>
<option value="07:15:00" <?php if($row['etime'] == "07:15:00"){ echo("SELECTED"); } ?>>7:15 AM</option>
<option value="07:30:00" <?php if($row['etime'] == "07:30:00"){ echo("SELECTED"); } ?>>7:30 AM</option>
<option value="07:45:00" <?php if($row['etime'] == "07:45:00"){ echo("SELECTED"); } ?>>7:45 AM</option>
<option value=""> </option>
<option value="08:00:00" <?php if($row['etime'] == "08:00:00"){ echo("SELECTED"); } ?>>8:00 AM</option>
<option value="08:15:00" <?php if($row['etime'] == "08:15:00"){ echo("SELECTED"); } ?>>8:15 AM</option>
<option value="08:30:00" <?php if($row['etime'] == "08:30:00"){ echo("SELECTED"); } ?>>8:30 AM</option>
<option value="08:45:00" <?php if($row['etime'] == "08:45:00"){ echo("SELECTED"); } ?>>8:45 AM</option>
<option value=""> </option>
<option value="09:00:00" <?php if($row['etime'] == "09:00:00"){ echo("SELECTED"); } ?>>9:00 AM</option>
<option value="09:15:00" <?php if($row['etime'] == "09:15:00"){ echo("SELECTED"); } ?>>9:15 AM</option>
<option value="09:30:00" <?php if($row['etime'] == "09:30:00"){ echo("SELECTED"); } ?>>9:30 AM</option>
<option value="09:45:00" <?php if($row['etime'] == "09:45:00"){ echo("SELECTED"); } ?>>9:45 AM</option>
<option value=""> </option>
<option value="10:00:00" <?php if($row['etime'] == "10:00:00"){ echo("SELECTED"); } ?>>10:00 AM</option>
<option value="10:15:00" <?php if($row['etime'] == "10:15:00"){ echo("SELECTED"); } ?>>10:15 AM</option>
<option value="10:30:00" <?php if($row['etime'] == "10:30:00"){ echo("SELECTED"); } ?>>10:30 AM</option>
<option value="10:45:00" <?php if($row['etime'] == "10:45:00"){ echo("SELECTED"); } ?>>10:45 AM</option>
<option value=""> </option>
<option value="11:00:00" <?php if($row['etime'] == "11:00:00"){ echo("SELECTED"); } ?>>11:00 AM</option>
<option value="11:15:00" <?php if($row['etime'] == "11:15:00"){ echo("SELECTED"); } ?>>11:15 AM</option>
<option value="11:30:00" <?php if($row['etime'] == "11:30:00"){ echo("SELECTED"); } ?>>11:30 AM</option>
<option value="11:45:00" <?php if($row['etime'] == "11:45:00"){ echo("SELECTED"); } ?>>11:45 AM</option>
<option value=""> </option>
<option value="12:00:00" <?php if($row['etime'] == "12:00:00"){ echo("SELECTED"); } ?>>12:00 PM</option>
<option value="12:15:00" <?php if($row['etime'] == "12:15:00"){ echo("SELECTED"); } ?>>12:15 PM</option>
<option value="12:30:00" <?php if($row['etime'] == "12:30:00"){ echo("SELECTED"); } ?>>12:30 PM</option>
<option value="12:45:00" <?php if($row['etime'] == "12:45:00"){ echo("SELECTED"); } ?>>12:45 PM</option>
<option value=""> </option>
<option value="13:00:00" <?php if($row['etime'] == "13:00:00"){ echo("SELECTED"); } ?>>1:00 PM</option>
<option value="13:15:00" <?php if($row['etime'] == "13:15:00"){ echo("SELECTED"); } ?>>1:15 PM</option>
<option value="13:30:00" <?php if($row['etime'] == "13:30:00"){ echo("SELECTED"); } ?>>1:30 PM</option>
<option value="13:45:00" <?php if($row['etime'] == "13:45:00"){ echo("SELECTED"); } ?>>1:45 PM</option>
<option value=""> </option>
<option value="14:00:00" <?php if($row['etime'] == "14:00:00"){ echo("SELECTED"); } ?>>2:00 PM</option>
<option value="14:15:00" <?php if($row['etime'] == "14:15:00"){ echo("SELECTED"); } ?>>2:15 PM</option>
<option value="14:30:00" <?php if($row['etime'] == "14:30:00"){ echo("SELECTED"); } ?>>2:30 PM</option>
<option value="14:45:00" <?php if($row['etime'] == "14:45:00"){ echo("SELECTED"); } ?>>2:45 PM</option>
<option value=""> </option>
<option value="15:00:00" <?php if($row['etime'] == "15:00:00"){ echo("SELECTED"); } ?>>3:00 PM</option>
<option value="15:15:00" <?php if($row['etime'] == "15:15:00"){ echo("SELECTED"); } ?>>3:15 PM</option>
<option value="15:30:00" <?php if($row['etime'] == "15:30:00"){ echo("SELECTED"); } ?>>3:30 PM</option>
<option value="15:45:00" <?php if($row['etime'] == "15:45:00"){ echo("SELECTED"); } ?>>3:45 PM</option>
<option value=""> </option>
<option value="16:00:00" <?php if($row['etime'] == "16:00:00"){ echo("SELECTED"); } ?>>4:00 PM</option>
<option value="16:15:00" <?php if($row['etime'] == "16:15:00"){ echo("SELECTED"); } ?>>4:15 PM</option>
<option value="16:30:00" <?php if($row['etime'] == "16:30:00"){ echo("SELECTED"); } ?>>4:30 PM</option>
<option value="16:45:00" <?php if($row['etime'] == "16:45:00"){ echo("SELECTED"); } ?>>4:45 PM</option>
<option value=""> </option>
<option value="17:00:00" <?php if($row['etime'] == "17:00:00"){ echo("SELECTED"); } ?>>5:00 PM</option>
<option value="17:15:00" <?php if($row['etime'] == "17:15:00"){ echo("SELECTED"); } ?>>5:15 PM</option>
<option value="17:30:00" <?php if($row['etime'] == "17:30:00"){ echo("SELECTED"); } ?>>5:30 PM</option>
<option value="17:45:00" <?php if($row['etime'] == "17:45:00"){ echo("SELECTED"); } ?>>5:45 PM</option>
<option value=""> </option>
<option value="18:00:00" <?php if($row['etime'] == "18:00:00"){ echo("SELECTED"); } ?>>6:00 PM</option>
<option value="18:15:00" <?php if($row['etime'] == "18:15:00"){ echo("SELECTED"); } ?>>6:15 PM</option>
<option value="18:30:00" <?php if($row['etime'] == "18:30:00"){ echo("SELECTED"); } ?>>6:30 PM</option>
<option value="18:45:00" <?php if($row['etime'] == "18:45:00"){ echo("SELECTED"); } ?>>6:45 PM</option>
<option value=""> </option>
<option value="19:00:00" <?php if($row['etime'] == "19:00:00"){ echo("SELECTED"); } ?>>7:00 PM</option>
<option value="19:15:00" <?php if($row['etime'] == "19:15:00"){ echo("SELECTED"); } ?>>7:15 PM</option>
<option value="19:30:00" <?php if($row['etime'] == "19:30:00"){ echo("SELECTED"); } ?>>7:30 PM</option>
<option value="19:45:00" <?php if($row['etime'] == "19:45:00"){ echo("SELECTED"); } ?>>7:45 PM</option>
<option value=""> </option>
<option value="20:00:00" <?php if($row['etime'] == "20:00:00"){ echo("SELECTED"); } ?>>8:00 PM</option>
<option value="20:15:00" <?php if($row['etime'] == "20:15:00"){ echo("SELECTED"); } ?>>8:15 PM</option>
<option value="20:30:00" <?php if($row['etime'] == "20:30:00"){ echo("SELECTED"); } ?>>8:30 PM</option>
<option value="20:45:00" <?php if($row['etime'] == "20:45:00"){ echo("SELECTED"); } ?>>8:45 PM</option>
<option value=""> </option>
<option value="21:00:00" <?php if($row['etime'] == "21:00:00"){ echo("SELECTED"); } ?>>9:00 PM</option>
<option value="21:15:00" <?php if($row['etime'] == "21:15:00"){ echo("SELECTED"); } ?>>9:15 PM</option>
<option value="21:30:00" <?php if($row['etime'] == "21:30:00"){ echo("SELECTED"); } ?>>9:30 PM</option>
<option value="21:45:00" <?php if($row['etime'] == "21:45:00"){ echo("SELECTED"); } ?>>9:45 PM</option>
<option value=""> </option>
<option value="22:00:00" <?php if($row['etime'] == "22:00:00"){ echo("SELECTED"); } ?>>10:00 PM</option>
<option value="22:15:00" <?php if($row['etime'] == "22:15:00"){ echo("SELECTED"); } ?>>10:15 PM</option>
<option value="22:30:00" <?php if($row['etime'] == "22:30:00"){ echo("SELECTED"); } ?>>10:30 PM</option>
<option value="22:45:00" <?php if($row['etime'] == "22:45:00"){ echo("SELECTED"); } ?>>10:45 PM</option>
<option value=""> </option>
<option value="23:00:00" <?php if($row['etime'] == "23:00:00"){ echo("SELECTED"); } ?>>11:00 PM</option>
<option value="23:15:00" <?php if($row['etime'] == "23:15:00"){ echo("SELECTED"); } ?>>11:15 PM</option>
<option value="23:30:00" <?php if($row['etime'] == "23:30:00"){ echo("SELECTED"); } ?>>11:30 PM</option>
<option value="23:45:00" <?php if($row['etime'] == "23:45:00"){ echo("SELECTED"); } ?>>11:45 PM</option>
<option value=""> </option>
<option value="00:00:00" <?php if($row['etime'] == "00:00:00"){ echo("SELECTED"); } ?>>12:00 AM</option>
<option value="00:15:00" <?php if($row['etime'] == "00:15:00"){ echo("SELECTED"); } ?>>12:15 AM</option>
<option value="00:30:00" <?php if($row['etime'] == "00:30:00"){ echo("SELECTED"); } ?>>12:30 AM</option>
<option value="00:45:00" <?php if($row['etime'] == "00:45:00"){ echo("SELECTED"); } ?>>12:45 AM</option>
<option value=""> </option>
<option value="01:00:00" <?php if($row['etime'] == "01:00:00"){ echo("SELECTED"); } ?>>1:00 AM</option>
<option value="01:15:00" <?php if($row['etime'] == "01:15:00"){ echo("SELECTED"); } ?>>1:15 AM</option>
<option value="01:30:00" <?php if($row['etime'] == "01:30:00"){ echo("SELECTED"); } ?>>1:30 AM</option>
<option value="01:45:00" <?php if($row['etime'] == "01:45:00"){ echo("SELECTED"); } ?>>1:45 AM</option>
<option value=""> </option>
<option value="02:00:00" <?php if($row['etime'] == "02:00:00"){ echo("SELECTED"); } ?>>2:00 AM</option>
<option value="02:15:00" <?php if($row['etime'] == "02:15:00"){ echo("SELECTED"); } ?>>2:15 AM</option>
<option value="02:30:00" <?php if($row['etime'] == "02:30:00"){ echo("SELECTED"); } ?>>2:30 AM</option>
<option value="02:45:00" <?php if($row['etime'] == "02:45:00"){ echo("SELECTED"); } ?>>2:45 AM</option>
<option value=""> </option>
<option value="03:00:00" <?php if($row['etime'] == "03:00:00"){ echo("SELECTED"); } ?>>3:00 AM</option>
<option value="03:15:00" <?php if($row['etime'] == "03:15:00"){ echo("SELECTED"); } ?>>3:15 AM</option>
<option value="03:30:00" <?php if($row['etime'] == "03:30:00"){ echo("SELECTED"); } ?>>3:30 AM</option>
<option value="03:45:00" <?php if($row['etime'] == "03:45:00"){ echo("SELECTED"); } ?>>3:45 AM</option>
<option value=""> </option>
<option value="04:00:00" <?php if($row['etime'] == "04:00:00"){ echo("SELECTED"); } ?>>4:00 AM</option>
<option value="04:15:00" <?php if($row['etime'] == "04:15:00"){ echo("SELECTED"); } ?>>4:15 AM</option>
<option value="04:30:00" <?php if($row['etime'] == "04:30:00"){ echo("SELECTED"); } ?>>4:30 AM</option>
<option value="04:45:00" <?php if($row['etime'] == "04:45:00"){ echo("SELECTED"); } ?>>4:45 AM</option>
</select>
            </div>
        </div>
		<div class="row medium-collapse" style="padding-left: 30px; padding-bottom: 20px;">
			<div class="small-12 medium-12 columns"><label for="description" class="middle">Event Description and Details&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">This information IS visible to the user.</span><br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Use of HTML is acceptable.</span></label>
				<textarea name="details" cols="30" rows="2" id="editor1" class="form" type="text" placeholder="Enter Meeting/Event description and details..." required><?php echo "{$row['details']}"; ?></textarea>
				<script>CKEDITOR.replace( 'editor1' );</script>
			</div>
		</div>
    </div>
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 0px 0px;">
            <div class="small-12 medium-12 columns"><strong>2) Extra Details...</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="location" class="middle">Add a location?<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">100 characters maximum.</span><br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Letters and numbers only.</label></div>
            <div class="small-12 medium-7 end columns"><input name="location" placeholder="Clubhouse" maxlength="100" class="form" type="text" value="<?php echo "{$row['location']}"; ?>"></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="email" class="middle">Email</label></div>
            <div class="small-12 medium-7 end columns"><input name="email" placeholder="email@email.com" maxlength="100" class="form" type="email" value="<?php echo "{$row['email']}"; ?>"></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="url" class="middle">URL</label></div>
            <div class="small-12 medium-7 end columns"><input name="url" placeholder="http://www.mytown.com" maxlength="100" class="form" type="url" value="<?php echo "{$row['url']}"; ?>"></div>
        </div>
<?php include('docid-field-edit.php'); ?>
		<div class="row medium-collapse" style="padding-left: 30px; padding-bottom: 20px;">
			<div class="small-12 medium-12 columns"><label for="detailsmini" class="middle">Event description and details for external calendar applications<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">This information is included in iCal/Outlook calendar links.</span><br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Do NOT use HTML or special characters.</span> <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">500 characters maximum.</span></label>
				<textarea name="detailsmini" maxlength="500" cols="45" rows="4"><?php echo "{$row['detailsmini']}"; ?></textarea>
			</div>
		</div>
		<div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>3) Ready to Save?</strong></div>
        </div>
        <div class="row medium-collapse">
            <div class="small-12 medium-6 columns" align="center">
            	<input type="hidden" name="action" value="save">
            	<input type="hidden" name="int1" value="<?php echo $_POST['int1']; ?>">
            	<input name="submit" value="Save and Copy Again" class="submit" type="submit">
            </div>
</form>
            <div class="small-12 medium-6 end columns" align="center">
<form action="calendar.php" method="get">
                <input type="submit" value="Cancel &amp; Return to Calendar" onclick="return confirm('Are you sure you wish to leave this page? Unsaved changes will be lost.');">
</form>
            </div>
        </div>
    </div>
</div>
<?php
	}
?>
<?php }; ?>
<!-- DUPLICATE FROM SPECIFIC INPUT FORM -->
<!-- DUPLICATE FROM LAST INPUT FORM -->
<?php if ($_POST["int1"] == ''){ ?>
<?php
	$query  = "SELECT `int1`, title, date, stime, etime, url, email, details, location, detailsmini, docid, event FROM calendar ORDER BY `int1` DESC LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<div class="cp-form-container">
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 0px 0px;">
<form enctype="multipart/form-data" method="POST" action="calendar-duplicate.php">
            <div class="small-12 medium-12 columns"><strong>1) Event Information</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="event" class="middle">Event Type</label></div>
            <div class="small-12 medium-7 end columns">
<select name="event">
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
            <div class="small-12 medium-7 end columns"><input name="title" size="40" maxlength="100" class="form" type="text" placeholder="Board of Directors Meeting" value="<?php echo "{$row['title']}"; ?>" required></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="date" class="middle">Date of the event</label></div>
            <div class="small-12 medium-7 end columns"><input name="date" class="form datepicker" type="date" value="<?php echo "{$row['date']}"; ?>" required></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="stime" class="middle">Start Time</label></div>
            <div class="small-12 medium-7 end columns">
<select name="stime">
<option value=""> </option>
<option value="05:00:00" <?php if($row['stime'] == "05:00:00"){ echo("SELECTED"); } ?>>5:00 AM</option>
<option value="05:15:00" <?php if($row['stime'] == "05:15:00"){ echo("SELECTED"); } ?>>5:15 AM</option>
<option value="05:30:00" <?php if($row['stime'] == "05:30:00"){ echo("SELECTED"); } ?>>5:30 AM</option>
<option value="05:45:00" <?php if($row['stime'] == "05:45:00"){ echo("SELECTED"); } ?>>5:45 AM</option>
<option value=""> </option>
<option value="06:00:00" <?php if($row['stime'] == "06:00:00"){ echo("SELECTED"); } ?>>6:00 AM</option>
<option value="06:15:00" <?php if($row['stime'] == "06:15:00"){ echo("SELECTED"); } ?>>6:15 AM</option>
<option value="06:30:00" <?php if($row['stime'] == "06:30:00"){ echo("SELECTED"); } ?>>6:30 AM</option>
<option value="06:45:00" <?php if($row['stime'] == "06:45:00"){ echo("SELECTED"); } ?>>6:45 AM</option>
<option value=""> </option>
<option value="07:00:00" <?php if($row['stime'] == "07:00:00"){ echo("SELECTED"); } ?>>7:00 AM</option>
<option value="07:15:00" <?php if($row['stime'] == "07:15:00"){ echo("SELECTED"); } ?>>7:15 AM</option>
<option value="07:30:00" <?php if($row['stime'] == "07:30:00"){ echo("SELECTED"); } ?>>7:30 AM</option>
<option value="07:45:00" <?php if($row['stime'] == "07:45:00"){ echo("SELECTED"); } ?>>7:45 AM</option>
<option value=""> </option>
<option value="08:00:00" <?php if($row['stime'] == "08:00:00"){ echo("SELECTED"); } ?>>8:00 AM</option>
<option value="08:15:00" <?php if($row['stime'] == "08:15:00"){ echo("SELECTED"); } ?>>8:15 AM</option>
<option value="08:30:00" <?php if($row['stime'] == "08:30:00"){ echo("SELECTED"); } ?>>8:30 AM</option>
<option value="08:45:00" <?php if($row['stime'] == "08:45:00"){ echo("SELECTED"); } ?>>8:45 AM</option>
<option value=""> </option>
<option value="09:00:00" <?php if($row['stime'] == "09:00:00"){ echo("SELECTED"); } ?>>9:00 AM</option>
<option value="09:15:00" <?php if($row['stime'] == "09:15:00"){ echo("SELECTED"); } ?>>9:15 AM</option>
<option value="09:30:00" <?php if($row['stime'] == "09:30:00"){ echo("SELECTED"); } ?>>9:30 AM</option>
<option value="09:45:00" <?php if($row['stime'] == "09:45:00"){ echo("SELECTED"); } ?>>9:45 AM</option>
<option value=""> </option>
<option value="10:00:00" <?php if($row['stime'] == "10:00:00"){ echo("SELECTED"); } ?>>10:00 AM</option>
<option value="10:15:00" <?php if($row['stime'] == "10:15:00"){ echo("SELECTED"); } ?>>10:15 AM</option>
<option value="10:30:00" <?php if($row['stime'] == "10:30:00"){ echo("SELECTED"); } ?>>10:30 AM</option>
<option value="10:45:00" <?php if($row['stime'] == "10:45:00"){ echo("SELECTED"); } ?>>10:45 AM</option>
<option value=""> </option>
<option value="11:00:00" <?php if($row['stime'] == "11:00:00"){ echo("SELECTED"); } ?>>11:00 AM</option>
<option value="11:15:00" <?php if($row['stime'] == "11:15:00"){ echo("SELECTED"); } ?>>11:15 AM</option>
<option value="11:30:00" <?php if($row['stime'] == "11:30:00"){ echo("SELECTED"); } ?>>11:30 AM</option>
<option value="11:45:00" <?php if($row['stime'] == "11:45:00"){ echo("SELECTED"); } ?>>11:45 AM</option>
<option value=""> </option>
<option value="12:00:00" <?php if($row['stime'] == "12:00:00"){ echo("SELECTED"); } ?>>12:00 PM</option>
<option value="12:15:00" <?php if($row['stime'] == "12:15:00"){ echo("SELECTED"); } ?>>12:15 PM</option>
<option value="12:30:00" <?php if($row['stime'] == "12:30:00"){ echo("SELECTED"); } ?>>12:30 PM</option>
<option value="12:45:00" <?php if($row['stime'] == "12:45:00"){ echo("SELECTED"); } ?>>12:45 PM</option>
<option value=""> </option>
<option value="13:00:00" <?php if($row['stime'] == "13:00:00"){ echo("SELECTED"); } ?>>1:00 PM</option>
<option value="13:15:00" <?php if($row['stime'] == "13:15:00"){ echo("SELECTED"); } ?>>1:15 PM</option>
<option value="13:30:00" <?php if($row['stime'] == "13:30:00"){ echo("SELECTED"); } ?>>1:30 PM</option>
<option value="13:45:00" <?php if($row['stime'] == "13:45:00"){ echo("SELECTED"); } ?>>1:45 PM</option>
<option value=""> </option>
<option value="14:00:00" <?php if($row['stime'] == "14:00:00"){ echo("SELECTED"); } ?>>2:00 PM</option>
<option value="14:15:00" <?php if($row['stime'] == "14:15:00"){ echo("SELECTED"); } ?>>2:15 PM</option>
<option value="14:30:00" <?php if($row['stime'] == "14:30:00"){ echo("SELECTED"); } ?>>2:30 PM</option>
<option value="14:45:00" <?php if($row['stime'] == "14:45:00"){ echo("SELECTED"); } ?>>2:45 PM</option>
<option value=""> </option>
<option value="15:00:00" <?php if($row['stime'] == "15:00:00"){ echo("SELECTED"); } ?>>3:00 PM</option>
<option value="15:15:00" <?php if($row['stime'] == "15:15:00"){ echo("SELECTED"); } ?>>3:15 PM</option>
<option value="15:30:00" <?php if($row['stime'] == "15:30:00"){ echo("SELECTED"); } ?>>3:30 PM</option>
<option value="15:45:00" <?php if($row['stime'] == "15:45:00"){ echo("SELECTED"); } ?>>3:45 PM</option>
<option value=""> </option>
<option value="16:00:00" <?php if($row['stime'] == "16:00:00"){ echo("SELECTED"); } ?>>4:00 PM</option>
<option value="16:15:00" <?php if($row['stime'] == "16:15:00"){ echo("SELECTED"); } ?>>4:15 PM</option>
<option value="16:30:00" <?php if($row['stime'] == "16:30:00"){ echo("SELECTED"); } ?>>4:30 PM</option>
<option value="16:45:00" <?php if($row['stime'] == "16:45:00"){ echo("SELECTED"); } ?>>4:45 PM</option>
<option value=""> </option>
<option value="17:00:00" <?php if($row['stime'] == "17:00:00"){ echo("SELECTED"); } ?>>5:00 PM</option>
<option value="17:15:00" <?php if($row['stime'] == "17:15:00"){ echo("SELECTED"); } ?>>5:15 PM</option>
<option value="17:30:00" <?php if($row['stime'] == "17:30:00"){ echo("SELECTED"); } ?>>5:30 PM</option>
<option value="17:45:00" <?php if($row['stime'] == "17:45:00"){ echo("SELECTED"); } ?>>5:45 PM</option>
<option value=""> </option>
<option value="18:00:00" <?php if($row['stime'] == "18:00:00"){ echo("SELECTED"); } ?>>6:00 PM</option>
<option value="18:15:00" <?php if($row['stime'] == "18:15:00"){ echo("SELECTED"); } ?>>6:15 PM</option>
<option value="18:30:00" <?php if($row['stime'] == "18:30:00"){ echo("SELECTED"); } ?>>6:30 PM</option>
<option value="18:45:00" <?php if($row['stime'] == "18:45:00"){ echo("SELECTED"); } ?>>6:45 PM</option>
<option value=""> </option>
<option value="19:00:00" <?php if($row['stime'] == "19:00:00"){ echo("SELECTED"); } ?>>7:00 PM</option>
<option value="19:15:00" <?php if($row['stime'] == "19:15:00"){ echo("SELECTED"); } ?>>7:15 PM</option>
<option value="19:30:00" <?php if($row['stime'] == "19:30:00"){ echo("SELECTED"); } ?>>7:30 PM</option>
<option value="19:45:00" <?php if($row['stime'] == "19:45:00"){ echo("SELECTED"); } ?>>7:45 PM</option>
<option value=""> </option>
<option value="20:00:00" <?php if($row['stime'] == "20:00:00"){ echo("SELECTED"); } ?>>8:00 PM</option>
<option value="20:15:00" <?php if($row['stime'] == "20:15:00"){ echo("SELECTED"); } ?>>8:15 PM</option>
<option value="20:30:00" <?php if($row['stime'] == "20:30:00"){ echo("SELECTED"); } ?>>8:30 PM</option>
<option value="20:45:00" <?php if($row['stime'] == "20:45:00"){ echo("SELECTED"); } ?>>8:45 PM</option>
<option value=""> </option>
<option value="21:00:00" <?php if($row['stime'] == "21:00:00"){ echo("SELECTED"); } ?>>9:00 PM</option>
<option value="21:15:00" <?php if($row['stime'] == "21:15:00"){ echo("SELECTED"); } ?>>9:15 PM</option>
<option value="21:30:00" <?php if($row['stime'] == "21:30:00"){ echo("SELECTED"); } ?>>9:30 PM</option>
<option value="21:45:00" <?php if($row['stime'] == "21:45:00"){ echo("SELECTED"); } ?>>9:45 PM</option>
<option value=""> </option>
<option value="22:00:00" <?php if($row['stime'] == "22:00:00"){ echo("SELECTED"); } ?>>10:00 PM</option>
<option value="22:15:00" <?php if($row['stime'] == "22:15:00"){ echo("SELECTED"); } ?>>10:15 PM</option>
<option value="22:30:00" <?php if($row['stime'] == "22:30:00"){ echo("SELECTED"); } ?>>10:30 PM</option>
<option value="22:45:00" <?php if($row['stime'] == "22:45:00"){ echo("SELECTED"); } ?>>10:45 PM</option>
<option value=""> </option>
<option value="23:00:00" <?php if($row['stime'] == "23:00:00"){ echo("SELECTED"); } ?>>11:00 PM</option>
<option value="23:15:00" <?php if($row['stime'] == "23:15:00"){ echo("SELECTED"); } ?>>11:15 PM</option>
<option value="23:30:00" <?php if($row['stime'] == "23:30:00"){ echo("SELECTED"); } ?>>11:30 PM</option>
<option value="23:45:00" <?php if($row['stime'] == "23:45:00"){ echo("SELECTED"); } ?>>11:45 PM</option>
<option value=""> </option>
<option value="00:00:00" <?php if($row['stime'] == "00:00:00"){ echo("SELECTED"); } ?>>12:00 AM</option>
<option value="00:15:00" <?php if($row['stime'] == "00:15:00"){ echo("SELECTED"); } ?>>12:15 AM</option>
<option value="00:30:00" <?php if($row['stime'] == "00:30:00"){ echo("SELECTED"); } ?>>12:30 AM</option>
<option value="00:45:00" <?php if($row['stime'] == "00:45:00"){ echo("SELECTED"); } ?>>12:45 AM</option>
<option value=""> </option>
<option value="01:00:00" <?php if($row['stime'] == "01:00:00"){ echo("SELECTED"); } ?>>1:00 AM</option>
<option value="01:15:00" <?php if($row['stime'] == "01:15:00"){ echo("SELECTED"); } ?>>1:15 AM</option>
<option value="01:30:00" <?php if($row['stime'] == "01:30:00"){ echo("SELECTED"); } ?>>1:30 AM</option>
<option value="01:45:00" <?php if($row['stime'] == "01:45:00"){ echo("SELECTED"); } ?>>1:45 AM</option>
<option value=""> </option>
<option value="02:00:00" <?php if($row['stime'] == "02:00:00"){ echo("SELECTED"); } ?>>2:00 AM</option>
<option value="02:15:00" <?php if($row['stime'] == "02:15:00"){ echo("SELECTED"); } ?>>2:15 AM</option>
<option value="02:30:00" <?php if($row['stime'] == "02:30:00"){ echo("SELECTED"); } ?>>2:30 AM</option>
<option value="02:45:00" <?php if($row['stime'] == "02:45:00"){ echo("SELECTED"); } ?>>2:45 AM</option>
<option value=""> </option>
<option value="03:00:00" <?php if($row['stime'] == "03:00:00"){ echo("SELECTED"); } ?>>3:00 AM</option>
<option value="03:15:00" <?php if($row['stime'] == "03:15:00"){ echo("SELECTED"); } ?>>3:15 AM</option>
<option value="03:30:00" <?php if($row['stime'] == "03:30:00"){ echo("SELECTED"); } ?>>3:30 AM</option>
<option value="03:45:00" <?php if($row['stime'] == "03:45:00"){ echo("SELECTED"); } ?>>3:45 AM</option>
<option value=""> </option>
<option value="04:00:00" <?php if($row['stime'] == "04:00:00"){ echo("SELECTED"); } ?>>4:00 AM</option>
<option value="04:15:00" <?php if($row['stime'] == "04:15:00"){ echo("SELECTED"); } ?>>4:15 AM</option>
<option value="04:30:00" <?php if($row['stime'] == "04:30:00"){ echo("SELECTED"); } ?>>4:30 AM</option>
<option value="04:45:00" <?php if($row['stime'] == "04:45:00"){ echo("SELECTED"); } ?>>4:45 AM</option>
</select>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="etime" class="middle">End Time</label></div>
            <div class="small-12 medium-7 end columns">
<select name="etime">
<option value=""> </option>
<option value="05:00:00" <?php if($row['etime'] == "05:00:00"){ echo("SELECTED"); } ?>>5:00 AM</option>
<option value="05:15:00" <?php if($row['etime'] == "05:15:00"){ echo("SELECTED"); } ?>>5:15 AM</option>
<option value="05:30:00" <?php if($row['etime'] == "05:30:00"){ echo("SELECTED"); } ?>>5:30 AM</option>
<option value="05:45:00" <?php if($row['etime'] == "05:45:00"){ echo("SELECTED"); } ?>>5:45 AM</option>
<option value=""> </option>
<option value="06:00:00" <?php if($row['etime'] == "06:00:00"){ echo("SELECTED"); } ?>>6:00 AM</option>
<option value="06:15:00" <?php if($row['etime'] == "06:15:00"){ echo("SELECTED"); } ?>>6:15 AM</option>
<option value="06:30:00" <?php if($row['etime'] == "06:30:00"){ echo("SELECTED"); } ?>>6:30 AM</option>
<option value="06:45:00" <?php if($row['etime'] == "06:45:00"){ echo("SELECTED"); } ?>>6:45 AM</option>
<option value=""> </option>
<option value="07:00:00" <?php if($row['etime'] == "07:00:00"){ echo("SELECTED"); } ?>>7:00 AM</option>
<option value="07:15:00" <?php if($row['etime'] == "07:15:00"){ echo("SELECTED"); } ?>>7:15 AM</option>
<option value="07:30:00" <?php if($row['etime'] == "07:30:00"){ echo("SELECTED"); } ?>>7:30 AM</option>
<option value="07:45:00" <?php if($row['etime'] == "07:45:00"){ echo("SELECTED"); } ?>>7:45 AM</option>
<option value=""> </option>
<option value="08:00:00" <?php if($row['etime'] == "08:00:00"){ echo("SELECTED"); } ?>>8:00 AM</option>
<option value="08:15:00" <?php if($row['etime'] == "08:15:00"){ echo("SELECTED"); } ?>>8:15 AM</option>
<option value="08:30:00" <?php if($row['etime'] == "08:30:00"){ echo("SELECTED"); } ?>>8:30 AM</option>
<option value="08:45:00" <?php if($row['etime'] == "08:45:00"){ echo("SELECTED"); } ?>>8:45 AM</option>
<option value=""> </option>
<option value="09:00:00" <?php if($row['etime'] == "09:00:00"){ echo("SELECTED"); } ?>>9:00 AM</option>
<option value="09:15:00" <?php if($row['etime'] == "09:15:00"){ echo("SELECTED"); } ?>>9:15 AM</option>
<option value="09:30:00" <?php if($row['etime'] == "09:30:00"){ echo("SELECTED"); } ?>>9:30 AM</option>
<option value="09:45:00" <?php if($row['etime'] == "09:45:00"){ echo("SELECTED"); } ?>>9:45 AM</option>
<option value=""> </option>
<option value="10:00:00" <?php if($row['etime'] == "10:00:00"){ echo("SELECTED"); } ?>>10:00 AM</option>
<option value="10:15:00" <?php if($row['etime'] == "10:15:00"){ echo("SELECTED"); } ?>>10:15 AM</option>
<option value="10:30:00" <?php if($row['etime'] == "10:30:00"){ echo("SELECTED"); } ?>>10:30 AM</option>
<option value="10:45:00" <?php if($row['etime'] == "10:45:00"){ echo("SELECTED"); } ?>>10:45 AM</option>
<option value=""> </option>
<option value="11:00:00" <?php if($row['etime'] == "11:00:00"){ echo("SELECTED"); } ?>>11:00 AM</option>
<option value="11:15:00" <?php if($row['etime'] == "11:15:00"){ echo("SELECTED"); } ?>>11:15 AM</option>
<option value="11:30:00" <?php if($row['etime'] == "11:30:00"){ echo("SELECTED"); } ?>>11:30 AM</option>
<option value="11:45:00" <?php if($row['etime'] == "11:45:00"){ echo("SELECTED"); } ?>>11:45 AM</option>
<option value=""> </option>
<option value="12:00:00" <?php if($row['etime'] == "12:00:00"){ echo("SELECTED"); } ?>>12:00 PM</option>
<option value="12:15:00" <?php if($row['etime'] == "12:15:00"){ echo("SELECTED"); } ?>>12:15 PM</option>
<option value="12:30:00" <?php if($row['etime'] == "12:30:00"){ echo("SELECTED"); } ?>>12:30 PM</option>
<option value="12:45:00" <?php if($row['etime'] == "12:45:00"){ echo("SELECTED"); } ?>>12:45 PM</option>
<option value=""> </option>
<option value="13:00:00" <?php if($row['etime'] == "13:00:00"){ echo("SELECTED"); } ?>>1:00 PM</option>
<option value="13:15:00" <?php if($row['etime'] == "13:15:00"){ echo("SELECTED"); } ?>>1:15 PM</option>
<option value="13:30:00" <?php if($row['etime'] == "13:30:00"){ echo("SELECTED"); } ?>>1:30 PM</option>
<option value="13:45:00" <?php if($row['etime'] == "13:45:00"){ echo("SELECTED"); } ?>>1:45 PM</option>
<option value=""> </option>
<option value="14:00:00" <?php if($row['etime'] == "14:00:00"){ echo("SELECTED"); } ?>>2:00 PM</option>
<option value="14:15:00" <?php if($row['etime'] == "14:15:00"){ echo("SELECTED"); } ?>>2:15 PM</option>
<option value="14:30:00" <?php if($row['etime'] == "14:30:00"){ echo("SELECTED"); } ?>>2:30 PM</option>
<option value="14:45:00" <?php if($row['etime'] == "14:45:00"){ echo("SELECTED"); } ?>>2:45 PM</option>
<option value=""> </option>
<option value="15:00:00" <?php if($row['etime'] == "15:00:00"){ echo("SELECTED"); } ?>>3:00 PM</option>
<option value="15:15:00" <?php if($row['etime'] == "15:15:00"){ echo("SELECTED"); } ?>>3:15 PM</option>
<option value="15:30:00" <?php if($row['etime'] == "15:30:00"){ echo("SELECTED"); } ?>>3:30 PM</option>
<option value="15:45:00" <?php if($row['etime'] == "15:45:00"){ echo("SELECTED"); } ?>>3:45 PM</option>
<option value=""> </option>
<option value="16:00:00" <?php if($row['etime'] == "16:00:00"){ echo("SELECTED"); } ?>>4:00 PM</option>
<option value="16:15:00" <?php if($row['etime'] == "16:15:00"){ echo("SELECTED"); } ?>>4:15 PM</option>
<option value="16:30:00" <?php if($row['etime'] == "16:30:00"){ echo("SELECTED"); } ?>>4:30 PM</option>
<option value="16:45:00" <?php if($row['etime'] == "16:45:00"){ echo("SELECTED"); } ?>>4:45 PM</option>
<option value=""> </option>
<option value="17:00:00" <?php if($row['etime'] == "17:00:00"){ echo("SELECTED"); } ?>>5:00 PM</option>
<option value="17:15:00" <?php if($row['etime'] == "17:15:00"){ echo("SELECTED"); } ?>>5:15 PM</option>
<option value="17:30:00" <?php if($row['etime'] == "17:30:00"){ echo("SELECTED"); } ?>>5:30 PM</option>
<option value="17:45:00" <?php if($row['etime'] == "17:45:00"){ echo("SELECTED"); } ?>>5:45 PM</option>
<option value=""> </option>
<option value="18:00:00" <?php if($row['etime'] == "18:00:00"){ echo("SELECTED"); } ?>>6:00 PM</option>
<option value="18:15:00" <?php if($row['etime'] == "18:15:00"){ echo("SELECTED"); } ?>>6:15 PM</option>
<option value="18:30:00" <?php if($row['etime'] == "18:30:00"){ echo("SELECTED"); } ?>>6:30 PM</option>
<option value="18:45:00" <?php if($row['etime'] == "18:45:00"){ echo("SELECTED"); } ?>>6:45 PM</option>
<option value=""> </option>
<option value="19:00:00" <?php if($row['etime'] == "19:00:00"){ echo("SELECTED"); } ?>>7:00 PM</option>
<option value="19:15:00" <?php if($row['etime'] == "19:15:00"){ echo("SELECTED"); } ?>>7:15 PM</option>
<option value="19:30:00" <?php if($row['etime'] == "19:30:00"){ echo("SELECTED"); } ?>>7:30 PM</option>
<option value="19:45:00" <?php if($row['etime'] == "19:45:00"){ echo("SELECTED"); } ?>>7:45 PM</option>
<option value=""> </option>
<option value="20:00:00" <?php if($row['etime'] == "20:00:00"){ echo("SELECTED"); } ?>>8:00 PM</option>
<option value="20:15:00" <?php if($row['etime'] == "20:15:00"){ echo("SELECTED"); } ?>>8:15 PM</option>
<option value="20:30:00" <?php if($row['etime'] == "20:30:00"){ echo("SELECTED"); } ?>>8:30 PM</option>
<option value="20:45:00" <?php if($row['etime'] == "20:45:00"){ echo("SELECTED"); } ?>>8:45 PM</option>
<option value=""> </option>
<option value="21:00:00" <?php if($row['etime'] == "21:00:00"){ echo("SELECTED"); } ?>>9:00 PM</option>
<option value="21:15:00" <?php if($row['etime'] == "21:15:00"){ echo("SELECTED"); } ?>>9:15 PM</option>
<option value="21:30:00" <?php if($row['etime'] == "21:30:00"){ echo("SELECTED"); } ?>>9:30 PM</option>
<option value="21:45:00" <?php if($row['etime'] == "21:45:00"){ echo("SELECTED"); } ?>>9:45 PM</option>
<option value=""> </option>
<option value="22:00:00" <?php if($row['etime'] == "22:00:00"){ echo("SELECTED"); } ?>>10:00 PM</option>
<option value="22:15:00" <?php if($row['etime'] == "22:15:00"){ echo("SELECTED"); } ?>>10:15 PM</option>
<option value="22:30:00" <?php if($row['etime'] == "22:30:00"){ echo("SELECTED"); } ?>>10:30 PM</option>
<option value="22:45:00" <?php if($row['etime'] == "22:45:00"){ echo("SELECTED"); } ?>>10:45 PM</option>
<option value=""> </option>
<option value="23:00:00" <?php if($row['etime'] == "23:00:00"){ echo("SELECTED"); } ?>>11:00 PM</option>
<option value="23:15:00" <?php if($row['etime'] == "23:15:00"){ echo("SELECTED"); } ?>>11:15 PM</option>
<option value="23:30:00" <?php if($row['etime'] == "23:30:00"){ echo("SELECTED"); } ?>>11:30 PM</option>
<option value="23:45:00" <?php if($row['etime'] == "23:45:00"){ echo("SELECTED"); } ?>>11:45 PM</option>
<option value=""> </option>
<option value="00:00:00" <?php if($row['etime'] == "00:00:00"){ echo("SELECTED"); } ?>>12:00 AM</option>
<option value="00:15:00" <?php if($row['etime'] == "00:15:00"){ echo("SELECTED"); } ?>>12:15 AM</option>
<option value="00:30:00" <?php if($row['etime'] == "00:30:00"){ echo("SELECTED"); } ?>>12:30 AM</option>
<option value="00:45:00" <?php if($row['etime'] == "00:45:00"){ echo("SELECTED"); } ?>>12:45 AM</option>
<option value=""> </option>
<option value="01:00:00" <?php if($row['etime'] == "01:00:00"){ echo("SELECTED"); } ?>>1:00 AM</option>
<option value="01:15:00" <?php if($row['etime'] == "01:15:00"){ echo("SELECTED"); } ?>>1:15 AM</option>
<option value="01:30:00" <?php if($row['etime'] == "01:30:00"){ echo("SELECTED"); } ?>>1:30 AM</option>
<option value="01:45:00" <?php if($row['etime'] == "01:45:00"){ echo("SELECTED"); } ?>>1:45 AM</option>
<option value=""> </option>
<option value="02:00:00" <?php if($row['etime'] == "02:00:00"){ echo("SELECTED"); } ?>>2:00 AM</option>
<option value="02:15:00" <?php if($row['etime'] == "02:15:00"){ echo("SELECTED"); } ?>>2:15 AM</option>
<option value="02:30:00" <?php if($row['etime'] == "02:30:00"){ echo("SELECTED"); } ?>>2:30 AM</option>
<option value="02:45:00" <?php if($row['etime'] == "02:45:00"){ echo("SELECTED"); } ?>>2:45 AM</option>
<option value=""> </option>
<option value="03:00:00" <?php if($row['etime'] == "03:00:00"){ echo("SELECTED"); } ?>>3:00 AM</option>
<option value="03:15:00" <?php if($row['etime'] == "03:15:00"){ echo("SELECTED"); } ?>>3:15 AM</option>
<option value="03:30:00" <?php if($row['etime'] == "03:30:00"){ echo("SELECTED"); } ?>>3:30 AM</option>
<option value="03:45:00" <?php if($row['etime'] == "03:45:00"){ echo("SELECTED"); } ?>>3:45 AM</option>
<option value=""> </option>
<option value="04:00:00" <?php if($row['etime'] == "04:00:00"){ echo("SELECTED"); } ?>>4:00 AM</option>
<option value="04:15:00" <?php if($row['etime'] == "04:15:00"){ echo("SELECTED"); } ?>>4:15 AM</option>
<option value="04:30:00" <?php if($row['etime'] == "04:30:00"){ echo("SELECTED"); } ?>>4:30 AM</option>
<option value="04:45:00" <?php if($row['etime'] == "04:45:00"){ echo("SELECTED"); } ?>>4:45 AM</option>
</select>
            </div>
        </div>
		<div class="row medium-collapse" style="padding-left: 30px; padding-bottom: 20px;">
			<div class="small-12 medium-12 columns"><label for="description" class="middle">Event Description and Details&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">This information IS visible to the user.</span><br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Use of HTML is acceptable.</span></label>
				<textarea name="details" cols="30" rows="2" id="editor1" class="form" type="text" placeholder="Enter Meeting/Event description and details..." required><?php echo "{$row['details']}"; ?></textarea>
				<script>CKEDITOR.replace( 'editor1' );</script>
			</div>
		</div>
    </div>
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 0px 0px;">
            <div class="small-12 medium-12 columns"><strong>2) Extra Details...</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="email" class="middle">Email</label></div>
            <div class="small-12 medium-7 end columns"><input name="email" placeholder="email@email.com" maxlength="100" class="form" type="email" value="<?php echo "{$row['email']}"; ?>"></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="url" class="middle">URL</label></div>
            <div class="small-12 medium-7 end columns"><input name="url" placeholder="http://www.mytown.com" maxlength="100" class="form" type="url" value="<?php echo "{$row['url']}"; ?>"></div>
        </div>
<?php include('docid-field-edit.php'); ?>
		<div class="row medium-collapse" style="padding-left: 30px; padding-bottom: 20px;">
			<div class="small-12 medium-12 columns"><label for="detailsmini" class="middle">Event description and details for external calendar applications<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">This information is included in iCal/Outlook calendar links.</span><br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Do NOT use HTML or special characters.</span> <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">500 characters maximum.</span></label>
				<textarea name="detailsmini" maxlength="500" cols="45" rows="4"><?php echo "{$row['detailsmini']}"; ?></textarea>
			</div>
		</div>
		<div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>3) Ready to Save?</strong></div>
        </div>
        <div class="row medium-collapse">
            <div class="small-6 columns" align="center">
            	<input type="hidden" name="action" value="save">
            	<input type="hidden" name="int1" value="<?php echo $_POST['int1']; ?>">
            	<input name="submit" value="Save and Duplicate" class="submit" type="submit">
            </div>
</form>
            <div class="small-6 end columns" align="center">
<form action="calendar.php" method="get">
                <input type="submit" value="Cancel &amp; Return to Calendar" onclick="return confirm('Are you sure you wish to leave this page? Unsaved changes will be lost.');">
</form>
            </div>
        </div>
    </div>
</div>
<?php
	}
?>
<?php }; ?>
<!-- DUPLICATE FROM SPECIFIC INPUT FORM -->
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Calendar Copy Control Panel Page<br></div>
</body>
</html>
