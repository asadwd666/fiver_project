<?php $current_page = '23'; include('protect.php'); ?>
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">
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
        <p>This is where you can control which control panel groups (Board, Concierge/Staff, and Full Administrator) have access to which control panels.</p>
    </div>
    <div class="small-12 medium-6 columns">
        <p>
            <i class="fa fa-hand-o-right" aria-hidden="true"></i>  Not all control panels are appropriate for all groups!<br>
            <i class="fa fa-hand-o-right" aria-hidden="true"></i>  Some control panel edits are restricted to CondoSites Webmasters only.
        </p>
    </div>
</div>
<!-- UPLOAD FORM -->
<div style="max-width: 99%;">
<!-- MODULE PERMISSIONS -->
<div class="nav-section-header-cp">
    <strong>Control Panel Groups</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
    <thead>
        <tr align="left">
            <th align="left" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <b><small>Name</small></b></th>
            <th align="left" class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <b><small>Group</small></b></th>
            <th align="center" width="10" class="rotate90"><b><small>Board</small></b></th>
            <th align="center" width="10" class="rotate90"><b><small>Staff</small></b></th>
            <th align="center" width="10" class="rotate90"><b><small>Admin</small></b></th>
<?php if ($_SESSION['webmaster'] == true){ ?>
            <th align="center" width="10" class="rotate90"><b><small>Wmstr</small></b></th>
<?php }; ?>
        </tr>
    </thead>
    <tbody style="background-color:#ffffff">

