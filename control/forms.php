<?php $current_page = '21'; include('protect.php'); ?>
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
<!-- HEALTH AND HELP -->
<div>
    <div class="large-8 columns" style="padding: 0px">
        <div class="nav-section-header-health-cp" align="center">
<big>&nbsp;</big>
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
        <p><a href="#eforms"><b>eForms</b></a> allow users to submit information to the board/management.  The first group of eForms compiles the user submitted information into an email and send it to a pre-defined distribution list.</p>
        <p><a href="#dsforms"><b>Database Submission eForms</b></a> inserts the submitted information into the database.</p>
    </div>
    <div class="small-12 medium-6 columns">
        <p><a href="#customforms"><b>Custom eForms</b></a> are created by your CondoSites webmaster and work just like eForms.</p>
        <p>You can also <a href="#modulecontent">edit the message</a> shown to users after submitting eForms.</p>
    </div>
</div>

<div style="max-width: 99%;">
<a name="eforms"></a>
<div class="nav-section-header-cp">
    <strong>eForms</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
    <thead>
        <tr align="center" valign="middle">
            <th colspan="7">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Contact your CondoSites Webmaster to have your eForm distribution email lists modified.<br></span>
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">The fields in these eForms <i>can</i> be customized.  Contact your CondoSites Webmaster to make changes.</span>
            </th>
        </tr>
        <tr align="left" valign="middle">
            <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Module</small></th>
            <th width="50" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>ID</small></th>
            <th class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <small>Tab</small></th>
            <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Email</small></th>
            <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Owner</small></b></div></th>
						<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Renter</small></b></div></th>
						<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Realtor</small></b></div></th>
        </tr>
    </thead>
    <tbody style="background-color:#ffffff">
<!-- DATABASE RESULTS -->
<?php
    $module = "forms.php#forms";
	$query  = "SELECT * FROM tabs WHERE liaison = 'Y' AND `int1` BETWEEN '400' AND '449' ORDER BY `int1`";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php include('forms-list.php'); ?>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
    </tbody>
</table>
<a name="dsforms"></a>
<br>
<div class="nav-section-header-cp">
    <strong>Database Submission eForms</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
    <thead>
        <tr align="center" valign="middle">
            <th colspan="6">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red"> All automated emails generated from concierge related Database Submission eForms are sent to your Concierge address, <?php echo "{$CLASSIFIEDS_EMAIL}"; ?>. Contact your CondoSites Webmaster to have this modified.<br></span>
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red"> Service Requests are sent to your Maintenance address, <?php echo "{$MAINTENANCE_EMAIL}"; ?>. Contact your CondoSites Webmaster to have this modified.<br></span>
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red"> The fields in these eForms are <i>not</i> customizable.</span>
            </th>
        </tr>
        <tr align="left" valign="middle">
            <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Module</small></th>
            <th width="50" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>ID</small></th>
            <th class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <small>Tab</small></th>
            <th align="center" width="10" class="rotate90"><b><small>Owner</small></b></th>
            <th align="center" width="10" class="rotate90"><b><small>Renter</small></b></th>
            <th align="center" width="10" class="rotate90"><b><small>Realtor</small></b></th>
        </tr>
    </thead>
    <tbody style="background-color:#ffffff">
<!-- DATABASE RESULTS -->
<?php
    $module = "forms.php#dsforms";
	$query  = "SELECT * FROM tabs WHERE liaison = 'Y' AND `int1` BETWEEN '450' AND '474' ORDER BY `int1`";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php include('forms-list.php'); ?>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
  </tbody>
</table>
<a name="customforms"></a>
<br>
<div class="nav-section-header-cp">
    <strong>Custom eForms</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
    <thead>
        <tr align="left" valign="middle">
            <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Module</small></th>
            <th width="50" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>ID</small></th>
            <th class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <small>Tab</small></th>
            <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Email</small></th>
            <th align="center" width="10" class="rotate90"><b><small>Owner</small></b></th>
            <th align="center" width="10" class="rotate90"><b><small>Renter</small></b></th>
            <th align="center" width="10" class="rotate90"><b><small>Realtor</small></b></th>
        </tr>
    </thead>
    <tbody style="background-color:#ffffff">
<!-- DATABASE RESULTS -->
<?php
    $module = "forms.php#customforms";
	$query  = "SELECT * FROM tabs WHERE liaison = 'Y' AND `int1` BETWEEN '475' AND '499' ORDER BY `int1`";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php include('forms-list.php'); ?>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
    </tbody>
</table>
<a name="modulecontent"></a>
<br>
<div class="nav-section-header-cp">
        <strong>Custom Module Content</strong>
</div>
<table style="background-color:#eeeddd" align="center" border="0" cellpadding="5" cellspacing="1" width="95%" class="text table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr align="left">
      <th style="min-width:25%"><b><small>Module<small/></b></th>
      <th><b><small>Code</small></b></th>
    </tr>
  </thead>
  <tbody style="background-color:#ffffff">
<!-- DATABASE RESULTS -->
<?php
    $module = "forms.php";
	$query  = "SELECT `int1`, `type`, `theircode` FROM `3rd` WHERE `liaison` = 'Y' AND `type` = 'eForm Thank You Text' ORDER BY `int1`";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
    <tr>
      <td>
          <b><?php echo "{$row['type']}"; ?></b><br>
          <br>
        <form name="3rdEdit" method="POST" action="3rd-edit.php">
          <input type="hidden" name="action" value="edit">
          <input type="hidden" name="module" value="<?php echo "{$module}"; ?>">
          <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
          <input name="submit" value="Edit" class="submit" type="submit">
        </form>
      </td>
      <td><?php echo "{$row['theircode']}"; ?></td>
    </tr>
<?php
	}
?>
  </tbody>
</table>
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>eForms Control Panel Page<br></div>
</body>
</html>
