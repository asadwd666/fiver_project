<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '/home/nodyss5/php/PHPMailer-6.3.0/src/PHPMailer.php';
require '/home/nodyss5/php/PHPMailer-6.3.0/src/SMTP.php';
require '/home/nodyss5/php/PHPMailer-6.3.0/src/Exception.php';
//require '/home/nodyss5/php/PHPMailer/PHPMailerAutoload.php';
require '../my-documents/smtp.php';

require_once('../my-documents/php7-my-db.php');

$id = $_POST["id"];
$action = $_POST["action"];
$success = "untried";

if ($action != null){

	if ($action == "add"){

		$first_name = $_SESSION['first_name'];
		$last_name = $_SESSION['last_name'];
		$useremail = $_SESSION['email'];
		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$make = mysqli_real_escape_string($conn, $_POST["make"]);
		$model = mysqli_real_escape_string($conn, $_POST["model"]);
		$color = mysqli_real_escape_string($conn, $_POST["color"]);
		$state = mysqli_real_escape_string($conn, $_POST["state"]);
		$license = mysqli_real_escape_string($conn, $_POST["license"]);
		$space = mysqli_real_escape_string($conn, $_POST["space"]);
		$userid = mysqli_real_escape_string($conn, $_POST["userid"]);

		if($space != "" OR $license != "" OR $state != "" OR $color != "" OR $model != "" OR $make != ""){
		    
			$query = "INSERT INTO vehicles (userid, owner, make, model, color, state, license, space, useripaddress) VALUES ('$userid', '$owner', '$make', '$model', '$color', '$state', '$license', '$space', '$useripaddress')";
			mysqli_query($conn,$query) or die('Error, insert query failed');

			$reseturl = $_SESSION['reseturl'];
            $communityurl = $_SESSION['communityurl'];
            $fromname = "$CommunityName via CondoSites";

			$subject = "$CommunityName/CondoSites - Vehicle Registration";
		    
		    $body = "<!DOCTYPE HTML><html><body><div style='padding: 25px;'>";
            $body .= "<p>A website user has submitted a vehicle for registration through the ".$CommunityName."/CondoSites community website.  Your action is required.<br>To approve and edit this listing, access the Vehicles control panel.<br><br>Below is an overview of the information submitted by the user.<br><br>Make: ".$make."<br>Model: ".$model."<br>Color: ".$color."<br>State: ".$state."<br>License Plate: ".$license."<br>Space: ".$space."<br><br>Submitted by: ".$first_name." ".$last_name."<br>Email: ".$useremail."<br>User ID: ".$userid."<br>User IP Address: ".$useripaddress."</p>";
            $body .= "</div><br><img src='".$communityurl."/pics/logo-small.png' style='max-width: 100px;'><br><br>Visit your <a href='".$communityurl."'>".$CommunityName." community website</a>.</p>";
            $body .= "<p><b>Email Subscription</b><br><small>You are receiving this email because you are a registered user of the ".$CommunityName." community website, operated by <a href='https://condosites.com' target='_blank'>CondoSites</a>.";
            $body .= "<br><br><span style='color: darkred;'>DO NOT REPLY TO THIS EMAIL!</span> IT IS SENT FROM AN UNMONITORED ADDRESS.";
            $body .= "<br><br><b><a href='".$communityurl."/spamhelp.php'>Are these emails being treated as spam?</a></b></p></small></body></html>";

            $mail = new PHPMailer();

            $mail->isSMTP();
            $mail->Host = $hostOPS;
            $mail->SMTPAuth = $smtpauthOPS;
            $mail->SMTPKeepAlive = $smtpkeepaliveOPS;
            $mail->Port = $smtpportOPS;
            $mail->SMTPSecure = $smtpsecureOPS;
            $mail->SMTPAutoTLS = $smtpautotlsOPS;
            $mail->Username = $usernameOPS;
            $mail->Password = $passwordOPS;
            $mail->setFrom($fromemailOPS, 'CondoSites Database Submission eForm');
    
            $mail->addAddress($CLASSIFIEDS_EMAIL, $fromname);
            $mail->Subject = "$subject";
            $mail->Body = "$body";
            $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';

            if(!$mail->send()) {

            } else {
    		    header('Location: thanks.php');
            }
			
		} else {
			$error = "ALL fields are required.";
			$success = "false";
		}
	}
}
?>
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="CondoSites - http://www.condosites.com" name="author">
	<title>Form</title>
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	<script src="forcom.js" type="text/javascript"></script>
	<link rel="stylesheet" href="../css/foundation.css">
	<link rel="stylesheet" href="../css/jquery-ui.min.css">
	<link rel="stylesheet" href="../css/jquery-ui.structure.min.css">
	<link rel="stylesheet" href="../css/datepickercontrol.css">
	<link rel="stylesheet" href="../css/app.css">
	<link rel="stylesheet" href="../my-documents/app-custom.css">
