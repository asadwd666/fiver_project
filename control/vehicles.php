<?php $current_page = '19'; include('protect.php');

$success = "untried"; 
$action = $_POST['action'];
$email = "";
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
<?php $id = $_POST["id"]; $action = $_POST["action"]; if ($action != null){ ?>
<?php
	if ($action == "delete"){
		$query = "DELETE FROM vehicles WHERE `id`='$id'";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
		
    		$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Your entry was deleted successfully.</strong></div>";

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('D', 'Vehicle', '$useripaddress', '$userid', '$id')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

		$query = "OPTIMIZE TABLE `vehicles`";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

	}
	if ($action == "add"){

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_POST["userid"];
		$owner = $_POST["owner"];
		$make = htmlspecialchars($_POST['make'], ENT_QUOTES);
		$model = htmlspecialchars($_POST['model'], ENT_QUOTES);
		$color = $_POST["color"];
		$state = $_POST["state"];
		$license = htmlspecialchars($_POST['license'], ENT_QUOTES);
		$permit = htmlspecialchars($_POST['permit'], ENT_QUOTES);
		$space = htmlspecialchars($_POST['space'], ENT_QUOTES);
		$comments = htmlspecialchars($_POST['comments'], ENT_QUOTES);
		$approved = $_POST["approved"];
		
		$query = "INSERT INTO vehicles (useripaddress, userid, owner, make, model, color, state, license, permit, space, comments, approved) VALUES ('$useripaddress', '$userid', '$owner', '$make', '$model', '$color', '$state', '$license', '$permit', '$space', '$comments', '$approved')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

        $errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Your entry was added successfully.</strong></div>";
	}
}
?>
<!-- HEALTH AND HELP -->
<div>
    <div class="large-8 columns" style="padding: 0px">
        <div class="nav-section-header-health-cp" align="center">
<big><i class="fa fa-stethoscope" aria-hidden="true"></i></big><strong>&nbsp;Health&nbsp;&nbsp;&nbsp;</strong>
<?php $sqlCAR = mysqli_query($conn,"SELECT count(*) FROM vehicles WHERE approved != 'Y'") or die(mysqli_error($conn));
//$countCAR = mysql_result($sqlCAR, "0");
$row = mysqli_fetch_row($sqlCAR);
$countCAR = $row[0];
?>
<?php if ($countCAR != '0'){ ?><i class="fa fa-exclamation-triangle note" aria-hidden="true"></i> You have <?php print($countCAR); ?> Vehicles/Bicycles pending your approval!<?php }; ?>
<?php if ($countCAR == '0'){ ?><i class="fa fa-check" aria-hidden="true"></i> Things are looking good!<?php }; ?>
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
        <p>This is where you can register and manage vehicles and bicycles. Users can submit their own vehicles and bicycles by clicking the link within the Vehicle Directory module or by using an eForm.</p>
    </div>
    <div class="small-12 medium-6 columns">
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#modulepermissions"><b>Module Permissions</b></a> allow you to choose to enable this module and to which groups of users.</p>
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#add"><b>Add a Vehicle or Bicycle</b></a> using the addition form below.</p>
        <?php if ($countCAR != '0'){ ?><p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#pending"><b>Approve a pending vehicle or bicycle</b></a> added by a user.</p><?php }; ?>
        <p><i class="fa fa-hand-o-down" aria-hidden="true"></i> <a href="#edit"><b>View and Edit</b></a> existing entries in your database.</p>
    </div>
</div>

<?php $sqlU2 = mysqli_query($conn,"SELECT count(*) FROM users WHERE unit2 != 'X'") or die(mysqli_error($conn));
//$countU2 = mysql_result($sqlU2, "0");
$row = mysqli_fetch_row($sqlU2);
$countU2 = $row[0];
?>
<div style="max-width: 99%;">
<!-- MODULE PERMISSIONS -->
<a name="modulepermissions"></a>
<div class="nav-section-header-cp">
    <strong>Module Permissions</strong>
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
	$module = "vehicles.php";
	$query  = "SELECT * FROM tabs WHERE liaison = 'Y' AND `int1` = '237' ORDER BY `int1`";
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
    <tfoot>
        <tr>
            <td colspan="9" align="left">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Be sure to check your association and state&apos;s covenants before enabling this module!<br></span>
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">If you would like this module accessible only to your board, contact your Webmaster.</span>
            </td>
        </tr>
    </tfoot>
</table>
<!-- UPLOAD FORM -->
<a name="add"></a>
<br>
<div class="nav-section-header-cp">
        <strong>Register a Vehicle or Bicycle</strong>
</div>
<?php echo($errorSUCCESS); ?>
<form enctype="multipart/form-data" method="POST" action="vehicles.php">
<div class="cp-form-container">
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 0px 0px;">
            <div class="small-12 medium-12 columns"><strong>1) Who should this be registered to?</strong></div>
        </div>
        <div class="row medium-collapse" style="padding: 10px 10px 10px 30px;">
            <div class="small-12 medium-12 columns">
                <?php include('userid-field.php'); ?><br>&nbsp;&nbsp;&nbsp;&nbsp;<i>Other</i> <input name="owner" maxlength="100" class="form" type="text" >
            </div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>2) Vehicle Information</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="make" class="middle">Make</label></div>
            <div class="small-12 medium-7 end columns"><input name="make" placeholder="Ford" maxlength="100" class="form" type="text" required></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="model" class="middle"> Model<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red"> Enter B* if registering a bicycle.</span></label></div>
            <div class="small-12 medium-7 end columns"><input name="model" placeholder="Model T" maxlength="100" class="form" type="text" required></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="color" class="middle">Color</label></div>
            <div class="small-12 medium-7 end columns">
