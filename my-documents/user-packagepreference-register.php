        <div class="row">
        <hr>
        </div>
        <div class="row">
          <div class="small-5 medium-5 large-5 columns"><label for="email" class="middle">Package Preference</label></div>
          <div class="small-7 medium-7 large-7 end columns">
		<select name="packagepreference">
		  <option value="Hold" <?php if($_POST['packagepreference'] == "Hold"){ echo("SELECTED"); } ?>>Hold for Pickup</option>
		  <option value="Deliver" <?php if($_POST['packagepreference'] == "Deliver"){ echo("SELECTED"); } ?>>Deliver to My Unit</option>
		  <option value="Unit" <?php if($_POST['packagepreference'] == "Unit"){ echo("SELECTED"); } ?>>Deliver Inside My Unit</option>
		</select>
          </div>
        </div>