<?php $current_page = '9'; include('protect.php'); ?>
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
<?php $int1 = $_POST["int1"]; $action = $_POST["action"]; if ($action != null){ ?>
<?php
	if ($action == "delete"){
		$query = "DELETE FROM chalkboard WHERE `int1`='$int1'";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

        	$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Your Newsboard Article was deleted successfully.</strong></div>";

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['int1'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('D', 'Newsboard', '$useripaddress', '$userid', '$id')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

		$query = "OPTIMIZE TABLE `chalkboard`";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

	}
	if ($action == "add"){

		$pod = $_POST["pod"];
		$eod = $_POST["eod"];
		$headline = htmlspecialchars($_POST['headline'], ENT_QUOTES);
		$message = $_POST["message"];
		$iframe = $_POST["iframe"];
		$url = htmlspecialchars($_POST["url"]);
		$email = htmlspecialchars($_POST["email"]);
		$potime = date("H:i:s");
		$docid = $_POST["docid"];
		$docid2 = $_POST["docid2"];
		$docid3 = $_POST["docid3"];
		$pic = $_POST["pic"];
		$pic2 = $_POST["pic2"];
		$pic3 = $_POST["pic3"];
		$tabid = $_POST["tabid"];
		$folderid = $_POST["folderid"];
		$calid = $_POST["calid"];
		$owner = $_POST["owner"];
		$realtor = $_POST["realtor"];
		$lease = $_POST["lease"];
		$flag = $_POST["flag"];
		$digitaldisplay = $_POST["digitaldisplay"];
		$digitaldisplaymessage = $_POST["digitaldisplaymessage"];

        if ($eod <= $pod) {
            
            $errorERROR = "<div class='nav-section-header-cp' style='background-color: #FAFEB8; color: black;'><i class='fa fa-exclamation-triangle note' aria-hidden='true'></i> <strong>Your expiration date is before your posting date!</strong></div>";
            
        }

	    $query = "INSERT INTO chalkboard (pod, eod, headline, message, iframe, url, email, potime, docid, docid2, docid3, pic, pic2, pic3, tabid, folderid, calid, owner, realtor, lease, flag, digitaldisplay, digitaldisplaymessage) VALUES ('$pod', '$eod', '$headline', '$message', '$iframe', '$url', '$email', '$potime', '$docid', '$docid2', '$docid3', '$pic', '$pic2', '$pic3', '$tabid', '$folderid', '$calid', '$owner', '$realtor', '$lease', '$flag', '$digitaldisplay', '$digitaldisplaymessage')";
	    $result = mysqli_query($conn,$query) or die('Error, insert query failed');

    	$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Your Newsboard Article was added successfully.</strong></div>";

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

<?php $sqlNEWS = mysqli_query($conn,"SELECT count(*) FROM chalkboard WHERE eod >= CURRENT_DATE() AND pod <= CURRENT_DATE() AND sample = '0'") or die(mysqli_error($conn));
$row = mysqli_fetch_row($sqlNEWS);
$countNEWS = $row[0];
?>
<?php $sqlNEWS2 = mysqli_query($conn,"SELECT count(*) FROM chalkboard WHERE sample = '0' AND pod >= CURRENT_DATE() - INTERVAL 30 DAY AND pod <= CURRENT_DATE()") or die(mysqli_error($conn));
$row = mysqli_fetch_row($sqlNEWS2);
$countNEWS2 = $row[0];
?>
<?php $sqlEOD = mysqli_query($conn,"SELECT count(*) FROM chalkboard WHERE eod < pod") or die(mysqli_error($conn));
$row = mysqli_fetch_row($sqlEOD);
$countEOD = $row[0];
?>
<?php if ($countNEWS != '0' AND $countEOD == '0' AND ($countNEWS2 > '0')){ ?><i class="fa fa-check" aria-hidden="true"></i> Awesome! You have fresh content on your Newsboard.<br><?php }; ?>
<?php if ($countNEWS == '0') { ?><i class="fa fa-exclamation-triangle note" aria-hidden="true"></i> You do not have anything posted to your Newsboard!<br><?php }; ?>
<?php if ($countNEWS != '0' AND $countNEWS2 == '0') { ?><i class="fa fa-exclamation-triangle note" aria-hidden="true"></i> All of your content is over 30 days old!<br><?php }; ?>
<?php if ($countEOD != '0'){ ?><i class="fa fa-exclamation-triangle note" aria-hidden="true"></i> You have an article with an expiration date before the posting date!<br><?php }; ?>

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
        <p><b>Newsboard Articles</b> are like newsletter articles and appear within the Newsboard - which is the column that appears on the right side of the main page (post login).  You can post a variety of content from notices of important meetings, maintenance projects, news, social events, new procedures, and more.</p>
        <p><i class="fa fa-hand-o-right" aria-hidden="true"></i>  <span class="note-red">If you plan to link Documents, Photos, or Calendar Events to your article, be sure to upload or create those items in advance in the respective control panel.</span></p>
    </div>
    <div class="small-12 medium-6 columns">
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#add"><b>Add a Newsboard Article</b></a> using the addition form below.</p>
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#edit"><b>View and Edit</b></a> existing entries in your database.</p>
    </div>
</div>
<div style="max-width: 99%;">
<!-- UPLOAD FORM -->
<a name="add"></a>
<div class="nav-section-header-cp">
        <strong>Add a Newsboard Article</strong>
</div>
<?php echo($errorSUCCESS); ?>
<?php echo($errorERROR); ?>
<form enctype="multipart/form-data" method="POST" action="chalkboard.php">
<div class="cp-form-container">
<!-- COLUMN 1 -->
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 0px 0px;">
            <div class="small-12 medium-12 columns"><strong>1) Headline and Article</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-3 columns"><label for="headline" class="middle">Headline</label></div>
            <div class="small-12 medium-9 end columns"><input name="headline" placeholder="Extra! Extra! Read all about it..." maxlength="100" class="form" type="text" required autofocus></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 end columns" style="padding-bottom: 10px;">
                <label for="message" class="middle" style="margin-bottom: -5px;">Main body of your Newsboard Article...<br>
                    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">If pasting content from Microsoft Word, use the "Paste from Word" ( <img src="https://condosites.net/commons/pastefromword.png" width="15"> ) button.</span><br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Use the Styles pulldown to apply <b><span class="bluepen">c</span><span class="greenpen">o</span><span class="bluepen">l</span><span class="greenpen">o</span><span class="bluepen">r</span></b> and formatting <span class="marker">styles</span> to your text.</span>
                </label>
                <textarea name="message" cols="30" rows="2" id="editor1" class="form" type="text"></textarea>
                <script>CKEDITOR.replace( 'editor1' );</script>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 end columns" style="padding-bottom: 10px;">
                <label for="digitaldisplaymessage" class="middle" style="margin-bottom: -25px;"><input type="checkbox" name="iframeQ" onclick="showMe('digitaldisplaymessage', this)" /> Add a summary for <a href="http://condosites.com/digitalsignage.php" target="_blank"><b>Digital Information Display</b></a></label>
                <div id="digitaldisplaymessage" style="display:none">
                    <div style="margin-top: 10px;">
                        <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Text entered here will show instead of the above main body of text on your Digital Display.</span><br>
                        <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">If pasting content from Microsoft Word, use the "Paste from Word" ( <img src="https://condosites.net/commons/pastefromword.png" width="15"> ) button.</span><br>
    			        <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Use the Styles pulldown to apply <b><span class="bluepen">c</span><span class="greenpen">o</span><span class="bluepen">l</span><span class="greenpen">o</span><span class="bluepen">r</span></b> and formatting <span class="marker">styles</span> to your text.</span>
                        <textarea name="digitaldisplaymessage" cols="30" rows="2" id="editor2" class="form" type="text"></textarea>
                        <script>CKEDITOR.replace( 'editor2' );</script>
                    </div>
                </div>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 end columns" style="padding-bottom: 10px;">
                <label for="iframe" class="middle" style="margin-bottom: -5px;"><input type="checkbox" name="iframeQ" onclick="showMe('iframe', this)" /> Add Optional iFrame Code &nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">From websites like YouTube.</span></label>
                <div id="iframe" style="display:none">
                    <textarea name="iframe" cols="30" rows="2" class="form" type="text" placeholder="Websites that offer you iFrames will present code that begins with <iframe> and ends with </iframe>."></textarea>
                </div>
            </div>
        </div>
        <div class="row" style="padding: 10px 10px 0px 0px;">
            <div class="small-12 medium-12 columns"><strong>2) Dates!</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-6 columns"><label for="pod" class="middle">When should this article appear for users?<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Today&apos;s date is entered by default.</span><br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Articles appear in reverse chronological order (newest to oldest) from this field.</span></label></div>
            <div class="small-12 medium-6 end columns"><input name="pod" class="form datepicker" type="date" value="<?php echo (date('Y-m-d')); ?>" required></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-6 columns"><label for="eod" class="middle">When should this article expire?<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Two weeks into the future is entered by default.</span></label></div>
            <div class="small-12 medium-6 end columns"><input name="eod" class="form datepicker" type="date" value="<?php echo date("Y-m-d", strtotime($date ."+14 days" )); ?>" required></div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>3) Who should see this article?</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="owner" class="middle">Show in <b>Owner</b> Section? </label></div>
            <div class="small-12 medium-2 end columns" style="padding-right: 15px;">
