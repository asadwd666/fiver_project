<?php $current_page = '24'; include('protect.php'); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="CondoSites - http://www.condosites.com" name="author">
<title>Control Panel</title>
<?php include('../control/cp-head-scripts.php'); ?>
</head>
<body>
<!-- LOGO AND NAVIGATION -->
<?php include('cp-navigation.php'); ?>
<!-- END LOGO AND NAVIGATION -->
<?php $id = $_POST["id"]; $action = $_POST["action"]; if ($action != null){ ?>
<?php
	if ($action == "OptimizeDatabases"){
		$query = "OPTIMIZE TABLE `3rd`, `board`, `calendar`, `chalkboard`, `concierge`, `documents`, `documentsrestricted`, `faq`, `folders`, `forms`, `log`, `meetingbox`, `messages`, `packages`, `pets`, `realestate`, `tabs`, `updatedate`, `users`, `utilities`, `vehicles`";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
		
		    $errorSUCCESSDB = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Database optimized successfully.</strong></div><br>";

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		
		$query = "INSERT INTO `log` (action, tablename, useripaddress, userid, id) VALUES ('P', 'Database', '$useripaddress', '$userid', 'Optimized')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
	}

	if ($action == "SPAMpurge"){
		$query = "DELETE FROM `users` WHERE `phone`='123456'";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

            $errorSUCCESSDB = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>SPAM users purged successfully.</strong></div><br>";

		$query = "OPTIMIZE TABLE `users`";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		$query = "INSERT INTO `log` (action, tablename, useripaddress, userid, id) VALUES ('P', 'SPAM', '$useripaddress', '$userid', 'Purge')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

	}

	if ($action == "DOCUMENTSpurge"){
		$query = "DELETE FROM `documents` WHERE aod BETWEEN '0000-01-01' AND CURDATE() - INTERVAL 1 DAY AND SYSDATE()";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

		    $errorSUCCESSDB = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Deletable documents have been purged successfully.</strong></div><br>";

		$query = "OPTIMIZE TABLE `documents`";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		
		$query = "INSERT INTO `log` (action, tablename, useripaddress, userid, id) VALUES ('P', 'Documents', '$useripaddress', '$userid', 'Purge')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
	}

	if ($action == "PACKAGEpurge"){
		$query = "DELETE FROM `packages` WHERE `pickedup` BETWEEN '0001-01-01' AND CURDATE() - INTERVAL 101 DAY";
		mysqli_query($conn,$query) or die('Error, delete query failed');
		
		    $errorSUCCESSDB = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Old packages purged successfully.</strong></div><br>";

		$query = "OPTIMIZE TABLE `packages`";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		
		$query = "INSERT INTO `log` (action, tablename, useripaddress, userid, id) VALUES ('P', 'Package', '$useripaddress', '$userid', 'Purge')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
	}

    if ($action == "CLASSIFIEDSpurge"){
		$query = "DELETE FROM `realestate` WHERE `approved` = 'Y' AND `eod` BETWEEN '0001-01-01' AND CURDATE() - INTERVAL 450 DAY";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
		
		        $errorSUCCESSDB = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Old classified ads purged successfully.</strong></div><br>";

		$query = "OPTIMIZE TABLE `realestate`";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		
		$query = "INSERT INTO `log` (action, tablename, useripaddress, userid, id) VALUES ('P', 'Classifieds', '$useripaddress', '$userid', 'Purge')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
	}

	if ($action == "CALENDARpurge"){
		$query = "DELETE FROM `calendar` WHERE `date` < CURDATE() AND `date` NOT BETWEEN CURDATE() - INTERVAL 450 DAY AND SYSDATE() AND `date` != '0000-00-00'";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

		        $errorSUCCESSDB = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Old calendar events purged successfully.</strong></div><br>";

		$query = "OPTIMIZE TABLE `calendar`";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		
		$query = "INSERT INTO `log` (action, tablename, useripaddress, userid, id) VALUES ('P', 'Calendar', '$useripaddress', '$userid', 'Purge')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
	}

    if ($action == "MESSAGESpurge"){
		$query = "DELETE FROM `messages` WHERE `status` = 'S' AND `date` BETWEEN '0001-01-01' AND CURDATE() - INTERVAL 450 DAY;";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

		        $errorSUCCESSDB = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Old messages purged successfully.</strong></div><br>";

		$query = "OPTIMIZE TABLE `messages`";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		
		$query = "INSERT INTO `log` (action, tablename, useripaddress, userid, id) VALUES ('P', 'Messages', '$useripaddress', '$userid', 'Purge')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
	}

    if ($action == "NEWSBOARDpurge"){
		$query = "DELETE FROM `chalkboard` WHERE eod < CURDATE() AND eod NOT BETWEEN CURDATE() - INTERVAL 450 DAY AND SYSDATE()";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
		
		        $errorSUCCESSDB = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Old Newsboard Articles purged successfully.</strong></div><br>";

		$query = "OPTIMIZE TABLE `chalkboard`";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		
		$query = "INSERT INTO `log` (action, tablename, useripaddress, userid, id) VALUES ('P', 'Classifieds', '$useripaddress', '$userid', 'Purge')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
	}

    if ($action == "RENTERpurge"){
		$query = "DELETE FROM `users` WHERE `accessdate` NOT BETWEEN CURDATE( ) - INTERVAL 60 DAY AND SYSDATE( ) AND `accessdate` <= CURDATE( ) AND `accessdate` != '0000-00-00' AND `status` = 'active'";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
		
		        $errorSUCCESSDB = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Old renters purged successfully.</strong></div><br>";

		$query = "OPTIMIZE TABLE `users`";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		
		$query = "INSERT INTO `log` (action, tablename, useripaddress, userid, id) VALUES ('P', 'Renter', '$useripaddress', '$userid', 'Purge')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
	}

    if ($action == "DISABLEDpurge"){
		$query = "DELETE FROM `users` WHERE `accessdate` NOT BETWEEN CURDATE() - INTERVAL 365 DAY AND SYSDATE() AND `accessdate` <= CURDATE() AND `accessdate` != '0000-00-00' AND `status` = 'disabled'";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
		
		        $errorSUCCESSDB = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Old users purged successfully.</strong></div><br>";

		$query = "OPTIMIZE TABLE `users`";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		$query = "INSERT INTO `log` (action, tablename, useripaddress, userid, id) VALUES ('P', 'Disabled Users', '$useripaddress', '$userid', 'Purge')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
	}

    if ($action == "LOGpurge"){
		$query = "DELETE FROM `log` WHERE `created_date` NOT BETWEEN CURDATE() - INTERVAL 450 DAY AND SYSDATE()";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
		
		        $errorSUCCESSDB = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Old logs purged successfully.</strong></div><br>";

		$query = "OPTIMIZE TABLE `log`";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		
		$query = "INSERT INTO `log` (action, tablename, useripaddress, userid, id) VALUES ('P', 'Log', '$useripaddress', '$userid', 'Purge')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
	}

	    if ($action == "PETSpurge"){
		$query = "DELETE FROM `pets` WHERE `userid` NOT IN (SELECT `id` FROM `users`) AND `userid` != '0'";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

		        $errorSUCCESSDB = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Old pets purged successfully.</strong></div><br>";

		$query = "OPTIMIZE TABLE `log`";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		
		$query = "INSERT INTO `log` (action, tablename, useripaddress, userid, id) VALUES ('P', 'Pets', '$useripaddress', '$userid', 'Purge')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
	}

	    if ($action == "CARSpurge"){
		$query = "DELETE FROM `vehicles` WHERE `userid` NOT IN (SELECT `id` FROM `users`) AND `userid` != '0'";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
		
		        $errorSUCCESSDB = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Old vehicles and bicycles purged successfully.</strong></div><br>";

		$query = "OPTIMIZE TABLE `log`";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		
		$query = "INSERT INTO `log` (action, tablename, useripaddress, userid, id) VALUES ('P', 'Vehicles', '$useripaddress', '$userid', 'Purge')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
	}

}
?>
<!-- DATABASE CALCULATIONS -->
<?php $sqlDBMcDBoptimized = mysqli_query($conn,"SELECT count(*) FROM `log` WHERE `id` = 'Optimized' ORDER BY `created_date` DESC LIMIT 1") or die(mysqli_error($conn));
//$countDBMcDBoptimized = mysql_result($sqlDBMcDBoptimized, "0");
$row = mysqli_fetch_row($sqlDBMcDBoptimized);
$countDBMcDBoptimized = $row[0];
?>
<?php $sqlDBMcSPAM = mysqli_query($conn,"SELECT count(*) FROM users WHERE webmaster = '0' AND phone = '123456'") or die(mysqli_error($conn));
//$countDBMcSPAM = mysql_result($sqlDBMcSPAM, "0");
$row = mysqli_fetch_row($sqlDBMcSPAM);
$countDBMcSPAM = $row[0];
?>
<?php $sqlDBMcDOC = mysqli_query($conn,"SELECT count(*) FROM documents WHERE aod BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() - INTERVAL 1 DAY AND SYSDATE()") or die(mysqli_error($conn));
//$countDBMcDOC = mysql_result($sqlDBMcDOC, "0");
$row = mysqli_fetch_row($sqlDBMcDOC);
$countDBMcDOC = $row[0];
?>
<?php $sqlDBMcPKG = mysqli_query($conn,"SELECT count(*) FROM packages WHERE `pickedup` BETWEEN '0001-01-01' AND CURDATE() - INTERVAL 101 DAY") or die(mysqli_error($conn));
//$countDBMcPKG = mysql_result($sqlDBMcPKG, "0");
$row = mysqli_fetch_row($sqlDBMcPKG);
$countDBMcPKG = $row[0];
?>
<?php $sqlDBMcCFD = mysqli_query($conn,"SELECT count(*) FROM realestate WHERE `approved` = 'Y' AND `eod` BETWEEN '0001-01-01' AND CURDATE() - INTERVAL 450 DAY") or die(mysqli_error($conn));
//$countDBMcCFD = mysql_result($sqlDBMcCFD, "0");
$row = mysqli_fetch_row($sqlDBMcCFD);
$countDBMcCFD = $row[0];
?>
<?php $sqlDBMcCAL = mysqli_query($conn,"SELECT count(*) FROM calendar WHERE `date` < CURDATE() AND `date` NOT BETWEEN CURDATE() - INTERVAL 450 DAY AND SYSDATE() AND `date` != '0000-00-00'") or die(mysqli_error($conn));
//$countDBMcCAL = mysql_result($sqlDBMcCAL, "0");
$row = mysqli_fetch_row($sqlDBMcCAL);
$countDBMcCAL = $row[0];
?>
<?php $sqlDBMcMSG = mysqli_query($conn,"SELECT count(*) FROM messages WHERE `status` = 'S' AND `date` BETWEEN '0001-01-01' AND CURDATE() - INTERVAL 450 DAY;") or die(mysqli_error($conn));
//$countDBMcMSG = mysql_result($sqlDBMcMSG, "0");
$row = mysqli_fetch_row($sqlDBMcMSG);
$countDBMcMSG = $row[0];
?>
<?php $sqlDBMcNEWS = mysqli_query($conn,"SELECT count(*) FROM chalkboard WHERE eod < CURDATE() AND eod NOT BETWEEN CURDATE() - INTERVAL 450 DAY AND SYSDATE()") or die(mysqli_error($conn));
//$countDBMcNEWS = mysql_result($sqlDBMcNEWS, "0");
$row = mysqli_fetch_row($sqlDBMcNEWS);
$countDBMcNEWS = $row[0];
?>
<?php $sqlDBMcRENT = mysqli_query($conn,"SELECT count(*) FROM users WHERE `accessdate` NOT BETWEEN CURDATE( ) - INTERVAL 60 DAY AND SYSDATE( ) AND `accessdate` <= CURDATE( ) AND `accessdate` != '0000-00-00' AND `status` = 'active'") or die(mysqli_error($conn));
//$countDBMcRENT = mysql_result($sqlDBMcRENT, "0");
$row = mysqli_fetch_row($sqlDBMcRENT);
$countDBMcRENT = $row[0];
?>
<?php $sqlDBMcDISU = mysqli_query($conn,"SELECT count(*) FROM users WHERE `accessdate` NOT BETWEEN CURDATE() - INTERVAL 365 DAY AND SYSDATE() AND `accessdate` <= CURDATE() AND `accessdate` != '0000-00-00' AND `status` = 'disabled'") or die(mysqli_error($conn));
//$countDBMcDISU = mysql_result($sqlDBMcDISU, "0");
$row = mysqli_fetch_row($sqlDBMcDISU);
$countDBMcDISU = $row[0];
?>
<?php $sqlDBMcLOG = mysqli_query($conn,"SELECT count(*) FROM `log` WHERE `created_date` NOT BETWEEN CURDATE() - INTERVAL 450 DAY AND SYSDATE()") or die(mysqli_error($conn));
//$countDBMcLOG = mysql_result($sqlDBMcLOG, "0");
$row = mysqli_fetch_row($sqlDBMcLOG);
$countDBMcLOG = $row[0];
?>
<?php $sqlDBMcPETS = mysqli_query($conn,"SELECT count(*) FROM `pets` WHERE `userid` NOT IN (SELECT `id` FROM `users`) AND `userid` != '0'") or die(mysqli_error($conn));
//$countDBMcPETS = mysql_result($sqlDBMcPETS, "0");
$row = mysqli_fetch_row($sqlDBMcPETS);
$countDBMcPETS = $row[0];
?>
<?php $sqlDBMcCARS = mysqli_query($conn,"SELECT count(*) FROM `vehicles` WHERE `userid` NOT IN (SELECT `id` FROM `users`) AND `userid` != '0'") or die(mysqli_error($conn));
//$countDBMcCARS = mysql_result($sqlDBMcCARS, "0");
$row = mysqli_fetch_row($sqlDBMcCARS);
$countDBMcCARS = $row[0];
?>
<!-- END DATABASE CALCULATIONS -->

