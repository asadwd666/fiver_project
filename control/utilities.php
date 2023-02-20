<?php $current_page = '16'; include('protect.php'); ?>
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
<?php $action = $_POST["action"]; if ($action != null){ ?>
<?php
	if ($action == "delete"){
		$id = $_POST["id"];
		$query = "DELETE FROM utilities WHERE `id`='$id'";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

            $errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Your entry was deleted successfully.</strong></div>";

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('D', 'Utilities', '$useripaddress', '$userid', '$id')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

		$query = "OPTIMIZE TABLE `utilities`";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

	}
	if ($action == "upload" && $_FILES['userfile']['size'] > 0){

		$date = date('Y-m-d');
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
		$comments = $_POST["comments"];

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

		if ($fileSize = '0') {
			$success = "false";
			$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #FAFEB8; color: black;'><i class='fa fa-exclamation-triangle note' aria-hidden='true'></i> <strong>You did not attach a logo.</strong></div>";
		}

		else {
		$query  = "INSERT INTO utilities (date, category, utility, company, contact, address1, address2, web, email, phone1, phone2, phone3, phone4, name, size, type, content, docid, comments) VALUES ('$date', '$category', '$utility', '$company', '$contact', '$address1', '$address2', '$web', '$email', '$phone1', '$phone2', '$phone3', '$phone4', '$fileName', '$fileSize', '$fileType', '$content', '$docid', '$comments')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

			$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Your entry was added successfully.</strong></div>";

		}

	}
	
	if ($action == "upload" && $_FILES['userfile']['size'] == 0){

		$date = date('Y-m-d');
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
		$comments = $_POST["comments"];

		$query  = "INSERT INTO utilities (date, category, utility, company, contact, address1, address2, web, email, phone1, phone2, phone3, phone4, name, size, type, content, docid, comments) VALUES ('$date', '$category', '$utility', '$company', '$contact', '$address1', '$address2', '$web', '$email', '$phone1', '$phone2', '$phone3', '$phone4', '$fileName', '$fileSize', '$fileType', '$content', '$docid', '$comments')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

		$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Your entry was added successfully.</strong></div>";

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
<?php $sqlUTL = mysqli_query($conn,"SELECT count(*) FROM utilities WHERE date > NOW() - INTERVAL 365 DAY") or die(mysqli_error($conn));
//$countUTL = mysql_result($sqlUTL, "0");
$row = mysqli_fetch_row($sqlUTL);
$countUTL = $row[0];
?>
<?php if ($countUTL == '0'){ ?><i class="fa fa-exclamation-triangle note" aria-hidden="true"></i> Have your utilities or local links info changed?<?php }; ?>
<?php if ($countUTL != '0'){ ?><i class="fa fa-check note" aria-hidden="true"></i> Things are looking good!<?php }; ?>
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
<div style="max-width: 99%;">

<div class="row cp-help">
    <div class="small-12 medium-6 columns">
        <p><b>Utilities and Local Links</b> tell your community about utility providers and local resources.  This is helpful to new residents and in times of utility outages.
        There is room to add information about their business hours, further descriptions on what the business does, and more.</p>
        <p>
            <i class="fa fa-hand-o-right" aria-hidden="true"></i>  <span class="note-red"><b>Property Management</b> entries have moved to the Property Manager Contact control panel.</span><br>
            <i class="fa fa-hand-o-right" aria-hidden="true"></i>  <span class="note-red">The <b>Login Help</b> entry has moved to the User Accounts control panel.<br></span>
        </p>
    </div>
    <div class="small-12 medium-6 columns">
                <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#add"><b>Add a Utility or Local Link</b></a> using the addition form below.</p>
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#edit"><b>View and Edit</b></a> existing entries in your database.</p>
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#modulepermissions"><b>Module Permissions</b></a> allow you to choose what content should be seen by which groups of users.</p>
    </div>
</div>

<!-- UPLOAD FORM -->
<a name="add"></a>
<div class="nav-section-header-cp">
        <strong>Add a Utility or Local Link</strong>
</div>
<?php echo($errorSUCCESS); ?>
<form enctype="multipart/form-data" method="POST" action="utilities.php">
<div class="cp-form-container">
<!-- COLUMN 1 -->
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>1) Category Information</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="category" class="middle">Category</label></div>
            <div class="small-12 medium-7 end columns">
                <select name="category" required autofocus>
                    <option value="">Select a Category</option>
                    <option value="Utility">Utility</option>
                    <option value="Local Links">Local Link</option>
                </select>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="utility" class="middle">Label</label></div>
            <div class="small-12 medium-7 end columns"><input name="utility" size="30" maxlength="100" class="form" placeholder="Phone Company" type="text" required></div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>2) Company Information</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="company" class="middle">Organization Name</label></div>
            <div class="small-12 medium-7 end columns"><input name="company" maxlength="100" class="form" type="text" required placeholder="AT&amp;T"></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="contact" class="middle">Contact</label></div>
            <div class="small-12 medium-7 end columns"><input name="contact" maxlength="100" class="form" type="text" placeholder="Ma Bell"></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="address1" class="middle">Address</label></div>
            <div class="small-12 medium-7 end columns"><input name="address1" maxlength="100" class="form" type="text" placeholder="123 Any St"></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="address2" class="middle">City, ST Zip</label></div>
            <div class="small-12 medium-7 end columns"><input name="address2" maxlength="100" class="form" type="text" placeholder="Seattle, WA 928101"></div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>3) Contact Information</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="phone1" class="middle">Phone 1</label></div>
            <div class="small-12 medium-7 end columns"><input name="phone1" maxlength="100" class="form" type="tel" placeholder="Usually the main phone number..."></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="phone2" class="middle">Phone 2</label></div>
            <div class="small-12 medium-7 end columns"><input name="phone2" maxlength="100" class="form" type="tel" placeholder="Perhaps a cell phone?"></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="phone3" class="middle">Phone 3</label></div>
            <div class="small-12 medium-7 end columns"><input name="phone3" maxlength="100" class="form" type="tel" placeholder="An emergency number, just in case..."></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="phone4" class="middle">Phone 4</label></div>
            <div class="small-12 medium-7 end columns"><input name="phone4" maxlength="100" class="form" type="tel" placeholder="Does anyone still use a FAX?"></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="web" class="middle">Website URL<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Be sure your link starts with http://</span></label></div>
            <div class="small-12 medium-7 end columns"><input name="web" maxlength="100" class="form" type="url" placeholder="Be sure your link starts with http://"></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="email" class="middle">Email</label></div>
            <div class="small-12 medium-7 end columns"><input name="email" maxlength="100" class="form" type="email" placeholder="mabell@att.com"></div>
        </div>
    </div>
