<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($scheck != '') {

    $query = "INSERT INTO log (action, tablename, useripaddress) VALUES ('D', 'Passwords-SPAM', '$useripaddress')";
    mysqli_query($conn, $query) or die('Error, updating log failed');

    header('Location: connect-thanks.php');
}

// SPAM BOT FILTERS

else if ($staff != '' && $scheck == '' && $useragent == 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3882.0 Safari/537.36') {

    $query = "INSERT INTO log (action, tablename, useripaddress, comment) VALUES ('N', 'Passwords-Admin', '$useripaddress', 'AGENT FILTER $first_name $last_name $email $useragent')";
    mysqli_query($conn, $query) or die('Error, updating log failed');

    header('Location: connect-thanks.php');
}
else if ($staff != '' && $scheck == '' && $useragent == 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.0 Safari/537.36') {

    $query = "INSERT INTO log (action, tablename, useripaddress, comment) VALUES ('N', 'Passwords-Admin', '$useripaddress', 'AGENT FILTER $first_name $last_name $email $useragent')";
    mysqli_query($conn, $query) or die('Error, updating log failed');

    header('Location: connect-thanks.php');
}
else if ($staff != '' && $scheck == '' && $useragent == 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.0 Safari/537.36') {

    $query = "INSERT INTO log (action, tablename, useripaddress, comment) VALUES ('N', 'Passwords-Admin', '$useripaddress', 'AGENT FILTER $first_name $last_name $email $useragent')";
    mysqli_query($conn, $query) or die('Error, updating log failed');

    header('Location: connect-thanks.php');
}
else if ($staff != '' && $scheck == '' && $useragent == 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36') {

    $query = "INSERT INTO log (action, tablename, useripaddress, comment) VALUES ('N', 'Passwords-Admin', '$useripaddress', 'AGENT FILTER $first_name $last_name $email $useragent')";
    mysqli_query($conn, $query) or die('Error, updating log failed');

    header('Location: connect-thanks.php');
}
else if ($staff != '' && $scheck == '' && (strpos($useragent, 'Linux') == true)) {

    $query = "INSERT INTO log (action, tablename, useripaddress, comment) VALUES ('N', 'Passwords-Admin', '$useripaddress', 'AGENT FILTER $first_name $last_name $email $useragent')";
    mysqli_query($conn, $query) or die('Error, updating log failed');

    header('Location: connect-thanks.php');
}
else if ($staff != '' && $scheck == '' && (strpos($email2, '@example.com') == true)) {

    $query = "INSERT INTO log (action, tablename, useripaddress, comment) VALUES ('N', 'Passwords-Admin', '$useripaddress', 'EMAIL FILTER $first_name $last_name $email $useragent')";
    mysqli_query($conn, $query) or die('Error, updating log failed');

    header('Location: connect-thanks.php');
}
else if ($staff != '' && $scheck == '' && (strpos($phone, '9999999999') == true)) {

    $query = "INSERT INTO log (action, tablename, useripaddress, comment) VALUES ('N', 'Passwords-Admin', '$useripaddress', 'PHONE FILTER $first_name $last_name $email $phone $useragent')";
    mysqli_query($conn, $query) or die('Error, updating log failed');

    header('Location: connect-thanks.php');
}
else if (strpos($first_name, 'http') == true) {

    $query = "INSERT INTO log (action, tablename, useripaddress, comment) VALUES ('N', 'Passwords-Admin', '$useripaddress', 'FIRST NAME FILTER $first_name $last_name $email $phone $useragent')";
    mysqli_query($conn, $query) or die('Error, updating log failed');

    header('Location: connect-thanks.php');
}
else if (strpos($last_name, 'http') == true) {

    $query = "INSERT INTO log (action, tablename, useripaddress, comment) VALUES ('N', 'Passwords-Admin', '$useripaddress', 'LAST NAME FILTER $first_name $last_name $email $phone $useragent')";
    mysqli_query($conn, $query) or die('Error, updating log failed');

    header('Location: connect-thanks.php');
}
else if (strpos($email, 'http') == true) {

    $query = "INSERT INTO log (action, tablename, useripaddress, comment) VALUES ('N', 'Passwords-Admin', '$useripaddress', 'EMAIL FILTER $first_name $last_name $email $phone $useragent')";
    mysqli_query($conn, $query) or die('Error, updating log failed');

    header('Location: connect-thanks.php');
}
else if (strpos($email2, 'http') == true) {

    $query = "INSERT INTO log (action, tablename, useripaddress, comment) VALUES ('N', 'Passwords-Admin', '$useripaddress', 'EMAIL2 FILTER $first_name $last_name $email $phone $useragent')";
    mysqli_query($conn, $query) or die('Error, updating log failed');

    header('Location: connect-thanks.php');
}
else if (strpos($email, 'mailto.plus') == true) {

    $query = "INSERT INTO log (action, tablename, useripaddress, comment) VALUES ('N', 'Passwords-Admin', '$useripaddress', 'EMAIL FILTER $first_name $last_name $email $phone $useragent')";
    mysqli_query($conn, $query) or die('Error, updating log failed');

    header('Location: connect-thanks.php');
}