</head>

<body>

<div class="stand-alone-page">
  <div class="popup-header">
<?php
	$query  = "SELECT title FROM tabs WHERE `int1` = '454'";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<h4><?php echo "{$row['title']}"; ?></h4>
<?php
	}
?>
</div>

<?php if (($_SESSION['owner'] != true) AND ($_SESSION['lease'] != true) AND ($_SESSION['realtor'] != true)){ ?>

  <div class="stand-alone-page-content">
    <div class="popup-subheader">
      <div class="row">
        <div class="small-12 columns text-center">
<blockquote>
<br><br><b>Please login to use this module.</b><br><br><br>
</blockquote>
        </div>
      </div>
    </div>

<?php }; ?>

<?php if (($_SESSION['owner'] == true) OR ($_SESSION['lease'] == true) OR ($_SESSION['realtor'] == true)){ ?>

  <div class="stand-alone-page-content">
    <div class="popup-subheader">
      <div class="row">
        <div class="small-12 columns text-center">
<blockquote>
<!-- TEXT 1 -->
<?php
	$query  = "SELECT text1 FROM forms WHERE `int1` = '454'";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php echo "{$row['text1']}"; ?>
<?php
	}
?>
<!-- END TEXT 1 -->
<br><b>All fields are required!</b><br>
</blockquote>
        </div>
      </div>
    </div>

    <div class="form-wrapper">

<form method="POST" action="" name="theform" id="theform" enctype="multipart/form-data">
<!-- FORM CONTENT -->

      <div class="row">
        <div class="small-12 columns text-center">
	<?php echo($error); ?>
	</div>
      </div>

<!-- FIELDS -->

      <div class="row medium-collapse">
        <div class="small-12 medium-5 large-4 columns"><label for="space" class="middle note-anchor">Parking Space</label></div>
        <div class="small-12 medium-5 end columns"><input name="space" type="text" size="5" maxlength="30" class="form" value="<?php echo($_POST['space']); ?>"></div>
      </div>
      <div class="row medium-collapse">
        <div class="small-12 medium-5 large-4 columns"><label for="make" class="middle note-anchor">Vehicle Make</label></div>
        <div class="small-12 medium-5 end columns"><input name="make" type="text" size="20" maxlength="30" class="form" value="<?php echo($_POST['make']); ?>"></div>
      </div>
      <div class="row medium-collapse">
        <div class="small-12 medium-5 large-4 columns"><label for="model" class="middle note-anchor">Vehicle Model</label></div>
        <div class="small-12 medium-5 end columns"><input name="model" type="text" size="20" maxlength="30" class="form" value="<?php echo($_POST['model']); ?>"></div>
      </div>
      <div class="row medium-collapse">
        <div class="small-12 medium-5 large-4 columns"><label for="color" class="middle note-anchor">Vehicle Color</label></div>
        <div class="small-12 medium-5 end columns">
	<select name="color">
