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

if($_POST['action'] == "email_remind"){
	$error = "";
	
	if($useremail == ""){
		$useremail = $_POST['email'];
	}
	
	$query  = "SELECT `first_name`, `last_name`, `email` FROM `users` WHERE `email` = '$useremail'";
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
    $mail->Port = $smtpportMSG;
    $mail->SMTPSecure = $smtpsecureMSG;
    $mail->SMTPAutoTLS = $smtpautotlsMSG;
    $mail->SMTPSecure = $smtpsecureCNG;
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
        $errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Reminder email was not sent.</strong></div>";
    } else {
        $errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Reminder email was sent to $username ($useremail).</strong></div>";
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
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
		
		$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Package deleted successfully.</strong></div>";
		
		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['int1'];
		
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('D', 'Packages', '$useripaddress', '$userid','$id')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

	}
	
}
?>
<!-- HEALTH AND HELP -->
<div>
    <div class="large-8 columns" style="padding: 0px">
        <div class="nav-section-header-health-cp" align="center">
<big><i class="fa fa-stethoscope" aria-hidden="true"></i></big><strong>&nbsp;Health&nbsp;&nbsp;&nbsp;</strong>
<?php $sqlPAK = mysqli_query($conn,"SELECT count(*) FROM packages WHERE `pickedup` = '0000-00-00 00:00:00' AND `received` < NOW() - INTERVAL 15 DAY") or die(mysqli_error($conn));
//$countPAK = mysql_result($sqlPAK, "0");
$row = mysqli_fetch_row($sqlPAK);
$countPAK = $row[0];
?>
<?php if ($countPAK >= '1'){ ?><i class="fa fa-exclamation-triangle note" aria-hidden="true"></i> You have undelivered packages over 15 days old.<?php }; ?>
<?php if ($countPAK == '0'){ ?><i class="fa fa-check" aria-hidden="true"></i> All of your old packages are delivered.<?php }; ?>
        </div>
    </div>
    <div class="large-4 columns" style="padding: 0px">
        <div class="nav-section-header-health-cp" align="center" style="background-color: lightyellow;">
            <big><i class="fa fa-clock-o" aria-hidden="true"></i></big> Auto refresh in <span style="color:#990000" id="countdown">60</span> minutes.&nbsp; (<a href="packages.php">Reset Timer</a>)
        </div>
    </div>
</div>
<!-- HEALTH AND HELP -->
<br>&nbsp;
<?php echo($errorSUCCESS); ?>
<div style="max-width: 99%;">
<!-- ALL PACKAGES -->
<div class="nav-section-header-cp">
        <strong><?php $sql = mysqli_query($conn,"SELECT count(*) FROM packages WHERE `pickedup` = '0000-00-00 00:00:00' OR (`pickedup` BETWEEN CURDATE() - INTERVAL 100 DAY AND SYSDATE())") or die(mysqli_error($conn));
        //$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?> Total Packages - including packages delivered from <?php echo date("Y-m-d", strtotime($date ."-101 days" )); ?></strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
    <thead>
        <tr>
            <th colspan="100">
<div style="float:right">
	<form action="packages-add.php">
	  <input type="submit" value="Add Packages & Deliveries" onclick="value='Processing Request - Add Packages & Deliveries'; style='color:red';" />
	</form>
</div>
<div style="float:left">
	<form action="packages.php">
	  <input type="submit" value="Return to Main Packages page" onclick="value='Processing Request - Return to Main Packages Page'; style='color:red';" />
	</form>
</div>
<div style="float:left">
	<form action="reports/csv-packages-all.php">
	  <input type="submit" value="Download all packages in CSV format" onclick="value='Processing Request - Re-Download'; style='color:red';" />
	</form>
</div>
            </th>
        </tr>
        <tr>
            <th colspan="100">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Delivered packages remain for 100 days after delivery.</span>
            </th>
        </tr>
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
	$query  = "SELECT * FROM packages WHERE `pickedup` = '0000-00-00 00:00:00' OR (`pickedup` BETWEEN CURDATE() - INTERVAL 101 DAY AND SYSDATE()) ORDER BY `int1` DESC";
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
	                <form name="PKGDelete" method="POST" action="packages-all.php" onclick="return confirm('Are you sure you want to DELETE this <?php echo "{$row['packagetype']}"; ?>?');">
	                    <input type="hidden" name="action" value="delete">
	                    <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
	                    <input name="submit" value="Delete" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
	                </form>
                </div>
                <div class="small-6 medium-6 large-2 columns">
	                <form name="PKGEdit" method="POST" action="packages-edit.php">
	                    <input type="hidden" name="action" value="edit">
	                    <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
	                    <input name="submit" value="Edit" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
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
		$useremail = $row1['email'];
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
		$useremail = $row1['email'];
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
		            <input name="email" type="hidden" value="<?php echo($useremail); ?>" />
		            <input name="action" type="hidden" value="email_remind" />
		            <input name="from" type="hidden" value="<?php echo($row['from']); ?>" />
		            <input name="pkgtracking" type="hidden" value="<?php echo($row['pkgtracking']); ?>" />
		            <input name="packagetype" type="hidden" value="<?php echo($row['packagetype']); ?>" />
		            <input name="comments" type="hidden" value="<?php echo($row['comments']); ?>" />
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
<!-- END ALL PACKAGES -->
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>All Packages Control Panel Page<br></div>
</body>
</html>