<select name="owner" class="form">
<option value="Y">Yes</option>
<option value="N">No</option>
</select>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="lease" class="middle">Show in <b>Renter</b> Section? </label></div>
            <div class="small-12 medium-2 end columns" style="padding-right: 15px;">
<select name="lease" class="form">
<option value="N">No</option>
<option value="Y">Yes</option>
</select>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="realtor" class="middle">Show in <b>Realtor</b> Section? </label></div>
            <div class="small-12 medium-2 end columns" style="padding-right: 15px;">
<select name="realtor" class="form">
<option value="N">No</option>
<option value="Y">Yes</option>
</select>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="digitaldisplay" class="middle">Show on <a href="http://condosites.com/digitalsignage.php" target="_blank"><b>Digital Information Display</b></a>? </label></div>
            <div class="small-12 medium-2 end columns" style="padding-right: 15px;">
<select name="digitaldisplay" class="form">
<option value="Y">Yes</option>
<option value="N">No</option>
</select>
            </div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>4) Add a flag!</strong>  &nbsp;&nbsp;&nbsp;&nbsp;<small><i>Optional</i></small></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-8 columns" style="padding-right: 15px;">
<label class="middle" style="margin-bottom: -5px;">Add optional themed flag to get user&apos;s attention.<br></label>
<select name="flag" class="form">
<option value="N" selected>None</option>
<option value="U">URGENT!</option>
<option value="M">Meeting!</option>
<option value="A">Action!</option>
<option value="D">Update!</option>
<option value="I">Important!</option>
<option value="C">Construction</option>
<option value="R">Reminder</option>
<option value="K">What's new!</option>
<option value="S">Social Event</option>
<option value="H">Hot Topic!</option>
<option value="G">Great News</option>
<option value="O">Next Up:</option>
<option value="L">for laughs!</option>
<option value="W">Weather</option>
</select>
<label class="middle">
    <div class="show-for-medium"><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Examples on the right.</span><br></div>
    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Articles tagged "URGENT!", "Meeting!", "Action!", "Update!", "Important!", "Construction", and "Reminder" will prioritize to the top of the Newsboard, just below the Newsboard Banner.</span>
    <br><br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Trying to better understand Newsboard Article sorting? <a href="https://condosites.com/help/newsboardsorting.php" target="_blank">Check out this help article.</a></span>
</label>
            </div>
            <div class="small-6 medium-2 columns show-for-medium" style="padding-right: 15px; margin-top:-85px; margin-bottom: 35px;">
                <div class="ribbon ribbon__U" style="margin-bottom: 10px;">URGENT!</div>
                <div class="ribbon ribbon__M" style="margin-bottom: 10px;">Meeting!</div>
                <div class="ribbon ribbon__A" style="margin-bottom: 10px;">Action!</div>
                <div class="ribbon ribbon__D" style="margin-bottom: 10px;">Update!</div>
                <div class="ribbon ribbon__I" style="margin-bottom: 10px;">Important!</div>
                <div class="ribbon ribbon__C" style="margin-bottom: 10px;">Construction</div>
                <div class="ribbon ribbon__R" style="margin-bottom: 10px;">Reminder</div>
            </div>
            <div class="small-6 medium-2 columns show-for-medium" style="padding-right: 15px; margin-top:-85px; margin-bottom: 35px;">
                <div class="ribbon ribbon__K" style="margin-bottom: 10px;">What's new!</div>
                <div class="ribbon ribbon__S" style="margin-bottom: 10px;"><i>Social Event</i></div>
                <div class="ribbon ribbon__H" style="margin-bottom: 10px;">Hot Topic!</div>
                <div class="ribbon ribbon__G" style="margin-bottom: 10px;">Great News!</div>
                <div class="ribbon ribbon__O" style="margin-bottom: 10px;">Next Up:</div>
                <div class="ribbon ribbon__L" style="margin-bottom: 10px;"><i>for laughs!</i></div>
                <div class="ribbon ribbon__W" style="margin-bottom: 10px;">Weather</div>
            </div>
        </div>
    </div>
<!-- END COLUMN 1 -->
<!-- COLUMN 2 -->
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>5) External Links...</strong>  &nbsp;&nbsp;&nbsp;&nbsp;<small><i>Optional</i></small></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="url" class="middle">Add a link to a website?<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Be sure your link starts with http://</span></label></div>
            <div class="small-12 medium-7 end columns"><input name="url" maxlength="100" class="form" type="url" placeholder="Be sure your link starts with http://"></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="email" class="middle">Add an email address?</label></div>
            <div class="small-12 medium-7 end columns"><input name="email" maxlength="100" class="form" type="email" placeholder="mabell@att.com"></div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns" style="margin-bottom: -20px;"><strong>6) Link Documents and Add Photos...</strong>  &nbsp;&nbsp;&nbsp;&nbsp;<small><i>Optional</i></small><label class="middle"><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Upload your documents and photos in the Documents &amp; Photos control panel.</span><br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Looking to add video? <a href="https://condosites.com/help/videos.php" target="_blank">Check out this help article.</a></span></label></div>
        </div>
<?php include('docid-field.php'); ?>
<?php include('docid-field-multi.php'); ?>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns" style="margin-bottom: -20px;"><strong>7) Link Folders, Modules, eForms, and Calendar Events...</strong>  &nbsp;&nbsp;&nbsp;&nbsp;<small><i>Optional</i></small><label class="middle"><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Setup this content in advance in their respective control panel.</span></label></div>
        </div>
<?php include('folderid-field.php'); ?>
<?php include('tabid-field.php'); ?>
<?php include('calid-field.php'); ?>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-6 columns"><strong>8) Ready to Save?</strong></div>
            <div class="small-12 medium-6 columns">
                <input type="hidden" name="action" value="add">
	            <input name="submit" value="Save this Newsboard Article" class="submit" type="submit">
            </div>
        </div>
        <div class="row medium-collapse">
            <div class="small-12 medium-12 columns" align="center">
<br><i class="fa fa-hand-o-down" aria-hidden="true"></i> Scroll down to see the Newsboard Articles already added.
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
        <strong>Most Recent Entry</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr align="left">
      <th class="table-sortable:alphanumeric" >&nbsp;&nbsp;&nbsp;<b><small>Message</small></b></th>
      <th width="50" class="table-sortable:numeric">&nbsp;&nbsp;&nbsp; <small>ID</small></th>
      <th class="table-sortable:date">&nbsp;&nbsp;&nbsp;<small>Post On</small></th>
      <th class="table-sortable:date">&nbsp;&nbsp;&nbsp;<small>Expiration</small></th>
	  <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Owner</small></b></div></th>
	  <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Renter</small></b></div></th>
	  <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Realtor</small></b></div></th>
	  <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>DID</small></b></div></th>
    </tr>
  </thead>
  <tbody style="background-color:#ffffff">
<?php
	$query  = "SELECT `int1`, pod, eod, headline, message, digitaldisplaymessage, url, email, potime, docid, docid2, docid3, pic, pic2, pic3, tabid, folderid, calid, owner, realtor, lease, flag, digitaldisplay, sample FROM chalkboard ORDER BY `int1` DESC LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- DATABASE RESULTS -->
    <tr>
      <td>
          <div class="small-12 medium-12 large-10 columns">
