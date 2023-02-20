<?php 

if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) 
	ob_start("ob_gzhandler"); else ob_start(); 

	$CommunityName = "Islandia 1";
	$dbhost = 'localhost';
	$dbuser = 'nodyss5_iLand1a1';
	$dbpass = 'SR79k4y&$XX%f5n4z;Uw(.,9h!e3~yAC]ah)';
	$dbname = 'nodyss5_islandiaone';
    
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
   	if ($conn->connect_error) {
        	die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
    }

	if(!isset($_SESSION['active'])){
		session_start();
	}

	// Shared Connection Array
    	$connectionPool = array();

	// MASTER ASSOCIATION CONNECTION
    $CommunityName2 = "Islandia East";
    $dbhost2 = 'localhost';
    $dbuser2 = 'nodyss5_iSlaNd1a3a57poa';
    $dbpass2 = '+kD4nm!5kg9]?Ik9u-y~*&Se}y1I^WZR$UTD';
    $dbname2 = 'nodyss5_islandiaeast';

$conn2 = new mysqli($dbhost2, $dbuser2, $dbpass2, $dbname2);
if ($conn2->connect_error) {
    die('Connect Error (' . $conn2->connect_errno . ') ' . $conn2->connect_error);
}


$connectionPool[$CommunityName] = array('priority' => 10, 'connection' =>  $conn, 'master' => false, 'primary' => true);
$connectionPool[$CommunityName2] = array('priority' => 20, 'connection' =>  $conn2, 'master' => true, 'primary' => false);

ksort($connectionPool);
?>
