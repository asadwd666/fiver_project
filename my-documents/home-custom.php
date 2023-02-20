<!-- ******************************************** -->
<!-- COMMUNITY PHOTOS -->

  <div class="container-splash">
    <div class="row">
      <div class="small-12 columns">
        <div class="community-logo-splash">

<!-- Logo -->
<img src="pics/logo.png" alt="">

<!-- Postcards -->
<div class="home-image home-image-1"><img src="pics/home-postcard-1.jpg" alt="Community Photo"></div>
<div class="home-image home-image-2"><img src="pics/home-postcard-2.jpg" alt="Community Photo"></div>

        </div>
      </div>
    </div>
  </div>

<!-- END COMMUNITY PHOTOS -->
<!-- ******************************************** -->

<!-- ******************************************** -->
<!-- TEXT, LINKS, AND PROPERTY MANAGEMENT -->

<!-- Content Setup -->
  <div class="content-splash">
    <div class="row">

<!-- Text -->
      <div class="small-12 medium-8 large-8 columns">
        <div class="content-splash-home-main">

<?php
	$query  = "SELECT `theircode` FROM 3rd WHERE type = 'Splash'";

	//old query
	//$result = mysqli_query($conn, $query);
	//while($row = $result->fetch_array(MYSQLI_ASSOC))

    $result = mysqli_query($conn, $query);
    while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
<big><?php echo "{$row['theircode']}"; ?></big>
<?php
	}
?>

        </div>
      </div>

<!-- Links -->
      <div class="small-12 medium-4 large-4 columns">
        <div class="content-splash-sidebar-home-section">
          <div class="row">
            <div class="small-12 columns">

<?php include('splash/column-links.php'); ?>

            </div>
          </div>
        </div>
      </div>

<!-- End Content Setup -->
    </div>
  </div>
