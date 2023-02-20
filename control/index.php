<?php 
require_once('../my-documents/php7-my-db.php');
$error = "";

/* Check for Email Address and Password */

if($_POST){
	if(empty($_POST['email']) || empty($_POST['password'])) {
		$error = '<br>Please enter your email address and password.<br><br>';
	} else {

/* Query database for email address */

        $sqlEMAIL = mysqli_query($conn,"SELECT count(*) FROM `users` WHERE `email`='".mysqli_real_escape_string($conn, $_POST['email'])."'") or die(mysqli_error($conn));
        //$countEMAIL = mysql_result($sqlEMAIL, "0");
        $row = mysqli_fetch_row($sqlEMAIL);
        $countEMAIL = $row[0];
        if ($countEMAIL == '0'){ $error = '<br>Invalid email address or password.<br>'; };

/* Query database for hashed password */

		$queryHASH = "SELECT `password`, `email` FROM users WHERE email='".mysqli_real_escape_string($conn, $_POST['email'])."'";
		$resultHASH = mysqli_query($conn,$queryHASH) or die('There was an error, contact CondoSites and report error: Password Head, line 9');
		while($rowHASH = $resultHASH->fetch_array(MYSQLI_ASSOC))

/* Verify hashed password with typed password */

		if (($_POST['email'] = $rowHASH['email']) AND (password_verify($_POST['password'], $rowHASH['password']))) {

/* Grab current date for Access Through Date comparison */
		$currentdate = date("Y-m-d");
		
/* Query user content, verify permissions, and access */
		$query = "SELECT `status`, `accessdate`, `owner`, `realtor`, `lease`, `board`, `concierge`, `liaison`, `webmaster`, `email`, `password`, `first_name`, `last_name`, `unit`, `unit2`, `phone`, `ghost`, `id`, `flex1`, `flex2`, `flex3`, `flex4`, `flex5` FROM users WHERE email='".mysqli_real_escape_string($conn, $_POST['email'])."'";
		$result = mysqli_query($conn,$query) or die('Error, select query failed');
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
		
/* Check account status */
				if($row['status'] == "new") {
					$error = '<br>Your account has not been approved yet.<br><br>';
				} else if($row['status'] == "disabled") {
					$error = '<br>Your account is disabled.<br><a href="../splash/connect-disabled.php?choice=disabled"><u>Request Reactivation</u></a><br><br>';
				} else if($row['accessdate'] >= '0000-00-01' && $row['accessdate'] <= $currentdate) {
					$error = '<br>You have reached the end of your lease/access through date, and your account was suspended.<br><a href="../splash/connect-disabled.php?choice=suspended"><u>Request Reactivation</u></a><br><br>';
				} else if($row['status'] == "suspended") {
					$error = '<br>Your account is suspended.<br><br>';

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
					
					if($row['webmaster']){
					
						$date = date('Y-m-d');
						$loginip = $_SERVER['REMOTE_ADDR'];
						$query = "UPDATE `users` SET logindate='$date', loginip='$loginip', authcode='' WHERE email='".mysqli_real_escape_string($conn, $_POST['email'])."'";
						mysqli_query($conn,$query) or die('Error, updating update date failed');
					
						header("Location: ../control/index-control.php?access=webmaster"); break;
						
					} else if($row['liaison']){
						
						$date = date('Y-m-d');
						$loginip = $_SERVER['REMOTE_ADDR'];
						$query = "UPDATE `users` SET logindate='$date', loginip='$loginip', authcode='' WHERE email='".mysqli_real_escape_string($conn, $_POST['email'])."'";
						mysqli_query($conn,$query) or die('Error, updating update date failed');
						
						header("Location: ../control/index-control.php?access=liaison"); break;
						
					} else if($row['concierge']){
					
						$date = date('Y-m-d');
						$loginip = $_SERVER['REMOTE_ADDR'];
						$query = "UPDATE `users` SET logindate='$date', loginip='$loginip', authcode='' WHERE email='".mysqli_real_escape_string($conn, $_POST['email'])."'";
						mysqli_query($conn,$query) or die('Error, updating update date failed');
					
						header("Location: ../control/index-control.php?access=concierge"); break;
						
					} else if($row['board']){
						
						$date = date('Y-m-d');
						$loginip = $_SERVER['REMOTE_ADDR'];
						$query = "UPDATE `users` SET logindate='$date', loginip='$loginip', authcode='' WHERE email='".mysqli_real_escape_string($conn, $_POST['email'])."'";
						mysqli_query($conn,$query) or die('Error, updating update date failed');
						
						header("Location: ../control/index-control.php?access=board"); break;
						
					}
				}
		}	
	}
	
/* Error for Email Address and Password */

	else {
	$error = '<br>Invalid email address or password.<br><span style="text-decoration: underline;"><a href="../splash/connect-help.php" class="iframe-link">Reset your password or get login help here.</a></span><br>';
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
	<title>Login | <?php include('../my-documents/communityname.html'); ?></title>
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	<link rel="stylesheet" href="../css/foundation.css">
	<link rel="stylesheet" href="../css/magnific-popup.css">
	<link rel="stylesheet" href="../css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/jquery-ui.min.css">
	<link rel="stylesheet" href="../css/jquery-ui.structure.min.css">
	<link rel="stylesheet" href="../css/app.css">
	<link rel="stylesheet" href="style-cp.css">
	<script src="../java/vendor/jquery.js"></script>
	<script src="../java/vendor/jquery-ui.min.js"></script>
	<script src="../java/vendor/jquery.magnific-popup.min.js"></script>
</head>

<?php if (empty($_SERVER['HTTPS'])) {
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}; ?>

<body style="background-image: url('https://condosites.net/img/cpbackground.png'); background-repeat: no-repeat; position: relative; background-position: left 0px;">

  <header>

<!-- ******************************************** -->
<!-- ALERT BAR -->

<?php include('../splash/construction.php'); ?>

<!-- END ALERT BAR -->
<!-- ******************************************** -->

  </header>

<!-- ******************************************** -->
<!-- MAIN CONTENT -->

<!-- Main Content Setup -->
<div class="container">

<!-- ******************************************** -->
<!-- COMMUNITY PRIDE -->

  <div class="row">
    <div class="small-12 small-centered medium-uncentered medium-6 large-12 columns">
      <h1 class="welcome-area-logo">
        <div style="max-width: 300px;">
		    <a href="http://condosites.net"><img src="https://condosites.net/img/condosites.png" alt="CondoSites Logo"></a>
		</div>
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
    <div class="small-12 medium-6 large-4 columns">
      <div class="content-splash-main">

        <div class="row">
          <div class="small-12 columns"><h3>Control Panel Login</h3><br></div>
        </div>

	<form method="POST">

        <div class="row">
          <div class="small-3 medium-3 large-3 columns"><label for="email" class="middle">Email</label></div>
          <div class="small-9 medium-9 large-9 end columns"><input name="email" class="form" type="email" id="email" maxlength="100"></div>
        </div>

        <div class="row">
          <div class="small-3 medium-3 large-3 columns"><label for="password" class="middle">Password</label></div>
          <div class="small-9 medium-9 large-9 end columns"><input name="password" class="form" type="password" id="pass" maxlength="100">
              <div style="margin-top: -39px; margin-right: 12px;" required>
                  <i class="fa fa-eye" id="togglePassword" style="color: #000; cursor: pointer; float: right;position: relative; z-index: 1"></i>
              </div>
          </div>
        </div>

        <div class="row">
            <div class="small-12 columns text-center">
                <input name="reseturl" type="hidden" value="<?php include('../my-documents/communityurl-ssl.html'); ?>/splash/connect-verify.php" readonly>
                <input name="communityurl" type="hidden" value="<?php include('../my-documents/communityurl-ssl.html'); ?>" readonly>
	            <input name="Submit" value="Login" class="submit" type="submit">
	            <p class="note-red"><big><?php echo $error; ?></big></p>
	        </div>
        </div>

	</form>

      </div>
    </div>

<!-- Message -->
    <div class="small-12 medium-6 large-8 columns">
      <div class="content-splash-main">

        <div class="row">
          <div class="small-12 columns">
<a href="../index.php"><img src="../pics/logo-small.png"></a><br>
<br>
If you need to create your login, need login help, or you&apos;re not a board member, building staff member, or website administrator, <b><a href="../index.php">return to the home page</a></b>.<br>

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

<!-- ******************************************** -->
<!-- LEGAL -->

<?php include('../version.php'); ?>

<!-- END LEGAL -->
<!-- ******************************************** -->


</body>

	<script src="../java/vendor/foundation.min.js"></script>
	<script src="../java/app.js"></script>
	<script>
		$(document).foundation();
	</script>
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