<?php
$query = "SELECT `packagetype`, `received` FROM `packages` WHERE `pickedup` = '0000-00-00 00:00:00' AND `userid` != '0' ORDER BY `received` DESC LIMIT 1";
$result = mysqli_query($conn, $query);
$row = $result->fetch_array(MYSQLI_ASSOC);

if (!empty($row)) { ?>
<!-- Last Entered Package -->
                <div>
                    <div class="large-12 columns">
                        <div class="slider-icon-center center">
                            <i class="fa fa-gift" aria-hidden="true"></i>
                            <h2>Last package entered was a<br><?php echo "{$row['packagetype']}"; ?> on <?php echo date('l', strtotime($row['received'])); ?> at <?php echo date('g:i A', strtotime($row['received'])); ?>.</h2>
                            <h3>You can choose whether or not to have your packages and deliveries appear on this display by editing your profile on your community website.</h3>
                        </div>
                    </div>
                </div>
<!-- Last Entered Package -->
<?php } ?>

<!-- Packages Carousel -->
<?php
$query = "SELECT count(*) as records FROM `packages` WHERE `pickedup` = '0000-00-00 00:00:00' AND `userid` != '0' AND `DID` = 'Y' ORDER BY `unit`, `unit2`";
$result = mysqli_query($conn, $query);
$rowCNT = $result->fetch_array(MYSQLI_ASSOC);

$packages = $rowCNT['records'];
$pages = ceil($packages/21);

$limit = 21;
$offset = 0;

for($page = 1; $page <= $pages; $page++ ) {
?>
<?php if ($packages >= '1'){ ?>

<!-- Packages Cell -->
                <div>
                    <div class="large-12 columns">
                        <div class="vertical-packages-row">

                            <?php
                            $query = "SELECT `packagetype`, `unit`, `unit2` FROM `packages` WHERE `pickedup` = '0000-00-00 00:00:00' AND `userid` != '0' AND `DID` = 'Y' ORDER BY `unit`, `unit2` LIMIT $offset, $limit";
                            $result = mysqli_query($conn, $query);

                            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                            ?>
                                <!-- Tile -->
                                <div class="vertical-packages-container">
                                    <div class="delivery-logo">
                                        <?php include('../display/icons-packages.php'); ?>
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
                            ?>

                        </div>
                        <div align="center" style="margin-top: 20px;">
                            <h3>Page <?php echo $page; ?> of <?php echo $pages; ?></h3>
                        </div>
                    </div>
                </div>
<!-- Packages Cell -->
<?php }; ?>
<?php
    $offset = ($limit * $page);
}
?>

<?php if ($packages >= '1'){ ?>
<!-- Packages Pickup Location -->
                <div>
                    <div class="large-12 columns">
                        <div class="slider-icon-center center">
                            <i class="fa fa-gift" aria-hidden="true"></i>
                            <h2><?php include('../my-documents/package-locations.php'); ?></h2>
                            
                        </div>
                    </div>
                </div>
<!-- Packages Pickup Location -->
<?php } ?>