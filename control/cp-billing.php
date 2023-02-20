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

<?php if ($rowBILL['Status'] != 'New' AND $rowBILL['Status'] != 'Closed'){ ?>
<div class="content-controlpanel-main">
    <div class="nav-section-header-cp" <?php if ($rowBILL['Status'] == 'PD' OR $rowBILL['Status'] == 'Due'){ ?>style="background-color:#990000"<?php }; ?>>
        <strong><big>Billing</big></strong>
    </div>
    <div class="nav-section-body-cp" <?php if ($rowBILL['Status'] == 'PD' OR $rowBILL['Status'] == 'Due'){ ?>style="background-color:#ffcccc"<?php }; ?>>
        <div class="row" align="center">

<?php if ($rowBILL['Status'] == 'Due' OR $rowBILL['Status'] == 'PD'){ ?>
            <div style="font-size: 1.5rem;">
                <a href="https://billing.condosites.com/reports/folio-F-print-F.php?AN=<?php echo "{$rowBILL['AN']}"; ?>&ID=<?php echo "{$rowBILL['int1']}"; ?>&LD=<?php echo "{$rowBILL['Launch_Date']}"; ?>&Folio=1" target="_blank">$<?php $AN = $rowBILL['AN']; $Total = mysqli_query($conn2,"SELECT SUM((Price * Qty) + ((Price * Qty) * Rate1) + ((((Price * Qty) * Rate1) + (Price * Qty)) * Rate2) - Payment) FROM Transactions WHERE AN = '$AN' ") or die(mysqli_error($conn2));
                    $row = mysqli_fetch_row($Total);
                    $count = $row[0];
                echo money_format('%(#10n', $count); ?></a>
            </div>
<p style="font-size: 1rem;">Balance&nbsp;Due&nbsp;in&nbsp;USD</p>
<?php }; ?>

            <div align="left" style="font-size: .8rem">
                <?php if ($rowBILL['Status'] == 'OK'){ ?><p><i>No payment currently due.</i><br><a href="https://condosites.com/billingpolicies.php" target="_blank">View Billing Policies</a></p><?php }; ?>
                <?php if ($rowBILL['Status'] == 'Due'){ ?><p><b>Late charge of $25 monthly if not paid in full by <?php echo date("M d, Y", strtotime($rowBILL['Bill_Date'] ."+25 days" )); ?>.</b> <a href="https://condosites.com/billingpolicies.php" target="_blank">View Billing Policies</a></p><?php }; ?>
                <?php if ($rowBILL['Status'] == 'PD'){ ?><p><span style="color:#990000;"><big><b>Account is Past Due!</b></big></span><br>Please remit payment in full immediately. <a href="https://condosites.com/billingpolicies.php" target="_blank">View Billing Policies</a></p><?php }; ?>
                <p><b><a href="https://billing.condosites.com/reports/folio-F-print-F.php?AN=<?php echo "{$rowBILL['AN']}"; ?>&ID=<?php echo "{$rowBILL['int1']}"; ?>&LD=<?php echo "{$rowBILL['Launch_Date']}"; ?>&Folio=1" target="_blank">View Current Charges</a></b></p>
                <p><b><a href="https://billing.condosites.com/reports/folio-A-print-A.php?AN=<?php echo "{$rowBILL['AN']}"; ?>&ID=<?php echo "{$rowBILL['int1']}"; ?>&LD=<?php echo "{$rowBILL['Launch_Date']}"; ?>" target="_blank">View Billing History</a></b></p>
                <p><b><a href="https://billing.condosites.com/reports/W9-CondoSites.pdf" target="_blank">Download Completed IRS W9 Form</a></b></p>
                <p><b>Billing Contact*:</b><br>
                    <?php echo "{$rowBILL['Billing_Company']}"; ?><br>
                    <?php echo "{$rowBILL['Billing_Name']}"; ?><br>
                    <?php echo "{$rowBILL['Billing_Email']}"; ?><br>
                    <?php echo "{$rowBILL['Billing_Phone']}"; ?><br>
                    <br>
                    <i>*Contact your CondoSites Relationship Manager to update billing contact.</i>
                </p>
            </div>
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