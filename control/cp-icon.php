<?php if ($row['id'] == '1'){ ?>

<!-- 3RD PARTY AND CUSTOM CONTENT -->
	<div><a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?></a></div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>
<!-- 3RD PARTY AND CUSTOM CONTENT -->

<?php }; ?>
<?php if ($row['id'] == '2'){ ?>

<!-- BOARD AND STAFF -->
<?php $sqlBSc = mysqli_query($conn,"SELECT count(*) FROM board") or die(mysqli_error($conn));
//$countBSc = mysql_result($sqlBSc, "0");
    $rowBSc = mysqli_fetch_row($sqlBSc);
    $countBSc = $rowBSc[0];
?>
<?php $sqlBS = mysqli_query($conn,"SELECT count(*) FROM board WHERE date > NOW() - INTERVAL 365 DAY") or die(mysqli_error($conn));
//$countBS = mysql_result($sqlBS, "0");
    $rowBS = mysqli_fetch_row($sqlBS);
    $countBS = $rowBS[0];
?>

	<div>
		<a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?>
		<?php if ($countBS == '0' AND $countBSc > '0'){ ?><i class="fa fa-exclamation-triangle red" aria-hidden="true"></i><?php }; ?>
		</a>
	</div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>

	<?php if ($countBS == '0' AND $countBSc > '0'){ ?><div class="health-red">Is this content current?</div><?php }; ?>
<!-- BOARD AND STAFF -->

<?php }; ?>
<?php if ($row['id'] == '3'){ ?>

<!-- BUSINESS DIRECTORY -->
<?php $sqlBSD = mysqli_query($conn,"SELECT count(*) FROM concierge WHERE approved != 'Y'") or die(mysqli_error($conn));
//$countBSD = mysql_result($sqlBSD, "0");
    $rowBSD = mysqli_fetch_row($sqlBSD);
    $countBSD = $rowBSD[0];
?>

	<div>
		<a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?>
		<?php if ($countBSD != '0'){ ?><i class="fa fa-exclamation-triangle red" aria-hidden="true"></i><?php }; ?>
		</a>
	</div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>

	<?php if ($countBSD != '0'){ ?><div class="health-red"><?php print($countBSD); ?> Action Items!</div><?php }; ?>
<!-- BUSINESS DIRECTORY -->

<?php }; ?>
<?php if ($row['id'] == '4'){ ?>

<!-- CALENDAR -->
<?php $sqlCALc = mysqli_query($conn,"SELECT count(*) FROM calendar") or die(mysqli_error($conn));
//$countCALc = mysql_result($sqlCALc, "0");
    $rowCALc = mysqli_fetch_row($sqlCALc);
    $countCALc = $rowCALc[0];
?>
<?php $sqlCAL = mysqli_query($conn,"SELECT count(*) FROM calendar WHERE date >= CURRENT_DATE() AND `event` != 'Holiday'") or die(mysqli_error($conn));
//$countCAL = mysql_result($sqlCAL, "0");
    $rowCAL = mysqli_fetch_row($sqlCAL);
    $countCAL = $rowCAL[0];
?>

	<div>
		<a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?>
		<?php if ($countCAL == '0' AND $countCALc > '0'){ ?><i class="fa fa-exclamation-triangle red" aria-hidden="true"></i><?php }; ?>
		<?php if ($countCAL == '1'){ ?><i class="fa fa-exclamation-triangle red" aria-hidden="true"></i><?php }; ?>
		<?php if ($countCAL == '2'){ ?><i class="fa fa-exclamation-triangle orange" aria-hidden="true"></i><?php }; ?>
		</a>
	</div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>

	<?php if ($countCAL == '0' AND $countCALc > '0'){ ?><div class="health-red">Calendar is empty!</div><?php }; ?>
	<?php if ($countCAL == '1'){ ?><div class="health-red">Dates Needed!</div><?php }; ?>
	<?php if ($countCAL == '2'){ ?><div class="health-orange">Dates Needed!</div><?php }; ?>
<!-- CALENDAR -->

<?php }; ?>
<?php if ($row['id'] == '5'){ ?>

<!-- DOCUMENTS AND PHOTOS -->
<?php $sqlDOC = mysqli_query($conn,"SELECT count(*) FROM documents WHERE created_date > NOW() - INTERVAL 60 DAY") or die(mysqli_error($conn));
//$countDOC = mysql_result($sqlDOC, "0");
    $rowDOC = mysqli_fetch_row($sqlDOC);
    $countDOC = $rowDOC[0];
?>

	<div>
		<a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?>
		<?php if ($countDOC == '0'){ ?><i class="fa fa-exclamation-triangle orange" aria-hidden="true"></i><?php }; ?>
		</a>
	</div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>

	<?php if ($countDOC == '0'){ ?><div class="health-orange">Are your Documents current?</div><?php }; ?>
<!-- DOCUMENTS AND PHOTOS -->

<?php }; ?>
<?php if ($row['id'] == '6'){ ?>

<!-- FAQs -->
<?php $sqlFAQ = mysqli_query($conn,"SELECT count(*) FROM faq WHERE created_date > NOW() - INTERVAL 365 DAY") or die(mysqli_error($conn));
//$countFAQ = mysql_result($sqlFAQ, "0");
    $rowFAQ = mysqli_fetch_row($sqlFAQ);
    $countFAQ = $rowFAQ[0];
?>

	<div>
		<a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?>
		<?php if ($countFAQ == '0'){ ?><i class="fa fa-exclamation-triangle orange" aria-hidden="true"></i><?php }; ?>
		</a>
	</div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>

	<?php if ($countFAQ == '0'){ ?><div class="health-orange">Is this content current?</div><?php }; ?>
<!-- FAQs -->

<?php }; ?>
<?php if ($row['id'] == '7'){ ?>

<!-- MEETING BOX -->
	<div>
		<a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?>
		<?php $queryMB  = "SELECT created_date FROM meetingbox WHERE created_date BETWEEN NOW() - INTERVAL 1000 DAY AND NOW() - INTERVAL 61 DAY"; $resultMB = mysqli_query($conn,$queryMB); while($rowMB = $resultMB->fetch_array(MYSQLI_ASSOC)) { ?><i class="fa fa-exclamation-triangle red" aria-hidden="true"></i><?php }; ?>
		</a>
	</div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>

	<?php $queryMB  = "SELECT created_date FROM meetingbox WHERE created_date BETWEEN NOW() - INTERVAL 1000 DAY AND NOW() - INTERVAL 61 DAY"; $resultMB = mysqli_query($conn,$queryMB); while($rowMB = $resultMB->fetch_array(MYSQLI_ASSOC)) { ?><div class="health-red">Update Needed!</div><?php }; ?>
<!-- MEETING BOX -->

<?php }; ?>
<?php if ($row['id'] == '8'){ ?>

<!-- MASTER PERMISSIONS -->
	<div><a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?></a></div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>
<!-- MASTER PERMISSIONS -->

<?php }; ?>
<?php if ($row['id'] == '9'){ ?>

<!-- NEWSBOARD -->
<?php $sqlNEWS = mysqli_query($conn,"SELECT count(*) FROM chalkboard WHERE eod >= CURRENT_DATE() AND pod <= CURRENT_DATE() AND sample = '0'") or die(mysqli_error($conn));
$rowNEWS = mysqli_fetch_row($sqlNEWS);
$countNEWS = $rowNEWS[0];
?>
<?php $sqlNEWS2 = mysqli_query($conn,"SELECT count(*) FROM chalkboard WHERE sample = '0' AND pod >= CURRENT_DATE() - INTERVAL 30 DAY AND pod <= CURRENT_DATE()") or die(mysqli_error($conn));
$rowNEWS2 = mysqli_fetch_row($sqlNEWS2);
$countNEWS2 = $rowNEWS2[0];
?>

	<div>
		<a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?>
		<?php if ($countNEWS == '0') { ?><i class="fa fa-exclamation-triangle red" aria-hidden="true"></i><?php }; ?>
		<?php if ($countNEWS != '0' AND $countNEWS2 == '0') { ?><i class="fa fa-exclamation-triangle orange" aria-hidden="true"></i><?php }; ?>
		</a>
	</div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>

	<?php if ($countNEWS == '0'){ ?><div class="health-red">Content Needed!</div><?php }; ?>
	<?php if ($countNEWS != '0' AND $countNEWS2 == '0') { ?><div class="health-orange">Content Needed!</div><?php }; ?>
<!-- NEWSBOARD -->

<?php }; ?>
<?php if ($row['id'] == '10'){ ?>

<!-- PACKAGES -->
<?php $sqlPAK = mysqli_query($conn,"SELECT count(*) FROM packages WHERE `pickedup` = '0000-00-00 00:00:00' AND `received` < NOW() - INTERVAL 15 DAY") or die(mysqli_error($conn));
//$countPAK = mysql_result($sqlPAK, "0");
    $rowPAK = mysqli_fetch_row($sqlPAK);
    $countPAK = $rowPAK[0];
?>

	<div>
		<a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?>
		<?php if ($countPAK >= '1'){ ?><i class="fa fa-exclamation-triangle orange" aria-hidden="true"></i><?php }; ?>
		</a>
	</div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>

	<?php if ($countPAK >= '1'){ ?><div class="health-orange">Packages need delivering!</div><?php }; ?>
<!-- PACKAGES -->

<?php }; ?>
<?php if ($row['id'] == '11'){ ?>

<!-- USER ACCOUNTS -->
<?php $sqlUSR = mysqli_query($conn,"SELECT count(*) FROM users WHERE (webmaster = '0' AND status != 'disabled' AND (email = '' OR (owner = '0' AND lease = '0' AND realtor = '0') OR (accessdate >= '0000-00-01' AND accessdate <= current_date())) OR (status = 'New') AND ghost != 'Y')") or die(mysqli_error($conn));
//$countUSR = mysql_result($sqlUSR, "0");
    $rowUSR = mysqli_fetch_row($sqlUSR);
    $countUSR = $rowUSR[0];
?>

	<div>
		<a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?>
		<?php if ($countUSR == '0'){ ?><i class="fa fa-check green" aria-hidden="true"></i><?php }; ?>
		<?php if ($countUSR != '0'){ ?><i class="fa fa-exclamation-triangle red" aria-hidden="true"></i><?php }; ?>
		</a>
	</div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>

	<?php if ($countUSR != '0'){ ?><div class="health-red"><?php print($countUSR); ?> Action Items!</div><?php }; ?>
<!-- USER ACCOUNTS -->

<?php }; ?>
<?php if ($row['id'] == '12'){ ?>

<!-- PETS -->
<?php $sqlPETS = mysqli_query($conn,"SELECT count(*) FROM pets WHERE approved != 'Y'") or die(mysqli_error($conn));
//$countPETS = mysql_result($sqlPETS, "0");
    $rowPETS = mysqli_fetch_row($sqlPETS);
    $countPETS = $rowPETS[0];
?>

	<div>
		<a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?>
		<?php if ($countPETS != '0'){ ?><i class="fa fa-exclamation-triangle red" aria-hidden="true"></i><?php }; ?>
		</a>
	</div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>

	<?php if ($countPETS != '0'){ ?><div class="health-red"><?php print($countPETS); ?> Action Items!</div><?php }; ?>
<!-- PETS -->

<?php }; ?>
<?php if ($row['id'] == '13'){ ?>

<!-- DOCUMENTS STAFF -->
	<div><a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?></a></div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>
<!-- DOCUMENTS STAFF -->

<?php }; ?>
<?php if ($row['id'] == '14'){ ?>

<!-- RESTRICTED DOCUMENTS -->
	<div><a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?></a></div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>
<!-- RESTRICTED DOCUMENTS -->

<?php }; ?>
<?php if ($row['id'] == '15'){ ?>

<!-- CLASSIFIEDS -->
<?php $sqlSELL = mysqli_query($conn,"SELECT count(*) FROM realestate WHERE approved != 'Y'") or die(mysqli_error($conn));
//$countSELL = mysql_result($sqlSELL, "0");
    $rowSELL = mysqli_fetch_row($sqlSELL);
    $countSELL = $rowSELL[0];
?>

	<div>
		<a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?>
		<?php if ($countSELL != '0'){ ?><i class="fa fa-exclamation-triangle red" aria-hidden="true"></i><?php }; ?>
		</a>
	</div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>

	<?php if ($countSELL != '0'){ ?><div class="health-red"><?php print($countSELL); ?> Action Items!</div><?php }; ?>
<!-- CLASSIFIEDS -->

<?php }; ?>
<?php if ($row['id'] == '16'){ ?>

<!-- UTILITIES -->
<?php $sqlUTL = mysqli_query($conn,"SELECT count(*) FROM utilities WHERE date > NOW() - INTERVAL 365 DAY AND `category` != 'Manager'") or die(mysqli_error($conn));
//$countUTL = mysql_result($sqlUTL, "0");
    $rowUTL = mysqli_fetch_row($sqlUTL);
    $countUTL = $rowUTL[0];
?>

	<div>
		<a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?>
		<?php if ($countUTL == '0'){ ?><i class="fa fa-exclamation-triangle orange" aria-hidden="true"></i><?php }; ?>
		</a>
	</div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>

    <?php if ($countUTL == '0'){ ?><div class="health-orange">Is this content current?</div><?php }; ?>
<!-- UTILITIES -->

<?php }; ?>
<?php if ($row['id'] == '17'){ ?>

<!-- DOCUMENTS BOARD -->
	<div><a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?></a></div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>
<!-- DOCUMENTS BOARD -->

<?php }; ?>
<?php if ($row['id'] == '18'){ ?>

<!-- FOLDERS -->
	<div><a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?></a></div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>
<!-- FOLDERS -->

<?php }; ?>
<?php if ($row['id'] == '19'){ ?>

<!-- VEHICLES -->
<?php $sqlCAR = mysqli_query($conn,"SELECT count(*) FROM vehicles WHERE approved != 'Y'") or die(mysqli_error($conn));
//$countCAR = mysql_result($sqlCAR, "0");
    $rowCAR = mysqli_fetch_row($sqlCAR);
    $countCAR = $rowCAR[0];
?>

	<div>
		<a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?>
		<?php if ($countCAR != '0'){ ?><i class="fa fa-exclamation-triangle red" aria-hidden="true"></i><?php }; ?>
		</a>
	</div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>


	<?php if ($countCAR != '0'){ ?><div class="health-red"><?php print($countCAR); ?> Action Items!</div><?php }; ?>
<!-- VEHICLES -->

<?php }; ?>
<?php if ($row['id'] == '20'){ ?>

<!-- MESSAGES -->
	<div><a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?></a></div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>
<!-- MESSAGES -->

<?php }; ?>
<?php if ($row['id'] == '21'){ ?>

<!-- EFORMS -->
	<div><a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?></a></div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>
<!-- EFORMS -->

<?php }; ?>
<?php if ($row['id'] == '22'){ ?>

<!-- CHANGE LOG -->
	<div><a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?></a></div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>
<!-- CHANGE LOG -->

<?php }; ?>
<?php if ($row['id'] == '23'){ ?>

<!-- CONTROL PANEL GROUPS -->
	<div><a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?></a></div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>
<!-- CONTROL PANEL GROUPS -->

<?php }; ?>
<?php if ($row['id'] == '24'){ ?>

<!-- DATABASE MAINTENANCE -->
	<div><a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?></a></div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>
<!-- DATABASE MAINTENANCE -->

<?php }; ?>
<?php if ($row['id'] == '25'){ ?>

<!-- UNITS -->
	<div><a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?></a></div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>
<!-- UNITS -->

<?php }; ?>
<?php if ($row['id'] == '26'){ ?>

<!-- HELP -->
	<div><a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?></a></div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>
<!-- HELP -->

<?php }; ?>
<?php if ($row['id'] == '27'){ ?>

<!-- GUIDE -->
	<div><a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?></a></div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>
<!-- GUIDE -->

<?php }; ?>
<?php if ($row['id'] == '28'){ ?>

<!-- VIDEOS -->
	<div><a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?></a></div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>
<!-- VIDEOS -->

<?php }; ?>
<?php if ($row['id'] == '29'){ ?>

<!-- CONTENT PLANNING GUIDE -->
	<div><a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?></a></div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>
<!-- CONTENT PLANNING GUIDE -->

<?php }; ?>
<?php if ($row['id'] == '30'){ ?>

<!-- SERVICE REQUESTS -->
<?php $sqlMAINTn = mysqli_query($conn,"SELECT count(*) FROM `service` WHERE `update_date` = '0000-00-00 00:00:00'") or die(mysqli_error($conn));
//$countMAINTn = mysql_result($sqlMAINTn, "0");
    $rowMAINTn = mysqli_fetch_row($sqlMAINTn);
    $countMAINTn = $rowMAINTn[0];
?>
<?php $sqlMAINT = mysqli_query($conn,"SELECT count(*) FROM `service` WHERE `status` != 'C'") or die(mysqli_error($conn));
//$countMAINT = mysql_result($sqlMAINT, "0");
    $rowMAINT = mysqli_fetch_row($sqlMAINT);
    $countMAINT = $rowMAINT[0];
?>

	<div>
		<a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?>
		<?php if ($countMAINT >= '1' AND $countMAINTn == '0'){ ?><i class="fa fa-exclamation-triangle orange" aria-hidden="true"></i><?php }; ?>
	    <?php if ($countMAINTn >= '1'){ ?><i class="fa fa-exclamation-triangle red" aria-hidden="true"></i><?php }; ?>
		</a>
	</div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>

	<?php if ($countMAINT >= '1' AND $countMAINTn == '0'){ ?><div class="health-orange"><?php print($countMAINT); ?> Service Requests open!</div><?php }; ?>
	<?php if ($countMAINTn == '1'){ ?><div class="health-red"><?php print($countMAINTn); ?> New Service Request!</div><?php }; ?>
	<?php if ($countMAINTn >= '2'){ ?><div class="health-red"><?php print($countMAINTn); ?> New Service Requests!</div><?php }; ?>
<!-- SERVICE REQUESTS -->

<?php }; ?>
<?php if ($row['id'] == '31'){ ?>

<!-- CUSTOM MODULES -->
	<div><a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?></a></div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>
<!-- CUSTOM MODULES -->

<?php }; ?>
<?php if ($row['id'] == '32'){ ?>

<!-- HOME TEXT -->
	<div><a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?></a></div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>
<!-- HOME TEXT -->

<?php }; ?>
<?php if ($row['id'] == '33'){ ?>

<!-- ALERT NOTICE -->
	<div><a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?></a></div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>
<!-- ALERT NOTICE -->

<?php }; ?>
<?php if ($row['id'] == '34'){ ?>

<!-- DIGITAL DISPLAY -->
	<div><a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?></a></div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>
<!-- DIGITAL DISPLAY -->

<?php }; ?>
<?php if ($row['id'] == '35'){ ?>
<?php $sqlMGR = mysqli_query($conn,"SELECT count(*) FROM utilities WHERE date > NOW() - INTERVAL 365 DAY AND `category` = 'Manager'") or die(mysqli_error($conn));
//$countMGR = mysql_result($sqlMGR, "0");
    $rowMGR = mysqli_fetch_row($sqlMGR);
    $countMGR = $rowMGR[0];
?>

<!-- PROPERTY MANAGEMENT -->
	<div><a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?></a></div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>
<!-- PROPERTY MANAGEMENT -->

	<?php if ($countMGR == '0'){ ?><div class="health-orange">Is this content current?</div><?php }; ?>
<?php }; ?>
<?php if ($row['id'] == '36'){ ?>
<?php $sqlEMV = mysqli_query($conn,"SELECT count(*) FROM `users` WHERE `emailconfirm` != 'V' AND webmaster = '0' AND status = 'Active' AND ghost != 'Y' AND email != '' AND password != '' AND (accessdate = '0000-00-00' OR accessdate >= current_date()) AND (owner = '1' OR lease = '1' OR realtor = '1')") or die(mysqli_error($conn));
//$countEMV = mysql_result($sqlEMV, "0");
    $rowEMV = mysqli_fetch_row($sqlEMV);
    $countEMV = $rowEMV[0];
?>

<!-- VERIFIED EMAIL ADDRESSES -->
	<div><a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?></a></div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>
<!-- VERIFIED EMAIL ADDRESSES -->

	<?php if ($countEMV != '0'){ ?><div class="health-orange"><?php print($countEMV); ?> Unverified Users!</div><?php }; ?>
<?php }; ?>
<?php if ($row['id'] == '37'){ ?>

<!-- ACCESSIBILITY -->
	<div><a href="<?php echo "{$row['url']}"; ?>" title="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['icon']}"; ?></a></div>
	<div><a href="<?php echo "{$row['url']}"; ?>"><?php echo "{$row['name']}"; ?></a></div>
<!-- ACCESSIBILITY -->

<?php }; ?>