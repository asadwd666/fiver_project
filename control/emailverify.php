<?php
//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '/home/nodyss5/php/PHPMailer-6.3.0/src/PHPMailer.php';
require '/home/nodyss5/php/PHPMailer-6.3.0/src/SMTP.php';
require '/home/nodyss5/php/PHPMailer-6.3.0/src/Exception.php';
$current_page = '36';
include('protect.php');
require '../my-documents/smtp.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="CondoSites - http://www.condosites.com" name="author">
<title>Control Panel</title>
<?php include('../control/cp-head-scripts.php'); ?>
</head>
<body>
<!-- LOGO AND NAVIGATION -->
<?php include('cp-navigation.php'); ?>
<!-- END LOGO AND NAVIGATION -->

<!-- DATABASE CALCULATIONS -->
<?php $sqlDBMcEMVF = mysqli_query($conn,"SELECT count(*) FROM `users` WHERE `emailconfirm` != 'V' AND webmaster = '0' AND status = 'Active' AND ghost != 'Y' AND email != '' AND password != '' AND (accessdate = '0000-00-00' OR accessdate >= current_date()) AND (owner = '1' OR lease = '1' OR realtor = '1')") or die(mysqli_error($conn));
//$countDBMcEMVF = mysql_result($sqlDBMcEMVF, "0");
$row = mysqli_fetch_row($sqlDBMcEMVF);
$countDBMcEMVF = $row[0];
?>
<?php $sqlU2 = mysqli_query($conn,"SELECT count(*) FROM users WHERE unit2 != 'X'") or die(mysqli_error($conn));
//$countU2 = mysql_result($sqlU2, "0");
$row = mysqli_fetch_row($sqlU2);
$countU2 = $row[0];
?>
<!-- END DATABASE CALCULATIONS -->

<!-- HEALTH AND HELP -->
<div>
    <div class="large-8 columns" style="padding: 0px">
        <div class="nav-section-header-health-cp" align="center">
<big><i class="fa fa-stethoscope" aria-hidden="true"></i></big><strong>&nbsp;Health&nbsp;&nbsp;&nbsp;</strong>

<?php if ($countDBMcEMVF >= '1'){ ?>
<i class="fa fa-exclamation-triangle note" aria-hidden="true"></i> You have users with unverified email addresses.
<?php }; ?>

<?php if ($countDBMcEMVF == '0'){ ?>
<i class="fa fa-check" aria-hidden="true"></i> All of your users have verified their email address.
<?php }; ?>

        </div>
    </div>
    <div class="large-4 columns" style="padding: 0px">
        <div class="nav-section-header-help-cp" align="center">
            <strong><big><i class="fa fa-hand-o-right" aria-hidden="true"></i></big>&nbsp;Hands&nbsp;point&nbsp;to&nbsp;tips!</strong>
        </div>
    </div>
</div>
<!-- HEALTH AND HELP -->
<br>&nbsp;

<div class="row cp-help">
    <div class="small-12 medium-6 columns">
        <p><b>User Email Address Verification</b> sends an email to all of your users with unverified email addresses.  The email contains a single-click link that confirms the user is receiving emails.  Email confirmations reduce bounces and help confirm the user&apos;s identity; and they are also a standard practice for email campaigns.</p>
    </div>
    <div class="small-12 medium-6 columns">
        <p>
            <i class="fa fa-hand-o-right" aria-hidden="true"></i>  <span class="note-red">It is <b>NOT</b> necessary to perform these actions regularly.</span><br>
            <i class="fa fa-hand-o-right" aria-hidden="true"></i>  <span class="note-red">CondoSites will automatically send verification emails to those who have not verified when they create logins and when they log into the site.</span>
        </p>
    </div>
</div>
<?php echo($errorSUCCESSDB); ?>

