<?php $current_page = '14'; include('protect.php'); ?>
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
<?php $action = $_POST["action"]; if ($action != null){ ?>
<?php
	if ($action == "delete"){
		$id = $_POST["id"];
		$query = "DELETE FROM documentsrestricted WHERE `id`='$id'";
		mysqli_query($conn,$query) or die('Error, delete query failed');

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('D', 'Documents Restricted', '$useripaddress', '$userid', '$id')";
		mysqli_query($conn,$query) or die('Error, updating log failed');

		$query = "OPTIMIZE TABLE `documents`";
		mysqli_query($conn,$query) or die('Error, delete query failed');

	}
	if ($action == "upload" && $_FILES['userfile']['size'] > 0){

		$date = date('Y-m-d');
		$doctype = $_POST['doctype'];
		$title = htmlspecialchars($_POST['title'], ENT_QUOTES);
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

		$query  = "INSERT INTO documentsrestricted (name, size, type, content, date, doctype, title) VALUES ('$fileName', '$fileSize', '$fileType', '$content', '$date', '$doctype', '$title')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

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
    <div class="small-12 medium-12 large-8 columns">
        <p>Webmasters use this control panel to upload special documents related to your CondoSites subscription. Content uploaded here is only accessible from your control panel main page and only by administrators.</p>
    </div>
</div>
<!-- UPLOAD FORM -->
<div style="max-width: 99%;">
<!-- UPLOAD FORM -->
<div class="nav-section-header-cp">
        <strong>Upload a Document or Photo</strong>
</div>
<form enctype="multipart/form-data" method="POST" action="documents-restricted.php">
<div class="cp-form-container">
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 0px 0px;">
            <div class="small-12 medium-12 columns"><strong>1) Find the document on your computer...</strong></div>
        </div>
        <div class="row medium-collapse" style="padding: 10px 10px 10px 30px;">
            <div class="small-12 medium-12 columns">
                <label for="file" class="middle"><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red"><b>3.5 MB Maximum</b></span></label>
                <input type="file" name="userfile" id="userfile" class="form" required autofocus>
            </div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>2) Name the document...</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 columns"><input name="title" maxlength="100" class="form" type="text" placeholder="Meeting Minutes 2017-01-31" required><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Remember to be consistent in your naming scheme!</span></div>
        </div>
    </div>
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>3) Where should this document appear?</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 columns">
<select name="doctype" class="form" required>
<option value="Legal Documents">Legal Documents</option>
<option value="Logo Packs">Logo Packs</option>
<option value="Neighborhood Communications">Neighborhood Communications</option>
</select>
            </div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-6 columns"><strong>4) Ready to Upload?</strong></div>
            <div class="small-12 medium-6 columns">
<input name="action" value="upload" type="hidden">
<input type="submit" name="submit" value="Upload Document">
<?php echo($errorSize); ?>
            </div>
        </div>
        <div class="row medium-collapse">
            <div class="small-12 medium-12 columns" align="center">
<br><i class="fa fa-hand-o-down" aria-hidden="true"></i> Scroll down to see the documents already uploaded.
            </div>
        </div>
    </div>
</div>
</form>
<!-- END UPLOAD FORM -->
<br>
<br>
<div class="nav-section-header-cp">
        <strong><?php $sql = mysqli_query($conn,"SELECT count(*) FROM documentsrestricted") or die(mysqli_error($conn));
        //$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Documents</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr align="left">
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Document Title</small></th>
      <th align="center" width="50" class="table-sortable:numeric">&nbsp;&nbsp;&nbsp; <small>ID</small></th>
      <th class="table-sortable:date">&nbsp;&nbsp;&nbsp; <small>Upload Date and Time</small></th>
      <th class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <small>Folder</small></th>
    </tr>
  </thead>
  <tbody style="background-color:#ffffff">
<!-- DATABASE RESULTS -->
<?php
    $query  = "SELECT `id`, name, type, size, date, doctype, title, created_date FROM documentsrestricted ORDER BY date DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
    <tr>
      <td>
        <div class="small-12 medium-12 large-11 columns">
        <a href="../download-documents.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$row['id']}"; ?>'); "><b><?php echo "{$row['title']}"; ?></b></a>
        <div style="float: left; padding: 8px;"><?php include('../icon-links.php'); ?></div>
        <span class="note-black"><br>Uploaded <?php echo date('Y-m-d', strtotime($row['created_date'])); ?></span>
        <div class="small-12 medium-12 large-1 columns">
            <form method="POST" action="documents-restricted.php" onclick="return confirm('Are you sure you want to delete the document: <?php echo "{$row['title']}"; ?>?');">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
                <input name="submit" value="Delete" class="submit" type="submit">
            </form>
        </div>
      </td>
      <td><?php echo "{$row['id']}"; ?></td>
      <td><?php echo "{$row['created_date']}"; ?></td>
      <td><?php echo "{$row['doctype']}"; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
  </tbody>
</table>
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Documents Restricted Control Panel Page<br></div>
</body>
</html>
