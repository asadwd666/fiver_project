<?php $current_page = '18'; include('protect.php'); $int1 = $_POST["int1"]; $module = $_POST['module']; $action = $_POST["action"];

    if ($action == "save"){

		$tabname = $_POST["tabname"];
		$title = preg_replace('/[^A-Za-z0-9- .]/', '', $_POST['title']);
		$rednote = htmlspecialchars($_POST['rednote'], ENT_QUOTES);
		$owner = $_POST["owner"];
		$realtor = $_POST["realtor"];
		$public = $_POST["public"];
		$lease = $_POST["lease"];
		$link = $_POST["link"];
		$options = $_POST["options"];
		$image = $_POST["image"];

		$query = "SELECT title FROM folders WHERE title = '$title' AND `int1` != '$int1'";
		$result = mysqli_query($conn, $query);
		$folder_taken = false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$folder_taken = true;
		}
		if($folder_taken == true){
			$success = "false";
			$error = "<br>A Folder already exists with that name.";
			$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #FAFEB8; color: black;'><i class='fa fa-exclamation-triangle note' aria-hidden='true'></i> <strong>A Folder already exists with that name.</strong></div>";
		} else {
		    
		$query = "SELECT `title` FROM `tabs` WHERE `title` = '$title' AND `int1` != '$int1'";
		$result = mysqli_query($conn, $query);
		$folder_taken = false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$folder_taken = true;
		}
		if($folder_taken == true){
			$success = "false";
			$error = "<br>A Custom Module already exists with that name.";
			$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #FAFEB8; color: black;'><i class='fa fa-exclamation-triangle note' aria-hidden='true'></i> <strong>A Custom Module already exists with that name.</strong></div>";
		} else {
		    
		$query = "SELECT `type` FROM `navigation` WHERE `type` = '$title'";
		$result = mysqli_query($conn, $query);
		$folder_taken = false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$folder_taken = true;
		}
		if($folder_taken == true){
			$success = "false";
			$error = "<br>A Navigation Column container already exists with that name.";
			$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #FAFEB8; color: black;'><i class='fa fa-exclamation-triangle note' aria-hidden='true'></i> <strong>A Navigation Column container already exists with that name.</strong></div>";
		} else {

		$query = "UPDATE folders SET tabname='$tabname', title='$title', rednote='$rednote', owner='$owner', realtor='$realtor', public='$public', lease='$lease', link='$link', options='$options', image='$image' WHERE `int1`='$int1' LIMIT 1";
		mysqli_query($conn,$query) or die('Error, update query failed');

		$folderold = $_POST["folderold"];
		$query = "UPDATE documents SET doctype='$title' WHERE doctype='$folderold'";
		mysqli_query($conn,$query) or die('Error, update query failed');

		$date = date("F j, Y");
		$query = "UPDATE updatedate SET date='$date'";
		mysqli_query($conn,$query) or die('Error, updating update date failed');

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['int1'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('E', 'Folders', '$useripaddress', '$userid', '$id')";
		mysqli_query($conn,$query) or die('Error, updating log failed');

			header('Location: '.$module);
    	}
		}
		}
    }

    if ($action == "cancel"){

	   	header('Location: '.$module);

    }