// END SPAM BOT USER AGENTS

else if ($action != null) {
    $success = true;
    if ($action == "add") {

        $useripaddress = $_SERVER['REMOTE_ADDR'];
        $reseturl = $_POST['reseturl'];
        $pass = mysqli_real_escape_string($conn, $_POST['pass']);
        $unit = preg_replace('/\W/', '', $_POST['unit']);
        $unit2 = htmlspecialchars($_POST['unit2'], ENT_QUOTES);
        $email2 = htmlspecialchars($_POST['email2'], ENT_QUOTES);
        $phone = preg_replace('/[^0-9-]/', '', $_POST['phone']);
        $owner = mysqli_real_escape_string($conn, empty($_POST['owner']) ? '0' : $_POST['owner']);
        $lease = mysqli_real_escape_string($conn, empty($_POST['lease']) ? '0' : $_POST['lease']);
        $realtor = mysqli_real_escape_string($conn, empty($_POST['realtor']) ? '0' : $_POST['realtor']);
        $staff = mysqli_real_escape_string($conn, $_POST['staff']);
        $directory = mysqli_real_escape_string($conn, $_POST['directory']);
        $dphone = mysqli_real_escape_string($conn, $_POST['dphone']);
        $accessdate = preg_replace('/[^0-9-]/', '', empty($_POST['accessdate']) ? '0000-00-00': $_POST['accessdate']);
        $account = mysqli_real_escape_string($conn, $_POST['account']);
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
        $packagedid = mysqli_real_escape_string($conn, $_POST['packagedid']);
        $ghost = htmlspecialchars($_POST['ghost'], ENT_QUOTES);
        $scheck = htmlspecialchars($_POST['scheck'], ENT_QUOTES);
        $useragent = $_SERVER['HTTP_USER_AGENT'];

        $sms_opt_in = empty($_POST['sms_opt_in']) ? "0" : "1";

        $query = "SELECT email FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);
        $email_taken = false;
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $email_taken = true;
        }
        if ($email_taken == true) {
            $success = "false";
            $errorEmail = "<br>Sorry, that email address is already in use.<br></big><a href='connect-help.php'>Retrieve your password.</a><big><br><br>";
        } else if ($email != $email2) {
            $success = "false";
            $errorEmail = "<br>Oops!... The emails addresses entered did not match.<br><br>";
        } else {
            if ($staff != '' && $scheck == '') {
                if ($pass != "" && $first_name != "" && $last_name != "" && $email != "" && $phone != "") {

                    $hash = password_hash($pass, PASSWORD_BCRYPT);
                    $query = "INSERT INTO users (password, first_name, last_name, email, phone, useripaddress, directory, dphone, owner, lease, realtor, account, flex1, flex2, flex3, flex4, flex5, club1, club2, club3, club4, club5, packagepreference, packagedid, ghost, `hide`, `status`) VALUES ('$hash', '$first_name', '$last_name', '$email', '$phone', '$useripaddress', '$directory', '$dphone', '1', '1', '1', '$account', '$flex1', '$flex2', '$flex3', '$flex4', '$flex5', '$club1', '$club2', '$club3', '$club4', '$club5', '$packagepreference', '$packagedid', '$ghost', 'Y', 'new')";
                    mysqli_query($conn, $query) or die('Error, insert query 1 failed');

                    // -- Admin Email -- //
                    $communityurl = $_POST['communityurl'];
                    $fromname = "$CommunityName via CondoSites";

                    $subject = "CondoSites - $CommunityName - Manager or Staff Member Signup";
                    $body = "<!DOCTYPE HTML><html><body><div style='padding: 25px;'>";
                    $body .= "<p><b>A website user, identifying themselves as an association manager or staff member, has just registered with your CondoSites / " . $CommunityName . " community website.</b></p><p><b><big>Depending upon setup, your action may be required.</big></b></p><p>Access the Users and Passwords control panel to approve or audit this user.</p>Name: " . $first_name . " " . $last_name . "<br>User: Association Manager or Staff Member<br>Email: " . $email . "<br>Phone: " . $phone . "<br><br>User IP Address: " . $useripaddress . "<br>User Agent: " . $useragent . "<br><br><p><b>If this is you, and there are no other administrators registered to your site, contact your CondoSites Webmaster to have your login approved.</b></p>";
                    $body .= "</div><br><img src='" . $communityurl . "/pics/logo-small.png' style='max-width: 100px;'><br><br>Visit your <a href='" . $communityurl . "'>" . $CommunityName . " community website</a>.</p>";
                    $body .= "<p><b>Email Subscription</b><br><small>You are receiving this email because you are a registered user of the " . $CommunityName . " community website, operated by <a href='https://condosites.com' target='_blank'>CondoSites</a>.";
                    $body .= "<br><br><span style='color: darkred;'>DO NOT REPLY TO THIS EMAIL!</span> IT IS SENT FROM AN UNMONITORED ADDRESS.";
                    $body .= "<br><br><b><a href='" . $communityurl . "/spamhelp.php'>Are these emails being treated as spam?</a></b></p></small></body></html>";

                    $mail = new PHPMailer(true);
                    try {
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

                        $mail->addAddress($SITE_MANAGER_EMAIL);
                        $mail->Subject = "$subject";
                        $mail->Body = "$body";
                        $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

                        $mail->isHTML(true);
                        $mail->CharSet = 'UTF-8';
                        $mail->Encoding = 'base64';
                        $mail->send();
                    } catch (phpmailerException $e) {
                        echo $e->errorMessage(); //Pretty error messages from PHPMailer
                        $error = "<br>Error sending Admin email<br><br>";
                        $success = "false";
                    } catch (Exception $e) {
                        echo $e->getMessage(); //Boring error messages from anything else!
                        $error = "<br>Error sending Admin email<br><br>";
                        $success = "false";
                    }
                    if ($success === true) {

                        // -- User Email -- //
                        $reseturl = $_POST['reseturl'];
                        $communityurl = $_POST['communityurl'];
                        $fromname = "$CommunityName via CondoSites";
                        $fullname = "$first_name $last_name";

                        $subject = "Your New Login - $CommunityName via CondoSites";
                        $body = "<!DOCTYPE HTML><html><body><div style='padding: 25px;'>";
                        $body .= "<p><b>Welcome to your new " . $CommunityName . " community website!</b></p><p><big>Your login request has been submitted to the primary administrator in your community for review.</big></p><p><big><b>YOU WILL NOT HAVE ACCESS UNTIL THEY APPROVE YOUR LOGIN.</b></big></p><br><p><b><big><a href=" . $reseturl . "?email=" . $email . ">Please take a moment to confirm your email address by clicking here.</a></big></b></p>";
                        $body .= "</div><br><img src='" . $communityurl . "/pics/logo-small.png' style='max-width: 100px;'><br><br>Visit your <a href='" . $communityurl . "'>" . $CommunityName . " community website</a>.</p>";
                        $body .= "<p><b>Email Subscription</b><br><small>You are receiving this email because you are a registered user of the " . $CommunityName . " community website, operated by <a href='https://condosites.com' target='_blank'>CondoSites</a>.";
                        $body .= "<br><br><span style='color: #8b0000;'>DO NOT REPLY TO THIS EMAIL!</span> IT IS SENT FROM AN UNMONITORED ADDRESS.";
                        $body .= "<br><br><b><a href='" . $communityurl . "/spamhelp.php'>Are these emails being treated as spam?</a></b></p></small></body></html>";

                        $mail = new PHPMailer(true);
                        try {
                            $mail->isSMTP();
                            $mail->Host = $hostOPS;
                            $mail->SMTPAuth = $smtpauthOPS;
                            $mail->SMTPKeepAlive = $smtpkeepaliveOPS;
                            $mail->Port = $smtpportOPS;
                            $mail->SMTPSecure = $smtpsecureOPS;
                            $mail->Username = $usernameOPS;
                            $mail->Password = $passwordOPS;
                            $mail->setFrom($fromemailOPS, $fromname);

                            $mail->addAddress($email, $fullname);
                            $mail->Subject = "$subject";
                            $mail->Body = "$body";
                            $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

                            $mail->isHTML(true);
                            $mail->CharSet = 'UTF-8';
                            $mail->Encoding = 'base64';
                            $mail->send();
                        } catch (phpmailerException $e) {
                            echo $e->errorMessage(); //Pretty error messages from PHPMailer
                            $error = "<br>Error sending User Login email<br><br>";
                            $success = "false";
                        } catch (Exception $e) {
                            echo $e->getMessage(); //Boring error messages from anything else!
                            $error = "<br>Error sending User Login email<br><br>";
                            $success = "false";
                        }

                        if ($success === true) {
                            $query = "INSERT INTO log (action, tablename, useripaddress, comment) VALUES ('N', 'Passwords-Admin', '$useripaddress', '$first_name $last_name $email $useragent')";
                            mysqli_query($conn, $query) or die('Error, updating log failed');

                            header('Location: connect-thanks.php');
                        }

                    } //success check

                } else {
                    $error = "<br>You missed a spot! ALL fields are required.<br><br>";
                    $success = "false";
                }
            }
            if ($staff == '' && $scheck == '') {
                
                if ($pass != "" && $first_name != "" && $last_name != "" && $email != "" && $phone != "" && $unit != "" && $unit2 != "") {

                    $hash = password_hash($pass, PASSWORD_BCRYPT);
                    // add text notifications
                    $query = "INSERT INTO users (password, first_name, last_name, unit, unit2, email, phone, useripaddress, directory, dphone, owner, lease, realtor, account, flex1, flex2, flex3, flex4, flex5, club1, club2, club3, club4, club5, packagepreference, ghost, accessdate, authcode, sms_opt_in) VALUES ('$hash', '$first_name', '$last_name', '$unit', '$unit2', '$email', '$phone', '$useripaddress', '$directory', '$dphone', '$owner', '$lease', '$realtor', '$account', '$flex1', '$flex2', '$flex3', '$flex4', '$flex5', '$club1', '$club2', '$club3', '$club4', '$club5', '$packagepreference', '$ghost', '$accessdate','', '$sms_opt_in')";
                    mysqli_query($conn, $query) or die('Error, insert query 3 failed');

                    if ($sms_opt_in == "1" && !empty($sms_url)) {
                        
                        
                        $query  = "SELECT iframe FROM 3rd WHERE type = 'Password Request'";
                        $result = mysqli_query($conn, $query);
                        $givbee_check = $result->fetch_array(MYSQLI_ASSOC);
                        $iframe = $givbee_check['iframe'];
                        
                        if ($iframe == 'Open') {
                            
                            $group2 = empty($unit2) ? 'X' : $unit2;
                            $params = array(
                                'firstname' => $first_name,
                                'lastname' => $last_name,
                                'phone' => $phone,
                                'owner' => $owner,
                                'realtor' => $realtor,
                                'renter' => $lease,
                                'Group2' => $group2,
                                'unit' => $unit
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
                            $result = file_get_contents($sms_url, false, $streamContext);

                            //If $result is FALSE, then the request has failed.
                            if ($result === false) {
                                //If the request failed, throw an Exception containing
                                //the error.
                                $error = error_get_last();
                                die("Error communicating with GivBee. " . $error);
                            }
                        }
                    }

                    // -- Admin Email -- //
                    $communityurl = $_POST['communityurl'];
                    $fromname = "$CommunityName via CondoSites";

                    $subject = "CondoSites - $CommunityName - New User Signup";
                    $body = "<!DOCTYPE HTML><html><body><div style='padding: 25px;'>";
                    $body .= "<p><b>A website user has just registered with your CondoSites / " . $CommunityName . " community website.</b></p><p><b><big>Depending upon setup, your action may be required.</big></b></p><p>Access the Users and Passwords control panel to approve or audit this user.</p>Name: " . $first_name . " " . $last_name . "<br>Unit: " . $unit . " " . $unit2 . "<br>User: Owner=" . $owner . " Renter=" . $lease . " Realtor=" . $realtor . "<br>Email: " . $email . "<br>Phone: " . $phone . "<br><br>User IP Address: " . $useripaddress . "<br>User Agent: " . $useragent . "<br><br><p><b>If this is you, and there are no other administrators registered to your site, contact your CondoSites Webmaster to have your login approved.</b></p>";
                    $body .= "</div><br><img src='" . $communityurl . "/pics/logo-small.png' style='max-width: 100px;'><br><br>Visit your <a href='" . $communityurl . "'>" . $CommunityName . " community website</a>.</p>";
                    $body .= "<p><b>Email Subscription</b><br><small>You are receiving this email because you are a registered user of the " . $CommunityName . " community website, operated by <a href='https://condosites.com' target='_blank'>CondoSites</a>.";
                    $body .= "<br><br><span style='color: #8b0000;'>DO NOT REPLY TO THIS EMAIL!</span> IT IS SENT FROM AN UNMONITORED ADDRESS.";
                    $body .= "<br><br><b><a href='" . $communityurl . "/spamhelp.php'>Are these emails being treated as spam?</a></b></p></small></body></html>";

                    $mail = new PHPMailer(true);
                    try {
                        $mail->isSMTP();
                        $mail->Host = $hostOPS;
                        $mail->SMTPAuth = $smtpauthOPS;
                        $mail->SMTPKeepAlive = $smtpkeepaliveOPS;
                        $mail->Port = $smtpportOPS;
                        $mail->SMTPSecure = $smtpsecureOPS;
                        $mail->Username = $usernameOPS;
                        $mail->Password = $passwordOPS;
                        $mail->setFrom($fromemailOPS, $fromname);

                        $mail->addAddress($SITE_MANAGER_EMAIL);
                        $mail->Subject = "$subject";
                        $mail->Body = "$body";
                        $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

                        $mail->isHTML(true);
                        $mail->CharSet = 'UTF-8';
                        $mail->Encoding = 'base64';
                        $mail->send();
                    } catch (phpmailerException $e) {
                        echo $e->errorMessage(); //Pretty error messages from PHPMailer
                        $error = "<br>Error sending Admin email<br><br>";
                        $success = "false";
                    } catch (Exception $e) {
                        echo $e->getMessage(); //Boring error messages from anything else!
                        $error = "<br>Error sending Admin email<br><br>";
                        $success = "false";
                    }
                    if ($success === true) {
                        // -- User Email -- //
                        $reseturl = $_POST['reseturl'];
                        $communityurl = $_POST['communityurl'];
                        $fromname = "$CommunityName via CondoSites";
                        $fullname = "$first_name $last_name";

                        $subject = "Your new login - $CommunityName via CondoSites";
                        $body = "<!DOCTYPE HTML><html><body><div style='padding: 25px;'>";
                        $body .= "<p>Dear " . $first_name . ",</p><p><b>Welcome to your new " . $CommunityName . " community website.</b></p><p><big>Your login request has been submitted to the primary administrator in your community for review.</big></p><p><big><b>Depending on their setup, you may not have access until they approve your login.</b></big></p><br><p><b><big><a href=" . $reseturl . "?email=" . $email . ">Please take a moment to confirm your email address by clicking here.</a></big></b></p>";
                        $body .= "</div><br><img src='" . $communityurl . "/pics/logo-small.png' style='max-width: 100px;'><br><br>Visit your <a href='" . $communityurl . "'>" . $CommunityName . " community website</a>.</p>";
                        $body .= "<p><b>Email Subscription</b><br><small>You are receiving this email because you are a registered user of the " . $CommunityName . " community website, operated by <a href='https://condosites.com' target='_blank'>CondoSites</a>.";
                        $body .= "<br><br><span style='color: darkred;'>DO NOT REPLY TO THIS EMAIL!</span> IT IS SENT FROM AN UNMONITORED ADDRESS.";
                        $body .= "<br><br><b><a href='" . $communityurl . "/spamhelp.php'>Are these emails being treated as spam?</a></b></p></small></body></html>";

                        $mail = new PHPMailer(true);
                        try {
                            $mail->isSMTP();
                            $mail->Host = $hostOPS;
                            $mail->SMTPAuth = $smtpauthOPS;
                            $mail->SMTPKeepAlive = $smtpkeepaliveOPS;
                            $mail->Port = $smtpportOPS;
                            $mail->SMTPSecure = $smtpsecureOPS;
                            $mail->Username = $usernameOPS;
                            $mail->Password = $passwordOPS;
                            $mail->setFrom($fromemailOPS, $fromname);

                            $mail->addAddress($email, $fullname);
                            $mail->Subject = "$subject";
                            $mail->Body = "$body";
                            $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

                            $mail->isHTML(true);
                            $mail->CharSet = 'UTF-8';
                            $mail->Encoding = 'base64';
                            $mail->send();
                        } catch (phpmailerException $e) {
                            echo $e->errorMessage(); //Pretty error messages from PHPMailer
                            $error = "<br>Error sending User Login email<br><br>";
                            $success = "false";
                        } catch (Exception $e) {
                            echo $e->getMessage(); //Boring error messages from anything else!
                            $error = "<br>Error sending User Login email<br><br>";
                            $success = "false";
                        }
                        if ($success === true) {
                            header('Location: connect-thanks.php');
                        }

                    }

                } else {
                    $error = "<br>You missed a spot! ALL fields are required.<br><br>";
                    $success = "false";
                }
            }
        }
        if ($success === false) {
            echo $error;
        }
    }
}