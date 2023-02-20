<?php $current_page = '10'; include('report-protect.php');

{

	$query  = "SELECT * FROM packages LIMIT 1";

	$result = mysqli_query($conn,$query) or die('Error, query failed');
	list($int1, $recipient, $userid, $packagetype, $pkgtracking, $from, $pkglocation, $received, $recemp, $pickedup, $puemp, $pickedupby, $created, $lastedited, $comments) = 
		$result->fetch_array();

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=Packages-All.csv");
}
?>
Package ID,Last, First,Unit,Tower,Email,User ID,Package Type,Package Tracking,From,Package Location,Received,Received By,Delivered,Delivered By,Delivered To,Created,Last Edited,Comments
<?php
	$query  = "SELECT * FROM packages ORDER BY `int1` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

?>
<?php echo "{$row['int1']}"; ?>,<?php if ($row['userid'] == '0'){ ?><?php echo "{$row['recipient']}"; ?>,,*,,,<?php }; ?><?php if ($row['userid'] !== '0'){ ?><?php $type = $row['userid']; $query1 = "SELECT last_name, first_name, unit, unit2, email FROM users WHERE id = '$type'"; $result1 = mysqli_query($conn,$query1); while($row1 = $result1->fetch_array(MYSQLI_ASSOC)) { $email = $row1['email']; ?><?php echo "{$row1['last_name']}"; ?>,<?php echo "{$row1['first_name']}"; ?>,<?php echo "{$row1['unit']}"; ?>,<?php echo "{$row1['unit2']}"; ?>,<?php echo "{$row1['email']}"; ?>,<?php }; ?><?php } ?><?php echo "{$row['userid']}"; ?>,<?php echo "{$row['packagetype']}"; ?>,<?php echo "{$row['pkgtracking']}"; ?>,<?php echo "{$row['from']}"; ?>,<?php echo "{$row['pkglocation']}"; ?>,<?php echo "{$row['received']}"; ?>,<?php echo "{$row['recemp']}"; ?>,<?php echo "{$row['pickedup']}"; ?>,<?php echo "{$row['puemp']}"; ?>,<?php echo "{$row['pickedupby']}"; ?>,<?php echo "{$row['created']}"; ?>,<?php echo "{$row['lastedited']}"; ?>,<?php echo "{$row['comments']}"; ?>

<?php
	}
?>