<?php if ($row['flag'] !== 'N'){ ?>
<div class="cp-ribbon ribbon__<?php echo "{$row['flag']}"; ?>" style="float: right;">
<?php if ($row['flag'] == 'U'){ ?>URGENT!<?php }; ?>
<?php if ($row['flag'] == 'M'){ ?>Meeting!<?php }; ?>
<?php if ($row['flag'] == 'D'){ ?>Update!<?php }; ?>
<?php if ($row['flag'] == 'A'){ ?>ACTION!<?php }; ?>
<?php if ($row['flag'] == 'I'){ ?>Important!<?php }; ?>
<?php if ($row['flag'] == 'S'){ ?><i>Social Event</i><?php }; ?>
<?php if ($row['flag'] == 'K'){ ?>What's new!<?php }; ?>
<?php if ($row['flag'] == 'R'){ ?><i>Reminder</i><?php }; ?>
<?php if ($row['flag'] == 'C'){ ?>CONSTRUCTION<?php }; ?>
<?php if ($row['flag'] == 'H'){ ?>HOT Topic!<?php }; ?>
<?php if ($row['flag'] == 'G'){ ?>Great News!<?php }; ?>
<?php if ($row['flag'] == 'O'){ ?>Next Up:<?php }; ?>
<?php if ($row['flag'] == 'L'){ ?><i>for laughs!</i><?php }; ?>
<?php if ($row['flag'] == 'W'){ ?><i>Weather</i><?php }; ?>
</div>
<?php }; ?>
<div>
<p><b><?php echo "{$row['headline']}"; ?></b></p>
<?php if ($row['message'] !== ''){ ?><?php echo "{$row['message']}"; ?><?php }; ?>

<?php if ($row['pic'] !== ''){ ?>
	<?php
	    $typeP1    = $row['pic'];
	    $queryP1  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$typeP1'";
	    $resultP1 = mysqli_query($conn,$queryP1);

    	while($rowP1 = $resultP1->fetch_array(MYSQLI_ASSOC))
	    {
    ?>
		<div style="float:right; padding:2px;"><img src="../download-documents-mini.php?id=<?php echo "{$rowP1['id']}"; ?>&docdate=<?php echo "{$rowP1['docdate']}"; ?>&size=<?php echo "{$rowP1['size']}"; ?>" alt="<?php echo "{$rowP1['title']}"; ?>" title="<?php echo "{$rowP1['title']}"; ?>" style="max-height: 50px;"></div>
	<?php
		}
	?>
<?php }; ?>
<?php if ($row['pic2'] !== ''){ ?>
	<?php
	    $typeP1    = $row['pic2'];
	    $queryP1  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$typeP1'";
	    $resultP1 = mysqli_query($conn,$queryP1);

    	while($rowP1 = $resultP1->fetch_array(MYSQLI_ASSOC))
	    {
    ?>
		<div style="float:right; padding:2px;"><img src="../download-documents-mini.php?id=<?php echo "{$rowP1['id']}"; ?>&docdate=<?php echo "{$rowP1['docdate']}"; ?>&size=<?php echo "{$rowP1['size']}"; ?>" alt="<?php echo "{$rowP1['title']}"; ?>" title="<?php echo "{$rowP1['title']}"; ?>" style="max-height: 50px;"></div>
	<?php
		}
	?>
<?php }; ?>
<?php if ($row['pic3'] !== ''){ ?>
	<?php
	    $typeP1    = $row['pic3'];
	    $queryP1  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$typeP1'";
	    $resultP1 = mysqli_query($conn,$queryP1);

    	while($rowP1 = $resultP1->fetch_array(MYSQLI_ASSOC))
	    {
    ?>
		<div style="float:right; padding:2px;"><img src="../download-documents-mini.php?id=<?php echo "{$rowP1['id']}"; ?>&docdate=<?php echo "{$rowP1['docdate']}"; ?>&size=<?php echo "{$rowP1['size']}"; ?>" alt="<?php echo "{$rowP1['title']}"; ?>" title="<?php echo "{$rowP1['title']}"; ?>" style="max-height: 50px;"></div>
	<?php
		}
	?>
<?php }; ?>

<span class="note-black">
<?php if ($row['url'] !== ''){ ?>Web Links: <a href="<?php echo "{$row['url']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('External/<?php echo "{$row['url']}"; ?>'); "><?php echo "{$row['url']}"; ?></a><?php }; ?>
<?php if ($row['email'] !== ''){ ?>&nbsp;|&nbsp;<a href="mailto:<?php echo "{$row['email']}"; ?>" onclick="javascript:pageTracker._trackPageview('Email/<?php echo "{$row['email']}"; ?>'); "><?php echo "{$row['email']}"; ?></a><?php }; ?>
<?php if ($row['docid'] !== ''){ ?><br>
<?php
	$typeD1    = $row['docid'];
	$queryD1  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeD1'";
	$resultD1 = mysqli_query($conn,$queryD1);

	while($rowD1 = $resultD1->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Document ID <?php echo "{$rowD1['id']}"; ?>) <?php echo "{$rowD1['title']}"; ?> (<?php echo "{$rowD1['doctype']}"; ?>)
<?php
	}
?>
<?php }; ?>
<?php if ($row['docid2'] !== ''){ ?><br>
<?php
	$typeD2    = $row['docid2'];
	$queryD2  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeD2'";
	$resultD2 = mysqli_query($conn,$queryD2);

	while($rowD2 = $resultD2->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Document ID <?php echo "{$rowD2['id']}"; ?>) <?php echo "{$rowD2['title']}"; ?> (<?php echo "{$rowD2['doctype']}"; ?>)
<?php
	}
?>
<?php }; ?>
<?php if ($row['docid3'] !== ''){ ?><br>
<?php
	$typeD3    = $row['docid3'];
	$queryD3  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeD3'";
	$resultD3 = mysqli_query($conn,$queryD3);

	while($rowD3 = $resultD3->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Document ID <?php echo "{$rowD3['id']}"; ?>) <?php echo "{$rowD3['title']}"; ?> (<?php echo "{$rowD3['doctype']}"; ?>)
<?php
	}
?>
<?php }; ?>
<?php if ($row['pic'] !== ''){ ?><br>
<?php
	$typeP1    = $row['pic'];
	$queryP1  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeP1'";
	$resultP1 = mysqli_query($conn,$queryP1);

	while($rowP1 = $resultP1->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Photo ID <?php echo "{$rowP1['id']}"; ?>) <?php echo "{$rowP1['title']}"; ?> (<?php echo "{$rowP1['doctype']}"; ?>)
<?php
	}
?>
<?php }; ?>
<?php if ($row['pic2'] !== ''){ ?><br>
<?php
	$typeP2    = $row['pic2'];
	$queryP2  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeP2'";
	$resultP2 = mysqli_query($conn,$queryP2);

	while($rowP2 = $resultP2->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Photo ID <?php echo "{$rowP2['id']}"; ?>) <?php echo "{$rowP2['title']}"; ?> (<?php echo "{$rowP2['doctype']}"; ?>)
<?php
	}
?>
<?php }; ?>
<?php if ($row['pic3'] !== ''){ ?><br>
<?php
	$typeP3   = $row['pic3'];
	$queryP3  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeP3'";
	$resultP3 = mysqli_query($conn,$queryP3);

	while($rowP3 = $resultP3->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Photo ID <?php echo "{$rowP3['id']}"; ?>) <?php echo "{$rowP3['title']}"; ?> (<?php echo "{$rowP3['doctype']}"; ?>)
<?php
	}
?>
<?php }; ?>
<?php if ($row['calid'] !== ''){ ?><br>
<?php
	$typeCID    = $row['calid'];
	$queryCID  = "SELECT `int1`, title, event, date, stime FROM calendar WHERE `int1` = '$typeCID'";
	$resultCID = mysqli_query($conn,$queryCID);

	while($rowCID = $resultCID->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Calendar ID <?php echo "{$rowCID['int1']}"; ?>) <?php echo "{$rowCID['title']}"; ?> (<?php echo "{$rowCID['event']}"; ?>) <?php echo "{$row7['date']}"; ?> <?php echo "{$row7['stime']}"; ?>
<?php
	}
?>
<?php }; ?>
<?php if ($row['folderid'] !== ''){ ?><br>
<?php
	$typeFID    = $row['folderid'];
	$queryFID  = "SELECT `int1`, title FROM folders WHERE `int1` = '$typeFID'";
	$resultFID = mysqli_query($conn,$queryFID);

	while($rowFID = $resultFID->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Folder ID <?php echo "{$rowFID['int1']}"; ?>) <?php echo "{$rowFID['title']}"; ?>
<?php
	}
?>
<?php }; ?>
<?php if ($row['tabid'] !== ''){ ?><br>
<?php
	$typeTID    = $row['tabid'];
	$queryTID  = "SELECT `int1`, title FROM tabs WHERE `int1` = '$typeTID'";
	$resultTID = mysqli_query($conn,$queryTID);

	while($rowTID = $resultTID->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Module ID <?php echo "{$rowTID['int1']}"; ?>) <?php echo "{$rowTID['title']}"; ?>
<?php
	}
?>
<?php }; ?>

<?php if ($row['digitaldisplaymessage'] !== ''){ ?><br><i class="fa fa-television" aria-hidden="true" title="This article includes an alternate summary for the Digital Information Display."></i> <span class="note-red">This article includes an alternate summary for the Digital Information Display.</span><?php }; ?>

<!-- STARS -->
<?php
    $int1CALL = $row['int1'];
    $sqlNEWS3 = mysqli_query($conn,"SELECT count(*) FROM chalkboard WHERE `int1` = '$int1CALL' AND `sample` = '0' AND pod >= CURRENT_DATE() - INTERVAL 30 DAY AND pod <= CURRENT_DATE() AND eod >= CURRENT_DATE()") or die(mysqli_error($conn));
    $row3 = mysqli_fetch_row($sqlNEWS3);
    $countNEWS3 = $row3[0];
?>

