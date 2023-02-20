<?php

require_once('../my-documents/php7-my-db-up.php');

if(isset($_GET['id'])){

	$id    = $_GET['id'];
	$date    = $_GET['date'];
	$size    = $_GET['size'];
	$query = "SELECT name, type, size, content, date, doctype, title, created_date " . "FROM documentsrestricted WHERE id = '$id' AND date = '$date' AND size = '$size'";

	$result = mysqli_query($conn,$query) or die('Error, query failed');
	list($name, $type, $size, $content) =  $result->fetch_array();

		header("Content-length: $size");
		header("Content-type: $type");
		header("Content-Disposition: inline; filename=$name");
		echo $content;

	exit;
}

?>