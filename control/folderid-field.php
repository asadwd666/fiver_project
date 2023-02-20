        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="utility" class="middle">Link to a Folder</label></div>
            <div class="small-12 medium-7 end columns">
<select name="folderid">
<option value="">None</option>
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
