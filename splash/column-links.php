<!-- Documents -->
<?php
	//$navigation    = $rowNAVIGATION['type'];
	$query  = "SELECT `id`, type, title, aod, docdate, size FROM documents WHERE public = 'H' AND aod NOT BETWEEN '0000-01-01' AND CURRENT_DATE() ORDER BY title";

	// Old MySQL Query
	// $result = mysqli_query($conn, $query);
	// while($row = $result->fetch_array(MYSQLI_ASSOC))

    $result = mysqli_query($conn, $query);
    while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

?>
    <ul class="nav-section-links">
		<li>
		    <?php include('icon-links.php'); ?>
		    <a href="download-documents.php?id=<?php echo "{$row['id']}"; ?>&docdate=<?php echo "{$row['docdate']}"; ?>&size=<?php echo "{$row['size']}"; ?>" target="_blank" class="nav-section-link" onclick="javascript:pageTracker._trackPageview('DOCUMENTS/<?php echo "{$row['id']}"; ?>'); "><?php echo "{$row['title']}"; ?></a>
		</li>
	</ul>
<?php
	}
?>

<!-- Links -->
<?php
	//$navigation    = $rowNAVIGATION['type'];
	// $query  = "SELECT `int1`, tabname, title, rednote, image, url, window FROM tabs WHERE public = 'H' ORDER BY title";
	$query  = "SELECT * FROM tabs WHERE public = 'H' ORDER BY title";

	// $result = mysqli_query($conn, $query);
	// while($row = $result->fetch_array(MYSQLI_ASSOC))
    $result = mysqli_query($conn, $query);
	
    while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
		
?>
		<ul class="nav-section-links">
		    <li>
		        <a href="<?php echo "{$row['url']}"; ?>" <?php if ($row['window'] !== '') { ?><?php echo "{$row['window']}"; ?><?php }; ?> class="<?php if ($row['window'] == '') { ?>iframe-link<?php }; ?>" onclick="javascript:pageTracker._trackPageview('ColumnLink/<?php echo "{$row['title']}"; ?>'); "><?php echo "{$row['image']}"; ?></a>
		        <a href="<?php echo "{$row['url']}"; ?>" <?php if ($row['window'] !== '') { ?><?php echo "{$row['window']}"; ?><?php }; ?> class="nav-section-link <?php if ($row['rednote'] !== ''){ ?>nav-section-subtext-anchor<?php }; ?> <?php if ($row['window'] == '') { ?>iframe-link<?php }; ?>" onclick="javascript:pageTracker._trackPageview('ColumnLink/<?php echo "{$row['title']}"; ?>'); "><?php echo "{$row['title']}"; ?></a>
		        <?php if ($row['rednote'] !== '') { ?><div class="nav-section-subtext-splash"><p><?php echo "{$row['rednote']}"; ?></p></div><?php }; ?>
	        </li>
		</ul>
<?php
	}
?>

<!-- Folders -->
<?php
	//$navigation    = $rowNAVIGATION['type'];
	$query  = "SELECT * FROM folders WHERE public = 'H' ORDER BY title";

	// Old MySQL Query
	// $result = mysqli_query($conn, $query);
	// while($row = $result->fetch_array(MYSQLI_ASSOC))

    $result = mysqli_query($conn, $query);
    while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

?>
		<ul class="nav-section-links">
		    <li>
		        <a href="<?php echo "{$row['link']}"; ?><?php echo "{$row['title']}"; ?>" class="iframe-link" onclick="javascript:pageTracker._trackPageview('FOLDER/<?php echo "{$row['title']}"; ?>'); "><?php echo "{$row['image']}"; ?></a>
		        <a href="<?php echo "{$row['link']}"; ?><?php echo "{$row['title']}"; ?>" class="nav-section-link <?php if ($row['rednote'] !== '') { ?>nav-section-subtext-anchor<?php }; ?> iframe-link" onclick="javascript:pageTracker._trackPageview('FOLDER/<?php echo "{$row['title']}"; ?>'); "><b><?php echo "{$row['title']}"; ?></b></a>
		        <?php if ($row['rednote'] !== '') { ?><div class="nav-section-subtext-splash"><p><?php echo "{$row['rednote']}"; ?></p></div><?php }; ?>
		    </li>
		</ul>
<?php
	}
?>