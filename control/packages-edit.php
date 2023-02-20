<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '/home/nodyss5/php/PHPMailer-6.3.0/src/PHPMailer.php';
require '/home/nodyss5/php/PHPMailer-6.3.0/src/SMTP.php';
require '/home/nodyss5/php/PHPMailer-6.3.0/src/Exception.php';
//require '/home/nodyss5/php/PHPMailer/PHPMailerAutoload.php';

require '../my-documents/smtp.php';

$current_page = '10';
include('protect.php');

// Read the Timezone Offset file
$timezoneOffsetStr = file_get_contents('../my-documents/localization-timezone.txt');

//Extract the offset
$timezoneOffset = substr($timezoneOffsetStr, 0, strpos($timezoneOffsetStr, ";"));

$int1 = $_POST["int1"];
$action = $_POST["action"];
if ($action == "save"){

		$recipient = htmlspecialchars($_POST['recipient'], ENT_QUOTES);
		$userid = $_POST['userid'];
		$packagetype = htmlspecialchars($_POST['packagetype'], ENT_QUOTES);
		$pkgtracking = htmlspecialchars($_POST['pkgtracking'], ENT_QUOTES);
		$from = htmlspecialchars($_POST['from'], ENT_QUOTES);
		$pkglocation = htmlspecialchars($_POST['pkglocation'], ENT_QUOTES);
		$received = $_POST['received'];
		$comments = htmlspecialchars($_POST['comments'], ENT_QUOTES);
		$lastedited = gmdate('Y-m-d H:i:s', time() + 3600*($timezoneOffset+date('I')));

		$query = "SELECT `unit`, `unit2`, `packagedid` FROM `users` WHERE `id` = '$userid'";
		$result = mysqli_query($conn, $query);
	    while($row = $result->fetch_array(MYSQLI_ASSOC)){
		    $unit = $row['unit'];
            $unit2 = $row['unit2'];
            $DID = $row['packagedid'];
        }

		$query = "UPDATE `packages` SET `recipient`='$recipient', `userid`='$userid', `packagetype`='$packagetype', `pkgtracking`='$pkgtracking', `from`='$from', `pkglocation`='$pkglocation', `received`='$received', `comments`='$comments', `lastedited`='$lastedited', `unit`='$unit', `unit2`='$unit2', `DID`='$DID' WHERE `int1`='$int1' LIMIT 1";
		mysqli_query($conn,$query) or die('Error, update query failed');
		
		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['int1'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('E', 'Packages', '$useripaddress', '$userid', '$id')";
		mysqli_query($conn,$query) or die('Error, updating log failed');

		header('Location: packages.php');
	}

if(($_POST['disregard_email']) == "yes"){

	$user = $_POST['disregardemail'];
    $query  = "SELECT `first_name`, `last_name`, `email`, `emailconfirm` FROM `users` WHERE `email` = '$user'";
    $result = mysqli_query($conn, $query);
	while($row = $result->fetch_array(MYSQLI_ASSOC)){
	    $userfirst = $row['first_name'];
        $userlast = $row['last_name'];
        $username = "$userfirst $userlast";
        $useremail = $row['email'];
        $emailconfirm = $row['emailconfirm'];
    }
	
	if ($emailconfirm != 'B') {
	
        $reseturl = $_SESSION['reseturl'];
        $communityurl = $_SESSION['communityurl'];
        $fromname = "$CommunityName via CondoSites";

        $body = "<!DOCTYPE HTML><html><body><div style='padding: 25px;'>";
        $body .= "<p>Dear ".$username.",</p> <p><b>A ".$_POST['packagetype']." notification was sent to you in error. Please disregard it.</b></p>";
        $body .= "<p>Tracking: ".$_POST['pkgtracking']."<br><br>Comments: ".$_POST['comments']."<br><br>".$_POST['message']."</p>";
        $body .= "</div><br><img src='".$communityurl."/pics/logo-small.png' style='max-width: 100px;'><br><br>Visit your <a href='".$communityurl."'>".$CommunityName." community website</a>.</p>";
        $body .= "<p><b>Email Subscription</b><br><small>You are receiving this email because you are a registered user of the ".$CommunityName." community website, operated by <a href='https://condosites.com' target='_blank'>CondoSites</a>.";
        $body .= "$dnrCNG";
        $body .= "<br><br><b><a href='".$communityurl."/spamhelp.php'>Are these emails being treated as spam?</a></b></p></small></body></html>";

        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host = $hostCNG;
        $mail->SMTPAuth = $smtpauthCNG;
        $mail->SMTPKeepAlive = $smtpkeepaliveCNG;
        $mail->Port = $smtpportMSG;
        $mail->SMTPSecure = $smtpsecureMSG;
        $mail->SMTPAutoTLS = $smtpautotlsMSG;
        $mail->Username = $usernameCNG;
        $mail->Password = $passwordCNG;
        $mail->setFrom($fromemailCNG, $fromname);

        $mail->addAddress($useremail, $username);
        $mail->Subject = "Disregard ".$_POST['packagetype']." Notice - $CommunityName via CondoSites";
        $mail->Body = "$body";
        $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
    
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        if(!$mail->send()) {
            $errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Disregard email was not sent.</strong></div>";
        } else {
            $errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Disregard email was sent to $username ($useremail).</strong></div>";
        }
	}
	if ($emailconfirm == 'B') {
	    $errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #FAFEB8; color: black;'><i class='fa fa-exclamation-triangle note' aria-hidden='true'></i> <strong>Disregard email was not sent. This user&apos;s email address is bouncing!</strong></div>";
	}
	
}

if(($_POST['userid']) && ($_POST['disregard_email']) == "yes"){

	$usernew = $_POST['userid'];
    $query  = "SELECT `first_name`, `last_name`, `email`, `emailconfirm` FROM `users` WHERE `id` = '$usernew'";
    $result = mysqli_query($conn, $query);
	while($row = $result->fetch_array(MYSQLI_ASSOC)){
	    $userfirst = $row['first_name'];
        $userlast = $row['last_name'];
        $username = "$userfirst $userlast";
        $useremail = $row['email'];
        $emailconfirm = $row['emailconfirm'];
    }
	
	if ($emailconfirm != 'B') {

        $reseturl = $_SESSION['reseturl'];
        $communityurl = $_SESSION['communityurl'];
        $fromname = "$CommunityName via CondoSites";

        $body = "<!DOCTYPE HTML><html><body><div style='padding: 25px;'>";
        $body .= "<p>Dear ".$username.",</p> <p><b>A ".$_POST['packagetype']." is waiting for you.</b></p>";
        $body .= "<p>Tracking: ".$_POST['pkgtracking']."<br><br>Comments: ".$_POST['comments']."<br><br>".$_POST['message']."</p>";
        $body .= "</div><br><img src='".$communityurl."/pics/logo-small.png' style='max-width: 100px;'><br><br>Visit your <a href='".$communityurl."'>".$CommunityName." community website</a>.</p>";
        $body .= "<p><b>Email Subscription</b><br><small>You are receiving this email because you are a registered user of the ".$CommunityName." community website, operated by <a href='https://condosites.com' target='_blank'>CondoSites</a>.";
        $body .= "$dnrCNG";
        $body .= "<br><br><b><a href='".$communityurl."/spamhelp.php'>Are these emails being treated as spam?</a></b></p></small></body></html>";

        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host = $hostCNG;
        $mail->SMTPAuth = $smtpauthCNG;
        $mail->SMTPKeepAlive = $smtpkeepaliveCNG;
        $mail->Port = $smtpportMSG;
        $mail->SMTPSecure = $smtpsecureMSG;
        $mail->SMTPAutoTLS = $smtpautotlsMSG;
        $mail->Username = $usernameCNG;
        $mail->Password = $passwordCNG;
        $mail->setFrom($fromemailCNG, $fromname);

        $mail->addAddress($useremail, $username);
        $mail->Subject = "A ".$_POST['packagetype']." has been received for you. - $CommunityName via CondoSites";
        $mail->Body = "$body";
        $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        if(!$mail->send()) {
            $errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Reminder email was not sent.</strong></div>";
        } else {
            $errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Reminder email was sent to $username ($useremail).</strong></div>";
        }
	}
    if ($emailconfirm == 'B') {
	    $errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #FAFEB8; color: black;'><i class='fa fa-exclamation-triangle note' aria-hidden='true'></i> <strong>Disregard email was not sent. This user&apos;s email address is bouncing!</strong></div>";
	}
	
}
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

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
<!-- INPUT FORM -->
<?php
	$query  = "SELECT `int1`, recipient, userid, packagetype, pkgtracking, `from`, pkglocation, received, recemp, pickedup, puemp, pickedupby, comments, lastedited FROM packages WHERE `int1`='$int1' LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<div class="nav-section-header-cp">
        <strong>Edit a Package or Delivery</strong>
</div>
<!-- UPLOAD FORM -->
<div class="cp-form-container">
<!-- COLUMN 1 -->
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 0px 0px;">
<form enctype="multipart/form-data" method="POST" action="packages-edit.php">
            <div class="small-12 medium-12 columns"><strong>1) Package Recipient</strong></div>
        </div>
        <div class="row medium-collapse" style="padding: 10px 10px 10px 30px;">
            <div class="small-12 medium-12 columns">
                <?php include('userid-field-edit.php'); ?>
                <label for="email_confirmation" class="middle" style="margin-bottom: -20px;">&nbsp;&nbsp;&nbsp;&nbsp;<i>Other</i> <input name="recipient" maxlength="100" class="form" type="text" value="<?php echo "{$row['recipient']}"; ?>"></label>
                <input name="received" maxlength="19" class="form" type="hidden" value="<?php echo date('Y-m-d', strtotime($row['received'])).'T'.date('H:i', strtotime($row['received'])); ?>" required>
            </div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>2) Sender and Comments</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="from" class="middle">Who is this package from?</label></div>
            <div class="small-12 medium-7 end columns"><input name="from" maxlength="100" class="form" type="text" placeholder="Macy&apos;s" value="<?php echo "{$row['from']}"; ?>"></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 columns"><label for="comments" class="middle" style="margin-bottom: -7px;">Comments&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Comments <b>ARE</b> visible to the user.</span></label>
                <textarea name="comments" class="form" type="text"><?php echo "{$row['comments']}"; ?></textarea>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 columns">
                <label for="email_confirmation" class="middle">
                    <input type="checkbox" name="disregard_email" value="yes"> Send notices to previous and new recipients.&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Valid only for registered users.</span>
                </label>
