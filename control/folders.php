<?php $current_page = '18'; include('protect.php'); ?>
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
<?php $int1 = $_POST["int1"]; $action = $_POST["action"]; if ($action != null){ ?>
<?php
	if ($action == "delete"){
		$query = "DELETE FROM folders WHERE `int1`='$int1'";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

        	$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Folder deleted successfully.</strong></div>";

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['int1'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('D', 'Folders', '$useripaddress', '$userid', '$id')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

		$query = "OPTIMIZE TABLE `folders`";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

	}
	if ($action == "add"){

		$tabname = $_POST["tabname"];
		$title = preg_replace('/[^A-Za-z0-9- .]/', '', $_POST['title']);
		$owner = $_POST["owner"];
		$realtor = $_POST["realtor"];
		$public = $_POST["public"];
		$lease = $_POST["lease"];
		$rednote = htmlspecialchars($_POST['rednote'], ENT_QUOTES);
		$link = $_POST["link"];
		$options = $_POST["options"];
		$image = $_POST["image"];

		$query = "SELECT title FROM folders WHERE title = '$title'";
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
		    
		$query = "SELECT `title` FROM `tabs` WHERE `title` = '$title'";
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

		$query = "INSERT INTO folders (tabname, title, owner, realtor, public, lease, rednote, link, options, image) VALUES ('$tabname', '$title', '$owner', '$realtor', '$public', '$lease', '$rednote', '$link', '$options', '$image')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

			$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Folder added successfully.</strong></div>";

		$date = date("F j, Y");
		$query = "UPDATE updatedate SET date='$date'";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
		}
		}
		}
	}
}
?>
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
        <p><b>Folders</b> are pages within your website that open in a lightbox window that contain documents and photos. Folders look and function like Custom Modules. Unlike a Custom Module, a Folder does not contain additional text or iFrame content.</p>
        <p><i class="fa fa-hand-o-right" aria-hidden="true"></i>  <span class="note-red">After you create a Folder, you can add documents, photos, and other modules via their respective control panels.</span></p>
    </div>
    <div class="small-12 medium-6 columns">
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#add"><b>Add a Folder/Photo Gallery</b></a> using the addition form below.</p>
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#edit"><b>View and Edit</b></a> existing entries in your database.</p>
    </div>
</div>

