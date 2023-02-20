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

if($_POST['action'] == "email_remind"){
	$error = "";
	
	if($useremail == ""){
		$useremail = $_POST['email'];
	}
	
	$query  = "SELECT `first_name`, `last_name`, `email`, `emailconfirm` FROM `users` WHERE `email` = '$useremail'";
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
        $body .= "<p>Dear ".$username.",</p> <p><b>REMINDER: A ".$_POST['packagetype']." is still waiting for you.</b></p>";
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
        $mail->Port = $smtpportCNG;
        $mail->SMTPSecure = $smtpsecureCNG;
        $mail->SMTPAutoTLS = $smtpautotlsCNG;
        $mail->Username = $usernameCNG;
        $mail->Password = $passwordCNG;
        $mail->setFrom($fromemailCNG, $fromname);

        $mail->addAddress($useremail, $username);
        $mail->Subject = "A ".$_POST['packagetype']." is still waiting for you. - $CommunityName via CondoSites";
        $mail->Body = "$body";
        $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
    
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';
            
        if(!$mail->send()) {
            $errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #FAFEB8; color: black;'><i class='fa fa-exclamation-triangle note' aria-hidden='true'></i> <strong>Reminder email was not sent.</strong></div>";
        } else {
            $errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Reminder email was sent to $username ($useremail).</strong></div>";
        }
	}
	if ($emailconfirm == 'B') {
	    $errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #FAFEB8; color: black;'><i class='fa fa-exclamation-triangle note' aria-hidden='true'></i> <strong>Reminder email was not sent. This user&apos;s email address is bouncing!</strong></div>";
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
	<script type="text/javascript"> var ss = 30; function countdown() {ss = ss-1; if (ss<0) {window.location="packages.php";} else {document.getElementById("countdown").innerHTML=ss; window.setTimeout("countdown()", 60000);}}</script>
</head>
<body onload="countdown()">
<!-- LOGO AND NAVIGATION -->
<?php include('cp-navigation.php'); ?>
<!-- END LOGO AND NAVIGATION -->
<?php $int1 = $_POST["int1"]; $action = $_POST["action"]; if ($action != null){ ?>
<?php
	if ($action == "delete"){
		$query = "DELETE FROM packages WHERE `int1`='$int1'";
		mysqli_query($conn,$query) or die('Error, delete query failed');
		
		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['int1'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('D', 'Packages', '$useripaddress', '$userid', '$id')";
		mysqli_query($conn,$query) or die('Error, updating log failed');
	}
	if ($action == "add"){

		$recipient = htmlspecialchars($_POST['recipient'], ENT_QUOTES);
		$user = $_POST['userid'];
		$packagetype = htmlspecialchars($_POST['packagetype'], ENT_QUOTES);
		$pkgtracking = htmlspecialchars($_POST['pkgtracking'], ENT_QUOTES);
		$from = htmlspecialchars($_POST['from'], ENT_QUOTES);
		$pkglocation = htmlspecialchars($_POST['pkglocation'], ENT_QUOTES);
		$received = $_POST["received"];
		$recemp = htmlspecialchars($_POST['recemp'], ENT_QUOTES);
		$pickedup = $_POST["pickedup"];
		$puemp = htmlspecialchars($_POST['puemp'], ENT_QUOTES);
		$pickedupby = htmlspecialchars($_POST['pickedupby'], ENT_QUOTES);
		$comments = htmlspecialchars($_POST['comments'], ENT_QUOTES);
		$created = date("Y-m-d");
		
		$query = "SELECT `unit`, `unit2`, `packagedid` FROM `users` WHERE `id` = '$user'";
		$result = mysqli_query($conn, $query);
	    while($row = $result->fetch_array(MYSQLI_ASSOC)){
		    $unit = $row['unit'];
            $unit2 = $row['unit2'];
            $DID = $row['packagedid'];
        }
		
		$query = "INSERT INTO packages (recipient, userid, packagetype, pkgtracking, `from`, pkglocation, received, recemp, pickedup, puemp, pickedupby, comments, `created`, `unit`, `unit2`, `DID`) VALUES ('$recipient', '$user', '$packagetype', '$pkgtracking', '$from', '$pkglocation', '$received', '$recemp', '$pickedup', '$puemp', '$pickedupby', '$comments', '$created', '$unit', '$unit2', '$DID')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

        if($_POST['package_email'] == 'yes'){
	        $error = "";
	
	        $user = $_POST['userid'];
        	$query  = "SELECT `first_name`, `last_name`, `email`, `emailconfirm` FROM `users` WHERE `id` = '$user'";
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
                $body .= "<p>Dear ".$username.",</p> <p><b>A ".$_POST['packagetype']." has been received for you.</b></p>";
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
                $mail->Subject = "A ".$_POST['packagetype']." has been received for you.";
                $mail->Body = "$body";
                $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
            
                if(!$mail->send()) {
                    $errorEMAIL = "Email was not sent.";
                } else {
                    $errorEMAIL = "Email was sent to $username ($useremail).";
                }
	        }
        }

	    if ($emailconfirm == 'B') {
	        $errorEMAIL = "Email was not sent. This user&apos;s email address is bouncing!";
	    }

		$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Your $packagetype was added successfully. $errorEMAIL</strong></div>";
		
	}
	
}
?>
<br>
<div style="max-width: 99%;">
<div class="nav-section-header-cp">
        <strong>Add a Package or Delivery</strong>
</div>
<?php echo($errorSUCCESS); ?>
<!-- UPLOAD FORM -->
<div class="cp-form-container">
<!-- COLUMN 1 -->
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 0px 0px;">
<form method="POST" action="packages-add.php">
            <div class="small-12 medium-12 columns"><strong>1) Package Recipient</strong></div>
        </div>
        <div class="row medium-collapse" style="padding: 10px 10px 10px 30px;">
            <div class="small-12 medium-12 columns">
                <?php include('userid-field.php'); ?>
                <label for="email_confirmation" class="middle" style="margin-bottom: -20px;"><input type="checkbox" name="package_email" value="yes" checked> Send email to user?&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Valid only for registered users.</span>
                <br>&nbsp;&nbsp;&nbsp;&nbsp;<i>Other</i> <input name="recipient" maxlength="100" class="form" type="text"></label>
                <!-- DETAILS FOR EMAIL -->
                <input type="hidden" name="message" value="<?php include('../my-documents/package-locations.php'); ?>" class="form">
                <!-- DETAILS FOR EMAIL -->
            </div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>2) Sender and Comments</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="from" class="middle">Who is this package from?</label></div>
            <div class="small-12 medium-7 end columns"><input name="from" maxlength="100" class="form" type="text" placeholder="Macy&apos;s"></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 columns"><label for="comments" class="middle" style="margin-bottom: -7px;">Comments&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Comments <b>ARE</b> visible to the user.</span></label>
                <textarea name="comments" class="form" type="text" placeholder="Comments"></textarea>
                <input name="received" maxlength="19" class="form" value="<?php echo gmdate('Y-m-d H:i:s', time() + 3600*($timezoneOffset+date('I'))); ?>" type="hidden">
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
            <div class="small-12 medium-12 columns">
        <select name="packagetype" required>