<?php if ($row['sample'] !== '0'){ ?><br><i class="fa fa-star s" aria-hidden="true" style="color: lightgray" title="This is a sample article created by CondoSites. It does NOT count toward your stars."></i> <span class="note-red">This is a sample article created by CondoSites. It does NOT count toward your stars.</span><?php }; ?>
<?php if ($row['sample'] == '0' AND $countNEWS3 == '0'){ ?><br><i class="fa fa-star s" aria-hidden="true" style="color: lightgray" title="This article is either more than 30-days old, has reached its expiration date, or is scheduled to appear in the future. So it does not count toward your stars."></i> <span class="note-red">This article is either more than 30-days old, has reached its expiration date, or is scheduled to appear in the future. So it does not count toward your stars.</span><?php }; ?>
<?php if ($row['sample'] == '0' AND $countNEWS3 !== '0'){ ?><br><i class="fa fa-star s" aria-hidden="true" style="color: gold" title="This article counts toward your stars!"></i> <span class="note-red">This article counts toward your stars through <?php echo date("M d, Y", strtotime($row['pod'] ."+30 days" )); ?>.</span><?php }; ?>
<!-- STARS -->



</span>
</div>
        <?php if ($row['eod'] <= $row['pod']){ ?><br><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="note-red">The expiration date is before the posting date.</span><?php }; ?>
</div>
        </div>
        <div class="small-6 medium-6 large-2 columns" style="padding:10px">
            <form name="CBEdit" method="POST" action="chalkboard-edit.php">
              <input type="hidden" name="action" value="edit">
              <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
              <input name="submit" value="Edit" class="submit" type="submit">
            </form>
        </div>
		<div class="small-6 medium-6 large-2 columns" style="padding:10px">
            <form name="CBDup" method="POST" action="chalkboard-duplicate.php">
                <input type="hidden" name="action" value="duplicate">
                <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
                <input name="submit" value="Copy" class="submit" type="submit">
            </form>
		</div>
        <div class="small-6 medium-6 large-2 columns" style="padding:10px">
            <form name="CBDelete" method="POST" action="chalkboard.php" onclick="return confirm('Are you sure you want to delete the Newsboard entry: <?php echo "{$row['headline']}"; ?>?');">
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
              <input name="submit" value="Delete" class="submit" type="submit">
            </form>
        </div>
      </td>
      <td><?php echo "{$row['int1']}"; ?></td>
      <td><?php echo "{$row['pod']}"; ?></td>
      <td <?php if ($row['eod'] <= $row['pod']){ ?>class="note-red"<?php }; ?>><?php echo "{$row['eod']}"; ?></td>
      <td align="center" <?php if ($row['owner'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['owner'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['owner']}"; ?></td>
      <td align="center" <?php if ($row['lease'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['lease'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['lease']}"; ?></td>
      <td align="center" <?php if ($row['realtor'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['realtor'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['realtor']}"; ?></td>
      <td align="center" <?php if ($row['digitaldisplay'] !== 'Y'){ ?>bgcolor="#f4d6a3"<?php }; ?><?php if ($row['digitaldisplay'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['digitaldisplay']}"; ?></td>
    </tr>
<!-- END DATABASE RESULTS -->
<?php
	}
?>
  </tbody>
</table>
<br>
<div class="nav-section-header-cp">
        <strong><?php $sql = mysqli_query($conn,"SELECT count(*) FROM chalkboard WHERE eod >= CURRENT_DATE() AND pod <= CURRENT_DATE()") or die(mysqli_error($conn));
        //$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Current Newsboard Articles</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr align="left">
      <th class="table-sortable:alphanumeric" >&nbsp;&nbsp;&nbsp;<b><small>Message</small></b></th>
      <th width="50" class="table-sortable:numeric">&nbsp;&nbsp;&nbsp; <small>ID</small></th>
      <th class="table-sortable:date">&nbsp;&nbsp;&nbsp;<small>Post On</small></th>
      <th class="table-sortable:date">&nbsp;&nbsp;&nbsp;<small>Expiration</small></th>
	  <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Owner</small></b></div></th>
	  <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Renter</small></b></div></th>
	  <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Realtor</small></b></div></th>
	  <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>DID</small></b></div></th>
    </tr>
  </thead>
  <tbody style="background-color:#ffffff">
<?php
	$query  = "SELECT `int1`, pod, eod, headline, message, digitaldisplaymessage, url, email, potime, docid, docid2, docid3, pic, pic2, pic3, tabid, folderid, calid, owner, realtor, lease, flag, digitaldisplay, sample FROM chalkboard WHERE eod >= CURRENT_DATE() AND pod <= CURRENT_DATE() ORDER BY pod DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>

<!-- DATABASE RESULTS -->
    <tr>
      <td>
          <div class="small-12 medium-12 large-10 columns">
<?php if ($row['flag'] !== 'N'){ ?>
<div class="cp-ribbon ribbon__<?php echo "{$row['flag']}"; ?>" style="float: right;">
<?php if ($row['flag'] == 'U'){ ?>URGENT!<?php }; ?>
<?php if ($row['flag'] == 'M'){ ?>Meeting!<?php }; ?>
<?php if ($row['flag'] == 'D'){ ?>Update!<?php }; ?>
<?php if ($row['flag'] == 'A'){ ?>ACTION!<?php }; ?>
<?php if ($row['flag'] == 'I'){ ?>Important!<?php }; ?>
<?php if ($row['flag'] == 'S'){ ?><i>Social Event</i><?php }; ?>
<?php if ($row['flag'] == 'K'){ ?>What's new!<?php }; ?>
<?php if ($row['flag'] == 'R'){ ?><i>Reminder</i><?php }; ?>
<?php if ($row['flag'] == 'C'){ ?>CONSTRUCTION<?php }; ?>
<?php if ($row['flag'] == 'H'){ ?>HOT Topic!<?php }; ?>
<?php if ($row['flag'] == 'G'){ ?>Great News!<?php }; ?>
<?php if ($row['flag'] == 'O'){ ?>Next Up:<?php }; ?>
<?php if ($row['flag'] == 'L'){ ?><i>for laughs!</i><?php }; ?>
<?php if ($row['flag'] == 'W'){ ?><i>Weather</i><?php }; ?>
</div>
<?php }; ?>
<div>
<p><b><?php echo "{$row['headline']}"; ?></b></p>
<?php if ($row['message'] !== ''){ ?><?php echo "{$row['message']}"; ?><?php }; ?>

<?php if ($row['pic'] !== ''){ ?>
	<?php
	    $typeP1    = $row['pic'];
	    $queryP1  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$typeP1'";
	    $resultP1 = mysqli_query($conn,$queryP1);

    	while($rowP1 = $resultP1->fetch_array(MYSQLI_ASSOC))
	    {
    ?>
		<div style="float:right; padding:2px;"><img src="../download-documents-mini.php?id=<?php echo "{$rowP1['id']}"; ?>&docdate=<?php echo "{$rowP1['docdate']}"; ?>&size=<?php echo "{$rowP1['size']}"; ?>" alt="<?php echo "{$rowP1['title']}"; ?>" title="<?php echo "{$rowP1['title']}"; ?>" style="max-height: 50px;"></div>
	<?php
		}
	?>
<?php }; ?>
<?php if ($row['pic2'] !== ''){ ?>
	<?php
	    $typeP1    = $row['pic2'];
	    $queryP1  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$typeP1'";
	    $resultP1 = mysqli_query($conn,$queryP1);

    	while($rowP1 = $resultP1->fetch_array(MYSQLI_ASSOC))
	    {
    ?>
		<div style="float:right; padding:2px;"><img src="../download-documents-mini.php?id=<?php echo "{$rowP1['id']}"; ?>&docdate=<?php echo "{$rowP1['docdate']}"; ?>&size=<?php echo "{$rowP1['size']}"; ?>" alt="<?php echo "{$rowP1['title']}"; ?>" title="<?php echo "{$rowP1['title']}"; ?>" style="max-height: 50px;"></div>
	<?php
		}
	?>
<?php }; ?>
<?php if ($row['pic3'] !== ''){ ?>
	<?php
	    $typeP1    = $row['pic3'];
	    $queryP1  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$typeP1'";
	    $resultP1 = mysqli_query($conn,$queryP1);

    	while($rowP1 = $resultP1->fetch_array(MYSQLI_ASSOC))
	    {
    ?>
		<div style="float:right; padding:2px;"><img src="../download-documents-mini.php?id=<?php echo "{$rowP1['id']}"; ?>&docdate=<?php echo "{$rowP1['docdate']}"; ?>&size=<?php echo "{$rowP1['size']}"; ?>" alt="<?php echo "{$rowP1['title']}"; ?>" title="<?php echo "{$rowP1['title']}"; ?>" style="max-height: 50px;"></div>
	<?php
		}
	?>
<?php }; ?>

<span class="note-black">
<?php if ($row['url'] !== ''){ ?>Web Links: <a href="<?php echo "{$row['url']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('External/<?php echo "{$row['url']}"; ?>'); "><?php echo "{$row['url']}"; ?></a><?php }; ?>
<?php if ($row['email'] !== ''){ ?>&nbsp;|&nbsp;<a href="mailto:<?php echo "{$row['email']}"; ?>" onclick="javascript:pageTracker._trackPageview('Email/<?php echo "{$row['email']}"; ?>'); "><?php echo "{$row['email']}"; ?></a><?php }; ?>
<?php if ($row['docid'] !== ''){ ?><br>
<?php
	$typeD1    = $row['docid'];
	$queryD1  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeD1'";
	$resultD1 = mysqli_query($conn,$queryD1);

	while($rowD1 = $resultD1->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Document ID <?php echo "{$rowD1['id']}"; ?>) <?php echo "{$rowD1['title']}"; ?> (<?php echo "{$rowD1['doctype']}"; ?>)
<?php
	}
?>
<?php }; ?>
<?php if ($row['docid2'] !== ''){ ?><br>
<?php
	$typeD2    = $row['docid2'];
	$queryD2  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeD2'";
	$resultD2 = mysqli_query($conn,$queryD2);

	while($rowD2 = $resultD2->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Document ID <?php echo "{$rowD2['id']}"; ?>) <?php echo "{$rowD2['title']}"; ?> (<?php echo "{$rowD2['doctype']}"; ?>)
<?php
	}
?>
<?php }; ?>
<?php if ($row['docid3'] !== ''){ ?><br>
<?php
	$typeD3    = $row['docid3'];
	$queryD3  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeD3'";
	$resultD3 = mysqli_query($conn,$queryD3);

	while($rowD3 = $resultD3->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Document ID <?php echo "{$rowD3['id']}"; ?>) <?php echo "{$rowD3['title']}"; ?> (<?php echo "{$rowD3['doctype']}"; ?>)
<?php
	}
?>
<?php }; ?>
<?php if ($row['pic'] !== ''){ ?><br>
<?php
	$typeP1    = $row['pic'];
	$queryP1  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeP1'";
	$resultP1 = mysqli_query($conn,$queryP1);

	while($rowP1 = $resultP1->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Photo ID <?php echo "{$rowP1['id']}"; ?>) <?php echo "{$rowP1['title']}"; ?> (<?php echo "{$rowP1['doctype']}"; ?>)
<?php
	}
?>
<?php }; ?>
<?php if ($row['pic2'] !== ''){ ?><br>
<?php
	$typeP2    = $row['pic2'];
	$queryP2  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeP2'";
	$resultP2 = mysqli_query($conn,$queryP2);

	while($rowP2 = $resultP2->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Photo ID <?php echo "{$rowP2['id']}"; ?>) <?php echo "{$rowP2['title']}"; ?> (<?php echo "{$rowP2['doctype']}"; ?>)
<?php
	}
?>
<?php }; ?>
<?php if ($row['pic3'] !== ''){ ?><br>
<?php
	$typeP3   = $row['pic3'];
	$queryP3  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeP3'";
	$resultP3 = mysqli_query($conn,$queryP3);

	while($rowP3 = $resultP3->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Photo ID <?php echo "{$rowP3['id']}"; ?>) <?php echo "{$rowP3['title']}"; ?> (<?php echo "{$rowP3['doctype']}"; ?>)
<?php
	}
?>
<?php }; ?>
<?php if ($row['calid'] !== ''){ ?><br>
<?php
	$typeCID    = $row['calid'];
	$queryCID  = "SELECT `int1`, title, event, date, stime FROM calendar WHERE `int1` = '$typeCID'";
	$resultCID = mysqli_query($conn,$queryCID);

	while($rowCID = $resultCID->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Calendar ID <?php echo "{$rowCID['int1']}"; ?>) <?php echo "{$rowCID['title']}"; ?> (<?php echo "{$rowCID['event']}"; ?>) <?php echo "{$row7['date']}"; ?> <?php echo "{$row7['stime']}"; ?>
<?php
	}
?>
<?php }; ?>
<?php if ($row['folderid'] !== ''){ ?><br>
<?php
	$typeFID    = $row['folderid'];
	$queryFID  = "SELECT `int1`, title FROM folders WHERE `int1` = '$typeFID'";
	$resultFID = mysqli_query($conn,$queryFID);

	while($rowFID = $resultFID->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Folder ID <?php echo "{$rowFID['int1']}"; ?>) <?php echo "{$rowFID['title']}"; ?>
<?php
	}
?>
<?php }; ?>
<?php if ($row['tabid'] !== ''){ ?><br>
<?php
	$typeTID    = $row['tabid'];
	$queryTID  = "SELECT `int1`, title FROM tabs WHERE `int1` = '$typeTID'";
	$resultTID = mysqli_query($conn,$queryTID);

	while($rowTID = $resultTID->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Module ID <?php echo "{$rowTID['int1']}"; ?>) <?php echo "{$rowTID['title']}"; ?>
<?php
	}
?>
<?php }; ?>