<!-- DETAILS FOR EMAIL -->
<?php
	$type    = $row['userid'];
	$query1  = "SELECT email FROM users WHERE id = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
?>
<input name="disregardemail" type="hidden" size="100" value="<?php echo "{$row1['email']}"; ?>">
<?php
	}
?>
<input name="messagebody" type="hidden" size="100" value="<?php include('messages-email-trail.php'); ?>">
<!-- DETAILS FOR EMAIL -->
            </div>
        </div>
    </div>
<!-- END COLUMN 1 -->
<!-- COLUMN 2 -->
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>3) Package Information</strong></div>
        </div>
        <div class="row medium-collapse" style="padding: 10px 10px 10px 30px;">
            <div class="small-12 medium-2 columns" align="center">
                <div style="max-width: 50px;"><?php include('package-graphics.php'); ?></div>
            </div>
            <div class="small-12 medium-10 columns">
<select name="packagetype">
<option value="">Select</option>
<option value="" disabled> </option>
<option value="" disabled>***PACKAGES***</option>
<option value="UPS Package" <?php if($row['packagetype'] == "UPS Package"){ echo("SELECTED"); } ?>>UPS Package</option>
<option value="UPS Express Package" <?php if($row['packagetype'] == "UPS Express Package"){ echo("SELECTED"); } ?>>UPS Express Package</option>
<option value="UPS Ground Package" <?php if($row['packagetype'] == "UPS Ground Package"){ echo("SELECTED"); } ?>>UPS Ground Package</option>
<option value="FedEx Package" <?php if($row['packagetype'] == "FedEx Package"){ echo("SELECTED"); } ?>>FedEx Package</option>
<option value="FedEx Express Package" <?php if($row['packagetype'] == "FedEx Express Package"){ echo("SELECTED"); } ?>>FedEx Express Package</option>
<option value="FedEx Ground Package" <?php if($row['packagetype'] == "FedEx Ground Package"){ echo("SELECTED"); } ?>>FedEx Ground Package</option>
<option value="DHL Package" <?php if($row['packagetype'] == "DHL Package"){ echo("SELECTED"); } ?>>DHL Package</option>
<option value="Amazon Package" <?php if($row['packagetype'] == "Amazon Package"){ echo("SELECTED"); } ?>>Amazon Package</option>
<option value="LaserShip Package" <?php if($row['packagetype'] == "LaserShip Package"){ echo("SELECTED"); } ?>>LaserShip Package</option>
<option value="OnTrac Package" <?php if($row['packagetype'] == "OnTrac Package"){ echo("SELECTED"); } ?>>OnTrac Package</option>
<option value="USPS Package" <?php if($row['packagetype'] == "USPS Package"){ echo("SELECTED"); } ?>>USPS Package</option>
<option value="USPS Certified Letter" <?php if($row['packagetype'] == "USPS Certified Letter"){ echo("SELECTED"); } ?>>USPS Certified Letter</option>
<option value="USPS Express Mail" <?php if($row['packagetype'] == "USPS Express Mail"){ echo("SELECTED"); } ?>>USPS Express Mail</option>
<option value="USPS Priority Mail" <?php if($row['packagetype'] == "USPS Priority Mail"){ echo("SELECTED"); } ?>>USPS Priority Mail</option>
<option value="USPS Registered Letter" <?php if($row['packagetype'] == "USPS Registered Letter"){ echo("SELECTED"); } ?>>USPS Registered Letter</option>
<option value="" disabled> </option>
<option value="" disabled>***DELIVERIES***</option>
<option value="Delivery" <?php if($row['packagetype'] == "Delivery"){ echo("SELECTED"); } ?>>Delivery</option>
<option value="Dry Cleaning Delivery" <?php if($row['packagetype'] == "Dry Cleaning Delivery"){ echo("SELECTED"); } ?>>Dry Cleaning Delivery</option>
<option value="Flower Delivery" <?php if($row['packagetype'] == "Flower Delivery"){ echo("SELECTED"); } ?>>Flower Delivery</option>
<option value="Gift" <?php if($row['packagetype'] == "Gift"){ echo("SELECTED"); } ?>>Gift</option>
<option value="Grocery Delivery" <?php if($row['packagetype'] == "Grocery Delivery"){ echo("SELECTED"); } ?>>Grocery Delivery</option>
<option value="Video" <?php if($row['packagetype'] == "Video"){ echo("SELECTED"); } ?>>Video</option>
        </select>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="received" class="middle">Storage Location</label></div>
            <div class="small-12 medium-7 end columns"><input name="pkglocation" maxlength="100" class="form" type="text" placeholder="Closet" value="<?php echo "{$row['pkglocation']}"; ?>"></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="pkgtracking" class="middle">Tracking Number</label></div>
            <div class="small-12 medium-7 end columns">
                <input name="pkgtracking" maxlength="100" class="form" type="text" placeholder="1Z234567890" value="<?php echo "{$row['pkgtracking']}"; ?>">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Focus your curser on the tracking field before scanning barcodes!</span>
            </div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>4) Ready to Save?</strong></div>
        </div>
        <div class="row medium-collapse">
            <div class="small-6 columns" align="center">
                <input type="hidden" name="action" value="save">
	            <input type="hidden" name="int1" value="<?php echo $_POST['int1']; ?>">
	            <input name="submit" value="Save" class="submit" type="submit" onclick="value='Processing Request - Save'; style='color:red';" />
                <?php echo($error); ?>
</form>
            </div>
            <div class="small-6 end columns" align="center">
<form action="packages.php" method="get">
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
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Packages Edit Control Panel Page<br></div>
</body>
</html>