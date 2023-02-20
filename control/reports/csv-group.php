<?php $current_page = '11'; include('report-protect.php');

if(isset($_GET['status'])){

	$status    = $_GET['status'];
	$query = "SELECT ghost FROM users WHERE `ghost` != '1' LIMIT 1";

	$result = mysqli_query($conn,$query) or die('Error, query failed');
	list($id, $first_name, $last_name, $unit, $unit2, $email, $directory, $phone, $dphone, $owner, $realtor, $lease, $board, $concierge, $liaison, $status, $accessdate, $flex1, $flex2, $flex3, $flex4, $flex5, $comments) =  $result->fetch_array();

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=Users.csv");
}
?>
ID,First Name,Last Name,Email,Email Directory,Phone,Phone Directory,Unit,Building/Street,User Permissions,Control Panel Permissions,End of Lease,Flex 1,Flex 2,Flex 3,Flex 4,Flex 5,Comments
<?php
	$status    = $_GET['status'];
	$query  = "SELECT id,first_name, last_name, unit, unit2, email, directory, phone, dphone, owner, realtor, lease, board, concierge, liaison, status, accessdate, flex1, flex2, flex3, flex4, flex5, comments FROM users WHERE status = '$status' AND `ghost` != 'Y'";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

?>
<?php echo "{$row['id']}"; ?>,<?php echo "{$row['first_name']}"; ?>,<?php echo "{$row['last_name']}"; ?>,<?php echo "{$row['email']}"; ?>,<?php echo "{$row['directory']}"; ?>,<?php echo "{$row['phone']}"; ?>,<?php echo "{$row['dphone']}"; ?>,<?php echo "{$row['unit']}"; ?>,<?php echo "{$row['unit2']}"; ?>,Owner=<?php echo "{$row['owner']}"; ?> Renter=<?php echo "{$row['lease']}"; ?> Realtor=<?php echo "{$row['realtor']}"; ?>,Board=<?php echo "{$row['board']}"; ?> Staff=<?php echo "{$row['concierge']}"; ?> Full Admin=<?php echo "{$row['liaison']}"; ?>,<?php echo "{$row['accessdate']}"; ?>,<?php echo "{$row['flex1']}"; ?>,<?php echo "{$row['flex2']}"; ?>,<?php echo "{$row['flex3']}"; ?>,<?php echo "{$row['flex4']}"; ?>,<?php echo "{$row['flex5']}"; ?>,<?php echo preg_replace("/(\,)/", "", $row['comments']); ?>

<?php
	}
?>