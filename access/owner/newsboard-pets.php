<?php
    if (!isset($connectionPool) || $connectionPool == null) {
        $connectionPool[$CommunityName]= array('priority' => 10, 'connection' =>  $conn, 'master' => false, 'primary' => true);
    }

    $dataArray = array();
	$query  = "SELECT * FROM pets WHERE lost = 'Yes'";
    foreach ($connectionPool as $connName => $configuration) {
        $resultARRAY = mysqli_query($configuration['connection'],$query);

        while ($data = $resultARRAY->fetch_array(MYSQLI_ASSOC)) {
            $dataArray[$data['title']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
        }
    }

    foreach($dataArray as $recordArray ) {
        ksort($recordArray, 1);
        foreach ($recordArray as $records) {
            foreach($records as $record) {
                $row = $record['data'];
?>
<!-- Setup -->
  <div class="newsboard-container">

<!-- Newsboard Lost Ribbon -->
    <div class="ribbon-wrapper">
      <div class="ribbon ribbon__U">
LOST!
      </div>
    </div>

<!-- Headline -->
  <div class="row">
    <div class="small-12 columns"><h2 class="newsboard-subtitle">Help... &quot;<?php echo "{$row['petname']}"; ?>&quot; is lost!</h2></div>
  </div>
      <?php if ($record['master'] === true) { ?><div class="nav-section-subtext-blue"><br><p>From <?php echo $record['dbconnName']; ?></p></div><?php }; ?>

  <div class="row">
      <div class="small-12 columns">
	<div class="newsboard-post-text">
<?php if ($row['name'] !== 'none.gif'){ ?><div class="newsboard-post-image-pet"><a href="../download-pets.php?id=<?php echo "{$row['id']}"; ?>" class="iframe-link" onclick="javascript:pageTracker._trackPageview('PETPHOTO/<?php echo "{$row['id']}"; ?>'); "><img src="../download-pets.php?id=<?php echo "{$row['id']}"; ?>" alt=""></a></div><?php }; ?>
	<?php if ($row['comments'] !== ''){ ?><?php echo "{$row['comments']}"; ?><?php }; ?>

<?php
	$type    = $row['userid'];
	$query1  = "SELECT first_name, last_name, unit, unit2, email, phone FROM users WHERE id = '$type'";
	$result1 = mysqli_query($connectionPool[$record['dbconnName']]['connection'],$query1);

	while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
	{
		$email = $row1['email'];
?>
<blockquote>
<ul class="newsboard-post-links">
    <li>
	<span class="note-red"><big><b>If found, please contact:</b></big></span><br>
	<b><?php echo "{$row1['first_name']}"; ?> <?php echo "{$row1['last_name']}"; ?></b><br>Unit: <?php echo "{$row1['unit']}"; ?><?php if ($row1['unit2'] !== 'X'){ ?> <?php echo "{$row1['unit2']}"; ?><?php }; ?><br><?php echo "{$row1['phone']}"; ?><br><a href="mailto:<?php echo "{$row1['email']}"; ?>"><?php echo "{$row1['email']}"; ?></a>
	</li>
</ul>
</blockquote>
<?php
	}
?>
      </div>
    </div>
  </div>

<!-- Setup -->
</div>
<?php
	        }
        }
    }
?>
