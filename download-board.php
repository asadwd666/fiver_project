<?php

require_once('my-documents/php7-my-db-up.php');

$connName = isset($_GET['conn']) ? $_GET['conn'] : "none";

if (isset($connectionPool) && isset($connectionPool[$connName])) {
    $dbConn = $connectionPool[$connName]['connection'];
} else {
    $dbConn = $conn;
}

if(isset($_GET['id'])){

	$id    = preg_replace('/[^0-9]/', '', $_GET['id']);
	$query = "SELECT name, type, size, content FROM board WHERE id = '$id'";

	$result = mysqli_query($dbConn,$query) or die('Error, query failed');
	list($name, $type, $size, $content) =                             
		$result->fetch_array();

		header("Content-type: $type");
		header("Content-Disposition: inline; filename=\"" . basename($name) . "\"");
		echo $content;
		ob_flush();

	exit;
}

?>