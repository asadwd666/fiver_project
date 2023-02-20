<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '/home/nodyss5/php/PHPMailer-6.3.0/src/PHPMailer.php';
require '/home/nodyss5/php/PHPMailer-6.3.0/src/SMTP.php';
require '/home/nodyss5/php/PHPMailer-6.3.0/src/Exception.php';
//require '/home/nodyss5/php/PHPMailer/PHPMailerAutoload.php';

require_once('../my-documents/php7-my-db.php');
require '../my-documents/smtp.php';

$id = $_POST["id"];
$action = $_POST["action"];
$success = "untried";

if ($action != null){

	if ($action == "add" && $_FILES['userfile']['size'] > 0 && $_FILES['userfile']['size'] <= 1500000){

		$first_name = $_SESSION['first_name'];
		$last_name = $_SESSION['last_name'];
		$useremail = $_SESSION['email'];
		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$species = mysqli_real_escape_string($conn, $_POST["species"]);
		
		$vaccination = mysqli_real_escape_string($conn, $_POST["vaccination"]);
		$license = mysqli_real_escape_string($conn, $_POST["license"]);
		
		$petname = mysqli_real_escape_string($conn, $_POST["petname"]);
		$userid = mysqli_real_escape_string($conn, $_POST["userid"]);
		$PetBreed = mysqli_real_escape_string($conn, $_POST["PetBreed"]);
		$PetWeight = mysqli_real_escape_string($conn, $_POST["PetWeight"]);
		$PetAgeYears = mysqli_real_escape_string($conn, $_POST["PetAgeYears"]);
		$PetAgeMonths = mysqli_real_escape_string($conn, $_POST["PetAgeMonths"]);
		$PetTerms = mysqli_real_escape_string($conn, $_POST["PetTerms"]);
		$comments = mysqli_real_escape_string($conn, $_POST["comments"]);
		$fileName = $_FILES['userfile']['name'];
		$tmpName  = $_FILES['userfile']['tmp_name'];
		$fileSize = $_FILES['userfile']['size'];
		$fileType = $_FILES['userfile']['type'];
		$fp      = fopen($tmpName, 'r');
		$content = fread($fp, filesize($tmpName));
		$content = addslashes($content);
		fclose($fp);

		if(!get_magic_quotes_gpc())
		{
			$fileName = addslashes($fileName);
		}

		if($petname != "" OR $PetBreed != "" OR $PetWeight != "" OR $PetAgeYears != "" OR $PetAgeMonths != "" ){

			$query  = "INSERT INTO pets (species, breed, weight, vaccination, license, petname, comments, userid, name, size, type, content, useripaddress) VALUES ('$species', '$PetBreed', '$PetWeight', '$vaccination', '$license', '$petname', '$comments', '$userid', '$fileName', '$fileSize', '$fileType', '$content', '$useripaddress')";
			mysqli_query($conn,$query) or die('Error, insert query failed');

			$reseturl = $_SESSION['reseturl'];
            $communityurl = $_SESSION['communityurl'];
            $fromname = "$CommunityName via CondoSites";

			$subject = "$CommunityName/CondoSites - Pet Registration";
		    
		    $body = "<!DOCTYPE HTML><html><body><div style='padding: 25px;'>";
            $body .= "<p>A website user has submitted a pet registration form through the ".$CommunityName."/CondoSites community website.  Your action is required.<br>To approve and edit this listing, access the Pets control panel.<br><br>Below is an overview of the information submitted by the user.<br><br>Submitted by: ".$first_name." ".$last_name."<br>Email: ".$useremail."<br>User ID: ".$userid."<br>User IP Address: ".$useripaddress."<br><br>Species: ".$species."<br>Pet Name: ".$petname."<br><br>Pet Breed: ".$PetBreed."<br>Pet Weight: ".$PetWeight."<br>Pet Age: ".$PetAgeYears." Years ".$PetAgeMonths." Months<br><br>Terms: ".$PetTerms."</p>";
            $body .= "</div><br><img src='".$communityurl."/pics/logo-small.png' style='max-width: 100px;'><br><br>Visit your <a href='".$communityurl."'>".$CommunityName." community website</a>.</p>";
            $body .= "<p><b>Email Subscription</b><br><small>You are receiving this email because you are a registered user of the ".$CommunityName." community website, operated by <a href='https://condosites.com' target='_blank'>CondoSites</a>.";
            $body .= "<br><br><span style='color: darkred;'>DO NOT REPLY TO THIS EMAIL!</span> IT IS SENT FROM AN UNMONITORED ADDRESS.";
            $body .= "<br><br><b><a href='".$communityurl."/spamhelp.php'>Are these emails being treated as spam?</a></b></p></small></body></html>";

            $mail = new PHPMailer();

            $mail->isSMTP();
            $mail->Host = $hostOPS;
            $mail->SMTPAuth = $smtpauthOPS;
            $mail->SMTPKeepAlive = $smtpkeepaliveOPS;
            $mail->Port = $smtpportOPS;
            $mail->SMTPSecure = $smtpsecureOPS;
            $mail->SMTPAutoTLS = $smtpautotlsOPS;
            $mail->Username = $usernameOPS;
            $mail->Password = $passwordOPS;
            $mail->setFrom($fromemailOPS, 'CondoSites Database Submission eForm');
    
            $mail->addAddress($CLASSIFIEDS_EMAIL, $fromname);
            $mail->Subject = "$subject";
            $mail->Body = "$body";
            $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';

            if(!$mail->send()) {

            } else {
    		    header('Location: thanks.php');
            }

		} else {
			$error = "Error: All fields are required!<br>You will also need to reattach your photo.<br><br>";
			$error2 = "You will also need to reattach your photo.<br><br>";
			$success = "false";
	}
	} else {
		$error = "Error: You did not attach a photo, or it was larger than 1 MB.<br><br>";
		$success = "false";
	}
}
?>
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
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
<?php
	$query  = "SELECT title FROM tabs WHERE `int1` = '452'";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<h4><?php echo "{$row['title']}"; ?></h4>