<option value="">Select Package Type</option>
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
            <div class="small-12 medium-5 columns"><label for="pkglocation" class="middle">Storage Location</label></div>
            <div class="small-12 medium-7 end columns"><input name="pkglocation" maxlength="100" class="form" type="text" placeholder="Closet"></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="pkgtracking" class="middle">Tracking Number</label></div>
            <div class="small-12 medium-7 end columns">
                <input name="pkgtracking" maxlength="100" class="form" type="text" placeholder="1Z234567890">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Focus your curser on the tracking field before scanning barcodes!</span>
            </div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>4) Ready to Save?</strong></div>
        </div>
        <div class="row medium-collapse">
            <div class="small-6 columns" align="center">
                <input type="hidden" name="action" value="add" />
                <input type="hidden" name="recemp" value="<?php echo($_SESSION['first_name']); ?> <?php echo($_SESSION['last_name']); ?>" class="form">
	            <input type="submit" class="submit" value="Submit Package" onclick="value='Processing Request - Resubmit'; style='color:red';" />
                <?php echo($error); ?>
</form>
            </div>
            <div class="small-6 end columns" align="center">
<form action="packages.php" method="get">
	            <input type="submit" value="Cancel &amp; Return to Packages" onclick="return confirm('Are you sure you wish to leave this page? Unsaved changes will be lost.');">
