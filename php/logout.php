<?php
require 'functions.php';
// Turn On Session.
session_start();

if (isset($_GET["location"])) {
    $var = explode('?', $_GET["location"])[0];
    $urlreq = explode('/', $var);
    $location = end($urlreq);
}


// Get previous URL
$idr = NULL;
if (isset($_GET["idr"])) {
    $idr = $_GET["idr"];
}

// Turn Off Session.
$_SESSION = [];
session_unset();
session_destroy();
logout($location, $idr);

exit;
