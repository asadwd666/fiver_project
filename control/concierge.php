<?php $current_page = '3'; include('protect.php'); ?>
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
<?php $int1 = $_POST["int1"]; $action = $_POST["action"]; if ($action != null){ ?>
<?php
	if ($action == "delete"){
		$query = "DELETE FROM concierge WHERE `int1`='$int1'";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
		
			$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Your entry was deleted successfully.</strong></div>";

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['int1'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('D', 'Business Directory', '$useripaddress', '$userid', '$id')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

		$query = "OPTIMIZE TABLE `concierge`";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

	}
	if ($action == "add"){

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$date = date('Y-m-d');
		$type = $_POST["type"];
		$name = htmlspecialchars($_POST['name'], ENT_QUOTES);
		$address = $_POST["address"];
		$phone = $_POST["phone"];
		$url = htmlspecialchars($_POST['url'], ENT_QUOTES);
		$email = htmlspecialchars($_POST['email'], ENT_QUOTES);
		$directions = htmlspecialchars($_POST['directions'], ENT_QUOTES);
		$comments = $_POST["comments"];
		$docid = $_POST["docid"];
		$approved = $_POST["approved"];

		$query = "INSERT INTO concierge (userid, useripaddress, date, type, name, address, phone, url, email, directions, comments, docid, approved) VALUES ('$userid', '$useripaddress', '$date', '$type', '$name', '$address', '$phone', '$url', '$email', '$directions', '$comments', '$docid', '$approved')";
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
<?php $sqlBSD = mysqli_query($conn,"SELECT count(*) FROM concierge WHERE approved != 'Y'") or die(mysqli_error($conn));
//$countBSD = mysql_result($sqlBSD, "0");
$row = mysqli_fetch_row($sqlBSD);
$countBSD = $row[0];
?>
<?php if ($countBSD != '0'){ ?><i class="fa fa-exclamation-triangle note" aria-hidden="true"></i> You have <?php print($countBSD); ?> listings <a href="#edit">pending your approval</a>!<?php }; ?>
<?php if ($countBSD == '0'){ ?><i class="fa fa-check" aria-hidden="true"></i> Things are looking good!<?php }; ?>
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
        <p><b>Business Directory Listings</b></a> tell your community about local businesses and services.
        There is room to add information about their business hours, further descriptions on what the business does, and more.</p>
    </div>
    <div class="small-12 medium-6 columns">
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#add"><b>Add a Business Directory Listing</b></a> using the addition form below.</p>
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#edit"><b>View and Edit</b></a> existing entries in your database.</p>
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#modulepermissions"><b>Module Permissions</b></a> allow you to choose what content should be seen by which groups of users. You can also <a href="#disclosure">edit the disclosure</a> shown to users.</p>
    </div>
</div>

<!-- UPLOAD FORM -->
<a name="add"></a>
<div class="nav-section-header-cp">
        <strong>Add a Business Directory Listing</strong>
</div>
<?php echo($errorSUCCESS); ?>
<!-- INPUT FORM -->
<form name="CLAdd" method="POST" action="concierge.php">
	<div class="cp-form-container">
	    <div class="small-12 medium-12 large-6 columns">
	        <div class="row" style="padding: 10px 10px 0px 0px;">
	            <div class="small-12 medium-12 columns"><strong>1) Who should this be registered to?</strong></div>
	        </div>
	        <div class="row medium-collapse" style="padding: 10px 10px 10px 30px;">
	            <div class="small-12 medium-12 columns">
	                <label for="make" class="middle"><?php echo "{$_SESSION['first_name']}"; ?> <?php echo "{$_SESSION['last_name']}"; ?></label>
	            </div>
	        </div>
	        <div class="row" style="padding: 10px 10px 10px 0px;">
	            <div class="small-12 medium-12 columns"><strong>2) Listing Information</strong></div>
	        </div>
					<div class="row medium-collapse" style="padding-left: 30px;">
	            <div class="small-12 medium-5 columns"><label for="type" class="middle">Category</label></div>
	            <div class="small-12 medium-7 end columns">
								<select name="type" autofocus>
								<option value="">Select a category for this listing</option>
								<option value="24 Hours" <?php if($row['type'] == "24 Hours"){ echo("SELECTED"); } ?>>Open 24 Hours</option>
								<option value="Automotive" <?php if($row['type'] == "Automotive"){ echo("SELECTED"); } ?>>Automotive</option>
								<option value="Appliance Sales and Repair" <?php if($row['type'] == "Appliance Sales and Repair"){ echo("SELECTED"); } ?>>Appliance Sales and Repair</option>
								<option value="Banks" <?php if($row['type'] == "Banks"){ echo("SELECTED"); } ?>>Banks</option>
								<option value="Barbers" <?php if($row['type'] == "Barbers"){ echo("SELECTED"); } ?>>Barbers</option>
								<option value="Bars" <?php if($row['type'] == "Bars"){ echo("SELECTED"); } ?>>Bars</option>
								<option value="Beaches" <?php if($row['type'] == "Beaches"){ echo("SELECTED"); } ?>>Beaches</option>
								<option value="Boating" <?php if($row['type'] == "Boating"){ echo("SELECTED"); } ?>>Boating</option>
								<option value="Carpet Cleaning" <?php if($row['type'] == "Carpet Cleaning"){ echo("SELECTED"); } ?>>Carpet Cleaning</option>
								<option value="Casinos" <?php if($row['type'] == "Casinos"){ echo("SELECTED"); } ?>>Casinos</option>
								<option value="Cement/Asphalt Work" <?php if($row['type'] == "Cement/Asphalt Work"){ echo("SELECTED"); } ?>>Cement/Asphalt Work</option>
								<option value="Cleaning Service" <?php if($row['type'] == "Cleaning Service"){ echo("SELECTED"); } ?>>Cleaning Service</option>
								<option value="Computers" <?php if($row['type'] == "Computers"){ echo("SELECTED"); } ?>>Computers</option>
								<option value="Contractors" <?php if($row['type'] == "Contractors"){ echo("SELECTED"); } ?>>Contractors</option>
								<option value="Coupons" <?php if($row['type'] == "Coupons"){ echo("SELECTED"); } ?>>Coupons</option>
								<option value="Dentists" <?php if($row['type'] == "Dentists"){ echo("SELECTED"); } ?>>Dentists</option>
								<option value="Doctors" <?php if($row['type'] == "Doctors"){ echo("SELECTED"); } ?>>Doctors</option>
								<option value="Dog Walkers" <?php if($row['type'] == "Dog Walkers"){ echo("SELECTED"); } ?>>Dog Walkers</option>
								<option value="Doors, Windows and Screens" <?php if($row['type'] == "Doors, Windows and Screens"){ echo("SELECTED"); } ?>>Doors Windows and Screens</option>
								<option value="Dry Cleaners" <?php if($row['type'] == "Dry Cleaners"){ echo("SELECTED"); } ?>>Dry Cleaners</option>
								<option value="Electricians" <?php if($row['type'] == "Electricians"){ echo("SELECTED"); } ?>>Electricians</option>
								<option value="Entertainment" <?php if($row['type'] == "Entertainment"){ echo("SELECTED"); } ?>>Entertainment</option>
								<option value="Fencing and Gates" <?php if($row['type'] == "Fencing and Gates"){ echo("SELECTED"); } ?>>Fencing and Gates</option>
								<option value="Flooring" <?php if($row['type'] == "Flooring"){ echo("SELECTED"); } ?>>Flooring</option>
								<option value="Food Deliveries" <?php if($row['type'] == "Food Deliveries"){ echo("SELECTED"); } ?>>Food Delivery</option>
								<option value="Galleries" <?php if($row['type'] == "Galleries"){ echo("SELECTED"); } ?>>Galleries</option>
								<option value="Golf" <?php if($row['type'] == "Golf"){ echo("SELECTED"); } ?>>Golf</option>
								<option value="Grocery Stores" <?php if($row['type'] == "Grocery Stores"){ echo("SELECTED"); } ?>>Grocery Stores</option>
								<option value="Gyms" <?php if($row['type'] == "Gyms"){ echo("SELECTED"); } ?>>Gyms</option>
								<option value="Hair Salons" <?php if($row['type'] == "Hair Salons"){ echo("SELECTED"); } ?>>Hair Salons</option>
								<option value="Handyman" <?php if($row['type'] == "Handyman"){ echo("SELECTED"); } ?>>Handyman</option>
								<option value="Heating and Air Conditioning" <?php if($row['type'] == "Heating and Air Conditioning"){ echo("SELECTED"); } ?>>Heating and Air Conditioning</option>
								<option value="Hospitals" <?php if($row['type'] == "Hospitals"){ echo("SELECTED"); } ?>>Hospitals</option>
								<option value="Housekeepers" <?php if($row['type'] == "Housekeepers"){ echo("SELECTED"); } ?>>Housekeepers</option>
								<option value="Housesitters" <?php if($row['type'] == "Housesitters"){ echo("SELECTED"); } ?>>Housesitters</option>
								<option value="Houses of Worship" <?php if($row['type'] == "Houses of Worship"){ echo("SELECTED"); } ?>>Houses of Worship</option>
								<option value="Insurance" <?php if($row['type'] == "Insurance"){ echo("SELECTED"); } ?>>Insurance</option>
								<option value="Kids Activities" <?php if($row['type'] == "Kids Activities"){ echo("SELECTED"); } ?>>Kids Activities</option>
								<option value="Landscaping" <?php if($row['type'] == "Landscaping"){ echo("SELECTED"); } ?>>Landscaping</option>
								<option value="Libraries" <?php if($row['type'] == "Libraries"){ echo("SELECTED"); } ?>>Libraries</option>
								<option value="Local Delivery" <?php if($row['type'] == "Local Delivery"){ echo("SELECTED"); } ?>>Local Delivery</option>
								<option value="Locksmith" <?php if($row['type'] == "Locksmith"){ echo("SELECTED"); } ?>>Locksmith</option>
								<option value="Museums" <?php if($row['type'] == "Museums"){ echo("SELECTED"); } ?>>Museums</option>
								<option value="Miscellaneous" <?php if($row['type'] == "Miscellaneous"){ echo("SELECTED"); } ?>>Miscellaneous</option>
								<option value="Nearby Attractions" <?php if($row['type'] == "Nearby Attractions"){ echo("SELECTED"); } ?>>Nearby Attractions</option>
								<option value="Newspapers" <?php if($row['type'] == "Newspapers"){ echo("SELECTED"); } ?>>Newspapers</option>
								<option value="Painting" <?php if($row['type'] == "Painting"){ echo("SELECTED"); } ?>>Painting</option>
								<option value="Parks" <?php if($row['type'] == "Parks"){ echo("SELECTED"); } ?>>Parks</option>
								<option value="Party Planning" <?php if($row['type'] == "Party Planning"){ echo("SELECTED"); } ?>>Party Planning</option>
								<option value="Patio Furniture" <?php if($row['type'] == "Patio Furniture"){ echo("SELECTED"); } ?>>Patio Furniture</option>
								<option value="Pest Control" <?php if($row['type'] == "Pest Control"){ echo("SELECTED"); } ?>>Pest Control</option>
								<option value="Pets" <?php if($row['type'] == "Pets"){ echo("SELECTED"); } ?>>Pets</option>
								<option value="Pharmacies" <?php if($row['type'] == "Pharmacies"){ echo("SELECTED"); } ?>>Pharmacies</option>
								<option value="Pizza" <?php if($row['type'] == "Pizza"){ echo("SELECTED"); } ?>>Pizza</option>
								<option value="Plumbers" <?php if($row['type'] == "Plumbers"){ echo("SELECTED"); } ?>>Plumbers</option>
								<option value="Pool Supplies/Service" <?php if($row['type'] == "Pool Supplies/Service"){ echo("SELECTED"); } ?>>Pool Supplies/Service</option>
								<option value="Professionals" <?php if($row['type'] == "Professionals"){ echo("SELECTED"); } ?>>Professionals</option>
								<option value="Rain Gutters" <?php if($row['type'] == "Rain Gutters"){ echo("SELECTED"); } ?>>Rain Gutters</option>
								<option value="Realtors" <?php if($row['type'] == "Realtors"){ echo("SELECTED"); } ?>>Realtors</option>
								<option value="Restaurant" <?php if($row['type'] == "Restaurant"){ echo("SELECTED"); } ?>>Restaurant</option>
								<option value="RV Maintenance and Repair" <?php if($row['type'] == "RV Maintenance and Repair"){ echo("SELECTED"); } ?>>RV Maintenance and Repair</option>
								<option value="Roofing" <?php if($row['type'] == "Roofing"){ echo("SELECTED"); } ?>>Roofing</option>
								<option value="Schools" <?php if($row['type'] == "Schools"){ echo("SELECTED"); } ?>>Schools</option>
								<option value="Seniors" <?php if($row['type'] == "Seniors"){ echo("SELECTED"); } ?>>Seniors</option>
								<option value="Shopping" <?php if($row['type'] == "Shopping"){ echo("SELECTED"); } ?>>Shopping</option>
								<option value="Shopping - Women" <?php if($row['type'] == "Shopping - Women"){ echo("SELECTED"); } ?>>Shopping - Women</option>
								<option value="Shopping - Men" <?php if($row['type'] == "Shopping - Men"){ echo("SELECTED"); } ?>>Shopping - Men</option>
								<option value="Social Services" <?php if($row['type'] == "Social Services"){ echo("SELECTED"); } ?>>Social Services</option>
								<option value="Sports" <?php if($row['type'] == "Sports"){ echo("SELECTED"); } ?>>Sports</option>
								<option value="Sushi" <?php if($row['type'] == "Sushi"){ echo("SELECTED"); } ?>>Sushi</option>
								<option value="Theaters" <?php if($row['type'] == "Theaters"){ echo("SELECTED"); } ?>>Theaters</option>
								<option value="Tours" <?php if($row['type'] == "Tours"){ echo("SELECTED"); } ?>>Tours</option>
								<option value="Transportation" <?php if($row['type'] == "Transportation"){ echo("SELECTED"); } ?>>Transportation</option>
								<option value="Vendors" <?php if($row['type'] == "Vendors"){ echo("SELECTED"); } ?>>Vendors</option>
								<option value="Walking Distance" <?php if($row['type'] == "Walking Distance"){ echo("SELECTED"); } ?>>Walking Distance</option>
								<option value="Wineries" <?php if($row['type'] == "Wineries"){ echo("SELECTED"); } ?>>Wineries</option>
								<option value="Window Cleaning" <?php if($row['type'] == "Window Cleaning"){ echo("SELECTED"); } ?>>Window Cleaning</option>
								</select>
								<label style="margin-top:-10px; margin-bottom: 10px;"><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Contact your CondoSites webmaster to add categories.</span></label>
	            </div>
	        </div>
	        <div class="row medium-collapse" style="padding-left: 30px;">
	            <div class="small-12 medium-5 columns"><label for="name" class="middle">Business Name</label></div>
	            <div class="small-12 medium-7 end columns"><input name="name" placeholder="McDonalds" maxlength="100" class="form" type="text" required></div>
	        </div>
					<div class="row medium-collapse" style="padding-left: 30px;">
							<div class="small-12 medium-5 columns"><label for="address" class="middle">Business Address</label></div>
							<div class="small-12 medium-7 end columns"><input name="address" placeholder="123 Any St, Seattle WA 98101" maxlength="150" class="form" type="text" ></div>
					</div>
					<div class="row medium-collapse" style="padding-left: 30px;">
							<div class="small-12 medium-5 columns"><label for="phone" class="middle">Business Phone</label></div>
							<div class="small-12 medium-7 end columns"><input name="phone" placeholder="(206) 555-1212" maxlength="100" class="form" type="tel" ></div>
					</div>
					<div class="row medium-collapse" style="padding-left: 30px;">
							<div class="small-12 medium-5 columns"><label for="email" class="middle">Business Email</label></div>
							<div class="small-12 medium-7 end columns"><input name="email" placeholder="burger@mcdonalds.com" maxlength="100" class="form" type="email" ></div>
					</div>
					<div class="row medium-collapse" style="padding-left: 30px;">
							<div class="small-12 medium-5 columns"><label for="url" class="middle">Business Website</label></div>
							<div class="small-12 medium-7 end columns"><input name="url" placeholder="http://www.mcdonalds.com" maxlength="100" class="form" type="url" ></div>
					</div>
					<div class="row medium-collapse" style="padding-left: 30px;">
							<div class="small-12 medium-5 columns"><label for="directions" class="middle">Map Directions URL</label></div>
							<div class="small-12 medium-7 end columns"><input name="directions" placeholder="Paste directions URL from Google Maps" maxlength="100" class="form" type="url" ></div>
					</div>
<?php include('docid-field.php'); ?>
	    </div>
	    <div class="small-12 medium-12 large-6 columns">
	        <div class="row" style="padding: 10px 10px 10px 0px;">
	            <div class="small-12 medium-12 columns"><strong>3) Approval and Comments</strong></div>
	        </div>
	        <div class="row medium-collapse" style="padding-left: 30px; padding-bottom: 20px;">
	            <div class="small-12 medium-12 columns"><label for="comments" class="middle">Comments  &nbsp;&nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Comments ARE visible to users.</span><br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">If pasting content from Microsoft Word, use the "Paste from Word" ( <img src="https://condosites.net/commons/pastefromword.png" width="15"> ) button.</span><br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Use the Styles pulldown to stylize your text.</span></label>
								<textarea name="comments" id="editor1" cols="40" rows="7"></textarea>
								<script>CKEDITOR.replace( 'editor1' );</script>
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
	            <div class="small-12 medium-6 columns"><strong>4) Ready to Save?</strong></div>
	            <div class="small-12 medium-6 columns">
					<input type="hidden" name="action" value="add">
					<input name="submit" value="Submit" class="submit" type="submit">
	            </div>
	        </div>
	        <div class="row medium-collapse">
	            <div class="small-12 medium-12 columns" align="center">
	                <br><i class="fa fa-hand-o-down" aria-hidden="true"></i> Scroll down to see the business directory entries already added.
	            </div>
	        </div>
	    </div>
	</div>
