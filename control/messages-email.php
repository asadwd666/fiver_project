<?php $current_page = '20'; include('protect.php');

require '../my-documents/smtp.php';

$int1 = $_POST["int1"];
$action = $_POST["action"];
$success = "untried";

if($action == "email_message"){
    
    $status = 'P';
	$date = date('Y-m-d H:i:s');
	$query = "UPDATE `messages` SET `status`='$status', `date`='$date' WHERE `int1` = '$int1' LIMIT 1";
	$result = mysqli_query($conn,$query) or die('Error, insert query failed');
    
    include('messages-script.php');
    
    header('Location: messages.php');
    
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="CondoSites - http://www.condosites.com" name="author">
<title>Control Panel</title>
<?php include('../control/cp-head-scripts.php'); ?>
</head>
<body>
<!-- LOGO AND NAVIGATION -->
<?php include('cp-navigation.php'); ?>
<!-- END LOGO AND NAVIGATION -->
<br>
<div style="max-width: 99%;">
<!-- INPUT FORM -->
<?php
	$query  = "SELECT * FROM messages WHERE `int1` = '$int1'";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

?>
	<div class="nav-section-header-cp">
		<strong>Preview Message for Email</strong>
	</div>
<!-- EMAIL FORM INFORMATION -->
	<div class="cp-form-container">
		<!-- COLUMN 1 -->
		<div class="small-12 medium-12 large-6 columns">
			<div class="row" style="padding: 10px 10px 0px 0px;">
<form enctype="multipart/form-data" method="POST">
				<div class="small-12 medium-12 columns"><strong>1) Review the body of the email...</strong></div>
			</div>
				<div class="row medium-collapse">
					<div class="small-12 medium-12 columns" style="padding: 30px; background-color: white; margin-top: 10px;">
						<?php include('messages-email-body-preview.php'); ?>
					</div>
					<div class="small-12 medium-12 columns">
						<label><br>HTML Output<?php if ($_SESSION['webmaster'] == '1'){ ?><br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Field is editable for Webmaster.</span><?php }; ?></label>
						<textarea <?php if ($_SESSION['webmaster'] == '0'){ ?>readonly<?php }; ?> name="messagebody" cols="80" rows="5"><?php include('messages-email-body.php'); ?></textarea>
					</div>
				</div>
			</div>
			<!-- END COLUMN 1 -->
			<!-- COLUMN 2 -->
			<div class="small-12 medium-12 large-6 columns">
				<div class="row" style="padding: 10px 10px 0px 0px;">
					<div class="small-12 medium-12 columns"><strong>2) Review the From, To, and CC...</strong></div>
				</div>
			    <div class="row medium-collapse" style="padding-left: 30px;">
				<div class="small-12 medium-6 columns"><label for="from" class="middle">What is the From Address:</label></div>
					<div class="small-12 medium-6 end columns">messages@condosites.net</div>
				</div>
			    <div class="row medium-collapse" style="padding-left: 30px;">
				<div class="small-12 medium-6 columns"><label for="from" class="middle">What is the Reply-To Address:</label></div>
					<div class="small-12 medium-6 end columns"><?php echo "{$row['from']}"; ?><input name="from" type="hidden" size="1" class="form" value="<?php echo "{$row['from']}"; ?>"></div>
				</div>
				<div class="row medium-collapse" style="padding-left: 30px;">
					<div class="small-12 medium-6 columns"><label for="subject" class="middle">The subject of the email:</label></div>
					<div class="small-12 medium-6 end columns"><?php echo "{$CommunityName}"; ?> - <?php echo "{$row['subject']}"; ?><input name="subject" type="hidden" size="1" class="subject" value="<?php echo "{$CommunityName}"; ?> - <?php echo "{$row['subject']}"; ?>"></div>
				</div>
				<div class="row" style="padding: 10px 10px 0px 0px;">
					<div class="small-12 medium-12 columns"><strong>3) Review who is receiving this email...</strong></div>
				</div>
        <?php if ($row['cc'] != ''){ ?>
				<div class="row medium-collapse" style="padding-left: 30px;">
					<div class="small-12 medium-6 columns"><label for="cc" class="middle">This email is being sent to an individual:</label></div>
					<div class="small-12 medium-6 end columns">
<?php
	$type    = $row['cc'];
	$query1  = "SELECT id, unit, unit2, last_name, first_name, email, phone FROM users WHERE id = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
?>
<?php echo "{$row1['last_name']}"; ?>, <?php echo "{$row1['first_name']}"; ?> (<?php echo "{$row1['unit']}"; ?><?php if ($row1['unit2'] !== 'X'){ ?> - <?php echo "{$row1['unit2']}"; ?><?php }; ?>)
<?php
	}