<!-- HEALTH AND HELP -->
<div>
    <div class="large-8 columns" style="padding: 0px">
        <div class="nav-section-header-health-cp" align="center">
<big><i class="fa fa-stethoscope" aria-hidden="true"></i></big><strong>&nbsp;Health&nbsp;&nbsp;&nbsp;</strong>

<?php if ($countDBMcSPAM == '0' AND $countDBMcDOC == '0' AND $countDBMcPKG == '0' AND $countDBMcCFD == '0' AND $countDBMcCAL == '0' AND $countDBMcMSG == '0' AND $countDBMcNEWS == '0' AND $countDBMcRENT == '0' AND $countDBMcDISU == '0' AND $countDBMcLOG == '0' AND $countDBMcDBoptimized >= '1'){ ?>
<i class="fa fa-check" aria-hidden="true"></i> All of your databases are optimized!
<?php }; ?>

<?php if ($countDBMcSPAM >= '1' OR $countDBMcDOC >= '1' OR $countDBMcPKG >= '1' OR $countDBMcCFD >= '1' OR $countDBMcCAL >= '1' OR $countDBMcMSG >= '1' OR $countDBMcNEWS >= '1' OR $countDBMcRENT >= '1' OR $countDBMcDISU >= '1' OR $countDBMcLOG >= '1' OR $countDBMcDBoptimized == '0'){ ?>
<i class="fa fa-exclamation-triangle note" aria-hidden="true"></i> It may be time to purge some data or optimize your database!
<?php }; ?>

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

<div class="row cp-help">
    <div class="small-12 medium-6 columns">
        <p><b>Database Maintenance</b> allows you to quickly purge old content and optimize your database to improve website performance.</p>
    </div>
    <div class="small-12 medium-6 columns">
        <p>
            <i class="fa fa-hand-o-right" aria-hidden="true"></i>  <span class="note-red">It is <b>NOT</b> necessary to perform these actions more than once per month.</span><br>
            <i class="fa fa-hand-o-right" aria-hidden="true"></i>  <span class="note-red">Your CondoSites webmaster will perform these actions for you quarterly.</span>
        </p>
    </div>
</div>
<?php echo($errorSUCCESSDB); ?>

<div style="max-width: 99%;">

<!-- DATABASE OPTIMIZE -->
<?php if ($countDBMcDBoptimized >= '1'){ ?>
<div class="nav-section-header-cp">
        <strong><i class="fa fa-check" aria-hidden="true"></i> Your database was last optimized on <?php $query  = "SELECT `created_date` FROM `log` WHERE `id` = 'Optimized' ORDER BY `created_date` DESC LIMIT 1"; $result = mysqli_query($conn, $query); while($row = $result->fetch_array(MYSQLI_ASSOC)) {echo date('M d, Y', strtotime($row['created_date']));} ?></strong>
</div>
<br>
<?php }; ?>
<?php if ($countDBMcDBoptimized == '0'){ ?>
<div class="nav-section-header-cp">
        <strong>Optimize Database</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
        <tr>
            <th>
                <div style="float: right;">
	                <form name="OptimizeDatabases" method="POST" action="databasemaintenance.php" onclick="return confirm('Are you sure you want to optimize the database?');">
	                    <input type="hidden" name="action" value="OptimizeDatabases">
	                    <input name="submit" value="Optimize Database" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
	                </form>
	            </div>
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">An optimized database improves the performance of your website.</span><br>
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Your database was last optimized on <?php $query  = "SELECT `created_date` FROM `log` WHERE `id` = 'Optimized' ORDER BY `created_date` DESC LIMIT 1"; $result = mysqli_query($conn, $query); while($row = $result->fetch_array(MYSQLI_ASSOC)) {echo date('M d, Y', strtotime($row['created_date']));} ?>.</span>
            </th>
        </tr>
  </thead>
</table>
<br>
<?php }; ?>
<!-- END DATABASE OPTIMIZE -->

