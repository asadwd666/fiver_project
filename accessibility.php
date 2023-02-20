<?php require_once('my-documents/php7-my-db.php');?>
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <!--[if IE]><meta http-equiv="refresh" content="0;url=IE.html" /><![endif]-->
	<meta charset="UTF-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="CondoSites - http://www.condosites.com" name="author">
	<title>Accessibility | <?php include('my-documents/communityname.html'); ?></title>
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
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

<!-- ******************************************** -->
<!-- MAIN CONTENT -->

<!-- Main Content Setup -->
<div class="container">

<!-- ******************************************** -->
<!-- COMMUNITY PRIDE -->

  <div class="row">
    <div class="small-12 small-centered medium-uncentered medium-12 large-12 columns">
      <h1 class="welcome-area-logo">
        <a href="https://condosites.com"><img src="https://condosites.com/img/condosites.png" alt="CondoSites Logo"></a>
        <a href="index.php"><img src="pics/logo.png" alt="Community Logo"></a>
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
    <div class="small-12 medium-12 large-12 columns">
      <div class="content-splash-main">

        <div class="row">
          <div class="small-12 columns">

<!-- CONTENT -->
<h1><b>Accessibility Notice</b></h1>

<p>CondoSites, the providers of this community website, is committed to providing an accessible website. We have worked hard to create an accessible structure for our clients, but not all of them offer accessible content.  If you have difficulty accessing content on this site, have difficulty viewing a file on the website, or notice any accessibility problems, please contact <?php print($CommunityName); ?> via the contact information below to specify the nature of the accessibility issue and any assistive technology you use. <?php print($CommunityName); ?>, and CondoSites, will strive to provide the content you need in the format you require.</p>
<br>
<!-- PASSWORD CONTACT -->
<?php
	$query  = "SELECT id, company, contact, phone1, email, name FROM utilities WHERE category = 'Password'";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php if ($row['name'] !== '' AND $row['name'] !== 'none.gif'){ ?><img src="download-utilities.php?id=<?php echo "{$row['id']}"; ?>" alt="<?php echo "{$row['company']}"; ?> logo"><br><?php }; ?>
<?php if ($row['company'] !== ''){ ?><b><?php echo "{$row['company']}"; ?></b><br><?php }; ?>
<?php if ($row['contact'] !== ''){ ?></b><?php echo "{$row['contact']}"; ?><br><?php }; ?>
<?php if ($row['phone1'] !== ''){ ?><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row['phone1']); ?>"><?php echo "{$row['phone1']}"; ?></a><br><?php }; ?>
<?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>?subject=Accessibility Help for <?php include('my-documents/communityname.html'); ?>"><?php echo "{$row['email']}"; ?></a><br><?php }; ?>
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
	$query  = "SELECT id, company, contact, phone1, email, name FROM utilities WHERE category = 'Manager'";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php if ($row['name'] !== '' AND $row['name'] !== 'none.gif'){ ?><img src="download-utilities.php?id=<?php echo "{$row['id']}"; ?>" alt="<?php echo "{$row['company']}"; ?> logo"><br><?php }; ?>
<?php if ($row['company'] !== ''){ ?><b><?php echo "{$row['company']}"; ?></b><br><?php }; ?>
<?php if ($row['contact'] !== ''){ ?></b><?php echo "{$row['contact']}"; ?><br><?php }; ?>
<?php if ($row['phone1'] !== ''){ ?><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row['phone1']); ?>"><?php echo "{$row['phone1']}"; ?></a><br><?php }; ?>
<?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>?subject=Accessibility Help for <?php include('my-documents/communityname.html'); ?>"><?php echo "{$row['email']}"; ?></a><br><?php }; ?>
<?php
	}
?>
<?php }; ?>
<!-- END PASSWORD CONTACT -->

<br>
<p><b>Compatibility</b><br>This website may not be readily compatible with older browsers operating systems. Please be sure you are using the newest version of Google Chrome, Apple Safari, Mozilla Firefox, or Microsoft Edge.  CondoSites is no longer compatible with Microsoft Internet Explorer.</p>
<br>
<p><b>Browser and Operating System Accessibility tools</b><br>This website is designed to be compatible with the accessibility tools built into your browser and operating system including High Contrast Modes, Link Focusing, and Zoom Shortcuts such as Command +/- (Mac) Ctrl +/- (Windows).</p>
<br>
<p><b>Third-Party Links and Content</b><br>This website links to third-party content hosted on external websites out of the control of <?php print($CommunityName); ?> and CondoSites. This third-party content may or may not meet accessibility standards.</p>


<!-- END CONTENT -->

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

	<script src="java/vendor/foundation.min.js"></script>
	<script src="java/app.js"></script>
	<script>
		$(document).foundation();
	</script>
	<script type="text/javascript" src="java/google-base.js"></script>
	<script type="text/javascript" src="my-documents/google-code.js"></script>

</html>