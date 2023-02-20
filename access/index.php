<?php
//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
include('password-head.php');

require '/home/nodyss5/php/PHPMailer-6.3.0/src/PHPMailer.php';
require '/home/nodyss5/php/PHPMailer-6.3.0/src/SMTP.php';
require '/home/nodyss5/php/PHPMailer-6.3.0/src/Exception.php';

require '../my-documents/smtp.php';

$userid = $_SESSION['id'];
$query = "SELECT `first_name`, `last_name`, `email`, `emailconfirm` FROM `users` WHERE `id`= $userid LIMIT 1";
$result = mysqli_query($conn,$query) or die('Error, select query failed');
while($row = $result->fetch_array(MYSQLI_ASSOC)){

    if (($row['emailconfirm'] != 'V') && ($row['emailconfirm'] != 'S')){

        $userfirst = $row['first_name'];
        $userlast = $row['last_name'];
        $username = "$userfirst $userlast";
        $useremail = $row['email'];
        $reseturl = $_SESSION['reseturl'];
        $communityurl = $_SESSION['communityurl'];
        $fromname = "$CommunityName via CondoSites";

        $body = "<!DOCTYPE HTML><html><body><div style='padding: 25px;'>";
        $body .= "<p>Dear ".$username.",</p> <p>In an effort to reduce spam and bounce messages, we are asking all users of the ".$CommunityName." website to confirm their email address.</p>";
        $body .= "<p><big><b><a href=".$reseturl."?email=".$useremail.">Please take a moment to confirm by clicking here</a>.</b></big></p><p>Or you may copy/paste this address into your browser:<br>".$reseturl."?email=".$useremail."</p>";
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
        $mail->Subject = "Verify Your Email Address - $CommunityName via CondoSites";
        $mail->Body = "$body";
        $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        if(!$mail->send()) {

        } else {

            $query = "UPDATE `users` SET `emailconfirm` = 'S' WHERE `id` = $userid LIMIT 1";
            $result = mysqli_query($conn,$query) or die('Error, user not found');

        }
    }
}

// VISITOR TRACKING
    $module = 'Interior Page';
    $page = $_GET['section'];
    $community = $connName;
    $userid = $_SESSION['id'];
    $useripaddress = $_SERVER['REMOTE_ADDR'];
    $queryVISITOR = "INSERT INTO `visitors` (`useripaddress`, `userid`, `community`, `module`, `page`) VALUES ('$useripaddress', '$userid', '$community', '$module', '$page')";
    mysqli_query($conn,$queryVISITOR) or die('Error, insert visitor log failed');

