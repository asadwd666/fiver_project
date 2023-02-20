<!-- User Bar Setup -->
<div id="user-bar">
<div class="row">

<!-- User Bar Name and Badges -->
    <div class="small-7 medium-5 large-4 columns">
      <div class="user-bar-box-container">
        <div class="user-bar-box user-bar-box__title">
          <div class="user-bar-box-inline-item">Hi, <span class="user-bar-welcome-name"><a href="../modules/user.php" class="iframe-link" title="Update your profile and change your password."><?php echo str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($_SESSION['first_name'])))); ?></a></span></div>

<!-- Service Requests -->
<?php $unit = $_SESSION['unit']; $unit2 = $_SESSION['unit2'];
        $queryUNIT = "SELECT `id` FROM `users` WHERE `unit` = '$unit' AND `unit2` = '$unit2' LIMIT 1";
        $resultUNIT = mysqli_query($conn,$queryUNIT);
        while($rowUNIT = mysqli_fetch_array($resultUNIT, MYSQLI_ASSOC)) { ?>
    <?php $user = $rowUNIT['id'];
            $type = $_SESSION['id'];
            $sqlSRu = mysqli_query($conn,"SELECT count(userid) FROM `service` WHERE `userid` = '$user' AND `privacy` = 'Y' AND `userid` != '$type'") or die(mysqli_error($conn));
            //$countSRu = mysql_result($sqlSRu, "0");
            $res=mysqli_fetch_row($sqlSRu);
            $countSRu = $res[0];
            ?>
    <?php $type = $_SESSION['id']; $sqlSRp = mysqli_query($conn,"SELECT count(userid) FROM `service` WHERE `userid` = '$type'") or die(mysqli_error($conn));
    //$countSRp = mysql_result($sqlSRp, "0");
            $row = mysqli_fetch_row($sqlSRp);
            $countSRp = $row[0];
    ?>
        <?php if ($countSRu >= '1' OR $countSRp >= '1'){ ?>
            <div class="user-bar-box-inline-item">
                <a href="../modules/servicerequests.php" class="iframe-link">
                    <i class="fa fa-wrench w" aria-hidden="true" title="View and comment on your Service Requests." border="0" src=""></i>
                </a>
                <sup>
                    <?php $type = $_SESSION['id'];
                            $sql = mysqli_query($conn,"SELECT count(*) FROM `service` WHERE `userid` = '$type' AND `status` != 'C'") or die(mysqli_error($conn));
                            //$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0];
                            $res=mysqli_fetch_row($sql);
                            $count = $res[0];
                            if ($count >= '1'){ print($count); } ?></sup></div>
        <?php }; ?>
<?php }; ?>

<!-- Pets -->
<?php $type = $_SESSION['id']; $sqlPET = mysqli_query($conn,"SELECT count(userid) FROM `pets` WHERE `userid` = '$type'") or die(mysqli_error($conn));
//$countPET = mysql_result($sqlPET, "0");
$row = mysqli_fetch_row($sqlPET);
$countPET = $row[0];
?>
    <?php if ($countPET >= '1'){ ?>
        <div class="user-bar-box-inline-item">
            <a href="../modules/pets-personal.php" class="iframe-link">
                <i class="fa fa-paw w" aria-hidden="true" title="View and edit your <?php $type = $_SESSION['id']; $sql = mysqli_query($conn,"SELECT count(userid) FROM `pets` WHERE userid = '$type'") or die(mysqli_error($conn));
                    //$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
        $count = $row[0];
                    print($count); ?> pets."></i></a></div>
    <?php }; ?>

<!-- Vehicles -->
<?php $type = $_SESSION['id']; $sqlCAR = mysqli_query($conn,"SELECT count(userid) FROM `vehicles` WHERE `userid` = '$type'") or die(mysqli_error($conn));
//$countCAR = mysql_result($sqlCAR, "0");
$row = mysqli_fetch_row($sqlCAR);
$countCAR = $row[0];
?>
    <?php if ($countCAR >= '1'){ ?>
        <div class="user-bar-box-inline-item"><a href="../modules/vehicles-personal.php" class="iframe-link"><i class="fa fa-car w" aria-hidden="true" title="View and edit your <?php $type = $_SESSION['id']; $sql = mysqli_query($conn,"SELECT count(userid) FROM vehicles WHERE userid = '$type'") or die(mysqli_error($conn));
        //$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
        $count = $row[0];
        print($count); ?> vehicles/bicycles."></i></a></div>
    <?php }; ?>

<!-- Packages -->
<?php $type = $_SESSION['id']; $sqlPKG = mysqli_query($conn,"SELECT count(userid) FROM `packages` WHERE `userid` = '$type'") or die(mysqli_error($conn));
//$countPKG = mysql_result($sqlPKG, "0");
$row = mysqli_fetch_row($sqlPKG);
$countPKG = $row[0];
?>
    <?php if ($countPKG >= '1'){ ?>
        <div class="user-bar-box-inline-item"><a href="../modules/packages-personal.php" class="iframe-link"><i class="fa fa-gift" aria-hidden="true" title="You have <?php $type = $_SESSION['id']; $sql = mysqli_query($conn,"SELECT count(userid) FROM packages WHERE userid = '$type' AND pickedup = '0000-00-00 00:00:00'") or die(mysqli_error($conn));
        //$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
        $count = $row[0];
        print($count); ?> package and/or delivery waiting at the Front Desk." border="0"></i></a><sup><?php $sql = mysqli_query($conn,"SELECT count(userid) FROM packages WHERE userid = '$type' AND pickedup = '0000-00-00 00:00:00'") or die(mysqli_error($conn));
        //$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; print($count); ?></sup></div>
    <?php }; ?>

        </div>
      </div>
    </div>

<!-- User Bar Menu and Logout -->
    <div class="small-5 medium-3 medium-push-4 large-push-6 large-2 columns">
      <div class="user-bar-box-container">
        <div class="user-bar-box">
          <div class="user-bar-box-inline-item">
            <div class="user-bar-profile"><a href="../modules/user.php" class="iframe-link" title="Update your profile and change your password.">Profile</a> | <a href="../logout.php" title="Logout from the website.">Logout</a></div>
          </div>
        </div>
      </div>
    </div>

<!-- Site Update -->
    <div class="small-12 medium-4 medium-pull-4 large-pull-2 large-6 columns">
      <div class="user-bar-box-container">
        <div class="user-bar-box">
          <div class="user-bar-rss"><?php if ($_GET["section"] == 'owner') { ?><?php include('owner/home-rss.php'); ?><?php }; ?>Site updated on <b><?php $query  = "SELECT date FROM updatedate"; $result = mysqli_query($conn, $query); while($row = $result->fetch_array(MYSQLI_ASSOC)) { echo "{$row['date']}"; } ?></b></div>
        </div>
      </div>
    </div>

<!-- User Bar Setup -->
</div>
</div>