<select name="color">
<option value="">Select Color</option>
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
<option value="">Select State</option>
<option value="" disabled></option>
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
            <div class="small-12 medium-7 end columns"><input name="license" placeholder="ABC-123" maxlength="100" class="form" type="text"></div>
        </div>
    </div>
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>3) Parking Information</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="permit" class="middle">Community Issued Permit Number</label></div>
            <div class="small-12 medium-7 end columns"><input name="permit" maxlength="20" class="form" type="text"></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="space" class="middle">Community Parking Space</label></div>
            <div class="small-12 medium-7 end columns"><input name="space" maxlength="20" class="form" type="text"></div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>4) Approval and Comments</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 columns"><label for="comments" class="middle">Comments&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Comments are NOT visible to the user.</span></label>
                <textarea name="comments" class="form" type="text" placeholder="Comments"></textarea>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="approved" class="middle">Is this vehicle/bicycle approved?</label></div>
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
	            <input name="submit" value="Submit" class="submit" type="submit" onclick="value='Processing Request - Resubmit'; style='color:red';" />
                <?php echo($error); ?>
            </div>
        </div>
        <div class="row medium-collapse">
            <div class="small-12 medium-12 columns" align="center">
<br><i class="fa fa-hand-o-down" aria-hidden="true"></i> Scroll down to see the vehicles and bicycles already added.
            </div>
        </div>
    </div>
</div>
</form>
<!-- END UPLOAD FORM -->
<a name="pending"></a>
<br>
<div class="nav-section-header-cp" style="background-color: #990000;">
        <strong><?php $sql = mysqli_query($conn,"SELECT count(*) FROM vehicles WHERE approved != 'Y' AND model != 'B*'") or die(mysqli_error($conn));
        //$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Vehicles Pending Approval</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr align="left">
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>User</small></th>
<?php $sqlU1 = mysqli_query($conn,"SELECT count(*) FROM users WHERE `unit` NOT BETWEEN '0' AND '999999'");
//$countU1 = mysql_result($sqlU1, "0");
$row = mysqli_fetch_row($sqlU1);
$countU1 = $row[0];
?>
      <th <?php if ($countU1 == '0'){ ?>class="table-sortable:numeric"<?php }; ?><?php if ($countU1 !== '0'){ ?>class="table-sortable:alphanumeric"<?php }; ?>><small>&nbsp;&nbsp;&nbsp; Unit</small></th>
<?php if ($countU2 != '0'){ ?>
      <th class="table-sortable:alphanumeric table-filterable">&nbsp;</th>
<?php }; ?>
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Space</small></th>
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>License</small></th>
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Permit</small></th>
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Make/Model</small></th>
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Color</small></th>
    </tr>
  </thead>
  <tbody style="background-color:#ffffff">
