<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '/home/nodyss5/php/PHPMailer-6.3.0/src/PHPMailer.php';
require '/home/nodyss5/php/PHPMailer-6.3.0/src/SMTP.php';
require '/home/nodyss5/php/PHPMailer-6.3.0/src/Exception.php';

require '../my-documents/smtp.php';
include '../my-documents/givbee-config.php';

$current_page = '11';
include('protect.php');

$id = $_POST["id"];
$action = $_POST["action"];
if ($action == "save"){

  $sms_opt_in = $_POST['sms_optin'];
	$useripaddress = $_SERVER['REMOTE_ADDR'];
	$first_name = htmlspecialchars($_POST['first_name'], ENT_QUOTES);
	$last_name = htmlspecialchars($_POST['last_name'], ENT_QUOTES);
	$unit = htmlspecialchars($_POST['unit'], ENT_QUOTES);
	$unit2 = htmlspecialchars($_POST['unit2'], ENT_QUOTES);
	$email = htmlspecialchars($_POST['email'], ENT_QUOTES);
	$phone = htmlspecialchars($_POST['phone'], ENT_QUOTES);
	$status = htmlspecialchars($_POST['status'], ENT_QUOTES);
	$owner = $_POST["owner"];
	$realtor = $_POST["realtor"];
	$lease = $_POST["lease"];
	$board = $_POST["board"];
	$concierge = $_POST["concierge"];
	$liaison = $_POST["liaison"];
	$directory = $_POST["directory"];
	$dphone = $_POST["dphone"];
	$hide = $_POST["hide"];
	$accessdate = $_POST["accessdate"];
	$account = htmlspecialchars($_POST['account'], ENT_QUOTES);
	$comments = htmlspecialchars($_POST['comments'], ENT_QUOTES);
	$ghost = $_POST["ghost"];
	$flex1 = htmlspecialchars($_POST['flex1'], ENT_QUOTES);
	$flex2 = htmlspecialchars($_POST['flex2'], ENT_QUOTES);
	$flex3 = htmlspecialchars($_POST['flex3'], ENT_QUOTES);
	$flex4 = htmlspecialchars($_POST['flex4'], ENT_QUOTES);
	$flex5 = htmlspecialchars($_POST['flex5'], ENT_QUOTES);
	$club1 = htmlspecialchars($_POST['club1'], ENT_QUOTES);
	$club2 = htmlspecialchars($_POST['club2'], ENT_QUOTES);
	$club3 = htmlspecialchars($_POST['club3'], ENT_QUOTES);
	$club4 = htmlspecialchars($_POST['club4'], ENT_QUOTES);
	$club5 = htmlspecialchars($_POST['club5'], ENT_QUOTES);
	$packagepreference = htmlspecialchars($_POST['packagepreference'], ENT_QUOTES);
	$packagedid = htmlspecialchars($_POST['packagedid'], ENT_QUOTES);

	$query = "SELECT email FROM users WHERE email = '$email' AND `id` != '$id'";
	$result = mysqli_query($conn, $query);
	$email_taken = false;
	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$email_taken = true;
	}

	if($email_taken == true){

		$success = "false";
		$errorEmail = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> <span class='note-red'>That email address is already in use!</span>";
		$errorStyle = "background-color: #ffcccc;";

	} else {

	    $query = "UPDATE users SET first_name='$first_name', last_name='$last_name', unit='$unit', unit2='$unit2', email='$email', phone='$phone', status='$status', owner='$owner', realtor='$realtor', lease='$lease', board='$board', concierge='$concierge', liaison='$liaison', directory='$directory', dphone='$dphone', hide='$hide', accessdate='$accessdate', account='$account', comments='$comments', ghost='$ghost', flex1='$flex1', flex2='$flex2', flex3='$flex3', flex4='$flex4', flex5='$flex5', club1='$club1', club2='$club2', club3='$club3', club4='$club4', club5='$club5', packagepreference='$packagepreference', packagedid='$packagedid', sms_opt_in='$sms_opt_in' WHERE `id`='$id' LIMIT 1";
	    mysqli_query($conn,$query) or die('Error, update query failed');

	    $useripaddress = $_SERVER['REMOTE_ADDR'];
	    $userid = $_SESSION['id'];
	    $id = $_POST['id'];
	    $comment = $last_name.", ".$first_name." ".$email." P:".$owner.$lease.$realtor." ".$board.$concierge.$liaison." ".$status." ".$accessdate." ".$comments;
	    $query = "INSERT INTO log (action, tablename, useripaddress, userid, id, comment) VALUES ('E', 'Passwords', '$useripaddress', '$userid', '$id', '$comment')";
	    mysqli_query($conn,$query) or die('Error, updating log failed');

            if (!empty($sms_url)) {
                $params = array(
                    'firstname' => $first_name,
                    'lastname' => $last_name,
                    'phone' => $phone,
                    'owner' => $owner,
                    'realtor' => $realtor,
                    'renter' => $lease,
                    'Group2' => empty($unit2) ? 'X' : $unit2,
                    'unit' => $unit
                );
                if (!isset($_POST['sms_optin']) || empty($_POST['sms_optin'])) {
                    $params['optin'] = 'delete';
                }

                $postStr = http_build_query($params);
                $options = array(
                    'http' =>
                        array(
                            'method' => 'POST', //We are using the POST HTTP method.
                            'header' => 'Content-type: application/x-www-form-urlencoded',
                            'content' => $postStr //Our URL-encoded query string.
                        )
                );
                $streamContext = stream_context_create($options);
                $result = file_get_contents($sms_url, false, $streamContext);


        }

    	header('Location: passwords.php');
    }
}

