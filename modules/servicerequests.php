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
	<script type="text/javascript">
	<!--
	  function showMe (it, box) {
		var vis = (box.checked) ? "block" : "none";
		document.getElementById(it).style.display = vis;
	  }
	  //-->
	</script>
</head>

<body>

<div id="all-documents-folder" class="stand-alone-page">
  <div class="popup-header">
    <h4>
My Service Requests
    </h4>
  </div>

<!-- Mobile Filter Notice -->
  <div class="stand-alone-page-content">
    <div class="rotate-note">Rotate your device for additional information.</div>
  </div>

</div>

<!-- CONTENT -->
<!-- OPEN SERVICE REQUESTS -->
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr>
      <th align="center" colspan="2">Open Service Requests</th>
    </tr>
    <tr>
      <th align="left" class="table-sortable:alphanumeric"><b>&nbsp;&nbsp;&nbsp; Service Request and Comments</b></th>
      <th align="left" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; Status</th>
    </tr>
  </thead>
  <tbody>

<!-- DATABASE RESULTS -->
<?php
	$type   = $_SESSION['id'];
	$query  = "SELECT * FROM `service` WHERE `userid` = '$type' AND `status` != 'C' ORDER BY `int1`";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
    <tr>
      <td>
		    <i class="fa fa-comment" aria-hidden="true"></i> <b><?php echo "{$row['location']}"; ?></b>
		    <br><?php echo "{$row['description']}"; ?>

		<?php
			$userid    = $row['userid'];
			$queryUSR  = "SELECT id, unit, unit2, last_name, first_name FROM users WHERE id = '$userid'";
			$resultUSR = mysqli_query($dbConn,$queryUSR);

			while($rowUSR = $resultUSR->fetch_array(MYSQLI_ASSOC))
			{
		?>
		    <blockquote>
		        <small><b><?php echo "{$rowUSR['last_name']}"; ?>, <?php echo "{$rowUSR['first_name']}"; ?></a></b></small>
		        <small><?php echo "{$rowUSR['unit']}"; ?><?php if ($rowUSR['unit2'] !== 'X'){ ?><?php echo "{$rowUSR['unit2']}"; ?><?php }; ?></small><br>
		        <small><b>Open</b> <?php echo "{$row['created_date']}"; ?></small>
						<?php if ($row['pte'] == 'N' AND $row['location'] == 'Unit'){ ?><div style="color: red;"><small><i class="fa fa-key" aria-hidden="true" style="color: red;"></i> Permission to enter <u>NOT</u> granted!</small></div><?php }; ?>
						<?php if ($row['pte'] != 'N' AND $row['location'] == 'Unit'){ ?><div style="color: green"><small><i class="fa fa-key" aria-hidden="true" style="color: green;"></i> Permission to enter is granted!</small></div><?php }; ?>
						<?php if ($row['privacy'] != 'Y'){ ?><div><small><i class="fa fa-user-times" aria-hidden="true" style="color: red;" title="You are NOT sharing service request with other users in your unit."></i> You are NOT sharing service request with other users in your unit.</small></div><?php }; ?>
						<?php if ($row['privacy'] == 'Y'){ ?><div><small><i class="fa fa-users" aria-hidden="true" style="color: green;" title="You are sharing service request with other users in your unit."></i> You are sharing service request with other users in your unit.</small></div><?php }; ?>
		    </blockquote>
		<?php
			}
		?>
		
<?php $id = $row['int1']; $sqlCMT = mysqli_query($dbConn,"SELECT count(*) FROM `comments` WHERE `module` = 'service' AND `id` = '$id'") or die(mysqli_error($dbConn));
$row = mysqli_fetch_row($sqlCMT);
$countCMT = $row[0];
?>
<?php if ($countCMT == '0'){ ?><div><b>Your Service Request has not yet been commented on.</b></div><?php }; ?>
<?php if ($countCMT >= '1'){ ?><div><input type="checkbox" name="<?php echo "{$id}"; ?>" onclick="showMe('<?php echo "{$id}"; ?>', this)" />&nbsp;<b>Show&nbsp;Comments&nbsp;&nbsp;</b></div><?php }; ?>

