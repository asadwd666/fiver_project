<?php $current_page = '20'; include('protect.php'); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="CondoSites - http://www.condosites.com" name="author">
<title>Control Panel</title>
<?php include('../control/cp-head-scripts.php'); ?>
	<script type="text/javascript">
        function show1(){
            document.getElementById('div1').style.display ='block'; document.getElementById('div2').style.display ='none';
        }
        function show2(){
            document.getElementById('div1').style.display = 'none'; document.getElementById('div2').style.display ='block';
        }
	</script>
</head>
<body>
<!-- LOGO AND NAVIGATION -->
<?php include('cp-navigation.php'); ?>
<!-- END LOGO AND NAVIGATION -->
<?php $int1 = $_POST["int1"]; $action = $_POST["action"]; if ($action != null){ ?>
<?php
	if ($action == "delete"){
		$query = "DELETE FROM messages WHERE `int1`='$int1'";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

            $errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Message deleted successfully.</strong></div>";

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['int1'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('D', 'Messages', '$useripaddress', '$userid', '$id')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

		$query = "OPTIMIZE TABLE `messages`";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

	}
	if ($action == "add"){

        $mass = $_POST["mass"];

		$from = htmlspecialchars($_POST['from'], ENT_QUOTES);
		$subject = htmlspecialchars($_POST['subject'], ENT_QUOTES);
		$message = $_POST["message"];
		$pic = $_POST["pic"];
		$newsid = $_POST["newsid"];
		$newsid2 = $_POST["newsid2"];
		$newsid3 = $_POST["newsid3"];
		$docid = $_POST["docid"];
		$docid2 = $_POST["docid2"];
		$docid3 = $_POST["docid3"];
		$calid = $_POST["calid"];
		$userid = $_SESSION['id'];
		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$unit2 = $_POST["unit2"];
		if ($mass == 'individual') {
		    $cc = $_POST["cc"];
		    $owner = 'N';
		    $realtor = 'N';
		    $lease = 'N';
		    $club1 = '';
		    $club2 = '';
		    $club3 = '';
		    $club4 = '';
		    $club5 = '';
		    $flag = 'A';
		    $unit2 = 'X';
		}
		if ($mass == 'group') {
		    $cc = '';
		    $owner = $_POST["owner"];
		    $realtor = $_POST["realtor"];
		    $lease = $_POST["lease"];
		    $club1 = $_POST["club1"];
		    $club2 = $_POST["club2"];
		    $club3 = $_POST["club3"];
		    $club4 = $_POST["club4"];
		    $club5 = $_POST["club5"];
		    $flag = $_POST["flag"];
		    $unit2 = $_POST["unit2"];
		}

		$query = "INSERT INTO `messages` (`from`, `subject`, `message`, `pic`, `newsid`, `newsid2`, `newsid3`, `docid`, `docid2`, `docid3`, `calid`, `userid`, `useripaddress`, `unit2`, `owner`, `realtor`, `lease`, `club1`, `club2`, `club3`, `club4`, `club5`, `flag`, `cc`) VALUES ('$from', '$subject', '$message', '$pic', '$newsid', '$newsid2', '$newsid3', '$docid', '$docid2', '$docid3', '$calid', '$userid', '$useripaddress', '$unit2', '$owner', '$realtor', '$lease', '$club1', '$club2', '$club3', '$club4', '$club5', '$flag', '$cc')";
		$result = mysqli_query($conn,$query) or die('Error, insert query failed');

    $errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #b8feb8; color: black;'><i class='fa fa-check' aria-hidden='true'></i> <strong>Message saved successfully as a draft.  Scroll down to Draft Messages to send.</strong></div>";
	}
	}
?>
<!-- HEALTH AND HELP -->
<div>
    <div class="large-8 columns" style="padding: 0px">
        <div class="nav-section-header-health-cp" align="center">
<big><i class="fa fa-stethoscope" aria-hidden="true"></i></big><strong>&nbsp;Health&nbsp;&nbsp;&nbsp;</strong>
<?php $sqlMSGc = mysqli_query($conn,"SELECT count(*) FROM `messages`") or die(mysqli_error($conn));
//$countMSGc = mysql_result($sqlMSGc, "0");
$rowMSGc = mysqli_fetch_row($sqlMSGc);
$countMSGc = $rowMSGc[0];
?>
<?php $sqlMSG = mysqli_query($conn,"SELECT count(*) FROM `messages` WHERE `date` BETWEEN NOW() - INTERVAL 30 DAY AND NOW() AND `status` = 'S'") or die(mysqli_error($conn));
//$countMSG = mysql_result($sqlMSG, "0");
$rowMSG = mysqli_fetch_row($sqlMSG);
$countMSG = $rowMSG[0];
?>
<?php if ($countMSG == '0' AND $countMSGc == '0'){ ?>You have not sent an email message yet.<?php }; ?>
<?php if ($countMSG == '0' AND $countMSGc >= '1'){ ?><i class="fa fa-exclamation-triangle note" aria-hidden="true"></i> It's been longer than a month since you've sent an email message.<?php }; ?>
<?php if ($countMSG == '1'){ ?><i class="fa fa-exclamation-check" aria-hidden="true"></i> You have sent <b>1</b> email message in the last month.<?php }; ?>
<?php if ($countMSG >= '2' AND $countMSG <= '4'){ ?><i class="fa fa-exclamation-check" aria-hidden="true"></i> You have sent <b><?php print($countMSG); ?></b> email messages in the last month.<?php }; ?>
<?php if ($countMSG >= '5'){ ?><i class="fa fa-triangle" aria-hidden="true"></i> If you send too many emails per month your users might consider it &quot;spammy&quot;.<?php }; ?>
        </div>
    </div>
    <div class="large-4 columns" style="padding: 0px">
        <div class="nav-section-header-help-cp" align="center">
            <strong><big><i class="fa fa-hand-o-right" aria-hidden="true"></i></big>&nbsp;Hands&nbsp;point&nbsp;to&nbsp;tips!</strong>
        </div>
    </div>
</div>
<!-- HEALTH AND HELP -->
<br>&nbsp;

<div class="row cp-help">
    <div class="small-12 medium-6 columns">
        <p><b>Bulk Email</b> your users in this control panel. Email addresses will automatically be selected based on the audience you choose, urgency you set, and the preferences set by your users.</p>
    </div>
    <div class="small-12 medium-6 columns">
        <p>
            <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">If you plan to link Documents, Calendar Events, or Newsboard Articles to your message, be sure to upload or create those items in advance in the respective control panel.</span><br>
            <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">If you have email at your domain, your webmaster can configure emails to send and receive from your SMTP email account.</span>
        </p>
    </div>
</div>
<div style="max-width: 99%;">
<!-- UPLOAD FORM -->
	<div class="nav-section-header-cp">
		<strong>Compose a Message for Email</strong>
	</div>
<?php if ($_GET["success"] == 'yes') { ?>
    <div class="nav-section-header-cp" style="background-color: #b8feb8; color: black;"><i class="fa fa-check" aria-hidden="true"></i> <strong>Your email has been sent.</strong></div>
<?php } ?>
	<?php echo($errorSUCCESS); ?>
	<form enctype="multipart/form-data" method="POST" action="messages.php">
	<div class="cp-form-container">
		<!-- COLUMN 1 -->
		<div class="small-12 medium-12 large-6 columns">
			<div class="row" style="padding: 10px 10px 0px 0px;">
				<div class="small-12 medium-12 columns"><strong>1) Let&apos;s start with the basics...</strong></div>
			</div>
			<div class="row medium-collapse" style="padding-left: 30px;">
				<div class="small-12 medium-6 columns"><label for="from" class="middle">Who can users send replies to?<br></label></div>
					<div class="small-12 medium-6 end columns">
