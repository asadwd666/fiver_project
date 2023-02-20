<?php
// Old mysql call
// require_once('my-documents/php7-my-db.php');
require_once('my-documents/php7-my-db.php');
$error = "";

/* Check for Email Address and Password */

if($_POST){
	if(empty($_POST['email']) || empty($_POST['password'])) {
		$error = '<br><i class="fa fa-exclamation-triangle note" aria-hidden="true" title="Action!"></i> Please enter your email address and password.<br><br>';
	} else {

/* Query database for email address */

        $sqlEMAIL = mysqli_query($conn,"SELECT count(*) FROM `users` WHERE `email`='".mysqli_real_escape_string($conn, $_POST['email'])."'") or die(mysqli_error($conn));
        //$countEMAIL = mysql_result($sqlEMAIL, "0");
        $row = mysqli_fetch_row($sqlEMAIL);
        $countEMAIL = $row[0];

        if ($countEMAIL == '0'){ $error = '<br><i class="fa fa-exclamation-triangle note" aria-hidden="true" title="Action!"></i> Invalid email address or password.<br><span style="text-decoration: underline;"><a href="splash/connect-help.php" class="iframe-link">Reset your password or get login help here.</a></span>'; };

/* Query database for hashed password */

		$queryHASH = "SELECT `password`, `email` FROM users WHERE email='".mysqli_real_escape_string($conn, $_POST['email'])."'";
		$resultHASH = mysqli_query($conn,$queryHASH) or die('There was an error, contact CondoSites and report error: Password Head, line 9');
		while($rowHASH = $resultHASH->fetch_array(MYSQLI_ASSOC))

/* Verify hashed password with typed password */

		if (($_POST['email'] = $rowHASH['email']) AND (password_verify($_POST['password'], $rowHASH['password']))) {

/* Grab current date for Access Through Date comparison */
		$currentdate = date("Y-m-d");
		
/* Query user content, verify permissions, and access */
		$query = "SELECT `status`, `accessdate`, `owner`, `realtor`, `lease`, `board`, `concierge`, `liaison`, `webmaster`, `email`, `password`, `first_name`, `last_name`, `unit`, `unit2`, `phone`, `ghost`, `id`, `flex1`, `flex2`, `flex3`, `flex4`, `flex5`, `emailconfirm` FROM users WHERE email='".mysqli_real_escape_string($conn, $_POST['email'])."'";
		$result = mysqli_query($conn,$query) or die('Error, select query failed');
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
		
/* Check account status */
				if($row['status'] == "new") {
					$error = '<br><i class="fa fa-exclamation-triangle note" aria-hidden="true" title="Action!"></i> Your account has not been approved yet.<br><br>';
				} else if($row['status'] == "disabled") {
					$error = '<br><i class="fa fa-exclamation-triangle note" aria-hidden="true" title="Action!"></i> Your account is disabled. <a href="splash/connect-disabled.php?choice=disabled" class="iframe-link"><u>Request Reactivation</u></a><br><br>';
				} else if($row['accessdate'] >= '0000-00-01' && $row['accessdate'] <= $currentdate) {
					$error = '<br><i class="fa fa-exclamation-triangle note" aria-hidden="true" title="Action!"></i> You have reached the end of your lease/access through date, and your account was suspended. <a href="splash/connect-disabled.php?choice=suspended" class="iframe-link"><u>Request Reactivation</u></a><br><br>';
				} else if($row['status'] == "suspended") {
					$error = '<br><i class="fa fa-exclamation-triangle note" aria-hidden="true" title="Action!"></i> Your account is suspended.<br><br>';

/* Build session */
				} else if ($row['status'] == "active") {
					$_SESSION['active'] = true;
					$_SESSION['owner'] = $row['owner'];
					$_SESSION['realtor'] = $row['realtor'];
					$_SESSION['lease'] = $row['lease'];
					$_SESSION['board'] = $row['board'];
					$_SESSION['concierge'] = $row['concierge'];
					$_SESSION['liaison'] = $row['liaison'];
					$_SESSION['webmaster'] = $row['webmaster'];
					$_SESSION['email'] = $row['email'];
					$_SESSION['first_name'] = $row['first_name'];					
					$_SESSION['last_name'] = $row['last_name'];					
					$_SESSION['unit'] = $row['unit'];
					$_SESSION['unit2'] = $row['unit2'];
					$_SESSION['phone'] = $row['phone'];
					$_SESSION['ghost'] = $row['ghost'];
					$_SESSION['flex1'] = $row['flex1'];
					$_SESSION['flex2'] = $row['flex2'];
					$_SESSION['flex3'] = $row['flex3'];
					$_SESSION['flex4'] = $row['flex4'];
					$_SESSION['flex5'] = $row['flex5'];
					$_SESSION['id'] = $row['id'];
					
					$_SESSION['reseturl'] = $_POST['reseturl'];
					$_SESSION['communityurl'] = $_POST['communityurl'];
					
					if($row['owner']){
					
						$date = date('Y-m-d');
						$loginip = $_SERVER['REMOTE_ADDR'];
						$query = "UPDATE `users` SET logindate='$date', loginip='$loginip', authcode='' WHERE email='".mysqli_real_escape_string($conn, $_POST['email'])."'";
						mysqli_query($conn,$query) or die('Error, updating update date failed');
					
						header("Location: access/index.php?section=owner"); break;
						
					} else if($row['lease']){
						
						$date = date('Y-m-d');
						$loginip = $_SERVER['REMOTE_ADDR'];
						$query = "UPDATE `users` SET logindate='$date', loginip='$loginip', authcode='' WHERE email='".mysqli_real_escape_string($conn, $_POST['email'])."'";
						mysqli_query($conn,$query) or die('Error, updating update date failed');
						
						header("Location: access/index.php?section=lease"); break;
						
					} else if($row['realtor']){
					
						$date = date('Y-m-d');
						$loginip = $_SERVER['REMOTE_ADDR'];
						$query = "UPDATE `users` SET logindate='$date', loginip='$loginip', authcode='' WHERE email='".mysqli_real_escape_string($conn, $_POST['email'])."'";
						mysqli_query($conn,$query) or die('Error, updating update date failed');
					
						header("Location: access/index.php?section=realtor"); break;
						
					}
				}
		}	
	}
	
/* Error for Email Address and Password */

	else {
	$error = '<br><i class="fa fa-exclamation-triangle note" aria-hidden="true" title="Action!"></i> Invalid email address or password.<br><span style="text-decoration: underline;"><a href="splash/connect-help.php" class="iframe-link">Reset your password or get login help here.</a></span>';
	}
	}
}
?>
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">

