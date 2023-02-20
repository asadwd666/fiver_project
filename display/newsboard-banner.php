<?php
	$queryMB  = "SELECT `line1`, `line2`, `line3` FROM `meetingbox` WHERE `digitaldisplay` = 'Y'";

	$resultMB = mysqli_query($primaryConn,$queryMB);

	while($rowMB = $resultMB->fetch_array(MYSQLI_ASSOC))
	{
?>
                <div class="newsboard-banner-container">
                    <div class="row collapse no-margin">
                        <div class="large-12 columns">
                            <div class="newsboard-banner center">

<!-- Newsboard Banner Content-->
	<?php if ($rowMB['line1'] !== ''){ ?><h3><?php echo "{$rowMB['line1']}"; ?></h3><?php }; ?>

	<?php if ($rowMB['line2'] !== ''){ ?><p><?php echo "{$rowMB['line2']}"; ?></p><?php }; ?>

	<?php if ($rowMB['line3'] !== ''){ ?><p><?php echo "{$rowMB['line3']}"; ?></p><?php }; ?>

<!-- Newsboard Banner Content-->

                            </div>
                        </div>
                    </div>
                </div>

<?php
	}
?>
