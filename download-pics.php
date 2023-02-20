<?php
	$id    = preg_replace('/[^0-9]/', '', $_GET['id']);
	{
?>
<img src="download-documents-mini.php?id=<?php echo "{$id}"; ?>" alt="">
<?php
	}
?>