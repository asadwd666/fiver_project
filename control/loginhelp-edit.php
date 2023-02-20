<?php $current_page = '35'; include('protect.php'); $id = $_POST["id"]; $action = $_POST["action"]; $module = $_POST['module'];

    if ($action == "save" && $_FILES['userfile']['size'] == '0'){

		$category = $_POST["category"];
		$utility = htmlspecialchars($_POST['utility'], ENT_QUOTES);
		$company = htmlspecialchars($_POST['company'], ENT_QUOTES);
		$contact = htmlspecialchars($_POST['contact'], ENT_QUOTES);
		$address1 = htmlspecialchars($_POST['address1'], ENT_QUOTES);
		$address2 = htmlspecialchars($_POST['address2'], ENT_QUOTES);
		$web = htmlspecialchars($_POST['web'], ENT_QUOTES);
		$email = htmlspecialchars($_POST['email'], ENT_QUOTES);
		$phone1 = htmlspecialchars($_POST['phone1'], ENT_QUOTES);
		$phone2 = htmlspecialchars($_POST['phone2'], ENT_QUOTES);
		$phone3 = htmlspecialchars($_POST['phone3'], ENT_QUOTES);
		$phone4 = htmlspecialchars($_POST['phone4'], ENT_QUOTES);
		$docid = $_POST["docid"];
		$comments = $_POST['comments'];
		$date = date("Y-m-d");

		$query = "UPDATE utilities SET category='$category', contact='$contact', utility='$utility', company='$company', address1='$address1', address2='$address2', web='$web', email='$email', phone1='$phone1', phone2='$phone2', phone3='$phone3', phone4='$phone4', docid='$docid', comments='$comments', date='$date' WHERE `id`='$id' LIMIT 1";
		mysqli_query($conn,$query) or die('Error, update query failed');

		$date = date("F j, Y");
		$query = "UPDATE updatedate SET date='$date'";
		mysqli_query($conn,$query) or die('Error, updating update date failed');

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('E', 'Utilities', '$useripaddress', '$userid', '$id')";
		mysqli_query($conn,$query) or die('Error, updating log failed');

		header('Location: '.$module);
	}
	
	if ($action == "save" && $_FILES['userfile']['size'] > '0'){

        $category = $_POST["category"];
		$utility = htmlspecialchars($_POST['utility'], ENT_QUOTES);
		$company = htmlspecialchars($_POST['company'], ENT_QUOTES);
		$contact = htmlspecialchars($_POST['contact'], ENT_QUOTES);
		$address1 = htmlspecialchars($_POST['address1'], ENT_QUOTES);
		$address2 = htmlspecialchars($_POST['address2'], ENT_QUOTES);
		$web = htmlspecialchars($_POST['web'], ENT_QUOTES);
		$email = htmlspecialchars($_POST['email'], ENT_QUOTES);
		$phone1 = htmlspecialchars($_POST['phone1'], ENT_QUOTES);
		$phone2 = htmlspecialchars($_POST['phone2'], ENT_QUOTES);
		$phone3 = htmlspecialchars($_POST['phone3'], ENT_QUOTES);
		$phone4 = htmlspecialchars($_POST['phone4'], ENT_QUOTES);
		$docid = $_POST["docid"];
		$comments = $_POST['comments'];
		$date = date("Y-m-d");
		
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

		if ($fileSize >= '1500000') {
			$success = "false";
			$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #FAFEB8; color: black;'><i class='fa fa-exclamation-triangle note' aria-hidden='true'></i> <strong>The photo you attached is too large! Max size 1 MB.</strong></div>";
		}

		else {

		$query = "UPDATE utilities SET category='$category', contact='$contact', utility='$utility', company='$company', address1='$address1', address2='$address2', web='$web', email='$email', phone1='$phone1', phone2='$phone2', phone3='$phone3', phone4='$phone4', docid='$docid', comments='$comments', date='$date', name='$fileName', type='$fileType', size='$fileSize', content='$content' WHERE `id`='$id' LIMIT 1";
		mysqli_query($conn,$query) or die('Error, update query failed');

		$date = date("F j, Y");
		$query = "UPDATE updatedate SET date='$date'";
		mysqli_query($conn,$query) or die('Error, updating update date failed');

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('E', 'Utilities', '$useripaddress', '$userid', '$id')";
		mysqli_query($conn,$query) or die('Error, updating log failed');

		header('Location: '.$module);
		}
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
<div style="max-width: 99%;">
<div class="nav-section-header-cp">
        <strong>Edit the Login Help Contact</strong>
</div>
<?php
	$query  = "SELECT * FROM utilities WHERE `id`='$id' LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- UPLOAD FORM -->
<?php echo($errorSUCCESS); ?>
<div class="cp-form-container">
<!-- COLUMN 1 -->
    <div class="small-12 medium-12 large-6 columns">
<form enctype="multipart/form-data" method="POST" action="loginhelp-edit.php">
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>1) Company Information</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="company" class="middle">Organization Name</label></div>
            <div class="small-12 medium-7 end columns">
                <input name="category" value="Password" type="hidden">
                <input name="utility" value="Password Help" type="hidden">
                <input name="company" maxlength="100" class="form" type="text" required placeholder="AT&amp;T" value="<?php echo "{$row['company']}"; ?>"></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="contact" class="middle">Contact</label></div>
            <div class="small-12 medium-7 end columns"><input name="contact" maxlength="100" class="form" type="text" placeholder="Ma Bell" value="<?php echo "{$row['contact']}"; ?>"></div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>2) Contact Information</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="phone1" class="middle">Phone 1</label></div>
            <div class="small-12 medium-7 end columns"><input name="phone1" maxlength="100" class="form" type="tel" placeholder="Usually the main phone number..." value="<?php echo "{$row['phone1']}"; ?>"></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="email" class="middle">Email</label></div>
            <div class="small-12 medium-7 end columns"><input name="email" maxlength="100" class="form" type="email" placeholder="mabell@att.com" value="<?php echo "{$row['email']}"; ?>"></div>
        </div>
    </div>