<div id="<?php echo "{$id}"; ?>" style="display:none">
		<?php
			$queryCMT  = "SELECT * FROM `comments` WHERE `module` = 'service' AND `id` = '$id' ORDER BY `created_date`";
			$resultCMT = mysqli_query($dbConn,$queryCMT);

			while($rowCMT = $resultCMT->fetch_array(MYSQLI_ASSOC))
			{
		?>

		    <i class="fa fa-comment-o" aria-hidden="true"></i> <?php echo "{$rowCMT['comment']}"; ?>
		<?php
			$userid    = $rowCMT['userid'];
			$queryUSR  = "SELECT id, unit, unit2, last_name, first_name FROM users WHERE id = '$userid'";
			$resultUSR = mysqli_query($dbConn,$queryUSR);

			while($rowUSR = $resultUSR->fetch_array(MYSQLI_ASSOC))
			{
		?>
		    <blockquote>
		        <small><b><?php echo "{$rowUSR['last_name']}"; ?>, <?php echo "{$rowUSR['first_name']}"; ?></a></b></small>
		        <small><?php echo "{$rowUSR['unit']}"; ?><?php if ($rowUSR['unit2'] !== 'X'){ ?><?php echo "{$rowUSR['unit2']}"; ?><?php }; ?></small><br>
		        <small>
		            <b>
		            <?php if ($rowCMT['status'] == 'O'){ ?>Open<?php }; ?>
		            <?php if ($rowCMT['status'] == 'I'){ ?>In Progress<?php }; ?>
		            <?php if ($rowCMT['status'] == 'B'){ ?>Awaiting Board<?php }; ?>
		            <?php if ($rowCMT['status'] == '3'){ ?>Awaiting 3rd Party<?php }; ?>
		            <?php if ($rowCMT['status'] == 'H'){ ?>On Hold<?php }; ?>
		            <?php if ($rowCMT['status'] == 'C'){ ?>Closed<?php }; ?>
		            </b>
		            <?php echo "{$rowCMT['created_date']}"; ?>
		        </small>
		    </blockquote>
		<?php
			}
		?>

		<?php
			}
		?>

</div>
<div style="float:right">
    <form name="AddComment" method="POST" action="../forms/submit-servicerequest-comment.php">
        <input type="hidden" name="id" value="<?php echo "{$id}"; ?>">
        <input type="hidden" name="module" value="service">
        <input name="submit" value="Comment/Reply to This Service Request" class="submit" type="submit">
    </form>
</div>

      </td>
      <td valign="top">
				<b>
				<?php if ($row['status'] == 'O'){ ?>Open<?php }; ?>
				<?php if ($row['status'] == 'I'){ ?>In Progress<?php }; ?>
				<?php if ($row['status'] == 'B'){ ?>Awaiting Board<?php }; ?>
				<?php if ($row['status'] == '3'){ ?>Awaiting 3rd Party<?php }; ?>
				<?php if ($row['status'] == 'H'){ ?>On Hold<?php }; ?>
				<?php if ($row['status'] == 'C'){ ?>Closed<?php }; ?>
				</b>
				<br><?php echo "{$row['created_date']}"; ?>
      </td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->

<!-- OTHER USERS IN UNIT -->

