<?php
foreach ($connectionPool as $connName => $configuration) {
    $countDOCCOUNT = 0;
    $queryDOCCNT = "SELECT count(*) as `docCount` FROM `documents` WHERE owner = 'Y' AND (type != 'image/jpeg' AND type != 'image/pjpeg' AND type != 'image/gif' AND type != 'image/png') AND created_date BETWEEN NOW() - INTERVAL 60 DAY AND NOW() AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE()";
    $resultDOCARRAY = mysqli_query($configuration['connection'],$queryDOCCNT);
    $data = $resultDOCARRAY->fetch_array(MYSQLI_ASSOC);
    $countDOCCOUNT = $data['docCount'];

//$sqlDOCCOUNT = mysqli_query($conn,"SELECT count(*) FROM `documents` WHERE owner = 'Y' AND (type != 'image/jpeg' AND type != 'image/pjpeg' AND type != 'image/gif' AND type != 'image/png') AND created_date BETWEEN NOW() - INTERVAL 60 DAY AND NOW() AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE()") or die(mysqli_error($conn));
//$countDOCCOUNT = mysql_result($sqlDOCCOUNT, "0");
//$row = mysqli_fetch_row($sqlDOCCOUNT);
//$countDOCCOUNT = $row[0];
    if ($countDOCCOUNT >= 1){ ?>
        <!-- Recent Documents Setup -->
                <div>
                    <div class="large-3 columns">
                        <div class="slider-icon center">
                            <i class="fa fa-file-text-o" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="large-9 columns">
                        <div class="information left">
                            <h2>New Documents Available on the Website to download</h2>
                            <p>Up to the five most recent uploaded in the last 60 days.</p>
                        </div>
                    </div>
                    <div class="large-12 columns">
                            <ul>
<!-- Recent Documents List -->
<?php
	$query  = "SELECT `title` FROM `documents` WHERE `owner` = 'Y' AND (`type` != 'image/jpeg' AND `type` != 'image/pjpeg' AND `type` != 'image/gif' AND `type` != 'image/png') AND `created_date` BETWEEN NOW() - INTERVAL 60 DAY AND NOW() AND `aod` NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY `created_date` DESC LIMIT 5";
	$result = mysqli_query($configuration['connection'], $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

?>
<li><?php echo "{$row['title']}"; ?></li>
<?php
	}
?>
<!-- Recent Documents List -->
                            </ul>
                        </div>
                    </div>
                </div>
<!-- Recent Documents Setup -->
<?php }
}
?>