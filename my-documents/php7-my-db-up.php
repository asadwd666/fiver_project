<?php if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start(); ?>
<?php
	$SITE_MANAGER_EMAIL = "sitemanager@condosites.net";
	$CommunityName = "CondoSites PROTOTYPE 20";
	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '123@456';
	$dbname = 'nodyss5_PROTOTYPEv17';

    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    if ($conn->connect_error) {
        die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
    }

	// Shared Connection Array
//    $connectionPool = array();

	// MASTER ASSOCIATION CONNECTION
//    $CommunityName2 = "CondoSites MASTER ASSOCIATION";
//    $dbhost2 = 'localhost';
//    $dbuser2 = 'nodyss5_PROTOTYPEvMA';
//    $dbpass2 = 'p-DPsC+VqnY,f6tjFc&lTWj]I?4@lbm0Io9Z';
//    $dbname2 = 'nodyss5_PROTOTYPEvMA';

//    $conn2 = new mysqli($dbhost2, $dbuser2, $dbpass2, $dbname2);
//    if ($conn2->connect_error) {
//        die('Connect Error (' . $conn2->connect_errno . ') ' . $conn2->connect_error);
//    }


//	$connectionPool[$CommunityName] = array('priority' => 10, 'connection' =>  $conn, 'master' => false, 'primary' => true);
//    $connectionPool[$CommunityName2] = array('priority' => 20, 'connection' =>  $conn2, 'master' => true, 'primary' => false);

//	ksort($connectionPool);

?>