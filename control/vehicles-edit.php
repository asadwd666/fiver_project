<?php $current_page = '19'; include('protect.php'); 

$id = $_POST["id"]; 
$action = $_POST["action"]; 
if ($action == "save"){

	$useripaddress = $_SERVER['REMOTE_ADDR'];
	$userid = $_POST["userid"];
	$owner = $_POST["owner"];
	$recipient = $_POST["recipient"];
	$make = htmlspecialchars($_POST['make'], ENT_QUOTES);
	$model = htmlspecialchars($_POST['model'], ENT_QUOTES);
	$color = $_POST["color"];
	$state = $_POST["state"];
	$license = htmlspecialchars($_POST['license'], ENT_QUOTES);
	$permit = htmlspecialchars($_POST['permit'], ENT_QUOTES);
	$space = htmlspecialchars($_POST['space'], ENT_QUOTES);
	$comments = htmlspecialchars($_POST['comments'], ENT_QUOTES);
	$approved = $_POST["approved"];

	$query = "UPDATE vehicles SET userid='$userid', owner='$owner', make='$make', model='$model', color='$color', state='$state', license='$license', permit='$permit', space='$space', comments='$comments', approved='$approved' WHERE `id`='$id' LIMIT 1";
	mysqli_query($conn,$query) or die('Error, update query failed');

	$useripaddress = $_SERVER['REMOTE_ADDR'];
	$userid = $_SESSION['id'];
	$id = $_POST['id'];
	$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('E', 'Vehicle', '$useripaddress', '$userid', '$id')";
	mysqli_query($conn,$query) or die('Error, updating log failed');

	header('Location: vehicles.php');
	
    $errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Your entry was added successfully.</strong></div>";
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
        <strong>Edit a Vehicle or Bicycle</strong>
</div>
<?php
	$query  = "SELECT * FROM vehicles WHERE `id`='$id' LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- UPLOAD FORM -->
<div class="cp-form-container">
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 0px 0px;">
<form enctype="multipart/form-data" method="POST" action="vehicles-edit.php">
            <div class="small-12 medium-12 columns"><strong>1) Who should this be registered to?</strong></div>
        </div>
        <div class="row medium-collapse" style="padding: 10px 10px 10px 30px;">
            <div class="small-12 medium-12 columns">
                <?php include('userid-field-edit.php'); ?><br>&nbsp;&nbsp;&nbsp;&nbsp;<i>Other</i> <input name="owner" maxlength="100" class="form" type="text" value="<?php echo "{$row['owner']}"; ?>">
            </div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>2) Vehicle Information</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="make" class="middle">Make</label></div>
            <div class="small-12 medium-7 end columns"><input name="make" value="<?php echo "{$row['make']}"; ?>" maxlength="100" class="form" type="text" required></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="model" class="middle"> Model<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red"> Enter B* if registering a bicycle.</span></label></div>
            <div class="small-12 medium-7 end columns"><input name="model" value="<?php echo "{$row['model']}"; ?>" maxlength="100" class="form" type="text" required></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="color" class="middle">Color</label></div>
            <div class="small-12 medium-7 end columns">
<select name="color">
<option value="<?php echo "{$row['color']}"; ?>"><?php echo "{$row['color']}"; ?></option>
<option value="Black">Black</option>
<option value="White">White</option>
<option value="Gray">Gray</option>
<option value="Silver">Silver</option>
<option value="Gold">Gold</option>
<option value="Tan">Tan</option>
<option value="Brown">Brown</option>
<option value="Blue">Blue</option>
<option value="Green">Green</option>
<option value="Orange">Orange</option>
<option value="Pink">Pink</option>
<option value="Red">Red</option>
<option value="Yellow">Yellow</option>
<option value="Violet">Violet</option>
</select>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="state" class="middle">Registered State</label></div>
            <div class="small-12 medium-7 end columns">
