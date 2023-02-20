<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '/home/nodyss5/php/PHPMailer-6.3.0/src/PHPMailer.php';
require '/home/nodyss5/php/PHPMailer-6.3.0/src/SMTP.php';
require '/home/nodyss5/php/PHPMailer-6.3.0/src/Exception.php';
//require '/home/nodyss5/php/PHPMailer/PHPMailerAutoload.php';
require_once('../my-documents/php7-my-db.php');
require '../my-documents/smtp.php';
include '../my-documents/givbee-config.php';

$id = $_SESSION["id"];
$action = $_POST["action"];
if ($action == "save"){

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$first_name = htmlspecialchars($_POST['first_name'], ENT_QUOTES);
		$last_name = htmlspecialchars($_POST['last_name'], ENT_QUOTES);
		$unit = htmlspecialchars($_POST['unit'], ENT_QUOTES);
		$unit2 = htmlspecialchars($_POST['unit2'], ENT_QUOTES);
		$email = htmlspecialchars($_POST['email'], ENT_QUOTES);
		$phone = htmlspecialchars($_POST['phone'], ENT_QUOTES);
		$directory = mysqli_real_escape_string($conn, $_POST['directory']);
		$dphone = mysqli_real_escape_string($conn, $_POST['dphone']);
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
		$sms_optin = isset($_POST['sms_optin']) ? $_POST['sms_optin'] : '';
		$packagepreference = htmlspecialchars($_POST['packagepreference'], ENT_QUOTES);
		$packagedid = htmlspecialchars($_POST['packagedid'], ENT_QUOTES);
		$ghost = htmlspecialchars($_POST['ghost'], ENT_QUOTES);
		
		$query = "SELECT email FROM users WHERE email = '$email' AND `id` != '$id'";
		$result = mysqli_query($conn, $query);
		$email_taken = false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$email_taken = true;
		}
		if($email_taken == true){
			$success = "false";
			$errorEmail = "That email address is already in use!";
		} else {
		
		if($first_name != "" && $last_name != "" && $email != "" && $phone != "" && $unit != "" && $unit2 != ""){

		    //Givbee Integration
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
                if (empty($_POST['sms_optin'])) {
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
                file_get_contents($sms_url, false, $streamContext);
            }

	
		$query = "UPDATE users SET first_name='$first_name', last_name='$last_name', unit='$unit', unit2='$unit2', email='$email', phone='$phone', directory='$directory', dphone='$dphone', account='$account', flex1='$flex1', flex2='$flex2', flex3='$flex3', flex4='$flex4', flex5='$flex5', club1='$club1', club2='$club2', club3='$club3', club4='$club4', club5='$club5', packagepreference='$packagepreference', packagedid='$packagedid', ghost='$ghost', sms_opt_in='$sms_optin' WHERE `id`='$id' LIMIT 1";
            mysqli_query($conn,$query) or die('Error, update query failed');
		
		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('E', 'Profile Edit USER', '$useripaddress', '$userid', '$id')";
		mysqli_query($conn,$query) or die('Error, updating log failed');

        if($email != $_POST['oldemail']){

    	    if($email == ""){
    	        $error = "All fields are required!";
			    $success = "false";
            }
    
            else {
                
        	    $query = "UPDATE `users` SET `emailconfirm`='C' WHERE `id`='$id' LIMIT 1";
        		mysqli_query($conn,$query) or die('Error, update query failed');

                $username = "$first_name $last_name";
                $useremail = $email;
                $reseturl = $_SESSION['reseturl'];
                $communityurl = $_SESSION['communityurl'];
                $fromname = "$CommunityName via CondoSites";
            
                $body = "<!DOCTYPE HTML><html><body><div style='padding: 25px;'>";
                $body .= "<p>Dear ".$username.",</p> <p><b>In an effort to reduce spam and bounce messages, we are asking all users of the ".$CommunityName." website to confirm their email address.</b></p>";
                $body .= "<p><big><b><a href=".$reseturl."?email=".$useremail.">Please take a moment to confirm by clicking here</a>.</b></big></p><p>Or you may copy/paste this address into your browser: ".$reseturl."?email=".$useremail."</p>";
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
		            header('Location: user-thanks.php');
                }
            }
            
		} else {
			$error = "All fields are required!";
			$success = "false";
		}

	}
	}
}	
?>
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<!--[if lte IE 10]><meta http-equiv="refresh" content="0;url=../IE.html" /><![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="CondoSites - http://www.condosites.com" name="author">
	<title>Update Profile | <?php include('../my-documents/communityname.html'); ?></title>
	<?php include('../my-documents/meta-robots.html'); ?>
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
	<script type="text/javascript"> 
	<!-- 
	  function showMe (it, box) { 
		var vis = (box.checked) ? "block" : "none"; 
		document.getElementById(it).style.display = vis;
	  } 
	  //--> 
	</script>
</head>

<?php if (empty($_SERVER['HTTPS'])) {
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}; ?>

<body>

<div id="all-documents-folder" class="stand-alone-page">
  <div class="popup-header">
    <h4>
My Profile
    </h4>
  </div>

<!-- Mobile Filter Notice -->
  <div class="stand-alone-page-content">
    <div class="rotate-note"></div>
  </div>
  
</div>

<!-- ******************************************** -->
<!-- MAIN CONTENT -->

<!-- Main Content Setup -->
<div class="container">

<br>

<!-- Content Setup -->
  <div class="row">

    <div class="small-12 medium-12 large-6 columns">

<!-- Message -->
      <div class="content-splash-main">

        <div class="row">
          <div class="small-12 columns"><h3>Profile</h3></div>
        </div>

        <div class="row">
          <div class="small-12 columns">

<!-- BEGIN FORM CUSTOM TEXT -->
<?php if ((($_SESSION['owner'] == true) OR ($_SESSION['lease'] == true) OR ($_SESSION['realtor'] == true)) AND (($_SESSION['ghost'] != 'Y') AND ($_SESSION['webmaster'] != true))){ ?>
Edit or disable your profile, customize your preferences, and change your password, on this page.
<?php }; ?>

<?php if (($_SESSION['owner'] != true) AND ($_SESSION['lease'] != true) AND ($_SESSION['realtor'] != true)){ ?>
<big>Sorry, you need to be logged in to view this content.</big>
<?php }; ?>

<?php if (($_SESSION['ghost'] == 'Y') AND ($_SESSION['webmaster'] != true)){ ?>
<big>Sorry, this page is not available to guests.</big>
<?php }; ?>

<?php if ($_SESSION['webmaster'] == true){ ?>
<big>Sorry, Webmaster profiles can not be edited here.</big>
<?php }; ?>

<!-- END FORM CUSTOM TEXT -->

          </div>
        </div>

      </div>

<!-- Message -->
      <div class="content-splash-sub">
        <div class="row">
          <div class="small-12 columns">

<?php if (!empty($_SERVER['HTTPS'])) { ?>
        <div class="row">
          <div class="small-2 medium-12 large-2 columns"><i class="fa fa-lock big" aria-hidden="true"></i></div>
          <div class="small-10 medium-12 large-10 end columns">We are committed to security.<br><small>Your session is encrypted for added protection.</small></div>
        </div>
<?php }; ?>

<?php if (empty($_SERVER['HTTPS'])) { ?>
        <div class="row">
          <div class="small-2 medium-12 large-2 columns"><i class="fa fa-unlock big" aria-hidden="true"></i></div>
          <div class="small-10 medium-12 large-10 end columns">Your session is not SSL encrypted.<br><small>Reload page to try again or try again later.</a></small></div>
        </div>
<?php }; ?>

          </div>
        </div>
      </div>

<?php if ((($_SESSION['owner'] == true) OR ($_SESSION['lease'] == true) OR ($_SESSION['realtor'] == true)) AND (($_SESSION['ghost'] != 'Y') AND ($_SESSION['webmaster'] != true))){ ?>
<form name="PWEdit" method="POST" action="">

      <div class="content-splash-main">

        <div class="row">
          <div class="small-12 columns"><h3>Preferences</h3></div>
        </div>



<?php
	$query  = "SELECT `first_name`, `last_name`, `unit`, `unit2`, `phone`,`owner`, `realtor`,`lease`, `email`, `directory`, `dphone`, `account`, `flex1`, `flex2`, `flex3`, `flex4`, `flex5`, `packagepreference`, `packagedid`, `ghost`, `status`, `sms_opt_in` FROM users WHERE `id`='$id' LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
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
            $givbee_status = file_get_contents($sms_url, false, $streamContext);
        }
        
        if ($row['status'] == 'Active') {
          $row['sms_opt_in'] = ($givbee_result == "Opted-In" ? 1 : 0);
        }

?>

        <div class="row">
          <div class="small-5 medium-7 large-7 end columns"><label for="ghost" class="middle">Email Delivery<br><span class="note-black"><i>*Preference applies only to mass email messages sent by your community via CondoSites software. Other emails related to your profile, such as package delivery notifications, pet and vehicle registrations, service requests, and password reset emails will continue to be sent.</i></span></label></div>
          <div class="small-7 medium-5 large-5 end columns">

<div>
<input type="radio" name="ghost" value="A" <?php if($row['ghost'] == 'A'){ ?>checked<?php }; ?><?php if($row['ghost'] == ''){ ?>checked<?php }; ?>><label>All Emails</label>
</div>

<div>
<input type="radio" name="ghost" value="U" <?php if($row['ghost'] == 'U'){ ?>checked<?php }; ?>><label>Urgent&nbsp;Only</label><br>
</div>

<div>
<input type="radio" name="ghost" value="N" <?php if($row['ghost'] == 'N'){ ?>checked<?php }; ?>><label>None</label>
</div>

          </div>
        </div>

        <div class="row">
        <hr>
        </div>
        
        <?php if (isset($sms_url) && !empty($sms_url)) { ?>
        <!-- Givbee Code -->
        <div class="row">
           <div class="small-12 end columns"><label for="ghost" class="middle">SMS Text Messaging</div>
        </div>
        <div class="row">
            <div class="small-2 medium-1 large-1 columns" align="right">
                <input name="sms_optin" type="checkbox" class="form" value="1" <?php echo ($row['sms_opt_in'] == 1) ? 'checked' : '';?>/>
            </div>
            <div class="small-10 medium-11 large-11 end columns">
                <label for="sms_opt_in" class="middle">Yes, please add my cell phone to <?php include('../my-documents/communityname.html'); ?> texting list.<br></label>
            </div>
        </div>
        <div class="row">
            <div class="small-12 end columns"><span class="note-black"><i>Msg&amp;data rates may apply. Frequency of messages varies. Your number will never be sold. If you change your mind, you can modify your selections by editing your profile after you login or reply "STOP" to any text message.<br>Service powered by <a href='https://www.givbee.com/' target='_blank'>GivBee.com</a></i></span></label></div>
        </div>
        <div class="row">
        <hr>
        </div>
        <!-- End givbee Code -->
        <?php } ?>

        <div class="row">
          <div class="small-2 medium-1 large-1 columns" align="right"><input type="checkbox" name="directory" value="Y" <?php if($row['directory'] == 'Y'){ ?>checked="true"<?php }; ?>></div>
          <div class="small-10 medium-11 large-11 end columns"><label> Make my <b>email address</b> available in the Resident Directory.</label></div>
        </div>
        <div class="row">
          <div class="small-2 medium-1 large-1 columns" align="right"><input type="checkbox" name="dphone" value="Y" <?php if($row['dphone'] == 'Y'){ ?>checked="true"<?php }; ?>></div>
          <div class="small-10 medium-11 large-11 end columns"><label> Make my <b>phone number</b> available in the Resident Directory.</label></div>
        </div>
        
        <div class="row">
        <hr>
        </div>

        <div class="row">
<?php include('../my-documents/user-packagepreference-edit.php'); ?>
        </div>
        <div class="row">
<?php include('../my-documents/user-packagedid-edit.php'); ?>
        </div>



<?php
	}