<?php include('../my-documents/messages-fromemail.php'); ?>
					</div>
					<div class="small-12 medium-12 end columns" style="margin-top: -20px; margin-bottom: 20px;">
                        <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">All emails come from &quot;<i><?php echo "{$CommunityName}"; ?> via CondoSites</i>&quot; (messages@condosites.net).</span><br>
                        <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">This entry will appear as the <i>Reply-To</i> field on the recipient&apos;s email.</span><br>
                        <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Your webmaster can add/edit <i>Reply-To</i> addresses.</span><br>
					</div>
				</div>
				<div class="row medium-collapse" style="padding-left: 30px;">
					<div class="small-12 medium-6 columns"><label for="subject" class="middle">What subject would you like on the email?<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Do <b>NOT</b> include community name.</span></label></div>
					<div class="small-12 medium-6 end columns"><input name="subject" placeholder="Notice of annual meeting" maxlength="100" class="form" type="text" required></div>
				</div>
				<div class="row medium-collapse" style="padding-left: 30px;">
					<div class="small-12 medium-12 columns"><label for="message" class="middle">Email Message Body&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">10,000 characters max, including html formatting characters.</span><br>
					    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">If pasting content from Microsoft Word, use the "Paste from Word" ( <img src="https://condosites.net/commons/pastefromword.png" width="15"> ) button.</span><br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Use the Styles pulldown to apply <b><span class="bluepen">c</span><span class="greenpen">o</span><span class="bluepen">l</span><span class="greenpen">o</span><span class="bluepen">r</span></b> and formatting <span class="marker">styles</span> to your text.</span>
					</label>
						<textarea name="message" id="editor1" class="form" type="text" placeholder="Type your email message here..." maxlength="9999" required></textarea>
                        <script>CKEDITOR.replace( 'editor1' );</script>
					</div>
				</div>
				<div class="row" style="padding: 40px 10px 0px 0px;">
					<div class="small-12 medium-12 columns"><strong>2) Would you like to add a Photo?</strong></div>
				</div>
                <div class="row medium-collapse" style="padding-left: 30px;">
                    <div class="small-12 medium-5 columns"><label for="utility" class="middle">Add a Photo to the Message Body</label></div>
                    <div class="small-12 medium-7 end columns">
<select name="pic">
<option value="">None</option>
<?php
	$query  = "SELECT `id`, title, doctype FROM documents WHERE (type = 'image/jpeg' OR type = 'image/pjpeg' OR type = 'image/gif' OR type = 'image/png') AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY `id` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$row['id']}"; ?>"><?php echo "{$row['id']}"; ?> - <?php echo "{$row['title']}"; ?> (<?php echo "{$row['doctype']}"; ?>)</option>
<?php
	}
