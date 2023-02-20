<select name="userid" autofocus>
<option value="">Select User</option>
<option value="" disabled>
<option value="0">Not listed - fill in "Other" field</option>
<option value="" disabled>
<?php
	$query  = "SELECT `id`, `last_name`, `first_name`, `unit`, `unit2`, `emailconfirm` FROM `users` WHERE `ghost` != 'Y' and `status` != 'disabled' ORDER BY `last_name`";
	$result = mysqli_query($conn, $query);

	while($row1 = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$row1['id']}"; ?>"><?php echo "{$row1['last_name']}"; ?>, <?php echo "{$row1['first_name']}"; ?> (<?php echo "{$row1['unit']}"; ?><?php if ($row1['unit2'] !== 'X'){ ?> - <?php echo "{$row1['unit2']}"; ?><?php }; ?>)  <?php if ($row1['emailconfirm'] == 'B'){ ?> This user&apos;s email address is bouncing!<?php }; ?></option>
<?php
	}
?>
</select>