</form>
            </div>
        </div>
    </div>
<!-- COLUMN 2 -->
</div>
<!-- END UPLOAD FORM -->
<br>&nbsp;
<!-- MOST RECENT EDITED PACKAGES -->
<div class="nav-section-header-cp">
        <strong>Most Recently Edited Package by <?php echo "{$_SESSION['first_name']}"; ?> <?php echo "{$_SESSION['last_name']}"; ?></strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
    <thead>
        <tr align="left">
            <th class="table-sortable:alphanumeric"><b>&nbsp;&nbsp;&nbsp; <small>Details</small></th>
            <th align="center" width="50" class="table-sortable:numeric">&nbsp;&nbsp;&nbsp; <small>ID</small></th>
            <th class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <small>Unit</small></th>
            <th class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <small>Recipient</small></th>
            <th><b>&nbsp;&nbsp;&nbsp; <small>Received</small></th>
        </tr>
    </thead>
    <tbody style="background-color:#ffffff">
<?php
    $conciergeid = $_SESSION['first_name']." ".$_SESSION['last_name'];
	$query  = "SELECT * FROM packages WHERE `recemp` = '$conciergeid' ORDER BY `lastedited` DESC LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- DATABASE RESULTS -->
        <tr>
            <td>
                <div class="small-12 medium-12 large-8 columns">
<div style="float:right; width: 60px;"><?php include('package-graphics.php'); ?></div>
<?php echo "{$row['from']}"; ?><br>
<?php if ($row['pkgtracking'] !== ''){ ?><b>Trk&#35;</b><?php include('package-track.php'); ?><?php }; ?><br>
<?php if ($row['pkglocation'] !== ''){ ?><span class="note-red"><big><?php echo "{$row['pkglocation']}"; ?></big></span><?php }; ?><br>
<?php if ($row['received'] !== ''){ ?><b>In </b><?php echo date('Y-m-d g:i a', strtotime($row['received'])); ?> <b>by </b><?php echo "{$row['recemp']}"; ?><?php }; ?>
<?php if ($row['pickedup'] !== '0000-00-00 00:00:00'){ ?><br><b>Out </b><?php echo date('Y-m-d g:i a', strtotime($row['pickedup'])); ?><b> by </b><?php echo "{$row['puemp']}"; ?><?php }; ?> <?php if ($row['pickedupby'] !== ''){ ?><b>to </b><?php echo "{$row['pickedupby']}"; ?><?php }; ?>
<?php if ($row['comments'] !== ''){ ?><br><?php echo "{$row['comments']}"; ?><?php }; ?>
                </div>
                <div class="small-6 medium-6 large-2 columns">
	                <form name="PKGDelete" method="POST" action="packages.php" onclick="return confirm('Are you sure you want to DELETE this <?php echo "{$row['packagetype']}"; ?>?');">
	                    <input type="hidden" name="action" value="delete">
	                    <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
	                    <input name="submit" value="Delete" class="submit" type="submit" onclick="value='Processing Request - Delete'; style='color:red';" />
	                </form>
                </div>
                <div class="small-6 medium-6 large-2 columns">
	                <form name="PKGEdit" method="POST" action="packages-edit.php">
	                    <input type="hidden" name="action" value="edit">
	                    <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
	                    <input name="submit" value="Edit" class="submit" type="submit" onclick="value='Processing Request - Edit'; style='color:red';" />
	                </form>
                </div>
            </td>
            <td><?php echo "{$row['int1']}"; ?></td>
            <td>
<?php if ($row['userid'] == '0'){ ?>*<?php }; ?>
<?php if ($row['userid'] != '0'){ ?>
<?php
	$type    = $row['userid'];
	$query1  = "SELECT id, unit, unit2, last_name, first_name, email, phone FROM users WHERE id = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?>
<b><?php echo "{$row1['unit']}"; ?> <?php if ($row1['unit2'] != 'X'){ ?><?php echo "{$row1['unit2']}"; ?><?php }; ?></b>
<?php
	}
?>
<?php }; ?>
            </td>
            <td>
