<?php
	$queryALERT  = "SELECT `line1`, `line2` FROM `alert` WHERE `showonpage` = '3' AND `eod` >= CURRENT_DATE() AND `pod` <= CURRENT_DATE()";

	//Old MySQL
	//$resultALERT = mysqli_query($conn,$queryALERT);

    $resultALERT = mysqli_query($conn, $queryALERT);

    // Old MySQL
	// while($rowALERT = $resultALERT->fetch_array(MYSQLI_ASSOC))

    while($rowALERT = $resultALERT->fetch_array(MYSQLI_ASSOC))
	{
?>
<div id="alert-bar-splash" style="background-color: #ffcccc;">
  <div class="row">
    <div class="small-12 columns">
<br>
<br>
<p><big><b><i class="fa fa-exclamation-triangle note" aria-hidden="true" title="Action!"></i> <?php echo "{$rowALERT['line1']}"; ?></b></big></p>
<p><?php echo "{$rowALERT['line2']}"; ?></p>
<br>
<br>
    </div>
  </div>
</div>
<?php
	}
?>
<?php
	$queryALERT  = "SELECT `line1`, `line2` FROM `alert` WHERE `showonpage` = '2' AND `eod` >= CURRENT_DATE() AND `pod` <= CURRENT_DATE()";

	//Old MySQL
	//$resultALERT = mysqli_query($conn,$queryALERT);

    $resultALERT = mysqli_query($conn, $queryALERT);

    // Old MySQL
	//while($rowALERT = $resultALERT->fetch_array(MYSQLI_ASSOC))
    while($rowALERT = $resultALERT->fetch_array(MYSQLI_ASSOC))
	{
?>
<div id="alert-bar-splash" style="background-color: #ffcccc;">
  <div class="row">
    <div class="small-12 columns">
<p><b><i class="fa fa-exclamation-triangle note" aria-hidden="true" title="Action!"></i> <?php echo "{$rowALERT['line1']}"; ?></b></big></p>
<p><?php echo "{$rowALERT['line2']}"; ?></p>
    </div>
  </div>
</div>
<?php
	}
?>
<?php
	$queryALERT  = "SELECT `line1`, `line2` FROM `alert` WHERE `showonpage` = '1' AND `eod` >= CURRENT_DATE() AND `pod` <= CURRENT_DATE()";

    //Old MySQL
	//$resultALERT = mysqli_query($conn,$queryALERT);

    $resultALERT = mysqli_query($conn, $queryALERT);

	//while($rowALERT = $resultALERT->fetch_array(MYSQLI_ASSOC))
    while($rowALERT = $resultALERT->fetch_array(MYSQLI_ASSOC))
	{
?>
<div id="alert-bar-splash">
  <div class="row">
    <div class="small-12 columns">
<br>
<br>
<p><big><b><i class="fa fa-exclamation-triangle note" aria-hidden="true" title="Action!"></i> <?php echo "{$rowALERT['line1']}"; ?></b></big></p>
<p><?php echo "{$rowALERT['line2']}"; ?></p>
<br>
<br>
    </div>
  </div>
</div>
<?php
	}
?>
