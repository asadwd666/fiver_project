<?php
    $useremail = $_SESSION['email'];
	$queryALERT  = "SELECT `emailconfirm` FROM `users` WHERE `email` = '$useremail' AND `emailconfirm` != 'V' LIMIT 1";
	$resultALERT = mysqli_query($conn,$queryALERT);

	while($rowALERT = $resultALERT->fetch_array(MYSQLI_ASSOC))
	{
?>
<div id="alert-bar-splash">
  <div class="row">
    <div class="small-12 columns">
<br>
<p><big><b><i class="fa fa-exclamation-triangle note" aria-hidden="true" title="Action!"></i> We need you to verify your email address.</b></big></p>
<p><b>An email will be sent to <a href="../modules/user.php" class="iframe-link" title="Update your profile and change your password."><?php echo $useremail; ?></a> with a single-click link to verify your email address.</b></p>
<p><small>(If this email address is incorrect, please <a href="../modules/user.php" class="iframe-link" title="Update your profile and change your password.">update your profile</a>.)</small></p>
<br>
    </div>
  </div>
</div>
<?php
	}
?>