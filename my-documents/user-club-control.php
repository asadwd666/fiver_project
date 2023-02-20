        <div class="row">
          <div class="small-2 medium-1 large-1 columns" align="right"><input type="checkbox" name="club1" value="Y" <?php if($row['club1'] == 'Y'){ ?>checked="true"<?php }; ?>></div>
          <div class="small-10 medium-11 large-11 end columns"><label> Member of the Golf Club</label></div>
        </div>

		<input type="hidden" name="club2" class="form" value="<?php echo "{$row['club2']}"; ?>">
		<input type="hidden" name="club3" class="form" value="<?php echo "{$row['club3']}"; ?>">
		<input type="hidden" name="club4" class="form" value="<?php echo "{$row['club4']}"; ?>">
		<input type="hidden" name="club5" class="form" value="<?php echo "{$row['club5']}"; ?>">