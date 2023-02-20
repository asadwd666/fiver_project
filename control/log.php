<?php $current_page = '22'; include('protect.php'); ?>
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

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
    <div class="small-12 medium-12 large-9 columns">
        <p>The <b>Change Log</b> records Edit and Delete/Disable actions performed by administrators, as well as profile Edit and Password changes by users.  It also logs Database Purge and Database Optimization actions performed by CondoSites.</p>
    </div>
</div>
<!-- UPLOAD FORM -->
<div style="max-width: 99%;">
<!-- LOG -->
<div class="nav-section-header-cp">
        <strong>Change Log</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr>
      <th colspan="100"><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Package data is not included.  Logs older than one year are subject to purge.</span></th>
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
	$query  = "SELECT `init1`, `created_date`, `action`, `tablename`, `id`, `userid`, `useripaddress`, `comment` FROM `log` WHERE `created_date` BETWEEN CURDATE() - INTERVAL 365 DAY AND SYSDATE() AND `tablename` != 'Packages' ORDER BY `init1` DESC";
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
	<?php if ($row['action'] == 'R'){ ?>Recover<?php }; ?>
	<?php if ($row['action'] == 'N'){ ?>New<?php }; ?>
      </td>
      <td><?php echo "{$row['tablename']}"; ?></td>
      <td><?php echo "{$row['id']}"; ?> <?php echo "{$row['comment']}"; ?></td>
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
<!-- LOG -->
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Change Log Control Panel Page<br></div>
</body>
</html>