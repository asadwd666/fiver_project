        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="utility" class="middle">Link to Document</label></div>
            <div class="small-12 medium-7 end columns">
<select name="docid">
<?php if ($row['docid'] == ''){ ?><option value="">None</option><?php }; ?>
<?php
	$type    = $row['docid'];
	$query11  = "SELECT `id`, title, owner, lease, realtor, public, doctype FROM documents where id = '$type'";
	$result11 = mysqli_query($conn,$query11);

	while($row11 = $result11->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$row['docid']}"; ?>"><?php echo "{$row11['id']}"; ?> - <?php echo "{$row11['title']}"; ?> (<?php echo "{$row11['doctype']}"; ?>)</option>
<?php
	}
?>
<option value="" disabled> </option>
<option value="">None</option>
<option value="" disabled> </option>
<?php
	$query  = "SELECT `id`, title, owner, lease, realtor, public, doctype FROM documents WHERE board != 'Y' AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY `id` DESC";
	$result = mysqli_query($conn, $query);

	while($row1 = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<option value="<?php echo "{$row1['id']}"; ?>"><?php echo "{$row1['id']}"; ?> - <?php echo "{$row1['title']}"; ?> (<?php echo "{$row1['doctype']}"; ?>)</option>
<?php
	}
?>
</select>
            </div>
        </div>
