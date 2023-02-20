<?php
if (!isset($connectionPool) || $connectionPool == null) {
    $connectionPool[$CommunityName] = array('priority' => 10, 'connection' =>  $conn, 'master' => false, 'primary' => true);
}

$localConnectionPool = array();

foreach ($connectionPool as $connName => $connection) {
    $localConnectionPool[$connection['priority']] = array('ConnectionName' => $connName, 'connection' => $connection['connection']);
}
sort($localConnectionPool, SORT_NUMERIC);

foreach ($localConnectionPool as $configuration) {

    $connName = $configuration['ConnectionName'];

    $countDOCCOUNT = 0;
    $query = "SELECT count(*) FROM `documents` WHERE owner = 'Y' AND (type != 'image/jpeg' AND type != 'image/pjpeg' AND type != 'image/gif' AND type != 'image/png') AND created_date BETWEEN NOW() - INTERVAL 60 DAY AND NOW() AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE()";

    $result = mysqli_query($configuration['connection'], $query);
    $row = mysqli_fetch_row($result);
    $countDOCCOUNT = $row[0];

    if ($countDOCCOUNT >= '1'){
        ?>

        <!-- Section -->
        <div class="newsboard-container newsboard-container__recent-documents">
            <div class="row">
                <div class="small-12 columns"><h3 class="newsboard-subtitle">Recently Uploaded Documents <?php echo ($connName == 'default' ? '' : 'by ' .$connName); ?></h3><label class="medium">This list shows up to 5 of the most recently uploaded documents over the last 60-days.</label></div>
            </div>

            <!-- Content -->
            <?php
            $dataArray = array();
            $query  = "SELECT `id`, type, title, aod, docdate, doctype, created_date, docdate, size FROM `documents` WHERE owner = 'Y' AND (type != 'image/jpeg' AND type != 'image/pjpeg' AND type != 'image/gif' AND type != 'image/png') AND created_date BETWEEN NOW() - INTERVAL 60 DAY AND NOW() AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY created_date DESC LIMIT 5";
            $result = mysqli_query($configuration['connection'], $query);

            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                ?>
                <div class="row">
                    <div class="small-12 medium-6 columns">
                        <div class="recent-documents-title"><p><?php include('../icon-links.php'); ?>
                                <a href="../download-documents.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>&conn=<?php echo $connName; ?>" target="_blank" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$row['id']}"; ?>'); "><?php echo "{$row['title']}"; ?></a></p></div>
                    </div>
                    <div class="small-12 medium-6 columns">
                        <div class="recent-documents-date"><p>Uploaded on <?php echo date('M d, Y', strtotime($row['created_date'])); ?>
                                <?php
                                $typeFID    = $row['doctype'];
                                $queryFID  = "SELECT link, title, options, image FROM folders WHERE title = '$typeFID'";
                                $resultFID = mysqli_query($configuration['connection'],$queryFID);

                                while($rowFID = $resultFID->fetch_array(MYSQLI_ASSOC))
                                {
                                    $link = $rowFID['link'] . "&conn=" . $connName;
                                    ?>
                                    to <a href="<?php echo "{$link}"; ?><?php echo "{$rowFID['title']}"; ?>" <?php echo "{$rowFID['options']}"; ?> class="iframe-link" onclick="javascript:pageTracker._trackPageview('FOLDER/<?php echo "{$rowFID['title']}"; ?>'); "><?php echo "{$rowFID['title']}"; ?></a>
                                    <?php
                                }
                                ?></p>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>

            <!-- All Documents -->
            <div class="row">
                <div class="small-12 columns">
                    <div class="calendar-view-full"><a href="../modules/documentcenter.php?conn=<?php echo $connName; ?>" class="iframe-link"><i class="fa fa-folder" aria-hidden="true"></i>View All Documents</a></div>
                </div>
            </div>

            <!-- Section -->
        </div>

        <?php
    }
}
?>