<?php if ($row['userid'] == '0'){ ?><b><?php echo "{$row['recipient']}"; ?><?php }; ?>
<?php if ($row['userid'] != '0'){ ?>
<?php
	$type    = $row['userid'];
	$query1  = "SELECT id, email, unit, unit2, last_name, first_name, email, phone, packagepreference FROM users WHERE id = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?>
<b><a href="mailto:<?php echo "{$row1['email']}"; ?>"><?php echo "{$row1['last_name']}"; ?>, <?php echo "{$row1['first_name']}"; ?></a> </b><br><?php echo "{$row1['phone']}"; ?>

<?php if ($row1['packagepreference'] !== 'X'){ ?>
<br><span class="note-red"><?php echo "{$row1['packagepreference']}"; ?></span>
<?php }; ?>
<?php
	}
?>
<?php }; ?>
            </td>
            <td>
                <?php if (($row['userid'] !== '0') && ($row['pickedup'] == '0000-00-00 00:00:00')){ ?>
	            <form method="POST" action="" onclick="return confirm('Are you sure you want to send a reminder about this package?');">
		            <input name="submit" value="Remind" class="submit" type="submit" onclick="value='Processing Request - Remind'; style='color:red';" />
		            <input name="email" type="hidden" value="<?php echo($email); ?>" />
		            <input name="action" type="hidden" value="email_remind" />
		            <input name="from" type="hidden" value="<?php echo($row['from']); ?>" />
		            <input name="pkgtracking" type="hidden" value="<?php echo($row['pkgtracking']); ?>" />
		            <input name="packagetype" type="hidden" value="<?php echo($row['packagetype']); ?>" />
		            <input name="comments" type="hidden" value="<?php echo($row['comments']); ?>" />
		            <input type="hidden" name="recemp" value="<?php echo($_SESSION['first_name']); ?> <?php echo($_SESSION['last_name']); ?>" class="form">
	                <input type="hidden" name="message" value="<?php include('../my-documents/package-locations.php'); ?>" class="form">
	            </form>
	            <br>
                <?php }; ?>
                <?php if ($row['pickedup'] == '0000-00-00 00:00:00'){ ?>
                <form name="PKGDeliver" method="POST" action="packages-deliver.php">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
                    <input name="submit" value="Deliver" class="submit" type="submit" onclick="value='Processing Request - Deliver'; style='color:red';" />
                </form>
                <?php }; ?>
                <?php if ($row['pickedup'] !== '0000-00-00 00:00:00'){ ?>
                <form name="PKGDeliver" method="POST" action="packages-deliver.php">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
                    <input name="submit" value="Undeliver" class="submit" type="submit" onclick="value='Processing Request - Undeliver'; style='color:red';" />
                </form>
                <?php }; ?>
            </td>
        </tr>
<!-- END DATABASE RESULTS -->
<?php
	}
?>
    </tbody>
</table>
<!-- END MOST RECENT EDITED PACKAGES -->
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Packages Add Control Panel Page<br></div>
</body>
</html>