<?php if ($row['digitaldisplaymessage'] !== ''){ ?><br><i class="fa fa-television" aria-hidden="true" title="This article includes an alternate summary for the Digital Information Display."></i> <span class="note-red">This article includes an alternate summary for the Digital Information Display.</span><?php }; ?>

<!-- STARS -->
<?php
    $int1CALL = $row['int1'];
    $sqlNEWS3 = mysqli_query($conn,"SELECT count(*) FROM chalkboard WHERE `int1` = '$int1CALL' AND `sample` = '0' AND pod >= CURRENT_DATE() - INTERVAL 30 DAY") or die(mysqli_error($conn));
    $row3 = mysqli_fetch_row($sqlNEWS3);
    $countNEWS3 = $row3[0];
?>

<?php if ($row['sample'] !== '0'){ ?><br><i class="fa fa-star s" aria-hidden="true" style="color: lightgray" title="This is a sample article created by CondoSites. It does NOT count toward your stars."></i> <span class="note-red">This is a sample article created by CondoSites. It does NOT count toward your stars.</span><?php }; ?>
<?php if ($row['sample'] == '0' AND $countNEWS3 == '0'){ ?><br><i class="fa fa-star s" aria-hidden="true" style="color: lightgray" title="This article is more than 30-days old, so it no longer counts towards your stars."></i> <span class="note-red">This article is more than 30-days old, so it no longer counts towards your stars.</span><?php }; ?>
<?php if ($row['sample'] == '0' AND $countNEWS3 !== '0'){ ?><br><i class="fa fa-star s" aria-hidden="true" style="color: gold" title="This article counts toward your stars!"></i> <span class="note-red">This article counts toward your stars through <?php echo date("M d, Y", strtotime($row['pod'] ."+30 days" )); ?>.</span><?php }; ?>
<!-- STARS -->



</span>
</div>
    <?php if ($row['eod'] <= $row['pod']){ ?><br><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="note-red">The expiration date is before the posting date.</span><?php }; ?>
