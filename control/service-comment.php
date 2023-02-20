<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '/home/nodyss5/php/PHPMailer-6.3.0/src/PHPMailer.php';
require '/home/nodyss5/php/PHPMailer-6.3.0/src/SMTP.php';
require '/home/nodyss5/php/PHPMailer-6.3.0/src/Exception.php';
//require '/home/nodyss5/php/PHPMailer/PHPMailerAutoload.php';
require '../my-documents/smtp.php';

$id = $_POST["id"];
$module = $_POST["module"];
$email = "";

$current_page = '30';
include('protect.php');

if(($_POST['userid']) && ($_POST['service_email']) == "yes"){
	
	if($_POST['status'] == "I"){ $status = 'In Progress'; }
	if($_POST['status'] == "B"){ $status = 'Awaiting Board'; }
	if($_POST['status'] == "3"){ $status = 'Awaiting 3rd Party'; }
	if($_POST['status'] == "H"){ $status = 'On Hold'; }
	if($_POST['status'] == "C"){ $status = 'Closed'; }
	
	$query  = "SELECT `email`, `first_name`, `last_name`, `emailconfirm` FROM `users` WHERE `id` = ".$_POST['userid'];
	$result = mysqli_query($conn, $query);
	while($row = $result->fetch_array(MYSQLI_ASSOC)){

        $userfirst = $row['first_name'];
        $userlast = $row['last_name'];
        $username = "$userfirst $userlast";
        $useremail = $row['email'];
        $reseturl = $_SESSION['reseturl'];
        $communityurl = $_SESSION['communityurl'];
        $fromname = "$CommunityName via CondoSites";
        $emailconfirm = $row['emailconfirm'];
        
        if ($emailconfirm != 'B') {

            $body = "<!DOCTYPE HTML><html><body><div style='padding: 25px;'>";
            $body .= "<p>Dear ".$username.",</p>";
            $body .= "<p><b>A comment has been added to your service request.</b><br><br>New Status: ".$status."<br><br>Comments: ".$_POST['comment']."<br><br>To comment further, log into your community website at <a href='".$communityurl."/splash/connect-login.php' target='_blank'>".$communityurl."/splash/connect-login.php</a>, and click on the small wrench icon at the top of the page to the right of your name.</p>";
            $body .= "</div><br><img src='".$communityurl."/pics/logo-small.png' style='max-width: 100px;'><br><br><p>Visit your <a href='".$communityurl."'>".$CommunityName." community website</a>.</p>";
            $body .= "<p><b>Email Subscription</b><br><small>You are receiving this email because you are a registered user of the ".$CommunityName." community website, operated by <a href='https://condosites.com' target='_blank'>CondoSites</a>.";
            $body .= "$dnrOPS";
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
            $mail->setFrom($fromemailOPS, $fromname);

            $mail->addAddress($useremail, $username);
            $mail->Subject = "Service Request Comment - $CommunityName via CondoSites";
            $mail->Body = "$body";
            $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';

            if(!$mail->send()) {
                
            } else {
                
            }
        }
	}
}

