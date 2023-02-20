<?php $current_page = '7'; include('protect.php'); ?>
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
<?php $sqlMTG = mysqli_query($conn,"SELECT count(*) FROM meetingbox WHERE created_date BETWEEN NOW() - INTERVAL 1000 DAY AND NOW() - INTERVAL 60 DAY") or die(mysqli_error($conn));
//$countMTG = mysql_result($sqlMTG, "0");
$row = mysqli_fetch_row($sqlMTG);
$countMTG = $row[0];
?>
<?php if ($countMTG == '1'){ ?><i class="fa fa-exclamation-triangle note" aria-hidden="true"></i> You have not updated this content in over than 60 days!<?php }; ?>
<?php if ($countMTG == '0'){ ?><i class="fa fa-check" aria-hidden="true"></i> The Newsboard Banner was updated in the last 30 days!<?php }; ?>
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
    <div class="small-12 medium-9 columns">
        <p>The <b>Newsboard Banner</b> appears at the top of the Newsboard - which is the column that appears on the right side of the main page (post login). It is a great location to display a short important message such as an important meeting date, or a notice of an unscheduled water shutoff.</p>
    </div>
</div>
<div style="max-width: 99%;">
<?php
	$line1 = htmlspecialchars($_POST['line1'], ENT_QUOTES);
	$line2 = htmlspecialchars($_POST['line2'], ENT_QUOTES);
	$line3 = htmlspecialchars($_POST['line3'], ENT_QUOTES);
	$docid = $_POST["docid"];
	$calid = $_POST["calid"];
	$owner = $_POST["owner"];
	$realtor = $_POST["realtor"];
	$lease = $_POST["lease"];
	$digitaldisplay = $_POST["digitaldisplay"];
	$url = htmlspecialchars($_POST['url'], ENT_QUOTES);
	$email = htmlspecialchars($_POST['email'], ENT_QUOTES);
    $created_date = date("Y-m-d H:i:s");

if ($line1 != null){

	$query = "UPDATE meetingbox SET url='$url', email='$email', line1='$line1', line2='$line2', line3='$line3', docid='$docid', calid='$calid', owner='$owner', realtor='$realtor', lease='$lease', digitaldisplay='$digitaldisplay', created_date='$created_date'";
	$result = mysqli_query($conn,$query) or die('Error, insert query failed');

			$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>The Newsboard Banner was updated successfully.</strong></div>";

	$date = date("F j, Y");
	$query = "UPDATE updatedate SET date='$date'";
	mysqli_query($conn,$query) or die('Error, updating update date failed');

	$useripaddress = $_SERVER['REMOTE_ADDR'];
	$userid = $_SESSION['id'];
	$query = "INSERT INTO log (action, tablename, useripaddress, userid) VALUES ('E', 'Meeting Box', '$useripaddress', '$userid')";
	mysqli_query($conn,$query) or die('Error, updating log failed');

	$query = "OPTIMIZE TABLE `meetingbox`";
	mysqli_query($conn,$query) or die('Error, optimize query failed');

}

?>
<!-- INPUT FORM -->
<?php
	$query  = "SELECT * FROM meetingbox";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<div class="nav-section-header-cp">
        <strong>Edit the Newsboard Banner</strong>
