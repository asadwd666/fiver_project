<?php $current_page = '30'; include('protect.php'); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="CondoSites - http://www.condosites.com" name="author">
<title>Control Panel</title>
<?php include('../control/cp-head-scripts.php'); ?>
	<script type="text/javascript">
	<!--
	  function showMe (it, box) {
		var vis = (box.checked) ? "block" : "none";
		document.getElementById(it).style.display = vis;
	  }
	  //-->
	</script>
</head>
<body>
<!-- LOGO AND NAVIGATION -->
<?php include('cp-navigation.php'); ?>
<!-- END LOGO AND NAVIGATION -->
<!-- HEALTH AND HELP -->
<div>
    <div class="large-8 columns" style="padding: 0px">
        <div class="nav-section-header-health-cp" align="center">
<big><i class="fa fa-stethoscope" aria-hidden="true"></i></big><strong>&nbsp;Health&nbsp;&nbsp;&nbsp;</strong>
<?php $sqlMAINTn = mysqli_query($conn,"SELECT count(*) FROM `service` WHERE `update_date` = '0000-00-00 00:00:00'") or die(mysqli_error($conn));
//$countMAINTn = mysql_result($sqlMAINTn, "0");
$row = mysqli_fetch_row($sqlMAINTn);
$countMAINTn = $row[0];
?>
<?php $sqlMAINT = mysqli_query($conn,"SELECT count(*) FROM `service` WHERE `status` != 'C'") or die(mysqli_error($conn));
//$countMAINT = mysql_result($sqlMAINT, "0");
$row = mysqli_fetch_row($sqlMAINT);
$countMAINT = $row[0];
?>

<?php if ($countMAINTn == '1'){ ?><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> You have <?php print($countMAINTn); ?> new service request!<?php }; ?>
<?php if ($countMAINTn >= '2'){ ?><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> You have <?php print($countMAINTn); ?> new service requests!<?php }; ?>

<?php if ($countMAINT == '0'){ ?><i class="fa fa-check" aria-hidden="true"></i> All of your service requests are completed!<?php }; ?>
<?php if ($countMAINT == '1'){ ?><i class="fa fa-exclamation-triangle note" aria-hidden="true"></i> You have 1 open service request.<?php }; ?>
<?php if ($countMAINT >= '2'){ ?><i class="fa fa-exclamation-triangle note" aria-hidden="true"></i> You have <?php echo "{$countMAINT}"; ?> open service requests.<?php }; ?>


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
        <p>This is where you can manage <b>Service Requests</b> initiated by users, or add Service Requests on behalf of your users.</p>
    </div>
    <div class="small-12 medium-6 columns">
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#modulepermissions"><b>Module Permissions</b></a> allow you to choose to enable this module and to which groups of users.</p>
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#add"><b>Add/Edit/View a Service Request</b></a> using the addition form below.</p>
    </div>
</div>

<a name="modulepermissions"></a>
<div class="nav-section-header-cp">
    <strong>Module Permissions</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
    <thead>
        <tr align="center" valign="middle">
            <th colspan="6">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Service Requests from users are sent to <?php echo "{$MAINTENANCE_EMAIL}"; ?>. Contact your CondoSites Webmaster to have this modified.<br></span>
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">The fields in these eForms are <i>not</i> customizable.</span>
            </th>
        </tr>
        <tr align="left" valign="middle">
            <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Module</small></th>
            <th width="50" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>ID</small></th>
            <th class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <small>Tab</small></th>
			<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Owner</small></b></div></th>
            <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Renter</small></b></div></th>
            <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Realtor</small></b></div></th>
        </tr>
    </thead>
    <tbody style="background-color:#ffffff">
<!-- DATABASE RESULTS -->
<?php
    $module = "service.php";
	$query  = "SELECT * FROM tabs WHERE liaison = 'Y' AND `int1` = '456' ORDER BY `int1`";
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