$emailassigned = "";
if(($_POST['assigned']) && ($_POST['service_email_assigned']) == "yes"){

	if($_POST['status'] == "I"){ $status = 'In Progress'; }
	if($_POST['status'] == "B"){ $status = 'Awaiting Board'; }
	if($_POST['status'] == "3"){ $status = 'Awaiting 3rd Party'; }
	if($_POST['status'] == "H"){ $status = 'On Hold'; }
	if($_POST['status'] == "C"){ $status = 'Closed'; }

	$query  = "SELECT `email`, `first_name`, `last_name`, `emailconfirm` FROM `users` WHERE `id` = ".$_POST['assigned'];
	$result = mysqli_query($conn, $query);
	while($row = $result->fetch_array(MYSQLI_ASSOC)){

        $userfirst = $row['first_name'];
        $userlast = $row['last_name'];
        $username = "$userfirst $userlast";
        $useremail = $row['email'];
        $reseturl = $_SESSION['reseturl'];
        $communityurl = $_SESSION['communityurl'];
        $fromname = "$CommunityName via CondoSites";
        $emailconfirm = $row['emailconfirm'];

        if ($emailconfirm != 'B') {

            $body = "<!DOCTYPE HTML><html><body><div style='padding: 25px;'>";
            $body .= "<p>Dear ".$username.",</p>";
            $body .= "<b>A comment has been added to your a service request you are assigned to.</b><br><br>New Status: ".$status."<br><br>Comments: ".$_POST['comment']."<br><br>Confidential Comments: ".$_POST['confcomments']."<br><br>Confidential Comments: ".$_POST['confcomments']."<br><br>To comment further, log into your community website at <a href='".$communityurl."/splash/connect-login.php' target='_blank'>".$communityurl."/splash/connect-login.php</a>, and click on the small wrench icon at the top of the page to the right of your name.";
            $body .= "</div><br><img src='".$communityurl."/pics/logo-small.png' style='max-width: 100px;'><br><br>Visit your <a href='".$communityurl."'>".$CommunityName." community website</a>.</p>";
            $body .= "<p><b>Email Subscription</b><br><small>You are receiving this email because you are a registered user of the ".$CommunityName." community website, operated by <a href='https://condosites.com' target='_blank'>CondoSites</a>.";
            $body .= "$dnrOPS";
            $body .= "<br><br><b><a href='".$communityurl."/spamhelp.php'>Are these emails being treated as spam?</a></b></p></small></body></html>";

            $mail = new PHPMailer();

            $mail->isSMTP();
            $mail->Host = $hostOPS;
            $mail->SMTPAuth = $smtpauthOPS;
            $mail->SMTPKeepAlive = $smtpkeepaliveOPS;
            $mail->Port = $smtpportOPS;
            $mail->SMTPSecure = $smtpsecureOPS;
            $mail->Username = $usernameOPS;
            $mail->Password = $passwordOPS;
            $mail->setFrom($fromemailOPS, $fromname);

            $mail->addAddress($useremail, $username);
            $mail->Subject = "Service Request Comment - $CommunityName via CondoSites";
            $mail->Body = "$body";
            $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';

            if(!$mail->send()) {
        
            } else {

            }
                
        }
	}
}
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="CondoSites - http://www.condosites.com" name="author">
<title>Control Panel</title>
<?php include('../control/cp-head-scripts.php'); ?>
</head>
<body>
<!-- LOGO AND NAVIGATION -->
<?php include('cp-navigation.php'); ?>
<!-- END LOGO AND NAVIGATION -->
<?php $int1 = $_POST["int1"]; $action = $_POST["action"]; if ($action != null){ ?>
<?php
	if ($action == "add"){

		$userid = $_SESSION["id"];
		$comment = htmlspecialchars($_POST['comment'], ENT_QUOTES);
		$confcomments = htmlspecialchars($_POST['confcomments'], ENT_QUOTES);
		$status = $_POST["status"];
		$type = $_POST["type"];
		$update_date = $_POST["update_date"];
		$assigned = $_POST["assigned"];
		$serviceflex1 = $_POST["serviceflex1"];
		$serviceflex2 = $_POST["serviceflex2"];
		$serviceflex3 = $_POST["serviceflex3"];
		$serviceflex4 = $_POST["serviceflex4"];
		$serviceflex5 = $_POST["serviceflex5"];

		$query = "INSERT INTO `comments` (`id`, `module`, `userid`, `comment`, `confcomments`, `status`) VALUES ('$id', '$module', '$userid', '$comment', '$confcomments', '$status')";
		mysqli_query($conn,$query) or die('Error, insert into Comments database query failed');
		
		$query = "UPDATE `service` SET `status`='$status', `update_date`='$update_date', `type`='$type', `assigned`='$assigned', `serviceflex1`='$serviceflex1', `serviceflex2`='$serviceflex2', `serviceflex3`='$serviceflex3', `serviceflex4`='$serviceflex4', `serviceflex5`='$serviceflex5' WHERE `int1`=$id";
		mysqli_query($conn,$query) or die('Error, updating Service database query failed');
		
		header('Location: service.php');
	}
	
}
?>
<br>
<div style="max-width: 99%;">
<div class="nav-section-header-cp">
        <strong>Add a Comment or Action</strong>
</div>
<?php
	$query  = "SELECT * FROM service WHERE `int1`='$id' LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- UPLOAD FORM -->
