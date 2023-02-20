<?php $current_page = '31'; include('protect.php'); $int1 = $_POST["int1"]; $module = $_POST['module']; $action = $_POST["action"]; if ($action == "save"){

		$tabname = $_POST["tabname"];
		$title = preg_replace('/[^A-Za-z0-9- .]/', '', $_POST['title']);
		$owner = $_POST["owner"];
		$realtor = $_POST["realtor"];
		$public = $_POST["public"];
		$lease = $_POST["lease"];
		$digitaldisplay = $_POST["digitaldisplay"];
		$rednote = htmlspecialchars($_POST['rednote'], ENT_QUOTES);
		$image = $_POST["image"];
		$url = preg_replace('/[^a-zA-Z0-9 ]/', '', $_POST['title']);
		$iframe = $_POST["iframe"];
		$theircode = $_POST["theircode"];
		$pic = $_POST["pic"];
		$digitaldisplaymessage = $_POST["digitaldisplaymessage"];
		
		$query = "SELECT `title` FROM `tabs` WHERE `title` = '$title' AND `int1` != '$int1'";
		$result = mysqli_query($conn, $query);
		$folder_taken = false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$folder_taken = true;
		}
		if($folder_taken == true){
			$success = "false";
			$error = "<br>A Custom Module already exists with that name.";
			$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #FAFEB8; color: black;'><i class='fa fa-exclamation-triangle note' aria-hidden='true'></i> <strong>A Custom Module already exists with that name.</strong></div>";
		} else {
		    
		$query = "SELECT title FROM folders WHERE title = '$title' AND `int1` != '$int1'";
		$result = mysqli_query($conn, $query);
		$folder_taken = false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$folder_taken = true;
		}
		if($folder_taken == true){
			$success = "false";
			$error = "<br>A Folder already exists with that name.";
			$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #FAFEB8; color: black;'><i class='fa fa-exclamation-triangle note' aria-hidden='true'></i> <strong>A Folder already exists with that name.</strong></div>";
		} else {
		    
		$query = "SELECT `type` FROM `navigation` WHERE `type` = '$title'";
		$result = mysqli_query($conn, $query);
		$folder_taken = false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$folder_taken = true;
		}
		if($folder_taken == true){
			$success = "false";
			$error = "<br>A Navigation Column container already exists with that name.";
			$errorSUCCESS = "<div class='nav-section-header-cp' style='background-color: #FAFEB8; color: black;'><i class='fa fa-exclamation-triangle note' aria-hidden='true'></i> <strong>A Navigation Column container already exists with that name.</strong></div>";
		} else {

		$query = "UPDATE `tabs` SET `tabname` = '$tabname', `title` = '$title', `owner` = '$owner', `realtor` = '$realtor', `public` = '$public', `lease` = '$lease', `digitaldisplay` = '$digitaldisplay', `rednote` = '$rednote', `image` = '$image', `url` = '../modules/module.php?choice=$url' WHERE `int1`='$int1' LIMIT 1";
		mysqli_query($conn,$query) or die('Error, update query failed');

		$query = "UPDATE `3rd` SET `theircode` = '$theircode', `type` = '$title', `iframe` = '$iframe', `digitaldisplaymessage` = '$digitaldisplaymessage', `pic` = '$pic' WHERE `int1`='$int1' LIMIT 1";
		mysqli_query($conn,$query) or die('Error, update query failed');

		$folderold = $_POST["folderold"];
		$query = "UPDATE documents SET doctype='$title' WHERE doctype='$folderold'";
		mysqli_query($conn,$query) or die('Error, update query failed');
		
		$folderold = $_POST["folderold"];
		$query = "UPDATE folders SET tabname='$title' WHERE tabname='$folderold'";
		mysqli_query($conn,$query) or die('Error, update query failed');
		
		$folderold = $_POST["folderold"];
		$query = "UPDATE tabs SET tabname='$title' WHERE tabname='$folderold'";
		mysqli_query($conn,$query) or die('Error, update query failed');

		$date = date("F j, Y");
		$query = "UPDATE updatedate SET date='$date'";
		mysqli_query($conn,$query) or die('Error, updating update date failed');

		$useripaddress = $_SERVER['REMOTE_ADDR'];
		$userid = $_SESSION['id'];
		$id = $_POST['int1'];
		$query = "INSERT INTO log (action, tablename, useripaddress, userid, id) VALUES ('E', '3rd', '$useripaddress', '$userid', '$id')";
		mysqli_query($conn,$query) or die('Error, updating log failed');

		header('Location: '.$module);
		}
		}
		}
	}

	if ($action == "cancel"){

		header('Location: '.$module);
	}