?>
</select>
                    </div>
                </div>
				<div class="row" style="padding: 10px 10px 0px 0px;">
					<div class="small-12 medium-12 columns"><strong>3) Would you like to link any documents?</strong></div>
				</div>
				<div class="row medium-collapse" style="padding-left: 30px;">
					<div class="small-12 medium-4 columns"><label for="docid" class="middle">Link to Document</label></div>
					<div class="small-12 medium-8 end columns">
						<select name="docid">
							<option value="">None</option>
						<?php
							$query  = "SELECT `id`, title, doctype FROM documents ORDER BY `id` DESC";
							$result = mysqli_query($conn, $query);

							while($row = $result->fetch_array(MYSQLI_ASSOC))
							{
						?>
							<option value="<?php echo "{$row['id']}"; ?>"><?php echo "{$row['id']}"; ?> - <?php echo "{$row['title']}"; ?> (<?php echo "{$row['doctype']}"; ?>)</option>
						<?php
							}
						?>
						</select>
					</div>
				</div>
				<div class="row medium-collapse" style="padding-left: 30px;">
					<div class="small-12 medium-4 columns"><label for="docid2" class="middle">Link to 2nd Document</label></div>
					<div class="small-12 medium-8 end columns">
						<select name="docid2">
							<option value="">None</option>
						<?php
							$query  = "SELECT `id`, title, doctype FROM documents ORDER BY `id` DESC";
							$result = mysqli_query($conn, $query);

							while($row = $result->fetch_array(MYSQLI_ASSOC))
							{
						?>
							<option value="<?php echo "{$row['id']}"; ?>"><?php echo "{$row['id']}"; ?> - <?php echo "{$row['title']}"; ?> (<?php echo "{$row['doctype']}"; ?>)</option>
						<?php
							}
						?>
						</select>
					</div>
				</div>
				<div class="row medium-collapse" style="padding-left: 30px;">
					<div class="small-12 medium-4 columns"><label for="docid3" class="middle">Link to 3rd Document</label></div>
					<div class="small-12 medium-8 end columns">
						<select name="docid3">
							<option value="">None</option>
						<?php
							$query  = "SELECT `id`, title, doctype FROM documents ORDER BY `id` DESC";
							$result = mysqli_query($conn, $query);

							while($row = $result->fetch_array(MYSQLI_ASSOC))
							{
						?>
							<option value="<?php echo "{$row['id']}"; ?>"><?php echo "{$row['id']}"; ?> - <?php echo "{$row['title']}"; ?> (<?php echo "{$row['doctype']}"; ?>)</option>
						<?php
							}
						?>
						</select>
					</div>
				</div>
			</div>
			<!-- END COLUMN 1 -->
			<!-- COLUMN 2 -->
			<div class="small-12 medium-12 large-6 columns">
				<div class="row" style="padding: 10px 10px 0px 0px;">
					<div class="small-12 medium-12 columns"><strong>4) Would you like to link any additional content?</strong></div>
				</div>
				<div class="row medium-collapse" style="padding-left: 30px;">
					<div class="small-12 medium-4 columns"><label for="calid" class="middle">Link to Calendar Event</label></div>
					<div class="small-12 medium-8 end columns">
						<select name="calid">
							<option value="">None</option>
						<?php
							$query  = "SELECT `int1`, title, date, stime, event FROM calendar WHERE date >= CURRENT_DATE() ORDER BY `int1` DESC";
							$result = mysqli_query($conn, $query);

							while($row7 = $result->fetch_array(MYSQLI_ASSOC))
							{
						?>
							<option value="<?php echo "{$row7['int1']}"; ?>"><?php echo "{$row7['int1']}"; ?> - <?php echo "{$row7['title']}"; ?> (<?php echo "{$row7['event']}"; ?>) <?php echo "{$row7['date']}"; ?> <?php echo "{$row7['stime']}"; ?></option>
						<?php
							}
						?>
						</select>
					</div>
				</div>
				<div class="row medium-collapse" style="padding-left: 30px;">
					<div class="small-12 medium-4 columns"><label for="newsid" class="middle">Newsboard Headline</label></div>
					<div class="small-12 medium-8 end columns">
						<select name="newsid">
							<option value="">None</option>
						<?php
							$query  = "SELECT `int1`, headline, pod FROM chalkboard where eod > CURRENT_DATE() ORDER BY `int1` DESC";
							$result = mysqli_query($conn, $query);

							while($row = $result->fetch_array(MYSQLI_ASSOC))
							{
						?>
							<option value="<?php echo "{$row['int1']}"; ?>"><?php echo "{$row['int1']}"; ?> - <?php echo "{$row['headline']}"; ?> (<?php echo "{$row['pod']}"; ?>)</option>
						<?php
							}
						?>
						</select>
					</div>
				</div>
				<div class="row medium-collapse" style="padding-left: 30px;">
					<div class="small-12 medium-4 columns"><label for="newsid2" class="middle">2nd Newsboard Headline</label></div>
					<div class="small-12 medium-8 end columns">
						<select name="newsid2">
							<option value="">None</option>
						<?php
							$query  = "SELECT `int1`, headline, pod FROM chalkboard where eod > CURRENT_DATE() ORDER BY `int1` DESC";
							$result = mysqli_query($conn, $query);

							while($row = $result->fetch_array(MYSQLI_ASSOC))
							{
						?>
							<option value="<?php echo "{$row['int1']}"; ?>"><?php echo "{$row['int1']}"; ?> - <?php echo "{$row['headline']}"; ?> (<?php echo "{$row['pod']}"; ?>)</option>
						<?php
							}
						?>
						</select>
					</div>
				</div>
				<div class="row medium-collapse" style="padding-left: 30px;">
					<div class="small-12 medium-4 columns"><label for="" class="middle">3rd Newsboard Headline</label></div>
					<div class="small-12 medium-8 end columns">
						<select name="newsid3">
							<option value="">None</option>
						<?php
							$query  = "SELECT `int1`, headline, pod FROM chalkboard where eod > CURRENT_DATE() ORDER BY `int1` DESC";
							$result = mysqli_query($conn, $query);

							while($row = $result->fetch_array(MYSQLI_ASSOC))
							{
						?>
							<option value="<?php echo "{$row['int1']}"; ?>"><?php echo "{$row['int1']}"; ?> - <?php echo "{$row['headline']}"; ?> (<?php echo "{$row['pod']}"; ?>)</option>
						<?php
							}
						?>
						</select>
					</div>
				</div>
				<div class="row" style="padding: 10px 10px 0px 0px;">
					<div class="small-12 medium-12 columns">
					    <strong>5) Is this a Group Email or Individual Email?</strong><br><br>
					</div>
				</div>
                <div class="row medium-collapse" style="padding-left: 30px;">
					<div class="small-12 medium-12 end columns">
						<label for="mass" class="middle">
							<input type="radio" name="mass" value="group" checked onclick="show1();" />&nbsp;Group &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="mass" value="individual" onclick="show2();" />&nbsp;Individual
						</label>
					</div>
				</div>

		<div id="div1" style="display:block">
				<div class="row" style="padding: 10px 10px 0px 0px;">
					<div class="small-12 medium-12 columns">
					    <strong>6) Who should receive this email?</strong>
					</div>
				</div>
				<div class="row medium-collapse" style="padding-left: 30px;">
					<div class="small-12 medium-6 columns"><label for="flag" class="middle">Set the priority of the email<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Use "Urgent" option responsibly!</span></label></div>
					<div class="small-12 medium-6 end columns">
						<label for="flag" class="middle">
							<input type="radio" name="flag" value="A" checked>&nbsp;Standard &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="flag" value="U">&nbsp;Urgent
						</label>
					</div>
				</div>
				