?>

      

    </div>

<!-- Message -->
      <div class="content-splash-main">

        <div class="row">
          <div class="small-12 columns"><h3>Password</h3></div>
        </div>

        <div class="row">
          <div class="small-12 columns">

<!-- BEGIN FORM CUSTOM TEXT -->
<?php if ((($_SESSION['owner'] == true) OR ($_SESSION['lease'] == true) OR ($_SESSION['realtor'] == true)) AND (($_SESSION['ghost'] != 'Y') AND ($_SESSION['webmaster'] != true))){ ?>
<a href="user-password.php"><u>Change your password</u></a>
<?php }; ?>

<!-- END FORM CUSTOM TEXT -->

          </div>
        </div>

      </div>

  </div>
<?php }; ?>

<!-- ******************************************** -->
<!-- PROFILE -->

<?php if ((($_SESSION['owner'] == true) OR ($_SESSION['lease'] == true) OR ($_SESSION['realtor'] == true)) AND (($_SESSION['ghost'] != 'Y') AND ($_SESSION['webmaster'] != true))){ ?>

<!-- Edit Profile -->
    <div class="small-12 medium-12 large-6 columns">
      <div class="content-splash-main">

<?php
	$query  = "SELECT `first_name`, `last_name`, `unit`, `unit2`, `phone`, `email`, `directory`, `dphone`, `account`, `flex1`, `flex2`, `flex3`, `flex4`, `flex5`, `packagepreference`, `ghost` FROM users WHERE `id`='$id' LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>

        <div class="row">
          <div class="small-12 columns"><h3>Edit</h3><span class="note-red"><big><big><?php echo($error); ?><?php echo($errorEmail); ?></big></big></span></div>
        </div>

        <div class="row">
          <div class="small-5 medium-3 large-3 columns"><label for="first_name" class="middle">First Name</label></div>
          <div class="small-7 medium-9 large-9 end columns"><input name="first_name" type="text" id="first_name" maxlength="30" class="form" value="<?php echo($row['first_name']); ?>" autocomplete="off"/></div>
        </div>

        <div class="row">
          <div class="small-5 medium-3 large-3 columns"><label for="last_name" class="middle">Last Name</label></div>
          <div class="small-7 medium-9 large-9 end columns"><input name="last_name" type="text" id="last_name" maxlength="30" class="form" value="<?php echo($row['last_name']); ?>" autocomplete="off"/></div>
        </div>
        
<?php if ($row['owner'] == '1'){ ?>
	<div class="row">
<?php include('../my-documents/accountnumber-edit.php'); ?>
	</div>
<?php }; ?>
<?php if ($row['lease'] == '1'){ ?>
	<div class="row">
	  <div class="small-5 medium-5 large-5 columns"><label for="accessdate" class="middle">End of Lease Date</label></div>
	  <div class="small-7 medium-7 large-7 end columns"><input name="accessdate" class="form" type="date" id="DPC_date1" size="10" value="<?php echo($row['accessdate']); ?>"></div>
	</div>
<?php }; ?>

        <div class="row">
        <hr>
        </div>

        <div class="row">
<?php include('../my-documents/units-table-edit.php'); ?>
        </div>

        <div class="row">
        <hr>
        </div>

        <div class="row">
          <div class="small-5 medium-5 large-5 columns"><label for="phone" class="middle">Phone Number</label></div>
          <div class="small-7 medium-7 large-7 end columns"><input name="phone" type="tel" size="13" maxlength="15" class="form" value="<?php echo($row['phone']); ?>" autocomplete="off"/></div>
        </div>


<?php include('../my-documents/user-flex-edit.php'); ?>
<?php include('../my-documents/user-club-edit.php'); ?>


        <div class="row">

	  <span class="note-red"><big><big><?php echo($errorEmail); ?></big></big></span>

          <div class="small-5 medium-5 large-5 columns"><label for="email" class="middle">Email Address</label></div>
          <div class="small-7 medium-7 large-7 end columns"><input name="email" class="form" type="email" id="email" maxlength="100" value="<?php echo($row['email']); ?>"></div>
        </div>

<?php
	}
