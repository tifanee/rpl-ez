<?php 
// Turn On Session.
session_start();
// Turn Off Session.
$_SESSION = [];
session_unset();
session_destroy();
// Go to Login Page.
header("Location: index.php");
exit;
?>