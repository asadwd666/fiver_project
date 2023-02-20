<?php if ($_SESSION['webmaster'] != true AND ($_SESSION['liaison'] == true OR $_SESSION['staff'] == true OR $_SESSION['board'] == true)){ ?>
<?php
	$dbhost2 = 'localhost';
	$dbuser2 = 'nodyss7_CSB1lln6';
	$dbpass2 = 'YXr(UAWzy7poaz32GQ}FIm8w5mdFJNkwGKGp~8L=dHRKH=+8N4CoLJ';
    $dbname2 = 'nodyss7_BILLING';

    $conn2 = new mysqli($dbhost2, $dbuser2, $dbpass2, $dbname2);
    if ($conn2->connect_error) {
        die('Connect Error (' . $conn2->connect_errno . ') ' . $conn2->connect_error);
    }
?>

<?php
    $LOCK = false;
    
    $CSDB = $dbname;
	$queryBILL  = "SELECT `Status` FROM $dbname2.Accounts WHERE `CSDB` = '$CSDB' LIMIT 1";
	$resultBILL = mysqli_query($conn2,$queryBILL);

	while($rowBILL = $resultBILL->fetch_array(MYSQLI_ASSOC))
	
	if ($rowBILL['Status'] == 'LOCK'){
        header("Location: ../control/billing.php");
	}
?>

<?php
    mysqli_close ($conn2)?>
<?php }; ?>