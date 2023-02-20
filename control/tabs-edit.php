<?php $current_page = '8'; include('protect.php'); $int1 = $_POST["int1"]; $module = $_POST['module']; $action = $_POST["action"];

	if ($action == "save"){

		$webmaster = $_SESSION["webmaster"];
		$tabname = $_POST["tabname"];
		$owner = $_POST["owner"];
		$realtor = $_POST["realtor"];
		$public = $_POST["public"];
		$lease = $_POST["lease"];
		$title = preg_replace('/[^a-zA-Z0-9 ]/', '', $_POST['title']);
		$rednote = htmlspecialchars($_POST['rednote'], ENT_QUOTES);
		$url = $_POST["url"];
		$window = $_POST["window"];
		$image = $_POST["image"];
		
		//Generic Icon
        $imagestandard = '<i class="fa fa-external-link" aria-hidden="true"></i>';
        
        if ($image == $imagestandard){
            $imagecorrected = $imagestandard;
        }
        
        //Image Field
        if ($image != $imagestandard){
            $imagecorrected = $image;
        }
        if ($image == ''){
            $imagecorrected = $imagestandard;
        }
        
		//Corporate Icons
		if (strpos($url, 'docs.google.com') == true){
	        $imagecorrected = '<img src="https://condosites.com/commons/Google-Spreadsheet.png" alt="Google Sheets">';
	    }
	    if (strpos($url, 'drive.google.com') == true){
	        $imagecorrected = '<img src="https://condosites.com/commons/Google-Drive.png" alt="Google Drive">';
	    }
	    if (strpos($url, 'facebook.com') == true){
	        $imagecorrected = '<img src="https://condosites.com/commons/facebook.png" alt="Facebook">';
	    }
	    if (strpos($url, 'opentable.com') == true){
	        $imagecorrected = '<img src="https://condosites.com/commons/opentable.png" alt="OpenTable">';
	    }
	    if (strpos($url, 'hotpads.com') == true){
	        $imagecorrected = '<img src="https://condosites.net/commons/hotpads.png" alt="HotPads">';
	    }
	    if (strpos($url, 'maps.google.com') == true){
	        $imagecorrected = '<img src="https://condosites.net/commons/google.png" alt="Google Maps">';
	    }
	    if (strpos($url, 'realtor.com') == true){
	        $imagecorrected = '<img src="https://condosites.net/commons/realtorcom.png" alt="Realtor.com">';
	    }
	    if (strpos($url, 'yahoo.com') == true){
	        $imagecorrected = '<img src="https://condosites.net/commons/yahoo.png" alt="Yahoo!">';
	    }
	    if (strpos($url, 'unionbank.com') == true){
	        $imagecorrected = '<img src="https://condosites.net/commons/UnionBank.png" alt="Union Bank">';
	    }
	    if (strpos($url, 'paylease.com') == true){
	        $imagecorrected = '<img src="https://condosites.net/commons/paylease.png" alt="Zego Pay">';
	    }
	    if (strpos($url, 'propertypay.cit.com') == true){
	        $imagecorrected = '<img src="https://condosites.net/commons/MoO.png" alt="C-Property">';
	    }
	    if (strpos($url, 'noaa.com') == true){
	        $imagecorrected = '<img src="https://condosites.net/commons/noaa.png" alt="NOAA">';
	    }
        if (strpos($url, 'noaa.gov') == true){
	        $imagecorrected = '<img src="https://condosites.net/commons/noaa.png" alt="NOAA">';
	    }
	    if (strpos($url, 'homewisedocs.com') == true){
	        $imagecorrected = '<img src="https://condosites.net/commons/homewise.png" alt="Homewise Docs">';
	    }
	    if (strpos($url, 'sso.godaddy.com') == true){
	        $imagecorrected = '<img src="https://condosites.net/commons/Windows.png" alt="Microsoft">';
	    }
	    if (strpos($url, 'microsoft.com') == true){
	        $imagecorrected = '<img src="https://condosites.net/commons/Windows.png" alt="Microsoft">';
	    }
	    if (strpos($url, 'youtube.com') == true){
	        $imagecorrected = '<img src="https://condosites.net/commons/youtube.png" alt="YouTube">';
	    }
	    if (strpos($url, 'youtu.be') == true){
	        $imagecorrected = '<img src="https://condosites.net/commons/youtube.png" alt="YouTube">';
	    }


		$query = "UPDATE tabs SET tabname='$tabname', owner='$owner', realtor='$realtor', public='$public', lease='$lease', title='$title', rednote='$rednote', url='$url', window='$window', image='$imagecorrected' WHERE `int1`='$int1' LIMIT 1";
		mysqli_query($conn,$query) or die('Error, update query failed');

		$date = date("F j, Y");
		$query = "UPDATE updatedate SET date='$date'";
		mysqli_query($conn,$query) or die('Error, updating update date failed');

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['int1'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('E', 'Modules', '$useripaddress', '$userid', '$id')";
		mysqli_query($conn,$query) or die('Error, updating log failed');

		$query = "OPTIMIZE TABLE `tabs`";
		mysqli_query($conn,$query) or die('Error, optimize query failed');

		header('Location: '.$module);
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
<br>
<div style="max-width: 99%;">
<div class="nav-section-header-cp">
        <strong>Edit Module Permissions</strong>
</div>
<!-- INPUT FORM -->
<?php if ($_SESSION['board'] OR $_SESSION['concierge'] OR $_SESSION['liaison'] OR $_SESSION['webmaster'] == true){ ?>
<?php
	$query  = "SELECT * FROM tabs WHERE `int1`='$int1' LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- UPLOAD FORM -->
<div class="cp-form-container">
<!-- COLUMN 1 -->
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 10px 0px;">
<form enctype="multipart/form-data" method="POST" action="tabs-edit.php">
            <div class="small-12 medium-12 columns"><strong>1) Module Information</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="title" class="middle"><?php echo "{$row['image']}"; ?> Module Name<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Letters and numbers only, no special characters.</span></label></div>
            <div class="small-12 medium-7 end columns"><input name="title" maxlength="100" class="form" type="text" required placeholder="Calendar" value="<?php echo "{$row['title']}"; ?>" autofocus></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="rednote" class="middle">Note in red <i>(optional)</i><br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">This text appears below the title.</span></label></div>
            <div class="small-12 medium-7 end columns"><input name="rednote" maxlength="100" class="form" type="text" placeholder="Find cool information here!" value="<?php echo "{$row['rednote']}"; ?>"></div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>Non-Editable Fields<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">These fields can not be edited after creation.  To modify this information, create a new entry and delete this entry.</span></strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-4 columns"><label for="url" class="middle">URL</label></div>
            <div class="small-12 medium-8 end columns"><input name="url" maxlength="250" class="form" type="text" required value='<?php echo "{$row['url']}"; ?>' <?php if ($_SESSION['webmaster'] == '0'){ ?>readonly<?php }; ?>></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-4 columns"><label for="image" class="middle">Icon</label></div>
            <div class="small-12 medium-8 end columns"><input name="image" maxlength="250" class="form" type="text" value='<?php echo "{$row['image']}"; ?>' <?php if ($_SESSION['webmaster'] == '0'){ ?>readonly<?php }; ?>></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-4 columns"><label for="window" class="middle">Open new link in...</label></div>
            <div class="small-12 medium-8 end columns">
                <?php if ($_SESSION['webmaster'] == '1'){ ?>
                <label for="window" class="middle">
					<input type="radio" name="window" value='target="_blank"' <?php if ($row['window'] == 'target="_blank"'){ ?>checked<?php }; ?>> New Window<br>
					<input type="radio" name="window" value='' <?php if ($row['window'] == ''){ ?>checked<?php }; ?>> Lightbox
				</label>
				<?php }; ?>
				<?php if ($_SESSION['webmaster'] == '0'){ ?>
                <input name="window" maxlength="250" class="form" type="text" value='<?php echo "{$row['window']}"; ?>' placeholder="Lightbox" readonly>
				<?php }; ?>
            </div>
        </div>
    </div>
<!-- END COLUMN 1 -->
<!-- COLUMN 2 -->
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>2) Location, location, location!</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="tabname" class="middle">Where should this module appear?</label></div>
            <div class="small-12 medium-7 end columns">
<select name="tabname">
<option value="<?php echo "{$row['tabname']}"; ?>"><?php echo "{$row['tabname']}"; ?>
<option value="" disabled></option>
<option value="" disabled>***Folders***</option>
<?php
	$query  = "SELECT title FROM folders ORDER BY title";
	$result = mysqli_query($conn, $query);

	while($rowF = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$rowF['title']}"; ?>"><?php echo "{$rowF['title']}"; ?></option>
<?php
	}
