<?php
	require_once('my-documents/php7-my-db.php');

    $connName = isset($_GET['conn']) ? $_GET['conn'] : "none";
    if (isset($connectionPool) && isset($connectionPool[$connName])) {
        $dbConn = $connectionPool[$connName]['connection'];
    } else {
        $dbConn = $conn;
    }

// CHECK PERMISSIONS
	if (((($_SESSION['owner'] == true) OR ($_SESSION['lease'] == true) OR ($_SESSION['realtor'] == true)) 
	AND ($_SESSION['ghost'] != 'Y')) 
	OR ($_SESSION['webmaster'] == true)){

	$mid    = preg_replace('/[^0-9]/', '', $_GET['mid']);
	$doc1    = preg_replace('/[^A-Z]/', '', $_GET['d1']);
	$doc2    = preg_replace('/[^A-Z]/', '', $_GET['d2']);
	$doc3    = preg_replace('/[^A-Z]/', '', $_GET['d3']);
	$date    = preg_replace('/[^0-9-]/', '', $_GET['date']);
	$table	= preg_replace('/[^A-Z,a-z,0-9]/', '', $_GET['table']);
	$queryEMB  = "SELECT `int1`, docid, docid2, docid3, `created_date` FROM $table WHERE `int1` = '$mid' AND `created_date` like '%$date%' LIMIT 1";
	$resultEMB = mysqli_query($dbConn,$queryEMB);

	while($rowEMB = $resultEMB->fetch_array(MYSQLI_ASSOC))

	if ($doc1 == 'Y'){

    // VISITOR TRACKING
        $module = 'Newsboard Article Linked Document';
        $page = $rowEMB['docid'];
        $community = $connName;
        $userid = $_SESSION['id'];
        $useripaddress = $_SERVER['REMOTE_ADDR'];
        $queryVISITOR = "INSERT INTO `visitors` (`useripaddress`, `userid`, `community`, `module`, `page`) VALUES ('$useripaddress', '$userid', '$community', '$module', '$page')";
        mysqli_query($conn,$queryVISITOR) or die('Error, insert visitor log failed');

		$docid = $rowEMB['docid'];
		$queryDOC = "SELECT name, type, size, content, title FROM documents WHERE `id` = '$docid'";

		$resultDOC = mysqli_query($dbConn,$queryDOC) or die('Error, query failed');
		list($name, $type, $size, $content, $title) =                      
			$resultDOC->fetch_array();

			header("Content-type: $type");
			header("Content-disposition: inline; filename=\"" . basename($name) . "\"");
			echo $content;
			ob_flush();

			exit();
	}
	
	elseif ($doc2 == 'Y'){
	    
    // VISITOR TRACKING
        $module = 'Newsboard Article Linked Document';
        $page2 = $rowEMB['docid2'];
        $community = $connName;
        $userid = $_SESSION['id'];
        $useripaddress = $_SERVER['REMOTE_ADDR'];
        $queryVISITOR = "INSERT INTO `visitors` (`useripaddress`, `userid`, `community`, `module`, `page`) VALUES ('$useripaddress', '$userid', '$community', '$module', '$page2')";
        mysqli_query($conn,$queryVISITOR) or die('Error, insert visitor log failed');

		$docid2 = $rowEMB['docid2'];
		$queryDOC = "SELECT name, type, size, content, title FROM documents WHERE `id` = '$docid2'";

		$resultDOC = mysqli_query($dbConn,$queryDOC) or die('Error, query failed');
		list($name, $type, $size, $content, $title) =                      
			$resultDOC->fetch_array();

			header("Content-type: $type");
			header("Content-disposition: inline; filename=\"" . basename($name) . "\"");
			echo $content;
			ob_flush();

			exit();
	}
	
	elseif ($doc3 == 'Y'){
	    
    // VISITOR TRACKING
        $module = 'Newsboard Article Linked Document';
        $page3 = $rowEMB['docid3'];
        $community = $connName;
        $userid = $_SESSION['id'];
        $useripaddress = $_SERVER['REMOTE_ADDR'];
        $queryVISITOR = "INSERT INTO `visitors` (`useripaddress`, `userid`, `community`, `module`, `page`) VALUES ('$useripaddress', '$userid', '$community', '$module', '$page3')";
        mysqli_query($conn,$queryVISITOR) or die('Error, insert visitor log failed');	    

		$docid3 = $rowEMB['docid3'];
		$queryDOC = "SELECT name, type, size, content, title FROM documents WHERE `id` = '$docid3'";

		$resultDOC = mysqli_query($dbConn,$queryDOC) or die('Error, query failed');
		list($name, $type, $size, $content, $title) =                      
			$resultDOC->fetch_array();

			header("Content-type: $type");
			header("Content-disposition: inline; filename=\"" . basename($name) . "\"");
			echo $content;
			ob_flush();

			exit();
	}
	 else {

		header("Location: 900.php");
		exit();
	}
	
	}
	
	else {

		header("Location: 900.php");
		exit();
	}
?>
