<?php $current_page = '33'; include('protect.php'); ?>
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
&nbsp;
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
    <div class="small-12 medium-12 medium-12 columns">
        <p>Alert text appears in the form of a yellow banner at the top of the Home Page and Login Pages.  This text typically appears only when a site is under construction or undergoing maintenance.</p>
    </div>
</div>
<div style="max-width: 99%;">
<?php
	$showonpage = $_POST["showonpage"];
	$line1 = htmlspecialchars($_POST['line1'], ENT_QUOTES);
	$line2 = htmlspecialchars($_POST['line2'], ENT_QUOTES);
	$pod = $_POST["pod"];
	$eod = $_POST["eod"];

if ($line1 != null){
	$query = "UPDATE `alert` SET pod='$pod', eod='$eod', showonpage='$showonpage', line1='$line1', line2='$line2'";
	mysqli_query($conn,$query) or die('Error, update query failed');

	$useripaddress = $_SERVER['REMOTE_ADDR'];
	$userid = $_SESSION['id'];
	$query = "INSERT INTO log (action, tablename, useripaddress, userid) VALUES ('E', 'Alert Notice', '$useripaddress', '$userid')";
	mysqli_query($conn,$query) or die('Error, updating log failed');

	$query = "OPTIMIZE TABLE `alert`";
	mysqli_query($conn,$query) or die('Error, optimize query failed');

}

?>
<!-- INPUT FORM -->
<?php
	$query  = "SELECT * FROM `alert`";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<div class="nav-section-header-cp">
        <strong>Edit the Alert Notice Text</strong>
</div>
<div class="cp-form-container">
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 10px 0px;">
<form enctype="multipart/form-data" method="POST" action="alert.php">
            <div class="small-12 medium-12 columns"><strong>1) What do you want to say?</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-3 columns"><label for="line1" class="middle"><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">250 Characters Max</span></label></div>
            <div class="small-12 medium-9 end columns"><input name="line1" maxlength="250" class="form" type="text" value="<?php echo "{$row['line1']}"; ?>" placeholder="<?php echo "{$row['line1']}"; ?>" required autofocus></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-3 columns"><label for="line2" class="middle"><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">250 Characters Max</span></label></div>
            <div class="small-12 medium-9 end columns"><input name="line2" maxlength="250" class="form" type="text" value="<?php echo "{$row['line2']}"; ?>" placeholder="<?php echo "{$row['line2']}"; ?>"></div>
        </div>
    </div>
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>2) Should this content be shown now?</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-6 columns"><label for="showonpage" class="middle">Show on <b>Home and Login</b> pages?</label></div>
            <div class="small-12 medium-2 end columns" style="padding-right: 15px;">
<select name="showonpage" class="form">
<option value="1" <?php if($row['showonpage'] == "1"){ echo("SELECTED"); } ?>>Yes</option>
<option value="0" <?php if($row['showonpage'] == "0"){ echo("SELECTED"); } ?>>No</option>
</select>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-6 columns"><label for="pod" class="middle">When should this alert appear?</label></div>
            <div class="small-12 medium-6 end columns"><input name="pod" class="form datepicker" type="date" value="<?php echo "{$row['pod']}"; ?>" required></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-6 columns"><label for="eod" class="middle">When should this alert expire?</label></div>
            <div class="small-12 medium-6 end columns"><input name="eod" class="form datepicker" type="date" value="<?php echo "{$row['eod']}"; ?>" required></div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>3) Ready to Save?</strong></div>
        </div>
        <div class="row medium-collapse">
            <div class="small-6 columns" align="center">
<input type="submit" name="submit" value="Save Changes">
            </div>
</form>
            <div class="small-6 end columns" align="center">
<form action="index.php" method="get">
<input type="submit" value="Cancel and Go Back" onclick="return confirm('Are you sure you wish to leave this page? Unsaved changes will be lost.');">
</form>
            </div>
        </div>
    </div>
</div>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
  </tbody>
</table>
</div>
<br>
<!-- SAMPLE -->
<?php include('../splash/construction.php'); ?>
<!-- END SAMPLE -->
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Alert Notice Control Panel Page<br></div>
</body>
</html>
