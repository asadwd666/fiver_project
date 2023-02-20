<?php require_once('../my-documents/php7-my-db.php');
$connName = isset($_GET['conn']) ? $_GET['conn'] : "none";

if (isset($connectionPool) && isset($connectionPool[$connName])) {
    $dbConn = $connectionPool[$connName]['connection'];
} else {
    $dbConn = $conn;
}
?>
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">
<head>
	<meta charset="utf-8">
	<!--[if lte IE 10]><meta http-equiv="refresh" content="0;url=../IE.html" /><![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="CondoSites - http://www.condosites.com" name="author">
	<title><?php include('../my-documents/communityname.html'); ?></title>
	<?php include('../my-documents/meta-robots.html'); ?>
	<link rel="stylesheet" href="../css/foundation.css">
	<link rel="stylesheet" href="../css/magnific-popup.css">
	<link rel="stylesheet" href="../css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/jquery-ui.min.css">
	<link rel="stylesheet" href="../css/jquery-ui.structure.min.css">
	<link rel="stylesheet" href="../css/app.css">
    <link rel="stylesheet" href="../my-documents/app-custom.css">
    <script src="../java/table.js" type="text/javascript"></script>
	<script src="../java/vendor/jquery.js"></script>
	<script src="../java/vendor/jquery-ui.min.js"></script>
	<script src="../java/vendor/jquery.magnific-popup.min.js"></script>
</head>

<body>

<div id="all-documents-folder" class="stand-alone-page">
  <div class="popup-header">
    <h4>
<?php
	$query  = "SELECT title FROM tabs WHERE `int1` = '230'";
	$result = mysqli_query($dbConn, $query);
    $row = $result->fetch_array(MYSQLI_ASSOC);

    if (!empty($row) && !empty($row['title']))
	{
        echo "{$row['title']}";
	}
?>
    </h4>
    <input type="button" value="Print Directory" onClick="window.open('pets-print.php');" class="filter-note" style="margin-top: 25px; ">
  </div>

<!-- Mobile Filter Notice -->
  <div class="stand-alone-page-content">
    <div class="rotate-note">Rotate your device to filter listings by species.</div>
  </div>

</div>

<!-- CONTENT -->
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">

<?php if (($_SESSION['owner'] == true) OR ($_SESSION['lease'] == true) OR ($_SESSION['realtor'] == true)){ ?>
<?php if (($_SESSION['ghost'] != 'Y') OR ($_SESSION['webmaster'] == true)){ ?>
  <thead>
<!-- SUBMIT CONTENT -->
    <tr style="background-color: #FAFEB8;">
      <th colspan="3">
<a href="../forms/submit-Pets.php">Would you like to <u>register your pet or service/support animal</u>?</a><br><small>Be sure to review your association&apos;s rules and guidelines!</small>
      </th>
    </tr>
<!-- END SUBMIT CONTENT -->
    <tr>
      <th align="left" class="table-sortable:alphanumeric" style="cursor:pointer;">&nbsp;&nbsp;&nbsp; Information</th>
      <th align="left" class="table-sortable:alphanumeric table-filterable" width="100"><small>Species</small></th>
    </tr>
  </thead>
<?php }; ?>
<?php }; ?>

<?php if (($_SESSION['owner'] != true) AND ($_SESSION['lease'] != true) AND ($_SESSION['realtor'] != true)){ ?>
  <tfoot>
    <tr style="background-color: #FAFEB8;">
      <th colspan="100">
<br>
<br>
<br>
<br>
<big>Sorry, you need to be logged in to view this content.</big><br>
<br>
<br>
<br>
<br>
      </th>
    </tr>
  </tfoot>
<?php }; ?>

<?php if (($_SESSION['ghost'] == 'Y') AND ($_SESSION['webmaster'] != true)){ ?>
  <tfoot>
    <tr style="background-color: #FAFEB8;">
      <th colspan="100">
<br>
<br>
<br>
<br>
<big>Sorry, this page is not available to guests.</big><br>
<br>
<br>
<br>
<br>
      </th>
    </tr>
  </tfoot>
<?php }; ?>
<?php
	$sessionowner = $_SESSION['owner'];
	$sessionlease = $_SESSION['lease'];
	$sessionrealtor = $_SESSION['realtor'];
	$sessionghost = $_SESSION['ghost'];
	$query  = "SELECT owner, lease FROM `tabs` WHERE `int1`='230'";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php if (((($row['owner'] == 'Y' && $sessionowner == '1') OR ($row['lease'] == 'Y' && $sessionlease == '1')) AND ($_SESSION['ghost'] != 'Y')) OR ($_SESSION['webmaster'] == true)){ ?>

  <tbody>

<!-- DATABASE RESULTS -->
<?php
	$query  = "SELECT * FROM pets WHERE approved = 'Y' ORDER by petname";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
    <tr>
      <td>
	<?php if ($row['name'] !== 'none.gif'){ ?><a href="../download-pets.php?id=<?php echo "{$row['id']}"; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('PETPHOTO/<?php echo "{$row['id']}"; ?>'); "><div class="module-image"><img src="../download-pets.php?id=<?php echo "{$row['id']}"; ?>" height="125" border="0" alt=""></div></a><?php }; ?>

	<b><big>&quot;<?php echo "{$row['petname']}"; ?>&quot;</big></b><br>
	<?php if ($row['userid'] == '0'){ ?><b><?php echo "{$row['owner']}"; ?></b><?php }; ?>
<?php if ($row['lost'] !== 'Yes'){ ?>
<?php
	$type    = $row['userid'];
	$query1  = "SELECT first_name, last_name, unit, unit2 FROM users WHERE id = '$type'";
	$result1 = mysqli_query($dbConn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?>
	<blockquote><b><?php echo "{$row1['first_name']}"; ?> <?php echo "{$row1['last_name']}"; ?></b><br>Unit: <?php echo "{$row1['unit']}"; ?><?php if ($row1['unit2'] !== 'X'){ ?> <?php echo "{$row1['unit2']}"; ?><?php }; ?></blockquote>
<?php
	}
?>
<?php }; ?>


<?php if ($row['lost'] !== 'No'){ ?>
<?php
	$type    = $row['userid'];
	$query1  = "SELECT first_name, last_name, unit, unit2, email, phone FROM users WHERE id = '$type'";
	$result1 = mysqli_query($dbConn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?>
	<span class="note-red"><big><big>I&apos;m Lost! If found, please contact:</big></big></span><br>
	<blockquote><b><?php echo "{$row1['first_name']}"; ?> <?php echo "{$row1['last_name']}"; ?></b><br>Unit: <?php echo "{$row1['unit']}"; ?><?php if ($row1['unit2'] !== 'X'){ ?> <?php echo "{$row1['unit2']}"; ?><?php }; ?><br><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row1['phone']); ?>"><?php echo "{$row1['phone']}"; ?></a><br><a href="mailto:<?php echo "{$row1['email']}"; ?>"><?php echo "{$row1['email']}"; ?></a></blockquote>
<?php
	}
?>
<?php }; ?>
	<?php if ($row['comments'] !== ''){ ?><?php if ($row['lost'] == 'No'){ ?><?php }; ?>Comments: <?php echo "{$row['comments']}"; ?><br><?php }; ?>

<?php if ($row['userid'] == $_SESSION['id']){ ?>
	<form name="PetEdit" method="POST" action="../forms/submit-Pets-lost.php">
	  <input type="hidden" name="action" value="edit">
	  <input type="hidden" name="id" value="<?php echo "{$row['id']}"; ?>">
	  <input name="submit" value="Report animal as lost or found" class="submit" type="submit">
	</form>
	<br>
<?php }; ?>

      </td>
      <td align="center" width="25%"><?php echo "{$row['species']}"; ?></td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->

  </tbody>

<?php }; ?>
<?php
	}
?>

</table>
<!-- CONTENT -->

</body>

	<script src="../java/vendor/what-input.js"></script>
	<script src="../java/vendor/foundation.min.js"></script>
	<script type="text/javascript" src="../java/google-base.js"></script>
	<script type="text/javascript" src="../my-documents/google-code.js"></script>

</html>