<!-- DATABASE RESULTS -->
<?php
	$query  = "SELECT * FROM vehicles WHERE approved != 'Y' AND model != 'B*' ORDER BY space";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
    <tr>
      <td>
        <div class="small-12 medium-12 large-8 columns">
<?php if ($row['userid'] !== '0'){ ?>
<?php
	$type    = $row['userid'];
	$query1  = "SELECT `id`, unit, unit2, last_name, first_name, email, phone FROM users WHERE id = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?>
<b><?php echo "{$row1['last_name']}"; ?>, <?php echo "{$row1['first_name']}"; ?></b>
<br><a href="mailto:<?php echo "{$row1['email']}"; ?>"><?php echo "{$row1['email']}"; ?></a>
<br><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row1['phone']); ?>"><?php echo "{$row1['phone']}"; ?></a>
<?php
	}
?>
<?php }; ?>
<?php if ($row['comments'] !== ''){ ?><span class="note-black"><?php if ($row['userid'] !== '0'){ ?><br><br><?php }; ?><?php echo "{$row['comments']}"; ?></span><?php }; ?>
        </div>
        <div class="small-6 medium-6 large-2 columns">
        	<form name="VehicleEdit" method="POST" action="vehicles-edit.php">
	            <input type="hidden" name="action" value="edit">
            	<input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
	            <input name="submit" value="Edit" class="submit" type="submit">
        	</form>
        </div>
        <div class="small-6 medium-6 large-2 columns">
	        <form name="VehicleDelete" method="POST" action="vehicles.php" onclick="return confirm('Are you sure you want to delete this <?php echo "{$row['make']}"; ?>?');">
	            <input type="hidden" name="action" value="delete">
	            <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
	            <input name="submit" value="Delete" class="submit" type="submit">
	        </form>
        </div>
      </td>
      <td>
<?php if ($row['userid'] !== '0'){ ?>
<?php
	$type    = $row['userid'];
	$query1  = "SELECT `id`, unit, unit2, last_name, first_name, email, phone FROM users WHERE id = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?>
      <b><?php echo "{$row1['unit']}"; ?></b>
<?php
	}
?>
<?php }; ?>
      </td>
<?php if ($countU2 != '0'){ ?>
      <td>
<?php
	$type    = $row['userid'];
	$query1  = "SELECT `id`, unit, unit2, last_name, first_name, email, phone FROM users WHERE id = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?>
      <?php if ($row1['unit2'] !== 'X'){ ?><?php echo "{$row1['unit2']}"; ?><?php }; ?>
<?php
	}
?>
      </td>
<?php }; ?>
      <td><?php echo "{$row['space']}"; ?></td>
      <td><?php echo "{$row['state']}"; ?> <span style="text-transform: uppercase"><?php echo "{$row['license']}"; ?></span></td>
      <td><span style="text-transform: uppercase"><?php echo "{$row['permit']}"; ?></span></td>
      <td><?php echo "{$row['make']}"; ?><br><?php echo "{$row['model']}"; ?></td>
      <td><?php echo "{$row['color']}"; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
  </tbody>
</table>
<br>
<div class="nav-section-header-cp" style="background-color: #990000;">
        <strong><?php $sql = mysqli_query($conn,"SELECT count(*) FROM vehicles WHERE approved != 'Y' AND model = 'B*'") or die(mysqli_error($conn));
        //$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Bicycles Pending Approval</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr align="left">
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>User</small></th>
<?php $sqlU1 = mysqli_query($conn,"SELECT count(*) FROM users WHERE `unit` NOT BETWEEN '0' AND '999999'");
//$countU1 = mysql_result($sqlU1, "0");
$row = mysqli_fetch_row($sqlU1);
$countU1 = $row[0];
?>
      <th <?php if ($countU1 == '0'){ ?>class="table-sortable:numeric"<?php }; ?><?php if ($countU1 !== '0'){ ?>class="table-sortable:alphanumeric"<?php }; ?>><small>&nbsp;&nbsp;&nbsp; Unit</small></th>
<?php if ($countU2 != '0'){ ?>
      <th class="table-sortable:alphanumeric table-filterable">&nbsp;</th>
<?php }; ?>
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Space</small></th>
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>License</small></th>
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Permit</small></th>
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Make</small></th>
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Color</small></th>
    </tr>
  </thead>
  <tbody style="background-color:#ffffff">