<?php $sqlU2 = mysqli_query($conn,"SELECT count(*) FROM users WHERE unit2 != 'X'") or die(mysqli_error($conn));
//$countU2 = mysql_result($sqlU2, "0");
$rowU2 = mysqli_fetch_row($sqlU2);
$countU2 = $rowU2[0];
?>
<?php if ($countU2 != '0'){ ?>
				<div class="row medium-collapse" style="padding-left: 30px;">
					<div class="small-12 medium-6 columns"><label for="unit2" class="middle">Send to specific building/street?<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Sends to all if none selected.</span></label></div>
					<div class="small-12 medium-6 end columns">
<?php include('../my-documents/units-buildings.php'); ?>
					</div>
				</div>
<?php }; ?>
<?php if ($countU2 == '0'){ ?>
<input type="hidden" name="unit2" value="X">
<?php }; ?>
				<div class="row medium-collapse" style="padding-left: 30px;">
					<div class="small-12 medium-4 columns"><label for="owner" class="middle">Send to <b>Owners</b>?</label></div>
					<div class="small-12 medium-2 end columns" style="padding-right: 15px;">
<select name="owner" class="form">
<option value="Y">Yes</option>
<option value="N">No</option>
</select>
					</div>
				</div>
				<div class="row medium-collapse" style="padding-left: 30px;">
					<div class="small-12 medium-4 columns"><label for="lease" class="middle">Send to <b>Renters</b>?</label></div>
					<div class="small-12 medium-2 end columns" style="padding-right: 15px;">
<select name="lease" class="form">
<option value="N">No</option>
<option value="Y">Yes</option>
</select>
					</div>
				</div>
				<div class="row medium-collapse" style="padding-left: 30px;">
					<div class="small-12 medium-4 columns"><label for="realtor" class="middle">Send to <b>Realtors</b>?</label></div>
					<div class="small-12 medium-2 end columns" style="padding-right: 15px;">
<select name="realtor" class="form">
<option value="N">No</option>
<option value="Y">Yes</option>
</select>
					</div>
				</div>

<?php include('../my-documents/user-club-control.php'); ?>

        </div>

        <div id="div2" style="display:none">
                <div class="row" style="padding: 10px 10px 0px 0px;">
					<div class="small-12 medium-12 columns">
					    <strong>6) Who should receive this email?</strong>
					</div>
		        </div>
				<div class="row medium-collapse" style="padding-left: 30px;">
					<div class="small-12 medium-4 columns"><label for="" class="middle">Select individual</label></div>
					<div class="small-12 medium-8 end columns">
						<select name="cc">
                            <option value="">Select User</option>
                            <option value="" disabled>
<?php
	$query  = "SELECT id, last_name, first_name, unit, unit2 FROM users WHERE ghost != 'Y' and status != 'disabled' ORDER BY `last_name`";
	$result = mysqli_query($conn, $query);

	while($row1 = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$row1['id']}"; ?>"><?php echo "{$row1['last_name']}"; ?>, <?php echo "{$row1['first_name']}"; ?> (<?php echo "{$row1['unit']}"; ?><?php if ($row1['unit2'] !== 'X'){ ?> - <?php echo "{$row1['unit2']}"; ?><?php }; ?>)</option>
<?php
	}
?>
                        </select>
					</div>
				</div>
        </div>

				<div class="row" style="padding: 10px 10px 0px 0px;">
					<div class="small-12 medium-12 columns"><strong>7) Ready to Save?</strong>
				</div>
				<div class="row medium-collapse" style="padding-left: 30px; padding-bottom: 20px;">
					<div class="small-12 medium-8 columns">
						<label for="flag" class="middle"><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">To send the email, first save the draft, then click the "Preview and Send" button for the entry below in Drafts.</span></label>
					</div>
					<div class="small-12 medium-4 columns" align="center">
						<input type="hidden" name="action" value="add">
						<input name="submit" value="Save as Draft" class="submit" type="submit">
						<?php echo($error); ?>
					</div>
				</div>
				<div class="row medium-collapse">
					<div class="small-12 medium-12 columns" align="center">
						<br><i class="fa fa-hand-o-down" aria-hidden="true"></i> Scroll down to see draft emails and sent emails.
					</div>
				</div>
			</div>
			<!-- END COLUMN 2 -->
		</div>
	</form>
	<!-- END UPLOAD FORM -->
	</div>