<!-- SPAM -->
<?php if ($countDBMcSPAM == '0'){ ?>
<div class="nav-section-header-cp">
        <strong><i class="fa fa-check" aria-hidden="true"></i> <?php print($countDBMcSPAM); ?> Potential SPAM User Accounts</strong>
</div>
<br>
<?php }; ?>
<?php if ($countDBMcSPAM >= '1'){ ?>
<div class="nav-section-header-cp" style="background-color:#ffa800">
        <strong><?php print($countDBMcSPAM); ?> Potential SPAM Accounts</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
    <thead>
        <tr>
            <th colspan="10"><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Carefully review the list below of potential SPAM accounts. Edit to correct any legitimate accounts. Lastly click the "Purge SPAM Accounts" button.</span>
                <div align="right">
	            <form name="SPAMpurge" method="POST" action="databasemaintenance.php" onclick="return confirm('Are you sure you want to purge this data? This can NOT be undone!');">
	                <input type="hidden" name="action" value="SPAMpurge">
	                <input name="submit" value="Purge Data" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
                </form>
                </div>
            </th>
        </tr>
        <tr align="left">
            <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>User</small></th>
            <th width="50" class="table-sortable:numeric"><small>&nbsp;&nbsp;&nbsp; ID</small></th>
            <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Unit</small></th>
            <th class="table-sortable:alphanumeric table-filterable">&nbsp;</th>
			<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Owner</small></b></div></th>
			<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Renter</small></b></div></th>
			<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Realtor</small></b></div></th>
			<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Board</small></b></div></th>
			<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Staff</small></b></div></th>
			<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Admin</small></b></div></th>
        </tr>
    </thead>
    <tbody>
<?php
	$query  = "SELECT `id`, unit, unit2, last_name, first_name, email, phone, useripaddress, owner, lease, realtor, board, concierge, liaison, account, comments, status, created_date, directory, dphone, hide, accessdate, ghost, flex1, flex2, flex3, flex4, flex5, packagepreference FROM users WHERE webmaster = '0' AND phone = '123456' AND ghost != 'Y' ORDER BY `id` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
        <tr>
            <td>
                <div class="small-12 medium-12 large-12 columns">
                <b><?php echo "{$row['last_name']}"; ?>, <?php echo "{$row['first_name']}"; ?></b>
<!-- COMMENTS -->
                <?php if ($row['comments'] != ''){ ?><i class="fa fa-comment" aria-hidden="true" align="right" title="<?php echo "{$row['comments']}"; ?>"></i><?php }; ?>
<!-- END COMMENTS -->
<!-- PETS -->
<?php
	$type   = $row['id'];
	$query2  = "SELECT userid FROM pets WHERE userid = '$type' LIMIT 1";
	$result2 = mysqli_query($conn,$query2);

	while($row2 = $result2->fetch_array(MYSQLI_ASSOC))
	{
?>
                <i class="fa fa-paw" aria-hidden="true" align="right" title="This user has pets registered."></i>
<?php
	}
?>
<!-- END PETS -->
<!-- VEHICLES -->
<?php
	$type   = $row['id'];
	$query2  = "SELECT userid FROM vehicles WHERE userid = '$type' AND MODEL != 'B*' LIMIT 1";
	$result2 = mysqli_query($conn,$query2);

	while($row2 = $result2->fetch_array(MYSQLI_ASSOC))
	{
?>
                <i class="fa fa-car" aria-hidden="true" align="right" title="This user has vehicles/bicycle registered."></i>
<?php
	}
?>
<!-- END VEHICLES -->
<!-- BICYCLES -->
<?php
	$type   = $row['id'];
	$query2  = "SELECT userid FROM vehicles WHERE userid = '$type' AND MODEL = 'B*' LIMIT 1";
	$result2 = mysqli_query($conn,$query2);

	while($row2 = $result2->fetch_array(MYSQLI_ASSOC))
	{
?>
                <i class="fa fa-bicycle" aria-hidden="true" align="right" title="This user has vehicles/bicycle registered."></i>
<?php
	}
?>
<!-- END BICYCLES -->
                <span class="note-black"><br>Created <?php echo "{$row['created_date']}"; ?><?php if ($row['account'] !== ''){ ?><br>Acct &#35;<?php echo "{$row['account']}"; ?><?php }; ?></span>
                <br><a href="<?php echo "{$row['email']}"; ?>"><?php echo "{$row['email']}"; ?></a>
                <br><?php echo "{$row['phone']}"; ?>
                <?php if ($row['accessdate'] >= '0000-00-01' && $row['accessdate'] <= $currentdate){ ?><br><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="note-red">Lease/Access Through Date <?php echo "{$row['accessdate']}"; ?></span><?php }; ?>
                <?php if ($row['status'] == 'suspended'){ ?><br><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="note-red">Suspended by Administrator</span><?php }; ?>
                <?php if ($row['email'] == ''){ ?><br><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="note-red">No&nbsp;Email</span><?php }; ?>
                <?php if ($row['password'] == ''){ ?><br><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="note-red">No&nbsp;Password</span><?php }; ?>
                <?php if ($row['owner'] == '0' AND $row['lease'] == '0' AND $row['realtor'] == '0'){ ?><br><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="note-red">No&nbsp;Permissions</span><?php }; ?>
                </div>
            </td>
            </td>
            <td><?php echo "{$row['id']}"; ?></td>
            <td><?php echo "{$row['unit']}"; ?></td>
            <td><?php echo "{$row['unit2']}"; ?></td>
            <?php if ($row['owner'] !== '1'){ ?><td align="center" bgcolor="#ffcccc">N</td><?php }; ?><?php if ($row['owner'] !== '0'){ ?><td align="center" bgcolor="#ccffcc">Y</td><?php }; ?>
            <?php if ($row['lease'] !== '1'){ ?><td align="center" bgcolor="#ffcccc">N</td><?php }; ?><?php if ($row['lease'] !== '0'){ ?><td align="center" bgcolor="#ccffcc">Y</td><?php }; ?>
            <?php if ($row['realtor'] !== '1'){ ?><td align="center" bgcolor="#ffcccc">N</td><?php }; ?><?php if ($row['realtor'] !== '0'){ ?><td align="center" bgcolor="#ccffcc">Y</td><?php }; ?>
            <?php if ($row['board'] !== '1'){ ?><td align="center" bgcolor="#f4d6a3">N</td><?php }; ?><?php if ($row['board'] !== '0'){ ?><td align="center" bgcolor="#ccffcc">Y</td><?php }; ?>
            <?php if ($row['concierge'] !== '1'){ ?><td align="center" bgcolor="#f4d6a3">N</td><?php }; ?><?php if ($row['concierge'] !== '0'){ ?><td align="center" bgcolor="#ccffcc">Y</td><?php }; ?>
            <?php if ($row['liaison'] !== '1'){ ?><td align="center" bgcolor="#f4d6a3">N</td><?php }; ?><?php if ($row['liaison'] !== '0'){ ?><td align="center" bgcolor="#ccffcc">Y</td><?php }; ?>
        </tr>
<!-- END DATABASE RESULTS -->
<?php
	}
?>
    </tbody>
</table>
<br>
<?php }; ?>
<!-- END SPAM USERS -->

<!-- DOCUMENTS -->
<?php if ($countDBMcDOC == '0'){ ?>
<div class="nav-section-header-cp">
        <strong><i class="fa fa-check" aria-hidden="true"></i> <?php print($countDBMcDOC); ?> Deleteable Documents</strong>
</div>
<br>
<?php }; ?>
<?php if ($countDBMcDOC >= '1'){ ?>
<div class="nav-section-header-cp">
        <strong><?php print($countDBMcDOC); ?> Deletable Documents</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
        <tr>
            <th colspan="10">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Deleted documents will appear here for 30-days after deletion.</span><br>
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Click the Purge Data button to perminantly delete these documents now.</span>
                <div align="right">
	            <form name="DOCUMENTSpurge" method="POST" action="databasemaintenance.php" onclick="return confirm('Are you sure you want to purge this data? This can NOT be undone!');">
	                <input type="hidden" name="action" value="DOCUMENTSpurge">
	                <input name="submit" value="Purge Data" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
                </form>
                </div>
            </th>
        </tr>
    <tr align="left">
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Document Title</small></th>
      <th align="center" width="50" class="table-sortable:numeric">&nbsp;&nbsp;&nbsp; <small>ID</small></th>
      <th class="table-sortable:date">&nbsp;&nbsp;&nbsp; <a title="Document Date - This is NOT the date the document was uploaded."><small>Date</small></a></th>
      <th class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <small>Folder</small></th>
	  <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Owner</small></b></div></th>
	  <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Renter</small></b></div></th>
	  <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Realtor</small></b></div></th>
	  <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Public</small></b></div></th>
	  <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Board</small></b></div></th>
    </tr>
  </thead>
  <tbody style="background-color:#ffffff">
<!-- DATABASE RESULTS -->
<?php
	$query  = "SELECT `id`, type, title, docdate, doctype, owner, lease, realtor, public, board, aod, size, created_date, userid FROM documents WHERE aod BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() - INTERVAL 1 DAY AND SYSDATE() ORDER BY `id` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
    <tr>
      <td>
        <div class="small-12 medium-12 large-8 columns">
        <a href="../download-documents.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$row['id']}"; ?>'); "><b><?php echo "{$row['title']}"; ?></b></a>
        <div style="float: left; padding: 8px;"><?php include('../icon-links.php'); ?></div>
        <span class="note-black"><br>Uploaded <?php echo date('Y-m-d', strtotime($row['created_date'])); ?>
<?php
	$type    = $row['userid'];
	$query1  = "SELECT last_name, first_name FROM users WHERE id = '$type' AND id != ''";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?>
 by <?php echo "{$row1['first_name']}"; ?> <?php echo "{$row1['last_name']}"; ?>
<?php
	}