</div>
        </div>
        <div class="small-6 medium-6 large-2 columns" style="padding:10px">
            <form name="CBEdit" method="POST" action="chalkboard-edit.php">
              <input type="hidden" name="action" value="edit">
              <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
              <input name="submit" value="Edit" class="submit" type="submit">
            </form>
        </div>
		<div class="small-6 medium-6 large-2 columns" style="padding:10px">
            <form name="CBDup" method="POST" action="chalkboard-duplicate.php">
                <input type="hidden" name="action" value="duplicate">
                <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
                <input name="submit" value="Copy" class="submit" type="submit">
            </form>
		</div>
        <div class="small-6 medium-6 large-2 columns" style="padding:10px">
            <form name="CBDelete" method="POST" action="chalkboard.php" onclick="return confirm('Are you sure you want to delete the Newsboard entry: <?php echo "{$row['headline']}"; ?>?');">
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
              <input name="submit" value="Delete" class="submit" type="submit">
            </form>
        </div>
      </td>
      <td><?php echo "{$row['int1']}"; ?></td>
      <td><?php echo "{$row['pod']}"; ?></td>
      <td <?php if ($row['eod'] <= $row['pod']){ ?>class="note-red"<?php }; ?>><?php echo "{$row['eod']}"; ?></td>
      <td align="center" <?php if ($row['owner'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['owner'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['owner']}"; ?></td>
      <td align="center" <?php if ($row['lease'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['lease'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['lease']}"; ?></td>
      <td align="center" <?php if ($row['realtor'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['realtor'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['realtor']}"; ?></td>
      <td align="center" <?php if ($row['digitaldisplay'] !== 'Y'){ ?>bgcolor="#f4d6a3"<?php }; ?><?php if ($row['digitaldisplay'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['digitaldisplay']}"; ?></td>
    </tr>
<!-- END DATABASE RESULTS -->
<?php
	}
?>
  </tbody>
</table>
<br>
<div class="nav-section-header-cp">
        <strong><?php $sql = mysqli_query($conn,"SELECT count(*) FROM chalkboard WHERE pod > CURRENT_DATE()") or die(mysqli_error($conn));
        //$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Future Newsboard Articles</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr align="left">
      <th class="table-sortable:alphanumeric" >&nbsp;&nbsp;&nbsp;<b><small>Message</small></b></th>
      <th width="50" class="table-sortable:numeric">&nbsp;&nbsp;&nbsp; <small>ID</small></th>
      <th class="table-sortable:date">&nbsp;&nbsp;&nbsp;<small>Post On</small></th>
      <th class="table-sortable:date">&nbsp;&nbsp;&nbsp;<small>Expiration</small></th>
      <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Owner</small></b></div></th>
	  <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Renter</small></b></div></th>
	  <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Realtor</small></b></div></th>
	  <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>DID</small></b></div></th>
    </tr>
  </thead>
  <tbody style="background-color:#ffffff">
<?php
	$query  = "SELECT `int1`, pod, eod, headline, message, digitaldisplaymessage, url, email, potime, docid, docid2, docid3, pic, pic2, pic3, tabid, folderid, calid, owner, realtor, lease, flag, digitaldisplay, sample FROM chalkboard WHERE pod > CURRENT_DATE() ORDER BY pod DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- DATABASE RESULTS -->
    <tr>
      <td>
          <div class="small-12 medium-12 large-10 columns">
<?php if ($row['flag'] !== 'N'){ ?>
<div class="cp-ribbon ribbon__<?php echo "{$row['flag']}"; ?>" style="float: right;">
<?php if ($row['flag'] == 'U'){ ?>URGENT!<?php }; ?>
<?php if ($row['flag'] == 'M'){ ?>Meeting!<?php }; ?>
<?php if ($row['flag'] == 'D'){ ?>Update!<?php }; ?>
<?php if ($row['flag'] == 'A'){ ?>ACTION!<?php }; ?>
<?php if ($row['flag'] == 'I'){ ?>Important!<?php }; ?>
<?php if ($row['flag'] == 'S'){ ?><i>Social Event</i><?php }; ?>
<?php if ($row['flag'] == 'K'){ ?>What's new!<?php }; ?>
<?php if ($row['flag'] == 'R'){ ?><i>Reminder</i><?php }; ?>
<?php if ($row['flag'] == 'C'){ ?>CONSTRUCTION<?php }; ?>
<?php if ($row['flag'] == 'H'){ ?>HOT Topic!<?php }; ?>
<?php if ($row['flag'] == 'G'){ ?>Great News!<?php }; ?>
<?php if ($row['flag'] == 'O'){ ?>Next Up:<?php }; ?>
<?php if ($row['flag'] == 'L'){ ?><i>for laughs!</i><?php }; ?>
<?php if ($row['flag'] == 'W'){ ?><i>Weather</i><?php }; ?>
</div>
<?php }; ?>
<div>
<p><b><?php echo "{$row['headline']}"; ?></b></p>
<?php if ($row['message'] !== ''){ ?><?php echo "{$row['message']}"; ?><?php }; ?>

<?php if ($row['pic'] !== ''){ ?>
	<?php
	    $typeP1    = $row['pic'];
	    $queryP1  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$typeP1'";
	    $resultP1 = mysqli_query($conn,$queryP1);

    	while($rowP1 = $resultP1->fetch_array(MYSQLI_ASSOC))
	    {
    ?>
		<div style="float:right; padding:2px;"><img src="../download-documents-mini.php?id=<?php echo "{$rowP1['id']}"; ?>&docdate=<?php echo "{$rowP1['docdate']}"; ?>&size=<?php echo "{$rowP1['size']}"; ?>" alt="<?php echo "{$rowP1['title']}"; ?>" title="<?php echo "{$rowP1['title']}"; ?>" style="max-height: 50px;"></div>
	<?php
		}
	?>
<?php }; ?>
<?php if ($row['pic2'] !== ''){ ?>
	<?php
	    $typeP1    = $row['pic2'];
	    $queryP1  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$typeP1'";
	    $resultP1 = mysqli_query($conn,$queryP1);

    	while($rowP1 = $resultP1->fetch_array(MYSQLI_ASSOC))
	    {
    ?>
		<div style="float:right; padding:2px;"><img src="../download-documents-mini.php?id=<?php echo "{$rowP1['id']}"; ?>&docdate=<?php echo "{$rowP1['docdate']}"; ?>&size=<?php echo "{$rowP1['size']}"; ?>" alt="<?php echo "{$rowP1['title']}"; ?>" title="<?php echo "{$rowP1['title']}"; ?>" style="max-height: 50px;"></div>
	<?php
		}
	?>
<?php }; ?>
<?php if ($row['pic3'] !== ''){ ?>
	<?php
	    $typeP1    = $row['pic3'];
	    $queryP1  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$typeP1'";
	    $resultP1 = mysqli_query($conn,$queryP1);

    	while($rowP1 = $resultP1->fetch_array(MYSQLI_ASSOC))
	    {
    ?>
		<div style="float:right; padding:2px;"><img src="../download-documents-mini.php?id=<?php echo "{$rowP1['id']}"; ?>&docdate=<?php echo "{$rowP1['docdate']}"; ?>&size=<?php echo "{$rowP1['size']}"; ?>" alt="<?php echo "{$rowP1['title']}"; ?>" title="<?php echo "{$rowP1['title']}"; ?>" style="max-height: 50px;"></div>
	<?php
		}
	?>
<?php }; ?>

<span class="note-black">
<?php if ($row['url'] !== ''){ ?>Web Links: <a href="<?php echo "{$row['url']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('External/<?php echo "{$row['url']}"; ?>'); "><?php echo "{$row['url']}"; ?></a><?php }; ?>
<?php if ($row['email'] !== ''){ ?>&nbsp;|&nbsp;<a href="mailto:<?php echo "{$row['email']}"; ?>" onclick="javascript:pageTracker._trackPageview('Email/<?php echo "{$row['email']}"; ?>'); "><?php echo "{$row['email']}"; ?></a><?php }; ?>
<?php if ($row['docid'] !== ''){ ?><br>
<?php
	$typeD1    = $row['docid'];
	$queryD1  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeD1'";
	$resultD1 = mysqli_query($conn,$queryD1);

	while($rowD1 = $resultD1->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Document ID <?php echo "{$rowD1['id']}"; ?>) <?php echo "{$rowD1['title']}"; ?> (<?php echo "{$rowD1['doctype']}"; ?>)
<?php
	}
?>
<?php }; ?>
<?php if ($row['docid2'] !== ''){ ?><br>
<?php
	$typeD2    = $row['docid2'];
	$queryD2  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeD2'";
	$resultD2 = mysqli_query($conn,$queryD2);

	while($rowD2 = $resultD2->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Document ID <?php echo "{$rowD2['id']}"; ?>) <?php echo "{$rowD2['title']}"; ?> (<?php echo "{$rowD2['doctype']}"; ?>)
<?php
	}
?>
<?php }; ?>
<?php if ($row['docid3'] !== ''){ ?><br>
<?php
	$typeD3    = $row['docid3'];
	$queryD3  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeD3'";
	$resultD3 = mysqli_query($conn,$queryD3);

	while($rowD3 = $resultD3->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Document ID <?php echo "{$rowD3['id']}"; ?>) <?php echo "{$rowD3['title']}"; ?> (<?php echo "{$rowD3['doctype']}"; ?>)
<?php
	}
?>
<?php }; ?>
<?php if ($row['pic'] !== ''){ ?><br>
<?php
	$typeP1    = $row['pic'];
	$queryP1  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeP1'";
	$resultP1 = mysqli_query($conn,$queryP1);

	while($rowP1 = $resultP1->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Photo ID <?php echo "{$rowP1['id']}"; ?>) <?php echo "{$rowP1['title']}"; ?> (<?php echo "{$rowP1['doctype']}"; ?>)
<?php
	}
?>
<?php }; ?>
<?php if ($row['pic2'] !== ''){ ?><br>
<?php
	$typeP2    = $row['pic2'];
	$queryP2  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeP2'";
	$resultP2 = mysqli_query($conn,$queryP2);

	while($rowP2 = $resultP2->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Photo ID <?php echo "{$rowP2['id']}"; ?>) <?php echo "{$rowP2['title']}"; ?> (<?php echo "{$rowP2['doctype']}"; ?>)
<?php
	}
?>
<?php }; ?>
<?php if ($row['pic3'] !== ''){ ?><br>
<?php
	$typeP3   = $row['pic3'];
	$queryP3  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeP3'";
	$resultP3 = mysqli_query($conn,$queryP3);

	while($rowP3 = $resultP3->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Photo ID <?php echo "{$rowP3['id']}"; ?>) <?php echo "{$rowP3['title']}"; ?> (<?php echo "{$rowP3['doctype']}"; ?>)
<?php
	}
?>
<?php }; ?>
<?php if ($row['calid'] !== ''){ ?><br>
<?php
	$typeCID    = $row['calid'];
	$queryCID  = "SELECT `int1`, title, event, date, stime FROM calendar WHERE `int1` = '$typeCID'";
	$resultCID = mysqli_query($conn,$queryCID);

	while($rowCID = $resultCID->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Calendar ID <?php echo "{$rowCID['int1']}"; ?>) <?php echo "{$rowCID['title']}"; ?> (<?php echo "{$rowCID['event']}"; ?>) <?php echo "{$row7['date']}"; ?> <?php echo "{$row7['stime']}"; ?>
<?php
	}
?>
<?php }; ?>
<?php if ($row['folderid'] !== ''){ ?><br>
<?php
	$typeFID    = $row['folderid'];
	$queryFID  = "SELECT `int1`, title FROM folders WHERE `int1` = '$typeFID'";
	$resultFID = mysqli_query($conn,$queryFID);

	while($rowFID = $resultFID->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Folder ID <?php echo "{$rowFID['int1']}"; ?>) <?php echo "{$rowFID['title']}"; ?>
<?php
	}
?>
<?php }; ?>
<?php if ($row['tabid'] !== ''){ ?><br>
<?php
	$typeTID    = $row['tabid'];
	$queryTID  = "SELECT `int1`, title FROM tabs WHERE `int1` = '$typeTID'";
	$resultTID = mysqli_query($conn,$queryTID);

	while($rowTID = $resultTID->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Module ID <?php echo "{$rowTID['int1']}"; ?>) <?php echo "{$rowTID['title']}"; ?>
<?php
	}
?>
<?php }; ?>

