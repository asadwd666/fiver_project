<?php $current_page = '11'; include('report-protect.php');

if(isset($_GET['id'])){

	$id    = $_GET['id'];
	$query = "SELECT first_name, last_name, unit, unit2, email, phone, owner, realtor, lease FROM users WHERE `id` = '$id'";

	$result = mysqli_query($conn,$query) or die('Error, query failed');
	list($first_name, $last_name, $unit, $unit2, $email, $phone, $owner, $realtor, $lease) =                             
		$result->fetch_array();
		
header("Content-Type: text/vCard");

header("Content-Disposition: attachment; filename=$last_name$first_name.vcf");

echo "BEGIN:VCARD\n";
echo "VERSION:3.0\n";
echo "N:$last_name;$first_name;;;\n";
echo "FN:$first_name $last_name\n";
echo "NOTE:Owner=$owner, Renter=$lease, Realtor=$realtor \n";
echo "EMAIL;type=INTERNET;type=WORK;type=pref:$email\n";
echo "TEL;type=WORK;type=pref:$phone\n";
echo "item1.ADR;type=WORK;type=pref:;;$unit\, $unit2;;;;\n";
echo "item1.X-ABADR:us\n";
echo "END:VCARD\n";

}
?>