if(($_POST['id']) && ($_POST['status_email']) == "yes"){
	$error = "";

    $user = $_POST['id'];
    $query  = "SELECT `first_name`, `last_name`, `email` FROM `users` WHERE `id` = '$user'";
    $result = mysqli_query($conn, $query);
	while($row = $result->fetch_array(MYSQLI_ASSOC)){
	    $userfirst = $row['first_name'];
        $userlast = $row['last_name'];
        $username = "$userfirst $userlast";
        $useremail = $row['email'];
    }
	
    $reseturl = $_SESSION['reseturl'];
    $communityurl = $_SESSION['communityurl'];
    $fromname = "$CommunityName via CondoSites";

    $body = "<!DOCTYPE HTML><html><body><div style='padding: 25px;'>";
    $body .= "<p>Dear ".$username.",</p>";
    if($_POST["liaison"] == '0'){
        $body .= "<p>Welcome to the ".$CommunityName." community website, powered by CondoSites!</p><p><b><big>Your account is now ".$_POST['status']."</big></b>.</p>";
    }
    if($_POST["liaison"] != '0'){
        $body .= "<p>Welcome to the ".$CommunityName." community website, powered by CondoSites!</p><p><b>Your account is now ".$_POST['status']."</b>.</p><p><b>Are you a new CondoSites Administrator?</b><br>Watch our three of 5-minute orientation videos at <a href='https://condosites.com/help'>https://condosites.com/help</a>.</p>";
    }
    if($_POST["emailconfirm"] != 'V'){
        $body .= "<p><big><b><a href=".$communityurl."/splash/connect-verify.php?email=".$useremail.">Please take a moment to confirm your email address by clicking here</a>.</b></big></p>";
    }
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
    $mail->Subject = "Your $CommunityName Community Website by CondoSites";
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

if(($_POST['status_email'] != "yes") && ($_POST["email"] != $_POST["oldemail"])){

    $user = $_POST['id'];
    $query  = "SELECT `first_name`, `last_name`, `email` FROM `users` WHERE `id` = '$user'";
    $result = mysqli_query($conn, $query);
	while($row = $result->fetch_array(MYSQLI_ASSOC)){
	    $userfirst = $row['first_name'];
        $userlast = $row['last_name'];
        $username = "$userfirst $userlast";
        $useremail = $row['email'];
    }
	
    $reseturl = $_SESSION['reseturl'];
    $communityurl = $_SESSION['communityurl'];
    $fromname = "$CommunityName via CondoSites";

    $body = "<!DOCTYPE HTML><html><body><div style='padding: 25px;'>";
    $body .= "<p>Dear ".$username.",</p>";
    if($_POST["liaison"] == '0'){
        $body .= "<p>Welcome to the ".$CommunityName." community website, powered by CondoSites!</p><p><b><big>Your account is now ".$_POST['status']." and your email address has been updated.</big></b>.</p>";
    }
    if($_POST["liaison"] != '0'){
        $body .= "<p>Welcome to the ".$CommunityName." community website, powered by CondoSites!</p><p><b>Your account is now ".$_POST['status']." and your email address has been updated.</b>.</p><p><b>If you are new to CondoSites, be sure to watch our series of 5-minute orientation videos available at <a href='https://condosites.com/help'>https://condosites.com/help</a>.</b></p>";
    }
    if($_POST["emailconfirm"] != 'V'){
        $body .= "<p><big><b><a href=".$communityurl."?email=".$useremail.">Please take a moment to confirm your email address by clicking here</a>.</b></big></p>";
    }
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
    $mail->Subject = "Your $CommunityName Community Website by CondoSites";
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

if(($_POST['id']) && ($_POST['passwordReset']) == "yes"){
	$setauthcode = Rand(000000,999999);
	$query = "UPDATE users SET authcode='$setauthcode' WHERE `email`='$email' LIMIT 1";
	mysqli_query($conn,$query) or die('Error, update query failed');

    $email = htmlspecialchars($_POST['email'], ENT_QUOTES);
	$query = "SELECT `email`, `first_name`, `last_name`, `ghost`, `authcode`, `id` FROM `users` WHERE `email` = '$email' LIMIT 1";
	$result = mysqli_query($conn,$query) or die('Error, select query failed');
	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$first_name = $row['first_name'];
		$last_name = $row['last_name'];
		$username = "$first_name $last_name";
		$ghost = $row['ghost'];
		$authcode = $row['authcode'];
		$email = $row['email'];
		$id = $row['id'];
	}
	if($last_name != '' && $ghost != 'Y'){
		
		$reseturl = $_SESSION['reseturl'];
        $communityurl = $_SESSION['communityurl'];
        $fromname = "$CommunityName via CondoSites";
		
		$subject = "Reset Your Password - $CommunityName via CondoSites";
		$body = "<!DOCTYPE HTML><html><body><div style='padding: 25px;'>";
        $body .= "<p>Dear ".$username.",</p> <p>Here is the link to reset your password on your community website, sent by the administrator of your website:<br>";
        $body .= "<a href=".$communityurl."/splash/connect-reset.php?email=".$email."&authcode=".$authcode.">".$communityurl."/splash/connect-reset.php?email=".$email."&authcode=".$authcode."</a></p>";
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
        $mail->setFrom($fromemailOPS, $fromname);

        $mail->addAddress($email, $username);
        $mail->Subject = "$subject";
        $mail->Body = "$body";
        $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        if(!$mail->send()) {

        } else {

        $query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('E', 'Password Reset ADMIN', '$useripaddress', '$id', '$authcode')";
		mysqli_query($conn,$query) or die('Error, updating log failed');

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
    <script type="text/javascript">
	<!--
	  function showMe (it, box) {
		var vis = (box.checked) ? "block" : "none";
		document.getElementById(it).style.display = vis;
	  }
	  //-->
	</script>
</head>
<body>
<!-- LOGO AND NAVIGATION -->
<?php include('cp-navigation.php'); ?>
<!-- END LOGO AND NAVIGATION -->
<br>
<div style="max-width: 99%;">
<div class="nav-section-header-cp">
        <strong>Edit a User Account</strong>
</div>
<!-- INPUT FORM -->
<?php
    $helpEmailStyle = "background-color: #ffcccc; margin-bottom: 10px; margin-right: -10px; padding-right: 10px;";
    $helpStyle = "background-color: #ffcccc; margin-right: -10px; padding-right: 10px;";
	$currentdate = date("Y-m-d");
	$query  = "SELECT `id`, `unit`, `unit2`, `last_name`, `first_name`, `email`, `phone`, `useripaddress`, `owner`, `lease`, `realtor`, `board`, `concierge`, `liaison`, `account`, `comments`, `status`, `created_date`, `useripaddress`, `logindate`, `loginip`, `directory`, `dphone`, `phone`, `hide`, `accessdate`, `ghost`, `flex1`, `flex2`, `flex3`, `flex4`, `flex5`, `packagepreference`, `packagedid`, `authcode`, `emailconfirm`, `sms_opt_in` FROM users WHERE `id`='$id' LIMIT 1";
	$result = mysqli_query($conn, $query);

	$row = $result->fetch_array(MYSQLI_ASSOC);
	if (!empty($row))
	{

        if (!empty($sms_url)) {
            $params = array(
                'firstname' => $row['first_name'],
                'lastname' => $row['last_name'],
                'phone' => $row['phone'],
                'owner' => $row['owner'],
                'realtor' => $row['realtor'],
                'renter' => $row['lease'],
                'Group2' => empty($row['unit2']) ? 'X' : $row['unit2'],
                'unit' => $row['unit'],
                'optin' => 'status'
            );

            $postStr = http_build_query($params);
            $options = array(
                'http' =>
                    array(
                        'method' => 'POST', //We are using the POST HTTP method.
                        'header' => 'Content-type: application/x-www-form-urlencoded',
                        'content' => $postStr //Our URL-encoded query string.
                    )
            );
            $streamContext = stream_context_create($options);
            $givbee_result = file_get_contents($sms_url, false, $streamContext);
            
        }
        
      if ($row['status'] == 'Active') {
        $row['sms_opt_in'] = ($givbee_result == "Opted-In" ? 1 : 0);
      }
?>
<!-- UPLOAD FORM -->
<div class="cp-form-container">
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 0px 0px;">
<form enctype="multipart/form-data" method="POST" action="passwords-edit.php">
            <div class="small-12 medium-12 columns"><strong>1) User Information...</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="first_name" class="middle">First Name</label></div>
            <div class="small-12 medium-7 end columns"><input name="first_name" value="<?php echo "{$row['first_name']}"; ?>" placeholder="John" maxlength="100" class="form" type="text" required autofocus></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="last_name" class="middle">Last Name</label></div>
            <div class="small-12 medium-7 end columns"><input name="last_name" value="<?php echo "{$row['last_name']}"; ?>" placeholder="Doe" maxlength="100" class="form" type="text" required></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px; <?php echo($errorStyle); ?> <?php if ($row['email'] == '') { echo($helpEmailStyle); }; ?>">
<?php if ($row['email'] == '') { ?>
            <div class="small-12 medium-12 columns"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="note-red">The user can&apos;t login without an email address.</span></div>
<?php }; ?>
            <div class="small-12 medium-12 columns">
                <?php echo($errorEmail); ?>
            </div>
            <div class="small-12 medium-5 columns"><label for="email" class="middle">Email Address</label></div>
            <div class="small-12 medium-7 end columns">
                <?php if ($row['emailconfirm'] == 'V'){ ?><small><i class='fa fa-check' aria-hidden='true'></i> <i>This user has verified their email address.</i></small><?php }; ?>
                <?php if ($row['emailconfirm'] != 'V'){ ?><small><i class='fa fa-exclamation-triangle' aria-hidden='true'></i> <i>This user has NOT verified their email address.</i></small><?php }; ?>
                <?php if ($row['emailconfirm'] == 'B'){ ?><br><small><i class='fa fa-exclamation-triangle' aria-hidden='true'></i> <i>This user&apos;s email address is bouncing.</i></small><?php }; ?>
                <input name="email" value="<?php echo "{$row['email']}"; ?>" maxlength="100" class="form" type="email" placeholder="john@somewhere.com" required>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="phone" class="middle">Phone Number</label></div>
            <div class="small-12 medium-7 end columns"><input name="phone" value="<?php echo "{$row['phone']}"; ?>" maxlength="100" class="form" type="tel" placeholder="000-000-0000" required></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="account" class="middle"><img src="https://condosites.com/commons/Zego_logo.png" width="25%"> &nbsp;Account Number</label></div>
            <div class="small-12 medium-7 end columns"><input name="account" class="form" id="account" maxlength="20" type="text" placeholder="optional" value="<?php echo "{$row['account']}"; ?>"></div>
        </div>
        <div class="row" style="padding: 10px 10px 0px 0px;">
            <div class="small-12 medium-12 columns"><strong>2) Community Information</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <?php include('../my-documents/units-table-edit.php'); ?>
        </div>

<?php include('../my-documents/user-flex-edit.php'); ?>
<?php include('../my-documents/user-club-control.php'); ?>

        <div class="row medium-collapse" style="padding-left: 30px; <?php if ($row['accessdate'] >= '0000-00-01' && $row['accessdate'] <= $currentdate) { echo($helpStyle); }; ?>">
<?php if ($row['accessdate'] >= '0000-00-01' && $row['accessdate'] <= $currentdate) { ?>
            <div class="small-12 medium-12 columns" style="padding-top: 10px;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="note-red">The user has reached the end of their lease/access date.</span></div>
<?php }; ?>
            <div class="small-12 medium-5 columns"><label for="accessdate" class="middle">Lease/Access Through Date</label></div>
            <div class="small-12 medium-7 end columns"><input name="accessdate" class="datepicker" type="date" value="<?php echo "{$row['accessdate']}"; ?>" placeholder="Leave blank if not used."></div>
        </div>
        <div class="row" style="padding: 10px 10px 0px 0px;">
            <div class="small-12 medium-12 columns"><strong>3) User Preferences</strong><br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Do not modify these settings without the user&apos;s consent.</span></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 end columns">
                <label for="hide" class="middle">
                <input type="checkbox" name="directory" value="Y" <?php if ($row['directory'] == 'Y'){ ?>checked ="true"<?php }; ?>> Display Email Address in User Directory
                <br><input type="checkbox" name="dphone" value="Y" <?php if ($row['dphone'] == 'Y'){ ?>checked ="true"<?php }; ?>> Display Phone Number in User Directory
                <br><input type="checkbox" name="hide" value="Y" <?php if ($row['hide'] == 'Y'){ ?>checked ="true"<?php }; ?>> Override preferences and hide user from directory?
                </label>
            </div>
            <div class="small-12 medium-12 columns"><label for="ghost" class="middle"> Email preference &nbsp;
                <input type="radio" name="ghost" value="U" <?php if($row['ghost'] == 'U'){ ?>checked<?php }; ?>> Urgent Only&nbsp;&nbsp;
                <input type="radio" name="ghost" value="A" <?php if($row['ghost'] == 'A'){ ?>checked<?php }; ?>> All &nbsp;&nbsp;
                <input type="radio" name="ghost" value="N" <?php if($row['ghost'] == 'N'){ ?>checked<?php }; ?>> None
                <br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">For email sent through the Messages control panel.</span></label>
            </div>

        <!-- Givbee Integration -->
        <?php if (isset($sms_url) && !empty($sms_url)) { ?>
            <div class="small-12 medium-12 columns">
                <label for="ghost" class="middle">
                <input type="checkbox" name="sms_optin" value="1" <?php echo ($row['sms_opt_in'] == 1) ? 'checked' : '';?> > SMS Text Messaging Opt-In
                <br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">For text messages sent through GivBee.</span>
                </label>
            </div>
        <?php } ?>
        <!-- End Givbee Integration -->

        </div>

        <div class="row medium-collapse" style="padding-left: 30px;">
            <?php include('../my-documents/user-packagepreference-edit.php'); ?>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <?php include('../my-documents/user-packagedid-edit.php'); ?>
        </div>
    </div>
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>4) User Permissions</strong></div>
        </div>
        <div class="small-12 medium-7 columns">
<?php if ($row['owner'] == '0' AND $row['lease'] == '0' AND $row['realtor'] == '0') { ?>
        <div class="small-12 medium-12 columns" style="padding-top: 10px;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="note-red">The user has has no permissions.</span></div>
<?php }; ?>
        <div class="row medium-collapse" style="padding-left: 30px; <?php if ($row['owner'] == '0' AND $row['lease'] == '0' AND $row['realtor'] == '0') { echo($helpStyle); }; ?>">
            <div class="small-12 medium-8 columns"><label for="owner" class="middle"><b>Owner</b> Access? </label></div>
            <div class="small-12 medium-4 end columns" style="padding-right: 15px;">
<select name="owner" class="form">
<option value="1" <?php if($row['owner'] == "1"){ echo("SELECTED"); } ?>>Yes</option>
<option value="0" <?php if($row['owner'] == "0"){ echo("SELECTED"); } ?>>No</option>
</select>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px; <?php if ($row['owner'] == '0' AND $row['lease'] == '0' AND $row['realtor'] == '0') { echo($helpStyle); }; ?>">
            <div class="small-12 medium-8 columns"><label for="lease" class="middle"><b>Renter</b> Access? </label></div>
            <div class="small-12 medium-4 end columns" style="padding-right: 15px;">
<select name="lease" class="form">
<option value="0" <?php if($row['lease'] == "0"){ echo("SELECTED"); } ?>>No</option>
<option value="1" <?php if($row['lease'] == "1"){ echo("SELECTED"); } ?>>Yes</option>
</select>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px; <?php if ($row['owner'] == '0' AND $row['lease'] == '0' AND $row['realtor'] == '0') { echo($helpStyle); }; ?>">
            <div class="small-12 medium-8 columns"><label for="realtor" class="middle"><b>Realtor</b> Access? </label></div>
            <div class="small-12 medium-4 end columns" style="padding-right: 15px;">
<select name="realtor" class="form">
<option value="0" <?php if($row['realtor'] == "0"){ echo("SELECTED"); } ?>>No</option>
<option value="1" <?php if($row['realtor'] == "1"){ echo("SELECTED"); } ?>>Yes</option>
</select>
            </div>
        </div>
        </div>
        <div class="small-12 medium-5 columns">
<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red"><b>Users</b> should be assigned to ONLY ONE user group.<br><br></span>
<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red"><b>Administrators</b> should be assigned to ALL THREE groups in order to preview content.</span>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>5) Control Panel Permissions</strong></div>
        </div>
        <div class="small-12 medium-7 columns">
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-8 columns"><label for="board" class="middle"><b>Board</b> Access? </label></div>
            <div class="small-12 medium-4 end columns" style="padding-right: 15px;">
<select name="board">
<option value="1" <?php if($row['board'] == "1"){ echo("SELECTED"); } ?>>Yes</option>
<option value="0" <?php if($row['board'] == "0"){ echo("SELECTED"); } ?>>No</option>
</select>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-8 columns"><label for="concierge" class="middle"><b>Concierge/Staff</b> Access? </label></div>
            <div class="small-12 medium-4 end columns" style="padding-right: 15px;">
<select name="concierge">
<option value="1" <?php if($row['concierge'] == "1"){ echo("SELECTED"); } ?>>Yes</option>
<option value="0" <?php if($row['concierge'] == "0"){ echo("SELECTED"); } ?>>No</option>
</select>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-8 columns"><label for="liaison" class="middle"><b>Full Administrator</b> Access? </label></div>
            <div class="small-12 medium-4 end columns" style="padding-right: 15px;">
<select name="liaison">
<option value="1" <?php if($row['liaison'] == "1"){ echo("SELECTED"); } ?>>Yes</option>
<option value="0" <?php if($row['liaison'] == "0"){ echo("SELECTED"); } ?>>No</option>
</select>
            </div>
        </div>
        </div>
        <div class="small-12 medium-5 columns">
<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red"><b>Administrators</b> may be assigned to multiple control panel groups.<br><br></span>
<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">The control panels that each group has access to is defined in the Control Panel Groups control panel.</span>
        </div>
        <div class="row" style="padding: 10px 10px 0px 0px;">
            <div class="small-12 medium-12 columns"><strong>6) Access and Password Help</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px; <?php if ($row['status'] != 'active') { echo($helpStyle); }; ?>">
