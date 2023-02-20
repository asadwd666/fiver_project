<?php
if (file_exists('my-documents/php7-my-db-display.php')) {
	require_once('my-documents/php7-my-db-display.php');
} else {
	require_once('my-documents/php7-my-db-up.php');
}

    $connName = isset($_GET['conn']) ? $_GET['conn'] : "none";

    if (isset($connectionPool) && isset($connectionPool[$connName])) {
        $dbConn = $connectionPool[$connName]['connection'];
    } else {
        $dbConn = $conn;
    }

	$id    = preg_replace('/[^0-9]/', '', $_GET['id']);
	$docdate    = preg_replace('/[^0-9-]/', '', $_GET['docdate']);
	$size    = preg_replace('/[^0-9]/', '', $_GET['size']);
	
	$query  = "SELECT  `id`, `type` FROM documents WHERE `id` = '$id' LIMIT 1";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))

	if (($row['type'] == 'image/jpeg') OR ($row['type'] == 'image/pjpeg') OR ($row['type'] == 'image/gif') OR ($row['type'] == 'image/png') OR ($row['type'] == 'video/mp4')) {

		$query = "SELECT `name`, `type`, `size`, `content`, `docdate` FROM `documents` WHERE `id` = '$id' AND `docdate` = '$docdate' AND `size` = '$size'";

		$result = mysqli_query($dbConn,$query) or die('Error, query failed');
		list($name, $type, $size, $content, $title) =                      
			$result->fetch_array();

			header("Content-type: $type");
			header("Content-disposition: inline; filename=\"" . basename($name) . "\"");
			echo $content;
			ob_flush();

			exit();

	}
?>
