<?php $current_page = '21'; include('protect.php'); $int1 = $_POST["int1"]; $module = $_POST['module']; $action = $_POST["action"]; if ($action == "save"){

		$text1 = $_POST["text1"];
		$text2 = $_POST["text2"];
		$terms = $_POST["terms"];

		$query = "UPDATE forms SET text1='$text1', text2='$text2', terms='$terms' WHERE `int1`='$int1' LIMIT 1";
		mysqli_query($conn,$query) or die('Error, update query failed');

		$date = date("F j, Y");
		$query = "UPDATE updatedate SET date='$date'";
		mysqli_query($conn,$query) or die('Error, updating update date failed');

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['int1'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('E', 'Forms', '$useripaddress', '$userid', '$id')";
		mysqli_query($conn,$query) or die('Error, updating log failed');

		$query = "OPTIMIZE TABLE `forms`";
		mysqli_query($conn,$query) or die('Error, delete query failed');


		header('Location: '.$module);
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
<?php echo($errorSUCCESS); ?>
<!-- INPUT FORM -->
<?php
	$query  = "SELECT text1, text2, terms, email FROM forms WHERE `int1`='$int1' LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<div class="nav-section-header-cp">
        <strong>
<?php
	$type    = $int1;
	$queryTAB  = "SELECT `title` FROM tabs WHERE `int1` = '$type'";
	$resultTAB = mysqli_query($conn,$queryTAB);

	while($rowTAB = $resultTAB->fetch_array(MYSQLI_ASSOC))
	{
?>
Customize <?php echo "{$rowTAB['title']}"; ?>
<?php
	}
?>
        </strong>
</div>
<div class="cp-form-container">
<!-- COLUMN 1 -->
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 10px 0px;">
<form enctype="multipart/form-data" method="POST" action="forms-edit.php">
            <div class="small-12 medium-12 columns"><strong>1) Text to appear at the top of the eForm...</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 end columns" style="padding-bottom: 10px;">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">If pasting content from Microsoft Word, use the "Paste from Word" ( <img src="https://condosites.net/commons/pastefromword.png" width="15"> ) button.</span><br>
    			<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Use the Styles pulldown to apply <b><span class="bluepen">c</span><span class="greenpen">o</span><span class="bluepen">l</span><span class="greenpen">o</span><span class="bluepen">r</span></b> and formatting <span class="marker">styles</span> to your text.</span>
                <textarea name="text1" cols="30" rows="2" id="editor1" class="form" type="text" placeholder="Use this form to..." required autofocus><?php echo "{$row['text1']}"; ?></textarea>
                <script>CKEDITOR.replace( 'editor1' );</script>
            </div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>2) Text to appear in Terms field...</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 end columns" style="padding-bottom: 20px;">
                <label for="file" class="middle"><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Do <b>NOT</b> use HTML in this field!</span></label>
                <textarea name="terms" cols="30" rows="2" class="form" type="text"><?php echo "{$row['terms']}"; ?></textarea>
            </div>
        </div>
    </div>
<!-- END COLUMN 1 -->
<!-- COLUMN 2 -->
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>3) Text to appear at the bottom of the eForm...</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 end columns" style="padding-bottom: 10px;">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">If pasting content from Microsoft Word, use the "Paste from Word" ( <img src="https://condosites.net/commons/pastefromword.png" width="15"> ) button.</span><br>
    			<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Use the Styles pulldown to apply <b><span class="bluepen">c</span><span class="greenpen">o</span><span class="bluepen">l</span><span class="greenpen">o</span><span class="bluepen">r</span></b> and formatting <span class="marker">styles</span> to your text.</span>
    			<textarea name="text2" cols="30" rows="2" id="editor2" class="form" type="text"><?php echo "{$row['text2']}"; ?></textarea>
                <script>CKEDITOR.replace( 'editor2' );</script>
            </div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>4) Email</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-7 columns"><label for="email" class="middle">Distribution List &nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Only editable by your Webmaster.</span></label></div>
            <div class="small-12 medium-5 end columns"><input name="email" maxlength="100" class="form" type="email" placeholder="<?php echo "{$row['email']}"; ?>" value="<?php echo "{$row['email']}"; ?>" readonly></div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>5) Ready to Save?</strong></div>
        </div>
        <div class="row medium-collapse">
            <div class="small-6 columns" align="center">
                <input type="hidden" name="action" value="save">
	            <input type="hidden" name="module" value="<?php echo $_POST['module']; ?>">
	            <input type="hidden" name="int1" value="<?php echo $_POST['int1']; ?>">
	            <input name="submit" value="Save" class="submit" type="submit">
                <?php echo($error); ?>
</form>
            </div>
            <div class="small-6 end columns" align="center">
<form action="forms.php" method="get">
	            <input type="submit" value="Cancel" onclick="return confirm('Are you sure you wish to leave this page? Unsaved changes will be lost.');">
</form>
            </div>
        </div>
    </div>
<!-- COLUMN 2 -->
</div>
<?php }; ?>
<!-- END INPUT FORM -->
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>eForms Edit Control Panel Page<br></div>
</body>
</html>
