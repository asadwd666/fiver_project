<?php $current_page = '15'; include('protect.php'); ?>
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
<?php $int1 = $_POST["int1"]; $action = $_POST["action"]; if ($action != null){ ?>
<?php
	if ($action == "delete"){
		$query = "DELETE FROM realestate WHERE `int1`='$int1'";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
		
			$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Your entry was deleted successfully.</strong></div>";

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['int1'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('D', 'Sell', '$useripaddress', '$userid', '$id')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

		$query = "OPTIMIZE TABLE `realestate`";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

	}

	if ($action == "add" && $_FILES['userfile']['size'] > '0'){

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$headline = htmlspecialchars($_POST['headline'], ENT_QUOTES);
		$description = $_POST["description"];
		$url = htmlspecialchars($_POST['url'], ENT_QUOTES);
		$email = htmlspecialchars($_POST['email'], ENT_QUOTES);
		$contact = htmlspecialchars($_POST['contact'], ENT_QUOTES);
		$phone = htmlspecialchars($_POST['phone'], ENT_QUOTES);
		$forsalerent = $_POST["forsalerent"];
		$price = htmlspecialchars($_POST['price'], ENT_QUOTES);
		$docid = $_POST["docid"];
		$eod = $_POST["eod"];
		$approved = $_POST["approved"];
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
            $errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #FAFEB8; color: black;'><i class='fa fa-exclamation-triangle note' aria-hidden='true'></i> <strong>Your entry did not upload! The photo you attached is too large! Max size 1 MB.</strong></div>";
		}

		else {

		$query = "INSERT INTO realestate (userid, useripaddress, headline, description, url, email, contact, phone, forsalerent, price, docid, eod, approved, name, size, type, content) VALUES ('$userid', '$useripaddress', '$headline', '$description', '$url', '$email', '$contact', '$phone', '$forsalerent', '$price', '$docid', '$eod', '$approved', '$fileName', '$fileSize', '$fileType', '$content')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

			$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Your entry was added successfully.</strong></div>";
		}
		
	}

	if ($action == "add" && $_FILES['userfile']['size'] == '0'){

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$headline = htmlspecialchars($_POST['headline'], ENT_QUOTES);
		$description = $_POST["description"];
		$url = htmlspecialchars($_POST['url'], ENT_QUOTES);
		$email = htmlspecialchars($_POST['email'], ENT_QUOTES);
		$contact = htmlspecialchars($_POST['contact'], ENT_QUOTES);
		$phone = htmlspecialchars($_POST['phone'], ENT_QUOTES);
		$forsalerent = $_POST["forsalerent"];
		$price = htmlspecialchars($_POST['price'], ENT_QUOTES);
		$docid = $_POST["docid"];
		$eod = $_POST["eod"];
		$approved = $_POST["approved"];

		$query = "INSERT INTO realestate (userid, useripaddress, headline, description, url, email, contact, phone, forsalerent, price, docid, eod, approved) VALUES ('$userid', '$useripaddress', '$headline', '$description', '$url', '$email', '$contact', '$phone', '$forsalerent', '$price', '$docid', '$eod', '$approved')";
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
<?php $sqlSELL = mysqli_query($conn,"SELECT count(*) FROM realestate WHERE approved != 'Y'") or die(mysqli_error($conn));
//$countSELL = mysql_result($sqlSELL, "0");
$row = mysqli_fetch_row($sqlSELL);
$countSELL = $row[0];
?>
<?php if ($countSELL != '0'){ ?><i class="fa fa-exclamation-triangle note" aria-hidden="true"></i> You have <?php print($countSELL); ?> Classified Ads pending your approval!<?php }; ?>
<?php if ($countSELL == '0'){ ?><i class="fa fa-check" aria-hidden="true"></i> Things are looking good!<?php }; ?>
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
        <p><b>Classifieds</b> is a control panel that allows you and your users to advertise everything from units for sale/rent, items for sale, and even private social functions, like a group of residents looking for a fourth for bridge.
        There is plenty of room to add information, links, and more.
    </div>
    <div class="small-12 medium-6 columns">
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#add"><b>Add a Classified Ad</b></a> using the addition form below.</p>
        <?php if ($countSELL != '0'){ ?><p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#pending"><b>Approve a pending classified ad</b></a> added by a user.</p><?php }; ?>
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#edit"><b>View and Edit</b></a> existing entries in your database.</p>
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#modulepermissions"><b>Module Permissions</b></a> allow you to choose what content should be seen by which groups of users.</p>
    </div>
</div>

<div style="max-width: 99%;">
<!-- UPLOAD FORM -->
<a name="add"></a>
<div class="nav-section-header-cp">
        <strong>Add a Listing</strong>
</div>
<?php echo($errorSUCCESS); ?>
<form enctype="multipart/form-data" method="POST" action="sell.php">
<div class="cp-form-container">
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 0px 0px;">
            <div class="small-12 medium-12 columns"><strong>1) Listing Information</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="headline" class="middle">Listing Headline</label></div>
            <div class="small-12 medium-7 end columns"><input name="headline" placeholder="Schwin Bicycle" maxlength="100" class="form" type="text" autofocus></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="price" class="middle">Price</label></div>
            <div class="small-12 medium-7 end columns"><input name="price" placeholder="$100" maxlength="100" class="form" type="text"></div>
        </div>
		<div class="row medium-collapse" style="padding-left: 30px; padding-bottom: 20px;">
			<div class="small-12 medium-12 columns"><label for="description" class="middle">Description&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Description IS visible to the user.</span> <br>
			        <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">If pasting content from Microsoft Word, use the "Paste from Word" ( <img src="https://condosites.net/commons/pastefromword.png" width="15"> ) button.</span><br>
			        <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Use the Styles pulldown to apply <b><span class="bluepen">c</span><span class="greenpen">o</span><span class="bluepen">l</span><span class="greenpen">o</span><span class="bluepen">r</span></b> and formatting <span class="marker">styles</span> to your text.</span>
			    </label>
				<textarea name="description" cols="30" rows="2" id="editor1" class="form" type="text" placeholder="Description" required></textarea>
				<script>CKEDITOR.replace( 'editor1' );</script>
			</div>
		</div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="contact" class="middle">Listing Contact</label></div>
            <div class="small-12 medium-7 end columns"><input name="contact" placeholder="John Doe" maxlength="100" class="form" type="text"></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="phone" class="middle">Contact Phone</label></div>
            <div class="small-12 medium-7 end columns"><input name="phone" placeholder="206-555-1212" maxlength="100" class="form" type="tel"></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="email" class="middle">Contact Email</label></div>
            <div class="small-12 medium-7 end columns"><input name="email" placeholder="email@email.com" maxlength="100" class="form" type="email"></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="url" class="middle">Link to External Website</label></div>
            <div class="small-12 medium-7 end columns"><input name="url" placeholder="http://www.craigslist.org" maxlength="100" class="form" type="url"></div>
        </div>
<?php include('docid-field-edit.php'); ?>
    </div>
    <div class="small-12 medium-12 large-6 columns">
		<div class="row" style="padding: 10px 10px 10px 0px;">
			<div class="small-12 medium-12 columns"><strong>2) Photo (optional)</strong></div>
		</div>
		<div class="row medium-collapse" style="padding-left: 30px;">
			<div class="small-12 medium-12 end columns">
				<label for="file" class="middle">
				    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">1 MB Maximum</span><br>
				    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Only JPEG/GIF/PNG formats</span><br>
				</label>
				<input type="file" name="userfile" id="userfile">
			</div>
		</div>
        <div class="row" style="padding: 10px 10px 0px 0px;">
            <div class="small-12 medium-12 columns"><strong>3) Who should this be registered to?</strong></div>
        </div>
        <div class="row medium-collapse" style="padding: 10px 10px 10px 30px;">
            <div class="small-12 medium-12 columns">
                <?php include('userid-field.php'); ?><br>&nbsp;&nbsp;&nbsp;&nbsp;<i>Other</i> <input name="owner" maxlength="100" class="form" type="text" >
            </div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>4) Approval</strong></div>
        </div>

        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-6 columns"><label for="eod" class="middle">What is the last day it should be seen?<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">We entered 60-days into the future.</span></label></div>
            <div class="small-12 medium-6 end columns"><input name="eod" class="form datepicker" type="date" value="<?php echo date("Y-m-d", strtotime($date ."+60 days" )); ?>" required></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="forsalerent" class="middle">Listing Type</label></div>
            <div class="small-12 medium-7 end columns">
