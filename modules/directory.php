<?php
$MAIactive=false;
if (file_exists('../my-documents/php7-my-directory-db.php')) {
    $MAIactive=true;
    require_once('../my-documents/php7-my-directory-db.php');
} else {
    require_once('../my-documents/php7-my-db.php');
}

$connName = isset($_GET['conn']) ? $_GET['conn'] : "none";
if (isset($connectionPool) && isset($connectionPool[$connName])) {
    $dbConn = $connectionPool[$connName]['connection'];
} else {
    $dbConn = $conn;
    $connectionPool = array();
    $connectionPool[$CommunityName] = array('priority' => 10, 'connection' =>  $conn, 'master' => false, 'primary' => true);
}
?>
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">
<head>
	<meta charset="utf-8">
	<!--[if lte IE 10]><meta http-equiv="refresh" content="0;url=../IE.html" /><![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="CondoSites - http://www.condosites.com" name="author">
	<title><?php include('../my-documents/communityname.html'); ?></title>
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	<link rel="stylesheet" href="../css/foundation.css">
	<link rel="stylesheet" href="../css/magnific-popup.css">
	<link rel="stylesheet" href="../css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/jquery-ui.min.css">
	<link rel="stylesheet" href="../css/jquery-ui.structure.min.css">
	<link rel="stylesheet" href="../css/app.css">
    <link rel="stylesheet" href="../my-documents/app-custom.css">
    <script src="../java/table.js" type="text/javascript"></script>
	<script src="../java/vendor/jquery.js"></script>
	<script src="../java/vendor/jquery-ui.min.js"></script>
	<script src="../java/vendor/jquery.magnific-popup.min.js"></script>
</head>

<body>

<div id="all-documents-folder" class="hidden-print stand-alone-page">
  <div class="popup-header">
    <h4>
<?php
	$query  = "SELECT title FROM tabs WHERE `int1` = '225'";
	$result = mysqli_query($dbConn, $query);
	$row = $result->fetch_array(MYSQLI_ASSOC);

	if (!empty($row) && !empty($row['title']))
	{
        echo "{$row['title']}";
	}
?>
    </h4>
    <input type="button" value="Print Directory" onClick="window.open('directory-print.php?conn=<?php echo $connName; ?>');" class="filter-note" style="margin-top: 25px; ">
  </div>

<!-- Mobile Filter Notice -->
  <div class="stand-alone-page-content">
    <div class="rotate-note">Rotate your device to sort and filter information.</div>
  </div>
  
</div>

<!-- CONTENT -->
<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0" class="hidden-print responsive-table table-autosort table-autofilter table-stripeclass:alternate table-stripeclass:alternate table-autostripe table-rowshade-alternate">

<!-- PERMISSION CHECKS -->

<?php if (($_SESSION['owner'] != true) AND ($_SESSION['lease'] != true) AND ($_SESSION['realtor'] != true)) { ?>
  <tfoot>
    <tr style="background-color: #FAFEB8;">
      <th colspan="100">
<br>
<br>
<br>
<br>
<big>Sorry, you need to be logged in to view this content.</big><br>
<br>
<br>
<br>
<br>
      </th>
    </tr>
  </tfoot>
<?php } ?>

<?php if (($_SESSION['ghost'] == 'Y') AND ($_SESSION['webmaster'] != true)){ ?>
  <tfoot>
    <tr style="background-color: #FAFEB8;">
      <th colspan="100">
<br>

<br>
<br>
<br>
<big>Sorry, this page is not available to guests.</big><br>
<br>
<br>
<br>
<br>
      </th>
    </tr>
  </tfoot>
<?php } ?>

<!-- END PERMISSION CHECKS -->

<?php if (($_SESSION['owner'] == true) OR ($_SESSION['lease'] == true) OR ($_SESSION['realtor'] == true)){ ?>
<?php if (($_SESSION['ghost'] != 'Y') OR ($_SESSION['webmaster'] == true)){ ?>
  <thead>
    <tr>
      <th colspan="3">
          <p>Only registered website users are listed.<br>Contact information is only displayed for users who have opted to allow it.</p>
          <p><small>The information contained is intended for non-commercial purposes only.</small></p>
      </th>
      <th colspan="2" align="center">
    <?php if ($_SESSION['ghost'] !== 'Y') { ?>
        <form name="UserEdit" method="POST" action="../modules/user.php">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?php echo($_SESSION['id']); ?>">
            <input name="submit" value="Edit My Information and Preferences" class="submit" type="submit">
	    </form>
	<?php } ?>
      </th>
    </tr>
    <tr>
      <th align="left" class="table-sortable:alphanumeric" style="cursor:pointer;">&nbsp;&nbsp;&nbsp; <small>Name</small></th>
<?php
$sqlU1 = "SELECT count(*) as U1Count FROM users WHERE `unit` NOT BETWEEN '0' AND '999999'";
$dataArray = array();
$countU1 = 0;
foreach ($connectionPool as $connName => $configuration) {
    $displayResults = array_key_exists('displayResults', $configuration) ? $configuration['displayResults'] : TRUE;
    if ($displayResults === true) {
        $resultU1 = mysqli_query($configuration['connection'], $sqlU1);
        while ($data = $resultU1->fetch_array(MYSQLI_ASSOC)) {
            $countU1 += $data['U1Count'];
        }
    }
}
?>
<th <?php if ($countU1 == '0'){ ?>class="table-sortable:numeric"<?php }; ?><?php if ($countU1 !== '0'){ ?>class="table-sortable:alphanumeric"<?php }; ?> width="100" align="left">&nbsp;&nbsp;&nbsp; <small>Unit</small></small></th>
<?php
$sqlU2 = "SELECT count(*) as U2Count FROM users WHERE unit2 != 'X'";
$dataArray = array();
$countU2 = 0;
$master = false;
foreach ($connectionPool as $connName => $configuration) {
    $displayResults = array_key_exists('displayResults', $configuration) ? $configuration['displayResults'] : TRUE;
    if ($displayResults === true) {
        $resultU2 = mysqli_query($configuration['connection'], $sqlU2);
        while ($data = $resultU2->fetch_array(MYSQLI_ASSOC)) {
            $countU2 += $data['U2Count'];
        }
    }
}
?>
<?php if ($countU2 != '0'){ ?>
      <th align="left" class="table-sortable:alphanumeric table-filterable" style="cursor:pointer;">&nbsp;&nbsp;&nbsp; <small>Street/Building</small></th>
<?php }; ?>
<?php if ($countU2 == '0'){ ?>
      <th align="left">&nbsp;</th>
<?php }; ?>
      <th align="left" class="table-sortable:alphanumeric" style="cursor:pointer;">&nbsp;&nbsp;&nbsp; <small>Email and Phone</small></th>
      <?php 
      if ($MAIactive === true) { ?>
        <th align="left" class="table-sortable:alphanumeric table-filterable" style="cursor:pointer;">&nbsp;&nbsp;&nbsp; <small>Community</small></th>
      <?php   
      } else { ?>
          <th align="left">&nbsp;</th>
      <?php } ?>
    </tr>
  </thead>
<?php } ?>
<?php } ?>
  <tbody>

<?php
	$sessionowner = $_SESSION['owner'];
	$sessionlease = $_SESSION['lease'];
	$sessionrealtor = $_SESSION['realtor'];
	$sessionghost = $_SESSION['ghost'];

	$query  = "SELECT owner, lease FROM `tabs` WHERE `int1`='225'";
	$result = mysqli_query($dbConn, $query);
    // There will at most be 1 row;
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if (empty($row)) {
        $row['owner'] = '';
        $row['lease'] = '';
        $row['ghost'] = '';
    }
?>
<?php if (((($row['owner'] == 'Y' && $sessionowner == '1') OR ($row['lease'] == 'Y' && $sessionlease == '1')) AND ($_SESSION['ghost'] != 'Y')) OR ($_SESSION['webmaster'] == true)){ ?>

<!-- DATABASE RESULTS -->
<?php
	$queryUSERS  = "SELECT `id`, `unit`, `unit2`, `first_name`, `last_name`, `email`, `phone`, `directory`, `dphone`, `owner`, `lease` 
                      FROM users 
                      WHERE ((`status` = 'active') 
                        AND (`owner` != 'false') 
                        AND (`hide` != 'Y')) OR 
                            ((`status` = 'active') 
                                 AND (`lease` != 'false') 
                                 AND (`hide` != 'Y')) 
                    ORDER BY `last_name`, `first_name`";
                  /**   ORDER BY `unit2` ASC, `unit` + 0 ASC, `last_name`, `first_name`"; **/

    $resultSet = array();
    $sortedOutput = array();
    $lnameArray = array();
    $fnameArray = array();
    foreach ($connectionPool as $connName => $configuration) {
        $displayResults = array_key_exists('displayResults', $configuration) ? $configuration['displayResults'] : TRUE;
        if ($displayResults === true) {
            $resultUSERS = mysqli_query($configuration['connection'], $queryUSERS);
            while ($data = $resultUSERS->fetch_array(MYSQLI_ASSOC)) {
                $data['community'] = $connName;
                $data['master'] = strtoupper($configuration['master']);
                /** $resultSet[$data['unit2']][$data['unit']][$data['last_name']][$data['first_name']] = $data; **/
                $resultSet[$data['last_name']][$data['first_name']] = $data;
            }
        }
    }
    ksort($resultSet, SORT_STRING);
    /**foreach($resultSet as $key=>$unitArray) {
        ksort($unitArray, SORT_STRING);
        foreach($resultSet as $lkey=>$lnameArray) {
            ksort($lnameArray, SORT_STRING); **/
            foreach($resultSet as $fkey=>$fnameArray) {
                ksort($fnameArray, SORT_STRING);
                foreach($fnameArray as $mkey=>$member) {
                    $sortedOutput[] = $member;
                }
            }
    /**
     * }  *
     */

   // $resultUSERS = mysqli_query($dbConn,$queryUSERS);
    //while($rowUSERS = $resultUSERS->fetch_array(MYSQLI_ASSOC))
    foreach($sortedOutput as $key=> $rowUSERS)
	{
?>
    <tr>
      <td>
	<b><?php echo($rowUSERS['last_name']); ?>, <?php echo($rowUSERS['first_name']); ?></b>
	<?php if ($rowUSERS['owner'] == '1'){ ?><br>Owner<?php }; ?><?php if ($rowUSERS['lease'] == '1'){ ?><?php if ($rowUSERS['owner'] != '1'){ ?><br>Renter<?php }; ?><?php }; ?>
	
<!-- MOBILE PORTRAIT RESULTS -->
    <div class="smallscreen-rotate-display">
        <?php echo "{$rowUSERS['unit']}"; ?><?php if ($countU2 != '0'){ ?> - <?php echo "{$rowUSERS['unit2']}"; ?><?php }; ?>
        <?php if ($rowUSERS['dphone'] == 'Y'){ ?><br><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$rowUSERS['phone']); ?>"><?php echo "{$rowUSERS['phone']}"; ?></a><?php }; ?>
        <?php if ($rowUSERS['directory'] == 'Y'){ ?><?php if ($rowUSERS['dphone'] == 'Y'){ ?><br><?php }; ?><a href="mailto:<?php echo($rowUSERS['email']); ?>"><?php echo($rowUSERS['email']); ?></a><?php }; ?>
        <?php if (isset($connectionPool)) { echo '<br>' . $rowUSERS['community']; } ?>
    </div>
<!-- MOBILE PORTRAIT RESULTS -->
	
      </td>
      <td><?php echo "{$rowUSERS['unit']}"; ?></td>
<?php if ($countU2 != '0'){ ?>
      <td><?php echo "{$rowUSERS['unit2']}"; ?></td>
<?php }; ?>
<?php if ($countU2 == '0'){ ?>
      <td>&nbsp;</td>
<?php }; ?>
      <td>
	<?php if ($rowUSERS['dphone'] == 'Y'){ ?><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$rowUSERS['phone']); ?>"><?php echo "{$rowUSERS['phone']}"; ?></a><?php }; ?>
	<?php if ($rowUSERS['directory'] == 'Y'){ ?><?php if ($rowUSERS['dphone'] == 'Y'){ ?><br><?php }; ?><a href="mailto:<?php echo($rowUSERS['email']); ?>"><?php echo($rowUSERS['email']); ?></a><?php }; ?>
      </td>
      <?php if ($MAIactive === true) {
          echo '<td>'. $rowUSERS['community'] .'</td>';
          } else {
          echo '<td></td>';
          }
          ?>
    </tr>
<?php } ?>
<?php
	}
?>
<!-- END DATABASE RESULTS -->

  </tbody>
</table>
<!-- CONTENT -->

</body>
	<script src="../java/vendor/what-input.js"></script>
	<script src="../java/vendor/foundation.min.js"></script>
	<script type="text/javascript" src="../java/google-base.js"></script>
	<script type="text/javascript" src="../my-documents/google-code.js"></script>
</html>
