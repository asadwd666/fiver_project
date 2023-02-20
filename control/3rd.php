<?php $current_page = '1'; include('protect.php'); $module = $_POST['module']; ?>
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
<?php $int1 = $_POST["int1"]; $action = $_POST["action"]; if ($action != null){ ?>
<?php
	if ($action == "delete"){
		$query = "DELETE FROM tabs WHERE `int1`='$int1'";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
		
	    	$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Your link has been removed.</strong></div>";

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['int1'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('D', '3rd Party URL', '$useripaddress', '$userid', '$id')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

		$query = "OPTIMIZE TABLE `tabs`";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

	}
	if ($action == "add"){

		$id = $_POST["id"];
		$tabname = $_POST["tabname"];
		$title = preg_replace('/[^a-zA-Z0-9 ]/', '', $_POST['title']);
		$owner = $_POST["owner"];
		$realtor = $_POST["realtor"];
		$public = $_POST["public"];
		$lease = $_POST["lease"];
		$rednote = htmlspecialchars($_POST['rednote'], ENT_QUOTES);
		$image = $_POST["image"];
		$url = $_POST["url"];
		$window = $_POST["window"];
		
	    //Generic Icon
        $imagecorrected = $image;
        
		//Corporate Icons
		if (strpos($url, 'docs.google.com/spreadsheets') == true){
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

		$query = "INSERT INTO `tabs` (`int1`, `tabname`, `title`, `owner`, `realtor`, `public`, `lease`, `rednote`, `liaison`, `image`, `url`, `window`) VALUES ('$id', '$tabname', '$title', '$owner', '$realtor', '$public', '$lease', '$rednote', 'Y', '$imagecorrected', '$url', '$window')";
        $result = mysqli_query($conn,$query) or die('Error, insert query failed');

			$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Your link was added successfully.</strong></div>";

		$query = "ALTER TABLE `tabs` ORDER BY `int1`;";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

		$date = date("F j, Y");
		$query = "UPDATE updatedate SET date='$date'";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
		
	}
}
?>
<!-- HEALTH AND HELP -->
<div>
    <div class="large-8 columns" style="padding: 0px">
        <div class="nav-section-header-health-cp" align="center">
<big><i class="fa fa-stethoscope" aria-hidden="true"></i></big><strong>&nbsp;Health&nbsp;&nbsp;&nbsp;</strong>
<i class="fa fa-exclamation-triangle note" aria-hidden="true"></i> Have you checked the validity of your 3rd party links lately?
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
    <div class="small-12 medium-6 columns">
        <p>This is where you can add or edit links to <b>3rd Party Websites</b> that appear directly on your Navigation Column.</p>
        <p><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Placing too many links can clutter up your website and be a chore to maintain!</span></p>
    </div>
    <div class="small-12 medium-6 columns">
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#add"><b>Add a 3rd Party Link</b></a> using the addition form below.</p>
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#edit"><b>View and Edit</b></a> existing entries in your database.</p>
    </div>
</div>
<div style="max-width: 99%;">

	<!-- UPLOAD FORM -->
    <a name="add"></a>
	<div class="nav-section-header-cp">
	        <strong>Add a 3rd Party Link</strong>
	</div>
	<?php echo($errorSUCCESS); ?>
	<form enctype="multipart/form-data" method="POST" action="3rd.php">
	<div class="cp-form-container">
	<!-- COLUMN 1 -->
	    <div class="small-12 medium-12 large-6 columns">
	        <div class="row" style="padding: 10px 10px 10px 0px;">
	            <div class="small-12 medium-12 columns"><strong>1) Let&apos;s start with the basics...</strong></div>
	        </div>
			<div class="row medium-collapse" style="padding-left: 30px;">
	            <div class="small-12 medium-6 columns"><label for="title" class="middle">Website Title<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Letters and numbers only, no special characters.</span></label></div>
	            <div class="small-12 medium-6 end columns"><input name="title" maxlength="100" class="form" type="text" placeholder="Google" required autofocus></div>
	        </div>
			<div class="row medium-collapse" style="padding-left: 30px;">
	            <div class="small-12 medium-6 columns"><label for="rednote" class="middle">Note in red <i>(optional)</i><br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">This text appears below the title.</span></label></div>
	            <div class="small-12 medium-6 end columns"><input name="rednote" maxlength="100" class="form" type="text" placeholder="(link to external site)" value="(link to external site)"></div>
	        </div>
            <div class="row medium-collapse" style="padding-left: 30px;">
                <div class="small-12 medium-6 columns"><label for="url" class="middle">URL<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Be sure URL starts with http://</span></label></div>
	            <div class="small-12 medium-6 end columns"><input name="url" maxlength="250" class="form" type="url" placeholder="http://www.google.com"></div>
	        </div>
			<div class="row medium-collapse" style="padding-left: 30px;">
	            <div class="small-12 medium-6 columns"><label for="image" class="middle">Icon <br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Default entry uses generic External Link icon.</span><?php if ($_SESSION['webmaster'] == '0'){ ?><br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Contact your CondoSites Webmaster to edit this field.</span></strong><?php }; ?></label></div>
	            <div class="small-12 medium-6 end columns"><input name="image" maxlength="100" class="form" type="text" placeholder='<img src="https://condosites.net/commons/google.png" alt="Google">' value='<i class="fa fa-external-link" aria-hidden="true"></i>'  <?php if ($_SESSION['webmaster'] == '0'){ ?>readonly<?php }; ?>></div>
	        </div>
            <div class="row medium-collapse" style="padding-left: 30px;">
                <div class="small-12 medium-6 columns"><label for="window" class="middle">Open new link in...</label></div>
                <div class="small-12 medium-6 end columns">
                    <label for="window" class="middle">
						<input type="radio" name="window" value='target="_blank"' checked> New Window<br>
						<input type="radio" name="window" value=''> Lightbox
					</label>
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
	            <div class="small-12 medium-5 columns"><label for="tabname" class="middle">Where should this appear?</label></div>
	            <div class="small-12 medium-7 end columns">
					<select name="tabname" required>
<option value="">Select a location to place the link.</option>
<option value="" disabled> </option>
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
<option value="" disabled> </option>
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
<option value="" disabled> </option>
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
	            <div class="small-12 medium-12 columns"><strong>3) Who should have access to this module?</strong></div>
	        </div>

					        <div class="row medium-collapse" style="padding-left: 30px;">
					            <div class="small-12 medium-5 columns"><label for="owner" class="middle">Show in <b>Owner</b> Section? </label></div>
					            <div class="small-12 medium-2 end columns" style="padding-right: 15px;">
					<select name="owner" class="form">
					<option value="Y" <?php if($row['owner'] == "Y"){ echo("SELECTED"); } ?>>Yes</option>
					<option value="N" <?php if($row['owner'] == "N"){ echo("SELECTED"); } ?>>No</option>
					<?php if ($_SESSION['webmaster'] == '1'){ ?><option value="N" <?php if($row['owner'] == "X"){ echo("SELECTED"); } ?>>Do Not Allow</option><?php }; ?>
					</select>
					            </div>
					        </div>
					        <div class="row medium-collapse" style="padding-left: 30px;">
					            <div class="small-12 medium-5 columns"><label for="lease" class="middle">Show in <b>Renter</b> Section? </label></div>
					            <div class="small-12 medium-2 end columns" style="padding-right: 15px;">
					<select name="lease" class="form">
					<option value="N" <?php if($row['lease'] == "N"){ echo("SELECTED"); } ?>>No</option>
					<option value="Y" <?php if($row['lease'] == "Y"){ echo("SELECTED"); } ?>>Yes</option>
					<?php if ($_SESSION['webmaster'] == '1'){ ?><option value="N" <?php if($row['lease'] == "X"){ echo("SELECTED"); } ?>>Do Not Allow</option><?php }; ?>
					</select>
					            </div>
					        </div>
					        <div class="row medium-collapse" style="padding-left: 30px;">
					            <div class="small-12 medium-5 columns"><label for="realtor" class="middle">Show in <b>Realtor</b> Section? </label></div>
					            <div class="small-12 medium-2 end columns" style="padding-right: 15px;">
					<select name="realtor" class="form">
					<option value="N" <?php if($row['realtor'] == "N"){ echo("SELECTED"); } ?>>No</option>
					<option value="Y" <?php if($row['realtor'] == "Y"){ echo("SELECTED"); } ?>>Yes</option>
					<?php if ($_SESSION['webmaster'] == '1'){ ?><option value="N" <?php if($row['realtor'] == "X"){ echo("SELECTED"); } ?>>Do Not Allow</option><?php }; ?>
					</select>
					            </div>
					        </div>
					        <div class="row medium-collapse" style="padding-left: 30px;">
					            <div class="small-12 medium-5 columns"><label for="public" class="middle">Show in <b>Public/Home</b> Page?</label></div>
                                <div class="small-12 medium-2 end columns" style="padding-right: 15px;">
                    <select name="public" class="form">
                    <option value="N">No</option>
                    <option value="Y">Public</option>
                    <option value="H">Home</option>
                    </select>
                                </div>
					        </div>
					        <div class="row medium-collapse" style="padding-left: 30px;">
					            <div class="small-12 medium-12 columns" style="margin-top: -15px;">
					        <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red"><strong>Home</strong> makes a document visible on the <strong>Home/Login</strong> page.</span><br>
					        <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red"><strong>Public</strong> makes a document visible in a <strong>folder, photo gallery, or custom module</strong> without being logged in.</span>
                                </div>
					        </div>
	        <div class="row" style="padding: 10px 10px 10px 0px;">
	            <div class="small-12 medium-5 columns"><strong>4) Ready to Save?</strong></div>
	            <div class="small-12 medium-7 columns">
    <input type="hidden" name="module" value="<?php echo $_POST['module']; ?>">
