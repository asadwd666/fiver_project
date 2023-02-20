<?php $current_page = '9'; include('protect.php'); $int1 = $_POST["int1"]; $action = $_POST["action"];

        $helpStyle = "background-color: #ffcccc; margin-right: -10px; padding-right: 10px;";

if ($action == "save"){

        
		$pod = $_POST["pod"];
		$eod = $_POST["eod"];
		$headline = htmlspecialchars($_POST['headline'], ENT_QUOTES);
		$message = $_POST["message"];
		$iframe = $_POST["iframe"];
		$url = htmlspecialchars($_POST['url'], ENT_QUOTES);
		$email = htmlspecialchars($_POST['email'], ENT_QUOTES);
		$docid = $_POST["docid"];
		$docid2 = $_POST["docid2"];
		$docid3 = $_POST["docid3"];
		$pic = $_POST["pic"];
		$pic2 = $_POST["pic2"];
		$pic3 = $_POST["pic3"];
		$folderid = $_POST["folderid"];
		$tabid = $_POST["tabid"];
		$calid = $_POST["calid"];
		$owner = $_POST["owner"];
		$lease = $_POST["lease"];
		$realtor = $_POST["realtor"];
		$flag = $_POST["flag"];
		$digitaldisplay = $_POST["digitaldisplay"];
		$digitaldisplaymessage = $_POST["digitaldisplaymessage"];

		$query = "UPDATE chalkboard SET pod='$pod', eod='$eod', headline='$headline', message='$message', iframe='$iframe', url='$url', email='$email', docid='$docid', docid2='$docid2', docid3='$docid3', pic='$pic', pic2='$pic2', pic3='$pic3', folderid='$folderid', tabid='$tabid', calid='$calid', owner='$owner', lease='$lease', realtor='$realtor', flag='$flag', digitaldisplay='$digitaldisplay', digitaldisplaymessage='$digitaldisplaymessage' WHERE `int1`='$int1' LIMIT 1";
		mysqli_query($conn,$query) or die('Error, update query failed');

		$date = date("F j, Y");
		$query = "UPDATE updatedate SET date='$date'";
		mysqli_query($conn,$query) or die('Error, updating update date failed');

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['int1'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('E', 'Newsboard', '$useripaddress', '$userid', '$id')";
		mysqli_query($conn,$query) or die('Error, updating log failed');

		header('Location: chalkboard.php');
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
<!-- INPUT FORM -->
<br>
<div style="max-width: 99%;">
<div class="nav-section-header-cp">
        <strong>Edit a Newsboard Article</strong>
</div>

<?php
	$query  = "SELECT * FROM chalkboard WHERE `int1`='$int1' LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<div class="cp-form-container">
<!-- COLUMN 1 -->
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 0px 0px;">
<form enctype="multipart/form-data" method="POST" action="chalkboard-edit.php">
            <div class="small-12 medium-12 columns"><strong>1) Headline and Article</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-3 columns"><label for="headline" class="middle">Headline</label></div>
            <div class="small-12 medium-9 end columns"><input name="headline" placeholder="Extra! Extra! Read all about it..." maxlength="100" class="form" type="text" value="<?php echo "{$row['headline']}"; ?>" required autofocus></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 end columns" style="padding-bottom: 10px;">
                <label for="file" class="middle" style="margin-bottom: -5px;">Main body of your Newsboard Article...<br>
                    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">If pasting content from Microsoft Word, use the "Paste from Word" ( <img src="https://condosites.net/commons/pastefromword.png" width="15"> ) button.</span><br>
			        <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Use the Styles pulldown to apply <b><span class="bluepen">c</span><span class="greenpen">o</span><span class="bluepen">l</span><span class="greenpen">o</span><span class="bluepen">r</span></b> and formatting <span class="marker">styles</span> to your text.</span>
			    </label>
                <textarea name="message" cols="30" rows="2" id="editor1" class="form" type="text"><?php echo "{$row['message']}"; ?></textarea>
                <script>CKEDITOR.replace( 'editor1' );</script>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 end columns" style="padding-bottom: 10px;">
                <?php if ($row['digitaldisplaymessage'] == ''){ ?>
                <label for="digitaldisplaymessage" class="middle" style="margin-bottom: -5px;">
                    <input type="checkbox" name="digitaldisplaymessage" onclick="showMe('digitaldisplaymessage', this)" /> Summary for <a href="http://condosites.com/digitalsignage.php" target="_blank"><b>Digital Information Display</b></a></label>
                <div id="digitaldisplaymessage" style="display:none">
                        <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Text entered here will show instead of the above main body of text on your Digital Display.</span><br>
                        <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">If pasting content from Microsoft Word, use the "Paste from Word" ( <img src="https://condosites.net/commons/pastefromword.png" width="15"> ) button.</span><br>
    			        <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Use the Styles pulldown to apply <b><span class="bluepen">c</span><span class="greenpen">o</span><span class="bluepen">l</span><span class="greenpen">o</span><span class="bluepen">r</span></b> and formatting <span class="marker">styles</span> to your text.</span>
                    <textarea name="digitaldisplaymessage" cols="30" rows="2" id="editor2" class="form" type="text"><?php echo "{$row['digitaldisplaymessage']}"; ?></textarea>
                    <script>CKEDITOR.replace( 'editor2' );</script>
                </div>
                <?php }; ?>
                
                <?php if ($row['digitaldisplaymessage'] != ''){ ?>
                <label for="digitaldisplaymessage" class="middle" style="margin-bottom: -5px;">Summary for <a href="http://condosites.com/digitalsignage.php" target="_blank"><b>Digital Information Display</b></a></label>
                <div id="digitaldisplaymessage">
                    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Text entered here will show instead of the above main body of text on your Digital Display.</span><br>
                    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">If pasting content from Microsoft Word, use the "Paste from Word" ( <img src="https://condosites.net/commons/pastefromword.png" width="15"> ) button.</span><br>
    			    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Use the Styles pulldown to apply <b><span class="bluepen">c</span><span class="greenpen">o</span><span class="bluepen">l</span><span class="greenpen">o</span><span class="bluepen">r</span></b> and formatting <span class="marker">styles</span> to your text.</span>
                    <textarea name="digitaldisplaymessage" cols="30" rows="2" id="editor3" class="form" type="text"><?php echo "{$row['digitaldisplaymessage']}"; ?></textarea>
                <script>CKEDITOR.replace( 'editor3' );</script>
                </div>
                <?php }; ?>
                
                <?php if ($row['iframe'] == ''){ ?>
                <label for="iframeQ" class="middle" style="margin-bottom: -5px;"><input type="checkbox" name="iframeQ" onclick="showMe('iframe', this)" /> Add Optional iFrame Code &nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">From websites like YouTube.</span></label>
                <div id="iframe" style="display:none">
                    <textarea name="iframe" cols="30" rows="2" class="form" type="text"><?php echo "{$row['iframe']}"; ?></textarea>
                </div>
                <?php }; ?>
                <?php if ($row['iframe'] != ''){ ?>
                <label for="iframeQ" class="middle" style="margin-bottom: -5px;">Optional iFrame Code &nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">From websites like YouTube.</span></label>
                <div id="iframe">
                    <textarea name="iframe" cols="30" rows="2" class="form" type="text"><?php echo "{$row['iframe']}"; ?></textarea>
                </div>
                <?php }; ?>
            </div>
        </div>
        <div class="row" style="padding: 10px 10px 0px 0px;">
            <div class="small-12 medium-12 columns"><strong>2) Dates!</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-6 columns"><label for="pod" class="middle">When should this article appear for users?<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Articles appear in reverse chronological order (newest to oldest) from this field.</span></label></div>
            <div class="small-12 medium-6 end columns"><input name="pod" class="form datepicker" type="date" value="<?php echo "{$row['pod']}"; ?>" required></div>
        </div>
