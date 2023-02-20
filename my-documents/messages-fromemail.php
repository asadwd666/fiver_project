<select name="from">
<option value="" <?php if($row['from'] == ""){ echo("SELECTED"); } ?>>No Reply-To Address</option>
<option value="test@condosites.net" <?php if($row['from'] == "test@condosites.net"){ echo("SELECTED"); } ?>>test@condosites.net</option>
<option value="donotreply@condosites.net" <?php if($row['from'] == "donotreply@condosites.net"){ echo("SELECTED"); } ?>>donotreply@condosites.net</option>
</select>
