<?php 

require_once('../my-documents/php7-my-db.php');

$redirect = false;

if($_GET["section"] == "owner" && !$_SESSION['owner']){
	$redirect = true;
}
if($_GET["section"] == "realtor" && !$_SESSION['realtor']){
	$redirect = true;
}
if($_GET["section"] == "lease" && !$_SESSION['lease']){
	$redirect = true;
}

if($_GET["section"] == "" && !$_SESSION['owner'] && !$_SESSION['realtor'] && !$_SESSION['lease']){
	$redirect = true;
}

if($_GET["section"] == "" && $_SESSION['owner']){
	$section = "webmaster";
	header("Location: index.php?section=owner");
}

else if($_GET["section"] == "" && $_SESSION['lease']){
	$section = "liaison";
	header("Location: index.php?section=lease");
}

else if($_GET["section"] == "" && $_SESSION['realtor']){
	$section = "concierge";
	header("Location: index.php?section=realtor");
}

else if($_GET["section"] != "owner" && $_GET["section"] != "lease" && $_GET["section"] != "realtor"){
	header("Location: index.php");
}

if($redirect){
	header("Location: ../splash/connect-login.php");
	exit();
}

?>