<!-- UNVERIFIED EMAIL ADDRESSES -->
<?php if ($countDBMcEMVF == '0'){ ?>
<div class="nav-section-header-cp">
        <strong><i class="fa fa-check" aria-hidden="true"></i> <?php print($countDBMcEMVF); ?> Users with unverified email addresses.</strong>
</div>
<br>
<?php }; ?>
<?php if ($countDBMcEMVF >= '1'){ ?>
<div class="nav-section-header-cp">
        <strong><?php print($countDBMcEMVF); ?> Unverified Email Addresses</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
    <thead>
        <tr>
            <th colspan="10">
                <div align="center">
                    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">THIS SCRIPT WILL TAKE SEVERAL MINUTES TO PROCESS.</span><br>
                    <form name="EmailVerify" method="POST" action="emailverify.php" onclick="return confirm('Are you sure you want to send verification emails to these <?php echo $countDBMcEMVF; ?> users?');">
                        <input type="hidden" name="action" value="EmailVerify">
                        <input name="submit" value="Send Verification Emails" class="submit" type="submit" onclick="value='PROCESSING - PLEASE WAIT'; style='color:red';" />
                    </form>
                    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">DO NOT CLOSE THE WINDOW OR LEAVE THIS PAGE!</span>
                </div>
            </th>
        </tr>
        <tr align="left">
            <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>User</small></th>
            <th width="50" class="table-sortable:numeric"><small>&nbsp;&nbsp;&nbsp; ID</small></th>
            <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; <small>Unit</small></th>
<?php if ($countU2 != '0'){ ?>
            <th class="table-sortable:alphanumeric table-filterable">&nbsp;</th>
<?php }; ?>
			<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Owner</small></b></div></th>
    		<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Renter</small></b></div></th>
			<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Realtor</small></b></div></th>
			<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Board</small></b></div></th>
			<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Staff</small></b></div></th>
			<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Admin</small></b></div></th>
        </tr>
    </thead>
    <tbody>
<?php
	$query  = "SELECT `id`, `unit`, `unit2`, `last_name`, `first_name`, `email`, `owner`, `lease`, `realtor`, `board`, `concierge`, `liaison`, `status`, `created_date` FROM `users` WHERE `emailconfirm` != 'V' AND webmaster = '0' AND status = 'Active' AND ghost != 'Y' AND email != '' AND password != '' AND (accessdate = '0000-00-00' OR accessdate >= current_date()) AND (owner = '1' OR lease = '1' OR realtor = '1') ORDER BY `id` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- DATABASE RESULTS -->
        <tr>
            <td>
                <div class="small-12 medium-12 large-8 columns">
                <b><?php echo "{$row['last_name']}"; ?>, <?php echo "{$row['first_name']}"; ?></b>
                <span class="note-black"><br>Created <?php echo "{$row['created_date']}"; ?></span>
                <br><a href="<?php echo "{$row['email']}"; ?>"><?php echo "{$row['email']}"; ?></a>
                </div>
            </td>
            <td><?php echo "{$row['id']}"; ?></td>
            <td><?php echo "{$row['unit']}"; ?></td>
<?php if ($countU2 != '0'){ ?>
            <td><?php echo "{$row['unit2']}"; ?></td>
<?php }; ?>
            <?php if ($row['owner'] !== '1'){ ?><td align="center" bgcolor="#ffcccc">N</td><?php }; ?><?php if ($row['owner'] !== '0'){ ?><td align="center" bgcolor="#ccffcc">Y</td><?php }; ?>
            <?php if ($row['lease'] !== '1'){ ?><td align="center" bgcolor="#ffcccc">N</td><?php }; ?><?php if ($row['lease'] !== '0'){ ?><td align="center" bgcolor="#ccffcc">Y</td><?php }; ?>
            <?php if ($row['realtor'] !== '1'){ ?><td align="center" bgcolor="#ffcccc">N</td><?php }; ?><?php if ($row['realtor'] !== '0'){ ?><td align="center" bgcolor="#ccffcc">Y</td><?php }; ?>
            <?php if ($row['board'] !== '1'){ ?><td align="center" bgcolor="#f4d6a3">N</td><?php }; ?><?php if ($row['board'] !== '0'){ ?><td align="center" bgcolor="#ccffcc">Y</td><?php }; ?>
            <?php if ($row['concierge'] !== '1'){ ?><td align="center" bgcolor="#f4d6a3">N</td><?php }; ?><?php if ($row['concierge'] !== '0'){ ?><td align="center" bgcolor="#ccffcc">Y</td><?php }; ?>
            <?php if ($row['liaison'] !== '1'){ ?><td align="center" bgcolor="#f4d6a3">N</td><?php }; ?><?php if ($row['liaison'] !== '0'){ ?><td align="center" bgcolor="#ccffcc">Y</td><?php }; ?>
        </tr>
<!-- END DATABASE RESULTS -->
<?php
	}
?>
    </tbody>
</table>
<br>
<!-- END UNVERIFIED EMAIL ADDRESSES -->

<div class="nav-section-header-cp">
        <strong>Script Status</strong>
</div>
<p style="border: 1px; padding: 10px; margin: 20px; background-color: #DCDCDC; font-family: courier; max-width: 1000px;">
    Ready...<br><br>
<?php }; ?>

