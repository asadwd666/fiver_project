<?php require_once('../my-documents/php7-my-db.php'); $id = $_SESSION["id"]; $action = $_POST["action"]; if ($action == "save"){

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$pass = mysqli_real_escape_string($conn, $_POST['password']);
		
		if($_POST['password'] != ""){

			$hash = password_hash($pass, PASSWORD_BCRYPT);
		
			$query = "UPDATE users SET password='$hash', authcode='' WHERE `id`='$id' LIMIT 1";
			mysqli_query($conn,$query) or die('Error, update query failed');
		
			$useripaddress = $_SERVER['REMOTE_ADDR'];
			$userid = $_SESSION['id'];
			$id = $_POST['id'];
			$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('E', 'Password Edit USER', '$useripaddress', '$userid', '$id')";
			mysqli_query($conn,$query) or die('Error, updating log failed');

			header('Location: user-thanks.php');

			} else {
				$error = "You did not enter a new password.";
				$success = "false";
			}

	}
	
?>
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">

<head>
	<meta charset="utf-8">
	<!--[if lte IE 10]><meta http-equiv="refresh" content="0;url=../IE.html" /><![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="CondoSites - http://www.condosites.com" name="author">
	<title>Login Request | <?php include('../my-documents/communityname.html'); ?></title>
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

      <div class="content-splash-sub">
        <div class="row">
          <div class="small-12 medium-12 large-12 columns">

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

<!-- ******************************************** -->
<!-- PROFILE -->

<!-- Edit Profile -->
  <div class="row">
    <div class="small-12 medium-12 large-12 columns">
      <div class="content-splash-main">

<?php
	$query  = "SELECT `id` FROM users WHERE `id`='$id' LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>

        <div class="row">
          <div class="small-12 columns"><h3>Edit My Password</h3></div>
        </div>

<form name="PWEdit" method="POST" action="">

        <div class="row">
          <div class="small-12 medium-4 large-4 columns"><label for="first_name" class="middle">New Password</label></div>
          <div class="small-12 medium-8 large-8 end columns"><input name="password" type="password" size="30" maxlength="100" class="form" ></div>
        </div>

        <div class="row">
          <div class="small-12 columns text-center">
		<span class="note-red"><big><big><?php echo($error); ?></big></big></span>
		<span class="note-red"><big><big><?php echo($errorEmail); ?></big></big></span><br>
		<input type="hidden" name="action" value="save">
		<input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
		<input name="submit" value="Save New Password" class="submit" type="submit"></div>
	  </div>
        </div>

</form>

<?php
	}
?>

      </div>
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