<?php if ($row['eod'] <= $row['pod']) { ?>
        <div class="small-12 medium-12 columns" style="padding-top: 10px;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="note-red">The expiration date is before the posting date.</span></div>
<?php }; ?>
        <div class="row medium-collapse" style="padding-left: 30px; <?php if ($row['eod'] <= $row['pod']) { echo($helpStyle); }; ?>">
            <div class="small-12 medium-6 columns"><label for="eod" class="middle">When should this article expire?</label></div>
            <div class="small-12 medium-6 end columns"><input name="eod" class="form datepicker" type="date" value="<?php echo "{$row['eod']}"; ?>" required></div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>3) Who should see this article?</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="owner" class="middle">Show in <b>Owner</b> Section? </label></div>
            <div class="small-12 medium-2 end columns" style="padding-right: 15px;">
<select name="owner" class="form">
<option value="Y" <?php if($row['owner'] == "Y"){ echo("SELECTED"); } ?>>Yes</option>
<option value="N" <?php if($row['owner'] == "N"){ echo("SELECTED"); } ?>>No</option>
</select>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="lease" class="middle">Show in <b>Renter</b> Section? </label></div>
            <div class="small-12 medium-2 end columns" style="padding-right: 15px;">
<select name="lease" class="form">
<option value="Y" <?php if($row['lease'] == "Y"){ echo("SELECTED"); } ?>>Yes</option>
<option value="N" <?php if($row['lease'] == "N"){ echo("SELECTED"); } ?>>No</option>
</select>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="realtor" class="middle">Show in <b>Realtor</b> Section? </label></div>
            <div class="small-12 medium-2 end columns" style="padding-right: 15px;">