<a name="add"></a>
<br>
<div class="nav-section-header-cp">
        <strong><?php $sql = mysqli_query($conn,"SELECT count(*) FROM `service` WHERE `status` != 'C'") or die(mysqli_error($conn));
        //$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Open Service Requests</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
    <thead>
        <tr>
            <th colspan="100">
                <div style="float:right">
	                <form action="service-add.php">
	                    <input type="submit" value="Add Service Request">
	                </form>
                </div>
                <div style="float:left">
	                <form action="service-all.php">
	                    <input type="submit" value="View All Service Requests">
	                </form>
                </div>
                <div style="float:left">
	                <form action="reports/csv-servicerequests-open.php">
	                    <input type="submit" value="Download This Data in CSV Format" />
	                </form>
                </div>
            </th>
        </tr>
        <tr>
            <th colspan="100">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Service Requests remain for 2 years after completion.</span>
                <br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Mouse over red and green icons for descriptions.</span>
            </th>
        </tr>
        <tr align="left">
            <th class="table-sortable:alphanumeric"><b>&nbsp;&nbsp;&nbsp; <small>Details</small></th>
            <th align="center" width="50" class="table-sortable:numeric">&nbsp;&nbsp;&nbsp; <small>ID</small></th>
            <th class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <small>Unit</small></th>
            <th class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <small>Category</small></th>
            <th class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <small>Assigned to</small></th>
            <th class="table-sortable:alphanumeric table-filterable"><b>&nbsp;&nbsp;&nbsp; <small>Status</small></th>
            <th class="table-sortable:alphanumeric table-filterable"><b>&nbsp;&nbsp;&nbsp; <small>Updated</small></th>
        </tr>
    </thead>
    <tbody style="background-color:#ffffff">
<?php
	$query  = "SELECT * FROM `service` WHERE `status` != 'C' ORDER BY `int1`";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- DATABASE RESULTS -->
        <tr <?php if ($row['status'] == 'C'){ ?>style="background-color: #ffcccc;"<?php }; ?><?php if ($row['update_date'] == '0000-00-00 00:00:00'){ ?>style="background-color: #dde7ef;"<?php }; ?> >
            <td valign="top">
<i class="fa fa-comment" aria-hidden="true"></i> <b><?php echo "{$row['type']}"; ?></b>
<?php if ($row['privacy'] != 'Y'){ ?><div style="float: right;"><i class="fa fa-user-times" aria-hidden="true" style="color: red;" title="User is NOT sharing service request with other users in the same unit."></i></div><?php }; ?>
<?php if ($row['privacy'] == 'Y'){ ?><div style="float: right;"><i class="fa fa-users" aria-hidden="true" style="color: green;" title="User is sharing service request with other users in the same unit."></i></div><?php }; ?>
<?php if ($row['pte'] != 'Y'){ ?><div style="float: right;"><i class="fa fa-key" aria-hidden="true" style="color: red;" title="Permission to enter is NOT granted to enter unit!"></i>&nbsp;&nbsp;</div><?php }; ?>
<?php if ($row['pte'] == 'Y'){ ?><div style="float: right;"><i class="fa fa-key" aria-hidden="true" style="color: green;" title="Permission to enter is granted to enter unit!"></i>&nbsp;&nbsp;</div><?php }; ?>
<div><?php echo "{$row['description']}"; ?></div>
<?php if ($row['confcomments'] != ''){ ?><div style="color: red;"><i class="fa fa-comment" aria-hidden="true" style="color: red;"></i></label>  <?php echo "{$row['confcomments']}"; ?></div><?php }; ?>
    <blockquote>
        <small><b>Open</b>&nbsp;<?php echo "{$row['created_date']}"; ?></small> &nbsp;&nbsp; 

<?php if ($row['status'] == 'C'){ ?>
<small><b>Total&nbsp;Time</b>&nbsp;
<?php
$datestamp = $row['created_date'];
$current = $row['update_date'];
$datetime1 = date_create($datestamp);
$datetime2 = date_create($current);
$interval = date_diff($datetime1, $datetime2);
echo $interval->format('%a days, %h hours %i minutes');
?>
</small>
<?php }; ?>

<?php if ($row['status'] != 'C'){ ?>
<small><b>Total&nbsp;Time</b>&nbsp;
<?php
$datestamp = $row['created_date'];
$current = Date('Y-m-d H:i:s');
$datetime1 = date_create($datestamp);
$datetime2 = date_create($current);
$interval = date_diff($datetime1, $datetime2);
echo $interval->format('%a days, %h hours %i minutes');
?>
</small>
<?php }; ?>

    </blockquote>
