<?php require_once('../my-documents/php7-my-db.php');
//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//require '/home/nodyss5/php/PHPMailer/PHPMailerAutoload.php';
//require '../../PHPMailer-6.3.0/src/PHPMailer.php';
//require '../../PHPMailer-6.3.0/src/SMTP.php';
//require '../../PHPMailer-6.3.0/src/Exception.php';
// require '/home/nodyss5/php/PHPMailer-6.3.0/src/PHPMailer.php';
// require '/home/nodyss5/php/PHPMailer-6.3.0/src/SMTP.php';
// require '/home/nodyss5/php/PHPMailer-6.3.0/src/Exception.php';

require '../my-documents/smtp.php';
include '../my-documents/givbee-config.php';

$success = "untried";
$useragent = $_SERVER['HTTP_USER_AGENT'];

if (!empty($_POST)) {
    $int1 = $_POST["int1"];
    $action = $_POST["action"];
    $scheck = htmlspecialchars($_POST['scheck'], ENT_QUOTES);
    $staff = mysqli_real_escape_string($conn, $_POST['staff']);
    $first_name = htmlspecialchars($_POST['first_name'], ENT_QUOTES);
    $last_name = htmlspecialchars($_POST['last_name'], ENT_QUOTES);
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES);
    $owner = isset($_POST['owner']) ? $_POST['owner'] : 0;
    $lease = isset($_POST['lease']) ? $_POST['lease'] : 0;
    $realtor = isset($_POST['realtor']) ? $_POST['realtor'] : 0;
    $staff = isset($_POST['staff']) ? $_POST['staff'] : 0;
    $sms_opt_in = isset($_POST['sms_opt_in']) ? $_POST['sms_opt_in'] : 0;
    $dphone = isset($_POST['dphone']) ? $_POST['dphone'] : "N";
    $directory = isset($_POST['directory']) ? $_POST['directory'] : "";
} else {
    $int1 = "";
    $action = "";
    $scheck = "";
    $staff =
    $first_name = "";
    $last_name = "";
    $email = "";
    $owner = 0;
    $lease = 0;
    $realtor = 0;
    $staff = 0;
    $sms_opt_in = 0;
    $dphone = "N";
    $directory = "";
}

//include('../../BUILD/user-registration-BOT-FILTERS.php');
//include('/home/nodyss5/www/BUILD/user-registration-BOT-FILTERS-2.php');
include('user-registration-BOT-FILTERS-2.php');

?>
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<!--[if lte IE 10]><meta http-equiv="refresh" content="0;url=../IE.html" /><![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="CondoSites - http://www.condosites.com" name="author">
	<title>Login Request | <?php include('../my-documents/communityname.html'); ?></title>
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	<link rel="stylesheet" href="../css/foundation.css">
	<link rel="stylesheet" href="../css/magnific-popup.css">
	<link rel="stylesheet" href="../css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/jquery-ui.min.css">
	<link rel="stylesheet" href="../css/jquery-ui.structure.min.css">
	<link rel="stylesheet" href="../css/datepickercontrol.css">
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
	  function hideMe (it, box) { 
		var vis = (box.checked) ? "none" : "block"; 
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

<!-- Message -->
    <div class="small-12 medium-4 large-5 columns">
      <div class="content-splash-main">

        <div class="row">
          <div class="small-12 columns">

<!-- BEGIN FORM CUSTOM TEXT -->
<?php
	$query  = "SELECT theircode FROM 3rd WHERE type = 'Password Request'";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php echo "{$row['theircode']}"; ?>
<?php
	}
?>
If you have previously created a log-in on this site and do not remember your password, login email address, or you are having difficulty <a href="connect-help.php" title="Login Help">get login help</a>.
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
          <div class="small-10 medium-12 large-10 end columns">Your session is not SSL encrypted.<br><small>Reload page to try again.</a></small></div>
        </div>
<?php }; ?>

          </div>
        </div>
      </div>

        </div>

<!-- Login -->
    <div class="small-12 medium-8 large-7 columns">
      <div class="content-splash-main">

        <div class="row">
          <div class="small-12 columns"><h3>Create your login...<span class="note-red"><big><big><?php echo (isset($error) ? $error : ""); ?><?php echo( isset($errorEmail) ? $errorEmail : ""); ?></big></big></span></h3></div>
        </div>

	<form method="POST" action="connect-request.php" name="theform" id="theform">

        <div class="row">
          <div class="small-4 medium-3 large-3 columns"><label for="first_name" class="middle">First Name</label></div>
          <div class="small-8 medium-9 large-9 end columns"><input name="first_name" type="text" id="first_name" maxlength="30" class="form" value="<?php echo($_POST['first_name']); ?>" autocomplete="off" placeholder="John"/></div>
        </div>

        <div class="row">
          <div class="small-4 medium-3 large-3 columns"><label for="last_name" class="middle">Last Name</label></div>
          <div class="small-8 medium-9 large-9 end columns"><input name="last_name" type="text" id="last_name" maxlength="30" class="form" value="<?php echo($_POST['last_name']); ?>" autocomplete="off" placeholder="Doe"/></div>
        </div>
        
        <div class="row">
          <div class="small-3 medium-3 large-3 columns"><label for="last_name" class="middle">I am a</label></div>
          <div class="small-9 medium-9 large-9 end columns">

