<?php $current_page = '32'; include('protect.php'); ?>
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
<big><i class="fa fa-stethoscope" aria-hidden="true"></i></big><strong>&nbsp;Health&nbsp;&nbsp;&nbsp;</strong>
<i class="fa fa-exclamation-triangle note" aria-hidden="true"></i> Does this information need to be updated?
        </div>
    </div>
    <div class="large-4 columns" style="padding: 0px">
        <div class="nav-section-header-help-cp" align="center">
            <strong><big><i class="fa fa-hand-o-right" aria-hidden="true"></i></big>&nbsp;Hands&nbsp;point&nbsp;to&nbsp;tips!</strong>
        </div>
    </div>
</div>
<?php
$int1 = $_POST["int1"]; 
$action = $_POST["action"];
?>
<!-- HEALTH AND HELP -->
<br>&nbsp;

<div class="row cp-help">
    <div class="small-12 medium-5 columns">
        <p>This is where you edit the text that appears on your Home Page. Most communities use this area to describe the community, it&apos;s location, features, and amenities.</p>
    </div>
    <div class="small-12 medium-7 columns">
        <p>
            <i class="fa fa-hand-o-right" aria-hidden="true"></i> Need ideas? <a href="http://condosites.com/communitiesweserve.php" target="_blank">Have a look at the websites of some of the communities we serve</a>.<br>
            <i class="fa fa-hand-o-right" aria-hidden="true"></i> Documents and Photos, Folders, Modules, and 3rd Party Links can be added, edited, and removed from their respective control panels.
        </p>
    </div>
</div>

<div style="max-width: 99%;">

<div class="nav-section-header-cp">
        <strong>Home Page Text</strong>
</div>
<table style="background-color:#eeeddd" align="center" border="0" cellpadding="5" cellspacing="1" width="95%" class="text table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr align="left">
      <th><b><small>Content</small></b></th>
    </tr>
  </thead>
  <tbody style="background-color:#ffffff">
<!-- DATABASE RESULTS -->
<?php
    $module = "hometext.php";
	$query  = "SELECT `int1`, `type`, `theircode`, `extra1`, `iframe` FROM 3rd WHERE liaison = 'Y' AND `type` = 'Splash' ORDER BY `int1`";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
    <tr>
      <td>
        <form name="3rdEdit" method="POST" action="3rd-edit.php">
          <input type="hidden" name="action" value="edit">
          <input type="hidden" name="module" value="<?php echo "{$module}"; ?>">
          <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
          <input name="submit" value="Edit" class="submit" type="submit">
        </form><br>
        <?php echo "{$row['theircode']}"; ?>
        <br>
        <?php echo "{$row['extra1']}"; ?>
        <br>
        <?php echo "{$row['iframe']}"; ?>
      </td>
    </tr>
<?php
	}
?>
<?php
    $module = "hometext.php";
	$query  = "SELECT `int1`, `type`, `theircode`, `extra1`, `iframe` FROM 3rd WHERE liaison = 'N' AND `type` = 'Splash' ORDER BY `int1`";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
    <tr>
      <td>
        <span class="note-red"><b>Your CondoSites Webmaster has applied custom styles on the back end which will break if edited via the text editor.</b><br>
        If you need to have this content edited, please contact your CondoSites Webmaster.</span>
        <div style="margin: 50px;">
        <?php echo "{$row['theircode']}"; ?>
        <br>
        <?php echo "{$row['extra1']}"; ?>
        <br>
        <?php echo "{$row['iframe']}"; ?>
        </div>
      </td>
    </tr>
<?php
	}
?>
  </tbody>
</table>
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Custom Modules Control Panel Page<br></div>
</body>
</html>