<!-- Packages Carousel -->
<?php
$query = "SELECT count(*) as records FROM `packages` WHERE `pickedup` = '0000-00-00 00:00:00' AND `userid` != '0' AND `DID` = 'Y' ORDER BY `unit`, `unit2`";
$packages = 0;
foreach ($connectionPool as $connName => $configuration) {
    $resultARRAY = mysqli_query($configuration['connection'],$query);
    $data = $resultARRAY->fetch_array(MYSQLI_ASSOC);
    $packages += $data['records'];
}
//$result = mysqli_query($conn, $query);
//$rowCNT = $result->fetch_array(MYSQLI_ASSOC);
//$packages = $rowCNT['records'];
$pages = ceil($packages/24);

$limit = 24;
$offset = 0;

for($page = 1; $page <= $pages; $page++ ) {
?>
<?php if ($packages >= '1'){ ?>
<div>
<!-- Packages Pickup Location -->
    <div class="large-4 columns">
        <div class="slider-icon center">
            <i class="fa fa-gift" aria-hidden="true"></i>
            <div class="packageslocation">
                <p><?php include('../my-documents/package-locations.php'); ?></p>
                <h3>Page <?php echo $page; ?> of <?php echo $pages; ?></h3>
            </div>
        </div>
    </div>
<!-- Packages Pickup Location -->

<!-- Packages Cell -->
    <div class="large-8 columns">
        <div class="information left">
            <div class="horizontal-packages-row">

                <?php
                $query = "SELECT `packagetype`, `unit`, `unit2` FROM `packages` WHERE `pickedup` = '0000-00-00 00:00:00' AND `userid` != '0' AND `DID` = 'Y' ORDER BY `unit`, `unit2` LIMIT $offset, $limit";
//                $result = mysqli_query($conn, $query);
//                while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $dataArray = array();
                foreach ($connectionPool as $connName => $configuration) {
                    $resultARRAY = mysqli_query($configuration['connection'],$query);
                    while ($data = $resultARRAY->fetch_array(MYSQLI_ASSOC)) {
                        $dataArray[$data['unit']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
                    }
                }

                foreach($dataArray as $recordArray ) {
                    asort($recordArray);
                    foreach ($recordArray as $records) {
                        foreach($records as $record) {
                            $row = $record['data'];

                ?>
                    <!-- Tile -->
                    <div class="horizontal-packages-container">
                        <div class="delivery-logo">
                            <?php include('icons-packages.php'); ?>
                        </div>

                        <div class="unit-number">
                            <h4><?php echo "{$row['unit']}"; ?></h4>
                        </div>
                        <?php if ($row['unit2'] !== 'X') { ?>
                            <div class="tower-number">
                                <h5><?php include('../my-documents/units-packages.php'); ?></h5>
                            </div>
                        <?php }; ?>
                    </div>
                    <!-- End Tile -->
                <?php
                        }
                    }
                }
                ?>

            </div>
        </div>
    </div>
<!-- END Packages Cell -->

</div>
<?php }; ?>
<!-- END Packages Carousel -->
<?php
    $offset = ($limit * $page);
}
?>


<!-- Last Entered Package -->
<?php if ($packages >= '1'){ ?>
<?php
$query = "SELECT `packagetype`, `received` FROM `packages` WHERE `pickedup` = '0000-00-00 00:00:00' AND `userid` != '0' ORDER BY `received` DESC LIMIT 1";
$dataArray = array();
foreach ($connectionPool as $connName => $configuration) {
    $resultARRAY = mysqli_query($configuration['connection'],$query);
    while ($data = $resultARRAY->fetch_array(MYSQLI_ASSOC)) {
        $dataArray[$data['received']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
    }
}

foreach($dataArray as $recordArray ) {
    asort($recordArray);
    foreach ($recordArray as $records) {
        foreach($records as $record) {
            $row = $record['data'];

//$result = mysqli_query($conn, $query);
//$row = $result->fetch_array(MYSQLI_ASSOC);

if (!empty($row)) { ?>
<div>
    <div class="large-4 columns">
        <div class="slider-icon center">
            <i class="fa fa-gift" aria-hidden="true" style="font-size: 420px; margin-top: 20px;"></i>
        </div>
    </div>
    <div class="large-8 columns">
        <div class="information left">
            <h2 style="margin-top: 100px; margin-bottom: 50px;">Last package entered was
                a<br><?php echo "{$row['packagetype']}"; ?>
                on <?php echo date('l', strtotime($row['received'])); ?>
                at <?php echo date('g:i A', strtotime($row['received'])); ?>.</h2>
            <br>
            <h3>You can choose whether or not to have your packages and deliveries appear on this display by editing
                your profile on your community website.</h3>
        </div>
    </div>
</div>
<?php
                }
            }
        }
    }
}
?>