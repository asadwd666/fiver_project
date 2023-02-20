<?php $current_page = '11'; include('report-protect.php');

if(isset($_GET['status'])){

	$status    = $_GET['status'];
	$query = "SELECT first_name, last_name, unit, unit2, email, phone, owner, realtor, lease, status FROM users WHERE `webmaster` != '1' LIMIT 1";

	$result = mysqli_query($conn,$query) or die('Error, query failed');
	list($first_name, $last_name, $unit, $unit2, $email, $phone, $owner, $realtor, $lease, $status) =                             
		$result->fetch_array();

header("Content-Type: text/vCard");
header("Content-Disposition: attachment; filename=Users.vcf");
}
?>
<?php
	$status    = $_GET['status'];
	$query  = "SELECT first_name, last_name, unit, unit2, email, phone, owner, realtor, lease, status FROM users WHERE status = '$status' AND `webmaster` != '1'";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

?>
BEGIN:VCARD
VERSION:3.0
N:<?php echo "{$row['last_name']}"; ?>;<?php echo "{$row['first_name']}"; ?>;;;
FN:<?php echo "{$row['first_name']}"; ?> <?php echo "{$row['last_name']}"; ?>;
NOTE:Owner=<?php echo "{$row['owner']}"; ?>, Renter=<?php echo "{$row['lease']}"; ?>, Realtor=<?php echo "{$row['realtor']}"; ?>;
EMAIL;type=INTERNET;type=WORK;type=pref:<?php echo "{$row['email']}"; ?>;
TEL;type=WORK;type=pref:<?php echo "{$row['phone']}"; ?>;
item1.ADR;type=WORK;type=pref:;;<?php echo "{$row['unit']}"; ?>\, <?php echo "{$row['unit2']}"; ?>;
item1.X-ABADR:us;
END:VCARD
<?php
	}
?>