<!-- DATABASE RESULTS -->
<?php
	$query  = "SELECT * FROM vehicles WHERE approved != 'Y' AND model = 'B*' ORDER BY space";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
    <tr>
      <td>
        <div class="small-12 medium-12 large-8 columns">
<?php if ($row['userid'] == '0'){ ?><b><?php echo "{$row['owner']}"; ?><?php }; ?>
<?php if ($row['userid'] !== '0'){ ?>
<?php
	$type    = $row['userid'];
	$query1  = "SELECT `id`, unit, unit2, last_name, first_name, email, phone FROM users WHERE id = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?>
<b><?php echo "{$row1['last_name']}"; ?>, <?php echo "{$row1['first_name']}"; ?></b>
<br><a href="mailto:<?php echo "{$row1['email']}"; ?>"><?php echo "{$row1['email']}"; ?></a>
<br><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row1['phone']); ?>"><?php echo "{$row1['phone']}"; ?></a>
<?php
	}
?>
<?php }; ?>
<?php if ($row['comments'] !== ''){ ?><span class="note-black"><?php if ($row['userid'] !== '0'){ ?><br><br><?php }; ?><?php echo "{$row['comments']}"; ?></span><?php }; ?>
        </div>
        <div class="small-6 medium-6 large-2 columns">
        	<form name="VehicleEdit" method="POST" action="vehicles-edit.php">
	            <input type="hidden" name="action" value="edit">
            	<input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
	            <input name="submit" value="Edit" class="submit" type="submit">
        	</form>
        </div>
        <div class="small-6 medium-6 large-2 columns">
	        <form name="VehicleDelete" method="POST" action="vehicles.php" onclick="return confirm('Are you sure you want to delete this <?php echo "{$row['make']}"; ?>?');">
	            <input type="hidden" name="action" value="delete">
	            <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
	            <input name="submit" value="Delete" class="submit" type="submit">
	        </form>
        </div>
      </td>
      <td>
<?php if ($row['userid'] !== '0'){ ?>
<?php
	$type    = $row['userid'];
	$query1  = "SELECT `id`, unit, unit2, last_name, first_name, email, phone FROM users WHERE id = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?>
      <b><?php echo "{$row1['unit']}"; ?></b>
<?php
	}
?>
<?php }; ?>
      </td>
<?php if ($countU2 != '0'){ ?>
      <td>
<?php
	$type    = $row['userid'];
	$query1  = "SELECT `id`, unit, unit2, last_name, first_name, email, phone FROM users WHERE id = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?>
      <?php if ($row1['unit2'] !== 'X'){ ?><?php echo "{$row1['unit2']}"; ?><?php }; ?>
<?php
	}
?>
      </td>
<?php }; ?>
      <td><?php echo "{$row['space']}"; ?></td>
      <td><?php echo "{$row['state']}"; ?> <span style="text-transform: uppercase"><?php echo "{$row['license']}"; ?></span></td>
      <td><span style="text-transform: uppercase"><?php echo "{$row['permit']}"; ?></span></td>
      <td><?php echo "{$row['make']}"; ?></td>
      <td><?php echo "{$row['color']}"; ?></td>
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
        <strong><?php $sql = mysqli_query($conn,"SELECT count(*) FROM vehicles WHERE approved = 'Y'AND model != 'B*' ") or die(mysqli_error($conn));
        //$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Approved Vehicles</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr>
        <th colspan="8">
            <i class="fa fa-hand-o-right" aria-hidden="true"></i> <a href="reports/csv-vehicles.php?model=B*" title="Download this group of vehicles in Comma Separated format."><u>Download</u> this group of vehicles in CSV format.</a>
        </th>
    </tr>
    <tr align="left">
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>User</small></th>
<?php $sqlU1 = mysqli_query($conn,"SELECT count(*) FROM users WHERE `unit` NOT BETWEEN '0' AND '999999'");
//$countU1 = mysql_result($sqlU1, "0");
$row = mysqli_fetch_row($sqlU1);
$countU1 = $row[0];
?>
      <th <?php if ($countU1 == '0'){ ?>class="table-sortable:numeric"<?php }; ?><?php if ($countU1 !== '0'){ ?>class="table-sortable:alphanumeric"<?php }; ?>><small>&nbsp;&nbsp;&nbsp; Unit</small></th>
