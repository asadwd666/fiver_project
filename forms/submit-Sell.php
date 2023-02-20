<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '/home/nodyss5/php/PHPMailer-6.3.0/src/PHPMailer.php';
require '/home/nodyss5/php/PHPMailer-6.3.0/src/SMTP.php';
require '/home/nodyss5/php/PHPMailer-6.3.0/src/Exception.php';
//require '/home/nodyss5/php/PHPMailer/PHPMailerAutoload.php';
require '../my-documents/smtp.php';

require_once('../my-documents/php7-my-db.php');
$int1 = $_POST["int1"];
$action = $_POST["action"];
$success = "untried";

if ($action != null){

	if ($action == "add" && $_FILES['userfile']['size'] == '0'){

		$first_name = $_SESSION['first_name'];
		$last_name = $_SESSION['last_name'];
		$useremail = $_SESSION['email'];
		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$headline = mysqli_real_escape_string($conn, $_POST["headline"]);
		$description = mysqli_real_escape_string($conn, $_POST["description"]);
		$url = mysqli_real_escape_string($conn, $_POST["url"]);
		$email = mysqli_real_escape_string($conn, $_POST["email"]);
		$contact = mysqli_real_escape_string($conn, $_POST["contact"]);
		$phone = mysqli_real_escape_string($conn, $_POST["phone"]);
		$forsalerent = mysqli_real_escape_string($conn, $_POST["forsalerent"]);
		$price = mysqli_real_escape_string($conn, $_POST["price"]);
		$userid = mysqli_real_escape_string($conn, $_POST["userid"]);

		if($headline != "" && $description != "" && $contact != "" && $phone != "" && $forsalerent != "" && $price != "" && $userid != ""){

			$query = "INSERT INTO realestate (headline, description, url, email, contact, phone, forsalerent, price, userid, useripaddress) VALUES ('$headline', '$description', '$url', '$email', '$contact', '$phone', '$forsalerent', '$price', '$userid', '$useripaddress')";
			mysqli_query($conn,$query) or die('Error, insert query failed');

            $reseturl = $_SESSION['reseturl'];
            $communityurl = $_SESSION['communityurl'];
            $fromname = "$CommunityName via CondoSites";

			$subject = "$CommunityName/CondoSites - Classifieds Submission";
		    
		    $body = "<!DOCTYPE HTML><html><body><div style='padding: 25px;'>";
            $body .= "<p>A website user has submitted a classified ad listing through the ".$CommunityName."/CondoSites community website.  Your action is required.<br>To approve and edit this listing, access the Classified Ads control panel.<br><br>Below is an overview of the ad submitted by the user.<br><br>Ad Type: ".$forsalerent."<br>Headline: ".$headline."<br>Price: ".$price."<br>Description: ".$description."<br><br>URL: ".$url."<br>Contact: ".$contact."<br>Email: ".$email."<br>Phone: ".$phone."<br><br><br>Submitted by: ".$first_name." ".$last_name."<br>User ID: ".$userid."<br>User IP Address: ".$useripaddress."</p>";
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
			$error = "ALL fields are required.\n\n";
			$success = "false";
		}
	}
	
	if ($action == "add" && $_FILES['userfile']['size'] > '0'){

		$first_name = $_SESSION['first_name'];
		$last_name = $_SESSION['last_name'];
		$useremail = $_SESSION['email'];
		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$headline = mysqli_real_escape_string($conn, $_POST["headline"]);
		$description = mysqli_real_escape_string($conn, $_POST["description"]);
		$url = mysqli_real_escape_string($conn, $_POST["url"]);
		$email = mysqli_real_escape_string($conn, $_POST["email"]);
		$contact = mysqli_real_escape_string($conn, $_POST["contact"]);
		$phone = mysqli_real_escape_string($conn, $_POST["phone"]);
		$forsalerent = mysqli_real_escape_string($conn, $_POST["forsalerent"]);
		$price = mysqli_real_escape_string($conn, $_POST["price"]);
		$userid = mysqli_real_escape_string($conn, $_POST["userid"]);
		$fileName = $_FILES['userfile']['name'];
		$tmpName  = $_FILES['userfile']['tmp_name'];
		$fileSize = $_FILES['userfile']['size'];
		$fileType = $_FILES['userfile']['type'];
		$fp      = fopen($tmpName, 'r');
		$content = fread($fp, filesize($tmpName));
		$content = addslashes($content);
		fclose($fp);

		if($headline != "" && $description != "" && $contact != "" && $phone != "" && $forsalerent != "" && $price != "" && $userid != ""){
			$query = "INSERT INTO realestate (headline, description, url, email, contact, phone, forsalerent, price, userid, useripaddress, name, size, type, content) VALUES ('$headline', '$description', '$url', '$email', '$contact', '$phone', '$forsalerent', '$price', '$userid', '$useripaddress', '$fileName', '$fileSize', '$fileType', '$content')";
			mysqli_query($conn,$query) or die('Error, insert query failed');

            $reseturl = $_SESSION['reseturl'];
            $communityurl = $_SESSION['communityurl'];
            $fromname = "$CommunityName via CondoSites";

			$subject = "$CommunityName/CondoSites - Classifieds Submission";
		    
		    $body = "<!DOCTYPE HTML><html><body><div style='padding: 25px;'>";
            $body .= "<p>A website user has submitted a classified ad listing through the ".$CommunityName."/CondoSites community website.  Your action is required.<br>To approve and edit this listing, access the Classified Ads control panel.<br><br>Below is an overview of the ad submitted by the user.<br><br>Ad Type: ".$forsalerent."<br>Headline: ".$headline."<br>Price: ".$price."<br>Description: ".$description."<br><br>URL: ".$url."<br>Contact: ".$contact."<br>Email: ".$email."<br>Phone: ".$phone."<br><br><br>Submitted by: ".$first_name." ".$last_name."<br>User ID: ".$userid."<br>User IP Address: ".$useripaddress."</p>";
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
			$error = "ALL fields are required.\n\n";
			$success = "false";
		}
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
	$query  = "SELECT title FROM tabs WHERE `int1` = '450'";
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
	$query  = "SELECT text1 FROM forms WHERE `int1` = '450'";
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
        <div class="small-12 medium-5 large-4 columns"><label for="forsalerent" class="middle note-anchor">What type of listing?</label></div>
        <div class="small-12 medium-5 end columns">
	  <select name="forsalerent" required>
<option value="">--Select--</option>
<option value="CLASSIFIED" <?php if($_POST['forsalerent'] == "CLASSIFIED"){ echo("SELECTED"); } ?>>Classified Ad</option>
<option value="CLASSIFIED" <?php if($_POST['forsalerent'] == "SOCIAL"){ echo("SELECTED"); } ?>>Private Social Event</option>
<option value="SALE" <?php if($_POST['forsalerent'] == "SALE"){ echo("SELECTED"); } ?>>Unit For Sale</option>
<option value="RENT" <?php if($_POST['forsalerent'] == "RENT"){ echo("SELECTED"); } ?>>Unit For Rent</option>
	  </select>
        </div>
      </div>
      <div class="row medium-collapse">
        <div class="small-12 medium-5 large-4 columns"><label for="headline" class="middle note-anchor">Headline</label></div>
        <div class="small-12 medium-5 end columns"><input name="headline" type="text" size="30" maxlength="50" class="form" value="<?php echo($_POST['headline']); ?>" required></div>
      </div>
      <div class="row medium-collapse">
        <div class="small-12 medium-5 large-4 columns"><label for="price" class="middle note-anchor">Price</label></div>
        <div class="small-12 medium-5 end columns"><input name="price" type="text" size="30" maxlength="50" class="form" value="<?php echo($_POST['price']); ?>" required></div>
      </div>
			<div class="row" style="padding-bottom: 20px;">
        <div class="small-12 columns text-center">Description <span class="note-red">HTML is allowed using the Source button.</span>
					<textarea name="description" cols="30" rows="2" id="editor1" class="form" type="text" placeholder="<?php echo "{$row['description']}"; ?>" required><?php echo "{$row['description']}"; ?></textarea>
					<script>CKEDITOR.replace( 'editor1' );</script>
				</div>
      </div>
      <div class="row medium-collapse">
        <div class="small-12 medium-5 large-4 columns"><label for="userfile" class="middle note-anchor">Add a Photo (optional) <span class="note-red">1 MB Maximum, JPEG/GIF/PNG format</span></label></div>
        <div class="small-12 medium-5 end columns"><input type="hidden" name="MAX_FILE_SIZE" value="1800000"><input type="file" name="userfile" id="userfile"></div>
      </div>
      <div class="row medium-collapse">
        <div class="small-12 medium-5 large-4 columns"><label for="url" class="middle note-anchor">URL (optional) <span class="note-red">Be sure URL begins with http://</span></label></div>
        <div class="small-12 medium-5 end columns"><input name="url" type="url" size="30" maxlength="100" class="form" value="<?php echo($_POST['url']); ?>"></div>
      </div>
      <div class="row medium-collapse">
        <div class="small-12 medium-5 large-4 columns"><label for="contact" class="middle note-anchor">Contact Name</label></div>
        <div class="small-12 medium-5 end columns"><input name="contact" type="text" size="20" maxlength="50" class="form" value="<?php echo($_POST['contact']); ?>" required></div>
      </div>
      <div class="row medium-collapse">
        <div class="small-12 medium-5 large-4 columns"><label for="phone" class="middle note-anchor">Contact Phone</label></div>
        <div class="small-12 medium-5 end columns"><input name="phone" type="tel" size="15" maxlength="30" class="form" value="<?php echo($_POST['phone']); ?>" required></div>
      </div>
      <div class="row medium-collapse">
        <div class="small-12 medium-5 large-4 columns"><label for="email" class="middle note-anchor">Contact Email</label></div>
        <div class="small-12 medium-5 end columns"><input name="email" type="email" size="30" maxlength="50" class="form" value="<?php echo($_POST['email']); ?>" required></div>
      </div>

<!-- END FIELDS -->

    </div>

<!-- TERMS -->

<?php
	$query  = "SELECT terms FROM forms WHERE `int1` = '450' AND terms != ''";
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
	<input type="hidden" name="mode" value="mode" />
	<input type="submit" name="post_comment" id="post_comment" class="submit" value="Submit" onclick="document.theform.post_comment.disabled=true; document.theform.mode.name = 'post'; document.theform.submit();" />
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
	$query  = "SELECT text2 FROM forms WHERE `int1` = '450'";
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
