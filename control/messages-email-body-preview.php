<?php echo $dnrMSG; ?><br>
<?php if ($row['from'] !== ''){ ?><small>Send replies to: <a href="mailto:<?php echo "{$row['from']}"; ?>?subject=Re: <?php echo "{$CommunityName}"; ?> - <?php echo "{$row['subject']}"; ?>"><?php echo "{$row['from']}"; ?></a></b></small><br><?php }; ?>

<div style="padding: 15px;">

    <?php echo "{$row['message']}"; ?>

    <?php if ($row['pic'] !== ''){ ?>
<?php
	$typeP1    = $row['pic'];
	$queryP1  = "SELECT title FROM documents WHERE `id` = '$typeP1'";
	$resultP1 = mysqli_query($conn,$queryP1);

	while($rowP1 = $resultP1->fetch_array(MYSQLI_ASSOC))
	{
?>
<div align="center" style="background-color:#ffffff; margin: 15px; overflow: hidden; border: 10px solid white; border-radius: 6px; box-shadow: 5px 5px 6px 1px #423F3E; -webkit-backface-visibility: hidden; -ms-backface-visibility: hidden; -moz-backface-visibility: hidden; backface-visibility: hidden; outline: 1px solid transparent;">
    <div align="center">
        <a href="<?php include('../my-documents/communityurl-ssl.html'); ?>/edoc2.php?mid=<?php echo "{$row['int1']}"; ?>&date=<?php echo date('Y-m-d'); ?>&p1=Y" target="_blank">
            <img style="width: 100%; border: 0px;" src="<?php include('../my-documents/communityurl-ssl.html'); ?>/edoc2.php?mid=<?php echo "{$row['int1']}"; ?>&date=<?php echo date('Y-m-d'); ?>&p1=Y">
        </a>
    </div>
</div>
<?php
	}
?>
    <?php }; ?>

</div>