<?php if ($row['status'] != 'active') { ?>
            <div class="small-12 medium-12 columns" style="padding-top: 10px;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="note-red">The user is not approved for access.</span></div>
<?php }; ?>
            <div class="small-12 medium-3 columns"><label for="status" class="middle">Account Status</label></div>
            <div class="small-12 medium-9 end columns">
<select name="status">
<?php if ($row['status'] == 'disabled') { ?>
<option value="disabled" <?php if($row['status'] == "disabled"){ echo("SELECTED"); } ?>>Disabled User</option>
<?php }; ?>
<?php if ($row['status'] == 'new') { ?>
<option value="new" <?php if($row['status'] == "new"){ echo("SELECTED"); } ?>>New User Awaiting Approval</option>
<?php }; ?>
<option value="active" <?php if($row['status'] == "active"){ echo("SELECTED"); } ?>>Active User</option>
<option value="suspended" <?php if($row['status'] == "suspended"){ echo("SELECTED"); } ?>>Suspended User</option>
</select>
<div style="font-size: .9rem; margin-top: -10px; padding-bottom: 10px;"><input type="checkbox" name="status_email" value="yes"> Send confirmation email to user?</div>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-3 columns"><label for="password" class="middle">Password&nbsp;Help</label></div>
            <div class="small-12 medium-9 columns">
