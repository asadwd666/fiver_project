        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="utility" class="middle">Link to Calendar Event</label></div>
            <div class="small-12 medium-7 end columns">
<select name="calid">
<option value="">None</option>
<?php
	$query  = "SELECT `int1`, title, date, stime, event FROM calendar WHERE date >= CURRENT_DATE() ORDER BY `int1` DESC";
	$result = mysqli_query($conn, $query);

	while($row7 = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$row7['int1']}"; ?>"><?php echo "{$row7['int1']}"; ?> - <?php echo "{$row7['title']}"; ?> (<?php echo "{$row7['event']}"; ?>) <?php echo "{$row7['date']}"; ?> <?php echo "{$row7['stime']}"; ?></option>
<?php
	}
?>
</select>
            </div>
        </div>