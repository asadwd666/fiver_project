<?php
	require_once('my-documents/php7-my-db.php');

    $connName = isset($_GET['conn']) ? $_GET['conn'] : "none";

    if (isset($connectionPool) && isset($connectionPool[$connName])) {
        $dbConn = $connectionPool[$connName]['connection'];
    } else {
        $dbConn = $conn;
    }

	
	$id    = preg_replace('/[^0-9]/', '', $_GET['id']);
	$docdate    = preg_replace('/[^0-9-]/', '', $_GET['docdate']);
	$size    = preg_replace('/[^0-9]/', '', $_GET['size']);
	
	$sessionowner = $_SESSION['owner'];
	$sessionlease = $_SESSION['lease'];
	$sessionrealtor = $_SESSION['realtor'];
	$sessionboard = $_SESSION['board'];
	$sessionid = $_SESSION['id'];
	
	$query  = "SELECT  `id`, owner, lease, realtor, board, public, type FROM documents WHERE `id` = '$id' LIMIT 1";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))

	if (($row['type'] == 'image/jpeg') OR ($row['type'] == 'image/pjpeg') OR ($row['type'] == 'image/gif') OR ($row['type'] == 'image/png') OR ($row['type'] == 'video/mp4')){
	
		if (($sessionowner == '1') OR ($sessionlease == '1') OR ($sessionrealtor == '1')){

		$query = "SELECT name, type, size, content, docdate FROM documents WHERE id = '$id' AND docdate = '$docdate' AND size = '$size'";

		$result = mysqli_query($dbConn,$query) or die('Error, query failed');
		list($name, $type, $size, $content, $title) =                      
			$result->fetch_array();

            $setauthcode = Rand(111111,999999);
            $currentdate = date('Ymd');
            $filename = "$setauthcode$currentdate$sessionid$name";

			header("Content-type: $type");
			header("Content-disposition: inline; filename=\"" . basename($filename) . "\"");
			echo $content;
			ob_flush();

			exit();
		} else {

			header("Location: 900.php");
			exit();
	
		}
	} else {

		header("Location: 900.php");
		exit();
	}
?>