<select name="forsalerent">
<option value="CLASSIFIED">Classified Ad</option>
<option value="SOCIAL">Private Social Event</option>
<option value="SALE">Unit For Sale</option>
<option value="RENT">Unit For Rent</option>
</select>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="approved" class="middle">Approve this listing?</label></div>
            <div class="small-12 medium-7 end columns">
<select name="approved">
<option value="Y">Yes</option>
<option value="N">No</option>
</select>
            </div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-6 columns"><strong>5) Ready to Save?</strong></div>
            <div class="small-12 medium-6 columns">
	            <input type="hidden" name="action" value="add">
                <input name="submit" value="Submit" class="submit" type="submit">
                <?php echo($error); ?>
            </div>
        </div>
        <div class="row medium-collapse">
            <div class="small-12 medium-12 columns" align="center">
<br><i class="fa fa-hand-o-down" aria-hidden="true"></i> Scroll down to see the classified ads already added.
            </div>
        </div>
    </div>
</div>
</form>
<!-- END UPLOAD FORM -->
<a name="pending"></a>
<br>
<div class="nav-section-header-cp" style="background-color: #990000;">
        <strong>
<?php $sql = mysqli_query($conn,"SELECT count(*) FROM realestate WHERE approved = 'N'") or die(mysqli_error($conn));
//$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Pending Approval (
      <?php $sql = mysqli_query($conn,"SELECT count(*) FROM realestate WHERE forsalerent = 'SALE' AND approved = 'N'") or die(mysqli_error($conn));
      //$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Sale /
      <?php $sql = mysqli_query($conn,"SELECT count(*) FROM realestate WHERE forsalerent = 'RENT' AND approved = 'N'") or die(mysqli_error($conn));
      //$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Rent /
      <?php $sql = mysqli_query($conn,"SELECT count(*) FROM realestate WHERE forsalerent = 'CLASSIFIED' AND approved = 'N'") or die(mysqli_error($conn));
      //$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Classified )
        </strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr align="left">
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Listing</small></th>
      <th width="100" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Photo</small></th>
      <th width="50" class="table-sortable:numeric">&nbsp;&nbsp;&nbsp; <small>ID</small></th>
      <th class="table-sortable:date table-filterable">&nbsp;&nbsp;&nbsp; <small>Expiration</small></th>
      <th class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <small>Type</small></th>

  </thead>
  <tbody style="background-color:#ffffff">
