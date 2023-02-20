<?php require_once('../my-documents/php7-my-db.php');

if (($_SESSION['owner'] != true) AND ($_SESSION['lease'] != true) AND ($_SESSION['realtor'] != true)){
	header("Location: ../splash/connect-login.php");
	exit();
}

$id = $_SESSION["id"];
$action = $_POST["action"];
if ($action == "save"){
    
    $accountupdate = $_POST['account'];

    $query = "UPDATE `users` SET account='$accountupdate' WHERE `id`='$id' LIMIT 1";
    mysqli_query($conn,$query) or die('Error, update query failed');
    
    header('Location: index.php');

}
?>
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="CondoSites - http://www.condosites.net" name="author">
	<title>PayLease Handoff | <?php include('../my-documents/communityname.html'); ?></title>
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	<link rel="stylesheet" href="../css/foundation.css">
	<link rel="stylesheet" href="../css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/jquery-ui.min.css">
	<link rel="stylesheet" href="../css/jquery-ui.structure.min.css">
	<link rel="stylesheet" href="../css/app.css">
	<link rel="stylesheet" href="../my-documents/app-custom.css">
</head>

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

<!-- Security Message -->
    <div class="small-12 medium-4 large-5 columns">
      <div class="content-splash-sub">
        <div class="row">
          <div class="small-12 columns">
              <img src="https://condosites.com/images/CondoSites.png" style="max-width: 250px; margin-bottom: 25px;">
          </div>
        </div>
        
        <div class="row">
          <div class="small-12 columns">

<?php if (!empty($_SERVER['HTTPS'])) { ?>
        <div class="row">
          <div class="small-2 medium-12 large-2 columns"><i class="fa fa-lock big" aria-hidden="true"></i></div>
          <div class="small-10 medium-12 large-10 end columns">
            <h3>We are committed to your security.</h3>
            <p><small>Your handoff to PayLease is encrypted for added protection.<br>
            <br>Only your name, unit, email address and phone number is sent to PayLease to facilitate the handoff.<br>
            <br>CondoSites, the operator of this website, does <u>not</u> share any other personal information, including your password, with PayLease.</small></p>
          </div>
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
<!-- End Security Message -->

<!-- Login -->
    <div class="small-12 medium-8 large-7 columns">
      <div class="content-splash-main">

        <div class="row">
            <div class="small-12 columns">
                <img src="https://condosites.com/images/PayLease-Logo.png" alt="PayLease" style="max-height: 50px"><br>
                <br>
                <h3>We are ready to log you in...</h3>
            </div>
            <div class="small-12 columns">
                
<!-- PayLease SSO -->

<?php include('../my-documents/paylease-sso.php'); ?>

<!-- PayLease SSO -->
                
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