<?php if ($row['authcode'] != ''){ ?>
<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="note-red">This user has a Password Reset in progress!<br><b>If the user has not received their password reset email</b>, verify their email address and instruct them to check their spam folder.  If the email address is incorrect, make the correction on this page, then check the box to send them another password reset email.</span>
<br><div style="font-size: .9rem; padding-top: 5px;">Send another password reset email to user? <input type="checkbox" name="passwordReset" value="yes"></div>
<?php }; ?>
<?php if ($row['authcode'] == ''){ ?>
<label for="passwordhelp" class="middle" style="margin-bottom: -5px;"><input type="checkbox" name="passwordhelp" onclick="showMe('passwordhelp', this)" /> Password Reset Assistance</label>
<div id="passwordhelp" style="display:none">
<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red"><b>Only the user can change their password!</b><br>For lost passwords, <b>verify the user's email address with what is entered on this screen</b>, then check the box below to send them a password reset email.</span>
<br><div style="font-size: .9rem; padding-top: 5px;"><input type="checkbox" name="passwordReset" value="yes"> Send password reset email to user?</div>
</div>
<?php } ?>
            </div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
                    <div class="small-12 medium-12 columns"><strong>7) Comments</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 columns"><span style="font-size: .9rem;">Comments&nbsp;&nbsp;&nbsp;&nbsp;</span><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Comments are NOT visible to the user.</span>
                <textarea name="comments" class="form" type="text"><?php echo "{$row['comments']}"; ?></textarea>
                <div class="note-black" style="padding-top: -10px;">
                    Profile created <b><?php echo "{$row['created_date']}"; ?></b> from IP <b><?php echo "{$row['useripaddress']}"; ?></b>
                    <?php if ($_SESSION['webmaster'] == '1'){ ?>Last login <b><?php echo "{$row['logindate']}"; ?></b> from IP <b><?php echo "{$row['loginip']}"; ?></b><?php }; ?>
                </div>
            </div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
                <div class="small-12 medium-12 columns"><strong>8) Ready to Save?</strong></div>
        </div>
        <div class="row medium-collapse">
            <div class="small-6 columns" align="center">
