<?php $current_page = '11'; include('protect.php'); ?>
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
<?php
$id = $_POST["id"];
$action = $_POST["action"];
$success = "untried";
$email = $_POST['email'];
$messagebody = $_POST['messagebody'];
$reseturl = $_POST['reseturl'];
$useripaddress = $_SERVER['REMOTE_ADDR'];
$currentdate = date('Y-m-d');
if ($action != null) { ?>
<?php

	if ($action == "purge"){
		$query = "DELETE FROM `users` WHERE `id`='$id'";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

        	$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>User purged successfully.</strong></div>";

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('D', 'Passwords', '$useripaddress', '$userid', 'Purge User')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
	}

	if ($action == "SPAMpurge"){
		$query = "DELETE FROM users WHERE `phone`='123456'";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

        	$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>SPAM users deleted successfully.</strong></div>";

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('D', 'Passwords', '$useripaddress', '$userid', 'SPAM Purge')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
	}

	if ($action == "passDisable"){
		$query = "UPDATE users SET `accessdate`='$currentdate', status='disabled' WHERE `id`='$id'";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

        	$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>User disabled successfully.</strong></div>";

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('D', 'Passwords', '$useripaddress', '$userid', '$id')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
	}

	if ($action == "SubjecttoApproval"){
		$query = "ALTER TABLE `users` CHANGE `status` `status` VARCHAR( 30 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'new' COMMENT 'account status (new, active, suspended)'";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

		$query = "UPDATE `3rd` SET `theircode` = '<br>Use this form to request access to the website.<br><br><b>You will have access to the website once it is approved by a website administrator.</b><br><br>', `extra1` = '<br><br>Your new account request has been submitted.<br><br>You will receive an email once your request has been approved by a website administrator.<br><br>', `iframe` = 'Subject' WHERE `3rd`.`int1` =20;";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

			$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>User access is now subject to approval.</strong></div>";

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('U', 'User', '$useripaddress', '$userid', 'Subject')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
	}

	if ($action == "OpenEnrollment"){
		$query = "ALTER TABLE `users` CHANGE `status` `status` VARCHAR( 30 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'active' COMMENT 'account status (new, active, suspended)'";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

		$query = "UPDATE `3rd` SET `theircode` = '<br>Use this form to request access to the website.<br><br><b>You will have immediate access to the website,<br>but your account is subject to audit by a website administrator.</b><br><br>', `extra1` = '<br><br>Your new account request has been approved.<br><br>You may now close this window and login to the site<br>using your email address and selected password.<br><br>', `iframe` = 'Open' WHERE `3rd`.`int1` =20;";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

			$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Users access is now immediate.</strong></div>";

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('U', 'User', '$useripaddress', '$userid', 'Open')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
	}

}
?>
<!-- HEALTH AND HELP -->
<div>
    <div class="large-6 columns" style="padding: 0px">
        <div class="nav-section-header-health-cp" align="center">
<big><i class="fa fa-stethoscope" aria-hidden="true"></i></big><strong>&nbsp;Health&nbsp;&nbsp;&nbsp;</strong>
<?php $sqlUSR = mysqli_query($conn,"SELECT count(*) FROM users WHERE (webmaster = '0' AND status != 'disabled' AND (email = '' OR (owner = '0' AND lease = '0' AND realtor = '0') OR (accessdate >= '0000-00-01' AND accessdate <= current_date())) OR (status = 'New') AND ghost != 'Y')") or die(mysqli_error($conn));
$row = mysqli_fetch_row($sqlUSR);
$countUSR = $row[0];
?>
<?php if ($countUSR != '0'){ ?><i class="fa fa-exclamation-triangle note" aria-hidden="true"></i> You have <?php print($countUSR); ?> users who need your help to get access!<?php }; ?>
<?php if ($countUSR == '0'){ ?><i class="fa fa-check" aria-hidden="true"></i> All of your users have access!<?php }; ?>
        </div>
    </div>
    <div class="large-3 columns" style="padding: 0px">
        <div class="nav-section-header-help-video-cp" align="center">
            <strong><big><a href="http://condosites.net/help/useraccounts.php" target="_blank"><i class="fa fa-youtube-play" aria-hidden="true"></i></big>&nbsp;Help&nbsp;video</a></strong>
        </div>
    </div>
    <div class="large-3 columns" style="padding: 0px">
        <div class="nav-section-header-help-cp" align="center">
            <strong><big><i class="fa fa-hand-o-right" aria-hidden="true"></i></big>&nbsp;Hands&nbsp;point&nbsp;to&nbsp;tips!</strong>
        </div>
    </div>
</div>
<!-- HEALTH AND HELP -->
<br>&nbsp;

<div class="row cp-help">
    <div class="small-12 medium-6 columns">
        <p>The <b>User Accounts</b> control panel is where you control user access to the website, and where administrators can make edits to user accounts.</p>
    </div>
    <div class="small-12 medium-6 columns">
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#modulepermissions"><b>Module Permissions</b></a> allow you to choose whether Owners and/or Renters will have access to a resident directory of users.</p>
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#users"><b>View and Edit</b></a> your NEW and ACTIVE users in the database.</p>
<?php $sqlUSR = mysqli_query($conn,"SELECT count(*) FROM users WHERE `status` = 'disabled'");
$row = mysqli_fetch_row($sqlUSR);
$countUSR = $row[0];
?>
<?php if ($countUSR != '0'){ ?>
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#disabledusers"><b>View and Edit</b></a> your DISABLED users in the database.</p>
<?php }; ?>
<?php
	$query  = "SELECT `id` FROM utilities WHERE `category` = 'Password' ORDER BY company LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#passwordhelp"><b>View and Edit</b></a> your Login Help contact in your community.</p>
<?php
	}
?>
    </div>
</div>

<?php echo($errorSUCCESS); ?>

<?php $sqlU2 = mysqli_query($conn,"SELECT count(*) FROM users WHERE unit2 != 'X'") or die(mysqli_error($conn));
$row = mysqli_fetch_row($sqlU2);
$countU2 = $row[0];
?>
<div style="max-width: 99%;">
<!-- MODULE PERMISSIONS -->
<a name="modulepermissions"></a>
<div class="nav-section-header-cp">
    <strong>Module Permissions</strong>
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
	$module = "passwords.php";
	$query  = "SELECT * FROM tabs WHERE liaison = 'Y' AND `int1` BETWEEN '225' AND '225' ORDER BY `int1`";
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
    <tfoot>
        <tr>
            <td colspan="9" align="left">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Be sure to check your state&apos;s Condominium Act/Statutes before enabling this module.</span>
            </td>
        </tr>
    </tfoot>
</table>
<a name="search"></a>
<br>
<!-- SEARCH -->
<div class="nav-section-header-cp">
    <strong>Search Users</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
    <thead>
