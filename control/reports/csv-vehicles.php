<?php $current_page = '19'; include('report-protect.php');

if(isset($_GET['model'])){

	$model    = $_GET['model'];
	$query = "SELECT * FROM vehicles WHERE `model` != 'B*' AND `approved` = 'Y' LIMIT 1";

	$result = mysqli_query($conn,$query) or die('Error, query failed');
	list($userid, $owner, $make, $model, $color, $state, $license, $permit, $space, $approved, $comments) = 
		$result->fetch_array();

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=Vehicles.csv");
}
?>
User ID,Unit,Unit2,Owner,Make,Model,Color,State,License,Permit,Space,Approved,Comments
<?php
	$status    = $_GET['status'];
	$query = "SELECT * FROM vehicles WHERE `model` != 'B*' AND `approved` = 'Y'";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

?><?php if ($row['userid'] !== '0'){ ?><?php echo "{$row['userid']}"; ?><?php }; ?>,<?php
	$type    = $row['userid'];
	$query1  = "SELECT unit, email FROM users WHERE id = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?><?php echo "{$row1['unit']}"; ?><?php } ?>,<?php
	$type    = $row['userid'];
	$query1  = "SELECT unit2, email FROM users WHERE id = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?><?php echo "{$row1['unit2']}"; ?><?php } ?>,<?php
	$type    = $row['userid'];
	$query1  = "SELECT first_name, last_name, email FROM users WHERE id = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?><?php echo "{$row1['last_name']}"; ?> <?php echo "{$row1['first_name']}"; ?><?php } ?><?php if ($row['owner'] !== ''){ ?><?php echo "{$row['owner']}"; ?><?php }; ?>,<?php echo "{$row['make']}"; ?>,<?php echo "{$row['model']}"; ?>,<?php echo "{$row['color']}"; ?>,<?php echo "{$row['state']}"; ?>,<?php echo "{$row['license']}"; ?>,<?php echo "{$row['permit']}"; ?>,<?php echo "{$row['space']}"; ?>,<?php echo "{$row['approved']}"; ?>,<?php echo "{$row['comments']}"; ?>

<?php
	}
?>