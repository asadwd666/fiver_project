<?php $current_page = '6'; include('protect.php'); $int1 = $_POST["int1"]; $action = $_POST["action"]; if ($action == "save"){

		$type = $_POST["type"];
		$question = htmlspecialchars($_POST['question'], ENT_QUOTES);
		$answer = $_POST["answer"];
		$web = htmlspecialchars($_POST['web'], ENT_QUOTES);
		$email = htmlspecialchars($_POST['email'], ENT_QUOTES);
		$docid = $_POST["docid"];
		$created_date = date('Y-m-d H:i:s');

		$query = "UPDATE faq SET type='$type', question='$question', answer='$answer', web='$web', email='$email', docid='$docid', created_date='$created_date' WHERE `int1`='$int1' LIMIT 1";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

		$date = date("F j, Y");
		$query = "UPDATE updatedate SET date='$date'";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['int1'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('E', 'FAQ', '$useripaddress', '$userid', '$id')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
		
		header('Location: faq.php');

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
<!-- INPUT FORM -->
<?php
	$query  = "SELECT `int1`, type, question, answer, web, email, docid FROM faq WHERE `int1`='$int1' LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<div class="nav-section-header-cp">
        <strong>Edit a Frequently Asked Question</strong>
</div>
<div class="cp-form-container">
<!-- COLUMN 1 -->
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 10px 0px;">
<form enctype="multipart/form-data" method="POST" action="faq-edit.php">
            <div class="small-12 medium-12 columns"><strong>1) What question are people frequently asking?</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 end columns"><input name="question" size="30" maxlength="100" class="form" placeholder="What day is trash day?" type="text" value="<?php echo "{$row['question']}"; ?>" required autofocus></div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>2) What is the answer?</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 end columns" style="padding-bottom: 10px;">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">If pasting content from Microsoft Word, use the "Paste from Word" ( <img src="https://condosites.net/commons/pastefromword.png" width="15"> ) button.</span><br>
    			<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Use the Styles pulldown to apply <b><span class="bluepen">c</span><span class="greenpen">o</span><span class="bluepen">l</span><span class="greenpen">o</span><span class="bluepen">r</span></b> and formatting <span class="marker">styles</span> to your text.</span>
                <textarea name="answer" cols="30" rows="2" id="editor1" class="form" type="text" placeholder="Trash day is Monday and recycling is picked up on Tuesday." required><?php echo "{$row['answer']}"; ?></textarea>
                <script>CKEDITOR.replace( 'editor1' );</script>
            </div>
        </div>
    </div>
<!-- END COLUMN 1 -->
<!-- COLUMN 2 -->
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>3) Supplemental Information</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="web" class="middle">Add a link to a website?<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Be sure your link starts with http://</span></label></div>
            <div class="small-12 medium-7 end columns"><input name="web" maxlength="100" class="form" type="url" placeholder="Be sure your link starts with http://" value="<?php echo "{$row['web']}"; ?>"></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="email" class="middle">Add an email address?</label></div>
            <div class="small-12 medium-7 end columns"><input name="email" maxlength="100" class="form" type="email" placeholder="trashy@dumpsterguys.com" value="<?php echo "{$row['email']}"; ?>"></div>
        </div>
<?php include('docid-field-edit.php'); ?>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>4) Which group does this apply to?</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 columns">
<select name="type" required>
<option value="Residents" <?php if($row['type'] == "Residents"){ echo("SELECTED"); } ?>>Residents</option>
<option value="Realtors" <?php if($row['type'] == "Realtors"){ echo("SELECTED"); } ?>>Realtors</option>
<option value="Pets" <?php if($row['type'] == "Pets"){ echo("SELECTED"); } ?>>Pets</option>
</select>
            </div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>5) Ready to Save?</strong></div>
        </div>
        <div class="row medium-collapse">
            <div class="small-6 columns" align="center">
                <input type="hidden" name="action" value="save">
	            <input type="hidden" name="int1" value="<?php echo $_POST['int1']; ?>">
	            <input name="submit" value="Save" class="submit" type="submit">
                <?php echo($error); ?>
</form>
            </div>
            <div class="small-6 end columns" align="center">
<form action="faq.php" method="get">
	            <input type="submit" value="Cancel" onclick="return confirm('Are you sure you wish to leave this page? Unsaved changes will be lost.');">
</form>
            </div>
        </div>
    </div>
<!-- COLUMN 2 -->
</div>
<?php
	}
?>
<!-- END INPUT FORM -->
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Frequently Asked Questions Edit Control Panel Page<br></div>
</body>
</html>