<?php
$sqlSTA = mysqli_query($conn,"SELECT count(*) FROM `users`");
$row = mysqli_fetch_row($sqlSTA);
$countSTA = $row[0];
?>
<?php if ($countSTA <= '2'){ ?>
        <tr>
            <th colspan="100">
                <div class="small-12 medium-6 columns">
<?php
$sqlACCESS = mysqli_query($conn,"SELECT count(*) FROM 3rd WHERE `iframe` = 'Open'");
$row = mysqli_fetch_row($sqlACCESS);
$countACCESS = $row[0];
?>
<?php if ($countACCESS == '1'){ ?>
        <form name="SubjecttoApproval" method="POST" action="passwords.php" onclick="return confirm('Are you sure you want to make ALL NEW USER ACCESS SUBJECT TO ADMINISTRATOR APPROVAL?');">
            <input type="hidden" name="action" value="SubjecttoApproval">
            <input name="submit" value="Switch to Subject to Approval" class="submit" type="submit">
        </form>
        <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Currently, new users are immediately approved.</span>
<?php }; ?>
<?php $sqlACCESS = mysqli_query($conn,"SELECT count(*) FROM 3rd WHERE `iframe` = 'Subject'");
$row = mysqli_fetch_row($sqlACCESS);
$countACCESS = $row[0];
?>
<?php if ($countACCESS == '1'){ ?>
        <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">New users are currently subject to administrator approval.</span>
        <form name="OpenEnrollment" method="POST" action="passwords.php" onclick="return confirm('Are you sure you want to give ALL NEW USERS IMMEDIATE ACCESS to the website?');">
            <input type="hidden" name="action" value="OpenEnrollment">
            <input name="submit" value="Switch to Open Enrollment" class="submit" type="submit">
        </form>
<?php }; ?>
                </div>
            </th>
        </tr>
<?php }; ?>
        <tr>
            <th>
<div style="padding-top: 15px;">
<form enctype="multipart/form-data" method="POST" action="passwords.php#search">
    <div class="small-12 medium-12 large-5 columns">
        <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Search fields only search for users by name.</span>
    </div>
    <div class="small-12 medium-4 large-2 columns"><label for="search" class="middle">User&apos;s&nbsp;Last&nbsp;and/or&nbsp;First&nbsp;Name </label></div>
    <div class="small-6 medium-3 large-2 columns">
        <input name="searchlast" maxlength="100" class="form" type="text" placeholder="Last Name">
    </div>
    <div class="small-6 medium-3 large-2 columns">
        <input name="searchfirst" maxlength="100" class="form" type="text" placeholder="First Name">
    </div>
    <div class="small-12 medium-2 large-1 columns">
        <input type="hidden" name="action" value="track">
        <input name="submit" value="Search" class="submit" type="submit" onclick="value='Processing Request - Search'; style='color:red';" />
<a name="users"></a>
    </div>
</form>
</div>
            </th>
        </tr>
    </thead>
</table>
<!-- END SEARCH -->
<!-- SPAM -->
<?php
    $lastget = $_POST['searchlast'];
    $searchlastget = ''; if ($_POST['searchlast'] != '') {$searchlastget = "`last_name` LIKE '%$lastget%' AND";}
    $firstget = $_POST['searchfirst'];
    $searchfirstget = ''; if ($_POST['searchfirst'] != '') {$searchfirstget = "`first_name` LIKE '%$firstget%' AND";}
	$query  = "SELECT `id` FROM users WHERE $searchlastget $searchfirstget webmaster = '0' AND phone = '123456' AND ghost != 'Y' ORDER BY `id` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<br>
<div class="nav-section-header-cp" style="background-color:#ffa800">
        <strong>
<?php
$lastget = $_POST['searchlast'];
$searchlastget = ''; if ($_POST['searchlast'] != '') {$searchlastget = "`last_name` LIKE '%$lastget%' AND";}
$firstget = $_POST['searchfirst'];
$searchfirstget = ''; if ($_POST['searchfirst'] != '') {$searchfirstget = "`first_name` LIKE '%$firstget%' AND";}
$sql = mysqli_query($conn,"SELECT count(*) FROM users WHERE $searchlastget $searchfirstget webmaster = '0' AND phone = '123456'") or die(mysqli_error($conn));
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Potential SPAM Accounts</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
    <thead>
        <tr>
            <th colspan="100">
    <div style="float: right;">
<?php
$lastget = $_POST['searchlast'];
$searchlastget = ''; if ($_POST['searchlast'] != '') {$searchlastget = "`last_name` LIKE '%$lastget%' AND";}
$firstget = $_POST['searchfirst'];
$searchfirstget = ''; if ($_POST['searchfirst'] != '') {$searchfirstget = "`first_name` LIKE '%$firstget%' AND";}
$sqlUSR = mysqli_query($conn,"SELECT count(*) FROM users WHERE $searchlastget $searchfirstget `phone`='123456'");
$row = mysqli_fetch_row($sqlUSA);
$countUSA = $row[0];
?>
<?php if ($countUSR != '0'){ ?>
	            <form name="SPAMpurge" method="POST" action="passwords.php" onclick="return confirm('Are you sure you want to purge all of the accounts listed above? This can NOT be undone!');">
	                <input type="hidden" name="action" value="SPAMpurge">
	                <input type="hidden" name="status" value="disabled">
	                <input name="submit" value="Purge SPAM Accounts" class="submit" type="submit">
                </form>
<?php }; ?>
    </div>
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> Carefully review the list below of potential SPAM accounts. Edit to correct any legitimate accounts. Lastly click the "Purge SPAM Accounts" button.
            </th>
        </tr>
        <tr align="left">
            <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>User</small></th>
            <th width="50" class="table-sortable:numeric"><small>&nbsp;&nbsp;&nbsp; ID</small></th>