<br>
<?php $sqlSND = mysqli_query($conn,"SELECT count(*) FROM `messages` WHERE `status` = 'P'") or die(mysqli_error($conn));
//$countSND = mysql_result($sqlSND, "0");
$rowSND = mysqli_fetch_row($sqlSND);
$countSND = $rowSND[0];
?>
<?php if ($countSND != '0'){ ?>
<div class="nav-section-header-cp" style="background-color:#ffa800">
    <?php $sqlUSR = mysqli_query($conn,"SELECT count(*) FROM `users` WHERE `emaildomain` != ''") or die(mysqli_error($conn));
    //$countUSR = mysql_result($sqlUSR, "0");
    $rowUSR = mysqli_fetch_row($sqlUSR);
    $countUSR = $rowUSR[0];
    ?>
	<strong>Messages Sending Script In Progress – <?php print($countUSR); ?> Emails Remaining</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr align="left">
        <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp;<b><small>Message</small></b></th>
		<th width="50" class="table-sortable:numeric">&nbsp;&nbsp;&nbsp;<small>ID</small></th>
        <th class="table-sortable:datetime">&nbsp;&nbsp;&nbsp;<small>Last Saved</small></th>
        <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Indv</small></b></div></th>
		<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Owner</small></b></div></th>
		<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Renter</small></b></div></th>
		<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Realtor</small></b></div></th>
    </tr>
  </thead>
  <tbody style="background-color:#ffffff">
<?php
	$query  = "SELECT * FROM messages where status = 'P' ORDER BY `int1` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- DATABASE RESULTS -->
    <tr>
      <td>
				<div class="small-12 medium-12 large-10 columns">
<b><?php echo "{$row['subject']}"; ?></b><?php if ($row['flag'] == 'U'){ ?><div class="cp-ribbon ribbon__U" style="float: right;">URGENT</div><?php }; ?>

<?php if ($row['cc'] != ''){ ?>
<?php
	$type    = $row['cc'];
	$query1  = "SELECT id, unit, unit2, last_name, first_name, email, phone FROM users WHERE id = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
?>
<br><i>This is an individual email to: <?php echo "{$row1['last_name']}"; ?>, <?php echo "{$row1['first_name']}"; ?> (<?php echo "{$row1['unit']}"; ?><?php if ($row1['unit2'] !== 'X'){ ?> - <?php echo "{$row1['unit2']}"; ?><?php }; ?>)</i>
<?php
	}
?>
<?php }; ?>

<?php if ($row['message'] !== ''){ ?><blockquote><?php echo "{$row['message']}"; ?></blockquote><?php }; ?>
<span class="note-black">
<?php if ($row['newsid'] !== ''){ ?>
<?php
	$typeN1    = $row['newsid'];
	$queryN1  = "SELECT `int1`, headline, pod FROM chalkboard WHERE `int1` = '$typeN1'";
	$resultN1 = mysqli_query($conn,$queryN1);

	while($rowN1 = $resultN1->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Newsboard ID <?php echo "{$rowN1['int1']}"; ?>) <?php echo "{$rowN1['headline']}"; ?> (<?php echo "{$rowN1['pod']}"; ?>)<br>
<?php
	}
?>
<?php }; ?>
<?php if ($row['newsid2'] !== ''){ ?>
<?php
	$typeN2    = $row['newsid2'];
	$queryN2  = "SELECT `int1`, headline, pod FROM chalkboard WHERE `int1` = '$typeN2'";
	$resultN2 = mysqli_query($conn,$queryN2);

	while($rowN2 = $resultN2->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Newsboard ID <?php echo "{$rowN2['int1']}"; ?>) <?php echo "{$rowN2['headline']}"; ?> (<?php echo "{$rowN2['pod']}"; ?>)<br>
<?php
	}
?>
<?php }; ?>
<?php if ($row['newsid3'] !== ''){ ?>
<?php
	$typeN3    = $row['newsid3'];
	$queryN3  = "SELECT `int1`, headline, pod FROM chalkboard WHERE `int1` = '$typeN3'";
	$resultN3 = mysqli_query($conn,$queryN3);

	while($rowN3 = $resultN3->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Newsboard ID <?php echo "{$rowN3['int1']}"; ?>) <?php echo "{$rowN3['headline']}"; ?> (<?php echo "{$rowN3['pod']}"; ?>)<br>
<?php
	}
?>
<?php }; ?>
<?php if ($row['docid'] !== ''){ ?>
<?php
	$typeD1    = $row['docid'];
	$queryD1  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeD1'";
	$resultD1 = mysqli_query($conn,$queryD1);

	while($rowD1 = $resultD1->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Document ID <?php echo "{$rowD1['id']}"; ?>) <?php echo "{$rowD1['title']}"; ?> (<?php echo "{$rowD1['doctype']}"; ?>)<br>
<?php
	}
?>
<?php }; ?>
<?php if ($row['docid2'] !== ''){ ?>
<?php
	$typeD2    = $row['docid2'];
	$queryD2  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeD2'";
	$resultD2 = mysqli_query($conn,$queryD2);

	while($rowD2 = $resultD2->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Document ID <?php echo "{$rowD2['id']}"; ?>) <?php echo "{$rowD2['title']}"; ?> (<?php echo "{$rowD2['doctype']}"; ?>)<br>
<?php
	}
?>
<?php }; ?>
<?php if ($row['docid3'] !== ''){ ?>
<?php
	$typeD3    = $row['docid3'];
	$queryD3  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeD3'";
	$resultD3 = mysqli_query($conn,$queryD3);

	while($rowD3 = $resultD3->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Document ID <?php echo "{$rowD3['id']}"; ?>) <?php echo "{$rowD3['title']}"; ?> (<?php echo "{$rowD3['doctype']}"; ?>)<br>
<?php
	}
