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

$int1 = $_POST["int1"];
$action = $_POST["action"];
$success = "untried";

if ($action != null){

	if ($action == "add"){

		$first_name = $_SESSION['first_name'];
		$last_name = $_SESSION['last_name'];
		$useremail = $_SESSION['email'];
		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = mysqli_real_escape_string($conn, $_POST["userid"]);
		$date = date('Y-m-d');
		$type = mysqli_real_escape_string($conn, $_POST["type"]);
		$name = mysqli_real_escape_string($conn, $_POST["name"]);
		$address = mysqli_real_escape_string($conn, $_POST["address"]);
		$phone = mysqli_real_escape_string($conn, $_POST["phone"]);
		$url = mysqli_real_escape_string($conn, $_POST["url"]);
		$email = mysqli_real_escape_string($conn, $_POST["email"]);
		$comments = mysqli_real_escape_string($conn, $_POST["comments"]);

		if($type != "" && $name != "" && $userid != ""){

			$query = "INSERT INTO concierge (userid, type, name, address, phone, url, email, comments, useripaddress) VALUES ('$userid', '$type', '$name', '$address', '$phone', '$url', '$email', '$comments', '$useripaddress')";
			mysqli_query($conn,$query) or die('Error, insert query failed');

            $reseturl = $_SESSION['reseturl'];
            $communityurl = $_SESSION['communityurl'];
            $fromname = "$CommunityName via CondoSites";

			$subject = "$CommunityName/CondoSites - Business Directory Submission";
		    
		    $body = "<!DOCTYPE HTML><html><body><div style='padding: 25px;'>";
            $body .= "<p>A website user has submitted a business directory listing through the ".$CommunityName."/CondoSites community website.  Your action is required.<br>To approve and edit this listing, access the Business Directory control panel.<br><br>Below is an overview of the ad submitted by the user.<br><br>Type: ".$type."<br>Name: ".$name."<br>Address: ".$address."<br>URL: ".$url."<br>Email: ".$email."<br>Phone: ".$phone."<br><br>Comments: ".$comments."<br><br><br>Submitted by: ".$first_name." ".$last_name."<br>User ID: ".$userid."<br>User IP Address: ".$useripaddress."</p>";
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
			$error = "Business Type and Business Name fields are required.<br><br>";
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
	$query  = "SELECT title FROM tabs WHERE `int1` = '453'";
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
	$query  = "SELECT text1 FROM forms WHERE `int1` = '453'";
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
        <div class="small-12 medium-5 large-4 columns"><label for="type" class="middle note-anchor">Business Type</label></div>
        <div class="small-12 medium-5 end columns">
	<select name="type">
<option value="">--Select--</option>
<option value="24 Hours" <?php if($_POST['type'] == "24 Hours"){ echo("SELECTED"); } ?>>Open 24 Hours</option>
<option value="Automotive" <?php if($_POST['type'] == "Automotive"){ echo("SELECTED"); } ?>>Automotive</option>
<option value="Appliance Sales and Repair" <?php if($_POST['type'] == "Appliance Sales and Repair"){ echo("SELECTED"); } ?>>Appliance Sales and Repair</option>
<option value="Banks" <?php if($_POST['type'] == "Banks"){ echo("SELECTED"); } ?>>Banks</option>
<option value="Barbers" <?php if($_POST['type'] == "Barbers"){ echo("SELECTED"); } ?>>Barbers</option>
<option value="Bars" <?php if($_POST['type'] == "Bars"){ echo("SELECTED"); } ?>>Bars</option>
<option value="Beaches" <?php if($_POST['type'] == "Beaches"){ echo("SELECTED"); } ?>>Beaches</option>
<option value="Boating" <?php if($_POST['type'] == "Boating"){ echo("SELECTED"); } ?>>Boating</option>
<option value="Carpet Cleaning" <?php if($_POST['type'] == "Carpet Cleaning"){ echo("SELECTED"); } ?>>Carpet Cleaning</option>
<option value="Casinos" <?php if($_POST['type'] == "Casinos"){ echo("SELECTED"); } ?>>Casinos</option>
<option value="Cement/Asphalt Work" <?php if($_POST['type'] == "Cement/Asphalt Work"){ echo("SELECTED"); } ?>>Cement/Asphalt Work</option>
<option value="Computers" <?php if($_POST['type'] == "Computers"){ echo("SELECTED"); } ?>>Computers</option>
<option value="Contractors" <?php if($_POST['type'] == "Contractors"){ echo("SELECTED"); } ?>>Contractors</option>
<option value="Coupons" <?php if($_POST['type'] == "Coupons"){ echo("SELECTED"); } ?>>Coupons</option>
<option value="Dentists" <?php if($_POST['type'] == "Dentists"){ echo("SELECTED"); } ?>>Dentists</option>
<option value="Doctors" <?php if($_POST['type'] == "Doctors"){ echo("SELECTED"); } ?>>Doctors</option>
<option value="Dog Walkers" <?php if($_POST['type'] == "Dog Walkers"){ echo("SELECTED"); } ?>>Dog Walkers</option>
<option value="Doors, Windows and Screens" <?php if($_POST['type'] == "Doors, Windows and Screens"){ echo("SELECTED"); } ?>>Doors Windows and Screens</option>
<option value="Dry Cleaners" <?php if($_POST['type'] == "Dry Cleaners"){ echo("SELECTED"); } ?>>Dry Cleaners</option>
<option value="Electricians" <?php if($_POST['type'] == "Electricians"){ echo("SELECTED"); } ?>>Electricians</option>
<option value="Entertainment" <?php if($_POST['type'] == "Entertainment"){ echo("SELECTED"); } ?>>Entertainment</option>
<option value="Fencing and Gates" <?php if($_POST['type'] == "Fencing and Gates"){ echo("SELECTED"); } ?>>Fencing and Gates</option>
<option value="Flooring" <?php if($_POST['type'] == "Flooring"){ echo("SELECTED"); } ?>>Flooring</option>
<option value="Food Deliveries" <?php if($_POST['type'] == "Food Deliveries"){ echo("SELECTED"); } ?>>Food Delivery</option>
<option value="Galleries" <?php if($_POST['type'] == "Galleries"){ echo("SELECTED"); } ?>>Galleries</option>
<option value="Golf" <?php if($_POST['type'] == "Golf"){ echo("SELECTED"); } ?>>Golf</option>
<option value="Grocery Stores" <?php if($_POST['type'] == "Grocery Stores"){ echo("SELECTED"); } ?>>Grocery Stores</option>
<option value="Gyms" <?php if($_POST['type'] == "Gyms"){ echo("SELECTED"); } ?>>Gyms</option>
<option value="Hair Salons" <?php if($_POST['type'] == "Hair Salons"){ echo("SELECTED"); } ?>>Hair Salons</option>
<option value="Handyman" <?php if($_POST['type'] == "Handyman"){ echo("SELECTED"); } ?>>Handyman</option>
<option value="Heating and Air Conditioning" <?php if($_POST['type'] == "Heating and Air Conditioning"){ echo("SELECTED"); } ?>>Heating and Air Conditioning</option>
<option value="Hospitals" <?php if($_POST['type'] == "Hospitals"){ echo("SELECTED"); } ?>>Hospitals</option>
<option value="Housekeepers" <?php if($_POST['type'] == "Housekeepers"){ echo("SELECTED"); } ?>>Housekeepers</option>
<option value="Housesitters" <?php if($_POST['type'] == "Housesitters"){ echo("SELECTED"); } ?>>Housesitters</option>
<option value="Kids Activities" <?php if($_POST['type'] == "Kids Activities"){ echo("SELECTED"); } ?>>Kids Activities</option>
<option value="Landscaping" <?php if($_POST['type'] == "Landscaping"){ echo("SELECTED"); } ?>>Landscaping</option>
<option value="Libraries" <?php if($_POST['type'] == "Libraries"){ echo("SELECTED"); } ?>>Libraries</option>
<option value="Local Delivery" <?php if($_POST['type'] == "Local Delivery"){ echo("SELECTED"); } ?>>Local Delivery</option>
<option value="Locksmith" <?php if($_POST['type'] == "Locksmith"){ echo("SELECTED"); } ?>>Locksmith</option>
<option value="Museums" <?php if($_POST['type'] == "Museums"){ echo("SELECTED"); } ?>>Museums</option>
<option value="Miscellaneous" <?php if($_POST['type'] == "Miscellaneous"){ echo("SELECTED"); } ?>>Miscellaneous</option>
<option value="Nearby Attractions" <?php if($_POST['type'] == "Nearby Attractions"){ echo("SELECTED"); } ?>>Nearby Attractions</option>
<option value="Newspapers" <?php if($_POST['type'] == "Newspapers"){ echo("SELECTED"); } ?>>Newspapers</option>
<option value="Painting" <?php if($_POST['type'] == "Painting"){ echo("SELECTED"); } ?>>Painting</option>
<option value="Parks" <?php if($_POST['type'] == "Parks"){ echo("SELECTED"); } ?>>Parks</option>
<option value="Party Planning" <?php if($_POST['type'] == "Party Planning"){ echo("SELECTED"); } ?>>Party Planning</option>
<option value="Patio Furniture" <?php if($_POST['type'] == "Patio Furniture"){ echo("SELECTED"); } ?>>Patio Furniture</option>
<option value="Pest Control" <?php if($_POST['type'] == "Pest Control"){ echo("SELECTED"); } ?>>Pest Control</option>
<option value="Pets" <?php if($_POST['type'] == "Pets"){ echo("SELECTED"); } ?>>Pets</option>
<option value="Pharmacies" <?php if($_POST['type'] == "Pharmacies"){ echo("SELECTED"); } ?>>Pharmacies</option>
<option value="Pizza" <?php if($_POST['type'] == "Pizza"){ echo("SELECTED"); } ?>>Pizza</option>
<option value="Plumbers" <?php if($_POST['type'] == "Plumbers"){ echo("SELECTED"); } ?>>Plumbers</option>
<option value="Pool Supplies/Service" <?php if($_POST['type'] == "Pool Supplies/Service"){ echo("SELECTED"); } ?>>Pool Supplies/Service</option>
<option value="Professionals" <?php if($_POST['type'] == "Professionals"){ echo("SELECTED"); } ?>>Professionals</option>
<option value="Rain Gutters" <?php if($_POST['type'] == "Rain Gutters"){ echo("SELECTED"); } ?>>Rain Gutters</option>
<option value="Realtors" <?php if($_POST['type'] == "Realtors"){ echo("SELECTED"); } ?>>Realtors</option>
<option value="Restaurant" <?php if($_POST['type'] == "Restaurant"){ echo("SELECTED"); } ?>>Restaurant</option>
<option value="Roofing" <?php if($_POST['type'] == "Roofing"){ echo("SELECTED"); } ?>>Roofing</option>
<option value="Schools" <?php if($_POST['type'] == "Schools"){ echo("SELECTED"); } ?>>Schools</option>
<option value="Seniors" <?php if($_POST['type'] == "Seniors"){ echo("SELECTED"); } ?>>Seniors</option>
<option value="Shopping" <?php if($_POST['type'] == "Shopping"){ echo("SELECTED"); } ?>>Shopping</option>
<option value="Shopping - Women" <?php if($_POST['type'] == "Shopping - Women"){ echo("SELECTED"); } ?>>Shopping - Women</option>
<option value="Shopping - Men" <?php if($_POST['type'] == "Shopping - Men"){ echo("SELECTED"); } ?>>Shopping - Men</option>
<option value="Sports" <?php if($_POST['type'] == "Sports"){ echo("SELECTED"); } ?>>Sports</option>
<option value="Sushi" <?php if($_POST['type'] == "Sushi"){ echo("SELECTED"); } ?>>Sushi</option>
<option value="Theaters" <?php if($_POST['type'] == "Theaters"){ echo("SELECTED"); } ?>>Theaters</option>
<option value="Tours" <?php if($_POST['type'] == "Tours"){ echo("SELECTED"); } ?>>Tours</option>
<option value="Transportation" <?php if($_POST['type'] == "Transportation"){ echo("SELECTED"); } ?>>Transportation</option>
<option value="Vendors" <?php if($_POST['type'] == "Vendors"){ echo("SELECTED"); } ?>>Vendors</option>
<option value="Walking Distance" <?php if($_POST['type'] == "Walking Distance"){ echo("SELECTED"); } ?>>Walking Distance</option>
<option value="Wineries" <?php if($_POST['type'] == "Wineries"){ echo("SELECTED"); } ?>>Wineries</option>
<option value="Window Cleaning" <?php if($_POST['type'] == "Window Cleaning"){ echo("SELECTED"); } ?>>Window Cleaning</option>
</select>
        </div>
      </div>
      <div class="row medium-collapse">
        <div class="small-12 medium-5 large-4 columns"><label for="name" class="middle note-anchor">Business Name</label></div>
        <div class="small-12 medium-5 end columns"><input name="name" type="text" size="20" maxlength="50" class="form" value="<?php echo($_POST['name']); ?>"></div>
      </div>
      <div class="row medium-collapse">
        <div class="small-12 medium-5 large-4 columns"><label for="address" class="middle note-anchor">Address (optional)</label></div>
        <div class="small-12 medium-5 end columns"><input name="address" type="text" size="30" maxlength="50" class="form" value="<?php echo($_POST['address']); ?>"></div>
      </div>
      <div class="row medium-collapse">
        <div class="small-12 medium-5 large-4 columns"><label for="phone" class="middle note-anchor">Phone (optional)</label></div>
        <div class="small-12 medium-5 end columns"><input name="phone" type="tel" size="15" maxlength="30" class="form" value="<?php echo($_POST['phone']); ?>"></div>
      </div>
      <div class="row medium-collapse">
        <div class="small-12 medium-5 large-4 columns"><label for="url" class="middle note-anchor">URL (optional) <span class="note-red">Be sure URL begins with http://</span></label></div>
        <div class="small-12 medium-5 end columns"><input name="url" type="url" size="30" maxlength="100" class="form" value="<?php echo($_POST['url']); ?>"></div>
      </div>
      <div class="row medium-collapse">
        <div class="small-12 medium-5 large-4 columns"><label for="email" class="middle note-anchor">Email (optional)</label></div>
        <div class="small-12 medium-5 end columns"><input name="email" type="email" size="30" maxlength="50" class="form" value="<?php echo($_POST['email']); ?>"></div>
      </div>
      <div class="row" style="padding-bottom: 20px;">
        <div class="small-12 columns text-center">Comments (optional) <span class="note-red">HTML is allowed.</span>
					<textarea name="comments" cols="30" rows="2" id="editor1" class="form" type="text" placeholder="<?php echo "{$row['comments']}"; ?>" required><?php echo "{$row['comments']}"; ?></textarea>
					<script>CKEDITOR.replace( 'editor1' );</script>
      </div>

<!-- FIELDS -->

    </div>

<!-- TERMS -->

<?php
	$query  = "SELECT terms FROM forms WHERE `int1` = '453' AND terms != ''";
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
	  <input type="submit" name="post_comment" id="post_comment" class="submit" value="Submit" onclick="document.theform.post_comment.disabled=true; document.theform.mode.name = 'post'; document.theform.submit();" /><br>
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
	$query  = "SELECT text2 FROM forms WHERE `int1` = '453'";
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