<?php if ($countU2 != '0'){ ?>
      <th class="table-sortable:alphanumeric table-filterable">&nbsp;</th>
<?php }; ?>
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Space</small></th>
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>License</small></th>
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Permit</small></th>
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Make/Model</small></th>
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Color</small></th>
    </tr>
  </thead>
  <tbody style="background-color:#ffffff">
<!-- DATABASE RESULTS -->
<?php
	$query  = "SELECT * FROM vehicles WHERE approved = 'Y' AND model != 'B*' ORDER BY space";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
    <tr>
      <td>
        <div class="small-12 medium-12 large-8 columns">
<?php if ($row['userid'] == '0'){ ?><b><?php echo "{$row['owner']}"; ?><?php }; ?>
<?php if ($row['userid'] !== '0'){ ?>
<?php
	$type    = $row['userid'];
	$query1  = "SELECT `id`, unit, unit2, last_name, first_name, email, phone FROM users WHERE id = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?>
<b><?php echo "{$row1['last_name']}"; ?>, <?php echo "{$row1['first_name']}"; ?></b>
<br><a href="mailto:<?php echo "{$row1['email']}"; ?>"><?php echo "{$row1['email']}"; ?></a>
<br><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row1['phone']); ?>"><?php echo "{$row1['phone']}"; ?></a>
<?php
	}
?>
<?php }; ?>
<?php if ($row['comments'] !== ''){ ?><span class="note-black"><?php if ($row['userid'] !== '0'){ ?><br><br><?php }; ?><?php echo "{$row['comments']}"; ?></span><?php }; ?>
        </div>
        <div class="small-6 medium-6 large-2 columns">
        	<form name="VehicleEdit" method="POST" action="vehicles-edit.php">
	            <input type="hidden" name="action" value="edit">
            	<input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
	            <input name="submit" value="Edit" class="submit" type="submit">
        	</form>
        </div>
        <div class="small-6 medium-6 large-2 columns">
	        <form name="VehicleDelete" method="POST" action="vehicles.php" onclick="return confirm('Are you sure you want to delete this <?php echo "{$row['make']}"; ?>?');">
	            <input type="hidden" name="action" value="delete">
	            <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
	            <input name="submit" value="Delete" class="submit" type="submit">
	        </form>
        </div>
      </td>
      <td>
<?php if ($row['userid'] !== '0'){ ?>
<?php
	$type    = $row['userid'];
	$query1  = "SELECT `id`, unit, unit2, last_name, first_name, email, phone FROM users WHERE id = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?>
      <b><?php echo "{$row1['unit']}"; ?></b>
<?php
	}
?>
<?php }; ?>
      </td>
<?php if ($countU2 != '0'){ ?>
      <td>
<?php
	$type    = $row['userid'];
	$query1  = "SELECT `id`, unit, unit2, last_name, first_name, email, phone FROM users WHERE id = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?>
      <?php if ($row1['unit2'] !== 'X'){ ?><?php echo "{$row1['unit2']}"; ?><?php }; ?>
<?php
	}
?>
      </td>
<?php }; ?>
      <td><?php echo "{$row['space']}"; ?></td>
      <td><?php echo "{$row['state']}"; ?> <span style="text-transform: uppercase"><?php echo "{$row['license']}"; ?></span></td>
      <td><span style="text-transform: uppercase"><?php echo "{$row['permit']}"; ?></span></td>
      <td><?php echo "{$row['make']}"; ?><br><?php echo "{$row['model']}"; ?></td>
      <td><?php echo "{$row['color']}"; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
  </tbody>
