<?php
function create_item($title, $link, $desc, $pubDate, $pubTime="12:00:00"){
	//TODO convert pubDate from epoch to rss format
	//$pubDate = strftime( "%a, %d %b %Y %T %Z" , $pubDate);
	$pubDate = strftime( "%a, %d %b %Y" , $pubDate); //Thu, 01 May 2008 00:00:00 PDT
	$output = '<item><title>'.$title.'</title><link>'.$link.'</link><description><![CDATA['.$desc.']]></description><pubDate>'.$pubDate.' '.$pubTime.' PDT</pubDate></item>'."\r";
	return $output;
}

$now = date("D, d M Y H:i:s T");

require_once('my-documents/php7-my-db.php');
$output = '<?xml version="1.0" encoding="ISO-8859-1" ?> <rss version="2.0"> 
	<channel><title>CondoSites RSS Feed</title><link>http://'.$_SERVER['SERVER_NAME'].'</link><image><url>http://www.condosites.com/images/CondoSitesLogo.jpg</url><title>CondoSites.com</title><link>http://www.CondoSites.com/</link></image>
	<description><![CDATA[This is an RSS feed from condosites.net]]></description>
	<language>en-us</language>
	<copyright>Copyright 2010-2018, CondoSites</copyright>'."\r";

#$output = "";

$query  = "SELECT UNIX_TIMESTAMP(date) AS date FROM updatedate";
$result = mysqli_query($conn, $query);
while($row = $result->fetch_array(MYSQLI_ASSOC)){
	$date = strftime( "%a, %d %b %Y %T %Z" , $row['date']);
	$output .= '<pubDate>'.$now.'</pubDate><lastBuildDate>'.$now.'</lastBuildDate>';
}

$domain = "http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
$domain = rtrim($domain, "rss-feed.php");

#$items = array(43=>"zzz", 26=>"xxx");
$items = array("1800" => "bar");

$query  = "SELECT headline, message, potime, pod, UNIX_TIMESTAMP(pod) AS created_date FROM chalkboard WHERE pod <= CURRENT_DATE() AND owner = 'Y'";
$result = mysqli_query($conn, $query);
$i = 0; 
while($row = $result->fetch_array(MYSQLI_ASSOC)){
	$key = (string)$row['pod'].$i;
	#echo "KEY: ".$key;
	$items[$key] = create_item($row['headline'], $domain, $row['message'], $row['created_date'], $row['potime']);
	$i = $i + 1; 
}

$query  = "SELECT title, details, created_date, UNIX_TIMESTAMP(created_date) AS pretty_date FROM calendar";
$result = mysqli_query($conn, $query);
while($row = $result->fetch_array(MYSQLI_ASSOC)){
	$value = create_item($row['title'], $domain, $row['details'], $row['pretty_date']);
	$items[$row['created_date'].$i] = $value;
	$i = $i + 1; 
}

$query  = "SELECT question, answer, 'FAQ: ', created_date, UNIX_TIMESTAMP(created_date) AS pretty_date FROM faq WHERE type = 'Residents'";
$result = mysqli_query($conn, $query);
while($row = $result->fetch_array(MYSQLI_ASSOC)){
	$value = create_item($row['FAQ: '].$row['question'], $domain, $row['answer'], $row['pretty_date']);
	$items[$row['created_date'].$i] = $value;
	$i = $i + 1; 
}

$query  = "SELECT line1, line2, '&nbsp;', line3, created_date, UNIX_TIMESTAMP(created_date) AS pretty_date FROM meetingbox WHERE owner = 'Y'";
$result = mysqli_query($conn, $query);
while($row = $result->fetch_array(MYSQLI_ASSOC)){
	$value = create_item($row['line1'], $domain, $row['line2'].$row['&nbsp;'].$row['line3'], $row['pretty_date']);
	$items[$row['created_date'].$i] = $value;
	$i = $i + 1; 
}

$query  = "SELECT title, name, doctype, 'Has been uploaded to the ', '&nbsp;folder.', 'Document: ', created_date, UNIX_TIMESTAMP(created_date) AS pretty_date FROM documents WHERE owner = 'Y' ";
$result = mysqli_query($conn, $query);
while($row = $result->fetch_array(MYSQLI_ASSOC)){
	$value = create_item($row['Document: '].$row['title'], $domain, $row['Has been uploaded to the '].$row['doctype'].$row['&nbsp;folder.'], $row['pretty_date']);
	$items[$row['created_date'].$i] = $value;
	$i = $i + 1; 
}

ksort($items);

$items = array_reverse($items, true);

$i = 0;
foreach($items as $key => $value){
	if($i < 99){
		//print_r($item);
		//print_r($value);
		$output .= $value;
		$i = $i + 1;
		
		#echo "key after: ".$key;
		#print $value;
	}
}

$output .= '</channel></rss>';

echo $output;

#print_r($items);

?>