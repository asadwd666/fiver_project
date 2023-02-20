<?php $current_page = '17'; include('protect.php'); $success = "untried"; $module = $_POST['module']; ?>
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
<?php $action = $_POST["action"]; if ($action != null){ ?>
<?php
	if ($action == "delete"){
		$id = $_POST["id"];
		$aod = date('Y-m-d');
		$query = "UPDATE `documents` SET aod='$aod' WHERE `id`='$id'";
		mysqli_query($conn,$query) or die('Error, delete query failed');
		
		    $errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Document deleted successfully.</strong></div>";

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		$comment = $_POST['title'];
		$query = "INSERT INTO log (`action`, `tablename`, `useripaddress`, `userid`, `id`, `comment`) VALUES ('D', 'Documents-Board', '$useripaddress', '$userid', '$id', '$comment')";
		mysqli_query($conn,$query) or die('Error, updating log failed');

		$query = "OPTIMIZE TABLE `documents`";
		mysqli_query($conn,$query) or die('Error, delete query failed');
		
		header('Location: '.$module);
	}
	
	if ($action == "recover"){
	    $location = "documents-board.php".$folder;
		$id = $_POST["id"];
		$aod = date('Y-m-d');
		$query = "UPDATE `documents` SET aod='0000-00-00' WHERE `id`='$id'";
		mysqli_query($conn,$query) or die('Error, delete query failed');
		
		    $errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Document restored successfully.</strong></div>";

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		$comment = $_POST['title'];
		$query = "INSERT INTO log (`action`, `tablename`, `useripaddress`, `userid`, `id`, `comment`) VALUES ('R', 'Documents-Board', '$useripaddress', '$userid', '$id', '$comment')";
		mysqli_query($conn,$query) or die('Error, updating log failed');

		$query = "OPTIMIZE TABLE `documents`";
		mysqli_query($conn,$query) or die('Error, delete query failed');
		
		header('Location: '.$module);
	}
	if ($action == "upload" && $_FILES['userfile']['size'] > 0){

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$docdate = $_POST['docdate'];
		$doctype = $_POST['doctype'];
		$aod = $_POST['aod'];
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
			$fileName = preg_replace('/[^A-Za-z0-9-.]/', '', $fileName);
		}

		if ($fileSize >= '3750000' AND $_SESSION['webmaster'] != true AND $_SESSION['id'] != '1') {
			header('Location: documents-big.php?big=yes');
		}

		if ($aod >= '0000-00-01' AND $aod <= date("Y-m-d")) {
			$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #FAFEB8; color: black;'><i class='fa fa-exclamation-triangle note' aria-hidden='true'></i> <strong>Your document did not upload! You entered a past date in the Delete After Date field.</strong></div>";
		}

		else {

		$query  = "INSERT INTO documents (name, size, type, content, docdate, doctype, title, useripaddress, userid, aod) VALUES ('$fileName', '$fileSize', '$fileType', '$content', '$docdate', '$doctype', '$title', '$useripaddress', '$userid', '$aod')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

		    $errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>$title uploaded successfully.</strong></div>";

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
<big><i class="fa fa-stethoscope" aria-hidden="true"></i></big><strong>&nbsp;Health&nbsp;&nbsp;&nbsp;</strong> Documents for Board Members do not impact Health rating.
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
        <p>This is where you upload <b>documents and photos</b> for <u><b>board use only</b></u>.</p>
        <p>
            <i class="fa fa-hand-o-right" aria-hidden="true"></i>  <span class="note-red">Photos for use in the skin of your site, should be emailed in high resolution directly to your webmaster.</span><br>
            <i class="fa fa-hand-o-right" aria-hidden="true"></i>  <span class="note-red">We recommend formatting documents as PDFs whenever possible.<br></span>
            <i class="fa fa-hand-o-right" aria-hidden="true"></i>  <span class="note-red">Documents typically sort alphabetically, so be sure to follow proper naming conventions so users find what they are looking for.  (<input type="checkbox" name="namingconventions" onclick="showMe('namingconventions', this)" /> Show tips below.)</span>
        </p>
    </div>
    <div class="small-12 medium-6 columns">
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#add"><b>Add a Document or Photo</b></a> using the addition form below.</p>
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#edit"><b>View and Edit</b></a> existing entries in your database.</p>
    </div>
</div>

<!-- UPLOAD FORM -->
<a name="add"></a>
<div style="max-width: 99%;">
<div class="nav-section-header-cp">
        <strong>Upload a Document or Photo</strong>
</div>
<?php echo($errorSUCCESS); ?>
<form enctype="multipart/form-data" method="POST" action="documents-board.php">
<div class="cp-form-container">
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 0px 0px;">
            <div class="small-12 medium-12 columns"><strong>1) Find the document on your computer...</strong></div>
        </div>
        <div class="row medium-collapse" style="padding: 10px 10px 10px 30px;">
            <div class="small-12 columns">
                <input type="file" name="userfile" id="userfile" class="form" required autofocus>
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red"><b>3.5 MB Maximum</b></span> &nbsp; &nbsp;
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red"><a href="documents-big.php">Is your <u>document too</u> big?</a></span><br>
                <i class="fa fa-hand-o-right" aria-hidden="true"></i>&nbsp;<span class="note-red"> <input type="checkbox" name="documentformats" onclick="showMe('documentformats', this)" />&nbsp;<b>Show&nbsp;acceptable&nbsp;Document&nbsp;Formats</b></span>
            </div>
                <div id="documentformats" style="display:none" class="note-black">
<ul>
Not all document formats can be opened on all devices without special 3rd party software.  Ensure your users can always open the documents you upload by only uploading in the following formats:
</ul>
                    <div class="small-6 columns" style="background-color: #ccffcc; padding: 10px">
    <b>Most Recommended:</b><br>
    <img title="Adobe PDF (.pdf)" src="https://condosites.net/commons/pdf.png" style="border: 0px solid;" border="0"> Adobe PDF (.pdf)<br>
    <img title="JPEG (.jpg), GIF (.gif), PNG (.png)" src="https://condosites.net/commons/pictures.png" style="border: 0px solid;" border="0"> Picture: JPEG (.jpg), GIF (.gif), PNG (.png)<br>
    <br>
    <b>Supported, but not recommended:</b><br>
    <img title="Microsoft Word (.doc)" src="https://condosites.net/commons/word.png" style="border: 0px solid;" border="0"> Microsoft Word (.doc / .docx)<br>
    <img title="Microsoft Excel (.xls)" src="https://condosites.net/commons/excel.png" style="border: 0px solid;" border="0"> Microsoft Excel (.xls / .xlsl)<br>
    <img title="Text Document (.txt)" src="https://condosites.net/commons/txt.png" style="border: 0px solid;" border="0"> Text Document (.txt)<br>
    <img title="ZIP Archive (.zip)" src="https://condosites.net/commons/zip.png" style="border: 0px solid;" border="0"> ZIP Archive (.zip)

                    </div>
                    <div class="small-6 columns" style="background-color: #ffcccc; padding: 10px">
    <b>NOT Supported:</b><br>
    OpenOffice (.odt, .ott, .oth, and .odm)<br>
    Microsoft PowerPoint (.ppt)<br>
    HTML (.html)<br>
    All other document formats
                    </div>
                </div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>2) Name the document...</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 columns"><input name="title" maxlength="100" class="form" type="text" placeholder="Meeting Minutes 2017-01-31" required><i class="fa fa-hand-o-right" aria-hidden="true"></i> <input type="checkbox" name="namingconventions" onclick="showMe('namingconventions', this)" /> <span class="note-red"><b>Show important tips on naming conventions.</b></span>
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
<option value="">Select where this document should appear...</option>
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
    </div>
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 0px 0px;">
            <div class="small-12 medium-12 columns"><strong>4) Dates!</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-6 columns"><label for="docdate" class="middle">When was the subject of the document?<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">e.g. The date of a meeting.</span></label></div>
            <div class="small-12 medium-6 end columns"><input name="docdate" class="form datepicker" type="date" placeholder="YYYY-MM-DD" required></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-6 columns"><label for="aod" class="middle">Delete after a particular date?<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Automatically deletes temporary documents.</span></label></div>
            <div class="small-12 medium-6 end columns"><input name="aod" class="form datepicker" type="date" placeholder="YYYY-MM-DD"></div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-6 columns"><strong>5) Ready to Upload?</strong></div>
            <div class="small-12 medium-6 columns">
