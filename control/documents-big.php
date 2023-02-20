<?php $current_page = '5'; include('protect.php'); $success = "untried"; ?>
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
<!-- UPLOAD FORM -->
<div style="max-width: 99%;">
<div class="nav-section-header-cp">
        <strong>Help With a Large Document or Photo</strong>
</div>
<form enctype="multipart/form-data" method="POST" action="documents-list.php">
<div class="cp-form-container">
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 0px 0px;">
            <div class="small-12 columns">
<?php if ($_GET["big"] == 'yes') { ?>
                <div style="color: darkred;"><b>Your document did not upload because it was too large!</b></div>
                <br>
<?php } ?>
<?php if ($_GET["big"] != 'yes') { ?>
                <b>Do you have a document or photo that is too big to upload? </b>
<?php } ?>
                CondoSites limits document and photo uploads to 3.5 MB. 
                If your document is too big, you may want to try some of these tips below...<br>
                <br>
                <b>For Photos:</b>
                <blockquote>
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> We recommend that the largest dimension of a photo to be between 800 to 1,000 pixels. Photos should also be between 72 to 125 dpi/ppi.<br>
                <br>
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> Use Preview (Mac OS), Paint (Windows), Adobe Photoshop, or similar photo editing software to reduce the photo size.<br>
                <br>
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> If you do not have one of the above mentioned applications, search the web for &quot;<a href="https://www.google.com/search?q=free+online+photo+editor" target="_blank">free online photo editor</a>&quot; to find a tool to help.
                <br>
                </blockquote>
            </div>
        </div>
    </div>
    <div class="small-12 medium-12 large-6 columns">
        <div class="row" style="padding: 10px 10px 10px 0px;">
            <div class="small-12 columns">
                <b>For Documents:</b>
                <blockquote>
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> Try to locate the digital original instead of a scanned document.<br>
                <br>
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> If you are trying to upload a scanned document, and it is <b>around 20 pages or less</b>, try rescanning the document at a lower resolution and in black &amp; white. 
                We recommend resolution settings of 72 dpi/ppi.  Some scanners use language like Normal, Better, Best, and Excellent. 
                Use of the "Normal" setting is sufficient for documents.  Your PDF should be aproximately 100kb per page.<br>
                <br>
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> If your document is <b>around 20 pages or more</b>, or if you are <b>unable to re-scan</b> it, you might try an online tool to compress the document.
                You can search the web for &quot;<a href="https://www.google.com/search?q=free+online+pdf+compression" target="_blank">free online pdf compression</a>&quot; to find a tool to help. We have heard great feedback about <a href="https://www.pdfcandy.com" target="_blank">PDF Candy</a>.
                These tools optimize PDF documents, by eliminating unnecessary data.<br>
                <br>
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> If you have Adobe Acrobat Professional, you can use its &quot;Optimize Scanned PDF&quot; tool.<br>
                <br>
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> If your document is over 20 pages, and you are unable to reduce the document to below 3.5 MB through the tips above, then send the document to your CondoSites Webmaster. 
                We will do our best to upload Governing Documents, Reserve Studies, and Insurance Binders over 3.5 MB but under 10 MB. 
                All other documents over 3.5 MB we will address on a case-by-case basis.
                </blockquote>
                <a href="documents-list.php">Return to the Documents &amp; Photos control panel.</a>
            </div>
        </div>
    </div>
</div>
</form>
<!-- END UPLOAD FORM -->
<div class="small-12 medium-12 large-12 columns note-black"><br><br>Big Documents &amp; Photos Help Page<br></div>
</body>
</html>