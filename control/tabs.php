<?php $current_page = '8'; include('protect.php'); ?>
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
<big><i class="fa fa-stethoscope" aria-hidden="true"></i></big><strong>&nbsp;Health&nbsp;&nbsp;&nbsp;</strong>
<i class="fa fa-exclamation-triangle note" aria-hidden="true"></i> Are the permissions set for these items still valid?
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
    <div class="small-12 columns">
        <p>This control panel compiles the <b>permission settings from all modules, eForms, 3rd Party Links, and Custom Modules</b> into one location.</p>
    </div>
</div>
<div style="max-width: 99%;">
<!-- MODULE PERMISSIONS -->
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
    $module = "tabs.php";
	$query  = "SELECT * FROM tabs WHERE liaison = 'Y' AND `int1` BETWEEN '100' AND '325' AND `int1` != '295' ORDER BY `int1`";
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
<a name="forms"></a>
<br>
<div class="nav-section-header-cp">
    <strong>eForms</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
    <thead>
        <tr align="center" valign="middle">
            <th colspan="7"><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Contact your CondoSites Webmaster to have your eForm distribution email lists modified.</span></th>
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
    $module = "tabs.php#forms";
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
            <th colspan="6"><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">All automated emails generated from Database Submission eForms are sent to: <?php echo "{$CLASSIFIEDS_EMAIL}"; ?>.<br>Contact your CondoSites Webmaster to have this modified.</span></th>
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
    $module = "tabs.php#dsforms";
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
            <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Owner</small></b></div></th>
            <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Renter</small></b></div></th>
            <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Realtor</small></b></div></th>
        </tr>
    </thead>
    <tbody style="background-color:#ffffff">
<!-- DATABASE RESULTS -->
<?php
    $module = "tabs.php#customforms";
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
<a name="3rd Party Links"></a>
<br>
<div class="nav-section-header-cp">
    <strong>3rd Party Links</strong>
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
<!-- DATABASE RESULTS -->
<?php
	$module = "tabs.php#custommodules";
	$query  = "SELECT * FROM tabs WHERE liaison = 'Y' AND ((`int1` BETWEEN '1' AND '99') OR (`int1` BETWEEN '295' AND '299') OR (`int1` BETWEEN '335' AND '375') OR (`int1` BETWEEN '500' AND '699')) ORDER BY `int1`";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php include('tabs-modulelist.php'); ?>
<?php
	}
?>
    </tbody>
</table>
<a name="custommodules"></a>
	<br>