<div class="cp-form-container">
<!-- COLUMN 1 -->
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 0px 0px;">
            <div class="small-12 medium-12 columns"><strong>Original Service Request</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 columns">

<blockquote>
    <?php if ($row['pte'] != 'Y'){ ?><div style="color: red;"><i class="fa fa-key" aria-hidden="true" style="color: red;"></i> Permission to enter <u>NOT</u> granted!</div><?php }; ?>
    <?php if ($row['pte'] == 'Y'){ ?><div style="color: green"><i class="fa fa-key" aria-hidden="true" style="color: green;"></i> Permission to enter is granted!</div><?php }; ?>
    <i class="fa fa-comment" aria-hidden="true"></i>  <?php echo "{$row['description']}"; ?>
    <?php if ($row['confcomments'] != ''){ ?><div style="color: red;"><i class="fa fa-comment" aria-hidden="true" style="color: red;"></i></label>  <?php echo "{$row['confcomments']}"; ?></div><?php }; ?>

<?php
	$userid    = $row['userid'];
	$queryUSR  = "SELECT `id`, `unit`, `unit2`, `last_name`, `first_name` FROM `users` WHERE id = '$userid'";
	$resultUSR = mysqli_query($conn,$queryUSR);

	while($rowUSR = $resultUSR->fetch_array(MYSQLI_ASSOC))
	{
?>
    <blockquote>
        <small><b><?php echo "{$rowUSR['last_name']}"; ?>, <?php echo "{$rowUSR['first_name']}"; ?></a></b></small> 
        <small><?php echo "{$rowUSR['unit']}"; ?><?php if ($rowUSR['unit2'] !== 'X'){ ?><?php echo "{$rowUSR['unit2']}"; ?><?php }; ?></small><br>
        <small><b>Open</b> <?php echo "{$row['created_date']}"; ?></small>
    </blockquote>
<?php
	}
?>

</blockquote>

            </div>
        </div>
        <div class="row" style="padding: 10px 10px 0px 0px;">
            <div class="small-12 medium-12 columns"><strong>Comments and Actions</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 columns">
<?php
    $id    = $row['int1'];
	$queryCMT  = "SELECT * FROM `comments` WHERE `module` = 'service' AND `id` = '$id' ORDER BY `created_date`";
	$resultCMT = mysqli_query($conn,$queryCMT);

	while($rowCMT = $resultCMT->fetch_array(MYSQLI_ASSOC))
	{
?>
<blockquote>
    <i class="fa fa-comment-o" aria-hidden="true"></i> <?php echo "{$rowCMT['comment']}"; ?>
    <?php if ($rowCMT['confcomments'] != ''){ ?><div style="color: red;"><i class="fa fa-comment-o" aria-hidden="true" style="color: red;"></i></label>  <?php echo "{$rowCMT['confcomments']}"; ?></div><?php }; ?>
<?php
	$userid    = $rowCMT['userid'];
	$queryUSR  = "SELECT id, unit, unit2, last_name, first_name FROM users WHERE id = '$userid'";
	$resultUSR = mysqli_query($conn,$queryUSR);

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
</blockquote>
<?php
	}
?>

            </div>
        </div>
    </div>
<!-- END COLUMN 1 -->
<!-- COLUMN 2 -->
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 0px 0px;">
<form enctype="multipart/form-data" method="POST" action="service-comment.php">
            <div class="small-12 medium-12 columns"><strong>1) Update Linked User</strong></div>
        </div>
        <div class="row medium-collapse" style="padding: 10px 10px 10px 30px;">
            <div class="small-12 medium-12 columns">
<?php include('userid-field-edit.php'); ?>
                <label for="email_confirmation" class="middle" style="margin-bottom: -15px;">
                    <input type="checkbox" name="service_email" value="yes" checked> Send email to user?&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Valid only for registered users.</span>
                </label>
            </div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>2) Update Service Request Information</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-6 columns"><label for="category" class="middle">Select general category</label></div>
            <div class="small-12 medium-6 end columns">
<?php include('../my-documents/service-categories.php'); ?>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-6 columns"><label for="category" class="middle">Assign this Service Request to...</span></label></div>
            <div class="small-12 medium-6 end columns">
