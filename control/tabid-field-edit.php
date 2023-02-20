        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="utility" class="middle">Link to a Module or eForm</label></div>
            <div class="small-12 medium-7 end columns">
<select name="tabid">
<?php if ($row['tabid'] == ''){ ?><option value="">None</option><?php }; ?>
<?php
	$type    = $row['tabid'];
	$query81  = "SELECT `int1`, title FROM tabs WHERE `int1` = '$type'";
	$result81 = mysqli_query($conn,$query81);

	while($row81 = $result81->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$row['tabid']}"; ?>"><?php echo "{$row81['int1']}"; ?> - <?php echo "{$row81['title']}"; ?></option>
<?php
	}
?>
<option value="" disabled></option>
<option value="">None</option>
<option value="" disabled></option>
<?php
	$query  = "SELECT `int1`, title FROM tabs WHERE liaison = 'Y' ORDER BY `int1`";
	$result = mysqli_query($conn, $query);

	while($row8 = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$row8['int1']}"; ?>"><?php echo "{$row8['int1']}"; ?> - <?php echo "{$row8['title']}"; ?></option>
<?php
	}
?>
</select>
            </div>
        </div>