<?php if ($row['digitaldisplaymessage'] !== ''){ ?><br><i class="fa fa-television" aria-hidden="true" title="This article includes an alternate summary for the Digital Information Display."></i> <span class="note-red">This article includes an alternate summary for the Digital Information Display.</span><?php }; ?>

<!-- STARS -->
<?php if ($row['sample'] !== '0'){ ?><br><i class="fa fa-star s" aria-hidden="true" style="color: lightgray" title="This is a sample article created by CondoSites. It does NOT count toward your stars."></i> <span class="note-red">This is a sample article created by CondoSites. It does NOT count toward your stars.</span><?php }; ?>
<?php if ($row['sample'] == '0'){ ?><br><i class="fa fa-star s" aria-hidden="true" style="color: lightgray" title="This article will count toward your stars when it reaches its date to show on your Newsboard."></i> <span class="note-red">This article will count toward your stars when it reaches its date to show on your Newsboard.</span><?php }; ?>
<!-- STARS -->



</span>
</div>
    <?php if ($row['eod'] <= $row['pod']){ ?><br><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="note-red">The expiration date is before the posting date.</span><?php }; ?>
</div>
        </div>
        <div class="small-6 medium-6 large-2 columns" style="padding:10px">
            <form name="CBEdit" method="POST" action="chalkboard-edit.php">
              <input type="hidden" name="action" value="edit">
              <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
              <input name="submit" value="Edit" class="submit" type="submit">
            </form>
        </div>
		<div class="small-6 medium-6 large-2 columns" style="padding:10px">
            <form name="CBDup" method="POST" action="chalkboard-duplicate.php">
                <input type="hidden" name="action" value="duplicate">
                <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
                <input name="submit" value="Copy" class="submit" type="submit">
            </form>
		</div>
        <div class="small-6 medium-6 large-2 columns" style="padding:10px">
            <form name="CBDelete" method="POST" action="chalkboard.php" onclick="return confirm('Are you sure you want to delete the Newsboard entry: <?php echo "{$row['headline']}"; ?>?');">
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
              <input name="submit" value="Delete" class="submit" type="submit">
            </form>
        </div>
      </td>
      <td><?php echo "{$row['int1']}"; ?></td>
      <td><?php echo "{$row['pod']}"; ?></td>
      <td <?php if ($row['eod'] <= $row['pod']){ ?>class="note-red"<?php }; ?>><?php echo "{$row['eod']}"; ?></td>
      <td align="center" <?php if ($row['owner'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['owner'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['owner']}"; ?></td>
      <td align="center" <?php if ($row['lease'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['lease'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['lease']}"; ?></td>
      <td align="center" <?php if ($row['realtor'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['realtor'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['realtor']}"; ?></td>
      <td align="center" <?php if ($row['digitaldisplay'] !== 'Y'){ ?>bgcolor="#f4d6a3"<?php }; ?><?php if ($row['digitaldisplay'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['digitaldisplay']}"; ?></td>
    </tr>
<!-- END DATABASE RESULTS -->
<?php
	}
?>
  </tbody>
</table>
<br>
<div class="nav-section-header-cp">
        <strong><?php $sql = mysqli_query($conn,"SELECT count(*) FROM chalkboard WHERE eod < CURDATE() AND eod BETWEEN CURDATE() - INTERVAL 450 DAY AND SYSDATE()") or die(mysqli_error($conn));
        //$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Past Newsboard Articles</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr align="left">
      <th colspan="8"><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Expired Newsboard Articles are retained for 15 months.</span></th>
    </tr>
    <tr align="left">
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp;<b><small>Message</small></b></th>
      <th width="50" class="table-sortable:numeric">&nbsp;&nbsp;&nbsp; <small>ID</small></th>
      <th class="table-sortable:date">&nbsp;&nbsp;&nbsp;<small>Post On</small></th>
      <th class="table-sortable:date">&nbsp;&nbsp;&nbsp;<small>Expiration</small></th>
	  <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Owner</small></b></div></th>
	  <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Renter</small></b></div></th>
	  <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Realtor</small></b></div></th>
	  <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>DID</small></b></div></th>
    </tr>
  </thead>
  <tbody style="background-color:#ffffff">
<?php
$query  = "SELECT `int1`, pod, eod, headline, message, digitaldisplaymessage, url, email, potime, docid, docid2, docid3, pic, pic2, pic3, tabid, folderid, calid, owner, realtor, lease, flag, digitaldisplay, sample FROM chalkboard WHERE eod < CURDATE() AND eod BETWEEN CURDATE() - INTERVAL 450 DAY AND SYSDATE() ORDER BY pod DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- DATABASE RESULTS -->
    <tr>
      <td>
          <div class="small-12 medium-12 large-10 columns">
<?php if ($row['flag'] !== 'N'){ ?>
<div class="cp-ribbon ribbon__<?php echo "{$row['flag']}"; ?>" style="float: right;">
<?php if ($row['flag'] == 'U'){ ?>URGENT!<?php }; ?>
<?php if ($row['flag'] == 'M'){ ?>Meeting!<?php }; ?>
<?php if ($row['flag'] == 'D'){ ?>Update!<?php }; ?>
<?php if ($row['flag'] == 'A'){ ?>ACTION!<?php }; ?>
<?php if ($row['flag'] == 'I'){ ?>Important!<?php }; ?>
<?php if ($row['flag'] == 'S'){ ?><i>Social Event</i><?php }; ?>
<?php if ($row['flag'] == 'K'){ ?>What's new!<?php }; ?>
<?php if ($row['flag'] == 'R'){ ?><i>Reminder</i><?php }; ?>
<?php if ($row['flag'] == 'C'){ ?>CONSTRUCTION<?php }; ?>
<?php if ($row['flag'] == 'H'){ ?>HOT Topic!<?php }; ?>
<?php if ($row['flag'] == 'G'){ ?>Great News!<?php }; ?>
<?php if ($row['flag'] == 'O'){ ?>Next Up:<?php }; ?>
<?php if ($row['flag'] == 'L'){ ?><i>for laughs!</i><?php }; ?>
<?php if ($row['flag'] == 'W'){ ?><i>Weather</i><?php }; ?>
</div>
<?php }; ?>
<div>
<p><b><?php echo "{$row['headline']}"; ?></b></p>
<?php if ($row['message'] !== ''){ ?><?php echo "{$row['message']}"; ?><?php }; ?>

<?php if ($row['pic'] !== ''){ ?>
	<?php
	    $typeP1    = $row['pic'];
	    $queryP1  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$typeP1'";
	    $resultP1 = mysqli_query($conn,$queryP1);

    	while($rowP1 = $resultP1->fetch_array(MYSQLI_ASSOC))
	    {
    ?>
		<div style="float:right; padding:2px;"><img src="../download-documents-mini.php?id=<?php echo "{$rowP1['id']}"; ?>&docdate=<?php echo "{$rowP1['docdate']}"; ?>&size=<?php echo "{$rowP1['size']}"; ?>" alt="<?php echo "{$rowP1['title']}"; ?>" title="<?php echo "{$rowP1['title']}"; ?>" style="max-height: 50px;"></div>
	<?php
		}
	?>
<?php }; ?>
<?php if ($row['pic2'] !== ''){ ?>
	<?php
	    $typeP1    = $row['pic2'];
	    $queryP1  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$typeP1'";
	    $resultP1 = mysqli_query($conn,$queryP1);

    	while($rowP1 = $resultP1->fetch_array(MYSQLI_ASSOC))
	    {
    ?>
		<div style="float:right; padding:2px;"><img src="../download-documents-mini.php?id=<?php echo "{$rowP1['id']}"; ?>&docdate=<?php echo "{$rowP1['docdate']}"; ?>&size=<?php echo "{$rowP1['size']}"; ?>" alt="<?php echo "{$rowP1['title']}"; ?>" title="<?php echo "{$rowP1['title']}"; ?>" style="max-height: 50px;"></div>
	<?php
		}
	?>
<?php }; ?>
<?php if ($row['pic3'] !== ''){ ?>
	<?php
	    $typeP1    = $row['pic3'];
	    $queryP1  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$typeP1'";
	    $resultP1 = mysqli_query($conn,$queryP1);

    	while($rowP1 = $resultP1->fetch_array(MYSQLI_ASSOC))
	    {
    ?>
		<div style="float:right; padding:2px;"><img src="../download-documents-mini.php?id=<?php echo "{$rowP1['id']}"; ?>&docdate=<?php echo "{$rowP1['docdate']}"; ?>&size=<?php echo "{$rowP1['size']}"; ?>" alt="<?php echo "{$rowP1['title']}"; ?>" title="<?php echo "{$rowP1['title']}"; ?>" style="max-height: 50px;"></div>
	<?php
		}
	?>
<?php }; ?>

<span class="note-black">
<?php if ($row['url'] !== ''){ ?>Web Links: <a href="<?php echo "{$row['url']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('External/<?php echo "{$row['url']}"; ?>'); "><?php echo "{$row['url']}"; ?></a><?php }; ?>
<?php if ($row['email'] !== ''){ ?>&nbsp;|&nbsp;<a href="mailto:<?php echo "{$row['email']}"; ?>" onclick="javascript:pageTracker._trackPageview('Email/<?php echo "{$row['email']}"; ?>'); "><?php echo "{$row['email']}"; ?></a><?php }; ?>
<?php if ($row['docid'] !== ''){ ?><br>
<?php
	$typeD1    = $row['docid'];
	$queryD1  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeD1'";
	$resultD1 = mysqli_query($conn,$queryD1);

	while($rowD1 = $resultD1->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Document ID <?php echo "{$rowD1['id']}"; ?>) <?php echo "{$rowD1['title']}"; ?> (<?php echo "{$rowD1['doctype']}"; ?>)
<?php
	}
?>
<?php }; ?>
<?php if ($row['docid2'] !== ''){ ?><br>
<?php
	$typeD2    = $row['docid2'];
	$queryD2  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeD2'";
	$resultD2 = mysqli_query($conn,$queryD2);

	while($rowD2 = $resultD2->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Document ID <?php echo "{$rowD2['id']}"; ?>) <?php echo "{$rowD2['title']}"; ?> (<?php echo "{$rowD2['doctype']}"; ?>)
<?php
	}
?>
<?php }; ?>
<?php if ($row['docid3'] !== ''){ ?><br>
<?php
	$typeD3    = $row['docid3'];
	$queryD3  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeD3'";
	$resultD3 = mysqli_query($conn,$queryD3);

	while($rowD3 = $resultD3->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Document ID <?php echo "{$rowD3['id']}"; ?>) <?php echo "{$rowD3['title']}"; ?> (<?php echo "{$rowD3['doctype']}"; ?>)
<?php
	}
?>
<?php }; ?>
<?php if ($row['pic'] !== ''){ ?><br>
<?php
	$typeP1    = $row['pic'];
	$queryP1  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeP1'";
	$resultP1 = mysqli_query($conn,$queryP1);

	while($rowP1 = $resultP1->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Photo ID <?php echo "{$rowP1['id']}"; ?>) <?php echo "{$rowP1['title']}"; ?> (<?php echo "{$rowP1['doctype']}"; ?>)
<?php
	}
?>
<?php }; ?>
<?php if ($row['pic2'] !== ''){ ?><br>
<?php
	$typeP2    = $row['pic2'];
	$queryP2  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeP2'";
	$resultP2 = mysqli_query($conn,$queryP2);

	while($rowP2 = $resultP2->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Photo ID <?php echo "{$rowP2['id']}"; ?>) <?php echo "{$rowP2['title']}"; ?> (<?php echo "{$rowP2['doctype']}"; ?>)
<?php
	}
?>
<?php }; ?>
<?php if ($row['pic3'] !== ''){ ?><br>
<?php
	$typeP3   = $row['pic3'];
	$queryP3  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeP3'";
	$resultP3 = mysqli_query($conn,$queryP3);

	while($rowP3 = $resultP3->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Photo ID <?php echo "{$rowP3['id']}"; ?>) <?php echo "{$rowP3['title']}"; ?> (<?php echo "{$rowP3['doctype']}"; ?>)
<?php
	}
?>
<?php }; ?>
<?php if ($row['calid'] !== ''){ ?><br>
<?php
	$typeCID    = $row['calid'];
	$queryCID  = "SELECT `int1`, title, event, date, stime FROM calendar WHERE `int1` = '$typeCID'";
	$resultCID = mysqli_query($conn,$queryCID);

	while($rowCID = $resultCID->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Calendar ID <?php echo "{$rowCID['int1']}"; ?>) <?php echo "{$rowCID['title']}"; ?> (<?php echo "{$rowCID['event']}"; ?>) <?php echo "{$row7['date']}"; ?> <?php echo "{$row7['stime']}"; ?>
<?php
	}
?>
<?php }; ?>
<?php if ($row['folderid'] !== ''){ ?><br>
<?php
	$typeFID    = $row['folderid'];
	$queryFID  = "SELECT `int1`, title FROM folders WHERE `int1` = '$typeFID'";
	$resultFID = mysqli_query($conn,$queryFID);

	while($rowFID = $resultFID->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Folder ID <?php echo "{$rowFID['int1']}"; ?>) <?php echo "{$rowFID['title']}"; ?>
<?php
	}
?>
<?php }; ?>
<?php if ($row['tabid'] !== ''){ ?><br>
<?php
	$typeTID    = $row['tabid'];
	$queryTID  = "SELECT `int1`, title FROM tabs WHERE `int1` = '$typeTID'";
	$resultTID = mysqli_query($conn,$queryTID);

	while($rowTID = $resultTID->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Module ID <?php echo "{$rowTID['int1']}"; ?>) <?php echo "{$rowTID['title']}"; ?>
<?php
	}
?>
<?php }; ?>

