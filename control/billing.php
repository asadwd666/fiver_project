<?php require_once('../my-documents/php7-my-db.php'); ?>
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="CondoSites - http://www.condosites.com" name="author">
<title>Control Panel</title>
<?php include('../control/cp-head-scripts.php'); ?>
</head>
<body>
<!-- LOGO AND NAVIGATION -->
<div class="stand-alone-page">
    <div class="controlpanel-header">
        <div class="small-12">
            <a href="index-control.php"><img src="https://condosites.com/images/CondoSites-cp.png" alt="CondoSites" style="padding-top: 5px; padding-bottom: 5px;"></a>
        </div>
    </div>
</div>
<div class="stand-alone-page">
    <div class="controlpanel-content">
        &nbsp;
    </div>
</div>
<!-- END LOGO AND NAVIGATION -->

<div style="max-width: 99%;">

<?php if ($_SESSION['webmaster'] == true OR $_SESSION['liaison'] == true OR $_SESSION['staff'] == true OR $_SESSION['board'] == true){ ?>
<?php
	$dbhost2 = 'localhost';
	$dbuser2 = 'nodyss7_CSB1lln6';
	$dbpass2 = 'YXr(UAWzy7poaz32GQ}FIm8w5mdFJNkwGKGp~8L=dHRKH=+8N4CoLJ';
    $dbname2 = 'nodyss7_BILLING';

    $conn2 = new mysqli($dbhost2, $dbuser2, $dbpass2, $dbname2);
    if ($conn2->connect_error) {
        die('Connect Error (' . $conn2->connect_errno . ') ' . $conn2->connect_error);
    }
?>

<?php
    $CSDB = $dbname;
	$queryBILL  = "SELECT `AN`, `UN`, `int1`, `Launch_Date`, `Bill_Date`, `Billing_Company`, `Billing_Name`, `Billing_Email`, `Billing_Phone`, `Contact_Company`,  `Contact_Name`, `Contact_Email`, `Contact_Phone`, `Status` FROM $dbname2.Accounts WHERE `CSDB` = '$CSDB' LIMIT 1";
	$resultBILL = mysqli_query($conn2,$queryBILL);

	while($rowBILL = $resultBILL->fetch_array(MYSQLI_ASSOC))
	{
?>
<br>
<?php if ($rowBILL['Status'] != 'New' AND $rowBILL['Status'] != 'Closed'){ ?>
<div class="content-controlpanel-main">
    <div class="nav-section-header-cp" <?php if ($rowBILL['Status'] == 'PD' OR $rowBILL['Status'] == 'Due' OR $rowBILL['Status'] == 'LOCK'){ ?>style="background-color:#990000"<?php }; ?>>
        <strong><big>Billing</big></strong>
    </div>
    <div class="nav-section-body-cp" <?php if ($rowBILL['Status'] == 'PD' OR $rowBILL['Status'] == 'Due' OR $rowBILL['Status'] == 'LOCK'){ ?>style="background-color:#ffcccc"<?php }; ?>>
        <div class="row" align="left">
            <br>
            <br>
            <div align="left">
                <?php if ($rowBILL['Status'] == 'OK'){ ?><p style="font-size: 2.25rem;"><i>No payment currently due.</i></p><p style="font-size: 1.25rem;"><a href="https://condosites.com/billingpolicies.php" target="_blank">View Billing Policies</a></p><?php }; ?>
                <?php if ($rowBILL['Status'] == 'Due'){ ?><p style="font-size: 2.25rem;"><i>You have a payment due.</i></p><p style="font-size: 1.25rem;"><b>Late charge of $25 monthly if not paid in full by <?php echo date("M d, Y", strtotime($rowBILL['Bill_Date'] ."+25 days" )); ?>.</b> <a href="https://condosites.com/billingpolicies.php" target="_blank">View Billing Policies</a></p><?php }; ?>
                <?php if ($rowBILL['Status'] == 'PD'){ ?><p style="font-size: 2.25rem;"><span style="color:#990000;"><big><b>Account is Past Due!</b></big></span></p><p style="font-size: 1.25rem;">Please remit payment in full immediately. <a href="https://condosites.com/billingpolicies.php" target="_blank">View Billing Policies</a></p><?php }; ?>
                <?php if ($rowBILL['Status'] == 'LOCK'){ ?><p style="font-size: 2.25rem;"><span style="color:#990000;"><big><b>Account is Past Due!</b></big></span></p><p style="font-size: 1.25rem;"><b>Administrative controls have been locked due to non-payment.</b><br>Please remit payment in full immediately to avoid further interruption in service.</p><?php }; ?>
            </div>
            <br>
            <br>
<?php if ($rowBILL['Status'] == 'Due' OR $rowBILL['Status'] == 'PD' OR $rowBILL['Status'] == 'LOCK'){ ?>
            <div style="font-size: 2rem;">
                <b><a href="https://billing.condosites.com/reports/folio-F-print-F.php?AN=<?php echo "{$rowBILL['AN']}"; ?>&ID=<?php echo "{$rowBILL['int1']}"; ?>&LD=<?php echo "{$rowBILL['Launch_Date']}"; ?>&Folio=1" target="_blank">$<?php $AN = $rowBILL['AN']; $Total = mysqli_query($conn2,"SELECT SUM((Price * Qty) + ((Price * Qty) * Rate1) + ((((Price * Qty) * Rate1) + (Price * Qty)) * Rate2) - Payment) FROM Transactions WHERE AN = '$AN' ") or die(mysqli_error($conn2));
                    $row = mysqli_fetch_row($Total);
                    $count = $row[0];
                echo money_format('%(#10n', $count); ?></a></b>
            </div>
<p style="font-size: 1rem;">Balance&nbsp;Due&nbsp;in&nbsp;USD</p><br>
<?php }; ?>
            <div align="left" style="font-size: 1.25rem;">
                <p><b><a href="https://billing.condosites.com/reports/folio-F-print-F.php?AN=<?php echo "{$rowBILL['AN']}"; ?>&ID=<?php echo "{$rowBILL['int1']}"; ?>&LD=<?php echo "{$rowBILL['Launch_Date']}"; ?>&Folio=1" target="_blank">View Current Charges and Payment Information</a></b></p>
                <p><b><a href="https://billing.condosites.com/reports/folio-A-print-A.php?AN=<?php echo "{$rowBILL['AN']}"; ?>&ID=<?php echo "{$rowBILL['int1']}"; ?>&LD=<?php echo "{$rowBILL['Launch_Date']}"; ?>" target="_blank">View Billing History</a></b></p>
                <p><b><a href="https://billing.condosites.com/reports/W9-CondoSites.pdf" target="_blank">Download Completed IRS W9 Form</a></b></p>
            </div>
            <br>
            <br>
            <div align="left" style="font-size: 1rem;"
                <p><b>This is who we have listed as the Billing Contact for your account:</b><br>
                <span style="font-size: .8rem;"<i>Contact your CondoSites Relationship Manager to update billing contact.</i></span><br>
                <blockquote>
                    <?php echo "{$rowBILL['Billing_Company']}"; ?><br>
                    <?php echo "{$rowBILL['Billing_Name']}"; ?><br>
                    <?php echo "{$rowBILL['Billing_Email']}"; ?><br>
                    <?php echo "{$rowBILL['Billing_Phone']}"; ?><br>
                </blockquote>
                </p>
            </div>
            <br>
<?php
    $user = $rowBILL['UN'];
	$queryUSER  = "SELECT `Name`, `Phone`, `Email` FROM $dbname2.Users WHERE `UN` = '$user' LIMIT 1";
	$resultUSER = mysqli_query($conn2,$queryUSER);

	while($rowUSER = $resultUSER->fetch_array(MYSQLI_ASSOC))
	{
?>
            <div align="left" style="font-size: 1rem;"
                <p><b>This is your CondoSites Relationship Manager:</b><br>
                <blockquote>
                    <?php echo "{$rowUSER['Name']}"; ?><br>
                    <a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$rowUSER['Phone']); ?>"><?php echo "{$rowUSER['Phone']}"; ?></a><br>
                    <a href="mailto:<?php echo "{$rowUSER['Email']}"; ?>"><?php echo "{$rowUSER['Email']}"; ?></a><br>
                </blockquote>
                </p>
            </div>
<?php
	}
?>
            <br>
            <br>
            <br>
        </div>
    </div>
</div>
<?php }; ?>

<?php
	}
?>
<?php
    mysqli_close ( $conn2)?>
<?php }; ?>

<div class="small-12 medium-12 large-12 columns note-black"><br><br>Billing Control Panel Page<br></div>
</body>
</html>
