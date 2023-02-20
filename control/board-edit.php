<?php $current_page = '2'; include('protect.php'); $id = $_POST["id"]; $action = $_POST["action"];
	
	if ($action == "save" && $_FILES['userfile']['size'] == '0'){

		$person = htmlspecialchars($_POST['person'], ENT_QUOTES);
		$date = date('Y-m-d');
		$title = $_POST["title"];
		$subposition = $_POST["subposition"];
		$thirdposition = htmlspecialchars($_POST['thirdposition'], ENT_QUOTES);
		$email = htmlspecialchars($_POST['email'], ENT_QUOTES);
		$bio = $_POST["bio"];
		$docid = $_POST["docid"];
		$grouping = $_POST["grouping"];

		$query = "UPDATE board SET person='$person', date='$date', title='$title', subposition='$subposition', thirdposition='$thirdposition', email='$email', bio='$bio', docid='$docid', grouping='$grouping' WHERE `id`='$id' LIMIT 1";
		mysqli_query($conn,$query) or die('Error, update query failed');

		$date = date("F j, Y");
		$query = "UPDATE updatedate SET date='$date'";
		mysqli_query($conn,$query) or die('Error, updating update date failed');

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('E', 'Board', '$useripaddress', '$userid', '$id')";
		mysqli_query($conn,$query) or die('Error, updating log failed');

		header('Location: board.php');
	}
	
	if ($action == "save" && $_FILES['userfile']['size'] > '0'){

		$person = htmlspecialchars($_POST['person'], ENT_QUOTES);
		$date = date('Y-m-d');
		$title = $_POST["title"];
		$subposition = $_POST["subposition"];
		$thirdposition = htmlspecialchars($_POST['thirdposition'], ENT_QUOTES);
		$email = htmlspecialchars($_POST['email'], ENT_QUOTES);
		$bio = $_POST["bio"];
		$docid = $_POST["docid"];
		$grouping = $_POST["grouping"];
		
		$fileName = $_FILES['userfile']['name'];
		$tmpName  = $_FILES['userfile']['tmp_name'];
		$fileSize = $_FILES['userfile']['size'];
		$fileType = $_FILES['userfile']['type'];
		
		$fp      = fopen($tmpName, 'r');
		$content = fread($fp, filesize($tmpName));
		$content = addslashes($content);
		fclose($fp);
		
		$fileFormat == '0';

        if($fileType == 'image/gif') { $fileFormat = '1' ;}
        if($fileType == 'image/jpeg') { $fileFormat = '1' ;}
        if($fileType == 'image/pjpeg') { $fileFormat = '1' ;}
        if($fileType == 'image/png') { $fileFormat = '1' ;}

		if (!get_magic_quotes_gpc())
		{
			$fileName = addslashes($fileName);
		}
		
		if ($fileSize >= '1500000') {
			$success = "false";
			$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #FAFEB8; color: black;'><i class='fa fa-exclamation-triangle note' aria-hidden='true'></i> <strong>The photo you attached is too large! Max size 1 MB.</strong></div>";
		}

        else if ($fileFormat != '1') {
			$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #FAFEB8; color: black;'><i class='fa fa-exclamation-triangle note' aria-hidden='true'></i> <strong>Your entry did not upload! The attachment is not a supported format.</strong></div>";
		}

        else {

		$query = "UPDATE board SET person='$person', date='$date', title='$title', subposition='$subposition', thirdposition='$thirdposition', email='$email', bio='$bio', docid='$docid', grouping='$grouping', name='$fileName', type='$fileType', size='$fileSize', content='$content' WHERE `id`='$id' LIMIT 1";
		mysqli_query($conn,$query) or die('Error, update query failed');

		$date = date("F j, Y");
		$query = "UPDATE updatedate SET date='$date'";
		mysqli_query($conn,$query) or die('Error, updating update date failed');

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('E', 'Board', '$useripaddress', '$userid', '$id')";
		mysqli_query($conn,$query) or die('Error, updating log failed');

		header('Location: board.php');
        }
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
<div class="nav-section-header-cp">
        <strong>Edit a Board, Staff, or Committee Member</strong>
</div>
<?php
	$query  = "SELECT `id`, name, size, created_date, person, title, subposition, thirdposition, email, bio, docid, grouping FROM board WHERE `id`='$id' LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- UPLOAD FORM -->
<?php echo($errorSUCCESS); ?>
<div class="cp-form-container">
<!-- COLUMN 1 -->
  <div class="small-12 medium-12 large-6 columns">
  	<div class="row" style="padding: 10px 10px 10px 0px;">
<form enctype="multipart/form-data" method="POST" action="board-edit.php">
      <div class="small-12 medium-12 columns"><strong>1) Member Information</strong></div>
    </div>
		<div class="row medium-collapse" style="padding-left: 30px;">
			<div class="small-12 medium-5 columns"><label for="person" class="middle">What is the member&apos;s name?</label></div>
			<div class="small-12 medium-7 end columns"><input name="person" maxlength="100" class="form" type="text" placeholder="John Doe" value="<?php echo "{$row['person']}"; ?>" required autofocus></div>
		</div>
		<div class="row medium-collapse" style="padding-left: 30px;">
			<div class="small-12 medium-5 columns"><label for="email" class="middle">What is their email address?</label></div>
			<div class="small-12 medium-7 end columns"><input name="email" maxlength="100" class="form" type="email" placeholder="johndoe@email.com" value="<?php echo "{$row['email']}"; ?>"></div>
		</div>
		<div class="row" style="padding: 10px 10px 10px 0px;">
			<div class="small-12 medium-12 columns"><strong>2) Member Affiliation</strong></div>
		</div>
    <div class="row medium-collapse" style="padding-left: 30px;">
    	<div class="small-12 medium-5 columns"><label for="grouping" class="middle">How should this member be grouped?</label></div>
      <div class="small-12 medium-7 end columns">
			<select name="grouping" required>
				<option value="Board" <?php if($row['grouping'] == "Board"){ echo("SELECTED"); } ?>>Board</option>
				<option value="Committee" <?php if($row['grouping'] == "Committee"){ echo("SELECTED"); } ?>>Committee</option>
				<option value="Staff" <?php if($row['grouping'] == "Staff"){ echo("SELECTED"); } ?>>Staff</option>
			</select>
      </div>
    </div>
		<div class="row medium-collapse" style="padding-left: 30px;">
    	<div class="small-12 medium-5 columns"><label for="title" class="middle">What is this member&apos;s title?</label></div>
      <div class="small-12 medium-7 end columns">
			<select name="title" required>
				<option value=" "></option>
				<option value="" disabled>*** Staff ***</option>
				<option value="Manager" <?php if($row['title'] == "Manager"){ echo("SELECTED"); } ?>>Manager</option>
				<option value="Head Concierge" <?php if($row['title'] == "Head Concierge"){ echo("SELECTED"); } ?>>Head Concierge</option>
				<option value="Concierge" <?php if($row['title'] == "Concierge"){ echo("SELECTED"); } ?>>Concierge</option>
				<option value="Front Desk" <?php if($row['title'] == "Front Desk"){ echo("SELECTED"); } ?>>Front Desk</option>
				<option value="Maintenance" <?php if($row['title'] == "Maintenance"){ echo("SELECTED"); } ?>>Maintenance</option>
				<option value="Security" <?php if($row['title'] == "Security"){ echo("SELECTED"); } ?>>Security</option>
				<option value="Porter" <?php if($row['title'] == "Porter"){ echo("SELECTED"); } ?>>Porter</option>
				<option value="Doorman" <?php if($row['title'] == "Doorman"){ echo("SELECTED"); } ?>>Doorman</option>
				<option value="" <?php if($row['title'] == ""){ echo("SELECTED"); } ?>>Other (no label will be applied)</option>
				<option value="" disabled></option>
				<option value="" disabled>*** Board ***</option>
				<option value="President" <?php if($row['title'] == "President"){ echo("SELECTED"); } ?>>President</option>
				<option value="Vice-President" <?php if($row['title'] == "Vice-President"){ echo("SELECTED"); } ?>>Vice-President</option>
				<option value="Treasurer" <?php if($row['title'] == "Treasurer"){ echo("SELECTED"); } ?>>Treasurer</option>
				<option value="Secretary" <?php if($row['title'] == "Secretary"){ echo("SELECTED"); } ?>>Secretary</option>
				<option value="Board Member" <?php if($row['title'] == "Board Member"){ echo("SELECTED"); } ?>>Board Member</option>
				<option value="Member" <?php if($row['title'] == "Member"){ echo("SELECTED"); } ?>>Member</option>
				<option value="Member at Large" <?php if($row['title'] == "Member at Large"){ echo("SELECTED"); } ?>>Member at Large</option>
				<option value="Director" <?php if($row['title'] == "Director"){ echo("SELECTED"); } ?>>Director</option>
				<option value="Officer" <?php if($row['title'] == "Officer"){ echo("SELECTED"); } ?>>Officer</option>
				<option value="" <?php if($row['title'] == ""){ echo("SELECTED"); } ?>>Other (no label will be applied)</option>
				<option value="" disabled></option>
				<option value="" disabled>*** Committee ***</option>
				<option value="Committee Chair" <?php if($row['title'] == "Committee Chair"){ echo("SELECTED"); } ?>>Committee Chair</option>
				<option value="Committee Member" <?php if($row['title'] == "Committee Member"){ echo("SELECTED"); } ?>>Committee Member</option>
				<option value="" <?php if($row['title'] == ""){ echo("SELECTED"); } ?>>Other (no label will be applied)</option>
			</select>
      </div>
    </div>
		<div class="row medium-collapse" style="padding-left: 30px;">
			<div class="small-12 medium-5 columns"><label for="subposition" class="middle">Does this member need a sub-title?</label></div>
			<div class="small-12 medium-7 end columns"><input name="subposition" maxlength="100" class="form" type="text" placeholder="e.g. CHAIRMAN AND President" value="<?php echo "{$row['subposition']}"; ?>"></div>
		</div>
		<div class="row medium-collapse" style="padding-left: 30px;">
			<div class="small-12 medium-5 columns"><label for="thirdposition" class="middle">Does this member need a post-title?</label></div>
			<div class="small-12 medium-7 end columns"><input name="thirdposition" maxlength="100" class="form" type="text" placeholder="e.g. President AND CHAIRMAN" value="<?php echo "{$row['thirdposition']}"; ?>"></div>
		</div>
		<div class="row" style="padding: 10px 10px 10px 0px;">
			<div class="small-12 medium-12 columns"><strong>3) Member Photo</strong></div>
		</div>
		<div class="row medium-collapse" style="padding-left: 30px;">
			<div class="row medium-collapse" style="padding-left: 30px;">
					<div class="small-12 medium-3 end columns">
					    <?php if ($row['name'] !== '' AND $row['name'] !== 'none.gif'){ ?>
						    <img src="../download-board.php?id=<?php echo"{$row['id']}"; ?>" alt="<?php echo "{$row['title']}"; ?>" style="max-height: 75px; max-width: 125px;" hspace="15" vspace="10">
                        <?php }; ?>
					</div>
					<div class="small-12 medium-9 end columns">
						<label for="file" class="middle">
						    Upload new photo (optional)<br>
						    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">1 MB Maximum</span><br>
						    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Only JPEG/GIF/PNG formats</span><br>
					        <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Remember to crop tightly! Photos will be displayed at 75 pixels wide.</span>
						</label>
						<input type="file" name="userfile" id="userfile">
					</div>
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
				<label for="bio" class="middle">Comments/Biography  &nbsp;&nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Comments ARE visible to users.</span><br>
				    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">If pasting content from Microsoft Word, use the "Paste from Word" ( <img src="https://condosites.net/commons/pastefromword.png" width="15"> ) button.</span><br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Use the Styles pulldown to apply <b><span class="bluepen">c</span><span class="greenpen">o</span><span class="bluepen">l</span><span class="greenpen">o</span><span class="bluepen">r</span></b> and formatting <span class="marker">styles</span> to your text.</span>
				</label>
				<textarea name="bio" cols="30" rows="2" id="editor1" class="form" type="text" placeholder="Comments/Biography"><?php echo "{$row['bio']}"; ?></textarea>
				<script>CKEDITOR.replace( 'editor1' );</script>
			</div>
		</div>
<?php include('docid-field-edit.php'); ?>
		<div class="row" style="padding: 10px 10px 10px 0px;">
				<div class="small-12 medium-12 columns"><strong>5) Ready to Save?</strong></div>
		</div>
		<div class="row medium-collapse">
				<div class="small-6 columns" align="center">
					<input type="hidden" name="action" value="save">
					<input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
					<input name="submit" value="Save" class="submit" type="submit">
				</div>
</form>
				<div class="small-6 end columns" align="center">
<form action="board.php" method="get">
<input type="submit" value="Cancel and Go Back" onclick="return confirm('Are you sure you wish to leave this page? Unsaved changes will be lost.');">
</form>
				</div>
		</div>
	</div>
<!-- COLUMN 2 -->
</div>
</form>
<!-- END UPLOAD FORM -->
<?php
	}
?>
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Board and Staff Edit Control Panel Page<br></div>
</body>
</html>