?>


      </div>
    </div>
<?php }; ?>

<?php if ((($_SESSION['owner'] == true) OR ($_SESSION['lease'] == true) OR ($_SESSION['realtor'] == true)) AND (($_SESSION['ghost'] != 'Y') AND ($_SESSION['webmaster'] != true))){ ?>

<!-- Save -->
    <div class="small-12 medium-12 large-6 columns">
      <div class="content-splash-main">

        <div class="row">
          <div class="small-12 columns"><h3>Save Changes</h3></div>
        </div>

        <div class="row">
          <div class="small-8 medium-8 large-8 columns">
		<span class="note-red"><big><big><?php echo($error); ?></big></big></span>
		<span class="note-red"><big><big><?php echo($errorEmail); ?></big></big></span>
          </div>
          <div class="small-4 medium-4 large-4 end columns">
		<input type="hidden" name="action" value="save">
		<input type="hidden" name="oldemail" value="<?php echo($row['email']); ?>">
		<input name="reseturl" type="hidden" value="<?php include('../my-documents/communityurl-ssl.html'); ?>/splash/connect-verify.php" readonly />
		<input name="communityurl" type="hidden" size="1" value="<?php include('../my-documents/communityurl-ssl.html'); ?>" readonly />
		<input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>">
		<input name="submit" value="Save Changes" class="submit" type="submit" onclick="value='Processing Request - Resubmit'; style='color:red';" />
		    </div>
        </div>

      </div>

    </div>

</form>

<!-- Disable -->

<?php
	if ($action == "DisableProfile"){

		$id = $_SESSION['id'];
		$currentdate = date('Y-m-d');
		$query = "UPDATE users SET `accessdate`='$currentdate', status='disabled' WHERE `id`='$id' LIMIT 1";
		mysqli_query($conn,$query) or die('Error, update query failed');
		
		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('D', 'Profile Disable-USER', '$useripaddress', '$userid', '$id')";
		mysqli_query($conn,$query) or die('Error, updating log failed');
		
		header('Location: ../index.php');

	}
?>

    <div class="small-12 medium-12 large-6 columns">
      <div class="content-splash-sub">

        <div class="row">
          <div class="small-12 columns"><h3>Disable Profile</h3></div>
        </div>

        <div class="row">
          <div class="small-12 medium-12 large-8 columns"><b>If you disable your profile, it can only be reactivated by an Administrator.</b><br>Once disabled, it will be purged after one year of inactivity.</div>
          <div class="small-12 medium-12 large-4 columns">
		<form name="DisableProfile" method="POST" onclick="return confirm('Are you sure you want to disable your profile? It can only be reactivated by an Administrator.');">
		  <input type="hidden" name="action" value="DisableProfile">
		  <input type="hidden" name="id" value="<?php echo($_SESSION['id']); ?>">
		  <input name="submit" value="Disable Profile" class="submit" type="submit" onclick="value='Processing Request'; style='color:red';" />
		</form>
          </div>
        </div>

    </div>
  </div>

<?php } ?>

</div>

<!-- Content Setup -->
  </div>

<!-- END PROFILE -->
<!-- ******************************************** -->

<!-- End Main Content Setup -->
</div>

</body>

	<script src="../java/vendor/what-input.js"></script>
	<script src="../java/vendor/foundation.min.js"></script>
	<script src="../java/app.js"></script>
	<script>
		$(document).foundation();
	</script>
	<script type="text/javascript" src="../java/google-base.js"></script>
	<script type="text/javascript" src="../my-documents/google-code.js"></script>

</html>