<?php $current_page = '2'; include('protect.php'); ?>
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
<?php $action = $_POST["action"]; if ($action != null){ ?>
<?php
	if ($action == "delete"){
		$id = $_POST["id"];
		$query = "DELETE FROM board WHERE `id`='$id'";
		mysqli_query($conn,$query) or die('Error, delete query failed');
		
		    $errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Your entry was deleted successfully.</strong></div>";

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('D', 'Board', '$useripaddress', '$userid', '$id')";
		mysqli_query($conn,$query) or die('Error, updating log failed');

		$query = "OPTIMIZE TABLE `board`";
		mysqli_query($conn,$query) or die('Error, delete query failed');

	}

	if ($action == "upload" && $_FILES['userfile']['size'] > '0'){

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
            $errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #FAFEB8; color: black;'><i class='fa fa-exclamation-triangle note' aria-hidden='true'></i> <strong>Your entry did not upload! The photo you attached is too large! Max size 1 MB.</strong></div>";
		}

        else if ($fileFormat != '1') {
			$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #FAFEB8; color: black;'><i class='fa fa-exclamation-triangle note' aria-hidden='true'></i> <strong>Your entry did not upload! The attachment is not a supported format.</strong></div>";
		}

		else {

		$query  = "INSERT INTO board (person, date, title, subposition, thirdposition, email, bio, grouping, name, size, type, content, docid ) VALUES ('$person', '$date', '$title', '$subposition', '$thirdposition', '$email', '$bio', '$grouping', '$fileName', '$fileSize', '$fileType', '$content', '$docid')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

			$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Your entry uploaded successfully.</strong></div>";

		}

	}
	
	if ($action == "upload" && $_FILES['userfile']['size'] == '0'){

		$person = htmlspecialchars($_POST['person'], ENT_QUOTES);
		$date = date('Y-m-d');
		$title = $_POST["title"];
		$subposition = $_POST["subposition"];
		$thirdposition = htmlspecialchars($_POST['thirdposition'], ENT_QUOTES);
		$email = htmlspecialchars($_POST['email'], ENT_QUOTES);
		$bio = $_POST["bio"];
		$docid = $_POST["docid"];
		$grouping = $_POST["grouping"];

		$query  = "INSERT INTO board (person, date, title, subposition, thirdposition, email, bio, grouping, docid ) VALUES ('$person', '$date', '$title', '$subposition', '$thirdposition', '$email', '$bio', '$grouping', '$docid')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

		$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Your entry uploaded successfully.</strong></div>";

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
<?php $sqlBSc = mysqli_query($conn,"SELECT count(*) FROM board") or die(mysqli_error($conn));
$row = mysqli_fetch_row($sqlBSc);
$countBSc = $row[0];
?>
<?php $sqlBS = mysqli_query($conn,"SELECT count(*) FROM board WHERE `date` > NOW() - INTERVAL 365 DAY") or die(mysqli_error($conn));
$row = mysqli_fetch_row($sqlBS);
$countBS = $row[0];
?>
<?php if ($countBS == '0' AND $countBSc >= '1'){ ?><i class="fa fa-exclamation-triangle note" aria-hidden="true"></i> <b>Is this content current?</b> Your board, committees and staff have not changed in a year.<?php }; ?>
<?php if ($countBS != '0' AND $countBSc >= '1'){ ?><i class="fa fa-check" aria-hidden="true"></i> Your board, committees and staff look like they are up to date.<?php }; ?>
<?php if ($countBSc < '1'){ ?><i class="fa fa-exclamation-triangle note" aria-hidden="true"></i> Looks like it&apos;s time to add your board and staff members!<?php }; ?>
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
<div style="max-width: 99%;">

<div class="row cp-help">
    <div class="small-12 medium-6 columns">
        <p>The <b>Board & Staff</b> control panel is an <b>information only</b> module used to tell your community about your board, committees, and staff members.
        There is room to add biographical text which is a great way to inform users about topics like:
        how long a board member has lived in the community or served on the board, their interests or hobbies,
        and if the entry is for a staff member, it can be helpful to display their work hours.</p>
    </div>
    <div class="small-12 medium-6 columns">
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#add"><b>Add a Board, Staff, or Committee member</b></a> using the addition form below.</p>
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#edit"><b>View and Edit</b></a> existing entries in your database.</p>
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#modulepermissions"><b>Module Permissions</b></a> allow you to choose what content should be seen by which groups of users.</p>
    </div>
</div>

<a name="add"></a>
<div class="nav-section-header-cp">
        <strong>Add a Board, Staff, or Committee Member</strong>
</div>
<?php echo($errorSUCCESS); ?>
<form enctype="multipart/form-data" method="POST" action="board.php">
<!-- UPLOAD FORM -->
<div class="cp-form-container">
<!-- COLUMN 1 -->
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>1) Member Information</strong></div>
        </div>
		<div class="row medium-collapse" style="padding-left: 30px;">
			<div class="small-12 medium-5 columns"><label for="person" class="middle">What is the member&apos;s name?</label></div>
			<div class="small-12 medium-7 end columns"><input name="person" maxlength="100" class="form" type="text" placeholder="John Doe" required autofocus></div>
		</div>
		<div class="row medium-collapse" style="padding-left: 30px;">
			<div class="small-12 medium-5 columns"><label for="email" class="middle">What is their email address? (optional)</label></div>
			<div class="small-12 medium-7 end columns"><input name="email" maxlength="100" class="form" type="email" placeholder="johndoe@email.com"></div>
		</div>
		<div class="row" style="padding: 10px 10px 10px 0px;">
			<div class="small-12 medium-12 columns"><strong>2) Member Affiliation</strong></div>
		</div>
        <div class="row medium-collapse" style="padding-left: 30px;">
    	<div class="small-12 medium-5 columns"><label for="grouping" class="middle">How should this member be grouped?</label></div>
        <div class="small-12 medium-7 end columns">
			<select name="grouping" required>
			    <option value="">Select a Grouping</option>
			    <option value="Staff">Staff</option>
			    <option value="Board">Board</option>
			    <option value="Committee">Committee</option>
			</select>
		</div>
    </div>
	<div class="row medium-collapse" style="padding-left: 30px;">
        <div class="small-12 medium-5 columns"><label for="title" class="middle">What is this member&apos;s title?</label></div>
        <div class="small-12 medium-7 end columns">
			<select name="title" required>
				<option value="">Select a Position</option>
				<option value="" disabled>*** Staff ***</option>
				<option value="Manager">Manager</option>
				<option value="Head Concierge">Head Concierge</option>
				<option value="Concierge">Concierge</option>
				<option value="Front Desk">Front Desk</option>
				<option value="Maintenance">Maintenance</option>
				<option value="Security">Security</option>
				<option value="Porter">Porter</option>
				<option value="Doorman">Doorman</option>
				<option value="">Other (no label will be applied)</option>
				<option value="" disabled> </option>
				<option value="" disabled>*** Board ***</option>
				<option value="President">President</option>
				<option value="Vice-President">Vice-President</option>
				<option value="Treasurer">Treasurer</option>
				<option value="Secretary">Secretary</option>
				<option value="Board Member">Board Member</option>
				<option value="Member">Member</option>
				<option value="Member at Large">Member at Large</option>
				<option value="Commercial">Commercial</option>
				<option value="Director">Director</option>
				<option value="Officer">Officer</option>
				<option value="">Other (no label will be applied)</option>
				<option value="" disabled> </option>
				<option value="" disabled>*** Committee ***</option>
				<option value="Committee Chair">Committee Chair</option>
				<option value="Committee Member">Committee Member</option>
				<option value="">Other (no label will be applied)</option>
			</select>
        </div>
    </div>
	<div class="row medium-collapse" style="padding-left: 30px;">
		<div class="small-12 medium-5 columns"><label for="subposition" class="middle">Does this member need a sub-title?</label></div>
			<div class="small-12 medium-7 end columns"><input name="subposition" maxlength="100" class="form" type="text" placeholder="e.g. CHAIRMAN AND President"></div>
		</div>
		<div class="row medium-collapse" style="padding-left: 30px;">
			<div class="small-12 medium-5 columns"><label for="thirdposition" class="middle">Does this member need a post-title?</label></div>
			<div class="small-12 medium-7 end columns"><input name="thirdposition" maxlength="100" class="form" type="text" placeholder="e.g. President AND CHAIRMAN"></div>
		</div>
		<div class="row" style="padding: 10px 10px 10px 0px;">
			<div class="small-12 medium-12 columns"><strong>3) Member Photo (optional)</strong></div>
		</div>
		<div class="row medium-collapse" style="padding-left: 30px;">
			<div class="small-12 medium-12 end columns">
				<label for="file" class="middle">
				    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">1 MB Maximum</span><br>
				    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Only JPEG/GIF/PNG formats</span><br>
					<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Remember to crop tightly! Photos will be displayed at 75 pixels wide.</span>
				</label>
				<input type="file" name="userfile" id="userfile">
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
				<label for="bio" class="middle">Comments/Biography &nbsp;&nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Comments ARE visible to users.</span><br>
				    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">If pasting content from Microsoft Word, use the "Paste from Word" ( <img src="https://condosites.net/commons/pastefromword.png" width="15"> ) button.</span><br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Use the Styles pulldown to apply <b><span class="bluepen">c</span><span class="greenpen">o</span><span class="bluepen">l</span><span class="greenpen">o</span><span class="bluepen">r</span></b> and formatting <span class="marker">styles</span> to your text.</span>
				</label>
				<textarea name="bio" cols="30" rows="2" id="editor1" class="form" type="text" placeholder="Comments/Biography"></textarea>
				<script>CKEDITOR.replace( 'editor1' );</script>
			</div>
		</div>