?>
        </span>
        <?php if ($row['aod'] !== '0000-00-00'){ ?><span class="note-red"><br>Delete After <?php echo "{$row['aod']}"; ?></span><?php }; ?>
        </div>
        <div class="small-12 medium-12 large-4 columns">
            <form method="POST" action="documents-list.php" onclick="return confirm('Are you sure you want to recover the document: <?php echo "{$row['title']}"; ?>?');">
                <input type="hidden" name="action" value="recover">
                <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
                <input name="submit" value="Recover Document" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
            </form>
        </div>
      </td>
      <td><?php echo "{$row['id']}"; ?></td>
      <td><?php echo "{$row['docdate']}"; ?><br></td>
      <td><?php echo "{$row['doctype']}"; ?><br></td>
      <td align="center" <?php if ($row['owner'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['owner'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['owner']}"; ?><br></td>
      <td align="center" <?php if ($row['lease'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['lease'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['lease']}"; ?><br></td>
      <td align="center" <?php if ($row['realtor'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['realtor'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['realtor']}"; ?><br></td>
      <td align="center" <?php if ($row['public'] == 'N'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['public'] == 'Y'){ ?>bgcolor="#ccffcc"<?php }; ?><?php if ($row['public'] == 'H'){ ?>bgcolor="#caecec"<?php }; ?>><?php echo "{$row['public']}"; ?><br></td>
      <td align="center" <?php if ($row['board'] !== 'Y'){ ?>bgcolor="#f4d6a3"<?php }; ?><?php if ($row['board'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['board']}"; ?><br></td>
    </tr>
<?php
	}
?>
  </tbody>
</table>
<br>
<?php }; ?>
<!-- END DOCUMENTS -->

<!-- PACKAGES -->
<?php if ($countDBMcPKG == '0'){ ?>
<div class="nav-section-header-cp">
        <strong><i class="fa fa-check" aria-hidden="true"></i> <?php print($countDBMcPKG); ?> Total Packages</strong>
</div>
<br>
<?php }; ?>
<?php if ($countDBMcPKG >= '1'){ ?>
<div class="nav-section-header-cp">
        <strong><?php print($countDBMcPKG); ?> Total Packages</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
    <thead>
        <tr>
            <th colspan="5">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Carefully review the list below of packages that were delivered over 90 days ago. Then click the "Purge Old Packages and Deliveries" button below.</span>
                <div align="right">
	                <form name="PACKAGEpurge" method="POST" action="databasemaintenance.php" onclick="return confirm('Are you sure you want to purge this data? This can NOT be undone!');">
	                    <input type="hidden" name="action" value="PACKAGEpurge">
	                    <input name="submit" value="Purge Data" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
                    </form>
                </div>
            </th>
        </tr>
        <tr align="left">
            <th class="table-sortable:alphanumeric"><b>&nbsp;&nbsp;&nbsp; <small>Details</small></th>
            <th align="center" width="50" class="table-sortable:numeric">&nbsp;&nbsp;&nbsp; <small>ID</small></th>
            <th class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <small>Unit</small></th>
            <th class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <small>Recipient</small></th>
            <th class="table-sortable:alphanumeric"><b>&nbsp;&nbsp;&nbsp; <small>Received</small></th>
        </tr>
    </thead>
    <tbody style="background-color:#ffffff">
<?php
	$query  = "SELECT * FROM packages WHERE `pickedup` BETWEEN '0001-01-01' AND CURDATE() - INTERVAL 101 DAY ORDER BY `int1` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
        <tr>
            <td>
                <div class="small-12 medium-12 large-8 columns">
<div style="float:right; width: 60px;"><?php include('package-graphics.php'); ?></div>
<?php echo "{$row['from']}"; ?><br>
<?php if ($row['pkgtracking'] !== ''){ ?><b>Trk&#35;</b><?php include('package-track.php'); ?><?php }; ?><br>
<?php if ($row['pkglocation'] !== ''){ ?><span class="note-red"><big><?php echo "{$row['pkglocation']}"; ?></big></span><?php }; ?><br>
<?php if ($row['received'] !== ''){ ?><b>In </b><?php echo date('Y-m-d g:i a', strtotime($row['received'])); ?> <b>by </b><?php echo "{$row['recemp']}"; ?><?php }; ?>
<?php if ($row['pickedup'] !== '0000-00-00 00:00:00'){ ?><br><b>Out </b><?php echo date('Y-m-d g:i a', strtotime($row['pickedup'])); ?><b> by </b><?php echo "{$row['puemp']}"; ?><?php }; ?> <?php if ($row['pickedupby'] !== ''){ ?><b>to </b><?php echo "{$row['pickedupby']}"; ?><?php }; ?>
<?php if ($row['comments'] !== ''){ ?><br><?php echo "{$row['comments']}"; ?><?php }; ?>
                </div>
                <div class="small-6 medium-6 large-2 columns">
	                <form name="PKGDelete" method="POST" action="packages.php" onclick="return confirm('Are you sure you want to DELETE this <?php echo "{$row['packagetype']}"; ?>?');">
	                    <input type="hidden" name="action" value="delete">
	                    <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
	                    <input name="submit" value="Delete" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
	                </form>
                </div>
                <div class="small-6 medium-6 large-2 columns">
	                <form name="PKGEdit" method="POST" action="packages-edit.php">
	                    <input type="hidden" name="action" value="edit">
	                    <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
	                    <input name="submit" value="Edit" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
	                </form>
                </div>
            </td>
            <td><?php echo "{$row['int1']}"; ?></td>
            <td>
<?php if ($row['userid'] == '0'){ ?>*<?php }; ?>
<?php if ($row['userid'] != '0'){ ?>
<?php
	$type    = $row['userid'];
	$query1  = "SELECT id, unit, unit2, last_name, first_name, email, phone FROM users WHERE id = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?>
<b><?php echo "{$row1['unit']}"; ?> <?php if ($row1['unit2'] != 'X'){ ?><?php echo "{$row1['unit2']}"; ?><?php }; ?></b>
<?php
	}
?>
<?php }; ?>
            </td>
            <td>
<?php if ($row['userid'] == '0'){ ?><b><?php echo "{$row['recipient']}"; ?><?php }; ?>
<?php if ($row['userid'] != '0'){ ?>
<?php
	$type    = $row['userid'];
	$query1  = "SELECT id, email, unit, unit2, last_name, first_name, email, phone, packagepreference FROM users WHERE id = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?>
<b><a href="mailto:<?php echo "{$row1['email']}"; ?>"><?php echo "{$row1['last_name']}"; ?>, <?php echo "{$row1['first_name']}"; ?></a> </b><br><?php echo "{$row1['phone']}"; ?>

<?php if ($row1['packagepreference'] !== 'X'){ ?>
<br><span class="note-red"><?php echo "{$row1['packagepreference']}"; ?></span>
<?php }; ?>
<?php
	}
?>
<?php }; ?>
            </td>
            <td>
                <?php if (($row['userid'] !== '0') && ($row['pickedup'] == '0000-00-00 00:00:00')){ ?>
	            <form method="POST" action="" onclick="return confirm('Are you sure you want to send a reminder about this package?');">
		            <input name="submit" value="Remind" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
		            <input name="email" type="hidden" value="<?php echo($email); ?>" />
		            <input name="action" type="hidden" value="email_remind" />
		            <input name="from" type="hidden" value="<?php echo($row['from']); ?>" />
		            <input name="pkgtracking" type="hidden" value="<?php echo($row['pkgtracking']); ?>" />
		            <input name="packagetype" type="hidden" value="<?php echo($row['packagetype']); ?>" />
		            <input name="comments" type="hidden" value="<?php echo($row['comments']); ?>" />
	                <input type="hidden" name="message" value="<?php include('../my-documents/package-locations.php'); ?>" class="form">
	            </form>
	            <br>
                <?php }; ?>
                <?php if ($row['pickedup'] == '0000-00-00 00:00:00'){ ?>
                <form name="PKGDeliver" method="POST" action="packages-deliver.php">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
                    <input name="submit" value="Deliver" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
                </form>
                <?php }; ?>
                <?php if ($row['pickedup'] !== '0000-00-00 00:00:00'){ ?>
                <form name="PKGDeliver" method="POST" action="packages-deliver.php">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
                    <input name="submit" value="Undeliver" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
                </form>
                <?php }; ?>
            </td>
        </tr>
<?php
	}
?>
  </tbody>
</table>
<br>
<?php }; ?>
<!-- END PACKAGES -->

<!-- CLASSIFIEDS -->
<?php if ($countDBMcCFD == '0'){ ?>
<div class="nav-section-header-cp">
        <strong><i class="fa fa-check" aria-hidden="true"></i> <?php print($countDBMcCFD); ?> Expired Listings</strong>
</div>
<br>
<?php }; ?>
<?php if ($countDBMcCFD >= '1'){ ?>
<div class="nav-section-header-cp">
        <strong>
<?php print($countDBMcCFD); ?> Expired Listings (
<?php $sql = mysqli_query($conn,"SELECT count(*) FROM realestate WHERE forsalerent = 'SALE' AND `eod` BETWEEN '0001-01-01' AND CURDATE() - INTERVAL 450 DAY") or die(mysqli_error($conn));
//$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Sale /
<?php $sql = mysqli_query($conn,"SELECT count(*) FROM realestate WHERE forsalerent = 'RENT' AND `eod` BETWEEN '0001-01-01' AND CURDATE() - INTERVAL 450 DAY") or die(mysqli_error($conn));
//$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Rent /
<?php $sql = mysqli_query($conn,"SELECT count(*) FROM realestate WHERE forsalerent = 'CLASSIFIED' AND `eod` BETWEEN '0001-01-01' AND CURDATE() - INTERVAL 450 DAY") or die(mysqli_error($conn));
//$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Classified )
        </strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
    <thead>
		<tr align="center">
			<th style="background-color:#eeeddd" valign="top" colspan="4">
			    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Expired classifieds are retained for 15-months.</span>
			    <div align="right">
	            <form name="CLASSIFIEDSpurge" method="POST" action="databasemaintenance.php" onclick="return confirm('Are you sure you want to purge this data? This can NOT be undone!');">
	                <input type="hidden" name="action" value="CLASSIFIEDSpurge">
	                <input name="submit" value="Purge Data" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
                </form>
                </div>
            </th>
		</tr>
        <tr align="left">
            <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Listing</small></th>
            <th width="50" class="table-sortable:numeric">&nbsp;&nbsp;&nbsp; <small>ID</small></th>
            <th class="table-sortable:date table-filterable">&nbsp;&nbsp;&nbsp; <small>Expiration</small></th>
            <th class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <small>Type</small></th>
        </tr>
    </thead>
    <tbody style="background-color:#ffffff">
<!-- DATABASE RESULTS -->
<?php
    $query  = "SELECT * FROM realestate WHERE `approved` = 'Y' AND `eod` BETWEEN '0001-01-01' AND CURDATE() - INTERVAL 450 DAY ORDER BY `int1` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- DATABASE RESULTS -->
    <tr>
      <td>
        <b><?php echo "{$row['headline']}"; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "{$row['price']}"; ?><br>
        <blockquote><?php echo "{$row['description']}"; ?></blockquote>
      </td>
      <td><?php echo "{$row['int1']}"; ?></td>
      <td><?php echo "{$row['eod']}"; ?></td>
      <td><?php echo "{$row['forsalerent']}"; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
  </tbody>
</table>
<br>
<?php }; ?>
<!-- END CLASSIFIEDS -->

<!-- CALENDAR -->
<?php if ($countDBMcCAL == '0'){ ?>
<div class="nav-section-header-cp">
        <strong><i class="fa fa-check" aria-hidden="true"></i> <?php print($countDBMcCAL); ?> Past Events</strong>
</div>
<br>
<?php }; ?>
<?php if ($countDBMcCAL >= '1'){ ?>
<div class="nav-section-header-cp">
        <strong>
<?php print($countDBMcCAL); ?> Past Events
        </strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
    <thead>
		<tr align="center">
			<th style="background-color:#eeeddd" valign="top" colspan="5">
			    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Expired calendar events are retained for 15-months.</span>
			    <div align="right">
	            <form name="CALENDARpurge" method="POST" action="databasemaintenance.php" onclick="return confirm('Are you sure you want to purge this data? This can NOT be undone!');">
	                <input type="hidden" name="action" value="CALENDARpurge">
	                <input name="submit" value="Purge Data" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
                </form>
                </div>
            </th>
		</tr>
        <tr align="left">
            <th><b>&nbsp;&nbsp;&nbsp; <small>Event</small></b></th>
            <th width="50" class="table-sortable:numeric">&nbsp;&nbsp;&nbsp; <small>ID</small></th>
            <th><b>&nbsp;&nbsp;&nbsp; <small>Date</small></b></th>
            <th><b>&nbsp;&nbsp;&nbsp; <small>Time</small></b></th>
            <th><b>&nbsp;&nbsp;&nbsp; <small>Event</small></b></th>
        </tr>
    </thead>
    <tbody style="background-color:#ffffff">
<!-- DATABASE RESULTS -->
<?php
    $query  = "SELECT * FROM `calendar` WHERE `date` < CURDATE() AND `date` NOT BETWEEN CURDATE() - INTERVAL 450 DAY AND SYSDATE() AND `date` != '0000-00-00';";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- DATABASE RESULTS -->
    <tr>
      <td>
        <div class="small-12 medium-12 large-10 columns" style="min-height:45px;">
          <b><?php echo "{$row['title']}"; ?></b><br>
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
		<div class="small-4 medium-4 large-2 columns">
            <form name="CalDup" method="POST" action="calendar-duplicate.php">
                <input type="hidden" name="action" value="duplicate">
                <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
                <input name="submit" value="Copy" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
            </form>
            <br>
		</div>
        <div class="small-4 medium-4 large-2 columns">
            <form name="CalEdit" method="POST" action="calendar-edit.php">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
                <input name="submit" value="Edit" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
            </form>
            <br>
		</div>
		<div class="small-4 medium-4 large-2 columns">
            <form name="CalDelete" method="POST" action="calendar.php" onclick="return confirm('Are you sure you want to delete <?php echo "{$row['title']}"; ?> on <?php echo "{$row['date']}"; ?>?');">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
                <input name="submit" value="Delete" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
            </form>
            <br>
		</div>
      </td>
      <td><?php echo "{$row['int1']}"; ?></td>
      <td><?php if ($row['date'] !== '0000-00-00'){ ?><?php echo "{$row['date']}"; ?><?php }; ?><?php if ($row['date'] == '0000-00-00'){ ?><i>ongoing</i><?php }; ?></td>
      <td><?php if ($row['stime'] !== '00:00:00'){ ?><?php echo date('g:i a', strtotime($row['stime'])); ?><?php }; ?><?php if ($row['etime'] !== '00:00:00'){ ?> - <?php echo date('g:i a', strtotime($row['etime'])); ?><?php }; ?></td>
      <td><?php echo "{$row['event']}"; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
  </tbody>
</table>
<br>
<?php }; ?>
<!-- END CALENDAR -->

<!-- MESSAGES -->
<?php if ($countDBMcMSG == '0'){ ?>
<div class="nav-section-header-cp">
        <strong><i class="fa fa-check" aria-hidden="true"></i> <?php print($countDBMcMSG); ?> Sent Messages</strong>
</div>
<br>
<?php }; ?>
<?php if ($countDBMcMSG >= '1'){ ?>
<div class="nav-section-header-cp">
    <strong><?php print($countDBMcMSG); ?> Sent Messages</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
    <thead>
		<tr align="center">
			<th style="background-color:#eeeddd" valign="top" colspan="6">
			    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Sent Messages retained for 15-months.</span>
			    <div align="right">
	            <form name="MESSAGESpurge" method="POST" action="databasemaintenance.php" onclick="return confirm('Are you sure you want to purge this data? This can NOT be undone!');">
	                <input type="hidden" name="action" value="MESSAGESpurge">
	                <input name="submit" value="Purge Data" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
                </form>
                </div>
            </th>
		</tr>
        <tr align="left">
            <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp;<b><small>Message</small></b></th>
	        <th width="50" class="table-sortable:numeric">&nbsp;&nbsp;&nbsp;<small>ID</small></th>
            <th class="table-sortable:datetime">&nbsp;&nbsp;&nbsp;<small>Sent On</small></th>
						<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Owner</small></b></div></th>
						<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Renter</small></b></div></th>
						<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Realtor</small></b></div></th>
        </tr>
    </thead>
    <tbody style="background-color:#ffffff">
<?php
	$query  = "SELECT subject, flag, message, owner, lease, realtor, date FROM messages WHERE `status` = 'S' AND `date` BETWEEN '0001-01-01' AND CURDATE() - INTERVAL 450 DAY ORDER BY `int1` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- DATABASE RESULTS -->
        <tr>
            <td>
<b><?php echo "{$row['subject']}"; ?></b>
<?php if ($row['message'] !== ''){ ?><blockquote><?php echo "{$row['message']}"; ?></blockquote><?php }; ?>
			</td>
			<td><?php echo "{$row['int1']}"; ?></td>
            <td><?php echo "{$row['date']}"; ?></td>
            <td align="center" <?php if ($row['owner'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['owner'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['owner']}"; ?></td>
            <td align="center" <?php if ($row['lease'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['lease'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['lease']}"; ?></td>
            <td align="center" <?php if ($row['realtor'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['realtor'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['realtor']}"; ?></td>
        </tr>
<!-- END DATABASE RESULTS -->
<?php
	}
?>
    </tbody>
</table>
<br>
<?php }; ?>
<!-- END MESSAGES -->

<!-- NEWSBOARD -->
<?php if ($countDBMcNEWS == '0'){ ?>
<div class="nav-section-header-cp">
        <strong><i class="fa fa-check" aria-hidden="true"></i> <?php print($countDBMcNEWS); ?> Past Newsboard Articles</strong>
</div>
<br>
<?php }; ?>
<?php if ($countDBMcNEWS >= '1'){ ?>
<div class="nav-section-header-cp">
        <strong><?php print($countDBMcNEWS); ?> Past Newsboard Articles</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
        <tr>
            <th colspan="7"><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Expired Newsboard Articles are retained for 15-months.</span>
                <div align="right">
	            <form name="NEWSBOARDpurge" method="POST" action="databasemaintenance.php" onclick="return confirm('Are you sure you want to purge this data? This can NOT be undone!');">
	                <input type="hidden" name="action" value="NEWSBOARDpurge">
	                <input name="submit" value="Purge Data" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
                </form>
                </div>
            </th>
        </tr>
    <tr align="left">
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp;<b><small>Message</small></b></th>
      <th width="50" class="table-sortable:numeric">&nbsp;&nbsp;&nbsp; <small>ID</small></th>
      <th class="table-sortable:date">&nbsp;&nbsp;&nbsp;<small>Post On</small></th>
      <th class="table-sortable:date">&nbsp;&nbsp;&nbsp;<small>Expiration</small></th>
			<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Owner</small></b></div></th>
			<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Renter</small></b></div></th>
			<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Realtor</small></b></div></th>
    </tr>
  </thead>
  <tbody style="background-color:#ffffff">
<?php
$query  = "SELECT `int1`, pod, eod, headline, message, url, email, potime, docid, docid2, docid3, pic, pic2, pic3, tabid, folderid, calid, owner, realtor, lease, flag FROM chalkboard WHERE eod < CURDATE() AND eod NOT BETWEEN CURDATE() - INTERVAL 450 DAY AND SYSDATE() ORDER BY pod DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- DATABASE RESULTS -->
    <tr>
      <td>
          <div class="small-12 medium-12 large-10 columns">
<?php if ($row['flag'] !== 'N'){ ?>
<div class="cp-ribbon ribbon__<?php echo "{$row['flag']}"; ?>" style="float: right;">
<?php if ($row['flag'] == 'U'){ ?>URGENT!<?php }; ?>
<?php if ($row['flag'] == 'D'){ ?>Updated!<?php }; ?>
<?php if ($row['flag'] == 'A'){ ?>ACTION!<?php }; ?>
<?php if ($row['flag'] == 'S'){ ?><i>Social Event</i><?php }; ?>
<?php if ($row['flag'] == 'H'){ ?>HOT Topic!<?php }; ?>
<?php if ($row['flag'] == 'G'){ ?>Great News!<?php }; ?>
<?php if ($row['flag'] == 'O'){ ?>Next Up:<?php }; ?>
<?php if ($row['flag'] == 'L'){ ?><i>for laughs!</i><?php }; ?>
</div>
<?php }; ?>
<div>
<b><?php echo "{$row['headline']}"; ?></b>
<?php if ($row['message'] !== ''){ ?><blockquote><?php echo "{$row['message']}"; ?></blockquote><?php }; ?>
<span class="note-black">
<?php if ($row['url'] !== ''){ ?>Web Links: <a href="<?php echo "{$row['url']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('External/<?php echo "{$row['url']}"; ?>'); "><?php echo "{$row['url']}"; ?></a><?php }; ?>
<?php if ($row['email'] !== ''){ ?>&nbsp;|&nbsp;<a href="mailto:<?php echo "{$row['email']}"; ?>" onclick="javascript:pageTracker._trackPageview('Email/<?php echo "{$row['email']}"; ?>'); "><?php echo "{$row['email']}"; ?></a><?php }; ?>
<?php if ($row['docid'] !== ''){ ?><br>
<?php
	$typeD1    = $row['docid'];
	$queryD1  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeD1'";
	$resultD1 = mysqli_query($conn,$queryD1);

	while($rowD1 = $resultD1->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Document ID <?php echo "{$rowD1['id']}"; ?>) <?php echo "{$rowD1['title']}"; ?> (<?php echo "{$rowD1['doctype']}"; ?>)
<?php
	}
?>
<?php }; ?>
<?php if ($row['docid2'] !== ''){ ?><br>
<?php
	$typeD2    = $row['docid2'];
	$queryD2  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeD2'";
	$resultD2 = mysqli_query($conn,$queryD2);

	while($rowD2 = $resultD2->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Document ID <?php echo "{$rowD2['id']}"; ?>) <?php echo "{$rowD2['title']}"; ?> (<?php echo "{$rowD2['doctype']}"; ?>)
<?php
	}
?>
<?php }; ?>
<?php if ($row['docid3'] !== ''){ ?><br>
<?php
	$typeD3    = $row['docid3'];
	$queryD3  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeD3'";
	$resultD3 = mysqli_query($conn,$queryD3);

	while($rowD3 = $resultD3->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Document ID <?php echo "{$rowD3['id']}"; ?>) <?php echo "{$rowD3['title']}"; ?> (<?php echo "{$rowD3['doctype']}"; ?>)
<?php
	}
?>
<?php }; ?>
<?php if ($row['pic'] !== ''){ ?><br>
<?php
	$typeP1    = $row['pic'];
	$queryP1  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeP1'";
	$resultP1 = mysqli_query($conn,$queryP1);

	while($rowP1 = $resultP1->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Photo ID <?php echo "{$rowP1['id']}"; ?>) <?php echo "{$rowP1['title']}"; ?> (<?php echo "{$rowP1['doctype']}"; ?>)
<?php
	}
?>
<?php }; ?>
<?php if ($row['pic2'] !== ''){ ?><br>
<?php
	$typeP2    = $row['pic2'];
	$queryP2  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeP2'";
	$resultP2 = mysqli_query($conn,$queryP2);

	while($rowP2 = $resultP2->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Photo ID <?php echo "{$rowP2['id']}"; ?>) <?php echo "{$rowP2['title']}"; ?> (<?php echo "{$rowP2['doctype']}"; ?>)
<?php
	}
?>
<?php }; ?>
<?php if ($row['pic3'] !== ''){ ?><br>
<?php
	$typeP3   = $row['pic3'];
	$queryP3  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeP3'";
	$resultP3 = mysqli_query($conn,$queryP3);

	while($rowP3 = $resultP3->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Photo ID <?php echo "{$rowP3['id']}"; ?>) <?php echo "{$rowP3['title']}"; ?> (<?php echo "{$rowP3['doctype']}"; ?>)
<?php
	}
?>
<?php }; ?>
<?php if ($row['calid'] !== ''){ ?><br>
<?php
	$typeCID    = $row['calid'];
	$queryCID  = "SELECT `int1`, title, event, date, stime FROM calendar WHERE `int1` = '$typeCID'";
	$resultCID = mysqli_query($conn,$queryCID);

	while($rowCID = $resultCID->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Calendar ID <?php echo "{$rowCID['int1']}"; ?>) <?php echo "{$rowCID['title']}"; ?> (<?php echo "{$rowCID['event']}"; ?>) <?php echo "{$row7['date']}"; ?> <?php echo "{$row7['stime']}"; ?>
<?php
	}
?>
<?php }; ?>
<?php if ($row['folderid'] !== ''){ ?><br>
<?php
	$typeFID    = $row['folderid'];
	$queryFID  = "SELECT `int1`, title FROM folders WHERE `int1` = '$typeFID'";
	$resultFID = mysqli_query($conn,$queryFID);

	while($rowFID = $resultFID->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Folder ID <?php echo "{$rowFID['int1']}"; ?>) <?php echo "{$rowFID['title']}"; ?>
<?php
	}
?>
<?php }; ?>
<?php if ($row['tabid'] !== ''){ ?><br>
<?php
	$typeTID    = $row['tabid'];
	$queryTID  = "SELECT `int1`, title FROM tabs WHERE `int1` = '$typeTID'";
	$resultTID = mysqli_query($conn,$queryTID);

	while($rowTID = $resultTID->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Module ID <?php echo "{$rowTID['int1']}"; ?>) <?php echo "{$rowTID['title']}"; ?>
<?php
	}
?>
<?php }; ?>
</span>
</div>
</div>
        </div>
        <div class="small-6 medium-6 large-2 columns" style="padding:10px">
            <form name="CBEdit" method="POST" action="chalkboard-edit.php">
              <input type="hidden" name="action" value="edit">
              <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
              <input name="submit" value="Edit" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
            </form>
        </div>
        <div class="small-6 medium-6 large-2 columns" style="padding:10px">
            <form name="CBDelete" method="POST" action="chalkboard.php" onclick="return confirm('Are you sure you want to delete the Newsboard entry: <?php echo "{$row['headline']}"; ?>?');">
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
              <input name="submit" value="Delete" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
            </form>
        </div>
      </td>
      <td><?php echo "{$row['int1']}"; ?></td>
      <td><?php echo "{$row['pod']}"; ?></td>
      <td><?php echo "{$row['eod']}"; ?></td>
      <td align="center" <?php if ($row['owner'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['owner'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['owner']}"; ?></td>
      <td align="center" <?php if ($row['lease'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['lease'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['lease']}"; ?></td>
      <td align="center" <?php if ($row['realtor'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['realtor'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['realtor']}"; ?></td>
    </tr>
<!-- END DATABASE RESULTS -->
<?php
	}
?>
  </tbody>
</table>
<br>
<?php }; ?>
<!-- END NEWSBOARD -->

<!-- RENTERS -->
<?php if ($countDBMcRENT == '0'){ ?>
<div class="nav-section-header-cp">
        <strong><i class="fa fa-check" aria-hidden="true"></i> <?php print($countDBMcRENT); ?> Renters Expired for More Than 60-Days</strong>
</div>
<br>
<?php }; ?>
<?php if ($countDBMcRENT >= '1'){ ?>
<div class="nav-section-header-cp">
        <strong><?php print($countDBMcRENT); ?> Renters Expired for More Than 60-Days</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
    <thead>
        <tr>
            <th colspan="10">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Users whos Access Through Date has passed more than 60-days.</span>
                <div align="right">
	            <form name="RENTERpurge" method="POST" action="databasemaintenance.php" onclick="return confirm('Are you sure you want to purge this data? This can NOT be undone!');">
	                <input type="hidden" name="action" value="RENTERpurge">
	                <input name="submit" value="Purge Data" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
                </form>
                </div>
            </th>
        </tr>
        <tr align="left">
            <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>User</small></th>
            <th width="50" class="table-sortable:numeric"><small>&nbsp;&nbsp;&nbsp; ID</small></th>
            <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Unit</small></th>
<?php if ($countU2 != '0'){ ?>
            <th class="table-sortable:alphanumeric table-filterable">&nbsp;</th>
<?php }; ?>
						<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Owner</small></b></div></th>
						<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Renter</small></b></div></th>
						<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Realtor</small></b></div></th>
						<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Board</small></b></div></th>
						<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Staff</small></b></div></th>
						<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Admin</small></b></div></th>
        </tr>
    </thead>
    <tbody>
<?php
	$query  = "SELECT `id`, unit, unit2, last_name, first_name, email, phone, useripaddress, owner, lease, realtor, board, concierge, liaison, account, comments, status, created_date, directory, dphone, hide, accessdate, ghost, flex1, flex2, flex3, flex4, flex5, packagepreference, authcode FROM users WHERE `accessdate` NOT BETWEEN CURDATE( ) - INTERVAL 60 DAY AND SYSDATE( ) AND `accessdate` <= CURDATE( ) AND `accessdate` != '0000-00-00' AND `status` = 'active' ORDER BY `id` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- DATABASE RESULTS -->
        <tr>
            <td>
                <div class="small-12 medium-12 large-8 columns">
                <b><?php echo "{$row['last_name']}"; ?>, <?php echo "{$row['first_name']}"; ?></b>
<!-- COMMENTS -->
                <?php if ($row['comments'] != ''){ ?><i class="fa fa-comment" aria-hidden="true" align="right" title="<?php echo "{$row['comments']}"; ?>"></i><?php }; ?>
<!-- END COMMENTS -->
<!-- PETS -->
<?php
	$type   = $row['id'];
	$query2  = "SELECT userid FROM pets WHERE userid = '$type' LIMIT 1";
	$result2 = mysqli_query($conn,$query2);

	while($row2 = $result2->fetch_array(MYSQLI_ASSOC))
	{
?>
                <i class="fa fa-paw" aria-hidden="true" align="right" title="This user has pets registered."></i>
<?php
	}
?>
<!-- END PETS -->
<!-- VEHICLES -->
<?php
	$type   = $row['id'];
	$query2  = "SELECT userid FROM vehicles WHERE userid = '$type' AND MODEL != 'B*' LIMIT 1";
	$result2 = mysqli_query($conn,$query2);

	while($row2 = $result2->fetch_array(MYSQLI_ASSOC))
	{
?>
                <i class="fa fa-car" aria-hidden="true" align="right" title="This user has vehicles/bicycle registered."></i>
<?php
	}
?>
<!-- END VEHICLES -->
<!-- BICYCLES -->
<?php
	$type   = $row['id'];
	$query2  = "SELECT userid FROM vehicles WHERE userid = '$type' AND MODEL = 'B*' LIMIT 1";
	$result2 = mysqli_query($conn,$query2);

	while($row2 = $result2->fetch_array(MYSQLI_ASSOC))
	{
?>
                <i class="fa fa-bicycle" aria-hidden="true" align="right" title="This user has vehicles/bicycle registered."></i>
<?php
	}
?>
<!-- END BICYCLES -->
                <span class="note-black"><br>Created <?php echo "{$row['created_date']}"; ?><?php if ($row['account'] !== ''){ ?><br>Acct &#35;<?php echo "{$row['account']}"; ?><?php }; ?></span>
                <br><a href="<?php echo "{$row['email']}"; ?>"><?php echo "{$row['email']}"; ?></a>
                <br><?php echo "{$row['phone']}"; ?>
                <?php if ($row['accessdate'] != '0000-00-00'){ ?><br><span class="note-black">Lease/Access Through Date <?php echo "{$row['accessdate']}"; ?></span><?php }; ?>
                </div>
                <div class="small-6 medium-6 large-2 columns">
                    <form name="passDisable" method="POST" action="passwords.php" onclick="return confirm('Are you sure you want to disable the user, <?php echo "{$row['first_name']}"; ?> <?php echo "{$row['last_name']}"; ?>?  Be sure to delete any registered vehicles or pets too.');">
                        <input type="hidden" name="action" value="passDisable">
                        <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
                        <input type="hidden" name="status" value="disabled">
                        <input name="submit" value="Disable" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
                    </form>
                </div>
                <div class="small-6 medium-6 large-2 columns">
                    <form name="TabEdit" method="POST" action="passwords-edit.php">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
                        <input name="submit" value="Edit" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
                    </form>
                </div>
            </td>
            <td><?php echo "{$row['id']}"; ?></td>
            <td><?php echo "{$row['unit']}"; ?></td>
<?php if ($countU2 != '0'){ ?>
            <td><?php echo "{$row['unit2']}"; ?></td>
<?php }; ?>
            <?php if ($row['owner'] !== '1'){ ?><td align="center" bgcolor="#ffcccc">N</td><?php }; ?><?php if ($row['owner'] !== '0'){ ?><td align="center" bgcolor="#ccffcc">Y</td><?php }; ?>
            <?php if ($row['lease'] !== '1'){ ?><td align="center" bgcolor="#ffcccc">N</td><?php }; ?><?php if ($row['lease'] !== '0'){ ?><td align="center" bgcolor="#ccffcc">Y</td><?php }; ?>
            <?php if ($row['realtor'] !== '1'){ ?><td align="center" bgcolor="#ffcccc">N</td><?php }; ?><?php if ($row['realtor'] !== '0'){ ?><td align="center" bgcolor="#ccffcc">Y</td><?php }; ?>
            <?php if ($row['board'] !== '1'){ ?><td align="center" bgcolor="#f4d6a3">N</td><?php }; ?><?php if ($row['board'] !== '0'){ ?><td align="center" bgcolor="#ccffcc">Y</td><?php }; ?>
            <?php if ($row['concierge'] !== '1'){ ?><td align="center" bgcolor="#f4d6a3">N</td><?php }; ?><?php if ($row['concierge'] !== '0'){ ?><td align="center" bgcolor="#ccffcc">Y</td><?php }; ?>
            <?php if ($row['liaison'] !== '1'){ ?><td align="center" bgcolor="#f4d6a3">N</td><?php }; ?><?php if ($row['liaison'] !== '0'){ ?><td align="center" bgcolor="#ccffcc">Y</td><?php }; ?>
        </tr>
<!-- END DATABASE RESULTS -->
<?php
	}
?>
    </tbody>
</table>
<br>
<?php }; ?>
<!-- END RENTERS -->

<!-- DISABLED USERS -->
<?php $sqlU2 = mysqli_query($conn,"SELECT count(*) FROM users WHERE unit2 != 'X'") or die(mysqli_error($conn));
//$countU2 = mysql_result($sqlU2, "0");
$row = mysqli_fetch_row($sqlU2);
$countU2 = $row[0];
?>

<?php if ($countDBMcDISU == '0'){ ?>
<div class="nav-section-header-cp">
        <strong><i class="fa fa-check" aria-hidden="true"></i> <?php print($countDBMcDISU); ?> Disabled Users for Over 1-Year</strong>
</div>
<br>
<?php }; ?>
<?php if ($countDBMcDISU >= '1'){ ?>
<div class="nav-section-header-cp">
        <strong><?php print($countDBMcDISU); ?> Disabled Users for Over 1-Year</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
    <thead>
        <tr>
            <th colspan="10">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Users who have been disabled for longer than 1-year.</span>
                <div align="right">
	            <form name="DISABLEDpurge" method="POST" action="databasemaintenance.php" onclick="return confirm('Are you sure you want to purge this data? This can NOT be undone!');">
	                <input type="hidden" name="action" value="DISABLEDpurge">
	                <input name="submit" value="Purge Data" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
                </form>
                </div>
            </th>
        </tr>
        <tr align="left">
            <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>User</small></th>
            <th width="50" class="table-sortable:numeric"><small>&nbsp;&nbsp;&nbsp; ID</small></th>
            <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Unit</small></th>
<?php if ($countU2 != '0'){ ?>
            <th class="table-sortable:alphanumeric table-filterable">&nbsp;</th>
<?php }; ?>
						<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Owner</small></b></div></th>
						<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Renter</small></b></div></th>
						<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Realtor</small></b></div></th>
						<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Board</small></b></div></th>
						<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Staff</small></b></div></th>
						<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Admin</small></b></div></th>
        </tr>
    </thead>
    <tbody>
<?php
	$query  = "SELECT `id`, password, unit, unit2, last_name, first_name, email, phone, useripaddress, owner, lease, realtor, board, concierge, liaison, account, comments, status, created_date, directory, dphone, hide, accessdate, ghost, flex1, flex2, flex3, flex4, flex5, packagepreference, authcode FROM users WHERE `accessdate` NOT BETWEEN CURDATE() - INTERVAL 365 DAY AND SYSDATE() AND `accessdate` <= CURDATE() AND `accessdate` != '0000-00-00' AND `status` = 'disabled' ORDER BY `id` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- DATABASE RESULTS -->
        <tr>
            <td>
                <div class="small-12 medium-12 large-8 columns">
                <b><?php echo "{$row['last_name']}"; ?>, <?php echo "{$row['first_name']}"; ?></b>
<!-- COMMENTS -->
                <?php if ($row['comments'] != ''){ ?><i class="fa fa-comment" aria-hidden="true" align="right" title="<?php echo "{$row['comments']}"; ?>"></i><?php }; ?>
<!-- END COMMENTS -->
<!-- PETS -->
<?php
	$type   = $row['id'];
	$query2  = "SELECT userid FROM pets WHERE userid = '$type' LIMIT 1";
	$result2 = mysqli_query($conn,$query2);

	while($row2 = $result2->fetch_array(MYSQLI_ASSOC))
	{
?>
                <i class="fa fa-paw" aria-hidden="true" align="right" title="This user has pets registered."></i>
<?php
	}
?>
<!-- END PETS -->
<!-- VEHICLES -->
<?php
	$type   = $row['id'];
	$query2  = "SELECT userid FROM vehicles WHERE userid = '$type' AND MODEL != 'B*' LIMIT 1";
	$result2 = mysqli_query($conn,$query2);

	while($row2 = $result2->fetch_array(MYSQLI_ASSOC))
	{
?>
                <i class="fa fa-car" aria-hidden="true" align="right" title="This user has vehicles/bicycle registered."></i>
<?php
	}
?>
<!-- END VEHICLES -->
<!-- BICYCLES -->
<?php
	$type   = $row['id'];
	$query2  = "SELECT userid FROM vehicles WHERE userid = '$type' AND MODEL = 'B*' LIMIT 1";
	$result2 = mysqli_query($conn,$query2);

	while($row2 = $result2->fetch_array(MYSQLI_ASSOC))
	{
?>
                <i class="fa fa-bicycle" aria-hidden="true" align="right" title="This user has vehicles/bicycle registered."></i>
<?php
	}
?>
<!-- END BICYCLES -->
                <span class="note-black"><br>Created <?php echo "{$row['created_date']}"; ?><?php if ($row['account'] !== ''){ ?><br>Acct &#35;<?php echo "{$row['account']}"; ?><?php }; ?></span>
                <br><a href="<?php echo "{$row['email']}"; ?>"><?php echo "{$row['email']}"; ?></a>
                <br><?php echo "{$row['phone']}"; ?>
                <?php if ($row['accessdate'] != '0000-00-00'){ ?><br><span class="note-black">Lease/Access Through Date <?php echo "{$row['accessdate']}"; ?></span><?php }; ?>
                </div>
                <div class="small-6 medium-6 large-2 columns">
                    <form name="passDisable" method="POST" action="passwords.php" onclick="return confirm('Are you sure you want to disable the user, <?php echo "{$row['first_name']}"; ?> <?php echo "{$row['last_name']}"; ?>?  Be sure to delete any registered vehicles or pets too.');">
                        <input type="hidden" name="action" value="passDisable">
                        <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
                        <input type="hidden" name="status" value="disabled">
                        <input name="submit" value="Disable" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
                    </form>
                </div>
                <div class="small-6 medium-6 large-2 columns">
                    <form name="TabEdit" method="POST" action="passwords-edit.php">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
                        <input name="submit" value="Edit" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
                    </form>
                </div>
            </td>
            <td><?php echo "{$row['id']}"; ?></td>
            <td><?php echo "{$row['unit']}"; ?></td>
<?php if ($countU2 != '0'){ ?>
            <td><?php echo "{$row['unit2']}"; ?></td>
<?php }; ?>
            <?php if ($row['owner'] !== '1'){ ?><td align="center" bgcolor="#ffcccc">N</td><?php }; ?><?php if ($row['owner'] !== '0'){ ?><td align="center" bgcolor="#ccffcc">Y</td><?php }; ?>
            <?php if ($row['lease'] !== '1'){ ?><td align="center" bgcolor="#ffcccc">N</td><?php }; ?><?php if ($row['lease'] !== '0'){ ?><td align="center" bgcolor="#ccffcc">Y</td><?php }; ?>
            <?php if ($row['realtor'] !== '1'){ ?><td align="center" bgcolor="#ffcccc">N</td><?php }; ?><?php if ($row['realtor'] !== '0'){ ?><td align="center" bgcolor="#ccffcc">Y</td><?php }; ?>
            <?php if ($row['board'] !== '1'){ ?><td align="center" bgcolor="#f4d6a3">N</td><?php }; ?><?php if ($row['board'] !== '0'){ ?><td align="center" bgcolor="#ccffcc">Y</td><?php }; ?>
            <?php if ($row['concierge'] !== '1'){ ?><td align="center" bgcolor="#f4d6a3">N</td><?php }; ?><?php if ($row['concierge'] !== '0'){ ?><td align="center" bgcolor="#ccffcc">Y</td><?php }; ?>
            <?php if ($row['liaison'] !== '1'){ ?><td align="center" bgcolor="#f4d6a3">N</td><?php }; ?><?php if ($row['liaison'] !== '0'){ ?><td align="center" bgcolor="#ccffcc">Y</td><?php }; ?>
        </tr>
<!-- END DATABASE RESULTS -->
<?php
	}
?>
    </tbody>
</table>
<br>
<?php }; ?>
<!-- END DISABLED USERS -->

<!-- PETS -->
<?php if ($countDBMcPETS == '0'){ ?>
<div class="nav-section-header-cp">
        <strong><i class="fa fa-check" aria-hidden="true"></i> <?php print($countDBMcPETS); ?> Pets Not Linked to a User</strong>
</div>
<br>
<?php }; ?>
<?php if ($countDBMcPETS >= '1'){ ?>
<div class="nav-section-header-cp">
        <strong><?php print($countDBMcPETS); ?> Pets Not Linked to a User</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
        <tr>
            <th colspan="10">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Pets that are not linked to a user. This can include pets that were not deleted when the user was disabled.</span>
	            <div align="right">
	            <form name="PETSpurge" method="POST" action="databasemaintenance.php" onclick="return confirm('Are you sure you want to purge this data? This can NOT be undone!');">
	                <input type="hidden" name="action" value="PETSpurge">
	                <input name="submit" value="Purge Data" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
                </form>
                </div>
            </th>
        </tr>
        <tr align="left">
			<th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Pet</small></th>
			<th>&nbsp;&nbsp;&nbsp; <small>Photo</small></th>
			<th class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <small>Species</small></th>
			<th class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <small>Lost</small></th>
        </tr>
  </thead>
  <tbody style="background-color:#ffffff">
<?php
	$query  = "SELECT * FROM `pets` WHERE `userid` NOT IN (SELECT `id` FROM `users`) AND `userid` != '0'";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>

<!-- DATABASE RESULTS -->
    <tr>
		<td>
			<div class="small-12 medium-12 large-8 columns">
<b>&quot;<?php echo "{$row['petname']}"; ?>&quot;</b>
<br><?php echo "{$row['comments']}"; ?>
			</div>
			<div class="small-6 medium-6 large-2 columns">
				    <form name="PetsEdit" method="POST" action="pets-edit.php">
				    <input type="hidden" name="action" value="edit">
				    <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
			    	<input name="submit" value="Edit" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
				</form>
            </div>
            <div class="small-6 medium-6 large-2 columns">
				<form method="POST" action="pets.php" onclick="return confirm('Are you sure you want to delete this <?php echo "{$row['species']}"; ?>?');">
					<input type="hidden" name="action" value="delete">
					<input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
					<input name="submit" value="Delete" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
				</form>
            </div>
        </td>
		<td align="center" style="background-color:#ffffff">
<div style="max-width: 100px;">
	<a href="../download-pets.php?id=<?php echo "{$row['id']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('PETPHOTO/<?php echo "{$row['id']}"; ?>'); "><img src="../download-pets.php?id=<?php echo "{$row['id']}"; ?>"></a>
</div>
		</td>
		<td><?php echo "{$row['species']}"; ?></td>
        <td align="center"><?php echo "{$row['lost']}"; ?></td>
    </tr>
<!-- END DATABASE RESULTS -->
<?php
	}
?>
  </tbody>
</table>
<!-- END PETS -->
</div>
<?php }; ?>

<!-- PETS -->
<?php if ($countDBMcCARS == '0'){ ?>
<div class="nav-section-header-cp">
        <strong><i class="fa fa-check" aria-hidden="true"></i> <?php print($countDBMcCARS); ?> Vehicles Not Linked to a User</strong>
</div>
<br>
<?php }; ?>
<?php if ($countDBMcCARS >= '1'){ ?>
<div class="nav-section-header-cp">
        <strong><?php print($countDBMcCARS); ?> Vehicles Not Linked to a User</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
        <tr>
            <th colspan="10">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Vehicles that are not linked to a user. This can include vehicles that were not deleted when the user was disabled.</span>
	            <div align="right">
	            <form name="CARSSpurge" method="POST" action="databasemaintenance.php" onclick="return confirm('Are you sure you want to purge this data? This can NOT be undone!');">
	                <input type="hidden" name="action" value="CARSpurge">
	                <input name="submit" value="Purge Data" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
                </form>
                </div>
            </th>
        </tr>
    <tr align="left">
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Record</small></th>
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Space</small></th>
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>License</small></th>
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Permit</small></th>
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Make</small></th>
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Color</small></th>
    </tr>
  </thead>
  <tbody style="background-color:#ffffff">
<?php
	$query  = "SELECT * FROM `vehicles` WHERE `userid` NOT IN (SELECT `id` FROM `users`) AND `userid` != '0'";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>

<!-- DATABASE RESULTS -->
    <tr>
      <td>
        <div class="small-12 medium-12 large-8 columns">
<?php if ($row['comments'] !== ''){ ?><span class="note-black"><?php if ($row['userid'] !== '0'){ ?><br><br><?php }; ?><?php echo "{$row['comments']}"; ?></span><?php }; ?>
        </div>
        <div class="small-6 medium-6 large-2 columns">
        	<form name="VehicleEdit" method="POST" action="vehicles-edit.php">
	            <input type="hidden" name="action" value="edit">
            	<input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
	            <input name="submit" value="Edit" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
        	</form>
        </div>
        <div class="small-6 medium-6 large-2 columns">
	        <form name="VehicleDelete" method="POST" action="vehicles.php" onclick="return confirm('Are you sure you want to delete this <?php echo "{$row['make']}"; ?>?');">
	            <input type="hidden" name="action" value="delete">
	            <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
	            <input name="submit" value="Delete" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
	        </form>
        </div>
      </td>
      <td><?php echo "{$row['space']}"; ?></td>
      <td><?php echo "{$row['state']}"; ?> <span style="text-transform: uppercase"><?php echo "{$row['license']}"; ?></span></td>
      <td><span style="text-transform: uppercase"><?php echo "{$row['permit']}"; ?></span></td>
      <td><?php echo "{$row['make']}"; ?></td>
      <td><?php echo "{$row['color']}"; ?></td>
    </tr>
<!-- END DATABASE RESULTS -->
<?php
	}
?>
  </tbody>
</table>
<!-- END VEHICLES -->
</div>
<?php }; ?>

<!-- LOG -->
<?php if ($countDBMcLOG == '0'){ ?>
<div class="nav-section-header-cp">
        <strong><i class="fa fa-check" aria-hidden="true"></i> <?php print($countDBMcLOG); ?> Change Logs</strong>
</div>
<br>
<?php }; ?>
<?php if ($countDBMcLOG >= '1'){ ?>
<div class="nav-section-header-cp">
        <strong><?php print($countDBMcLOG); ?> Change Logs</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
        <tr>
            <th colspan="10">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Log files over 1-year old.</span>
	            <div align="right">
	            <form name="LOGpurge" method="POST" action="databasemaintenance.php" onclick="return confirm('Are you sure you want to purge this data? This can NOT be undone!');">
	                <input type="hidden" name="action" value="LOGpurge">
	                <input name="submit" value="Purge Data" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
                </form>
                </div>
            </th>
        </tr>
    <tr align="left">
      <th align="left" class="table-sortable:numeric">&nbsp;&nbsp;&nbsp; <b><small>ID</small></b></th>
      <th align="left" class="table-sortable:datetime">&nbsp;&nbsp;&nbsp; <b><small>Timestamp</small></b></th>
      <th align="left" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <b><small>Action</small></b></th>
      <th align="left" class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <b><small>Module</small></b></th>
      <th align="left" class="table-sortable:numeric table-filterable">&nbsp;&nbsp;&nbsp; <b><small>Module ID</small></b></th>
      <th align="left" class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <b><small>User</small></b></th>
      <th align="left" class="table-sortable:numeric table-filterable">&nbsp;&nbsp;&nbsp; <b><small>User IP</small></b></th>
    </tr>
  </thead>
  <tbody style="background-color:#ffffff">
<?php
	$query  = "SELECT `init1`, `created_date`, `action`, `tablename`, `id`, `userid`, `useripaddress` FROM `log` WHERE `created_date` NOT BETWEEN CURDATE() - INTERVAL 450 DAY AND SYSDATE() ORDER BY `init1` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
    <tr>
      <td><?php echo "{$row['init1']}"; ?></td>
      <td><?php echo "{$row['created_date']}"; ?></td>
      <td>
	<?php if ($row['action'] == 'A'){ ?>Advanced<?php }; ?>
	<?php if ($row['action'] == 'D'){ ?>Delete<?php }; ?>
	<?php if ($row['action'] == 'E'){ ?>Edit<?php }; ?>
      </td>
      <td><?php echo "{$row['tablename']}"; ?></td>
      <td><?php echo "{$row['id']}"; ?></td>
      <td>
<?php
	$type    = $row['userid'];
	$query1  = "SELECT * FROM users WHERE id = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?>
<?php echo "{$row1['last_name']}"; ?>, <?php echo "{$row1['first_name']}"; ?>
<?php
	}
?>
(<?php echo "{$row['userid']}"; ?>)
      </td>
      <td><?php echo "{$row['useripaddress']}"; ?></td>
    </tr>
<?php
	}
?>
  </tbody>
</table>
<?php }; ?>
<!-- END LOG -->

<div class="small-12 medium-12 large-12 columns note-black"><br><br>Database Maintenance Control Panel Page<br></div>
</body>
</html>