<option value="">Select Color</option>
<option value="Black" <?php if($_POST['color'] == "Black"){ echo("SELECTED"); } ?>>Black</option>
<option value="White" <?php if($_POST['color'] == "White"){ echo("SELECTED"); } ?>>White</option>
<option value="Gray" <?php if($_POST['color'] == "Gray"){ echo("SELECTED"); } ?>>Gray</option>
<option value="Silver" <?php if($_POST['color'] == "Silver"){ echo("SELECTED"); } ?>>Silver</option>
<option value="Gold" <?php if($_POST['color'] == "Gold"){ echo("SELECTED"); } ?>>Gold</option>
<option value="Tan" <?php if($_POST['color'] == "Tan"){ echo("SELECTED"); } ?>>Tan</option>
<option value="Brown" <?php if($_POST['color'] == "Brown"){ echo("SELECTED"); } ?>>Brown</option>
<option value="Blue" <?php if($_POST['color'] == "Blue"){ echo("SELECTED"); } ?>>Blue</option>
<option value="Green" <?php if($_POST['color'] == "Green"){ echo("SELECTED"); } ?>>Green</option>
<option value="Orange" <?php if($_POST['color'] == "Orange"){ echo("SELECTED"); } ?>>Orange</option>
<option value="Red" <?php if($_POST['color'] == "Red"){ echo("SELECTED"); } ?>>Red</option>
<option value="Yellow" <?php if($_POST['color'] == "Yellow"){ echo("SELECTED"); } ?>>Yellow</option>
<option value="Violet" <?php if($_POST['color'] == "Violet"){ echo("SELECTED"); } ?>>Violet</option>
	</select>
        </div>
      </div>
      <div class="row medium-collapse">
        <div class="small-12 medium-5 large-4 columns"><label for="license" class="middle note-anchor">License Plate</label></div>
        <div class="small-12 medium-5 end columns"><input name="license" type="text" size="20" maxlength="10" class="form" value="<?php echo($_POST['license']); ?>"></div>
      </div>
      <div class="row medium-collapse">
        <div class="small-12 medium-5 large-4 columns"><label for="state" class="middle note-anchor">State</label></div>
        <div class="small-12 medium-5 end columns">
      	<select name="state">
