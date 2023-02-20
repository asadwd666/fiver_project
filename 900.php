<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Error 900 - Document Permissions Error | CondoSites</title>
  <meta content="CondoSites - http://www.condosites.com" name="author">
  <link rel="stylesheet" href="../css/foundation.css" />
  <link rel="stylesheet" href="../css/app.css" />
</head>
<body bgcolor="#ffffff">
<div class="container">

    <div class="row">
        <div class="small-12 small-centered medium-uncentered medium-6 large-12 columns">
            <h1 class="welcome-area-logo">
                <a href="../index.php"><img src="../pics/logo-small.png"></a>
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="small-center medium-center large-center columns">
            <div class="content-splash-main">
                <div class="row">
                    <div class="small-12 columns" align="center">
    <h3>oops!</h3>
    <br>
    <b>Either your session has timed out due to inactivity, or you do not have permission to download this document.</b><br>Follow this <a href="#" onClick="history.go(-1)">link</a> to go back to the previous page you were on,<br>or this <a href="../../../../../../../index.php">link</a> to go to the home page of this site.
    <br>
    <blockquote>
<?php require_once('my-documents/php7-my-db-up.php');?>
<?php
	$query  = "SELECT * FROM utilities WHERE category = 'Password'";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<br>
<br>
<b>If you believe this is an error, please contact the primary administrator for this website:</b><br>
<br>
<?php if ($row['name'] !== 'none.gif'){ ?><img src="download-utilities.php?id=<?php echo "{$row['id']}"; ?>" alt="<?php echo "{$row['company']}"; ?>"><br><?php }; ?>
<?php if ($row['company'] !== ''){ ?><b><?php echo "{$row['company']}"; ?></b><br><?php }; ?>
<?php if ($row['contact'] !== ''){ ?></b><?php echo "{$row['contact']}"; ?><br><?php }; ?>
<?php if ($row['phone1'] !== ''){ ?><a href="tel:<?php echo $dial = preg_replace("/[^0-9]/",'',$row['phone1']); ?>"><?php echo "{$row['phone1']}"; ?></a><br><?php }; ?>
<?php if ($row['email'] !== ''){ ?><a href="mailto:<?php echo "{$row['email']}"; ?>"><?php echo "{$row['email']}"; ?></a><br><?php }; ?>
<br>
<big><b>Be sure to tell them:</b></big><br>
- You received this message.<br>
- What page you were on.<br>
- What document you were trying to download.
<?php
	}
?>
    </blockquote>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</body>
</html>