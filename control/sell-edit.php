<?php $current_page = '15'; include('protect.php'); $int1 = $_POST["int1"]; $action = $_POST["action"];

    if ($action == "save" && $_FILES['userfile']['size'] == '0'){

		$headline = htmlspecialchars($_POST['headline'], ENT_QUOTES);
		$description = $_POST["description"];
		$url = htmlspecialchars($_POST['url'], ENT_QUOTES);
		$email = htmlspecialchars($_POST['email'], ENT_QUOTES);
		$contact = htmlspecialchars($_POST['contact'], ENT_QUOTES);
		$phone = htmlspecialchars($_POST['phone'], ENT_QUOTES);
		$forsalerent = $_POST['forsalerent'];
		$price = htmlspecialchars($_POST['price'], ENT_QUOTES);
		$docid = $_POST['docid'];
		$eod = $_POST['eod'];
		$approved = $_POST['approved'];
		$userid = $_POST['userid'];

		$query = "UPDATE realestate SET headline='$headline', description='$description', url='$url', email='$email', contact='$contact', phone='$phone', forsalerent='$forsalerent', price='$price', docid='$docid', eod='$eod', approved='$approved', userid='$userid' WHERE `int1`='$int1' LIMIT 1";
		mysqli_query($conn,$query) or die('Error, update query failed');

		$date = date("F j, Y");
		$query = "UPDATE updatedate SET date='$date'";
		mysqli_query($conn,$query) or die('Error, updating update date failed');

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['int1'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('E', 'Sell', '$useripaddress', '$userid', '$id')";
		mysqli_query($conn,$query) or die('Error, updating log failed');

		header('Location: sell.php');
	}
	
	if ($action == "save" && $_FILES['userfile']['size'] > '0'){

		$headline = htmlspecialchars($_POST['headline'], ENT_QUOTES);
		$description = $_POST["description"];
		$url = htmlspecialchars($_POST['url'], ENT_QUOTES);
		$email = htmlspecialchars($_POST['email'], ENT_QUOTES);
		$contact = htmlspecialchars($_POST['contact'], ENT_QUOTES);
		$phone = htmlspecialchars($_POST['phone'], ENT_QUOTES);
		$forsalerent = $_POST['forsalerent'];
		$price = htmlspecialchars($_POST['price'], ENT_QUOTES);
		$docid = $_POST['docid'];
		$eod = $_POST['eod'];
		$approved = $_POST['approved'];
		$userid = $_POST['userid'];
		
		$fileName = $_FILES['userfile']['name'];
		$tmpName  = $_FILES['userfile']['tmp_name'];
		$fileSize = $_FILES['userfile']['size'];
		$fileType = $_FILES['userfile']['type'];
		
		$fp      = fopen($tmpName, 'r');
		$content = fread($fp, filesize($tmpName));
		$content = addslashes($content);
		fclose($fp);

		if (!get_magic_quotes_gpc())
		{
			$fileName = addslashes($fileName);
		}
		
		if ($fileSize >= '1500000') {
			$success = "false";
			$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #FAFEB8; color: black;'><i class='fa fa-exclamation-triangle note' aria-hidden='true'></i> <strong>The photo you attached is too large! Max size 1 MB.</strong></div>";
		}

        else {

		$query = "UPDATE realestate SET headline='$headline', description='$description', url='$url', email='$email', contact='$contact', phone='$phone', forsalerent='$forsalerent', price='$price', docid='$docid', eod='$eod', approved='$approved', userid='$userid', name='$fileName', type='$fileType', size='$fileSize', content='$content' WHERE `int1`='$int1' LIMIT 1";
		mysqli_query($conn,$query) or die('Error, update query failed');

		$date = date("F j, Y");
		$query = "UPDATE updatedate SET date='$date'";
		mysqli_query($conn,$query) or die('Error, updating update date failed');

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['int1'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('E', 'Sell', '$useripaddress', '$userid', '$id')";
		mysqli_query($conn,$query) or die('Error, updating log failed');

		header('Location: sell.php');
        }
	}

?>
<!DOCTYPE html>
<html>
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
				<strong>Edit a Listing</strong>
</div>
	<!-- UPLOAD FORM -->
<?php
        $query  = "SELECT * FROM realestate WHERE `int1`='$int1' LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
	<div class="cp-form-container">
	    <div class="small-12 medium-12 large-6 columns">
	        <div class="row" style="padding: 10px 10px 0px 0px;">
<form enctype="multipart/form-data" method="POST" action="sell-edit.php">
	            <div class="small-12 medium-12 columns"><strong>1) Listing Information</strong></div>
	        </div>
	        <div class="row medium-collapse" style="padding-left: 30px;">
	            <div class="small-12 medium-5 columns"><label for="headline" class="middle">Listing Headline</label></div>
	            <div class="small-12 medium-7 end columns"><input name="headline" placeholder="Schwin Bicycle" maxlength="100" class="form" type="text" value="<?php echo "{$row['headline']}"; ?>" autofocus></div>
	        </div>
	        <div class="row medium-collapse" style="padding-left: 30px;">
	            <div class="small-12 medium-5 columns"><label for="price" class="middle">Price</label></div>
	            <div class="small-12 medium-7 end columns"><input name="price" placeholder="$100" maxlength="100" class="form" type="text" value="<?php echo "{$row['price']}"; ?>"></div>
	        </div>
	        <div class="row medium-collapse" style="padding-left: 30px; padding-bottom: 20px;">
	            <div class="small-12 medium-12 columns"><label for="description" class="middle">Description&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Description IS visible to the user.</span> <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Use of HTML is acceptable.</span></label>
				    <textarea name="description" cols="30" rows="2" id="editor1" class="form" type="text" required><?php echo "{$row['description']}"; ?></textarea>
	                <script>CKEDITOR.replace( 'editor1' );</script>
	            </div>
	        </div>
	        <div class="row medium-collapse" style="padding-left: 30px;">
	            <div class="small-12 medium-5 columns"><label for="contact" class="middle">Listing Contact</label></div>
	            <div class="small-12 medium-7 end columns"><input name="contact" placeholder="John Doe" maxlength="100" class="form" type="text" value="<?php echo "{$row['contact']}"; ?>"></div>
	        </div>
	        <div class="row medium-collapse" style="padding-left: 30px;">
	            <div class="small-12 medium-5 columns"><label for="phone" class="middle">Contact Phone</label></div>
	            <div class="small-12 medium-7 end columns"><input name="phone" placeholder="206-555-1212" maxlength="100" class="form" type="tel" value="<?php echo "{$row['phone']}"; ?>"></div>
	        </div>
	        <div class="row medium-collapse" style="padding-left: 30px;">
	            <div class="small-12 medium-5 columns"><label for="email" class="middle">Contact Email</label></div>
	            <div class="small-12 medium-7 end columns"><input name="email" placeholder="email@email.com" maxlength="100" class="form" type="email" value="<?php echo "{$row['email']}"; ?>"></div>
	        </div>
	        <div class="row medium-collapse" style="padding-left: 30px;">
	            <div class="small-12 medium-5 columns"><label for="url" class="middle">Link to External Website</label></div>
	            <div class="small-12 medium-7 end columns"><input name="url" placeholder="http://www.craigslist.org" maxlength="100" class="form" type="url" value="<?php echo "{$row['url']}"; ?>"></div>
	        </div>
	<?php include('docid-field-edit.php'); ?>
	    </div>
	    <div class="small-12 medium-12 large-6 columns">
		    <div class="row" style="padding: 10px 10px 10px 0px;">
			    <div class="small-12 medium-12 columns"><strong>2) Photo (Optional)</strong></div>
		    </div>
		    <div class="row medium-collapse" style="padding-left: 30px;">
			    <div class="row medium-collapse" style="padding-left: 30px;">
				    <div class="small-12 medium-3 end columns">
					    <img src="../download-sell.php?int1=<?php echo"{$row['int1']}"; ?>" alt="<?php echo "{$row['title']}"; ?>" style="max-height: 75px; max-width: 125px;" hspace="15" vspace="10">
					</div>
					<div class="small-12 medium-9 end columns">
					    <label for="file" class="middle">
					        Upload new photo (optional)<br>
					    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">1 MB Maximum</span><br>
					    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Only JPEG/GIF/PNG formats</span><br>
					    </label>
					    <input type="file" name="userfile" id="userfile">
				    </div>
				</div>
		</div>
	        <div class="row" style="padding: 10px 10px 0px 0px;">
	            <div class="small-12 medium-12 columns"><strong>3) Who should this be registered to?</strong></div>
	        </div>
	        <div class="row medium-collapse" style="padding: 10px 10px 10px 30px;">
	            <div class="small-12 medium-12 columns">
	                <?php include('userid-field-edit.php'); ?><br>&nbsp;&nbsp;&nbsp;&nbsp;<i>Other</i> <input name="owner" maxlength="100" class="form" type="text" >
	            </div>
	        </div>
	        <div class="row" style="padding: 10px 10px 10px 0px;">
	            <div class="small-12 medium-12 columns"><strong>4) Approval</strong></div>
	        </div>

	        <div class="row medium-collapse" style="padding-left: 30px;">
	            <div class="small-12 medium-6 columns"><label for="eod" class="middle">What is the last day it should be seen?<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">We entered 60-days into the future.</span></label></div>
	            <div class="small-12 medium-6 end columns"><input name="eod" class="form datepicker" type="date" value="<?php if ($row['eod'] !== '0000-00-00'){ ?><?php echo "{$row['eod']}"; ?><?php }; ?><?php if ($row['eod'] == '0000-00-00'){ ?><?php echo date("Y-m-d", strtotime($date ."+60 days" )); ?><?php }; ?>" required></div>
	        </div>
	        <div class="row medium-collapse" style="padding-left: 30px;">
	            <div class="small-12 medium-5 columns"><label for="forsalerent" class="middle">Listing Type</label></div>
	            <div class="small-12 medium-7 end columns">
