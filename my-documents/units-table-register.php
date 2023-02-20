        <div class="small-5 medium-5 large-5 columns">
            <label for="unit" class="middle">

<!-- UNIT DESIGNATION -->
House Number and Building

            </label>
        </div>
        <div class="small-7 medium-7 large-7 end columns">

<!-- UNIT1 FIELD -->
<input name="unit" type="text" class="form form-split-left" id="unit" maxlength="4" placeholder="1234" value="<?php echo($_POST['unit']); ?>">

<!-- UNIT2 FIELD -->
<select name="unit2" class="form form-split-right">
<option value="" <?php if($_POST['unit2'] == ""){ echo("SELECTED"); } ?>>Select Building</option>
<option value="1" <?php if($_POST['unit2'] == "1"){ echo("SELECTED"); } ?>>Building 1</option>
</select>


        </div>