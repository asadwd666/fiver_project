<?php require_once('../my-documents/php7-my-db.php');?>

<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="CondoSites - http://www.condosites.com" name="author">
	<title>Disabled Login Help | <?php include('../my-documents/communityname.html'); ?></title>
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
    <div class="small-12 medium-6 large-7 columns">
      <div class="content-splash-main">

        <div class="row">
          <div class="small-12 columns">

You will need to contact the individual below help you further.<br>
<br>
<b>IMPORTANT:</b> Be sure to indicate that you have a <b><?php print "{$_GET['choice']}"; ?></b> account!<br>
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

<br>
<br>
<a href="../index.php" target="_parent">Return Home</a>
<br>
<br>
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