<!-- CONTROL PANEL -->
<?php if ($_SESSION['webmaster'] == true){ ?>
<?php
	$query  = "SELECT * FROM `controlpanels` WHERE `webmaster` != '2' ORDER BY `name`";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
        <tr>
            <td>
                <div class="small-12 medium-12 large-8 columns">
                    <?php echo "{$row['name']}"; ?>
                </div>
                <div class="small-12 medium-12 large-4 columns" align="right">
<?php if ($_SESSION['webmaster'] != true){ ?>
    <?php if ($row['board'] !== '2' OR $row['concierge'] !== '2' OR $row['liaison'] !== '2'){ ?>
                	<form name="ControlPanelEdit" method="POST" action="cpgroups-edit.php">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
                        <input name="submit" value="Edit" class="submit" type="submit">
                    </form>
    <?php }; ?>
<?php }; ?>
<?php if ($_SESSION['webmaster'] != true AND ($row['board'] == '2' AND $row['concierge'] == '2' AND $row['liaison'] == '2')){ ?>
    <i>Webmaster access only.</i>
<?php }; ?>
<?php if ($_SESSION['webmaster'] == true){ ?>
                	<form name="ControlPanelEdit" method="POST" action="cpgroups-edit.php">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
                        <input name="submit" value="Edit" class="submit" type="submit">
                    </form>
<?php }; ?>
                </div>
            </td>
            <td>
	<?php if ($row['cat'] == 'A'){ ?>Advanced<?php }; ?>
	<?php if ($row['cat'] == 'C'){ ?>Communications<?php }; ?>
	<?php if ($row['cat'] == 'F'){ ?>Features & Modules<?php }; ?>
	<?php if ($row['cat'] == 'H'){ ?>Help & How To<?php }; ?>
            </td>
            <td align="center" <?php if ($row['board'] == '2'){ ?>bgcolor="#ededed"<?php }; ?><?php if ($row['board'] !== '1'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['board'] !== '0'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php if ($row['board'] == '1'){ ?>Y<?php }; ?><?php if ($row['board'] == '0'){ ?>N<?php }; ?></td>
            <td align="center" <?php if ($row['concierge'] == '2'){ ?>bgcolor="#ededed"<?php }; ?><?php if ($row['concierge'] !== '1'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['concierge'] !== '0'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php if ($row['concierge'] == '1'){ ?>Y<?php }; ?><?php if ($row['concierge'] == '0'){ ?>N<?php }; ?></td>
            <td align="center" <?php if ($row['liaison'] == '2'){ ?>bgcolor="#ededed"<?php }; ?><?php if ($row['liaison'] !== '1'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['liaison'] !== '0'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php if ($row['liaison'] == '1'){ ?>Y<?php }; ?><?php if ($row['liaison'] == '0'){ ?>N<?php }; ?></td>
<?php if ($_SESSION['webmaster'] == true){ ?>
            <td align="center" <?php if ($row['webmaster'] == '2'){ ?>bgcolor="#ededed"<?php }; ?><?php if ($row['webmaster'] !== '1'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['webmaster'] !== '0'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php if ($row['webmaster'] == '1'){ ?>Y<?php }; ?><?php if ($row['webmaster'] == '0'){ ?>N<?php }; ?></td>
<?php }; ?>
        </tr>
<?php }; ?>
<?php }; ?>
<!-- END CONTROL PANEL -->

<!-- CONTROL PANEL -->
<?php if ($_SESSION['webmaster'] != true){ ?>
<?php
	$query  = "SELECT * FROM `controlpanels` WHERE `liaison` != '2' ORDER BY `name`";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
        <tr>
            <td>
                <div class="small-12 medium-12 large-8 columns">
                    <?php echo "{$row['name']}"; ?>
                </div>
                <div class="small-12 medium-12 large-4 columns" align="right">
<?php if ($_SESSION['webmaster'] != true){ ?>
    <?php if ($row['board'] !== '2' OR $row['concierge'] !== '2' OR $row['liaison'] !== '2'){ ?>
                	<form name="ControlPanelEdit" method="POST" action="cpgroups-edit.php">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
                        <input name="submit" value="Edit" class="submit" type="submit">
                    </form>
    <?php }; ?>
<?php }; ?>
<?php if ($_SESSION['webmaster'] != true AND ($row['board'] == '2' AND $row['concierge'] == '2' AND $row['liaison'] == '2')){ ?>
    <i>Webmaster access only.</i>
<?php }; ?>
<?php if ($_SESSION['webmaster'] == true){ ?>
                	<form name="ControlPanelEdit" method="POST" action="cpgroups-edit.php">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
                        <input name="submit" value="Edit" class="submit" type="submit">
                    </form>
<?php }; ?>
                </div>
            </td>
            <td>
	<?php if ($row['cat'] == 'A'){ ?>Advanced<?php }; ?>
	<?php if ($row['cat'] == 'C'){ ?>Communications<?php }; ?>
	<?php if ($row['cat'] == 'F'){ ?>Features & Modules<?php }; ?>
	<?php if ($row['cat'] == 'H'){ ?>Help & How To<?php }; ?>
            </td>
            <td align="center" <?php if ($row['board'] == '2'){ ?>bgcolor="#ededed"<?php }; ?><?php if ($row['board'] !== '1'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['board'] !== '0'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php if ($row['board'] == '1'){ ?>Y<?php }; ?><?php if ($row['board'] == '0'){ ?>N<?php }; ?></td>
            <td align="center" <?php if ($row['concierge'] == '2'){ ?>bgcolor="#ededed"<?php }; ?><?php if ($row['concierge'] !== '1'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['concierge'] !== '0'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php if ($row['concierge'] == '1'){ ?>Y<?php }; ?><?php if ($row['concierge'] == '0'){ ?>N<?php }; ?></td>
            <td align="center" <?php if ($row['liaison'] == '2'){ ?>bgcolor="#ededed"<?php }; ?><?php if ($row['liaison'] !== '1'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['liaison'] !== '0'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php if ($row['liaison'] == '1'){ ?>Y<?php }; ?><?php if ($row['liaison'] == '0'){ ?>N<?php }; ?></td>
<?php if ($_SESSION['webmaster'] == true){ ?>
            <td align="center" <?php if ($row['webmaster'] == '2'){ ?>bgcolor="#ededed"<?php }; ?><?php if ($row['webmaster'] !== '1'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['webmaster'] !== '0'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php if ($row['webmaster'] == '1'){ ?>Y<?php }; ?><?php if ($row['webmaster'] == '0'){ ?>N<?php }; ?></td>
<?php }; ?>
        </tr>
<?php }; ?>
<?php }; ?>
<!-- END CONTROL PANEL -->

    </tbody>
</table>
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Control Panel Groups Control Panel Page<br></div>
</body>
</html>