<select name="realtor" class="form">
<option value="Y" <?php if($row['realtor'] == "Y"){ echo("SELECTED"); } ?>>Yes</option>
<option value="N" <?php if($row['realtor'] == "N"){ echo("SELECTED"); } ?>>No</option>
</select>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="digitaldisplay" class="middle">Show <a href="http://condosites.com/digitaldisplay.php" target="_blank"><b>Digital Information Display</b></a>? </label></div>
            <div class="small-12 medium-2 end columns" style="padding-right: 15px;">
<select name="digitaldisplay" class="form">
<option value="Y" <?php if($row['digitaldisplay'] == "Y"){ echo("SELECTED"); } ?>>Yes</option>
<option value="N" <?php if($row['digitaldisplay'] == "N"){ echo("SELECTED"); } ?>>No</option>
</select>
            </div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>4) Add a flag!</strong>  &nbsp;&nbsp;&nbsp;&nbsp;<small><i>Optional</i></small></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-8 columns" style="padding-right: 15px;">
<label class="middle" style="margin-bottom: -5px;">Add optional themed flag to get user&apos;s attention.</label>
<select name="flag" class="form">
<option value="N" <?php if($row['flag'] == "N"){ echo("SELECTED"); } ?>>None</option>
<option value="U" <?php if($row['flag'] == "U"){ echo("SELECTED"); } ?>>URGENT!</option>
<option value="M" <?php if($row['flag'] == "M"){ echo("SELECTED"); } ?>>Meeting!</option>
<option value="A" <?php if($row['flag'] == "A"){ echo("SELECTED"); } ?>>Action!</option>
<option value="D" <?php if($row['flag'] == "D"){ echo("SELECTED"); } ?>>Update!</option>
<option value="I" <?php if($row['flag'] == "I"){ echo("SELECTED"); } ?>>Important!</option>
<option value="C" <?php if($row['flag'] == "C"){ echo("SELECTED"); } ?>>Construction</option>
<option value="R" <?php if($row['flag'] == "R"){ echo("SELECTED"); } ?>>Reminder</option>
<option value="K" <?php if($row['flag'] == "K"){ echo("SELECTED"); } ?>>What's new!</option>
<option value="S" <?php if($row['flag'] == "S"){ echo("SELECTED"); } ?>>Social Event</option>
<option value="H" <?php if($row['flag'] == "H"){ echo("SELECTED"); } ?>>Hot Topic!</option>
<option value="G" <?php if($row['flag'] == "G"){ echo("SELECTED"); } ?>>Great News</option>
<option value="O" <?php if($row['flag'] == "O"){ echo("SELECTED"); } ?>>Next Up:</option>
<option value="L" <?php if($row['flag'] == "L"){ echo("SELECTED"); } ?>>for laughs!</option>
<option value="W" <?php if($row['flag'] == "W"){ echo("SELECTED"); } ?>>Weather</option>
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
            <div class="small-12 medium-7 end columns"><input name="url" maxlength="100" class="form" type="url" placeholder="Be sure your link starts with http://" value="<?php echo "{$row['url']}"; ?>"></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="email" class="middle">Add an email address?</label></div>
            <div class="small-12 medium-7 end columns"><input name="email" maxlength="100" class="form" type="email" placeholder="mabell@att.com" value="<?php echo "{$row['email']}"; ?>"></div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns" style="margin-bottom: -20px;"><strong>6) Link Documents and Add Photos...</strong>  &nbsp;&nbsp;&nbsp;&nbsp;<small><i>Optional</i></small><label class="middle"><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Upload your documents and photos in the Documents &amp; Photos control panel.</span><br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Looking to add video? <a href="https://condosites.com/help/videos.php" target="_blank">Check out this help article.</a></span></label></div>
        </div>
<?php include('docid-field-edit.php'); ?>
<?php include('docid-field-edit-multi.php'); ?>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns" style="margin-bottom: -20px;"><strong>7) Link Folders, Modules, eForms, and Calendar Events...</strong>  &nbsp;&nbsp;&nbsp;&nbsp;<small><i>Optional</i></small><label class="middle"><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Setup this content in advance in their respective control panel.</span></label></div>
        </div>
<?php include('folderid-field-edit.php'); ?>
<?php include('tabid-field-edit.php'); ?>
<?php include('calid-field-edit.php'); ?>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>8) Ready to Save?</strong></div>
        </div>
        <div class="row medium-collapse">
            <div class="small-6 columns" align="center">
                <input type="hidden" name="action" value="save">
	            <input type="hidden" name="int1" value="<?php echo $_POST['int1']; ?>">
	            <input name="submit" value="Save" class="submit" type="submit">
            </div>
</form>
            <div class="small-6 end columns" align="center">
<form action="chalkboard.php" method="get">
                <input type="submit" value="Cancel and Go Back" onclick="return confirm('Are you sure you wish to leave this page? Unsaved changes will be lost.');">
</form>
            </div>
        </div>
    </div>
<!-- COLUMN 2 -->
</div>
</form>
<?php
	}
?>
<!-- END INPUT FORM -->
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Newsboard Article Edit Control Panel Page<br></div>
</body>
</html>
