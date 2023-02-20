<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '/home/nodyss5/php/PHPMailer-6.3.0/src/PHPMailer.php';
require '/home/nodyss5/php/PHPMailer-6.3.0/src/SMTP.php';
require '/home/nodyss5/php/PHPMailer-6.3.0/src/Exception.php';
//require '/home/nodyss5/php/PHPMailer/PHPMailerAutoload.php';

require_once('../my-documents/php7-my-db-up.php');
require '../my-documents/smtp.php';

?>
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<!--[if IE]><meta http-equiv="refresh" content="0;url=IE.html" /><![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="CondoSites - http://www.condosites.com" name="author">
	<title>Login Help | <?php include('../my-documents/communityname.html'); ?></title>
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	<link rel="stylesheet" href="../css/foundation.css">
	<link rel="stylesheet" href="../css/magnific-popup.css">
	<link rel="stylesheet" href="../css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/jquery-ui.min.css">
	<link rel="stylesheet" href="../css/jquery-ui.structure.min.css">
	<link rel="stylesheet" href="../css/app.css">
	<link rel="stylesheet" href="../my-documents/app-custom.css">
	<script src="../java/vendor/jquery.js"></script>
	<script src="../java/vendor/jquery-ui.min.js"></script>
	<script src="../java/vendor/jquery.magnific-popup.min.js"></script>
</head>

<?php if (empty($_SERVER['HTTPS'])) {
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}; ?>

<body>

<?php

$success = "untried";

$email = htmlspecialchars($_POST['email'], ENT_QUOTES);
$useripaddress = $_SERVER['REMOTE_ADDR'];

if($email != ""){

	$setauthcode = Rand(111111,999999);
	$query = "UPDATE users SET authcode='$setauthcode' WHERE `email`='$email' AND `authcode`='' LIMIT 1";
	mysqli_query($conn,$query) or die('Error, update query failed');

	$query = "SELECT `email`, `first_name`, `last_name`, `ghost`, `authcode`, `id` FROM users WHERE `email` = '$email' LIMIT 1";
	$result = mysqli_query($conn,$query) or die('Error, select query failed');
	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$first_name = $row['first_name'];
		$last_name = $row['last_name'];
		$username = "$first_name $last_name";
		$ghost = $row['ghost'];
		$authcode = $row['authcode'];
		$email = $row['email'];
		$id = $row['id'];
		$communityurl = $_POST['communityurl'];
        $fromname = "$CommunityName via CondoSites";
	}

	if($last_name != '' && $ghost != 'Y'){

        $subject = "Reset Your Password - $CommunityName via CondoSites";
		$body = "<!DOCTYPE HTML><html><body><div style='padding: 25px;'>";
        $body .= "<p>Dear ".$username.",</p> <p>Here is the link to reset your password on your community website:<br>";
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

        $query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('E', 'Password Reset USER', '$useripaddress', '$id', '$authcode')";
		mysqli_query($conn,$query) or die('Error, updating log failed');

    	header('Location: connect-emailed.php');

        }

	} else {
		$success = "false";
	}
}

if($success == "untried"){

?>
<?php
} else if ($success == 'false') {
	$error = '<br>Invalid email address.<br>';
}
?>


<!-- ******************************************** -->
<!-- MAIN CONTENT -->

<!-- Main Content Setup -->
<div class="container">

<!-- ******************************************** -->
<!-- COMMUNITY PRIDE -->

  <div class="row">
    <div class="small-12 small-centered medium-uncentered medium-6 large-12 columns">
      <h1 class="welcome-area-logo">
        <a href="../index.php"><img src="../pics/logo-small.png"></a>
      </h1>
    </div>
  </div>

<!-- END COMMUNITY PRIDE -->
<!-- ******************************************** -->


<!-- ******************************************** -->
<!-- LOGIN -->

<!-- Content Setup -->
  <div class="row">

<!-- Login -->
    <div class="small-12 medium-6 large-6 columns">
      <div class="content-splash-main">

        <div class="row">
          <div class="small-12 columns"><h3>Forgot your password?</h3><br></div>
        </div>

	<form method="POST">

        <div class="row">
          <div class="small-12 columns text">
          <label for="email" class="left">Enter your login email below.  If your email address is valid, a link to reset your password will be sent to that address.</label>
          </div>
        </div>

        <div class="row">
          <div class="small-12 columns text">
	    <input name="email" type="email" class="form" id="email" maxlength="100" placeholder="email@domain.com" required autofocus/>
	  </div>
        </div>

        <div class="row">
          <div class="small-12 columns text">
              <span class="note-red">Click the Send Password Reset Email button once!</span><br>
		<input name="communityurl" type="hidden" value="<?php include('../my-documents/communityurl-ssl.html'); ?>" readonly />
	    <input name="submit" value="Send Password Reset Email" class="submit" type="submit" onclick="value='Processing Request - Resubmit'; style='color:red';" />
        <p class="note-red"><big><?php echo $error; ?></big></p>
	    <br>
	    <br>
	    <a href="../index.php" target="_parent">Return Home</a>
	  </div>
        </div>

	</form>

      </div>
    </div>