?>
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
<option value="" disabled>***Custom Modules***</option>
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
            <div class="small-12 medium-12 columns"><strong>3) Who should have access to this?</strong></div>
        </div>
<?php if ($row['owner'] !== 'X' AND $_SESSION['webmaster'] !== '1'){ ?>
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
<?php if ($_SESSION['webmaster'] == '1'){ ?>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="owner" class="middle">Show in <b>Owner</b> Section? </label></div>
            <div class="small-12 medium-2 end columns" style="padding-right: 15px;">
<select name="owner" class="form">
<option value="Y" <?php if($row['owner'] == "Y"){ echo("SELECTED"); } ?>>Yes</option>
<option value="N" <?php if($row['owner'] == "N"){ echo("SELECTED"); } ?>>No</option>
<option value="X" <?php if($row['owner'] == "X"){ echo("SELECTED"); } ?>>Do Not Allow</option>
</select>
            </div>
        </div>
<?php }; ?>
<?php if ($row['lease'] !== 'X' AND $_SESSION['webmaster'] !== '1'){ ?>
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
<?php if ($_SESSION['webmaster'] == '1'){ ?>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="lease" class="middle">Show in <b>Renter</b> Section? </label></div>
            <div class="small-12 medium-2 end columns" style="padding-right: 15px;">
<select name="lease" class="form">
<option value="N" <?php if($row['lease'] == "N"){ echo("SELECTED"); } ?>>No</option>
<option value="Y" <?php if($row['lease'] == "Y"){ echo("SELECTED"); } ?>>Yes</option>
<option value="X" <?php if($row['lease'] == "X"){ echo("SELECTED"); } ?>>Do Not Allow</option>
</select>
            </div>
        </div>
<?php }; ?>
<?php if ($row['realtor'] !== 'X' AND $_SESSION['webmaster'] !== '1'){ ?>
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
<?php if ($_SESSION['webmaster'] == '1'){ ?>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="realtor" class="middle">Show in <b>Realtor</b> Section? </label></div>
            <div class="small-12 medium-2 end columns" style="padding-right: 15px;">
<select name="realtor" class="form">
<option value="N" <?php if($row['realtor'] == "N"){ echo("SELECTED"); } ?>>No</option>
<option value="Y" <?php if($row['realtor'] == "Y"){ echo("SELECTED"); } ?>>Yes</option>
<option value="X" <?php if($row['realtor'] == "X"){ echo("SELECTED"); } ?>>Do Not Allow</option>
</select>
            </div>
        </div>
<?php }; ?>
<?php if ($row['public'] !== 'X' AND $_SESSION['webmaster'] !== '1'){ ?>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="lease" class="middle">Show on <b>Public/Home</b> Page? </label></div>
            <div class="small-12 medium-2 end columns" style="padding-right: 15px;">
<select name="public" class="form">
<option value="N" <?php if($row['public'] == "N"){ echo("SELECTED"); } ?>>No</option>
<option value="H" <?php if($row['public'] == "H"){ echo("SELECTED"); } ?>>Home</option>
<option value="Y" <?php if($row['public'] == "Y"){ echo("SELECTED"); } ?>>Public</option>
</select>
            </div>
        </div>
<?php }; ?>
<?php if ($_SESSION['webmaster'] == '1'){ ?>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="public" class="middle">Show in <b>Public/Home</b> Page?</label></div>
            <div class="small-12 medium-2 end columns" style="padding-right: 15px;">
<select name="public" class="form">
<option value="N" <?php if($row['public'] == "N"){ echo("SELECTED"); } ?>>No</option>
<option value="H" <?php if($row['public'] == "H"){ echo("SELECTED"); } ?>>Home</option>
<option value="Y" <?php if($row['public'] == "Y"){ echo("SELECTED"); } ?>>Public</option>
<option value="X" <?php if($row['public'] == "X"){ echo("SELECTED"); } ?>>Do Not Allow</option>
</select>
            </div>
        </div>
<?php }; ?>
		<div class="row medium-collapse" style="padding-left: 30px;">
			<div class="small-12 medium-12 columns" style="margin-top: -15px; margin-bottom: 15px;">
				<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red"><strong>Home</strong> makes a document visible on the <strong>Home/Login</strong> page.</span><br>
			    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red"><strong>Public</strong> makes a document visible in a <strong>folder, photo gallery, or custom module</strong> without being logged in.</span>
            </div>
		</div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>4) Ready to Save?</strong></div>
        </div>
        <div class="row medium-collapse">
            <div class="small-6 columns" align="center">
	<input type="hidden" name="action" value="save">
	<input type="hidden" name="int1" value="<?php echo $_POST['int1']; ?>">
	<input type="hidden" name="module" value="<?php echo $_POST['module']; ?>">
	<input name="submit" value="Save" class="submit" type="submit">
<?php if ($_SESSION['webmaster'] == '0'){ ?>
    <input type="hidden" name="url" class="form" value='<?php echo "{$row['url']}"; ?>'>
    <input type="hidden" name="window" class="form" value='<?php echo "{$row['window']}"; ?>'>
    <input type="hidden" name="image" class="form" value='<?php echo "{$row['image']}"; ?>'>
<?php }; ?>
<?php if ($row['owner'] == 'X'){ ?><input name="owner" type="hidden" class="form" id="title" size="1" value="<?php echo "{$row['owner']}"; ?>"><?php }; ?>
<?php if ($row['lease'] == 'X'){ ?><input name="lease" type="hidden" class="form" id="title" size="1" value="<?php echo "{$row['lease']}"; ?>"><?php }; ?>
<?php if ($row['realtor'] == 'X'){ ?><input name="realtor" type="hidden" class="form" id="title" size="1" value="<?php echo "{$row['realtor']}"; ?>"><?php }; ?>
<?php if ($row['public'] == 'X'){ ?><input name="public" type="hidden" class="form" id="title" size="1" value="<?php echo "{$row['public']}"; ?>"><?php }; ?>
            </div>
</form>
            <div class="small-6 end columns" align="center">
<form name="TabCancel" method="POST" action="">
<input type="hidden" name="action" value="cancel">
<input type="hidden" name="module" value="<?php echo $_POST['module']; ?>">
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
<?php }; ?>
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Modules Edit Control Panel Page<br></div>
</body>
</html>