?>
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<!--[if IE]><meta http-equiv="refresh" content="0;url=IE.html" /><![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="CondoSites - http://www.condosites.com" name="author">
	<title><?php include('../my-documents/communityname.html'); ?></title>
	<?php include('../my-documents/meta-robots.html'); ?>
	<link rel="stylesheet" href="../css/foundation.css">
	<link rel="stylesheet" href="../css/magnific-popup.css">
	<link rel="stylesheet" href="../css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/jquery-ui.min.css">
	<link rel="stylesheet" href="../css/jquery-ui.structure.min.css">
	<link rel="stylesheet" href="../css/app.css">
	<link rel="stylesheet" href="../my-documents/app-custom.css">
</head>

<body>

<!-- ******************************************** -->
<!-- MOBILE NEWS DOCS AND LINS SELECTOR -->

<div class="mobile-toggle-container">
  <div id="mobile-toggle">
    <div class="mobile-toggle-nav">Documents and Links</div>
    <div class="mobile-toggle-newsboard mobile-toggle__active">Newsboard</div>
  </div>
</div>

<!-- END MOBILE NEWS DOCS AND LINS SELECTOR -->
<!-- ******************************************** -->

<header>

<!-- ******************************************** -->
<!-- HEALTH BAR -->

<?php include('../control/health.php'); ?>

<!-- END HEALTH BAR -->
<!-- ******************************************** -->

<!-- ******************************************** -->
<!-- GUEST BAR -->

<?php include('guest.php'); ?>

<!-- END GUEST BAR -->
<!-- ******************************************** -->

<!-- ******************************************** -->
<!-- EMAIL VERIFICATION BAR -->

<?php include('emailverificationbar.php'); ?>

<!-- END EMAIL VERIFICATION BAR -->
<!-- ******************************************** -->

<!-- ******************************************** -->
<!-- USER BAR -->

<?php include('accountbar.php'); ?>

<!-- END USER BAR -->
<!-- ******************************************** -->

</header>

<!-- ******************************************** -->
<!-- MAIN CONTENT -->

<div class="background-wrapper">
<div class="container">

<!-- ******************************************** -->
<!-- COMMUNITY PRIDE -->

  <div id="welcome-area">
    <div class="row">

<?php include('../my-documents/access-custom.php'); ?>

    </div>
  </div>

<!-- END COMMUNITY PRIDE -->
<!-- ******************************************** -->

<!-- ******************************************** -->
<!-- NEWS AND NAV COLUMNS -->

<!-- News and Nav Columns Setup -->
<div class="row">

<!-- ******************************************** -->
<!-- DOCUMENTS AND LINKS -->

<!-- Documents and Links Setup -->
<div class="wrap" id="wrap">
<nav id="menu" role="navigation">
  <div class="small-12 large-4 columns">
    <div id="navigation">

<!-- Property Management -->
<?php if ($_GET["section"] == 'owner') { ?><?php include('owner/column-propertymanagement.php'); ?><?php }; ?>
<?php if ($_GET["section"] == 'lease') { ?><?php include('leaser/column-propertymanagement.php'); ?><?php }; ?>
<?php if ($_GET["section"] == 'realtor') { ?><?php include('realtor/column-propertymanagement.php'); ?><?php }; ?>

<!-- Documents -->
<?php if ($_GET["section"] == 'owner') { ?><?php include('owner/column-documents.php'); ?><?php }; ?>
<?php if ($_GET["section"] == 'lease') { ?><?php include('leaser/column-documents.php'); ?><?php }; ?>
<?php if ($_GET["section"] == 'realtor') { ?><?php include('realtor/column-documents.php'); ?><?php }; ?>

<!-- Realtor Special -->
<?php if ($_GET["section"] == 'realtor') { ?><?php include('realtor/column-2minutes.php'); ?><?php }; ?>
<?php if ($_GET["section"] == 'realtor') { ?><?php include('realtor/column-2newsletters.php'); ?><?php }; ?>
<?php if ($_GET["section"] == 'realtor') { ?><?php include('realtor/column-floorplans.php'); ?><?php }; ?>

<!-- Sections -->
<?php if ($_GET["section"] == 'owner') { ?><?php include('owner/column-sections.php'); ?><?php }; ?>
<?php if ($_GET["section"] == 'lease') { ?><?php include('leaser/column-sections.php'); ?><?php }; ?>
<?php if ($_GET["section"] == 'realtor') { ?><?php include('realtor/column-sections.php'); ?><?php }; ?>

<!-- Board -->
<?php if ($_SESSION["board"] == true) { ?><?php include('owner/column-board.php'); ?><?php }; ?>

<!-- Restricted -->
<?php if (($_SESSION["webmaster"] == true) OR ($_SESSION["liaison"] == true) OR ($_SESSION["concierge"] == true) OR ($_SESSION["board"] == true)) { ?><?php include('owner/column-restricted.php'); ?><?php }; ?>

<br>
<br>
<br>

<!-- Documents and Links Setup -->
    </div>
  </div>
</nav>
</div>

<!-- END DOCUMENTS AND LINKS -->
<!-- ******************************************** -->

<!-- ******************************************** -->
<!-- NEWSBOARD -->

<!-- Newsboard Setup -->
<div class="large-8 columns">
<div id="newsboard" class="active">

<!-- Newsboard Banner -->
<?php if ($_GET["section"] == 'owner') { ?><?php include('owner/newsboard-banner.php'); ?><?php }; ?>
<?php if ($_GET["section"] == 'lease') { ?><?php include('leaser/newsboard-banner.php'); ?><?php }; ?>
<?php if ($_GET["section"] == 'realtor') { ?><?php include('realtor/newsboard-banner.php'); ?><?php }; ?>

<!-- Newsboard Articles - Urgent -->
<?php if ($_GET["section"] == 'owner') { ?><?php include('owner/newsboard-articles-urgent.php'); ?><?php }; ?>
<?php if ($_GET["section"] == 'lease') { ?><?php include('leaser/newsboard-articles-urgent.php'); ?><?php }; ?>
<?php if ($_GET["section"] == 'realtor') { ?><?php include('realtor/newsboard-articles-urgent.php'); ?><?php }; ?>

<!-- Upcoming Events - List -->
<?php if ($_GET["section"] == 'owner') { ?><?php include('owner/newsboard-upcomingevents-list.php'); ?><?php }; ?>
<?php if ($_GET["section"] == 'lease') { ?><?php include('owner/newsboard-upcomingevents-list.php'); ?><?php }; ?>

<!-- Upcoming Events - Grid -->
<?php if ($_GET["section"] == 'owner') { ?><?php include('owner/newsboard-upcomingevents-grid.php'); ?><?php }; ?>
<?php if ($_GET["section"] == 'lease') { ?><?php include('owner/newsboard-upcomingevents-grid.php'); ?><?php }; ?>

<!-- 5 Most Recent Documents -->
<?php if ($_GET["section"] == 'owner') { ?><?php include('owner/newsboard-5mostrecent.php'); ?><?php }; ?>
<?php if ($_GET["section"] == 'lease') { ?><?php include('leaser/newsboard-5mostrecent.php'); ?><?php }; ?>
<?php if ($_GET["section"] == 'realtor') { ?><?php include('realtor/newsboard-5mostrecent.php'); ?><?php }; ?>

<!-- Lost Pets -->
<?php if ($_GET["section"] == 'owner') { ?><?php include('owner/newsboard-pets.php'); ?><?php }; ?>
<?php if ($_GET["section"] == 'lease') { ?><?php include('owner/newsboard-pets.php'); ?><?php }; ?>

<!-- Newsboard Articles -->
<?php if ($_GET["section"] == 'owner') { ?><?php include('owner/newsboard-articles.php'); ?><?php }; ?>
<?php if ($_GET["section"] == 'lease') { ?><?php include('leaser/newsboard-articles.php'); ?><?php }; ?>
<?php if ($_GET["section"] == 'realtor') { ?><?php include('realtor/newsboard-articles.php'); ?><?php }; ?>

<!-- Newsboard Footer -->
<?php if ($_GET["section"] == 'owner') { ?><?php include('owner/newsboard-footer.php'); ?><?php }; ?>
<?php if ($_GET["section"] == 'lease') { ?><?php include('leaser/newsboard-footer.php'); ?><?php }; ?>
<?php if ($_GET["section"] == 'realtor') { ?><?php include('realtor/newsboard-footer.php'); ?><?php }; ?>

<br>
<br>
<br>

<!-- Newsboard Setup -->
</div>
</div>

<!-- END NEWSBOARD -->
<!-- ******************************************** -->

<!-- News and Nav Columns Setup -->
</div>

<!-- END NEWS AND NAV COLUMNS -->
<!-- ******************************************** -->

<!-- Main Content -->
</div>
</div>

<!-- END MAIN CONTENT -->
<!-- ******************************************** -->

<!-- ******************************************** -->
<!-- LEGAL -->

	<?php include('../version.php'); ?>

<!-- END LEGAL -->
<!-- ******************************************** -->

</body>

    <script src="../java/vendor/jquery.js"></script>
	<script src="../java/vendor/jquery-ui.min.js"></script>
	<script src="../java/vendor/jquery.magnific-popup.min.js"></script>
	<script src="../java/vendor/what-input.js"></script>
	<script src="../java/vendor/foundation.min.js"></script>
	<script src="../java/app.js"></script>
	<script>
		$(document).foundation();
	</script>
	<script type="text/javascript" src="../java/google-base.js"></script>
	<script type="text/javascript" src="../my-documents/google-code.js"></script>

</html>