<head>
	<meta charset="utf-8">
	<!--[if IE]><meta http-equiv="refresh" content="0;url=IE.html" /><![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="CondoSites - http://www.condosites.com" name="author">
	<title><?php include('my-documents/communityname.html'); ?></title>
	<?php include('my-documents/meta-robots.html'); ?>
	<link rel="stylesheet" href="css/foundation.css">
	<link rel="stylesheet" href="css/magnific-popup.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/jquery-ui.min.css">
	<link rel="stylesheet" href="css/jquery-ui.structure.min.css">
	<link rel="stylesheet" href="css/app.css">
	<link rel="stylesheet" href="my-documents/app-custom.css">
	<script src="java/vendor/jquery.js"></script>
	<script src="java/vendor/jquery-ui.min.js"></script>
	<script src="java/vendor/jquery.magnific-popup.min.js"></script>
</head>

<body>

  <header>

<!-- ******************************************** -->
<!-- ALERT BAR -->

<?php include('splash/construction.php'); ?>

<!-- END ALERT BAR -->
<!-- ******************************************** -->


<!-- ******************************************** -->
<!-- USER BAR -->

<!-- User Bar Setup -->
<div id="user-bar">
  <div class="row">

<!-- Property Management Links -->
<?php
	$query  = "SELECT `utility` FROM `utilities` WHERE `category` = 'Manager' LIMIT 1";
	//Old MySQL Query
	//$result = mysqli_query($conn, $query);

    $result = mysqli_query($conn, $query);

    //Old MySQL Fetch
	//while($row = $result->fetch_array(MYSQLI_ASSOC))
    while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
    <div class="small-12 medium-6 large-3 columns">
      <div class="user-bar-box-container">
        <div class="user-bar-box user-bar-box-splash-left">
          <div class="user-bar-box-inline-item">
            <div class="show-for-small-only">
<a href="modules/utilities-select.php?choice=Manager" class="iframe-link"><i class="fa fa-address-card-o" aria-hidden="true"></i>&nbsp;Contact Property Management</a>
            </div>
            <div class="show-for-medium-only">
<a href="modules/utilities-select.php?choice=Manager" class="iframe-link"><i class="fa fa-address-card-o" aria-hidden="true"></i>&nbsp;Contact Property Management</a>
            </div>
            <div class="show-for-large" <?php if (!empty($_SERVER['HTTPS'])) { ?>style="padding-top: 25px;"<?php }; ?>>
<a href="modules/utilities-select.php?choice=Manager" class="iframe-link"><i class="fa fa-address-card-o" aria-hidden="true"></i>&nbsp;Contact Property Management</a>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php
	}
?>

