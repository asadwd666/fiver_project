<?php
require_once('../my-documents/php7-my-db.php');

if($_GET["access"] == "" && $_SESSION['webmaster']){
	$access = "webmaster";
}

else if($_GET["access"] == "" && $_SESSION['liaison']){
	$access = "liaison";
}

else if($_GET["access"] == "" && $_SESSION['concierge']){
	$access = "concierge";
}

else if($_GET["access"] == "" && $_SESSION['board']){
	$access = "board";
}

$webmaster = false;
$liaison = false;
$concierge = false;
$board = false;

$query = "SELECT `url`, `webmaster`, `liaison`, `concierge`, `board` FROM controlpanels where `id` = $current_page";
$result = mysqli_query($conn,$query) or die('Error, select query failed');
while($row = $result->fetch_array(MYSQLI_ASSOC)){
	$webmaster = $row['webmaster'];
	$liaison = $row['liaison'];
	$concierge = $row['concierge'];
	$board = $row['board'];
}
$access_granted = false;
if($webmaster || $liaison || $concierge || $board){
	$access_granted = false;
}
if($webmaster && ($_SESSION['webmaster'])){
	$access_granted = true;
}
if($liaison && $_SESSION['liaison']){
	$access_granted = true;
}
if($concierge && $_SESSION['concierge']){
	$access_granted = true;
}
if($board && $_SESSION['board']){
	$access_granted = true;
}
if(!$access_granted){
	header("Location: index.php");
	exit();
}
?>