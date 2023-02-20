<?php $current_page = '12'; include('protect.php'); ?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="CondoSites - http://www.condosites.com" name="author">
<title>Control Panel</title>
<?php include('../control/cp-head-scripts.php'); ?>
</head>
<body>
<!-- LOGO AND NAVIGATION -->
<?php include('cp-navigation.php'); ?>
<!-- END LOGO AND NAVIGATION -->
<?php $action = $_POST["action"]; if ($action != null){ ?>
<?php
	if ($action == "delete"){
		$id = $_POST["id"];
		$query = "DELETE FROM pets WHERE `id`='$id'";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
		
	    	$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>The entry was deleted successfully.</strong></div>";

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('D', 'Pets', '$useripaddress', '$userid', '$id')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

		$query = "OPTIMIZE TABLE `pets`";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

	}
	if ($action == "upload" && $_FILES['userfile']['size'] > 0){

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$species = $_POST["species"];
		$breed = $_POST["breed"];
		$weight = $_POST["weight"];
		$license = $_POST["license"];
		$vaccination = $_POST["vaccination"];
		$lost = $_POST["lost"];
		$petname = htmlspecialchars($_POST['petname'], ENT_QUOTES);
		$owner = htmlspecialchars($_POST['owner'], ENT_QUOTES);
		$userid = $_POST["userid"];
		$comments = $_POST["comments"];
		$approved = $_POST["approved"];
		$fileName = $_FILES['userfile']['name'];
		$tmpName  = $_FILES['userfile']['tmp_name'];
		$fileSize = $_FILES['userfile']['size'];
		$fileType = $_FILES['userfile']['type'];
		$fp      = fopen($tmpName, 'r');
		$content = fread($fp, filesize($tmpName));
		$content = addslashes($content);
		fclose($fp);

		if(!get_magic_quotes_gpc())
		{
			$fileName = addslashes($fileName);
		}

		if ($fileSize >= '1500000') {
			$success = "false";
			$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #FAFEB8; color: black;'><i class='fa fa-exclamation-triangle note' aria-hidden='true'></i> <strong>The photo you attached is too large! Max size 1 MB.</strong></div>";
		}

		else {

		$query  = "INSERT INTO pets (useripaddress, species, breed, weight, license, vaccination, lost, petname, owner, userid, name, size, type, content, comments, approved ) VALUES ('$useripaddress', '$species', '$breed', '$weight', '$license', '$vaccination', '$lost', '$petname', '$owner', '$userid', '$fileName', '$fileSize', '$fileType', '$content', '$comments', '$approved')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

			$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Your entry was added successfully.</strong></div>";
		}

	}

	$date = date("F j, Y");
	$query = "UPDATE updatedate SET date='$date'";
	mysqli_query($conn,$query) or die('Error, updating update date failed');
}
?>
<!-- HEALTH AND HELP -->
<div>
    <div class="large-8 columns" style="padding: 0px">
        <div class="nav-section-header-health-cp" align="center">