<?php $sqlU1 = mysqli_query($conn,"SELECT count(*) FROM users WHERE `unit` NOT BETWEEN '0' AND '999999'");
$row = mysqli_fetch_row($sqlU1);
$countU1 = $row[0];
?>
            <th <?php if ($countU1 == '0'){ ?>class="table-sortable:numeric"<?php }; ?><?php if ($countU1 !== '0'){ ?>class="table-sortable:alphanumeric"<?php }; ?>><small>&nbsp;&nbsp;&nbsp; Unit</small></th>
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
	$lastget = $_POST['searchlast'];
    $searchlastget = ''; if ($_POST['searchlast'] != '') {$searchlastget = "`last_name` LIKE '%$lastget%' AND";}
    $firstget = $_POST['searchfirst'];
    $searchfirstget = ''; if ($_POST['searchfirst'] != '') {$searchfirstget = "`first_name` LIKE '%$firstget%' AND";}
	$query  = "SELECT `id`, `unit`, `unit2`, `last_name`, `first_name`, `email`, `phone`, `useripaddress`, `owner`, `lease`, `realtor`, `board`, `concierge`, `liaison`, `account`, `comments`, `status`, `created_date`, `directory`, `dphone`, `hide`, `accessdate`, `ghost`, `flex1`, `flex2`, `flex3`, `flex4`, `flex5`, `packagepreference`, `authcode`, `emailconfirm` FROM users WHERE $searchlastget $searchfirstget webmaster = '0' AND phone = '123456' AND ghost != 'Y' ORDER BY `id` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
        <tr>
            <td>
                <div class="small-12 medium-12 large-9 columns">
                <b><?php echo "{$row['last_name']}"; ?>, <?php echo "{$row['first_name']}"; ?></b>
                    <?php if ($row['hide'] == 'Y'){ ?><i class="fa fa-ban" aria-hidden="true" align="right" title="This user is HIDDEN in the Resident Directory."></i><?php }; ?>
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
                <br><a href="mailto:<?php echo "{$row['email']}"; ?>"><?php echo "{$row['email']}"; ?></a>
                    <?php if ($row['emailconfirm'] == 'V'){ ?><i class="fa fa-check" aria-hidden="true" title="This user has verified their email address."></i><?php }; ?>
                    <?php if ($row['emailconfirm'] == 'B'){ ?><i class="fa fa-exclamation-triangle" aria-hidden="true" title="This user&apos;s emails are bouncing."></i><?php }; ?>
                    <?php if ($row['directory'] == 'Y'){ ?><i class="fa fa-envelope-o green" aria-hidden="true" title="This user IS displaying their email address in the Resident Directory."></i><?php }; ?>
                    <?php if ($row['directory'] != 'Y'){ ?><i class="fa fa-envelope-o red" aria-hidden="true" align="right" title="This user is NOT displaying their email address in the Resident Directory."></i><?php }; ?>
                    <?php if ($row['ghost'] == 'A'){ ?><small>All Email</small><?php }; ?>
                    <?php if ($row['ghost'] == 'U'){ ?><small>Urgent Only</small><?php }; ?>
                    <?php if ($row['ghost'] == 'N'){ ?><small>No Email</small><?php }; ?>
                <br><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row['phone']); ?>"><?php echo "{$row['phone']}"; ?></a>
                    <?php if ($row['dphone'] == 'Y'){ ?><i class="fa fa-phone green" aria-hidden="true" title="This user IS displaying their phone number in the Resident Directory."></i><?php }; ?>
                    <?php if ($row['dphone'] != 'Y'){ ?><i class="fa fa-phone red" aria-hidden="true" align="right" title="This user is NOT displaying their phone number in the Resident Directory."></i><?php }; ?>
                <?php if ($row['accessdate'] >= '0000-00-01' && $row['accessdate'] <= $currentdate){ ?><br><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="note-red">Lease/Access Through Date <?php echo "{$row['accessdate']}"; ?></span><?php }; ?>
                <?php if ($row['status'] == 'suspended'){ ?><br><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="note-red">Suspended by Administrator</span><?php }; ?>
                <?php if ($row['email'] == ''){ ?><br><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="note-red">No&nbsp;Email</span><?php }; ?>
                <?php if ($row['owner'] == '0' AND $row['lease'] == '0' AND $row['realtor'] == '0'){ ?><br><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="note-red">No&nbsp;Permissions</span><?php }; ?>
                </div>
                <div class="small-12 medium-12 large-3 columns" align="right">
                    <div style="padding: 10px;">
                    <form name="TabEdit" method="POST" action="passwords-edit.php">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
                        <input name="submit" value="Edit" class="submit" type="submit">
                    </form>
                    </div>
<?php if ($_SESSION['webmaster'] == true){ ?>
                    <div style="padding: 10px;">
                    <form name="Purge" method="POST" action="passwords.php" onclick="return confirm('Are you sure you want to disable the user, <?php echo "{$row['first_name']}"; ?> <?php echo "{$row['last_name']}"; ?>?  Be sure to delete any registered vehicles or pets too.');">
                        <input type="hidden" name="action" value="purge">
                        <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
                        <input name="submit" value="Purge User" style="color: #990000" class="submit" type="submit" onclick="value='Processing Request - Resubmit'; style='color:red';" />
                    </form>
                    </div>
<?php }; ?>
                </div>
            </td>
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
<?php
	}
?>
<!-- END SPAM USERS -->
<!-- NEW USERS -->
<?php
    $lastget = $_POST['searchlast'];
    $searchlastget = ''; if ($_POST['searchlast'] != '') {$searchlastget = "`last_name` LIKE '%$lastget%' AND";}
    $firstget = $_POST['searchfirst'];
    $searchfirstget = ''; if ($_POST['searchfirst'] != '') {$searchfirstget = "`first_name` LIKE '%$firstget%' AND";}
	$query  = "SELECT `id` FROM users WHERE $searchlastget $searchfirstget webmaster = '0' AND status = 'New' AND ghost != 'Y' ORDER BY `id` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<br>
<div class="nav-section-header-cp" style="background-color:#990000">
        <strong><?php
$lastget = $_POST['searchlast'];
$searchlastget = ''; if ($_POST['searchlast'] != '') {$searchlastget = "`last_name` LIKE '%$lastget%' AND";}
$firstget = $_POST['searchfirst'];
$searchfirstget = ''; if ($_POST['searchfirst'] != '') {$searchfirstget = "`first_name` LIKE '%$firstget%' AND";}
$sql = mysqli_query($conn,"SELECT count(*) FROM users WHERE $searchlastget $searchfirstget webmaster = '0' AND status = 'New'") or die(mysqli_error($conn));

$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> New Accounts</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
    <thead>
        <tr>
            <th colspan="100">
                <div class="small-12 medium-6 columns">
        <form action="reports/csv-group.php">
            <input type="hidden" name="status" value="new">
            <input type="submit" value="Download This Data in CSV Format">
        </form>
<?php if ($_POST['searchlast'] != '' || $_GET['searchfirst'] != ''){ ?>
        <form action="passwords.php#search" method="post">
            <input type="submit" value="Show All Users">
        </form>
<?php }; ?>
                </div>
                <div class="small-12 medium-6 columns">