<!-- MODULE PERMISSIONS -->
<div class="nav-section-header-cp">
    <strong>Custom Module Permissions</strong>
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
	$module = "tabs.php";
	$query  = "SELECT * FROM tabs WHERE liaison = 'Y' AND `int1` BETWEEN '1000' AND '1999' ORDER BY `int1`";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
        <tr>
            <td>
                <div class="small-12 medium-12 large-8 columns">
                    <a href="<?php echo "{$row['url']}"; ?>" <?php if ($row['window'] !== '') { ?><?php echo "{$row['window']}"; ?><?php }; ?> <?php if ($row['window'] == '') { ?>target="_blank"<?php }; ?> onclick="javascript:pageTracker._trackPageview('ColumnLink/<?php echo "{$row['title']}"; ?>'); "><?php echo "{$row['image']}"; ?> <?php echo "{$row['title']}"; ?></a>
                    <?php if ($row['rednote'] !== ''){ ?><br><span class="note-red"><?php echo "{$row['rednote']}"; ?></span><?php }; ?>
                </div>
                <div class="small-6 medium-6 large-2 columns">
	                <form name="TabEdit" method="POST" action="custommodules-edit.php">
	                    <input type="hidden" name="action" value="edit">
	                    <input type="hidden" name="module" value="<?php echo "{$module}"; ?>">
	                    <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
	                    <input name="submit" value="Edit" class="submit" type="submit">
	                </form>
                </div>
                <div class="small-6 medium-6 large-2 columns">
					<?php if ($row['liaison'] == 'Y'){ ?>
					<form name="FoldersDelete" method="POST" action="custommodules.php" onclick="return confirm('Are you sure you want to delete the module: <?php echo "{$row['title']}"; ?>?');">
					<input type="hidden" name="action" value="delete">
					<input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
					<input name="submit" value="Delete" class="submit" type="submit">
					</form>
					<?php }; ?>
				</div>
            </td>
            <td><?php echo "{$row['int1']}"; ?></td>
            <td><span class="text"><?php echo "{$row['tabname']}"; ?></span></td>
            <td align="center" width="10" <?php if ($row['owner'] == 'X'){ ?>bgcolor="#ededed"<?php }; ?><?php if ($row['owner'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['owner'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php if ($row['owner'] !== 'X'){ ?><?php echo "{$row['owner']}"; ?><?php }; ?></td>
            <td align="center" width="10" <?php if ($row['lease'] == 'X'){ ?>bgcolor="#ededed"<?php }; ?><?php if ($row['lease'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['lease'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php if ($row['lease'] !== 'X'){ ?><?php echo "{$row['lease']}"; ?><?php }; ?></td>
            <td align="center" width="10" <?php if ($row['realtor'] == 'X'){ ?>bgcolor="#ededed"<?php }; ?><?php if ($row['realtor'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['realtor'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php if ($row['realtor'] !== 'X'){ ?><?php echo "{$row['realtor']}"; ?><?php }; ?></td>
            <td align="center" width="10" <?php if ($row['public'] == 'X'){ ?>bgcolor="#ededed"<?php }; ?><?php if ($row['public'] == 'N'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['public'] == 'Y'){ ?>bgcolor="#ccffcc"<?php }; ?><?php if ($row['public'] == 'H'){ ?>bgcolor="#caecec"<?php }; ?>><?php if ($row['public'] !== 'X'){ ?><?php echo "{$row['public']}"; ?><?php }; ?></td>
        </tr>
<?php
	}
?>
<!-- END TABS PERMISSION EDITS -->
    </tbody>
</table>
<a name="folders"></a>
<br>
<div class="nav-section-header-cp">
        <strong>Folders and Photo Galleries</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr align="left" valign="middle">
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Folder Name</small></th>
			<th width="50" class="table-sortable:numeric">&nbsp;&nbsp;&nbsp; <small>ID</small></th>
      <th class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <small>Nav Column Location</small></th>
      <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Owner</small></b></div></th>
      <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Renter</small></b></div></th>
      <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Realtor</small></b></div></th>
      <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Home</small></b></div></th>
    </tr>
  </thead>
  <tbody style="background-color:#ffffff">
<!-- DATABASE RESULTS -->
<?php
    $module = "tabs.php";
	$query  = "SELECT * FROM folders ORDER BY `int1`";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
    <tr>
      <td>
				<div class="small-12 medium-12 large-8 columns">
					<a href="<?php echo "{$row['link']}"; ?><?php echo "{$row['title']}"; ?>" <?php echo "{$row['options']}"; ?> target="_blank"><?php echo "{$row['image']}"; ?> <?php echo "{$row['title']}"; ?></a>
				</div>
				<div class="small-6 medium-6 large-2 columns">
					<form name="FoldersEdit" method="POST" action="folders-edit.php">
					<input type="hidden" name="action" value="edit">
					<input type="hidden" name="module" value="<?php echo "{$module}"; ?>">
					<input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
					<input name="submit" value="Edit" class="submit" type="submit">
					</form>
				</div>
				<div class="small-6 medium-6 large-2 columns">
					<?php if ($row['liaison'] == 'Y'){ ?>
					<form name="FoldersDelete" method="POST" action="folders.php" onclick="return confirm('Are you sure you want to delete the folder: <?php echo "{$row['title']}"; ?>?');">
					<input type="hidden" name="action" value="delete">
					<input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
					<input name="submit" value="Delete" class="submit" type="submit">
					</form>
					<?php }; ?>
				</div>
			</td>
      <td><?php echo "{$row['int1']}"; ?></td>
			<td><?php echo "{$row['tabname']}"; ?></td>
			<td align="center" width="10" <?php if ($row['owner'] == 'X'){ ?>bgcolor="#ededed"<?php }; ?><?php if ($row['owner'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['owner'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php if ($row['owner'] !== 'X'){ ?><?php echo "{$row['owner']}"; ?><?php }; ?></td>
			<td align="center" width="10" <?php if ($row['lease'] == 'X'){ ?>bgcolor="#ededed"<?php }; ?><?php if ($row['lease'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['lease'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php if ($row['lease'] !== 'X'){ ?><?php echo "{$row['lease']}"; ?><?php }; ?></td>
			<td align="center" width="10" <?php if ($row['realtor'] == 'X'){ ?>bgcolor="#ededed"<?php }; ?><?php if ($row['realtor'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['realtor'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php if ($row['realtor'] !== 'X'){ ?><?php echo "{$row['realtor']}"; ?><?php }; ?></td>
			<td align="center" width="10" <?php if ($row['public'] == 'X'){ ?>bgcolor="#ededed"<?php }; ?><?php if ($row['public'] == 'N'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['public'] == 'Y'){ ?>bgcolor="#ccffcc"<?php }; ?><?php if ($row['public'] == 'H'){ ?>bgcolor="#caecec"<?php }; ?>><?php if ($row['public'] !== 'X'){ ?><?php echo "{$row['public']}"; ?><?php }; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
  </tbody>
</table>
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Master Permissions Control Panel Page<br></div>
</body>
</html>