<big><i class="fa fa-stethoscope" aria-hidden="true"></i></big><strong>&nbsp;Health&nbsp;&nbsp;&nbsp;</strong>
<?php $sqlPETS = mysqli_query($conn,"SELECT count(*) FROM pets WHERE approved != 'Y'") or die(mysqli_error($conn));
//$countPETS = mysql_result($sqlPETS, "0");
$row = mysqli_fetch_row($sqlPETS);
$countPETS = $row[0];
?>
<?php if ($countPETS != '0'){ ?><i class="fa fa-exclamation-triangle note" aria-hidden="true"></i> You have <?php print($countPETS); ?> Pets pending your approval!<?php }; ?>
<?php if ($countPETS == '0'){ ?><i class="fa fa-check" aria-hidden="true"></i> All registered pets have been approved!<?php }; ?>
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
        <p>This is where you can register and manage <b>pets</b> registered in your website.</p>
        <p>
            <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Users can submit their own pets by clicking the link within the Pet Directory module. You can also enable a Database Submission eForm in the eForms control panel.</span><br>
            <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">If a pet gets lost, a user can tag their pet as lost - which will make a special Newsboard Article appear with the pet and owner&apos;s information.</span>
        </p>
    </div>
    <div class="small-12 medium-6 columns">
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#modulepermissions"><b>Module Permissions</b></a> allow you to choose to enable this module and to which groups of users.</p>
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#add"><b>Add a Pet</b></a> using the addition form below.</p>
        <?php if ($countPETS != '0'){ ?><p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#pending"><b>Approve a pending pet</b></a> added by a user.</p><?php }; ?>
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#edit"><b>View and Edit</b></a> existing entries in your database.</p>
    </div>
</div>

<div style="max-width: 99%;">
<!-- MODULE PERMISSIONS -->
<a name="modulepermissions"></a>
<div class="nav-section-header-cp">
    <strong>Module Permissions</strong>
</div>
<?php echo($errorSUCCESS); ?>
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
	$query  = "SELECT * FROM tabs WHERE liaison = 'Y' AND `int1` BETWEEN '230' AND '230' ORDER BY `int1`";
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
<a name="add"></a>
<br>
<div class="nav-section-header-cp">
        <strong>Add a Pet</strong>
</div>
<form enctype="multipart/form-data" method="POST" action="pets.php">
<!-- UPLOAD FORM -->
<div class="cp-form-container">
<!-- COLUMN 1 -->
  <div class="small-12 medium-12 large-6 columns">
  	<div class="row" style="padding: 10px 10px 10px 0px;">
      <div class="small-12 medium-12 columns"><strong>1) Pet Information</strong></div>
    </div>
		<div class="row medium-collapse" style="padding-left: 30px;">
			<div class="small-12 medium-5 columns"><label for="petname" class="middle">What is the pet&apos;s name?</label></div>
			<div class="small-12 medium-7 end columns"><input name="petname" maxlength="100" class="form" type="text" placeholder="Bowser" autofocus></div>
		</div>
    <div class="row medium-collapse" style="padding-left: 30px;">
    	<div class="small-12 medium-5 columns"><label for="species" class="middle">What species is the pet?</label></div>
      <div class="small-12 medium-7 end columns">
<select name="species" required>
<option value="">Select the species of the pet</option>
<option value="Cat">Cat</option>
<option value="Dog">Dog</option>
<option value="Bird">Bird</option>
<option value="Pet">Other</option>
</select>
      </div>
    </div>
    <div class="row medium-collapse" style="padding-left: 30px;">
		<div class="small-12 medium-5 columns"><label for="breed" class="middle">Breed</label></div>
		<div class="small-12 medium-7 end columns"><input name="breed" maxlength="28" class="form" type="text" placeholder="Golden Retriever"></div>
	</div>
	<div class="row medium-collapse" style="padding-left: 30px;">
		<div class="small-12 medium-5 columns"><label for="weight" class="middle">Weight in <?php include('../my-documents/localization-weight.txt'); ?> (at maturity)</label></div>
		<div class="small-12 medium-7 end columns"><input name="weight" maxlength="6" class="form" type="number" placeholder="10"></div>
	</div>
	<div class="row medium-collapse" style="padding-left: 30px;">
		<div class="small-12 medium-5 columns"><label for="license" class="middle">License</label></div>
		<div class="small-12 medium-7 end columns"><input name="license" maxlength="28" class="form" type="text" placeholder="12345"></div>
	</div>
	<div class="row medium-collapse" style="padding-left: 30px;">
		<div class="small-12 medium-5 columns"><label for="vaccination" class="middle">Vaccination Date</label></div>
		<div class="small-12 medium-7 end columns"><input name="vaccination" maxlength="20" class="form datepicker" type="date" placeholder="YYYY-MM-DD"></div>
	</div>
	    <div class="row" style="padding: 10px 10px 10px 0px;">
			<div class="small-12 medium-12 columns"><strong>2) Photo</strong></div>
		</div>
		<div class="row medium-collapse" style="padding-left: 30px;">
			<div class="small-12 medium-12 end columns">
				<label for="file" class="middle"><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red"><b>REQUIRED!</b>  1 MB Maximum</span></label>
				<input type="file" name="userfile" id="userfile" required>
			</div>
		</div>
		<div class="row" style="padding: 10px 10px 0px 0px;">
      <div class="small-12 medium-12 columns"><strong>3) Who should this be registered to?</strong></div>
    </div>
    <div class="row medium-collapse" style="padding: 10px 10px 10px 30px;">
      <div class="small-12 medium-12 columns">
