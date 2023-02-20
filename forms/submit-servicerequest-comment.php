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

	if ($action == "add"){

		$id = $_POST["id"];
		$module = $_POST["module"];
		$userid = $_SESSION["id"];
		$first_name = $_SESSION['first_name'];
		$last_name = $_SESSION['last_name'];
		$unit = $_SESSION['unit'];
		$unit2 = $_SESSION['unit2'];
		$phone = $_SESSION['phone'];
		$useremail = $_SESSION['email'];
		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = mysqli_real_escape_string($conn, $_POST["userid"]);
		$comment = mysqli_real_escape_string($conn, $_POST["comment"]);
		$privacy = $_POST['privacy'];
		$pte = $_POST['pte'];
		$usercomment = $_POST['usercomment'];
		$staffcomment = $_POST['staffcomment'];
		$status = $_POST["status"];
		$update_date = $_POST["update_date"];

		if($comment != ""){
			
		    $query = "INSERT INTO `comments` (`id`, `module`, `userid`, `comment`, `status`) VALUES ('$id', '$module', '$userid', '$comment', '$status')";
		    mysqli_query($conn,$query) or die('Error, insert into Comments database query failed');
		
    		$query = "UPDATE `service` SET `status`='$status', `privacy`='$privacy', `pte`='$pte', `update_date`='$update_date' WHERE `int1`=$id";
	    	mysqli_query($conn,$query) or die('Error, updating Service database query failed');
			
			$reseturl = $_SESSION['reseturl'];
            $communityurl = $_SESSION['communityurl'];
            $fromname = "$CommunityName via CondoSites";

			$subject = "$CommunityName/CondoSites - Service Request Comment";
		    
		    $body = "<!DOCTYPE HTML><html><body><div style='padding: 25px;'>";
            $body .= "<p>A user has submitted a comment to a service request through the ".$CommunityName."/CondoSites community website.  Your action is required.<br><br>Submitted by: ".$first_name." ".$last_name."<br>Unit: ".$unit." ".$unit2."<br>Phone: ".$phone."<br>Email: ".$useremail."<br><br>Comment: ".$comment."<br><br>Manage service requests here: ".$staffcomment."<br><br>User ID: ".$userid."<br>User IP Address: ".$useripaddress."</p>";
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
    
            $mail->addAddress($MAINTENANCE_EMAIL, $fromname);
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
			$error = "<br><div style='color: red;'>ALL fields are required!</div><br>";
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
	<link rel="stylesheet" href="../css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/jquery-ui.min.css">
	<link rel="stylesheet" href="../css/jquery-ui.structure.min.css">
	<link rel="stylesheet" href="../css/datepickercontrol.css">
	<link rel="stylesheet" href="../css/app.css">
	<link rel="stylesheet" href="../my-documents/app-custom.css">
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

<div class="stand-alone-page">
  <div class="popup-header">
<?php
	$query  = "SELECT title FROM tabs WHERE `int1` = '456'";
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
	$query  = "SELECT text1 FROM forms WHERE `int1` = '456'";
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
      <div class="row small-12">

<?php
	$int1 = $_POST["id"];
	$query  = "SELECT * FROM `service` WHERE `int1` = '$int1'";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<div align="center"><input type="checkbox" name="<?php echo "{$row['int1']}"; ?>" onclick="showMe('<?php echo "{$row['int1']}"; ?>', this)" /> <label for="request">Show service request and comments.</label></div>
<div id="<?php echo "{$row['int1']}"; ?>" style="display:none" class="small-12 medium-10 columns">
		    <i class="fa fa-comment" aria-hidden="true"></i>  <?php echo "{$row['description']}"; ?>

		<?php
			$userid    = $row['userid'];
			$queryUSR  = "SELECT id, unit, unit2, last_name, first_name FROM users WHERE id = '$userid'";
			$resultUSR = mysqli_query($conn,$queryUSR);

			while($rowUSR = $resultUSR->fetch_array(MYSQLI_ASSOC))
			{
		?>
		    <blockquote>
		        <small>
		            <b><?php echo "{$rowUSR['last_name']}"; ?>, <?php echo "{$rowUSR['first_name']}"; ?></a></b>
		            <?php echo "{$rowUSR['unit']}"; ?><?php if ($rowUSR['unit2'] !== 'X'){ ?><?php echo "{$rowUSR['unit2']}"; ?><?php }; ?><br>
		            <b>Open</b> <?php echo "{$row['created_date']}"; ?>
						<?php if ($row['pte'] != 'Y'){ ?><div style="color: red;"><i class="fa fa-key" aria-hidden="true" style="color: red;"></i> Permission to enter <u>NOT</u> granted!</div><?php }; ?>
						<?php if ($row['pte'] == 'Y'){ ?><div style="color: green"><i class="fa fa-key" aria-hidden="true" style="color: green;"></i> Permission to enter is granted!</div><?php }; ?>
						<?php if ($row['privacy'] != 'Y'){ ?><div><i class="fa fa-user-times" aria-hidden="true" style="color: red;" title="You are NOT sharing service request with other users in your unit."></i> You are NOT sharing service request with other users in your unit.</div><?php }; ?>
						<?php if ($row['privacy'] == 'Y'){ ?><div><i class="fa fa-users" aria-hidden="true" style="color: green;" title="You are sharing service request with other users in your unit."></i> You are sharing service request with other users in your unit.</div><?php }; ?>
				</small>
		    </blockquote>
		<?php
			}
		?>
		<?php
		    $id = $row['int1'];
			$queryCMT  = "SELECT * FROM `comments` WHERE `module` = 'service' AND `id` = '$id' ORDER BY `created_date`";
			$resultCMT = mysqli_query($conn,$queryCMT);

			while($rowCMT = $resultCMT->fetch_array(MYSQLI_ASSOC))
			{
		?>
		    <i class="fa fa-comment-o" aria-hidden="true"></i> <?php echo "{$rowCMT['comment']}"; ?>
		<?php
			$userid    = $rowCMT['userid'];
			$queryUSR  = "SELECT id, unit, unit2, last_name, first_name FROM users WHERE id = '$userid'";
			$resultUSR = mysqli_query($conn,$queryUSR);

			while($rowUSR = $resultUSR->fetch_array(MYSQLI_ASSOC))
			{
		?>
		    <blockquote>
		        <small>
		            <b><?php echo "{$rowUSR['last_name']}"; ?>, <?php echo "{$rowUSR['first_name']}"; ?></a></b>
		            <?php echo "{$rowUSR['unit']}"; ?><?php if ($rowUSR['unit2'] !== 'X'){ ?><?php echo "{$rowUSR['unit2']}"; ?><?php }; ?><br>
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
      </div>

	  <div class="row" style="padding-bottom: 20px;">
        <div class="small-12 columns text-center"><label for="comment" style="text-align: center;">Add a Comment to your Service Request</label>
    		<textarea name="comment" class="form" type="text" rows="8" placeholder="Enter a description of your service request here."><?php echo $_POST['comment']; ?></textarea>
            <label for="pte" style="text-align: center;"><input type="checkbox" name="pte" value="Y" <?php if ($row['pte'] == 'Y'){ ?>checked<?php }; ?>>&nbsp;I&nbsp;grant&nbsp;permission&nbsp;to&nbsp;enter&nbsp;my&nbsp;unit.&nbsp;(if&nbsp;applicable)</label>
            <label for="privacy" style="text-align: center;"><input type="checkbox" name="privacy" value="Y" <?php if ($row['privacy'] == 'Y'){ ?>checked<?php }; ?>>&nbsp;Allow other users in your unit to access and contribute to this service request.</label>
            <input type="hidden" name="module" value="<?php echo $_POST['module']; ?>">

    <input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">

    <?php if ($row['status'] == 'C'){ ?><input type="hidden" name="status" value="O"><?php }; ?>
    <?php if ($row['status'] != 'C'){ ?><input type="hidden" name="status" value="<?php echo "{$row['status']}"; ?>"><?php }; ?>

    <input type="hidden" name="update_date" value="<?php echo date('Y-m-d g:i:s'); ?>">
	<input name="usercomment" type="hidden" value="<?php include('../my-documents/communityurl.html'); ?>/modules/servicerequests.php">
	<input name="staffcomment" type="hidden" value="<?php include('../my-documents/communityurl.html'); ?>/control/service-comment.php?sr=<?php echo "{$row['authcode']}"; ?>&u=<?php echo "{$row['userid']}"; ?>">
	
		</div>
      </div>
<?php
	}
?>
<!-- END FIELDS -->

    </div>

<!-- TERMS -->

<?php
	$query  = "SELECT terms FROM forms WHERE `int1` = '456' AND terms != ''";
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
    <?php echo($error); ?>
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
	$query  = "SELECT text2 FROM forms WHERE `int1` = '456'";
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