<?php
	}
?>
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

  <div class="stand-alone-page-content">
    <div class="popup-subheader">
      <div class="row">
        <div class="small-12 columns text-center">
<blockquote>
<!-- TEXT 1 -->
<?php
	$query  = "SELECT text1 FROM forms WHERE `int1` = '452'";
	$result = mysqli_query($conn, $query);

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

<form method="POST" action="" name="theform" id="theform" enctype="multipart/form-data">
<!-- FORM CONTENT -->

      <div class="row">
        <div class="small-12 columns text-center">
	<?php echo($error); ?>
	</div>
      </div>

<!-- FIELDS -->

      <div class="row medium-collapse">
        <div class="small-12 medium-5 large-4 columns"><label for="userfile" class="middle note-anchor">Photo <span class="note-red">***REQUIRED*** 1 MB Maximum, JPEG/GIF/PNG format</span></label></div>
        <div class="small-12 medium-5 end columns"><input type="hidden" name="MAX_FILE_SIZE" value="1800000"><input type="file" name="userfile" id="userfile" required><?php echo($error2); ?></div>
      </div>
      <div class="row medium-collapse">
        <div class="small-12 medium-5 large-4 columns"><label for="species" class="middle note-anchor">Species</label></div>
        <div class="small-12 medium-5 end columns">
	<select name="species" required>
