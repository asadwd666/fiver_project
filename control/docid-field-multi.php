        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="utility" class="middle">Link to 2nd Document</label></div>
            <div class="small-12 medium-7 end columns">
<select name="docid2">
<option value="">None</option>
<?php
	$query  = "SELECT `id`, title, owner, lease, realtor, public, doctype FROM documents WHERE board != 'Y' AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY `id` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$row['id']}"; ?>"><?php echo "{$row['id']}"; ?> - <?php echo "{$row['title']}"; ?> (<?php echo "{$row['doctype']}"; ?>)</option>
<?php
	}
?>
</select>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="utility" class="middle">Link to 3rd Document</label></div>
            <div class="small-12 medium-7 end columns">
<select name="docid3">
<option value="">None</option>
<?php
	$query  = "SELECT `id`, title, owner, lease, realtor, public, doctype FROM documents WHERE board != 'Y' AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY `id` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$row['id']}"; ?>"><?php echo "{$row['id']}"; ?> - <?php echo "{$row['title']}"; ?> (<?php echo "{$row['doctype']}"; ?>)</option>
<?php
	}
?>
</select>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 end columns" style="padding-bottom: -10px; margin-top: -10px" align="center">
                <label for="phototips" class="middle" style="margin-bottom: -5px;"><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Show photo layout tips.</span> <input type="checkbox" name="phototips" onclick="showMe('phototips', this)" /></label>
            </div>
            <div id="phototips" style="display:none" class="note-black">
<b>1 photo - on the right of your text</b>, use the 1st dropdown.<br>
<b>1 photo - below your text</b>, use the 2nd dropdown.<br>
<b>2 photos - side by side &quot;twin style&quot;</b>, use the 2nd and 3rd dropdown.<br>
<b>2 photos - one larger and a second smaller photo to its right</b>, use the 1st and 3rd dropdown.<br>
<b>3 photos - in a collage</b>, use the 1st, 2nd, and 3rd dropdown.<br>
<br>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="utility" class="middle">Add 1st Photo</label></div>
            <div class="small-12 medium-7 end columns">
<select name="pic">
<option value="">None</option>
<?php
	$query  = "SELECT `id`, title, doctype FROM documents WHERE (type = 'image/jpeg' OR type = 'image/pjpeg' OR type = 'image/gif' OR type = 'image/png') AND board != 'Y' AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY `id` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$row['id']}"; ?>"><?php echo "{$row['id']}"; ?> - <?php echo "{$row['title']}"; ?> (<?php echo "{$row['doctype']}"; ?>)</option>
<?php
	}
?>
</select>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="utility" class="middle">Add 2nd Photo</label></div>
            <div class="small-12 medium-7 end columns">
<select name="pic2">
<option value="">None</option>
<?php
	$query  = "SELECT `id`, title, doctype FROM documents WHERE (type = 'image/jpeg' OR type = 'image/pjpeg' OR type = 'image/gif' OR type = 'image/png') AND board != 'Y' AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY `id` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$row['id']}"; ?>"><?php echo "{$row['id']}"; ?> - <?php echo "{$row['title']}"; ?> (<?php echo "{$row['doctype']}"; ?>)</option>
<?php
	}
?>
</select>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="utility" class="middle">Add 3rd Photo</label></div>
            <div class="small-12 medium-7 end columns">
<select name="pic3">
<option value="">None</option>
<?php
	$query  = "SELECT `id`, title, doctype FROM documents WHERE (type = 'image/jpeg' OR type = 'image/pjpeg' OR type = 'image/gif' OR type = 'image/png') AND board != 'Y' AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY `id` DESC";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$row['id']}"; ?>"><?php echo "{$row['id']}"; ?> - <?php echo "{$row['title']}"; ?> (<?php echo "{$row['doctype']}"; ?>)</option>
<?php
	}
?>
</select>
            </div>
        </div>