<div class="row">
<div style="float:left;">
<input type="checkbox" name="owner" <?php if ($owner == '1'){ ?>checked ="true"<?php }; ?> value="1" onclick="showMe('owner', this)" /><label>Owner&nbsp;&nbsp;</label>
</div>

<div style="float:left;">
<input type="checkbox" name="lease" <?php if ($lease == '1'){ ?>checked ="true"<?php }; ?> value="1" onclick="showMe('lease', this)"><label>Renter&nbsp;&nbsp;</label>
</div>

<div style="float:left;">
<input type="checkbox" name="realtor" <?php if ($realtor == '1'){ ?>checked ="true"<?php }; ?> value="1" onclick="showMe('realtor', this); hideMe('flexhide', this)"><label>Realtor&nbsp;&nbsp;</label>
</div>
</div>

<div class="row">
<div style="float:left;">
<input type="checkbox" name="staff" <?php if ($staff == '1'){ ?>checked ="true"<?php }; ?> value="1" onclick="showMe('staff', this); hideMe('unithide', this); hideMe('directoryprefhide', this); hideMe('flexhide', this)" /><label>Association&nbsp;Manager or&nbsp;Staff&nbsp;Member</label>
</div>
</div>

<div class="row" id="staff" style="display:none"><span class="note-red">Your access will be held subject to administrator approval.</span></div>

          </div>
        </div>


	<div class="row" id="owner" style="display:none">
<?php include('../my-documents/accountnumber-register.php'); ?>
	</div>


	<div id="lease" style="display:none">
        <div class="row">
            <hr>
        </div>
        <div class="row">
	        <div class="small-5 medium-5 large-5 columns"><label for="accessdate" class="middle">End of Lease Date</label></div>
	        <div class="small-7 medium-7 large-7 end columns"><input name="accessdate" class="form datepicker" type="date" size="10" value="<?php echo($_POST['accessdate']); ?>" placeholder="<?php echo date("Y-m-d", strtotime($date ."+180 days" )); ?>" /></div>
        </div>
	</div>


        <div class="row">
        <hr>
        </div>

	<div class="row" id="realtor" style="display:none"><span class="note-red">Realtors, please enter the address of the unit you are representing.<br>If you are not representing a specific unit, enter "0" and (if shown) select the first street/building in the pulldown list.<br><br></span></div>

<div id="unithide" style="display:block">

        <div class="row">
<?php include('../my-documents/units-table-register.php'); ?>
        </div>

        <div class="row">
        <hr>
        </div>

</div>

        <div class="row">
          <div class="small-5 medium-5 large-5 columns"><label for="phone" class="middle"><?php if (isset($sms_url) && !empty($sms_url)) { ?>Mobile <?php } ?>Phone Number</label></div>
          <div class="small-7 medium-7 large-7 end columns"><input name="phone" type="tel" size="13" maxlength="15" class="form" value="<?php echo($_POST['phone']); ?>" autocomplete="off" placeholder="000-000-0000" /></div>
        </div>
        
        <!-- Givbee Code -->
        <?php if (isset($sms_url) && !empty($sms_url)) { ?>
        <div class="row">
            <div class="small-2 medium-1 large-1 columns" align="right">
                <input type="checkbox" name="sms_opt_in" value="1" <?php if($sms_opt_in == '1'){ ?>checked="true"<?php }; ?>>
            </div>
            <div class="small-10 medium-11 large-11 end columns">
                <label for="sms_opt_in" class="middle">Please add my mobile phone number above to the association&apos;s texting list.<br></label>
            </div>
        </div>
        <div class="row">
            <span class="note-black"><i>Msg&amp;data rates may apply. Frequency of messages varies. Your number will never be sold. If you change your mind, you can modify your selections by editing your profile after you login or reply "STOP" to any text message. Service powered by <a href='https://www.givbee.com/' target='_blank'>GivBee.com</a></i></span></label>
        </div>
        <?php } ?>
        <!-- End GivBee Code -->

<div id="flexhide" style="display:block">
<?php include('../my-documents/user-packagepreference-register.php'); ?>
<?php include('../my-documents/user-packagedid-register.php'); ?>
<?php include('../my-documents/user-flex-register.php'); ?>
<?php include('../my-documents/user-club-register.php'); ?>
</div>

        <div class="row">
        <hr>
        </div>

        <div class="row">

	  <span class="note-red"><big><big><?php echo($errorEmail); ?></big></big></span>

          <div class="small-5 medium-5 large-5 columns"><label for="email" class="middle">Email Address</label></div>
          <div class="small-7 medium-7 large-7 end columns"><input name="email" class="form" type="email" id="email" maxlength="100" placeholder="email@domain.com" autocomplete="off" value="<?php echo($_POST['email']); ?>" /></div>
        </div>

        <div class="row">
          <div class="small-5 medium-5 large-5 columns"><label for="email2" class="middle">Re-enter Email Address</label></div>
          <div class="small-7 medium-7 large-7 end columns"><input name="email2" class="form" type="email" id="email2" maxlength="100" placeholder="email@domain.com" autocomplete="off" value="<?php echo($_POST['email2']); ?>" /></div>
        </div>

        <div class="row">
          <div class="small-5 medium-5 large-5 columns">
	    <label for="email2" class="middle">Email Preference*
          </div>
          <div class="small-7 medium-7 large-7 end columns">