</form>
<!-- END INPUT FORM -->
<a name="edit"></a>
<br>
<div class="nav-section-header-cp" style="background-color: #990000;">
        <strong><?php $sql = mysqli_query($conn,"SELECT count(*) FROM concierge WHERE approved = 'N'") or die(mysqli_error($conn));
        //$count = mysql_result($sql, "0");
        $row = mysqli_fetch_row($sql);
        $count = $row[0];
        print($count); ?> Pending Business Directory Listings</strong>
</div>
<table width="95%" style="background-color:#eeeddd" align="center" border="0" cellpadding="5" cellspacing="1" class="text table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr align="left">
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Listing</small></th>
      <th width="50" class="table-sortable:numeric">&nbsp;&nbsp;&nbsp; <small>ID</small></th>
      <th class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <small>Category</small></th>
    </tr>
  </thead>
  <tbody style="background-color:#ffffff">
<?php
	$query  = "SELECT * FROM concierge WHERE approved = 'N' ORDER BY `int1` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- DATABASE RESULTS -->
    <tr>
      <td>
	<div class="small-12 medium-12 large-8 columns">
		<b><?php echo "{$row['name']}"; ?></b><br>

<?php if ($row['url'] !== ''){ ?><a href="<?php echo "{$row['url']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('External/<?php echo "{$row['url']}"; ?>'); "><?php echo "{$row['url']}"; ?></a><br><?php }; ?>

<?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>" onclick="javascript:pageTracker._trackPageview('Email/<?php echo "{$row['email']}"; ?>'); "><?php echo "{$row['email']}"; ?></a><br><?php }; ?>

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

<?php if ($row['directions'] !== ''){ ?><a href="<?php echo "{$row['directions']}"; ?>" target="_blank">Directions</a><br><?php }; ?>

<?php if ($row['address'] !== ''){ ?><?php echo "{$row['address']}"; ?><br><?php }; ?><?php if ($row['address'] = ''){ ?><br><?php }; ?>

<?php if ($row['phone'] !== ''){ ?><p class="nav-property-manager"><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row['phone']); ?>"><?php echo "{$row['phone']}"; ?></a><br><?php }; ?>

<?php if ($row['comments'] !== ''){ ?>
<blockquote>
    <?php echo "{$row['comments']}"; ?>
</blockquote>
<?php }; ?>

	</div>
	<div class="small-6 medium-6 large-2 columns">
		<form name="CLEdit" method="POST" action="concierge-edit.php">
			<input type="hidden" name="action" value="edit">
			<input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
			<input name="submit" value="Edit" class="submit" type="submit">
		</form>
    </div>
    <div class="small-6 medium-6 large-2 columns">
		<form name="CLDelete" method="POST" action="concierge.php" onclick="return confirm('Are you sure you want to delete <?php echo "{$row['name']}"; ?>?');">
	    	<input type="hidden" name="action" value="delete">
			<input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
			<input name="submit" value="Delete" class="submit" type="submit">
		</form>
    </div>
	</td>
        <td><?php echo "{$row['int1']}"; ?></td>
        <td><?php echo "{$row['type']}"; ?></td>
    </tr>
<!-- END DATABASE RESULTS -->
<?php
	}
?>
  </tbody>
</table>
<br>
<div class="nav-section-header-cp">
        <strong><?php $sql = mysqli_query($conn,"SELECT count(*) FROM concierge WHERE approved = 'Y'") or die(mysqli_error($conn));
        //$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Approved Business Directory Listings</strong>
</div>
<table width="95%" style="background-color:#eeeddd" align="center" border="0" cellpadding="5" cellspacing="1" class="text table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr align="left">
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Listing</small></th>
      <th width="50" class="table-sortable:numeric">&nbsp;&nbsp;&nbsp; <small>ID</small></th>
      <th class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <small>Category</small></th>
    </tr>
  </thead>
  <tbody style="background-color:#ffffff">
<?php
	$query  = "SELECT * FROM concierge WHERE approved = 'Y' ORDER BY `int1` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- DATABASE RESULTS -->
    <tr>
      <td>
	<div class="small-12 medium-12 large-8 columns">
		<b><?php echo "{$row['name']}"; ?></b><br>

<?php if ($row['url'] !== ''){ ?><a href="<?php echo "{$row['url']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('External/<?php echo "{$row['url']}"; ?>'); "><?php echo "{$row['url']}"; ?></a><br><?php }; ?>

<?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>" onclick="javascript:pageTracker._trackPageview('Email/<?php echo "{$row['email']}"; ?>'); "><?php echo "{$row['email']}"; ?></a><br><?php }; ?>

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

<?php if ($row['directions'] !== ''){ ?><a href="<?php echo "{$row['directions']}"; ?>" target="_blank">Directions</a><br><?php }; ?>

<?php if ($row['address'] !== ''){ ?><?php echo "{$row['address']}"; ?><br><?php }; ?><?php if ($row['address'] = ''){ ?><br><?php }; ?>

<?php if ($row['phone'] !== ''){ ?><?php echo "{$row['phone']}"; ?><br><?php }; ?>

<?php if ($row['comments'] !== ''){ ?>
<blockquote>
    <?php echo "{$row['comments']}"; ?>
</blockquote>
<?php }; ?>

	</div>
	<div class="small-6 medium-6 large-2 columns">
		<form name="CLEdit" method="POST" action="concierge-edit.php">
			<input type="hidden" name="action" value="edit">
			<input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
			<input name="submit" value="Edit" class="submit" type="submit">
		</form>
    </div>
    <div class="small-6 medium-6 large-2 columns">
		<form name="CLDelete" method="POST" action="concierge.php" onclick="return confirm('Are you sure you want to delete <?php echo "{$row['name']}"; ?>?');">
	    	<input type="hidden" name="action" value="delete">
			<input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
			<input name="submit" value="Delete" class="submit" type="submit">
		</form>
    </div>
	</td>
        <td><?php echo "{$row['int1']}"; ?></td>
        <td><?php echo "{$row['type']}"; ?></td>
    </tr>
<!-- END DATABASE RESULTS -->
<?php
	}
?>
  </tbody>
</table>
<br>
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
	$module = "concierge.php";
	$query  = "SELECT * FROM tabs WHERE liaison = 'Y' AND `int1` BETWEEN '300' AND '300' ORDER BY `int1`";
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
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">The modules <b>below</b> contain just the subsets of the module.</span><br>
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
	$module = "concierge.php";
	$query  = "SELECT * FROM tabs WHERE liaison = 'Y' AND `int1` BETWEEN '301' AND '309' ORDER BY `int1`";
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
<a name="disclosure"></a>
<br>
<div class="nav-section-header-cp">
        <strong>Custom Module Content</strong>
</div>
<table style="background-color:#eeeddd" align="center" border="0" cellpadding="5" cellspacing="1" width="95%" class="text table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr align="left">
      <th style="min-width:25%"><b><small>Module<small/></b></th>
      <th><b><small>Code</small></b></th>
    </tr>
  </thead>
  <tbody style="background-color:#ffffff">
<!-- DATABASE RESULTS -->
<?php
    $module = "concierge.php";
	$query  = "SELECT `int1`, `type`, `theircode` FROM `3rd` WHERE `liaison` = 'Y' AND `type` = 'Business Directory Disclosure' ORDER BY `int1`";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
    <tr>
      <td>
          <b><?php echo "{$row['type']}"; ?></b><br>
          <br>
        <form name="3rdEdit" method="POST" action="3rd-edit.php">
          <input type="hidden" name="action" value="edit">
          <input type="hidden" name="module" value="<?php echo "{$module}"; ?>">
          <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
          <input name="submit" value="Edit" class="submit" type="submit">
        </form>
      </td>
      <td><?php echo "{$row['theircode']}"; ?></td>
    </tr>
<?php
	}
?>
  </tbody>
</table>
</div>
<br>

<div class="small-12 medium-12 large-12 columns note-black"><br><br>Business Directory Control Panel Page<br></div>
</body>
</html>