?>
<?php }; ?>
<?php if ($row['calid'] !== ''){ ?>
<?php
	$typeCID    = $row['calid'];
	$queryCID  = "SELECT `int1`, title, event, date FROM calendar WHERE `int1` = '$typeCID'";
	$resultCID = mysqli_query($conn,$queryCID);

	while($rowCID = $resultCID->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Calendar ID <?php echo "{$rowCID['int1']}"; ?>) <?php echo "{$rowCID['title']}"; ?> (<?php echo "{$rowCID['event']}"; ?>) <?php echo "{$row7['date']}"; ?> <?php echo "{$row7['stime']}"; ?><br>
<?php
	}
?>
<?php }; ?>
</span>
				</div>
			</td>
			<td><?php echo "{$row['int1']}"; ?></td>
      <td><?php echo "{$row['date']}"; ?></td>
      <td align="center" <?php if ($row['cc'] == ''){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['cc'] != ''){ ?>bgcolor="#ccffcc"<?php }; ?>><?php if ($row['cc'] !== ''){ ?>Y<?php }; ?><?php if ($row['cc'] == ''){ ?>N<?php }; ?></td>
      <td align="center" <?php if ($row['owner'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['owner'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['owner']}"; ?></td>
      <td align="center" <?php if ($row['lease'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['lease'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['lease']}"; ?></td>
      <td align="center" <?php if ($row['realtor'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['realtor'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['realtor']}"; ?></td>
    </tr>
<!-- END DATABASE RESULTS -->
<?php
	}
?>
  </tbody>
</table>
<br>
<?php }; ?>
<div class="nav-section-header-cp">
    <?php $sqlMSG = mysqli_query($conn,"SELECT count(*) FROM `messages` WHERE `status` = 'D'") or die(mysqli_error($conn));
    $rowMSG = mysqli_fetch_row($sqlMSG);
    $countMSG = $rowMSG[0];
    ?>
	<strong><?php print($countMSG); ?> Draft Messages</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr align="left">
        <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp;<b><small>Message</small></b></th>
		<th width="50" class="table-sortable:numeric">&nbsp;&nbsp;&nbsp;<small>ID</small></th>
        <th class="table-sortable:datetime">&nbsp;&nbsp;&nbsp;<small>Last Saved</small></th>
        <th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Indv</small></b></div></th>
		<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Owner</small></b></div></th>
		<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Renter</small></b></div></th>
		<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Realtor</small></b></div></th>
    </tr>
  </thead>
  <tbody style="background-color:#ffffff">
<?php
	$query  = "SELECT * FROM messages where status = 'D' ORDER BY `int1` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- DATABASE RESULTS -->
    <tr>
      <td>
				<div class="small-12 medium-12 large-10 columns">
<b><?php echo "{$row['subject']}"; ?></b><?php if ($row['flag'] == 'U'){ ?><div class="cp-ribbon ribbon__U" style="float: right;">URGENT</div><?php }; ?>

<?php if ($row['cc'] != ''){ ?>
<?php
	$type    = $row['cc'];
	$query1  = "SELECT id, unit, unit2, last_name, first_name, email, phone FROM users WHERE id = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
?>
<br><i>This is an individual email to: <?php echo "{$row1['last_name']}"; ?>, <?php echo "{$row1['first_name']}"; ?> (<?php echo "{$row1['unit']}"; ?><?php if ($row1['unit2'] !== 'X'){ ?> - <?php echo "{$row1['unit2']}"; ?><?php }; ?>)</i>
<?php
	}
?>
<?php }; ?>

<?php if ($row['message'] !== ''){ ?><blockquote><?php echo "{$row['message']}"; ?></blockquote><?php }; ?>
<span class="note-black">
<?php if ($row['newsid'] !== ''){ ?>
<?php
	$typeN1    = $row['newsid'];
	$queryN1  = "SELECT `int1`, headline, pod FROM chalkboard WHERE `int1` = '$typeN1'";
	$resultN1 = mysqli_query($conn,$queryN1);

	while($rowN1 = $resultN1->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Newsboard ID <?php echo "{$rowN1['int1']}"; ?>) <?php echo "{$rowN1['headline']}"; ?> (<?php echo "{$rowN1['pod']}"; ?>)<br>
<?php
	}
?>
<?php }; ?>
<?php if ($row['newsid2'] !== ''){ ?>
<?php
	$typeN2    = $row['newsid2'];
	$queryN2  = "SELECT `int1`, headline, pod FROM chalkboard WHERE `int1` = '$typeN2'";
	$resultN2 = mysqli_query($conn,$queryN2);

	while($rowN2 = $resultN2->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Newsboard ID <?php echo "{$rowN2['int1']}"; ?>) <?php echo "{$rowN2['headline']}"; ?> (<?php echo "{$rowN2['pod']}"; ?>)<br>
<?php
	}
?>
<?php }; ?>
<?php if ($row['newsid3'] !== ''){ ?>
<?php
	$typeN3    = $row['newsid3'];
	$queryN3  = "SELECT `int1`, headline, pod FROM chalkboard WHERE `int1` = '$typeN3'";
	$resultN3 = mysqli_query($conn,$queryN3);

	while($rowN3 = $resultN3->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Newsboard ID <?php echo "{$rowN3['int1']}"; ?>) <?php echo "{$rowN3['headline']}"; ?> (<?php echo "{$rowN3['pod']}"; ?>)<br>
<?php
	}
?>
<?php }; ?>
<?php if ($row['docid'] !== ''){ ?>
<?php
	$typeD1    = $row['docid'];
	$queryD1  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeD1'";
	$resultD1 = mysqli_query($conn,$queryD1);

	while($rowD1 = $resultD1->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Document ID <?php echo "{$rowD1['id']}"; ?>) <?php echo "{$rowD1['title']}"; ?> (<?php echo "{$rowD1['doctype']}"; ?>)<br>
<?php
	}