<!-- END COLUMN 1 -->
<!-- COLUMN 2 -->
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>4) Logo</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 end columns">
                <label for="file" class="middle">
                    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">1 MB Maximum</span><br>
                    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Logos should be sized as 200 px wide x 75 to 120 px tall.</span><br>
                </label>
                <input type="file" name="userfile" id="userfile">
            </div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>5) Comments and Supplemental Content</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 end columns" style="padding-bottom: 10px;">
                <label for="file" class="middle">Comments &nbsp;&nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Comments are visible to users.</span><br>
                    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">If pasting content from Microsoft Word, use the "Paste from Word" ( <img src="https://condosites.net/commons/pastefromword.png" width="15"> ) button.</span><br>
    			    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Use the Styles pulldown to apply <b><span class="bluepen">c</span><span class="greenpen">o</span><span class="bluepen">l</span><span class="greenpen">o</span><span class="bluepen">r</span></b> and formatting <span class="marker">styles</span> to your text.</span>
    			</label>
                <textarea name="comments" cols="30" rows="2" id="editor1" class="form" type="text" placeholder="Comments"></textarea>
                <script>CKEDITOR.replace( 'editor1' );</script>
            </div>
        </div>
<?php include('docid-field.php'); ?>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-6 columns"><strong>6) Ready to Save?</strong></div>
            <div class="small-12 medium-6 columns">
	            <input name="action" value="upload" type="hidden">
	            <input type="submit" name="submit" value="Submit">
            </div>
        </div>
        <div class="row medium-collapse">
            <div class="small-12 medium-12 columns" align="center">
<br><i class="fa fa-hand-o-down" aria-hidden="true"></i> Scroll down to see the utilities and local organizations already added.
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
        <strong>Utilities &amp; Local Links</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr align="left">
        <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Listing</small></th>
        <th align="center"><small>Logo</small></th>
        <th class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <small>Utility</small></th>
    </tr>
  </thead>
  <tbody style="background-color:#ffffff">
<!-- DATABASE RESULTS -->
<?php
	$query  = "SELECT * FROM utilities WHERE `category` != 'Manager' AND `category` != 'Password' ORDER BY company";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
    <tr>
      <td>
        <div class="small-12 medium-12 large-8 columns">
