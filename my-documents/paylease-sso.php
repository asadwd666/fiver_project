<?php

/*
PAYLEASE KEYS:
*/

    $PL_PMID    = '';
	$PL_KEY     = '';
	$PL_PropID  = '';

/*
ADDITIONAL FIELDS:
*/

    $amount = '';

/*
USER INFORMATION:
*/

	$id = $_SESSION['id'];
	$query  = "SELECT `id`, `unit`, `unit2`, `first_name`, `last_name`, `email`, `phone`, `account` FROM `users` WHERE `id`='$id' LIMIT 1";
	$result = mysqli_query($conn, $query);
    while($row = $result->fetch_array(MYSQLI_ASSOC))
    {


/*
CODE TO GENERATE PAYLEASE RESIDENT ID:
*/

    $accountbase = $row['unit'];

	$account = $row['unit']."-".$id ;

/*
CODE TO HASH:
*/

        $string = "pm_id=".$PL_PMID."&key=".$PL_KEY."&property_id=".$PL_PropID."&resident_id=".$account."&first_name=".$row['first_name']."&last_name=".$row['last_name']."&email=".$row['email']."&phone=".$row['phone']."&amount=".$amount ;

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

<form enctype="multipart/form-data" method="POST" action="index.php">
<div class="row medium-collapse" style="padding-left: 30px;">
    <div class="small-12 medium-10 columns">
        <label for="account" class="middle">Confirm Condo Unit to Pay<br>
            <p><small>If you own one unit, the entry should reflect that unit. If you own multiple units, enter the unit for the account you wish to transact. If you are a repeat user, the most recent unit used to login will be shown.</small></p>
        </label>
    </div>
    <div class="small-12 medium-3 columns">
        <input name="account" class="form" id="account" maxlength="6" type="text" placeholder="<?php echo "{$accountbase}"; ?>" value="<?php if ($row['account'] != '') { ?><?php echo "{$row['account']}"; ?><?php }; ?><?php if ($row['account'] == '') { ?><?php echo "{$accountbase}"; ?><?php }; ?>">
    </div>
    <div class="small-12 medium-7 columns">
<input type="hidden" name="action" value="save">
<input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>">
<input name="submit" value="Apply" class="submit" type="submit">
    </div>
</div>

<?php if ($row['account'] != '') { ?>
<a href="https://www.paylease.com/sso_payment?pm_id=<?php print($PL_PMID); ?>&key=<?php print($PL_KEY); ?>&property_id=<?php print($PL_PropID); ?>&resident_id=<?php echo($account); ?>&first_name=<?php echo($row['first_name']); ?>&last_name=<?php echo($row['last_name']); ?>&email=<?php echo($row['email']); ?>&phone=<?php echo($row['phone']); ?>&amount=<?php print($amount); ?>&hmac=<?php echo $myHash; ?>">Click here to continue using unit <?php echo($row['account']); ?></a>
<?php }; ?>

<?php } ?>
