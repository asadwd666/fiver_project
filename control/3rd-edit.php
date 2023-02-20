<?php $current_page = '1'; include('protect.php'); $int1 = $_POST["int1"]; $module = $_POST['module']; $action = $_POST["action"]; if ($action == "save"){

		$theircode = $_POST["theircode"];
		$extra1 = $_POST["extra1"];
		$iframe = $_POST["iframe"];

		$query = "UPDATE 3rd SET theircode='$theircode', extra1='$extra1', iframe='$iframe' WHERE `int1`='$int1' LIMIT 1";
		mysqli_query($conn,$query) or die('Error, update query failed');

		$date = date("F j, Y");
		$query = "UPDATE updatedate SET date='$date'";
		mysqli_query($conn,$query) or die('Error, updating update date failed');

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['int1'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('E', '3rd', '$useripaddress', '$userid', '$id')";
		mysqli_query($conn,$query) or die('Error, updating log failed');

		header('Location: '.$module);
	}

	if ($action == "cancel"){

		header('Location: '.$module);
	}

?>
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">
<head>
<meta charset="UTF-8">
<meta content="CondoSites - http://www.condosites.com" name="author">
<title>Control Panel</title>
<?php include('../control/cp-head-scripts.php'); ?>
</head>
<body>
<!-- LOGO AND NAVIGATION -->
<?php include('cp-navigation.php'); ?>
<!-- END LOGO AND NAVIGATION -->
<br>
<!-- INPUT FORM -->
<div class="nav-section-header-cp">
        <strong>Edit 3rd Party Code and Custom Content</strong>
</div>
<?php
	$query  = "SELECT * FROM 3rd WHERE `int1`='$int1' LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<div class="cp-form-container">
<!-- COLUMN 1 -->
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 10px 0px;">
<form enctype="multipart/form-data" method="POST" action="3rd-edit.php">
            <div class="small-12 columns"><strong>1) What text &amp; code do you want to show?</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 end columns" style="padding-bottom: 10px;">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">If pasting content from Microsoft Word, use the "Paste from Word" ( <img src="https://condosites.net/commons/pastefromword.png" width="15"> ) button.</span><br>
    			<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Use the Styles pulldown to apply <b><span class="bluepen">c</span><span class="greenpen">o</span><span class="bluepen">l</span><span class="greenpen">o</span><span class="bluepen">r</span></b> and formatting <span class="marker">styles</span> to your text.</span>
                <textarea name="theircode" cols="30" rows="2" id="editor1" class="form" type="text" required autofocus><?php echo "{$row['theircode']}"; ?></textarea>
                <script>CKEDITOR.replace( 'editor1' );</script>
            </div>
        </div>
    </div>
<!-- END COLUMN 1 -->
<!-- COLUMN 2 -->
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>2) Additional Text</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 end columns" style="padding-bottom: 10px;">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red"><?php if ($row['extra1'] == ''){ ?>This field is not used for this entry.<?php }; ?> <?php if ($row['extra1'] != ''){ ?>This field is not used for this entry.<?php }; ?></span>
                <textarea name="extra1" cols="30" rows="2" class="form" type="text" <?php if ($row['extra1'] == ''){ ?>disabled<?php }; ?>><?php echo "{$row['extra1']}"; ?></textarea>
            </div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium12 columns"><strong>3) iFrame Code</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium12 end columns" style="padding-bottom: 10px;">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red"><?php if ($row['iframe'] == ''){ ?>This field is not used for this entry.<?php }; ?> <?php if ($row['iframe'] != ''){ ?>This field is not used for this entry.<?php }; ?></span>
                <textarea name="iframe" cols="30" rows="2" class="form" type="text" <?php if ($row['iframe'] == ''){ ?>disabled<?php }; ?>><?php echo "{$row['iframe']}"; ?></textarea>
            </div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium12 columns"><strong>4) Ready to Save?</strong></div>
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
<form name="3rdCancel" method="POST">
                <input type="hidden" name="action" value="cancel">
                <input type="hidden" name="module" value="<?php echo $_POST['module']; ?>">
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
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Custom Content Edit Control Panel Page<br></div>
</body>
</html>