<!-- Message -->
    <div class="small-12 medium-6 large-6 columns">
      <div class="content-splash-main">

        <div class="row">
          <div class="small-12 columns"><h3>Other troubles?</h3><br></div>
        </div>

        <div class="row">
          <div class="small-12 columns">

If you do not remember the email you use to login with, please contact:<br>
<br>
<!-- PASSWORD CONTACT -->
<?php
	$query  = "SELECT id, company, contact, phone1, email, name FROM utilities WHERE category = 'Password'";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php if ($row['name'] !== '' AND $row['name'] !== 'none.gif'){ ?><img src="../download-utilities.php?id=<?php echo "{$row['id']}"; ?>" alt="<?php echo "{$row['company']}"; ?>"><br><?php }; ?>
<?php if ($row['company'] !== ''){ ?><b><?php echo "{$row['company']}"; ?></b><br><?php }; ?>
<?php if ($row['contact'] !== ''){ ?></b><?php echo "{$row['contact']}"; ?><br><?php }; ?>
<?php if ($row['phone1'] !== ''){ ?><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row['phone1']); ?>"><?php echo "{$row['phone1']}"; ?></a><br><?php }; ?>
<?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>?subject=Login Help for <?php include('../my-documents/communityname.html'); ?>"><?php echo "{$row['email']}"; ?></a><br><?php }; ?>
<?php
	}
?>
<!-- END PASSWORD CONTACT -->
<!-- PASSWORD CONTACT -->
<?php $sqlPWH = mysqli_query($conn,"SELECT count(*) FROM utilities WHERE category = 'Password'") or die(mysqli_error($conn));
//$countPWH = mysql_result($sqlPWH, "0");
$row = mysqli_fetch_row($sqlPWH);
$countPWH = $row[0];
?>
<?php if ($countPWH == '0'){ ?>
<?php
	$query  = "SELECT id, company, contact, phone1, email, name FROM utilities WHERE category = 'Manager'";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php if ($row['name'] !== '' AND $row['name'] !== 'none.gif'){ ?><img src="../download-utilities.php?id=<?php echo "{$row['id']}"; ?>" alt="<?php echo "{$row['company']}"; ?>"><br><?php }; ?>
<?php if ($row['company'] !== ''){ ?><b><?php echo "{$row['company']}"; ?></b><br><?php }; ?>
<?php if ($row['contact'] !== ''){ ?></b><?php echo "{$row['contact']}"; ?><br><?php }; ?>
<?php if ($row['phone1'] !== ''){ ?><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row['phone1']); ?>"><?php echo "{$row['phone1']}"; ?></a><br><?php }; ?>
<?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>?subject=Login Help for <?php include('../my-documents/communityname.html'); ?>"><?php echo "{$row['email']}"; ?></a><br><?php }; ?>
<?php
	}
?>
<?php }; ?>
<!-- END PASSWORD CONTACT -->

          </div>
        </div>

      </div>


<!-- Message -->

      <div class="content-splash-sub">
        <div class="row">
          <div class="small-12 columns">

<?php if (!empty($_SERVER['HTTPS'])) { ?>
        <div class="row">
          <div class="small-2 medium-2 large-1 columns"><i class="fa fa-lock big" aria-hidden="true"></i></div>
          <div class="small-10 medium-10 large-11 end columns">We are committed to security.<br><small>Your session is encrypted for added protection.</small></div>
        </div>
<?php }; ?>

<?php if (empty($_SERVER['HTTPS'])) { ?>
        <div class="row">
          <div class="small-2 medium-2 large-1 columns"><i class="fa fa-unlock big" aria-hidden="true"></i></div>
          <div class="small-10 medium-10 large-11 end columns">Your session is not SSL encrypted.<br><small>Reload page to try again.</a></small></div>
        </div>
<?php }; ?>

          </div>
        </div>
      </div>

        </div>

      </div>
    </div>

<!-- Content Setup -->
  </div>

<!-- END LOGIN -->
<!-- ******************************************** -->

<!-- End Main Content Setup -->
</div>

</body>

	<script src="../java/vendor/foundation.min.js"></script>
	<script src="../java/app.js"></script>
	<script>
		$(document).foundation();
	</script>
	<script type="text/javascript" src="../java/google-base.js"></script>
	<script type="text/javascript" src="../my-documents/google-code.js"></script>

</html>