?>
<?php }; ?>
<?php if ($row['docid2'] !== ''){ ?>
<?php
	$typeD2    = $row['docid2'];
	$queryD2  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeD2'";
	$resultD2 = mysqli_query($conn,$queryD2);

	while($rowD2 = $resultD2->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Document ID <?php echo "{$rowD2['id']}"; ?>) <?php echo "{$rowD2['title']}"; ?> (<?php echo "{$rowD2['doctype']}"; ?>)<br>
<?php
	}
?>
<?php }; ?>
<?php if ($row['docid3'] !== ''){ ?>
<?php
	$typeD3    = $row['docid3'];
	$queryD3  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeD3'";
	$resultD3 = mysqli_query($conn,$queryD3);

	while($rowD3 = $resultD3->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Document ID <?php echo "{$rowD3['id']}"; ?>) <?php echo "{$rowD3['title']}"; ?> (<?php echo "{$rowD3['doctype']}"; ?>)<br>
<?php
	}
?>
<?php }; ?>
<?php if ($row['calid'] !== ''){ ?>
<?php
	$typeCID    = $row['calid'];
	$queryCID  = "SELECT `int1`, title, event, date FROM calendar WHERE `int1` = '$typeCID'";
	$resultCID = mysqli_query($conn,$queryCID);

	while($rowCID = $resultCID->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Calendar ID <?php echo "{$rowCID['int1']}"; ?>) <?php echo "{$rowCID['title']}"; ?> (<?php echo "{$rowCID['event']}"; ?>) <?php echo "{$row7['date']}"; ?> <?php echo "{$row7['stime']}"; ?><br>
<?php
	}
?>
<?php }; ?>
</span>
				</div>
				<div class="small-4 medium-4 large-2 columns">
					<form name="MSGEdit" method="POST" action="messages-edit.php">
					  <input type="hidden" name="action" value="edit">
					  <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
					  <input name="submit" value="Edit" class="submit" type="submit">
					</form>
					<br>
				</div>
				<?php $sqlSND = mysqli_query($conn,"SELECT count(*) FROM `messages` WHERE `status` = 'P'") or die(mysqli_error($conn));
				//$countSND = mysql_result($sqlSND, "0");
                $rowSND = mysqli_fetch_row($sqlSND);
                $countSND = $rowSND[0];
				?>
                <?php if ($countSND == '0'){ ?>
				<div class="small-4 medium-4 large-2 columns">
					<form name="MSGSend" method="POST" action="messages-email.php">
					  <input type="hidden" name="action" value="edit">
					  <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
					  <input name="submit" value="Preview &amp; Send" class="submit" type="submit">
					</form>
					<br>
				</div>
				<?php }; ?>
				<div class="small-4 medium-4 large-2 columns">
					<form name="MSGDelete" method="POST" action="messages.php" onclick="return confirm('Are you sure you want to delete the message draft: <?php echo "{$row['subject']}"; ?>?');">
					  <input type="hidden" name="action" value="delete">
					  <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
					  <input name="submit" value="Delete" class="submit" type="submit">
					</form>
					<br>
				</div>
				<?php if ($countSND != '0'){ ?>
				<div class="small-4 medium-4 large-2 columns">
    				<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Sending of additional email is not available while Email Sending Script in progress.</span>
    			</div>
    			<?php }; ?>
			</td>
			<td><?php echo "{$row['int1']}"; ?></td>
      <td><?php echo "{$row['date']}"; ?></td>
      <td align="center" <?php if ($row['cc'] == ''){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['cc'] != ''){ ?>bgcolor="#ccffcc"<?php }; ?>><?php if ($row['cc'] !== ''){ ?>Y<?php }; ?><?php if ($row['cc'] == ''){ ?>N<?php }; ?></td>
      <td align="center" <?php if ($row['owner'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['owner'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['owner']}"; ?></td>
      <td align="center" <?php if ($row['lease'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['lease'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['lease']}"; ?></td>
      <td align="center" <?php if ($row['realtor'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['realtor'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['realtor']}"; ?></td>
    </tr>
<!-- END DATABASE RESULTS -->
<?php
	}
?>
  </tbody>
</table>
<br>
<div class="nav-section-header-cp">
	<?php $sqlMSG = mysqli_query($conn,"SELECT count(*) FROM `messages` WHERE `status` = 'S'") or die(mysqli_error($conn));
    $rowMSG = mysqli_fetch_row($sqlMSG);
    $countMSG = $rowMSG[0];
    ?>
	<strong><?php print($countMSG); ?> Sent Messages</strong>
</div>
<table width="100%" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
		<tr align="center">
			<th style="background-color:#eeeddd" valign="top" colspan="7"><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Sent Messages retained for 15-months, they can not be deleted or edited.</span></td>
		</tr>
    <tr align="left">
        <th class="table-sortable:alphanumeric">&nbsp;&nbsp;&nbsp;<b><small>Message</small></b></th>
		<th width="50" class="table-sortable:numeric">&nbsp;&nbsp;&nbsp;<small>ID</small></th>
        <th class="table-sortable:datetime">&nbsp;&nbsp;&nbsp;<small>Sent On</small></th>
		<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Indv</small></b></div></th>
		<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Owner</small></b></div></th>
		<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Renter</small></b></div></th>
		<th align="center" width="10" class="table-sortable:alphanumeric"><div class="rotate90"><b><small>Realtor</small></b></div></th>
    </tr>
  </thead>
  <tbody style="background-color:#ffffff">
<?php
	$query  = "SELECT * FROM messages where status = 'S' ORDER BY `int1` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- DATABASE RESULTS -->
    <tr>
      <td>
<b><?php echo "{$row['subject']}"; ?></b><?php if ($row['flag'] == 'U'){ ?><div class="cp-ribbon ribbon__U" style="float: right;">URGENT</div><?php }; ?>

<?php if ($row['cc'] != ''){ ?>
<?php
	$type    = $row['cc'];
	$query1  = "SELECT id, unit, unit2, last_name, first_name, email, phone FROM users WHERE id = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
?>
<br><i>This is an individual email to: <?php echo "{$row1['last_name']}"; ?>, <?php echo "{$row1['first_name']}"; ?> (<?php echo "{$row1['unit']}"; ?><?php if ($row1['unit2'] !== 'X'){ ?> - <?php echo "{$row1['unit2']}"; ?><?php }; ?>)</i>
<?php
	}
?>
<?php }; ?>

<?php if ($row['message'] !== ''){ ?><blockquote><?php echo "{$row['message']}"; ?></blockquote><?php }; ?>
<span class="note-black">
<?php if ($row['newsid'] !== ''){ ?>
<?php
	$typeN1    = $row['newsid'];
	$queryN1  = "SELECT `int1`, headline, pod FROM chalkboard WHERE `int1` = '$typeN1'";
	$resultN1 = mysqli_query($conn,$queryN1);

	while($rowN1 = $resultN1->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Newsboard ID <?php echo "{$rowN1['int1']}"; ?>) <?php echo "{$rowN1['headline']}"; ?> (<?php echo "{$rowN1['pod']}"; ?>)<br>
<?php
	}
?>
<?php }; ?>
<?php if ($row['newsid2'] !== ''){ ?>
<?php
	$typeN2    = $row['newsid2'];
	$queryN2  = "SELECT `int1`, headline, pod FROM chalkboard WHERE `int1` = '$typeN2'";
	$resultN2 = mysqli_query($conn,$queryN2);

	while($rowN2 = $resultN2->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Newsboard ID <?php echo "{$rowN2['int1']}"; ?>) <?php echo "{$rowN2['headline']}"; ?> (<?php echo "{$rowN2['pod']}"; ?>)<br>
<?php
	}
?>
<?php }; ?>
<?php if ($row['newsid3'] !== ''){ ?>
<?php
	$typeN3    = $row['newsid3'];
	$queryN3  = "SELECT `int1`, headline, pod FROM chalkboard WHERE `int1` = '$typeN3'";
	$resultN3 = mysqli_query($conn,$queryN3);

	while($rowN3 = $resultN3->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Newsboard ID <?php echo "{$rowN3['int1']}"; ?>) <?php echo "{$rowN3['headline']}"; ?> (<?php echo "{$rowN3['pod']}"; ?>)<br>
<?php
	}
?>
<?php }; ?>
<?php if ($row['docid'] !== ''){ ?>
<?php
	$typeD1    = $row['docid'];
	$queryD1  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeD1'";
	$resultD1 = mysqli_query($conn,$queryD1);

	while($rowD1 = $resultD1->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Document ID <?php echo "{$rowD1['id']}"; ?>) <?php echo "{$rowD1['title']}"; ?> (<?php echo "{$rowD1['doctype']}"; ?>)<br>
<?php
	}
?>
<?php }; ?>
<?php if ($row['docid2'] !== ''){ ?>
<?php
	$typeD2    = $row['docid2'];
	$queryD2  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeD2'";
	$resultD2 = mysqli_query($conn,$queryD2);

	while($rowD2 = $resultD2->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Document ID <?php echo "{$rowD2['id']}"; ?>) <?php echo "{$rowD2['title']}"; ?> (<?php echo "{$rowD2['doctype']}"; ?>)<br>
<?php
	}
