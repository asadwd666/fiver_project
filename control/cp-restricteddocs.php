<div class="nav-section-header-cp">
      <strong>Special Documents from CondoSites</strong>
</div>
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="responsive-table table-autosort table-autofilter table-stripeclass:alternate table-stripeclass:alternate table-autostripe table-rowshade-alternate">
  <thead>
    <tr>
      <th class="table-sortable:alphanumeric" style="cursor:pointer;">&nbsp;&nbsp;&nbsp; Document Title</th>
      <th class="table-sortable:alphanumeric table-filterable" style="cursor:pointer;">&nbsp;&nbsp;&nbsp; <small>Folder</small></th>
      <th class="table-sortable:date table-filterable" style="cursor:pointer;">&nbsp;&nbsp;&nbsp; <small>Year</small></th>
    </tr>
  </thead>
  <tbody>
<!-- DATABASE RESULTS -->
<?php
	$query  = "SELECT `id`, type, title, date, size, doctype FROM documentsrestricted ORDER BY title";
	$result = mysqli_query($conn, $query);

	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
?>
	    <tr>
	      <td align="left"><?php include('icon-links-restricted.php'); ?>&nbsp;&nbsp;&nbsp;<a href="download-documents-restricted.php?id=<?php echo "{$row['id']}"; ?>&date=<?php echo "{$row['date']}"; ?>&size=<?php echo "{$row['size']}"; ?>" onclick="javascript:pageTracker._trackPageview('DOCUMENTS-RESTRICTED/<?php echo "{$row['id']}"; ?>'); "><?php echo "{$row['title']}"; ?></a></td>
	      <td align="left" class="responsive-table-cell"><?php echo "{$row['doctype']}"; ?></td>
	      <td align="left"><?php echo date('Y', strtotime($row['date'])); ?></td>
	    </tr>
<?php
	}
?>
<!-- END DATABASE RESULTS -->
  </tbody>
</table>