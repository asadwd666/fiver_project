<?php $current_page = '12'; include('protect.php'); $id = $_POST["id"]; $action = $_POST["action"]; if ($action == "save"){

    if ($action == "save" && $_FILES['userfile']['size'] == '0'){

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

		$query = "UPDATE pets SET species='$species', breed='$breed', weight='$weight', license='$license', vaccination='$vaccination', lost='$lost', petname='$petname', owner='$owner', userid='$userid', comments='$comments', approved='$approved' WHERE `id`='$id' LIMIT 1";
		mysqli_query($conn,$query) or die('Error, update query failed');

		$date = date("F j, Y");
		$query = "UPDATE updatedate SET date='$date'";
		mysqli_query($conn,$query) or die('Error, updating update date failed');

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('E', 'Pets', '$useripaddress', '$userid', '$id')";
		mysqli_query($conn,$query) or die('Error, updating log failed');

		header('Location: pets.php');
    }
    
    if ($action == "save" && $_FILES['userfile']['size'] > '0'){
        
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

		$query = "UPDATE pets SET breed='$breed', weight='$weight', license='$license', vaccination='$vaccination', lost='$lost', petname='$petname', owner='$owner', userid='$userid', comments='$comments', approved='$approved', name='$fileName', type='$fileType', size='$fileSize', content='$content' WHERE `id`='$id' LIMIT 1";
		mysqli_query($conn,$query) or die('Error, update query failed');

		$date = date("F j, Y");
		$query = "UPDATE updatedate SET date='$date'";
		mysqli_query($conn,$query) or die('Error, updating update date failed');

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('E', 'Pets', '$useripaddress', '$userid', '$id')";
		mysqli_query($conn,$query) or die('Error, updating log failed');

		header('Location: pets.php');
		}
    }    
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
        <strong>Edit a Pet</strong>
</div>
<?php
	$query  = "SELECT * FROM pets WHERE `id`='$id' LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- UPLOAD FORM -->
<div class="cp-form-container">
<!-- COLUMN 1 -->
  <div class="small-12 medium-12 large-6 columns">
  	<div class="row" style="padding: 10px 10px 10px 0px;">
<form enctype="multipart/form-data" method="POST" action="pets-edit.php">
      <div class="small-12 medium-12 columns"><strong>1) Pet Information</strong></div>
    </div>
		<div class="row medium-collapse" style="padding-left: 30px;">
			<div class="small-12 medium-5 columns"><label for="petname" class="middle">What is the pet&apos;s name?</label></div>
			<div class="small-12 medium-7 end columns"><input name="petname" maxlength="100" class="form" type="text" placeholder="Bowser" value="<?php echo "{$row['petname']}"; ?>" autofocus></div>
		</div>
    <div class="row medium-collapse" style="padding-left: 30px;">
    	<div class="small-12 medium-5 columns"><label for="species" class="middle">What species is the pet?</label></div>
      <div class="small-12 medium-7 end columns">
<select name="species" required>
	<option value="Cat" <?php if($row['species'] == "Cat"){ echo("SELECTED"); } ?>>Cat</option>
	<option value="Dog" <?php if($row['species'] == "Dog"){ echo("SELECTED"); } ?>>Dog</option>
	<option value="Bird" <?php if($row['species'] == "Bird"){ echo("SELECTED"); } ?>>Bird</option>
	<option value="Other" <?php if($row['species'] == "Other"){ echo("SELECTED"); } ?>>Other</option>
