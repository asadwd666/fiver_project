<?php
require_once('../my-documents/php7-my-db-up.php');

    $email = $_GET['email'];
    $id = $_GET["id"];
    $date = date('Y-m-d');
    $useripaddress = $_SERVER['REMOTE_ADDR'];

    if ($email != ""){

    $query = "UPDATE `users` SET `emailconfirm` = 'V' WHERE email='".mysqli_real_escape_string($conn, $_GET['email'])."'";
    mysqli_query($conn,$query) or die('Error, updating update date failed');
    
	$query = "INSERT INTO log (action, tablename, useripaddress, id) VALUES ('E', 'Verify-Email', '$useripaddress', '$id')";
	mysqli_query($conn,$query) or die('Error, updating log failed');

    $error = "<p>Your email address has been confirmed! Thank you.</p>";
    
    }

?>
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">

<head>
	<meta charset="utf-8">
	<!--[if IE]><meta http-equiv="refresh" content="0;url=IE.html" /><![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="CondoSites - http://www.condosites.com" name="author">
	<title>Unsubscribe / Update Email Preferences | <?php include('../my-documents/communityname.html'); ?></title>
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

<!-- CONFIRMATION -->
    <div class="small-12 medium-6 large-6 columns">
      <div class="content-splash-main">

        <div class="row">
          <div class="small-12 columns"><h3>Email Confirmation</h3><br></div>
        </div>

        <div class="row">
            <div class="small-12 columns text">
                <label for="email" class="left"><?php echo($error); ?><br><br><a href="../index.php" target="_parent">Return to your community website home page.</a></label>
            </div>
        </div>

      </div>
    </div>
 
<!-- SSL -->

    <div class="small-12 medium-6 large-6 columns">
      <div class="content-splash-main">


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