<?php include('userid-field.php'); ?><br>&nbsp;&nbsp;&nbsp;&nbsp;<i>Other</i> <input name="owner" maxlength="100" class="form" type="text" >
      </div>
    </div>
  </div>
<!-- COLUMN 1 -->
<!-- COLUMN 2 -->
	<div class="small-12 medium-12 large-6 columns">
		<div class="row" style="padding: 10px 10px 10px 0px;">
			<div class="small-12 medium-12 columns"><strong>4) Comments</strong></div>
		</div>
		<div class="row medium-collapse" style="padding-left: 30px;">
			<div class="small-12 medium-12 end columns" style="padding-bottom: 10px;">
				<label for="comments" class="middle">Comments &nbsp;&nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Comments ARE visible to users.</span><br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">If pasting content from Microsoft Word, use the "Paste from Word" ( <img src="https://condosites.net/commons/pastefromword.png" width="15"> ) button.</span><br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Use the Styles pulldown to stylize your text.</span></label>
				<textarea name="comments" cols="30" rows="2" id="editor1" class="form" type="text" placeholder="Comments"></textarea>
				<script>CKEDITOR.replace( 'editor1' );</script>
			</div>
		</div>
		<div class="row" style="padding: 10px 10px 10px 0px;">
			<div class="small-12 medium-12 columns"><strong>5) Approval and Lost</strong></div>
		</div>
		<div class="row medium-collapse" style="padding-left: 30px;">
				<div class="small-12 medium-5 columns"><label for="approved" class="middle">Is this pet approved?</label></div>
				<div class="small-12 medium-2 end columns">
<select name="approved">
<option value="Y">Yes</option>
<option value="N">No</option>
</select>
				</div>
		</div>
		<div class="row medium-collapse" style="padding-left: 30px;">
			<div class="small-12 medium-5 columns"><label for="lost" class="middle">Is this pet lost?</label></div>
			<div class="small-12 medium-2 end columns">
	<select name="lost">
	<option value="No">No</option>
	<option value="Yes">Yes</option>
	</select>
			</div>
		</div>
		<div class="row" style="padding: 10px 10px 10px 0px;">
			<div class="small-12 medium-6 columns"><strong>6) Ready to Save?</strong></div>
			<div class="small-12 medium-6 columns">
				<input name="action" value="upload" type="hidden">
				<input type="submit" name="submit" value="Submit" onclick="return confirm('Did you remember to attach a photo?');">
			</div>
		</div>
		<div class="row medium-collapse">
			<div class="small-12 medium-12 columns" align="center">
				<br><i class="fa fa-hand-o-down" aria-hidden="true"></i> Scroll down to see pets already added.
			</div>
		</div>
	</div>
<!-- COLUMN 2 -->
</div>
</form>
<!-- END UPLOAD FORM -->
<a name="pending"></a>
<br>
<!-- PENDING -->
<div class="nav-section-header-cp">
        <strong>
					<?php $sql = mysqli_query($conn,"SELECT count(*) FROM pets WHERE approved = 'N'") or die(mysqli_error($conn));
					//$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Pets Pending Approval </big></big> (
					<?php $sql = mysqli_query($conn,"SELECT count(*) FROM pets WHERE species = 'Cat' AND approved = 'N'") or die(mysqli_error($conn));
					//$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Cats /
					<?php $sql = mysqli_query($conn,"SELECT count(*) FROM pets WHERE species = 'Dog' AND approved = 'N'") or die(mysqli_error($conn));
					//$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Dogs /
					<?php $sql = mysqli_query($conn,"SELECT count(*) FROM pets WHERE species = 'Bird' AND approved = 'N'") or die(mysqli_error($conn));
					//$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Birds /
					<?php $sql = mysqli_query($conn,"SELECT count(*) FROM pets WHERE species = 'Other' AND approved = 'N'") or die(mysqli_error($conn));
					//$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Other )
				</strong>
