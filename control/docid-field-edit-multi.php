        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="utility" class="middle">Link to 2nd Document</label></div>
            <div class="small-12 medium-7 end columns">
<select name="docid2">
<?php if ($row['docid2'] == ''){ ?><option value="">None<?php }; ?>
<?php
	$type    = $row['docid2'];
	$query21  = "SELECT `id`, title, owner, lease, realtor, public, doctype FROM documents WHERE id = '$type'";
	$result21 = mysqli_query($conn,$query21);

	while($row21 = $result21->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$row['docid2']}"; ?>"><?php echo "{$row21['id']}"; ?> - <?php echo "{$row21['title']}"; ?> (<?php echo "{$row21['doctype']}"; ?>)</option>
<?php
	}
?>
<option value="" disabled> </option>
<option value="">None</option>
<option value="" disabled> </option>
<?php
	$query  = "SELECT `id`, title, owner, lease, realtor, public, doctype FROM documents WHERE ((owner = 'Y') OR (lease = 'Y') OR (realtor = 'Y') OR (doctype = 'Staff')) AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY `id` DESC";
	$result = mysqli_query($conn, $query);

	while($row2 = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$row2['id']}"; ?>"><?php echo "{$row2['id']}"; ?> - <?php echo "{$row2['title']}"; ?> (<?php echo "{$row2['doctype']}"; ?>)</option>
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
<?php if ($row['docid3'] == ''){ ?><option value="">None</option><?php }; ?>
<?php
	$type    = $row['docid3'];
	$query31  = "SELECT `id`, title, owner, lease, realtor, public, doctype FROM documents WHERE id = '$type'";
	$result31 = mysqli_query($conn,$query31);

	while($row31 = $result31->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$row['docid3']}"; ?>"><?php echo "{$row31['id']}"; ?> - <?php echo "{$row31['title']}"; ?> (<?php echo "{$row31['doctype']}"; ?>)</option>
<?php
	}
?>
<option value="" disabled> </option>
<option value="">None</option>
<option value="" disabled> </option>
<?php
	$query  = "SELECT `id`, title, owner, lease, realtor, public, doctype FROM documents WHERE ((owner = 'Y') OR (lease = 'Y') OR (realtor = 'Y') OR (doctype = 'Staff')) AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY `id` DESC";
	$result = mysqli_query($conn, $query);

	while($row3 = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$row3['id']}"; ?>"><?php echo "{$row3['id']}"; ?> - <?php echo "{$row3['title']}"; ?> (<?php echo "{$row3['doctype']}"; ?>)</option>
<?php
	}
?>
</select>
            </div>
        </div>
        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-12 end columns" style="padding-bottom: -10px; margin-top: -10px" align="center">
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
<?php if ($row['pic'] == ''){ ?><option value="">None</option><?php }; ?>
<?php
	$type    = $row['pic'];
	$query41  = "SELECT `id`, title, doctype FROM documents WHERE id = '$type'";
	$result41 = mysqli_query($conn,$query41);

	while($row41 = $result41->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$row['pic']}"; ?>"><?php echo "{$row41['id']}"; ?> - <?php echo "{$row41['title']}"; ?> (<?php echo "{$row41['doctype']}"; ?>)</option>
<?php
	}
?>
<option value="" disabled> </option>
<option value="">None</option>
<option value="" disabled> </option>
<?php
	$query  = "SELECT `id`, title, doctype FROM documents WHERE (type = 'image/jpeg' OR type = 'image/pjpeg' OR type = 'image/gif' OR type = 'image/png') AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY `id` DESC";
	$result = mysqli_query($conn, $query);

	while($row4 = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$row4['id']}"; ?>"><?php echo "{$row4['id']}"; ?> - <?php echo "{$row4['title']}"; ?> (<?php echo "{$row4['doctype']}"; ?>)</option>
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
<?php if ($row['pic2'] == ''){ ?><option value="">None</option><?php }; ?>
<?php
	$type    = $row['pic2'];
	$query51  = "SELECT `id`, title, doctype FROM documents WHERE id = '$type'";
	$result51 = mysqli_query($conn,$query51);

	while($row51 = $result51->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$row['pic2']}"; ?>"><?php echo "{$row51['id']}"; ?> - <?php echo "{$row51['title']}"; ?> (<?php echo "{$row51['doctype']}"; ?>)</option>
<?php
	}
?>
<option value="" disabled> </option>
<option value="">None</option>
<option value="" disabled> </option>
<?php
	$query  = "SELECT `id`, title, doctype FROM documents WHERE (type = 'image/jpeg' OR type = 'image/pjpeg' OR type = 'image/gif' OR type = 'image/png') AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY `id` DESC";
	$result = mysqli_query($conn, $query);

	while($row5 = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$row5['id']}"; ?>"><?php echo "{$row5['id']}"; ?> - <?php echo "{$row5['title']}"; ?> (<?php echo "{$row5['doctype']}"; ?>)</option>
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
<?php if ($row['pic3'] == ''){ ?><option value="">None</option><?php }; ?>
<?php
	$type    = $row['pic3'];
	$query61  = "SELECT `id`, title, doctype FROM documents WHERE id = '$type'";
	$result61 = mysqli_query($conn,$query61);

	while($row61 = $result61->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$row['pic3']}"; ?>"><?php echo "{$row61['id']}"; ?> - <?php echo "{$row61['title']}"; ?> (<?php echo "{$row61['doctype']}"; ?>)</option>
<?php
	}
?>
<option value="" disabled> </option>
<option value="">None</option>
<option value="" disabled> </option>
<?php
	$query  = "SELECT `id`, title, doctype FROM documents WHERE (type = 'image/jpeg' OR type = 'image/pjpeg' OR type = 'image/gif' OR type = 'image/png') AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY `id` DESC";
	$result = mysqli_query($conn, $query);

	while($row6 = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$row6['id']}"; ?>"><?php echo "{$row6['id']}"; ?> - <?php echo "{$row6['title']}"; ?> (<?php echo "{$row6['doctype']}"; ?>)</option>
<?php
	}
?>
</select>
            </div>
        </div>
