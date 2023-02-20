<?php $current_page = '34'; include('protect.php'); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="CondoSites - http://www.condosites.com" name="author">
<title>Control Panel</title>
<?php include('../control/cp-head-scripts.php'); ?>
</head>
<body>
<!-- LOGO AND NAVIGATION -->
<?php include('cp-navigation.php'); ?>
<!-- END LOGO AND NAVIGATION -->
<!-- HEALTH AND HELP -->
<div>
    <div class="large-8 columns" style="padding: 0px">
        <div class="nav-section-header-health-cp" align="center">
<big>&nbsp;</big>
        </div>
    </div>
    <div class="large-4 columns" style="padding: 0px">
        <div class="nav-section-header-help-cp" align="center">
            <strong><big><i class="fa fa-hand-o-right" aria-hidden="true"></i></big>&nbsp;Hands&nbsp;point&nbsp;to&nbsp;tips!</strong>
        </div>
    </div>
</div>
<!-- HEALTH AND HELP -->
<br>&nbsp;

<div class="row cp-help">
    <div class="small-12 medium-6 columns">
        <p>The Digital Information Display control panel shows what will be showing on your building&apos;s digital display.</p>
        <p>
            <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Content on your actual display may be delayed depending on its refresh timing.</span><br>
            <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red">Don&apos;t want to wait for the next slide? Just drag to the slide on the carousel.</span>
        </p>
    </div>
    <div class="small-12 medium-6 columns">
        <p>To <b>edit</b> the material shown below, visit the material&apos;s respective control panel.</p>
        <p>
            <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red"><b><a href="https://condosites.com/help/did.php" target="_blank">Get to know DID and learn how to control content <u>here</u>.</a></b></span><br>
            <i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="note-red"><b><a href="https://condosites.com/help/didtrouble.php" target="_blank">Things not look right on your display? <u>Troubleshoot here</u>.</a></b></span>
        </p>
    </div>
</div>

<div align="center">
    <p><b>Showing:</b> DID Portrait &nbsp; &nbsp; <b>Switch to: </b><a href="videodisplay.php">DID Classic</a> | <a href="videodisplay-packages.php">DID Packages</a></p>
</div>

<div align="center" class="show-for-large">
    <style>
        #wrap-large { width: 560px; height: 980px; padding: 0; overflow: hidden; }
        #frame-large {
            width: 1092px;
            height: 1924px;
            -ms-zoom: 0.5;
            -moz-transform: scale(0.5);
            -moz-transform-origin: 0 0;
            -o-transform: scale(0.5);
            -o-transform-origin: 0 0;
            -webkit-transform: scale(0.5);
            -webkit-transform-origin: 0 0;
            transform:scale(0.5);
        }
    </style>

    <div id="wrap-large" class="display-bezel-large">
        <iframe id="frame-large" src="../display-vertical/index.php" type="text/html" width="100%" height="1080px;"></iframe>
    </div>
</div>

<div align="center" class="show-for-medium-only">
    <style>
        #wrap-medium { width: 392px; height: 686px; padding: 0; overflow: hidden; }
        #frame-medium {
            width: 1092px;
            height: 1920px;
            -ms-zoom: 0.35;
            -moz-transform: scale(0.35);
            -moz-transform-origin: 0 0;
            -o-transform: scale(0.35);
            -o-transform-origin: 0 0;
            -webkit-transform: scale(0.35);
            -webkit-transform-origin: 0 0;
            transform:scale(0.35);
        }
    </style>

    <div id="wrap-medium" class="display-bezel-medium">
        <iframe id="frame-medium" src="../display-vertical/index.php" type="text/html" width="100%" height="1080px;"></iframe>
    </div>
</div>

<div align="center" class="show-for-small-only">
    <style>
        #wrap-small { width: 205px; height: 356px; padding: 0; overflow: hidden; }
        #frame-small {
            width: 1092px;
            height: 1920px;
            -ms-zoom: 0.18;
            -moz-transform: scale(0.18);
            -moz-transform-origin: 0 0;
            -o-transform: scale(0.18);
            -o-transform-origin: 0 0;
            -webkit-transform: scale(0.18);
            -webkit-transform-origin: 0 0;
            transform:scale(0.18);
        }
    </style>

    <div id="wrap-small" class="display-bezel-small">
        <iframe id="frame-small" src="../display-vertical/index.php" type="text/html" width="100%" height="1080px;"></iframe>
    </div>
</div>

<br>
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Digital Information Display Control Panel Page<br></div>
</body>
</html>
