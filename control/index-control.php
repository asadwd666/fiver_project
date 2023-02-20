<?php require('../my-documents/php7-my-db.php'); ?>
<?php include('../control/cp-head-access.php'); ?>
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<!--[if IE]><meta http-equiv="refresh" content="0;url=IE.html" /><![endif]-->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="CondoSites - http://www.condosites.com" name="author">
<title>Control Panel</title>
<?php include('../control/cp-head-scripts.php'); ?>
</head>
<body>
<!-- LOGO AND NAVIGATION -->
<?php include('cp-navigation.php'); ?>
<!-- END LOGO AND NAVIGATION -->

<!-- BILLING CHECK -->
<?php include('../control/billing-check.php'); ?>
<!-- END BILLING CHECK -->


<!-- HEALTH BAR -->
<?php include('../control/health.php'); ?>
<!-- END HEALTH BAR -->

<!-- ******************************************** -->
<!-- ALERT BAR -->

<?php include('construction.php'); ?>

<!-- END ALERT BAR -->
<!-- ******************************************** -->

<br>

    <div class="small-12 medium-9 large-10 columns">
      <div class="content-controlpanel-main">

<!-- COMMUNICATIONS -->
<?php
	$query  = "SELECT `id`, name, url, icon FROM controlpanels WHERE $access = '1' AND cat = 'C' OR cat = 'D' LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
        <div class="nav-section-header-cp">
          <strong>Documents and Communications</strong>
        </div>
<?php
	}
?>
        <div class="nav-section-body-cp" align="center">
          <div class="row">
<?php
	$query  = "SELECT `id`, name, url, icon FROM controlpanels WHERE $access = '1' AND cat = 'C' ORDER BY name";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
          <div class="cp-icons" align="center" style="float: left;">
<?php include('cp-icon.php'); ?>
          </div>
<?php
	}
?>
<?php
	$query  = "SELECT `id`, name, url, icon FROM controlpanels WHERE $access = '1' AND cat = 'D' ORDER BY name";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
          <div class="cp-icons" align="center" style="float: left;">
<?php include('cp-icon.php'); ?>
          </div>
<?php
	}
?>
          </div>
        </div>

<!-- END COMMUNICATIONS -->

<!-- FEATURES & MODULES -->
<?php
	$query  = "SELECT `id`, name, url, icon FROM controlpanels WHERE $access = '1' AND cat = 'F' LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
        <div class="nav-section-header-cp">
          <strong>Website Features and Modules</strong>
        </div>
<?php
	}
?>
        <div class="nav-section-body-cp">
          <div class="row">
<?php
	$query  = "SELECT `id`, name, url, icon FROM controlpanels WHERE $access = '1' AND cat = 'F' ORDER BY name";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
          <div class="cp-icons" align="center" style="float: left;">
<?php include('cp-icon.php'); ?>
          </div>
<?php
	}
?>
          </div>
        </div>
<!-- END FEATURES & MODULES -->

<!-- ACCESS & ADVANCED -->
<?php
	$query  = "SELECT `id`, name, url, icon FROM controlpanels WHERE $access = '1' AND cat = 'A' LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
        <div class="nav-section-header-cp">
          <strong>User Access and Advanced Settings</strong>
        </div>
<?php
	}
?>
        <div class="nav-section-body-cp">
          <div class="row">
<?php
	$query  = "SELECT `id`, name, url, icon FROM controlpanels WHERE $access = '1' AND cat = 'A' ORDER BY name";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
          <div class="cp-icons" align="center" style="float: left;">
<?php include('cp-icon.php'); ?>
          </div>
<?php
	}
?>
          </div>
        </div>
<!-- END ACCESS & ADVANCED -->

        </div>
      </div>
<!-- HELP -->
      <div class="small-12 medium-3 large-2 columns">
        <div class="content-controlpanel-main">
<?php
	$query  = "SELECT `id`, name, url, icon FROM controlpanels WHERE $access = '1' AND cat = 'H' LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
        <div class="nav-section-header-help-cp">
          <strong><big><i class="fa fa-hand-o-right" aria-hidden="true"></i></big> Help</strong>
        </div>
<?php
	}
?>
        <div class="nav-section-body-help-cp">
          <div class="row">
<?php
	$query  = "SELECT `id`, name, url, icon FROM controlpanels WHERE $access = '1' AND cat = 'H' ORDER BY name";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
            <div class="cp-icons-help" align="center">
<?php include('cp-icon.php'); ?>
            </div>
<?php
	}
?>
          <div>
        </div>
      </div>
    </div>
<!-- END HELP -->
<br>
<!-- BILLING -->
<?php include('cp-billing.php'); ?>
<!-- END BILLING -->
      </div>
    </div>
  </div>
<br>
      </div>
    </div>

<div class="small-12 medium-12 large-12 columns note-black"><br><br><?php print ucfirst($access); ?> Control Panel Page<br></div>
</body>
</html>