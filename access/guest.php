<?php if ($_SESSION['email'] == 'guest@condosites.net') { ?>
<div id="alert-bar-splash">
  <div class="row">
    <div class="small-12 columns">
<br>
<p><big><i class="fa fa-exclamation-triangle note" aria-hidden="true" title="Action!"></i> You are logged into this website as a guest!</big></p>
<p>You are welcome to look around, but you will not be able to access any areas with sensitive content.</p>
<?php if ($_GET["section"] == 'owner' OR $_GET["section"] == 'lease' OR $_GET["section"] == 'realtor'){ ?>
    <p><span style="font-size: .8rem;">View as: <?php if ($_SESSION['owner'] == true && $_GET["section"] !== 'owner'){ ?><a href="index.php?section=owner">Owner</a> | <?php }; ?> <?php if ($_SESSION['lease'] == true && $_GET["section"] !== 'lease'){ ?><a href="index.php?section=lease">Leaser/Renter</a> | <?php }; ?><?php if ($_SESSION['realtor'] == true && $_GET["section"] !== 'realtor'){ ?><a href="index.php?section=realtor">Realtor</a><?php }; ?></span></p>
<?php }; ?>
<br>
    </div>
  </div>
</div>
<?php }; ?>