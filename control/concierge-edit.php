<?php $current_page = '3'; include('protect.php'); $int1 = $_POST["int1"]; $action = $_POST["action"]; if ($action == "save"){

		$date = date('Y-m-d');
		$type = $_POST["type"];
		$name = htmlspecialchars($_POST['name'], ENT_QUOTES);
		$address = htmlspecialchars($_POST['address'], ENT_QUOTES);
		$phone = htmlspecialchars($_POST['phone'], ENT_QUOTES);
		$url = htmlspecialchars($_POST['url'], ENT_QUOTES);
		$email = htmlspecialchars($_POST['email'], ENT_QUOTES);
		$directions = htmlspecialchars($_POST['directions'], ENT_QUOTES);
		$comments = $_POST["comments"];
		$docid = $_POST["docid"];
		$approved = $_POST["approved"];

		$query = "UPDATE concierge SET date='$date', type='$type', name='$name', address='$address', phone='$phone', url='$url', email='$email', directions='$directions', comments='$comments', docid='$docid', approved='$approved' WHERE `int1`='$int1' LIMIT 1";
		mysqli_query($conn,$query) or die('Error, update query failed');

		$date = date("F j, Y");
		$query = "UPDATE updatedate SET date='$date'";
		mysqli_query($conn,$query) or die('Error, updating update date failed');

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['int1'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('E', 'Business Directory', '$useripaddress', '$userid', '$id')";
		mysqli_query($conn,$query) or die('Error, updating log failed');

		header('Location: concierge.php');
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
<div class="nav-section-header-cp">
        <strong>Edit a a Business Directory Listing</strong>
</div>
<!-- INPUT FORM -->
<?php
	$query  = "SELECT * FROM concierge WHERE `int1`='$int1' LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<div class="cp-form-container">
		<div class="small-12 medium-12 large-6 columns">
				<div class="row" style="padding: 10px 10px 0px 0px;">
<form enctype="multipart/form-data" method="POST" action="concierge-edit.php">
						<div class="small-12 medium-12 columns"><strong>1) Who should this be registered to?</strong></div>
				</div>
				<div class="row medium-collapse" style="padding: 10px 10px 10px 30px;">
            <div class="small-12 medium-12 columns">
                <?php include('userid-field-edit.php'); ?>
            </div>
        </div>
				<div class="row" style="padding: 10px 10px 10px 0px;">
						<div class="small-12 medium-12 columns"><strong>2) Listing Information</strong></div>
				</div>
				<div class="row medium-collapse" style="padding-left: 30px;">
						<div class="small-12 medium-5 columns"><label for="type" class="middle">Category <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Submit an enhancement request to your webmaster to have more categories added.</span></label></div>
						<div class="small-12 medium-7 end columns">
							<select name="type">
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
						</div>
				</div>
				<div class="row medium-collapse" style="padding-left: 30px;">
						<div class="small-12 medium-5 columns"><label for="name" class="middle">Business Name</label></div>
						<div class="small-12 medium-7 end columns"><input name="name" placeholder="McDonalds" maxlength="100" class="form" type="text" value="<?php echo "{$row['name']}"; ?>" required></div>
				</div>
				<div class="row medium-collapse" style="padding-left: 30px;">
						<div class="small-12 medium-5 columns"><label for="address" class="middle">Business Address</label></div>
						<div class="small-12 medium-7 end columns"><input name="address" placeholder="123 Any St, Seattle WA 98101" maxlength="150" class="form" type="text" value="<?php echo "{$row['address']}"; ?>"></div>
				</div>
				<div class="row medium-collapse" style="padding-left: 30px;">
							<div class="small-12 medium-5 columns"><label for="phone" class="middle">Business Phone</label></div>
							<div class="small-12 medium-7 end columns"><input name="phone" placeholder="(206) 555-1212" maxlength="100" class="form" type="tel" value="<?php echo "{$row['phone']}"; ?>"></div>
					</div>
				<div class="row medium-collapse" style="padding-left: 30px;">
						<div class="small-12 medium-5 columns"><label for="email" class="middle">Business Email</label></div>
						<div class="small-12 medium-7 end columns"><input name="email" placeholder="burger@mcdonalds.com" maxlength="100" class="form" type="email" value="<?php echo "{$row['email']}"; ?>"></div>
				</div>
				<div class="row medium-collapse" style="padding-left: 30px;">
						<div class="small-12 medium-5 columns"><label for="url" class="middle">Business  Website</label></div>
						<div class="small-12 medium-7 end columns"><input name="url" placeholder="http://www.mcdonalds.com" maxlength="100" class="form" type="url" value="<?php echo "{$row['url']}"; ?>"></div>
				</div>
				<div class="row medium-collapse" style="padding-left: 30px;">
						<div class="small-12 medium-5 columns"><label for="directions" class="middle">Map Directions URL</label></div>
						<div class="small-12 medium-7 end columns"><input name="directions" placeholder="Paste directions URL from Google Maps" maxlength="100" class="form" type="url" value="<?php echo "{$row['directions']}"; ?>"></div>
				</div>
<?php include('docid-field-edit.php'); ?>
		</div>
		<div class="small-12 medium-12 large-6 columns">
				<div class="row" style="padding: 10px 10px 10px 0px;">
						<div class="small-12 medium-12 columns"><strong>3) Approval and Comments</strong></div>
				</div>
				<div class="row medium-collapse" style="padding-left: 30px; padding-bottom: 20px;">
						<div class="small-12 medium-12 columns"><label for="comments" class="middle">Comments&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Comments ARE visible to the user.</span></label>
							<textarea name="comments" id="editor1" cols="40" rows="7"><?php echo "{$row['comments']}"; ?></textarea>
							<script>CKEDITOR.replace( 'editor1' );</script>
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
            <div class="small-12 medium-12 columns"><strong>4) Ready to Save?</strong></div>
        </div>
        <div class="row medium-collapse">
            <div class="small-6 columns" align="center">
							<input type="hidden" name="action" value="save">
							<input type="hidden" name="int1" value="<?php echo $_POST['int1']; ?>">
							<input name="submit" value="Save" class="submit" type="submit">
            </div>
</form>
            <div class="small-6 end columns" align="center">
							<form action="concierge.php" method="get">
							<input type="submit" value="Cancel" onclick="return confirm('Are you sure you wish to leave this page? Unsaved changes will be lost.');">
							</form>
            </div>
        </div>
		</div>
</div>
<?php
	}
?>
<!-- END INPUT FORM -->
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Business Directory Edit Control Panel Page<br></div>
</body>
</html>