<select name="forsalerent">
<option value="SOCIAL" <?php if($row['forsalerent'] == "SOCIAL"){ echo("SELECTED"); } ?>>Private Social Event</option>
<option value="CLASSIFIED" <?php if($row['forsalerent'] == "CLASSIFIED"){ echo("SELECTED"); } ?>>Classified Ad</option>
<option value="SALE" <?php if($row['forsalerent'] == "SALE"){ echo("SELECTED"); } ?>>Unit For Sale</option>
<option value="RENT" <?php if($row['forsalerent'] == "RENT"){ echo("SELECTED"); } ?>>Unit For Rent</option>
</select>
	            </div>
	        </div>
	        <div class="row medium-collapse" style="padding-left: 30px; <?php if ($row['approved'] == 'N'){ ?>background-color: #ffcccc; padding-top: 10px; margin-right: -10px; padding-right: 10px; <?php }; ?>">
	            <div class="small-12 medium-5 columns"><label for="approved" class="middle">Approve this listing?</label></div>
	            <div class="small-12 medium-7 end columns">
	<select name="approved">
	<option value="Y" <?php if($row['approved'] == "Y"){ echo("SELECTED"); } ?>>Yes</option>
	<option value="N" <?php if($row['approved'] == "N"){ echo("SELECTED"); } ?>>No</option>
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
	            </div>
</form>
	            <div class="small-6 end columns" align="center">
<form action="sell.php" method="get">
	                <input type="submit" value="Cancel and Go Back" onclick="return confirm('Are you sure you wish to leave this page? Unsaved changes will be lost.');">
</form>
	            </div>
	        </div>
	    </div>
	</div>
<?php
	}
?>
<!-- END UPLOAD FORM -->
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Classifieds Edit Control Panel Page<br></div>
</body>
</html>