<?php $unit = $_SESSION['unit']; $unit2 = $_SESSION['unit2']; $queryUNIT = "SELECT `id` FROM `users` WHERE `unit` = '$unit' AND `unit2` = '$unit2'"; $resultUNIT = mysqli_query($dbConn,$queryUNIT); while($rowUNIT = $resultUNIT->fetch_array(MYSQLI_ASSOC)) { ?>

<?php
	$unit   = $rowUNIT['id'];
	$type   = $_SESSION['id'];
	$query  = "SELECT * FROM `service` WHERE `userid` = '$unit' AND `userid` != '$type' AND `status` != 'C' AND `privacy` = 'Y' ORDER BY `int1`";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
    <tr>
      <td>
		    <i class="fa fa-comment" aria-hidden="true"></i> <b><?php echo "{$row['location']}"; ?></b>
		    <br><?php echo "{$row['description']}"; ?>

		<?php
			$userid    = $row['userid'];
			$queryUSR  = "SELECT id, unit, unit2, last_name, first_name FROM users WHERE id = '$userid'";
			$resultUSR = mysqli_query($dbConn,$queryUSR);

			while($rowUSR = $resultUSR->fetch_array(MYSQLI_ASSOC))
			{
		?>
		    <blockquote>
		        <small><b><?php echo "{$rowUSR['last_name']}"; ?>, <?php echo "{$rowUSR['first_name']}"; ?></a></b></small>
		        <small><?php echo "{$rowUSR['unit']}"; ?><?php if ($rowUSR['unit2'] !== 'X'){ ?><?php echo "{$rowUSR['unit2']}"; ?><?php }; ?></small><br>
		        <small><b>Open</b> <?php echo "{$row['created_date']}"; ?></small>
						<?php if ($row['pte'] == 'N' AND $row['location'] == 'Unit'){ ?><div style="color: red;"><small><i class="fa fa-key" aria-hidden="true" style="color: red;"></i> Permission to enter <u>NOT</u> granted!</small></div><?php }; ?>
						<?php if ($row['pte'] != 'N' AND $row['location'] == 'Unit'){ ?><div style="color: green"><small><i class="fa fa-key" aria-hidden="true" style="color: green;"></i> Permission to enter is granted!</small></div><?php }; ?>
						<?php if ($row['privacy'] != 'Y'){ ?><div><small><i class="fa fa-user-times" aria-hidden="true" style="color: red;" title="You are NOT sharing service request with other users in your unit."></i> You are NOT sharing service request with other users in your unit.</small></div><?php }; ?>
						<?php if ($row['privacy'] == 'Y'){ ?><div><small><i class="fa fa-users" aria-hidden="true" style="color: green;" title="You are sharing service request with other users in your unit."></i> You are sharing service request with other users in your unit.</small></div><?php }; ?>
		    </blockquote>
		<?php
			}
		?>
		
<?php $id = $row['int1']; $sqlCMT = mysqli_query($dbConn,"SELECT count(*) FROM `comments` WHERE `module` = 'service' AND `id` = '$id'") or die(mysqli_error($dbConn));
$row = mysqli_fetch_row($sqlCMT);
$countCMT = $row[0];
?>
<?php if ($countCMT == '0'){ ?><div><b>Your Service Request has not yet been commented on.</b></div><?php }; ?>
<?php if ($countCMT >= '1'){ ?><div><input type="checkbox" name="<?php echo "{$id}"; ?>" onclick="showMe('<?php echo "{$id}"; ?>', this)" />&nbsp;<b>Show&nbsp;Comments&nbsp;&nbsp;</b></div><?php }; ?>

<div id="<?php echo "{$id}"; ?>" style="display:none">
		<?php
			$queryCMT  = "SELECT * FROM `comments` WHERE `module` = 'service' AND `id` = '$id' ORDER BY `created_date`";
			$resultCMT = mysqli_query($dbConn,$queryCMT);

			while($rowCMT = $resultCMT->fetch_array(MYSQLI_ASSOC))
			{
		?>

		    <i class="fa fa-comment-o" aria-hidden="true"></i> <?php echo "{$rowCMT['comment']}"; ?>
		<?php
			$userid    = $rowCMT['userid'];
			$queryUSR  = "SELECT id, unit, unit2, last_name, first_name FROM users WHERE id = '$userid'";
			$resultUSR = mysqli_query($dbConn,$queryUSR);

			while($rowUSR = $resultUSR->fetch_array(MYSQLI_ASSOC))
			{
		?>
		    <blockquote>
		        <small><b><?php echo "{$rowUSR['last_name']}"; ?>, <?php echo "{$rowUSR['first_name']}"; ?></a></b></small>
		        <small><?php echo "{$rowUSR['unit']}"; ?><?php if ($rowUSR['unit2'] !== 'X'){ ?><?php echo "{$rowUSR['unit2']}"; ?><?php }; ?></small><br>
		        <small>
		            <b>
		            <?php if ($rowCMT['status'] == 'O'){ ?>Open<?php }; ?>
		            <?php if ($rowCMT['status'] == 'I'){ ?>In Progress<?php }; ?>
		            <?php if ($rowCMT['status'] == 'B'){ ?>Awaiting Board<?php }; ?>
		            <?php if ($rowCMT['status'] == '3'){ ?>Awaiting 3rd Party<?php }; ?>
		            <?php if ($rowCMT['status'] == 'H'){ ?>On Hold<?php }; ?>
		            <?php if ($rowCMT['status'] == 'C'){ ?>Closed<?php }; ?>
		            </b>
		            <?php echo "{$rowCMT['created_date']}"; ?>
		        </small>
		    </blockquote>
		<?php
			}
		?>

		<?php
			}
		?>

</div>
<div style="float:right">
    <form name="AddComment" method="POST" action="../forms/submit-servicerequest-comment.php">
        <input type="hidden" name="id" value="<?php echo "{$id}"; ?>">
        <input type="hidden" name="module" value="service">
        <input name="submit" value="Comment/Reply to This Service Request" class="submit" type="submit">
    </form>
</div>

      </td>
      <td valign="top">
				<b>
				<?php if ($row['status'] == 'O'){ ?>Open<?php }; ?>
				<?php if ($row['status'] == 'I'){ ?>In Progress<?php }; ?>
				<?php if ($row['status'] == 'B'){ ?>Awaiting Board<?php }; ?>
				<?php if ($row['status'] == '3'){ ?>Awaiting 3rd Party<?php }; ?>
				<?php if ($row['status'] == 'H'){ ?>On Hold<?php }; ?>
				<?php if ($row['status'] == 'C'){ ?>Closed<?php }; ?>
				</b>
				<br><?php echo "{$row['created_date']}"; ?>
      </td>
    </tr>
<?php
	}