</div>
<table width="95%" style="background-color:#eeeddd" align="center" border="0" cellpadding="5" cellspacing="1" class="text table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr align="left">
			<th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Pet</small></th>
			<th>&nbsp;&nbsp;&nbsp; <small>Photo</small></th>
			<th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Unit</small></th>
			<th class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <small>Species</small></th>
			<th class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <small>Lost</small></th>
    </tr>
  </thead>
  <tbody style="background-color:#ffffff">
<?php
	$query  = "SELECT * FROM pets WHERE approved = 'N' ORDER BY petname";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- DATABASE RESULTS -->
    <tr>
			<td>
				<div class="small-12 medium-12 large-8 columns">
<b>&quot;<?php echo "{$row['petname']}"; ?>&quot;</b><br>
<?php if ($row['breed'] != ''){ ?><?php echo "{$row['breed']}"; ?>, <?php }; ?><?php if ($row['weight'] != ''){ ?><?php echo "{$row['weight']}"; ?> in <?php include('../my-documents/localization-weight.txt'); ?> (at maturity).<?php }; ?><br>
<?php if ($row['vaccination'] != '0000-00-00'){ ?>Vaccination: <?php echo "{$row['vaccination']}"; ?><br><?php }; ?>
<?php echo "{$row['comments']}"; ?>
				</div>
		<div class="small-6 medium-6 large-2 columns">
				<form name="PetsEdit" method="POST" action="pets-edit.php">
					<input type="hidden" name="action" value="edit">
					<input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
					<input name="submit" value="Edit" class="submit" type="submit">
				</form>
        </div>
        <div class="small-6 medium-6 large-2 columns">
				<form method="POST" action="pets.php" onclick="return confirm('Are you sure you want to delete this <?php echo "{$row['species']}"; ?>?');">
					<input type="hidden" name="action" value="delete">
					<input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
					<input name="submit" value="Delete" class="submit" type="submit">
				</form>
        </div>
      </td>
			<td align="center" style="background-color:#ffffff">
<?php if ($row['name'] !== 'none.gif'){ ?>
<div style="max-width: 200px;">
	<a href="../download-pets.php?id=<?php echo "{$row['id']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('PETPHOTO/<?php echo "{$row['id']}"; ?>'); "><img src="../download-pets.php?id=<?php echo "{$row['id']}"; ?>"></a>
</div>
<?php }; ?>
			</td>
			<td>
	<?php if ($row['userid'] == '0'){ ?><b><?php echo "{$row['owner']}"; ?></b><?php }; ?>
<?php
	$type    = $row['userid'];
	$query1  = "SELECT first_name, last_name, email, phone, unit, unit2 FROM users WHERE id = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?>
	<b><?php echo "{$row1['first_name']}"; ?> <?php echo "{$row1['last_name']}"; ?></b>
	<br>Unit: <?php echo "{$row1['unit']}"; ?><?php if ($row1['unit2'] !== 'X'){ ?> <?php echo "{$row1['unit2']}"; ?><?php }; ?>
	<br><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row1['phone']); ?>"><?php echo "{$row1['phone']}"; ?></a>
	<br><a href="mailto:<?php echo "{$row1['email']}"; ?>"><?php echo "{$row1['email']}"; ?></a>
<?php
	}
?>
      </td>
			<td><?php echo "{$row['species']}"; ?></td>
      <td align="center"><?php echo "{$row['lost']}"; ?></td>
    </tr>
<!-- END DATABASE RESULTS -->
<?php
	}
?>
  </tbody>
</table>
<!-- END PENDING -->
<a name="edit"></a>
<br>
<!-- APPROVED -->
<div class="nav-section-header-cp">
        <strong>
			  <?php $sql = mysqli_query($conn,"SELECT count(*) FROM pets WHERE approved = 'Y'") or die(mysqli_error($conn));
			  //$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Approved Pets </big></big> (
		      <?php $sql = mysqli_query($conn,"SELECT count(*) FROM pets WHERE species = 'Cat' AND approved = 'Y'") or die(mysqli_error($conn));
		      //$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Cats /
		      <?php $sql = mysqli_query($conn,"SELECT count(*) FROM pets WHERE species = 'Dog' AND approved = 'Y'") or die(mysqli_error($conn));
		      //$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Dogs /
		      <?php $sql = mysqli_query($conn,"SELECT count(*) FROM pets WHERE species = 'Bird' AND approved = 'Y'") or die(mysqli_error($conn));
		      //$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Birds /
		      <?php $sql = mysqli_query($conn,"SELECT count(*) FROM pets WHERE species = 'Other' AND approved = 'Y'") or die(mysqli_error($conn));
		      //$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Other )
				</strong>