<!-- DATABASE RESULTS -->
<?php
    $query  = "SELECT * FROM realestate WHERE approved = 'N' ORDER BY `int1` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- DATABASE RESULTS -->
    <tr>
      <td>
        <div class="small-12 medium-12 large-8 columns">
          <b><?php echo "{$row['headline']}"; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "{$row['price']}"; ?><br>
          <blockquote><?php echo "{$row['description']}"; ?></blockquote>
          <span class="note-black">
          <b><?php echo "{$row['contact']}"; ?></b><br>
          <?php echo "{$row['phone']}"; ?><br>
          <?php if ($row['url'] !== ''){ ?><a href="<?php echo "{$row['url']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('External/<?php echo "{$row['url']}"; ?>'); ">Website</a><br><?php }; ?>
          &nbsp;<?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>" onclick="javascript:pageTracker._trackPageview('Email/<?php echo "{$row['email']}"; ?>'); ">Email</a><br><?php }; ?>
<?php if ($row['docid'] !== ''){ ?>
	<?php
		$type    = $row['docid'];
		$queryDOC  = "SELECT title FROM documents WHERE `id` = '$type'";
		$resultDOC = mysqli_query($conn,$queryDOC);

		while($rowDOC = $resultDOC->fetch_array(MYSQLI_ASSOC))
		{
	?>
Link to Document <?php echo "{$rowDOC['title']}"; ?><br>
	<?php
		}
	?>
<?php }; ?>
            </span>
        </div>
		<div class="small-6 medium-6 large-2 columns">
            <form name="REEdit" method="POST" action="sell-edit.php">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
                <input name="submit" value="Edit" class="submit" type="submit">
            </form>
        </div>
        <div class="small-6 medium-6 large-2 columns">
	        <form name="REDelete" method="POST" action="sell.php" onclick="return confirm('Are you sure you want to delete <?php echo "{$row['headline']}"; ?>?');">
	            <input type="hidden" name="action" value="delete">
            	<input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
	            <input name="submit" value="Delete" class="submit" type="submit">
	        </form>
        </div>
      </td>
      <td valign="top"><?php if ($row['name'] !== ''){ ?><?php if ($row['name'] !== 'none'){ ?><div style="max-width:200px;"><img src="../download-sell.php?int1=<?php echo"{$row['int1']}"; ?>" alt="<?php echo "{$row['title']}"; ?>"></div><?php }; ?><?php }; ?></td>
      <td><?php echo "{$row['int1']}"; ?></td>
      <td><?php echo "{$row['eod']}"; ?></td>
      <td><?php echo "{$row['forsalerent']}"; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
  </tbody>
</table>
<a name="edit"></a>
<br>
<div class="nav-section-header-cp">
        <strong>
<?php $sql = mysqli_query($conn,"SELECT count(*) FROM realestate WHERE approved = 'Y' AND approved = 'Y' AND eod NOT BETWEEN '0000-01-01' AND CURRENT_DATE()") or die(mysqli_error($conn));
//$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Approved and Visible Listings (
<?php $sql = mysqli_query($conn,"SELECT count(*) FROM realestate WHERE forsalerent = 'SALE' AND approved = 'Y' AND eod NOT BETWEEN '0000-01-01' AND CURRENT_DATE()") or die(mysqli_error($conn));
//$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Sale /
<?php $sql = mysqli_query($conn,"SELECT count(*) FROM realestate WHERE forsalerent = 'RENT' AND approved = 'Y' AND approved = 'Y' AND eod NOT BETWEEN '0000-01-01' AND CURRENT_DATE()") or die(mysqli_error($conn));
//$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Rent /
<?php $sql = mysqli_query($conn,"SELECT count(*) FROM realestate WHERE forsalerent = 'CLASSIFIED' AND approved = 'Y' AND approved = 'Y' AND eod NOT BETWEEN '0000-01-01' AND CURRENT_DATE()") or die(mysqli_error($conn));
//$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Classified )
        </strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr align="left">
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Listing</small></th>
      <th width="100" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Photo</small></th>
      <th width="50" class="table-sortable:numeric">&nbsp;&nbsp;&nbsp; <small>ID</small></th>
      <th class="table-sortable:date table-filterable">&nbsp;&nbsp;&nbsp; <small>Expiration</small></th>
      <th class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <small>Type</small></th>
    </tr>
  </thead>
  <tbody style="background-color:#ffffff">
<!-- DATABASE RESULTS -->
<?php
    $query  = "SELECT * FROM realestate WHERE approved = 'Y' AND eod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY `int1` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- DATABASE RESULTS -->
    <tr>
      <td>
        <div class="small-12 medium-12 large-8 columns">
          <b><?php echo "{$row['headline']}"; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "{$row['price']}"; ?><br>
          <blockquote><?php echo "{$row['description']}"; ?></blockquote>
          <span class="note-black">
          <b><?php echo "{$row['contact']}"; ?></b><br>
          <?php echo "{$row['phone']}"; ?><br>
          <?php if ($row['url'] !== ''){ ?><a href="<?php echo "{$row['url']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('External/<?php echo "{$row['url']}"; ?>'); "><?php echo "{$row['url']}"; ?></a><br><?php }; ?>
          <?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>" onclick="javascript:pageTracker._trackPageview('Email/<?php echo "{$row['email']}"; ?>'); "><?php echo "{$row['email']}"; ?></a><br><?php }; ?>
<?php if ($row['docid'] !== ''){ ?>
	<?php
		$type    = $row['docid'];
		$queryDOC  = "SELECT title FROM documents WHERE `id` = '$type'";
		$resultDOC = mysqli_query($conn,$queryDOC);

		while($rowDOC = $resultDOC->fetch_array(MYSQLI_ASSOC))
		{
	?>
Link to Document <?php echo "{$rowDOC['title']}"; ?><br>
	<?php
		}
	?>
<?php }; ?>
            </span>
        </div>
        <div class="small-6 medium-6 large-2 columns">
            <form name="REEdit" method="POST" action="sell-edit.php">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
                <input name="submit" value="Edit" class="submit" type="submit">
            </form>
        </div>
        <div class="small-6 medium-6 large-2 columns">
	        <form name="REDelete" method="POST" action="sell.php" onclick="return confirm('Are you sure you want to delete <?php echo "{$row['headline']}"; ?>?');">
	            <input type="hidden" name="action" value="delete">
            	<input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
	            <input name="submit" value="Delete" class="submit" type="submit">
	        </form>
        </div>
      </td>
      <td valign="top"><?php if ($row['name'] !== ''){ ?><?php if ($row['name'] !== 'none'){ ?><div style="max-width:200px;"><img src="../download-sell.php?int1=<?php echo"{$row['int1']}"; ?>" alt="<?php echo "{$row['title']}"; ?>"></div><?php }; ?><?php }; ?></td>
      <td><?php echo "{$row['int1']}"; ?></td>
      <td><?php echo "{$row['eod']}"; ?></td>
      <td><?php echo "{$row['forsalerent']}"; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
  </tbody>
</table>
<br>
<div class="nav-section-header-cp">
        <strong>
<?php $sql = mysqli_query($conn,"SELECT count(*) FROM realestate WHERE eod < CURRENT_DATE() AND eod > '0000-00-01' AND approved = 'Y'") or die(mysqli_error($conn));
//$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Expired Listings (
<?php $sql = mysqli_query($conn,"SELECT count(*) FROM realestate WHERE forsalerent = 'SALE' AND eod < CURRENT_DATE() AND eod > '0000-00-01' AND approved = 'Y'") or die(mysqli_error($conn));
//$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Sale /
<?php $sql = mysqli_query($conn,"SELECT count(*) FROM realestate WHERE forsalerent = 'RENT' AND eod < CURRENT_DATE() AND eod > '0000-00-01' AND approved = 'Y'") or die(mysqli_error($conn));
//$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Rent /
<?php $sql = mysqli_query($conn,"SELECT count(*) FROM realestate WHERE forsalerent = 'CLASSIFIED' AND eod < CURRENT_DATE() AND eod > '0000-00-01' AND approved = 'Y'") or die(mysqli_error($conn));
//$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Classified )
        </strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr align="left">
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Listing</small></th>
      <th width="100" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Photo</small></th>
      <th width="50" class="table-sortable:numeric">&nbsp;&nbsp;&nbsp; <small>ID</small></th>
      <th class="table-sortable:date table-filterable">&nbsp;&nbsp;&nbsp; <small>Expiration</small></th>
      <th class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <small>Type</small></th>
    </tr>
  </thead>
  <tbody style="background-color:#ffffff">
<!-- DATABASE RESULTS -->
<?php
    $query  = "SELECT * FROM realestate WHERE approved = 'Y' AND eod < CURRENT_DATE() AND eod > '0000-00-01' ORDER BY `int1` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- DATABASE RESULTS -->
    <tr>
      <td>
        <div class="small-12 medium-12 large-8 columns">
          <b><?php echo "{$row['headline']}"; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "{$row['price']}"; ?><br>
          <blockquote><?php echo "{$row['description']}"; ?></blockquote>
          <span class="note-black">
          <b><?php echo "{$row['contact']}"; ?></b><br>
          <?php echo "{$row['phone']}"; ?><br>
          <?php if ($row['url'] !== ''){ ?><a href="<?php echo "{$row['url']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('External/<?php echo "{$row['url']}"; ?>'); "><?php echo "{$row['url']}"; ?></a><br><?php }; ?>
          <?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>" onclick="javascript:pageTracker._trackPageview('Email/<?php echo "{$row['email']}"; ?>'); "><?php echo "{$row['email']}"; ?></a><br><?php }; ?>
<?php if ($row['docid'] !== ''){ ?>
	<?php
		$type    = $row['docid'];
		$queryDOC  = "SELECT title FROM documents WHERE `id` = '$type'";
		$resultDOC = mysqli_query($conn,$queryDOC);

		while($rowDOC = $resultDOC->fetch_array(MYSQLI_ASSOC))
		{
	?>
Link to Document <?php echo "{$rowDOC['title']}"; ?><br>
	<?php
		}
	?>
<?php }; ?>
            </span>
        </div>
				<div class="small-6 medium-6 large-2 columns">
            <form name="REEdit" method="POST" action="sell-edit.php">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
                <input name="submit" value="Edit" class="submit" type="submit">
            </form>
        </div>
        <div class="small-6 medium-6 large-2 columns">
	        <form name="REDelete" method="POST" action="sell.php" onclick="return confirm('Are you sure you want to delete <?php echo "{$row['headline']}"; ?>?');">
	            <input type="hidden" name="action" value="delete">
            	<input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
	            <input name="submit" value="Delete" class="submit" type="submit">
	        </form>
        </div>
      </td>
      <td valign="top"><?php if ($row['name'] !== ''){ ?><?php if ($row['name'] !== 'none'){ ?><div style="max-width:200px;"><img src="../download-sell.php?int1=<?php echo"{$row['int1']}"; ?>" alt="<?php echo "{$row['title']}"; ?>"></div><?php }; ?><?php }; ?></td>
      <td><?php echo "{$row['int1']}"; ?></td>
      <td><?php echo "{$row['eod']}"; ?></td>
      <td><?php echo "{$row['forsalerent']}"; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
  </tbody>
</table>
</div>
<br>

<div style="max-width: 99%;">
<a name="modulepermissions"></a>
<!-- MODULE PERMISSIONS -->
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
	$module = "sell.php";
	$query  = "SELECT * FROM tabs WHERE liaison = 'Y' AND `int1` BETWEEN '204' AND '204' ORDER BY `int1`";
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
	$module = "sell.php";
	$query  = "SELECT * FROM tabs WHERE liaison = 'Y' AND `int1` BETWEEN '205' AND '209' ORDER BY `int1`";
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

<div class="small-12 medium-12 large-12 columns note-black"><br><br>Classifieds Control Panel Page<br></div>
</body>
</html>
