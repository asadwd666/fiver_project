<?php
//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '/home/nodyss5/php/PHPMailer-6.3.0/src/PHPMailer.php';
require '/home/nodyss5/php/PHPMailer-6.3.0/src/SMTP.php';
require '/home/nodyss5/php/PHPMailer-6.3.0/src/Exception.php';

// error_reporting(E_STRICT | E_ALL);

date_default_timezone_set('Etc/UTC');

$current_page = '20';
include('../my-documents/php7-my-db-up.php');
// require '/home/nodyss5/php/PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer();

$body = 'This is a test email.';

$mail->isSMTP();
$mail->Host = 'secure.condosites.net';
$mail->SMTPAuth = true;
$mail->SMTPKeepAlive = true; // SMTP connection will not close after each email sent, reduces SMTP overhead
$mail->Port = 587;
$mail->SMTPSecure = "tls";
$mail->Username = 'messages@condosites.net';
$mail->Password = '6UMC2avgH0v0tWoWx7BCawnFjf~&.XB6zt7#82';
$mail->setFrom('messages@condosites.net', 'CondoSites');
$mail->addReplyTo('messages@condosites.net', 'CondoSites');

$mail->Subject = "PHPMailer mailing list test";
$mail->msgHTML($body);
$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

$query = "SELECT `first_name`, `last_name`, `email` FROM `users` WHERE `emailbatch` = '13'";
$result = mysqli_query($conn,$query) or die('Error, resetting email recipient query failed');
// $result = mysqli_query($conn,$query) or die(mysqli_error($conn));

while($row = $result->fetch_array(MYSQLI_ASSOC))
    $rows[] = $row;
if(mysqli_num_rows($result) > 0){
    foreach ($rows as $row) {

        $mail->addAddress($row['email'], $row['first_name']);
        
        if (!$mail->send()) {
            echo "Mailer Error (" . str_replace("@", "&#64;", $row["email"]) . ') ' . $mail->ErrorInfo . '<br />';
            break; //Abandon sending
    
        } else {
            echo "Message sent to :" . $row['first_name'] . ' (' . str_replace("@", "&#64;", $row['email']) . ')<br />';
    
            //Mark it as sent in the DB
            $useremail = $row['email'];
            $queryRESET = "UPDATE `users` SET `emailbatch`='0' WHERE email = '$useremail'";
            $resultRESET = mysqli_query($conn,$queryRESET) or die('Error, resetting email recipient query failed');
            
        }
        // Clear all addresses and attachments for next loop
        $mail->clearAddresses();
        $mail->clearAttachments();
    }
}else{
    echo "No data returned. Empty result";
}
