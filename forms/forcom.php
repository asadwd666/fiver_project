<?php require_once('../my-documents/php7-my-db.php');

$connName = isset($_GET['conn']) ? $_GET['conn'] : "Default";

if (isset($connectionPool) && isset($connectionPool[$connName])) {
    $dbConn = $connectionPool[$connName]['connection'];
} else {
    $dbConn = $conn;
}

if (!isset($connectionPool) || $connectionPool == null) {
    $connectionPool['default'] = array('priority' => 10, 'connection' =>  $conn, 'master' => false, 'primary' => true);
}

$maName = '';
$fromMaster = false;
foreach ($connectionPool as $name => $connDetails) {
    if ($connDetails['master'] === true) {
        $maName = $name;
    }
}
?>
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

<?php if (($_SESSION['owner'] == true) OR ($_SESSION['lease'] == true) OR ($_SESSION['realtor'] == true)){ ?>

<div class="stand-alone-page">
  <div class="popup-header">
<?php
	$type    = $_GET['choice'];
	$query  = "SELECT title FROM tabs WHERE `int1` = '$type'";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<h4><?php echo "{$row['title']}"; ?></h4>
<?php
	}
?>
</div>

  <div class="stand-alone-page-content">
    <div class="popup-subheader">
      <div class="row">
        <div class="small-12 columns text-center">
<blockquote>
<!-- TEXT 1 -->
<?php
	$type    = $_GET['choice'];
	$query  = "SELECT text1 FROM forms WHERE `int1` = '$type'";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php echo "{$row['text1']}"; ?>
<?php
	}
?>
<!-- END TEXT 1 -->
<br><b>All fields are required!</b><br>
</blockquote>
        </div>
      </div>
    </div>

    <div class="form-wrapper">

<form action="../cgi-bin/formmail.pl" method="post" name="emailform" id="emailform" onsubmit="MM_validateForm('phone');return document.MM_returnValue">
<input name="subject" value="<?php echo "{$CommunityName}"; ?>/CondoSites Mailform - <?php
	$type    = $_GET['choice'];
	$query  = "SELECT title FROM tabs WHERE `int1` = '$type'";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php echo "{$row['title']}"; ?>
<?php
	}
?>" type="hidden">
<input name="recipient" value="<?php
	$type    = $_GET['choice'];
	$query  = "SELECT email FROM forms WHERE `int1` = '$type'";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php echo "{$row['email']}"; ?>
<?php
	}
?>" type="hidden">
<input name="required" value="email" type="hidden">
<input name="print_config" value="realname, email" type="hidden">
<input name="redirect" value="../forms/thanks.php" type="hidden">

<!-- BEGIN FORM CONTENT -->
<input type=hidden name="FORCOM" class="form" id="FORCOM" value="<?php $choice=$_GET['choice']; { ?><?php echo "{$choice}"; ?><?php } ?>">

<!-- STANDARD FIELDS -->

      <div class="row medium-collapse">
        <div class="small-12 medium-5 large-4 columns"><label for="realname" class="middle">Resident Name</label></div>
        <div class="small-12 medium-5 end columns"><input name="realname" type="text" size="25" maxlength="100" class="form" value="<?php echo($_SESSION['first_name']); ?> <?php echo($_SESSION['last_name']); ?>" required><input type=hidden name="LOGGED-IN-AS" class="form" id="LOGGED-IN-AS" value="ID:<?php echo($_SESSION['id']); ?> - <?php echo($_SESSION['last_name']); ?>, <?php echo($_SESSION['first_name']); ?>" required></div>
      </div>

      <div class="row medium-collapse">
        <div class="small-12 medium-5 large-4 columns"><label for="unit" class="middle">Unit</label></div>
        <div class="small-12 medium-5 end columns">
<?php include('../my-documents/units-table.html'); ?>
        </div>
      </div>

      <div class="row medium-collapse">
        <div class="small-12 medium-5 large-4 columns"><label for="email" class="middle">Email</label></div>
        <div class="small-12 medium-5 end columns"><input name="email" type="email" class="form" id="email" size="25" maxlength="100" value="<?php echo($_SESSION['email']); ?>" required></div>
      </div>

      <div class="row medium-collapse">
        <div class="small-12 medium-5 large-4 columns"><label for="phone" class="middle">Phone</label></div>
        <div class="small-12 medium-5 end columns"><input name="phone" type="tel" class="form" id="phone" size="25" maxlength="100" value="<?php echo($_SESSION['phone']); ?>" required></div>
      </div>

      <div class="row medium-collapse">
        <div class="small-12 medium-5 large-4 columns"><label for="OwnersName" class="middle note-anchor">Owner&apos;s Name<br><span class="note-red">(if different from applicant)</span></label></div>
        <div class="small-12 medium-5 end columns"><input name="OwnersName" type="text" id="ownersname" size="25" maxlength="100" class="form" isdatepicker="true"></div>
      </div>

<!-- END STANDARD FIELDS -->

<!-- SPECIFIC FIELDS -->

<?php
	$type    = $_GET['choice'];
	$query  = "SELECT code2 FROM forms WHERE `int1` = '$type'";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php echo "{$row['code2']}"; ?>
<?php
	}
?>

<!-- END SPECIFIC FIELDS -->

    </div>

<!-- TERMS -->

<?php
	$type    = $_GET['choice'];
	$query  = "SELECT terms FROM forms WHERE `int1` = '$type' AND terms != ''";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
    <div class="popup-subheader">
      <div class="row">
        <div class="small-12 columns text-center"><br>Terms:<br><textarea readonly="readonly" name="terms" cols="45" rows="5" class="form" id="terms"><?php echo "{$row['terms']}"; ?></textarea></div>
      </div>
      <div class="row">
        <div class="small-12 columns text-center" style="background-color: #ffcccccc"><b>BY CLICKING &quot;SUBMIT&quot; BELOW YOU AGREE THAT YOU: have read the terms above, and agree to adhere to those terms.</b></div>
      </div>
<?php
	}
?>

<!-- END TERMS -->

    <div class="popup-subheader">
      <div class="row">
        <div class="small-12 columns text-center">
	  <br>
	  <input type="hidden" name="env_report" value="REMOTE_ADDR">
	  <input name="submit" value="Submit" class="submit" type="submit" onclick="value='Processing Request - Resubmit'; style='color:red';" />
        </div>
      </div>

<!-- END FORM CONTENT -->
</form>

    </div>
  </div>

    <div class="popup-subheader">
      <div class="row">
        <div class="small-12 columns text-center">
<blockquote>
<!-- TEXT 2 -->
<?php
	$type    = $_GET['choice'];
	$query  = "SELECT text2 FROM forms WHERE `int1` = '$type'";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php echo "{$row['text2']}"; ?>
<?php
	}
?>
<!-- END TEXT 2 -->
</blockquote>
        </div>
      </div>


</div>

<?php }; ?>

	<script src="../java/vendor/jquery.js"></script>
	<script src="../java/vendor/jquery-ui.min.js"></script>
	<script src="../java/vendor/what-input.js"></script>
	<script src="../java/vendor/foundation.min.js"></script>
	<script src="../java/form.js"></script>
	<script src="../java/google-base.js" type="text/javascript"></script>
	<script src="../my-documents/google-code.js" type="text/javascript"></script>

</body>

</html>