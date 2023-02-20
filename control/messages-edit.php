<?php $current_page = '20'; include('protect.php'); $int1 = $_POST["int1"]; $action = $_POST["action"]; if ($action == "save"){

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

		$query = "UPDATE messages SET `from`='$from', subject='$subject', message='$message', pic='$pic', newsid='$newsid', newsid2='$newsid2', newsid3='$newsid3', docid='$docid', docid2='$docid2', docid3='$docid3', calid='$calid', userid='$userid', useripaddress='$useripaddress', unit2='$unit2', owner='$owner', lease='$lease', realtor='$realtor', club1='$club1', club2='$club2', club3='$club3', club4='$club4', club5='$club5', flag='$flag', cc='$cc' WHERE `int1`='$int1' LIMIT 1";
		mysqli_query($conn,$query) or die('Error, update query failed');

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['int1'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('E', 'Messages', '$useripaddress', '$userid', '$id')";
		mysqli_query($conn,$query) or die('Error, updating log failed');

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
<br>
<div style="max-width: 99%;">
<!-- INPUT FORM -->
<?php
	$query  = "SELECT * FROM messages WHERE `int1`='$int1' LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
	<div class="nav-section-header-cp">
		<strong>Edit a Message for Email</strong>
	</div>
	<div class="cp-form-container">
		<!-- COLUMN 1 -->
		<div class="small-12 medium-12 large-6 columns">
			<div class="row" style="padding: 10px 10px 0px 0px;">
<form enctype="multipart/form-data" method="POST" action="messages-edit.php">
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
					<div class="small-12 medium-6 end columns"><input name="subject" placeholder="Notice of annual meeting" maxlength="100" class="form" type="text" value="<?php echo "{$row['subject']}"; ?>" required></div>
				</div>
				<div class="row medium-collapse" style="padding-left: 30px;">
					<div class="small-12 medium-12 columns"><label for="message" class="middle">Email Message Body&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">10,000 characters max, including html formatting characters.</span><br>
	    				    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">If pasting content from Microsoft Word, use the "Paste from Word" ( <img src="https://condosites.net/commons/pastefromword.png" width="15"> ) button.</span><br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Use the Styles pulldown to apply <b><span class="bluepen">c</span><span class="greenpen">o</span><span class="bluepen">l</span><span class="greenpen">o</span><span class="bluepen">r</span></b> and formatting <span class="marker">styles</span> to your text.</span>
    					</label>
						<textarea name="message" cols="30" rows="10" id="editor1" class="form" type="text" placeholder="Type your email message here..." maxlength="9999" required><?php echo "{$row['message']}"; ?></textarea>
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
<?php if ($row['pic'] == ''){ ?><option value="">None</option><?php }; ?>
<?php
	$type    = $row['pic'];
	$query41  = "SELECT `id`, title, doctype FROM documents WHERE id = '$type'";
	$result41 = mysqli_query($conn,$query41);

	while($row41 = $result41->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$row['pic']}"; ?>"><?php echo "{$row41['id']}"; ?> - <?php echo "{$row41['title']}"; ?> (<?php echo "{$row41['doctype']}"; ?>)</option>
<?php
	}
?>
<option value=""> </option>
<option value="">None</option>
<option value=""> </option>
<?php
	$query  = "SELECT `id`, title, doctype FROM documents WHERE (type = 'image/jpeg' OR type = 'image/pjpeg' OR type = 'image/gif' OR type = 'image/png') AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY `id` DESC";
	$result = mysqli_query($conn, $query);

	while($row4 = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$row4['id']}"; ?>"><?php echo "{$row4['id']}"; ?> - <?php echo "{$row4['title']}"; ?> (<?php echo "{$row4['doctype']}"; ?>)</option>
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
						<?php if ($row['docid'] == ''){ ?><option value="">None</option><?php }; ?>
						<?php
							$type    = $row['docid'];
							$query11  = "SELECT `id`, title, doctype FROM documents WHERE id = '$type'";
							$result11 = mysqli_query($conn,$query11);

							while($row11 = $result11->fetch_array(MYSQLI_ASSOC))
							{
						?>
						<option value="<?php echo "{$row['docid']}"; ?>"><?php echo "{$row11['id']}"; ?> - <?php echo "{$row11['title']}"; ?> (<?php echo "{$row11['doctype']}"; ?>)</option>
						<?php
							}
						?>
						<option value=""> </option>
						<option value="">None</option>
						<option value=""> </option>
						<?php
							$query  = "SELECT `id`, title, doctype FROM documents ORDER BY `id` DESC";
							$result = mysqli_query($conn, $query);

							while($row1 = $result->fetch_array(MYSQLI_ASSOC))
							{
						?>
						<option value="<?php echo "{$row1['id']}"; ?>"><?php echo "{$row1['id']}"; ?> - <?php echo "{$row1['title']}"; ?> (<?php echo "{$row1['doctype']}"; ?>)</option>
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
						<?php if ($row['docid2'] == ''){ ?><option value="">None</option><?php }; ?>
						<?php
							$type    = $row['docid2'];
							$query21  = "SELECT `id`, title, doctype FROM documents WHERE id = '$type'";
							$result21 = mysqli_query($conn,$query21);

							while($row21 = $result21->fetch_array(MYSQLI_ASSOC))
							{
						?>
						<option value="<?php echo "{$row['docid2']}"; ?>"><?php echo "{$row21['id']}"; ?> - <?php echo "{$row21['title']}"; ?> (<?php echo "{$row21['doctype']}"; ?>)</option>
						<?php
							}
						?>
						<option value=""></option>
						<option value="">None</option>
						<option value=""></option>
						<?php
							$query  = "SELECT `id`, title, doctype FROM documents ORDER BY `id` DESC";
							$result = mysqli_query($conn, $query);

							while($row2 = $result->fetch_array(MYSQLI_ASSOC))
							{
						?>
						<option value="<?php echo "{$row2['id']}"; ?>"><?php echo "{$row2['id']}"; ?> - <?php echo "{$row2['title']}"; ?> (<?php echo "{$row2['doctype']}"; ?>)</option>
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
						<?php if ($row['docid3'] == ''){ ?><option value="">None</option><?php }; ?>
						<?php
							$type    = $row['docid3'];
							$query31  = "SELECT `id`, title, doctype FROM documents WHERE id = '$type'";
							$result31 = mysqli_query($conn,$query31);

							while($row31 = $result31->fetch_array(MYSQLI_ASSOC))
							{
						?>
						<option value="<?php echo "{$row['docid3']}"; ?>"><?php echo "{$row31['id']}"; ?> - <?php echo "{$row31['title']}"; ?> (<?php echo "{$row31['doctype']}"; ?>)</option>
						<?php
							}
						?>
						<option value=""> </option>
						<option value="">None</option>
						<option value=""> </option>
						<?php
							$query  = "SELECT `id`, title, doctype FROM documents ORDER BY `id` DESC";
							$result = mysqli_query($conn, $query);

							while($row3 = $result->fetch_array(MYSQLI_ASSOC))
							{
						?>
						<option value="<?php echo "{$row3['id']}"; ?>"><?php echo "{$row3['id']}"; ?> - <?php echo "{$row3['title']}"; ?> (<?php echo "{$row3['doctype']}"; ?>)</option>
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
						<?php if ($row['calid'] == ''){ ?><option value="">None</option><?php }; ?>
						<?php
							$type    = $row['calid'];
							$query71  = "SELECT `int1`, title, date, stime, event FROM calendar WHERE `int1` = '$type'";
							$result71 = mysqli_query($conn,$query71);

							while($row71 = $result71->fetch_array(MYSQLI_ASSOC))
							{
						?>
						<option value="<?php echo "{$row['calid']}"; ?>"><?php echo "{$row71['int1']}"; ?> - <?php echo "{$row71['title']}"; ?>  (<?php echo "{$row71['event']}"; ?>) <?php echo "{$row71['date']}"; ?> <?php echo "{$row71['stime']}"; ?></option>
						<?php
							}
						?>
						<option value=""> </option>
						<option value="">None</option>
						<option value=""> </option>
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
						<?php if ($row['newsid'] == ''){ ?><option value="">None</option><?php }; ?>
						<?php
							$type    = $row['newsid'];
							$queryN1  = "SELECT `int1`, headline, pod FROM chalkboard WHERE `int1` = '$type'";
							$resultN1 = mysqli_query($conn,$queryN1);

							while($rowN1 = $resultN1->fetch_array(MYSQLI_ASSOC))
							{
						?>
						<option value="<?php echo "{$row['newsid']}"; ?>"><?php echo "{$rowN1['int1']}"; ?> - <?php echo "{$rowN1['headline']}"; ?> (<?php echo "{$rowN1['pod']}"; ?>)</option>
						<?php
							}
						?>
						<option value=""> </option>
						<option value="">None</option>
						<option value=""> </option>
						<?php
							$query  = "SELECT `int1`, headline, pod FROM chalkboard where eod > CURRENT_DATE() ORDER BY `int1` DESC";
							$result = mysqli_query($conn, $query);

							while($row1 = $result->fetch_array(MYSQLI_ASSOC))
							{
						?>
						<option value="<?php echo "{$row1['int1']}"; ?>"><?php echo "{$row1['int1']}"; ?> - <?php echo "{$row1['headline']}"; ?> (<?php echo "{$row1['pod']}"; ?>)</option>
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
						<?php if ($row['newsid2'] == ''){ ?><option value="">None</option><?php }; ?>
						<?php
							$type    = $row['newsid2'];
							$queryN2  = "SELECT `int1`, headline, pod FROM chalkboard WHERE `int1` = '$type'";
							$resultN2 = mysqli_query($conn,$queryN2);

							while($rowN2 = $resultN2->fetch_array(MYSQLI_ASSOC))
							{
						?>
						<option value="<?php echo "{$row['newsid2']}"; ?>"><?php echo "{$rowN2['int1']}"; ?> - <?php echo "{$rowN2['headline']}"; ?> (<?php echo "{$rowN2['pod']}"; ?>)</option>
						<?php
							}
						?>
						<option value=""> </option>
						<option value="">None</option>
						<option value=""> </option>
						<?php
							$query  = "SELECT `int1`, headline, pod FROM chalkboard where eod > CURRENT_DATE() ORDER BY `int1` DESC";
							$result = mysqli_query($conn, $query);

							while($row2 = $result->fetch_array(MYSQLI_ASSOC))
							{
						?>
						<option value="<?php echo "{$row2['int1']}"; ?>"><?php echo "{$row2['int1']}"; ?> - <?php echo "{$row2['headline']}"; ?> (<?php echo "{$row2['pod']}"; ?>)</option>
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
						<?php if ($row['newsid3'] == ''){ ?><option value="">None</option><?php }; ?>
						<?php
							$type    = $row['newsid3'];
							$queryN3  = "SELECT `int1`, headline, pod FROM chalkboard WHERE `int1` = '$type'";
							$resultN3 = mysqli_query($conn,$queryN3);

							while($rowN3 = $resultN3->fetch_array(MYSQLI_ASSOC))
							{
						?>
						<option value="<?php echo "{$row['newsid3']}"; ?>"><?php echo "{$rowN3['int1']}"; ?> - <?php echo "{$rowN3['headline']}"; ?> (<?php echo "{$rowN3['pod']}"; ?>)</option>
						<?php
							}
						?>
						<option value=""> </option>
						<option value="">None</option>
						<option value=""> </option>
						<?php
							$query  = "SELECT `int1`, headline, pod FROM chalkboard where eod > CURRENT_DATE() ORDER BY `int1` DESC";
							$result = mysqli_query($conn, $query);

							while($row3 = $result->fetch_array(MYSQLI_ASSOC))
							{
						?>
						<option value="<?php echo "{$row3['int1']}"; ?>"><?php echo "{$row3['int1']}"; ?> - <?php echo "{$row3['headline']}"; ?> (<?php echo "{$row3['pod']}"; ?>)</option>
						<?php
							}
						?>
						</select>
					</div>
				</div>
				<div class="row" style="padding: 10px 10px 0px 0px;">
					<div class="small-12 medium-12 columns">
					    <strong>5) Is this a Group Email or Individual Email?</strong>
					</div>
				</div>
                <div class="row medium-collapse" style="padding-left: 30px;">
					<div class="small-12 medium-12 end columns">
						<label for="mass" class="middle">
							<input type="radio" name="mass" value="group" <?php if ($row['cc'] == ''){ ?>checked<?php }; ?> onclick="show1();" />&nbsp;Group &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="mass" value="individual" <?php if ($row['cc'] != ''){ ?>checked<?php }; ?> onclick="show2();" />&nbsp;Individual
						</label>
					</div>
				</div>


        <div id="div1" <?php if ($row['cc'] == ''){ ?>style="display:block"<?php }; ?><?php if ($row['cc'] != ''){ ?>style="display:none"<?php }; ?>>
				<div class="row" style="padding: 10px 10px 0px 0px;">
					<div class="small-12 medium-12 columns">
					    <strong>6) Who should receive this email?</strong>
					</div>
				</div>
				<div class="row medium-collapse" style="padding-left: 30px;">
					<div class="small-12 medium-6 columns"><label for="flag" class="middle">Set the priority of the email<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Use "Urgent" option responsibly!</span></label></div>
					<div class="small-12 medium-6 end columns">
						<label for="flag" class="middle">
							<input type="radio" name="flag" value="A" <?php if($row['flag'] == 'A'){ ?>checked<?php }; ?>>&nbsp;Standard &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="flag" value="U" <?php if($row['flag'] == 'U'){ ?>checked<?php }; ?>>&nbsp;Urgent
						</label>
					</div>
				</div>

<?php $sqlU2 = mysqli_query($conn,"SELECT count(*) FROM users WHERE unit2 != 'X'") or die(mysqli_error($conn));
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
	<option value="Y" <?php if($row['owner'] == 'Y'){ echo("SELECTED"); } ?>>Yes</option>
	<option value="N" <?php if($row['owner'] == 'N'){ echo("SELECTED"); } ?>>No</option>
</select>
					</div>
				</div>
				<div class="row medium-collapse" style="padding-left: 30px;">
					<div class="small-12 medium-4 columns"><label for="lease" class="middle">Send to <b>Renters</b>?</label></div>
					<div class="small-12 medium-2 end columns" style="padding-right: 15px;">
<select name="lease" class="form">
	<option value="Y" <?php if($row['lease'] == 'Y'){ echo("SELECTED"); } ?>>Yes</option>
	<option value="N" <?php if($row['lease'] == 'N'){ echo("SELECTED"); } ?>>No</option>
</select>
					</div>
				</div>
				<div class="row medium-collapse" style="padding-left: 30px;">
					<div class="small-12 medium-4 columns"><label for="realtor" class="middle">Send to <b>Realtors</b>?</label></div>
					<div class="small-12 medium-2 end columns" style="padding-right: 15px;">
<select name="realtor" class="form">
	<option value="Y" <?php if($row['realtor'] == 'Y'){ echo("SELECTED"); } ?>>Yes</option>
	<option value="N" <?php if($row['realtor'] == 'N'){ echo("SELECTED"); } ?>>No</option>
</select>
					</div>
				</div>
				
<?php include('../my-documents/user-club-control.php'); ?>

        </div>

        <div id="div2" <?php if ($row['cc'] == ''){ ?>style="display:none"<?php }; ?><?php if ($row['cc'] != ''){ ?>style="display:block"<?php }; ?>>
                <div class="row" style="padding: 10px 10px 0px 0px;">
					<div class="small-12 medium-12 columns">
					    <strong>6) Who should receive this email?</strong>
					</div>
		        </div>
				<div class="row medium-collapse" style="padding-left: 30px;">
					<div class="small-12 medium-4 columns"><label for="" class="middle">Select individual</label></div>
					<div class="small-12 medium-8 end columns">
<select name="cc" autofocus>
<?php if ($row['cc'] == ''){ ?><option value="">Select User</option><?php }; ?>
<?php
	$type    = $row['cc'];
	$query1  = "SELECT id, unit, unit2, last_name, first_name, email, phone FROM users WHERE id = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$row1['id']}"; ?>"><?php echo "{$row1['last_name']}"; ?>, <?php echo "{$row1['first_name']}"; ?> (<?php echo "{$row1['unit']}"; ?><?php if ($row1['unit2'] !== 'X'){ ?> - <?php echo "{$row1['unit2']}"; ?><?php }; ?>)</option>
<?php
	}
?>
<option value="" disabled>
<?php
	$query  = "SELECT id, unit, unit2, last_name, first_name, email, phone FROM users WHERE ghost != 'Y' ORDER BY `last_name`";
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
					<div class="small-12 medium-12 columns"><strong>6) Ready to Save?</strong>
				</div>
				<div class="row medium-collapse" style="padding-left: 30px; padding-bottom: 20px;">
					<div class="small-6 columns" align="center">
						<input type="hidden" name="action" value="save">
						<input type="hidden" name="int1" value="<?php echo $_POST['int1']; ?>">
						<input name="submit" value="Save Draft" class="submit" type="submit" onclick="value='Processing Request - Resubmit'; style='color:red';" />
</form>
					</div>
					<div class="small-6 columns" align="center">
<form action="messages.php" method="get">
<input type="submit" value="Cancel" onclick="return confirm('Are you sure you wish to leave this page? Unsaved changes will be lost.');">
</form>
						<?php echo($error); ?>
					</div>
				</div>
			</div>
		</div>
		<!-- END COLUMN 2 -->
	</div>
<?php
	}
?>
<!-- END INPUT FORM -->
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Messages Edit Control Panel Page<br></div>
</body>
</html>