?>
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
<br>&nbsp;
<div style="max-width: 99%;">
	<!-- INPUT FORM -->
	<?php
		$query  = "SELECT `int1`, tabname, title, rednote, owner, realtor, public, lease, link, options, image, liaison FROM folders WHERE `int1`='$int1' LIMIT 1";
		$result = mysqli_query($conn, $query);

		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{
	?>
	<div class="nav-section-header-cp">
	        <strong>Edit a Folder/Photo Gallery</strong>
	</div>
    <?php echo($errorSUCCESS); ?>
	<div class="cp-form-container">
	<!-- COLUMN 1 -->
	    <div class="small-12 medium-12 large-6 columns">
	        <div class="row" style="padding: 10px 10px 10px 0px;">
<form enctype="multipart/form-data" method="POST" action="folders-edit.php">
	            <div class="small-12 medium-12 columns"><strong>1) Let&apos;s start with the basics...</strong></div>
	        </div>
					<div class="row medium-collapse" style="padding-left: 30px;">
	            <div class="small-12 medium-5 columns"><label for="title" class="middle">Folder/Photo Gallery Title<?php if ($row['liaison'] == 'Y'){ ?><br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red"><b>Use only letters, numbers, and hyphens!</b> Other characters will be omited.</span><?php }; ?></label></div>
	            <div class="small-12 medium-7 end columns">
								<?php if ($row['liaison'] == 'Y'){ ?><input name="title" type="text" size="25" maxlength="50" class="form" required autofocus value="<?php echo "{$row['title']}"; ?>"><?php }; ?>
								<?php if ($row['liaison'] == 'N'){ ?><b><?php echo "{$row['title']}"; ?></b><br><i class="fa fa-hand-o-right" aria-hidden="true"></i>  <span class="note-red">Only <i>custom</i> folders have modifyable names.<br><br></span><input type="hidden" name="title" size="25" maxlength="50" class="form" value="<?php echo "{$row['title']}"; ?>"><?php }; ?>
								<span class="note-red"><?php echo($error); ?></span>
							</div>
	        </div>
					<div class="row medium-collapse" style="padding-left: 30px;">
	            <div class="small-12 medium-5 columns"><label for="rednote" class="middle">Note in red <i>(optional)</i><br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">This text appears below the title.</span></label></div>
	            <div class="small-12 medium-7 end columns"><input name="rednote" maxlength="100" class="form" type="text" placeholder="Including Budgets and Audits" value="<?php echo "{$row['rednote']}"; ?>" autofocus></div>
	        </div>
					<div class="row" style="padding: 10px 10px 10px 0px;">
	            <div class="small-12 medium-12 columns"><strong>2) How the folder functions...</strong></div>
	        </div>
					<div class="row medium-collapse" style="padding-left: 30px;">
	            <div class="small-12 medium-5 columns"><label for="link" class="middle">How should the contents be arranged?<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Photos will be automatically recognized and displayed in alphabetical order.</span></label></div>
	            <div class="small-12 medium-7 end columns">
								<select name="link" required>
									<option value="">Choose a default sort order</option>
									<option value="../modules/documentcenter-select.php?choice=" <?php if($row['link'] == "../modules/documentcenter-select.php?choice="){ echo("SELECTED"); } ?>>Ascending (A-Z) Alphabetical Order</option>
									<option value="../modules/documentcenter-select-desc.php?choice=" <?php if($row['link'] == "../modules/documentcenter-select-desc.php?choice="){ echo("SELECTED"); } ?>>Descending (Z-A) Alphabetical Order</option>
									<option value="../modules/documentcenter-select-chron.php?choice=" <?php if($row['link'] == "../modules/documentcenter-select-chron.php?choice="){ echo("SELECTED"); } ?>>Reverse Chronological Order</option>
								</select>
							</div>
	        </div>
					<div class="row medium-collapse" style="padding-left: 30px;">
	            <div class="small-12 medium-5 columns"><label for="image" class="middle">Choose an icon</label></div>
	            <div class="small-12 medium-7 end columns">
								<label for="folder" class="middle">
									<input type="radio" name="image" value='<i class="fa fa-folder" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-folder" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-folder" aria-hidden="true"></i> Folder Icon<br>
									<input type="radio" name="image" value='<i class="fa fa-camera-retro" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-camera-retro" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-camera-retro" aria-hidden="true"></i> Photo Gallery Icon
								</label>
							</div>
	        </div>

	    </div>