<!-- Login Links -->
<?php
    // OLD MYSQL QUERY
    //$sqlMGR = mysqli_query($conn,"SELECT count(*) FROM `utilities` WHERE `category` = 'Manager'") or die(mysqli_error($conn));
    $sqlMGR = mysqli_query($conn, "SELECT count(*) FROM `utilities` WHERE `category` = 'Manager'");

    // OLD MySQL Result
    //$countMGR = mysql_result($sqlMGR, "0");
    $countMGRARRAY = mysqli_fetch_row($sqlMGR);
    $countMGR = $countMGRARRAY[0];

    ?>
<?php if ($countMGR == '0'){ ?>    <div class="small-12 medium-12 large-12 columns"><?php }; ?>
<?php if ($countMGR != '0'){ ?>    <div class="small-12 medium-6 large-9 columns"><?php }; ?>
      <div class="user-bar-box-container">
        <div class="user-bar-box user-bar-box-splash-right">
          <div class="user-bar-box-inline-item">
            <div class="show-for-small-only">
<a href="splash/connect-login.php" title="SSL Encrypted Login Page"><i class="fa fa-lock" aria-hidden="true"></i></a>
&nbsp;<a href="splash/connect-login.php" title="SSL Encrypted Login Page"><b>Returning User Login</b></a>
&nbsp;|&nbsp; <a href="splash/connect-request.php" class="iframe-link" >Create a Login</a>
            </div>
        <div class="show-for-medium-only">
<a href="splash/connect-login.php" title="SSL Encrypted Login Page"><i class="fa fa-lock" aria-hidden="true"></i></a>
&nbsp;<a href="splash/connect-login.php" title="SSL Encrypted Login Page"><b>Returning User Login</b></a>
&nbsp;|&nbsp; <a href="splash/connect-request.php" class="iframe-link" >Create a Login</a>
            </div>
            <div class="show-for-large" style="padding-top:10px;">
<?php if (empty($_SERVER['HTTPS'])) { ?>
<a href="splash/connect-login.php" title="SSL Encrypted Login Page"><i class="fa fa-lock" aria-hidden="true"></i></a>
&nbsp;<a href="splash/connect-login.php" title="SSL Encrypted Login Page"><b>Returning User Login</b></a>
&nbsp;|&nbsp; <a href="splash/connect-request.php" class="iframe-link" >Create a Login</a>
<?php }; ?>
<?php if (!empty($_SERVER['HTTPS'])) { ?>
	<form method="POST">
              <div class="large-4 columns" style="line-height: 1.5rem;">
                <small><a title="We are committed to security. Your session is encrypted for added protection."><i class="fa fa-lock" aria-hidden="true"></i></a></small>
                <b>Website Login</b><br>
                <a href="splash/connect-request.php" class="iframe-link">Create&nbsp;a&nbsp;login</a> | <a href="splash/connect-help.php" class="iframe-link">Login&nbsp;Help?</a>
              </div>
              <div class="large-4 columns">
                <input name="email" class="form" type="email" id="email" maxlength="100" placeholder="Email Address"><div style="margin-top: -10px;" required><small>Login Email Address</small></div>
              </div>
              <div class="large-3 columns">
                <input name="password" class="form" type="password" id="pass" maxlength="100" placeholder="Password">
                  <div style="margin-top: -40px; margin-right: 12px; float: right;" required><i class="fa fa-eye" id="togglePassword" style="color: #000; margin-left: -30px; cursor: pointer;"></i> </div>
                  <div style="margin-top: 10px;" required><small>Password</small></div>
              </div>
              <div class="large-1 columns" style="margin-left: -50px; padding-top: 5px;">
                <input name="reseturl" type="hidden" value="<?php include('my-documents/communityurl-ssl.html'); ?>/splash/connect-verify.php" readonly>
                <input name="communityurl" type="hidden" value="<?php include('my-documents/communityurl-ssl.html'); ?>" readonly>
                <input name="Submit" value=" Login " class="submit" type="submit" onclick="value='Processing - Login'; style='color:red';" />
              </div>
    </form>
              <div class="large-12 columns" align="right"><big><?php echo $error; ?></big></div>
<?php }; ?>
            </div>
          </div>
        </div>
      </div>
    </div>

<!-- User Bar Setup -->
  </div>
</div>

<!-- END USER BAR -->
<!-- ******************************************** -->

  </header>

<!-- ******************************************** -->
<!-- MAIN CONTENT -->

<div class="background-wrapper-splash">

<?php include('my-documents/home-custom.php'); ?>

</div>

<!-- END MAIN CONTENT -->
<!-- ******************************************** -->

<!-- ******************************************** -->
<!-- LEGAL -->

<?php include('version.php'); ?>

<!-- END LEGAL -->
<!-- ******************************************** -->

</body>

	<script src="java/vendor/what-input.js"></script>
	<script src="java/vendor/foundation.min.js"></script>
	<script src="java/app.js"></script>
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