</div>
<table width="95%" style="background-color:#eeeddd" align="center" border="0" cellpadding="5" cellspacing="1" class="text table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr align="left">
			<th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Pet</small></th>
			<th>&nbsp;&nbsp;&nbsp; <small>Photo</small></th>
			<th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Unit</small></th>
			<th class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <small>Species</small></th>
			<th class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <small>Lost</small></th>
    </tr>
  </thead>
  <tbody style="background-color:#ffffff">
<?php
	$query  = "SELECT * FROM pets WHERE approved = 'Y' ORDER BY petname";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- DATABASE RESULTS -->
    <tr>
			<td>
				<div class="small-12 medium-12 large-8 columns">
<b>&quot;<?php echo "{$row['petname']}"; ?>&quot;</b><br>
<?php if ($row['breed'] != ''){ ?><?php echo "{$row['breed']}"; ?>, <?php }; ?><?php if ($row['weight'] != ''){ ?><?php echo "{$row['weight']}"; ?> in <?php include('../my-documents/localization-weight.txt'); ?> (at maturity).<?php }; ?><br>
<?php if ($row['vaccination'] != '0000-00-00'){ ?>Vaccination: <?php echo "{$row['vaccination']}"; ?><br><?php }; ?>
<?php echo "{$row['comments']}"; ?>
				</div>
				<div class="small-6 medium-6 large-2 columns">
					<form name="PetsEdit" method="POST" action="pets-edit.php">
					<input type="hidden" name="action" value="edit">
					<input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
					<input name="submit" value="Edit" class="submit" type="submit">
					</form>
        </div>
        <div class="small-6 medium-6 large-2 columns">
					<form method="POST" action="pets.php" onclick="return confirm('Are you sure you want to delete this <?php echo "{$row['species']}"; ?>?');">
					<input type="hidden" name="action" value="delete">
					<input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
					<input name="submit" value="Delete" class="submit" type="submit">
					</form>
        </div>
      </td>
			<td align="center" style="background-color:#ffffff">
<?php if ($row['name'] !== 'none.gif'){ ?>
<div style="max-width: 200px;">
	<a href="../download-pets.php?id=<?php echo "{$row['id']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('PETPHOTO/<?php echo "{$row['id']}"; ?>'); "><img src="../download-pets.php?id=<?php echo "{$row['id']}"; ?>"></a>
</div>
<?php }; ?>
			</td>
			<td>
	<?php if ($row['userid'] == '0'){ ?><b><?php echo "{$row['owner']}"; ?></b><?php }; ?>
<?php
	$type    = $row['userid'];
	$query1  = "SELECT first_name, last_name, email, phone, unit, unit2 FROM users WHERE id = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?>
	<b><?php echo "{$row1['first_name']}"; ?> <?php echo "{$row1['last_name']}"; ?></b>
	<br>Unit: <?php echo "{$row1['unit']}"; ?><?php if ($row1['unit2'] !== 'X'){ ?> <?php echo "{$row1['unit2']}"; ?><?php }; ?>
	<br><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row1['phone']); ?>"><?php echo "{$row1['phone']}"; ?></a>
	<br><a href="mailto:<?php echo "{$row1['email']}"; ?>"><?php echo "{$row1['email']}"; ?></a>
<?php
	}
?>
      </td>
			<td><?php echo "{$row['species']}"; ?></td>
      <td align="center"><?php echo "{$row['lost']}"; ?></td>
    </tr>
<!-- END DATABASE RESULTS -->
<?php
	}
?>
  </tbody>
</table>
<!-- CONTENT -->
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Pets Control Panel Page<br></div>
</body>
</html>