<select name="assigned">
<?php
	$type    = $row['assigned'];
	$query1  = "SELECT `id`, `unit`, `unit2`, `last_name`, `first_name`, `email`, `phone`, `emailconfirm` FROM `users` WHERE id = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php if ($row['assigned'] >= '1'){ ?><option value="<?php echo "{$row1['id']}"; ?>"><?php echo "{$row1['last_name']}"; ?>, <?php echo "{$row1['first_name']}"; ?> (<?php echo "{$row1['unit']}"; ?><?php if ($row1['unit2'] !== 'X'){ ?> - <?php echo "{$row1['unit2']}"; ?><?php }; ?>)  <?php if ($row1['emailconfirm'] == 'B'){ ?> This user&apos;s email address is bouncing!<?php }; ?></option><?php }; ?>
<?php if ($row['assigned'] <= '1'){ ?><option value="">None</option><?php }; ?>
<option value="" disabled></option>
<?php
	}
?>
<option value="">None</option>
<option value="" disabled></option>
<?php
	$query  = "SELECT `id`, `last_name`, `first_name`, `unit`, `unit2`, `emailconfirm` FROM `users` WHERE `ghost` != 'Y' AND `status` != 'disabled' AND (`board` = true OR `concierge` = true OR `liaison` = true OR `webmaster` = true) ORDER BY `last_name`";
	$result = mysqli_query($conn, $query);

	while($row1 = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$row1['id']}"; ?>"><?php echo "{$row1['last_name']}"; ?>, <?php echo "{$row1['first_name']}"; ?> (<?php echo "{$row1['unit']}"; ?><?php if ($row1['unit2'] !== 'X'){ ?> - <?php echo "{$row1['unit2']}"; ?><?php }; ?>)  <?php if ($row1['emailconfirm'] == 'B'){ ?> This user&apos;s email address is bouncing!<?php }; ?></option>
<?php
	}
?>
</select>
<label for="email_confirmation_assigned" class="middle"><input type="checkbox" name="service_email_assigned" value="yes" checked> Send email to assigned user?</span></label>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">

<?php
	$query  = "SELECT `serviceflex1`, `serviceflex2`, `serviceflex3`, `serviceflex4`, `serviceflex5` FROM service WHERE `int1`='$id' LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php include('../my-documents/service-flex-control.php'); ?>
<?php
	}
?>

        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>3) Service Request Comment</strong></div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 columns">
                <label for="comment" class="middle">Add New Comment&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Comments <b>ARE</b> visible to the user.</span></label>
                <textarea name="comment" class="form" type="text" rows="6" placeholder="Enter Comments here – accessible by the user." required></textarea>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 columns">
                <label for="confcomments" class="middle">Add a Confidential Comment&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Confidential comments are <b>NOT</b> visible to the user.</span></label>
                <textarea name="confcomments" class="form" type="text" rows="3" placeholder="Enter CONFIDENTIAL comments here - NOT accessible by the user."></textarea>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-6 columns"><label for="status" class="middle">Update Status</label></div>
            <div class="small-12 medium-6 end columns">
        <select name="status" required>
<option value="">Select Status</option>
<option value="I">In Progress</option>
<option value="B">Awaiting Board</option>
<option value="3">Awaiting 3rd Party</option>
<option value="H">On Hold</option>
<option value="C">Closed</option>
        </select>
            </div>
        </div>
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 medium-12 columns"><strong>4) Ready to Save?</strong></div>
        </div>
        <div class="row medium-collapse">
            <div class="small-6 columns" align="center">
                <input type="hidden" name="module" value="<?php echo $_POST['module']; ?>">
                <input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
                <input type="hidden" name="update_date" value="<?php echo date('Y-m-d G:i:s'); ?>">
                <input type="hidden" name="action" value="add">
	            <input name="submit" value="Submit" class="submit" type="submit" onclick="value='Processing Request - Resubmit'; style='color:red';" />
                <?php echo($error); ?>
</form>
            </div>
            <div class="small-6 end columns" align="center">
<form action="service.php" method="get">
	            <input type="submit" value="Cancel" onclick="return confirm('Are you sure you wish to leave this page? Unsaved changes will be lost.');">
</form>
            </div>
        </div>
    </div>
<!-- COLUMN 2 -->
</div>
<!-- END UPLOAD FORM -->
<?php
	}
?>
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Service Request Comment Control Panel Page<br></div>
</body>
</html>
