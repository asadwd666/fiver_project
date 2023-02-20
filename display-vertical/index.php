
<?php require_once('../my-documents/php7-my-db-up.php');

// Read the Timezone Offset file
$timezoneOffsetStr = file_get_contents('../my-documents/localization-timezone.txt');

//Extract the offset
$timezoneOffset = substr($timezoneOffsetStr, 0, strpos($timezoneOffsetStr, ";"));

?>
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <!--[if lte IE 10]><meta http-equiv="refresh" content="0;url=IE.html" /><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="CondoSites - http://www.condosites.com" name="author">
    <title>CondoSites</title>
    <link rel="stylesheet" href="../css/foundation.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/weather-icons.min.css">
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/app.css">
    <link rel="stylesheet" href="../my-documents/app-custom.css">
    <link rel="stylesheet" href="../css/display.css">
    <link rel="stylesheet" href="../my-documents/display-custom.css">
    <script src="../java/vendor/jquery.js"></script>
    <script src="../java/vendor/owl.carousel.min.js"></script>
    
</head>
<!--
    add class vertical to main div wrapper on line 31
css file appended to ../css/display.css
javascript file created specifically for vertical display ../my-documents/owl.carousel.settings-vertical.js
-->
<body>

    <div class="main mvix vertical background">
        <div class="row">
            <div class="large-6 columns">
<!-- LOGO -->
<!-- ******************************************** -->
                <div class="logo ">
                    <img src="../pics/logo-display.png" alt="">
                </div>
<!-- ******************************************** -->
<!-- LOGO -->
            </div>
            <div class="large-6 columns">
                <div class="row collapse">

<!-- Newsboard Banner Check -->
<?php $sqlNB = mysqli_query($conn,"SELECT count(*) FROM `meetingbox` WHERE `digitaldisplay` = 'Y'") or die(mysqli_error($conn));
//$countNB = mysql_result($sqlNB, "0");
$row = mysqli_fetch_row($sqlNB);
$countNB = $row[0];
?>

                    <div class="time-weather-container <?php if ($countNB == '0'){ ?>no-newsboard<?php }; ?>">
<!-- Newsboard Banner Check -->

<!-- TIME and DATE -->
<!-- ******************************************** -->
                        <div class="large-12 columns">
                            <div class="time center">
                                <h3>

                                    <?php include('../java/vendor/time.js'); ?>

                                </h3>
                                <h4><?php echo date('l, F j'); ?></h4>
                            </div>
                        </div>
                    
<!-- ******************************************** -->
<!-- END TIME and DATE -->

<!-- WEATHER -->
<!-- ******************************************** -->
                    <div class="row collapse">
                        <div class="large-6 columns">
                            <div class="weather-current center">
                                <h3 id="weather"></h3>
                                <h4 id="description"></h4>
                            </div>
                        </div>
                        <div class="large-6 columns">
                            <div class="weather center">
                                <i id="icon"></i>
                            </div>
                        </div>

<!-- ******************************************** -->
<!-- END WEATHER -->
</div>
                    </div>
                </div>
    </div>
        </div>
<!-- NEWSBOARD BANNER -->
<!-- ******************************************** -->

<?php include('newsboard-banner.php'); ?>

<!-- ******************************************** -->
<!-- END NEWSBOARD BANNER -->


<!-- CAROUSELS -->
<!-- ******************************************** -->

        <div class="row">
            <div class="owl-carousel-1 owl-carousel slider">

<?php include('../my-documents/owl.carousel-PORTRAIT-1.php'); ?>

            </div>
        </div>

        <div class="row no-margin">
            <div class="owl-carousel-2 owl-carousel slider">

<?php include('../my-documents/owl.carousel-PORTRAIT-2.php'); ?>

            </div>
        </div>
        
<!-- ******************************************** -->
<!-- END CAROUSELS -->

    </div>
    
<!-- FOOTER -->
<!-- ******************************************** -->
<!-- APPLY VERTICAL CLASS TO FOOTER -->
    <div class="mvix vertical footer">
        <div class="row">
            <div class="large-2 columns">
                <div class="footer-left left">
                    <p>Last refreshed at <?php echo gmdate("g:i A M d", time() + 3600*($timezoneOffset+date("I"))); ?></p>
                </div>
            </div>
            <div class="large-8 columns">
                <div class="footer-middle center">
                    <h3>Visit <?php include('../my-documents/communityurl.html'); ?></h3>
                </div>
            </div>
            <div class="large-2 columns">
                <div class="footer-right right">
                    <img src="https://condosites.net/images/CondoSites-White.png" alt="" class="logo">
                </div>
            </div>
        </div>
    </div>
<!-- ******************************************** -->
<!-- END FOOTER -->

</body>

<script src="../java/vendor/foundation.min.js"></script>
<script> $(document).foundation(); </script>
<!-- NEW FILE FOR VERTICAL CAROUSEL SETTINGS -->
<?php include('../my-documents/owl.carousel.settings-vertical.js'); ?>
<?php include('../java/vendor/weather.js'); ?>

</html>