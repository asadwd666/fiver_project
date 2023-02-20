<?php $current_page = '23'; include('protect.php'); $id = $_POST["id"]; $action = $_POST["action"]; if ($action == "save"){

		$webmaster = $_POST["webmaster"];
		$liaison = $_POST["liaison"];
		$concierge = $_POST["concierge"];
		$board = $_POST["board"];

		$query = "UPDATE `controlpanels` SET webmaster='$webmaster', liaison='$liaison', concierge='$concierge', board='$board' WHERE `id`='$id' LIMIT 1";
		mysqli_query($conn,$query) or die('Error, update query failed');

		$date = date("F j, Y");
		$query = "UPDATE updatedate SET date='$date'";
		mysqli_query($conn,$query) or die('Error, updating update date failed');

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['int1'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('E', 'Control Panels', '$useripaddress', '$userid', '$id')";
		mysqli_query($conn,$query) or die('Error, updating log failed');

		header('Location: cpgroups.php');
	}

?>
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
<br>
<div style="max-width: 99%;">
<!-- INPUT FORM -->
<?php
	$query  = "SELECT `name`, `webmaster`, `liaison`, `board`, `concierge` FROM `controlpanels` WHERE `id`='$id' LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- UPLOAD FORM -->
<div class="nav-section-header-cp">
        <strong>Edit the <?php echo "{$row['name']}"; ?> control panel permissions</strong>
</div>
<div class="cp-form-container">
<!-- COLUMN 1 -->
    <div class="small-12 medium-12 large-6 columns">
			<div class="row" style="padding: 10px 10px 10px 0px;">
<form enctype="multipart/form-data" method="POST" action="cpgroups-edit.php">
					<div class="small-12 medium-12 columns"><strong>1) Who should have access to the <u><?php echo "{$row['name']}"; ?></u> control panel?</strong></div>
			</div>
<?php if ($row['board'] !== '2'){ ?>
			<div class="row medium-collapse" style="padding-left: 30px;">
					<div class="small-12 medium-10 columns"><label for="board" class="middle">Show on <b>Board</b> Control Panels? </label></div>
					<div class="small-12 medium-2 end columns" style="padding-right: 15px;">
						<select name="board">
						<option value="1" <?php if($row['board'] == "1"){ echo("SELECTED"); } ?>>Yes</option>
						<option value="0" <?php if($row['board'] == "0"){ echo("SELECTED"); } ?>>No</option>
						</select>
					</div>
			</div>
<?php }; ?>
<?php if ($row['concierge'] !== '2'){ ?>
			<div class="row medium-collapse" style="padding-left: 30px;">
					<div class="small-12 medium-10 columns"><label for="concierge" class="middle">Show on <b>Staff</b> Control Panels? </label></div>
					<div class="small-12 medium-2 end columns" style="padding-right: 15px;">
						<select name="concierge">
						<option value="1" <?php if($row['concierge'] == "1"){ echo("SELECTED"); } ?>>Yes</option>
						<option value="0" <?php if($row['concierge'] == "0"){ echo("SELECTED"); } ?>>No</option>
						</select>
					</div>
			</div>
<?php }; ?>
<?php if ($row['liaison'] !== '2'){ ?>
			<div class="row medium-collapse" style="padding-left: 30px;">
					<div class="small-12 medium-10 columns"><label for="liaison" class="middle">Show on <b>Full Administrator</b> Control Panels? </label></div>
					<div class="small-12 medium-2 end columns" style="padding-right: 15px;">
						<select name="liaison">
						<option value="1" <?php if($row['liaison'] == "1"){ echo("SELECTED"); } ?>>Yes</option>
						<option value="0" <?php if($row['liaison'] == "0"){ echo("SELECTED"); } ?>>No</option>
						</select>
					</div>
			</div>
<?php }; ?>
<?php if ($_SESSION['webmaster'] == true){ ?>
<?php if ($row['webmaster'] !== '2'){ ?>
			<div class="row medium-collapse" style="padding-left: 30px;">
					<div class="small-12 medium-10 columns"><label for="webmaster" class="middle">Show on <b>Webmaster</b> Control Panels? </label></div>
					<div class="small-12 medium-2 end columns" style="padding-right: 15px;">
						<select name="webmaster">
						<option value="1" <?php if($row['webmaster'] == "1"){ echo("SELECTED"); } ?>>Yes</option>
						<option value="0" <?php if($row['webmaster'] == "0"){ echo("SELECTED"); } ?>>No</option>
						</select>
					</div>
			</div>
<?php }; ?>
<?php }; ?>
<?php if ($_SESSION['webmaster'] !== true){ ?>
    <?php if ($row['webmaster'] !== '2'){ ?><input name="webmaster" type="hidden" class="form" id="webmaster" value="<?php echo "{$row['webmaster']}"; ?>"><?php }; ?>
<?php }; ?>
    </div>
<!-- END COLUMN 1 -->
<!-- COLUMN 2 -->
    <div class="small-12 medium-12 large-6 columns">
				<div class="row" style="padding: 10px 10px 10px 0px;">
					<div class="small-12 medium-12 columns"><strong>2) Ready to Save?</strong></div>
				</div>
				<div class="row medium-collapse">
					<div class="small-6 columns" align="center">
						<?php if ($row['board'] == '2'){ ?><input name="board" type="hidden" class="form" id="board" size="1" value="<?php echo "{$row['board']}"; ?>"><?php }; ?>
			      <?php if ($row['concierge'] == '2'){ ?><input name="concierge" type="hidden" class="form" id="concierge" size="1" value="<?php echo "{$row['concierge']}"; ?>"><?php }; ?>
			      <?php if ($row['liaison'] == '2'){ ?><input name="liaison" type="hidden" class="form" id="liaison" size="1" value="<?php echo "{$row['liaison']}"; ?>"><?php }; ?>
			      <?php if ($row['webmaster'] == '2'){ ?><input name="webmaster" type="hidden" class="form" id="webmaster" size="1" value="<?php echo "{$row['webmaster']}"; ?>"><?php }; ?>
			      	<input type="hidden" name="action" value="save">
			      	<input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
			      	<input name="submit" value="Save" class="submit" type="submit">
</form>
					</div>
        	<div class="small-6 end columns" align="center">
						<form action="cpgroups.php" method="get">
						<input type="submit" value="Cancel" onclick="return confirm('Are you sure you wish to leave this page? Unsaved changes will be lost.');">
						</form>
					</div>
        </div>
    </div>
</div>
<!-- END UPLOAD FORM -->
<?php
	}
?>
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Control Panel Permission Edit Control Panel Page<br></div>
</body>
</html>