<div id="<?php echo "{$row['int1']}"; ?>" style="display:none">
<?php
    $id    = $row['int1'];
	$queryCMT  = "SELECT * FROM `comments` WHERE `module` = 'service' AND `id` = '$id' ORDER BY `created_date`";
	$resultCMT = mysqli_query($conn,$queryCMT);

	while($rowCMT = $resultCMT->fetch_array(MYSQLI_ASSOC))
	{
?>
<blockquote>
    <i class="fa fa-comment-o" aria-hidden="true"></i> <?php echo "{$rowCMT['comment']}"; ?>
    <?php if ($rowCMT['confcomments'] != ''){ ?><div style="color: red;"><i class="fa fa-comment-o" aria-hidden="true" style="color: red;"></i></label>  <?php echo "{$rowCMT['confcomments']}"; ?></div><?php }; ?>
    <br>
<?php
	$userid    = $rowCMT['userid'];
	$queryUSR  = "SELECT id, unit, unit2, last_name, first_name FROM users WHERE id = '$userid'";
	$resultUSR = mysqli_query($conn,$queryUSR);

	while($rowUSR = $resultUSR->fetch_array(MYSQLI_ASSOC))
	{
?>
    <blockquote>
        <small><b><?php echo "{$rowUSR['last_name']}"; ?>, <?php echo "{$rowUSR['first_name']}"; ?></a></b></small>
        <small><?php echo "{$rowUSR['unit']}"; ?><?php if ($rowUSR['unit2'] !== 'X'){ ?><?php echo "{$rowUSR['unit2']}"; ?><?php }; ?></small><br>
        <small>
            <b>
            <?php if ($rowCMT['status'] == 'O'){ ?>Open<?php }; ?>
            <?php if ($rowCMT['status'] == 'I'){ ?>In Progress<?php }; ?>
            <?php if ($rowCMT['status'] == 'B'){ ?>Awaiting Board<?php }; ?>
            <?php if ($rowCMT['status'] == '3'){ ?>Awaiting 3rd Party<?php }; ?>
            <?php if ($rowCMT['status'] == 'H'){ ?>On Hold<?php }; ?>
            <?php if ($rowCMT['status'] == 'C'){ ?>Closed<?php }; ?>
            </b>
            <?php echo "{$rowCMT['created_date']}"; ?>
        </small>
    </blockquote>
<?php
	}
?>
</blockquote>
<?php
	}
?>
</div>


<?php
    $id    = $row['int1'];
	$queryCMT  = "SELECT `id` FROM `comments` WHERE `module` = 'service' AND `id` = '$id' LIMIT 1";
	$resultCMT = mysqli_query($conn,$queryCMT);

	while($rowCMT = $resultCMT->fetch_array(MYSQLI_ASSOC))
	{
?>
<div style="float:left;"><input type="checkbox" name="<?php echo "{$row['int1']}"; ?>" onclick="showMe('<?php echo "{$row['int1']}"; ?>', this)" />&nbsp;Show&nbsp;Comments</div>
<?php
	}
?>

<div style="float:right;">
    <form name="AddComment" method="POST" action="service-comment.php">
        <input type="hidden" name="id" value="<?php echo "{$row['int1']}"; ?>">
        <input type="hidden" name="module" value="service">
        <input name="submit" value="Add Comment / Action" class="submit" type="submit">
    </form>
</div>

            </td>
            <td valign="top">
<?php echo "{$row['int1']}"; ?>
            </td>
            <td valign="top">
<?php
	$type    = $row['userid'];
	$query1  = "SELECT first_name, last_name, email, phone, unit, unit2 FROM users WHERE id = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?>
	<?php echo "{$row1['unit']}"; ?><?php if ($row1['unit2'] !== 'X'){ ?> <?php echo "{$row1['unit2']}"; ?><?php }; ?>
	<br><b><?php echo "{$row1['first_name']}"; ?> <?php echo "{$row1['last_name']}"; ?></b>
<?php
	}
?>
            </td>
            <td valign="top">
<?php echo "{$row['type']}"; ?>
            </td>
            <td valign="top">
<?php if ($row['assigned'] != '0'){ ?>
<?php
	$type    = $row['assigned'];
	$query1  = "SELECT first_name, last_name, email, phone, unit, unit2 FROM users WHERE id = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?>
	<b><?php echo "{$row1['first_name']}"; ?> <?php echo "{$row1['last_name']}"; ?></b>
<?php
	}
?>
<?php }; ?>
<?php if ($row['assigned'] == '0'){ ?>None<?php }; ?>
            </td>
            <td valign="top">
<?php if ($row['status'] == 'O'){ ?>Open<?php }; ?>
<?php if ($row['status'] == 'I'){ ?>In Progress<?php }; ?>
<?php if ($row['status'] == 'B'){ ?>Awaiting Board<?php }; ?>
<?php if ($row['status'] == '3'){ ?>Awaiting 3rd Party<?php }; ?>
<?php if ($row['status'] == 'H'){ ?>On Hold<?php }; ?>
<?php if ($row['status'] == 'C'){ ?>Closed<?php }; ?>
            </td>
            <td valign="top">
<?php if ($row['update_date'] == '0000-00-00 00:00:00'){ ?><b>New</b><?php }; ?>
<?php if ($row['update_date'] != '0000-00-00 00:00:00'){ ?><?php echo date('Y-m-d', strtotime($row['update_date'])); ?><?php }; ?>
            </td>
        </tr>
<!-- END DATABASE RESULTS -->
<?php
	}
?>
    </tbody>
</table>
<!-- END UNCOMPLETED -->
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Service Request Main Control Panel Page<br></div>
</body>
</html>
