<?php $current_page = '17'; include('protect.php'); $id = $_POST["id"]; $action = $_POST["action"];
	if ($action == "save"){

		$type = $_POST["type"];
		$doctype = $_POST["doctype"];
		$title = htmlspecialchars($_POST['title'], ENT_QUOTES);
		$docdate = $_POST["docdate"];
		$aod = $_POST["aod"];

		$query = "UPDATE documents SET type='$type', doctype='$doctype', title='$title', docdate='$docdate', aod='$aod' WHERE `id`='$id' LIMIT 1";
		mysqli_query($conn,$query) or die('Error, update query failed');

		$date = date("F j, Y");
		$query = "UPDATE updatedate SET date='$date'";
		mysqli_query($conn,$query) or die('Error, updating update date failed');

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('E', 'Documents-Board', '$useripaddress', '$userid', '$id')";
		mysqli_query($conn,$query) or die('Error, updating log failed');

		header('Location: documents-board.php');
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
	<script type="text/javascript">
	<!--
	  function showMe (it, box) {
		var vis = (box.checked) ? "block" : "none";
		document.getElementById(it).style.display = vis;
	  }
	  //-->
	</script>
</head>
<body>
<!-- LOGO AND NAVIGATION -->
<?php include('cp-navigation.php'); ?>
<!-- END LOGO AND NAVIGATION -->
<br>
<div style="max-width: 99%;">
<div class="nav-section-header-cp">
        <strong>Edit a Document</strong>
</div>
<?php
	$query  = "SELECT `id`, type, name, size, created_date, doctype, title, owner, lease, realtor, public, board, docdate, aod FROM documents WHERE `id`='$id' LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- UPLOAD FORM -->
<div class="cp-form-container">
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 0px 0px;">
<form enctype="multipart/form-data" method="POST" action="documents-edit-board.php">
            <div class="small-12 medium-12 columns"><strong>1) Uploaded Document</strong></div>
        </div>
        <div class="row medium-collapse" style="padding: 10px 10px 10px 30px;">
            <div class="small-12 medium-12 columns">
                <?php echo "{$row['name']}"; ?><br><span class="note-black">File size: <?php echo "{$row['size']}"; ?> bytes.  Uploaded: <?php echo "{$row['created_date']}"; ?></span>
                <select name="type" autofocus>
<option value="<?php echo "{$row['type']}"; ?>">Unknown</option>
<option value="<?php echo "{$row['type']}"; ?>"> </option>
<option value="image/jpeg" <?php if($row['type'] == "image/jpeg"){ echo("SELECTED"); } ?>>JPEG Image (.jpg)</option>
<option value="image/gif" <?php if($row['type'] == "image/gif"){ echo("SELECTED"); } ?>>GIF Image (.gif)</option>
<option value="image/png" <?php if($row['type'] == "image/png"){ echo("SELECTED"); } ?>>PNG Image (.png)</option>
<option value="application/plain" <?php if($row['type'] == "application/plain"){ echo("SELECTED"); } ?>>Plain Text (.txt)</option>
<option value="application/rtf" <?php if($row['type'] == "application/rtf"){ echo("SELECTED"); } ?>>Rich Text Format (.rtf)</option>
<option value="application/pdf" <?php if($row['type'] == "application/pdf"){ echo("SELECTED"); } ?>>PDF (.pdf)</option>
<option value="application/msword" <?php if($row['type'] == "application/msword"){ echo("SELECTED"); } ?>>MS Word (.doc)</option>
<option value="application/vnd.ms-excel" <?php if($row['type'] == "application/vnd.ms-excel"){ echo("SELECTED"); } ?>>MS Excel (.xls)</option>
<option value="application/zip" <?php if($row['type'] == "application/zip"){ echo("SELECTED"); } ?>>ZIP Archive (.zip)</option>
<option value="video/mp4" <?php if($row['type'] == "video/mp4"){ echo("SELECTED"); } ?>>MP4 Video (.mp4)</option>
<?php if ($row['type'] == 'image/pjpeg'){ ?><option value="<?php echo "{$row['type']}"; ?>">JPEG Image</option><?php }; ?>
<?php if ($row['type'] == 'application/download'){ ?><option value="<?php echo "{$row['type']}"; ?>">Miscelaneous Downloadable Format</option><?php }; ?>
<?php if ($row['type'] == 'application/octet-stream'){ ?><option value="<?php echo "{$row['type']}"; ?>">Miscelaneous Downloadable Format</option><?php }; ?>
                </select>
            </div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>2) Name the document...</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 columns"><input name="title" maxlength="100" class="form" type="text" value="<?php echo "{$row['title']}"; ?>" required><i class="fa fa-hand-o-right" aria-hidden="true"></i> <input type="checkbox" name="namingconventions" onclick="showMe('namingconventions', this)" /> <span class="note-red"><b>Show important tips on naming conventions.</b></span>
                <div id="namingconventions" style="display:none" class="note-black">
<ul>
    <li>A proper name will allow documents to group by subject and chronologically by default.</li>
    <li>Make the subject the first word of the document name.</li>
    <li>If a regularly published document, include the document date in YYYY-MM-DD format after the subject.</li>
    <li>Do NOT use the community name! (it&apos;s implied).</li>
    <li>Add additional specifics last.</li>
</ul>
                    <div class="small-6 columns" style="background-color: #ccffcc; padding: 10px">
<b>Correct</b><br>
Party for New Years 2017<br>
Financials 2017-03<br>
Minutes 2017-02-28 (BOD)<br>
Newsletter 2017-01<br>
Bylaws<br>
Declaration (Original)<br>
Declaration (1st Amendment)<br>
                    </div>
                    <div class="small-6 columns" style="background-color: #ffcccc; padding: 10px">
<b>Incorrect</b><br>
2017 New Years Party<br>
March 2017 Financials<br>
BOD Meeting Minutes 02/28/2017<br>
Spring Newsletter<br>
Community Bylaws<br>
Original Declaration<br>
1st Amendment to Declaration<br>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>3) Where should this document appear?</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 columns">
<select name="doctype" class="form" required>
<option value="<?php echo "{$row['doctype']}"; ?>"><?php echo "{$row['doctype']}"; ?></option>
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
    </div>
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 0px 0px;">
            <div class="small-12 medium-12 columns"><strong>4) Dates!</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-6 columns"><label for="docdate" class="middle">When was the subject of the document?<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">e.g. The date of a meeting.</span></label></div>
            <div class="small-12 medium-6 end columns"><input name="docdate" class="form datepicker" type="date" value="<?php echo "{$row['docdate']}"; ?>" required></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-6 columns"><label for="aod" class="middle">Delete after a particular date?<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Automatically deletes temporary documents.</span></label></div>
            <div class="small-12 medium-6 end columns"><input name="aod" class="form datepicker" type="date" value="<?php echo "{$row['aod']}"; ?>" ></div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>7) Ready to save your changes?</strong></div>
        </div>
        <div class="row medium-collapse">
            <div class="small-6 columns" align="center">
<input type="hidden" name="action" value="save">
<input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
<input name="submit" value="Save Changes" class="submit" type="submit">
            </div>
</form>
<form action="documents-board.php" method="get">
            <div class="small-6 columns" align="center">
<input type="submit" value="Cancel and Go Back" onclick="return confirm('Are you sure you wish to leave this page? Unsaved changes will be lost.');">
            </div>
</form>
        </div>
    </div>
</div>
</form>
<!-- END UPLOAD FORM -->
<?php
}
?>
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Documents Edit (Board) Control Panel Page<br></div>
</body>
</html>