<?php
$sqlACCESS = mysqli_query($conn,"SELECT count(*) FROM 3rd WHERE `iframe` = 'Open'");
$row = mysqli_fetch_row($sqlACCESS);
$countACCESS = $row[0];
?>
<?php if ($countACCESS == '1'){ ?>
        <form name="SubjecttoApproval" method="POST" action="passwords.php" onclick="return confirm('Are you sure you want to make ALL NEW USER ACCESS SUBJECT TO ADMINISTRATOR APPROVAL?');">
            <input type="hidden" name="action" value="SubjecttoApproval">
            <input name="submit" value="Switch to Subject to Approval" class="submit" type="submit">
        </form>
        <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Currently, new users are immediately approved.</span>
<?php }; ?>
<?php $sqlACCESS = mysqli_query($conn,"SELECT count(*) FROM 3rd WHERE `iframe` = 'Subject'");
$row = mysqli_fetch_row($sqlACCESS);
$countACCESS = $row[0];
?>
<?php if ($countACCESS == '1'){ ?>
        <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">New users are currently subject to administrator approval.</span>
        <form name="OpenEnrollment" method="POST" action="passwords.php" onclick="return confirm('Are you sure you want to give ALL NEW USERS IMMEDIATE ACCESS to the website?');">
            <input type="hidden" name="action" value="OpenEnrollment">
            <input name="submit" value="Switch to Open Enrollment" class="submit" type="submit">
        </form>
<?php }; ?>
                </div>
            </th>
        </tr>
        <tr align="left">
            <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>User</small></th>
            <th width="50" class="table-sortable:numeric"><small>&nbsp;&nbsp;&nbsp; ID</small></th>
<?php $sqlU1 = mysqli_query($conn,"SELECT count(*) FROM users WHERE `unit` NOT BETWEEN '0' AND '999999'");
$row = mysqli_fetch_row($sqlU1);
$countU1 = $row[0];
?>
            <th <?php if ($countU1 == '0'){ ?>class="table-sortable:numeric"<?php }; ?><?php if ($countU1 !== '0'){ ?>class="table-sortable:alphanumeric"<?php }; ?>><small>&nbsp;&nbsp;&nbsp; Unit</small></th>
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
	$lastget = $_POST['searchlast'];
    $searchlastget = ''; if ($_POST['searchlast'] != '') {$searchlastget = "`last_name` LIKE '%$lastget%' AND";}
    $firstget = $_POST['searchfirst'];
    $searchfirstget = ''; if ($_POST['searchfirst'] != '') {$searchfirstget = "`first_name` LIKE '%$firstget%' AND";}
	$query  = "SELECT `id`, `unit`, `unit2`, `last_name`, `first_name`, `email`, `phone`, `useripaddress`, `owner`, `lease`, `realtor`, `board`, `concierge`, `liaison`, `account`, `comments`, `status`, `created_date`, `directory`, `dphone`, `hide`, `accessdate`, `ghost`, `flex1`, `flex2`, `flex3`, `flex4`, `flex5`, `packagepreference`, `authcode`, `emailconfirm` FROM users WHERE $searchlastget $searchfirstget webmaster = '0' AND status = 'New' AND ghost != 'Y' ORDER BY `id` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- DATABASE RESULTS -->
        <tr>
            <td>
                <div class="small-12 medium-12 large-9 columns">
                <b><?php echo "{$row['last_name']}"; ?>, <?php echo "{$row['first_name']}"; ?></b>
                    <?php if ($row['hide'] == 'Y'){ ?><i class="fa fa-ban" aria-hidden="true" align="right" title="This user is HIDDEN in the Resident Directory."></i><?php }; ?>
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
                <br><a href="mailto:<?php echo "{$row['email']}"; ?>"><?php echo "{$row['email']}"; ?></a>
                    <?php if ($row['emailconfirm'] == 'V'){ ?><i class="fa fa-check" aria-hidden="true" title="This user has verified their email address."></i><?php }; ?>
                    <?php if ($row['emailconfirm'] == 'B'){ ?><i class="fa fa-exclamation-triangle" aria-hidden="true" title="This user&apos;s emails are bouncing."></i><?php }; ?>
                    <?php if ($row['directory'] == 'Y'){ ?><i class="fa fa-envelope-o green" aria-hidden="true" title="This user IS displaying their email address in the Resident Directory."></i><?php }; ?>
                    <?php if ($row['directory'] != 'Y'){ ?><i class="fa fa-envelope-o red" aria-hidden="true" align="right" title="This user is NOT displaying their email address in the Resident Directory."></i><?php }; ?>
                    <?php if ($row['ghost'] == 'A'){ ?><small>All Email</small><?php }; ?>
                    <?php if ($row['ghost'] == 'U'){ ?><small>Urgent Only</small><?php }; ?>
                    <?php if ($row['ghost'] == 'N'){ ?><small>No Email</small><?php }; ?>
                <br><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row['phone']); ?>"><?php echo "{$row['phone']}"; ?></a>
                    <?php if ($row['dphone'] == 'Y'){ ?><i class="fa fa-phone green" aria-hidden="true" title="This user IS displaying their phone number in the Resident Directory."></i><?php }; ?>
                    <?php if ($row['dphone'] != 'Y'){ ?><i class="fa fa-phone red" aria-hidden="true" align="right" title="This user is NOT displaying their phone number in the Resident Directory."></i><?php }; ?>
                <?php if ($row['accessdate'] >= '0000-00-01' && $row['accessdate'] <= $currentdate){ ?><br><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="note-red">Lease/Access Through Date <?php echo "{$row['accessdate']}"; ?></span><?php }; ?>
                <?php if ($row['status'] == 'suspended'){ ?><br><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="note-red">Suspended by Administrator</span><?php }; ?>
                <?php if ($row['status'] == 'new'){ ?><br><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="note-red">Awaiting Administrator Approval</span><?php }; ?>
                <?php if ($row['email'] == ''){ ?><br><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="note-red">No&nbsp;Email</span><?php }; ?>
                <?php if ($row['owner'] == '0' AND $row['lease'] == '0' AND $row['realtor'] == '0'){ ?><br><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="note-red">No&nbsp;Permissions</span><?php }; ?>
                </div>
                <div class="small-12 medium-12 large-3 columns" align="right">
                    <div style="padding: 10px;">
                    <form name="passDisable" method="POST" action="passwords.php" onclick="return confirm('Are you sure you want to disable the user, <?php echo "{$row['first_name']}"; ?> <?php echo "{$row['last_name']}"; ?>?  Be sure to delete any registered vehicles or pets too.');">
                        <input type="hidden" name="action" value="passDisable">
                        <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
                        <input type="hidden" name="status" value="disabled">
                        <input name="submit" value="Disable" class="submit" type="submit">
                    </form>
                    </div>
                    <div style="padding: 10px;">
                    <form name="TabEdit" method="POST" action="passwords-edit.php">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
                        <input name="submit" value="Approve / Edit" class="submit" type="submit">
                    </form>
                    </div>
<?php if ($_SESSION['webmaster'] == true){ ?>
                    <div style="padding: 10px;">
                    <form name="Purge" method="POST" action="passwords.php" onclick="return confirm('Are you sure you want to disable the user, <?php echo "{$row['first_name']}"; ?> <?php echo "{$row['last_name']}"; ?>?  Be sure to delete any registered vehicles or pets too.');">
                        <input type="hidden" name="action" value="purge">
                        <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
                        <input name="submit" value="Purge User" style="color: #990000" class="submit" type="submit" onclick="value='Processing Request - Resubmit'; style='color:red';" />
                    </form>
                    </div>
<?php }; ?>
                </div>
            </td>
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
<?php
	}
