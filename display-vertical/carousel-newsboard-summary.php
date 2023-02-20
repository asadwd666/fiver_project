<?php
foreach ($connectionPool as $connName => $configuration) {

	$queryNEWS  = "SELECT `headline` FROM `chalkboard` WHERE (`digitaldisplay` = 'Y' AND `eod` >= CURRENT_DATE() AND `pod` <= CURRENT_DATE()) ORDER BY pod DESC LIMIT 1";
	$resultNEWS = mysqli_query($configuration['connection'],$queryNEWS);

	while($rowNEWS = $resultNEWS->fetch_array(MYSQLI_ASSOC))
	{
?>
<!-- Newsboard Article Setup -->
                <div>
                    <div class="large-3 columns">
                        <div class="slider-icon center">
                            <i class="fa fa-newspaper-o" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="large-9 columns">
                        <div class="information left">
                            <h2>Headlines from <?php echo $connName; ?></h2>
                            <div class="mvix-overflow-container">
                                
                                <ul>
<!-- Newsboard Article Headlines -->

<?php
	$queryNEWS  = "SELECT `headline` FROM `chalkboard` WHERE (`digitaldisplay` = 'Y' AND `eod` >= CURRENT_DATE() AND `pod` <= CURRENT_DATE()) ORDER BY pod DESC LIMIT 5";
	$resultNEWS = mysqli_query($configuration['connection'],$queryNEWS);

	while($rowNEWS = $resultNEWS->fetch_array(MYSQLI_ASSOC))
	{
?>
<li><?php echo "{$rowNEWS['headline']}"; ?></li>
<?php
	}
?>

<!-- Newsboard Article Headlines -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
<!-- Newsboard Article Setup -->
<?php
	}
}
?>