?>

<?php }; ?>

<!-- OTHER USERS IN UNIT -->

  </tbody>
</table>
<br>
<!-- CLOSED SERVICE REQUESTS -->
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr>
      <th align="center" colspan="2">Closed Service Requests</th>
    </tr>
    <tr>
      <th align="left" class="table-sortable:alphanumeric"><b>&nbsp;&nbsp;&nbsp; Service Request and Comments</b></th>
      <th align="left" class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp; Status</th>
    </tr>
  </thead>
  <tbody>

<!-- DATABASE RESULTS -->
<?php
	$type   = $_SESSION['id'];
	$query  = "SELECT * FROM `service` WHERE `userid` = '$type' AND `status` = 'C' ORDER BY `int1`";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
    <tr>
      <td>
		    <i class="fa fa-comment" aria-hidden="true"></i> <b><?php echo "{$row['location']}"; ?></b>
		    <br><?php echo "{$row['description']}"; ?>

		<?php
			$userid    = $row['userid'];
			$queryUSR  = "SELECT id, unit, unit2, last_name, first_name FROM users WHERE id = '$userid'";
			$resultUSR = mysqli_query($dbConn,$queryUSR);

			while($rowUSR = $resultUSR->fetch_array(MYSQLI_ASSOC))
			{
		?>
		    <blockquote>
		        <small><b><?php echo "{$rowUSR['last_name']}"; ?>, <?php echo "{$rowUSR['first_name']}"; ?></a></b></small>
		        <small><?php echo "{$rowUSR['unit']}"; ?><?php if ($rowUSR['unit2'] !== 'X'){ ?><?php echo "{$rowUSR['unit2']}"; ?><?php }; ?></small><br>
		        <small><b>Open</b> <?php echo "{$row['created_date']}"; ?></small>
						<?php if ($row['pte'] == 'N' AND $row['location'] == 'Unit'){ ?><div style="color: red;"><small><i class="fa fa-key" aria-hidden="true" style="color: red;"></i> Permission to enter <u>NOT</u> granted!</small></div><?php }; ?>
						<?php if ($row['pte'] != 'N' AND $row['location'] == 'Unit'){ ?><div style="color: green"><small><i class="fa fa-key" aria-hidden="true" style="color: green;"></i> Permission to enter is granted!</small></div><?php }; ?>
						<?php if ($row['privacy'] != 'Y'){ ?><div><small><i class="fa fa-user-times" aria-hidden="true" style="color: red;" title="You are NOT sharing service request with other users in your unit."></i> You are NOT sharing service request with other users in your unit.</small></div><?php }; ?>
						<?php if ($row['privacy'] == 'Y'){ ?><div><small><i class="fa fa-users" aria-hidden="true" style="color: green;" title="You are sharing service request with other users in your unit."></i> You are sharing service request with other users in your unit.</small></div><?php }; ?>
		    </blockquote>
		<?php
			}
		?>
		