?>
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<meta content="CondoSites - http://www.condosites.com" name="author">
<title>Control Panel</title>
<?php include('../control/cp-head-scripts.php'); ?>
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
<!-- LOGO AND NAVIGATION -->
<?php include('cp-navigation.php'); ?>
<!-- END LOGO AND NAVIGATION -->
<br>
<!-- INPUT FORM -->
<div class="nav-section-header-cp">
        <strong>Edit 3rd Party Code and Custom Content</strong>
</div>
<?php echo($errorSUCCESS); ?>
<?php
	$query  = "SELECT * FROM tabs WHERE `int1`='$int1' LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<div class="cp-form-container">
<!-- COLUMN 1 -->
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 10px 0px;">
<form enctype="multipart/form-data" method="POST" action="custommodules-edit.php">
                <div class="small-12 medium-12 columns"><strong>1) Let&apos;s start with the basics...</strong></div>
	        </div>
			<div class="row medium-collapse" style="padding-left: 30px;">
	            <div class="small-12 medium-5 columns"><label for="title" class="middle">Module Name<br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red"><b>Use only letters and numbers!</b> Other characters will be omited.</span></label></div>
	            <div class="small-12 medium-7 end columns"><input name="title" maxlength="100" class="form" type="text" placeholder="Pool Rules" value="<?php echo $row['title']; ?>" required autofocus></div>
	        </div>
			<div class="row medium-collapse" style="padding-left: 30px;">
	            <div class="small-12 medium-5 columns"><label for="rednote" class="middle">Note in red <i>(optional)</i><br><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">This text appears below the title.</span></label></div>
	            <div class="small-12 medium-7 end columns"><input name="rednote" maxlength="100" class="form" type="text" placeholder="Including hours and information" value="<?php echo $row['rednote']; ?>"></div>
	        </div>
			<div class="row" style="padding: 10px 10px 10px 0px;">
	            <div class="small-12 medium-12 columns"><strong>2) Choose an Icon</strong></div>
	        </div>
			<div class="row medium-collapse" style="padding-left: 30px;">
	            <div class="small-4 medium-4 end columns">
					<label for="image" class="middle">
					    <input type="radio" name="image" value='<i class="fa fa-dot-circle-o" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-dot-circle-o" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-dot-circle-o" aria-hidden="true"></i> Dot&nbsp;in&nbsp;Circle<br>
						<input type="radio" name="image" value='<i class="fa fa-ambulance" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-ambulance" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-ambulance" aria-hidden="true"></i> Ambulance<br>
						<input type="radio" name="image" value='<i class="fa fa-anchor" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-anchor" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-anchor" aria-hidden="true"></i> Anchor<br>
						<input type="radio" name="image" value='<i class="fa fa-archive" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-archive" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-archive" aria-hidden="true"></i> Archive<br>
						<input type="radio" name="image" value='<i class="fa fa-asterisk" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-asterisk" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-asterisk" aria-hidden="true"></i> Asterisk<br>
						<input type="radio" name="image" value='<i class="fa fa-at" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-at" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-at" aria-hidden="true"></i> &quot;At&quot;<br>
						<input type="radio" name="image" value='<i class="fa fa-bank" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-bank" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-bank" aria-hidden="true"></i> Bank<br>
						<input type="radio" name="image" value='<i class="fa fa-bath" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-bath" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-bath" aria-hidden="true"></i> Bathtub<br>
						<input type="radio" name="image" value='<i class="fa fa-bed" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-bed" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-bed" aria-hidden="true"></i> Bed<br>
						<input type="radio" name="image" value='<i class="fa fa-bell" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-bell" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-bell" aria-hidden="true"></i> Bell<br>
						<input type="radio" name="image" value='<i class="fa fa-bicycle" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-bicycle" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-bicycle" aria-hidden="true"></i> Bicycle<br>
						<input type="radio" name="image" value='<i class="fa fa-binoculars" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-binoculars" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-binoculars" aria-hidden="true"></i> Binoculars<br>
						<input type="radio" name="image" value='<i class="fa fa-birthday-cake" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-birthday-cake" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-birthday-cake" aria-hidden="true"></i> Birthday&nbsp;Cake<br>
						<input type="radio" name="image" value='<i class="fa fa-bolt" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-bolt" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-bolt" aria-hidden="true"></i> Bolt<br>
						<input type="radio" name="image" value='<i class="fa fa-book" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-book" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-book" aria-hidden="true"></i> Book<br>
						<input type="radio" name="image" value='<i class="fa fa-bookmark" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-bookmark" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-bookmark" aria-hidden="true"></i> Bookmark<br>
						<input type="radio" name="image" value='<i class="fa fa-briefcase" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-briefcase" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-briefcase" aria-hidden="true"></i> Briefcase<br>
						<input type="radio" name="image" value='<i class="fa fa-bug" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-bug" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-bug" aria-hidden="true"></i> Bug<br>
						<input type="radio" name="image" value='<i class="fa fa-building-o" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-building-o" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-building-o" aria-hidden="true"></i> Building<br>
						<input type="radio" name="image" value='<i class="fa fa-bullhorn" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-bullhorn" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-bullhorn" aria-hidden="true"></i> Bullhorn<br>
						<input type="radio" name="image" value='<i class="fa fa-bus" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-bus" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-bus" aria-hidden="true"></i> Bus<br>
						<input type="radio" name="image" value='<i class="fa fa-camera-retro" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-camera-retro" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-camera-retro" aria-hidden="true"></i> Camera<br>
						<input type="radio" name="image" value='<i class="fa fa-car" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-car" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-car" aria-hidden="true"></i> Car<br>
						<input type="radio" name="image" value='<i class="fa fa-cirtificate" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-certificate" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-certificate" aria-hidden="true"></i> Certificate<br>
						<input type="radio" name="image" value='<i class="fa fa-area-chart" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-area-chart" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-area-chart" aria-hidden="true"></i> Chart (Area)<br>
						<input type="radio" name="image" value='<i class="fa fa-bar-chart" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-bar-chart" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-bar-chart" aria-hidden="true"></i> Chart (Bar)<br>
						<input type="radio" name="image" value='<i class="fa fa-check-circle" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-check-circle" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-check-circle" aria-hidden="true"></i> Check<br>
						<input type="radio" name="image" value='<i class="fa fa-child" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-child" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-child" aria-hidden="true"></i> Child<br>
						<input type="radio" name="image" value='<i class="fa fa-clock-o" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-clock-o" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-clock-o" aria-hidden="true"></i> Clock<br>
				</div>
				<div class="small-4 medium-4 end columns">
						<input type="radio" name="image" value='<i class="fa fa-comment" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-comment" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-comment" aria-hidden="true"></i> Comment<br>
						<input type="radio" name="image" value='<i class="fa fa-cutlery" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-cutlery" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-cutlery" aria-hidden="true"></i> Cutlery<br>
						<input type="radio" name="image" value='<i class="fa fa-film" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-film" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-film" aria-hidden="true"></i> Film<br>
						<input type="radio" name="image" value='<i class="fa fa-fire-extinguisher" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-fire-extinguisher" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-fire-extinguisher" aria-hidden="true"></i> Fire&nbsp;Extinguisher<br>
						<input type="radio" name="image" value='<i class="fa fa-flag" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-flag" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-flag" aria-hidden="true"></i> Flag<br>
						<input type="radio" name="image" value='<i class="fa fa-gavel" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-gavel" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-flag" aria-hidden="true"></i> Gavel<br>
						<input type="radio" name="image" value='<i class="fa fa-handshake-o" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-handshake-o" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-handshake-o" aria-hidden="true"></i> Handshake<br>
						<input type="radio" name="image" value='<i class="fa fa-heartbeat" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-heartbeat" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-heartbeat" aria-hidden="true"></i> Heartbeat<br>
						<input type="radio" name="image" value='<i class="fa fa-home" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-home" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-home" aria-hidden="true"></i> Home<br>
						<input type="radio" name="image" value='<i class="fa fa-key" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-key" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-key" aria-hidden="true"></i> Key<br>
						<input type="radio" name="image" value='<i class="fa fa-laptop" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-laptop" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-laptop" aria-hidden="true"></i> Laptop<br>
						<input type="radio" name="image" value='<i class="fa fa-leaf" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-leaf" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-leaf" aria-hidden="true"></i> Leaf<br>
						<input type="radio" name="image" value='<i class="fa fa-support" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-support" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-support" aria-hidden="true"></i> Life&nbsp;Ring<br>
						<input type="radio" name="image" value='<i class="fa fa-lightbulb-o" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-lightbulb-o" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> Lightbulb<br>
						<input type="radio" name="image" value='<i class="fa fa-lock" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-lock" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-lock" aria-hidden="true"></i> Lock<br>
						<input type="radio" name="image" value='<i class="fa fa-money" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-money" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-money" aria-hidden="true"></i> Money<br>
						<input type="radio" name="image" value='<i class="fa fa-motorcycle" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-motorcycle" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-motorcycle" aria-hidden="true"></i> Motorcycle<br>
						<input type="radio" name="image" value='<i class="fa fa-music" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-music" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-music" aria-hidden="true"></i> Music<br>
						<input type="radio" name="image" value='<i class="fa fa-paw" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-paw" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-paw" aria-hidden="true"></i> Paw<br>
						<input type="radio" name="image" value='<i class="fa fa-pie-chart" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-pie-chart" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-pie-chart" aria-hidden="true"></i> Pie Chart<br>
						<input type="radio" name="image" value='<i class="fa fa-phone" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-phone" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-phone" aria-hidden="true"></i> Phone<br>
						<input type="radio" name="image" value='<i class="fa fa-plane" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-plane" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-plane" aria-hidden="true"></i> Plane<br>
						<input type="radio" name="image" value='<i class="fa fa-plug" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-plug" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-plug" aria-hidden="true"></i> Plug<br>
						<input type="radio" name="image" value='<i class="fa fa-plus" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-plus" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-plus" aria-hidden="true"></i> Plus<br>
						<input type="radio" name="image" value='<i class="fa fa-print" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-print" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-print" aria-hidden="true"></i> Print<br>
						<input type="radio" name="image" value='<i class="fa fa-puzzle-piece" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-puzzle-piece" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-puzzle-piece" aria-hidden="true"></i> Puzzle&nbsp;Piece<br>
						<input type="radio" name="image" value='<i class="fa fa-question" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-question" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-question" aria-hidden="true"></i> Question<br>
						<input type="radio" name="image" value='<i class="fa fa-recycle" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-recycle" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-recycle" aria-hidden="true"></i> Recycle<br>
						<input type="radio" name="image" value='<i class="fa fa-road" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-road" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-road" aria-hidden="true"></i> Road<br>
				</div>
				<div class="small-4 medium-4 end columns">
						<input type="radio" name="image" value='<i class="fa fa-map-signs" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-map-signs" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-map-signs" aria-hidden="true"></i> Road Signs<br>
						<input type="radio" name="image" value='<i class="fa fa-user-secret" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-user-secret" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-user-secret" aria-hidden="true"></i> Secret Agent<br>
						<input type="radio" name="image" value='<i class="fa fa-ship" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-ship" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-ship" aria-hidden="true"></i> Ship<br>
						<input type="radio" name="image" value='<i class="fa fa-shopping-cart" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-shopping-cart" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-shopping-cart" aria-hidden="true"></i> Shopping&nbsp;Cart<br>
						<input type="radio" name="image" value='<i class="fa fa-american-sign-language-interpreting" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-american-sign-language-interpreting" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-american-sign-language-interpreting" aria-hidden="true"></i> Sign&nbsp;Language<br>
						<input type="radio" name="image" value='<i class="fa fa-smile-o" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-smile-o" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-smile-o" aria-hidden="true"></i> Smile<br>
						<input type="radio" name="image" value='<i class="fa fa-snowflake-o" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-snowflake-o" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-snowflake-o" aria-hidden="true"></i> Snowflake<br>
						<input type="radio" name="image" value='<i class="fa fa-soccer-ball-o" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-soccer-ball-o" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-soccer-ball-o" aria-hidden="true"></i> Soccer&nbsp;Ball<br>
						<input type="radio" name="image" value='<i class="fa fa-star" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-star" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-star" aria-hidden="true"></i> Star<br>
						<input type="radio" name="image" value='<i class="fa fa-suitcase" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-suitcase" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-suitcase" aria-hidden="true"></i> Suitcase<br>
						<input type="radio" name="image" value='<i class="fa fa-sun-o" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-sun-o" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-sun-o" aria-hidden="true"></i> Sun<br>
						<input type="radio" name="image" value='<i class="fa fa-tachometer" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-tachometer" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-tachometer" aria-hidden="true"></i> Tachometer<br>
						<input type="radio" name="image" value='<i class="fa fa-tags" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-tags" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-tags" aria-hidden="true"></i> Tags<br>
						<input type="radio" name="image" value='<i class="fa fa-tv" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-tv" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-tv" aria-hidden="true"></i> Television<br>
						<input type="radio" name="image" value='<i class="fa fa-thermometer-4" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-thermometer-4" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-thermometer-4" aria-hidden="true"></i> Thermometer<br>
						<input type="radio" name="image" value='<i class="fa fa-thumb-tack" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-thumb-tack" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-thumb-tack" aria-hidden="true"></i> Thumb&nbsp;tack<br>
						<input type="radio" name="image" value='<i class="fa fa-thumbs-up" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-thumbs-up" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-thumbs-up" aria-hidden="true"></i> Thumbs&nbsp;up<br>
						<input type="radio" name="image" value='<i class="fa fa-ticket" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-ticket" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-ticket" aria-hidden="true"></i> Ticket<br>
						<input type="radio" name="image" value='<i class="fa fa-train" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-train" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-train" aria-hidden="true"></i> Train<br>
						<input type="radio" name="image" value='<i class="fa fa-trash" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-trash" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-trash" aria-hidden="true"></i> Trash<br>
						<input type="radio" name="image" value='<i class="fa fa-tree" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-tree" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-tree" aria-hidden="true"></i> Tree<br>
						<input type="radio" name="image" value='<i class="fa fa-truck" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-truck" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-truck" aria-hidden="true"></i> Truck<br>
						<input type="radio" name="image" value='<i class="fa fa-umbrella" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-umbrella" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-umbrella" aria-hidden="true"></i> Umbrella<br>
						<input type="radio" name="image" value='<i class="fa fa-user-circle" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-user-circle" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-user-circle" aria-hidden="true"></i> User<br>
						<input type="radio" name="image" value='<i class="fa fa-video-camera" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-video-camera" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-video-camera" aria-hidden="true"></i> Video Camera<br>
						<input type="radio" name="image" value='<i class="fa fa-warning" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-warning" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-warning" aria-hidden="true"></i> Warning<br>
						<input type="radio" name="image" value='<i class="fa fa-wifi" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-wifi" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-wifi" aria-hidden="true"></i> WiFi<br>
						<input type="radio" name="image" value='<i class="fa fa-wheelchair" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-wheelchair" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-wheelchair" aria-hidden="true"></i> Wheelchair<br>
						<input type="radio" name="image" value='<i class="fa fa-wrench" aria-hidden="true"></i>' <?php if ($row['image'] == '<i class="fa fa-wrench" aria-hidden="true"></i>'){ ?>checked<?php }; ?>> <i class="fa fa-wrench" aria-hidden="true"></i> Wrench<br>
					</label>
				</div>
	        </div>

	    </div>
	<!-- END COLUMN 1 -->
	<!-- COLUMN 2 -->
	    <div class="small-12 medium-12 large-6 columns">
	        <div class="row" style="padding: 10px 10px 10px 0px;">
	            <div class="small-12 medium-12 columns"><strong>3) What would you like to say?</strong></div>
	        </div>
	        <div class="row medium-collapse" style="padding-left: 30px; padding-bottom: 20px;">
			    <div class="small-12 medium-12 columns">
			        <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">If pasting content from Microsoft Word, use the "Paste from Word" ( <img src="https://condosites.net/commons/pastefromword.png" width="15"> ) button.</span><br>
			        <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Use the Styles pulldown to apply <b><span class="bluepen">c</span><span class="greenpen">o</span><span class="bluepen">l</span><span class="greenpen">o</span><span class="bluepen">r</span></b> and formatting <span class="marker">styles</span> to your text.</span>
				    <textarea name="theircode" cols="30" rows="2" id="editor1" class="form" type="text" placeholder="Enter your desired text here" required>
					<?php
					$int = $row['int1'];
					$queryTC  = "SELECT `theircode` FROM `3rd` WHERE `int1` = '$int'";
					$resultTC = mysqli_query($conn,$queryTC);

					while($rowTC = $resultTC->fetch_array(MYSQLI_ASSOC))
					{
					?>
					<?php echo "{$rowTC['theircode']}"; ?>
					<?php
					} ?>
				    </textarea>
				    <script>CKEDITOR.replace( 'editor1' );</script>

			    </div>
			    
		    </div>
            <div class="row medium-collapse" style="padding-left: 30px;">
                <div class="small-12 medium-12 end columns" style="padding-bottom: 10px;">
                    <?php
					$int = $row['int1'];
					$queryIF  = "SELECT `iframe`, `digitaldisplaymessage` FROM `3rd` WHERE `int1` = '$int'";
					$resultIF = mysqli_query($conn,$queryIF);

					while($rowIF = $resultIF->fetch_array(MYSQLI_ASSOC)) { ?>
					
					<?php if ($rowIF['digitaldisplaymessage'] == ''){ ?>
                <label for="digitaldisplaymessage" class="middle" style="margin-bottom: -5px;">
                    <input type="checkbox" name="digitaldisplaymessage" onclick="showMe('digitaldisplaymessage', this)" /> Summary for <a href="http://condosites.com/digitalsignage.php" target="_blank"><b>Digital Information Display</b></a></label>
                <div id="digitaldisplaymessage" style="display:none">
                        <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Text entered here will show instead of the above main body of text on your Digital Display.</span><br>
                        <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">If pasting content from Microsoft Word, use the "Paste from Word" ( <img src="https://condosites.net/commons/pastefromword.png" width="15"> ) button.</span><br>
    			        <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Use the Styles pulldown to apply <b><span class="bluepen">c</span><span class="greenpen">o</span><span class="bluepen">l</span><span class="greenpen">o</span><span class="bluepen">r</span></b> and formatting <span class="marker">styles</span> to your text.</span>
                    <textarea name="digitaldisplaymessage" cols="30" rows="2" id="editor2" class="form" type="text"><?php echo "{$rowIF['digitaldisplaymessage']}"; ?></textarea>
                    <script>CKEDITOR.replace( 'editor2' );</script>
                </div>
                <?php }; ?>
                
                <?php if ($rowIF['digitaldisplaymessage'] != ''){ ?>
                <label for="digitaldisplaymessage" class="middle" style="margin-bottom: -5px;">Summary for <a href="http://condosites.com/digitalsignage.php" target="_blank"><b>Digital Information Display</b></a></label>
                <div id="digitaldisplaymessage">
                    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Text entered here will show instead of the above main body of text on your Digital Display.</span><br>
                    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">If pasting content from Microsoft Word, use the "Paste from Word" ( <img src="https://condosites.net/commons/pastefromword.png" width="15"> ) button.</span><br>
    			    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Use the Styles pulldown to apply <b><span class="bluepen">c</span><span class="greenpen">o</span><span class="bluepen">l</span><span class="greenpen">o</span><span class="bluepen">r</span></b> and formatting <span class="marker">styles</span> to your text.</span>
                    <textarea name="digitaldisplaymessage" cols="30" rows="2" id="editor3" class="form" type="text"><?php echo "{$rowIF['digitaldisplaymessage']}"; ?></textarea>
                <script>CKEDITOR.replace( 'editor3' );</script>
                </div>
                <?php }; ?>

                        <?php if ($rowIF['iframe'] == ''){ ?>
                        <label for="iframeQ" class="middle" style="margin-bottom: -5px;"><input type="checkbox" name="iframeQ" onclick="showMe('iframe', this)" /> Add Optional iFrame Code &nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">From websites like YouTube.</span></label>
                        <div id="iframe" style="display:none">
                            <textarea name="iframe" cols="30" rows="2" class="form" type="text"><?php echo "{$rowIF['iframe']}"; ?></textarea>
                        </div>
                        <?php }; ?>
                        <?php if ($rowIF['iframe'] != ''){ ?>
                        <label for="iframeQ" class="middle" style="margin-bottom: -5px;">Optional iFrame Code &nbsp;&nbsp;<i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">From websites like YouTube.</span></label>
                        <div id="iframe">
                            <textarea name="iframe" cols="30" rows="2" class="form" type="text"><?php echo "{$rowIF['iframe']}"; ?></textarea>
                        </div>
                        <?php }; ?>

					<?php } ?>
                </div>
            </div>
            <div class="row medium-collapse" style="padding-left: 30px;">
                <div class="small-12 medium-5 columns"><label for="utility" class="middle">Add a Photo to the Body of Text</label></div>
                <div class="small-12 medium-7 end columns">

