<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '/home/nodyss5/php/PHPMailer-6.3.0/src/PHPMailer.php';
require '/home/nodyss5/php/PHPMailer-6.3.0/src/SMTP.php';
require '/home/nodyss5/php/PHPMailer-6.3.0/src/Exception.php';
//require '/home/nodyss5/php/PHPMailer/PHPMailerAutoload.php';
$current_page = '30';
include('protect.php');

require '../my-documents/smtp.php';
$authcode = Rand(111111,999999);

$email = "";
if(($_POST['userid']) && ($_POST['service_email']) == "yes"){
	$query  = "SELECT `email`, `first_name`, `last_name`, `emailconfirm` FROM `users` WHERE `id` = ".$_POST['userid'];
	$result = mysqli_query($conn, $query);
	while($row = $result->fetch_array(MYSQLI_ASSOC)){

        $userfirst = $row['first_name'];
        $userlast = $row['last_name'];
        $username = "$userfirst $userlast";
        $useremail = $row['email'];
        $reseturl = $_SESSION['reseturl'];
        $communityurl = $_SESSION['communityurl'];
        $fromname = "$CommunityName via CondoSites";
        $emailconfirm = $row['emailconfirm'];

    	if ($emailconfirm != 'B') {

            $body = "<!DOCTYPE HTML><html><body><div style='padding: 25px;'>";
            $body .= "<p>Dear ".$username.",</p>";
            $body .= "<b>A ".$_POST['type']." Service Request has been registered on your behalf by ".$_SESSION['first_name']." ".$_SESSION['last_name'].".</b><br><br>Comments: ".$_POST['description']."<br><br>To comment further, log into your community website at <a href='".$communityurl."/splash/connect-login.php' target='_blank'>".$communityurl."/splash/connect-login.php</a>, and click on the small wrench icon at the top of the page to the right of your name.";
            $body .= "</div><br><img src='".$communityurl."/pics/logo-small.png' style='max-width: 100px;'><br><br>Visit your <a href='".$communityurl."'>".$CommunityName." community website</a>.</p>";
            $body .= "<p><b>Email Subscription</b><br><small>You are receiving this email because you are a registered user of the ".$CommunityName." community website, operated by <a href='https://condosites.com' target='_blank'>CondoSites</a>.";
            $body .= "$dnrOPS";
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
            $mail->setFrom($fromemailOPS, $fromname);

            $mail->addAddress($useremail, $username);
            $mail->Subject = "Service Request - $CommunityName via CondoSites";
            $mail->Body = "$body";
            $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
        
            if(!$mail->send()) {
                
            } else {
                
            }
    	}
	}
}

$emailassigned = "";
if(($_POST['assigned']) && ($_POST['service_email_assigned']) == "yes"){
	$query  = "SELECT `email`, `first_name`, `last_name`, `emailconfirm` FROM `users` WHERE `id` = ".$_POST['assigned'];
	$result = mysqli_query($conn, $query);
	while($row = $result->fetch_array(MYSQLI_ASSOC)){

        $userfirst = $row['first_name'];
        $userlast = $row['last_name'];
        $username = "$userfirst $userlast";
        $useremail = $row['email'];
        $reseturl = $_SESSION['reseturl'];
        $communityurl = $_SESSION['communityurl'];
        $fromname = "$CommunityName via CondoSites";
        $emailconfirm = $row['emailconfirm'];

    	if ($emailconfirm != 'B') {

            $body = "<!DOCTYPE HTML><html><body><div style='padding: 25px;'>";
            $body .= "<p>Dear ".$username.",</p>";
            $body .= "<b>A ".$_POST['type']." Service Request has been assigned to you by ".$_SESSION['first_name']." ".$_SESSION['last_name'].".</b><br><br>Comments: ".$_POST['description']."<br><br>Confidential Comments: ".$_POST['confcomments']."<br><br>To comment further, log into your community website at <a href='".$communityurl."/splash/connect-login.php' target='_blank'>".$communityurl."/splash/connect-login.php</a>, and click on the small wrench icon at the top of the page to the right of your name.";
            $body .= "</div><br><img src='".$communityurl."/pics/logo-small.png' style='max-width: 100px;'><br><br>Visit your <a href='".$communityurl."'>".$CommunityName." community website</a>.</p>";
            $body .= "<p><b>Email Subscription</b><br><small>You are receiving this email because you are a registered user of the ".$CommunityName." community website, operated by <a href='https://condosites.com' target='_blank'>CondoSites</a>.";
            $body .= "$dnrOPS";
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
            $mail->setFrom($fromemailOPS, $fromname);

            $mail->addAddress($useremail, $username);
            $mail->Subject = "A Service Request has been assigned to you - $CommunityName via CondoSites";
            $mail->Body = "$body";
            $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
        
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
        
            if(!$mail->send()) {

            } else {
            }

        }
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
<?php $int1 = $_POST["int1"]; $action = $_POST["action"]; if ($action != null){ ?>
<?php
	if ($action == "add"){

		$userid = $_POST["userid"];
		$type = $_POST['type'];
		$description = htmlspecialchars($_POST['description'], ENT_QUOTES);
		$confcomments = htmlspecialchars($_POST['confcomments'], ENT_QUOTES);
		$privacy = $_POST["privacy"];
		$status = $_POST["status"];
		$assigned = $_POST["assigned"];
		$serviceflex1 = $_POST["serviceflex1"];
		$serviceflex2 = $_POST["serviceflex2"];
		$serviceflex3 = $_POST["serviceflex3"];
		$serviceflex4 = $_POST["serviceflex4"];
		$serviceflex5 = $_POST["serviceflex5"];

		$query = "INSERT INTO `service` (`authcode`, `userid`, `type`, `description`, `confcomments`, `privacy`, `status`, `assigned`, `serviceflex1`, `serviceflex2`, `serviceflex3`, `serviceflex4`, `serviceflex5`) VALUES ('$authcode', '$userid', '$type', '$description', '$confcomments', '$privacy', 'O', '$assigned', '$serviceflex1', '$serviceflex2', '$serviceflex3', '$serviceflex4', '$serviceflex5')";
		mysqli_query($conn,$query) or die('Error, insert query failed');
		
		header('Location: service.php');
	}
	
}
?>
<br>
<div style="max-width: 99%;">
<div class="nav-section-header-cp">
        <strong>Add a Service Request</strong>
</div>
<!-- UPLOAD FORM -->
<div class="cp-form-container">
<!-- COLUMN 1 -->
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 0px 0px;">
<form enctype="multipart/form-data" method="POST" action="service-add.php">
            <div class="small-12 medium-12 columns"><strong>1) Link Service Request To...</strong><br>
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red"><b>Optional!</b>  When used, the linked user below will be able to access and comment on this Service Request.</span>
            </div>
        </div>
        <div class="row medium-collapse" style="padding: 10px 10px 10px 30px;">
            <div class="small-12 medium-12 columns">
<?php include('userid-field.php'); ?>
                <label for="email_confirmation" class="middle">
                    <input type="checkbox" name="service_email" value="yes" checked> Send email to user?&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Valid only for registered users.</span>
                </label>
            </div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>2) Service Request Information</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-6 columns"><label for="category" class="middle">Select Category<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Contact your webmaster to have categories edited.</span></label></div>
            <div class="small-12 medium-6 end columns">
