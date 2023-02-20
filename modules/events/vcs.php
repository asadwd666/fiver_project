<?php

require_once('../../my-documents/php7-my-db.php');

if(isset($_GET['int1'])){

	$int1    = $_GET['int1'];
	$query = "SELECT `title`, DATE_FORMAT(`date`,'%Y%m%d'), DATE_FORMAT(`stime`,'T%H%i%s'), `detailsmini`, url, `int1` FROM calendar WHERE `int1` = '$int1'";

	$result = mysqli_query($conn,$query) or die('Error, query failed');
	list($title, $date, $stime, $detailsmini, $url) =                             
		$result->fetch_array();


header("Content-Type: text/Calendar");

header("Content-Disposition: inline; filename=calendar.vcs");
echo "BEGIN:VCALENDAR\n";
echo "PRODID:-//CondoSites//Event//\n";
echo "METHOD:PUBLISH\n";
echo "BEGIN:VEVENT\n";
echo "DTSTART:$date$stime\n";
echo "DTEND:$date$stime\n";
echo "TRANSP:OPAQUE\n";
echo "SEQUENCE:$int1\n";
echo "UID:condosites$int1\n";
echo "DTSTAMP:".date('Ymd').'T'.date('His')."\n";
echo "DESCRIPTION:$detailsmini\n";
echo "SUMMARY:$title\n";
echo "URL:$url\n";
echo "PRIORITY:5\n";
echo "CLASS:PUBLIC\n";
echo "END:VEVENT\n";
echo "END:VCALENDAR\n";
}
?>