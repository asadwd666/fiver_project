<div class="stand-alone-page">
    <div class="controlpanel-header">
        <div class="small-12 medium-6 large-8 columns show-for-medium">
            <a href="index-control.php"><img src="https://condosites.com/images/CondoSites-cp.png" alt="CondoSites" style="padding-top: 5px; padding-bottom: 5px;"></a>
        </div>
<FORM ACTION="../cgi-bin/redirect.pl" METHOD=POST onSubmit="return dropdown(this.gourl)" >
        <div class="small-9 medium-4 large-3 columns" style="padding-top: 15px;">
<SELECT NAME="gourl" class="form">
<OPTION VALUE="index-control.php?access=<?php print $access; ?>">Control Panel Main Page</option>
<OPTION VALUE=""> </option>
<?php
	$queryNAV  = "SELECT `id`, name, url FROM controlpanels WHERE $access = '1' ORDER BY name";
	$resultNAV = mysqli_query($conn,$queryNAV);

	while($rowNAV = $resultNAV->fetch_array(MYSQLI_ASSOC))
	{
?>
<OPTION VALUE="<?php echo "{$rowNAV['url']}"; ?>"><?php echo "{$rowNAV['name']}"; ?></option>
<?php
	}
?>
<OPTION VALUE=""> </option>
<?php if ($_SESSION['webmaster'] == true) { ?><OPTION VALUE="index-control.php?access=webmaster">Webmaster Control Panel</option><?php }; ?>
<?php if ($_SESSION['liaison'] == true) { ?><OPTION VALUE="index-control.php?access=liaison">Full Administrator Control Panel</option><?php }; ?>
<?php if ($_SESSION['board'] == true) { ?><OPTION VALUE="index-control.php?access=board">Board Control Panel</option><?php }; ?>
<?php if ($_SESSION['concierge'] == true) { ?><OPTION VALUE="index-control.php?access=concierge">Concierge/Staff Control Panel</option><?php }; ?>
<OPTION VALUE=""> </option>
<OPTION VALUE="https://www.condosites.com/policies.php">CondoSites Service Policies</option>
<OPTION VALUE=""> </option>
<OPTION VALUE="../logout-controlpanel.php">LOGOUT</option>
</SELECT>
        </div>
        <div class="small-3 medium-2 large-1 columns" style="padding-top: 15px; padding-right: 15px;">
<INPUT TYPE=SUBMIT VALUE="Go" class="form">
        </div>
</FORM>
    </div>
</div>
<div class="stand-alone-page">
    <div class="controlpanel-content">
        &nbsp;
    </div>
</div>