<?php $sqlID = mysqli_query($conn,"SELECT count(*) FROM `tabs` WHERE `int1` BETWEEN '500' AND '599'") or die(mysqli_error($conn));
//$countID = mysql_result($sqlID, "0");
$row = mysqli_fetch_row($sqlID);
$countID = $row[0];
?>
<?php if ($countID == '0'){ ?>
    <input type="hidden" name="id" value="501">
	<input type="hidden" name="action" value="add">
	<input name="submit" value="Submit" class="submit" type="submit">
<?php }; ?>

<?php $queryID  = "SELECT `int1` FROM `tabs` WHERE `int1` BETWEEN '500' AND '599' ORDER BY `int1` DESC LIMIT 1"; $resultID = mysqli_query($conn,$queryID);
while($rowID = $resultID->fetch_array(MYSQLI_ASSOC)) { ?>
<input type="hidden" name="id" value="<?php echo $rowID['int1'] + 1; ?>">
<?php if ($rowID['int1'] <= '590'){ ?>
    <input type="hidden" name="module" value="<?php echo $_POST['module']; ?>">
	<input type="hidden" name="action" value="add">
	<input name="submit" value="Submit" class="submit" type="submit">
<?php }; ?>
<?php if ($rowID['int1'] >= '591'){ ?>
    <span class="note-red"><big>The allotment for 3rd Party Links has either been reached or this portion of your database is in need of attention. Please contact your CondoSites Webmaster and report this error.</big></span>
<?php }; ?>
<?php } ?>
	                <?php echo($error); ?>
	            </div>
	        </div>
	        <div class="row medium-collapse">
	            <div class="small-12 medium-12 columns" align="center">
	                <br><i class="fa fa-hand-o-down" aria-hidden="true"></i> Scroll down to see the links already added.
	            </div>
	        </div>
	    </div>
	<!-- COLUMN 2 -->
  </div>
  </form>
	<!-- END UPLOAD FORM -->
	<br>

<!-- MODULE PERMISSIONS -->
<a name="edit"></a>
<div class="nav-section-header-cp">
    <strong>3rd Party Link Permissions</strong>
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
	$module = "3rd.php";
	$query  = "SELECT * FROM tabs WHERE liaison = 'Y' AND `int1` BETWEEN '290' AND '295' OR `int1` BETWEEN '335' AND '399' OR `int1` BETWEEN '500' AND '599' OR `int1` BETWEEN '600' AND '699' ORDER BY `int1`";
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
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>3rd Party Links Control Panel Page<br></div>
</body>
</html>