?>
<!-- SUSPENDED USERS -->
<?php
	$currentdate = date("Y-m-d");
    $lastget = $_POST['searchlast'];
    $searchlastget = ''; if ($_POST['searchlast'] != '') {$searchlastget = "`last_name` LIKE '%$lastget%' AND";}
    $firstget = $_POST['searchfirst'];
    $searchfirstget = ''; if ($_POST['searchfirst'] != '') {$searchfirstget = "`first_name` LIKE '%$firstget%' AND";}
	$query  = "SELECT status, password, owner, lease, realtor, accessdate, ghost, email FROM users WHERE $searchlastget $searchfirstget status != 'new' AND status != 'disabled' AND password = '' OR $searchlastget $searchfirstget status != 'disabled' AND (webmaster = '0' AND (status = 'suspended' OR email = '' OR $searchlastget $searchfirstget (owner = '0' AND lease = '0' AND realtor = '0') OR (accessdate >= '0000-00-01' AND accessdate <= current_date())) AND ghost != 'Y') ORDER BY `id` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<br>
<div class="nav-section-header-cp" style="background-color:#990000">
        <strong><?php
$lastget = $_POST['searchlast'];
$searchlastget = ''; if ($_POST['searchlast'] != '') {$searchlastget = "`last_name` LIKE '%$lastget%' AND";}
$firstget = $_POST['searchfirst'];
$searchfirstget = ''; if ($_POST['searchfirst'] != '') {$searchfirstget = "`first_name` LIKE '%$firstget%' AND";}
$sql = mysqli_query($conn,"SELECT count(*) FROM users WHERE $searchlastget $searchfirstget status != 'new' AND status != 'disabled' AND password = '' OR $searchlastget $searchfirstget status != 'disabled' AND (webmaster = '0' AND (status = 'suspended' OR email = '' OR $searchlastget $searchfirstget (owner = '0' AND lease = '0' AND realtor = '0') OR (accessdate >= '0000-00-01' AND accessdate <= current_date())) AND ghost != 'Y')") or die(mysqli_error($conn));

$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Suspended or Incomplete Accounts</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
    <thead>
        <tr>
            <th colspan="100">
                <div class="small-12 medium-6 columns">
        <form action="reports/csv-group.php">
            <input type="hidden" name="status" value="suspended">
            <input type="submit" value="Download This Data in CSV Format">
        </form>
<?php if ($_POST['searchlast'] != '' || $_GET['searchfirst'] != ''){ ?>
        <form action="passwords.php#search" method="post">
            <input type="submit" value="Show All Users">
        </form>
<?php }; ?>
                </div>
                <div class="small-12 medium-6 columns">
                    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Users who have reached their Lease/Access Through Date are automatically purged after 60-days.</span>
                </div>
            </th>
        </tr>
<?php if ($_POST['searchlast'] != '' || $_GET['searchfirst'] != ''){ ?>
        <tr>
            <th colspan="100">
                <div class="small-12 columns">
        <form action="passwords.php#search" method="post">
            <input type="submit" value="Show All Users">
        </form>
                </div>
            </th>
        </tr>
<?php }; ?>
        <tr align="left">
            <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>User</small></th>
            <th width="50" class="table-sortable:numeric"><small>&nbsp;&nbsp;&nbsp; ID</small></th>
<?php $sqlU1 = mysqli_query($conn,"SELECT count(*) FROM users WHERE `unit` NOT BETWEEN '0' AND '999999'");
$row = mysqli_fetch_row($sqlU1);
$countU1 = $row[0];
?>
            <th <?php if ($countU1 == '0'){ ?>class="table-sortable:numeric"<?php }; ?><?php if ($countU1 !== '0'){ ?>class="table-sortable:alphanumeric"<?php }; ?>><small>&nbsp;&nbsp;&nbsp; Unit</small></th>
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
	$currentdate = date("Y-m-d");
	$lastget = $_POST['searchlast'];
    $searchlastget = ''; if ($_POST['searchlast'] != '') {$searchlastget = "`last_name` LIKE '%$lastget%' AND";}
    $firstget = $_POST['searchfirst'];
    $searchfirstget = ''; if ($_POST['searchfirst'] != '') {$searchfirstget = "`first_name` LIKE '%$firstget%' AND";}
	$query  = "SELECT `id`, `unit`, `unit2`, `last_name`, `first_name`, `email`, `phone`, `useripaddress`, `owner`, `lease`, `realtor`, `board`, `concierge`, `liaison`, `account`, `comments`, `status`, `created_date`, `directory`, `dphone`, `hide`, `accessdate`, `ghost`, `flex1`, `flex2`, `flex3`, `flex4`, `flex5`, `packagepreference`, `authcode`, `emailconfirm` FROM users WHERE $searchlastget $searchfirstget status != 'new' AND status != 'disabled' AND password = '' OR $searchlastget $searchfirstget status != 'disabled' AND (webmaster = '0' AND (status = 'suspended' OR email = '' OR (owner = '0' AND lease = '0' AND realtor = '0') OR $searchlastget $searchfirstget (accessdate >= '0000-00-01' AND accessdate <= current_date())) AND ghost != 'Y') ORDER BY `id` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- DATABASE RESULTS -->
        <tr>
            <td>
                <div class="small-12 medium-12 large-9 columns">
                <b><?php echo "{$row['last_name']}"; ?>, <?php echo "{$row['first_name']}"; ?></b>
                    <?php if ($row['hide'] == 'Y'){ ?><i class="fa fa-ban" aria-hidden="true" align="right" title="This user is HIDDEN in the Resident Directory."></i><?php }; ?>
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
                <br><a href="mailto:<?php echo "{$row['email']}"; ?>"><?php echo "{$row['email']}"; ?></a>
                    <?php if ($row['emailconfirm'] == 'V'){ ?><i class="fa fa-check" aria-hidden="true" title="This user has verified their email address."></i><?php }; ?>
                    <?php if ($row['emailconfirm'] == 'B'){ ?><i class="fa fa-exclamation-triangle" aria-hidden="true" title="This user&apos;s emails are bouncing."></i><?php }; ?>
                    <?php if ($row['directory'] == 'Y'){ ?><i class="fa fa-envelope-o green" aria-hidden="true" title="This user IS displaying their email address in the Resident Directory."></i><?php }; ?>
                    <?php if ($row['directory'] != 'Y'){ ?><i class="fa fa-envelope-o red" aria-hidden="true" align="right" title="This user is NOT displaying their email address in the Resident Directory."></i><?php }; ?>
                    <?php if ($row['ghost'] == 'A'){ ?><small>All Email</small><?php }; ?>
                    <?php if ($row['ghost'] == 'U'){ ?><small>Urgent Only</small><?php }; ?>
                    <?php if ($row['ghost'] == 'N'){ ?><small>No Email</small><?php }; ?>
                <br><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row['phone']); ?>"><?php echo "{$row['phone']}"; ?></a>
                    <?php if ($row['dphone'] == 'Y'){ ?><i class="fa fa-phone green" aria-hidden="true" title="This user IS displaying their phone number in the Resident Directory."></i><?php }; ?>
                    <?php if ($row['dphone'] != 'Y'){ ?><i class="fa fa-phone red" aria-hidden="true" align="right" title="This user is NOT displaying their phone number in the Resident Directory."></i><?php }; ?>
                <?php if ($row['accessdate'] >= '0000-00-01' && $row['accessdate'] <= $currentdate){ ?><br><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="note-red">Lease/Access Through Date <?php echo "{$row['accessdate']}"; ?></span><?php }; ?>
                <?php if ($row['status'] == 'suspended'){ ?><br><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="note-red">Suspended by Administrator</span><?php }; ?>
                <?php if ($row['email'] == ''){ ?><br><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="note-red">No&nbsp;Email</span><?php }; ?>
                <?php if ($row['owner'] == '0' AND $row['lease'] == '0' AND $row['realtor'] == '0'){ ?><br><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="note-red">No&nbsp;Permissions</span><?php }; ?>
                </div>
                <div class="small-12 medium-12 large-3 columns" align="right">
                    <div style="padding: 10px;">
                    <form name="passDisable" method="POST" action="passwords.php" onclick="return confirm('Are you sure you want to disable the user, <?php echo "{$row['first_name']}"; ?> <?php echo "{$row['last_name']}"; ?>?  Be sure to delete any registered vehicles or pets too.');">
                        <input type="hidden" name="action" value="passDisable">
                        <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
                        <input type="hidden" name="status" value="disabled">
                        <input name="submit" value="Disable" class="submit" type="submit">
                    </form>
                    </div>
                    <div style="padding: 10px;">
                    <form name="TabEdit" method="POST" action="passwords-edit.php">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
                        <input name="submit" value="Edit" class="submit" type="submit">
                    </form>
                    </div>