<?php include('docid-field.php'); ?>
		<div class="row" style="padding: 10px 10px 10px 0px;">
			<div class="small-12 medium-6 columns"><strong>5) Ready to Save?</strong></div>
			<div class="small-12 medium-6 columns">
				<input name="action" value="upload" type="hidden">
				<input type="submit" name="submit" value="Submit">
			</div>
		</div>
		<div class="row medium-collapse">
			<div class="small-12 medium-12 columns" align="center">
				<br><i class="fa fa-hand-o-down" aria-hidden="true"></i> Scroll down to see entries already added.
			</div>
		</div>
	</div>
<!-- COLUMN 2 -->
</div>
</form>
<!-- END UPLOAD FORM -->
<a name="edit"></a>
<br>
<div class="nav-section-header-cp">
        <strong>
            <?php $sql = mysqli_query($conn,"SELECT count(*) FROM board") or die(mysqli_error($conn));
            //$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
        $count = $row[0];
            print($count); ?> People </big></big>(
            <?php $sql = mysqli_query($conn,"SELECT count(*) FROM board WHERE grouping = 'Board'") or die(mysqli_error($conn));
            //$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
        $count = $row[0];
            print($count); ?> Board /
            <?php $sql = mysqli_query($conn,"SELECT count(*) FROM board WHERE grouping = 'Committee'") or die(mysqli_error($conn));
            //$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
        $count = $row[0];
            print($count); ?> Committee /
            <?php $sql = mysqli_query($conn,"SELECT count(*) FROM board WHERE grouping = 'Staff'") or die(mysqli_error($conn));
            //$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
        $count = $row[0];
            print($count); ?> Staff )
		</strong>