<input name="reseturl" type="hidden" value="<?php include('../my-documents/communityurl-ssl.html'); ?>/splash/connect-reset.php">
<input name="verifyurl" type="hidden" value="<?php include('../my-documents/communityurl-ssl.html'); ?>/splash/connect-verify.php">
<input type="hidden" name="action" value="save">
<input type="hidden" name="oldemail" value="<?php echo $row['email']; ?>">
<input type="hidden" name="emailconfirm" value="<?php echo $row['emailconfirm']; ?>">
<input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
<input name="submit" value="Save" class="submit" type="submit" onclick="value='Processing Request - Resubmit'; style='color:red';" />

<!-- EMAIL BODY CONTENT -->
<div style="visibility: hidden; margin-bottom: -100px;">
<textarea cols="10" rows="1" <?php if ($_SESSION['webmaster'] == '0'){ ?>readonly<?php }; ?> name="messagebodystart"><?php include('../splash/email-body-start.php'); ?></textarea>
<textarea cols="10" rows="1" <?php if ($_SESSION['webmaster'] == '0'){ ?>readonly<?php }; ?> name="messagebodyfinish"><?php include('../splash/email-body-finish.php'); ?></textarea>
</div>
<!-- END EMAIL BODY CONTENT -->

            </div>
</form>
            <div class="small-6 end columns" align="center">