<?php if ($_SESSION['webmaster'] == true){ ?>
                    <div style="padding: 10px;">
                    <form name="Purge" method="POST" action="passwords.php" onclick="return confirm('Are you sure you want to disable the user, <?php echo "{$row['first_name']}"; ?> <?php echo "{$row['last_name']}"; ?>?  Be sure to delete any registered vehicles or pets too.');">
                        <input type="hidden" name="action" value="purge">
                        <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
                        <input name="submit" value="Purge User" style="color: #990000" class="submit" type="submit" onclick="value='Processing Request - Resubmit'; style='color:red';" />
                    </form>
                    </div>
<?php }; ?>
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
<?php
	}
?>
<!-- ACTIVE USERS -->
<?php
    $lastget = $_POST['searchlast'];
    $searchlastget = ''; if ($_POST['searchlast'] != '') {$searchlastget = "`last_name` LIKE '%$lastget%' AND";}
    $firstget = $_POST['searchfirst'];
    $searchfirstget = ''; if ($_POST['searchfirst'] != '') {$searchfirstget = "`first_name` LIKE '%$firstget%' AND";}
	$query  = "SELECT `id` FROM users WHERE $searchlastget $searchfirstget webmaster = '0' AND status = 'Active' AND ghost != 'Y' AND email != '' AND password != '' AND (accessdate = '0000-00-00' OR accessdate >= current_date()) AND (owner = '1' OR lease = '1' OR realtor = '1') ORDER BY `id` DESC LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<br>
<div class="nav-section-header-cp">
        <strong><?php
$lastget = $_POST['searchlast'];
$searchlastget = ''; if ($_POST['searchlast'] != '') {$searchlastget = "`last_name` LIKE '%$lastget%' AND";}
$firstget = $_POST['searchfirst'];
$searchfirstget = ''; if ($_POST['searchfirst'] != '') {$searchfirstget = "`first_name` LIKE '%$firstget%' AND";}

$sql = mysqli_query($conn,"SELECT count(*) FROM users WHERE $searchlastget $searchfirstget webmaster = '0' AND status = 'Active' AND ghost != 'Y' AND email != '' AND password != '' AND (accessdate = '0000-00-00' OR accessdate >= current_date()) AND (owner = '1' OR lease = '1' OR realtor = '1')") or die(mysqli_error($conn));

$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Active Accounts</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
    <thead>
        <tr>
            <th colspan="100">
                <div class="small-12 medium-6 columns">
        <form action="reports/csv-group.php">
            <input type="hidden" name="status" value="active">
            <input type="submit" value="Download This Data in CSV Format">
        </form>
<?php if ($_POST['searchlast'] != '' || $_GET['searchfirst'] != ''){ ?>
        <form action="passwords.php#search" method="post">
            <input type="submit" value="Show All Users">
        </form>
<?php }; ?>
                </div>
                <div class="small-12 medium-6 columns">
<?php $sqlACCESS = mysqli_query($conn,"SELECT count(*) FROM 3rd WHERE `iframe` = 'Open'");
$row = mysqli_fetch_row($sqlACCESS);
$countACCESS = $row[0];
?>
<?php if ($countACCESS == '1'){ ?>
        <form name="SubjecttoApproval" method="POST" action="passwords.php" onclick="return confirm('Are you sure you want to make ALL NEW USER ACCESS SUBJECT TO ADMINISTRATOR APPROVAL?');">
            <input type="hidden" name="action" value="SubjecttoApproval">
            <input name="submit" value="Switch to Subject to Approval" class="submit" type="submit">
        </form>
        <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Currently, new users are immediately approved.</span>
<?php }; ?>
<?php $sqlACCESS = mysqli_query($conn,"SELECT count(*) FROM 3rd WHERE `iframe` = 'Subject'");
$row = mysqli_fetch_row($sqlACCESS);
$countACCESS = $row[0];
?>
<?php if ($countACCESS == '1'){ ?>
        <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">New users are currently subject to administrator approval.</span>
        <form name="OpenEnrollment" method="POST" action="passwords.php" onclick="return confirm('Are you sure you want to give ALL NEW USERS IMMEDIATE ACCESS to the website?');">
            <input type="hidden" name="action" value="OpenEnrollment">
            <input name="submit" value="Switch to Open Enrollment" class="submit" type="submit">
        </form>
<?php }; ?>
                </div>
            </th>
        </tr>
        <tr>
            <th colspan="100">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">User Accounts can be created by the user, using the Create Login link on the home page.</span>
                <br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Mouse over red and green icons for descriptions.</span>
            </th>
        </tr>
        <tr align="left">
            <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp;<small>User</small></th>
            <th width="50" class="table-sortable:numeric"><small>&nbsp;&nbsp;&nbsp;ID</small></th>