<option value="" <?php if($_POST['species'] == ""){ echo("SELECTED"); } ?>>Select</option>
<option value="Cat" <?php if($_POST['species'] == "Cat"){ echo("SELECTED"); } ?>>Cat</option>
<option value="Dog" <?php if($_POST['species'] == "Dog"){ echo("SELECTED"); } ?>>Dog</option>
<option value="Other" <?php if($_POST['species'] == "Other"){ echo("SELECTED"); } ?>>Other</option>
	</select>
      </div>
      </div>
      <div class="row medium-collapse">
        <div class="small-12 medium-5 large-4 columns"><label for="petname" class="middle note-anchor">Name of Animal</label></div>
        <div class="small-12 medium-5 end columns"><input name="petname" type="text" size="20" maxlength="30" class="form" value="<?php echo($_POST['petname']); ?>" required></div>
      </div>
      <div class="row medium-collapse">
        <div class="small-12 medium-5 large-4 columns"><label for="PetBreed" class="middle note-anchor">Breed</label></div>
        <div class="small-12 medium-5 end columns"><input name="PetBreed" type="text" class="form" id="PetBreed" size="20" maxlength="28" value="<?php echo($_POST['PetBreed']); ?>" required></div>
      </div>
      <div class="row medium-collapse">
        <div class="small-12 medium-5 large-4 columns"><label for="license" class="middle note-anchor">Local License Number</label></div>
        <div class="small-12 medium-5 end columns"><input name="license" type="text" class="form" id="license" size="20" maxlength="28" value="<?php echo($_POST['license']); ?>" required></div>
      </div>
      <div class="row medium-collapse">
        <div class="small-12 medium-5 large-4 columns"><label for="vaccination" class="middle note-anchor">Vaccination Date</label></div>
        <div class="small-12 medium-5 end columns"><input name="vaccination" class="form datepicker" type="date" placeholder="YYYY-MM-DD" id="vaccination" size="20" maxlength="28" value="<?php echo($_POST['vaccination']); ?>" required></div>
      </div>
      <div class="row medium-collapse">
        <div class="small-12 medium-5 large-4 columns"><label for="PetWeight" class="middle note-anchor">Weight  in <?php include('../my-documents/localization-weight.txt'); ?> (at maturity)</label></div>
        <div class="small-12 medium-5 end columns"><input name="PetWeight" type="number" class="form" id="PetWeight" size="5" maxlength="2" value="<?php echo($_POST['PetWeight']); ?>" required></div>
      </div>
      <div class="row medium-collapse">
        <div class="small-12 medium-5 large-4 columns"><label for="PetAgeYears" class="middle note-anchor">Age (in human years)</label></div>
        <div class="small-12 medium-5 end columns">