<?php if ($row['company'] !== ''){ ?><b><?php echo "{$row['company']}"; ?></b><br><?php }; ?>
<?php if ($row['contact'] !== ''){ ?><?php echo "{$row['contact']}"; ?><br><?php }; ?>
<?php if ($row['utility'] !== ''){ ?><span class="note-red"><?php echo "{$row['utility']}"; ?></span><br><br><?php }; ?>
<?php if ($row['docid'] !== ''){ ?>
<?php
	$type    = $row['docid'];
	$queryDOC  = "SELECT `id`, type, title, aod, docdate, doctype, size FROM documents WHERE `id` = '$type'";
	$resultDOC = mysqli_query($conn,$queryDOC);

	while($rowDOC = $resultDOC->fetch_array(MYSQLI_ASSOC))
	{
?>
	Link to Document <?php echo "{$rowDOC['title']}"; ?><br>
<?php
	}
?>
<?php }; ?>
<?php if ($row['phone1'] !== ''){ ?><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row['phone1']); ?>"><?php echo "{$row['phone1']}"; ?></a><br><?php }; ?>
<?php if ($row['phone2'] !== ''){ ?><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row['phone2']); ?>"><?php echo "{$row['phone2']}"; ?></a><br><?php }; ?>
<?php if ($row['phone3'] !== ''){ ?><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row['phone3']); ?>"><?php echo "{$row['phone3']}"; ?></a><br><?php }; ?>
<?php if ($row['phone4'] !== ''){ ?><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row['phone4']); ?>"><?php echo "{$row['phone4']}"; ?></a><br><br><?php }; ?>
<?php if ($row['web'] !== ''){ ?><a href="<?php echo "{$row['web']}"; ?>" target="_blank"><?php echo "{$row['web']}"; ?></a><br><?php }; ?>
<?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>"><?php echo "{$row['email']}"; ?></a><br><br><?php }; ?>
<?php if ($row['address1'] !== ''){ ?><?php echo "{$row['address1']}"; ?><br><?php }; ?>
<?php if ($row['address2'] !== ''){ ?><?php echo "{$row['address2']}"; ?><br><?php }; ?>
<?php if ($row['comments'] !== ''){ ?><?php echo "{$row['comments']}"; ?><br><?php }; ?>
        </div>
        <div class="small-6 medium-6 large-2 columns">
	        <form name="UtilitiesEdit" method="POST" action="utilities-edit.php">
	            <input type="hidden" name="action" value="edit">
	            <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
	            <input name="submit" value="Edit" class="submit" type="submit">
	        </form>
        </div>
        <div class="small-6 medium-6 large-2 columns">
        	<form method="POST" action="utilities.php" onclick="return confirm('Are you sure you want to delete <?php echo "{$row['company']}"; ?>?');">
            	<input type="hidden" name="action" value="delete">
            	<input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
	            <input name="submit" value="Delete" class="submit" type="submit">
	        </form>
        </div>
      </td>
      <td align="center" style="background-color:#ffffff"><?php if ($row['name'] !== ''){ ?><?php if ($row['name'] !== 'none'){ ?><img src="../download-utilities.php?id=<?php echo "{$row['id']}"; ?>" alt="<?php echo "{$row['company']}"; ?>"><?php }; ?><?php }; ?></td>
      <td align="center"><?php echo "{$row['category']}"; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
  </tbody>
</table>
</div>

<div style="max-width: 99%;">
<!-- MODULE PERMISSIONS -->
<a name="modulepermissions"></a>
<br>
<div class="nav-section-header-cp">
    <strong>Module Permissions</strong>
</div>
<br>
<div class="cp-help">
    <div class="small-12 medium-6 columns">
        <p><b>Module Permissions allow you to choose what content should be seen by which groups of users.</b></p>
    </div>
    <div class="small-12 medium-6 columns">
        <p>
            <i class="fa fa-hand-o-right" aria-hidden="true"></i> You may choose to use a combination of modules with different permissions.
        </p>
    </div>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
    <thead>
        <tr align="left" valign="middle">
            <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Module</small></th>
            <th width="50" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>ID</small></th>
            <th class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <small>Tab</small></th>
			<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Owner</small></b></div></th>
            <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Renter</small></b></div></th>
            <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Realtor</small></b></div></th>
            <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Home</small></b></div></th>
        </tr>
    </thead>
    <tbody style="background-color:#ffffff">
<!-- TABS PERMISSION EDITS -->
<?php
	$module = "utilities.php";
	$query  = "SELECT * FROM tabs WHERE liaison = 'Y' AND `int1` BETWEEN '310' AND '310' ORDER BY `int1`";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php include('tabs-modulelist.php'); ?>
<?php
	}
?>
<!-- END TABS PERMISSION EDITS -->
        <tr>
            <td>
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">The module <b>above</b> contains all the entries in this module.</span><br>
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">The modules <b>below</b> contain just that subset entries.</span><br>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
<!-- TABS PERMISSION EDITS -->
<?php
	$module = "utilities.php";
	$query  = "SELECT * FROM tabs WHERE liaison = 'Y' AND `int1` BETWEEN '311' AND '312' ORDER BY `int1`";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php include('tabs-modulelist.php'); ?>
<?php
	}
?>
<!-- END TABS PERMISSION EDITS -->
    </tbody>
</table>
<br>

<div class="small-12 medium-12 large-12 columns note-black"><br><br>Utilities and Local Links Control Panel Page<br></div>
</body>
</html>