<?php $sqlU1 = mysqli_query($conn,"SELECT count(*) FROM users WHERE `unit` NOT BETWEEN '0' AND '999999'");
$row = mysqli_fetch_row($sqlU1);
$countU1 = $row[0];
?>
            <th <?php if ($countU1 == '0'){ ?>class="table-sortable:numeric"<?php }; ?><?php if ($countU1 !== '0'){ ?>class="table-sortable:alphanumeric"<?php }; ?>><small>&nbsp;&nbsp;&nbsp;Unit</small></th>
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
    $lastget = $_POST['searchlast'];
    $searchlastget = ''; if ($_POST['searchlast'] != '') {$searchlastget = "`last_name` LIKE '%$lastget%' AND";}
    $firstget = $_POST['searchfirst'];
    $searchfirstget = ''; if ($_POST['searchfirst'] != '') {$searchfirstget = "`first_name` LIKE '%$firstget%' AND";}
	$query  = "SELECT `id`, `unit`, `unit2`, `last_name`, `first_name`, `email`, `phone`, `useripaddress`, `owner`, `lease`, `realtor`, `board`, `concierge`, `liaison`, `account`, `comments`, `status`, `created_date`, `directory`, `dphone`, `hide`, `accessdate`, `ghost`, `flex1`, `flex2`, `flex3`, `flex4`, `flex5`, `packagepreference`, `authcode`, `emailconfirm` FROM users WHERE $searchlastget $searchfirstget webmaster = '0' AND status = 'Active' AND ghost != 'Y' AND email != '' AND password != '' AND (accessdate = '0000-00-00' OR accessdate >= current_date()) AND (owner = '1' OR lease = '1' OR realtor = '1') ORDER BY `id` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- DATABASE RESULTS -->
        <tr>
            <td>
                <div class="small-12 medium-12 large-9 columns">
                <b><?php echo "{$row['last_name']}"; ?>, <?php echo "{$row['first_name']}"; ?></b>
                    <?php if ($row['hide'] == 'Y'){ ?><i class="fa fa-ban" aria-hidden="true" align="right" title="This user is HIDDEN in the Resident Directory."></i><?php }; ?>
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
                <br><a href="mailto:<?php echo "{$row['email']}"; ?>"><?php echo "{$row['email']}"; ?></a>
                    <?php if ($row['emailconfirm'] == 'V'){ ?><i class="fa fa-check" aria-hidden="true" title="This user has verified their email address."></i><?php }; ?>
                    <?php if ($row['emailconfirm'] == 'B'){ ?><i class="fa fa-exclamation-triangle" aria-hidden="true" title="This user&apos;s emails are bouncing."></i><?php }; ?>
                    <?php if ($row['directory'] == 'Y'){ ?><i class="fa fa-envelope-o green" aria-hidden="true" title="This user IS displaying their email address in the Resident Directory."></i><?php }; ?>
                    <?php if ($row['directory'] != 'Y'){ ?><i class="fa fa-envelope-o red" aria-hidden="true" align="right" title="This user is NOT displaying their email address in the Resident Directory."></i><?php }; ?>
                    <?php if ($row['ghost'] == 'A'){ ?><small>All Email</small><?php }; ?>
                    <?php if ($row['ghost'] == 'U'){ ?><small>Urgent Only</small><?php }; ?>
                    <?php if ($row['ghost'] == 'N'){ ?><small>No Email</small><?php }; ?>
                <br><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row['phone']); ?>"><?php echo "{$row['phone']}"; ?></a>
                    <?php if ($row['dphone'] == 'Y'){ ?><i class="fa fa-phone green" aria-hidden="true" title="This user IS displaying their phone number in the Resident Directory."></i><?php }; ?>
                    <?php if ($row['dphone'] != 'Y'){ ?><i class="fa fa-phone red" aria-hidden="true" align="right" title="This user is NOT displaying their phone number in the Resident Directory."></i><?php }; ?>
                <?php if ($row['accessdate'] != '0000-00-00'){ ?><br><span class="note-black">Lease/Access Through Date <?php echo "{$row['accessdate']}"; ?></span><?php }; ?>
                </div>
                <div class="small-12 medium-12 large-3 columns" align="right">
                    <div style="padding: 10px;">
                    <form name="passDisable" method="POST" action="passwords.php" onclick="return confirm('Are you sure you want to disable the user, <?php echo "{$row['first_name']}"; ?> <?php echo "{$row['last_name']}"; ?>?  Be sure to delete any registered vehicles or pets too.');">
                        <input type="hidden" name="action" value="passDisable">
                        <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
                        <input type="hidden" name="status" value="disabled">
                        <input name="submit" value="Disable" class="submit" type="submit">
                    </form>
                    </div>
                    <div style="padding: 10px;">
                    <form name="TabEdit" method="POST" action="passwords-edit.php">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
                        <input name="submit" value="Edit" class="submit" type="submit">
                    </form>
                    </div>
<?php if ($_SESSION['webmaster'] == true){ ?>
                    <div style="padding: 10px;">
                    <form name="Purge" method="POST" action="passwords.php" onclick="return confirm('Are you sure you want to disable the user, <?php echo "{$row['first_name']}"; ?> <?php echo "{$row['last_name']}"; ?>?  Be sure to delete any registered vehicles or pets too.');">
                        <input type="hidden" name="action" value="purge">
                        <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
                        <input name="submit" value="Purge User" style="color: #990000" class="submit" type="submit" onclick="value='Processing Request - Resubmit'; style='color:red';" />
                    </form>
                    </div>
<?php }; ?>
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
<?php
	}
?>
<!-- DISABLED USERS -->
<a name="disabledusers"></a>
<?php
    $lastget = $_POST['searchlast'];
    $searchlastget = ''; if ($_POST['searchlast'] != '') {$searchlastget = "`last_name` LIKE '%$lastget%' AND";}
    $firstget = $_POST['searchfirst'];
    $searchfirstget = ''; if ($_POST['searchfirst'] != '') {$searchfirstget = "`first_name` LIKE '%$firstget%' AND";}
	$query  = "SELECT `id` FROM users WHERE $searchlastget $searchfirstget webmaster = '0' AND status = 'disabled' AND ghost != 'Y' ORDER BY `id` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<br>
<div class="nav-section-header-cp" style="background-color: #990000;">
        <strong><?php
$lastget = $_POST['searchlast'];
$searchlastget = ''; if ($_POST['searchlast'] != '') {$searchlastget = "`last_name` LIKE '%$lastget%' AND";}
$firstget = $_POST['searchfirst'];
$searchfirstget = ''; if ($_POST['searchfirst'] != '') {$searchfirstget = "`first_name` LIKE '%$firstget%' AND";}

$sql = mysqli_query($conn,"SELECT count(*) FROM users WHERE $searchlastget $searchfirstget webmaster = '0' AND status = 'disabled' AND ghost != 'Y'") or die(mysqli_error($conn));

