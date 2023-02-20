<?php
require_once('../my-documents/php7-my-db.php');

    $email = $_GET['email'];
    $authcode = $_GET['authcode'];
    $id = $_POST["id"];
    $action = $_POST["action"];

    if ($action == "save"){

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$pass = mysqli_real_escape_string($conn, $_POST['password']);
		
		if($_POST['password'] != ""){

			$hash = password_hash($pass, PASSWORD_BCRYPT);
		
			$query = "UPDATE users SET password='$hash', authcode='', emailconfirm='V' WHERE `email`='$email' AND `authcode` = $authcode LIMIT 1";
			mysqli_query($conn,$query) or die('Error, update query failed');
		
			$useripaddress = $_SERVER['REMOTE_ADDR'];
			$userid = $_SESSION['id'];
			$id = $_POST['id'];
			$query = "INSERT INTO log (action, tablename, useripaddress, id) VALUES ('E', 'Passwords-USER', '$useripaddress', '$authcode')";
			mysqli_query($conn,$query) or die('Error, updating log failed');

			header('Location: ../splash/connect-reset-login.php');

			} else {
				$error = "<br><br>You did not enter a new password.";
				$success = "false";
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
	<title>Password Reset | <?php include('../my-documents/communityname.html'); ?></title>
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
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

<!-- Login -->

    <div class="small-12 medium-6 large-6 columns">
      <div class="content-splash-main">

        <div class="row">
          <div class="small-12 columns"><h3>Password Reset</h3><br></div>
        </div>

<?php if ($email == "" && $authcode == "") { ?>
<i>You need an email invitation in order to reset your password.</i>
<?php }; ?>

<?php if ($email != "" && $authcode != "") { ?>
<form name="PWEdit" method="POST" action="">

        <div class="row">
          <div class="small-3 medium-3 large-6 columns"><label for="email" class="middle">Email</label></div>
          <div class="small-9 medium-9 large-6 end columns"><?php echo($email); ?></div>
        </div>

        <div class="row">
          <div class="small-6 medium-6 large-6 columns"><label for="password" class="middle">Enter your new password</label></div>
          <div class="small-6 medium-6 large-6 end columns"><input name="password" type="password" size="30" maxlength="100" class="form" ></div>
        </div>

        <div class="row">
          <div class="small-12 columns text">
              <span class="note-red">Click the Save New Password button once!</span><br>
	    <input type="hidden" name="action" value="save">
	    <input name="submit" value="Save New Password" class="submit" type="submit" onclick="value='Processing Request - Resubmit'; style='color:red';" />
	    <span class="note-red"><big><big><?php echo($error); ?></big></big></span>
	    <br><br><span class="note-black">Authorization code: <?php echo($authcode); ?></span>
	    <br>
	    <a href="../index.php" target="_parent">Return Home</a>
	  </div>
        </div>

</form>
<?php }; ?>

      </div>
    </div>

<!-- Message -->
    <div class="small-12 medium-6 large-6 columns">
      <div class="content-splash-main">

        <div class="row">
          <div class="small-12 columns">

If you are having trouble with your profile, have questions, or need further assistance, please contact:<br>
<br>
<!-- PASSWORD CONTACT -->
<?php
	$query  = "SELECT id, company, contact, phone1, email FROM utilities WHERE category = 'Password'";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php if ($row['name'] !== 'none.gif'){ ?><img src="../download-utilities.php?id=<?php echo "{$row['id']}"; ?>" alt="<?php echo "{$row['company']}"; ?>"><br><?php }; ?>
<?php if ($row['company'] !== ''){ ?><b><?php echo "{$row['company']}"; ?></b><br><?php }; ?>
<?php if ($row['contact'] !== ''){ ?></b><?php echo "{$row['contact']}"; ?><br><?php }; ?>
<?php if ($row['phone1'] !== ''){ ?><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row['phone1']); ?>"><?php echo "{$row['phone1']}"; ?></a><br><?php }; ?>
<?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>"><?php echo "{$row['email']}"; ?></a><br><?php }; ?>
<?php
	}
?>
<!-- END PASSWORD CONTACT -->
<!-- PASSWORD CONTACT -->
<?php $sqlPWH = mysqli_query($conn,"SELECT count(*) FROM utilities WHERE category = 'Password'") or die(mysqli_error($conn));
//$countPWH = mysql_result($sqlPWH, "0");
$row = mysqli_fetch_row($sqlPWH);
$countPWH = $row[0];
?>
<?php if ($countPWH == '0'){ ?>
<?php
	$query  = "SELECT id, company, contact, phone1, email FROM utilities WHERE category = 'Manager'";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php if ($row['name'] !== 'none.gif'){ ?><img src="../download-utilities.php?id=<?php echo "{$row['id']}"; ?>" alt="<?php echo "{$row['company']}"; ?>"><br><?php }; ?>
<?php if ($row['company'] !== ''){ ?><b><?php echo "{$row['company']}"; ?></b><br><?php }; ?>
<?php if ($row['contact'] !== ''){ ?></b><?php echo "{$row['contact']}"; ?><br><?php }; ?>
<?php if ($row['phone1'] !== ''){ ?><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row['phone1']); ?>"><?php echo "{$row['phone1']}"; ?></a><br><?php }; ?>
<?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>"><?php echo "{$row['email']}"; ?></a><br><?php }; ?>
<?php
	}
?>
<?php }; ?>
<!-- END PASSWORD CONTACT -->

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

</body>

	<script src="../java/vendor/foundation.min.js"></script>
	<script src="../java/app.js"></script>
	<script>
		$(document).foundation();
	</script>
	<script type="text/javascript" src="../java/google-base.js"></script>
	<script type="text/javascript" src="../my-documents/google-code.js"></script>

</html>