<option value="">State</option>
<option value=""></option>
<option value="">--- US & Canada ---</option>
<option value="AL" <?php if($_POST['state'] == "AL"){ echo("SELECTED"); } ?>>Alabama (AL)</option>
<option value="AB" <?php if($_POST['state'] == "AB"){ echo("SELECTED"); } ?>>Alberta (AB)</option>
<option value="AK" <?php if($_POST['state'] == "AK"){ echo("SELECTED"); } ?>>Alaska (AL)</option>
<option value="AZ" <?php if($_POST['state'] == "AZ"){ echo("SELECTED"); } ?>>Arizona (AZ)</option>
<option value="AR" <?php if($_POST['state'] == "AR"){ echo("SELECTED"); } ?>>Arkansas (AR)</option>
<option value="BC" <?php if($_POST['state'] == "BC"){ echo("SELECTED"); } ?>>British Columbia (BC)</option>
<option value="CA" <?php if($_POST['state'] == "CA"){ echo("SELECTED"); } ?>>California (CA)</option>
<option value="CO" <?php if($_POST['state'] == "CO"){ echo("SELECTED"); } ?>>Colorado (CO)</option>
<option value="CT" <?php if($_POST['state'] == "CT"){ echo("SELECTED"); } ?>>Connecticut (CT)</option>
<option value="DE" <?php if($_POST['state'] == "DE"){ echo("SELECTED"); } ?>>Delaware (DE)</option>
<option value="FL" <?php if($_POST['state'] == "FL"){ echo("SELECTED"); } ?>>Florida (FL)</option>
<option value="GA" <?php if($_POST['state'] == "GA"){ echo("SELECTED"); } ?>>Georgia (GA)</option>
<option value="HI" <?php if($_POST['state'] == "HI"){ echo("SELECTED"); } ?>>Hawaii (HI)</option>
<option value="ID" <?php if($_POST['state'] == "ID"){ echo("SELECTED"); } ?>>Idaho (ID)</option>
<option value="IL" <?php if($_POST['state'] == "IL"){ echo("SELECTED"); } ?>>Illinois (IL)</option>
<option value="IN" <?php if($_POST['state'] == "IN"){ echo("SELECTED"); } ?>>Indiana (IN)</option>
<option value="IA" <?php if($_POST['state'] == "IA"){ echo("SELECTED"); } ?>>Iowa (IA)</option>
<option value="KS" <?php if($_POST['state'] == "KS"){ echo("SELECTED"); } ?>>Kansas (KS)</option>
<option value="KY" <?php if($_POST['state'] == "KY"){ echo("SELECTED"); } ?>>Kentucky (KY)</option>
<option value="LA" <?php if($_POST['state'] == "LA"){ echo("SELECTED"); } ?>>Louisiana (LA)</option>
<option value="ME" <?php if($_POST['state'] == "ME"){ echo("SELECTED"); } ?>>Maine (ME)</option>
<option value="MB" <?php if($_POST['state'] == "MB"){ echo("SELECTED"); } ?>>Manitoba (MB)</option>
<option value="MD" <?php if($_POST['state'] == "MD"){ echo("SELECTED"); } ?>>Maryland (MD)</option>
<option value="MA" <?php if($_POST['state'] == "MA"){ echo("SELECTED"); } ?>>Massachusetts (MA)</option>
<option value="MI" <?php if($_POST['state'] == "MI"){ echo("SELECTED"); } ?>>Michigan (MI)</option>
<option value="MN" <?php if($_POST['state'] == "MN"){ echo("SELECTED"); } ?>>Minnesota (MN)</option>
<option value="MS" <?php if($_POST['state'] == "MS"){ echo("SELECTED"); } ?>>Mississippi (MS)</option>
<option value="MO" <?php if($_POST['state'] == "MO"){ echo("SELECTED"); } ?>>Missouri (MO)</option>
<option value="MT" <?php if($_POST['state'] == "MT"){ echo("SELECTED"); } ?>>Montana (MT)</option>
<option value="NE" <?php if($_POST['state'] == "NE"){ echo("SELECTED"); } ?>>Nebraska (NE)</option>
<option value="NV" <?php if($_POST['state'] == "NV"){ echo("SELECTED"); } ?>>Nevada (NV)</option>
<option value="NB" <?php if($_POST['state'] == "NB"){ echo("SELECTED"); } ?>>New Brunswick (NB)</option>
<option value="NH" <?php if($_POST['state'] == "NH"){ echo("SELECTED"); } ?>>New Hampshire (NH)</option>
<option value="NJ" <?php if($_POST['state'] == "NJ"){ echo("SELECTED"); } ?>>New Jersey (NJ)</option>
<option value="NM" <?php if($_POST['state'] == "NM"){ echo("SELECTED"); } ?>>New Mexico (NM)</option>
<option value="NY" <?php if($_POST['state'] == "NY"){ echo("SELECTED"); } ?>>New York (NY)</option>
<option value="NL" <?php if($_POST['state'] == "NL"){ echo("SELECTED"); } ?>>Newfoundland and Labrador (NL)</option>
<option value="NC" <?php if($_POST['state'] == "NC"){ echo("SELECTED"); } ?>>North Carolina (NC)</option>
<option value="ND" <?php if($_POST['state'] == "ND"){ echo("SELECTED"); } ?>>North Dakota (ND)</option>
<option value="NS" <?php if($_POST['state'] == "NS"){ echo("SELECTED"); } ?>>Nova Scotia (NS)</option>
<option value="NT" <?php if($_POST['state'] == "NT"){ echo("SELECTED"); } ?>>Northwest Territories (NT)</option>
<option value="NU" <?php if($_POST['state'] == "NU"){ echo("SELECTED"); } ?>>Nunavut (NU)</option>
<option value="OH" <?php if($_POST['state'] == "OH"){ echo("SELECTED"); } ?>>Ohio (OH)</option>
<option value="OK" <?php if($_POST['state'] == "OK"){ echo("SELECTED"); } ?>>Oklahoma (OK)</option>
<option value="ON" <?php if($_POST['state'] == "ON"){ echo("SELECTED"); } ?>>Ontario (ON)</option>
<option value="OR" <?php if($_POST['state'] == "OR"){ echo("SELECTED"); } ?>>Oregon (OR)</option>
<option value="PA" <?php if($_POST['state'] == "PA"){ echo("SELECTED"); } ?>>Pennsylvania (PA)</option>
<option value="PE" <?php if($_POST['state'] == "PE"){ echo("SELECTED"); } ?>>Prince Edward Island (PE)</option>
<option value="PR" <?php if($_POST['state'] == "PR"){ echo("SELECTED"); } ?>>Puerto Rico (PR)</option>
<option value="QC" <?php if($_POST['state'] == "QC"){ echo("SELECTED"); } ?>>Quebec (QU)</option>
<option value="RI" <?php if($_POST['state'] == "RI"){ echo("SELECTED"); } ?>>Rhode Island (RI)</option>
<option value="SK" <?php if($_POST['state'] == "SK"){ echo("SELECTED"); } ?>>Saskatchewan (SK)</option>
<option value="SC" <?php if($_POST['state'] == "SC"){ echo("SELECTED"); } ?>>South Carolina (SC)</option>
<option value="SD" <?php if($_POST['state'] == "SD"){ echo("SELECTED"); } ?>>South Dakota (SD)</option>
<option value="TN" <?php if($_POST['state'] == "TN"){ echo("SELECTED"); } ?>>Tennessee (TN)</option>
<option value="TX" <?php if($_POST['state'] == "TX"){ echo("SELECTED"); } ?>>Texas (TX)</option>
<option value="UT" <?php if($_POST['state'] == "UT"){ echo("SELECTED"); } ?>>Utah (UT)</option>
<option value="VI" <?php if($_POST['state'] == "VI"){ echo("SELECTED"); } ?>>US Virgin Islands (VI)</option>
<option value="VT" <?php if($_POST['state'] == "VT"){ echo("SELECTED"); } ?>>Vermont (VT)</option>
<option value="VA" <?php if($_POST['state'] == "VA"){ echo("SELECTED"); } ?>>Virginia (VA)</option>
<option value="WA" <?php if($_POST['state'] == "WA"){ echo("SELECTED"); } ?>>Washington (WA)</option>
<option value="WV" <?php if($_POST['state'] == "WV"){ echo("SELECTED"); } ?>>West Virginia (WV)</option>
<option value="WI" <?php if($_POST['state'] == "WI"){ echo("SELECTED"); } ?>>Wisconsin (WI)</option>
<option value="WY" <?php if($_POST['state'] == "WY"){ echo("SELECTED"); } ?>>Wyoming (WY)</option>
<option value="YT" <?php if($_POST['state'] == "YT"){ echo("SELECTED"); } ?>>Yukon (YT)</option>
<option value=""></option>
<option value="">--- Mexico ---</option>
<option value="AGS" <?php if($_POST['state'] == "AGS"){ echo("SELECTED"); } ?>>Aguascalientes (AGS)</option>
<option value="BCN" <?php if($_POST['state'] == "BCN"){ echo("SELECTED"); } ?>>Baja California Norte (BCN)</option>
<option value="BCS" <?php if($_POST['state'] == "BVS"){ echo("SELECTED"); } ?>>Baja California Sur (BCS)</option>
<option value="CAM" <?php if($_POST['state'] == "CAM"){ echo("SELECTED"); } ?>>Campeche (CAM)</option>
<option value="CHIS" <?php if($_POST['state'] == "CHIS"){ echo("SELECTED"); } ?>>Chiapas (CHIS)</option>
<option value="CHIH" <?php if($_POST['state'] == "CHIH"){ echo("SELECTED"); } ?>>Chihuahua (CHIH)</option>
<option value="COAH" <?php if($_POST['state'] == "COAH"){ echo("SELECTED"); } ?>>Coahuila (COAH)</option>
<option value="COL" <?php if($_POST['state'] == "COL"){ echo("SELECTED"); } ?>>Colima (COL)</option>
<option value="DF" <?php if($_POST['state'] == "DF"){ echo("SELECTED"); } ?>>Distrito Federal (DF)</option>
<option value="DGO" <?php if($_POST['state'] == "DGO"){ echo("SELECTED"); } ?>>Durango (DGO)</option>
<option value="GTO" <?php if($_POST['state'] == "GTO"){ echo("SELECTED"); } ?>>Guanajuato (GTO)</option>
<option value="GRO" <?php if($_POST['state'] == "GRO"){ echo("SELECTED"); } ?>>Guerrero (GRO)</option>
<option value="HGO" <?php if($_POST['state'] == "HGO"){ echo("SELECTED"); } ?>>Hidalgo (HGO)</option>
<option value="JAL" <?php if($_POST['state'] == "JAL"){ echo("SELECTED"); } ?>>Jalisco (JAL)</option>
<option value="EDM" <?php if($_POST['state'] == "EDM"){ echo("SELECTED"); } ?>>M&#233;xico - Estado de (EDM)</option>
<option value="MICH" <?php if($_POST['state'] == "MICH"){ echo("SELECTED"); } ?>>Michoac&#225;n (MICH)</option>
<option value="MOR" <?php if($_POST['state'] == "MOR"){ echo("SELECTED"); } ?>>Morelos (MOR)</option>
<option value="NAY" <?php if($_POST['state'] == "NAY"){ echo("SELECTED"); } ?>>Nayarit (NAY)</option>
<option value="NL" <?php if($_POST['state'] == "NL"){ echo("SELECTED"); } ?>>Nuevo Le&#243;n (NL)</option>
<option value="OAX" <?php if($_POST['state'] == "OAX"){ echo("SELECTED"); } ?>>Oaxaca (OAX)</option>
<option value="PUE" <?php if($_POST['state'] == "PUE"){ echo("SELECTED"); } ?>>Puebla (PUE)</option>
<option value="QRO" <?php if($_POST['state'] == "QUO"){ echo("SELECTED"); } ?>>Quer&#233;taro (QRO)</option>
<option value="QROO" <?php if($_POST['state'] == "QROO"){ echo("SELECTED"); } ?>>Quintana Roo (QROO)</option>
<option value="SLP" <?php if($_POST['state'] == "SLP"){ echo("SELECTED"); } ?>>San Luis Potos&#237; (SLP)</option>
<option value="SIN" <?php if($_POST['state'] == "SIN"){ echo("SELECTED"); } ?>>Sinaloa (SIN)</option>
<option value="SON" <?php if($_POST['state'] == "SON"){ echo("SELECTED"); } ?>>Sonora (SON)</option>
<option value="TAB" <?php if($_POST['state'] == "TAB"){ echo("SELECTED"); } ?>>Tabasco (TAB)</option>
<option value="TAMPS" <?php if($_POST['state'] == "TAMPS"){ echo("SELECTED"); } ?>>Tamaulipas (TAMPS)</option>
<option value="TLAX" <?php if($_POST['state'] == "TLAX"){ echo("SELECTED"); } ?>>Tlaxcala (TLAX)</option>
<option value="VER" <?php if($_POST['state'] == "VER"){ echo("SELECTED"); } ?>>Veracruz (VER)</option>
<option value="YUC" <?php if($_POST['state'] == "YUC"){ echo("SELECTED"); } ?>>Yucat&#225;n (YUC)</option>
<option value="ZAC" <?php if($_POST['state'] == "ZAC"){ echo("SELECTED"); } ?>>Zacatecas (ZAC)</option>
	</select>
        </div>
      </div>

