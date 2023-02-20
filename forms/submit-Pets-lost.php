<?php require_once('../my-documents/php7-my-db.php'); $id = $_POST["id"]; $action = $_POST["action"]; if ($action == "save"){

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$comments = mysqli_real_escape_string($conn, $_POST["comments"]);
		$lost = mysqli_real_escape_string($conn, $_POST["lost"]);

		$query = "UPDATE pets SET comments='$comments', lost='$lost' WHERE `id`='$id' LIMIT 1";
		mysqli_query($conn,$query) or die('Error, update query failed');

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['id'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('L', 'Pets', '$useripaddress', '$userid', '$id')";
		mysqli_query($conn,$query) or die('Error, updating log failed');

		header('Location: ../modules/pets-personal.php');
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
	<script src="../java/ckeditor/ckeditor.js"></script>
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
<h4>My animal is lost!</h4>
</div>

<?php if (($_SESSION['owner'] != true) AND ($_SESSION['lease'] != true) AND ($_SESSION['realtor'] != true)){ ?>

  <div class="stand-alone-page-content">
    <div class="popup-subheader">
      <div class="row">
        <div class="small-12 columns text-center">
<blockquote>
<br><br><b>Please login to use this module.</b><br><br><br>
</blockquote>
        </div>
      </div>
    </div>

<?php }; ?>

<?php if (($_SESSION['owner'] == true) OR ($_SESSION['lease'] == true) OR ($_SESSION['realtor'] == true)){ ?>
<?php
	$query  = "SELECT * FROM pets WHERE `id`='$id' LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
  <div class="stand-alone-page-content">
    <div class="popup-subheader">
      <div class="row">
        <div class="small-12 columns">
<!-- BEGIN LOST PET COMMENT -->
<blockquote>
<br>
<?php if ($row['name'] !== 'none.gif'){ ?><div class="module-image"><img src="../download-pets.php?id=<?php echo "{$row['id']}"; ?>" alt=""></div><?php }; ?>
Tagging <?php echo($row['petname']); ?> as lost will immediately place their name and photo, the comments below, and your contact information on the Newsboard.  This information will only be visible to registered website owners and renters, and is very helpful to your neighbors in the recovery of your lost pet.<br><br>You should also add helpful information such as where you may have seen your animal last, or their favorite treat in the comments field below.<br>
<br>
</blockquote>
<!-- END LOST PET COMMENT -->
        </div>
      </div>
    </div>

    <div class="form-wrapper">

<form method="POST" action="" name="theform" id="theform" enctype="multipart/form-data">
<!-- FORM CONTENT -->

      <div class="row">
        <div class="small-12 columns text-center">
	<?php echo($error); ?>
	</div>
      </div>

<!-- FIELDS -->
      <div class="row medium-collapse">
        <div class="small-12 medium-5 large-4 columns"><label for="lost" class="middle note-anchor">Is <b><?php echo($row['petname']); ?></b> lost?</label></div>
        <div class="small-12 medium-5 end columns"><select name="lost">
<option value="Yes" <?php if($row['lost'] == "Yes"){ echo("SELECTED"); } ?>>Yes</option>
<option value="No" <?php if($row['lost'] == "No"){ echo("SELECTED"); } ?>>No</option>
		</select></div>
      </div>
      <div class="row" style="padding-bottom: 20px;">
        <div class="small-12 columns text-center">Comments<br><span class="note-red">(Comments are visible to other registered users.)</span>
					<textarea name="comments" cols="30" rows="2" id="editor1" class="form" type="text" placeholder="<?php echo "{$row['comments']}"; ?>" required><?php echo "{$row['comments']}"; ?></textarea>
					<script>CKEDITOR.replace( 'editor1' );</script>
      </div>
<!-- FIELDS -->

    </div>

    <div class="popup-subheader">
      <div class="row">
        <div class="small-12 columns text-center">
	  <br>
	  <input type="hidden" name="action" value="save">
	  <input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
	  <input name="submit" value="Save" class="submit" type="submit"></div>
	  <br>
	  <br>&nbsp;
        </div>
      </div>

<!-- END FORM CONTENT -->
</form>

    </div>
  </div>

<?php
	}
?>
<?php }; ?>

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