<!-- END COLUMN 1 -->
<!-- COLUMN 2 -->
	    <div class="small-12 medium-12 large-6 columns">
	        <div class="row" style="padding: 10px 10px 10px 0px;">
	            <div class="small-12 medium-12 columns"><strong>3) Location, location, location!</strong></div>
	        </div>
	        <div class="row medium-collapse" style="padding-left: 30px;">
	            <div class="small-12 medium-5 columns"><label for="tabname" class="middle">Where should this appear?</label></div>
	            <div class="small-12 medium-7 end columns">
								<select name="tabname" required>
					<option value="<?php echo "{$row['tabname']}"; ?>"><?php echo "{$row['tabname']}"; ?>
					<option value="">Select a location to place the folder/photo gallery.</option>
					<option value="" disabled></option>
					<option value="" disabled>***Navigation Column***</option>
					<?php
						$query  = "SELECT type FROM navigation WHERE `link` = 'Y' ORDER BY type";
						$result = mysqli_query($conn, $query);

						while($rowF = $result->fetch_array(MYSQLI_ASSOC))
						{
					?>
					<option value="<?php echo "{$rowF['type']}"; ?>"><?php echo "{$rowF['type']}"; ?>
					<?php
						}
					?>
					<?php
						$query  = "SELECT title FROM tabs WHERE `url` LIKE '%../modules/module.php?choice=%' AND liaison = 'Y' AND (`int1` BETWEEN '1000' AND '1999') LIMIT 1";
						$result = mysqli_query($conn, $query);

						while($rowC = $result->fetch_array(MYSQLI_ASSOC))
						{
					?>
					<option value="" disabled></option>
					<option value="" disabled>***Custom Pages***</option>
					<?php
						}
					?>
					<?php
						$query  = "SELECT title FROM tabs WHERE `url` LIKE '%../modules/module.php?choice=%' AND liaison = 'Y' AND (`int1` BETWEEN '1000' AND '1999') ORDER BY title";
						$result = mysqli_query($conn, $query);

						while($rowC = $result->fetch_array(MYSQLI_ASSOC))
						{
					?>
					<option value="<?php echo "{$rowC['title']}"; ?>"><?php echo "{$rowC['title']}"; ?></option>
					<?php
						}
					?>
					</select>
							</div>
	        </div>
					<div class="row" style="padding: 10px 10px 10px 0px;">
	            <div class="small-12 medium-12 columns"><strong>4) Who should have access to this folder/photo gallery?</strong></div>
	        </div>
					<?php if ($row['owner'] !== 'X'){ ?>
					        <div class="row medium-collapse" style="padding-left: 30px;">
					            <div class="small-12 medium-5 columns"><label for="owner" class="middle">Show in <b>Owner</b> Section? </label></div>
					            <div class="small-12 medium-2 end columns" style="padding-right: 15px;">
					<select name="owner" class="form">
					<option value="Y" <?php if($row['owner'] == "Y"){ echo("SELECTED"); } ?>>Yes</option>
					<option value="N" <?php if($row['owner'] == "N"){ echo("SELECTED"); } ?>>No</option>
					</select>
					            </div>
					        </div>
					<?php }; ?>
					<?php if ($row['lease'] !== 'X'){ ?>
					        <div class="row medium-collapse" style="padding-left: 30px;">
					            <div class="small-12 medium-5 columns"><label for="lease" class="middle">Show in <b>Renter</b> Section? </label></div>
					            <div class="small-12 medium-2 end columns" style="padding-right: 15px;">
					<select name="lease" class="form">
					<option value="N" <?php if($row['lease'] == "N"){ echo("SELECTED"); } ?>>No</option>
					<option value="Y" <?php if($row['lease'] == "Y"){ echo("SELECTED"); } ?>>Yes</option>
					</select>
					            </div>
					        </div>
					<?php }; ?>
					<?php if ($row['realtor'] !== 'X'){ ?>
					        <div class="row medium-collapse" style="padding-left: 30px;">
					            <div class="small-12 medium-5 columns"><label for="realtor" class="middle">Show in <b>Realtor</b> Section? </label></div>
					            <div class="small-12 medium-2 end columns" style="padding-right: 15px;">
					<select name="realtor" class="form">
					<option value="N" <?php if($row['realtor'] == "N"){ echo("SELECTED"); } ?>>No</option>
					<option value="Y" <?php if($row['realtor'] == "Y"){ echo("SELECTED"); } ?>>Yes</option>
					</select>
					            </div>
					        </div>
					<?php }; ?>
					<?php if ($row['public'] !== 'X'){ ?>
					        <div class="row medium-collapse" style="padding-left: 30px;">
					            <div class="small-12 medium-5 columns"><label for="lease" class="middle">Show on <b>Home</b> Page? </label></div>
					            <div class="small-12 medium-2 end columns" style="padding-right: 15px;">
					<select name="public" class="form">
					<option value="N" <?php if($row['public'] == "N"){ echo("SELECTED"); } ?>>No</option>
					<option value="H" <?php if($row['public'] == "H"){ echo("SELECTED"); } ?>>Home</option>
					</select>
					            </div>
					        </div>
					<?php }; ?>
					<div class="row" style="padding: 10px 10px 10px 0px;">
	            <div class="small-12 columns"><strong>5) Ready to Save?</strong></div>
	        </div>
	        <div class="row medium-collapse">
	            <div class="small-6 columns" align="center">
								<?php if ($row['owner'] == 'X'){ ?><input name="owner" type="hidden" class="form" id="title" size="1" value="<?php echo "{$row['owner']}"; ?>"><?php }; ?>
								<?php if ($row['lease'] == 'X'){ ?><input name="lease" type="hidden" class="form" id="title" size="1" value="<?php echo "{$row['lease']}"; ?>"><?php }; ?>
								<?php if ($row['realtor'] == 'X'){ ?><input name="realtor" type="hidden" class="form" id="title" size="1" value="<?php echo "{$row['realtor']}"; ?>"><?php }; ?>
								<?php if ($row['public'] == 'X'){ ?><input name="public" type="hidden" class="form" id="title" size="1" value="<?php echo "{$row['public']}"; ?>"><?php }; ?>
									<input type="hidden" name="action" value="save">
									<input type="hidden" name="options" value="">
									<input type="hidden" name="module" value="<?php echo $_POST['module']; ?>">
									<input type="hidden" name="folderold" value="<?php echo "{$row['title']}"; ?>">
									<input type="hidden" name="int1" value="<?php echo $_POST['int1']; ?>">
									<input name="submit" value="Save" class="submit" type="submit">
	                <?php echo($error); ?>
	</form>
	            </div>
	            <div class="small-6 end columns" align="center">
					<form name="Cancel" method="POST" action="">
                        <input type="hidden" name="action" value="cancel">
						<input type="hidden" name="module" value="<?php echo $_POST['module']; ?>">
						<input type="submit" value="Cancel" onclick="return confirm('Are you sure you wish to leave this page? Unsaved changes will be lost.');">
					</form>
	            </div>
	        </div>
	    </div>
<!-- COLUMN 2 -->
	</div>
<?php
	}
?>
<!-- END INPUT FORM -->
<br>
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Folders Edit Control Panel Page<br></div>
</body>
</html>