<?php $id = $row['int1']; $sqlCMT = mysqli_query($dbConn,"SELECT count(*) FROM `comments` WHERE `module` = 'service' AND `id` = '$id'") or die(mysqli_error($dbConn));
$row = mysqli_fetch_row($sqlCMT);
$countCMT = $row[0];
?>
<?php if ($countCMT == '0'){ ?><div><b>Your Service Request has not yet been commented on.</b></div><?php }; ?>
<?php if ($countCMT >= '1'){ ?><div><input type="checkbox" name="<?php echo "{$id}"; ?>" onclick="showMe('<?php echo "{$id}"; ?>', this)" />&nbsp;<b>Show&nbsp;Comments&nbsp;&nbsp;</b></div><?php }; ?>

<div id="<?php echo "{$id}"; ?>" style="display:none">
		<?php
			$queryCMT  = "SELECT * FROM `comments` WHERE `module` = 'service' AND `id` = '$id' ORDER BY `created_date`";
			$resultCMT = mysqli_query($dbConn,$queryCMT);

			while($rowCMT = $resultCMT->fetch_array(MYSQLI_ASSOC))
			{
		?>

		    <i class="fa fa-comment-o" aria-hidden="true"></i> <?php echo "{$rowCMT['comment']}"; ?>
		<?php
			$userid    = $rowCMT['userid'];
			$queryUSR  = "SELECT id, unit, unit2, last_name, first_name FROM users WHERE id = '$userid'";
			$resultUSR = mysqli_query($dbConn,$queryUSR);

			while($rowUSR = $resultUSR->fetch_array(MYSQLI_ASSOC))
			{
		?>
		    <blockquote>
		        <small><b><?php echo "{$rowUSR['last_name']}"; ?>, <?php echo "{$rowUSR['first_name']}"; ?></a></b></small>
		        <small><?php echo "{$rowUSR['unit']}"; ?><?php if ($rowUSR['unit2'] !== 'X'){ ?><?php echo "{$rowUSR['unit2']}"; ?><?php }; ?></small><br>
		        <small>
		            <b>
		            <?php if ($rowCMT['status'] == 'O'){ ?>Open<?php }; ?>
		            <?php if ($rowCMT['status'] == 'I'){ ?>In Progress<?php }; ?>
		            <?php if ($rowCMT['status'] == 'B'){ ?>Awaiting Board<?php }; ?>
		            <?php if ($rowCMT['status'] == '3'){ ?>Awaiting 3rd Party<?php }; ?>
		            <?php if ($rowCMT['status'] == 'H'){ ?>On Hold<?php }; ?>
		            <?php if ($rowCMT['status'] == 'C'){ ?>Closed<?php }; ?>
		            </b>
		            <?php echo "{$rowCMT['created_date']}"; ?>
		        </small>
		    </blockquote>
		<?php
			}
		?>

		<?php
			}
		?>

