<?php
    if (!isset($connectionPool) || $connectionPool == null) {
        $connectionPool[$CommunityName] = array('priority' => 10, 'connection' =>  $conn, 'master' => false, 'primary' => true);
    }
?>
<!-- Newsboard Footer Setup -->
<div class="newsboard-container">

<!-- Newsboard Article Ribbon -->
    <div class="ribbon-wrapper">
        <div class="ribbon ribbon__G">And More...</div>
    </div>

    <div class="row">
        <div class="small-12 columns">
            <h3 class="newsboard-subtitle">Looking for more news?</h3>
        </div>
    </div>

<!-- Link -->
  <div class="row">

    <div class="large-6 small-12 columns">
      <div class="calendar-view-full">Previously posted articles:<br>
      <a href="../modules/newsboard.php" class="iframe-link"><i class="fa fa-newspaper-o" aria-hidden="true"></i>View Newsboard Archive</a></div><br>
    </div>

<?php

  $dataArray = array();
  $query  = "SELECT `int1` FROM tabs WHERE `int1` = '411' AND owner = 'Y' LIMIT 1";
  foreach ($connectionPool as $connName => $configuration) {
    $resultARRAY = mysqli_query($configuration['connection'],$query);
    if (mysqli_num_rows($resultARRAY) == 1) { 
      $dataArray[$configuration['priority']] = $connName;
    }  
     // if ($configuration['primary'] == true) {
     //  

     //   while ($data = $resultARRAY->fetch_array(MYSQLI_ASSOC)) {
     //     $dataArray[$data['title']][$configuration['priority']][] = array('data' => $data, 'dbconnName' => $connName, 'master' => $configuration['master']);
     //   }
     //}
  }
  
  if (count($dataArray) >= 1) {

  ksort($dataArray);
    
    
      
    // foreach($dataArray as $recordArray ) {
    //     asort($recordArray);
    //     foreach ($recordArray as $records) {
    //         foreach($records as $record) {
    //         $row = $record['data'];
?>

    <div class="large-6 small-12 columns">
      <div class="calendar-view-full">If you have ideas for content:<br>
      <?php foreach ($dataArray as $key => $value) { ?>
      <a href="../forms/forcom.php?choice=411&conn=<?php echo $value; ?>" class="iframe-link"><i class="fa fa-check-square-o" aria-hidden="true"></i>Submit a Suggestion to <?php echo $value; ?>
      </a></br>
<?php
	   }
      //  }
  }
?>
</div><br>
</div>
  </div>

<!-- Setup -->
</div>