</select>
      </div>
    </div>
    <div class="row medium-collapse" style="padding-left: 30px;">
		<div class="small-12 medium-5 columns"><label for="breed" class="middle">Breed</label></div>
		<div class="small-12 medium-7 end columns"><input name="breed" maxlength="28" class="form" type="text" placeholder="Golden Retriever" value="<?php echo "{$row['breed']}"; ?>"></div>
	</div>
	<div class="row medium-collapse" style="padding-left: 30px;">
		<div class="small-12 medium-5 columns"><label for="weight" class="middle">Weight in <?php include('../my-documents/localization-weight.txt'); ?> (at maturity)</label></div>
		<div class="small-12 medium-7 end columns"><input name="weight" maxlength="6" class="form" type="number" placeholder="10" value="<?php echo "{$row['weight']}"; ?>"></div>
	</div>
	<div class="row medium-collapse" style="padding-left: 30px;">
		<div class="small-12 medium-5 columns"><label for="license" class="middle">License</label></div>
		<div class="small-12 medium-7 end columns"><input name="license" maxlength="28" class="form" type="text" placeholder="12345" value="<?php echo "{$row['license']}"; ?>"></div>
	</div>
	<div class="row medium-collapse" style="padding-left: 30px;">
		<div class="small-12 medium-5 columns"><label for="vaccination" class="middle">Vaccination Date</label></div>
		<div class="small-12 medium-7 end columns"><input name="vaccination" maxlength="20" class="form datepicker" type="date" placeholder="YYYY-MM-DD" value="<?php echo "{$row['vaccination']}"; ?>"></div>
	</div>
		<div class="row" style="padding: 10px 10px 10px 0px;">
			<div class="small-12 medium-12 columns"><strong>2) Pet Photo</strong></div>
		</div>
		<div class="row medium-collapse" style="padding-left: 30px;">
    		<div class="small-12 medium-3 end columns">
	    		<img align="left" src="../download-pets.php?id=<?php echo "{$row['id']}"; ?>" alt="<?php echo "{$row['title']}"; ?>" style="max-height: 75px; max-width: 125px;" hspace="15" vspace="10">
	    	</div>
	    	<div class="small-12 medium-9 end columns">
	    		<label for="file" class="middle">
		    	    Upload new photo (optional)<br>
		    		<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">1 MB Maximum</span>
		    	</label>
		    	<input type="file" name="userfile" id="userfile">
		    </div>
		</div>
		<div class="row" style="padding: 10px 10px 0px 0px;">
      <div class="small-12 medium-12 columns"><strong>3) Who should this be registered to?</strong></div>
    </div>
    <div class="row medium-collapse" style="padding: 10px 10px 10px 30px;">
      <div class="small-12 medium-12 columns">
<?php include('userid-field-edit.php'); ?><br>&nbsp;&nbsp;&nbsp;&nbsp;<i>Other</i> <input name="owner" maxlength="100" class="form" type="text" >
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
				<label for="comments" class="middle">Comments <i class="fa fa-hand-o-right" aria-hidden="true"></i> &nbsp;&nbsp;&nbsp;<span class="note-red">Comments ARE visible to users.</span></label>
				<textarea name="comments" cols="30" rows="2" id="editor1" class="form" type="text" placeholder="Comments"><?php echo "{$row['comments']}"; ?></textarea>
				<script>CKEDITOR.replace( 'editor1' );</script>
			</div>
		</div>
		<div class="row" style="padding: 10px 10px 10px 0px;">
				<div class="small-12 medium-12 columns"><strong>5) Approval and Lost</strong></div>
		</div>
		<div class="row medium-collapse" style="padding-left: 30px;">
			<div class="small-12 medium-5 columns"><label for="lost" class="middle">Is this pet lost?</label></div>
			<div class="small-12 medium-2 end columns">
	<select name="lost">
		<option value="Yes" <?php if($row['lost'] == "Yes"){ echo("SELECTED"); } ?>>Yes</option>
		<option value="No" <?php if($row['lost'] == "No"){ echo("SELECTED"); } ?>>No</option>
	</select>
			</div>
		</div>
		<div class="row medium-collapse" style="padding-left: 30px; <?php if ($row['approved'] == 'N'){ ?>background-color: #ffcccc; padding-top: 10px; margin-right: -10px; padding-right: 10px; <?php }; ?>">
				<div class="small-12 medium-5 columns"><label for="approved" class="middle">Is this pet approved?</label></div>
				<div class="small-12 medium-2 end columns">
<select name="approved">
	<option value="Y" <?php if($row['approved'] == "Y"){ echo("SELECTED"); } ?>>Yes</option>
	<option value="N" <?php if($row['approved'] == "N"){ echo("SELECTED"); } ?>>No</option>
</select>
				</div>
		</div>
		<div class="row" style="padding: 10px 10px 10px 0px;">
				<div class="small-12 medium-12 columns"><strong>6) Ready to Save?</strong></div>
		</div>
		<div class="row medium-collapse">
				<div class="small-6 columns" align="center">
					<input type="hidden" name="action" value="save">
					<input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
					<input name="submit" value="Save" class="submit" type="submit">
				</div>
</form>
				<div class="small-6 end columns" align="center">
<form action="pets.php" method="get">
<input type="submit" value="Cancel and Go Back" onclick="return confirm('Are you sure you wish to leave this page? Unsaved changes will be lost.');">
</form>
				</div>
		</div>
	</div>
<!-- COLUMN 2 -->
</div>
<!-- END UPLOAD FORM -->

<?php
	}
?>
<!-- END UPLOAD FORM -->
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Pets Edit Control Panel Page<br></div>
</body>
</html>
