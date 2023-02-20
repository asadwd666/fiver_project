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

$_POST["action"];
?>
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<!--[if IE]><meta http-equiv="refresh" content="0;url=IE.html" /><![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="CondoSites - http://www.condosites.com" name="author">
	<title>Unsubscribe / Update Email Preferences | <?php include('../my-documents/communityname.html'); ?></title>
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
$ghost = htmlspecialchars($_POST['ghost'], ENT_QUOTES);
$useripaddress = $_SERVER['REMOTE_ADDR'];

if($email != "" && $action = 'save'){

	$query = "SELECT `ghost`, `last_name`, `first_name`, `id`, `status` FROM `users` WHERE `email` = '$email' LIMIT 1";
	$result = mysqli_query($conn,$query) or die('Error, select query failed');
	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$id = $row['id'];
		$ghost = $row['ghost'];
		$last_name = $row['last_name'];
		$first_name = $row['first_name'];
		$username = "$first_name $last_name";
		$status = $row['status'];
		$communityurl = $_POST['communityurl'];
        $fromname = "$CommunityName via CondoSites";
		$reseturl = $_POST['reseturl'];
	}

	if($last_name != '' && $ghost != 'Y' && $status == 'active'){

        $ghost = htmlspecialchars($_POST['ghost'], ENT_QUOTES);
		$query = "UPDATE users SET ghost='$ghost' WHERE `email`='$email' LIMIT 1";
		mysqli_query($conn,$query) or die('Error, update query failed');
		
		$subject = "Email Preference Update - $CommunityName via CondoSites";
		$body = "<!DOCTYPE HTML><html><body><div style='padding: 25px;'>";
        $body .= "<p>Dear ".$username.",</p> <p>Your email preferences have been updated.</p>";
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
            
            if($ghost != 'D'){

                $query = "INSERT INTO log (action, tablename, useripaddress, userid) VALUES ('E', 'Email Pref $ghost', '$useripaddress', '$id')";
		        mysqli_query($conn,$query) or die('Error, updating log failed');

        		header('Location: connect-unsubscribe-thanks.php');
        		
            }
            
	        if($ghost == 'D'){

        		$currentdate = date('Y-m-d');
		        $query = "UPDATE users SET `accessdate`='$currentdate', status='disabled' WHERE `email`='$email' LIMIT 1";
		        mysqli_query($conn,$query) or die('Error, update query failed');
		        
		        $queryID = "SELECT `id` FROM `users` WHERE `email` = '$email' LIMIT 1";
		        $resultID = mysqli_query($conn,$queryID);
		        
		        $query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('D', 'Profile Disable-USER', '$useripaddress', '$userid', '$resultID')";
		        mysqli_query($conn,$query) or die('Error, updating log failed');

        		header('Location: connect-unsubscribe-thanks.php');

	        }

        }


	} if($last_name == '' || $ghost == 'Y'){
        $error = '<br><b>Preferences for this email address can only be edited by an <a href="connect-help.php">administrator</a>.</b><br><br>';
	} else {
	    $error = '<br><b>Invalid email address: </b>'.$email.'<br><br>';
	}

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
          <div class="small-12 columns"><h3>Unsubscribe / Update Email Preferences</h3><br></div>
        </div>

	<form method="POST">

        <div class="row">
            <div class="small-12 columns text">
                <label for="email" class="left">Enter your login email address and email preference below.  If your email address matches our records, your email preferences will be updated.</label>
            </div>
        </div>

        <div class="row">
            <div class="small-12 columns text">
	            <input name="email" type="email" class="form" id="email" maxlength="100" placeholder="email@domain.com" value="<?php echo $_GET['email']; ?>" required autofocus/>
	            <p class="note-red"><big><?php echo $error; ?></big></p>
	        </div>
        </div>

        <div class="row">
          <div class="small-5 medium-5 large-5 columns">
	    <label for="email2" class="middle">Email Preference*
          </div>
          <div class="small-7 medium-7 large-7 end columns">

<input type="radio" name="ghost" value="A" <?php if($_POST['ghost'] == 'A'){ ?>checked<?php }; ?> required /><label>Receive&nbsp;All&nbsp;Emails</label><br>
<input type="radio" name="ghost" value="U" <?php if($_POST['ghost'] == 'U'){ ?>checked<?php }; ?> required /><label>Urgent&nbsp;Only</label><br>
<input type="radio" name="ghost" value="N" <?php if($_POST['ghost'] == 'N'){ ?>checked<?php }; ?> required /><label>None/Unsubscribe</label><br>
<br>
<input type="radio" name="ghost" value="D" required /><label>I no longer own/live in the community</label><br>
<br>

          </div>
        </div>
        <div class="row">
          <div class="small-12 columns text">
              <span class="note-red">Click the Update button once!</span><br>
            <input type="hidden" name="action" value="save">
            <input name="reseturl" type="hidden" value="<?php include('../my-documents/communityurl-ssl.html'); ?>/splash/connect-verify.php" readonly />
		    <input name="communityurl" type="hidden" size="1" value="<?php include('../my-documents/communityurl-ssl.html'); ?>" readonly />
	        <input name="submit" value="Update" class="submit" type="submit" onclick="value='Processing Request - Resubmit'; style='color:red';" />
        <p class="note-red"><big><?php echo $error; ?></big></p>
	    <br>
	    <br>
	    <a href="../index.php" target="_parent">Return Home</a>
        <p><span class="note-black"><i><br>*Preference applies only to mass email messages sent by your community via CondoSites software. Other emails related to your profile, such as package delivery notifications, pet and vehicle registrations, service requests, and password reset emails will continue to be sent.</i></span></p></label>
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

If you need additional help, please contact:<br>
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