</div>
<table width="95%" style="background-color:#eeeddd" align="center" border="0" cellpadding="5" cellspacing="1" class="text table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
    <thead>
        <tr align="left">
            <th class="table-sortable:alphanumeric"><b>&nbsp;&nbsp;&nbsp;<small>Person</small></b></th>
            <th align="center"><b><small>Photo</small></b></th>
            <th width="50" class="table-sortable:numeric">&nbsp;&nbsp;&nbsp;<small>ID</small></th>
            <th class="table-sortable:alphanumeric table-filterable"><b>&nbsp;&nbsp;&nbsp;<small>Grouping</small></b></th>
            <th class="table-sortable:alphanumeric table-filterable"><b>&nbsp;&nbsp;&nbsp;<small>Position</small></b></th>
        </tr>
    </thead>
    <tbody style="background-color:#ffffff">
<?php
	$query  = "SELECT * FROM board ORDER BY person";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- DATABASE RESULTS -->
        <tr>
            <td>
				<div class="small-12 medium-12 large-8 columns">
				    <b><?php echo "{$row['person']}"; ?></b><br>
				    <a href="mailto:<?php echo "{$row['email']}"; ?>"><?php echo "{$row['email']}"; ?></a><br>
				    <?php if ($row['bio'] !== ''){ ?><blockquote><?php echo "{$row['bio']}"; ?></blockquote><?php }; ?>
				</div>
				<div class="small-6 medium-6 large-2 columns">
					<form name="BoardEdit" method="POST" action="board-edit.php">
				        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
                        <input name="submit" value="Edit" class="submit" type="submit">
					</form>
                </div>
                <div class="small-6 medium-6 large-2 columns">
					<form method="POST" action="board.php" onclick="return confirm('Are you sure you want to delete <?php echo "{$row['person']}"; ?>?');">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
                        <input name="submit" value="Delete" class="submit" type="submit">
					</form>
                </div>
			</td>
            <td valign="top"><?php if ($row['name'] !== ''){ ?><?php if ($row['name'] !== 'none'){ ?><div style="max-width:200px;"><img src="../download-board.php?id=<?php echo"{$row['id']}"; ?>" alt="<?php echo "{$row['title']}"; ?>"></div><?php }; ?><?php }; ?></td>
			<td align="left"><?php echo "{$row['id']}"; ?></td>
            <td><?php echo "{$row['grouping']}"; ?></td>
            <td><?php if ($row['subposition'] !== ''){ ?><?php echo "{$row['subposition']}"; ?>&nbsp;<?php }; ?><?php echo "{$row['title']}"; ?> <?php echo "{$row['thirdposition']}"; ?></td>
        </tr>
<!-- END DATABASE RESULTS -->
<?php
	}
?>
    </tbody>
</table>
</div>

<div style="max-width: 99%;">
<a name="modulepermissions"></a>
<br>
<!-- MODULE PERMISSIONS -->
<div class="nav-section-header-cp">
    <strong>Module Permissions</strong>
</div>
<br>
<div class="cp-help">
    <div class="small-12 medium-6 columns">
        <p><b>Module Permissions allow you to choose what content should be seen by which groups of users.</b></p>
    </div>
    <div class="small-12 medium-6 columns">
        <p>
            <i class="fa fa-hand-o-right" aria-hidden="true"></i> You may choose to use a combination of modules with different permissions.
        </p>
    </div>
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
	$module = "board.php";
	$query  = "SELECT * FROM tabs WHERE liaison = 'Y' AND `int1` BETWEEN '201' AND '203' ORDER BY `int1`";
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
<br>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Board and Staff Control Panel Page<br></div>
</body>
</html>