<input name="action" value="upload" type="hidden">
<input type="submit" name="submit" value="Upload Document">
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
<a name="edit"></a>
<br>
<div class="nav-section-header-cp">
        <strong><?php $sql = mysqli_query($conn,"SELECT count(*) FROM documents WHERE board = 'Y' AND (aod = '0000-00-00' OR aod >= CURRENT_DATE())") or die(mysqli_error($conn));
        //$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Documents</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr align="left">
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Document Title</small></th>
      <th align="center" width="50" class="table-sortable:numeric">&nbsp;&nbsp;&nbsp; <small>ID</small></th>
      <th class="table-sortable:date">&nbsp;&nbsp;&nbsp; <a title="Document Date - This is NOT the date the document was uploaded."><small>Date</small></a></th>
<?php if ($_GET['folder'] == ''){ ?>
      <th class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <small>Folder</small></th>
<?php }; ?>
<?php if ($_GET['folder'] != ''){ ?>
      <th>
        <form action="documents-board.php#edit" method="get">
            <input type="submit" value="Show All Folders">
        </form>
      </th>
<?php }; ?>
    </tr>
  </thead>
  <tbody style="background-color:#ffffff">
<!-- DATABASE RESULTS -->
<?php
    $today = date('Y-m-d');
    $foldername = $_GET['folder'];
    $folderfilter = ''; if ($_GET['folder'] != '') {$folderfilter = "`doctype` = '$foldername' AND";}
	$query  = "SELECT `id`, type, title, docdate, doctype, owner, lease, realtor, public, board, aod, size, created_date, userid FROM documents WHERE ". $folderfilter ." board = 'Y' AND (aod = '0000-00-00' OR aod >= CURRENT_DATE()) ORDER BY `id` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
    <tr>
    <?php if ($row['aod'] == $today){ ?><td style="background-color: #e2e2e2;"><?php }; ?>
    <?php if ($row['aod'] !== $today){ ?><td><?php }; ?>
        <div class="small-12 medium-12 large-8 columns">
        <a href="../download-documents.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$row['id']}"; ?>'); "><b><?php echo "{$row['title']}"; ?></b></a>
        <div style="float: left; padding: 8px;"><?php include('../icon-links.php'); ?></div>
        <span class="note-black"><br>Uploaded <?php echo date('Y-m-d', strtotime($row['created_date'])); ?>
