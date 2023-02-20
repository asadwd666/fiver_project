<?php require_once ('../my-documents/my-db.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta content="CondoSites - http://www.condosites.net" name="author">
	<title>PayLease handoff</title>
</head>
<body>

<?php
	$PL_PMID = '21334423';
	$PL_KEY = 'e26Zxekzuxa4RcoLlVmb';
	$PL_PropID = 'TestProp_jnZNY';

	$id = $_SESSION['id'];
	$query  = "SELECT account, first_name, last_name FROM users WHERE `id`='$id' LIMIT 1";
	$result = mysql_query($query);

	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
    {

        $string = "pm_id=".$PL_PMID."&key=".$PL_KEY."&property_id=".$PL_PropID."&resident_id=".$row['account']."&first_name=".$row['first_name']."&last_name=".$row['last_name'] ;

        function encryptString($string, $key) {
            $key = file_get_contents($key);
            $hash = hash_hmac('sha256', $string, $key);
            $signature = $hash;
            return $signature;
        }

        function validateHMAC($request, $hmac, $key) { $request = urldecode(str_replace("&hmac=$hmac", "", $request));
            $myString = $this -> encryptString($request, 'sharedkey.mac');
            if ($hmac == $myString) {
                return true;
            } else {
                return false;
            }
        }

        $myHash = encryptString($string,'sharedkey.mac');

        ?>


        <a href="https://test.paylease.net/sso_payment?pm_id=<?php print($PL_PMID); ?>&key=<?php print($PL_KEY); ?>&property_id=<?php print($PL_PropID); ?>&resident_id=<?php echo($row['account']); ?>&first_name=<?php echo($row['first_name']); ?>&last_name=<?php echo($row['last_name']); ?>&hmac=<?php echo $myHash; ?>">Link</a>



<?php } ?>
</body>
</html>
