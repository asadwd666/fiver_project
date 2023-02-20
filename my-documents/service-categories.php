        <select name="type">
<option value="">Select Service Request Category</option>
<option value=""></option>
<option value="">*** Select Maintenance Category ***</option>
<option value="Electrical" <?php if($row['type'] == "Electrical"){ echo("SELECTED"); } ?>>Electrical</option>
<option value="Elevator" <?php if($row['type'] == "Elevator"){ echo("SELECTED"); } ?>>Elevator</option>
<option value="Gym" <?php if($row['type'] == "Gym"){ echo("SELECTED"); } ?>>Gym</option>
<option value="HVAC" <?php if($row['type'] == "HVAC"){ echo("SELECTED"); } ?>>HVAC/Heat/Air Conditioning</option>
<option value="Janitorial" <?php if($row['type'] == "Janitorial"){ echo("SELECTED"); } ?>>Janitorial</option>
<option value="Landscaping" <?php if($row['type'] == "Landscaping"){ echo("SELECTED"); } ?>>Landscaping</option>
<option value="Lights" <?php if($row['type'] == "Lights"){ echo("SELECTED"); } ?>>Lights</option>
<option value="Plumbing" <?php if($row['type'] == "Plumbing"){ echo("SELECTED"); } ?>>Plumbing</option>
<option value="Sprinklers" <?php if($row['type'] == "Sprinklers"){ echo("SELECTED"); } ?>>Sprinklers/Irrigation</option>
<option value=""></option>
<option value="">*** Select Administrative Category ***</option>
<option value="Documents" <?php if($row['type'] == "Documents"){ echo("SELECTED"); } ?>>Association Documents</option>
<option value="Key/Fob" <?php if($row['type'] == "Key/Fob"){ echo("SELECTED"); } ?>>Key/Fob Order</option>

        </select>
