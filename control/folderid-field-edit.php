        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="utility" class="middle">Link to a Folder</label></div>
            <div class="small-12 medium-7 end columns">
<select name="folderid">
<?php if ($row['folderid'] == ''){ ?><option value="">None</option><?php }; ?>
<?php
	$type    = $row['folderid'];
	$query91  = "SELECT `int1`, title FROM folders WHERE `int1` = '$type'";
	$result91 = mysqli_query($conn,$query91);

	while($row91 = $result91->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$row['folderid']}"; ?>"><?php echo "{$row91['int1']}"; ?> - <?php echo "{$row91['title']}"; ?></option>
<?php
	}
?>
<option value=""> </option>
<option value="">None</option>
<option value=""> </option>
<?php
	$query  = "SELECT `int1`, title FROM folders ORDER BY `int1`";
	$result = mysqli_query($conn, $query);

	while($row9 = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$row9['int1']}"; ?>"><?php echo "{$row9['int1']}"; ?> - <?php echo "{$row9['title']}"; ?></option>
<?php
	}
?>
</select>
            </div>
        </div>