<?php include('../my-documents/service-categories.php'); ?>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-6 columns"><label for="category" class="middle">Assign this Service Request to...</span></label></div>
            <div class="small-12 medium-6 end columns">
<select name="assigned">
<option value="">Select User</option>
<option value="" disabled></option>
<option value="">None</option>
<option value="" disabled></option>
<?php
	$query  = "SELECT `id`, `last_name`, `first_name`, `unit`, `unit2`, `emailconfirm` FROM `users` WHERE `ghost` != 'Y' AND `status` != 'disabled' AND (`board` = true OR `concierge` = true OR `liaison` = true OR `webmaster` = true) ORDER BY `last_name`";
	$result = mysqli_query($conn, $query);

	while($row1 = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$row1['id']}"; ?>"><?php echo "{$row1['last_name']}"; ?>, <?php echo "{$row1['first_name']}"; ?> (<?php echo "{$row1['unit']}"; ?><?php if ($row1['unit2'] !== 'X'){ ?> - <?php echo "{$row1['unit2']}"; ?><?php }; ?>)  <?php if ($row1['emailconfirm'] == 'B'){ ?> This user&apos;s email address is bouncing!<?php }; ?></option>
<?php
	}
?>
</select>
    <label for="email_confirmation_assigned" class="middle"><input type="checkbox" name="service_email_assigned" value="yes" checked> Send email to assigned user?</span></label>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
<?php include('../my-documents/service-flex-control.php'); ?>
        </div>
    </div>
<!-- END COLUMN 1 -->
<!-- COLUMN 2 -->
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>3) Service Request Description</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 columns"><label for="description" class="middle">Description&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Description and comments <b>ARE</b> visible to the user.</span></label>
                <textarea name="description" class="form" type="text" rows="8" placeholder="Enter a description of your service request here." required></textarea>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 columns"><label for="confcomments" class="middle">Confidential Comments&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Confidential Comments are <b>NOT</b> visible to the user.</span></label>
                <textarea name="confcomments" class="form" type="text" rows="4" placeholder="Enter CONFIDENTIAL comments here - NOT accessible by the user."></textarea>
            </div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>4) Ready to Save?</strong></div>
        </div>
        <div class="row medium-collapse">
            <div class="small-6 columns" align="center">
                <input type="hidden" name="action" value="add">
	            <input name="submit" value="Submit" class="submit" type="submit" onclick="value='Processing Request - Resubmit'; style='color:red';" />
                <?php echo($error); ?>
</form>
            </div>
            <div class="small-6 end columns" align="center">
<form action="service.php" method="get">
	            <input type="submit" value="Cancel" onclick="return confirm('Are you sure you wish to leave this page? Unsaved changes will be lost.');">
</form>
            </div>
        </div>
    </div>
<!-- COLUMN 2 -->
</div>
<!-- END UPLOAD FORM -->

</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Service Request Add Control Panel Page<br></div>
</body>
</html>