<form action="passwords.php" method="get">
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
<!-- END INPUT FORM -->
<?php if ($_SESSION['webmaster'] == true){ ?>
<br>
<!-- LOG -->
<div class="nav-section-header-cp">
        <strong>Change Log</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr align="left">
      <th width="100" align="left" class="table-sortable:numeric">&nbsp;&nbsp;&nbsp; <b><small>Log ID</small></b></th>
      <th align="left" class="table-sortable:datetime">&nbsp;&nbsp;&nbsp; <b><small>Timestamp</small></b></th>
      <th align="left" class="table-sortable:alphanumeric table-filterable">&nbsp;&nbsp;&nbsp; <b><small>User</small></b></th>
      <th align="left" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <b><small>Action</small></b></th>
      <th align="left" class="table-sortable:numeric table-filterable">&nbsp;&nbsp;&nbsp; <b><small>User IP</small></b></th>
    </tr>
  </thead>
  <tbody style="background-color:#ffffff">
<!-- LOG -->
<?php
	$type    = $_POST['id'];
	$queryLOG  = "SELECT `init1`, `created_date`, `action`, `tablename`, `id`, `userid`, `useripaddress`, `comment` FROM `log` WHERE `tablename` like '%Passwords%' AND `id` = '$type' ORDER BY `created_date` DESC";
	$resultLOG = mysqli_query($conn,$queryLOG);

	while($rowLOG = $resultLOG->fetch_array(MYSQLI_ASSOC))
	{
?>
    <tr>
      <td><?php echo "{$rowLOG['init1']}"; ?></td>
      <td><?php echo "{$rowLOG['created_date']}"; ?></td>
      <td>
<?php
	$type    = $rowLOG['userid'];
	$query1  = "SELECT * FROM users WHERE id = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?>
<?php echo "{$row1['last_name']}"; ?>, <?php echo "{$row1['first_name']}"; ?>
<?php
	}
?>
(<?php echo "{$rowLOG['userid']}"; ?>)
      </td>
      <td>
	<?php if ($rowLOG['action'] == 'A'){ ?>Advanced<?php }; ?>
	<?php if ($rowLOG['action'] == 'D'){ ?>Delete<?php }; ?>
	<?php if ($rowLOG['action'] == 'E'){ ?>Edit<?php }; ?>
	<br><?php echo "{$rowLOG['comment']}"; ?>
      </td>
      <td><?php echo "{$rowLOG['useripaddress']}"; ?></td>
    </tr>
<?php
	}
?>
  </tbody>
</table>
<?php }; ?>
<!-- LOG -->
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>User Accounts Edit Control Panel Page<br></div>
</body>
</html>
