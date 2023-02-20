<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '/home/nodyss5/php/PHPMailer-6.3.0/src/PHPMailer.php';
require '/home/nodyss5/php/PHPMailer-6.3.0/src/SMTP.php';
require '/home/nodyss5/php/PHPMailer-6.3.0/src/Exception.php';
//require '/home/nodyss5/php/PHPMailer/PHPMailerAutoload.php';

require '../my-documents/smtp.php';
require '../my-documents/google-email.php';

$int1 = $_POST["int1"];
$action = $_POST["action"];
$success = "untried";
$current_page = '20';
include('protect.php');

if($action == "email_message"){
    
	$query = "SELECT `owner`, `lease`, `realtor`, `unit2`, `club1`, `club2`, `club3`, `club4`, `club5`, `flag`, `cc` FROM `messages` WHERE `int1` = '$int1' LIMIT 1";
	$result = mysqli_query($conn,$query) or die('Error, select query failed');
	while($row = $result->fetch_array(MYSQLI_ASSOC)){

	    if($int1 != ""){

            	$streetfilter = $row['unit2'];
            	$emailconfirm = "AND `emailconfirm` != 'B'"; 
                $streetstring = ''; if ($row['unit2'] != 'X') {$streetstring = "AND `unit2` = '$streetfilter' ";}
                $club1string = ''; if ($row['club1'] == 'Y') {$club1string = "AND `club1` = 'Y' ";}
                $club2string = ''; if ($row['club2'] == 'Y') {$club2string = "AND `club2` = 'Y' ";}
                $club3string = ''; if ($row['club3'] == 'Y') {$club3string = "AND `club3` = 'Y' ";}
                $club4string = ''; if ($row['club4'] == 'Y') {$club4string = "AND `club4` = 'Y' ";}
                $club5string = ''; if ($row['club5'] == 'Y') {$club5string = "AND `club5` = 'Y' ";}
                $flagstring = ''; if ($row['flag'] == 'U') {$flagstring = "AND (ghost != 'Y' AND ghost != 'N') ";} else if ($row['flag'] == 'A') {$flagstring = "AND (`ghost` != 'Y' AND `ghost` != 'N' AND `ghost` != 'U') ";}

        // -- ALL ELSE -- //
            
            // -- OWNERS -- //
            if ($row['owner'] == 'Y') {

            	$queryEMAIL  = "UPDATE `users` SET `emailbatch` = '1' WHERE `status` = 'active' AND `owner` = '1' ". $emailconfirm." ". $club1string." ". $club2string." ". $club3string." ". $club4string." ". $club5string." ".$flagstring." ".$streetstring." ";
                $resultEMAIL = mysqli_query($conn,$queryEMAIL);
	        }

            // -- RENTERS -- //
            if ($row['lease'] == 'Y'){
                
    	        $queryEMAIL  = "UPDATE `users` SET `emailbatch` = '1' WHERE `status` = 'active' AND `lease` = '1' ". $emailconfirm." ". $club1string." ". $club2string." ". $club3string." ". $club4string." ". $club5string." ".$flagstring." ".$streetstring." ";
                $resultEMAIL = mysqli_query($conn,$queryEMAIL);
            }

            // -- REALTORS -- //
            if ($row['realtor'] == 'Y'){
                
            	$queryEMAIL  = "UPDATE `users` SET `emailbatch` = '1' WHERE `status` = 'active' AND `realtor` = '1' ". $emailconfirm." ". $club1string." ". $club2string." ". $club3string." ". $club4string." ". $club5string." ".$flagstring." ".$streetstring." ";
                $resultEMAIL = mysqli_query($conn,$queryEMAIL);
            }
            
            // -- INDIVIDUAL -- //
            if ($row['cc'] != ''){
                
                $userid = $row['cc'];
            	$queryEMAIL  = "UPDATE `users` SET `emailbatch` = '98' WHERE `id` = '$userid' ". $emailconfirm;
                $resultEMAIL = mysqli_query($conn,$queryEMAIL);
            }

        // -- SENDING ADMIN -- //
            $sendingadmin = $_SESSION['email'];
            $queryEMAIL  = "UPDATE `users` SET `emailbatch` = '99' WHERE `email` = '$sendingadmin' ". $emailconfirm;
            $resultEMAIL = mysqli_query($conn,$queryEMAIL);
    	}

	}
	
	$queryDOMAIN = "SELECT `email`, `emailbatch` FROM `users` WHERE `emailbatch` != '0'";
	$resultDOMAIN = mysqli_query($conn,$queryDOMAIN) or die('Error, select query failed');
	while($rowDOMAIN = $resultDOMAIN->fetch_array(MYSQLI_ASSOC))

            $useremail = $rowDOMAIN['email'];
            $domain = substr(strrchr($useremail, "@"), 1);

            $queryEMAIL  = "UPDATE `users` SET `emaildomain` = '$domain' WHERE `email` = '$useremail'";
            $resultEMAIL = mysqli_query($conn,$queryEMAIL);

	}

	$query = "SELECT * FROM messages WHERE `int1` = '$int1' LIMIT 1";
	$result = mysqli_query($conn,$query) or die('Error, select query failed');
	while($row = $result->fetch_array(MYSQLI_ASSOC)){
	    
        $replyto = $row['from'];
        $subject = $_POST['subject'];
        $communityurl = $_SESSION['communityurl'];
        $fromname = "$CommunityName via CondoSites";

        $bodymain .= $_POST['messagebody'];
        
        $body = "<html><head><title>Email from ".$CommunityName."</title>";
        $body = "<link rel='stylesheet' href='".$communityurl."/java/ckeditor/contents.css'>";
        $body = "</head><body>";
        $body .= $dnrMSG."<br>";
        if ($replyto !== ''){
            $body .= "Send replies to: <a href='mailto:".$replyto."?subject=Re: ".$subject."'>".$replyto."</a></b><br>";
        }
        $body .= "<br>";
        $body .= $bodymain;
        $body .= "<br><br><img src='".$communityurl."/pics/logo-small.png' style='max-width: 100px;'><br><br><p>Visit your <a href='".$communityurl."'>".$CommunityName." community website</a>.</p>";
        $body .= "<p><b>Email Subscription</b><br>You are receiving this email because you are a registered user of the ".$CommunityName." community website, operated by <a href='https://condosites.com' target='_blank'>CondoSites</a>.</p>";
        $body .= "<br>".$dnrMSG."<br>";
        if ($replyto !== ''){
            $body .= "Send replies to: <a href='mailto:".$replyto."?subject=Re: ".$subject."'>".$replyto."</a></b>";
        }
        $body .= "<p><b><a href='".$communityurl."/splash/connect-unsubscribe.php'>Unsubscribe or update your email preferences.</a></b></p>";
    
        // Google Analytics Tracking
        $body .= "<img style='display:none;' src='https://www.google-analytics.com/collect?v=1&tid=".$googlecode."&cid=".$CommunityName."&t=event&ec=email&ea=open&el=".$row['int1']."".$subject."&cs=BULK&cm=email&cn=".$subject."&dt=MESSAGES'>";
        
        $body .= "<p><b><a href='".$communityurl."/spamhelp.php'>Are these emails being treated as spam?</a></b></p></body></html>";

    // -- EMAIL SCRIPT – ADMIN -- //
        $sqlDOM = mysqli_query($conn,"SELECT count(*) FROM `users` WHERE `emailbatch` = '99'") or die(mysqli_error($conn));
        //$countDOM = mysql_result($sqlDOM, "0");
        $row = mysqli_fetch_row($sqlDOM);
        $countDOM = $row[0];
        if ($countDOM != '0'){
        
            $mail = new PHPMailer();

            $mail->isSMTP();
            $mail->Host = $hostMSG;
            $mail->SMTPAuth = $smtpauthMSG;
            $mail->SMTPKeepAlive = $smtpkeepaliveMSG;
            $mail->Port = $smtpportMSG;
            $mail->SMTPSecure = $smtpsecureMSG;
            $mail->SMTPAutoTLS = $smtpautotlsMSG;
            $mail->Username = $usernameMSG;
            $mail->Password = $passwordMSG;
            $mail->setFrom($fromemailMSG, $fromname);

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->msgHTML($body);
            $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

            $mail->Subject = "$subject";
            $mail->addReplyTo($replyto);

            $query = "SELECT `first_name`, `last_name`, `email`, `emaildomain` FROM `users` WHERE `emailbatch` = '99'";
            $result = mysqli_query($conn,$query) or die('Error, resetting email recipient query failed');
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {

                $firstname = $row['first_name'];
                $lastname = $row['last_name'];
                $username = "$firstname $lastname";
                $useremail = $row['email'];

                $mail->addAddress($useremail, $username);

            }

            if (!$mail->send()) {

            } else {

                $queryRESET = "UPDATE `users` SET `emailbatch` = '0', `emaildomain` = '' WHERE `emailbatch` = '99'";
                $resultRESET = mysqli_query($conn,$queryRESET) or die('Error, resetting email recipient query failed');

            }
                
            $mail->clearAddresses();
            $mail->clearAttachments();
        }
        
    // -- EMAIL SCRIPT – INDIVIDUAL -- //
        mysqli_query($conn,"SELECT count(*) FROM `users` WHERE `emailbatch` = '98'") or die(mysqli_error($conn));
        //$countDOM = mysql_result($sqlDOM, "0");
        $row = mysqli_fetch_row($sqlDOM);
        $countDOM = $row[0];
        if ($countDOM != '0'){
        
            $mail = new PHPMailer();

            $mail->isSMTP();
            $mail->Host = $hostMSG;
            $mail->SMTPAuth = $smtpauthMSG;
            $mail->SMTPKeepAlive = $smtpkeepaliveMSG;
            $mail->Port = $smtpportMSG;
            $mail->SMTPSecure = $smtpsecureMSG;
            $mail->SMTPAutoTLS = $smtpautotlsMSG;
            $mail->Username = $usernameMSG;
            $mail->Password = $passwordMSG;
            $mail->setFrom($fromemailMSG, $fromname);

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->msgHTML($body);
            $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

            $mail->Subject = "$subject";
            $mail->addReplyTo($replyto);

            $query = "SELECT `first_name`, `last_name`, `email`, `emaildomain` FROM `users` WHERE `emailbatch` = '98' ORDER BY `email`";
            $result = mysqli_query($conn,$query) or die('Error, resetting email recipient query failed');
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {

                $firstname = $row['first_name'];
                $lastname = $row['last_name'];
                $username = "$firstname $lastname";
                $useremail = $row['email'];

                $mail->addAddress($useremail, $username);

            }

            if (!$mail->send()) {

            } else {

                $queryRESET = "UPDATE `users` SET `emailbatch` = '0', `emaildomain` = '' WHERE `emailbatch` = '98'";
                $resultRESET = mysqli_query($conn,$queryRESET) or die('Error, resetting email recipient query failed');

            }
                
            $mail->clearAddresses();
            $mail->clearAttachments();
        }
        
    // -- EMAIL SCRIPT – ALL ELSE -- //
        mysqli_query($conn,"SELECT count(*) FROM `users` WHERE `emailbatch` = '1'") or die(mysqli_error($conn));
        //$countDOM = mysql_result($sqlDOM, "0");
        $row = mysqli_fetch_row($sqlDOM);
        $countDOM = $row[0];
        if ($countDOM != '0'){
        
            $mail = new PHPMailer();

            $mail->isSMTP();
            $mail->Host = $hostMSG;
            $mail->SMTPAuth = $smtpauthMSG;
            $mail->SMTPKeepAlive = $smtpkeepaliveMSG;
            $mail->Port = $smtpportMSG;
            $mail->SMTPSecure = $smtpsecureMSG;
            $mail->SMTPAutoTLS = $smtpautotlsMSG;
            $mail->Username = $usernameMSG;
            $mail->Password = $passwordMSG;
            $mail->setFrom($fromemailMSG, $fromname);

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->msgHTML($body);
            $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

            $mail->Subject = "$subject";
            $mail->addReplyTo($replyto);

            $query = "SELECT `first_name`, `last_name`, `email`, `emaildomain` FROM `users` WHERE `emailbatch` = '1' ORDER BY `email`";
            $result = mysqli_query($conn,$query) or die('Error, resetting email recipient query failed');
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {

                $firstname = $row['first_name'];
                $lastname = $row['last_name'];
                $username = "$firstname $lastname";
                $useremail = $row['email'];

                $mail->addBCC($useremail, $username);

            }

            if (!$mail->send()) {

            } else {

                $queryRESET = "UPDATE `users` SET `emailbatch` = '0', `emaildomain` = '' WHERE `emailbatch` = '1' ";
                $resultRESET = mysqli_query($conn,$queryRESET) or die('Error, resetting email recipient query failed');

            }
                
            $mail->clearAddresses();
            $mail->clearAttachments();
        }


    // -- EMAIL SCRIPT – APPLE -- //
        mysqli_query($conn,"SELECT count(*) FROM `users` WHERE `emailbatch` = '1' AND (`emaildomain` LIKE 'mac.%' OR `emaildomain` LIKE 'icloud.%' OR `emaildomain` LIKE 'me.%')") or die(mysqli_error($conn));
        //$countDOM = mysql_result($sqlDOM, "0");
        $row = mysqli_fetch_row($sqlDOM);
        $countDOM = $row[0];
        if ($countDOM != '0'){
        
            $mail = new PHPMailer();

            $mail->isSMTP();
            $mail->Host = $hostMSG;
            $mail->SMTPAuth = $smtpauthMSG;
            $mail->SMTPKeepAlive = $smtpkeepaliveMSG;
            $mail->Port = $smtpportMSG;
            $mail->SMTPSecure = $smtpsecureMSG;
            $mail->SMTPAutoTLS = $smtpautotlsMSG;
            $mail->Username = $usernameMSG;
            $mail->Password = $passwordMSG;
            $mail->setFrom($fromemailMSG, $fromname);

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->msgHTML($body);
            $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

            $mail->Subject = "$subject";
            $mail->addReplyTo($replyto);

            $query = "SELECT `first_name`, `last_name`, `email`, `emaildomain` FROM `users` WHERE `emailbatch` = '1' AND (`emaildomain` LIKE 'mac.%' OR `emaildomain` LIKE 'icloud.%' OR `emaildomain` LIKE 'me.%') ORDER BY `emaildomain`";
            $result = mysqli_query($conn,$query) or die('Error, resetting email recipient query failed');
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {

                $firstname = $row['first_name'];
                $lastname = $row['last_name'];
                $username = "$firstname $lastname";
                $useremail = $row['email'];

                $mail->addBCC($useremail, $username);

            }

            if (!$mail->send()) {

            } else {

                $queryRESET = "UPDATE `users` SET `emailbatch` = '0', `emaildomain` = '' WHERE (`emaildomain` LIKE 'mac.%' OR `emaildomain` LIKE 'icloud.%' OR `emaildomain` LIKE 'me.%')";
                $resultRESET = mysqli_query($conn,$queryRESET) or die('Error, resetting email recipient query failed');

            }
                
            $mail->clearAddresses();
            $mail->clearAttachments();
        }
        
    // -- EMAIL SCRIPT – AT&T -- //
        mysqli_query($conn,"SELECT count(*) FROM `users` WHERE `emailbatch` = '1' AND (`emaildomain` LIKE 'att.net' OR `emaildomain` LIKE 'ameritech.net' OR `emaildomain` LIKE 'bellsouth.net' OR `emaildomain` LIKE 'flash.net' OR `emaildomain` LIKE 'nvbell.net' OR `emaildomain` LIKE 'pacbell.net' OR `emaildomain` LIKE 'prodigy.net' OR `emaildomain` LIKE 'sbcglobal.net' OR `emaildomain` LIKE 'snet.net' OR `emaildomain` LIKE 'swbell.net' OR `emaildomain` LIKE 'wans.net')") or die(mysqli_error($conn));
        //$countDOM = mysql_result($sqlDOM, "0");
        $row = mysqli_fetch_row($sqlDOM);
        $countDOM = $row[0];
        if ($countDOM != '0'){
        
            $mail = new PHPMailer();

            $mail->isSMTP();
            $mail->Host = $hostMSG;
            $mail->SMTPAuth = $smtpauthMSG;
            $mail->SMTPKeepAlive = $smtpkeepaliveMSG;
            $mail->Port = $smtpportMSG;
            $mail->SMTPSecure = $smtpsecureMSG;
            $mail->SMTPAutoTLS = $smtpautotlsMSG;
            $mail->Username = $usernameMSG;
            $mail->Password = $passwordMSG;
            $mail->setFrom($fromemailMSG, $fromname);

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->msgHTML($body);
            $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

            $mail->Subject = "$subject";
            $mail->addReplyTo($replyto);

            $query = "SELECT `first_name`, `last_name`, `email`, `emaildomain` FROM `users` WHERE `emailbatch` = '1' AND (`emaildomain` LIKE 'att.net' OR `emaildomain` LIKE 'ameritech.net' OR `emaildomain` LIKE 'bellsouth.net' OR `emaildomain` LIKE 'flash.net' OR `emaildomain` LIKE 'nvbell.net' OR `emaildomain` LIKE 'pacbell.net' OR `emaildomain` LIKE 'prodigy.net' OR `emaildomain` LIKE 'sbcglobal.net' OR `emaildomain` LIKE 'snet.net' OR `emaildomain` LIKE 'swbell.net' OR `emaildomain` LIKE 'wans.net') ORDER BY `emaildomain`";
            $result = mysqli_query($conn,$query) or die('Error, resetting email recipient query failed');
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {

                $firstname = $row['first_name'];
                $lastname = $row['last_name'];
                $username = "$firstname $lastname";
                $useremail = $row['email'];

                $mail->addBCC($useremail, $username);

            }

            if (!$mail->send()) {

            } else {

                $queryRESET = "UPDATE `users` SET `emailbatch` = '0', `emaildomain` = '' WHERE (`emaildomain` LIKE 'att.net' OR `emaildomain` LIKE 'ameritech.net' OR `emaildomain` LIKE 'bellsouth.net' OR `emaildomain` LIKE 'flash.net' OR `emaildomain` LIKE 'nvbell.net' OR `emaildomain` LIKE 'pacbell.net' OR `emaildomain` LIKE 'prodigy.net' OR `emaildomain` LIKE 'sbcglobal.net' OR `emaildomain` LIKE 'snet.net' OR `emaildomain` LIKE 'swbell.net' OR `emaildomain` LIKE 'wans.net')";
                $resultRESET = mysqli_query($conn,$queryRESET) or die('Error, resetting email recipient query failed');

            }
                
            $mail->clearAddresses();
            $mail->clearAttachments();
        }
        
    // -- EMAIL SCRIPT – COMCAST -- //
        mysqli_query($conn,"SELECT count(*) FROM `users` WHERE `emailbatch` = '1' AND `emaildomain` LIKE 'comcast.%'") or die(mysqli_error($conn));
        //$countDOM = mysql_result($sqlDOM, "0");
        $row = mysqli_fetch_row($sqlDOM);
        $countDOM = $row[0];
        if ($countDOM != '0'){
        
            $mail = new PHPMailer();

            $mail->isSMTP();
            $mail->Host = $hostMSG;
            $mail->SMTPAuth = $smtpauthMSG;
            $mail->SMTPKeepAlive = $smtpkeepaliveMSG;
            $mail->Port = $smtpportMSG;
            $mail->SMTPSecure = $smtpsecureMSG;
            $mail->SMTPAutoTLS = $smtpautotlsMSG;
            $mail->Username = $usernameMSG;
            $mail->Password = $passwordMSG;
            $mail->setFrom($fromemailMSG, $fromname);

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->msgHTML($body);
            $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

            $mail->Subject = "$subject";
            $mail->addReplyTo($replyto);

            $query = "SELECT `first_name`, `last_name`, `email`, `emaildomain` FROM `users` WHERE `emaildomain` LIKE 'comcast.%' AND `emailbatch` = '1' ORDER BY `email`";
            $result = mysqli_query($conn,$query) or die('Error, resetting email recipient query failed');
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {

                $firstname = $row['first_name'];
                $lastname = $row['last_name'];
                $username = "$firstname $lastname";
                $useremail = $row['email'];

                $mail->addBCC($useremail, $username);

            }

            if (!$mail->send()) {

            } else {

                $queryRESET = "UPDATE `users` SET `emailbatch` = '0', `emaildomain` = '' WHERE `emaildomain` LIKE 'comcast.%'";
                $resultRESET = mysqli_query($conn,$queryRESET) or die('Error, resetting email recipient query failed');

            }
                
            $mail->clearAddresses();
            $mail->clearAttachments();
        }
        
    // -- EMAIL SCRIPT – GMAIL -- //
        mysqli_query($conn,"SELECT count(*) FROM `users` WHERE `emailbatch` = '1' AND `emaildomain` LIKE 'gmail.%'") or die(mysqli_error($conn));
        //$countDOM = mysql_result($sqlDOM, "0");
        $row = mysqli_fetch_row($sqlDOM);
        $countDOM = $row[0];
        if ($countDOM != '0'){
        
            $mail = new PHPMailer();

            $mail->isSMTP();
            $mail->Host = $hostMSG;
            $mail->SMTPAuth = $smtpauthMSG;
            $mail->SMTPKeepAlive = $smtpkeepaliveMSG;
            $mail->Port = $smtpportMSG;
            $mail->SMTPSecure = $smtpsecureMSG;
            $mail->SMTPAutoTLS = $smtpautotlsMSG;
            $mail->Username = $usernameMSG;
            $mail->Password = $passwordMSG;
            $mail->setFrom($fromemailMSG, $fromname);

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->msgHTML($body);
            $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

            $mail->Subject = "$subject";
            $mail->addReplyTo($replyto);

            $query = "SELECT `first_name`, `last_name`, `email`, `emaildomain` FROM `users` WHERE `emaildomain` LIKE 'gmail.%' AND `emailbatch` = '1' ORDER BY `email`";
            $result = mysqli_query($conn,$query) or die('Error, resetting email recipient query failed');
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {

                $firstname = $row['first_name'];
                $lastname = $row['last_name'];
                $username = "$firstname $lastname";
                $useremail = $row['email'];

                $mail->addBCC($useremail, $username);

            }
        
            if (!$mail->send()) {

            } else {

                $queryRESET = "UPDATE `users` SET `emailbatch` = '0', `emaildomain` = '' WHERE `emaildomain` LIKE 'gmail.%'";
                $resultRESET = mysqli_query($conn,$queryRESET) or die('Error, resetting email recipient query failed');

            }
                
            $mail->clearAddresses();
            $mail->clearAttachments();
        }
        
    // -- EMAIL SCRIPT – MICROSOFT -- //
        mysqli_query($conn,"SELECT count(*) FROM `users` WHERE `emailbatch` = '1' AND (`emaildomain` LIKE 'hotmail.%' OR `emaildomain` LIKE 'live.%' OR `emaildomain` LIKE 'microsoft.%' OR `emaildomain` LIKE 'msn.%' OR `emaildomain` LIKE 'outlook.%')") or die(mysqli_error($conn));
        //$countDOM = mysql_result($sqlDOM, "0");
        $row = mysqli_fetch_row($sqlDOM);
        $countDOM = $row[0];
        if ($countDOM != '0'){
        
            $mail = new PHPMailer();

            $mail->isSMTP();
            $mail->Host = $hostMSG;
            $mail->SMTPAuth = $smtpauthMSG;
            $mail->SMTPKeepAlive = $smtpkeepaliveMSG;
            $mail->Port = $smtpportMSG;
            $mail->SMTPSecure = $smtpsecureMSG;
            $mail->SMTPAutoTLS = $smtpautotlsMSG;
            $mail->Username = $usernameMSG;
            $mail->Password = $passwordMSG;
            $mail->setFrom($fromemailMSG, $fromname);

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->msgHTML($body);
            $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

            $mail->Subject = "$subject";
            $mail->addReplyTo($replyto);

            $query = "SELECT `first_name`, `last_name`, `email`, `emaildomain` FROM `users` WHERE `emailbatch` = '1' AND (`emaildomain` LIKE 'hotmail.%' OR `emaildomain` LIKE 'live.%' OR `emaildomain` LIKE 'microsoft.%' OR `emaildomain` LIKE 'msn.%' OR `emaildomain` LIKE 'outlook.%') ORDER BY `emaildomain`";
            $result = mysqli_query($conn,$query) or die('Error, resetting email recipient query failed');
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {

                $firstname = $row['first_name'];
                $lastname = $row['last_name'];
                $username = "$firstname $lastname";
                $useremail = $row['email'];

                $mail->addBCC($useremail, $username);

            }

            if (!$mail->send()) {

            } else {

                $queryRESET = "UPDATE `users` SET `emailbatch` = '0', `emaildomain` = '' WHERE (`emaildomain` LIKE 'hotmail.%' OR `emaildomain` LIKE 'live.%' OR `emaildomain` LIKE 'microsoft.%' OR `emaildomain` LIKE 'msn.%' OR `emaildomain` LIKE 'outlook.%')";
                $resultRESET = mysqli_query($conn,$queryRESET) or die('Error, resetting email recipient query failed');

            }
                
            $mail->clearAddresses();
            $mail->clearAttachments();
        }
        
    // -- EMAIL SCRIPT – VERIZON -- //
        mysqli_query($conn,"SELECT count(*) FROM `users` WHERE `emailbatch` = '1' AND `emaildomain` LIKE 'verizon.%'") or die(mysqli_error($conn));
        //$countDOM = mysql_result($sqlDOM, "0");
        $row = mysqli_fetch_row($sqlDOM);
        $countDOM = $row[0];
        if ($countDOM != '0'){
        
            $mail = new PHPMailer();

            $mail->isSMTP();
            $mail->Host = $hostMSG;
            $mail->SMTPAuth = $smtpauthMSG;
            $mail->SMTPKeepAlive = $smtpkeepaliveMSG;
            $mail->Port = $smtpportMSG;
            $mail->SMTPSecure = $smtpsecureMSG;
            $mail->SMTPAutoTLS = $smtpautotlsMSG;
            $mail->Username = $usernameMSG;
            $mail->Password = $passwordMSG;
            $mail->setFrom($fromemailMSG, $fromname);

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->msgHTML($body);
            $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

            $mail->Subject = "$subject";
            $mail->addReplyTo($replyto);

            $query = "SELECT `first_name`, `last_name`, `email`, `emaildomain` FROM `users` WHERE `emaildomain` LIKE 'verizon.%' AND `emailbatch` = '1' ORDER BY `email`";
            $result = mysqli_query($conn,$query) or die('Error, resetting email recipient query failed');
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {

                $firstname = $row['first_name'];
                $lastname = $row['last_name'];
                $username = "$firstname $lastname";
                $useremail = $row['email'];

                $mail->addBCC($useremail, $username);

            }

            if (!$mail->send()) {

            } else {

                $queryRESET = "UPDATE `users` SET `emailbatch` = '0', `emaildomain` = '' WHERE `emaildomain` LIKE 'verizon.%'";
                $resultRESET = mysqli_query($conn,$queryRESET) or die('Error, resetting email recipient query failed');

            }
                
            $mail->clearAddresses();
            $mail->clearAttachments();
        }
        
    // -- EMAIL SCRIPT – AOL -- //
        mysqli_query($conn,"SELECT count(*) FROM `users` WHERE `emailbatch` = '1' AND `emaildomain` LIKE 'aol.%'") or die(mysqli_error($conn));
        //$countDOM = mysql_result($sqlDOM, "0");
        $row = mysqli_fetch_row($sqlDOM);
        $countDOM = $row[0];
        if ($countDOM != '0'){
        
            $mail = new PHPMailer();

            $mail->isSMTP();
            $mail->Host = $hostMSG;
            $mail->SMTPAuth = $smtpauthMSG;
            $mail->SMTPKeepAlive = $smtpkeepaliveMSG;
            $mail->Port = $smtpportMSG;
            $mail->SMTPSecure = $smtpsecureMSG;
            $mail->SMTPAutoTLS = $smtpautotlsMSG;
            $mail->Username = $usernameMSG;
            $mail->Password = $passwordMSG;
            $mail->setFrom($fromemailMSG, $fromname);

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->msgHTML($body);
            $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

            $mail->Subject = "$subject";
            $mail->addReplyTo($replyto);

            $query = "SELECT `first_name`, `last_name`, `email`, `emaildomain` FROM `users` WHERE `emaildomain` LIKE 'aol.%' AND `emailbatch` = '1' ORDER BY `email`";
            $result = mysqli_query($conn,$query) or die('Error, resetting email recipient query failed');
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {

                $firstname = $row['first_name'];
                $lastname = $row['last_name'];
                $username = "$firstname $lastname";
                $useremail = $row['email'];

                $mail->addBCC($useremail, $username);

            }

            if (!$mail->send()) {

            } else {

                $queryRESET = "UPDATE `users` SET `emailbatch` = '0', `emaildomain` = '' WHERE `emaildomain` LIKE 'aol.%'";
                $resultRESET = mysqli_query($conn,$queryRESET) or die('Error, resetting email recipient query failed');

            }
                
            $mail->clearAddresses();
            $mail->clearAttachments();
        }
        
    // -- EMAIL SCRIPT – YAHOO! -- //
        mysqli_query($conn,"SELECT count(*) FROM `users` WHERE `emailbatch` = '1' AND (`emaildomain` LIKE 'yahoo.%' OR `emaildomain` LIKE 'ymail.%')") or die(mysqli_error($conn));
        //$countDOM = mysql_result($sqlDOM, "0");
        $row = mysqli_fetch_row($sqlDOM);
        $countDOM = $row[0];
        if ($countDOM != '0'){
        
            $mail = new PHPMailer();

            $mail->isSMTP();
            $mail->Host = $hostMSG;
            $mail->SMTPAuth = $smtpauthMSG;
            $mail->SMTPKeepAlive = $smtpkeepaliveMSG;
            $mail->Port = $smtpportMSG;
            $mail->SMTPSecure = $smtpsecureMSG;
            $mail->SMTPAutoTLS = $smtpautotlsMSG;
            $mail->Username = $usernameMSG;
            $mail->Password = $passwordMSG;
            $mail->setFrom($fromemailMSG, $fromname);

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->msgHTML($body);
            $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

            $mail->Subject = "$subject";
            $mail->addReplyTo($replyto);

            $query = "SELECT `first_name`, `last_name`, `email`, `emaildomain` FROM `users` WHERE `emailbatch` = '1' AND (`emaildomain` LIKE 'yahoo.%' OR `emaildomain` LIKE 'ymail.%') ORDER BY `emaildomain`";
            $result = mysqli_query($conn,$query) or die('Error, resetting email recipient query failed');
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {

                $firstname = $row['first_name'];
                $lastname = $row['last_name'];
                $username = "$firstname $lastname";
                $useremail = $row['email'];

                $mail->addBCC($useremail, $username);

            }

            if (!$mail->send()) {

            } else {

                $queryRESET = "UPDATE `users` SET `emailbatch` = '0', `emaildomain` = '' WHERE (`emaildomain` LIKE 'yahoo.%' OR `emaildomain` LIKE 'ymail.%')";
                $resultRESET = mysqli_query($conn,$queryRESET) or die('Error, resetting email recipient query failed');

            }
                
            $mail->clearAddresses();
            $mail->clearAttachments();
        }

    $queryRESET = "UPDATE `users` SET `emailbatch` = '0', `emaildomain` = ''";

	$status = 'S';
	$date = date('Y-m-d H:i:s');
	$query = "UPDATE messages SET `status`='$status', `date`='$date' WHERE `int1` = '$int1' LIMIT 1";
	$result = mysqli_query($conn,$query) or die('Error, insert query failed');

	header('Location: messages.php');
	}
?>