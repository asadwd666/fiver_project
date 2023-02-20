          <div class="small-5 medium-5 large-5 columns"><label for="email" class="middle">Package Preference</label></div>
          <div class="small-7 medium-7 large-7 end columns">
		<select name="packagepreference">
            <option value="Hold" <?php if($row['packagepreference'] == "Hold"){ echo("SELECTED"); } ?>>Hold for Pickup</option>
            <option value="Deliver" <?php if($row['packagepreference'] == "Deliver"){ echo("SELECTED"); } ?>>Deliver to My Unit</option>
            <option value="Unit" <?php if($row['packagepreference'] == "Unit"){ echo("SELECTED"); } ?>>Deliver Inside My Unit</option>
		</select>
          </div>
