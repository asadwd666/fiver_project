<?php require_once('../my-documents/php7-my-db.php');?>
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="CondoSites - http://www.condosites.com" name="author">
	<title>Form</title>
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	<script src="forcom.js" type="text/javascript"></script>
	<link rel="stylesheet" href="../css/foundation.css">
	<link rel="stylesheet" href="../css/jquery-ui.min.css">
	<link rel="stylesheet" href="../css/jquery-ui.structure.min.css">
	<link rel="stylesheet" href="../css/datepickercontrol.css">
	<link rel="stylesheet" href="../css/app.css">
	<link rel="stylesheet" href="../my-documents/app-custom.css">
</head>

<body>

<div class="stand-alone-page">
  <div class="popup-header">
<h4>Thank you!</h4>
</div>
  
  <div class="stand-alone-page-content">
    <div class="popup-subheader">
      <div class="row">
        <div class="small-12 columns text-center">
            <br>
            <br>
<!-- TEXT 1 -->
<?php
	$query  = "SELECT theircode FROM 3rd WHERE type = 'eForm Thank You Text'";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php echo "{$row['theircode']}"; ?>
<?php
	}
?>
<!-- END TEXT 1 -->
<br><br><b>If you have a item of immediate concern,</b><br>please contact property management.<br><br>
<?php
	$query  = "SELECT * FROM utilities WHERE category = 'Manager' ORDER BY company";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php if ($row['name'] !== '' AND $row['name'] !== 'none.gif'){ ?><img src="../download-utilities.php?id=<?php echo "{$row['id']}"; ?>" alt="<?php echo "{$row['company']}"; ?>"><br><?php }; ?>

<?php if ($row['company'] !== ''){ ?><b><?php echo "{$row['company']}"; ?></b><br><?php }; ?>
<?php if ($row['contact'] !== ''){ ?><?php echo "{$row['contact']}"; ?><br><?php }; ?>

<?php if ($row['address1'] !== ''){ ?><?php echo "{$row['address1']}"; ?>, <?php }; ?><?php if ($row['address2'] !== ''){ ?><br><?php echo "{$row['address2']}"; ?><br><?php }; ?>

<?php if ($row['phone1'] !== ''){ ?><?php echo "{$row['phone1']}"; ?><br><?php }; ?>
<?php if ($row['phone2'] !== ''){ ?><?php echo "{$row['phone2']}"; ?><br><?php }; ?>
<?php if ($row['phone3'] !== ''){ ?><?php echo "{$row['phone3']}"; ?><br><?php }; ?>
<?php if ($row['phone4'] !== ''){ ?><?php echo "{$row['phone4']}"; ?><br><?php }; ?>

<?php if ($row['web'] !== ''){ ?><a href="<?php echo "{$row['web']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('Utility/<?php echo "{$row['web']}"; ?>'); "><?php echo "{$row['web']}"; ?></a><br><?php }; ?>

<?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>" onclick="javascript:pageTracker._trackPageview('Email/<?php echo "{$row['email']}"; ?>'); "><?php echo "{$row['email']}"; ?></a><br><?php }; ?>

<?php if ($row['comments'] !== ''){ ?><br><?php echo "{$row['comments']}"; ?><?php }; ?>
<?php
	}
?>
<br>
<br>
<br>
<br>
<br>
        </div>
      </div>
    </div>

</div>

	<script src="../java/vendor/jquery.js"></script>
	<script src="../java/vendor/jquery-ui.min.js"></script>
	<script src="../java/vendor/what-input.js"></script>
	<script src="../java/vendor/foundation.min.js"></script>
	<script src="../java/form.js"></script>
	<script src="../java/google-base.js" type="text/javascript"></script>
	<script src="../my-documents/google-code.js" type="text/javascript"></script>

</body>

</html>