<select name="PetAgeYears" required class="form-split-left">
<option value="" <?php if($_POST['PetAgeYears'] == ""){ echo("SELECTED"); } ?>>Years</option>
<option value="0" <?php if($_POST['PetAgeYears'] == "0"){ echo("SELECTED"); } ?>>0</option>
<option value="1" <?php if($_POST['PetAgeYears'] == "1"){ echo("SELECTED"); } ?>>1</option>
<option value="2" <?php if($_POST['PetAgeYears'] == "2"){ echo("SELECTED"); } ?>>2</option>
<option value="3" <?php if($_POST['PetAgeYears'] == "3"){ echo("SELECTED"); } ?>>3</option>
<option value="4" <?php if($_POST['PetAgeYears'] == "4"){ echo("SELECTED"); } ?>>4</option>
<option value="5" <?php if($_POST['PetAgeYears'] == "5"){ echo("SELECTED"); } ?>>5</option>
<option value="6" <?php if($_POST['PetAgeYears'] == "6"){ echo("SELECTED"); } ?>>6</option>
<option value="7" <?php if($_POST['PetAgeYears'] == "7"){ echo("SELECTED"); } ?>>7</option>
<option value="8" <?php if($_POST['PetAgeYears'] == "8"){ echo("SELECTED"); } ?>>8</option>
<option value="9" <?php if($_POST['PetAgeYears'] == "9"){ echo("SELECTED"); } ?>>9</option>
<option value="10" <?php if($_POST['PetAgeYears'] == "10"){ echo("SELECTED"); } ?>>10</option>
<option value="11" <?php if($_POST['PetAgeYears'] == "11"){ echo("SELECTED"); } ?>>11</option>
<option value="12" <?php if($_POST['PetAgeYears'] == "12"){ echo("SELECTED"); } ?>>12</option>
<option value="13" <?php if($_POST['PetAgeYears'] == "13"){ echo("SELECTED"); } ?>>13</option>
<option value="14" <?php if($_POST['PetAgeYears'] == "14"){ echo("SELECTED"); } ?>>14</option>
<option value="15" <?php if($_POST['PetAgeYears'] == "15"){ echo("SELECTED"); } ?>>15</option>
<option value="16" <?php if($_POST['PetAgeYears'] == "16"){ echo("SELECTED"); } ?>>16</option>
<option value="17" <?php if($_POST['PetAgeYears'] == "17"){ echo("SELECTED"); } ?>>17</option>
<option value="18" <?php if($_POST['PetAgeYears'] == "18"){ echo("SELECTED"); } ?>>18</option>
<option value="19" <?php if($_POST['PetAgeYears'] == "19"){ echo("SELECTED"); } ?>>19</option>
<option value="20" <?php if($_POST['PetAgeYears'] == "20"){ echo("SELECTED"); } ?>>20</option>
<option value="21+" <?php if($_POST['PetAgeYears'] == "21+"){ echo("SELECTED"); } ?>>21+</option>
</select>
<select name="PetAgeMonths" required class="form-split-right">
<option value="" <?php if($_POST['PetAgeMonths'] == ""){ echo("SELECTED"); } ?>>Months</option>
<option value="0" <?php if($_POST['PetAgeMonths'] == "0"){ echo("SELECTED"); } ?>>0</option>
<option value="1" <?php if($_POST['PetAgeMonths'] == "1"){ echo("SELECTED"); } ?>>1</option>
<option value="2" <?php if($_POST['PetAgeMonths'] == "2"){ echo("SELECTED"); } ?>>2</option>
<option value="3" <?php if($_POST['PetAgeMonths'] == "3"){ echo("SELECTED"); } ?>>3</option>
<option value="4" <?php if($_POST['PetAgeMonths'] == "4"){ echo("SELECTED"); } ?>>4</option>
<option value="5" <?php if($_POST['PetAgeMonths'] == "5"){ echo("SELECTED"); } ?>>5</option>
<option value="6" <?php if($_POST['PetAgeMonths'] == "6"){ echo("SELECTED"); } ?>>6</option>
<option value="7" <?php if($_POST['PetAgeMonths'] == "7"){ echo("SELECTED"); } ?>>7</option>
<option value="8" <?php if($_POST['PetAgeMonths'] == "8"){ echo("SELECTED"); } ?>>8</option>
<option value="9" <?php if($_POST['PetAgeMonths'] == "9"){ echo("SELECTED"); } ?>>9</option>
<option value="10" <?php if($_POST['PetAgeMonths'] == "10"){ echo("SELECTED"); } ?>>10</option>
<option value="11" <?php if($_POST['PetAgeMonths'] == "11"){ echo("SELECTED"); } ?>>11</option>
	</select>
        </div>
      </div>

      <div class="row" style="padding-bottom: 20px;">
        <div class="small-12 columns text-center">Comments<br><span class="note-red">(Comments are visible to other registered users.)</span>
					<textarea name="comments" cols="30" rows="2" id="editor1" class="form" type="text" placeholder="<?php echo "{$row['comments']}"; ?>" required><?php echo "{$row['comments']}"; ?></textarea>
					<script>CKEDITOR.replace( 'editor1' );</script>
      </div>

<!-- FIELDS -->

    </div>

<!-- TERMS -->

<?php
	$query  = "SELECT terms FROM forms WHERE `int1` = '452' AND terms != ''";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
    <div class="popup-subheader">
      <div class="row">
        <div class="small-12 columns text-center"><br>Terms:<br><textarea readonly="readonly" name="terms" cols="45" rows="5" class="form" id="terms"><?php echo "{$row['terms']}"; ?></textarea></div>
      </div>
      <div class="row">
        <div class="small-12 columns text-center" style="background-color: #ffcccccc"><b>BY CLICKING &quot;SUBMIT&quot; BELOW YOU AGREE THAT YOU: have read the terms above, and agree to adhere those terms.</b></div>
      </div>
<?php
	}
?>

<!-- END TERMS -->

    <div class="popup-subheader">
      <div class="row">
        <div class="small-12 columns text-center">
	  <br>
	  <input type="hidden" name="action" value="add">
	  <input type="submit" class="submit" value="Submit" /><br>
	  <br>

<!-- USER -->
Submitted by: <?php echo($_SESSION['first_name']); ?> <?php echo($_SESSION['last_name']); ?><br><span class="note-red">IP Address: <?php echo($_SERVER['REMOTE_ADDR']); ?></span><br><input type=hidden name="userid" class="form" id="userid" value="<?php echo($_SESSION['id']); ?>">
<!-- END USER -->

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
	$query  = "SELECT text2 FROM forms WHERE `int1` = '452'";
	$result = mysqli_query($conn, $query);

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