<div style="float:left;">
<input type="radio" name="ghost" value="A" <?php if($_POST['ghost'] == 'A'){ ?>checked<?php }; ?><?php if($_POST['ghost'] == ''){ ?>checked<?php }; ?>><label>All</label>
</div>

<div style="float:left;">
<input type="radio" name="ghost" value="U" <?php if($_POST['ghost'] == 'U'){ ?>checked<?php }; ?>><label>Urgent&nbsp;Only</label><br>
</div>

<div style="float:left;">
<input type="radio" name="ghost" value="N" <?php if($_POST['ghost'] == 'N'){ ?>checked<?php }; ?>><label>None</label>
</div>

          </div>
        </div>
        
<div class="row">
<span class="note-black"><i>*Preference applies only to messages sent via CondoSites software.</i></span></label>
</div>
        
        <div class="row">
        <hr>
        </div>

<div id="directoryprefhide" style="display:block">
        <div class="row">
          <div class="small-2 medium-1 large-1 columns" align="right">
              <input type="checkbox" name="directory" value="Y" <?php if($directory == 'Y'){ ?>checked="true"<?php }; ?>>
          </div>
          <div class="small-10 medium-11 large-11 end columns"><label> Make my <b>email address</b> available in the Resident Directory.</label></div>
        </div>
        <div class="row">
          <div class="small-2 medium-1 large-1 columns" align="right">
              <input type="checkbox" name="dphone" value="Y" <?php if($dphone == 'Y'){ ?>checked="true"<?php }; ?>>
          </div>
          <div class="small-10 medium-11 large-11 end columns"><label> Make my <b>phone number</b> available in the Resident Directory.</label>
        </div>
        <div class="row">
          <div class="small-12 medium-12 large-12 columns">
		<span class="note-black"><i>If you change your mind, you can modify your selections by editing your profile after you login.</i></span>
            </div>
          </div>
        </div>

        <div class="row">
        <hr>
        </div>
</div>

        <div class="row">
          <div class="small-6 medium-5 large-5 columns">
              <label for="password" class="middle">Choose a Unique Password</label>
          </div>
          <div class="small-6 medium-7 large-7 end columns">
              <input name="pass" id="pass" type="password" size="13" maxlength="100" autocomplete="off" class="form" value="<?php echo($_POST['pass']); ?>" autocomplete="off" />
              <div style="margin-top: -45px; margin-right: 0px;" required>
                  <i class="fa fa-eye" id="togglePassword" style="color: #000; margin-right: 6px; margin-top: 4px; float: right; cursor: pointer;position: relative;z-index: 1"></i>
              </div>
          </div>
        </div>

        <div class="row">
          <div class="small-12 columns text-center">
            <span class="note-black">By submitting login request, you agree to our <a href="https://condosites.com/termsofuseagreement.php" target="_blank">Terms of use and Privacy Policy</a>.</span><br><br>
		    <span class="note-red"><big><big><?php echo(isset($error) ? $error : ""); ?></big></big></span>
		    <span class="note-red"><big><big><?php echo(isset($errorEmail) ? $errorEmail : ""); ?></big></big></span>
		    <input name="reseturl" type="hidden" value="<?php include('../my-documents/communityurl-ssl.html'); ?>/splash/connect-verify.php" readonly />
		    <input name="communityurl" type="hidden" size="1" value="<?php include('../my-documents/communityurl-ssl.html'); ?>" readonly />
		    <input type="hidden" name="scheck" class="form" maxlength="5" value="" autocomplete="off" />
		    <input type="hidden" name="action" value="add" />
		    <span class="note-red">Click the Submit Login Request button once!</span><br>
		    <input type="submit" class="submit" value="Submit Login Request" onclick="value='Processing Request - Resubmit'; style='color:red';" />
		    <br>
	      </div>
        </div>

	</form>

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

	<script src="../java/vendor/jquery.js"></script>
	<script src="../java/vendor/jquery-ui.min.js"></script>
	<script src="../java/vendor/what-input.js"></script>
	<script src="../java/vendor/foundation.min.js"></script>
	<script src="../java/form.js"></script>
	<script>
		$(document).foundation();
	</script>
	<script type="text/javascript" src="../java/google-base.js"></script>
	<script type="text/javascript" src="../my-documents/google-code.js"></script>
    <script type="text/javascript">
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#pass');

        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye slash icon
            this.classList.toggle('fa-eye-slash');
        });
    </script>

</html>