<div style="max-width: 99%;">
	<!-- UPLOAD FORM -->
	<a name="add"></a>
	<div class="nav-section-header-cp">
	        <strong>Add a Folder/Photo Gallery</strong>
	</div>
	<?php echo($errorSUCCESS); ?>
	<form enctype="multipart/form-data" method="POST" action="folders.php">
	<div class="cp-form-container">
	<!-- COLUMN 1 -->
	    <div class="small-12 medium-12 large-6 columns">
	        <div class="row" style="padding: 10px 10px 10px 0px;">
	            <div class="small-12 medium-12 columns"><strong>1) Let&apos;s start with the basics...</strong></div>
	        </div>
					<div class="row medium-collapse" style="padding-left: 30px;">
	            <div class="small-12 medium-5 columns"><label for="title" class="middle">Folder/Photo Gallery Title<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red"><b>Use only letters, numbers, and hyphens!</b> Other characters will be omited.</span></label></div>
	            <div class="small-12 medium-7 end columns"><input name="title" maxlength="100" class="form" type="text" placeholder="Agendas" required autofocus></div>
	        </div>
					<div class="row medium-collapse" style="padding-left: 30px;">
	            <div class="small-12 medium-5 columns"><label for="rednote" class="middle">Note in red <i>(optional)</i><br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">This text appears below the title.</span></label></div>
	            <div class="small-12 medium-7 end columns"><input name="rednote" maxlength="100" class="form" type="text" placeholder="Including Budgets and Audits"></div>
	        </div>
					<div class="row" style="padding: 10px 10px 10px 0px;">
	            <div class="small-12 medium-12 columns"><strong>2) How the folder functions...</strong></div>
	        </div>
					<div class="row medium-collapse" style="padding-left: 30px;">
	            <div class="small-12 medium-5 columns"><label for="link" class="middle">How should the contents be arranged?<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Photos will be automatically recognized and displayed in alphabetical order.</span></label></div>
	            <div class="small-12 medium-7 end columns">
								<select name="link" required>
									<option value="">Choose a default sort order</option>
									<option value="../modules/documentcenter-select.php?choice=">Ascending (A-Z) Alphabetical Order</option>
									<option value="../modules/documentcenter-select-desc.php?choice=">Descending (Z-A) Alphabetical Order</option>
									<option value="../modules/documentcenter-select-chron.php?choice=">Reverse Chronological Order</option>
								</select>
							</div>
	        </div>
					<div class="row medium-collapse" style="padding-left: 30px;">
	            <div class="small-12 medium-5 columns"><label for="image" class="middle">Choose an icon</label></div>
	            <div class="small-12 medium-7 end columns">
								<label for="folder" class="middle">
									<input type="radio" name="image" value='<i class="fa fa-folder" aria-hidden="true"></i>' checked> <i class="fa fa-folder" aria-hidden="true"></i> Folder Icon<br>
									<input type="radio" name="image" value='<i class="fa fa-camera-retro" aria-hidden="true"></i>'> <i class="fa fa-camera-retro" aria-hidden="true"></i> Photo Gallery Icon
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
								<option value="">Select a location to place the folder/photo gallery.</option>
								<option value="" disabled></option>
								<option value="" disabled>***Navigation Column***</option>
								<?php
								$query  = "SELECT type FROM navigation WHERE `link` = 'Y' ORDER BY type";
								$result = mysqli_query($conn, $query);

								while($rowF = $result->fetch_array(MYSQLI_ASSOC))
								{
								?>
								<option value="<?php echo "{$rowF['type']}"; ?>"><?php echo "{$rowF['type']}"; ?></option>
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
	            <div class="small-12 medium-6 columns"><strong>5) Ready to Save?</strong></div>
	            <div class="small-12 medium-6 columns">
								<input type="hidden" name="options" value="">
								<input type="hidden" name="action" value="add">
								<input name="submit" value="Submit" class="submit" type="submit">
	                <?php echo($error); ?>
	            </div>
	        </div>
	        <div class="row medium-collapse">
	            <div class="small-12 medium-12 columns" align="center">
	<br><i class="fa fa-hand-o-down" aria-hidden="true"></i> Scroll down to see the folders and photo galleries already added.
	            </div>
	        </div>
	    </div>
	<!-- COLUMN 2 -->
  </form>
  </div>
	<!-- END UPLOAD FORM -->
    <a name="edit"></a>
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
    $module = "folders.php";
	$query  = "SELECT * FROM folders ORDER BY `int1`";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
    <tr>
      <td>
				<div class="small-12 medium-12 large-8 columns">
					<a href="<?php echo "{$row['link']}"; ?><?php echo "{$row['title']}"; ?>" <?php echo "{$row['options']}"; ?> target="_blank"><?php echo "{$row['image']}"; ?> <?php echo "{$row['title']}"; ?></a>
					<?php if ($row['rednote'] != ''){ ?><span class="note-red"><br><b><?php echo "{$row['rednote']}"; ?></b></span><?php }; ?>
					
					<br><span-class="note-black"><small>
					<?php if ($row['link'] == '../modules/documentcenter-select.php?choice='){ ?>Ascending (A-Z) Alphabetical Order<?php }; ?>
					<?php if ($row['link'] == '../modules/documentcenter-select-desc.php?choice='){ ?>Descending (Z-A) Alphabetical Order<?php }; ?>
					<?php if ($row['link'] == '../modules/documentcenter-select-chron.php?choice='){ ?>Reverse Chronological Order<?php }; ?>
					</small></span>
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
<br>
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Folders Control Panel Page<br></div>
</body>
</html>