<?php if ($row['digitaldisplaymessage'] !== ''){ ?><br><i class="fa fa-television" aria-hidden="true" title="This article includes an alternate summary for the Digital Information Display."></i> <span class="note-red">This article includes an alternate summary for the Digital Information Display.</span><?php }; ?>

<!-- STARS -->
<?php if ($row['sample'] !== '0'){ ?><br><i class="fa fa-star s" aria-hidden="true" style="color: lightgray" title="This is a sample article created by CondoSites. It does NOT count toward your stars."></i> <span class="note-red">This is a sample article created by CondoSites. It does NOT count toward your stars.</span><?php }; ?>
<?php if ($row['sample'] == '0'){ ?><br><i class="fa fa-star s" aria-hidden="true" style="color: lightgray" title="This article has expired and no longer counts toward your stars."></i> <span class="note-red">This article has expired and no longer counts toward your stars.</span><?php }; ?>
<!-- STARS -->



</span>
</div>
    <?php if ($row['eod'] <= $row['pod']){ ?><br><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="note-red">The expiration date is before the posting date.</span><?php }; ?>
</div>
        </div>
        <div class="small-6 medium-6 large-2 columns" style="padding:10px">
            <form name="CBEdit" method="POST" action="chalkboard-edit.php">
              <input type="hidden" name="action" value="edit">
              <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
              <input name="submit" value="Edit" class="submit" type="submit">
            </form>
        </div>
		<div class="small-6 medium-6 large-2 columns" style="padding:10px">
            <form name="CBDup" method="POST" action="chalkboard-duplicate.php">
                <input type="hidden" name="action" value="duplicate">
                <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
                <input name="submit" value="Copy" class="submit" type="submit">
            </form>
		</div>
        <div class="small-6 medium-6 large-2 columns" style="padding:10px">
            <form name="CBDelete" method="POST" action="chalkboard.php" onclick="return confirm('Are you sure you want to delete the Newsboard entry: <?php echo "{$row['headline']}"; ?>?');">
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
              <input name="submit" value="Delete" class="submit" type="submit">
            </form>
        </div>
      </td>
      <td><?php echo "{$row['int1']}"; ?></td>
      <td><?php echo "{$row['pod']}"; ?></td>
      <td <?php if ($row['eod'] <= $row['pod']){ ?>class="note-red"<?php }; ?>><?php echo "{$row['eod']}"; ?></td>
      <td align="center" <?php if ($row['owner'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['owner'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['owner']}"; ?></td>
      <td align="center" <?php if ($row['lease'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['lease'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['lease']}"; ?></td>
      <td align="center" <?php if ($row['realtor'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['realtor'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['realtor']}"; ?></td>
      <td align="center" <?php if ($row['digitaldisplay'] !== 'Y'){ ?>bgcolor="#f4d6a3"<?php }; ?><?php if ($row['digitaldisplay'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['digitaldisplay']}"; ?></td>
    </tr>
<!-- END DATABASE RESULTS -->
<?php
	}
?>
  </tbody>
</table>
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Newsboard Articles Control Panel Page<br></div>
</body>
</html>