<select name="pic">
<?php
	$int = $row['int1'];
	$queryIF  = "SELECT `pic` FROM `3rd` WHERE `int1` = '$int'";
	$resultIF = mysqli_query($conn,$queryIF);

	while($rowIF = $resultIF->fetch_array(MYSQLI_ASSOC))
	{
?>
	
<?php
	$type    = $rowIF['pic'];
	$query41  = "SELECT `id`, `title`, `doctype` FROM `documents` WHERE `id` = '$type'";
	$result41 = mysqli_query($conn,$query41);

	while($row41 = $result41->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$rowIF['pic']}"; ?>"><?php echo "{$row41['id']}"; ?> - <?php echo "{$row41['title']}"; ?> (<?php echo "{$row41['doctype']}"; ?>)</option>
<?php
	}
?>
<?php } ?>
<option value="" disabled> </option>
<?php if ($row['pic'] == ''){ ?><option value="">None</option><?php }; ?>
<option value="" disabled> </option>
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
	        <div class="row" style="padding: 10px 10px 10px 0px;">
	            <div class="small-12 medium-12 columns"><strong>4) Location, location, location!</strong></div>
	        </div>
	        <div class="row medium-collapse" style="padding-left: 30px;">
	            <div class="small-12 medium-5 columns"><label for="tabname" class="middle">Where should this appear?</label></div>
	            <div class="small-12 medium-7 end columns">
					<select name="tabname" required>
					<option value="<?php echo "{$row['tabname']}"; ?>"><?php echo "{$row['tabname']}"; ?>
					<option value="">Select a location to place the module.</option>
					<option value="" disabled></option>
					<option value="" disabled>***Navigation Column***</option>
					<?php
					$queryF  = "SELECT type FROM navigation WHERE `link` = 'Y' ORDER BY type";
					$resultF = mysqli_query($conn,$queryF);

					while($rowF = $resultF->fetch_array(MYSQLI_ASSOC))
					{
					?>
					<option value="<?php echo "{$rowF['type']}"; ?>"><?php echo "{$rowF['type']}"; ?></option>
					<?php
					}
					?>
					</select>
				</div>
	        </div>
			<div class="row" style="padding: 10px 10px 10px 0px;">
	            <div class="small-12 medium-12 columns"><strong>5) Who should have access to this module?</strong></div>
	        </div>
					<?php if ($row['owner'] !== 'X'){ ?>
					        <div class="row medium-collapse" style="padding-left: 30px;">
					            <div class="small-12 medium-5 columns"><label for="owner" class="middle">Show in <b>Owner</b> Section? </label></div>
					            <div class="small-12 medium-2 end columns" style="padding-right: 15px;">
					<select name="owner" class="form">
					<option value="Y" <?php if($row['owner'] == "Y"){ echo("SELECTED"); } ?>>Yes</option>
					<option value="N" <?php if($row['owner'] == "N"){ echo("SELECTED"); } ?>>No</option>
					</select>
					            </div>
					        </div>
					<?php }; ?>
					<?php if ($row['lease'] !== 'X'){ ?>
					        <div class="row medium-collapse" style="padding-left: 30px;">
					            <div class="small-12 medium-5 columns"><label for="lease" class="middle">Show in <b>Renter</b> Section? </label></div>
					            <div class="small-12 medium-2 end columns" style="padding-right: 15px;">
					<select name="lease" class="form">
					<option value="N" <?php if($row['lease'] == "N"){ echo("SELECTED"); } ?>>No</option>
					<option value="Y" <?php if($row['lease'] == "Y"){ echo("SELECTED"); } ?>>Yes</option>
					</select>
					            </div>
					        </div>
					<?php }; ?>
					<?php if ($row['realtor'] !== 'X'){ ?>
					        <div class="row medium-collapse" style="padding-left: 30px;">
					            <div class="small-12 medium-5 columns"><label for="realtor" class="middle">Show in <b>Realtor</b> Section? </label></div>
					            <div class="small-12 medium-2 end columns" style="padding-right: 15px;">
					<select name="realtor" class="form">
					<option value="N" <?php if($row['realtor'] == "N"){ echo("SELECTED"); } ?>>No</option>
					<option value="Y" <?php if($row['realtor'] == "Y"){ echo("SELECTED"); } ?>>Yes</option>
					</select>
					            </div>
					        </div>
					<?php }; ?>
					<?php if ($row['public'] !== 'X'){ ?>
					        <div class="row medium-collapse" style="padding-left: 30px;">
                                <div class="small-12 medium-5 columns"><label for="public" class="middle">Show in <b>Public/Home</b> Page?</label></div>
                                <div class="small-12 medium-2 end columns" style="padding-right: 15px;">
                    <select name="public" class="form">
                    <option value="N" <?php if($row['public'] == "N"){ echo("SELECTED"); } ?>>No</option>
                    <option value="Y" <?php if($row['public'] == "Y"){ echo("SELECTED"); } ?>>Public</option>
                    <option value="H" <?php if($row['public'] == "H"){ echo("SELECTED"); } ?>>Home</option>
                    </select>
                                </div>
                            </div>
                            <div class="row medium-collapse" style="padding-left: 30px;">
                                <div class="small-12 medium-5 columns"><label for="realtor" class="middle">Show <a href="http://condosites.com/digitalsignage.php" target="_blank"><b>Digital Information Display</b></a>? </label></div>
                                <div class="small-12 medium-2 end columns" style="padding-right: 15px;">
                    <select name="digitaldisplay" class="form">
                    <option value="Y" <?php if($row['digitaldisplay'] == "Y"){ echo("SELECTED"); } ?>>Yes</option>
                    <option value="N" <?php if($row['digitaldisplay'] == "N"){ echo("SELECTED"); } ?>>No</option>
                    </select>
                                </div>
                            </div>
		                    <div class="row medium-collapse" style="padding-left: 30px;">
			                    <div class="small-12 medium-12 columns" style="margin-top: -15px; margin-bottom: 15px;">
				                    <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red"><strong>Home</strong> makes a document visible on the <strong>Home/Login</strong> page.</span><br>
			                        <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red"><strong>Public</strong> makes a document visible in a <strong>folder, photo gallery, or custom module</strong> without being logged in.</span>
                                </div>
		                    </div>
					<?php }; ?>
	        <div class="row" style="padding: 10px 10px 10px 0px;">
	            <div class="small-12 medium-6 columns"><strong>6) Ready to Save?</strong></div>
        </div>
        <div class="row medium-collapse">
            <div class="small-6 columns" align="center">
                <input type="hidden" name="action" value="save">
                <input type="hidden" name="module" value="<?php echo $_POST['module']; ?>">
                <input type="hidden" name="folderold" value="<?php echo "{$row['title']}"; ?>">
	            <input type="hidden" name="int1" value="<?php echo $_POST['int1']; ?>">
	            <input name="submit" value="Save" class="submit" type="submit">
                <?php echo($error); ?>
</form>
            </div>
            <div class="small-6 end columns" align="center">
<form name="CustomModuleCancel" method="POST">
                <input type="hidden" name="action" value="cancel">
                <input type="hidden" name="module" value="<?php echo $_POST['module']; ?>">
	            <input type="submit" value="Cancel" onclick="return confirm('Are you sure you wish to leave this page? Unsaved changes will be lost.');">
</form>
            </div>
        </div>
    </div>
<!-- COLUMN 2 -->
</div>
<?php
	}
?>
<!-- END INPUT FORM -->
</div>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Custom Content Edit Control Panel Page<br></div>
</body>
</html>
