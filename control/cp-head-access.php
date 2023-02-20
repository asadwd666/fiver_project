<?php 

$access = $_GET["access"];
$redirect = false;


if($_GET["access"] == "" && !$_SESSION['webmaster'] && !$_SESSION['liaison'] && !$_SESSION['concierge'] && !$_SESSION['board']){
	$redirect = true;
}
if($_GET["access"] == "webmaster" && !$_SESSION['webmaster']){
	$redirect = true;
}
if($_GET["access"] == "liaison" && !$_SESSION['liaison']){
	$redirect = true;
}
if($_GET["access"] == "concierge" && !$_SESSION['concierge']){
	$redirect = true;
}
if($_GET["access"] == "board" && !$_SESSION['board']){
	$redirect = true;
}


if($_GET["access"] == "" && $_SESSION['webmaster']){
	$access = "webmaster";
	header("Location: ../control/index-control.php?access=webmaster");
}

else if($_GET["access"] == "" && $_SESSION['liaison']){
	$access = "liaison";
	header("Location: ../control/index-control.php?access=liaison");
}

else if($_GET["access"] == "" && $_SESSION['concierge']){
	$access = "concierge";
	header("Location: ../control/index-control.php?access=concierge");
}

else if($_GET["access"] == "" && $_SESSION['board']){
	$access = "board";
	header("Location: ../control/index-control.php?access=board");
}

if ($redirect){
	header("Location: index.php");
	exit();
}

?>