<?php $current_page = '30'; include('report-protect.php');

{

	$query = "SELECT * FROM `service` WHERE `status` != 'C' LIMIT 1";

	$result = mysqli_query($conn,$query) or die('Error, query failed');
	list($int1, $userid, $status, $type, $assigned, $privacy, $pte, $serviceflex1, $serviceflex2, $serviceflex3, $serviceflex4, $serviceflex5, $created_date, $update_date, $description, $confcomments) = 
		$result->fetch_array();

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=ServiceRequests.csv");
}
?>
Request ID,User,Unit,Unit2,Email,Phone,Service Request Type,Assigned To,Status,Privacy,PTE,Flex 1,Flex 2,Flex 3,Flex 4,Flex 5,Date Opened,Last Updated,Total Time,Description and Comments
<?php
	$query  = "SELECT * FROM `service` WHERE `status` != 'C' ORDER BY `int1`";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

?>
<?php echo "{$row['int1']}"; ?>,<?php if ($row['userid'] == '0'){ ?>,,,,<?php }; ?><?php if ($row['userid'] !== '0'){ ?><?php
	$type    = $row['userid'];
	$query1  = "SELECT `first_name`, `last_name`, `unit`, `unit2`, `phone`, `email` FROM `users` WHERE `id` = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
?><?php echo "{$row1['last_name']}"; ?> <?php echo "{$row1['first_name']}"; ?>,<?php echo "{$row1['unit']}"; ?>,<?php echo "{$row1['unit2']}"; ?>,<?php echo "{$row1['email']}"; ?>,<?php echo "{$row1['phone']}"; ?><?php } ?><?php }; ?>,<?php echo "{$row['type']}"; ?>,<?php if ($row['assigned'] !== '0'){ ?><?php
	$type    = $row['assigned'];
	$query1  = "SELECT `first_name`, `last_name` FROM `users` WHERE `id` = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
?><?php echo "{$row1['last_name']}"; ?> <?php echo "{$row1['first_name']}"; ?><?php } ?><?php }; ?>,<?php if ($row['status'] == 'O'){ ?>Open<?php }; ?><?php if ($row['status'] == 'I'){ ?>In Progress<?php }; ?><?php if ($row['status'] == 'B'){ ?>Awaiting Board<?php }; ?><?php if ($row['status'] == '3'){ ?>Awaiting 3rd Party<?php }; ?><?php if ($row['status'] == 'H'){ ?>On Hold<?php }; ?><?php if ($row['status'] == 'C'){ ?>Closed<?php }; ?>,<?php echo "{$row['privacy']}"; ?>,<?php echo "{$row['pte']}"; ?>,<?php echo "{$row['serviceflex1']}"; ?>,<?php echo "{$row['serviceflex2']}"; ?>,<?php echo "{$row['serviceflex3']}"; ?>,<?php echo "{$row['serviceflex4']}"; ?>,<?php echo "{$row['serviceflex5']}"; ?>,<?php echo "{$row['created_date']}"; ?>,<?php echo "{$row['update_date']}"; ?>,<?php if ($row['status'] == 'C'){ ?><?php
$datestamp = $row['created_date'];
$current = $row['update_date'];
$datetime1 = date_create($datestamp);
$datetime2 = date_create($current);
$interval = date_diff($datetime1, $datetime2);
echo $interval->format('%a days %h hours %i minutes');
?><?php }; ?><?php if ($row['status'] != 'C'){ ?><?php
$datestamp = $row['created_date'];
$current = Date('Y-m-d H:i:s');
$datetime1 = date_create($datestamp);
$datetime2 = date_create($current);
$interval = date_diff($datetime1, $datetime2);
echo $interval->format('%a days %h hours %i minutes');
?><?php }; ?>,<?php 
$string = $row['description'];
$commastring = preg_replace("/,/", "", $string);
echo $descriptionstring = preg_replace("/[\n\r]/", " ", $commastring);
?>

<?php } ?>