<?php
	$query  = "SELECT `theircode` FROM 3rd WHERE type = 'Splash'";
    $result = mysqli_query($conn, $query);
    while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<big><?php echo "{$row['theircode']}"; ?></big>
<?php
	}
?>