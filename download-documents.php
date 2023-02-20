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

// CHECK DOCUMENT PERMISSIONS
	$query  = "SELECT  `id`, owner, lease, realtor, board, public, doctype FROM documents WHERE `id` = '$id' LIMIT 1";
	$result = mysqli_query($dbConn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))

	if (((($row['doctype'] == 'Staff') 
		OR ($row['owner'] == 'Y' && $sessionowner == '1') 
		OR ($row['lease'] == 'Y' && $sessionlease == '1') 
		OR ($row['realtor'] == 'Y' && $sessionrealtor == '1') 
		OR ($row['board'] == 'Y' && $sessionboard == '1') 
		OR ($row['public'] != 'N')) 
		AND ($_SESSION['ghost'] != 'Y')) 
		OR ($_SESSION['webmaster'] == true))
	
	{

	
// VISITOR TRACKING
    $module = 'Downloaded Document';
    $page = preg_replace('/[^0-9]/', '', $_GET['id']);
    $community = $connName;
    $userid = $_SESSION['id'];
    $useripaddress = $_SERVER['REMOTE_ADDR'];
    $queryVISITOR = "INSERT INTO `visitors` (`useripaddress`, `userid`, `community`, `module`, `page`) VALUES ('$useripaddress', '$userid', '$community', '$module', '$page')";
    mysqli_query($conn,$queryVISITOR) or die('Error, insert visitor log failed');

// RETREIVE DOCUMENT
	$query = "SELECT name, type, size, content, docdate FROM documents WHERE id = '$id' AND docdate = '$docdate' AND size = '$size'";

	$result = mysqli_query($dbConn ,$query) or die('Error, query failed');
	list($name, $type, $size, $content, $title) =                      
		$result->fetch_array();

		header("Content-type: $type");
		header("Content-disposition: inline; filename=\"" . basename($name) . "\"");
		echo $content;
		ob_flush();

		exit();
	} else {

		header("Location: 900.php");
		exit();
	
	}

?>