<?php if ($row['calid'] !== ''){ ?>
<div style="background-color: #3c3c3c; color: white; padding: 10px; width: 95%">CALENDAR EVENT</div>
<?php
	$typeCID    = $row['calid'];
	$queryCID  = "SELECT * FROM calendar WHERE `int1` = '$typeCID'";
	$resultCID = mysqli_query($conn,$queryCID);

	while($rowCID = $resultCID->fetch_array(MYSQLI_ASSOC))
	{
?>

<div style="padding-left:25px; padding-right: 25px;">
<br><b><?php echo "{$rowCID['title']}"; ?></b><br>
<?php echo date('D, M d', strtotime($rowCID['date'])); ?> <?php if ($rowCID['stime'] !== ''){ ?>at <?php echo date('g:i a', strtotime($rowCID['stime'])); ?><?php }; ?><br><br>
</div>

<?php
	}
?>
<?php }; ?>
<?php if ($row['newsid'] !== ''){ ?>
<div style="background-color: #3c3c3c; color: white; padding: 10px; width: 95%">NEWSBOARD HEADLINES ON THE WEBSITE</div><br>
<?php
	$typeN1    = $row['newsid'];
	$queryN1  = "SELECT * FROM chalkboard WHERE `int1` = '$typeN1'";
	$resultN1 = mysqli_query($conn,$queryN1);

	while($rowN1 = $resultN1->fetch_array(MYSQLI_ASSOC))
	{
?>

<div style="padding-left:25px; padding-right: 25px;"><b><?php echo "{$rowN1['headline']}"; ?></b></div><br>

<?php
	}
?>
<?php }; ?>
<?php if ($row['newsid2'] !== ''){ ?>
<?php
	$typeN2    = $row['newsid2'];
	$queryN2  = "SELECT * FROM chalkboard WHERE `int1` = '$typeN2'";
	$resultN2 = mysqli_query($conn,$queryN2);

	while($rowN2 = $resultN2->fetch_array(MYSQLI_ASSOC))
	{
?>
<div style="padding-left:25px; padding-right: 25px;"><b><?php echo "{$rowN2['headline']}"; ?></b></div><br>

<?php
	}
?>
<?php }; ?>
<?php if ($row['newsid3'] !== ''){ ?>
<?php
	$typeN3    = $row['newsid3'];
	$queryN3  = "SELECT * FROM chalkboard WHERE `int1` = '$typeN3'";
	$resultN3 = mysqli_query($conn,$queryN3);

	while($rowN3 = $resultN3->fetch_array(MYSQLI_ASSOC))
	{
?>
<div style="padding-left:25px; padding-right: 25px;"><b><?php echo "{$rowN3['headline']}"; ?></b></div><br>

<?php
	}
?>
<?php }; ?>
<?php if ($row['docid'] !== ''){ ?>
<div style="background-color: #3c3c3c; color: white; padding: 10px; width: 95%">DOCUMENTS AVAILABLE TO DOWNLOAD</div><br>
<?php
	$typeD1    = $row['docid'];
	$queryD1  = "SELECT title FROM documents WHERE `id` = '$typeD1'";
	$resultD1 = mysqli_query($conn,$queryD1);

	while($rowD1 = $resultD1->fetch_array(MYSQLI_ASSOC))
	{
?>
<div style="padding-left:25px; padding-right: 25px;"><b><a href="<?php include('../my-documents/communityurl-ssl.html'); ?>/edoc2.php?mid=<?php echo "{$row['int1']}"; ?>&date=<?php echo date('Y-m-d', strtotime($row['date'])); ?>&d1=Y"><?php echo "{$rowD1['title']}"; ?></b></a></div><br>

<?php
	}
?>
<?php }; ?>
<?php if ($row['docid2'] !== ''){ ?>
<?php
	$typeD2    = $row['docid2'];
	$queryD2  = "SELECT title FROM documents WHERE `id` = '$typeD2'";
	$resultD2 = mysqli_query($conn,$queryD2);

	while($rowD2 = $resultD2->fetch_array(MYSQLI_ASSOC))
	{
?>
<div style="padding-left:25px; padding-right: 25px;"><b><a href="<?php include('../my-documents/communityurl-ssl.html'); ?>/edoc2.php?mid=<?php echo "{$row['int1']}"; ?>&date=<?php echo date('Y-m-d', strtotime($row['date'])); ?>&d2=Y"><?php echo "{$rowD2['title']}"; ?></a></b></div><br>

<?php
	}
?>
<?php }; ?>
<?php if ($row['docid3'] !== ''){ ?>
<?php
	$typeD3    = $row['docid3'];
	$queryD3  = "SELECT title FROM documents WHERE `id` = '$typeD3'";
	$resultD3 = mysqli_query($conn,$queryD3);

	while($rowD3 = $resultD3->fetch_array(MYSQLI_ASSOC))
	{
?>
<div style="padding-left:25px; padding-right: 25px;"><b><a href="<?php include('../my-documents/communityurl-ssl.html'); ?>/edoc2.php?mid=<?php echo "{$row['int1']}"; ?>&date=<?php echo date('Y-m-d', strtotime($row['date'])); ?>&d3=Y"><?php echo "{$rowD3['title']}"; ?></a></b></div><br>

<?php
	}
?>
<?php }; ?>
<br>
<img src='<?php include('../my-documents/communityurl-ssl.html'); ?>/pics/logo-small.png' style='max-width: 100px;'>
<br>
<br>
<p>Visit your <a href='<?php include('../my-documents/communityurl-ssl.html'); ?>'><?php echo $CommunityName; ?> community website</a>.</p>
<p>
<b>Email Subscription</b><br><small>You are receiving this email because you are a registered user of the <?php echo $CommunityName; ?> community website, operated by <a href='https://condosites.com' target='_blank'>CondoSites</a>.
<br><br><?php echo $dnrMSG; ?><br>
<?php if ($row['from'] !== ''){ ?><small>Send replies to: <a href="mailto:<?php echo "{$row['from']}"; ?>?subject=Re: <?php echo "{$CommunityName}"; ?> - <?php echo "{$row['subject']}"; ?>"><?php echo "{$row['from']}"; ?></a></b></small><?php }; ?>
<br>
<br>
<b><a href="<?php include('../my-documents/communityurl-ssl.html'); ?>/splash/connect-unsubscribe.php">Unsubscribe or update your email preferences.</a></b>
<br>
<b><a href='<?php include('../my-documents/communityurl-ssl.html'); ?>/spamhelp.php'>Are these emails being treated as spam?</a></b>
</small>
</p>