<select name="state">
<option value="<?php echo "{$row['state']}"; ?>"><?php echo "{$row['state']}"; ?></option>
<option value="" disabled>
<option value="" disabled>***US &amp; Canada***</option>
<option value="AL">Alabama (AL)</option>
<option value="AB">Alberta (AB)</option>
<option value="AK">Alaska (AL)</option>
<option value="AZ">Arizona (AZ)</option>
<option value="AR">Arkansas (AR)</option>
<option value="BC">British Columbia (BC)</option>
<option value="CA">California (CA)</option>
<option value="CO">Colorado (CO)</option>
<option value="CT">Connecticut (CT)</option>
<option value="DE">Delaware (DE)</option>
<option value="FL">Florida (FL)</option>
<option value="GA">Georgia (GA)</option>
<option value="HI">Hawaii (HI)</option>
<option value="ID">Idaho (ID)</option>
<option value="IL">Illinois (IL)</option>
<option value="IN">Indiana (IN)</option>
<option value="IA">Iowa (IA)</option>
<option value="KS">Kansas (KS)</option>
<option value="KY">Kentucky (KY)</option>
<option value="LA">Louisiana (LA)</option>
<option value="ME">Maine (ME)</option>
<option value="MB">Manitoba (MB)</option>
<option value="MD">Maryland (MD)</option>
<option value="MA">Massachusetts (MA)</option>
<option value="MI">Michigan (MI)</option>
<option value="MN">Minnesota (MN)</option>
<option value="MS">Mississippi (MS)</option>
<option value="MO">Missouri (MO)</option>
<option value="MT">Montana (MT)</option>
<option value="NE">Nebraska (NE)</option>
<option value="NV">Nevada (NV)</option>
<option value="NB">New Brunswick (NB)</option>
<option value="NH">New Hampshire (NH)</option>
<option value="NJ">New Jersey (NJ)</option>
<option value="NM">New Mexico (NM)</option>
<option value="NY">New York (NY)</option>
<option value="NL">Newfoundland and Labrador (NL)</option>
<option value="NC">North Carolina (NC)</option>
<option value="ND">North Dakota (ND)</option>
<option value="NS">Nova Scotia (NS)</option>
<option value="NT">Northwest Territories (NT)</option>
<option value="NU">Nunavut (NU)</option>
<option value="OH">Ohio (OH)</option>
<option value="OK">Oklahoma (OK)</option>
<option value="ON">Ontario (ON)</option>
<option value="OR">Oregon (OR)</option>
<option value="PA">Pennsylvania (PA)</option>
<option value="PE">Prince Edward Island (PE)</option>
<option value="PR">Puerto Rico (PR)</option>
<option value="QC">Quebec (QU)</option>
<option value="RI">Rhode Island (RI)</option>
<option value="SK">Saskatchewan (SK)</option>
<option value="SC">South Carolina (SC)</option>
<option value="SD">South Dakota (SD)</option>
<option value="TN">Tennessee (TN)</option>
<option value="TX">Texas (TX)</option>
<option value="UT">Utah (UT)</option>
<option value="VI">US Virgin Islands (VI)</option>
<option value="VT">Vermont (VT)</option>
<option value="VA">Virginia (VA)</option>
<option value="WA">Washington (WA)</option>
<option value="WV">West Virginia (WV)</option>
<option value="WI">Wisconsin (WI)</option>
<option value="WY">Wyoming (WY)</option>
<option value="YT">Yukon (YT)</option>
<option value="" disabled></option>
<option value="" disabled>***Mexico***</option>
<option value="AGS">Aguascalientes (AGS)</option>
<option value="BCN">Baja California Norte (BCN)</option>
<option value="BCS">Baja California Sur (BCS)</option>
<option value="CAM">Campeche (CAM)</option>
<option value="CHIS">Chiapas (CHIS)</option>
<option value="CHIH">Chihuahua (CHIH)</option>
<option value="COAH">Coahuila (COAH)</option>
<option value="COL">Colima (COL)</option>
<option value="DF">Distrito Federal (DF)</option>
<option value="DGO">Durango (DGO)</option>
<option value="GTO">Guanajuato (GTO)</option>
<option value="GRO">Guerrero (GRO)</option>
<option value="HGO">Hidalgo (HGO)</option>
<option value="JAL">Jalisco (JAL)</option>
<option value="EDM">M&#233;xico - Estado de (EDM)</option>
<option value="MICH">Michoac&#225;n (MICH)</option>
<option value="MOR">Morelos (MOR)</option>
<option value="NAY">Nayarit (NAY)</option>
<option value="NL">Nuevo Le&#243;n (NL)</option>
<option value="OAX">Oaxaca (OAX)</option>
<option value="PUE">Puebla (PUE)</option>
<option value="QRO">Quer&#233;taro (QRO)</option>
<option value="QROO">Quintana Roo (QROO)</option>
<option value="SLP">San Luis Potos&#237; (SLP)</option>
<option value="SIN">Sinaloa (SIN)</option>
<option value="SON">Sonora (SON)</option>
<option value="TAB">Tabasco (TAB)</option>
<option value="TAMPS">Tamaulipas (TAMPS)</option>
<option value="TLAX">Tlaxcala (TLAX)</option>
<option value="VER">Veracruz (VER)</option>
<option value="YUC">Yucat&#225;n (YUC)</option>
<option value="ZAC">Zacatecas (ZAC)</option>
</select>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="license" class="middle">License Plate</label></div>
            <div class="small-12 medium-7 end columns"><input name="license" value="<?php echo "{$row['license']}"; ?>" maxlength="100" class="form" type="text"></div>
        </div>
    </div>
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>3) Parking Information</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="permit" class="middle">Community Issued Permit Number</label></div>
            <div class="small-12 medium-7 end columns"><input name="permit" maxlength="20" class="form" type="text" value="<?php echo "{$row['permit']}"; ?>"></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="space" class="middle">Community Parking Space</label></div>
            <div class="small-12 medium-7 end columns"><input name="space" maxlength="20" class="form" type="text" value="<?php echo "{$row['space']}"; ?>"></div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>4) Approval and Comments</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 columns"><label for="comments" class="middle">Comments&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Comments are NOT visible to the user.</span></label>
                <textarea name="comments" class="form" type="text" placeholder="Comments"><?php echo "{$row['comments']}"; ?></textarea>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px; <?php if ($row['approved'] == 'N'){ ?>background-color: #ffcccc; padding-top: 10px; margin-right: -10px; padding-right: 10px; <?php }; ?>">
            <div class="small-12 medium-5 columns"><label for="approved" class="middle">Is this vehicle/bicycle approved?</label></div>
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
<input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
<input name="submit" value="Save Changes" class="submit" type="submit" onclick="value='Processing Request - Resubmit'; style='color:red';" />
            </div>
</form>
            <div class="small-6 end columns" align="center">
<form action="vehicles.php" method="get">
<input type="submit" value="Cancel and Go Back" onclick="return confirm('Are you sure you wish to leave this page? Unsaved changes will be lost.');">
</form>
            </div>
        </div>
    </div>
</div>
<!-- END UPLOAD FORM -->
<?php
	}
?>
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Vehicles Edit Control Panel Page<br></div>
</body>
</html>