?>
					</div>
				</div>
        <?php }; ?>

		<?php if ($row['cc'] == ''){ ?>
				<div class="row medium-collapse" style="padding-left: 30px;">
					<div class="small-12 medium-6 columns"><label for="flag" class="middle">Email priority setting:</label></div>
					<div class="small-12 medium-6 end columns">
						<label for="flag" class="middle">
							<?php if($row['flag'] == 'A'){ ?><b>Standard</b><?php }; ?>
                            <?php if($row['flag'] == 'U'){ ?><b>Urgent</b><?php }; ?>
                            <input name="flag" type="hidden" size="1" class="flag" value="<?php echo "{$row['flag']}"; ?>">
						</label>
					</div>
				</div>
				<div class="row medium-collapse" style="padding-left: 30px;">
					<div class="small-12 medium-6 columns"><label for="unit2" class="middle">Send email to:</label></div>
					<div class="small-12 medium-6 end columns">
					    <?php if($row['owner'] == 'N' AND $row['lease'] == 'N' AND $row['realtor'] == 'N'){ ?><b>NONE - No Audience Selected</b><?php }; ?>
					    <?php if($row['unit2'] != 'X'){ ?><?php echo "{$row['unit2']}"; ?>&nbsp;<?php }; ?>
					    <?php if($row['owner'] == 'Y'){ ?>Owners&nbsp;<?php }; ?>
                        <?php if($row['lease'] == 'Y'){ ?>Renters&nbsp;<?php }; ?>
                        <?php if($row['realtor'] == 'Y'){ ?>Realtors&nbsp;<?php }; ?>
					</div>
				</div>
				<div class="row medium-collapse" style="padding-left: 30px;">
					<div class="small-12 medium-12 columns"><label for="message" class="middle">Addresses this email will be sent to:</label>
<!-- EMAIL ADDRESSES -->
<textarea readonly cols="50" rows="15" type="hidden">
******************************************
All Other Email Addresses
******************************************
<?php if ($row['owner'] == 'Y'){ ?>
<?php
    $streetfilter = $row['unit2'];
    $streetstring = ''; if ($row['unit2'] != 'X') {$streetstring = "AND `unit2` = '$streetfilter' ";}
    $club1string = ''; if ($row['club1'] == 'Y') {$club1string = "AND `club1` = 'Y' ";}
    $club2string = ''; if ($row['club2'] == 'Y') {$club2string = "AND `club2` = 'Y' ";}
    $club3string = ''; if ($row['club3'] == 'Y') {$club3string = "AND `club3` = 'Y' ";}
    $club4string = ''; if ($row['club4'] == 'Y') {$club4string = "AND `club4` = 'Y' ";}
    $club5string = ''; if ($row['club5'] == 'Y') {$club5string = "AND `club5` = 'Y' ";}
    $flagstring = ''; if ($row['flag'] == 'U') {$flagstring = "AND (ghost != 'Y' AND ghost != 'N') ";} else if ($row['flag'] == 'A') {$flagstring = "AND (`ghost` != 'Y' AND `ghost` != 'N' AND `ghost` != 'U') ";}
    $filter = "AND (`email` NOT LIKE '%att.net' AND `email` NOT LIKE '%ameritech.net' AND `email` NOT LIKE '%bellsouth.net' AND `email` NOT LIKE '%flash.net' AND `email` NOT LIKE '%nvbell.net' AND `email` NOT LIKE '%pacbell.net' AND `email` NOT LIKE '%prodigy.net' AND `email` NOT LIKE '%sbcglobal.net' AND `email` NOT LIKE '%snet.net' AND `email` NOT LIKE '%swbell.net' AND `email` NOT LIKE '%wans.net' AND `email` NOT LIKE '%@yahoo.%' AND `email` NOT LIKE '%@aol.%' AND `email` NOT LIKE '%@verizon.%' AND `email` NOT LIKE '%@comcast.%' AND `email` NOT LIKE '%@gmail.%' AND `email` NOT LIKE '%@hotmail.%' AND `email` NOT LIKE '%@live.%' AND `email` NOT LIKE '%@msn.%' AND `email` NOT LIKE '%@outlook.%' AND `email` NOT LIKE '%@microsoft.%' AND `email` NOT LIKE '%@mac.%' AND `email` NOT LIKE '%@me.%' AND `email` NOT LIKE '%@icloud.%')";
    
	$queryEMAIL  = "SELECT `email` FROM `users` WHERE `status` = 'active' AND `owner` = '1' ". $club1string." ". $club2string." ". $club3string." ". $club4string." ". $club5string." ".$flagstring." ".$streetstring." ".$filter." ";
    $resultEMAIL = mysqli_query($conn,$queryEMAIL);

	while($rowEMAIL = $resultEMAIL->fetch_array(MYSQLI_ASSOC))
	{
?><?php echo "{$rowEMAIL['email']}"; ?>, <?php	}?>
<?php	}?>
<?php if ($row['lease'] == 'Y' && $row['owner'] == 'N'  && $row['realtor'] == 'N'){ ?>
<?php
    $streetfilter = $row['unit2'];
    $streetstring = ''; if ($row['unit2'] != 'X') {$streetstring = "AND `unit2` = '$streetfilter' ";}
    $club1string = ''; if ($row['club1'] == 'Y') {$club1string = "AND `club1` = 'Y' ";}
    $club2string = ''; if ($row['club2'] == 'Y') {$club2string = "AND `club2` = 'Y' ";}
    $club3string = ''; if ($row['club3'] == 'Y') {$club3string = "AND `club3` = 'Y' ";}
    $club4string = ''; if ($row['club4'] == 'Y') {$club4string = "AND `club4` = 'Y' ";}
    $club5string = ''; if ($row['club5'] == 'Y') {$club5string = "AND `club5` = 'Y' ";}
    $flagstring = ''; if ($row['flag'] == 'U') {$flagstring = "AND (ghost != 'Y' AND ghost != 'N') ";} else if ($row['flag'] == 'A') {$flagstring = "AND (`ghost` != 'Y' AND `ghost` != 'N' AND `ghost` != 'U') ";}
    $filter = "AND (`email` NOT LIKE '%att.net' AND `email` NOT LIKE '%ameritech.net' AND `email` NOT LIKE '%bellsouth.net' AND `email` NOT LIKE '%flash.net' AND `email` NOT LIKE '%nvbell.net' AND `email` NOT LIKE '%pacbell.net' AND `email` NOT LIKE '%prodigy.net' AND `email` NOT LIKE '%sbcglobal.net' AND `email` NOT LIKE '%snet.net' AND `email` NOT LIKE '%swbell.net' AND `email` NOT LIKE '%wans.net' AND `email` NOT LIKE '%@yahoo.%' AND `email` NOT LIKE '%@aol.%' AND `email` NOT LIKE '%@verizon.%' AND `email` NOT LIKE '%@comcast.%' AND `email` NOT LIKE '%@gmail.%' AND `email` NOT LIKE '%@hotmail.%' AND `email` NOT LIKE '%@live.%' AND `email` NOT LIKE '%@msn.%' AND `email` NOT LIKE '%@outlook.%' AND `email` NOT LIKE '%@microsoft.%' AND `email` NOT LIKE '%@mac.%' AND `email` NOT LIKE '%@me.%' AND `email` NOT LIKE '%@icloud.%')";
    
	$queryEMAIL  = "SELECT `email` FROM `users` WHERE `status` = 'active' AND `lease` = '1' ". $club1string." ". $club2string." ". $club3string." ". $club4string." ". $club5string." ".$flagstring." ".$streetstring." ".$filter." ";
    $resultEMAIL = mysqli_query($conn,$queryEMAIL);

	while($rowEMAIL = $resultEMAIL->fetch_array(MYSQLI_ASSOC))
	{
?><?php echo "{$rowEMAIL['email']}"; ?>, <?php	}?>
<?php	}?>
<?php if ($row['realtor'] == 'Y' && $row['owner'] == 'N'  && $row['lease'] == 'N'){ ?>
<?php
    $streetfilter = $row['unit2'];
    $streetstring = ''; if ($row['unit2'] != 'X') {$streetstring = "AND `unit2` = '$streetfilter' ";}
    $club1string = ''; if ($row['club1'] == 'Y') {$club1string = "AND `club1` = 'Y' ";}
    $club2string = ''; if ($row['club2'] == 'Y') {$club2string = "AND `club2` = 'Y' ";}
    $club3string = ''; if ($row['club3'] == 'Y') {$club3string = "AND `club3` = 'Y' ";}
    $club4string = ''; if ($row['club4'] == 'Y') {$club4string = "AND `club4` = 'Y' ";}
    $club5string = ''; if ($row['club5'] == 'Y') {$club5string = "AND `club5` = 'Y' ";}
    $flagstring = ''; if ($row['flag'] == 'U') {$flagstring = "AND (ghost != 'Y' AND ghost != 'N') ";} else if ($row['flag'] == 'A') {$flagstring = "AND (`ghost` != 'Y' AND `ghost` != 'N' AND `ghost` != 'U') ";}
    $filter = "AND (`email` NOT LIKE '%att.net' AND `email` NOT LIKE '%ameritech.net' AND `email` NOT LIKE '%bellsouth.net' AND `email` NOT LIKE '%flash.net' AND `email` NOT LIKE '%nvbell.net' AND `email` NOT LIKE '%pacbell.net' AND `email` NOT LIKE '%prodigy.net' AND `email` NOT LIKE '%sbcglobal.net' AND `email` NOT LIKE '%snet.net' AND `email` NOT LIKE '%swbell.net' AND `email` NOT LIKE '%wans.net' AND `email` NOT LIKE '%@yahoo.%' AND `email` NOT LIKE '%@aol.%' AND `email` NOT LIKE '%@verizon.%' AND `email` NOT LIKE '%@comcast.%' AND `email` NOT LIKE '%@gmail.%' AND `email` NOT LIKE '%@hotmail.%' AND `email` NOT LIKE '%@live.%' AND `email` NOT LIKE '%@msn.%' AND `email` NOT LIKE '%@outlook.%' AND `email` NOT LIKE '%@microsoft.%' AND `email` NOT LIKE '%@mac.%' AND `email` NOT LIKE '%@me.%' AND `email` NOT LIKE '%@icloud.%')";
    
	$queryEMAIL  = "SELECT `email` FROM `users` WHERE `status` = 'active' AND `realtor` = '1' ". $club1string." ". $club2string." ". $club3string." ". $club4string." ". $club5string." ".$flagstring." ".$streetstring." ".$filter." ";;
    $resultEMAIL = mysqli_query($conn,$queryEMAIL);

	while($rowEMAIL = $resultEMAIL->fetch_array(MYSQLI_ASSOC))
	{
?><?php echo "{$rowEMAIL['email']}"; ?>, <?php	}?>
<?php	}?>



******************************************
Apple Email Addresses
(@icloud, @mac, @me)
******************************************
<?php if ($row['owner'] == 'Y'){ ?>
<?php
    $streetfilter = $row['unit2'];
    $streetstring = ''; if ($row['unit2'] != 'X') {$streetstring = "AND `unit2` = '$streetfilter' ";}
    $club1string = ''; if ($row['club1'] == 'Y') {$club1string = "AND `club1` = 'Y' ";}
    $club2string = ''; if ($row['club2'] == 'Y') {$club2string = "AND `club2` = 'Y' ";}
    $club3string = ''; if ($row['club3'] == 'Y') {$club3string = "AND `club3` = 'Y' ";}
    $club4string = ''; if ($row['club4'] == 'Y') {$club4string = "AND `club4` = 'Y' ";}
    $club5string = ''; if ($row['club5'] == 'Y') {$club5string = "AND `club5` = 'Y' ";}
    $flagstring = ''; if ($row['flag'] == 'U') {$flagstring = "AND (ghost != 'Y' AND ghost != 'N') ";} else if ($row['flag'] == 'A') {$flagstring = "AND (`ghost` != 'Y' AND `ghost` != 'N' AND `ghost` != 'U') ";}
    $filter = "AND (`email` LIKE '%@mac.%' OR `email` LIKE '%@me.%' OR `email` LIKE '%@icloud.%')";
    
	$queryEMAIL  = "SELECT `email` FROM `users` WHERE `status` = 'active' AND `owner` = '1' ". $club1string." ". $club2string." ". $club3string." ". $club4string." ". $club5string." ".$flagstring." ".$streetstring." ".$filter." ";
    
	$resultEMAIL = mysqli_query($conn,$queryEMAIL);

	while($rowEMAIL = $resultEMAIL->fetch_array(MYSQLI_ASSOC))
	{
?><?php echo "{$rowEMAIL['email']}"; ?>, <?php	}?>
<?php	}?>
<?php if ($row['lease'] == 'Y'){ ?>
<?php
    $streetfilter = $row['unit2'];
    $streetstring = ''; if ($row['unit2'] != 'X') {$streetstring = "AND `unit2` = '$streetfilter' ";}
    $club1string = ''; if ($row['club1'] == 'Y') {$club1string = "AND `club1` = 'Y' ";}
    $club2string = ''; if ($row['club2'] == 'Y') {$club2string = "AND `club2` = 'Y' ";}
    $club3string = ''; if ($row['club3'] == 'Y') {$club3string = "AND `club3` = 'Y' ";}
    $club4string = ''; if ($row['club4'] == 'Y') {$club4string = "AND `club4` = 'Y' ";}
    $club5string = ''; if ($row['club5'] == 'Y') {$club5string = "AND `club5` = 'Y' ";}
    $flagstring = ''; if ($row['flag'] == 'U') {$flagstring = "AND (ghost != 'Y' AND ghost != 'N') ";} else if ($row['flag'] == 'A') {$flagstring = "AND (`ghost` != 'Y' AND `ghost` != 'N' AND `ghost` != 'U') ";}
    $filter = "AND (`email` LIKE '%@mac.%' OR `email` LIKE '%@me.%' OR `email` LIKE '%@icloud.%')";
    
	$queryEMAIL  = "SELECT `email` FROM `users` WHERE `status` = 'active' AND `lease` = '1' ". $club1string." ". $club2string." ". $club3string." ". $club4string." ". $club5string." ".$flagstring." ".$streetstring." ".$filter." ";
    
	$resultEMAIL = mysqli_query($conn,$queryEMAIL);

	while($rowEMAIL = $resultEMAIL->fetch_array(MYSQLI_ASSOC))
	{
?><?php echo "{$rowEMAIL['email']}"; ?>, <?php	}?>
<?php	}?>
<?php if ($row['realtor'] == 'Y'){ ?>
<?php
    $streetfilter = $row['unit2'];
    $streetstring = ''; if ($row['unit2'] != 'X') {$streetstring = "AND `unit2` = '$streetfilter' ";}
    $club1string = ''; if ($row['club1'] == 'Y') {$club1string = "AND `club1` = 'Y' ";}
    $club2string = ''; if ($row['club2'] == 'Y') {$club2string = "AND `club2` = 'Y' ";}
    $club3string = ''; if ($row['club3'] == 'Y') {$club3string = "AND `club3` = 'Y' ";}
    $club4string = ''; if ($row['club4'] == 'Y') {$club4string = "AND `club4` = 'Y' ";}
    $club5string = ''; if ($row['club5'] == 'Y') {$club5string = "AND `club5` = 'Y' ";}
    $flagstring = ''; if ($row['flag'] == 'U') {$flagstring = "AND (ghost != 'Y' AND ghost != 'N') ";} else if ($row['flag'] == 'A') {$flagstring = "AND (`ghost` != 'Y' AND `ghost` != 'N' AND `ghost` != 'U') ";}
    $filter = "AND (`email` LIKE '%@mac.%' OR `email` LIKE '%@me.%' OR `email` LIKE '%@icloud.%')";
    
	$queryEMAIL  = "SELECT `email` FROM `users` WHERE `status` = 'active' AND `realtor` = '1' ". $club1string." ". $club2string." ". $club3string." ". $club4string." ". $club5string." ".$flagstring." ".$streetstring." ".$filter." ";;
    
	$resultEMAIL = mysqli_query($conn,$queryEMAIL);

	while($rowEMAIL = $resultEMAIL->fetch_array(MYSQLI_ASSOC))
	{
?><?php echo "{$rowEMAIL['email']}"; ?>, <?php	}?>
<?php	}?>



******************************************
AT&T Email Addresses
(@att.net, @ameritech.net, @bellsouth.net, @flash.net, @nvbell.net, @pacbell.net, @prodigy.net, @sbcglobal.net, @snet.net, @swbell.net, @wans.net)
******************************************
<?php if ($row['owner'] == 'Y'){ ?>
<?php
    $streetfilter = $row['unit2'];
    $streetstring = ''; if ($row['unit2'] != 'X') {$streetstring = "AND `unit2` = '$streetfilter' ";}
    $club1string = ''; if ($row['club1'] == 'Y') {$club1string = "AND `club1` = 'Y' ";}
    $club2string = ''; if ($row['club2'] == 'Y') {$club2string = "AND `club2` = 'Y' ";}
    $club3string = ''; if ($row['club3'] == 'Y') {$club3string = "AND `club3` = 'Y' ";}
    $club4string = ''; if ($row['club4'] == 'Y') {$club4string = "AND `club4` = 'Y' ";}
    $club5string = ''; if ($row['club5'] == 'Y') {$club5string = "AND `club5` = 'Y' ";}
    $flagstring = ''; if ($row['flag'] == 'U') {$flagstring = "AND (ghost != 'Y' AND ghost != 'N') ";} else if ($row['flag'] == 'A') {$flagstring = "AND (`ghost` != 'Y' AND `ghost` != 'N' AND `ghost` != 'U') ";}
    $filter = "AND (`email` LIKE '%att.net' OR `email` LIKE '%ameritech.net' OR `email` LIKE '%bellsouth.net' OR `email` LIKE '%flash.net' OR `email` LIKE '%nvbell.net' OR `email` LIKE '%pacbell.net' OR `email` LIKE '%prodigy.net' OR `email` LIKE '%sbcglobal.net' OR `email` LIKE '%snet.net' OR `email` LIKE '%swbell.net' OR `email` LIKE '%wans.net')";
    
	$queryEMAIL  = "SELECT `email` FROM `users` WHERE `status` = 'active' AND `owner` = '1' ". $club1string." ". $club2string." ". $club3string." ". $club4string." ". $club5string." ".$flagstring." ".$streetstring." ".$filter." ";
    
	$resultEMAIL = mysqli_query($conn,$queryEMAIL);

	while($rowEMAIL = $resultEMAIL->fetch_array(MYSQLI_ASSOC))
	{
?><?php echo "{$rowEMAIL['email']}"; ?>, <?php	}?>
<?php	}?>
<?php if ($row['lease'] == 'Y'){ ?>
<?php
    $streetfilter = $row['unit2'];
    $streetstring = ''; if ($row['unit2'] != 'X') {$streetstring = "AND `unit2` = '$streetfilter' ";}
    $club1string = ''; if ($row['club1'] == 'Y') {$club1string = "AND `club1` = 'Y' ";}
    $club2string = ''; if ($row['club2'] == 'Y') {$club2string = "AND `club2` = 'Y' ";}
    $club3string = ''; if ($row['club3'] == 'Y') {$club3string = "AND `club3` = 'Y' ";}
    $club4string = ''; if ($row['club4'] == 'Y') {$club4string = "AND `club4` = 'Y' ";}
    $club5string = ''; if ($row['club5'] == 'Y') {$club5string = "AND `club5` = 'Y' ";}
    $flagstring = ''; if ($row['flag'] == 'U') {$flagstring = "AND (ghost != 'Y' AND ghost != 'N') ";} else if ($row['flag'] == 'A') {$flagstring = "AND (`ghost` != 'Y' AND `ghost` != 'N' AND `ghost` != 'U') ";}
    $filter = "AND (`email` LIKE '%att.net' OR `email` LIKE '%ameritech.net' OR `email` LIKE '%bellsouth.net' OR `email` LIKE '%flash.net' OR `email` LIKE '%nvbell.net' OR `email` LIKE '%pacbell.net' OR `email` LIKE '%prodigy.net' OR `email` LIKE '%sbcglobal.net' OR `email` LIKE '%snet.net' OR `email` LIKE '%swbell.net' OR `email` LIKE '%wans.net')";
    
	$queryEMAIL  = "SELECT `email` FROM `users` WHERE `status` = 'active' AND `lease` = '1' ". $club1string." ". $club2string." ". $club3string." ". $club4string." ". $club5string." ".$flagstring." ".$streetstring." ".$filter." ";
    
	$resultEMAIL = mysqli_query($conn,$queryEMAIL);

	while($rowEMAIL = $resultEMAIL->fetch_array(MYSQLI_ASSOC))
	{
?><?php echo "{$rowEMAIL['email']}"; ?>, <?php	}?>
<?php	}?>
<?php if ($row['realtor'] == 'Y'){ ?>
<?php
    $streetfilter = $row['unit2'];
    $streetstring = ''; if ($row['unit2'] != 'X') {$streetstring = "AND `unit2` = '$streetfilter' ";}
    $club1string = ''; if ($row['club1'] == 'Y') {$club1string = "AND `club1` = 'Y' ";}
    $club2string = ''; if ($row['club2'] == 'Y') {$club2string = "AND `club2` = 'Y' ";}
    $club3string = ''; if ($row['club3'] == 'Y') {$club3string = "AND `club3` = 'Y' ";}
    $club4string = ''; if ($row['club4'] == 'Y') {$club4string = "AND `club4` = 'Y' ";}
    $club5string = ''; if ($row['club5'] == 'Y') {$club5string = "AND `club5` = 'Y' ";}
    $flagstring = ''; if ($row['flag'] == 'U') {$flagstring = "AND (ghost != 'Y' AND ghost != 'N') ";} else if ($row['flag'] == 'A') {$flagstring = "AND (`ghost` != 'Y' AND `ghost` != 'N' AND `ghost` != 'U') ";}
    $filter = "AND (`email` LIKE '%att.net' OR `email` LIKE '%ameritech.net' OR `email` LIKE '%bellsouth.net' OR `email` LIKE '%flash.net' OR `email` LIKE '%nvbell.net' OR `email` LIKE '%pacbell.net' OR `email` LIKE '%prodigy.net' OR `email` LIKE '%sbcglobal.net' OR `email` LIKE '%snet.net' OR `email` LIKE '%swbell.net' OR `email` LIKE '%wans.net')";
    
	$queryEMAIL  = "SELECT `email` FROM `users` WHERE `status` = 'active' AND `realtor` = '1' ". $club1string." ". $club2string." ". $club3string." ". $club4string." ". $club5string." ".$flagstring." ".$streetstring." ".$filter." ";;
    
	$resultEMAIL = mysqli_query($conn,$queryEMAIL);

	while($rowEMAIL = $resultEMAIL->fetch_array(MYSQLI_ASSOC))
	{
?><?php echo "{$rowEMAIL['email']}"; ?>, <?php	}?>
<?php	}?>



******************************************
Comcast Email Addresses (@comcast)
******************************************
<?php if ($row['owner'] == 'Y'){ ?>
<?php
    $streetfilter = $row['unit2'];
    $streetstring = ''; if ($row['unit2'] != 'X') {$streetstring = "AND `unit2` = '$streetfilter' ";}
    $club1string = ''; if ($row['club1'] == 'Y') {$club1string = "AND `club1` = 'Y' ";}
    $club2string = ''; if ($row['club2'] == 'Y') {$club2string = "AND `club2` = 'Y' ";}
    $club3string = ''; if ($row['club3'] == 'Y') {$club3string = "AND `club3` = 'Y' ";}
    $club4string = ''; if ($row['club4'] == 'Y') {$club4string = "AND `club4` = 'Y' ";}
    $club5string = ''; if ($row['club5'] == 'Y') {$club5string = "AND `club5` = 'Y' ";}
    $flagstring = ''; if ($row['flag'] == 'U') {$flagstring = "AND (ghost != 'Y' AND ghost != 'N') ";} else if ($row['flag'] == 'A') {$flagstring = "AND (`ghost` != 'Y' AND `ghost` != 'N' AND `ghost` != 'U') ";}
    $filter = "AND (`email` LIKE '%@comcast.%')";
    
	$queryEMAIL  = "SELECT `email` FROM `users` WHERE `status` = 'active' AND `owner` = '1' ". $club1string." ". $club2string." ". $club3string." ". $club4string." ". $club5string." ".$flagstring." ".$streetstring." ".$filter." ";
    
	$resultEMAIL = mysqli_query($conn,$queryEMAIL);

	while($rowEMAIL = $resultEMAIL->fetch_array(MYSQLI_ASSOC))
	{
?><?php echo "{$rowEMAIL['email']}"; ?>, <?php	}?>
<?php	}?>
<?php if ($row['lease'] == 'Y'){ ?>
<?php
    $streetfilter = $row['unit2'];
    $streetstring = ''; if ($row['unit2'] != 'X') {$streetstring = "AND `unit2` = '$streetfilter' ";}
    $club1string = ''; if ($row['club1'] == 'Y') {$club1string = "AND `club1` = 'Y' ";}
    $club2string = ''; if ($row['club2'] == 'Y') {$club2string = "AND `club2` = 'Y' ";}
    $club3string = ''; if ($row['club3'] == 'Y') {$club3string = "AND `club3` = 'Y' ";}
    $club4string = ''; if ($row['club4'] == 'Y') {$club4string = "AND `club4` = 'Y' ";}
    $club5string = ''; if ($row['club5'] == 'Y') {$club5string = "AND `club5` = 'Y' ";}
    $flagstring = ''; if ($row['flag'] == 'U') {$flagstring = "AND (ghost != 'Y' AND ghost != 'N') ";} else if ($row['flag'] == 'A') {$flagstring = "AND (`ghost` != 'Y' AND `ghost` != 'N' AND `ghost` != 'U') ";}
    $filter = "AND (`email` LIKE '%@comcast.%')";
    
	$queryEMAIL  = "SELECT `email` FROM `users` WHERE `status` = 'active' AND `lease` = '1' ". $club1string." ". $club2string." ". $club3string." ". $club4string." ". $club5string." ".$flagstring." ".$streetstring." ".$filter." ";
    
	$resultEMAIL = mysqli_query($conn,$queryEMAIL);

	while($rowEMAIL = $resultEMAIL->fetch_array(MYSQLI_ASSOC))
	{
?><?php echo "{$rowEMAIL['email']}"; ?>, <?php	}?>
<?php	}?>
<?php if ($row['realtor'] == 'Y'){ ?>
<?php
    $streetfilter = $row['unit2'];
    $streetstring = ''; if ($row['unit2'] != 'X') {$streetstring = "AND `unit2` = '$streetfilter' ";}
    $club1string = ''; if ($row['club1'] == 'Y') {$club1string = "AND `club1` = 'Y' ";}
    $club2string = ''; if ($row['club2'] == 'Y') {$club2string = "AND `club2` = 'Y' ";}
    $club3string = ''; if ($row['club3'] == 'Y') {$club3string = "AND `club3` = 'Y' ";}
    $club4string = ''; if ($row['club4'] == 'Y') {$club4string = "AND `club4` = 'Y' ";}
    $club5string = ''; if ($row['club5'] == 'Y') {$club5string = "AND `club5` = 'Y' ";}
    $flagstring = ''; if ($row['flag'] == 'U') {$flagstring = "AND (ghost != 'Y' AND ghost != 'N') ";} else if ($row['flag'] == 'A') {$flagstring = "AND (`ghost` != 'Y' AND `ghost` != 'N' AND `ghost` != 'U') ";}
    $filter = "AND (`email` LIKE '%@comcast.%')";
    
	$queryEMAIL  = "SELECT `email` FROM `users` WHERE `status` = 'active' AND `realtor` = '1' ". $club1string." ". $club2string." ". $club3string." ". $club4string." ". $club5string." ".$flagstring." ".$streetstring." ".$filter." ";;
    
	$resultEMAIL = mysqli_query($conn,$queryEMAIL);

	while($rowEMAIL = $resultEMAIL->fetch_array(MYSQLI_ASSOC))
	{
?><?php echo "{$rowEMAIL['email']}"; ?>, <?php	}?>
<?php	}?>



******************************************
Gmail Email Addresses (@gmail)
******************************************
<?php if ($row['owner'] == 'Y'){ ?>
<?php
    $streetfilter = $row['unit2'];
    $streetstring = ''; if ($row['unit2'] != 'X') {$streetstring = "AND `unit2` = '$streetfilter' ";}
    $club1string = ''; if ($row['club1'] == 'Y') {$club1string = "AND `club1` = 'Y' ";}
    $club2string = ''; if ($row['club2'] == 'Y') {$club2string = "AND `club2` = 'Y' ";}
    $club3string = ''; if ($row['club3'] == 'Y') {$club3string = "AND `club3` = 'Y' ";}
    $club4string = ''; if ($row['club4'] == 'Y') {$club4string = "AND `club4` = 'Y' ";}
    $club5string = ''; if ($row['club5'] == 'Y') {$club5string = "AND `club5` = 'Y' ";}
    $flagstring = ''; if ($row['flag'] == 'U') {$flagstring = "AND (ghost != 'Y' AND ghost != 'N') ";} else if ($row['flag'] == 'A') {$flagstring = "AND (`ghost` != 'Y' AND `ghost` != 'N' AND `ghost` != 'U') ";}
    $filter = "AND (`email` LIKE '%@gmail.%')";
    
	$queryEMAIL  = "SELECT `email` FROM `users` WHERE `status` = 'active' AND `owner` = '1' ". $club1string." ". $club2string." ". $club3string." ". $club4string." ". $club5string." ".$flagstring." ".$streetstring." ".$filter." ";
    
	$resultEMAIL = mysqli_query($conn,$queryEMAIL);

	while($rowEMAIL = $resultEMAIL->fetch_array(MYSQLI_ASSOC))
	{
?><?php echo "{$rowEMAIL['email']}"; ?>, <?php	}?>
<?php	}?>
<?php if ($row['lease'] == 'Y'){ ?>
<?php
    $streetfilter = $row['unit2'];
    $streetstring = ''; if ($row['unit2'] != 'X') {$streetstring = "AND `unit2` = '$streetfilter' ";}
    $club1string = ''; if ($row['club1'] == 'Y') {$club1string = "AND `club1` = 'Y' ";}
    $club2string = ''; if ($row['club2'] == 'Y') {$club2string = "AND `club2` = 'Y' ";}
    $club3string = ''; if ($row['club3'] == 'Y') {$club3string = "AND `club3` = 'Y' ";}
    $club4string = ''; if ($row['club4'] == 'Y') {$club4string = "AND `club4` = 'Y' ";}
    $club5string = ''; if ($row['club5'] == 'Y') {$club5string = "AND `club5` = 'Y' ";}
    $flagstring = ''; if ($row['flag'] == 'U') {$flagstring = "AND (ghost != 'Y' AND ghost != 'N') ";} else if ($row['flag'] == 'A') {$flagstring = "AND (`ghost` != 'Y' AND `ghost` != 'N' AND `ghost` != 'U') ";}
    $filter = "AND (`email` LIKE '%@gmail.%')";
    
	$queryEMAIL  = "SELECT `email` FROM `users` WHERE `status` = 'active' AND `lease` = '1' ". $club1string." ". $club2string." ". $club3string." ". $club4string." ". $club5string." ".$flagstring." ".$streetstring." ".$filter." ";
    
	$resultEMAIL = mysqli_query($conn,$queryEMAIL);

	while($rowEMAIL = $resultEMAIL->fetch_array(MYSQLI_ASSOC))
	{
?><?php echo "{$rowEMAIL['email']}"; ?>, <?php	}?>
<?php	}?>
<?php if ($row['realtor'] == 'Y'){ ?>
<?php
    $streetfilter = $row['unit2'];
    $streetstring = ''; if ($row['unit2'] != 'X') {$streetstring = "AND `unit2` = '$streetfilter' ";}
    $club1string = ''; if ($row['club1'] == 'Y') {$club1string = "AND `club1` = 'Y' ";}
    $club2string = ''; if ($row['club2'] == 'Y') {$club2string = "AND `club2` = 'Y' ";}
    $club3string = ''; if ($row['club3'] == 'Y') {$club3string = "AND `club3` = 'Y' ";}
    $club4string = ''; if ($row['club4'] == 'Y') {$club4string = "AND `club4` = 'Y' ";}
    $club5string = ''; if ($row['club5'] == 'Y') {$club5string = "AND `club5` = 'Y' ";}
    $flagstring = ''; if ($row['flag'] == 'U') {$flagstring = "AND (ghost != 'Y' AND ghost != 'N') ";} else if ($row['flag'] == 'A') {$flagstring = "AND (`ghost` != 'Y' AND `ghost` != 'N' AND `ghost` != 'U') ";}
    $filter = "AND (`email` LIKE '%@gmail.%')";
    
	$queryEMAIL  = "SELECT `email` FROM `users` WHERE `status` = 'active' AND `realtor` = '1' ". $club1string." ". $club2string." ". $club3string." ". $club4string." ". $club5string." ".$flagstring." ".$streetstring." ".$filter." ";;
    
	$resultEMAIL = mysqli_query($conn,$queryEMAIL);

	while($rowEMAIL = $resultEMAIL->fetch_array(MYSQLI_ASSOC))
	{
?><?php echo "{$rowEMAIL['email']}"; ?>, <?php	}?>
<?php	}?>



******************************************
Microsoft Email Addresses
(@hotmail, @live, @microsoft, @msn, @outlook)
******************************************
<?php if ($row['owner'] == 'Y'){ ?>
<?php
    $streetfilter = $row['unit2'];
    $streetstring = ''; if ($row['unit2'] != 'X') {$streetstring = "AND `unit2` = '$streetfilter' ";}
    $club1string = ''; if ($row['club1'] == 'Y') {$club1string = "AND `club1` = 'Y' ";}
    $club2string = ''; if ($row['club2'] == 'Y') {$club2string = "AND `club2` = 'Y' ";}
    $club3string = ''; if ($row['club3'] == 'Y') {$club3string = "AND `club3` = 'Y' ";}
    $club4string = ''; if ($row['club4'] == 'Y') {$club4string = "AND `club4` = 'Y' ";}
    $club5string = ''; if ($row['club5'] == 'Y') {$club5string = "AND `club5` = 'Y' ";}
    $flagstring = ''; if ($row['flag'] == 'U') {$flagstring = "AND (ghost != 'Y' AND ghost != 'N') ";} else if ($row['flag'] == 'A') {$flagstring = "AND (`ghost` != 'Y' AND `ghost` != 'N' AND `ghost` != 'U') ";}
    $filter = "AND (`email` LIKE '%@hotmail.%' OR `email` LIKE '%@live.%' OR `email` LIKE '%@msn.%' OR `email` LIKE '%@outlook.%' OR `email` LIKE '%@microsoft.%')";
    
	$queryEMAIL  = "SELECT `email` FROM `users` WHERE `status` = 'active' AND `owner` = '1' ". $club1string." ". $club2string." ". $club3string." ". $club4string." ". $club5string." ".$flagstring." ".$streetstring." ".$filter." ";
    
	$resultEMAIL = mysqli_query($conn,$queryEMAIL);

	while($rowEMAIL = $resultEMAIL->fetch_array(MYSQLI_ASSOC))
	{
?><?php echo "{$rowEMAIL['email']}"; ?>, <?php	}?>
<?php	}?>
<?php if ($row['lease'] == 'Y'){ ?>
<?php
    $streetfilter = $row['unit2'];
    $streetstring = ''; if ($row['unit2'] != 'X') {$streetstring = "AND `unit2` = '$streetfilter' ";}
    $club1string = ''; if ($row['club1'] == 'Y') {$club1string = "AND `club1` = 'Y' ";}
    $club2string = ''; if ($row['club2'] == 'Y') {$club2string = "AND `club2` = 'Y' ";}
    $club3string = ''; if ($row['club3'] == 'Y') {$club3string = "AND `club3` = 'Y' ";}
    $club4string = ''; if ($row['club4'] == 'Y') {$club4string = "AND `club4` = 'Y' ";}
    $club5string = ''; if ($row['club5'] == 'Y') {$club5string = "AND `club5` = 'Y' ";}
    $flagstring = ''; if ($row['flag'] == 'U') {$flagstring = "AND (ghost != 'Y' AND ghost != 'N') ";} else if ($row['flag'] == 'A') {$flagstring = "AND (`ghost` != 'Y' AND `ghost` != 'N' AND `ghost` != 'U') ";}
    $filter = "AND (`email` LIKE '%@hotmail.%' OR `email` LIKE '%@live.%' OR `email` LIKE '%@msn.%' OR `email` LIKE '%@outlook.%' OR `email` LIKE '%@microsoft.%')";
    
	$queryEMAIL  = "SELECT `email` FROM `users` WHERE `status` = 'active' AND `lease` = '1' ". $club1string." ". $club2string." ". $club3string." ". $club4string." ". $club5string." ".$flagstring." ".$streetstring." ".$filter." ";
    
	$resultEMAIL = mysqli_query($conn,$queryEMAIL);

	while($rowEMAIL = $resultEMAIL->fetch_array(MYSQLI_ASSOC))
	{
?><?php echo "{$rowEMAIL['email']}"; ?>, <?php	}?>
<?php	}?>
<?php if ($row['realtor'] == 'Y'){ ?>
<?php
    $streetfilter = $row['unit2'];
    $streetstring = ''; if ($row['unit2'] != 'X') {$streetstring = "AND `unit2` = '$streetfilter' ";}
    $club1string = ''; if ($row['club1'] == 'Y') {$club1string = "AND `club1` = 'Y' ";}
    $club2string = ''; if ($row['club2'] == 'Y') {$club2string = "AND `club2` = 'Y' ";}
    $club3string = ''; if ($row['club3'] == 'Y') {$club3string = "AND `club3` = 'Y' ";}
    $club4string = ''; if ($row['club4'] == 'Y') {$club4string = "AND `club4` = 'Y' ";}
    $club5string = ''; if ($row['club5'] == 'Y') {$club5string = "AND `club5` = 'Y' ";}
    $flagstring = ''; if ($row['flag'] == 'U') {$flagstring = "AND (ghost != 'Y' AND ghost != 'N') ";} else if ($row['flag'] == 'A') {$flagstring = "AND (`ghost` != 'Y' AND `ghost` != 'N' AND `ghost` != 'U') ";}
    $filter = "AND (`email` LIKE '%@hotmail.%' OR `email` LIKE '%@live.%' OR `email` LIKE '%@msn.%' OR `email` LIKE '%@outlook.%' OR `email` LIKE '%@microsoft.%')";
    
	$queryEMAIL  = "SELECT `email` FROM `users` WHERE `status` = 'active' AND `realtor` = '1' ". $club1string." ". $club2string." ". $club3string." ". $club4string." ". $club5string." ".$flagstring." ".$streetstring." ".$filter." ";;
    
	$resultEMAIL = mysqli_query($conn,$queryEMAIL);

	while($rowEMAIL = $resultEMAIL->fetch_array(MYSQLI_ASSOC))
	{
?><?php echo "{$rowEMAIL['email']}"; ?>, <?php	}?>
<?php	}?>



******************************************
Verizon, AOL, and Yahoo! Email Addresses
(@aol, @verizon, @yahoo)
******************************************
<?php if ($row['owner'] == 'Y'){ ?>
<?php
    $streetfilter = $row['unit2'];
    $streetstring = ''; if ($row['unit2'] != 'X') {$streetstring = "AND `unit2` = '$streetfilter' ";}
    $club1string = ''; if ($row['club1'] == 'Y') {$club1string = "AND `club1` = 'Y' ";}
    $club2string = ''; if ($row['club2'] == 'Y') {$club2string = "AND `club2` = 'Y' ";}
    $club3string = ''; if ($row['club3'] == 'Y') {$club3string = "AND `club3` = 'Y' ";}
    $club4string = ''; if ($row['club4'] == 'Y') {$club4string = "AND `club4` = 'Y' ";}
    $club5string = ''; if ($row['club5'] == 'Y') {$club5string = "AND `club5` = 'Y' ";}
    $flagstring = ''; if ($row['flag'] == 'U') {$flagstring = "AND (ghost != 'Y' AND ghost != 'N') ";} else if ($row['flag'] == 'A') {$flagstring = "AND (`ghost` != 'Y' AND `ghost` != 'N' AND `ghost` != 'U') ";}
    $filter = "AND (`email` LIKE '%@yahoo.%' OR `email` LIKE '%@aol.%' OR `email` LIKE '%@verizon.%')";
    
	$queryEMAIL  = "SELECT `email` FROM `users` WHERE `status` = 'active' AND `owner` = '1' ". $club1string." ". $club2string." ". $club3string." ". $club4string." ". $club5string." ".$flagstring." ".$streetstring." ".$filter." ";
    
	$resultEMAIL = mysqli_query($conn,$queryEMAIL);

	while($rowEMAIL = $resultEMAIL->fetch_array(MYSQLI_ASSOC))
	{
?><?php echo "{$rowEMAIL['email']}"; ?>, <?php	}?>
<?php	}?>
<?php if ($row['lease'] == 'Y'){ ?>
<?php
    $streetfilter = $row['unit2'];
    $streetstring = ''; if ($row['unit2'] != 'X') {$streetstring = "AND `unit2` = '$streetfilter' ";}
    $club1string = ''; if ($row['club1'] == 'Y') {$club1string = "AND `club1` = 'Y' ";}
    $club2string = ''; if ($row['club2'] == 'Y') {$club2string = "AND `club2` = 'Y' ";}
    $club3string = ''; if ($row['club3'] == 'Y') {$club3string = "AND `club3` = 'Y' ";}
    $club4string = ''; if ($row['club4'] == 'Y') {$club4string = "AND `club4` = 'Y' ";}
    $club5string = ''; if ($row['club5'] == 'Y') {$club5string = "AND `club5` = 'Y' ";}
    $flagstring = ''; if ($row['flag'] == 'U') {$flagstring = "AND (ghost != 'Y' AND ghost != 'N') ";} else if ($row['flag'] == 'A') {$flagstring = "AND (`ghost` != 'Y' AND `ghost` != 'N' AND `ghost` != 'U') ";}
    $filter = "AND (`email` LIKE '%@yahoo.%' OR `email` LIKE '%@aol.%' OR `email` LIKE '%@verizon.%')";
    
	$queryEMAIL  = "SELECT `email` FROM `users` WHERE `status` = 'active' AND `lease` = '1' ". $club1string." ". $club2string." ". $club3string." ". $club4string." ". $club5string." ".$flagstring." ".$streetstring." ".$filter." ";
    
	$resultEMAIL = mysqli_query($conn,$queryEMAIL);

	while($rowEMAIL = $resultEMAIL->fetch_array(MYSQLI_ASSOC))
	{
?><?php echo "{$rowEMAIL['email']}"; ?>, <?php	}?>
<?php	}?>
<?php if ($row['realtor'] == 'Y'){ ?>
<?php
    $streetfilter = $row['unit2'];
    $streetstring = ''; if ($row['unit2'] != 'X') {$streetstring = "AND `unit2` = '$streetfilter' ";}
    $club1string = ''; if ($row['club1'] == 'Y') {$club1string = "AND `club1` = 'Y' ";}
    $club2string = ''; if ($row['club2'] == 'Y') {$club2string = "AND `club2` = 'Y' ";}
    $club3string = ''; if ($row['club3'] == 'Y') {$club3string = "AND `club3` = 'Y' ";}
    $club4string = ''; if ($row['club4'] == 'Y') {$club4string = "AND `club4` = 'Y' ";}
    $club5string = ''; if ($row['club5'] == 'Y') {$club5string = "AND `club5` = 'Y' ";}
    $flagstring = ''; if ($row['flag'] == 'U') {$flagstring = "AND (ghost != 'Y' AND ghost != 'N') ";} else if ($row['flag'] == 'A') {$flagstring = "AND (`ghost` != 'Y' AND `ghost` != 'N' AND `ghost` != 'U') ";}
    $filter = "AND (`email` LIKE '%@yahoo.%' OR `email` LIKE '%@aol.%' OR `email` LIKE '%@verizon.%')";
    
	$queryEMAIL  = "SELECT `email` FROM `users` WHERE `status` = 'active' AND `realtor` = '1' ". $club1string." ". $club2string." ". $club3string." ". $club4string." ". $club5string." ".$flagstring." ".$streetstring." ".$filter." ";;
    
	$resultEMAIL = mysqli_query($conn,$queryEMAIL);

	while($rowEMAIL = $resultEMAIL->fetch_array(MYSQLI_ASSOC))
	{
?><?php echo "{$rowEMAIL['email']}"; ?>, <?php	}?>
<?php	}?>
</textarea>
<!-- END EMAIL ADDRESSES -->
					</div>
				</div>
		<?php }; ?>
		
				<div class="row" style="padding: 10px 10px 0px 0px;">
					<div class="small-12 medium-12 columns">
					    <strong>4) Important Details</strong><br>
					</div>
					<div class="row medium-collapse" style="padding-left: 30px;">
				        <div class="small-12 medium-12 columns">
				            <label for="from" class="middle">
				                <p>Sending too many emails to your users can result in emails being treated as SPAM.  We do not recommend sending more than three emails per week.</p>
        					    <p>In compliance with modern bulk email sending standards and policies, our emails contain unsubscribe links; and transmit using SPF, 2048 bit DKIM Key lengths, and DMARC records to reduce greylisting and verify the authentity of the email to the receiving email provider.</p>
		        			    <p>Email delivery is subject to greylisting policies by the receiving email provider. Emails can be delayed by 24-48 hours depending on the receiving provider&apos;s greylisting policy and is outside of our control.</p>
					            <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red"><b>CLICK THE SEND BUTTON ONLY ONCE!</b></span><br>
					            <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red"><b>The email script can take several minutes to process.</b></span>
				            </label>
				        </div>
                        <div class="small-12 medium-12 end columns"><input type="checkbox" name="terms" value="" required><label><i> I have read and understand the above information.</i></label></div>
    				</div>
				</div>
				<div class="row" style="padding: 10px 10px 0px 0px;">
					<div class="small-12 medium-12 columns">
					    <strong>5) Ready to Send?</strong>
					</div>
				</div>
				<div class="row medium-collapse" style="padding-left: 30px; padding-bottom: 20px;">
					<div class="small-4 columns" align="center">
						<input name="submit" value="Send" class="submit" type="submit" onclick="value='Processing'; style='color:red';" />
	                    <input name="int1" type="hidden" value="<?php echo "{$row['int1']}"; ?>" />
	                    <input name="action" type="hidden" value="email_message" />
</form>
					</div>
					<div class="small-4 columns" align="center">
<form name="MSGEdit" method="POST" action="messages-edit.php">
	                    <input type="hidden" name="action" value="edit" />
	                    <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>" />
	                    <input name="submit" value="Edit Message" class="submit" type="submit" />
</form>
					</div>
					<div class="small-4 columns" align="center">
<form action="messages.php" method="get">
	                    <input type="submit" value="Cancel">
</form>
					</div>
				</div>
				<div class="row" style="padding: 10px 10px 0px 0px;">
					<div class="small-12 medium-12 columns">
					    <?php echo($error); ?>
					</div>
				</div>
			</div>
		</div>
		<!-- END COLUMN 2 -->
	</div>
<!-- END EMAIL FORM INFORMATION -->
<?php
	}
?>

<!-- END INPUT FORM -->
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Messages Preview Control Panel Page<br></div>
</body>
</html>
