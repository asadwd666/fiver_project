<select name="userid" autofocus>
<?php if ($row['userid'] == '0'){ ?><option value="0">Other</option><?php }; ?>
<?php
	$type    = $row['userid'];
	$query1  = "SELECT `id`, `unit`, `unit2`, `last_name`, `first_name`, `email`, `phone`, `emailconfirm` FROM `users` WHERE id = '$type'";
	$result1 = mysqli_query($conn,$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$row1['id']}"; ?>"><?php echo "{$row1['last_name']}"; ?>, <?php echo "{$row1['first_name']}"; ?> (<?php echo "{$row1['unit']}"; ?><?php if ($row1['unit2'] !== 'X'){ ?> - <?php echo "{$row1['unit2']}"; ?><?php }; ?>) <?php if ($row1['emailconfirm'] == 'B'){ ?> This user&apos;s email address is bouncing!<?php }; ?></option>
<?php
	}
?>
<option value="" disabled>
<option value="0">Not listed - fill in "Other" field</option>
<option value="" disabled>
<?php
	$query  = "SELECT `id`, `unit`, `unit2`, `last_name`, `first_name`, `email`, `phone`, `emailconfirm` FROM `users` WHERE `ghost` != 'Y' ORDER BY `last_name`";
	$result = mysqli_query($conn, $query);

	while($row1 = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$row1['id']}"; ?>"><?php echo "{$row1['last_name']}"; ?>, <?php echo "{$row1['first_name']}"; ?> (<?php echo "{$row1['unit']}"; ?><?php if ($row1['unit2'] !== 'X'){ ?> - <?php echo "{$row1['unit2']}"; ?><?php }; ?>) <?php if ($row1['emailconfirm'] == 'B'){ ?> This user&apos;s email address is bouncing!<?php }; ?></option>
<?php
	}
?>
</select>