<?php
	$type    = $row['userid'];
	$query1  = "SELECT last_name, first_name FROM users WHERE id = '$type' AND id != ''";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?>
 by <?php echo "{$row1['first_name']}"; ?> <?php echo "{$row1['last_name']}"; ?>
<?php
	}
?>
        </span>
        <?php if ($row['aod'] > $today){ ?><span class="note-red"><br>Delete After <?php echo "{$row['aod']}"; ?></span><?php }; ?>
        <?php if ($row['aod'] == $today){ ?><span class="note-black"><br><b>The document has been removed from the website.</b><br>After today, you can recover the document for 30-days, or immediately delete it, in the Database Maintenance control panel.</span><?php }; ?>
        </div>
        <?php if ($row['aod'] !== $today){ ?>
        <div class="small-6 medium-6 large-2 columns">
            <form name="DocumentsEdit" method="POST" action="documents-edit-board.php">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
                <?php if ($foldername !== ''){ ?><input type="hidden" name="module" value="documents-board.php?folder=<?php echo "{$row['doctype']}"; ?>#edit"><?php }; ?>
                <?php if ($foldername == ''){ ?><input type="hidden" name="module" value="documents-board.php#edit"><?php }; ?>
                <input name="submit" value="Edit" class="submit" type="submit">
            </form>
        </div>
        <?php }; ?>
        <?php if ($row['aod'] !== $today){ ?>
        <div class="small-6 medium-6 large-2 columns">
            <form method="POST" action="documents-board.php" onclick="return confirm('Are you sure you want to delete the document: <?php echo "{$row['title']}"; ?>?');">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
                <input type="hidden" name="title" value="<?php echo "{$row['title']}"; ?>">
                <?php if ($foldername !== ''){ ?><input type="hidden" name="module" value="documents-board.php?folder=<?php echo "{$row['doctype']}"; ?>#edit"><?php }; ?>
                <?php if ($foldername == ''){ ?><input type="hidden" name="module" value="documents-board.php#edit"><?php }; ?>
                <input name="submit" value="Delete" class="submit" type="submit">
            </form>
        </div>
        <?php }; ?>
        <?php if ($row['aod'] == $today){ ?>
        <div class="small-12 medium-12 large-4 columns" align="center">
            <form method="POST" action="documents-board.php" onclick="return confirm('Are you sure you want to recover the document: <?php echo "{$row['title']}"; ?>?');">
                <input type="hidden" name="action" value="recover">
                <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
                <input type="hidden" name="title" value="<?php echo "{$row['title']}"; ?>">
                <?php if ($foldername !== ''){ ?><input type="hidden" name="module" value="documents-board.php?folder=<?php echo "{$row['doctype']}"; ?>#edit"><?php }; ?>
                <?php if ($foldername == ''){ ?><input type="hidden" name="module" value="documents-board.php#edit"><?php }; ?>
                <input name="submit" value="Recover Document" class="submit" type="submit">
            </form>
        </div>
        <?php }; ?>
      </td>
      <td><?php echo "{$row['id']}"; ?></td>
      <td><?php echo "{$row['docdate']}"; ?></td>
      <?php if ($foldername == $row['doctype']){ ?><td><?php echo "{$row['doctype']}"; ?></td><?php }; ?>
      <?php if ($foldername !== $row['doctype']){ ?><td><u><a href="documents-board.php?folder=<?php echo "{$row['doctype']}"; ?>#edit"><?php echo "{$row['doctype']}"; ?></a></u></td><?php }; ?>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
  </tbody>
</table>
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Documents (Board) Control Panel Page<br></div>
</body>
</html>