<!-- END FIELDS -->

    </div>

<!-- TERMS -->

<?php
	$query  = "SELECT terms FROM forms WHERE `int1` = '454' AND terms != ''";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
    <div class="popup-subheader">
      <div class="row">
        <div class="small-12 columns text-center"><br>Terms:<br><textarea readonly="readonly" name="terms" cols="45" rows="5" class="form" id="terms"><?php echo "{$row['terms']}"; ?></textarea></div>
      </div>
      <div class="row">
        <div class="small-12 columns text-center" style="background-color: #ffcccccc"><b>BY CLICKING &quot;SUBMIT&quot; BELOW YOU AGREE THAT YOU: have read the terms above, and agree to adhere those terms.</b></div>
      </div>
<?php
	}
?>

<!-- END TERMS -->

    <div class="popup-subheader">
      <div class="row">
        <div class="small-12 columns text-center">
	  <br>
	<input type="hidden" name="action" value="add">
	<input type="hidden" name="mode" value="mode" />
	<input type="submit" name="post_comment" id="post_comment" class="submit" value="Submit" onclick="document.theform.post_comment.disabled=true; document.theform.mode.name = 'post'; document.theform.submit();" />
	  <br>

<!-- USER -->
Submitted by: <?php echo($_SESSION['first_name']); ?> <?php echo($_SESSION['last_name']); ?><br><span class="note-red">IP Address: <?php echo($_SERVER['REMOTE_ADDR']); ?></span><br><input type=hidden name="userid" class="form" id="userid" value="<?php echo($_SESSION['id']); ?>">
<!-- END USER -->

        </div>
      </div>

<!-- END FORM CONTENT -->
</form>

    </div>
  </div>

    <div class="popup-subheader">
      <div class="row">
        <div class="small-12 columns text-center">
<blockquote>
<!-- TEXT 2 -->
<?php
	$type    = $_GET['choice'];
	$query  = "SELECT text2 FROM forms WHERE `int1` = '454'";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php echo "{$row['text2']}"; ?>
<?php
	}
?>
<!-- END TEXT 2 -->
</blockquote>
        </div>
      </div>

<?php }; ?>

</div>

	<script src="../java/vendor/jquery.js"></script>
	<script src="../java/vendor/jquery-ui.min.js"></script>
	<script src="../java/vendor/what-input.js"></script>
	<script src="../java/vendor/foundation.min.js"></script>
	<script src="../java/form.js"></script>
	<script src="../java/google-base.js" type="text/javascript"></script>
	<script src="../my-documents/google-code.js" type="text/javascript"></script>

</body>

</html>