</table>
<br>
<div class="nav-section-header-cp">
        <strong><?php $sql = mysqli_query($conn,"SELECT count(*) FROM vehicles WHERE approved = 'Y' AND model = 'B*'") or die(mysqli_error($conn));
        //$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Approved Bicycles</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr>
        <th colspan="8">
            <i class="fa fa-hand-o-right" aria-hidden="true"></i> <a href="reports/csv-bicycles.php?model=B*" title="Download all users in this group in Comma Separated format."><u>Download</u> this group of users in CSV format.</a>
        </th>
    </tr>
    <tr align="left">
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>User</small></th>
<?php $sqlU1 = mysqli_query($conn,"SELECT count(*) FROM users WHERE `unit` NOT BETWEEN '0' AND '999999'");
//$countU1 = mysql_result($sqlU1, "0");
$row = mysqli_fetch_row($sqlU1);
$countU1 = $row[0];
?>
      <th <?php if ($countU1 == '0'){ ?>class="table-sortable:numeric"<?php }; ?><?php if ($countU1 !== '0'){ ?>class="table-sortable:alphanumeric"<?php }; ?>><small>&nbsp;&nbsp;&nbsp; Unit</small></th>
<?php if ($countU2 != '0'){ ?>
      <th class="table-sortable:alphanumeric table-filterable">&nbsp;</th>
<?php }; ?>
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Space</small></th>
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>License</small></th>
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Permit</small></th>
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Make</small></th>
      <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Color</small></th>
    </tr>
  </thead>
  <tbody style="background-color:#ffffff">
<!-- DATABASE RESULTS -->
<?php
	$query  = "SELECT * FROM vehicles WHERE approved = 'Y' AND model = 'B*' ORDER BY space";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
    <tr>
      <td>
        <div class="small-12 medium-12 large-8 columns">
<?php if ($row['userid'] == '0'){ ?><b><?php echo "{$row['owner']}"; ?><?php }; ?>
<?php if ($row['userid'] !== '0'){ ?>
<?php
	$type    = $row['userid'];
	$query1  = "SELECT `id`, unit, unit2, last_name, first_name, email, phone FROM users WHERE id = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?>
<b><?php echo "{$row1['last_name']}"; ?>, <?php echo "{$row1['first_name']}"; ?></b>
<br><a href="mailto:<?php echo "{$row1['email']}"; ?>"><?php echo "{$row1['email']}"; ?></a>
<br><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row1['phone']); ?>"><?php echo "{$row1['phone']}"; ?></a>
<?php
	}
?>
<?php }; ?>
<?php if ($row['comments'] !== ''){ ?><span class="note-black"><?php if ($row['userid'] !== '0'){ ?><br><br><?php }; ?><?php echo "{$row['comments']}"; ?></span><?php }; ?>
        </div>
        <div class="small-6 medium-6 large-2 columns">
        	<form name="VehicleEdit" method="POST" action="vehicles-edit.php">
	            <input type="hidden" name="action" value="edit">
            	<input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
	            <input name="submit" value="Edit" class="submit" type="submit">
        	</form>
        </div>
        <div class="small-6 medium-6 large-2 columns">
	        <form name="VehicleDelete" method="POST" action="vehicles.php" onclick="return confirm('Are you sure you want to delete this <?php echo "{$row['make']}"; ?>?');">
	            <input type="hidden" name="action" value="delete">
	            <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
	            <input name="submit" value="Delete" class="submit" type="submit">
	        </form>
        </div>
      </td>
      <td>
<?php if ($row['userid'] !== '0'){ ?>
<?php
	$type    = $row['userid'];
	$query1  = "SELECT `id`, unit, unit2, last_name, first_name, email, phone FROM users WHERE id = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?>
      <b><?php echo "{$row1['unit']}"; ?></b>
<?php
	}
?>
<?php }; ?>
      </td>
<?php if ($countU2 != '0'){ ?>
      <td>
<?php
	$type    = $row['userid'];
	$query1  = "SELECT `id`, unit, unit2, last_name, first_name, email, phone FROM users WHERE id = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?>
      <?php if ($row1['unit2'] !== 'X'){ ?><?php echo "{$row1['unit2']}"; ?><?php }; ?>
<?php
	}
?>
      </td>
<?php }; ?>
      <td><?php echo "{$row['space']}"; ?></td>
      <td><?php echo "{$row['state']}"; ?> <span style="text-transform: uppercase"><?php echo "{$row['license']}"; ?></span></td>
      <td><span style="text-transform: uppercase"><?php echo "{$row['permit']}"; ?></span></td>
      <td><?php echo "{$row['make']}"; ?></td>
      <td><?php echo "{$row['color']}"; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
  </tbody>
</table>
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Vehicles Control Panel Page<br></div>
</body>
</html>