<!-- END COLUMN 1 -->
<!-- COLUMN 2 -->
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>3) Logo</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-3 end columns">
				<?php if ($row['name'] !== '' AND $row['name'] !== 'none.gif'){ ?>
				    <img align="left" src="../download-utilities.php?id=<?php echo "{$row['id']}"; ?>" alt="<?php echo "{$row['title']}"; ?>" style="max-height: 75px; max-width: 125px;" hspace="15" vspace="10">
                <?php }; ?>
			</div>
		    <div class="small-12 medium-9 end columns">
				<label for="file" class="middle">
				    Upload new logo (optional)<br>
				    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">1 MB Maximum</span><br>
                    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Logos should be sized as 200 px wide x 75 to 120 px tall.</span><br>
				</label>
				<input type="file" name="userfile" id="userfile">
			</div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>4) Ready to Save?</strong></div>
        </div>
        <div class="row medium-collapse">
            <div class="small-6 columns" align="center">
<input type="hidden" name="action" value="save">
<input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
<input type="hidden" name="module" value="<?php echo $_POST['module']; ?>">
<input name="submit" value="Save" class="submit" type="submit">
            </div>
</form>
            <div class="small-6 end columns" align="center">
<form action="<?php echo $_POST['module']; ?>" method="get">
<input type="submit" value="Cancel and Go Back" onclick="return confirm('Are you sure you wish to leave this page? Unsaved changes will be lost.');">
</form>
            </div>
        </div>
    </div>
<!-- COLUMN 2 -->
</div>
<!-- END UPLOAD FORM -->
<?php
	}
?>
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Login Help Contact Edit Control Panel Page<br></div>
</body>
</html>