</div>
<?php echo($errorSUCCESS); ?>
<div class="cp-form-container">
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 10px 0px;">
<form enctype="multipart/form-data" method="POST" action="meetingbox.php">
            <div class="small-12 medium-12 columns"><strong>1) What do you want to say?</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-3 columns"><label for="line1" class="middle"><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">75 Characters Max</span></label></div>
            <div class="small-12 medium-9 end columns"><input name="line1" maxlength="75" class="form" type="text" value="<?php echo "{$row['line1']}"; ?>" placeholder="<?php echo "{$row['line1']}"; ?>" required autofocus></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-3 columns"><label for="line2" class="middle"><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">100 Characters Max</span></label></div>
            <div class="small-12 medium-9 end columns"><input name="line2" maxlength="100" class="form" type="text" value="<?php echo "{$row['line2']}"; ?>" placeholder="<?php echo "{$row['line2']}"; ?>"></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-3 columns"><label for="line3" class="middle"><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">100 Characters Max</span></label></div>
            <div class="small-12 medium-9 end columns"><input name="line3" maxlength="100" class="form" type="text" value="<?php echo "{$row['line3']}"; ?>" placeholder="<?php echo "{$row['line3']}"; ?>"></div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>2) Links...</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="url" class="middle">Add a link to a website?<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Be sure your link starts with http://</span></label></div>
            <div class="small-12 medium-7 end columns"><input name="url" maxlength="100" class="form" type="url" placeholder="Be sure your link starts with http://" value="<?php echo "{$row['url']}"; ?>"></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="email" class="middle">Add an email address?</label></div>
            <div class="small-12 medium-7 end columns"><input name="email" maxlength="100" class="form" type="email" placeholder="mabell@att.com" value="<?php echo "{$row['email']}"; ?>"></div>
        </div>
    </div>
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>3) Supplemental Content?</strong></div>
        </div>
<?php include('docid-field-edit.php'); ?>
<?php include('calid-field-edit.php'); ?>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>4) Who should have access to this information?</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 columns"><label for="owner" class="middle"><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">If you are not using this feature, set all permissions to "No".</span></label></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="owner" class="middle">Show in <b>Owner</b> Section? </label></div>
            <div class="small-12 medium-2 end columns" style="padding-right: 15px;">
<select name="owner" class="form">
<option value="Y" <?php if($row['owner'] == "Y"){ echo("SELECTED"); } ?>>Yes</option>
<option value="N" <?php if($row['owner'] == "N"){ echo("SELECTED"); } ?>>No</option>
</select>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="lease" class="middle">Show in <b>Renter</b> Section? </label></div>
            <div class="small-12 medium-2 end columns" style="padding-right: 15px;">
<select name="lease" class="form">
<option value="N" <?php if($row['lease'] == "N"){ echo("SELECTED"); } ?>>No</option>
<option value="Y" <?php if($row['lease'] == "Y"){ echo("SELECTED"); } ?>>Yes</option>
</select>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="realtor" class="middle">Show in <b>Realtor</b> Section? </label></div>
            <div class="small-12 medium-2 end columns" style="padding-right: 15px;">
<select name="realtor" class="form">
<option value="N" <?php if($row['realtor'] == "N"){ echo("SELECTED"); } ?>>No</option>
<option value="Y" <?php if($row['realtor'] == "Y"){ echo("SELECTED"); } ?>>Yes</option>
</select>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="realtor" class="middle">Show <a href="http://condosites.com/digitalsignage.php" target="_blank"><b>Digital Information Display</b></a>? </label></div>
            <div class="small-12 medium-2 end columns" style="padding-right: 15px;">
<select name="digitaldisplay" class="form">
<option value="Y" <?php if($row['digitaldisplay'] == "Y"){ echo("SELECTED"); } ?>>Yes</option>
<option value="N" <?php if($row['digitaldisplay'] == "N"){ echo("SELECTED"); } ?>>No</option>
</select>
            </div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>5) Ready to Save?</strong></div>
        </div>
        <div class="row medium-collapse">
            <div class="small-6 columns" align="center">
<input type="submit" name="submit" value="Save Changes">
            </div>
</form>
            <div class="small-6 end columns" align="center">
<form action="index-control.php" method="get">
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
<br>
<!-- SAMPLE -->
    <div class="row">
        <div class="small-1 medium-2 large-2 columns">&nbsp;</div>
        <div class="small-10 medium-8 large-8 columns">
<?php include('../access/owner/newsboard-banner.php'); ?>
        </div>
        <div class="small-1 medium-2 large-2 columns">&nbsp;</div>
    </div>
<!-- END SAMPLE -->
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Newsboard Banner Control Panel Page<br></div>
</body>
</html>
