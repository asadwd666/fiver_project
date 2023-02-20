<?php
require_once('my-documents/php7-my-db.php');
unset($_SESSION);
session_unset();
session_destroy();
header("Location: index.php");
exit();
?>