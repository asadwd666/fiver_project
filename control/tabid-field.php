        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="utility" class="middle">Link to a Module or eForm</label></div>
            <div class="small-12 medium-7 end columns">
<select name="tabid">
<option value="">None</option>
<option value="" disabled>
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