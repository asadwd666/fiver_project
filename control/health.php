<?php if ($_SESSION['liaison'] OR $_SESSION['webmaster'] == true){ ?>
<!-- Health Bar Setup -->
<div id="health-bar">
<div class="row small-collapse">

<!-- Health Title and Logo -->
    <div class="medium-1 columns">
      <div class="health-bar-box-container health-bar-box-container__title">
        <div class="health-bar-box health-bar-box__title" align="center">
          <div class="health-title"><i class="fa fa-stethoscope" aria-hidden="true"></i><strong>Health</strong></div>
        </div>
      </div>
    </div>

<!-- Health Stars -->
    <div class="medium-3 columns">
      <div class="health-bar-box-container">
        <div class="health-bar-box health-bar-box__stars">
          <div class="health-stars-title"><strong>Stars for Content</strong> (5 max)</div>
          <div class="health-stars">
            
<!-- GOLD STARS -->
<?php $queryDOC  = "SELECT created_date FROM documents WHERE created_date BETWEEN NOW() - INTERVAL 30 DAY AND NOW() ORDER BY created_date DESC LIMIT 1"; $resultDOC = mysqli_query($conn,$queryDOC); while($rowDOC = $resultDOC->fetch_array(MYSQLI_ASSOC)) { ?>
<i class="fa fa-star" aria-hidden="true" title="You earned a star for recently uploading a document!"></i>
<?php }; ?>

<?php $queryMB  = "SELECT created_date FROM meetingbox WHERE created_date BETWEEN NOW() - INTERVAL 30 DAY AND NOW()"; $resultMB = mysqli_query($conn,$queryMB); while($rowMB = $resultMB->fetch_array(MYSQLI_ASSOC)) { ?>
<i class="fa fa-star" aria-hidden="true" title="You earned a star for updating your Newsboard Banner in the last 30 days!"></i>
<?php }; ?>

<?php $sqlNEWS = mysqli_query($conn,"SELECT count(*) FROM chalkboard WHERE eod >= CURRENT_DATE() AND pod <= CURRENT_DATE() AND sample = '0'") or die(mysqli_error($conn));
$row = mysqli_fetch_row($sqlNEWS);
$countNEWS = $row[0];
?>
<?php $sqlNEWS2 = mysqli_query($conn,"SELECT count(*) FROM chalkboard WHERE sample = '0' AND pod >= CURRENT_DATE() - INTERVAL 30 DAY AND pod <= CURRENT_DATE()") or die(mysqli_error($conn));
$row = mysqli_fetch_row($sqlNEWS2);
$countNEWS2 = $row[0];
?>
<?php if ($countNEWS != '0' AND ($countNEWS2 > '0')){ ?><i class="fa fa-star" aria-hidden="true" title="You earned a star for maintaining Newsboard content!"></i><?php }; ?>

<?php $sqlUSR = mysqli_query($conn,"SELECT count(*) FROM users WHERE (webmaster = '0' AND status != 'disabled' AND (email = '' OR (owner = '0' AND lease = '0' AND realtor = '0') OR (accessdate >= '0000-00-01' AND accessdate <= current_date())) OR (status = 'New') AND ghost != 'Y')") or die(mysqli_error($conn));
//$countUSR = mysql_result($sqlUSR, "0");
$row = mysqli_fetch_row($sqlUSR);
$countUSR = $row[0];
?>
<?php if ($countUSR == '0'){ ?><i class="fa fa-star" aria-hidden="true" title="You earned a star for keeping your users online!"></i><?php }; ?>

<?php $sqlCAL = mysqli_query($conn,"SELECT count(*) FROM calendar WHERE date >= CURRENT_DATE() AND `event` != 'Holiday'") or die(mysqli_error($conn));
//$countCAL = mysql_result($sqlCAL, "0");
$row = mysqli_fetch_row($sqlCAL);
$countCAL = $row[0];
?>
<?php if ($countCAL >= '3'){ ?><i class="fa fa-star" aria-hidden="true" title="You earned a star for a populated calender!"></i><?php }; ?>
<!-- GOLD STARS -->

<!-- SILVER STARS -->
<?php $sqlDOC = mysqli_query($conn,"SELECT count(*) FROM documents WHERE created_date > NOW() - INTERVAL 30 DAY") or die(mysqli_error($conn));
//$countDOC = mysql_result($sqlDOC, "0");
$row = mysqli_fetch_row($sqlDOC);
$countDOC = $row[0];
?>
<?php if ($countDOC == '0'){ ?>
<i class="fa fa-star s" aria-hidden="true" title="You haven&apos;t uploaded a document in the last month!"></i>
<?php }; ?>

<?php $queryMB  = "SELECT created_date FROM meetingbox WHERE created_date NOT BETWEEN NOW() - INTERVAL 30 DAY AND NOW()"; $resultMB = mysqli_query($conn,$queryMB); while($rowMB = $resultMB->fetch_array(MYSQLI_ASSOC)) { ?>
<i class="fa fa-star s" aria-hidden="true" title="The Newsboard Banner needs updating!"></i>
<?php }; ?>

<?php $sqlNEWS = mysqli_query($conn,"SELECT count(*) FROM chalkboard WHERE eod >= CURRENT_DATE() AND pod <= CURRENT_DATE() AND sample = '0'") or die(mysqli_error($conn));
$row = mysqli_fetch_row($sqlNEWS);
$countNEWS = $row[0];
?>
<?php $sqlNEWS2 = mysqli_query($conn,"SELECT count(*) FROM chalkboard WHERE sample = '0' AND pod >= CURRENT_DATE() - INTERVAL 30 DAY AND pod <= CURRENT_DATE()") or die(mysqli_error($conn));
$row = mysqli_fetch_row($sqlNEWS2);
$countNEWS2 = $row[0];
?>
<?php if ($countNEWS == '0') { ?><i class="fa fa-star s" aria-hidden="true" title="Time to publish a Newsboard Article!"></i><?php }; ?>
<?php if ($countNEWS != '0' AND $countNEWS2 == '0') { ?><i class="fa fa-star s" aria-hidden="true" title="All of your content is over 30 days old!"></i><?php }; ?>

<?php $sql = mysqli_query($conn,"SELECT count(*) FROM users WHERE (webmaster = '0' AND status != 'disabled' AND (email = '' OR (owner = '0' AND lease = '0' AND realtor = '0') OR (accessdate >= '0000-00-01' AND accessdate <= current_date())) OR (status = 'New') AND ghost != 'Y')") or die(mysqli_error($conn));
//$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; ?>
<?php if ($count != '0'){ ?><i class="fa fa-star s" aria-hidden="true" title="You have users who need your help to get access."></i><?php }; ?>

<?php $sqlCAL = mysqli_query($conn,"SELECT count(*) FROM calendar WHERE date >= CURRENT_DATE() AND `event` != 'Holiday'") or die(mysqli_error($conn));
//$countCAL = mysql_result($sqlCAL, "0");
$row = mysqli_fetch_row($sqlCAL);
$countCAL = $row[0];
?>
<?php if ($countCAL <= '2'){ ?><i class="fa fa-star s" aria-hidden="true" title="Your calendar needs dates!"></i><?php }; ?>
<!-- SILVER STARS -->

<!-- Audience View Switch -->
<?php if ($_SESSION['liaison'] OR $_SESSION['webmaster'] == true){ ?>
    <?php if ($_GET["section"] == 'owner' OR $_GET["section"] == 'lease' OR $_GET["section"] == 'realtor'){ ?>
        <div><span style="font-size: .8rem;">View as: <?php if ($_SESSION['owner'] == true && $_GET["section"] !== 'owner'){ ?><a href="index.php?section=owner">Owner</a> | <?php }; ?> <?php if ($_SESSION['lease'] == true && $_GET["section"] !== 'lease'){ ?><a href="index.php?section=lease">Leaser/Renter</a> | <?php }; ?><?php if ($_SESSION['realtor'] == true && $_GET["section"] !== 'realtor'){ ?><a href="index.php?section=realtor">Realtor</a><?php }; ?></span></div>
    <?php }; ?>
<?php }; ?>
          </div>
          </div>
        </div>
      </div>

<!-- Health Report Left -->
      <div class="medium-4 columns">
        <div class="health-bar-box-container">
          <div class="health-bar-box">
            <div class="health-action-box-1">

<!-- NEWSBOARD BANNER -->
<?php $queryMB  = "SELECT created_date FROM meetingbox WHERE created_date BETWEEN NOW() - INTERVAL 30 DAY AND NOW()"; $resultMB = mysqli_query($conn,$queryMB); while($rowMB = $resultMB->fetch_array(MYSQLI_ASSOC)) { ?>
<div class="health-action-item"><i class="fa fa-check" aria-hidden="true" title="Awesome!"></i> The Newsboard Banner was updated in the last 30 days!</div>
<?php }; ?>

<?php $queryMB  = "SELECT created_date FROM meetingbox WHERE created_date BETWEEN NOW() - INTERVAL 60 DAY AND NOW() - INTERVAL 31 DAY"; $resultMB = mysqli_query($conn,$queryMB); while($rowMB = $resultMB->fetch_array(MYSQLI_ASSOC)) { ?>
<div class="health-action-item"><i class="fa fa-exclamation-triangle note" aria-hidden="true" title="Action!"></i> The Newsboard Banner was last updated on <?php echo date('M d, Y', strtotime($rowMB['created_date'])); ?></div>
<?php }; ?>

<?php $queryMB  = "SELECT created_date FROM meetingbox WHERE created_date BETWEEN NOW() - INTERVAL 5000 DAY AND NOW() - INTERVAL 61 DAY"; $resultMB = mysqli_query($conn,$queryMB); while($rowMB = $resultMB->fetch_array(MYSQLI_ASSOC)) { ?>
<div class="health-action-item"><i class="fa fa-exclamation-triangle note" aria-hidden="true" title="Action!"></i> The Newsboard Banner should be updated!</div>
<?php }; ?>
<!-- END NEWSBOARD BANNER -->

<!-- NEWSBOARD -->
<?php $sqlNEWS = mysqli_query($conn,"SELECT count(*) FROM chalkboard WHERE eod >= CURRENT_DATE() AND pod <= CURRENT_DATE() AND sample = '0'") or die(mysqli_error($conn));
$row = mysqli_fetch_row($sqlNEWS);
$countNEWS = $row[0];
?>
<?php $sqlNEWS2 = mysqli_query($conn,"SELECT count(*) FROM chalkboard WHERE sample = '0' AND pod >= CURRENT_DATE() - INTERVAL 30 DAY AND pod <= CURRENT_DATE()") or die(mysqli_error($conn));
$row = mysqli_fetch_row($sqlNEWS2);
$countNEWS2 = $row[0];
?>

<?php if ($countNEWS == '0') { ?>
<div class="health-action-item"><i class="fa fa-exclamation-triangle" aria-hidden="true" title="Action!"></i> You do not have any Newsboard articles!</div>
<?php }; ?>

<?php if ($countNEWS != '0' AND $countNEWS2 == '0') { ?>
<div class="health-action-item"><i class="fa fa-exclamation-triangle note" aria-hidden="true" title="Action!"></i> All of your Newsboard Articals are over 30 days old!</div>
<?php }; ?>

<?php if ($countNEWS != '0' AND ($countNEWS2 > '0')){ ?>
<div class="health-action-item"><i class="fa fa-check" aria-hidden="true" title="Awesome!"></i> You have content on your Newsboard!</div>
<?php }; ?>
<!-- END NEWSBOARD -->

<!-- CALENDAR -->
<?php $sqlCALc = mysqli_query($conn,"SELECT count(*) FROM calendar") or die(mysqli_error($conn));
//$countCALc = mysql_result($sqlCALc, "0");
$row = mysqli_fetch_row($sqlCALc);
$countCALc = $row[0];
?>
<?php $sqlCAL = mysqli_query($conn,"SELECT count(*) FROM calendar WHERE date >= CURRENT_DATE() AND `event` != 'Holiday'") or die(mysqli_error($conn));
//$countCAL = mysql_result($sqlCAL, "0");
$row = mysqli_fetch_row($sqlCAL);
$countCAL = $row[0];
?>

<?php if ($countCAL == '0' AND $countCALc > '0'){ ?>
<div class="health-action-item"><i class="fa fa-exclamation-triangle" aria-hidden="true" title="Action!"></i> There are no more events on the calendar!</div>
<?php }; ?>

<?php if ($countCAL == '0' AND $countCALc == '0'){ ?>
<div class="health-action-item"><i class="fa fa-exclamation-triangle note" aria-hidden="true" title="Action!"></i> You need to populate your calendar!</div>
<?php }; ?>

<?php if ($countCAL == '1'){ ?>
<div class="health-action-item"><i class="fa fa-exclamation-triangle note" aria-hidden="true" title="Action!"></i> There is only <b>1</b> event left on the calendar!</div>
<?php }; ?>

<?php if ($countCAL == '2'){ ?>
<div class="health-action-item"><i class="fa fa-exclamation-triangle noteblue" aria-hidden="true" title="Note!"></i> There are <b>2</b> more events on the calendar!</div>
<?php }; ?>

<?php if ($countCAL >= '3'){ ?>
<div class="health-action-item"><i class="fa fa-check" aria-hidden="true" title="Awesome!"></i> There are <b><?php print($countCAL); ?></b> more events on the calendar!</div>

<?php }; ?>
<!-- END CALENDAR -->

<!-- DOCUMENTS -->
<?php $queryDOC  = "SELECT created_date FROM documents WHERE created_date BETWEEN NOW() - INTERVAL 30 DAY AND NOW() ORDER BY created_date DESC LIMIT 1"; $resultDOC = mysqli_query($conn,$queryDOC); while($rowDOC = $resultDOC->fetch_array(MYSQLI_ASSOC)) { ?>
<div class="health-action-item"><i class="fa fa-check" aria-hidden="true" title="Awesome!"></i> You have recently uploaded a Document.</div>
<?php }; ?>

<?php $sqlDOC2 = mysqli_query($conn,"SELECT count(*) FROM documents WHERE created_date > NOW() - INTERVAL 30 DAY") or die(mysqli_error($conn));
//$countDOC2 = mysql_result($sqlDOC2, "0");
$row = mysqli_fetch_row($sqlDOC2);
$countDOC2 = $row[0];
?>

<?php if ($countDOC2 == '0'){ ?>
<div class="health-action-item"><i class="fa fa-exclamation-triangle note" aria-hidden="true" title="Alert"></i> Are your Documents current?</div>
<?php }; ?>
<!-- END DOCUMENTS -->


            </div>
          </div>
        </div>
      </div>
				
<!-- Health Report Right -->
      <div class="medium-4 columns">
        <div class="health-bar-box-container">
          <div class="health-bar-box">
            <div class="health-action-box-2">

<!-- USERS -->
<?php $sql = mysqli_query($conn,"SELECT count(*) FROM users WHERE status != 'disabled' AND password = '' OR (webmaster = '0' AND status != 'disabled' AND (email = '' OR (owner = '0' AND lease = '0' AND realtor = '0') OR (accessdate >= '0000-00-01' AND accessdate <= current_date())) OR (status = 'New') AND ghost != 'Y')") or die(mysqli_error($conn));
//$count = mysql_result($sql, "0");
$row = mysqli_fetch_row($sql);
$count = $row[0]; ?>

<?php if ($count != '0'){ ?>
<div class="health-action-item"><i class="fa fa-exclamation-triangle" aria-hidden="true" title="Action!"></i> You have <b><?php print($count); ?> User(s)</b> who need your help to get access!</div>
<?php }; ?>

<?php if ($count == '0'){ ?>
<div class="health-action-item"><i class="fa fa-check" aria-hidden="true" title="Awesome!"></i> All of your users have access.</div>
<?php }; ?>
<!-- END USERS -->

<!-- APPROVALS -->
<?php $sqlBSD = mysqli_query($conn,"SELECT count(*) FROM concierge WHERE approved != 'Y'") or die(mysqli_error($conn));
//$countBSD = mysql_result($sqlBSD, "0");
$row = mysqli_fetch_row($sqlBSD);
$countBSD = $row[0];
?>
<?php if ($countBSD != '0'){ ?>
<div class="health-action-item"><i class="fa fa-exclamation-triangle" aria-hidden="true" title="Action!"></i> You have <b><?php print($countBSD); ?> Business Directory listings</b> pending approval.</div>
<?php }; ?>

<?php $sqlCAR = mysqli_query($conn,"SELECT count(*) FROM vehicles WHERE approved != 'Y'") or die(mysqli_error($conn));
//$countCAR = mysql_result($sqlCAR, "0");
$row = mysqli_fetch_row($sqlCAR);
$countCAR = $row[0];
?>
<?php if ($countCAR != '0'){ ?>
<div class="health-action-item"><i class="fa fa-exclamation-triangle" aria-hidden="true" title="Action!"></i> You have <b><?php print($countCAR); ?> Vehicles/Bicycles</b> pending approval.</div>
<?php }; ?>

<?php $sqlSELL = mysqli_query($conn,"SELECT count(*) FROM realestate WHERE approved != 'Y'") or die(mysqli_error($conn));
//$countSELL = mysql_result($sqlSELL, "0");
$row = mysqli_fetch_row($sqlSELL);
$countSELL = $row[0];
?>
<?php if ($countSELL != '0'){ ?>
<div class="health-action-item"><i class="fa fa-exclamation-triangle" aria-hidden="true" title="Action!"></i> You have <b><?php print($countSELL); ?> Classified Ads</b> pending approval.</div>
<?php }; ?>

<?php $sqlPETS = mysqli_query($conn,"SELECT count(*) FROM pets WHERE approved != 'Y'") or die(mysqli_error($conn));
//$countPETS = mysql_result($sqlPETS, "0");
$row = mysqli_fetch_row($sqlPETS);
$countPETS = $row[0];
?>
<?php if ($countPETS != '0'){ ?>
<div class="health-action-item"><i class="fa fa-exclamation-triangle" aria-hidden="true" title="Action!"></i> You have <b><?php print($countPETS); ?> Pets</b> pending approval.</div>
<?php }; ?>

<?php $sqlMAINTn = mysqli_query($conn,"SELECT count(*) FROM `service` WHERE `update_date` = '0000-00-00 00:00:00'") or die(mysqli_error($conn));
//$countMAINTn = mysql_result($sqlMAINTn, "0");
$row = mysqli_fetch_row($sqlMAINTn);
$countMAINTn = $row[0];
?>
<?php if ($countMAINTn == '1'){ ?><div class="health-action-item"><i class="fa fa-exclamation-triangle" aria-hidden="true" title="Action!"></i> You have <b><?php print($countMAINTn); ?> new</b> service request.</div><?php }; ?>
<?php if ($countMAINTn >= '2'){ ?><div class="health-action-item"><i class="fa fa-exclamation-triangle" aria-hidden="true" title="Action!"></i> You have <b><?php print($countMAINTn); ?> new</b> service requests.</div><?php }; ?>

<?php $sqlMAINT = mysqli_query($conn,"SELECT count(*) FROM `service` WHERE `status` != 'C'") or die(mysqli_error($conn));
//$countMAINT = mysql_result($sqlMAINT, "0");
$row = mysqli_fetch_row($sqlMAINT);
$countMAINT = $row[0];
?>
<?php if ($countMAINT == '1'){ ?><div class="health-action-item"><i class="fa fa-exclamation-triangle note" aria-hidden="true" title="Action!"></i> You have <?php print($countMAINT); ?> service request open.</div><?php }; ?>
<?php if ($countMAINT >= '2'){ ?><div class="health-action-item"><i class="fa fa-exclamation-triangle note" aria-hidden="true" title="Action!"></i> You have <?php print($countMAINT); ?> service requests open.</div><?php }; ?>

<!-- END APPROVALS -->


            </div>
          </div>
        </div>
      </div>
      
<!-- Health Bar Setup -->
    </div>
  </div>
<?php }; ?>
