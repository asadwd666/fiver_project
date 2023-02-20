<?php
	$query  = "SELECT `int1`, tabname, title, rednote, image, url FROM tabs WHERE tabname = 'Headline' AND realtor = 'Y' ORDER BY title";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{

?>
	<a href="<?php echo "{$row['url']}"; ?>"><i class="fa fa-rss" aria-hidden="true"></i></a>
<?php
	}
?>