?>
<?php }; ?>
<?php if ($row['docid3'] !== ''){ ?>
<?php
	$typeD3    = $row['docid3'];
	$queryD3  = "SELECT `id`, title, doctype FROM documents WHERE `id` = '$typeD3'";
	$resultD3 = mysqli_query($conn,$queryD3);

	while($rowD3 = $resultD3->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Document ID <?php echo "{$rowD3['id']}"; ?>) <?php echo "{$rowD3['title']}"; ?> (<?php echo "{$rowD3['doctype']}"; ?>)<br>
<?php
	}
?>
<?php }; ?>
<?php if ($row['calid'] !== ''){ ?>
<?php
	$typeCID    = $row['calid'];
	$queryCID  = "SELECT `int1`, title, event, date FROM calendar WHERE `int1` = '$typeCID'";
	$resultCID = mysqli_query($conn,$queryCID);

	while($rowCID = $resultCID->fetch_array(MYSQLI_ASSOC))
	{
?>
		        (Calendar ID <?php echo "{$rowCID['int1']}"; ?>) <?php echo "{$rowCID['title']}"; ?> (<?php echo "{$rowCID['event']}"; ?>) <?php echo "{$row7['date']}"; ?> <?php echo "{$row7['stime']}"; ?><br>
<?php
	}
?>
<?php }; ?>
</span>
			</td>
			<td><?php echo "{$row['int1']}"; ?></td>
      <td><?php echo "{$row['date']}"; ?></td>
      <td align="center" <?php if ($row['cc'] == ''){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['cc'] != ''){ ?>bgcolor="#ccffcc"<?php }; ?>><?php if ($row['cc'] !== ''){ ?>Y<?php }; ?><?php if ($row['cc'] == ''){ ?>N<?php }; ?></td>
      <td align="center" <?php if ($row['owner'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['owner'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['owner']}"; ?></td>
      <td align="center" <?php if ($row['lease'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['lease'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['lease']}"; ?></td>
      <td align="center" <?php if ($row['realtor'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['realtor'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php echo "{$row['realtor']}"; ?></td>
    </tr>
<!-- END DATABASE RESULTS -->
<?php
	}
?>
</tbody>
</table>
<br>
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Messages Control Panel Page<br></div>
</body>
</html>
