        <div class="row medium-collapse" style="padding-left: 30px;">
            <div class="small-12 medium-5 columns"><label for="utility" class="middle">Link to Document</label></div>
            <div class="small-12 medium-7 end columns">
<select name="docid" class="form">
<option value="">None</option>
<?php
	$query  = "SELECT `id`, title, owner, lease, realtor, public, doctype FROM documents WHERE board != 'Y' AND board != 'Y' AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY `id` DESC";
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
