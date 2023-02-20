<?php
	require_once('my-documents/php7-my-db-up.php');
	$mid    = preg_replace('/[^0-9]/', '', $_GET['mid']);
	$pic    = preg_replace('/[^A-Z]/', '', $_GET['p1']);
	$doc1    = preg_replace('/[^A-Z]/', '', $_GET['d1']);
	$doc2    = preg_replace('/[^A-Z]/', '', $_GET['d2']);
	$doc3    = preg_replace('/[^A-Z]/', '', $_GET['d3']);
	$date    = preg_replace('/[^0-9-]/', '', $_GET['date']);
	$query  = "SELECT `int1`, pic, docid, docid2, docid3, date FROM messages WHERE `int1` = '$mid' AND `date` like '%$date%' LIMIT 1";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))

	if ($doc1 == 'Y'){

		$docid = $row['docid'];
		$queryDOC = "SELECT name, type, size, content, title FROM documents WHERE `id` = '$docid'";

		$resultDOC = mysqli_query($conn,$queryDOC) or die('Error, query failed');
		list($name, $type, $size, $content, $title) =                      
			$resultDOC->fetch_array();

			header("Content-type: $type");
			header("Content-disposition: attachment; filename=\"" . basename($name) . "\"");
			echo $content;
			ob_flush();

			exit();
	}
	
	elseif ($doc2 == 'Y'){

		$docid2 = $row['docid2'];
		$queryDOC = "SELECT name, type, size, content, title FROM documents WHERE `id` = '$docid2'";

		$resultDOC = mysqli_query($conn,$queryDOC) or die('Error, query failed');
		list($name, $type, $size, $content, $title) =                      
			$resultDOC->fetch_array();

			header("Content-type: $type");
			header("Content-disposition: attachment; filename=\"" . basename($name) . "\"");
			echo $content;
			ob_flush();

			exit();
	}
	
	elseif ($doc3 == 'Y'){

		$docid3 = $row['docid3'];
		$queryDOC = "SELECT name, type, size, content, title FROM documents WHERE `id` = '$docid3'";

		$resultDOC = mysqli_query($conn,$queryDOC) or die('Error, query failed');
		list($name, $type, $size, $content, $title) =                      
			$resultDOC->fetch_array();

			header("Content-type: $type");
			header("Content-disposition: attachment; filename=\"" . basename($name) . "\"");
			echo $content;
			ob_flush();

			exit();
	}
	
	elseif ($pic == 'Y'){

		$pic = $row['pic'];
		$queryDOC = "SELECT name, type, size, content, title FROM documents WHERE `id` = '$pic'";

		$resultDOC = mysqli_query($conn,$queryDOC) or die('Error, query failed');
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
?>