</div>
    <div style="float:right">
    <form name="AddComment" method="POST" action="../forms/submit-servicerequest-comment.php">
        <input type="hidden" name="id" value="<?php echo "{$id}"; ?>">
        <input type="hidden" name="module" value="service">
        <input name="submit" value="Comment/Reply to This Service Request" class="submit" type="submit">
    </form>
    </div>

      </td>
      <td valign="top">
				<b>
				<?php if ($row['status'] == 'O'){ ?>Open<?php }; ?>
				<?php if ($row['status'] == 'I'){ ?>In Progress<?php }; ?>
				<?php if ($row['status'] == 'B'){ ?>Awaiting Board<?php }; ?>
				<?php if ($row['status'] == '3'){ ?>Awaiting 3rd Party<?php }; ?>
				<?php if ($row['status'] == 'H'){ ?>On Hold<?php }; ?>
				<?php if ($row['status'] == 'C'){ ?>Closed<?php }; ?>
				</b>
				<br><?php echo "{$row['created_date']}"; ?>
      </td>
    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->

<!-- OTHER USERS IN UNIT -->

<?php $unit = $_SESSION['unit']; $unit2 = $_SESSION['unit2']; $queryUNIT = "SELECT `id` FROM `users` WHERE `unit` = '$unit' AND `unit2` = '$unit2'"; $resultUNIT = mysqli_query($dbConn,$queryUNIT); while($rowUNIT = $resultUNIT->fetch_array(MYSQLI_ASSOC)) { ?>

<?php
	$unit   = $rowUNIT['id'];
	$type   = $_SESSION['id'];
	$query  = "SELECT * FROM `service` WHERE `userid` = '$unit' AND `userid` != '$type' AND `status` = 'C' AND `privacy` = 'Y' ORDER BY `int1`";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
    <tr>
      <td>
		    <i class="fa fa-comment" aria-hidden="true"></i> <b><?php echo "{$row['location']}"; ?></b>
		    <br><?php echo "{$row['description']}"; ?>

		<?php
			$userid    = $row['userid'];
			$queryUSR  = "SELECT id, unit, unit2, last_name, first_name FROM users WHERE id = '$userid'";
			$resultUSR = mysqli_query($dbConn,$queryUSR);

			while($rowUSR = $resultUSR->fetch_array(MYSQLI_ASSOC))
			{
		?>
		    <blockquote>
		        <small><b><?php echo "{$rowUSR['last_name']}"; ?>, <?php echo "{$rowUSR['first_name']}"; ?></a></b></small>
		        <small><?php echo "{$rowUSR['unit']}"; ?><?php if ($rowUSR['unit2'] !== 'X'){ ?><?php echo "{$rowUSR['unit2']}"; ?><?php }; ?></small><br>
		        <small><b>Open</b> <?php echo "{$row['created_date']}"; ?></small>
						<?php if ($row['pte'] == 'N' AND $row['location'] == 'Unit'){ ?><div style="color: red;"><small><i class="fa fa-key" aria-hidden="true" style="color: red;"></i> Permission to enter <u>NOT</u> granted!</small></div><?php }; ?>
						<?php if ($row['pte'] != 'N' AND $row['location'] == 'Unit'){ ?><div style="color: green"><small><i class="fa fa-key" aria-hidden="true" style="color: green;"></i> Permission to enter is granted!</small></div><?php }; ?>
						<?php if ($row['privacy'] != 'Y'){ ?><div><small><i class="fa fa-user-times" aria-hidden="true" style="color: red;" title="You are NOT sharing service request with other users in your unit."></i> You are NOT sharing service request with other users in your unit.</small></div><?php }; ?>
						<?php if ($row['privacy'] == 'Y'){ ?><div><small><i class="fa fa-users" aria-hidden="true" style="color: green;" title="You are sharing service request with other users in your unit."></i> You are sharing service request with other users in your unit.</small></div><?php }; ?>
		    </blockquote>
		<?php
			}
		?>
		
<?php $id = $row['int1']; $sqlCMT = mysqli_query($dbConn,"SELECT count(*) FROM `comments` WHERE `module` = 'service' AND `id` = '$id'") or die(mysqli_error($dbConn));
$row = mysqli_fetch_row($sqlCMT);
$countCMT = $row[0];
?>
<?php if ($countCMT == '0'){ ?><div><b>Your Service Request has not yet been commented on.</b></div><?php }; ?>
<?php if ($countCMT >= '1'){ ?><div><input type="checkbox" name="<?php echo "{$id}"; ?>" onclick="showMe('<?php echo "{$id}"; ?>', this)" />&nbsp;<b>Show&nbsp;Comments&nbsp;&nbsp;</b></div><?php }; ?>

<div id="<?php echo "{$id}"; ?>" style="display:none">
		<?php
			$queryCMT  = "SELECT * FROM `comments` WHERE `module` = 'service' AND `id` = '$id' ORDER BY `created_date`";
			$resultCMT = mysqli_query($dbConn,$queryCMT);

			while($rowCMT = $resultCMT->fetch_array(MYSQLI_ASSOC))
			{
		?>

		    <i class="fa fa-comment-o" aria-hidden="true"></i> <?php echo "{$rowCMT['comment']}"; ?>
		<?php
			$userid    = $rowCMT['userid'];
			$queryUSR  = "SELECT id, unit, unit2, last_name, first_name FROM users WHERE id = '$userid'";
			$resultUSR = mysqli_query($dbConn,$queryUSR);

			while($rowUSR = $resultUSR->fetch_array(MYSQLI_ASSOC))
			{
		?>
		    <blockquote>
		        <small><b><?php echo "{$rowUSR['last_name']}"; ?>, <?php echo "{$rowUSR['first_name']}"; ?></a></b></small>
		        <small><?php echo "{$rowUSR['unit']}"; ?><?php if ($rowUSR['unit2'] !== 'X'){ ?><?php echo "{$rowUSR['unit2']}"; ?><?php }; ?></small><br>
		        <small>
		            <b>
		            <?php if ($rowCMT['status'] == 'O'){ ?>Open<?php }; ?>
		            <?php if ($rowCMT['status'] == 'I'){ ?>In Progress<?php }; ?>
		            <?php if ($rowCMT['status'] == 'B'){ ?>Awaiting Board<?php }; ?>
		            <?php if ($rowCMT['status'] == '3'){ ?>Awaiting 3rd Party<?php }; ?>
		            <?php if ($rowCMT['status'] == 'H'){ ?>On Hold<?php }; ?>
		            <?php if ($rowCMT['status'] == 'C'){ ?>Closed<?php }; ?>
		            </b>
		            <?php echo "{$rowCMT['created_date']}"; ?>
		        </small>
		    </blockquote>
		<?php
			}
		?>

		<?php
			}
		?>

</div>
    <div style="float:right">
    <form name="AddComment" method="POST" action="../forms/submit-servicerequest-comment.php">
        <input type="hidden" name="id" value="<?php echo "{$id}"; ?>">
        <input type="hidden" name="module" value="service">
        <input name="submit" value="Comment/Reply to This Service Request" class="submit" type="submit">
    </form>
    </div>

      </td>
      <td valign="top">
				<b>
				<?php if ($row['status'] == 'O'){ ?>Open<?php }; ?>
				<?php if ($row['status'] == 'I'){ ?>In Progress<?php }; ?>
				<?php if ($row['status'] == 'B'){ ?>Awaiting Board<?php }; ?>
				<?php if ($row['status'] == '3'){ ?>Awaiting 3rd Party<?php }; ?>
				<?php if ($row['status'] == 'H'){ ?>On Hold<?php }; ?>
				<?php if ($row['status'] == 'C'){ ?>Closed<?php }; ?>
				</b>
				<br><?php echo "{$row['created_date']}"; ?>
      </td>
    </tr>
<?php
	}
?>

<?php }; ?>

<!-- OTHER USERS IN UNIT -->

  </tbody>
</table>
<!-- CONTENT -->

</body>

	<script src="../java/vendor/what-input.js"></script>
	<script src="../java/vendor/foundation.min.js"></script>
	<script type="text/javascript" src="../java/google-base.js"></script>
	<script type="text/javascript" src="../my-documents/google-code.js"></script>

</html>