<!-- MASS EMAIL VERIFICATION SCRIPT -->
<?php $id = $_POST["id"]; $action = $_POST["action"]; if ($action != null){ ?>
<?php

    if ($action == "EmailVerify"){
        
        $query = "SELECT `email` FROM `users` WHERE `emailconfirm` != 'V' AND webmaster = '0' AND status = 'Active' AND ghost != 'Y' AND email != '' AND password != '' AND (accessdate = '0000-00-00' OR accessdate >= current_date()) AND (owner = '1' OR lease = '1' OR realtor = '1')";
	    $result = mysqli_query($conn,$query) or die('Error, select query failed');
	    while($row = $result->fetch_array(MYSQLI_ASSOC)){

            $useremail = $row['email'];
            $domain = substr(strrchr($useremail, "@"), 1);

            $queryEMAIL  = "UPDATE `users` SET `emaildomain` = '$domain' WHERE `email` = '$useremail'";
            $resultEMAIL = mysqli_query($conn,$queryEMAIL);

	    }

        $reseturl = $_SESSION['reseturl'];
        $communityurl = $_SESSION['communityurl'];
        $fromname = "$CommunityName via CondoSites";

        $mail = new PHPMailer\PHPMailer\PHPMailer();

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

        $mail->Subject = "$fromname  Verify Your Email Address";
        $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

        $query = "SELECT `first_name`, `last_name`, `email`, `emaildomain` FROM `users` WHERE `emailconfirm` != 'V' ORDER BY `emaildomain`";
        $result = mysqli_query($conn,$query) or die('Error, resetting email recipient query failed');

        while($row = $result->fetch_array(MYSQLI_ASSOC))
            $rows[] = $row;

        if(mysqli_num_rows($result) > 0){
    
            foreach ($rows as $row) {

                $firstname = $row['first_name'];
                $lastname = $row['last_name'];
                $username = "$firstname $lastname";
                $useremail = $row['email'];

                $body = "<!DOCTYPE HTML><html><body><div style='padding: 25px;'>";
                $body .= "<p>Dear ".$username.",</p> <p>In an effort to reduce spam and bounce messages, we are asking all users of the ".$CommunityName." website to confirm their email address.</p>";
                $body .= "<p><big><b><a href=".$reseturl."?email=".$useremail.">Please take a moment to confirm by clicking here</a></b>.</big></p><p>Or you may copy/paste this address into your web browser:<br>".$reseturl."?email=".$useremail."</p>";
                $body .= "<p>CondoSites is the operator of the ".$CommunityName." community website.</p>";
                $body .= "</div><br><img src='".$communityurl."/pics/logo-small.png' style='max-width: 100px;'><br><br>Visit your <a href='".$communityurl."'>".$CommunityName." community website</a>, operated by <a href='https://condosites.com' target='_blank'>CondoSites</a>.<br><br><b>Email Subscription</b><br><small>You are receiving this email because you are a registered user of the ".$CommunityName." community website.<br><b><a href='".$communityurl."/splash/connect-unsubscribe.php'>Unsubscribe or update your email preferences.</a></b><br><br><b><a href='".$communityurl."/spamhelp.php'>Are these emails being treated as spam?</a></b><br></small></body></html>";

                $mail->msgHTML($body);
                $mail->addAddress($useremail, $username);
        
                if (!$mail->send()) {

                    echo "Mailer Error (" . str_replace("@", "&#64;", $row["email"]) . ') ' . $mail->ErrorInfo . '<br />';
                    break;

                } else {

                    echo "Message sent to: " . $username . ' (' . str_replace("@", "&#64;", $useremail) . ')<br />';
    
                    //Mark it as sent in the DB
                    $useremail = $row['email'];
                    $queryRESET = "UPDATE `users` SET `emailconfirm` = 'S', `emaildomain` = '' WHERE email = '$useremail'";
                    $resultRESET = mysqli_query($conn,$queryRESET) or die('Error, resetting email recipient query failed');

                }

                // Clear all addresses and attachments for next loop
                $mail->clearAddresses();
                $mail->clearAttachments();

            }

        } else {

            echo "No data returned. Empty result";
    
        }

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		$query = "INSERT INTO `log` (action, tablename, useripaddress, userid, id) VALUES ('S', 'Mass Email Verification', '$useripaddress', '$userid', 'Email')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');
		
		echo "<strong><br>Script Complete</strong>";
		
	}
}
?>
<!-- END MASS EMAIL VERIFICATION SCRIPT -->
</p>
<br>

<div class="small-12 medium-12 large-12 columns note-black"><br><br>User Email Address Verification Control Panel Page<br></div>
</body>
</html>
