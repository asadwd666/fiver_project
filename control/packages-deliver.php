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
$pkgtracking = $_POST["pkgtracking"];
$action = $_POST["action"];

if ($action == "save"){

	$pickedup = $_POST["pickedup"];
	$puemp = htmlspecialchars($_POST['puemp'], ENT_QUOTES);
	$pickedupby = htmlspecialchars($_POST['pickedupby'], ENT_QUOTES);
	$comments = htmlspecialchars($_POST['comments'], ENT_QUOTES);
	$lastedited = date("Y-m-d H:i:s");

	$query = "UPDATE packages SET pickedup='$pickedup', puemp='$puemp', pickedupby='$pickedupby', comments='$comments', lastedited='$lastedited' WHERE `int1`='$int1' LIMIT 1";
	mysqli_query($conn,$query) or die('Error, update query failed');

	$useripaddress = $_SERVER['REMOTE_ADDR'];
	$userid = $_SESSION['id'];
	$id = $_POST['int1'];
	$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('E', 'Packages', '$useripaddress', '$userid', '$id')";
	mysqli_query($conn,$query) or die('Error, updating log failed');

    if(($_POST['deliver_email']) == "yes"){

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
            $body .= "<p>Dear ".$username.",</p> <p><b>A ".$_POST['packagetype']." has been delivered.</b></p>";
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
            $mail->Subject = "A ".$_POST['packagetype']." has been delivered. - $CommunityName via CondoSites";
            $mail->Body = "$body";
            $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

            if(!$mail->send()) {
                $errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Delivery email was not sent.</strong></div>";
            } else {
                $errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Delivery email was sent to $username ($useremail).</strong></div>";
            }
	    }
	    if ($emailconfirm == 'B') {
	        $errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #FAFEB8; color: black;'><i class='fa fa-exclamation-triangle note' aria-hidden='true'></i> <strong>Delivery email was not sent. This user&apos;s email address is bouncing!</strong></div>";
	    }
	}
	
	header('Location: packages.php');

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
if ($action == "edit"){
	$query  = "SELECT `int1`, recipient, userid, packagetype, pkgtracking, `from`, pkglocation, received, recemp, pickedup, puemp, pickedupby, comments, lastedited FROM packages WHERE `int1`='$int1' LIMIT 1";
}
if ($action == "track"){
	$query  = "SELECT `int1`, recipient, userid, packagetype, pkgtracking, `from`, pkglocation, received, recemp, pickedup, puemp, pickedupby, comments, lastedited FROM packages WHERE `pkgtracking`='$pkgtracking' LIMIT 1";
}
	$result = mysqli_query($conn, $query);
	
	if (mysqli_num_rows($result)==0)
    {
        header('Location: packages.php?package=none');
    }

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<div class="nav-section-header-cp">
        <strong>Deliver/Undeliver a Package or Delivery</strong>
</div>
<!-- UPLOAD FORM -->
<div class="cp-form-container">
<!-- COLUMN 1 -->
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 0px 0px;">
<form enctype="multipart/form-data" method="POST" action="packages-deliver.php">
            <div class="small-12 medium-12 columns"><strong>1) Package Recipient</strong></div>
        </div>
        <div class="row medium-collapse" style="padding: 10px 10px 10px 30px;">
            <div class="small-12 medium-12 columns">
<?php
	$type    = $row['userid'];
	$query1  = "SELECT `id`, `unit`, `unit2`, `last_name`, `first_name`, `email`, `phone` FROM `users` WHERE `id` = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
?>
<label for="received" class="middle">Recipient: <b><?php echo "{$row1['last_name']}"; ?>, <?php echo "{$row1['first_name']}"; ?> (<?php echo "{$row1['unit']}"; ?><?php if ($row1['unit2'] !== ''){ ?> - <?php echo "{$row1['unit2']}"; ?><?php }; ?>)</b></label>
<?php
	}
?>


            </div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>2) Package Information</strong></div>
        </div>
        <div class="row medium-collapse" style="padding: 10px 10px 10px 30px;">
            <div class="small-12 medium-2 columns" align="center">
                <div style="max-width: 50px; padding-top: 10px;"><?php include('package-graphics.php'); ?></div>
            </div>
            <div class="small-12 medium-10 columns">
                <label for="received" class="middle">
<?php if ($row['pkgtracking'] !== ''){ ?>Tracking Number <b><?php echo "{$row['pkgtracking']}"; ?></b><br><?php }; ?>
<?php if ($row['from'] !== ''){ ?>From <b><?php echo "{$row['from']}"; ?></b><br><?php }; ?>
Received <b><?php echo "{$row['received']}"; ?></b> by: <b><?php echo "{$row['recemp']}"; ?></b>
                </label>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 columns"><label for="comments" class="middle">Comments&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Comments <b>ARE</b> visible to the user.</span></label>
                <textarea name="comments" class="form" type="text" placeholder="Comments"><?php echo "{$row['comments']}"; ?></textarea>
            </div>
        </div>
    </div>
<!-- END COLUMN 1 -->
<!-- COLUMN 2 -->
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>3) Delivery Information</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="pickedup" class="middle">Picked Up At</label></div>
            <div class="small-12 medium-7 end columns"><input name="pickedup" maxlength="19" class="form" type="datetime-local" placeholder="<?php echo gmdate('Y-m-d', time() + 3600*($timezoneOffset+date('I')))."T".gmdate('H:i:s', time() + 3600*($timezoneOffset+date('I'))); ?>" value="<?php echo gmdate('Y-m-d', time() + 3600*($timezoneOffset+date('I')))."T".gmdate('H:i:s', time() + 3600*($timezoneOffset+date('I'))); ?>"></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="pickedupby" class="middle">Picked Up By</label></div>
            <div class="small-12 medium-7 end columns"><input name="pickedupby" maxlength="100" class="form" type="text" value="<?php echo "{$row['pickedupby']}"; ?>" autofocus></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="puemp" class="middle">Released By</label></div>
            <div class="small-12 medium-7 end columns"><input name="puemp" maxlength="100" class="form" type="text" <?php if ($row['puemp'] == ''){ ?>value="<?php echo($_SESSION['first_name']); ?> <?php echo($_SESSION['last_name']); ?>"><?php }; ?><?php if ($row['puemp'] !== ''){ ?>value="<?php echo "{$row['puemp']}"; ?>"><?php }; ?></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 columns">
                <label for="email_confirmation" class="middle"><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">To <b>Undeliver</b> a package delete the contents of the three fields above.</span></label>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 columns">
                <label for="email_confirmation" class="middle">
                    <input type="checkbox" name="deliver_email" value="yes"> Send delivery notice to recipient.&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Valid only for registered users.</span>
                </label>
<!-- DETAILS FOR EMAIL -->
<input name="userid" type="hidden" value="<?php echo "{$row['userid']}"; ?>">
<input name="packagetype" type="hidden" value="<?php echo "{$row['packagetype']}"; ?>">
<input name="pkgtracking" type="hidden" value="<?php echo "{$row['pkgtracking']}"; ?>">
<input name="messagebody" type="hidden" size="100" value="<?php include('messages-email-trail.php'); ?>">
<!-- DETAILS FOR EMAIL -->
            </div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>4) Ready to Save?</strong></div>
        </div>
        <div class="row medium-collapse">
            <div class="small-6 columns" align="center">
                <input type="hidden" name="action" value="save">
                <input type="hidden" name="int1" value="<?php echo $row['int1']; ?>">
	            <input name="submit" value="Save" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
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
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Packages Deliver/Undeliver Control Panel Page<br></div>
</body>
</html>