$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Disabled Accounts</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
    <thead>
        <tr>
            <th colspan="100">
                <div class="small-12 medium-6 columns">
        <form action="reports/csv-group.php">
            <input type="hidden" name="status" value="disabled">
            <input type="submit" value="Download This Data in CSV Format">
        </form>
<?php if ($_POST['searchlast'] != '' || $_GET['searchfirst'] != ''){ ?>
        <form action="passwords.php#search" method="post">
            <input type="submit" value="Show All Users">
        </form>
<?php }; ?>
                </div>
                <div class="small-12 medium-6 columns">
                    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Disabled users are automatically purged after one-year.</span>
                </div>
            </th>
        </tr>
<?php if ($_POST['searchlast'] != '' || $_GET['searchfirst'] != ''){ ?>
        <tr>
            <th colspan="100">
                <div class="small-12 columns">
        <form action="passwords.php#search" method="post">
            <input type="submit" value="Show All Users">
        </form>
                </div>
            </th>
        </tr>
<?php }; ?>
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
    $lastget = $_POST['searchlast'];
    $searchlastget = ''; if ($_POST['searchlast'] != '') {$searchlastget = "`last_name` LIKE '%$lastget%' AND";}
    $firstget = $_POST['searchfirst'];
    $searchfirstget = ''; if ($_POST['searchfirst'] != '') {$searchfirstget = "`first_name` LIKE '%$firstget%' AND";}
	$query  = "SELECT `id`, `unit`, `unit2`, `last_name`, `first_name`, `email`, `phone`, `useripaddress`, `owner`, `lease`, `realtor`, `board`, `concierge`, `liaison`, `account`, `comments`, `status`, `created_date`, `directory`, `dphone`, `hide`, `accessdate`, `ghost`, `flex1`, `flex2`, `flex3`, `flex4`, `flex5`, `packagepreference`, `authcode`, `emailconfirm` FROM users WHERE $searchlastget $searchfirstget webmaster = '0' AND `status` = 'disabled' AND ghost != 'Y' ORDER BY `id` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- DATABASE RESULTS -->
        <tr>
            <td>
                <div class="small-12 medium-12 large-10 columns">
                <b><?php echo "{$row['last_name']}"; ?>, <?php echo "{$row['first_name']}"; ?></b>
                    <?php if ($row['hide'] == 'Y'){ ?><i class="fa fa-ban" aria-hidden="true" align="right" title="This user is HIDDEN in the Resident Directory."></i><?php }; ?>
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
                <br><a href="mailto:<?php echo "{$row['email']}"; ?>"><?php echo "{$row['email']}"; ?></a>
                    <?php if ($row['directory'] == 'Y'){ ?><i class="fa fa-envelope-o green" aria-hidden="true" title="This user IS displaying their email address in the Resident Directory."></i><?php }; ?>
                    <?php if ($row['directory'] != 'Y'){ ?><i class="fa fa-envelope-o red" aria-hidden="true" align="right" title="This user is NOT displaying their email address in the Resident Directory."></i><?php }; ?>
                    <?php if ($row['ghost'] == 'A'){ ?><small>All Email</small><?php }; ?>
                    <?php if ($row['ghost'] == 'U'){ ?><small>Urgent Only</small><?php }; ?>
                    <?php if ($row['ghost'] == 'N'){ ?><small>No Email</small><?php }; ?>
                <br><?php echo "{$row['phone']}"; ?>
                    <?php if ($row['dphone'] == 'Y'){ ?><i class="fa fa-phone green" aria-hidden="true" title="This user IS displaying their phone number in the Resident Directory."></i><?php }; ?>
                    <?php if ($row['dphone'] != 'Y'){ ?><i class="fa fa-phone red" aria-hidden="true" align="right" title="This user is NOT displaying their phone number in the Resident Directory."></i><?php }; ?>
                <br><span class="note-black">Date Disabled <?php echo "{$row['accessdate']}"; ?></span>
                </div>
                <div class="small-6 medium-6 large-2 columns">
    	            <form name="TabEdit" method="POST" action="passwords-edit.php">
	                    <input type="hidden" name="action" value="edit">
    	                <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
	                    <input name="submit" value="Edit" class="submit" type="submit" onclick="value='Processing Request - Resubmit'; style='color:red';" />
	                </form>
                </div>
<?php if ($_SESSION['webmaster'] == true){ ?>
                    <div style="padding: 10px;">
                    <form name="Purge" method="POST" action="passwords.php" onclick="return confirm('Are you sure you want to disable the user, <?php echo "{$row['first_name']}"; ?> <?php echo "{$row['last_name']}"; ?>?  Be sure to delete any registered vehicles or pets too.');">
                        <input type="hidden" name="action" value="purge">
                        <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
                        <input name="submit" value="Purge User" style="color: #990000" class="submit" type="submit" onclick="value='Processing Request - Resubmit'; style='color:red';" />
                    </form>
                    </div>
<?php }; ?>
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
<?php
	}
?>
<!-- END DISABLED USERS -->



<?php
	$query  = "SELECT `id` FROM utilities WHERE `category` = 'Password' ORDER BY company";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<a name="passwordhelp"></a>
<br>
<div class="nav-section-header-cp">
        <strong>Login Help Contact</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr align="left">
        <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Listing</small></th>
        <th align="center"><small>Logo</small></th>
    </tr>
  </thead>
  <tbody style="background-color:#ffffff">
<!-- DATABASE RESULTS -->
<?php
	$query  = "SELECT * FROM utilities WHERE `category` = 'Password' ORDER BY company LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
    <tr>
      <td>
        <div class="small-12 medium-12 large-8 columns">
<?php if ($row['company'] !== ''){ ?><b><?php echo "{$row['company']}"; ?></b><br><?php }; ?>
<?php if ($row['contact'] !== ''){ ?><?php echo "{$row['contact']}"; ?><br><?php }; ?>
<?php if ($row['phone1'] !== ''){ ?><?php echo "{$row['phone1']}"; ?><br><?php }; ?>
<?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>"><?php echo "{$row['email']}"; ?></a><br><br><?php }; ?>
        </div>
        <div class="small-6 medium-6 large-2 columns">
	        <form name="UtilitiesEdit" method="POST" action="loginhelp-edit.php">
	            <input type="hidden" name="action" value="edit">
	            <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
	            <input name="submit" value="Edit" class="submit" type="submit">
	            <input type="hidden" name="module" value="passwords.php">
	        </form>
        </div>
      </td>
      <td align="center" style="background-color:#ffffff"><?php if ($row['name'] !== ''){ ?><?php if ($row['name'] !== 'none'){ ?><img src="../download-utilities.php?id=<?php echo "{$row['id']}"; ?>" alt="<?php echo "{$row['company']}"; ?>"><?php }; ?><?php }; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
  </tbody>
</table>
</div>
<br>
<?php
	}
?>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>User Accounts Control Panel Page<br></div>
</body>
</html>
